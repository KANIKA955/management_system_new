<?php

namespace App\Providers;

use App\Events\ChatCreated;
use App\Events\ChatStatusChanged;
use App\Events\NewChatMessage;
use App\Listeners\DispatchChatWebhook;
use App\Services\WebhookService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/chat.php', 'chat'
        );
        $this->app->singleton(WebhookService::class, function ($app) {
            return new WebhookService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen([
            ChatCreated::class,
            NewChatMessage::class,
            ChatStatusChanged::class
        ], DispatchChatWebhook::class);
    }
}
