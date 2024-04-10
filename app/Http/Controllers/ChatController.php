<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $chat = Chat::latest('id')->first();
        
        if (!$chat) {
            return redirect()->route('chat.new');
        }

        return redirect()->route('chat.show', ['id' => $chat->id]);
    }

    public function show(Request $request, $id)
    {
        $history = ChatMessage::where('chat_id', $id)
                    ->latest('created_at');

        return Inertia::render('Chat/index', [
                    'chat_id' => $id,
                    'history' => $history
                ]);
    }

    public function new(Request $request)
    {
        $user = auth()->user();
        $chat = new Chat(['user_id' => $user->id]);
        $chat->save();

        return redirect()->route('chat.show', ['id' => $chat->id]);
    }
}
