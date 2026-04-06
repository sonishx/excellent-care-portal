@extends('layouts.app')

@section('title', 'Inbox - Excellent Care Services')

@section('content')
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }

    .inbox-page {
        min-height: 100vh;
        background: #f5f7fb;
        padding: 24px;
    }

    .inbox-shell {
        max-width: 1080px;
        margin: 0 auto;
        background: #ffffff;
        min-height: 630px;
        display: grid;
        grid-template-columns: 135px 270px 1fr;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
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

    .user-box {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 4px 0;
    }

    .user-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
    }

    .user-name {
        font-size: 9px;
        font-weight: 600;
        color: #111827;
        line-height: 1.2;
    }

    .user-role {
        font-size: 8px;
        color: #7c8796;
        line-height: 1.2;
    }

    .list-panel {
        border-right: 1px solid #eef2f7;
        background: #ffffff;
        padding: 14px 14px 10px;
    }

    .title {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
    }

    .search-input {
        width: 100%;
        height: 34px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0 12px;
        font-size: 11px;
        margin-bottom: 12px;
        outline: none;
    }

    .tabs {
        display: flex;
        gap: 6px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .tab {
        padding: 5px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        background: #fff;
        font-size: 9px;
        color: #556070;
    }

    .tab.active {
        background: #f4f6f8;
        font-weight: 600;
    }

    .conversation {
        display: flex;
        gap: 10px;
        padding: 10px 8px;
        border-radius: 10px;
        align-items: flex-start;
    }

    .conversation:hover {
        background: #fafbfc;
    }

    .conv-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fde68a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .conv-body {
        flex: 1;
        min-width: 0;
    }

    .conv-top {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 2px;
    }

    .conv-name {
        font-size: 11px;
        font-weight: 700;
        color: #111827;
        line-height: 1.25;
    }

    .conv-time {
        font-size: 9px;
        color: #7c8796;
        white-space: nowrap;
    }

    .conv-subject {
        font-size: 10px;
        color: #111827;
        line-height: 1.3;
        margin-bottom: 2px;
    }

    .conv-preview {
        font-size: 9px;
        color: #94a3b8;
        line-height: 1.35;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 185px;
    }

    .conv-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #2563eb;
        margin-top: 6px;
        flex-shrink: 0;
    }

    .conversation-panel {
        position: relative;
        background: #ffffff;
        padding: 14px;
        display: flex;
        flex-direction: column;
    }

    .top-actions {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 10px;
    }

    .new-btn {
        background: #1f6ef2;
        color: white;
        border: none;
        border-radius: 7px;
        padding: 7px 14px;
        font-size: 10px;
        font-weight: 600;
    }

    .conversation-box {
        flex: 1;
        border: 1px solid #edf1f5;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 540px;
        background: #fff;
    }

    .empty-state {
        text-align: center;
        max-width: 250px;
    }

    .empty-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: #f3f5f7;
        color: #c0c8d2;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .empty-title {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
    }

    .empty-text {
        font-size: 11px;
        color: #7c8796;
        line-height: 1.5;
        margin-bottom: 18px;
    }

    .empty-btn {
        border: 1px solid #dbe2ea;
        background: #fff;
        border-radius: 7px;
        padding: 8px 14px;
        font-size: 10px;
        font-weight: 600;
        color: #4b5563;
    }

    @media (max-width: 1100px) {
        .inbox-shell {
            grid-template-columns: 1fr;
        }

        .sidebar,
        .list-panel {
            border-right: none;
            border-bottom: 1px solid #eef2f7;
        }

        .conversation-box {
            min-height: 400px;
        }
    }
</style>

<div class="inbox-page">
    <div class="inbox-shell">
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
                    <a href="#">👥 Clients</a>
                    <a href="/inbox" class="active">💬 Messages</a>
                    <a href="#">📅 Schedule</a>
                    <a href="/settings">⚙ Settings</a>
                </div>
            </div>

            <div class="user-box">
                <div class="user-avatar">👩</div>
                <div>
                    <div class="user-name">Dr. Sarah Smith</div>
                    <div class="user-role">Senior Clinician</div>
                </div>
            </div>
        </div>

        <!-- Inbox list -->
        <div class="list-panel">
            <div class="title">Inbox</div>

            <input type="text" class="search-input" placeholder="Search messages or people...">

            <div class="tabs">
                <div class="tab active">All</div>
                <div class="tab">Unread 2</div>
                <div class="tab">Archived</div>
                <div class="tab">Starred</div>
            </div>

            <div class="conversation">
                <div class="conv-avatar" style="background:#fcd6c8;">👩</div>
                <div class="conv-body">
                    <div class="conv-top">
                        <div class="conv-name">Sarah Jenkins (Physio)</div>
                        <div class="conv-time">10:30 AM</div>
                    </div>
                    <div class="conv-subject">Re: NDIS Plan Review Updates</div>
                    <div class="conv-preview">Hi Dr. Smith, I've updated the plan documents for...</div>
                </div>
                <div class="conv-dot"></div>
            </div>

            <div class="conversation">
                <div class="conv-avatar" style="background:#ddd6fe;">CT</div>
                <div class="conv-body">
                    <div class="conv-top">
                        <div class="conv-name">Caregiver Team</div>
                        <div class="conv-time">09:15 AM</div>
                    </div>
                    <div class="conv-subject">Shift confirmation for Weekend</div>
                    <div class="conv-preview">Just confirming the roster changes for the upcoming...</div>
                </div>
                <div class="conv-dot"></div>
            </div>

            <div class="conversation">
                <div class="conv-avatar" style="background:#fbcfe8;">👩</div>
                <div class="conv-body">
                    <div class="conv-top">
                        <div class="conv-name">Jane Doe (Participant)</div>
                        <div class="conv-time">Yesterday</div>
                    </div>
                    <div class="conv-subject">Question about medication</div>
                    <div class="conv-preview">Can I take these with food or should I wait until...</div>
                </div>
            </div>

            <div class="conversation">
                <div class="conv-avatar" style="background:#bbf7d0;">↩</div>
                <div class="conv-body">
                    <div class="conv-top">
                        <div class="conv-name">My Aged Care Support</div>
                        <div class="conv-time">Mon</div>
                    </div>
                    <div class="conv-subject">New guidelines update v2.4</div>
                    <div class="conv-preview">Please review the attached PDF regarding new...</div>
                </div>
            </div>

            <div class="conversation">
                <div class="conv-avatar" style="background:#fdba74;">👨</div>
                <div class="conv-body">
                    <div class="conv-top">
                        <div class="conv-name">Mark Wilson</div>
                        <div class="conv-time">Last week</div>
                    </div>
                    <div class="conv-subject">Re: Appointment Reschedule</div>
                    <div class="conv-preview">That time works perfectly for me. See you then.</div>
                </div>
            </div>
        </div>

        <!-- Empty state -->
        <div class="conversation-panel">
            <div class="top-actions">
                <button class="new-btn">+ New Message</button>
            </div>

            <div class="conversation-box">
                <div class="empty-state">
                    <div class="empty-icon">💬</div>
                    <div class="empty-title">Select a conversation</div>
                    <div class="empty-text">
                        Choose a message from the list to view details,<br>
                        reply to patients, or collaborate with your care<br>
                        team.
                    </div>
                    <button class="empty-btn">✎ Start a new conversation</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection