@extends('layouts.app')

@section('title', 'Chat Support - Excellent Care Services')

@section('content')
<div style="display:flex; max-width:1200px; margin:30px auto; gap:16px; min-height:600px;">
    <!-- Sidebar -->
    <div style="width:180px; background:#f8f9fa; padding:12px; border-radius:8px;">
        <h3 style="font-size:14px; font-weight:700; margin-top:0;">Chat History</h3>
        <button id="newChatBtn" style="width:100%; padding:8px; border:1px solid #dbe2ea; background:#fff; border-radius:6px; cursor:pointer; font-size:12px; font-weight:600; color:#1f6ef2; margin-bottom:12px;">+ New Chat</button>
        <div id="chat-history" style="max-height:400px; overflow-y:auto;">
            @foreach($messages as $msg)
                @if($msg->sender_type === 'user')
                <div style="padding:8px; border-radius:6px; margin-bottom:6px; background:#eaf2ff; cursor:pointer; font-size:11px;" class="history-item" data-date="{{ $msg->created_at->format('Y-m-d') }}">
                    <div style="font-weight:600; color:#111827;">{{ Str::limit($msg->message, 30) }}</div>
                    <div style="color:#6b7280; margin-top:2px;">{{ $msg->created_at->format('M d, h:i A') }}</div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Chat Panel -->
    <div style="flex:1; display:flex; flex-direction:column; background:#fff; border-radius:8px; padding:16px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="border-bottom:1px solid #edf1f5; padding-bottom:12px; margin-bottom:12px;">
            <h2 style="margin:0; font-size:16px; color:#111827;">NDIS Care Support Bot</h2>
            <p style="margin:4px 0 0 0; font-size:12px; color:#6b7280;">Powered by AI • Available 24/7</p>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" style="flex:1; overflow-y:auto; padding:12px 0; margin-bottom:12px;">
            @if(count($messages) === 0)
            <div style="display:flex; align-items:center; justify-content:center; height:100%; color:#9ca3af; text-align:center;">
                <div>
                    <div style="font-size:32px; margin-bottom:8px;">💬</div>
                    <p style="margin:0; font-size:13px;">Start a conversation with the support bot</p>
                </div>
            </div>
            @else
                @foreach($messages as $msg)
                <div style="display:flex; justify-content:{{ $msg->sender_type == 'user' ? 'flex-end' : 'flex-start' }}; margin-bottom:12px;" class="message-item">
                    <div style="max-width:65%; padding:10px 14px; border-radius:12px; background: {{ $msg->sender_type == 'user' ? '#1f6ef2' : '#f3f4f6' }}; color: {{ $msg->sender_type == 'user' ? '#fff' : '#111827' }};  box-shadow:{{ $msg->sender_type == 'user' ? '0 2px 8px rgba(31,110,242,0.2)' : 'none' }};">
                        {{ $msg->message }}
                        <div style="font-size:10px; color:{{ $msg->sender_type == 'user' ? '#dbeafe' : '#6b7280' }}; margin-top:4px;">
                            {{ $msg->created_at->format('h:i A') }}
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <!-- Loading Indicator -->
        <div id="loading-indicator" style="display:none; margin-bottom:12px;">
            <div style="display:flex; justify-content:flex-start;">
                <div style="padding:10px 14px; border-radius:12px; background:#f3f4f6; color:#111827;">
                    <span style="display:inline-block; animation: bounce 1.4s infinite;">.</span><span style="display:inline-block; animation: bounce 1.4s infinite; animation-delay: 0.2s;">.</span><span style="display:inline-block; animation: bounce 1.4s infinite; animation-delay: 0.4s;">.</span>
                </div>
            </div>
        </div>

        <!-- Input Form -->
        <form id="chatForm" style="display:flex; gap:8px;">
            @csrf
            <input type="text" name="message" id="chatInput" placeholder="Type your message..." style="flex:1; padding:10px 14px; border-radius:999px; border:1px solid #dbe2ea; font-size:13px; outline:none; transition:border-color 0.3s;" required>
            <button type="submit" style="width:40px; height:40px; border:none; border-radius:50%; background:#1f6ef2; color:#fff; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; transition:background 0.3s;" title="Send message">
                ➤
            </button>
        </form>
    </div>
