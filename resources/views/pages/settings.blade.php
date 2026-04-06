@extends('layouts.app')

@section('title', 'Settings - Excellent Care Services')

@section('content')
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }

    .settings-page {
        min-height: 100vh;
        background: #f5f7fb;
    }

    .top-header {
        height: 72px;
        background: #ffffff;
        border-bottom: 1px solid #edf1f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 32px;
    }

    .brand-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-logo {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #6f2dbd;
        color: white;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        line-height: 1.05;
    }

    .brand-provider {
        font-size: 9px;
        color: #7c8796;
        line-height: 1.2;
    }

    .brand-name {
        font-size: 14px;
        font-weight: 700;
        color: #f45d75;
    }

    .brand-name span {
        color: #f28c52;
        font-size: 11px;
        font-weight: 600;
        margin-left: 2px;
    }

    .top-nav {
        display: flex;
        align-items: center;
        gap: 28px;
        margin-left: 28px;
    }

    .top-nav a {
        text-decoration: none;
        color: #4b5563;
        font-size: 14px;
    }

    .top-nav a.active {
        color: #2563eb;
        font-weight: 700;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .icon-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .settings-content {
        max-width: 1280px;
        margin: 0 auto;
        padding: 28px 32px 36px;
    }

    .page-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 24px;
        align-items: start;
    }

    .sidebar-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 20px 0;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
    }

    .sidebar-title {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        padding: 0 22px 12px;
    }

    .sidebar-subtitle {
        font-size: 13px;
        color: #6b7280;
        padding: 0 22px 16px;
    }

    .side-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 22px;
        text-decoration: none;
        color: #4b5563;
        font-size: 13px;
    }

    .side-link.active {
        background: #eef4ff;
        color: #2563eb;
        font-weight: 600;
    }

    .logout-wrap {
        padding: 14px 22px 0;
    }

    .logout-btn {
        background: none;
        border: none;
        color: #ef4444;
        font-size: 13px;
        padding: 0;
        cursor: pointer;
    }

    .content-area {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .flash-success {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #15803d;
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 13px;
    }

    .top-profile-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .profile-mini {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .profile-photo {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .profile-name {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
    }

    .profile-role {
        font-size: 13px;
        color: #6b7280;
        margin-top: 4px;
    }

    .verified-badge {
        background: #ecfdf3;
        color: #15803d;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-light-blue {
        background: #1f6ef2;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: 13px;
        font-weight: 600;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
    }

    .card {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        border: none;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 18px;
    }

    .toggle-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .toggle-row:last-child {
        margin-bottom: 0;
    }

    .toggle-text strong {
        display: block;
        font-size: 14px;
        color: #111827;
        margin-bottom: 4px;
    }

    .toggle-text span {
        font-size: 13px;
        color: #6b7280;
    }

    .toggle-switch-input {
        width: 48px;
        height: 26px;
        appearance: none;
        background: #d1d5db;
        border-radius: 999px;
        position: relative;
        outline: none;
        cursor: pointer;
    }

    .toggle-switch-input:checked {
        background: #3b82f6;
    }

    .toggle-switch-input::before {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: white;
        transition: 0.2s;
    }

    .toggle-switch-input:checked::before {
        left: 25px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-select {
        height: 46px;
        border-radius: 10px;
        border: 1px solid #dbe2ea;
        font-size: 14px;
        box-shadow: none !important;
        background: white;
    }

    .range-row {
        margin-bottom: 24px;
    }

    .range-value {
        font-size: 14px;
        color: #6b7280;
        margin-top: 8px;
    }

    .field-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
    }

    .security-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
    }

    .security-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .security-item:last-child {
        border-bottom: none;
    }

    .security-left strong {
        display: block;
        font-size: 14px;
        color: #111827;
        margin-bottom: 4px;
    }

    .security-left span {
        font-size: 13px;
        color: #6b7280;
    }

    .btn-light {
        background: white;
        color: #374151;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-danger-light {
        background: white;
        color: #ef4444;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-row {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

    @media (max-width: 1024px) {
        .page-layout {
            grid-template-columns: 1fr;
        }

        .settings-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .top-header {
            flex-direction: column;
            height: auto;
            padding: 16px;
            gap: 12px;
        }

        .settings-content {
            padding: 20px 16px 28px;
        }

        .top-profile-card {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="settings-page">
    <div class="top-header">
        <div class="d-flex align-items-center">
            <div class="brand-wrap">
                <div class="brand-logo">We<br>ndis</div>
                <div>
                    <div class="brand-provider">Registered<br>NDIS Provider</div>
                </div>
                <div class="brand-name">excellent<span>Care Services</span></div>
            </div>

            <div class="top-nav">
                <a href="/dashboard">Dashboard</a>
                <a href="#">Patients</a>
                <a href="#">Reports</a>
                <a href="/settings" class="active">Settings</a>
            </div>
        </div>

        <div class="header-right">
            <div class="icon-circle">🔔</div>
            <div class="icon-circle">👩</div>
        </div>
    </div>

    <div class="settings-content">
        <div class="page-layout">
            <div class="sidebar-card">
                <div class="sidebar-title">Settings</div>
                <div class="sidebar-subtitle">Manage your preferences</div>

                <a href="#" class="side-link active">👤 Account</a>
                <a href="#" class="side-link">🔔 Notifications</a>
                <a href="#" class="side-link">♿ Accessibility</a>
                <a href="#" class="side-link">🛡 Security</a>

                <div class="logout-wrap">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">↩ Sign out</button>
                    </form>
                </div>
            </div>

            <div class="content-area">
                @if(session('success'))
                    <div class="flash-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="top-profile-card">
                    <div class="profile-mini">
                        <div class="profile-photo">👩</div>
                        <div>
                            <div class="profile-name">{{ Auth::user()->name }}</div>
                            <div class="profile-role">{{ Auth::user()->role }} • Registered Portal User</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="verified-badge">● Verified User</span>
                        <a href="/profile" class="btn-light-blue text-decoration-none">Update Profile</a>
                    </div>
                </div>

                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf

                    <div class="settings-grid">
                        <div class="card">
                            <div class="section-title">Notifications</div>

                            <div class="toggle-row">
                                <div class="toggle-text">
                                    <strong>Email Notifications</strong>
                                    <span>Receive updates about patient reports</span>
                                </div>
                                <input type="checkbox" name="email_notifications" class="toggle-switch-input" {{ $settings->email_notifications ? 'checked' : '' }}>
                            </div>

                            <div class="toggle-row">
                                <div class="toggle-text">
                                    <strong>Push Notifications</strong>
                                    <span>Urgent alerts on mobile device</span>
                                </div>
                                <input type="checkbox" name="push_notifications" class="toggle-switch-input" {{ $settings->push_notifications ? 'checked' : '' }}>
                            </div>

                            <div class="toggle-row">
                                <div class="toggle-text">
                                    <strong>SMS Alerts</strong>
                                    <span>For critical patient changes</span>
                                </div>
                                <input type="checkbox" name="sms_alerts" class="toggle-switch-input" {{ $settings->sms_alerts ? 'checked' : '' }}>
                            </div>

                            <div class="mt-4">
                                <label class="form-label">Digest Frequency</label>
                                <select name="digest_frequency" class="form-select">
                                    <option value="Daily Summary" {{ $settings->digest_frequency == 'Daily Summary' ? 'selected' : '' }}>Daily Summary</option>
                                    <option value="Weekly Summary" {{ $settings->digest_frequency == 'Weekly Summary' ? 'selected' : '' }}>Weekly Summary</option>
                                    <option value="Monthly Summary" {{ $settings->digest_frequency == 'Monthly Summary' ? 'selected' : '' }}>Monthly Summary</option>
                                </select>
                                @error('digest_frequency')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card">
                            <div class="section-title">Accessibility</div>

                            <div class="range-row">
                                <label class="form-label">Text Size</label>
                                <input type="range" name="text_size" min="80" max="150" value="{{ $settings->text_size }}" class="form-range">
                                <div class="range-value">{{ $settings->text_size }}%</div>
                                @error('text_size')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="toggle-row">
                                <div class="toggle-text">
                                    <strong>High Contrast</strong>
                                    <span>Increase visual distinction</span>
                                </div>
                                <input type="checkbox" name="high_contrast" class="toggle-switch-input" {{ $settings->high_contrast ? 'checked' : '' }}>
                            </div>

                            <div class="toggle-row">
                                <div class="toggle-text">
                                    <strong>Reduce Motion</strong>
                                    <span>Minimize animations</span>
                                </div>
                                <input type="checkbox" name="reduce_motion" class="toggle-switch-input" {{ $settings->reduce_motion ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="security-card mt-4">
                        <div class="section-title">Security & Login</div>

                        <div class="security-item">
                            <div class="security-left">
                                <strong>Password</strong>
                                <span>Password change will be implemented next</span>
                            </div>
                            <button type="button" class="btn-light">Change Password</button>
                        </div>

                        <div class="security-item">
                            <div class="security-left">
                                <strong>Two-Factor Authentication (2FA)</strong>
                                <span>Placeholder for future implementation</span>
                            </div>
                            <button type="button" class="btn-danger-light">Disable</button>
                        </div>

                        <div class="btn-row">
                            <button type="submit" class="btn-light-blue">Save Settings</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection