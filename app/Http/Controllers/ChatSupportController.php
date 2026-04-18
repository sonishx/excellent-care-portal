<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatSupportController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pages.chatsupport', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        
        $userMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        // Bot response will be handled by frontend
        $botMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => '', 
            'sender_type' => 'bot',
        ]);

        return response()->json([
            'user' => $userMessage,
            'bot' => $botMessage,
        ]);
    }
}