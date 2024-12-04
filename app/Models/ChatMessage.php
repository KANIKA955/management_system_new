<?php

namespace App\Models;

use App\Events\NewChatMessage;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_type',
        'sender_id',
        'content',
        'attachment_path',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($message) {
            $message->chat->update(['last_activity_at' => now()]);
            event(new NewChatMessage($message));
        });
    }

    public function sender()
    {
        // if sender_type is 'client', return the client relationship
        if ($this->sender_type === 'client') {
            return $this->sender_id;
        }
        else {
            return $this->belongsTo(User::class, 'sender_id');
        }
    }
}
