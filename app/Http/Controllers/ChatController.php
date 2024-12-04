<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Department;
use App\Services\ChatService;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ChatController extends Controller
{
    protected $chatService;
    protected $fileUploadService;

    public function __construct(ChatService $chatService, FileUploadService $fileUploadService)
    {
        $this->chatService = $chatService;
        $this->fileUploadService = $fileUploadService;
    }

    public function index(Request $request)
    {
        // Updated query to properly load last message for each chat
        $query = Chat::query()
            ->with(['messages' => function ($query) {
                $query->latest();  // Remove the first() from here
            }])
            ->orderBy('last_activity_at', 'desc');

        if (!Auth::user()->hasRole(['admin', 'manager'])) {
            $query->where('department_id', auth()->user()->department_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('department')) {
            $query->where('department_id', $request->department);
        }

        $chats = $query->get()->map(function ($chat) {
            // Get the last message for each chat
            $lastMessage = $chat->messages->first(); // Move first() here

            return [
                'chat_id' => $chat->chat_id,
                'client_id' => $chat->client_id,
                'client_name' => $chat->client?->name ?? 'Unknown Client',
                'client_avatar' => $chat->client?->avatar_url ?? '/assets/images/default-avatar.png',
                'status' => $chat->status,
                'is_high_priority' => $chat->is_high_priority,
                'department_id' => $chat->department_id,
                'department_name' => $chat->department?->name,
                'last_message' => $lastMessage ? [
                    'content' => str()->limit($lastMessage->content, 100),
                    'created_at' => $lastMessage->created_at->diffForHumans(),
                    'is_read' => $lastMessage->is_read
                ] : null,
                'unread_count' => $chat->messages()
                    ->where('is_read', false)
                    ->where('sender_type', 'client')
                    ->count(),
                'last_activity_at' => $chat->last_activity_at->diffForHumans(),
            ];
        });

        // Current chat messages loading
        $currentChat = null;
        $currentMessages = [];

        if ($request->has('chatId')) {
            $chat = Chat::where('chat_id', $request->chatId)
                ->with(['messages' => function ($query) {
                    $query->with('sender')->orderBy('created_at', 'asc');
                }])->first();

            if ($chat) {
                $currentChat = [
                    'id' => $chat->chat_id,
                    'status' => $chat->status,
                ];

                $currentMessages = $chat->messages->map(function ($message) {
                    return [
                        'id' => $message->id,
                        'content' => $message->content,
                        'sender_type' => $message->sender_type,
                        'sender_id' => $message->sender_id,
                        'sender_name' => $message->sender->name ?? 'Unknown',
                        'sender_avatar' => $message->sender->avatar_url ?? '/assets/images/default-avatar.png',
                        'created_at' => $message->created_at->format('h:i A'),
                        'attachment' => $message->attachment_path ? [
                            'url' => $this->fileUploadService->getTemporaryUrl($message->attachment_path),
                            'filename' => basename($message->attachment_path)
                        ] : null,
                        'is_read' => $message->is_read
                    ];
                });

                // Mark messages as read
                if ($currentMessages->isNotEmpty()) {
                    $chat->messages()
                        ->where('is_read', false)
                        ->where('sender_type', 'client')
                        ->update(['is_read' => true]);
                }
            }
        }

        return Inertia::render('Chats/Index', [
            'chats' => $chats,
            'departments' => Department::select('id', 'name')->get(),
            'filters' => $request->only(['status', 'department']),
            'permissions' => [
                'canTransferChat' => Auth::user()->can('Chat transfer'),
                'canHandleChat' => Auth::user()->can('Chat handle'),
                'canViewChat' => Auth::user()->can('Chat view'),
            ],
            'currentChat' => $currentChat,
            'currentMessages' => $currentMessages,
        ]);
    }

    public function sendMessage(Request $request, string $chatId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx'
        ]);

        $chat = Chat::where('chat_id', $chatId)->firstOrFail();

        if (!Auth::user()->hasRole(['admin', 'manager']) &&
            $chat->department_id !== Auth::user()->department_id) {
            abort(403);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $this->fileUploadService->uploadFile(
                $request->file('attachment'),
                'chat-attachments'
            );
        }

        $this->chatService->createMessage(
            $chat->id,
            'agent',
            Auth::id(),
            $request->content,
            $attachmentPath
        );

        return redirect()->route('chats.index', ['chatId' => $chatId]);
    }

    public function getAttachment(Request $request, string $path)
    {
        // Validate the path belongs to a chat message
        $message = ChatMessage::where('attachment_path', $path)->firstOrFail();

        // Check if user has access to this chat
        $chat = $message->chat;
        if (!Auth::user()->hasRole(['admin', 'manager']) &&
            $chat->department_id !== Auth::user()->department_id) {
            abort(403);
        }

        // Check if file exists
        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        // Get file mime type
        $mimeType = Storage::disk('private')->mimeType($path);

        // Get file contents
        $fileContents = Storage::disk('private')->get($path);

        // Generate filename for download
        $filename = basename($path);

        // Return file with proper headers
        return response($fileContents)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }
}
