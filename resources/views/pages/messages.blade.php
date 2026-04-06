@extends('layouts.app')

@section('title', 'Messages - Excellent Care Services')

@section('content')
<style>
    html,
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }

    .messages-page {
        width: 100%;
        min-height: 100vh;
        background: #f5f7fb;
        padding: 0;
        margin: 0;
    }

    .messages-shell {
        width: 100%;
        min-height: 100vh;
        background: #ffffff;
        display: grid;
        grid-template-columns: 150px 260px 1fr;
        overflow: hidden;
    }

    .sidebar {
        border-right: 1px solid #eef2f7;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 14px 10px 16px;
    }

    .brand-wrap {
        margin-bottom: 18px;
    }

    .brand-line {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .brand-logo {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #6f2dbd;
        color: #fff;
        font-size: 9px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1.05;
        text-align: center;
    }

    .brand-provider {
        font-size: 11px;
        color: #7c8796;
        line-height: 1.2;
    }

    .brand-name {
        font-size: 14px;
        font-weight: 700;
        color: #f45d75;
        margin-top: 1px;
    }

    .brand-name span {
        color: #f28c52;
        font-size: 11px;
        font-weight: 600;
        margin-left: 2px;
    }

    .menu a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 10px;
        margin-bottom: 4px;
        border-radius: 8px;
        font-size: 14px;
        color: #556070;
        text-decoration: none;
    }

    .menu a.active {
        background: #eaf2ff;
        color: #2563eb;
        font-weight: 600;
    }

    .logout-btn {
        background: none;
        border: none;
        color: #ef4444;
        font-size: 13px;
        padding: 0;
        cursor: pointer;
        text-align: left;
    }

    .conversation-list {
        border-right: 1px solid #eef2f7;
        background: #ffffff;
        padding: 12px 0 0;
        overflow-y: auto;
    }

    .conv-search {
        padding: 0 10px 12px;
    }

    .conv-search input {
        width: 100%;
        height: 40px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        padding: 0 10px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .conv-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .conv-item {
        display: flex;
        gap: 10px;
        padding: 10px 12px;
        align-items: flex-start;
        cursor: pointer;
    }

    .conv-item.active {
        background: #f8fbff;
    }

    .conv-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #fde68a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .conv-text {
        flex: 1;
        min-width: 0;
    }

    .conv-row {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 2px;
    }

    .conv-name {
        font-size: 11px;
        font-weight: 700;
        color: #111827;
    }

    .conv-time {
        font-size: 9px;
        color: #94a3b8;
        white-space: nowrap;
    }

    .conv-preview {
        font-size: 9px;
        color: #111827;
        line-height: 1.3;
    }

    .chat-panel {
        display: flex;
        flex-direction: column;
        background: #ffffff;
        min-width: 0;
        min-height: 100vh;
    }

    .chat-header {
        height: 70px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 16px;
        flex-shrink: 0;
    }

    .chat-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #fde68a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
    }

    .chat-user-name {
        font-size: 12px;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }

    .chat-user-role {
        font-size: 10px;
        color: #6b7280;
        line-height: 1.2;
    }

    .online-dot {
        color: #22c55e;
        font-size: 10px;
        margin-left: 4px;
    }

    .chat-icons {
        font-size: 14px;
        color: #6b7280;
        display: flex;
        gap: 14px;
    }

    .chat-body {
        flex: 1;
        background: #f9fbff;
        padding: 24px 20px;
        overflow-y: auto;
        min-height: 0;
    }

    .date-pill {
        background: #edf2ff;
        color: #64748b;
        font-size: 9px;
        border-radius: 999px;
        padding: 5px 10px;
        margin: 0 auto 18px;
        display: block;
        width: fit-content;
    }

    .msg-row {
        display: flex;
        margin-bottom: 14px;
    }

    .msg-row.left {
        justify-content: flex-start;
    }

    .msg-row.right {
        justify-content: flex-end;
    }

    .msg-bubble {
        max-width: 420px;
        padding: 12px 14px;
        border-radius: 14px;
        font-size: 14px;
        line-height: 1.45;
        position: relative;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .msg-bubble.left {
        background: #ffffff;
        color: #111827;
        border: 1px solid #edf1f5;
    }

    .msg-bubble.right {
        background: #1f6ef2;
        color: #ffffff;
    }

    .msg-time {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }

    .msg-time.right {
        text-align: right;
        color: #dbeafe;
    }

    .chat-input-form {
        margin: 0;
        flex-shrink: 0;
    }

    .chat-input-bar {
        height: 58px;
        border-top: 1px solid #eef2f7;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 14px;
        background: #ffffff;
    }

    .chat-input-icon {
        font-size: 15px;
        color: #6b7280;
        flex-shrink: 0;
    }

    .chat-input {
        flex: 1;
        height: 38px;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0 14px;
        font-size: 12px;
        outline: none;
        min-width: 0;
    }

    .send-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #1f6ef2;
        color: white;
        font-size: 13px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .empty-box {
        text-align: center;
        margin-top: 80px;
        color: #6b7280;
        font-size: 13px;
    }

    @media (max-width: 1100px) {
        .messages-shell {
            grid-template-columns: 1fr;
        }

        .sidebar,
        .conversation-list {
            border-right: none;
            border-bottom: 1px solid #eef2f7;
        }

        .chat-panel {
            min-height: auto;
        }
    }
</style>

<div class="messages-page">
    <div class="messages-shell">
        <!-- Left Sidebar -->
        <div class="sidebar">
            <div>
                <div class="brand-wrap">
                    <div class="brand-line">
                        <div class="brand-logo">We<br>ndis</div>
                        <div>
                            <div class="brand-provider">Registered<br>NDIS Provider</div>
                            <div class="brand-name">excellent<span>Care Services</span></div>
                        </div>
                    </div>
                </div>

                <div class="menu">
                    <a href="/dashboard">🏠 Dashboard</a>
                    <a href="/messages" class="active">💬 Messages</a>
                    <a href="/patients">👥 Patients</a>
                    <a href="#">📅 Schedule</a>
                    <a href="/settings">⚙ Settings</a>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">↩ Log out</button>
            </form>
        </div>

        <!-- Conversation List -->
        <div class="conversation-list">
            <div class="conv-search">
                <input type="text" placeholder="Search conversations...">
            </div>

            @forelse($users as $user)
                <a href="{{ route('messages', ['user' => $user->id]) }}" class="conv-link">
                    <div class="conv-item {{ $selectedUser && $selectedUser->id == $user->id ? 'active' : '' }}">
                        <div class="conv-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="conv-text">
                            <div class="conv-row">
                                <div class="conv-name">{{ $user->name }}</div>
                            </div>
                            <div class="conv-preview">{{ $user->role }}</div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-box">No users found for conversation.</div>
            @endforelse
        </div>

        <!-- Chat Area -->
        <div class="chat-panel">
            @if($selectedUser)
                <div class="chat-header">
                    <div class="chat-user">
                        <div class="chat-user-avatar">
                            {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="chat-user-name">{{ $selectedUser->name }} <span class="online-dot">●</span></div>
                            <div class="chat-user-role">{{ $selectedUser->role }}</div>
                        </div>
                    </div>

                    <div class="chat-icons">
                        <span>📞</span>
                        <span>🎥</span>
                        <span>ⓘ</span>
                        <span>🔒</span>
                    </div>
                </div>

                <div class="chat-body">
                    <div class="date-pill">Conversation Thread</div>

                    @forelse($messages as $message)
                        <div class="msg-row {{ $message->sender_id == Auth::id() ? 'right' : 'left' }}">
                            <div>
                                <div class="msg-bubble {{ $message->sender_id == Auth::id() ? 'right' : 'left' }}">
                                    {{ $message->message }}
                                </div>
                                <div class="msg-time {{ $message->sender_id == Auth::id() ? 'right' : '' }}">
                                    {{ $message->created_at->format('h:i A') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-box">No messages yet. Start the conversation.</div>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('messages.store') }}" class="chat-input-form">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">

                    <div class="chat-input-bar">
                        <span class="chat-input-icon">⊕</span>
                        <input type="text" name="message" class="chat-input" placeholder="Type a message..." required>
                        <span class="chat-input-icon">☺</span>
                        <button type="submit" class="send-btn">➤</button>
                    </div>
                </form>
            @else
                <div class="empty-box">No conversation selected.</div>
            @endif
        </div>
    </div>
</div>
@endsection