<div id="chatbot-wrapper" class="chatbot-wrapper">
    <!-- Chatbot Toggle Button -->
    <button id="chatbot-toggle" class="chatbot-toggle">
        <span class="chat-icon">💬</span>
        <span class="close-icon" style="display: none;">✕</span>
    </button>

    <!-- Chatbot Window -->
    <div id="chatbot-window" class="chatbot-window" style="display: none;">
        <div class="chatbot-header">
            <div class="header-info">
                <div class="bot-avatar">AI</div>
                <div>
                    <div class="bot-name">Care Assistant</div>
                    <div class="bot-status">Online</div>
                </div>
            </div>
            <button id="chatbot-close" class="chatbot-close">✕</button>
        </div>

        <div id="chatbot-messages" class="chatbot-messages">
            <div class="message bot">
                Hello! I'm your virtual assistant. How can I help you today?
            </div>
        </div>

        <div id="chatbot-typing" class="chatbot-typing" style="display: none;">
            <span></span><span></span><span></span>
        </div>

        <form id="chatbot-form" class="chatbot-form">
            @csrf
            <input type="text" id="chatbot-input" placeholder="Type your message..." autocomplete="off">
            <button type="submit">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
            </button>
        </form>
    </div>
</div>

<style>
    .chatbot-wrapper {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        font-family: 'Inter', sans-serif;
    }

    .chatbot-toggle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #6f2dbd;
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(111, 45, 189, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .chatbot-toggle:hover {
        transform: scale(1.1);
    }

    .chatbot-window {
        position: absolute;
        bottom: 80px;
        right: 0;
        width: 350px;
        height: 500px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .chatbot-header {
        padding: 15px 20px;
        background: #6f2dbd;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .bot-avatar {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }

    .bot-name {
        font-size: 14px;
        font-weight: 600;
    }

    .bot-status {
        font-size: 11px;
        opacity: 0.8;
    }

    .chatbot-close {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }

    .chatbot-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: #f8f9fa;
    }

    .message {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 14px;
        font-size: 13px;
        line-height: 1.5;
    }

    .message.bot {
        align-self: flex-start;
        background: white;
        color: #333;
        border-bottom-left-radius: 2px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .message.user {
        align-self: flex-end;
        background: #6f2dbd;
        background: var(--primary-gradient);
        color: white;
        border-bottom-right-radius: 2px;
    }

    .chatbot-typing {
        padding: 0 20px 10px;
        display: flex;
        gap: 4px;
    }

    .chatbot-typing span {
        width: 6px;
        height: 6px;
        background: #ccc;
        border-radius: 50%;
        animation: typing 1s infinite ease-in-out;
    }

    .chatbot-typing span:nth-child(2) { animation-delay: 0.2s; }
    .chatbot-typing span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes typing {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    .chatbot-form {
        padding: 15px;
        border-top: 1px solid #eee;
        display: flex;
        gap: 10px;
    }

    .chatbot-form input {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 8px 15px;
        font-size: 13px;
        outline: none;
    }

    .chatbot-form button {
        background: #6f2dbd;
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* Markdown styling for bot messages */
    .message.bot p { margin-bottom: 8px; }
    .message.bot p:last-child { margin-bottom: 0; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('chatbot-wrapper');
        const toggle = document.getElementById('chatbot-toggle');
        const window = document.getElementById('chatbot-window');
        const close = document.getElementById('chatbot-close');
        const form = document.getElementById('chatbot-form');
        const input = document.getElementById('chatbot-input');
        const messages = document.getElementById('chatbot-messages');
        const typing = document.getElementById('chatbot-typing');
        const chatIcon = toggle.querySelector('.chat-icon');
        const closeIcon = toggle.querySelector('.close-icon');

        toggle.addEventListener('click', () => {
            const isVisible = window.style.display !== 'none';
            window.style.display = isVisible ? 'none' : 'flex';
            chatIcon.style.display = isVisible ? 'block' : 'none';
            closeIcon.style.display = isVisible ? 'none' : 'block';
            if (!isVisible) input.focus();
        });

        close.addEventListener('click', () => {
            window.style.display = 'none';
            chatIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;

            // Add user message
            appendMessage(message, 'user');
            input.value = '';

            // Show typing
            typing.style.display = 'flex';
            messages.scrollTop = messages.scrollHeight;

            try {
                const response = await fetch('{{ route("chatsupport.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                typing.style.display = 'none';

                if (data.success) {
                    appendMessage(data.message, 'bot');
                } else {
                    appendMessage('Sorry, something went wrong.', 'bot');
                }
            } catch (error) {
                typing.style.display = 'none';
                appendMessage('Error connecting to assistant.', 'bot');
            }
        });

        function appendMessage(text, type) {
            const div = document.createElement('div');
            div.className = `message ${type}`;
            div.innerHTML = text.replace(/\n/g, '<br>'); // Simple line break handling
            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
        }
    });
</script>
