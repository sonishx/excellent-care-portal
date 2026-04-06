@extends('layouts.app')

@section('title', 'Login - Excellent Care Services')

@section('content')
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }

    .login-page {
        min-height: 100vh;
        background: #f5f7fb;
    }

    .top-header {
        height: 70px;
        background: #ffffff;
        border-bottom: 1px solid #edf1f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 55px;
    }

    .brand-area {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-logo-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #6f2dbd;
        color: white;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        text-align: center;
        line-height: 1.1;
    }

    .brand-provider {
        font-size: 11px;
        color: #6b7280;
        line-height: 1.2;
    }

    .brand-main {
        font-size: 20px;
        font-weight: 700;
        color: #f45d75;
        margin-left: 4px;
    }

    .brand-main span {
        font-size: 13px;
        color: #f28c52;
        font-weight: 600;
        margin-left: 2px;
    }

    .top-links a {
        text-decoration: none;
        color: #111827;
        font-size: 13px;
        margin-left: 28px;
    }

    .login-content {
        min-height: calc(100vh - 70px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 35px 20px;
    }

    .login-card {
        width: 100%;
        max-width: 430px;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.08);
        padding: 38px 30px 24px;
    }

    .login-title {
        font-size: 30px;
        font-weight: 700;
        color: #111827;
        text-align: center;
        margin-bottom: 8px;
    }

    .login-subtitle {
        text-align: center;
        color: #7b8794;
        font-size: 14px;
        margin-bottom: 22px;
    }

    .error-box {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #dc2626;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 12px;
        margin-bottom: 18px;
    }

    .error-box strong {
        display: block;
        margin-bottom: 2px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-control {
        height: 44px;
        border-radius: 8px;
        border: 1px solid #dbe2ea;
        font-size: 14px;
        box-shadow: none !important;
    }

    .form-control:focus {
        border-color: #3b82f6;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        margin-bottom: 18px;
        font-size: 12px;
    }

    .form-check-label {
        font-size: 12px;
        color: #6b7280;
    }

    .forgot-link {
        text-decoration: none;
        font-size: 12px;
        color: #2563eb;
    }

    .btn-signin {
        width: 100%;
        height: 46px;
        border: none;
        border-radius: 8px;
        background: #1f6ef2;
        color: white;
        font-size: 15px;
        font-weight: 600;
        transition: 0.2s ease;
    }

    .btn-signin:hover {
        background: #155edf;
    }

    .bottom-register {
        text-align: center;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #f1f3f6;
        font-size: 12px;
        color: #6b7280;
    }

    .bottom-register a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .page-footer {
        text-align: center;
        margin-top: 18px;
        font-size: 11px;
        color: #9ca3af;
    }

    .page-footer a {
        color: #9ca3af;
        text-decoration: none;
        margin: 0 10px;
    }

    .copyright {
        text-align: center;
        margin-top: 10px;
        font-size: 10px;
        color: #c0c7d1;
    }

    .field-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .top-header {
            padding: 15px 18px;
            flex-direction: column;
            height: auto;
            gap: 10px;
        }

        .login-card {
            padding: 30px 20px 22px;
        }

        .login-title {
            font-size: 28px;
        }
    }
</style>

<div class="login-page">
    <div class="top-header">
        <div class="brand-area">
            <div class="brand-logo-circle">We<br>ndis</div>

            <div class="brand-provider">
                Registered<br>NDIS Provider
            </div>

            <div class="brand-main">
                excellent<span>Care Services</span>
            </div>
        </div>

        <div class="top-links">
            <a href="#">Help Centre</a>
            <a href="#">Contact Support</a>
        </div>
    </div>

    <div class="login-content">
        <div class="login-card">
            <h1 class="login-title">Welcome Back</h1>
            <div class="login-subtitle">Sign in to access the NDIS &amp; Aged Care Portal</div>

            @if($errors->has('email'))
                <div class="error-box">
                    <strong>Invalid credentials</strong>
                    {{ $errors->first('email') }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="clinic@gmail.com" value="{{ old('email') }}">
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn-signin" id="signInBtn">Sign In</button>

                <div class="bottom-register">
                    Don’t have an account?
                    <a href="/signup">Register now</a>
                </div>
            </form>
        </div>

        <div class="page-footer">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">NDIS Compliance</a>
        </div>

        <div class="copyright">
            © 2024 CareConnect Australia. All rights reserved.
        </div>
    </div>
</div>
@endsection