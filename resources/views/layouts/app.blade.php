<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @php
        $seoSettings = \App\Models\SeoSetting::getSettings();
        $currentRoute = Route::currentRouteName();
        $pageRoute = match($currentRoute) {
            'home' => 'home',
            'about' => 'about', 
            'services' => 'services',
            'contact' => 'contact',
            'blog.index' => 'blog',
            'pricing' => 'pricing',
            default => $currentRoute
        };
        $pageSeo = \App\Models\PageSeoSetting::getByRoute($pageRoute);
    @endphp
    
    <!-- Primary SEO Meta Tags -->
    <title>{{ $pageSeo?->meta_title ?: ($pageSeo?->page_title ? $pageSeo->page_title . ' - ' . $seoSettings->site_name : $seoSettings->site_name . ' - ' . $seoSettings->site_tagline) }}</title>
    <meta name="title" content="{{ $pageSeo?->meta_title ?: ($pageSeo?->page_title ? $pageSeo->page_title . ' - ' . $seoSettings->site_name : $seoSettings->site_name . ' - ' . $seoSettings->site_tagline) }}">
    <meta name="description" content="{{ $pageSeo?->meta_description ?: $seoSettings->site_description }}">
    <meta name="keywords" content="{{ $pageSeo?->meta_keywords ?: $seoSettings->site_keywords }}">
    <meta name="author" content="{{ $seoSettings->site_author }}">
    <meta name="robots" content="{{ $pageSeo?->getRobotsContent() ?: 'index,follow' }}">
    
    <!-- Canonical URL -->
    @if($seoSettings->canonical_urls_enabled)
        <link rel="canonical" href="{{ $pageSeo?->getCanonicalUrl() ?: url()->current() }}">
    @endif
    
    <!-- Open Graph / Facebook -->
    @if($seoSettings->open_graph_enabled)
        <meta property="og:type" content="{{ $pageSeo?->og_type ?: 'website' }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $pageSeo?->og_title ?: ($pageSeo?->meta_title ?: $seoSettings->site_name) }}">
        <meta property="og:description" content="{{ $pageSeo?->og_description ?: ($pageSeo?->meta_description ?: $seoSettings->site_description) }}">
        <meta property="og:image" content="{{ $pageSeo?->getOgImageUrl() ?: $seoSettings->getOgImageUrl() }}">
        <meta property="og:locale" content="{{ app()->getLocale() }}">
        <meta property="og:site_name" content="{{ $seoSettings->site_name }}">
        @if($seoSettings->facebook_app_id)
            <meta property="fb:app_id" content="{{ $seoSettings->facebook_app_id }}">
        @endif
    @endif
    
    <!-- Twitter -->
    @if($seoSettings->twitter_cards_enabled)
        <meta property="twitter:card" content="{{ $pageSeo?->twitter_card_type ?: 'summary_large_image' }}">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ $pageSeo?->twitter_title ?: ($pageSeo?->og_title ?: $seoSettings->site_name) }}">
        <meta property="twitter:description" content="{{ $pageSeo?->twitter_description ?: ($pageSeo?->og_description ?: $seoSettings->site_description) }}">
        <meta property="twitter:image" content="{{ $pageSeo?->getTwitterImageUrl() ?: $seoSettings->getOgImageUrl() }}">
        @if($seoSettings->twitter_username)
            <meta name="twitter:creator" content="{{ $seoSettings->twitter_username }}">
            <meta name="twitter:site" content="{{ $seoSettings->twitter_username }}">
        @endif
    @endif
    
    <!-- Additional SEO Meta Tags -->
    <meta name="theme-color" content="{{ $seoSettings->theme_color }}">
    <meta name="msapplication-TileColor" content="{{ $seoSettings->theme_color }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $seoSettings->getFaviconUrl() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $seoSettings->getAppleTouchIconUrl() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $seoSettings->getFaviconUrl() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $seoSettings->getFaviconUrl() }}">
    @if($seoSettings->manifest_file)
        <link rel="manifest" href="{{ asset($seoSettings->manifest_file) }}">
    @endif
    
    <!-- Site Verification -->
    @foreach($seoSettings->getVerificationCodes() as $engine => $code)
        @if($code)
            <meta name="{{ $engine }}-site-verification" content="{{ $code }}">
        @endif
    @endforeach
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="//cdn.tailwindcss.com">
    <link rel="dns-prefetch" href="//unpkg.com">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- JSON-LD Structured Data -->
    @if($seoSettings->json_ld_enabled)
        <script type="application/ld+json">
        {!! json_encode($seoSettings->getOrganizationSchema(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        
        @if($pageSeo && $pageSeo->generateJsonLD())
            @foreach($pageSeo->generateJsonLD() as $schemaKey => $schemaData)
                <script type="application/ld+json">
                {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
                </script>
            @endforeach
        @endif
    @endif
    
    <!-- Google Analytics -->
    @if($seoSettings->google_analytics_id)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seoSettings->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $seoSettings->google_analytics_id }}');
        </script>
    @endif
    
    <!-- Google Tag Manager -->
    @if($seoSettings->google_tag_manager_id)
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $seoSettings->google_tag_manager_id }}');</script>
    @endif
    
    <!-- Facebook Pixel -->
    @if($seoSettings->facebook_pixel_id)
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $seoSettings->facebook_pixel_id }}');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ $seoSettings->facebook_pixel_id }}&ev=PageView&noscript=1"
        /></noscript>
    @endif
    
    <!-- Custom Head Code -->
    @if($seoSettings->custom_head_code)
        {!! $seoSettings->custom_head_code !!}
    @endif
    
    @if($pageSeo?->custom_head_code)
        {!! $pageSeo->custom_head_code !!}
    @endif
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                        'space': ['Space Grotesk', 'sans-serif'],
                    },
                    colors: {
                        'primary': '{{ $seoSettings->theme_color }}',
                        'secondary': '#E53E3E', 
                        'accent': '#FC8181',
                        'dark': '{{ $seoSettings->background_color }}',
                        'dark-light': '#1a1a1a',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'slide-up': 'slide-up 0.5s ease-out',
                        'fade-in': 'fade-in 0.5s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        glow: {
                            '0%': { boxShadow: '0 0 20px rgba(139, 92, 246, 0.3)' },
                            '100%': { boxShadow: '0 0 30px rgba(139, 92, 246, 0.6)' },
                        },
                        'slide-up': {
                            '0%': { transform: 'translateY(100px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        'fade-in': {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    },
                }
            }
        }
    </script>
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, {{ $seoSettings->background_color }} 0%, #1a1a1a 25%, #2d1b4e 50%, #1a1a1a 75%, {{ $seoSettings->background_color }} 100%);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, {{ $seoSettings->theme_color }}, #E53E3E, #FC8181);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, {{ $seoSettings->theme_color }}, #E53E3E, #FC8181);
            z-index: 9999;
            transition: width 0.3s ease;
        }

        .main-content {
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
        }

        .main-content.loaded {
            opacity: 1;
        }

        body.preloader-active {
            overflow: hidden;
        }

        img {
            content-visibility: auto;
        }

        .lazy {
            opacity: 0;
            transition: opacity 0.3s;
        }

        .lazy.loaded {
            opacity: 1;
        }
    </style>
    
    @stack('head')
