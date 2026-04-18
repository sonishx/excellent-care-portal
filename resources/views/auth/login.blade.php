@extends('layouts.app')

@section('title', 'Login - Excellent Care Services')

@section('content')
<style>
    .login-page {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(15,23,42,0.08);
        padding: 36px 28px;
    }

    .login-title {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        text-align: center;
        margin-bottom: 6px;
    }

    .login-subtitle {
        font-size: 14px;
        color: #6b7280;
        text-align: center;
        margin-bottom: 18px;
    }

    .form-label { font-size: 13px; font-weight: 600; margin-bottom: 6px; }
    .form-control { height: 44px; border-radius: 8px; border: 1px solid #dbe2ea; padding: 0 12px; }

    .btn-signin {
        width: 100%;
        height: 46px;
        border: none;
        border-radius: 8px;
        background: #1f6ef2;
        color: white;
        font-size: 15px;
        font-weight: 600;
        margin-top: 10px;
    }

    .btn-signin:hover { background: #155edf; }

    .error-box {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #dc2626;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 12px;
        margin-bottom: 12px;
    }

    .bottom-register {
        text-align: center;
        margin-top: 18px;
        font-size: 12px;
    }

    .bottom-register a { color: #2563eb; font-weight: 600; }
</style>

<div class="login-page">
    <div class="login-card">
        <h1 class="login-title">Welcome Back</h1>
        <div class="login-subtitle">Sign in to access the NDIS & Aged Care Portal</div>

        @if($errors->any())
            <div class="error-box">
                <strong>Login Error:</strong> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="example@gmail.com" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password">
            </div>

            <div class="form-options mb-3">
                <div>
                    <input type="checkbox" name="remember" id="rememberMe">
                    <label for="rememberMe">Remember me</label>
                </div>
                <a href="#" style="color:#2563eb; font-size:12px;">Forgot password?</a>
            </div>

            <button type="submit" class="btn-signin">Sign In</button>

            <div class="bottom-register">
                Don’t have an account? <a href="/signup">Register now</a>
            </div>
        </form>
    </div>
</div>
@endsection