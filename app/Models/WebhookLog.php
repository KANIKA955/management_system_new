<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    protected $fillable = [
        'webhook_id',
        'payload',
        'success',
        'status_code',
        'response',
        'attempt_at'
    ];

    protected $casts = [
        'payload' => 'array',
        'success' => 'boolean',
        'attempt_at' => 'datetime'
    ];

    public function webhook()
    {
        return $this->belongsTo(WebhookConfiguration::class);
    }
}
