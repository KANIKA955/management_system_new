<?php

namespace App\Services;

use App\Models\WebhookConfiguration;
use App\Models\WebhookLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    public function getWebhookForClient(string $clientId)
    {
        return WebhookConfiguration::where('client_id', $clientId)
            ->where('is_active', true)
            ->first();
    }

    public function dispatchWebhook(WebhookConfiguration $webhook, array $payload)
    {
        try {
            $response = Http::timeout(5)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Webhook-Signature' => $this->generateSignature($payload),
                ])
                ->post($webhook->webhook_url, $payload);

            $this->logWebhookAttempt($webhook, $payload, $response->successful(), $response->status(), $response->body());

            return $response->successful();
        } catch (\Exception $e) {
            $this->logWebhookAttempt($webhook, $payload, false, 500, $e->getMessage());
            throw $e;
        }
    }

    protected function generateSignature(array $payload)
    {
        return hash_hmac('sha256', json_encode($payload), config('chat.webhook_secret'));
    }

    protected function logWebhookAttempt($webhook, $payload, $success, $statusCode, $response)
    {
        WebhookLog::create([
            'webhook_id' => $webhook->id,
            'payload' => $payload,
            'success' => $success,
            'status_code' => $statusCode,
            'response' => $response,
            'attempt_at' => now()
        ]);
    }
}
