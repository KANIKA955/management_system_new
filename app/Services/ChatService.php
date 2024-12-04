<?php

namespace App\Services;

use App\Enums\ChatStatus;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Events\ChatCreated;
use App\Events\ChatStatusChanged;
use Illuminate\Support\Str;

class ChatService
{
    public function createChat(string $clientId, int $departmentId, bool $isHighPriority): Chat
    {
        $chat = Chat::create([
            'chat_id' => 'chat_' . Str::random(16),
            'client_id' => $clientId,
            'department_id' => $departmentId,
            'is_high_priority' => $isHighPriority,
            'status' => 'pending',
            'last_activity_at' => now()
        ]);

        // Log initial status
        $chat->statusLogs()->create([
            'old_status' => 'created',
            'new_status' => 'pending',
            'changed_by' => $clientId,
            'notes' => 'Chat initiated'
        ]);

        event(new ChatCreated($chat));

        return $chat;
    }

    public function createMessage(
        int $chatId,
        string $senderType,
        string $senderId,
        string $content,
        ?string $attachmentPath = null
    ): ChatMessage {
        $message = ChatMessage::create([
            'chat_id' => $chatId,
            'sender_type' => $senderType,
            'sender_id' => $senderId,
            'content' => $content,
            'attachment_path' => $attachmentPath
        ]);

        // Update chat last activity
        Chat::where('id', $chatId)->update([
            'last_activity_at' => now()
        ]);

        return $message;
    }

    public function closeChat(Chat $chat, string $closedBy, ?string $notes = null): void
    {
        $oldStatus = $chat->status;

        // Update chat status
        $chat->status = ChatStatus::CLOSED;
        $chat->closed_at = now();
        $chat->save();

        // Log status change
        $chat->statusLogs()->create([
            'old_status' => $oldStatus->value, // Convert enum to string for logging
            'new_status' => ChatStatus::CLOSED->value,
            'changed_by' => $closedBy,
            'notes' => $notes ?? 'Chat closed by ' . $closedBy
        ]);

        // Create system message about closure
        $this->createMessage(
            chatId: $chat->id,
            senderType: 'system',
            senderId: 'system',
            content: 'Chat closed by ' . $closedBy
        );

        // Dispatch event
        event(new ChatStatusChanged(
            chat: $chat,
            oldStatus: $oldStatus,
            newStatus: ChatStatus::CLOSED
        ));
    }

    public function updateStatus(Chat $chat, ChatStatus $newStatus, string $changedBy, ?string $notes = null): void
    {
        $oldStatus = $chat->status;

        if ($oldStatus !== $newStatus) {
            // Update chat status
            $chat->status = $newStatus;
            $chat->save();

            // Create status log
            $chat->statusLogs()->create([
                'old_status' => $oldStatus->value,
                'new_status' => $newStatus->value,
                'changed_by' => $changedBy,
                'notes' => $notes
            ]);

            event(new ChatStatusChanged($chat, $oldStatus, $newStatus));
        }
    }

    public function getClientChats(string $clientId)
    {
        return Chat::where('client_id', $clientId)
            ->with(['statusLogs' => function ($query) {
                $query->latest()->limit(1);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->through(function ($chat) {
                return [
                    'chat_id' => $chat->chat_id,
                    'status' => $chat->status->value,
                    'is_high_priority' => $chat->is_high_priority,
                    'created_at' => $chat->created_at,
                    'last_activity_at' => $chat->last_activity_at,
                    'last_message' => $chat->messages()
                        ->latest()
                        ->first(['content', 'created_at', 'sender_type']),
                    'unread_count' => $chat->messages()
                        ->where('is_read', false)
                        ->where('sender_type', '!=', 'client')
                        ->count(),
                ];
            });
    }

    public function getChatByIdentifier(string $chatId): ?Chat
    {
        return Chat::where('chat_id', $chatId)->first();
    }

    public function validateChatAccess(Chat $chat, string $clientId): bool
    {
        return $chat->client_id === $clientId;
    }
}
