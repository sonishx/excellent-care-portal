@extends('layouts.app')

@section('title', 'Compose Message - Excellent Care Services')

@section('content')
<style>
    .compose-container { max-width: 820px; margin: 0 auto; }

    .compose-hero {
        background: linear-gradient(135deg, #6f2dbd 0%, #a663cc 100%);
        border-radius: 24px;
        padding: 36px 40px;
        color: white;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    .compose-hero::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .compose-hero h1 { font-size: 26px; font-weight: 900; letter-spacing: -0.5px; margin: 0 0 6px; position: relative; z-index: 1; }
    .compose-hero p  { font-size: 14px; opacity: 0.85; margin: 0; position: relative; z-index: 1; }

    .compose-card {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        padding: 36px;
    }

    .form-group { margin-bottom: 24px; }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-group .form-hint {
        font-size: 12px;
        color: var(--text-light);
        font-weight: 400;
        text-transform: none;
        letter-spacing: 0;
        margin-left: 8px;
    }

    .styled-select, .styled-input {
        width: 100%;
        height: 52px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 0 18px;
        font-size: 15px;
        font-family: inherit;
        font-weight: 500;
        color: var(--text);
        background: #fafbfc;
        transition: all 0.25s cubic-bezier(.4,0,.2,1);
        outline: none;
        -webkit-appearance: none;
    }
    .styled-select:focus, .styled-input:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(111,45,189,0.08);
    }
    .styled-select::placeholder, .styled-input::placeholder { color: #94a3b8; }

    .styled-textarea {
        width: 100%;
        min-height: 220px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px;
        font-size: 15px;
        font-family: inherit;
        font-weight: 400;
        color: var(--text);
        background: #fafbfc;
        transition: all 0.25s cubic-bezier(.4,0,.2,1);
        outline: none;
        resize: vertical;
        line-height: 1.7;
    }
    .styled-textarea:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(111,45,189,0.08);
    }
    .styled-textarea::placeholder { color: #94a3b8; }

    .compose-actions {
        display: flex;
        gap: 14px;
        justify-content: flex-end;
        padding-top: 24px;
        border-top: 1px solid var(--border);
        margin-top: 8px;
    }
    .compose-actions .btn-primary {
        padding: 14px 36px;
        border-radius: 50px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .compose-actions .btn-outline {
        padding: 14px 28px;
        border-radius: 50px;
        font-size: 14px;
    }

    /* Recipient preview */
    .recipient-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(111,45,189,0.04);
        border: 1px solid rgba(111,45,189,0.1);
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    .recipient-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 800;
        font-size: 14px;
    }
</style>

<div class="compose-container">
    <div class="compose-hero">
        <h1>Compose Message</h1>
        <p>Send a secure, private message to any portal member.</p>
    </div>

    @if($recipient)
        <div class="recipient-preview">
            <div class="recipient-avatar">{{ strtoupper(substr($recipient->name, 0, 1)) }}</div>
            <div>
                <div style="font-weight: 700; font-size: 14px;">Replying to {{ $recipient->name }}</div>
                <div style="font-size: 12px; color: var(--text-light);">{{ ucfirst($recipient->role) }}</div>
            </div>
        </div>
    @endif

    <div class="compose-card">
        <form action="{{ route('messages.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Recipient <span class="form-hint">— Choose who receives this message</span></label>
                <select name="receiver_id" class="styled-select" required>
                    <option value="">Select a portal member...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ ($recipient && $recipient->id == $user->id) ? 'selected' : '' }}>
                            {{ $user->name }} — {{ ucfirst($user->role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Subject <span class="form-hint">— Brief topic of your message</span></label>
                <input type="text" name="subject" class="styled-input" value="{{ $subject ?? '' }}" placeholder="e.g. Care plan update for next week" required>
            </div>

            <div class="form-group">
                <label>Message Body</label>
                <textarea name="message" class="styled-textarea" placeholder="Write your message here. Be specific about any clinical updates, requests, or questions..." required></textarea>
            </div>

            <div class="compose-actions">
                <a href="{{ route('messages.index') }}" class="btn-outline" style="text-decoration: none;">Cancel</a>
                <button type="submit" class="btn-primary">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