</head>
<body class="bg-dark text-white font-inter overflow-x-hidden preloader-active">
    
    <!-- Google Tag Manager (noscript) -->
    @if($seoSettings->google_tag_manager_id)
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $seoSettings->google_tag_manager_id }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    
    <!-- Custom Body Code -->
    @if($seoSettings->custom_body_code)
        {!! $seoSettings->custom_body_code !!}
    @endif
    
    @if($pageSeo?->custom_body_code)
        {!! $pageSeo->custom_body_code !!}
    @endif
    
    <!-- Preloader -->
    @include('components.preloader')
    
    <!-- Main Content Wrapper -->
    <div class="main-content" id="mainContent">
        <!-- Scroll Indicator -->
        <div class="scroll-indicator" id="scrollIndicator"></div>
        
        <!-- Background Particles -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute inset-0">
                @for($i = 0; $i < 50; $i++)
                    <div class="absolute w-1 h-1 bg-primary rounded-full opacity-20 animate-pulse" 
                         style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5000) }}ms;"></div>
                @endfor
            </div>
        </div>
        
        {{-- <!-- Breadcrumbs -->
        @if($seoSettings->breadcrumbs_enabled && $pageSeo && count($pageSeo->getBreadcrumbs()) > 1)
            <nav class="breadcrumbs bg-dark-light py-4 mt-20" aria-label="Breadcrumb">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <ol class="flex items-center space-x-2 text-sm">
                        @foreach($pageSeo->getBreadcrumbs() as $index => $breadcrumb)
                            @if($loop->last)
                                <li class="text-gray-400" aria-current="page">
                                    {{ $breadcrumb['name'] }}
                                </li>
                            @else
                                <li>
                                    <a href="{{ $breadcrumb['url'] }}" class="text-primary hover:text-secondary transition-colors duration-200">
                                        {{ $breadcrumb['name'] }}
                                    </a>
                                </li>
                                @if(!$loop->last)
                                    <li class="text-gray-600">
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ol>
                </div>
            </nav>
        @endif --}}
        
        <!-- Navigation -->
        @include('components.navigation')
        
        <!-- Main Content -->
        <main class="relative z-10">
            @yield('content')
        </main>
        
        <!-- Footer -->
        @include('components.footer')
    </div>

    <!-- Load AOS only after preloader -->
    <link id="aos-css" href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" media="print" onload="this.media='all'">
    
    <!-- Scripts -->
    <script>
        // Global TKDS object for utilities
        window.TKDS = {
            baseUrl: '{{ url("/") }}',
            csrfToken: '{{ csrf_token() }}',
            currentRoute: '{{ Route::currentRouteName() }}',
            seoSettings: {!! json_encode($seoSettings->only(['site_name', 'theme_color', 'background_color'])) !!},
            config: {
                contactFormUrl: '{{ route("contact.store") }}',
                blogApiUrl: '{{ route("blog.api") }}',
            }
        };

        // Wait for preloader completion
        window.addEventListener('preloaderComplete', function() {
            initializePage();
        });

        // Fallback initialization
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (document.body.classList.contains('preloader-active')) {
                    initializePage();
                }
            }, 10000);
        });

        function initializePage() {
            // Remove preloader active class
            document.body.classList.remove('preloader-active');
            
            // Show main content
            const mainContent = document.getElementById('mainContent');
            if (mainContent) {
                mainContent.classList.add('loaded');
            }

            // Load and initialize AOS
            if (typeof AOS === 'undefined') {
                const aosScript = document.createElement('script');
                aosScript.src = 'https://unpkg.com/aos@2.3.1/dist/aos.js';
                aosScript.onload = function() {
                    AOS.init({
                        duration: 1000,
                        once: true,
                        offset: 100,
                        easing: 'ease-out-cubic',
                        mirror: false
                    });
                };
                document.head.appendChild(aosScript);
            } else {
                AOS.init({
                    duration: 1000,
                    once: true,
                    offset: 100,
                    easing: 'ease-out-cubic',
                    mirror: false
                });
            }
            
            // Initialize other page features
            initializePageFeatures();
        }

        function initializePageFeatures() {
            // Scroll Indicator
            window.addEventListener('scroll', throttle(() => {
                const scrollIndicator = document.getElementById('scrollIndicator');
                if (scrollIndicator) {
                    const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
                    scrollIndicator.style.width = Math.min(scrolled, 100) + '%';
                }
            }, 16));
            
            // Smooth Scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Enhanced Navbar Background on Scroll
            window.addEventListener('scroll', throttle(() => {
                const navbar = document.getElementById('navbar');
                if (navbar) {
                    if (window.scrollY > 100) {
                        navbar.classList.add('bg-dark/95', 'backdrop-blur-lg', 'border-b', 'border-white/10');
                        navbar.classList.remove('bg-transparent');
                    } else {
                        navbar.classList.remove('bg-dark/95', 'backdrop-blur-lg', 'border-b', 'border-white/10');
                        navbar.classList.add('bg-transparent');
                    }
                }
            }, 16));

            // Lazy loading for images
            const lazyImages = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(img => imageObserver.observe(img));

            // Add page loaded class
            document.body.classList.add('page-loaded');

            // Initialize contact form if exists
            initializeContactForm();

            // Google Analytics page view tracking
            if (typeof gtag !== 'undefined') {
                gtag('config', '{{ $seoSettings->google_analytics_id }}', {
                    page_title: document.title,
                    page_location: window.location.href
                });
            }

            // Facebook Pixel page view tracking
            if (typeof fbq !== 'undefined') {
                fbq('track', 'PageView');
            }
        }

        // Throttle function for performance
        function throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            }
        }

        // Initialize contact form functionality
        function initializeContactForm() {
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', handleContactFormSubmission);
                
                // Real-time validation
                const formFields = contactForm.querySelectorAll('input, select, textarea');
                formFields.forEach(field => {
                    field.addEventListener('blur', validateField);
                    field.addEventListener('input', clearFieldError);
                });

                // Email validation
                const emailField = contactForm.querySelector('#email');
                if (emailField) {
                    emailField.addEventListener('blur', validateEmail);
                }
            }
        }

        // Handle contact form submission
        function handleContactFormSubmission(e) {
            e.preventDefault();
            
            const form = e.target;
            const submitButton = form.querySelector('#submitButton');
            const buttonText = form.querySelector('#buttonText');
            const buttonIcon = form.querySelector('#buttonIcon');
            const successMessage = form.querySelector('#successMessage');
            const errorMessage = form.querySelector('#errorMessage');
            
            // Clear previous messages
            if (successMessage) successMessage.classList.add('hidden');
            if (errorMessage) errorMessage.classList.add('hidden');
            
            // Clear previous error messages
            form.querySelectorAll('.error-message').forEach(el => {
                el.classList.add('hidden');
                const field = el.parentElement.querySelector('input, select, textarea');
                if (field) field.classList.remove('border-red-500');
            });
            
            // Disable submit button
            if (submitButton) {
                submitButton.disabled = true;
                if (buttonText) buttonText.textContent = 'Sending...';
                if (buttonIcon) buttonIcon.className = 'fas fa-spinner fa-spin';
            }
            
            // Collect form data
            const formData = new FormData(form);
            
            // Send request
            fetch(window.TKDS.config.contactFormUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': window.TKDS.csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    if (successMessage) {
                        successMessage.classList.remove('hidden');
                        const successText = successMessage.querySelector('#successText');
                        if (successText) successText.textContent = data.message;
                    }
                    
                    // Reset form
                    form.reset();
                    
                    // Scroll to success message
                    if (successMessage) {
                        successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    // Google Analytics event
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'form_submit', {
                            event_category: 'Contact',
                            event_label: 'Contact Form Submission',
                            value: 1
                        });
                    }

                    // Facebook Pixel event
                    if (typeof fbq !== 'undefined') {
                        fbq('track', 'Contact');
                    }
                } else {
                    handleFormErrors(data, form, errorMessage);
                }
            })
            .catch(error => {
                console.error('Contact form error:', error);
                if (errorMessage) {
                    errorMessage.classList.remove('hidden');
                    const errorText = errorMessage.querySelector('#errorText');
                    if (errorText) errorText.textContent = 'Something went wrong. Please try again later.';
                }
            })
            .finally(() => {
                // Re-enable submit button
                if (submitButton) {
                    submitButton.disabled = false;
                    if (buttonText) buttonText.textContent = 'Send Message';
                    if (buttonIcon) buttonIcon.className = 'fas fa-paper-plane';
                }
            });
        }

        // Handle form validation errors
        function handleFormErrors(data, form, errorMessage) {
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const fieldElement = form.querySelector(`[name="${field}"]`);
                    if (fieldElement) {
                        const errorElement = fieldElement.parentElement.querySelector('.error-message');
                        if (errorElement) {
                            errorElement.textContent = data.errors[field][0];
                            errorElement.classList.remove('hidden');
                            fieldElement.classList.add('border-red-500');
                        }
                    }
                });
            } else {
                if (errorMessage) {
                    errorMessage.classList.remove('hidden');
                    const errorText = errorMessage.querySelector('#errorText');
                    if (errorText) errorText.textContent = data.message || 'Please check your information and try again.';
                }
            }
        }

        // Field validation functions
        function validateField() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                showFieldError(this, 'This field is required.');
            } else {
                clearFieldError.call(this);
            }
        }

        function validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.value && !emailRegex.test(this.value)) {
                showFieldError(this, 'Please enter a valid email address.');
            }
        }

        function showFieldError(field, message) {
            field.classList.add('border-red-500');
            const errorElement = field.parentElement.querySelector('.error-message');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }
        }

        function clearFieldError() {
            if (this.classList.contains('border-red-500') && this.value.trim()) {
                this.classList.remove('border-red-500');
                const errorElement = this.parentElement.querySelector('.error-message');
                if (errorElement) errorElement.classList.add('hidden');
            }
        }

        // Performance optimization: Preload critical resources
        window.addEventListener('load', function() {
            // Preload next page resources if needed
            const links = document.querySelectorAll('a[href]');
            links.forEach(link => {
                if (link.hostname === window.location.hostname && !link.href.includes('#')) {
                    const prefetchLink = document.createElement('link');
                    prefetchLink.rel = 'prefetch';
                    prefetchLink.href = link.href;
                    document.head.appendChild(prefetchLink);
                }
            });
        });
    </script>
    
    <!-- Custom Footer Code -->
    @if($seoSettings->custom_footer_code)
        {!! $seoSettings->custom_footer_code !!}
    @endif
    @stack('styles')

