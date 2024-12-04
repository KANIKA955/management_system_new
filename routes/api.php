<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\WebhookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['api.token', 'throttle:60,1'])->group(function () {
    // Chat Routes
    Route::prefix('chat')->group(function () {
        Route::post('/initiate', [ChatController::class, 'initiate'])
            ->name('chat.initiate');

        Route::post('/message', [ChatController::class, 'sendMessage'])
            ->name('chat.message');

        Route::get('/{chatId}/status', [ChatController::class, 'getStatus'])
            ->name('chat.status');

        Route::get('/{chatId}/messages', [ChatController::class, 'getMessages'])
            ->name('chat.messages');

        Route::post('/close', [ChatController::class, 'closeChat'])
            ->name('chat.close');

        Route::get('/client/{clientId}/chats', [ChatController::class, 'getClientChats']);

        Route::get('attachment/{path}', [ChatController::class, 'downloadAttachment'])
            ->name('chat.attachment.download')
            ->where('path', '.*');

        Route::post('/{chatId}/reply', [ChatController::class, 'replyMessage'])
            ->name('chat.message');

    });

    // Webhook Routes
    Route::prefix('webhooks')->group(function () {
        Route::post('/register', [WebhookController::class, 'register'])
            ->name('webhook.register');

        Route::put('/{webhookId}', [WebhookController::class, 'update'])
            ->name('webhook.update');

        Route::delete('/{webhookId}', [WebhookController::class, 'delete'])
            ->name('webhook.delete');
    });
});
