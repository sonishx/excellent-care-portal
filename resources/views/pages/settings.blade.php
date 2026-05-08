@extends('layouts.app')

@section('title', 'Settings - Excellent Care Services')

@section('content')
<style>
    .settings-page { padding-bottom: 50px; }
    .page-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 24px;
        align-items: start;
    }

    .sidebar-card {
        padding: 20px 0;
    }

    .sidebar-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        padding: 0 25px 15px;
        letter-spacing: -0.5px;
    }

    .side-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 25px;
        text-decoration: none;
        color: var(--text-light);
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .side-link:hover {
        background: rgba(111, 45, 189, 0.05);
        color: var(--primary);
    }

    .side-link.active {
        background: rgba(111, 45, 189, 0.1);
        color: var(--primary);
        border-right: 4px solid var(--primary);
    }

    .profile-banner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .profile-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .profile-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        font-weight: 700;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .toggle-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid var(--border);
    }

    .toggle-row:last-child { border-bottom: none; }

    .toggle-info strong {
        display: block;
        font-size: 14px;
        color: var(--text);
        margin-bottom: 2px;
    }

    .toggle-info span {
        font-size: 12px;
        color: var(--text-light);
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }

    .switch input { opacity: 0; width: 0; height: 0; }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #94a3b8;
        transition: .3s;
        border-radius: 24px;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.1);
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px; width: 18px;
        left: 3px; bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked + .slider { background: var(--primary-gradient); }
    input:checked + .slider:before { transform: translateX(20px); }

    @media (max-width: 1024px) {
        .page-layout { grid-template-columns: 1fr; }
        .settings-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="settings-page">
    <div class="page-layout">
        <div class="card sidebar-card">
            <h2 class="sidebar-title">Settings</h2>

            <a href="#profile-section" class="side-link active">👤 Account & Profile</a>
            <a href="#notification-section" class="side-link">🔔 Notification Preferences</a>
            <a href="#accessibility-section" class="side-link">♿ Accessibility Options</a>
            <a href="#security-section" class="side-link">🛡 Security & Privacy</a>
            
            @if(strtolower(Auth::user()->role) === 'admin')
                <a href="{{ route('invitations.index') }}" class="side-link">✉ User Invitations</a>
            @endif

            <div style="padding: 20px 25px 0; border-top: 1px solid var(--border); margin-top: 10px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 700; font-size: 14px; cursor: pointer;">↩ Sign Out</button>
                </form>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 15px; border-radius: 12px; margin-bottom: 10px; font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif

            <div id="profile-section" class="card profile-banner">
                <div class="profile-info">
                    <div class="profile-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 2px;">{{ Auth::user()->name }}</h3>
                        <p style="font-size: 13px; color: var(--text-light);">{{ ucfirst(Auth::user()->role) }} • Excellent Care Portal</p>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; align-items: center;">
                    <span style="font-size: 12px; font-weight: 700; color: #16a34a; background: #f0fdf4; padding: 6px 12px; border-radius: 20px;">● Active User</span>
                    <a href="{{ route('profile') }}" class="btn-primary" style="font-size: 13px;">Edit Profile</a>
                </div>
            </div>

            <form method="POST" action="{{ route('settings.update') }}">
                @csrf
                <div class="settings-grid">
                    <div id="notification-section" class="card">
                        <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 15px;">Notification Center</h4>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <strong>Email Alerts</strong>
                                <span>Updates on patient reports & tasks</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="email_notifications" {{ $settings->email_notifications ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <strong>Push Notifications</strong>
                                <span>Real-time portal updates</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="push_notifications" {{ $settings->push_notifications ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <strong>SMS Broadcasts</strong>
                                <span>Emergency clinical alerts</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="sms_alerts" {{ $settings->sms_alerts ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <div id="accessibility-section" class="card">
                        <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 15px;">Accessibility</h4>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 8px;">Interface Text Size</label>
                            <div style="background: #f1f5f9; padding: 10px; border-radius: 10px; border: 1px solid var(--border);">
                                <input type="range" name="text_size" min="80" max="150" value="{{ $settings->text_size }}" style="width: 100%; accent-color: var(--primary); height: 6px;">
                            </div>
                            <div style="text-align: right; font-size: 12px; font-weight: 800; color: var(--primary); margin-top: 5px;">{{ $settings->text_size }}%</div>
                        </div>

                        <div class="toggle-row">
                            <div class="toggle-info">
                                <strong>High Contrast Mode</strong>
                                <span>Enhance visual clarity</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="high_contrast" {{ $settings->high_contrast ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div id="security-section" class="card mt-4">
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 20px;">Security & Login</h4>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 15px; border-bottom: 1px solid var(--border); margin-bottom: 15px;">
                        <div>
                            <div style="font-weight: 700; font-size: 14px;">Password</div>
                            <div style="font-size: 12px; color: var(--text-light);">Last changed 3 months ago</div>
                        </div>
                        <button type="button" class="btn-outline">Change Password</button>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 700; font-size: 14px;">Two-Factor Authentication</div>
                            <div style="font-size: 12px; color: var(--text-light);">Add an extra layer of security to your account</div>
                        </div>
                        <button type="button" class="btn-outline">Setup 2FA</button>
                    </div>

                    <div style="margin-top: 30px; display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn-primary">Save Settings</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Smooth Scroll for Sidebar
    document.querySelectorAll('.side-link').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    document.querySelectorAll('.side-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }
            }
        });
    });

    // Live Accessibility Previews
    const textSizeSlider = document.querySelector('input[name="text_size"]');
    const contrastToggle = document.querySelector('input[name="high_contrast"]');
    const sizeDisplay = textSizeSlider ? textSizeSlider.nextElementSibling : null;

    if (textSizeSlider) {
        textSizeSlider.addEventListener('input', function() {
            const size = this.value;
            if (sizeDisplay) sizeDisplay.textContent = size + '%';
            document.body.style.fontSize = (size / 100) + 'rem';
        });
    }

    if (contrastToggle) {
        contrastToggle.addEventListener('change', function() {
            document.body.style.filter = this.checked ? 'contrast(1.2)' : 'none';
        });
    }
</script>
@endsection