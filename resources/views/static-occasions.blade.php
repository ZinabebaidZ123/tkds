<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Occasions - TKDS Servers</title>
    <meta name="description" content="Special occasions sale with up to 70% off on premium hosting solutions and streaming services">
    <meta name="keywords" content="hosting, servers, streaming, special offer, discount">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Exo+2:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sales.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'orbitron': ['Orbitron', 'monospace'],
                        'exo': ['Exo 2', 'sans-serif'],
                    },
                    colors: {
                        'neon-pink': '#ff0040',
                        'neon-red': '#ff4060',
                        'dark-bg': '#0a0a0a',
                        'dark-card': '#1a1a1a',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite alternate',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'rotate-slow': 'rotateSlow 20s linear infinite',
                        'bounce-soft': 'bounceSoft 2s infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(5deg)' }
                        },
                        pulseGlow: {
                            '0%': { boxShadow: '0 0 20px rgba(255, 64, 96, 0.5)' },
                            '100%': { boxShadow: '0 0 40px rgba(255, 64, 96, 0.8)' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(100px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        rotateSlow: {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' }
                        },
                        bounceSoft: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        glow: {
                            '0%': { filter: 'brightness(1) saturate(1)' },
                            '100%': { filter: 'brightness(1.2) saturate(1.3)' }
                        }
                    },
                    perspective: {
                        '1000': '1000px',
                        '1500': '1500px',
                    }
                }
            }
        }
    </script>

<script src="{{ asset('js/sales.js') }}"></script>
</head>
<body class="bg-dark-bg text-white font-exo overflow-x-hidden bg-gradient-dark font-oswald  min-h-screen">
 <!-- Header -->
<header class="absolute top-0 w-full z-50 p-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="tv-startup-logo font-bebas">
            TKDS
            <div class="text-sm font-normal text-gray-300 font-oswald">SHAPING THE WORLD</div>
        </div>
        <a href="tel:+13252680040" class="call-sales-btn inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-800 to-gray-700 hover:from-gray-700 hover:to-gray-600 text-white font-semibold font-oswald text-sm uppercase tracking-wider rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-600 hover:border-gray-500 backdrop-blur-sm">
            CALL SALES
            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
        </a>
    </div>
</header>


  <!-- Hero Section -->
    <section class="relative min-h-[80vh] flex items-center justify-center overflow-hidden">
        <!-- Background Animation -->
        <div class="absolute inset-0">
            <!-- Animated Grid -->
            <div class="absolute inset-0 opacity-20 grid-pattern"></div>
            
            <!-- Wave Patterns -->
            <div class="absolute bottom-0 w-full">
                <div class="wave-pattern"></div>
                <div class="wave-pattern"></div>
                <div class="wave-pattern"></div>
            </div>
            
            <!-- Floating Elements -->
            <div class="floating-dots" style="top: 20%; left: 10%;"></div>
            <div class="floating-dots large" style="top: 60%; left: 15%; animation-delay: -2s;"></div>
            <div class="floating-dots" style="top: 30%; left: 80%;"></div>
            <div class="floating-dots large" style="top: 70%; left: 85%; animation-delay: -1.5s;"></div>
            <div class="floating-dots" style="top: 15%; left: 70%; animation-delay: -0.5s;"></div>
            <div class="floating-dots" style="top: 80%; left: 20%; animation-delay: -2.5s;"></div>
        </div>

        <!-- Discount Wave Badge (Right Side) -->
        <div class="absolute top-1/4 right-8 md:right-16">
            <div class="wave-badge">
                <div class="text-center text-white font-bebas">
                    <div class="text-sm">UP TO</div>
                    <div class="text-3xl font-black">80%</div>
                    <div class="text-sm">OFF</div>
                </div>
            </div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 text-center px-6 max-w-6xl mx-auto">
            <!-- Main Title -->
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black font-anton mb-6 slide-in-left leading-tight">
                <span class="text-white" style="text-stroke: 2px transparent;">BLACK</span>
                <span class="text-gradient-red italic font-bebas" style="font-style: italic; position: relative;">Sale</span><br>
                <span class="text-white text-5xl md:text-7xl lg:text-8xl">FRIDAY</span>
            </h1>

            <!-- Subtitle -->
            <div class="text-2xl md:text-4xl font-bold text-gradient-red mb-4 slide-in-right font-bebas tracking-wider">
                Expand Your TV Network
            </div>
            <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-2xl mx-auto slide-in-right font-oswald">
                To Additional Platforms
            </p>

            <!-- Countdown Timer -->
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-12">
                <div class="glass-effect rounded-2xl p-4 text-center scale-hover">
                    <div class="text-3xl md:text-4xl font-bold text-white font-bebas tracking-wider" id="days">02</div>
                    <div class="text-xs text-gray-300 uppercase tracking-wider font-oswald">DAYS</div>
                </div>
                <div class="glass-effect rounded-2xl p-4 text-center scale-hover">
                    <div class="text-3xl md:text-4xl font-bold text-white font-bebas tracking-wider" id="hours">15</div>
                    <div class="text-xs text-gray-300 uppercase tracking-wider font-oswald">HOURS</div>
                </div>
                <div class="glass-effect rounded-2xl p-4 text-center scale-hover">
                    <div class="text-3xl md:text-4xl font-bold text-white font-bebas tracking-wider" id="minutes">53</div>
                    <div class="text-xs text-gray-300 uppercase tracking-wider font-oswald">MINUTES</div>
                </div>
                <div class="glass-effect rounded-2xl p-4 text-center scale-hover">
                    <div class="text-3xl md:text-4xl font-bold text-white font-bebas tracking-wider" id="seconds">51</div>
                    <div class="text-xs text-gray-300 uppercase tracking-wider font-oswald">SECONDS</div>
                </div>
            </div>

            <!-- CTA Button -->
            <button class="bg-gradient-to-r from-red-600 to-red-700 text-white px-12 py-4 rounded-full text-lg md:text-xl font-bold hover:scale-110 transition-all duration-300 neon-shadow-red animate-pulse-glow font-oswald">
                <i class="fas fa-tv mr-3"></i>START YOUR JOURNEY
            </button>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-2xl text-red-500"></i>
        </div>
    </section>

