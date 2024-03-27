<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $chat = new Chat(['user_id' => 1]);
        $chat->save();

        return Inertia::render('Chat/index', []);
    }
}
