<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->query('view', 'inbox');
        $currentUser = Auth::id();

        if ($view === 'sent') {
            $messages = Message::with('receiver')
                ->where('sender_id', $currentUser)
                ->latest()
                ->get();
        } else {
            $messages = Message::with('sender')
                ->where('receiver_id', $currentUser)
                ->latest()
                ->get();
        }

        return view('pages.messages.index', compact('messages', 'view'));
    }

    public function create(Request $request)
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $replyTo = $request->query('reply_to');
        $recipient = $replyTo ? User::find($replyTo) : null;
        $subject = $request->query('subject');

        return view('pages.messages.create', compact('users', 'recipient', 'subject'));
    }

    public function show($id)
    {
        $message = Message::with(['sender', 'receiver'])->findOrFail($id);

        // Authorization
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read if receiving
        if ($message->receiver_id === Auth::id() && !$message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('pages.messages.show', compact('message'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('messages.index', ['view' => 'sent'])->with('success', 'Message sent successfully.');
    }
}