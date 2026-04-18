<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatSupportController extends Controller
{
    public function index() {
        $messages = ChatMessage::where('user_id', Auth::id())
                        ->orderBy('created_at', 'asc')
                        ->get();
        return view('pages.chatsupport', compact('messages'));
    }

    public function sendMessage(Request $request) {
        $request->validate(['message' => 'required|string']);

        // Save user's message
        $userMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender_type' => 'user'
        ]);

        // Generate bot response (simple example)
        $botReply = $this->getBotResponse($request->message);

        // Save bot message
        $botMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $botReply,
            'sender_type' => 'bot'
        ]);

        return response()->json([
            'user' => $userMessage,
            'bot'  => $botMessage
        ]);
    }

    private function getBotResponse($userMessage) {
        // Simple rule-based bot
        if (stripos($userMessage, 'invoice') !== false) {
            return "Sure, I can help you locate your invoice. Please provide the invoice number or date.";
        }
        if (stripos($userMessage, 'shift') !== false) {
            return "You can view all your shifts under the 'Patients' or 'Care Plans' section.";
        }
        return "I’m here to help! Could you clarify your request?";
    }
}