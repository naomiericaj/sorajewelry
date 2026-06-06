<div id="sora-chatbot">
    <button id="sora-chat-toggle" class="sora-chat-toggle" aria-label="Open Sora Assistant">
        <span class="sora-chat-sparkle">✦</span>
        <span class="sora-chat-icon">AI</span>
    </button>

    <div id="sora-chat-panel">
        <div class="sora-chat-header">
            <div>
                <strong>Sora Assistant</strong>
                <span>Ask me about products, payment, or shipping</span>
            </div>

            <button id="sora-chat-close" type="button">×</button>
        </div>

        <div id="sora-chat-messages">
            <div class="sora-message bot">
                Hi! I’m Sora Assistant. How can I help you today?
            </div>
        </div>

        <form id="sora-chat-form">
            @csrf

            <input
                type="text"
                id="sora-chat-input"
                placeholder="Ask something..."
                autocomplete="off"
            >

            <button type="submit">
                Send
            </button>
        </form>
    </div>
</div>

<style>
    #sora-chatbot {
        position: fixed;
        right: 0;
        top: 0;
        height: 100vh;
        z-index: 99999;
        font-family: Arial, sans-serif;
    }

    .sora-chat-toggle {
        position: fixed;
        right: 28px;
        bottom: 28px;

        width: 68px;
        height: 68px;
        border-radius: 50%;

        border: none;
        background: linear-gradient(135deg, #111 0%, #3a3028 45%, #d7c3a3 100%);
        color: white;

        cursor: pointer;
        z-index: 100000;

        display: flex;
        align-items: center;
        justify-content: center;

        box-shadow: 0 16px 38px rgba(0, 0, 0, 0.24);
        transition: all 0.3s ease;
    }

    .sora-chat-toggle:hover {
        transform: translateY(-4px) scale(1.04);
        box-shadow: 0 20px 48px rgba(0, 0, 0, 0.3);
    }

    .sora-chat-toggle:active {
        transform: scale(0.96);
    }

    .sora-chat-toggle::before {
        content: "";
        position: absolute;
        inset: -6px;
        border-radius: 50%;
        border: 1px solid rgba(215, 195, 163, 0.7);
        animation: soraChatPulse 1.9s infinite;
    }

    .sora-chat-icon {
        font-family: Georgia, serif;
        font-size: 20px;
        letter-spacing: 1px;
        font-weight: 500;
    }

    .sora-chat-sparkle {
        position: absolute;
        top: 12px;
        right: 14px;
        font-size: 15px;
        color: #fff6df;
    }

    @keyframes soraChatPulse {
        0% {
            transform: scale(0.92);
            opacity: 0.8;
        }

        70% {
            transform: scale(1.2);
            opacity: 0;
        }

        100% {
            transform: scale(1.2);
            opacity: 0;
        }
    }

    #sora-chat-panel {
        position: fixed;
        right: -420px;
        top: 0;
        width: 400px;
        max-width: 92vw;
        height: 100vh;

        background: #f8f8f6;
        border-left: 1px solid #ddd;
        box-shadow: -12px 0 35px rgba(0, 0, 0, 0.18);

        display: grid;
        grid-template-rows: auto 1fr auto;

        transition: right 0.3s ease;
        z-index: 100001;
    }

    #sora-chat-panel.open {
        right: 0;
    }

    .sora-chat-header {
        background: linear-gradient(135deg, #111 0%, #4e443a 60%, #a7ad98 100%);
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .sora-chat-header strong {
        display: block;
        font-family: Georgia, serif;
        font-size: 19px;
        font-weight: 400;
        margin-bottom: 5px;
    }

    .sora-chat-header span {
        display: block;
        font-size: 12px;
        opacity: 0.9;
        line-height: 1.4;
    }

    #sora-chat-close {
        border: none;
        background: transparent;
        color: white;
        font-size: 30px;
        line-height: 1;
        cursor: pointer;
    }

    #sora-chat-messages {
        padding: 18px;
        overflow-y: auto;
    }

    .sora-message {
        max-width: 85%;
        padding: 12px 14px;
        margin-bottom: 12px;
        font-size: 14px;
        line-height: 1.5;
        white-space: pre-line;
        border-radius: 16px;
    }

    .sora-message.bot {
        background: white;
        color: #333;
        border: 1px solid #e4e4df;
        border-bottom-left-radius: 4px;
    }

    .sora-message.user {
        background: #111;
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 4px;
    }

    .sora-message.loading {
        color: #777;
        font-style: italic;
    }

    #sora-chat-form {
        height: 64px;
        display: grid;
        grid-template-columns: 1fr 78px;
        border-top: 1px solid #ddd;
        background: white;
    }

    #sora-chat-input {
        border: none;
        padding: 0 16px;
        outline: none;
        font-size: 14px;
        background: white;
    }

    #sora-chat-form button {
        border: none;
        background: #111;
        color: white;
        cursor: pointer;
        font-size: 14px;
        transition: 0.25s ease;
    }

    #sora-chat-form button:hover {
        background: #4e443a;
    }

    @media (max-width: 600px) {
        #sora-chat-panel {
            width: 100vw;
            max-width: 100vw;
            right: -100vw;
        }

        .sora-chat-toggle {
            right: 18px;
            bottom: 18px;
            width: 60px;
            height: 60px;
        }

        .sora-chat-icon {
            font-size: 18px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const panel = document.getElementById('sora-chat-panel');
        const toggle = document.getElementById('sora-chat-toggle');
        const closeBtn = document.getElementById('sora-chat-close');
        const form = document.getElementById('sora-chat-form');
        const input = document.getElementById('sora-chat-input');
        const messages = document.getElementById('sora-chat-messages');

        if (!panel || !toggle || !closeBtn || !form || !input || !messages) {
            return;
        }

        toggle.addEventListener('click', function () {
            panel.classList.add('open');
            toggle.style.display = 'none';
            input.focus();
        });

        closeBtn.addEventListener('click', function () {
            panel.classList.remove('open');
            toggle.style.display = 'flex';
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const userMessage = input.value.trim();

            if (!userMessage) {
                return;
            }

            addMessage(userMessage, 'user');
            input.value = '';

            const loadingMessage = addMessage('Typing...', 'bot loading');

            fetch("{{ route('ai.chatbot.message') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    message: userMessage
                })
            })
            .then(response => response.json())
            .then(data => {
                loadingMessage.remove();
                addMessage(data.reply ?? 'Sorry, I could not generate a reply.', 'bot');
            })
            .catch(error => {
                loadingMessage.remove();
                addMessage('Sorry, something went wrong. Please try again.', 'bot');
                console.error(error);
            });
        });

        function addMessage(text, type) {
            const div = document.createElement('div');
            div.className = 'sora-message ' + type;
            div.textContent = text;

            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;

            return div;
        }
    });
</script>