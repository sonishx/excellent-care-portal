@extends('layouts.app')

@section('title', 'Chat Support - Excellent Care Services')

@section('content')
<div style="display:flex; max-width:1200px; margin:30px auto; gap:16px; min-height:600px;">
    <!-- Sidebar -->
    <div style="width:180px; background:#f8f9fa; padding:12px; border-radius:8px;">
        <h3 style="font-size:14px; font-weight:700;">Chat History</h3>
        <div id="chat-history">
            @foreach($messages as $msg)
                <div style="padding:6px; border-radius:6px; margin-bottom:4px; background: {{ $loop->last ? '#eaf2ff' : '#fff' }};">
                    <strong>{{ $msg->sender_type == 'bot' ? 'NDIS Bot' : Auth::user()->name }}</strong>
                    <div style="font-size:11px; color:#6b7280;">{{ $msg->created_at->format('h:i A') }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Chat Panel -->
    <div style="flex:1; display:flex; flex-direction:column; background:#fff; border-radius:8px; padding:12px;">
        <div id="chat-messages" style="flex:1; overflow-y:auto; padding-bottom:12px;">
            @foreach($messages as $msg)
                <div style="display:flex; justify-content:{{ $msg->sender_type == 'user' ? 'flex-end' : 'flex-start' }}; margin-bottom:8px;">
                    <div style="max-width:60%; padding:8px 12px; border-radius:12px; background: {{ $msg->sender_type == 'user' ? '#1f6ef2' : '#f3f4f6' }}; color: {{ $msg->sender_type == 'user' ? '#fff' : '#111827' }};">
                        {{ $msg->message }}
                        <div style="font-size:9px; color:{{ $msg->sender_type == 'user' ? '#dbeafe' : '#6b7280' }}; margin-top:2px;">
                            {{ $msg->created_at->format('h:i A') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Input -->
        <form id="chatForm" style="display:flex; gap:8px; margin-top:12px;">
            @csrf
            <input type="text" name="message" id="chatInput" placeholder="Type your message..." style="flex:1; padding:8px 12px; border-radius:999px; border:1px solid #dbe2ea;">
            <button type="submit" style="width:36px; height:36px; border:none; border-radius:50%; background:#1f6ef2; color:#fff;">➤</button>
        </form>
    </div>
</div>

<script>
const form = document.getElementById('chatForm');
const input = document.getElementById('chatInput');
const chatMessages = document.getElementById('chat-messages');

form.addEventListener('submit', async function(e) {
    e.preventDefault();
    const msg = input.value.trim();
    if(!msg) return;

    const token = document.querySelector('input[name="_token"]').value;

    // Append user message
    const userDiv = document.createElement('div');
    userDiv.style.cssText = "display:flex; justify-content:flex-end; margin-bottom:8px;";
    userDiv.innerHTML = `<div style="max-width:60%; padding:8px 12px; border-radius:12px; background:#1f6ef2; color:#fff;">${msg}</div>`;
    chatMessages.appendChild(userDiv);

    input.value = '';
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Save message to backend
    await fetch("{{ route('chatsupport.send') }}", {
        method: "POST",
        headers: { "Content-Type":"application/json", "X-CSRF-TOKEN": token },
        body: JSON.stringify({ message: msg })
    });

    // Generate bot response in browser
    const botReply = generateBotReply(msg);

    const botDiv = document.createElement('div');
    botDiv.style.cssText = "display:flex; justify-content:flex-start; margin-bottom:8px;";
    botDiv.innerHTML = `<div style="max-width:60%; padding:8px 12px; border-radius:12px; background:#f3f4f6; color:#111827;">${botReply}</div>`;
    chatMessages.appendChild(botDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
});

// Simple browser-based AI logic
function generateBotReply(message) {
    const msg = message.toLowerCase();
    if(msg.includes('invoice')) return "Sure! Please provide the invoice number or date.";
    if(msg.includes('shift')) return "You can view all your shifts under 'Patients' or 'Care Plans'.";
    if(msg.includes('care plan')) return "I can help you with care plans. Which patient do you want to view?";
    return "Hi! Can you clarify your request?";
}
</script>
@endsection