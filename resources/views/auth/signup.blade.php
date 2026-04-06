@extends('layouts.app')

@section('title', 'Signup - Excellent Care Services')

@section('content')
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }

    .signup-page {
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

    .signup-content {
        min-height: calc(100vh - 70px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 35px 20px;
    }

    .signup-card {
        width: 100%;
        max-width: 520px;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.08);
        padding: 34px 30px 24px;
    }

    .signup-title {
        font-size: 30px;
        font-weight: 700;
        color: #111827;
        text-align: center;
        margin-bottom: 8px;
    }

    .signup-subtitle {
        text-align: center;
        color: #7b8794;
        font-size: 14px;
        margin-bottom: 22px;
    }

    .role-selector {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .role-option {
        flex: 1;
        border: 1px solid #dbe2ea;
        border-radius: 8px;
        text-align: center;
        padding: 10px 8px;
        font-size: 13px;
        font-weight: 500;
        color: #4b5563;
        background: #ffffff;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .role-option.active {
        border-color: #2563eb;
        background: #eef4ff;
        color: #2563eb;
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

    .password-hint {
        font-size: 11px;
        color: #dc2626;
        margin-top: 4px;
    }

    .form-check-label {
        font-size: 12px;
        color: #6b7280;
    }

    .btn-create {
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

    .btn-create:hover {
        background: #155edf;
    }

    .bottom-login {
        text-align: center;
        margin-top: 18px;
        font-size: 12px;
        color: #6b7280;
    }

    .bottom-login a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .bottom-badges {
        text-align: center;
        margin-top: 18px;
        font-size: 11px;
        color: #9ca3af;
    }

    .error-text {
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

        .signup-card {
            padding: 28px 20px 22px;
        }

        .signup-title {
            font-size: 26px;
        }

        .role-selector {
            flex-direction: column;
        }
    }
</style>

<div class="signup-page">
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

    <div class="signup-content">
        <div class="signup-card">
            <h1 class="signup-title">Create your account</h1>
            <div class="signup-subtitle">
                Manage care and compliance efficiently. Select your role to get started.
            </div>

            <form method="POST" action="{{ route('signup.post') }}">
                @csrf

                <div class="role-selector">
                    <div class="role-option active" data-role="Clinician">Clinician</div>
                    <div class="role-option" data-role="Caregiver">Caregiver</div>
                    <div class="role-option" data-role="Admin">Admin</div>
                </div>

                <input type="hidden" name="role" id="selectedRole" value="Clinician">

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Dr. Jane Doe" value="{{ old('name') }}">
                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com.au" value="{{ old('email') }}">
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" placeholder="+61 400 123 456">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                        @error('password')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                    <label class="form-check-label" for="termsCheck">
                        I agree to the
                        <a href="#" class="text-decoration-none">Terms of Service</a>
                        and
                        <a href="#" class="text-decoration-none">Privacy Policy</a>.
                    </label>
                </div>

                <button type="submit" class="btn-create">Create Account</button>

                <div class="bottom-login">
                    Already have an account?
                    <a href="/">Log in to Portal</a>
                </div>

                <div class="bottom-badges">
                    Encrypted &amp; Secure &nbsp;&nbsp; • &nbsp;&nbsp; NDIS Compliant
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleOptions = document.querySelectorAll('.role-option');
        const selectedRoleInput = document.getElementById('selectedRole');

        roleOptions.forEach(option => {
            option.addEventListener('click', function () {
                roleOptions.forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                selectedRoleInput.value = this.getAttribute('data-role');
            });
        });
    });
</script>
@endsection