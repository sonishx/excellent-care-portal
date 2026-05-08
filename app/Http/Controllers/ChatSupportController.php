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
        $messages = [];
        if (Auth::check()) {
            $messages = ChatMessage::where('user_id', Auth::id())
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('pages.chatsupport', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        
        $userId = Auth::id();
        $userRole = Auth::user()?->role;

        // Save user message
        ChatMessage::create([
            'user_id' => $userId,
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        // Generate bot response using the service
        $botReply = $this->chatbotService->generateResponse(
            $request->message,
            $userId,
            $userRole,
        );

        // Save bot message
        $botMessage = ChatMessage::create([
            'user_id' => $userId,
            'message' => $botReply,
            'sender_type' => 'bot',
        ]);

        return response()->json([
            'success' => true,
            'message' => $botMessage->message,
        ]);
    }
}