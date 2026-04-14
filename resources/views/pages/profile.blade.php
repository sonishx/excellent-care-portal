@extends('layouts.app')

@section('title', 'Profile - Excellent Care Services')

@section('content')
@php
    $nameParts = explode(' ', Auth::user()->name, 2);
    $firstName = $nameParts[0] ?? '';
    $lastName = $nameParts[1] ?? '';
@endphp

<style>
/* Page-specific CSS for Profile page */
.profile-shell {
    min-height: 100vh;
    background: #f7f9fc;
    padding-bottom: 30px;
}

.profile-container {
    max-width: 900px;
    margin: 26px auto 0;
    padding: 0 20px;
}

.breadcrumb {
    font-size: 11px;
    color: #9ca3af;
    margin-bottom: 10px;
}

.page-title {
    font-size: 34px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}

.page-subtitle {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 18px;
}

.profile-grid {
    display: grid;
    grid-template-columns: 190px 1fr;
    gap: 20px;
}

.profile-side-card {
    background: #ffffff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
    height: fit-content;
}

.profile-side-top {
    background: #eef4ff;
    padding: 18px 16px 10px;
    text-align: center;
}

.profile-photo {
    width: 78px;
    height: 78px;
    border-radius: 50%;
    background: #b6d4fe;
    margin: 0 auto 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
}

.profile-name {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
}

.profile-badge {
    display: inline-block;
    margin-top: 6px;
    background: #eef4ff;
    color: #2563eb;
    border-radius: 999px;
    padding: 5px 10px;
    font-size: 11px;
    font-weight: 600;
}

.profile-side-body {
    padding: 14px 16px 18px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    margin-bottom: 10px;
    color: #6b7280;
}

.info-row strong {
    color: #111827;
    font-weight: 600;
}

.help-box {
    margin-top: 14px;
    background: #f8fbff;
    border-radius: 10px;
    padding: 12px;
    font-size: 11px;
    color: #6b7280;
}

.main-area {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.success-alert {
    background: #ecfdf3;
    border: 1px solid #bbf7d0;
    color: #15803d;
    border-radius: 10px;
    padding: 14px 16px;
    font-size: 12px;
}

.content-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 18px 18px 16px;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
}

.section-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-label {
    font-size: 11px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.form-control, .form-select {
    height: 40px;
    border-radius: 8px;
    border: 1px solid #dbe2ea;
    font-size: 12px;
    box-shadow: none !important;
    background: white;
}

.btn-row {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 14px;
}

.btn-cancel {
    background: transparent;
    border: none;
    color: #6b7280;
    font-size: 12px;
}

.btn-save {
    background: #1f6ef2;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 16px;
    font-size: 12px;
    font-weight: 600;
}

.field-error {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

@media (max-width: 900px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }

    .top-header {
        flex-direction: column;
        height: auto;
        gap: 10px;
        padding: 12px;
    }
}
</style>

<div class="profile-shell">
    <div class="profile-container">
        <div class="breadcrumb">Home &gt; Settings &gt; My Profile</div>
        <div class="page-title">My Profile</div>
        <div class="page-subtitle">Manage your personal details, professional role, and account settings.</div>

        <div class="profile-grid">
            <!-- Sidebar -->
            <div class="profile-side-card">
                <div class="profile-side-top">
                    <div class="profile-photo">👩</div>
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-badge">{{ Auth::user()->role }}</div>
                </div>

                <div class="profile-side-body">
                    <div class="info-row"><span>Status</span><strong>Active</strong></div>
                    <div class="info-row"><span>Member Since</span><strong>{{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'N/A' }}</strong></div>
                    <div class="info-row"><span>Last Login</span><strong>Current Session</strong></div>

                    <div class="help-box">
                        <strong>Need Help?</strong><br>
                        Contact admin support for changes to restricted fields.
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-area">
                @if(session('success'))
                    <div class="success-alert">{{ session('success') }}</div>
                @endif

                <div class="content-card">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf

                        <div class="section-title">👤 Personal Information</div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" value="{{ $firstName }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="{{ $lastName }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}">
                            @error('name')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="section-title mt-2">📧 Contact Details</div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}">
                            @error('email')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="section-title mt-2">💼 Professional Role</div>

                        <div class="mb-3">
                            <label class="form-label">Primary Role</label>
                            <select name="role" class="form-select">
                                <option value="Clinician" {{ Auth::user()->role == 'Clinician' ? 'selected' : '' }}>Clinician</option>
                                <option value="Caregiver" {{ Auth::user()->role == 'Caregiver' ? 'selected' : '' }}>Caregiver</option>
                                <option value="Admin" {{ Auth::user()->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NDIS Provider Number</label>
                                <input type="text" class="form-control" value="N/A" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">AHPRA Registration</label>
                                <input type="text" class="form-control" value="N/A" readonly>
                            </div>
                        </div>

                        <div class="btn-row">
                            <button type="reset" class="btn-cancel">Cancel</button>
                            <button type="submit" class="btn-save">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection