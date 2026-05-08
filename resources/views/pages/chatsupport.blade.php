@extends('layouts.app')

@section('title', 'Chat Support - Excellent Care Services')

@section('content')
<style>
    .chat-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 24px;
        min-height: calc(100vh - 200px);
        margin-bottom: 50px;
    }

    .history-card {
        background: white;
        border-radius: 16px;
        padding: 20px 0;
        box-shadow: var(--shadow);
    }

    .history-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--text);
        padding: 0 20px 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .history-list {
        max-height: 500px;
        overflow-y: auto;
    }

    .history-item {
        padding: 12px 20px;
        cursor: pointer;
        transition: all 0.2s;
        border-left: 3px solid transparent;
    }

    .history-item:hover {
        background: rgba(111, 45, 189, 0.05);
        color: var(--primary);
    }

    .history-item.active {
        background: rgba(111, 45, 189, 0.08);
        border-left: 3px solid var(--primary);
        color: var(--primary);
    }

    .chat-card {
        background: white;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .chat-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-messages {
        flex: 1;
        padding: 24px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 16px;
        background: #fdfdff;
    }

    .message-bubble {
        max-width: 75%;
        padding: 12px 18px;
        border-radius: 18px;
        font-size: 14px;
        line-height: 1.5;
        position: relative;
    }

    .message-user {
        align-self: flex-end;
        background: #6f2dbd; /* Fallback solid color */
        background: var(--primary-gradient);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 12px rgba(111, 45, 189, 0.2);
    }

    .message-bot {
        align-self: flex-start;
        background: white;
        color: var(--text);
        border-bottom-left-radius: 4px;
        border: 1px solid var(--border);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .chat-input-area {
        padding: 20px 24px;
        border-top: 1px solid var(--border);
        background: white;
    }

    .chat-input-form {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .chat-input {
        flex: 1;
        background: #f8fafc;
        border: 1px solid var(--border);
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .chat-input:focus {
        background: white;
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 4px rgba(111, 45, 189, 0.1);
    }

    .send-btn {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--primary);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .send-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(111, 45, 189, 0.3);
    }
</style>

<div class="chat-layout">
    <!-- Sidebar -->
    <div class="history-card">
        <h3 class="history-title">Chat History</h3>
        
        <div style="padding: 0 20px 15px;">
            <button id="newChatBtn" class="btn-outline" style="width: 100%; font-size: 12px;">+ New Session</button>
        </div>

        <div class="history-list" id="chat-history">
            @foreach($messages as $msg)
                @if($msg->sender_type === 'user')
                    <div class="history-item" data-date="{{ $msg->created_at->format('Y-m-d') }}">
                        <div style="font-weight: 700; font-size: 13px; margin-bottom: 2px;">{{ Str::limit($msg->message, 25) }}</div>
                        <div style="font-size: 11px; color: var(--text-light);">{{ $msg->created_at->format('M d, h:i A') }}</div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Main Chat -->
    <div class="chat-card">
        <div class="chat-header">
            <div>
                <h2 style="font-size: 16px; font-weight: 800; color: var(--text);">Support Intelligence</h2>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: #16a34a; font-weight: 700;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #16a34a;"></span>
                    System Online
                </div>
            </div>
            <button class="btn-outline" style="padding: 6px 12px; font-size: 11px;">Clear Transcript</button>
        </div>

        <div class="chat-messages" id="chat-messages">
            @if(count($messages) === 0)
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; opacity: 0.5;">
                    <div style="font-size: 48px; margin-bottom: 10px;">🛡️</div>
                    <p style="font-weight: 700; color: var(--text-light);">How can I assist you today?</p>
                </div>
            @else
                @foreach($messages as $msg)
                    <div class="message-bubble {{ $msg->sender_type == 'user' ? 'message-user' : 'message-bot' }}">
                        {{ $msg->message }}
                        <div style="font-size: 10px; margin-top: 6px; opacity: 0.7; text-align: {{ $msg->sender_type == 'user' ? 'right' : 'left' }}">
                            {{ $msg->created_at->format('h:i A') }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div id="loading-indicator" style="display: none; padding: 0 24px 15px;">
            <div class="message-bubble message-bot" style="width: 60px; text-align: center;">
                <span class="dot-bounce">.</span><span class="dot-bounce">.</span><span class="dot-bounce">.</span>
            </div>
        </div>

        <div class="chat-input-area">
            <form id="chatForm" class="chat-input-form">
                @csrf
                <input type="text" name="message" id="chatInput" class="chat-input" placeholder="Type your inquiry here..." required>
                <button type="submit" class="send-btn">
                    <span style="font-size: 18px;">➤</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .dot-bounce {
        display: inline-block;
        animation: bounce 1.4s infinite;
    }
    .dot-bounce:nth-child(2) { animation-delay: 0.2s; }
    .dot-bounce:nth-child(3) { animation-delay: 0.4s; }

    @keyframes bounce {
        0%, 60%, 100% { opacity: 0.3; transform: translateY(0); }
        30% { opacity: 1; transform: translateY(-4px); }
    }

    #chat-messages::-webkit-scrollbar { width: 6px; }
    #chat-messages::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
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
    userDiv.className = "message-bubble message-user";
    userDiv.innerHTML = `${escapeHtml(msg)}<div style="font-size:10px; margin-top:6px; opacity:0.7; text-align:right;">Just now</div>`;
    chatMessages.appendChild(userDiv);

    input.value = '';
    input.focus();
    scrollToBottom();

    // Show loading indicator
    loadingIndicator.style.display = 'block';
    scrollToBottom();

    try {
        const response = await fetch("{{ route('chatsupport.send') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": token },
            body: JSON.stringify({ message: msg })
        });

        const data = await response.json();
        loadingIndicator.style.display = 'none';

        if (data.success && data.message) {
            const botDiv = document.createElement('div');
            botDiv.className = "message-bubble message-bot";
            botDiv.innerHTML = `${data.message}<div style="font-size:10px; margin-top:6px; opacity:0.7;">Just now</div>`;
            chatMessages.appendChild(botDiv);
        }
        scrollToBottom();
    } catch (error) {
        loadingIndicator.style.display = 'none';
        const errorDiv = document.createElement('div');
        errorDiv.className = "message-bubble";
        errorDiv.style.background = "#fee2e2";
        errorDiv.style.color = "#dc2626";
        errorDiv.textContent = "Sorry, I encountered an error. Please try again.";
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