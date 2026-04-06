@extends('layouts.app')

@section('title', 'Chat Support - Excellent Care Services')

@section('content')
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #2b2b2b;
    }

    .figma-frame {
        min-height: 100vh;
        background: #2b2b2b;
        padding: 28px 24px;
    }

    .frame-label {
        display: inline-block;
        background: #4a4a4a;
        color: #fff;
        font-size: 14px;
        border-radius: 8px;
        padding: 6px 12px;
        margin-bottom: 14px;
    }

    .support-shell {
        max-width: 1080px;
        margin: 0 auto;
        background: #ffffff;
        min-height: 640px;
        display: grid;
        grid-template-columns: 140px 200px 1fr;
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
        font-size: 7px;
        color: #7c8796;
        line-height: 1.2;
    }

    .brand-name {
        font-size: 10px;
        font-weight: 700;
        color: #f45d75;
        margin-top: 1px;
    }

    .brand-name span {
        color: #f28c52;
        font-size: 8px;
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
        font-size: 11px;
        color: #556070;
        text-decoration: none;
    }

    .menu a.active {
        background: #eaf2ff;
        color: #2563eb;
        font-weight: 600;
    }

    .logout-link {
        font-size: 11px;
        color: #ef4444;
        text-decoration: none;
        padding: 6px 4px 0;
        display: inline-block;
    }

    .chat-list {
        border-right: 1px solid #eef2f7;
        background: #ffffff;
        padding: 12px 0 0;
    }

    .chat-list-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        padding: 0 12px 10px;
    }

    .support-item {
        display: flex;
        gap: 10px;
        padding: 10px 12px;
        align-items: flex-start;
        cursor: pointer;
    }

    .support-item.active {
        background: #f8fbff;
    }

    .support-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .support-body {
        flex: 1;
        min-width: 0;
    }

    .support-name {
        font-size: 11px;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
    }

    .support-sub {
        font-size: 9px;
        color: #6b7280;
        margin-top: 2px;
    }

    .chat-panel {
        display: flex;
        flex-direction: column;
        background: #ffffff;
    }

    .chat-header {
        height: 58px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 16px;
    }

    .chat-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #dbeafe;
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
    }

    .chat-user-sub {
        font-size: 10px;
        color: #22c55e;
    }

    .chat-actions {
        font-size: 14px;
        color: #6b7280;
        display: flex;
        gap: 12px;
    }

    .chat-body {
        flex: 1;
        background: #f9fbff;
        padding: 18px 16px;
        overflow-y: auto;
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
        max-width: 380px;
        padding: 10px 12px;
        border-radius: 14px;
        font-size: 11px;
        line-height: 1.45;
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
        font-size: 8px;
        color: #94a3b8;
        margin-top: 4px;
    }

    .msg-time.right {
        text-align: right;
        color: #dbeafe;
    }

    .attach-card {
        margin-top: 8px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        color: #111827;
    }

    .attach-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .attach-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #fee2e2;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .attach-name {
        font-size: 10px;
        font-weight: 600;
        color: #111827;
        line-height: 1.3;
    }

    .attach-meta {
        font-size: 8px;
        color: #94a3b8;
    }

    .quick-actions {
        display: flex;
        gap: 8px;
        padding: 0 16px 10px;
        background: #ffffff;
    }

    .quick-btn {
        border: 1px solid #dbe2ea;
        background: #fff;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 10px;
        color: #4b5563;
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
    }

    .chat-input {
        flex: 1;
        height: 38px;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0 14px;
        font-size: 12px;
        outline: none;
    }

    .send-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #1f6ef2;
        color: white;
        font-size: 13px;
    }

    .footer-note {
        font-size: 9px;
        color: #9ca3af;
        text-align: center;
        padding: 4px 0 8px;
        background: #ffffff;
    }

    @media (max-width: 1100px) {
        .support-shell {
            grid-template-columns: 1fr;
        }

        .sidebar,
        .chat-list {
            border-right: none;
            border-bottom: 1px solid #eef2f7;
        }
    }
</style>

<div class="figma-frame">
    <div class="frame-label">chatsupport</div>

    <div class="support-shell">
        <!-- Sidebar -->
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
                    <a href="#">👥 Client</a>
                    <a href="/dashboard">📊 Report</a>
                    <a href="/chatsupport" class="active">💬 Support</a>
                    <a href="/settings">⚙ Settings</a>
                </div>
            </div>

            <a href="#" class="logout-link">↩ Log out</a>
        </div>

        <!-- Support list -->
        <div class="chat-list">
            <div class="chat-list-title">Chat History</div>

            <div class="support-item active">
                <div class="support-avatar">🤖</div>
                <div class="support-body">
                    <div class="support-name">NDIS Support Assistant</div>
                    <div class="support-sub">Online · Typically replies instantly</div>
                </div>
            </div>
        </div>

        <!-- Chat panel -->
        <div class="chat-panel">
            <div class="chat-header">
                <div class="chat-user">
                    <div class="chat-avatar">🤖</div>
                    <div>
                        <div class="chat-user-name">NDIS Support Assistant</div>
                        <div class="chat-user-sub">Online · Typically replies instantly</div>
                    </div>
                </div>

                <div class="chat-actions">
                    <span>🔍</span>
                    <span>⋮</span>
                </div>
            </div>

            <div class="chat-body">
                <div class="msg-row left">
                    <div>
                        <div class="msg-bubble left">
                            Hello! I'm your NDIS Support Assistant. How can I help you manage your participants or shifts today?
                        </div>
                        <div class="msg-time">10:34 AM</div>
                    </div>
                </div>

                <div class="msg-row right">
                    <div>
                        <div class="msg-bubble right">
                            Hi there. I seem to be having trouble locating the invoice for the last shift with John Doe. Can you help me find it?
                        </div>
                        <div class="msg-time right">10:41 AM</div>
                    </div>
                </div>

                <div class="msg-row left">
                    <div>
                        <div class="msg-bubble left">
                            Sure, I can help with that. Is it regarding invoice #882 from October 22nd?

                            <div class="attach-card">
                                <div class="attach-left">
                                    <div class="attach-icon">📄</div>
                                    <div>
                                        <div class="attach-name">Invoice #882 - John Doe</div>
                                        <div class="attach-meta">PDF · 1.2 MB</div>
                                    </div>
                                </div>
                                <div style="font-size:10px; color:#2563eb; font-weight:600;">View</div>
                            </div>
                        </div>
                        <div class="msg-time">10:42 AM</div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <button class="quick-btn">Yes, that's the one</button>
                <button class="quick-btn">No, different date</button>
                <button class="quick-btn">Download PDF</button>
            </div>

            <div class="chat-input-bar">
                <span class="chat-input-icon">📎</span>
                <input type="text" class="chat-input" placeholder="Type your message here...">
                <button class="send-btn">➤</button>
            </div>

            <div class="footer-note">
                This is an automated assistant. For medical emergencies, please call 000 immediately.
            </div>
        </div>
    </div>
</div>
@endsection