@php
    $footerSettings = \App\Models\FooterSetting::getSettings();
@endphp

@if($footerSettings->isActive())
<footer class="bg-dark relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-30"></div>

    <!-- Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-primary/5 via-transparent to-secondary/5"></div>
        <div class="absolute top-10 right-10 w-64 h-64 bg-primary/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-secondary/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-accent/3 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>
    
    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8 relative z-10">
        
<!-- Newsletter Section -->
        @if($footerSettings->newsletter_enabled)
        <div class="bg-gradient-to-br from-primary/10 to-secondary/10 backdrop-blur-xl rounded-2xl p-8 mb-16 border border-primary/20 hover:border-primary/30 transition-all duration-500" data-aos="fade-up">
            <div class="flex flex-col lg:flex-row items-center space-y-6 lg:space-y-0 lg:space-x-8">
                <!-- Left Side - Icon & Text -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-white text-lg"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white">
                            {{ $footerSettings->newsletter_title }}
                        </h3>
                    </div>
                    <p class="text-gray-300 text-base leading-relaxed max-w-lg">
                        {{ $footerSettings->newsletter_subtitle }}
                    </p>
                </div>
                
                <!-- Right Side - Form -->
                <div class="flex-1 w-full max-w-md">
                    <div class="space-y-4">
                        <div class="relative">
                            <input type="email" 
                                   id="newsletter-email"
                                   placeholder="{{ $footerSettings->newsletter_placeholder }}" 
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                        </div>
                        <button id="newsletter-subscribe"
                                class="w-full px-4 py-3 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-primary/30">
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ $footerSettings->newsletter_button_text }}
                        </button>
                    </div>
                    
                    @if($footerSettings->newsletter_privacy_text)
                    <p class="text-xs text-gray-500 mt-3 text-center">
                        {{ $footerSettings->newsletter_privacy_text }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif
        
        <!-- Footer Links Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-12 mb-16">
            <!-- Company Info -->
            <div class="lg:col-span-2">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-14 h-14  rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-black text-xl">
                            <img src="{{ asset('images/TKDSFAV.png') }}" alt="TKDS Media" class="w-10 h-10 object-contain">
                        </span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white">
                            <span class="text-gradient bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">{{ $footerSettings->company_name }}</span>
                        </h3>
                        <p class="text-sm text-gray-400 -mt-1">{{ $footerSettings->company_tagline }}</p>
                    </div>
                </div>
                <p class="text-gray-400 mb-6 text-base leading-relaxed">
                    {{ $footerSettings->company_description }}
                </p>
                
                <!-- Social Media -->
                @if($footerSettings->show_social_media && count($footerSettings->getSocialLinks()) > 0)
                <div class="space-y-3">
                    <h4 class="text-white font-bold">Follow Us</h4>
                    <div class="flex space-x-3">
                        @foreach($footerSettings->getSocialLinks() as $platform => $social)
                            <a href="{{ $social['url'] }}" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="group relative w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-primary/20 transition-all duration-300 transform hover:scale-110 hover:-translate-y-1">
                                <i class="{{ $social['icon'] }} text-gray-400 group-hover:text-white transition-colors duration-300"></i>
                                <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-dark-light text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                    {{ $social['name'] }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Services -->
            @if($footerSettings->show_services_section)
            <div>
                <h4 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-cogs text-primary mr-3"></i>
                    Services
                </h4>
                <ul class="space-y-3">
                    @php
                        $footerServices = \App\Models\Service::active()->ordered()->limit(8)->get();
                    @endphp
                    
                    @forelse($footerServices as $service)
                        <li>
                            <a href="{{ $service->getUrl() }}" class="group text-gray-400 hover:text-primary transition-all duration-300 flex items-center text-sm">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                                <span>{{ $service->title }}</span>
                            </a>
                        </li>
                    @empty
                        {{-- Fallback static services if no services in database --}}
                        @php
                            $staticServices = [
                                ['Live Streaming', route('services')],
                                ['OTT Platform', route('services')],
                                ['Cloud Servers', route('services')],
                                ['Sports Broadcasting', route('services')],
                                ['Radio & Podcast', route('services')],
                                ['Graphic Design', route('services')],
                                ['All Services', route('services')]
                            ];
                        @endphp
                        
                        @foreach($staticServices as $service)
                            <li>
                                <a href="{{ $service[1] }}" class="group text-gray-400 hover:text-primary transition-all duration-300 flex items-center text-sm">
                                    <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                                    <span>{{ $service[0] }}</span>
                                </a>
                            </li>
                        @endforeach
                    @endforelse
                </ul>
            </div>
            @endif
            
            <!-- Company -->
            @if($footerSettings->show_company_section)
            <div>
                <h4 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-building text-secondary mr-3"></i>
                    Company
                </h4>
                <ul class="space-y-3">
                    @php
                        $companyLinks = [
                            ['About Us', 'about'],
                            ['Pricing', 'pricing'],
                            ['Blog', 'blog.index'],
                            ['Contact', 'contact']
                        ];
                    @endphp
                    
                    @foreach($companyLinks as $link)
                        <li>
                            <a href="{{ route($link[1]) }}" class="group text-gray-400 hover:text-secondary transition-all duration-300 flex items-center text-sm">
                                <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                                <span>{{ $link[0] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <!-- Legal & Support -->
            @if($footerSettings->show_legal_section)
            <div>
                <h4 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-shield-alt text-accent mr-3"></i>
                    Legal & Support
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('contact') }}" class="group text-gray-400 hover:text-accent transition-all duration-300 flex items-center text-sm">
                            <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span>24/7 Support</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('privacy-policy') }}" class="group text-gray-400 hover:text-primary transition-all duration-300 flex items-center text-sm">
                            <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span>Privacy Policy</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms-conditions') }}" class="group text-gray-400 hover:text-primary transition-all duration-300 flex items-center text-sm">
                            <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span>Terms & Conditions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cookie-policy') }}" class="group text-gray-400 hover:text-primary transition-all duration-300 flex items-center text-sm">
                            <i class="fas fa-chevron-right text-xs mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span>Cookie Policy</span>
                        </a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
        
        <!-- Contact Info Bar -->
        <div class="glass-effect rounded-2xl p-6 mb-8 border border-white/10 hover:border-primary/20 transition-all duration-500" data-aos="fade-up">
            <div class="grid md:grid-cols-3 gap-6 text-center md:text-left">
                <div class="group flex items-center justify-center md:justify-start space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fas fa-envelope text-white"></i>
                    </div>
                    <div>
                        <div class="text-white font-bold">Email</div>
                        <a href="mailto:{{ $footerSettings->contact_email }}" class="text-gray-400 text-sm hover:text-primary transition-colors duration-300">{{ $footerSettings->contact_email }}</a>
                    </div>
                </div>
                
                <div class="group flex items-center justify-center md:justify-start space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-secondary to-accent rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fas fa-phone text-white"></i>
                    </div>
                    <div>
                        <div class="text-white font-bold">Phone</div>
                        <a href="tel:{{ str_replace([' ', '(', ')', '-'], '', $footerSettings->contact_phone) }}" class="text-gray-400 text-sm hover:text-secondary transition-colors duration-300">{{ $footerSettings->contact_phone }}</a>
                    </div>
                </div>
                
                <div class="group flex items-center justify-center md:justify-start space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-accent to-primary rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <div>
                        <div class="text-white font-bold">Support</div>
                        <div class="text-gray-400 text-sm">{{ $footerSettings->support_hours }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-white/20 pt-6">
            <div class="flex flex-col lg:flex-row items-center justify-between space-y-4 lg:space-y-0">
                <!-- Copyright -->
                <div class="text-center lg:text-left">
                    <div class="text-gray-400 text-sm mb-1">
                        &copy; {{ date('Y') }} {{ $footerSettings->copyright_text }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $footerSettings->footer_subtitle }}
                    </div>
                </div>
                
                <!-- Trust Badges -->
                @if($footerSettings->show_trust_badges)
                <div class="flex items-center space-x-4">
                    <div class="group flex items-center space-x-2 text-gray-400 hover:text-green-400 transition-colors duration-300">
                        <i class="fas fa-shield-alt group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="text-xs font-medium">{{ $footerSettings->ssl_secured_text }}</span>
                    </div>
                    <div class="group flex items-center space-x-2 text-gray-400 hover:text-blue-400 transition-colors duration-300">
                        <i class="fas fa-award group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="text-xs font-medium">{{ $footerSettings->iso_certified_text }}</span>
                    </div>
                    <div class="group flex items-center space-x-2 text-gray-400 hover:text-purple-400 transition-colors duration-300">
                        <i class="fas fa-globe group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="text-xs font-medium">{{ $footerSettings->global_cdn_text }}</span>
                    </div>
                </div>
                @endif
                
                <!-- Back to Top -->
                <button onclick="scrollToTop()" class="group flex items-center space-x-2 px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-gray-400 hover:text-primary hover:bg-primary/10 hover:border-primary/30 transition-all duration-300 backdrop-blur-sm">
                    <span class="text-sm font-medium">{{ $footerSettings->back_to_top_text }}</span>
                    <i class="fas fa-rocket group-hover:transform group-hover:-translate-y-1 group-hover:rotate-12 transition-all duration-300"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Animated Decorative Border -->
    <div class="relative h-2 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary via-secondary to-accent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-accent via-primary to-secondary opacity-0 hover:opacity-100 transition-opacity duration-1000"></div>
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute w-20 h-full bg-white/20 blur-sm -skew-x-12 animate-pulse" style="animation: shimmer 3s ease-in-out infinite;"></div>
        </div>
    </div>