<!-- Why Choose Us Section -->
<section class="py-20 relative overflow-hidden min-h-screen">
    <!-- Full Width Background Image -->
    <div class="absolute inset-0 w-screen -left-6 -right-6 md:-left-12 md:-right-12">
        <img 
            src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&auto=format&fit=crop&w=2500&q=80" 
            alt="Streaming Technology" 
            class="w-full h-full object-cover object-center"
        />
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-black/60 to-gray-900/70"></div>
    </div>
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-neon-pink rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-600 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-7xl mx-auto h-screen flex items-center">
            <!-- Left Image Column -->
            <div class="relative group">
                <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-dark-card/90 to-gray-900/90 backdrop-blur-md border border-gray-700/70 shadow-2xl h-[500px] lg:h-[600px]">
                    <img 
                        src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                        alt="Why Choose Us" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                    <!-- Overlay Grid Pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="grid grid-cols-12 h-full">
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                            <div class="border-r border-white/10"></div>
                        </div>
                    </div>
                    <!-- Corner Decorations -->
                    <div class="absolute top-6 left-6 w-12 h-12 border-t-2 border-l-2 border-neon-pink/60"></div>
                    <div class="absolute top-6 right-6 w-12 h-12 border-t-2 border-r-2 border-neon-pink/60"></div>
                    <div class="absolute bottom-6 left-6 w-12 h-12 border-b-2 border-l-2 border-neon-pink/60"></div>
                    <div class="absolute bottom-6 right-6 w-12 h-12 border-b-2 border-r-2 border-neon-pink/60"></div>
                </div>
                <!-- Glow Effect -->
                <div class="absolute -inset-2 bg-gradient-to-br from-neon-pink/30 to-purple-600/30 rounded-3xl blur-xl opacity-60 -z-10 group-hover:opacity-80 transition-opacity"></div>
            </div>
            
            <!-- Right Content Column -->
            <div class="text-left lg:pl-12">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-black font-orbitron mb-6 text-white drop-shadow-2xl leading-tight">
                    WHY CHOOSE
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-neon-pink via-pink-400 to-purple-500">TKDS</span>
                </h2>
                <div class="text-2xl md:text-3xl font-bold text-gradient-red mb-8 font-bebas tracking-wider drop-shadow-lg">
                    UNMATCHED EXCELLENCE
                </div>
                
                <ul class="space-y-6 mb-12">
                    <li class="group flex items-start space-x-4 p-4 bg-dark-card/50 rounded-xl border border-gray-700/50 hover:border-neon-pink/50 transition-all duration-300 hover:bg-dark-card/70 hover:translate-x-4">
                        <div class="w-12 h-12 bg-gradient-neon rounded-xl flex items-center justify-center flex-shrink-0 mt-1 group-hover:scale-110 transition-all duration-300 shadow-lg">
                            <i class="fas fa-rocket text-xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold font-orbitron text-white mb-2 group-hover:text-neon-pink transition-colors">Lightning Performance</h4>
                            <p class="text-gray-300 leading-relaxed">Global CDN with SSD storage delivers content instantly worldwide</p>
                        </div>
                    </li>
                    <li class="group flex items-start space-x-4 p-4 bg-dark-card/50 rounded-xl border border-gray-700/50 hover:border-neon-pink/50 transition-all duration-300 hover:bg-dark-card/70 hover:translate-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 group-hover:scale-110 transition-all duration-300 shadow-lg">
                            <i class="fas fa-shield-alt text-xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold font-orbitron text-white mb-2 group-hover:text-purple-400 transition-colors">Enterprise Security</h4>
                            <p class="text-gray-300 leading-relaxed">Military-grade encryption & AI-powered threat protection 24/7</p>
                        </div>
                    </li>
                    <li class="group flex items-start space-x-4 p-4 bg-dark-card/50 rounded-xl border border-gray-700/50 hover:border-neon-pink/50 transition-all duration-300 hover:bg-dark-card/70 hover:translate-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 group-hover:scale-110 transition-all duration-300 shadow-lg">
                            <i class="fas fa-headset text-xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold font-orbitron text-white mb-2 group-hover:text-emerald-400 transition-colors">Expert 24/7 Support</h4>
                            <p class="text-gray-300 leading-relaxed">Real humans, not bots. Instant responses around the clock</p>
                        </div>
                    </li>
                    <li class="group flex items-start space-x-4 p-4 bg-dark-card/50 rounded-xl border border-gray-700/50 hover:border-neon-pink/50 transition-all duration-300 hover:bg-dark-card/70 hover:translate-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 group-hover:scale-110 transition-all duration-300 shadow-lg">
                            <i class="fas fa-chart-line text-xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold font-orbitron text-white mb-2 group-hover:text-blue-400 transition-colors">99.9% Uptime Guarantee</h4>
                            <p class="text-gray-300 leading-relaxed">SLA-backed reliability with enterprise-grade infrastructure</p>
                        </div>
                    </li>
                </ul>
                
                <div class="bg-gradient-to-r from-neon-pink to-purple-600 text-white px-8 py-4 rounded-2xl font-bold text-lg inline-flex items-center hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-neon-pink backdrop-blur-sm border border-neon-pink/50 hover:border-neon-pink">
                    <i class="fas fa-arrow-right mr-3"></i>
                    GET STARTED NOW
                </div>
            </div>
        </div>
    </div>
