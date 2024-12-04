<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\WebhookService;
use App\Events\{ChatCreated, NewChatMessage, ChatStatusChanged};
use App\Enums\ChatStatus;

class DispatchChatWebhook implements ShouldQueue
{
    public function __construct(
        private readonly WebhookService $webhookService
    ) {}

    public function handle($event): void
    {
        $payload = match(true) {
            $event instanceof ChatCreated => [
                'event_type' => 'chat.created',
                'chat_id' => $event->chat->chat_id,
                'client_id' => $event->chat->client_id,
                'data' => [
                    'department_id' => $event->chat->department_id,
                    'status' => $event->chat->status->value, // Convert enum to string
                    'created_at' => $event->chat->created_at
                ]
            ],
            $event instanceof NewChatMessage => [
                'event_type' => 'chat.message',
                'chat_id' => $event->message->chat->chat_id,
                'client_id' => $event->message->chat->client_id,
                'data' => [
                    'message_id' => $event->message->id,
                    'content' => $event->message->content,
                    'sender_type' => $event->message->sender_type,
                    'attachment_url' => $event->message->attachment_path ?
                        url('storage/' . $event->message->attachment_path) : null,
                    'sent_at' => $event->message->created_at
                ]
            ],
            $event instanceof ChatStatusChanged => [
                'event_type' => 'chat.status_changed',
                'chat_id' => $event->chat->chat_id,
                'client_id' => $event->chat->client_id,
                'data' => [
                    'old_status' => $event->oldStatus instanceof ChatStatus ?
                        $event->oldStatus->value : $event->oldStatus,
                    'new_status' => $event->newStatus instanceof ChatStatus ?
                        $event->newStatus->value : $event->newStatus,
                    'changed_at' => now()
                ]
            ],
            default => null
        };

        if ($payload) {
            // Get client_id based on event type
            $clientId = match(true) {
                $event instanceof ChatCreated => $event->chat->client_id,
                $event instanceof NewChatMessage => $event->message->chat->client_id,
                $event instanceof ChatStatusChanged => $event->chat->client_id,
                default => null
            };

            if ($clientId) {
                $this->webhookService->dispatch($clientId, $payload);
            }
        }
    }

    private function shouldDispatch($event, $webhook): bool
    {
        $eventType = match(true) {
            $event instanceof ChatCreated => 'chat.created',
            $event instanceof NewChatMessage => 'chat.message',
            $event instanceof ChatStatusChanged => 'chat.status_changed',
            default => null
        };

        return $eventType && in_array($eventType, $webhook->events_config);
    }
}
