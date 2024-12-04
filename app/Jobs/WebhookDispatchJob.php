<?php

namespace App\Jobs;

use App\Models\WebhookConfiguration;
use App\Services\WebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class WebhookDispatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $webhook;
    public $payload;
    public $tries = 3;
    public $backoff = [10, 60, 180]; // Retry after 10s, 1m, 3m

    public function __construct(WebhookConfiguration $webhook, array $payload)
    {
        $this->webhook = $webhook;
        $this->payload = $payload;
        $this->onQueue('webhooks');
    }

    public function handle(WebhookService $webhookService)
    {
        try {
            $webhookService->dispatchWebhook($this->webhook, $this->payload);
        } catch (\Exception $e) {
            Log::error('Webhook dispatch failed', [
                'webhook_id' => $this->webhook->id,
                'attempt' => $this->attempts(),
                'error' => $e->getMessage()
            ]);

            if ($this->attempts() === $this->tries) {
                // Final attempt failed
                $this->fail($e);
            } else {
                // Retry with backoff
                $this->release(
                    $this->backoff[$this->attempts() - 1]
                );
            }
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Webhook dispatch finally failed', [
            'webhook_id' => $this->webhook->id,
            'error' => $exception->getMessage()
        ]);
    }
}
