@extends('layouts.app')

@section('title', 'Signup - Excellent Care Services')

@section('content')
<style>
.signup-page { min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 30px 20px; }
.signup-card { width: 100%; max-width: 520px; background: #fff; border-radius: 14px; box-shadow: 0 8px 25px rgba(15,23,42,0.08); padding: 36px 28px; }
.signup-title { font-size: 28px; font-weight: 700; text-align: center; color: #111827; margin-bottom: 6px; }
.signup-subtitle { font-size: 14px; text-align: center; color: #6b7280; margin-bottom: 18px; }
.role-selector { display: flex; gap: 10px; margin-bottom: 20px; }
.role-option { flex: 1; text-align: center; border: 1px solid #dbe2ea; border-radius: 8px; padding: 10px 8px; cursor: pointer; transition: 0.2s; }
.role-option.active, .role-option:hover { border-color: #2563eb; background: #eef4ff; color: #2563eb; }
.form-label { font-size: 13px; font-weight: 600; margin-bottom: 6px; }
.form-control { width: 100%; height: 44px; border-radius: 8px; border: 1px solid #dbe2ea; padding: 0 12px; }
.btn-create { width: 100%; height: 46px; border-radius: 8px; background: #1f6ef2; color: #fff; font-weight: 600; font-size: 15px; margin-top: 12px; }
.btn-create:hover { background: #155edf; }
.bottom-login { text-align: center; margin-top: 18px; font-size: 12px; color: #6b7280; }
.bottom-login a { color: #2563eb; font-weight: 600; }
.bottom-badges { text-align: center; margin-top: 14px; font-size: 11px; color: #9ca3af; }
.error-text { color: #dc2626; font-size: 12px; margin-top: 4px; }

@media (max-width: 768px) {
    .signup-card { padding: 28px 20px; }
    .signup-title { font-size: 26px; }
    .role-selector { flex-direction: column; }
}
</style>

<div class="signup-page">
    <div class="signup-card">
        <h1 class="signup-title">Create your account</h1>
        <div class="signup-subtitle">Manage care and compliance efficiently. Select your role to get started.</div>

        <form method="POST" action="{{ route('signup.post') }}">
            @csrf

            <div class="role-selector">
                <div class="role-option active" data-role="Clinician">Clinician</div>
                <div class="role-option" data-role="Caregiver">Caregiver</div>
                <div class="role-option" data-role="Admin">Admin</div>
            </div>
            <input type="hidden" name="role" id="selectedRole" value="Clinician">

            <div class="mb-3">
                <label class="form-label" for="fullName">Full Name</label>
                <input type="text" id="fullName" name="name" class="form-control" placeholder="Dr. Jane Doe" value="{{ old('name') }}">
                @error('name') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="name@example.com.au" value="{{ old('email') }}">
                @error('email') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="+61 400 123 456" value="{{ old('phone') }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                    @error('password') <div class="error-text">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password">
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                <label class="form-check-label" for="termsCheck">
                    I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>.
                </label>
            </div>

            <button type="submit" class="btn-create">Create Account</button>

            <div class="bottom-login">
                Already have an account? <a href="{{ route('login') }}">Log in to Portal</a>
            </div>

            <div class="bottom-badges">
                Encrypted & Secure • NDIS Compliant
            </div>
        </form>
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