</section>

 <!-- Services Slider Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-title">
                <h2 class="font-orbitron ">
                    PREMIUM SERVICES
                </h2>
                <p>
                    Experience cutting-edge technology with our professional solutions
                </p>
            </div>

            <!-- Services 3D Slider -->
            <div class="slider-container">
                <div class="slider-wrapper" id="sliderWrapper">
                    <!-- Service 1 -->
                    <div class="slide active" data-index="0">
                        <div class="slide-card">
                            <div class="glowing-orb"></div>
                            
                            <div class="service-icon">
                                <i class="fas fa-server"></i>
                            </div>
                            
                            <h3 class="service-title font-orbitron">
                                Premium Hosting
                            </h3>
                            <p class="service-description">
                                Advanced cloud hosting solutions with enterprise-grade security, 99.9% uptime guarantee, and lightning-fast performance for your critical applications.
                            </p>
                            
                            <button class="read-more-btn" onclick="showMore(0)">
                                Read More
                            </button>
                            
                            <div class="price-badge">
                                50% OFF
                            </div>
                        </div>
                    </div>

                    <!-- Service 2 -->
                    <div class="slide next" data-index="1">
                        <div class="slide-card">
                            <div class="glowing-orb"></div>
                            
                            <div class="service-icon">
                                <i class="fas fa-cloud"></i>
                            </div>
                            
                            <h3 class="service-title font-orbitron">
                                Cloud Storage
                            </h3>
                            <p class="service-description">
                                Secure and scalable cloud storage with automated backups, real-time sync, and advanced encryption to protect your valuable data.
                            </p>
                            
                            <button class="read-more-btn" onclick="showMore(1)">
                                Read More
                            </button>
                            
                            <div class="price-badge">
                                40% OFF
                            </div>
                        </div>
                    </div>

                    <!-- Service 3 -->
                    <div class="slide far-right" data-index="2">
                        <div class="slide-card">
                            <div class="glowing-orb"></div>
                            
                            <div class="service-icon">
                                <i class="fas fa-broadcast-tower"></i>
                            </div>
                            
                            <h3 class="service-title font-orbitron">
                                CDN Network
                            </h3>
                            <p class="service-description">
                                Global content delivery network ensuring fast loading times worldwide with edge servers and intelligent caching technology.
                            </p>
                            
                            <button class="read-more-btn" onclick="showMore(2)">
                                Read More
                            </button>
                            
                            <div class="price-badge">
                                30% OFF
                            </div>
                        </div>
                    </div>

                    <!-- Service 4 -->
                    <div class="slide far-left" data-index="3">
                        <div class="slide-card">
                            <div class="glowing-orb"></div>
                            
                            <div class="service-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            
                            <h3 class="service-title font-orbitron">
                                Security Pro
                            </h3>
                            <p class="service-description">
                                Advanced cybersecurity solutions with AI-powered threat detection, real-time monitoring, and comprehensive protection protocols.
                            </p>
                            
                            <button class="read-more-btn" onclick="showMore(3)">
                                Read More
                            </button>
                            
                            <div class="price-badge">
                                60% OFF
                            </div>
                        </div>
                    </div>

                    <!-- Service 5 -->
                    <div class="slide prev" data-index="4">
                        <div class="slide-card">
                            <div class="glowing-orb"></div>
                            
                            <div class="service-icon">
                                <i class="fas fa-database"></i>
                            </div>
                            
                            <h3 class="service-title font-orbitron">
                                Database Management
                            </h3>
                            <p class="service-description">
                                Professional database administration with optimization, backup strategies, and performance monitoring for maximum efficiency.
                            </p>
                            
                            <button class="read-more-btn" onclick="showMore(4)">
                                Read More
                            </button>
                            
                            <div class="price-badge">
                                45% OFF
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button class="nav-button prev" onclick="slideServices('prev')">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-button next" onclick="slideServices('next')">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Dots Indicator -->
            <div class="dots-indicator" id="dotsIndicator">
                <div class="dot active" onclick="slideToService(0)"></div>
                <div class="dot" onclick="slideToService(1)"></div>
                <div class="dot" onclick="slideToService(2)"></div>
                <div class="dot" onclick="slideToService(3)"></div>
                <div class="dot" onclick="slideToService(4)"></div>
            </div>
        </div>
    </section>

    <script>
        let currentSlide = 0;
        const totalSlides = 5;
        let autoRotateInterval;
        
        const slideClasses = ['far-left', 'prev', 'active', 'next', 'far-right'];

        function updateSlides() {
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.dot');

            slides.forEach((slide, index) => {
                // Remove all classes
                slideClasses.forEach(className => slide.classList.remove(className));
                
                // Calculate position relative to current slide
                let position = index - currentSlide;
                
                // Handle circular positioning
                if (position < -2) position += totalSlides;
                if (position > 2) position -= totalSlides;
                
                // Apply appropriate class
                switch(position) {
                    case -2: slide.classList.add('far-left'); break;
                    case -1: slide.classList.add('prev'); break;
                    case 0: slide.classList.add('active'); break;
                    case 1: slide.classList.add('next'); break;
                    case 2: slide.classList.add('far-right'); break;
                }
            });

            // Update dots
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        function slideServices(direction) {
            if (direction === 'next') {
                currentSlide = (currentSlide + 1) % totalSlides;
            } else {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            }
            updateSlides();
            resetAutoRotate();
        }

        function slideToService(index) {
            currentSlide = index;
            updateSlides();
            resetAutoRotate();
        }

        function showMore(index) {
            alert(`More details about service ${index + 1}`);
        }

        function startAutoRotate() {
            autoRotateInterval = setInterval(() => {
                slideServices('next');
            }, 4000);
        }

        function stopAutoRotate() {
            clearInterval(autoRotateInterval);
        }

        function resetAutoRotate() {
            stopAutoRotate();
            setTimeout(startAutoRotate, 2000);
        }

        // Touch/Swipe Support
        let startX = 0;
        let endX = 0;

        document.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
        });

        document.addEventListener('touchend', function(e) {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        });

        function handleSwipe() {
            const threshold = 50;
            const diff = startX - endX;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    slideServices('next');
                } else {
                    slideServices('prev');
                }
            }
        }

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                slideServices('prev');
            } else if (e.key === 'ArrowRight') {
                slideServices('next');
            }
        });

        // Pause auto-rotate on hover
        document.addEventListener('DOMContentLoaded', function() {
            const sliderContainer = document.querySelector('.slider-container');
            
            sliderContainer.addEventListener('mouseenter', stopAutoRotate);
            sliderContainer.addEventListener('mouseleave', startAutoRotate);
            
            // Start auto-rotate
            startAutoRotate();
        });

        // Click on slides to navigate
        document.querySelectorAll('.slide').forEach((slide, index) => {
            slide.addEventListener('click', function() {
                if (!this.classList.contains('active')) {
                    slideToService(index);
                }
            });
        });
    </script>

    <!-- Packages Section -->
    <section class="py-20 relative">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/10 to-pink-900/10"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-6xl font-black font-orbitron  mb-4">
                    EXPLOSIVE PACKAGES
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto ">
                    Choose your perfect plan and save big with our special occasion discounts
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto pt-16">
                @foreach($packages ?? [
                    ['name' => 'Starter', 'price' => '$99', 'discount' => '50%'],
                    ['name' => 'Professional', 'price' => '$199', 'discount' => '60%', 'featured' => true],
                    ['name' => 'Enterprise', 'price' => '$399', 'discount' => '70%']
                ] as $index => $package)
                <div class="group perspective-1000 {{ isset($package['featured']) ? 'lg:-mt-8' : '' }}">
                    <div class="relative {{ isset($package['featured']) ? 'bg-gradient-to-br from-neon-pink/20 to-purple-600/20 scale-105' : 'bg-gradient-to-br from-dark-card to-gray-900' }} rounded-3xl p-8 card-3d glass-effect border-2 {{ isset($package['featured']) ? 'border-neon-pink' : 'border-gray-700' }} hover:border-neon-pink transition-all duration-500">
                        
                        @if(isset($package['featured']))
                        <!-- Popular Badge -->
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="bg-gradient-neon text-white px-6 py-2 rounded-full text-sm font-bold animate-pulse">
                                🔥 MOST POPULAR
                            </span>
                        </div>
                        @endif

                        <!-- Floating Elements -->
                        <div class="absolute -top-3 -right-3 w-16 h-16 bg-gradient-neon rounded-full blur-lg opacity-30 animate-float"></div>
                        
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold font-orbitron mb-2">{{ $package['name'] }}</h3>
                            <div class="text-5xl font-black text-neon-pink font-orbitron mb-2">{{ $package['price'] }}</div>
                            <p class="text-gray-400">/month</p>
                            
                            <!-- Discount Badge -->
                            <div class="mt-4">
                                <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-4 py-1 rounded-full text-sm font-bold animate-glow">
                                    {{ $package['discount'] }} OFF
                                </span>
                            </div>
                        </div>

                        <!-- Features -->
                        <ul class="space-y-4 mb-8">
                            @foreach([
                                'Unlimited Storage',
                                'Advanced Security',
                                '24/7 Premium Support',
                                'Free SSL Certificate',
                                '99.9% Uptime Guarantee',
                                'CDN Integration',
                                'Daily Backups',
                                'Priority Bandwidth'
                            ] as $featureIndex => $feature)
                            @if($featureIndex < ($index + 1) * 3)
                            <li class="flex items-center text-gray-300">
                                <i class="fas fa-check-circle text-neon-pink mr-3"></i>
                                {{ $feature }}
                            </li>
                            @endif
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        <button class="w-full {{ isset($package['featured']) ? 'bg-gradient-neon neon-shadow' : 'bg-gradient-to-r from-gray-700 to-gray-600 hover:from-neon-pink hover:to-neon-red' }} text-white py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 group-hover:shadow-2xl">
                            {{ isset($package['featured']) ? '🚀 GET STARTED NOW' : 'Choose Plan' }}
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>



  <!-- Products Showcase -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                FEATURED PRODUCTS
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Discover our premium products with exclusive special occasion pricing
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto" id="productsGrid">
            @foreach($products ?? [
                ['title' => 'VPS Hosting', 'price' => '$50', 'image' => null],
                ['title' => 'Dedicated Server', 'price' => '$200', 'image' => null],
                ['title' => 'Cloud Storage', 'price' => '$30', 'image' => null],
                ['title' => 'CDN Service', 'price' => '$80', 'image' => null],
                ['title' => 'SSL Certificates', 'price' => '$15', 'image' => null],
                ['title' => 'Email Hosting', 'price' => '$25', 'image' => null]
            ] as $index => $product)
            <div class="group">
                <div class="relative bg-gradient-to-br from-dark-card to-gray-900 rounded-2xl overflow-hidden glass-effect border border-gray-700 hover:border-neon-pink transition-all duration-300 hover:scale-105">
                    <!-- Product Image/Icon -->
                    <div class="h-32 bg-gradient-to-br from-neon-pink/10 to-purple-600/10 flex items-center justify-center">
                        <div class="text-4xl text-neon-pink">
                            <i class="fas fa-{{ ['hdd', 'server', 'cloud', 'globe', 'lock', 'envelope'][$index % 6] }}"></i>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-4">
                        <h3 class="text-lg font-bold font-orbitron mb-2">{{ $product['title'] ?? 'Premium Product' }}</h3>
                        <p class="text-gray-400 text-sm mb-3">Professional solution for your business</p>
                        
                        <!-- Price -->
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-neon-pink font-orbitron">{{ $product['price'] ?? '$99' }}/mo</span>
                            <button class="bg-gradient-to-r from-neon-pink to-purple-600 text-white px-3 py-1.5 rounded-full text-xs font-bold hover:scale-105 transition-all duration-300">
                                Order
                            </button>
                        </div>
                    </div>

                    <!-- Discount Corner -->
                    <div class="absolute top-3 right-3">
                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                            -{{ [30, 40, 50, 60, 70, 35][$index % 6] }}%
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

 <!-- Video Section -->
