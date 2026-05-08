@extends('layouts.app')

@section('title', 'Verify Email - Excellent Care Services')

@section('content')
<div style="max-width: 500px; margin: 100px auto;">
    <div class="card" style="text-align: center;">
        <h1 class="page-title" style="font-size: 24px;">Verify Your Email</h1>
        <p class="page-subtitle" style="margin-bottom: 25px;">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </p>

        @if (session('message'))
            <div style="margin-bottom: 20px; padding: 12px; background: #f0fdf4; color: #166534; border-radius: 8px; font-size: 14px;">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 15px;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary" style="width: 100%;">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-outline" style="width: 100%;">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
