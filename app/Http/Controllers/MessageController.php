<?php

namespace App\Http\Controllers;
use App\Events\NewMessage;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Chat $chat)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $message = $chat->messages()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        broadcast(new NewMessage($message))->toOthers();

        return response()->json($message, 201);
    }
}