<section class="py-20 relative overflow-hidden bg-gradient-to-br from-gray-900 to-dark-card">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-900/10 to-pink-900/10"></div>
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-96 h-96 bg-neon-pink rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-600 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron  mb-4">
                SEE MAGIC IN ACTION
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Watch how our solutions transform businesses worldwide
            </p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="relative">
                <!-- Main Video Container -->
                <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-dark-card/80 to-gray-900/80 backdrop-blur-sm border border-gray-700/50 shadow-2xl">
                    <!-- Video Area -->
                    <div class="aspect-video bg-gradient-to-br from-gray-800 to-dark-card flex items-center justify-center relative overflow-hidden">
                        <!-- Animated Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-neon-pink/5 to-purple-600/5"></div>
                        
                        <!-- Grid Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="grid grid-cols-12 h-full">
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                                <div class="border-r border-gray-600/30"></div>
                            </div>
                        </div>
                        
                        <!-- Play Button -->
                        <button class="relative w-28 h-28 bg-gradient-to-br from-red-800 to-red-600 rounded-full flex items-center justify-center text-white text-3xl hover:scale-105 transition-all duration-300 shadow-xl">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-red-800 to-red-600 animate-pulse opacity-75"></div>
                            <i class="fas fa-play ml-1 relative z-10"></i>
                            <div class="absolute inset-0 rounded-full border-4 border-white/20"></div>
                        </button>
                        
                        <!-- Corner Decorations -->
                        <div class="absolute top-4 left-4 w-8 h-8 border-t-2 border-l-2 border-neon-pink/50"></div>
                        <div class="absolute top-4 right-4 w-8 h-8 border-t-2 border-r-2 border-neon-pink/50"></div>
                        <div class="absolute bottom-4 left-4 w-8 h-8 border-b-2 border-l-2 border-neon-pink/50"></div>
                        <div class="absolute bottom-4 right-4 w-8 h-8 border-b-2 border-r-2 border-neon-pink/50"></div>
                    </div>

                    <!-- Video Info Bar -->
                    <div class="bg-gradient-to-r from-dark-card to-gray-900 p-6 border-t border-gray-700/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold font-orbitron text-white mb-1">TKDS Solutions Overview</h3>
                                <p class="text-gray-400">Experience the future of hosting and streaming technology</p>
                            </div>
                    
                        </div>
                    </div>
                </div>
                
                <!-- Glow Effect -->
                <div class="absolute -inset-2 bg-gradient-to-br from-neon-pink/20 to-purple-600/20 rounded-3xl blur-xl opacity-50 -z-10"></div>
            </div>
            

        </div>
    </div>
