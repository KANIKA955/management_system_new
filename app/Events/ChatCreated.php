<?php

// app/Events/ChatCreated.php
namespace App\Events;
use App\Models\Chat;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatCreated
{
    use Dispatchable, SerializesModels;

    public $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }
}