<style>
/* ===== UNIVERSAL SELECT MENU STYLES ===== */

/* Reset and base styling for ALL select elements */
select {
    /* Remove default styling */
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    
    /* Base styling */
    width: 100%;
    padding: 0.75rem 2.5rem 0.75rem 1rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
    
    /* Custom dropdown arrow */
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.25rem 1.25rem;
}

/* Hover state */
select:hover {
    background-color: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Focus state */
select:focus {
    outline: none;
    background-color: rgba(255, 255, 255, 0.15);
    border-color: #C53030;
    box-shadow: 0 0 0 3px rgba(197, 48, 48, 0.2), 0 8px 25px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
    
    /* Change arrow color on focus */
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23C53030' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
}

/* Active/Open state */
select:active {
    transform: translateY(0);
}

/* Option styling */
select option {
    background-color: #1a1a1a;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    font-size: 1rem;
}

select option:hover,
select option:checked,
select option:focus {
    background-color: #C53030;
    color: white;
}

/* Disabled state */
select:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

select:disabled:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    transform: none;
    box-shadow: none;
}

/* Invalid/Error state */
select:invalid,
select.error {
    border-color: #ef4444;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ef4444' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
}

select:invalid:focus,
select.error:focus {
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
}

/* Success state */
select.success {
    border-color: #10b981;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2310b981' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
}

