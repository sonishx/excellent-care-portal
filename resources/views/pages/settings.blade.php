@extends('layouts.app')

@section('title', 'Settings - Excellent Care Services')

@section('content')
<style>
    /* Page-specific CSS not in master layout */
    .settings-page {
        min-height: 100vh;
        background: #f5f7fb;
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

    @media (max-width: 1024px) {
        .page-layout {
            grid-template-columns: 1fr;
        }

        .settings-grid {
            grid-template-columns: 1fr;
        }
    }
    .btn-light {
    background: white;
    color: #374151;
    border: 1px solid #dbe2ea;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}

.btn-danger-light {
    background: white;
    color: #ef4444;
    border: 1px solid #dbe2ea;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
}
/* Buttons for toggle/action consistency */
.form-range {
    width: 100%;
    accent-color: #2563eb;
    margin-top: 6px;
}

.range-value {
    font-size: 13px;
    color: #6b7280;
    margin-top: 4px;
}

/* Security Card */
.security-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 6px 18px rgba(15,23,42,0.05);
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* Security item button styling */
.btn-light, .btn-danger-light, .btn-light-blue {
    transition: all 0.2s ease;
}
.btn-light:hover {
    background: #f3f4f6;
}
.btn-danger-light:hover {
    background: #fee2e2;
}
.btn-light-blue:hover {
    opacity: 0.9;
}

/* Sidebar links hover */
.side-link:hover {
    background: #f3f4f6;
}

/* Active session table placeholder */
.active-session-table {
    width: 100%;
    border-collapse: collapse;
}
.active-session-table th, .active-session-table td {
    padding: 12px 10px;
    font-size: 13px;
    border-bottom: 1px solid #eef2f7;
}
.active-session-table th {
    text-transform: uppercase;
    color: #6b7280;
    font-size: 12px;
}

/* Profile action buttons */
.top-profile-card a.btn-light-blue {
    font-size: 13px;
    padding: 10px 16px;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .page-layout {
        grid-template-columns: 1fr;
    }
    .settings-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="settings-page">
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