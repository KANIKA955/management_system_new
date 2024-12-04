<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ChatStatusLog extends Model
{
    protected $fillable = [
        'chat_id',
        'old_status',
        'new_status',
        'changed_by',
        'notes'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
