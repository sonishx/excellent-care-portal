@extends('layouts.app')

@section('title', 'My Care Dashboard - Excellent Care Services')

@section('content')
<style>
    .patient-hero { background: linear-gradient(135deg, #6f2dbd 0%, #a663cc 100%); border-radius: 24px; padding: 40px; color: white; margin-bottom: 30px; position: relative; overflow: hidden; }
    .patient-hero::after { content: ''; position: absolute; top: 0; right: 0; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%; transform: translate(100px, -100px); }
    .welcome-text { font-size: 36px; font-weight: 800; margin-bottom: 10px; letter-spacing: -1px; }
    .welcome-sub { font-size: 16px; opacity: 0.9; max-width: 500px; line-height: 1.6; }
    
    .status-pill { background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; margin-top: 20px; }
    .status-dot { width: 8px; height: 8px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 10px #4ade80; }

    .action-card { transition: all 0.3s ease; cursor: pointer; border: 1px solid transparent; }
    .action-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 15px 30px rgba(111, 45, 189, 0.1); }
    
    .team-member { display: flex; align-items: center; gap: 15px; padding: 15px; border-radius: 16px; background: #f8fafc; border: 1px solid var(--border); margin-bottom: 12px; }
    .note-item { padding: 15px; border-left: 4px solid var(--primary); background: #fdfcff; border-radius: 0 12px 12px 0; margin-bottom: 15px; }
</style>

<div class="patient-dashboard">
    <div class="patient-hero">
        <h1 class="welcome-text">Hello, {{ $user->name }} 👋</h1>
        <p class="welcome-sub">
            Welcome back to your personal care portal. Everything is organized here to help you stay informed about your health and care plan.
        </p>
        <div class="status-pill">
            <span class="status-dot"></span>
            Your Care Plan is Active
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 30px;">
        <div class="main-content">
            <!-- Quick Actions -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 35px;">
                <a href="{{ route('messages.index') }}" class="card action-card" style="text-decoration: none; color: inherit;">
                    <div style="font-size: 24px; margin-bottom: 12px;">💬</div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800;">Message Team</h3>
                    <p style="font-size: 13px; color: var(--text-light); margin-top: 5px;">Chat with your assigned clinician.</p>
                </a>
                <a href="{{ route('documents') }}" class="card action-card" style="text-decoration: none; color: inherit;">
                    <div style="font-size: 24px; margin-bottom: 12px;">📄</div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800;">My Documents</h3>
                    <p style="font-size: 13px; color: var(--text-light); margin-top: 5px;">View reports and NDIS forms.</p>
                </a>
                <div class="card action-card">
                    <div style="font-size: 24px; margin-bottom: 12px;">📅</div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800;">Schedule</h3>
                    <p style="font-size: 13px; color: var(--text-light); margin-top: 5px;">View your upcoming visits.</p>
                </div>
            </div>

            <!-- Recent Care Updates -->
            <div class="card" style="padding: 30px;">
                <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 20px; font-weight: 800;">Recent Care Updates</h2>
                @forelse($careNotes as $note)
                    <div class="note-item">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="font-weight: 700; font-size: 14px; color: var(--text);">Update from {{ $note->user->name }}</span>
                            <span style="font-size: 12px; color: var(--text-light);">{{ $note->created_at->format('M d, Y') }}</span>
                        </div>
                        <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #4b5563;">{{ $note->note }}</p>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px;">
                        <p style="color: var(--text-light);">No recent updates found in your care timeline.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="sidebar">
            <!-- My Care Team -->
            <div class="card" style="padding: 24px; margin-bottom: 30px;">
                <h3 style="margin-top: 0; font-size: 18px; font-weight: 800; margin-bottom: 20px;">My Care Team</h3>
                @forelse($assignedStaff as $staff)
                    <div class="team-member">
                        <div class="brand-logo-circle" style="width: 40px; height: 40px; font-size: 12px;">
                            {{ substr($staff->name, 0, 1) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 14px; font-weight: 700; color: var(--text);">{{ $staff->name }}</div>
                            <div style="font-size: 12px; color: var(--primary); font-weight: 600;">{{ ucfirst($staff->role) }}</div>
                        </div>
                        <a href="{{ route('messages.create', ['reply_to' => $staff->id]) }}" style="color: var(--primary); font-size: 18px; text-decoration: none;">✉️</a>
                    </div>
                @empty
                    <p style="font-size: 13px; color: var(--text-light); text-align: center;">You haven't been assigned a care team yet.</p>
                @endforelse
            </div>

            <!-- Recent Messages -->
            <div class="card" style="padding: 24px;">
                <h3 style="margin-top: 0; font-size: 18px; font-weight: 800; margin-bottom: 20px;">Recent Messages</h3>
                @forelse($recentMessages as $msg)
                    <a href="{{ route('messages.show', $msg->id) }}" style="display: block; padding-bottom: 15px; margin-bottom: 15px; border-bottom: 1px solid var(--border); text-decoration: none; color: inherit;">
                        <div style="font-weight: 700; font-size: 14px; margin-bottom: 4px;">{{ $msg->sender->name }}</div>
                        <p style="margin: 0; font-size: 13px; color: var(--text-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $msg->message }}</p>
                    </a>
                @empty
                    <p style="font-size: 13px; color: var(--text-light); text-align: center;">No recent messages.</p>
                @endforelse
                <a href="{{ route('messages.index') }}" style="display: block; text-align: center; font-size: 13px; font-weight: 700; color: var(--primary); text-decoration: none; margin-top: 10px;">Go to Inbox →</a>
            </div>
        </div>
    </div>
</div>
@endsection