</div>

<style>
    #chatInput:focus {
        border-color: #1f6ef2;
        box-shadow: 0 0 0 3px rgba(31,110,242,0.1);
    }

    button[type="submit"]:hover {
        background: #155edf;
    }

    .history-item:hover {
        background: #dbeafe !important;
    }

    @keyframes bounce {
        0%, 60%, 100% { opacity: 0.3; }
        30% { opacity: 1; }
    }

    #chat-messages {
        scroll-behavior: smooth;
    }
</style>

<script>
const form = document.getElementById('chatForm');
const input = document.getElementById('chatInput');
const chatMessages = document.getElementById('chat-messages');
const loadingIndicator = document.getElementById('loading-indicator');
const newChatBtn = document.getElementById('newChatBtn');

// Auto-scroll to bottom
function scrollToBottom() {
    setTimeout(() => {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }, 0);
}

scrollToBottom();

// Send message
form.addEventListener('submit', async function(e) {
    e.preventDefault();
    const msg = input.value.trim();
    if(!msg) return;

    const token = document.querySelector('input[name="_token"]').value;

    // Append user message
    const userDiv = document.createElement('div');
    userDiv.style.cssText = "display:flex; justify-content:flex-end; margin-bottom:12px;";
    userDiv.innerHTML = `<div style="max-width:65%; padding:10px 14px; border-radius:12px; background:#1f6ef2; color:#fff; box-shadow:0 2px 8px rgba(31,110,242,0.2);">${escapeHtml(msg)}</div>`;
    chatMessages.appendChild(userDiv);

    input.value = '';
    input.focus();
    scrollToBottom();

    // Show loading indicator
    loadingIndicator.style.display = 'block';
    scrollToBottom();

    try {
        // Send message to backend
        const response = await fetch("{{ route('chatsupport.send') }}", {
            method: "POST",
            headers: { 
                "Content-Type": "application/json", 
                "X-CSRF-TOKEN": token 
            },
            body: JSON.stringify({ message: msg })
        });

        const data = await response.json();

        // Hide loading indicator
        loadingIndicator.style.display = 'none';

        if (data.success && data.message) {
            // Append bot message
            const botDiv = document.createElement('div');
            botDiv.style.cssText = "display:flex; justify-content:flex-start; margin-bottom:12px;";
            botDiv.innerHTML = `<div style="max-width:65%; padding:10px 14px; border-radius:12px; background:#f3f4f6; color:#111827;">${data.message}</div>`;
            chatMessages.appendChild(botDiv);
        }

        scrollToBottom();
    } catch (error) {
        loadingIndicator.style.display = 'none';
        const errorDiv = document.createElement('div');
        errorDiv.style.cssText = "display:flex; justify-content:flex-start; margin-bottom:12px;";
        errorDiv.innerHTML = `<div style="max-width:65%; padding:10px 14px; border-radius:12px; background:#fee2e2; color:#dc2626;">Sorry, I encountered an error. Please try again.</div>`;
        chatMessages.appendChild(errorDiv);
        scrollToBottom();
    }
});

// Helper function to escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// New chat button
newChatBtn.addEventListener('click', function() {
    if(confirm('Start a new conversation? Current chat will be preserved in history.')) {
        chatMessages.innerHTML = '<div style="display:flex; align-items:center; justify-content:center; height:100%; color:#9ca3af; text-align:center;"><div><div style="font-size:32px; margin-bottom:8px;">💬</div><p style="margin:0; font-size:13px;">Start a conversation with the support bot</p></div></div>';
        input.focus();
        scrollToBottom();
    }
});
</script>
@endsection