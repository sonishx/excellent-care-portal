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
        $currentUser = Auth::user();

        $users = User::where('id', '!=', $currentUser->id)->get();

        $selectedUserId = $request->get('user');

        if (!$selectedUserId && $users->count() > 0) {
            $selectedUserId = $users->first()->id;
        }

        $selectedUser = $selectedUserId ? User::find($selectedUserId) : null;

        $messages = collect();

        if ($selectedUser) {
            $messages = Message::where(function ($query) use ($currentUser, $selectedUser) {
                $query->where('sender_id', $currentUser->id)
                      ->where('receiver_id', $selectedUser->id);
            })->orWhere(function ($query) use ($currentUser, $selectedUser) {
                $query->where('sender_id', $selectedUser->id)
                      ->where('receiver_id', $currentUser->id);
            })->orderBy('created_at')->get();
        }

        return view('pages.messages', compact('users', 'selectedUser', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect()->route('messages', ['user' => $request->receiver_id]);
    }
}