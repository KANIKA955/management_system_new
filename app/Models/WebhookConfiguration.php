<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookConfiguration extends Model
{
    protected $fillable = [
        'client_id',
        'webhook_url',
        'events_config',
        'is_active'
    ];

    protected $casts = [
        'events_config' => 'array',
        'is_active' => 'boolean'
    ];
}
