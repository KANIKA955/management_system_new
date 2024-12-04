<?php

namespace App\Events;

use App\Enums\ChatStatus;
use App\Models\Chat;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatStatusChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Chat $chat,
        public ChatStatus|string $oldStatus,
        public ChatStatus|string $newStatus
    ) {}
}