</section>

<!-- Clients Slider -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron  mb-4">
                TRUSTED BY GIANTS
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Join thousands of satisfied clients who trust our solutions
            </p>
        </div>

        <!-- Infinite Scroll Clients -->
        <div class="overflow-hidden relative">
            <div class="flex animate-scroll-smooth">
                @foreach(range(1, 16) as $i)
                <div class="flex-shrink-0 mx-6">
                    <div class="w-28 h-28 bg-gradient-to-br from-dark-card to-gray-900 rounded-2xl glass-effect border border-gray-700 hover:border-neon-pink transition-all duration-300 flex items-center justify-center group hover:scale-110">
                        <!-- Company Logos -->
                        @if($i == 1)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Amazon_logo.svg/200px-Amazon_logo.svg.png" alt="Amazon" class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 2)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/200px-Google_2015_logo.svg.png" alt="Google" class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 3)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Microsoft_logo.svg/200px-Microsoft_logo.svg.png" alt="Microsoft" class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 4)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/80px-Apple_logo_black.svg.png" alt="Apple" class="w-12 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300 filter invert">
                        @elseif($i == 5)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Facebook_Logo_%282019%29.png/200px-Facebook_Logo_%282019%29.png" alt="Facebook" class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 6)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Logo_of_Twitter.svg/200px-Logo_of_Twitter.svg.png" alt="Twitter" class="w-12 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 7)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Netflix_icon.svg/200px-Netflix_icon.svg.png" alt="Netflix" class="w-12 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 8)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/LinkedIn_logo_initials.png/200px-LinkedIn_logo_initials.png" alt="LinkedIn" class="w-12 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 9)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1e/Spotify_logo_without_text.svg/200px-Spotify_logo_without_text.svg.png" alt="Spotify" class="w-12 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 10)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ab/YouTube_Logo_2005.svg/200px-YouTube_Logo_2005.svg.png" alt="YouTube" class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 11)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Paypal_2014_logo.png/200px-Paypal_2014_logo.png" alt="PayPal" class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 12)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/Instagram.svg/200px-Instagram.svg.png" alt="Instagram" class="w-12 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 13)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Telegram_logo.svg/200px-Telegram_logo.svg.png" alt="Telegram" class="w-12 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 14)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Coca-Cola_logo.svg/200px-Coca-Cola_logo.svg.png" alt="Coca Cola" class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @elseif($i == 15)
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Adidas_Logo.svg/200px-Adidas_Logo.svg.png" alt="Adidas" class="w-12 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300 filter invert">
                        @else
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/McDonald%27s_Golden_Arches.svg/200px-McDonald%27s_Golden_Arches.svg.png" alt="McDonald's" class="w-12 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300">
                        @endif
                    </div>
                </div>
                @endforeach
                
                <!-- Duplicate for seamless loop -->
                @foreach(range(1, 16) as $i)
                <div class="flex-shrink-0 mx-6">
                    <div class="w-28 h-28 bg-gradient-to-br from-dark-card to-gray-900 rounded-2xl glass-effect border border-gray-700 hover:border-neon-pink transition-all duration-300 flex items-center justify-center group hover:scale-110">
                        @if(in_array($i, [1, 2, 3, 4, 5, 6, 7, 8]))
                        <!-- Tech Company Icons -->
                        <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300">
                            <i class="fab fa-{{ ['apple', 'google', 'microsoft', 'amazon', 'facebook', 'twitter', 'youtube', 'linkedin'][($i-1) % 8] }}"></i>
                        </div>
                        @else
                        <!-- Custom Logos -->
                        <div class="text-center group-hover:text-neon-pink transition-all duration-300">
                            @if($i == 9)
                            <div class="text-gray-500 font-bold text-lg">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded mx-auto mb-1"></div>
                                <div class="text-xs">CloudTech</div>
                            </div>
                            @elseif($i == 10)
                            <div class="text-gray-500 font-bold text-lg">
                                <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-teal-600 rounded-full mx-auto mb-1"></div>
                                <div class="text-xs">StreamPro</div>
                            </div>
                            @elseif($i == 11)
                            <div class="text-gray-500 font-bold text-lg">
                                <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-pink-600 rounded mx-auto mb-1 transform rotate-45"></div>
                                <div class="text-xs">DataFlow</div>
                            </div>
                            @elseif($i == 12)
                            <div class="text-gray-500 font-bold text-lg">
                                <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full mx-auto mb-1"></div>
                                <div class="text-xs">TechCore</div>
                            </div>
                            @elseif($i == 13)
                            <div class="text-gray-500 font-bold text-lg">
                                <div class="flex space-x-1 justify-center mb-1">
                                    <div class="w-2 h-6 bg-gradient-to-t from-cyan-500 to-blue-600 rounded"></div>
                                    <div class="w-2 h-4 bg-gradient-to-t from-cyan-500 to-blue-600 rounded mt-2"></div>
                                    <div class="w-2 h-6 bg-gradient-to-t from-cyan-500 to-blue-600 rounded"></div>
                                </div>
                                <div class="text-xs">WebHost</div>
                            </div>
                            @elseif($i == 14)
                            <div class="text-gray-500 font-bold text-lg">
                                <div class="w-8 h-8 border-2 border-purple-500 rounded mx-auto mb-1 flex items-center justify-center">
                                    <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                </div>
                                <div class="text-xs">NetSync</div>
                            </div>
                            @elseif($i == 15)
                            <div class="text-gray-500 font-bold text-lg">
                                <div class="relative w-8 h-8 mx-auto mb-1">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 rounded transform rotate-12"></div>
                                    <div class="absolute inset-1 bg-dark-card rounded"></div>
                                </div>
                                <div class="text-xs">CodeLab</div>
                            </div>
                            @else
                            <div class="text-gray-500 font-bold text-lg">
                                <div class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-cyan-600 rounded-full mx-auto mb-1 flex items-center justify-center">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <div class="text-xs">HostMax</div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>