</footer>

<style>
@keyframes shimmer {
    0% { transform: translateX(-100%) skewX(-12deg); }
    50% { transform: translateX(100vw) skewX(-12deg); }
    100% { transform: translateX(100vw) skewX(-12deg); }
}

.glass-effect:hover {
    background: rgba(255, 255, 255, 0.15);
}

.text-gradient {
    background: linear-gradient(135deg, #C53030, #E53E3E, #FC8181);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>

<script>
// Back to Top Function with smooth animation
function scrollToTop() {
    const scrollStep = -window.scrollY / (500 / 15);
    const scrollInterval = setInterval(() => {
        if (window.scrollY !== 0) {
            window.scrollBy(0, scrollStep);
        } else {
            clearInterval(scrollInterval);
        }
    }, 15);
}

// Newsletter subscription - COMPLETELY UPDATED
document.addEventListener('DOMContentLoaded', function() {
    const newsletterEmail = document.getElementById('newsletter-email');
    const subscribeBtn = document.getElementById('newsletter-subscribe');
    
    if (subscribeBtn && newsletterEmail) {
        subscribeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const email = newsletterEmail.value.trim();
            
            if (!email) {
                showNewsletterMessage('Please enter your email address', 'error');
                return;
            }
            
            if (!isValidEmail(email)) {
                showNewsletterMessage('Please enter a valid email address', 'error');
                return;
            }

            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Subscribing...';
            this.disabled = true;

            // Send subscription request
            fetch('/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    email: email,
                    name: null // Can be extended later
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNewsletterMessage(data.message, 'success');
                    newsletterEmail.value = '';
                    
                    // Show success state
                    this.innerHTML = '<i class="fas fa-check mr-2"></i>Subscribed!';
                    this.classList.remove('from-primary', 'to-secondary');
                    this.classList.add('bg-green-500');
                    
                    // Track successful subscription
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'newsletter_subscribe', {
                            event_category: 'Newsletter',
                            event_label: 'Footer Subscription'
                        });
                    }
                    
                } else {
                    showNewsletterMessage(data.message || 'Subscription failed. Please try again.', 'error');
                    
                    // Show error state
                    this.innerHTML = '<i class="fas fa-exclamation mr-2"></i>Try Again';
                    this.classList.remove('from-primary', 'to-secondary');
                    this.classList.add('bg-red-500');
                }
            })
            .catch(error => {
                console.error('Newsletter subscription error:', error);
                showNewsletterMessage('Something went wrong. Please try again later.', 'error');
                
                // Show error state
                this.innerHTML = '<i class="fas fa-exclamation mr-2"></i>Error';
                this.classList.remove('from-primary', 'to-secondary');
                this.classList.add('bg-red-500');
            })
            .finally(() => {
                // Reset button state after 3 seconds
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    this.classList.remove('bg-green-500', 'bg-red-500');
                    this.classList.add('from-primary', 'to-secondary');
                }, 3000);
            });
        });

        // Enter key support
        newsletterEmail.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                subscribeBtn.click();
            }
        });

        // Real-time email validation
        newsletterEmail.addEventListener('input', function() {
            const email = this.value.trim();
            if (email && !isValidEmail(email)) {
                this.classList.add('border-red-300');
                this.classList.remove('border-white/20');
            } else {
                this.classList.remove('border-red-300');
                this.classList.add('border-white/20');
            }
        });
    }
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showNewsletterMessage(message, type) {
    // Remove existing notification
    const existingNotification = document.querySelector('.newsletter-notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    // Create notification
    const notification = document.createElement('div');
    notification.className = `newsletter-notification fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;
    
    if (type === 'success') {
        notification.classList.add('bg-green-500', 'text-white');
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-check text-white"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white hover:text-green-200 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    } else {
        notification.classList.add('bg-red-500', 'text-white');
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div class="flex-1">
                    <p class="font-medium">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white hover:text-red-200 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    }

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto-hide after 6 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 6000);
}
</script>
@endif