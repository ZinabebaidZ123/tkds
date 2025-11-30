@extends('layouts.app')

@section('title', 'Talk with TKDS AI')
@section('meta_description', 'Chat with our AI assistant to get instant help with services, products, and pricing.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-red-900 to-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-8" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-red-600 to-red-700 rounded-full mb-4">
                <i class="fas fa-robot text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-3">
                Talk with TKDS AI
            </h1>
            <p class="text-gray-300 text-lg">
                Get instant help with our services, products, and pricing
            </p>
        </div>

        <!-- Chat Container -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden" data-aos="fade-up">

            <!-- Chat Messages Area -->
            <div id="chat-messages" class="h-96 md:h-[500px] overflow-y-auto p-6 space-y-4 bg-gradient-to-br from-gray-50 to-white">
                <!-- Welcome Message -->
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-r from-red-600 to-red-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-robot text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gradient-to-r from-red-50 to-red-50 rounded-2xl rounded-tl-none px-4 py-3 max-w-md border border-red-200">
                            <p class="text-sm font-medium text-red-900 mb-1">TKDS AI</p>
                            <p class="text-gray-800">
                                Hello! I'm TKDS AI, your virtual assistant. How can I help you today?
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form (Hidden by default) -->
            <div id="contact-form-container" class="hidden p-6 bg-red-50 border-t border-red-200">
                <div class="max-w-2xl mx-auto">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-envelope mr-2 text-red-600"></i>
                        We'd love to help! Please provide your contact information
                    </h3>
                    <form id="ai-contact-form" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                <input type="text" name="name" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="email" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                            <input type="tel" name="phone" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Additional Message (Optional)</label>
                            <textarea name="message" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
                        </div>
                        <input type="hidden" name="question" id="original-question">
                        <div class="flex space-x-3">
                            <button type="submit"
                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Submit
                            </button>
                            <button type="button" onclick="hideContactForm()"
                                    class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition-all duration-300">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form id="chat-form" class="flex items-center space-x-3">
                    <input type="text" id="user-message"
                           placeholder="Type your message here..."
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           required>
                    <button type="submit" id="send-button"
                            class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 flex items-center space-x-2">
                        <i class="fas fa-paper-plane"></i>
                        <span class="hidden sm:inline">Send</span>
                    </button>
                </form>
                <div id="loading-indicator" class="hidden mt-3 text-center">
                    <div class="inline-flex items-center space-x-2 text-red-600">
                        <i class="fas fa-circle-notch fa-spin"></i>
                        <span class="text-sm">TKDS AI is thinking...</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Tips Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4" data-aos="fade-up" data-aos-delay="200">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-4 border border-white/20">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-lightbulb text-yellow-400 text-xl mt-1"></i>
                    <div>
                        <h3 class="text-white font-semibold mb-1">Ask about Services</h3>
                        <p class="text-gray-300 text-sm">Get information about our broadcasting solutions and services</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-4 border border-white/20">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-shopping-cart text-green-400 text-xl mt-1"></i>
                    <div>
                        <h3 class="text-white font-semibold mb-1">Browse Products</h3>
                        <p class="text-gray-300 text-sm">Discover our range of products and pricing options</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-4 border border-white/20">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-headset text-blue-400 text-xl mt-1"></i>
                    <div>
                        <h3 class="text-white font-semibold mb-1">Get Support</h3>
                        <p class="text-gray-300 text-sm">Need help? Our AI can connect you with our support team</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Generate unique conversation ID
const conversationId = 'conv_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
const chatMessages = document.getElementById('chat-messages');
const chatForm = document.getElementById('chat-form');
const userMessageInput = document.getElementById('user-message');
const sendButton = document.getElementById('send-button');
const loadingIndicator = document.getElementById('loading-indicator');
const contactFormContainer = document.getElementById('contact-form-container');
const contactForm = document.getElementById('ai-contact-form');

// Scroll to bottom of chat
function scrollToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Add user message to chat
function addUserMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex items-start space-x-3 justify-end';
    messageDiv.innerHTML = `
        <div class="flex-1 flex justify-end">
            <div class="bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl rounded-tr-none px-4 py-3 max-w-md">
                <p>${escapeHtml(message)}</p>
            </div>
        </div>
        <div class="flex-shrink-0">
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-gray-600 text-sm"></i>
            </div>
        </div>
    `;
    chatMessages.appendChild(messageDiv);
    scrollToBottom();
}

// Add AI message to chat
function addAiMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex items-start space-x-3';

    // Convert markdown-style bold **text** to HTML
    const formattedMessage = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

    messageDiv.innerHTML = `
        <div class="flex-shrink-0">
            <div class="w-10 h-10 bg-gradient-to-r from-red-600 to-red-700 rounded-full flex items-center justify-center">
                <i class="fas fa-robot text-white text-sm"></i>
            </div>
        </div>
        <div class="flex-1">
            <div class="bg-gradient-to-r from-red-50 to-red-50 rounded-2xl rounded-tl-none px-4 py-3 max-w-md border border-red-200">
                <p class="text-sm font-medium text-red-900 mb-1">TKDS AI</p>
                <p class="text-gray-800">${formattedMessage}</p>
            </div>
        </div>
    `;
    chatMessages.appendChild(messageDiv);
    scrollToBottom();
}

// Show contact form
function showContactForm() {
    contactFormContainer.classList.remove('hidden');
    document.getElementById('original-question').value = userMessageInput.value;
    scrollToBottom();
}

// Hide contact form
function hideContactForm() {
    contactFormContainer.classList.add('hidden');
}

// Escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Handle chat form submission
chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const message = userMessageInput.value.trim();
    if (!message) return;

    // Add user message to chat
    addUserMessage(message);

    // Clear input
    userMessageInput.value = '';

    // Show loading
    sendButton.disabled = true;
    loadingIndicator.classList.remove('hidden');

    try {
        // Send message to AI
        const response = await fetch('/ai/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                message: message,
                conversation_id: conversationId
            })
        });

        const data = await response.json();

        if (data.success) {
            // Add AI response to chat
            addAiMessage(data.message);

            // Show contact form if AI suggests it
            if (data.ask_for_contact) {
                showContactForm();
            }
        } else {
            addAiMessage('Sorry, I encountered an error. Please try again or contact our support team.');
        }
    } catch (error) {
        console.error('Error:', error);
        addAiMessage('Sorry, something went wrong. Please try again later.');
    } finally {
        // Hide loading
        sendButton.disabled = false;
        loadingIndicator.classList.add('hidden');
    }
});

// Handle contact form submission
contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(contactForm);
    const data = Object.fromEntries(formData);

    try {
        const response = await fetch('/ai/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            addAiMessage(result.message);
            contactForm.reset();
            hideContactForm();
        } else {
            alert('There was an error submitting your information. Please try again.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('There was an error submitting your information. Please try again.');
    }
});
</script>

@endsection
