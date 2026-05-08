<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::with('invitedBy')->latest()->get();
        return view('pages.invitations', compact('invitations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email|unique:invitations,email',
            'role' => 'required|in:caregiver,clinician,patient,admin',
        ]);

        $token = Str::random(32);

        $invitation = Invitation::create([
            'email' => $request->email,
            'role' => $request->role,
            'token' => $token,
            'expires_at' => now()->addDays(7),
            'invited_by_id' => Auth::id(),
        ]);

        $link = route('signup', ['token' => $token]);

        // Dispatch real email
        Mail::to($request->email)->send(new InvitationMail($invitation, $link));

        return back()->with('success', "Invitation sent to {$request->email}.");
    }

    public function destroy($id)
    {
        $invitation = Invitation::findOrFail($id);
        $invitation->delete();

        return back()->with('success', 'Invitation revoked.');
    }
}
