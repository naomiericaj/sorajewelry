<div id="sora-chatbot">
    <button id="sora-chat-toggle" type="button">
        AI Chat
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

    #sora-chat-toggle {
        position: fixed;
        right: 24px;
        bottom: 24px;
        width: 82px;
        height: 52px;
        border: none;
        background: #111;
        color: white;
        cursor: pointer;
        font-size: 14px;
        box-shadow: 0 8px 24px rgba(0,0,0,.22);
        z-index: 100000;
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
        box-shadow: -12px 0 35px rgba(0,0,0,.18);
        display: grid;
        grid-template-rows: auto 1fr auto;
        transition: right .3s ease;
    }

    #sora-chat-panel.open {
        right: 0;
    }

    .sora-chat-header {
        background: #a7ad98;
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .sora-chat-header strong {
        display: block;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .sora-chat-header span {
        display: block;
        font-size: 12px;
        opacity: .9;
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
    }

    .sora-message.bot {
        background: white;
        color: #333;
        border: 1px solid #e4e4df;
    }

    .sora-message.user {
        background: #111;
        color: white;
        margin-left: auto;
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
    }

    @media (max-width: 600px) {
        #sora-chat-panel {
            width: 100vw;
            right: -100vw;
        }

        #sora-chat-toggle {
            right: 18px;
            bottom: 18px;
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

        toggle.addEventListener('click', function () {
            panel.classList.add('open');
            toggle.style.display = 'none';
            input.focus();
        });

        closeBtn.addEventListener('click', function () {
            panel.classList.remove('open');
            toggle.style.display = 'block';
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