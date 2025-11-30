@props(['type' => 'service', 'item' => null, 'title' => 'Get In Touch'])

@php
    $itemId = $item ? $item->id : null;
    // Handle both services and products - use title for both
    $itemName = $item ? ($item->title ?? $item->name ?? 'Unknown Item') : 'Unknown Item';
    $formId = $type . '-contact-form-' . $itemId;
@endphp

<section class="py-20 bg-gradient-to-b from-dark-light to-dark">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-white/5 to-white/10 backdrop-blur-xl rounded-3xl border border-white/10 overflow-hidden">
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-primary/10 to-secondary/10 p-8 text-center border-b border-white/10">
                <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/20 to-secondary/20 backdrop-blur-lg rounded-full px-6 py-3 border border-primary/30 mb-6">
                    <i class="fas fa-headset text-primary"></i>
                    <span class="text-sm font-semibold text-primary uppercase tracking-wider">Contact Us</span>
                </div>
                
                <h3 class="text-3xl md:text-4xl font-black text-white mb-4">{{ $title }}</h3>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                    Interested in <span class="font-semibold text-primary">{{ $itemName }}</span>? 
                    Let's discuss your requirements and find the perfect solution for your needs.
                </p>
            </div>

            <!-- Form Section -->
            <div class="p-8 md:p-12">
                <!-- Success Message -->
                <div id="successMessage-{{ $formId }}" class="hidden mb-8 p-6 bg-gradient-to-r from-green-500/20 to-green-600/20 border border-green-500/30 rounded-2xl backdrop-blur-sm">
                    <div class="flex items-center text-green-100">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-check text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Message Sent Successfully!</h4>
                            <span id="successText-{{ $formId }}">Thank you for your interest! We will get back to you soon.</span>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div id="errorMessage-{{ $formId }}" class="hidden mb-8 p-6 bg-gradient-to-r from-red-500/20 to-red-600/20 border border-red-500/30 rounded-2xl backdrop-blur-sm">
                    <div class="flex items-center text-red-100">
                        <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Something went wrong</h4>
                            <span id="errorText-{{ $formId }}">Please check your information and try again.</span>
                        </div>
                    </div>
                </div>

                <form id="{{ $formId }}" class="space-y-8">
                    @csrf
                    <input type="hidden" name="item_type" value="{{ $type }}">
                    <input type="hidden" name="item_id" value="{{ $itemId }}">
                    <input type="hidden" name="item_name" value="{{ $itemName }}">

                    <!-- Name Fields -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="group">
                            <label for="firstName-{{ $formId }}" class="block text-sm font-semibold text-gray-300 mb-3">
                                <i class="fas fa-user mr-2 text-primary"></i>First Name *
                            </label>
                            <input type="text" 
                                   id="firstName-{{ $formId }}" 
                                   name="firstName" 
                                   required
                                   minlength="2"
                                   class="w-full px-6 py-4 bg-white/5 border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 backdrop-blur-sm hover:border-primary/50"
                                   placeholder="Enter your first name">
                            <div class="error-message text-red-400 text-sm mt-2 hidden flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span></span>
                            </div>
                        </div>
                        
                        <div class="group">
                            <label for="lastName-{{ $formId }}" class="block text-sm font-semibold text-gray-300 mb-3">
                                <i class="fas fa-user mr-2 text-primary"></i>Last Name *
                            </label>
                            <input type="text" 
                                   id="lastName-{{ $formId }}" 
                                   name="lastName" 
                                   required
                                   minlength="2"
                                   class="w-full px-6 py-4 bg-white/5 border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 backdrop-blur-sm hover:border-primary/50"
                                   placeholder="Enter your last name">
                            <div class="error-message text-red-400 text-sm mt-2 hidden flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <label for="email-{{ $formId }}" class="block text-sm font-semibold text-gray-300 mb-3">
                            <i class="fas fa-envelope mr-2 text-primary"></i>Email Address *
                        </label>
                        <input type="email" 
                               id="email-{{ $formId }}" 
                               name="email" 
                               required
                               class="w-full px-6 py-4 bg-white/5 border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 backdrop-blur-sm hover:border-primary/50"
                               placeholder="your.email@example.com">
                        <div class="error-message text-red-400 text-sm mt-2 hidden flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span></span>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="group">
                        <label for="phone-{{ $formId }}" class="block text-sm font-semibold text-gray-300 mb-3">
                            <i class="fas fa-phone mr-2 text-primary"></i>Phone Number
                        </label>
                        <input type="tel" 
                               id="phone-{{ $formId }}" 
                               name="phone" 
                               class="w-full px-6 py-4 bg-white/5 border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 backdrop-blur-sm hover:border-primary/50"
                               placeholder="+1 (555) 123-4567">
                        <div class="error-message text-red-400 text-sm mt-2 hidden flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span></span>
                        </div>
                    </div>

                    <!-- Pay Now Checkbox -->
                    <div class="flex items-start space-x-4 p-6 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-2xl border border-primary/20">
                        <input type="checkbox" 
                               id="payNow-{{ $formId }}" 
                               name="payNow" 
                               value="1"
                               class="w-5 h-5 text-primary bg-white/10 border-primary/30 rounded focus:ring-primary focus:ring-2 mt-1">
                        <div>
                            <label for="payNow-{{ $formId }}" class="text-white font-semibold cursor-pointer flex items-center">
                                <i class="fas fa-bolt text-yellow-400 mr-2"></i>
                                I'm ready to pay now
                            </label>
                            <p class="text-gray-400 text-sm mt-1">Check this for priority support and faster response time</p>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="group">
                        <label for="message-{{ $formId }}" class="block text-sm font-semibold text-gray-300 mb-3">
                            <i class="fas fa-comment-dots mr-2 text-primary"></i>Message *
                        </label>
                        <textarea id="message-{{ $formId }}" 
                                  name="message" 
                                  rows="6" 
                                  required
                                  minlength="10"
                                  maxlength="2000"
                                  class="w-full px-6 py-4 bg-white/5 border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 resize-none backdrop-blur-sm hover:border-primary/50"
                                  placeholder="Tell us about your specific requirements, questions, or how we can help you..."></textarea>
                        <div class="flex justify-between items-center mt-2">
                            <div class="error-message text-red-400 text-sm hidden flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span></span>
                            </div>
                            <div class="text-gray-400 text-xs">
                                <span id="charCount-{{ $formId }}">0</span>/2000 characters
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="submitButton-{{ $formId }}"
                            class="group w-full px-8 py-6 bg-gradient-to-r from-primary to-secondary text-white font-bold text-lg rounded-2xl hover:from-secondary hover:to-primary transition-all duration-500 transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-primary/30 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none active:scale-[0.98] relative overflow-hidden">
                        
                        <!-- Button background animation -->
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        
                        <span class="flex items-center justify-center space-x-3 relative z-10">
                            <span id="buttonText-{{ $formId }}">Send Inquiry</span>
                            <i id="buttonIcon-{{ $formId }}" class="fas fa-paper-plane text-xl transform group-hover:translate-x-1 transition-transform duration-300"></i>
                        </span>
                    </button>
                    
                    <!-- Privacy Notice -->
                    <div class="text-center">
                        <p class="text-gray-400 text-sm">
                            <i class="fas fa-shield-alt text-green-400 mr-2"></i>
                            Your information is secure and will only be used to contact you about this inquiry.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('{{ $formId }}');
    const formId = '{{ $formId }}';
    const submitButton = document.getElementById('submitButton-' + formId);
    const buttonText = document.getElementById('buttonText-' + formId);
    const buttonIcon = document.getElementById('buttonIcon-' + formId);
    const successMessage = document.getElementById('successMessage-' + formId);
    const errorMessage = document.getElementById('errorMessage-' + formId);
    const messageTextarea = document.getElementById('message-' + formId);
    const charCount = document.getElementById('charCount-' + formId);

    // Character counter
    messageTextarea.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = length;
        
        if (length > 2000) {
            charCount.classList.add('text-red-400');
            charCount.classList.remove('text-gray-400');
        } else {
            charCount.classList.remove('text-red-400');
            charCount.classList.add('text-gray-400');
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous messages
        successMessage.classList.add('hidden');
        errorMessage.classList.add('hidden');
        
        // Clear previous error messages
        form.querySelectorAll('.error-message').forEach(el => {
            el.classList.add('hidden');
            const input = el.closest('.group').querySelector('input, textarea');
            input.classList.remove('border-red-500');
            input.classList.add('border-white/20');
        });
        
        // Show loading state
        submitButton.disabled = true;
        buttonText.textContent = 'Sending...';
        buttonIcon.className = 'fas fa-spinner fa-spin text-xl';
        
        // Collect form data
        const formData = new FormData(form);
        
        // Send request
        fetch('{{ route("service.contact.send") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                successMessage.classList.remove('hidden');
                document.querySelector('#successText-' + formId).textContent = data.message;
                
                // Reset form
                form.reset();
                charCount.textContent = '0';
                
                // Scroll to success message
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Track success event
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'form_submit', {
                        event_category: 'Contact Form',
                        event_label: '{{ $itemName }}',
                        item_type: '{{ $type }}',
                        priority: data.priority || 'normal'
                    });
                }
            } else {
                // Show validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const fieldElement = form.querySelector(`[name="${field}"]`);
                        if (fieldElement) {
                            const errorElement = fieldElement.closest('.group').querySelector('.error-message span');
                            const errorContainer = fieldElement.closest('.group').querySelector('.error-message');
                            
                            errorElement.textContent = data.errors[field][0];
                            errorContainer.classList.remove('hidden');
                            fieldElement.classList.add('border-red-500');
                            fieldElement.classList.remove('border-white/20');
                        }
                    });
                    
                    // Focus on first error field
                    const firstErrorField = form.querySelector('.border-red-500');
                    if (firstErrorField) {
                        firstErrorField.focus();
                    }
                } else {
                    // Show general error
                    errorMessage.classList.remove('hidden');
                    document.querySelector('#errorText-' + formId).textContent = data.message || 'Please check your information and try again.';
                    errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        })
        .catch(error => {
            console.error('Form submission error:', error);
            errorMessage.classList.remove('hidden');
            document.querySelector('#errorText-' + formId).textContent = 'Something went wrong. Please try again later.';
            errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        })
        .finally(() => {
            // Reset submit button
            submitButton.disabled = false;
            buttonText.textContent = 'Send Inquiry';
            buttonIcon.className = 'fas fa-paper-plane text-xl transform group-hover:translate-x-1 transition-transform duration-300';
        });
    });

    // Real-time validation
    form.querySelectorAll('input, textarea').forEach(field => {
        field.addEventListener('blur', function() {
            const errorContainer = this.closest('.group').querySelector('.error-message');
            const errorSpan = errorContainer.querySelector('span');
            
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('border-red-500');
                this.classList.remove('border-white/20');
                errorSpan.textContent = 'This field is required.';
                errorContainer.classList.remove('hidden');
            } else if (this.type === 'email' && this.value && !isValidEmail(this.value)) {
                this.classList.add('border-red-500');
                this.classList.remove('border-white/20');
                errorSpan.textContent = 'Please enter a valid email address.';
                errorContainer.classList.remove('hidden');
            } else if (this.hasAttribute('minlength') && this.value.length < parseInt(this.getAttribute('minlength'))) {
                this.classList.add('border-red-500');
                this.classList.remove('border-white/20');
                errorSpan.textContent = `Minimum ${this.getAttribute('minlength')} characters required.`;
                errorContainer.classList.remove('hidden');
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-white/20');
                errorContainer.classList.add('hidden');
            }
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('border-red-500') && this.value.trim()) {
                const errorContainer = this.closest('.group').querySelector('.error-message');
                this.classList.remove('border-red-500');
                this.classList.add('border-white/20');
                errorContainer.classList.add('hidden');
            }
        });
    });

    // Email validation helper
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
</script>