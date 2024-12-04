<?php

namespace App\Models;

use App\Enums\ChatStatus;
use App\Events\ChatStatusChanged;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chat extends Model
{
    protected $fillable = [
        'chat_id',
        'client_id',
        'department_id',
        'status',
        'is_high_priority',
        'last_activity_at'
    ];

    protected $casts = [
        'is_high_priority' => 'boolean',
        'last_activity_at' => 'datetime',
        'closed_at' => 'datetime',
        'status' => ChatStatus::class
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chat) {
            $chat->chat_id = $chat->chat_id ?? 'chat_' . Str::random(16);
            $chat->status = $chat->status ?? ChatStatus::defaultStatus();
            $chat->last_activity_at = now();
        });
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(ChatStatusLog::class);
    }

    public function updateStatus($newStatus, $changedBy, $notes = null)
    {
        $oldStatus = $this->status;

        if ($oldStatus !== $newStatus) {
            $this->status = $newStatus;
            $this->closed_at = $newStatus === 'closed' ? now() : null;
            $this->save();

            $this->statusLogs()->create([
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => $changedBy,
                'notes' => $notes
            ]);

            // Dispatch webhook event
            event(new ChatStatusChanged($this));
        }
    }
}
