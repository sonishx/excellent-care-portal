@extends('layouts.app')

@section('title', 'Chat Support')

@section('content')
<div style="max-width:600px; margin:30px auto;">
    <div id="chat-messages" style="border:1px solid #ddd; min-height:400px; padding:12px; overflow-y:auto;"></div>

    <form id="chatForm" style="display:flex; margin-top:12px;">
        @csrf
        <input type="text" id="chatInput" placeholder="Type your message..." style="flex:1; padding:8px 12px; border:1px solid #ccc; border-radius:4px;">
        <button type="submit" style="margin-left:6px; padding:8px 12px; border:none; background:#1f6ef2; color:white; border-radius:4px;">Send</button>
    </form>
</div>

<script>
const form = document.getElementById('chatForm');
const input = document.getElementById('chatInput');
const chatMessages = document.getElementById('chat-messages');

form.addEventListener('submit', async function(e) {
    e.preventDefault();
    const msg = input.value.trim();
    if (!msg) return;

    // Show user message
    chatMessages.innerHTML += `<div style="text-align:right; margin-bottom:6px;"><b>You:</b> ${msg}</div>`;
    input.value = '';
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Send to BotMan
    const res = await fetch("{{ route('botman.handle') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ message: msg })
    });

    // BotMan outputs directly via echo, so you can optionally capture responses via frontend event
});
</script>
@endsection