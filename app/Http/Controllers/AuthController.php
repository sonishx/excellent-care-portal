<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showSignup(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Registration is by invitation only.');
        }

        $invitation = \App\Models\Invitation::where('token', $token)->first();

        if (!$invitation || $invitation->isExpired() || $invitation->isUsed()) {
            return redirect()->route('login')->with('error', 'Invalid or expired invitation link.');
        }

        return view('auth.signup', compact('invitation'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            'token' => 'required|string|exists:invitations,token',
        ]);

        $invitation = \App\Models\Invitation::where('token', $request->token)->first();

        if (!$invitation || $invitation->isExpired() || $invitation->isUsed()) {
            return redirect()->route('login')->with('error', 'Invalid or expired invitation link.');
        }

        if ($invitation->email !== $request->email) {
            return back()->withErrors(['email' => 'This email does not match the invitation.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $invitation->role,
            'password' => Hash::make($request->password),
        ]);

        $invitation->update(['registered_at' => now()]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registration successful. Welcome to the portal!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect('/dashboard')->with('success', 'Login successful. Welcome back!');
        }

        return back()->withErrors([
            'email' => 'Please check your email and password.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}