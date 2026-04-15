// Chatbot functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeChatbot();
});

function initializeChatbot() {
    const toggleBtn = document.getElementById('chatbot-toggle');
    const container = document.getElementById('chatbot-container');
    const closeBtn = document.getElementById('chatbot-close');
    const sendBtn = document.getElementById('chatbot-send');
    const input = document.getElementById('chatbot-input');
    
    // Toggle chatbot visibility
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            container.style.display = container.style.display === 'none' ? 'flex' : 'none';
            toggleBtn.classList.toggle('hidden');
            if (container.style.display === 'flex') {
                input.focus();
            }
        });
    }
    
    // Close button
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            container.style.display = 'none';
            if (toggleBtn) toggleBtn.classList.remove('hidden');
        });
    }
    
    // Send message
    if (sendBtn) {
        sendBtn.addEventListener('click', sendChatMessage);
    }
    
    // Enter key to send
    if (input) {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendChatMessage();
            }
        });
    }
    
    // Show welcome message
    showWelcomeMessage();
}

function showWelcomeMessage() {
    const messagesContainer = document.getElementById('chatbot-messages');
    if (messagesContainer && messagesContainer.children.length === 0) {
        const welcomeMsg = document.createElement('div');
        welcomeMsg.className = 'chatbot-message bot-message';
        welcomeMsg.innerHTML = `<div class="message-bubble">👋 Hi! I'm TechStore Assistant. How can I help you today?\n\nYou can ask about:\n• Products & pricing\n• Order tracking\n• Warranty & returns\n• Shipping info</div>`;
        messagesContainer.appendChild(welcomeMsg);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
}

function sendChatMessage() {
    const input = document.getElementById('chatbot-input');
    const message = input.value.trim();
    
    if (!message) return;
    
    // Display user message
    const messagesContainer = document.getElementById('chatbot-messages');
    
    const userMessageDiv = document.createElement('div');
    userMessageDiv.className = 'chatbot-message user-message';
    userMessageDiv.innerHTML = `<div class="message-bubble">${escapeHtml(message)}</div>`;
    messagesContainer.appendChild(userMessageDiv);
    
    // Clear input
    input.value = '';
    
    // Scroll to bottom
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    
    // Show loading indicator
    const loadingDiv = document.createElement('div');
    loadingDiv.className = 'chatbot-message bot-message';
    loadingDiv.innerHTML = `<div class="message-bubble">Thinking...</div>`;
    messagesContainer.appendChild(loadingDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    
    // Send to server
    fetch('ajax/chatbot.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'message=' + encodeURIComponent(message)
    })
    .then(response => response.json())
    .then(data => {
        // Remove loading indicator
        messagesContainer.removeChild(loadingDiv);
        
        if (data.success) {
            // Display bot response
            const botMessageDiv = document.createElement('div');
            botMessageDiv.className = 'chatbot-message bot-message';
            botMessageDiv.innerHTML = `<div class="message-bubble">${escapeHtml(data.message).replace(/\n/g, '<br>')}</div>`;
            messagesContainer.appendChild(botMessageDiv);
        } else {
            // Error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'chatbot-message bot-message';
            errorDiv.innerHTML = `<div class="message-bubble">Sorry, I had an issue processing that. Please try again.</div>`;
            messagesContainer.appendChild(errorDiv);
        }
        
        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    })
    .catch(error => {
        // Remove loading indicator
        if (messagesContainer.contains(loadingDiv)) {
            messagesContainer.removeChild(loadingDiv);
        }
        
        // Error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'chatbot-message bot-message';
        errorDiv.innerHTML = `<div class="message-bubble">Connection error. Please try again.</div>`;
        messagesContainer.appendChild(errorDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    });
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
