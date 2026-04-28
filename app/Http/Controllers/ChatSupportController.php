<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatbotService;

class ChatSupportController extends Controller
{
    protected $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function index()
    {
        $messages = ChatMessage::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pages.chatsupport', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        
        // Save user message
        ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        // Generate bot response using the service
        $botReply = $this->chatbotService->generateResponse(
            $request->message,
            Auth::id(),
            Auth::user()?->role,
        );

        // Save bot message
        $botMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $botReply,
            'sender_type' => 'bot',
        ]);

        return response()->json([
            'success' => true,
            'message' => $botMessage->message,
        ]);
    }
}