</section>

<!-- Customer Reviews Section -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-dark-bg via-purple-900/10 to-dark-bg"></div>
    
    <!-- Floating Background Elements -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-neon-pink/10 rounded-full blur-2xl animate-float"></div>
    <div class="absolute bottom-20 right-10 w-48 h-48 bg-purple-600/10 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>
    <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-neon-pink/5 rounded-full blur-xl animate-pulse"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron text-gradient mb-4">
                WHAT CLIENTS SAY
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Real experiences from real customers who transformed their business with us
            </p>
        </div>

        <!-- Creative 3D Reviews Slider -->
        <div class="relative max-w-7xl mx-auto">
            <!-- Main Slider Container -->
            <div class="reviews-slider-container relative h-96 perspective-2000" id="reviewsSlider">
                <div class="slider-track absolute w-full h-full flex items-center justify-center">
                    
                    <!-- Review Card 1 -->
                    <div class="review-slide active" data-index="0">
                        <div class="review-card">
                            <div class="card-glow"></div>
                            <div class="quote-decoration">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="review-text">
                                "Outstanding service! TKDS transformed our entire infrastructure. The 99.9% uptime is not just a promise, it's reality."
                            </p>
                            <div class="reviewer-info">
                                <div class="avatar">S</div>
                                <div class="details">
                                    <h4>Sarah Johnson</h4>
                                    <span>CEO, TechStart Inc</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Card 2 -->
                    <div class="review-slide next" data-index="1">
                        <div class="review-card">
                            <div class="card-glow"></div>
                            <div class="quote-decoration">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="review-text">
                                "Best investment we ever made. Their support team is incredible and response times are lightning fast."
                            </p>
                            <div class="reviewer-info">
                                <div class="avatar">M</div>
                                <div class="details">
                                    <h4>Michael Chen</h4>
                                    <span>CTO, CloudVision</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Card 3 -->
                    <div class="review-slide far-right" data-index="2">
                        <div class="review-card">
                            <div class="card-glow"></div>
                            <div class="quote-decoration">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="review-text">
                                "TKDS made our streaming platform possible. Scalable, reliable, and cost-effective solutions."
                            </p>
                            <div class="reviewer-info">
                                <div class="avatar">E</div>
                                <div class="details">
                                    <h4>Emma Rodriguez</h4>
                                    <span>Founder, StreamPro</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Card 4 -->
                    <div class="review-slide far-left" data-index="3">
                        <div class="review-card">
                            <div class="card-glow"></div>
                            <div class="quote-decoration">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="review-text">
                                "Professional setup, amazing performance, and pricing that fits any budget. Highly recommended!"
                            </p>
                            <div class="reviewer-info">
                                <div class="avatar">D</div>
                                <div class="details">
                                    <h4>David Kim</h4>
                                    <span>DevOps Lead</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Card 5 -->
                    <div class="review-slide prev" data-index="4">
                        <div class="review-card">
                            <div class="card-glow"></div>
                            <div class="quote-decoration">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="review-text">
                                "Security features are top-notch. We sleep peacefully knowing our data is in safe hands."
                            </p>
                            <div class="reviewer-info">
                                <div class="avatar">L</div>
                                <div class="details">
                                    <h4>Lisa Thompson</h4>
                                    <span>IT Director</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Card 6 -->
                    <div class="review-slide hidden" data-index="5">
                        <div class="review-card">
                            <div class="card-glow"></div>
                            <div class="quote-decoration">
                                <i class="fas fa-quote-left"></i>
                            </div>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="review-text">
                                "Migration was seamless. Zero downtime and exceptional support throughout the entire process."
                            </p>
                            <div class="reviewer-info">
                                <div class="avatar">A</div>
                                <div class="details">
                                    <h4>Ahmed Ali</h4>
                                    <span>System Admin</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Navigation Arrows -->
            <button class="slider-nav prev-btn" id="prevBtn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-nav next-btn" id="nextBtn">
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Progress Dots -->
            <div class="slider-dots" id="sliderDots">
                <div class="dot active" data-index="0"></div>
                <div class="dot" data-index="1"></div>
                <div class="dot" data-index="2"></div>
                <div class="dot" data-index="3"></div>
                <div class="dot" data-index="4"></div>
                <div class="dot" data-index="5"></div>
            </div>
        </div>
    </div>
