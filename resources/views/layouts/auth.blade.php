{{-- File: resources/views/layouts/auth.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Authentication - TKDS Media')</title>
    <meta name="description" content="@yield('meta_description', 'Secure authentication for TKDS Media broadcasting platform.')">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
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
                        'primary': '#C53030',
                        'secondary': '#E53E3E', 
                        'accent': '#FC8181',
                        'dark': '#0a0a0a',
                        'dark-light': '#1a1a1a',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                }
            }
        }
    </script>
    
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #2d1b4e 50%, #1a1a1a 75%, #0a0a0a 100%);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #C53030, #E53E3E);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #E53E3E, #FC8181);
        }
        
        /* Focus styles */
        input:focus, textarea:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(197, 48, 48, 0.1);
        }
        
        /* Button hover effects */
        .btn-hover-effect {
            position: relative;
            overflow: hidden;
        }
        
        .btn-hover-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-hover-effect:hover::before {
            left: 100%;
        }
        
        /* Loading animation */
        .loading-dots::after {
            content: '';
            animation: dots 1.5s steps(3, end) infinite;
        }
        
        @keyframes dots {
            0%, 20% {
                color: rgba(0, 0, 0, 0);
                text-shadow: .25em 0 0 rgba(0, 0, 0, 0), .5em 0 0 rgba(0, 0, 0, 0);
            }
            40% {
                color: currentColor;
                text-shadow: .25em 0 0 rgba(0, 0, 0, 0), .5em 0 0 rgba(0, 0, 0, 0);
            }
            60% {
                text-shadow: .25em 0 0 currentColor, .5em 0 0 rgba(0, 0, 0, 0);
            }
            80%, 100% {
                text-shadow: .25em 0 0 currentColor, .5em 0 0 currentColor;
            }
        }
        
        /* Input validation styles */
        .input-success {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }
        
        .input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }
        
        /* Animation delays for staggered effects */
        .animate-delay-100 { animation-delay: 100ms; }
        .animate-delay-200 { animation-delay: 200ms; }
        .animate-delay-300 { animation-delay: 300ms; }
        .animate-delay-400 { animation-delay: 400ms; }
        .animate-delay-500 { animation-delay: 500ms; }
    </style>
    
    @stack('head')
</head>
<body class="bg-dark text-white font-inter overflow-x-hidden">
    
    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Global Scripts -->
    <script>
        // CSRF token setup for AJAX requests
        window.TKDS = {
            csrfToken: '{{ csrf_token() }}',
            baseUrl: '{{ url("/") }}',
        };
        
        // Auto-hide success/error messages
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-auto-hide');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
        
        // Enhanced form validation
        function validateFormField(field, rules) {
            const value = field.value.trim();
            let isValid = true;
            let errorMessage = '';
            
            // Required validation
            if (rules.required && !value) {
                isValid = false;
                errorMessage = `${field.getAttribute('data-label') || field.name} is required.`;
            }
            
            // Email validation
            if (rules.email && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address.';
                }
            }
            
            // Min length validation
            if (rules.minLength && value.length > 0 && value.length < rules.minLength) {
                isValid = false;
                errorMessage = `Must be at least ${rules.minLength} characters long.`;
            }
            
            // Password confirmation
            if (rules.confirmation) {
                const confirmationField = document.getElementById(rules.confirmation);
                if (confirmationField && value !== confirmationField.value) {
                    isValid = false;
                    errorMessage = 'Password confirmation does not match.';
                }
            }
            
            // Update field appearance
            field.classList.remove('input-success', 'input-error');
            if (value.length > 0) {
                field.classList.add(isValid ? 'input-success' : 'input-error');
            }
            
            // Show/hide error message
            const errorElement = field.parentNode.querySelector('.field-error');
            if (errorElement) {
                errorElement.textContent = isValid ? '' : errorMessage;
                errorElement.style.display = isValid ? 'none' : 'block';
            }
            
            return isValid;
        }
        
        // Smooth scroll for anchor links
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
        
        // Enhanced loading states
        function setButtonLoading(button, loading = true) {
            const icon = button.querySelector('i');
            const text = button.querySelector('span');
            
            if (loading) {
                button.disabled = true;
                button.classList.add('opacity-75', 'cursor-not-allowed');
                if (icon) {
                    icon.className = 'fas fa-spinner fa-spin';
                }
                if (text) {
                    text.classList.add('loading-dots');
                }
            } else {
                button.disabled = false;
                button.classList.remove('opacity-75', 'cursor-not-allowed');
                if (text) {
                    text.classList.remove('loading-dots');
                }
            }
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Escape key to close modals or go back
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal:not(.hidden)');
                if (modals.length > 0) {
                    modals.forEach(modal => modal.classList.add('hidden'));
                }
            }
            
            // Ctrl/Cmd + Enter to submit forms
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                const activeForm = document.activeElement.closest('form');
                if (activeForm) {
                    activeForm.submit();
                }
            }
        });
        
        // Auto-resize textareas
        document.addEventListener('input', function(e) {
            if (e.target.tagName === 'TEXTAREA') {
                e.target.style.height = 'auto';
                e.target.style.height = (e.target.scrollHeight) + 'px';
            }
        });
        
        // Performance optimization: Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>