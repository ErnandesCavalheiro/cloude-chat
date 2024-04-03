<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\AnthropicService;
use Illuminate\Support\Facades\Log;

class ChatMessageController extends Controller
{
    public function __construct(private readonly AnthropicService $anthropicService) 
    {}

    public function sendMessage(Request $request)
    {
        $user_message = new ChatMessage(['chat_id' => $request->chat_id, 'role' => 'user', 'content' => $request->message]);
        $user_message->save();

        $history = ChatMessage::where('chat_id', $request->chat_id)
                    ->orderBy('created_at', 'asc')
                    ->get(['role', 'content'])
                    ->map(function ($message) {
                        return [
                            'role' => $message->role,
                            'content' => $message->content
                        ];
                    })
                    ->toArray();

        $response = $this->anthropicService->createMessage($request->message, $history);
        $response_content = $this->anthropicService->getMessageContent($response);

        $ai_response = new ChatMessage(['chat_id' => $request->chat_id, 'role' => 'assistant', 'content' => $response_content]);
        $ai_response->save();

        return response()->json(['response' => $response_content, 'history' => $history], 200);
    }
}