<script>
  (function() {
            let currentReviewSlide = 0;
            const totalReviewSlides = 6;
            let reviewAutoSlideInterval;
            
            const slidePositions = ['far-left', 'prev', 'active', 'next', 'far-right', 'hidden'];

            function updateReviewSlides() {
                const slides = document.querySelectorAll('#reviewsSlider .review-slide');
                const dots = document.querySelectorAll('#sliderDots .dot');

                slides.forEach((slide, index) => {
                    slidePositions.forEach(pos => slide.classList.remove(pos));
                    
                    let position = index - currentReviewSlide;
                    
                    if (position < -2) position += totalReviewSlides;
                    if (position > 2) position -= totalReviewSlides;
                    
                    switch(position) {
                        case -2: slide.classList.add('far-left'); break;
                        case -1: slide.classList.add('prev'); break;
                        case 0: slide.classList.add('active'); break;
                        case 1: slide.classList.add('next'); break;
                        case 2: slide.classList.add('far-right'); break;
                        default: slide.classList.add('hidden'); break;
                    }
                });

                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentReviewSlide);
                });
            }

            function slideReviews(direction) {
                if (direction === 'next') {
                    currentReviewSlide = (currentReviewSlide + 1) % totalReviewSlides;
                } else {
                    currentReviewSlide = (currentReviewSlide - 1 + totalReviewSlides) % totalReviewSlides;
                }
                updateReviewSlides();
                resetAutoSlide();
            }

            function slideToReview(index) {
                currentReviewSlide = index;
                updateReviewSlides();
                resetAutoSlide();
            }

            function startAutoSlide() {
                reviewAutoSlideInterval = setInterval(() => {
                    slideReviews('next');
                }, 4000);
            }

            function stopAutoSlide() {
                if (reviewAutoSlideInterval) {
                    clearInterval(reviewAutoSlideInterval);
                }
            }

            function resetAutoSlide() {
                stopAutoSlide();
                setTimeout(startAutoSlide, 3000);
            }

            // Initialize when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                // Check if elements exist before adding listeners
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                const dots = document.querySelectorAll('#sliderDots .dot');
                const slides = document.querySelectorAll('#reviewsSlider .review-slide');
                const reviewSlider = document.getElementById('reviewsSlider');

                if (prevBtn) {
                    prevBtn.addEventListener('click', function() {
                        slideReviews('prev');
                    });
                }
                
                if (nextBtn) {
                    nextBtn.addEventListener('click', function() {
                        slideReviews('next');
                    });
                }
                
                dots.forEach(function(dot, index) {
                    dot.addEventListener('click', function() {
                        slideToReview(index);
                    });
                });

                slides.forEach((slide, index) => {
                    slide.addEventListener('click', function() {
                        if (!this.classList.contains('active')) {
                            slideToReview(index);
                        }
                    });
                });

                if (reviewSlider) {
                    reviewSlider.addEventListener('mouseenter', stopAutoSlide);
                    reviewSlider.addEventListener('mouseleave', startAutoSlide);
                }

                updateReviewSlides();
                startAutoSlide();
            });

            // Touch support
            let startX = 0;
            let endX = 0;

            document.addEventListener('DOMContentLoaded', function() {
                const reviewSlider = document.getElementById('reviewsSlider');
                if (reviewSlider) {
                    reviewSlider.addEventListener('touchstart', function(e) {
                        startX = e.touches[0].clientX;
                    });

                    reviewSlider.addEventListener('touchend', function(e) {
                        endX = e.changedTouches[0].clientX;
                        const threshold = 80;
                        const diff = startX - endX;
                        
                        if (Math.abs(diff) > threshold) {
                            if (diff > 0) {
                                slideReviews('next');
                            } else {
                                slideReviews('prev');
                            }
                        }
                    });
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft') {
                    slideReviews('prev');
                } else if (e.key === 'ArrowRight') {
                    slideReviews('next');
                }
            });

        })();
</script>
</section>


    <!-- Contact Form Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 to-pink-900/20"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                        GET YOUR DISCOUNT NOW
                    </h2>
                    <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                        Don't miss out on this limited-time offer. Contact us today and save big!
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Contact Info -->
                    <div class="space-y-8">
                        <div class="group">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-neon rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300">
                                    <i class="fab fa-whatsapp text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">WhatsApp Support</h3>
                                    <p class="text-gray-300">Instant responses for urgent inquiries</p>
                                    <a href="https://wa.me/+1234567890" class="text-neon-pink hover:text-neon-red transition-colors">+1 (234) 567-890</a>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-neon rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300">
                                    <i class="fas fa-envelope text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">Email Support</h3>
                                    <p class="text-gray-300">Professional assistance via email</p>
                                    <a href="mailto:support@tkds.com" class="text-neon-pink hover:text-neon-red transition-colors">support@tkds.com</a>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-neon rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300">
                                    <i class="fas fa-clock text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">Available 24/7</h3>
                                    <p class="text-gray-300">Round-the-clock support</p>
                                    <span class="text-neon-pink">Always online for you</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="glass-effect rounded-3xl p-8 border border-neon-pink/30 hover:border-neon-pink/60 transition-all duration-300">
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <input type="text" placeholder="Your Name" class="w-full bg-dark-card border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-neon-pink focus:outline-none transition-colors">
                                </div>
                                <div>
                                    <input type="email" placeholder="Email Address" class="w-full bg-dark-card border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-neon-pink focus:outline-none transition-colors">
                                </div>
                            </div>
                            
                            <div>
                                <input type="tel" placeholder="Phone Number" class="w-full bg-dark-card border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-neon-pink focus:outline-none transition-colors">
                            </div>
                            
                            <div>
                                <select class="w-full bg-dark-card border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-neon-pink focus:outline-none transition-colors">
                                    <option value="">Select Service</option>
                                    <option value="hosting">Web Hosting</option>
                                    <option value="vps">VPS Hosting</option>
                                    <option value="dedicated">Dedicated Servers</option>
                                    <option value="streaming">Streaming Services</option>
                                    <option value="other">Other Services</option>
                                </select>
                            </div>
                            
                            <div>
                                <textarea placeholder="Tell us about your needs..." rows="4" class="w-full bg-dark-card border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-neon-pink focus:outline-none transition-colors resize-none"></textarea>
                            </div>
                            
                            <button type="submit" class="w-full bg-gradient-neon text-white py-4 rounded-xl font-bold text-lg hover:scale-105 transition-all duration-300 neon-shadow">
                                <i class="fas fa-paper-plane mr-2"></i>CLAIM MY DISCOUNT
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


