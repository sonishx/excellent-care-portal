@extends('layouts.app')

@section('title', 'Messages - Excellent Care Services')

@section('content')
<style>
    /* ── Messaging Hub Premium Styles ── */
    .msg-hero {
        background: linear-gradient(135deg, #6f2dbd 0%, #a663cc 50%, #f45d75 100%);
        border-radius: 24px;
        padding: 40px 44px;
        color: white;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    .msg-hero::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .msg-hero::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 30%;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .msg-hero h1 { font-size: 30px; font-weight: 900; letter-spacing: -1px; margin: 0 0 6px; position: relative; z-index: 1; }
    .msg-hero p  { font-size: 15px; opacity: 0.85; margin: 0; position: relative; z-index: 1; }

    /* Tab pills */
    .msg-tabs { display: flex; gap: 8px; margin-bottom: 28px; }
    .msg-tab {
        padding: 10px 28px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        border-radius: 50px;
        transition: all 0.25s cubic-bezier(.4,0,.2,1);
        letter-spacing: 0.3px;
    }
    .msg-tab.active {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 14px rgba(111,45,189,0.35);
    }
    .msg-tab.inactive {
        background: white;
        color: var(--text-light);
        border: 1px solid var(--border);
    }
    .msg-tab.inactive:hover { background: #f8fafc; color: var(--primary); border-color: var(--primary); }

    /* Grid */
    .msg-grid { display: grid; grid-template-columns: 1fr 340px; gap: 28px; }

    /* Message list card */
    .msg-list-card {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .msg-list-header {
        padding: 22px 28px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .msg-list-header h3 { margin: 0; font-size: 17px; font-weight: 800; }
    .msg-count {
        background: rgba(111,45,189,0.08);
        color: var(--primary);
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 800;
    }

    /* Individual message row */
    .msg-row {
        display: flex;
        align-items: center;
        padding: 18px 28px;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.25s cubic-bezier(.4,0,.2,1);
        position: relative;
    }
    .msg-row:last-child { border-bottom: none; }
    .msg-row:hover { background: linear-gradient(90deg, rgba(111,45,189,0.03), transparent); padding-left: 36px; }
    .msg-row.unread { background: linear-gradient(90deg, rgba(111,45,189,0.04), rgba(244,93,117,0.02)); }
    .msg-row.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--primary), var(--secondary));
        border-radius: 0 4px 4px 0;
    }

    /* Avatar */
    .msg-avatar {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        font-weight: 800;
        margin-right: 18px;
        flex-shrink: 0;
        position: relative;
    }
    .msg-avatar.grad-1 { background: linear-gradient(135deg, #6f2dbd, #a663cc); }
    .msg-avatar.grad-2 { background: linear-gradient(135deg, #2563eb, #60a5fa); }
    .msg-avatar.grad-3 { background: linear-gradient(135deg, #059669, #34d399); }
    .msg-avatar.grad-4 { background: linear-gradient(135deg, #d97706, #fbbf24); }

    .msg-unread-dot {
        position: absolute;
        top: -3px;
        right: -3px;
        width: 14px;
        height: 14px;
        background: var(--secondary);
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 12px rgba(244,93,117,0.4);
        animation: glow 2s ease-in-out infinite;
    }
    @keyframes glow {
        0%, 100% { box-shadow: 0 0 8px rgba(244,93,117,0.3); }
        50% { box-shadow: 0 0 18px rgba(244,93,117,0.6); }
    }

    /* Role badge */
    .msg-role-badge {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 6px;
        flex-shrink: 0;
    }
    .msg-role-badge.clinician  { background: rgba(37,99,235,0.08); color: #2563eb; }
    .msg-role-badge.caregiver  { background: rgba(5,150,105,0.08); color: #059669; }
    .msg-role-badge.admin      { background: rgba(111,45,189,0.08); color: #6f2dbd; }
    .msg-role-badge.patient    { background: rgba(217,119,6,0.08); color: #d97706; }

    /* Sidebar */
    .msg-sidebar-card {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        padding: 28px;
    }
    .msg-sidebar-card h3 { margin: 0 0 20px; font-size: 16px; font-weight: 800; }
    .contact-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px;
        border-radius: 14px;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .contact-item:hover {
        background: #faf5ff;
        border-color: rgba(111,45,189,0.15);
        transform: translateX(4px);
    }
    .contact-avatar {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 13px;
        font-weight: 800;
        flex-shrink: 0;
    }

    /* Stats row */
    .msg-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .msg-stat-item {
        background: white;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 18px 20px;
        text-align: center;
    }
    .msg-stat-num {
        font-size: 26px;
        font-weight: 900;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .msg-stat-label { font-size: 11px; color: var(--text-light); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }

    /* Empty state */
    .msg-empty {
        text-align: center;
        padding: 70px 30px;
    }
    .msg-empty-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(111,45,189,0.1), rgba(244,93,117,0.1));
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        margin: 0 auto 20px;
    }

    @media (max-width: 1024px) {
        .msg-grid { grid-template-columns: 1fr; }
        .msg-hero { padding: 30px; }
        .msg-stats { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="messaging-hub">
    <!-- Hero -->
    <div class="msg-hero">
        <h1>Messaging Hub</h1>
        <p>Secure, end-to-end communication for clinical coordination and care updates.</p>
    </div>

    <!-- Stats -->
    @php
        $inboxCount = \App\Models\Message::where('receiver_id', auth()->id())->count();
        $unreadCount = \App\Models\Message::where('receiver_id', auth()->id())->whereNull('read_at')->count();
        $sentCount = \App\Models\Message::where('sender_id', auth()->id())->count();
    @endphp
    <div class="msg-stats">
        <div class="msg-stat-item">
            <div class="msg-stat-num">{{ $inboxCount }}</div>
            <div class="msg-stat-label">Total Received</div>
        </div>
        <div class="msg-stat-item">
            <div class="msg-stat-num">{{ $unreadCount }}</div>
            <div class="msg-stat-label">Unread</div>
        </div>
        <div class="msg-stat-item">
            <div class="msg-stat-num">{{ $sentCount }}</div>
            <div class="msg-stat-label">Sent</div>
        </div>
    </div>

    <!-- Tabs + Compose -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
        <div class="msg-tabs">
            <a href="{{ route('messages.index', ['view' => 'inbox']) }}" class="msg-tab {{ $view === 'inbox' ? 'active' : 'inactive' }}">Inbox</a>
            <a href="{{ route('messages.index', ['view' => 'sent']) }}" class="msg-tab {{ $view === 'sent' ? 'active' : 'inactive' }}">Sent</a>
        </div>
        <a href="{{ route('messages.create') }}" class="btn-primary" style="padding: 12px 28px; border-radius: 50px; font-size: 13px;">
            + Compose New
        </a>
    </div>

    <!-- Main grid -->
    <div class="msg-grid">
        <!-- Message List -->
        <div class="msg-list-card">
            <div class="msg-list-header">
                <h3>{{ $view === 'inbox' ? 'Inbox' : 'Sent Messages' }}</h3>
                <span class="msg-count">{{ $messages->count() }} messages</span>
            </div>

            @forelse($messages as $index => $msg)
                @php
                    $otherUser = $view === 'inbox' ? $msg->sender : $msg->receiver;
                    $isUnread  = $view === 'inbox' && !$msg->read_at;
                    $roleClass = strtolower($otherUser->role);
                    $gradients = ['grad-1','grad-2','grad-3','grad-4'];
                    $gradClass = $gradients[$index % 4];
                @endphp
                <a href="{{ route('messages.show', $msg->id) }}" class="msg-row {{ $isUnread ? 'unread' : '' }}">
                    <div class="msg-avatar {{ $gradClass }}">
                        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                        @if($isUnread)
                            <div class="msg-unread-dot"></div>
                        @endif
                    </div>

                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                            <span style="font-weight: {{ $isUnread ? '800' : '600' }}; font-size: 15px; color: var(--text);">{{ $otherUser->name }}</span>
                            <span style="font-size: 11px; color: var(--text-light); flex-shrink: 0; margin-left: 12px;">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <div style="font-size: 14px; font-weight: {{ $isUnread ? '700' : '500' }}; color: {{ $isUnread ? 'var(--text)' : '#64748b' }}; margin-bottom: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $msg->subject }}
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 13px; color: #94a3b8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 380px;">
                                {{ Str::limit($msg->message, 70) }}
                            </span>
                            <span class="msg-role-badge {{ $roleClass }}">{{ $otherUser->role }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="msg-empty">
                    <div class="msg-empty-icon" style="font-size: 28px; color: var(--primary);">No messages</div>
                    <h3 style="font-weight: 800; color: var(--text); margin: 0 0 8px;">Your {{ $view }} is empty</h3>
                    <p style="font-size: 14px; color: #94a3b8; margin: 0 0 24px;">Start a conversation with your care team or patients.</p>
                    <a href="{{ route('messages.create') }}" class="btn-primary" style="padding: 12px 32px; border-radius: 50px; text-decoration: none;">
                        Send your first message
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Sidebar -->
        <div>
            <div class="msg-sidebar-card" style="margin-bottom: 20px;">
                <h3>Quick Contacts</h3>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    @foreach($messages->take(5)->pluck($view === 'inbox' ? 'sender' : 'receiver')->unique('id') as $contact)
                        <a href="{{ route('messages.create', ['reply_to' => $contact->id]) }}" class="contact-item">
                            <div class="contact-avatar">{{ strtoupper(substr($contact->name, 0, 1)) }}</div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 14px; font-weight: 700; color: var(--text);">{{ $contact->name }}</div>
                                <div style="font-size: 11px; color: var(--text-light); font-weight: 600;">{{ ucfirst($contact->role) }}</div>
                            </div>
                            <span style="font-size: 16px;">→</span>
                        </a>
                    @endforeach
                    @if($messages->isEmpty())
                        <p style="font-size: 13px; color: var(--text-light); text-align: center; padding: 20px; font-style: italic;">No recent contacts.</p>
                    @endif
                </div>
            </div>

            <div class="msg-sidebar-card">
                <h3>Security Notice</h3>
                <p style="font-size: 13px; color: var(--text-light); line-height: 1.7; margin: 0;">
                    All messages are securely stored and encrypted at rest. Only you and the recipient can view conversation contents.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
