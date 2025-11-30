@extends('layouts.app')

@section('title', $settings->meta_title ?? 'Contact Us - TKDS Media')
@section('meta_description', $settings->meta_description ?? 'Get in touch with TKDS Media for professional broadcasting solutions. Contact our experts today.')

@section('content')

<section id="contact" class="py-20 bg-dark-light relative overflow-hidden mt-20">
    <!-- Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-primary/5 via-transparent to-secondary/5"></div>
        <div class="absolute top-20 right-20 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-20 w-80 h-80 bg-secondary/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center space-x-2 bg-primary/10 rounded-full px-6 py-2 mb-6">
                <i class="fas fa-envelope text-primary"></i>
                <span class="text-primary font-medium">{{ $settings->hero_badge_text ?? 'Contact Us' }}</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                {{ $settings->hero_title ?? "Let's Start Your Broadcasting Journey" }}
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                {{ $settings->hero_subtitle ?? 'Ready to transform your content strategy? Our experts are here to help you every step of the way' }}
            </p>
        </div>
        
        <!-- Contact Grid -->
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <!-- Contact Form -->
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="glass-effect rounded-2xl p-8">
                    <h3 class="text-2xl font-black text-white mb-6">{{ $settings->form_title ?? 'Send us a Message' }}</h3>
                    
                    <!-- Success Message -->
                    <div id="successMessage" class="hidden mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-lg">
                        <div class="flex items-center text-green-400">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span id="successText">Thank you for your message! We will get back to you soon.</span>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div id="errorMessage" class="hidden mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-lg">
                        <div class="flex items-center text-red-400">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span id="errorText">Please check your information and try again.</span>
                        </div>
                    </div>
                    
                    <form id="contactForm" class="space-y-6">
                        @csrf
                        
                        <!-- Name Fields -->
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-400 mb-2">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required
                                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                                <div class="error-message text-red-400 text-sm mt-1 hidden"></div>
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-400 mb-2">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required
                                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                                <div class="error-message text-red-400 text-sm mt-1 hidden"></div>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                            <div class="error-message text-red-400 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-400 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" 
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                            <div class="error-message text-red-400 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <!-- Service Interest -->
                        <div>
                            <label for="service" class="block text-sm font-medium text-gray-400 mb-2">Service Interest</label>
                            <select id="service" name="service" 
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                                <option value="">Select a service</option>
                                <option value="live-streaming">Live Streaming</option>
                                <option value="cloud-production">Cloud Production</option>
                                <option value="ott-platform">OTT Platform</option>
                                <option value="sports-broadcasting">Sports Broadcasting</option>
                                <option value="radio-streaming">Radio Streaming</option>
                                <option value="custom-solution">Custom Solution</option>
                            </select>
                            <div class="error-message text-red-400 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <!-- Budget -->
                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-400 mb-2">Monthly Budget</label>
                            <select id="budget" name="budget" 
                                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                                <option value="">Select your budget</option>
                                <option value="under-500">Under $500</option>
                                <option value="500-1000">$500 - $1,000</option>
                                <option value="1000-5000">$1,000 - $5,000</option>
                                <option value="5000-10000">$5,000 - $10,000</option>
                                <option value="over-10000">Over $10,000</option>
                            </select>
                            <div class="error-message text-red-400 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-400 mb-2">Message *</label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 resize-none"
                                      placeholder="Tell us about your project and requirements..."></textarea>
                            <div class="error-message text-red-400 text-sm mt-1 hidden"></div>
                        </div>
                        <x-recaptcha form="contact" />
                        <!-- Submit Button -->
                        <button type="submit" id="submitButton"
                                class="w-full px-6 py-4 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-primary/30 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <span class="flex items-center justify-center space-x-2">
                                <span id="buttonText">Send Message</span>
                                <i id="buttonIcon" class="fas fa-paper-plane"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="space-y-8">
                    
                    <!-- Contact Info -->
                    @if($settings->office_address || $settings->office_phone || $settings->office_email)
                    <div class="glass-effect rounded-2xl p-8">
                        <h3 class="text-2xl font-black text-white mb-6">Get In Touch</h3>
                        
                        <div class="space-y-4">
                            @if($settings->office_address)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                                <div>
                                    <p class="text-white font-medium">Office Address</p>
                                    <p class="text-gray-400 text-sm whitespace-pre-line">{{ $settings->office_address }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($settings->office_phone)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-phone text-primary mt-1"></i>
                                <div>
                                    <p class="text-white font-medium">Phone</p>
                                    <a href="tel:{{ $settings->office_phone }}" class="text-gray-400 text-sm hover:text-primary transition-colors duration-200">{{ $settings->office_phone }}</a>
                                </div>
                            </div>
                            @endif
                            
                            @if($settings->office_email)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-envelope text-primary mt-1"></i>
                                <div>
                                    <p class="text-white font-medium">Email</p>
                                    <a href="mailto:{{ $settings->office_email }}" class="text-gray-400 text-sm hover:text-primary transition-colors duration-200">{{ $settings->office_email }}</a>
                                </div>
                            </div>
                            @endif
                            
                            @if($settings->support_email && $settings->support_email != $settings->office_email)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-headset text-primary mt-1"></i>
                                <div>
                                    <p class="text-white font-medium">Support</p>
                                    <a href="mailto:{{ $settings->support_email }}" class="text-gray-400 text-sm hover:text-primary transition-colors duration-200">{{ $settings->support_email }}</a>
                                </div>
                            </div>
                            @endif
                            
                            @if($settings->sales_email && $settings->sales_email != $settings->office_email)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-handshake text-primary mt-1"></i>
                                <div>
                                    <p class="text-white font-medium">Sales</p>
                                    <a href="mailto:{{ $settings->sales_email }}" class="text-gray-400 text-sm hover:text-primary transition-colors duration-200">{{ $settings->sales_email }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Quick Actions -->
                    <div class="glass-effect rounded-2xl p-8">
                        <h3 class="text-2xl font-black text-white mb-6">Quick Actions</h3>
                        
                        <div class="space-y-4">
                            <a href="#packages" class="flex items-center justify-between p-4 glass-effect rounded-xl hover:bg-white/20 transition-all duration-300 group">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-rocket text-primary"></i>
                                    <span class="text-white font-medium">View Packages</span>
                                </div>
                                <i class="fas fa-arrow-right text-gray-400 group-hover:text-primary transition-colors duration-300"></i>
                            </a>
                            
                            <a href="#" class="flex items-center justify-between p-4 glass-effect rounded-xl hover:bg-white/20 transition-all duration-300 group">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-calendar text-secondary"></i>
                                    <span class="text-white font-medium">Schedule Demo</span>
                                </div>
                                <i class="fas fa-arrow-right text-gray-400 group-hover:text-secondary transition-colors duration-300"></i>
                            </a>
                            
                            <a href="#" class="flex items-center justify-between p-4 glass-effect rounded-xl hover:bg-white/20 transition-all duration-300 group">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-download text-primary"></i>
                                    <span class="text-white font-medium">Download Brochure</span>
                                </div>
                                <i class="fas fa-arrow-right text-gray-400 group-hover:text-primary transition-colors duration-300"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    @if(count($settings->getSocialLinks()) > 0)
                    <div class="glass-effect rounded-2xl p-8">
                        <h3 class="text-2xl font-black text-white mb-6">Follow Us</h3>
                        
                        <div class="flex space-x-4">
                            @foreach($settings->getSocialLinks() as $platform => $link)
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener"
                               class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center hover:scale-110 transition-transform duration-300"
                               title="{{ $link['name'] }}">
                                <i class="{{ $link['icon'] }} text-white"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Support Hours -->
                    <div class="glass-effect rounded-2xl p-8">
                        <h3 class="text-2xl font-black text-white mb-6">Support Hours</h3>
                        
                        <div class="space-y-3">
                            @if($settings->monday_friday_hours)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Monday - Friday</span>
                                <span class="text-white font-medium">{{ $settings->monday_friday_hours }}</span>
                            </div>
                            @endif
                            
                            @if($settings->saturday_hours)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Saturday</span>
                                <span class="text-white font-medium">{{ $settings->saturday_hours }}</span>
                            </div>
                            @endif
                            
                            @if($settings->sunday_hours)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Sunday</span>
                                <span class="text-white font-medium">{{ $settings->sunday_hours }}</span>
                            </div>
                            @endif
                            
                            @if($settings->emergency_support && $settings->emergency_text)
                            <div class="border-t border-white/20 pt-3 mt-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="text-green-400 font-medium">{{ $settings->emergency_text }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Google Maps Section -->
        @if($settings->google_maps_embed)
        <div class="mt-16" data-aos="fade-up">
            <div class="glass-effect rounded-2xl p-8">
                <h3 class="text-2xl font-black text-white mb-6 text-center">Find Us</h3>
                <div class="rounded-xl overflow-hidden">
                    {!! $settings->google_maps_embed !!}
                </div>
            </div>
        </div>
        @endif
        
        <!-- FAQ Section -->
        @if(isset($faqs) && $faqs->count() > 0)
        <div class="mt-16" data-aos="fade-up">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-black text-white mb-4">Frequently Asked Questions</h3>
                <p class="text-gray-400">Find answers to common questions about our services</p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-8">
                @foreach($faqs as $category => $categoryFaqs)
                <div class="glass-effect rounded-2xl p-8">
                    <h4 class="text-xl font-bold text-white mb-6 capitalize">{{ str_replace('_', ' ', $category) }}</h4>
                    <div class="space-y-4">
                        @foreach($categoryFaqs as $faq)
                        <div class="border-b border-white/10 pb-4 last:border-b-0 last:pb-0">
                            <h5 class="text-white font-medium mb-2">{{ $faq->question }}</h5>
                            <p class="text-gray-400 text-sm">{{ $faq->answer }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitButton = document.getElementById('submitButton');
    const buttonText = document.getElementById('buttonText');
    const buttonIcon = document.getElementById('buttonIcon');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    
    // Clear previous messages
    successMessage.classList.add('hidden');
    errorMessage.classList.add('hidden');
    
    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => {
        el.classList.add('hidden');
        el.parentElement.querySelector('input, select, textarea').classList.remove('border-red-500');
    });
    
    // Disable submit button
    submitButton.disabled = true;
    buttonText.textContent = 'Sending...';
    buttonIcon.className = 'fas fa-spinner fa-spin';
    
    // Collect form data
    const formData = new FormData(this);
    
    // Send request
    fetch('{{ route("contact.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            successMessage.classList.remove('hidden');
            document.getElementById('successText').textContent = data.message;
            
            // Reset form
            this.reset();
            
            // Scroll to success message
            successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            // Show validation errors
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const fieldElement = document.querySelector(`[name="${field}"]`);
                    if (fieldElement) {
                        const errorElement = fieldElement.parentElement.querySelector('.error-message');
                        errorElement.textContent = data.errors[field][0];
                        errorElement.classList.remove('hidden');
                        fieldElement.classList.add('border-red-500');
                    }
                });
            } else {
                // Show general error
                errorMessage.classList.remove('hidden');
                document.getElementById('errorText').textContent = data.message || 'Please check your information and try again.';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorMessage.classList.remove('hidden');
        document.getElementById('errorText').textContent = 'Something went wrong. Please try again later.';
    })
    .finally(() => {
        // Re-enable submit button
        submitButton.disabled = false;
        buttonText.textContent = 'Send Message';
        buttonIcon.className = 'fas fa-paper-plane';
    });
});

// Real-time validation
document.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('blur', function() {
        if (this.hasAttribute('required') && !this.value.trim()) {
            this.classList.add('border-red-500');
            const errorElement = this.parentElement.querySelector('.error-message');
            errorElement.textContent = 'This field is required.';
            errorElement.classList.remove('hidden');
        } else {
            this.classList.remove('border-red-500');
            this.parentElement.querySelector('.error-message').classList.add('hidden');
        }
    });
    
    field.addEventListener('input', function() {
        if (this.classList.contains('border-red-500') && this.value.trim()) {
            this.classList.remove('border-red-500');
            this.parentElement.querySelector('.error-message').classList.add('hidden');
        }
    });
});

// Email validation
document.getElementById('email').addEventListener('blur', function() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (this.value && !emailRegex.test(this.value)) {
        this.classList.add('border-red-500');
        const errorElement = this.parentElement.querySelector('.error-message');
        errorElement.textContent = 'Please enter a valid email address.';
        errorElement.classList.remove('hidden');
    }
});
</script>
@endpush