<!-- Footer -->
<footer class="relative bg-gradient-to-br from-dark-card via-gray-900 to-black py-16 border-t border-gray-800/50 overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0">
        <!-- Grid Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="grid grid-cols-12 h-full">
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
                <div class="border-r border-white/5"></div>
            </div>
        </div>
        
        <!-- Floating Orbs -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-gradient-to-r from-neon-pink/20 via-pink-500/10 to-purple-600/20 rounded-full blur-3xl opacity-40 animate-float-slow"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-gradient-to-br from-purple-600/15 to-neon-pink/15 rounded-full blur-3xl opacity-30 animate-float" style="animation-delay: -2s;"></div>
        <div class="absolute top-1/2 left-1/4 w-48 h-48 bg-gradient-to-r from-neon-pink/10 to-purple-400/10 rounded-full blur-2xl opacity-20 animate-pulse-glow"></div>
    </div>

    <div class="container mx-auto max-w-7xl px-6 relative z-10">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-8 lg:gap-16 items-center mb-16">
            <!-- Logo & Brand -->
            <div class="text-center md:text-left">
                <div class="inline-flex items-center mb-6 p-6 bg-gradient-to-br from-dark-card/50 to-gray-900/50 backdrop-blur-sm rounded-3xl border border-gray-700/50 shadow-2xl hover:shadow-neon-pink transition-all duration-300 group">
                    <div class="tv-startup-logo font-bebas text-4xl lg:text-5xl mr-4 group-hover:scale-110 transition-transform">
                        TKDS
                    </div>
                    <div class="text-sm font-normal text-gray-300 font-oswald tracking-wider leading-tight">
                        SHAPING THE<br>
                        <span class="text-neon-pink font-bold">WORLD</span>
                    </div>
                </div>
            </div>

            <!-- Marketing Message -->
            <div class="text-center ">
                <div class="p-8 bg-dark-card/40 backdrop-blur-md rounded-3xl border border-gray-700/30 shadow-xl hover:shadow-2xl hover:border-neon-pink/40 transition-all duration-500">
                    <h3 class="text-xl  font-black font-orbitron mb-4 bg-gradient-to-r from-white to-gray-200 bg-clip-text text-transparent drop-shadow-lg">
                        FUTURE OF
                    </h3>
                    <h3 class="text-md  font-black font-bebas text-gradient-red mb-6 tracking-wider">
                        STREAMING
                    </h3>
                    <p class="text-lg text-gray-300 leading-relaxed max-w-md mx-auto md:mx-0">
                        Enterprise-grade hosting & live streaming solutions trusted worldwide
                    </p>
                </div>
            </div>

            <!-- CTA & Discount -->
            <div class="text-center">
                <div class="relative">
                    <!-- Discount Badge -->
                    <div class="inline-block p-8 bg-gradient-to-br from-red-600/90 to-red-500/90 backdrop-blur-md rounded-3xl border-2 border-red-500/50 shadow-2xl hover:shadow-red-600/50 hover:scale-105 transition-all duration-300 mb-6 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-600/20 to-red-500/20 animate-pulse opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <div class="text-6xl lg:text-7xl font-black font-orbitron text-white mb-2 drop-shadow-2xl leading-none">
                                80<span class="text-4xl">%</span>
                            </div>
                            <div class="text-sm uppercase tracking-wider text-red-200 font-oswald font-bold">OFF</div>
                            <div class="text-xs text-red-300 uppercase tracking-widest font-bold mt-2 opacity-75">LIMITED TIME</div>
                        </div>
                    </div>
                    
           
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-800/50 pt-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Social Links -->
                <div class="flex space-x-6">
                    <a href="#" class="w-12 h-12 bg-dark-card/50 backdrop-blur-sm rounded-2xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-neon hover:shadow-neon-pink transition-all duration-300 border border-gray-700/50 hover:border-neon-pink/50">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-dark-card/50 backdrop-blur-sm rounded-2xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-neon hover:shadow-neon-pink transition-all duration-300 border border-gray-700/50 hover:border-neon-pink/50">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-dark-card/50 backdrop-blur-sm rounded-2xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-neon hover:shadow-neon-pink transition-all duration-300 border border-gray-700/50 hover:border-neon-pink/50">
                        <i class="fab fa-youtube text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-dark-card/50 backdrop-blur-sm rounded-2xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-neon hover:shadow-neon-pink transition-all duration-300 border border-gray-700/50 hover:border-neon-pink/50">
                        <i class="fas fa-phone text-xl"></i>
                    </a>
                </div>

                <!-- Copyright -->
                <div class="text-center md:text-right">
                    <p class="text-gray-400 text-sm font-oswald tracking-wider">
                        &copy; 2025 <span class="font-bold text-white">TKDS Servers</span>. All rights reserved.
                    </p>
                    <p class="text-xs text-gray-500 mt-1 font-oswald tracking-widest opacity-75">
                        POWERED BY INNOVATION
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>


</body>
</html>