/* Small size variant */
select.select-sm {
    padding: 0.5rem 2rem 0.5rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.5rem;
    background-size: 1rem 1rem;
    background-position: right 0.5rem center;
}

/* Large size variant */
select.select-lg {
    padding: 1rem 3rem 1rem 1.25rem;
    font-size: 1.125rem;
    border-radius: 1rem;
    background-size: 1.5rem 1.5rem;
    background-position: right 1rem center;
}

/* Compact variant */
select.select-compact {
    padding: 0.375rem 2rem 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    background-size: 1rem 1rem;
    background-position: right 0.5rem center;
}

/* Light theme override (for forms on light backgrounds) */
select.select-light {
    background-color: white;
    color: #374151;
    border-color: #d1d5db;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
}

select.select-light:hover {
    background-color: #f9fafb;
    border-color: #9ca3af;
}

select.select-light:focus {
    background-color: white;
    border-color: #C53030;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23C53030' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
}

select.select-light option {
    background-color: white;
    color: #374151;
}

/* Loading state */
select.select-loading {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'%3e%3ccircle cx='12' cy='12' r='10' stroke='%23ffffff' stroke-width='2' fill='none' stroke-dasharray='31.416' stroke-dashoffset='31.416'%3e%3canimateTransform attributeName='transform' type='rotate' dur='2s' values='0 12 12;360 12 12' repeatCount='indefinite'/%3e%3canimate attributeName='stroke-dasharray' dur='2s' values='0 31.416;15.708 15.708;0 31.416' repeatCount='indefinite'/%3e%3canimate attributeName='stroke-dashoffset' dur='2s' values='0;-15.708;-31.416' repeatCount='indefinite'/%3e%3c/circle%3e%3c/svg%3e");
    background-size: 1rem 1rem;
    cursor: wait;
}

