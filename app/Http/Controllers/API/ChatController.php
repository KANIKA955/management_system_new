<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Services\ChatService;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    protected $chatService;
    protected $fileUploadService;

    public function __construct(ChatService $chatService, FileUploadService $fileUploadService)
    {
        $this->chatService = $chatService;
        $this->fileUploadService = $fileUploadService;
    }

    public function initiate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'client_id' => 'required|string',
                'is_high_priority' => 'required|boolean',
                'department_id' => 'required|exists:departments,id',
                'initial_message' => 'required|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();

            // Create chat
            $chat = $this->chatService->createChat(
                $request->client_id,
                $request->department_id,
                $request->is_high_priority
            );

            // Create initial message
            $this->chatService->createMessage(
                $chat->id,
                'client',
                $request->client_id,
                $request->initial_message
            );

            DB::commit();

            return response()->json([
                'chat_id' => $chat->chat_id,
                'status' => $chat->status
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return response()->json([
                'error' => 'Failed to initiate chat'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'chat_id' => 'required|string|exists:chats,chat_id',
                'message' => 'required|string|max:1000',
                'client_id' => 'required|string',
                'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $chat = Chat::where('chat_id', $request->chat_id)->first();

            if ($chat->status === 'closed') {
                return response()->json([
                    'error' => 'Chat session is closed'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();

            // Handle file upload if present
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $this->fileUploadService->uploadFile(
                    $request->file('attachment'),
                    'chat-attachments'
                );
            }

            // Create message
            $message = $this->chatService->createMessage(
                $chat->id,
                'client',
                $request->client_id,
                $request->message,
                $attachmentPath
            );

            DB::commit();

            return response()->json([
                'message_id' => $message->id,
                'status' => 'sent'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return response()->json([
                'error' => 'Failed to send message'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getStatus(Request $request, $chatId)
    {
        try {
            $chat = Chat::where('chat_id', $chatId)
                ->with(['statusLogs' => function($query) {
                    $query->latest()->first();
                }])
                ->first();

            if (!$chat) {
                return response()->json([
                    'error' => 'Chat not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'chat_id' => $chat->chat_id,
                'status' => $chat->status,
                'last_activity' => $chat->last_activity_at,
                'created_at' => $chat->created_at
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Failed to get chat status'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getMessages(Request $request, $chatId)
    {
        try {
            $validator = Validator::make(['chat_id' => $chatId], [
                'chat_id' => 'required|string|exists:chats,chat_id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $chat = Chat::where('chat_id', $chatId)->first();

            $messages = $chat->messages()
                ->orderBy('created_at', 'asc')
                ->paginate(50)
                ->through(function ($message) {
                    return [
                        'id' => $message->id,
                        'content' => $message->content,
                        'sender_type' => $message->sender_type,
                        'sender_id' => $message->sender_id,
                        'created_at' => $message->created_at,
                        'attachment' => $message->attachment_path ? [
                            'path' => $message->attachment_path,
                            'url' => $this->fileUploadService->getTemporaryUrl($message->attachment_path),
                            'filename' => basename($message->attachment_path)
                        ] : null,
                        'is_read' => $message->is_read
                    ];
                });

            return response()->json([
                'chat_id' => $chat->chat_id,
                'messages' => $messages
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Failed to get chat messages'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function downloadAttachment(Request $request, string $path)
    {
        // Verify signed URL
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        // Check if file exists
        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        // Return file download response
        return Storage::disk('private')->download($path);
    }

    public function closeChat(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'chat_id' => 'required|string|exists:chats,chat_id',
                'client_id' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $chat = Chat::where('chat_id', $request->chat_id)
                ->where('client_id', $request->client_id)
                ->first();

            if (!$chat) {
                return response()->json([
                    'error' => 'Chat not found'
                ], Response::HTTP_NOT_FOUND);
            }

            if ($chat->status === 'closed') {
                return response()->json([
                    'error' => 'Chat is already closed'
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $this->chatService->closeChat($chat, $request->client_id);

            return response()->json([
                'chat_id' => $chat->chat_id,
                'status' => 'closed',
                'closed_at' => $chat->closed_at
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Failed to close chat'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getClientChats(Request $request, string $clientId)
    {
        try {
            $chats = $this->chatService->getClientChats($clientId);

            return response()->json($chats, Response::HTTP_OK);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'error' => 'Failed to fetch client chats'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function replyMessage(Request $request, string $chatId)
    {
        // Validate request
        DB::beginTransaction();

        try {
            $request->validate([
                'content' => 'required|string|max:1000',
                'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx'
            ]);

            $chat = Chat::where('chat_id', $chatId)->firstOrFail();

            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $this->fileUploadService->uploadFile(
                    $request->file('attachment'),
                    'chat-attachments'
                );
            }

            $message = $this->chatService->createMessage(
                $chat->id,
                'agent',
                1,
                $request->content,
                $attachmentPath
            );

            // Send webhook notification
            $this->sendWebhookNotification([
                'client_id' => $chat->client_id,
                'event_type' => 'message',
                'chat_id' => $chatId
            ]);

            DB::commit();

            return response()->json([
                'message_id' => $message->id,
                'status' => 'sent'
            ], Response::HTTP_OK);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return response()->json([
                'error' => 'Failed to send message'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    private function sendWebhookNotification(array $data)
    {
        try {
            $signature = config('app.webhook_signature');
            $webhookUrl = config('app.webhook_url');

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-webhook-signature' => $signature
            ])->post($webhookUrl, $data);

            if (!$response->successful()) {
                \Log::error('Webhook notification failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'data' => $data
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Webhook notification error', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);
            // We don't want to fail the main operation if webhook fails
            report($e);
        }
    }
}
