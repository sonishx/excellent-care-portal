@extends('layouts.app')

@section('title', 'View Message - Excellent Care Services')

@section('content')
<style>
    .detail-container { max-width: 820px; margin: 0 auto; }

    /* Back navigation */
    .detail-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: var(--text-light);
        font-size: 13px;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 50px;
        background: white;
        border: 1px solid var(--border);
        transition: all 0.2s;
        margin-bottom: 28px;
    }
    .detail-back:hover {
        color: var(--primary);
        border-color: var(--primary);
        transform: translateX(-4px);
    }

    /* Subject header */
    .detail-subject {
        margin-bottom: 28px;
    }
    .detail-subject h1 {
        font-size: 28px;
        font-weight: 900;
        letter-spacing: -0.8px;
        color: var(--text);
        margin: 0 0 14px;
        line-height: 1.3;
    }
    .detail-meta {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }
    .detail-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-light);
    }
    .detail-meta-label {
        font-weight: 700;
        color: var(--text);
    }
    .detail-meta-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }
    .detail-meta-icon.from { background: rgba(111,45,189,0.08); }
    .detail-meta-icon.to   { background: rgba(5,150,105,0.08); }
    .detail-meta-icon.time { background: rgba(37,99,235,0.08); }
    .detail-meta-icon.status { background: rgba(244,93,117,0.08); }

    /* Message bubble */
    .detail-bubble {
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        overflow: hidden;
        margin-bottom: 28px;
    }
    .detail-bubble-header {
        padding: 24px 32px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 16px;
        background: linear-gradient(135deg, rgba(111,45,189,0.02), rgba(244,93,117,0.02));
    }
    .detail-sender-avatar {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        font-weight: 800;
        flex-shrink: 0;
    }
    .detail-sender-name { font-weight: 800; font-size: 17px; color: var(--text); }
    .detail-sender-role {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 6px;
        display: inline-block;
        margin-top: 3px;
    }
    .detail-sender-role.clinician  { background: rgba(37,99,235,0.08); color: #2563eb; }
    .detail-sender-role.caregiver  { background: rgba(5,150,105,0.08); color: #059669; }
    .detail-sender-role.admin      { background: rgba(111,45,189,0.08); color: #6f2dbd; }
    .detail-sender-role.patient    { background: rgba(217,119,6,0.08); color: #d97706; }

    .detail-bubble-body {
        padding: 32px;
        font-size: 16px;
        line-height: 1.9;
        color: var(--text);
        white-space: pre-line;
    }
    .detail-bubble-footer {
        padding: 18px 32px;
        border-top: 1px solid var(--border);
        background: #fafbfc;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        color: var(--text-light);
    }

    /* Reply section */
    .detail-reply {
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        padding: 32px;
    }
    .detail-reply h3 {
        margin: 0 0 8px;
        font-size: 18px;
        font-weight: 800;
    }
    .detail-reply p {
        font-size: 13px;
        color: var(--text-light);
        margin: 0 0 24px;
    }
    .reply-actions {
        display: flex;
        gap: 14px;
    }
    .reply-btn {
        flex: 1;
        padding: 14px 24px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(.4,0,.2,1);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .reply-btn.primary {
        background: linear-gradient(135deg, #6f2dbd, #a663cc);
        color: white;
        border: none;
    }
    .reply-btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(111,45,189,0.3);
    }
    .reply-btn.secondary {
        background: white;
        color: var(--text-light);
        border: 2px solid var(--border);
    }
    .reply-btn.secondary:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
</style>

<div class="detail-container">
    <a href="{{ route('messages.index') }}" class="detail-back">← Back to Messages</a>

    <!-- Subject + Meta -->
    <div class="detail-subject">
        <h1>{{ $message->subject }}</h1>
        <div class="detail-meta">
            <div class="detail-meta-item">
                <div class="detail-meta-icon from">F</div>
                <span class="detail-meta-label">From:</span>
                {{ $message->sender->name }}
            </div>
            <div class="detail-meta-item">
                <div class="detail-meta-icon to">T</div>
                <span class="detail-meta-label">To:</span>
                {{ $message->receiver->name }}
            </div>
            <div class="detail-meta-item">
                <div class="detail-meta-icon time">S</div>
                {{ $message->created_at->format('M d, Y • h:i A') }}
            </div>
            @if($message->read_at)
                <div class="detail-meta-item">
                    <div class="detail-meta-icon status">✓</div>
                    Read {{ $message->read_at->diffForHumans() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Message Bubble -->
    <div class="detail-bubble">
        <div class="detail-bubble-header">
            <div class="detail-sender-avatar">
                {{ strtoupper(substr($message->sender->name, 0, 1)) }}
            </div>
            <div>
                <div class="detail-sender-name">{{ $message->sender->name }}</div>
                <span class="detail-sender-role {{ strtolower($message->sender->role) }}">{{ $message->sender->role }}</span>
            </div>
        </div>

        <div class="detail-bubble-body">{{ $message->message }}</div>

        <div class="detail-bubble-footer">
            <span>Sent {{ $message->created_at->diffForHumans() }}</span>
            <span>Encrypted & Secure</span>
        </div>
    </div>

    <!-- Reply Section -->
    @if($message->receiver_id === Auth::id())
        <div class="detail-reply">
            <h3>Continue Conversation</h3>
            <p>Reply directly to {{ $message->sender->name }} or take further action on this message.</p>
            <div class="reply-actions">
                <a href="{{ route('messages.create', ['reply_to' => $message->sender_id, 'subject' => 'Re: ' . $message->subject]) }}" class="reply-btn primary">
                    Reply
                </a>
                <a href="{{ route('messages.create') }}" class="reply-btn secondary">
                    New Message
                </a>
                <a href="{{ route('messages.index') }}" class="reply-btn secondary">
                    Back to Inbox
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