/* Custom scrollbar for select dropdown */
select::-webkit-scrollbar {
    width: 8px;
}

select::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

select::-webkit-scrollbar-thumb {
    background: #C53030;
    border-radius: 4px;
}

select::-webkit-scrollbar-thumb:hover {
    background: #E53E3E;
}

/* Responsive design */
@media (max-width: 640px) {
    select {
        padding: 0.625rem 2.25rem 0.625rem 0.875rem;
        font-size: 0.875rem;
        background-size: 1.125rem 1.125rem;
        background-position: right 0.625rem center;
    }
}

/* Animation for select opening (if supported) */
@keyframes selectOpen {
    from {
        transform: translateY(-2px) scale(0.98);
        opacity: 0.8;
    }
    to {
        transform: translateY(-2px) scale(1);
        opacity: 1;
    }
}

select:focus {
    animation: selectOpen 0.2s ease-out;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    select {
        border-width: 2px;
        border-color: white;
    }
    
    select:focus {
        border-color: #C53030;
        outline: 2px solid #C53030;
        outline-offset: 2px;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    select {
        transition: none;
        animation: none;
    }
    
    select:hover,
    select:focus {
        transform: none;
    }
}

/* Print styles */
@media print {
    select {
        background: white !important;
        color: black !important;
        border: 1px solid black !important;
        background-image: none !important;
    }
}
</style>
    @stack('scripts')
</body>
</html>