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

@php
    $activeSections = $activeSections ?? $page->getActiveSectionsAttribute();
@endphp
{{-- Loop through active sections in order --}}
@foreach($activeSections as $sectionKey)
    @switch($sectionKey)

     @case('header')
     @if($page->hasActiveSection('header'))
<!-- Header -->
<header class="absolute top-0 w-full z-50 p-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <div class="flex items-center space-x-3">
            @if(!empty($page->header_logo_image))
                <img src="{{ asset('storage/'.$page->header_logo_image) }}"
                     alt="{{ $page->header_logo_text ?? 'TKDS' }}"
                     class="h-10 w-auto">
            @else
                <div class="tv-startup-logo font-bebas">
                    {{ $page->header_logo_text ?? 'TKDS' }}
                    <div class="text-sm font-normal text-gray-300 font-oswald">
                        {{ $page->header_logo_subtitle ?? 'SHAPING THE WORLD' }}
                    </div>
                </div>
            @endif
        </div>

        @if($page->header_button_text || $page->header_phone)
            <a href="tel:{{ $page->header_phone ?? '+13252680040' }}"
               class="call-sales-btn inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-800 to-gray-700 hover:from-gray-700 hover:to-gray-600 text-white font-semibold font-oswald text-sm uppercase tracking-wider rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-600 hover:border-gray-500 backdrop-blur-sm">
                {{ $page->header_button_text ?? 'CALL SALES' }}
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </a>
        @endif

    </div>
</header>
   @endif
 @break

 @case('hero')
@if($page->hasActiveSection('hero'))
<!-- Hero Section -->
<section class="relative min-h-[80vh] flex items-center justify-center overflow-hidden">
 
    <div class="absolute inset-0">
        <div class="absolute inset-0 opacity-20 grid-pattern"></div>

        <div class="absolute bottom-0 w-full">
            <div class="wave-pattern"></div>
            <div class="wave-pattern"></div>
            <div class="wave-pattern"></div>
        </div>

        <div class="floating-dots" style="top: 20%; left: 10%;"></div>
        <div class="floating-dots large" style="top: 60%; left: 15%; animation-delay: -2s;"></div>
        <div class="floating-dots" style="top: 30%; left: 80%;"></div>
        <div class="floating-dots large" style="top: 70%; left: 85%; animation-delay: -1.5s;"></div>
        <div class="floating-dots" style="top: 15%; left: 70%; animation-delay: -0.5s;"></div>
        <div class="floating-dots" style="top: 80%; left: 20%; animation-delay: -2.5s;"></div>
    </div>

    @if($page->discount_percentage)
        <!-- Discount Wave Badge (Right Side) -->
        <div class="absolute top-1/4 right-8 md:right-16">
            <div class="wave-badge">
                <div class="text-center text-white font-bebas">
                    <div class="text-sm">UP TO</div>
                    <div class="text-3xl font-black">{{ $page->discount_percentage }}%</div>
                    <div class="text-sm">OFF</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Content -->
    <div class="relative z-10 text-center px-6 max-w-6xl mx-auto">
        <!-- Main Title -->
        <h1 class="text-4xl mt-24 md:mt-0 md:text-6xl lg:text-7xl font-black font-anton mb-6 slide-in-left leading-tight">
            <span class="text-white" style="text-stroke: 2px transparent;">
                {{ $page->hero_title_part1 ?? 'BLACK' }}
            </span>
            <span class="text-gradient-red italic font-bebas" style="font-style: italic; position: relative;">
                {{ $page->hero_title_part2 ?? 'Sale' }}
            </span><br>
            <span class="text-white text-5xl md:text-7xl lg:text-8xl">
                {{ $page->hero_title_part3 ?? 'FRIDAY' }}
            </span>
        </h1>

        <!-- Subtitle -->
        <div class="text-2xl md:text-4xl font-bold text-white md:text-gradient-red mb-4 slide-in-right font-bebas tracking-wider">
            {{ $page->hero_subtitle ?? 'Expand Your TV Network' }}
        </div>
        <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-2xl mx-auto slide-in-right font-oswald">
            {{ $page->hero_description ?? 'To Additional Platforms' }}
        </p>

        <!-- Countdown Timer -->
        <div id="countdown-root"
             data-countdown-target="{{ $countdownTarget ?? '' }}"
             class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-12">
            <div class="glass-effect rounded-2xl p-4 text-center scale-hover">
                <div class="text-3xl md:text-4xl font-bold text-white font-bebas tracking-wider" id="days">00</div>
                <div class="text-xs text-gray-300 uppercase tracking-wider font-oswald">DAYS</div>
            </div>
            <div class="glass-effect rounded-2xl p-4 text-center scale-hover">
                <div class="text-3xl md:text-4xl font-bold text-white font-bebas tracking-wider" id="hours">00</div>
                <div class="text-xs text-gray-300 uppercase tracking-wider font-oswald">HOURS</div>
            </div>
            <div class="glass-effect rounded-2xl p-4 text-center scale-hover">
                <div class="text-3xl md:text-4xl font-bold text-white font-bebas tracking-wider" id="minutes">00</div>
                <div class="text-xs text-gray-300 uppercase tracking-wider font-oswald">MINUTES</div>
            </div>
            <div class="glass-effect rounded-2xl p-4 text-center scale-hover">
                <div class="text-3xl md:text-4xl font-bold text-white font-bebas tracking-wider" id="seconds">00</div>
                <div class="text-xs text-gray-300 uppercase tracking-wider font-oswald">SECONDS</div>
            </div>
        </div>

        <!-- CTA Button -->
        @if($page->hero_button_text)
            <a href="{{ $page->hero_button_url ?: '#contact' }}"
               class="bg-gradient-to-r from-red-600 to-red-700 text-white px-12 py-4 rounded-full text-lg md:text-xl font-bold hover:scale-110 transition-all duration-300 neon-shadow-red animate-pulse-glow font-oswald inline-flex items-center justify-center">
                <i class="fas fa-tv mr-3"></i>{{ $page->hero_button_text }}
            </a>
        @endif
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-2xl text-red-500"></i>
    </div>
</section>

  @endif
 @break

  @case('why_choose')
@if($page->hasActiveSection('why_choose'))
<!-- Why Choose Us Section -->
<section class="py-20 relative overflow-hidden min-h-screen">
    <!-- Full Width Background Image -->
    <div class="absolute inset-0 w-screen -left-6 -right-6 md:-left-12 md:-right-12">
        <img 
            src="{{ $page->why_choose_background_image 
                    ? asset('storage/'.$page->why_choose_background_image) 
                    : 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&auto=format&fit=crop&w=2500&q=80' }}" 
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-7xl mx-auto min-h-screen">
            <!-- Left Image Column -->
            <div class="relative group">
                <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-dark-card/90 to-gray-900/90 backdrop-blur-md border border-gray-700/70 shadow-2xl h-[500px] lg:h-[600px]">
                    <img 
                        src="{{ $page->why_choose_left_image
                                ? asset('storage/'.$page->why_choose_left_image)
                                : 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" 
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
                    {{ $page->why_choose_title ?? 'WHY CHOOSE' }}
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-neon-pink via-pink-400 to-purple-500">
                        {{ $page->why_choose_subtitle ?? 'TKDS' }}
                    </span>
                </h2>
                <div class="text-2xl md:text-3xl font-bold text-gradient-red mb-8 font-bebas tracking-wider drop-shadow-lg">
                    {{ $page->why_choose_description ?? 'UNMATCHED EXCELLENCE' }}
                </div>
                
                <ul class="space-y-6 mb-12">
                    @php $cards = $whyCards ?? []; @endphp

                    @forelse($cards as $card)
                        <li class="group flex items-start space-x-4 p-4 bg-dark-card/50 rounded-xl border border-gray-700/50 hover:border-neon-pink/50 transition-all duration-300 hover:bg-dark-card/70 hover:translate-x-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 mt-1 group-hover:scale-110 transition-all duration-300 shadow-lg"
                                 style="background-image: linear-gradient(to right, {{ $card['color_from'] ?? '#ec4899' }}, {{ $card['color_to'] ?? '#8b5cf6' }});">
                                @if(!empty($card['icon']))
                                    <i class="{{ $card['icon'] }} text-xl text-white"></i>
                                @else
                                    <i class="fas fa-check text-xl text-white"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-xl font-bold font-orbitron text-white mb-2 group-hover:text-neon-pink transition-colors">
                                    {{ $card['title'] ?? '' }}
                                </h4>
                                <p class="text-gray-300 leading-relaxed">
                                    {{ $card['description'] ?? '' }}
                                </p>
                            </div>
                        </li>
                    @empty
                        {{-- لو مفيش كروت في الداتابيز، نعرض الأربع كروت الافتراضية اللي عندك --}}
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
                                <p class="text-gray-300 leading-relaxed">Military-grade encryption &amp; AI-powered threat protection 24/7</p>
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
                    @endforelse
                </ul>
                
                @if($page->why_choose_button_text)
                    <a href="{{ $page->why_choose_button_url ?: '#contact' }}"
                       class="bg-gradient-to-r from-neon-pink to-purple-600 text-white px-8 py-4 rounded-2xl font-bold text-lg inline-flex items-center hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-neon-pink backdrop-blur-sm border border-neon-pink/50 hover:border-neon-pink">
                        <i class="fas fa-arrow-right mr-3"></i>
                        {{ $page->why_choose_button_text }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

  @endif
 @break


 @case('services')
 @if($page->hasActiveSection('services') && $services && $services->count() > 0)
        
<!-- Services Slider Section -->
<section class="services-section">
    <div class="container">
        <div class="section-title">
            <h2 class="font-orbitron">
                {{ $page->services_title ?? 'PREMIUM SERVICES' }}
            </h2>
            <p>
                {{ $page->services_subtitle ?? 'Experience cutting-edge technology with our professional solutions' }}
            </p>
        </div>

        <!-- Services 3D Slider -->
        <div class="slider-container">
            <div class="slider-wrapper" id="sliderWrapper">
            @php
    $bgUrl = 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80';
@endphp


                @foreach($services as $index => $service)
                    <div class="slide {{ $index === 0 ? 'active' : ($index === 1 ? 'next' : ($index === 2 ? 'far-right' : ($index === count($services)-1 ? 'prev' : 'far-left'))) }}"
                         data-index="{{ $index }}">
                        <div class="slide-card relative overflow-hidden">
                            <!-- Background image fills card -->
                            <div class="absolute inset-0">
                                <div class="w-full h-full bg-center bg-cover"
                                     style="background-image: url('{{ $bgUrl }}');"></div>
                                <div class="absolute inset-0 bg-black/60"></div>
                            </div>

                            <div class="relative z-10">
                                <div class="glowing-orb"></div>

                                <div class="service-icon">
                                    @if(!empty($service->icon))
                                        <i class="{{ $service->icon }}"></i>
                                    @else
                                        <i class="fas fa-server"></i>
                                    @endif
                                </div>

                                <h3 class="service-title font-orbitron">
                                    {{ $service->title }}
                                </h3>
                                <p class="service-description">
                                    {{ $service->short_description ?? \Illuminate\Support\Str::limit($service->description, 180) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <button class="nav-button prev" type="button">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="nav-button next" type="button">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <!-- Dots Indicator -->
        <div class="dots-indicator" id="dotsIndicator">
            @foreach($services as $index => $service)
                <div class="dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
            @endforeach
        </div>

        <!-- Global CTA under slider -->
        <div class="mt-10 flex justify-center">
            <a href="{{ route('services') }}"
               class="inline-flex items-center px-8 py-3 rounded-full bg-gradient-to-r from-neon-pink to-purple-600 text-white font-semibold text-sm md:text-base shadow-lg hover:shadow-neon-pink transition-all duration-300 hover:scale-105 border border-neon-pink/60">
                <i class="fas fa-layer-group mr-2"></i>
                View More Available Services
            </a>
        </div>
    </div>
</section>

  @endif
 @break

<script>
document.addEventListener('DOMContentLoaded', function () {
    const section   = document.querySelector('.services-section');
    if (!section) return;

    const slides    = section.querySelectorAll('.slide');
    const dots      = section.querySelectorAll('.dot');
    const prevBtn   = section.querySelector('.nav-button.prev');
    const nextBtn   = section.querySelector('.nav-button.next');
    const totalSlides = slides.length;

    if (!totalSlides) return;

    let currentSlide = 0;
    let autoRotateInterval = null;
    const slideClasses = ['far-left', 'prev', 'active', 'next', 'far-right'];
    const AUTO_INTERVAL = 7000; // 7 seconds

    function updateSlides() {
        slides.forEach((slide, index) => {
            slideClasses.forEach(c => slide.classList.remove(c));

            let position = index - currentSlide;
            if (position < -2) position += totalSlides;
            if (position >  2) position -= totalSlides;

            switch (position) {
                case -2: slide.classList.add('far-left');  break;
                case -1: slide.classList.add('prev');      break;
                case 0:  slide.classList.add('active');    break;
                case 1:  slide.classList.add('next');      break;
                case 2:  slide.classList.add('far-right'); break;
            }
        });

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
        if (index < 0 || index >= totalSlides) return;
        currentSlide = index;
        updateSlides();
        resetAutoRotate();
    }

    function startAutoRotate() {
        if (totalSlides <= 1 || autoRotateInterval) return;
        autoRotateInterval = setInterval(() => {
            slideServices('next');
        }, AUTO_INTERVAL);
    }

    function stopAutoRotate() {
        if (!autoRotateInterval) return;
        clearInterval(autoRotateInterval);
        autoRotateInterval = null;
    }

    function resetAutoRotate() {
        stopAutoRotate();
        startAutoRotate();
    }

    if (prevBtn) prevBtn.addEventListener('click', () => slideServices('prev'));
    if (nextBtn) nextBtn.addEventListener('click', () => slideServices('next'));

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.dataset.index, 10);
            slideToService(index);
        });
    });

    slides.forEach((slide, index) => {
        slide.addEventListener('click', function () {
            if (!this.classList.contains('active')) {
                slideToService(index);
            }
        });
    });

    const sliderContainer = section.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopAutoRotate);
        sliderContainer.addEventListener('mouseleave', startAutoRotate);

        let startX = 0;
        let endX   = 0;
        sliderContainer.addEventListener('touchstart', function (e) {
            startX = e.touches[0].clientX;
        });
        sliderContainer.addEventListener('touchend', function (e) {
            endX = e.changedTouches[0].clientX;
            const threshold = 50;
            const diff = startX - endX;
            if (Math.abs(diff) > threshold) {
                if (diff > 0) slideServices('next');
                else slideServices('prev');
            }
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft')  slideServices('prev');
        if (e.key === 'ArrowRight') slideServices('next');
    });

    // init
    updateSlides();
    startAutoRotate();
});
</script>




  <!-- Packages Section -->
{{-- <section class="py-20 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-900/10 to-pink-900/10"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                {{ $page->packages_title ?? 'EXPLOSIVE PACKAGES' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->packages_subtitle ?? 'Discover our premium packages with special occasion pricing' }}
            </p>
        </div>
  @include('components.pricing-section')
    </div>
</section> --}}



  @case('products')
        @if($page->hasActiveSection('products') && $products && $products->count() > 0)
<!-- Products Showcase -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                {{ $page->products_title ?? 'FEATURED PRODUCTS' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->products_subtitle ?? 'Discover our premium products with exclusive special occasion pricing' }}
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto" id="productsGrid">
            @foreach($products as $index => $product)
                <div class="group">
                    <div class="relative bg-gradient-to-br from-dark-card to-gray-900 rounded-2xl overflow-hidden glass-effect border border-gray-700 hover:border-neon-pink transition-all duration-300 hover:scale-105">
                        <!-- Product Image/Icon -->
                        <div class="h-32 bg-gradient-to-br from-neon-pink/10 to-purple-600/10 flex items-center justify-center">
                            @if(!empty($product->image))
                                <img src="{{ asset('storage/'.$product->image) }}"
                                     alt="{{ $product->title ?? $product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="text-4xl text-neon-pink">
                                    <i class="fas fa-{{ ['hdd', 'server', 'cloud', 'globe', 'lock', 'envelope'][$index % 6] }}"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="text-lg font-bold font-orbitron mb-2">
                                {{ $product->title ?? $product->name }}
                            </h3>
                            <p class="text-gray-400 text-sm mb-3">
                                {{ $product->short_description ?? 'Professional solution for your business' }}
                            </p>
                            
                            <!-- Price + Order -->
                            <div class="flex justify-between items-center">
                                @if($product->price)
                                    <span class="text-xl font-bold text-neon-pink font-orbitron">
                                        {{ number_format($product->price, 2) }} /mo
                                    </span>
                                @else
                                    <span></span>
                                @endif

                                <a href="{{ route('shop.product', $product->slug ?? $product->id) }}"
                                   class="bg-gradient-to-r from-neon-pink to-purple-600 text-white px-3 py-1.5 rounded-full text-xs font-bold hover:scale-105 transition-all duration-300">
                                    Order
                                </a>
                            </div>
                        </div>

                        <!-- تم إزالة خصم الكورنر -->
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

  @endif
 @break

  @case('video')
@if($page->hasActiveSection('video'))
<!-- Video Section -->
<section class="py-20 relative overflow-hidden" 
         style="background-image: url('https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2500&q=80
'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-black/60 to-gray-900/90"></div>
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-96 h-96 bg-neon-pink rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-600 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                {{ $page->video_title ?? 'SEE MAGIC IN ACTION' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->video_subtitle ?? 'Watch how our solutions transform businesses worldwide' }}
            </p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="relative group">
                <!-- Main Video Container -->
                <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-dark-card/90 to-gray-900/90 backdrop-blur-md border border-gray-700/50 shadow-2xl" id="videoContainer">
                    <!-- Video Area -->
                    <div class="aspect-video relative overflow-hidden" id="videoArea">
                        @if($page->video_url)
                            @php
                                $isYoutube = str_contains($page->video_url, 'youtube.com') || str_contains($page->video_url, 'youtu.be');
                                $isVimeo = str_contains($page->video_url, 'vimeo.com');
                                $isEmbed = $isYoutube || $isVimeo;
                            @endphp

                            @if($isEmbed)
                                {{-- YouTube/Vimeo iframe --}}
                                <iframe id="videoIframe" 
                                        src="{{ $page->video_url }}?enablejsapi=1&controls=0&rel=0&modestbranding=1&showinfo=0"
                                        class="w-full h-full"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            @else
                                {{-- Native MP4 video with custom controls --}}
                                <video id="videoPlayer" 
                                       class="w-full h-full object-cover" 
                                       poster="{{ $page->video_thumbnail ? asset('storage/'.$page->video_thumbnail) : 'https://media.istockphoto.com/id/1041174316/photo/european-telecommunication-network-connected-over-europe-france-germany-uk-italy-concept.webp?a=1&b=1&s=612x612&w=0&k=20&c=elHHTOV7XD6d4QpDljTBsUabpbCHudVhv9xXaj6UBnM=' }}"
                                       preload="metadata">
                                    <source src="{{ $page->video_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @else
                            {{-- Placeholder with background --}}
                            <div class="w-full h-full bg-gradient-to-br from-gray-800/50 to-dark-card/50 flex items-center justify-center relative overflow-hidden"
                                 style="background-image: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'); background-size: cover; background-position: center;">
                                <div class="absolute inset-0 bg-gradient-to-br from-neon-pink/20 to-purple-600/20"></div>
                                <div class="absolute inset-0 opacity-30">
                                    <div class="grid grid-cols-12 h-full">
                                        <div class="border-r border-white/30"></div><div class="border-r border-white/30"></div>
                                        <div class="border-r border-white/30"></div><div class="border-r border-white/30"></div>
                                        <div class="border-r border-white/30"></div><div class="border-r border-white/30"></div>
                                        <div class="border-r border-white/30"></div><div class="border-r border-white/30"></div>
                                        <div class="border-r border-white/30"></div><div class="border-r border-white/30"></div>
                                        <div class="border-r border-white/30"></div>
                                    </div>
                                </div>
                                <div class="text-6xl text-neon-pink animate-pulse relative z-10">
                                    <i class="fas fa-video"></i>
                                </div>
                            </div>
                        @endif

                        <!-- Video Controls Overlay -->
                        <div class="absolute inset-0 flex flex-col bg-black/30 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none group-hover:pointer-events-auto" id="videoControls">
                            <!-- Top Controls -->
                            <div class="flex justify-between items-center p-4 pt-2">
                                <div class="flex items-center space-x-2">
                                    <button id="playPauseBtn" class="video-control-btn w-12 h-12 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white text-xl transition-all duration-200" data-action="playpause">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <button id="muteBtn" class="video-control-btn w-12 h-12 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white text-xl transition-all duration-200" data-action="mute">
                                        <i class="fas fa-volume-up"></i>
                                    </button>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span id="timeDisplay" class="text-white text-sm font-mono">0:00 / 0:00</span>
                                </div>
                            </div>

                            <!-- Center Play Button (large) -->
                            <div class="flex-1 flex items-center justify-center">
                                <button id="centerPlayBtn" class="video-control-btn w-24 h-24 bg-gradient-to-br from-red-600/90 to-red-500/90 rounded-full flex items-center justify-center text-white text-3xl shadow-2xl hover:scale-110 transition-all duration-300 backdrop-blur-sm border-4 border-white/40" data-action="playpause">
                                    <i class="fas fa-play ml-2"></i>
                                </button>
                            </div>

                            <!-- Bottom Progress Bar -->
                            <div class="p-4 pb-2">
                                <div class="w-full bg-white/20 rounded-full h-2 cursor-pointer relative group-hover:h-3 transition-all duration-200 overflow-hidden" id="progressBar">
                                    <div class="absolute left-0 top-0 bg-gradient-to-r from-neon-pink to-purple-600 h-full rounded-full transition-all duration-300" id="progressFill" style="width: 0%"></div>
                                    <div class="absolute left-0 top-0 bg-white/50 w-4 h-4 rounded-full -mt-1 ml-[-0.5rem] opacity-0 group-hover:opacity-100 transition-opacity cursor-grab shadow-md" id="progressThumb"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Corner Decorations -->
                        <div class="absolute top-4 left-4 w-8 h-8 border-t-2 border-l-2 border-neon-pink/50 pointer-events-none"></div>
                        <div class="absolute top-4 right-4 w-8 h-8 border-t-2 border-r-2 border-neon-pink/50 pointer-events-none"></div>
                        <div class="absolute bottom-4 left-4 w-8 h-8 border-b-2 border-l-2 border-neon-pink/50 pointer-events-none"></div>
                        <div class="absolute bottom-4 right-4 w-8 h-8 border-b-2 border-r-2 border-neon-pink/50 pointer-events-none"></div>
                    </div>

                    <!-- Video Info Bar -->
                    <div class="bg-gradient-to-r from-dark-card/95 to-gray-900/95 p-6 border-t border-gray-700/50 backdrop-blur-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold font-orbitron text-white mb-1">
                                    {{ $page->video_info_title ?? 'TKDS Solutions Overview' }}
                                </h3>
                                <p class="text-gray-400">
                                    {{ $page->video_info_description ?? 'Experience the future of hosting and streaming technology' }}
                                </p>
                            </div>
                        
                        </div>
                    </div>
                </div>
                
                <!-- Glow Effect -->
                <div class="absolute -inset-2 bg-gradient-to-br from-neon-pink/40 to-purple-600/40 rounded-[2.5rem] blur-3xl opacity-70 -z-10 animate-pulse"></div>
            </div>
        </div>
    </div>
</section>
  @endif
 @break

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoContainer = document.getElementById('videoContainer');
    const videoArea = document.getElementById('videoArea');
    if (!videoContainer || !videoArea) return;

    const videoPlayer = document.getElementById('videoPlayer');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const centerPlayBtn = document.getElementById('centerPlayBtn');
    const muteBtn = document.getElementById('muteBtn');
    const progressBar = document.getElementById('progressBar');
    const progressFill = document.getElementById('progressFill');
    const progressThumb = document.getElementById('progressThumb');
    const timeDisplay = document.getElementById('timeDisplay');

    let isDragging = false;
    let isVideoAreaClick = false;

    // Only work with native video
    if (!videoPlayer) return;

    // Prevent event bubbling on control buttons
    document.querySelectorAll('.video-control-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            isVideoAreaClick = false;
        });
    });

    // Play/Pause
    function togglePlay() {
        if (videoPlayer.paused) {
            videoPlayer.play();
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
            centerPlayBtn.innerHTML = '<i class="fas fa-pause ml-2"></i>';
        } else {
            videoPlayer.pause();
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
            centerPlayBtn.innerHTML = '<i class="fas fa-play ml-2"></i>';
        }
    }

    // Mute/Unmute - FIXED: no play/pause interference
    function toggleMute() {
        videoPlayer.muted = !videoPlayer.muted;
        muteBtn.innerHTML = videoPlayer.muted ? 
            '<i class="fas fa-volume-mute"></i>' : 
            '<i class="fas fa-volume-up"></i>';
    }

    // Time formatting
    function formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }

    // Update time display and progress
    function updateTime() {
        const current = formatTime(videoPlayer.currentTime);
        const duration = formatTime(videoPlayer.duration);
        timeDisplay.textContent = `${current} / ${duration}`;
        
        if (!isDragging && !isNaN(videoPlayer.duration)) {
            const percent = (videoPlayer.currentTime / videoPlayer.duration) * 100;
            progressFill.style.width = `${percent}%`;
            progressThumb.style.left = `calc(${percent}% - 0.5rem)`;
        }
    }

    // Progress bar click/drag
    function handleProgress(e) {
        e.stopPropagation();
        const rect = progressBar.getBoundingClientRect();
        const percent = Math.max(0, Math.min(100, ((e.clientX - rect.left) / rect.width) * 100));
        const time = (percent / 100) * videoPlayer.duration;
        videoPlayer.currentTime = time;
        progressFill.style.width = `${percent}%`;
        progressThumb.style.left = `calc(${percent}% - 0.5rem)`;
    }

    // Event Listeners - FIXED event handling
    videoArea.addEventListener('click', function(e) {
        if (!isVideoAreaClick) {
            togglePlay();
        }
        isVideoAreaClick = false;
    });

    if (playPauseBtn) playPauseBtn.addEventListener('click', togglePlay);
    if (centerPlayBtn) centerPlayBtn.addEventListener('click', togglePlay);
    if (muteBtn) muteBtn.addEventListener('click', toggleMute);

    if (progressBar) {
        progressBar.addEventListener('click', handleProgress);
        progressThumb.addEventListener('mousedown', (e) => {
            isDragging = true;
            e.stopPropagation();
        });
        document.addEventListener('mousemove', (e) => {
            if (isDragging) handleProgress(e);
        });
        document.addEventListener('mouseup', () => {
            isDragging = false;
        });
    }

    // Video events
    videoPlayer.addEventListener('timeupdate', updateTime);
    videoPlayer.addEventListener('loadedmetadata', updateTime);
    videoPlayer.addEventListener('ended', () => {
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        centerPlayBtn.innerHTML = '<i class="fas fa-play ml-2"></i>';
        progressFill.style.width = '100%';
    });

    // Initial state
    playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
    centerPlayBtn.innerHTML = '<i class="fas fa-play ml-2"></i>';
});
</script>




    @case('clients')
     @if($page->hasActiveSection('clients'))
<!-- Clients Slider -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                {{ $page->clients_title ?? 'TRUSTED BY GIANTS' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->clients_subtitle ?? 'Join thousands of satisfied clients who trust our solutions' }}
            </p>
        </div>

        <!-- Infinite Scroll Clients -->
        <div class="overflow-hidden relative">
            <div class="flex animate-scroll-smooth">
                {{-- First pass - Real clients --}}
                @if($page->clients_logos && is_array($page->clients_logos) && count($page->clients_logos) > 0)
                    @foreach($page->clients_logos as $client)
                        <div class="flex-shrink-0 mx-6">
                            <div class="w-28 h-28 bg-gradient-to-br from-dark-card to-gray-900 rounded-2xl glass-effect border border-gray-700 hover:border-neon-pink transition-all duration-300 flex items-center justify-center group hover:scale-110">
                                @if(is_string($client))
                                    {{-- Handle old format (string) --}}
                                    <img src="{{ asset('storage/' . $client) }}"
                                         alt="Client Logo"
                                         class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300 max-h-20"
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="text-center hidden">
                                        <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    </div>
                                @elseif(is_array($client))
                                    {{-- Handle new format (array) --}}
                                    @if(isset($client['logo']) && $client['logo'])
                                        <img src="{{ asset('storage/' . $client['logo']) }}"
                                             alt="{{ $client['name'] ?? 'Client' }}"
                                             class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300 max-h-20"
                                             loading="lazy"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div class="text-center hidden">
                                            <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300 mb-2">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            @if(isset($client['name']))
                                                <div class="text-xs text-gray-400 font-bold">{{ $client['name'] }}</div>
                                            @endif
                                        </div>
                                    @elseif(isset($client['icon']) && $client['icon'])
                                        <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300">
                                            <i class="{{ $client['icon'] }}"></i>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300 mb-2">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            @if(isset($client['name']))
                                                <div class="text-xs text-gray-400 font-bold">{{ $client['name'] }}</div>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fallback logos if no clients --}}
                    @php
                        $fallbackLogos = [
                            ['name' => 'Amazon', 'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Amazon-Logo.png'],
                            ['name' => 'Google', 'logo' => 'https://logos-world.net/wp-content/uploads/2020/09/Google-Logo.png'],
                            ['name' => 'Microsoft', 'logo' => 'https://logos-world.net/wp-content/uploads/2020/06/Microsoft-Logo.png'],
                            ['name' => 'Apple', 'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Apple-Logo.png', 'invert' => true],
                            ['name' => 'Meta', 'logo' => 'https://logos-world.net/wp-content/uploads/2021/10/Meta-Logo.png'],
                            ['name' => 'Netflix', 'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Netflix-Logo.png'],
                            ['name' => 'Tesla', 'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Tesla-Logo.png'],
                            ['name' => 'Adobe', 'logo' => 'https://logos-world.net/wp-content/uploads/2020/04/Adobe-Logo.png']
                        ];
                    @endphp
                    
                    @foreach($fallbackLogos as $fallback)
                        <div class="flex-shrink-0 mx-6">
                            <div class="w-28 h-28 bg-gradient-to-br from-dark-card to-gray-900 rounded-2xl glass-effect border border-gray-700 hover:border-neon-pink transition-all duration-300 flex items-center justify-center group hover:scale-110">
                                <img src="{{ $fallback['logo'] }}"
                                     alt="{{ $fallback['name'] }}"
                                     class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300 max-h-20 {{ isset($fallback['invert']) ? 'filter brightness-0 invert' : '' }}"
                                     loading="lazy"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <div class="text-center hidden">
                                    <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300 mb-1">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="text-xs text-gray-400 font-bold">{{ $fallback['name'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- Duplicate for seamless infinite loop --}}
                @if($page->clients_logos && is_array($page->clients_logos) && count($page->clients_logos) > 0)
                    @foreach($page->clients_logos as $client)
                        <div class="flex-shrink-0 mx-6">
                            <div class="w-28 h-28 bg-gradient-to-br from-dark-card to-gray-900 rounded-2xl glass-effect border border-gray-700 hover:border-neon-pink transition-all duration-300 flex items-center justify-center group hover:scale-110">
                                @if(is_string($client))
                                    {{-- Handle old format (string) --}}
                                    <img src="{{ asset('storage/' . $client) }}"
                                         alt="Client Logo"
                                         class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300 max-h-20"
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="text-center hidden">
                                        <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    </div>
                                @elseif(is_array($client))
                                    {{-- Handle new format (array) --}}
                                    @if(isset($client['logo']) && $client['logo'])
                                        <img src="{{ asset('storage/' . $client['logo']) }}"
                                             alt="{{ $client['name'] ?? 'Client' }}"
                                             class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300 max-h-20"
                                             loading="lazy"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div class="text-center hidden">
                                            <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300 mb-2">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            @if(isset($client['name']))
                                                <div class="text-xs text-gray-400 font-bold">{{ $client['name'] }}</div>
                                            @endif
                                        </div>
                                    @elseif(isset($client['icon']) && $client['icon'])
                                        <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300">
                                            <i class="{{ $client['icon'] }}"></i>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300 mb-2">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            @if(isset($client['name']))
                                                <div class="text-xs text-gray-400 font-bold">{{ $client['name'] }}</div>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Duplicate fallback logos --}}
                    @foreach($fallbackLogos as $fallback)
                        <div class="flex-shrink-0 mx-6">
                            <div class="w-28 h-28 bg-gradient-to-br from-dark-card to-gray-900 rounded-2xl glass-effect border border-gray-700 hover:border-neon-pink transition-all duration-300 flex items-center justify-center group hover:scale-110">
                                <img src="{{ $fallback['logo'] }}"
                                     alt="{{ $fallback['name'] }}"
                                     class="w-16 h-auto object-contain opacity-70 group-hover:opacity-100 transition-opacity duration-300 max-h-20 {{ isset($fallback['invert']) ? 'filter brightness-0 invert' : '' }}"
                                     loading="lazy"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <div class="text-center hidden">
                                    <div class="text-2xl text-gray-500 group-hover:text-neon-pink transition-all duration-300 mb-1">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="text-xs text-gray-400 font-bold">{{ $fallback['name'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
  @endif
 @break

<style>
@keyframes scroll-smooth {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-scroll-smooth {
    animation: scroll-smooth 40s linear infinite;
}
@media (hover: hover) {
    .animate-scroll-smooth:hover {
        animation-play-state: paused;
    }
}
@media (max-width: 768px) {
    .animate-scroll-smooth {
        animation-duration: 30s;
    }
}
</style>

  @case('reviews')
@if($page->hasActiveSection('reviews'))
<!-- Customer Reviews Section -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-dark-bg via-purple-900/10 to-dark-bg"></div>
    
    <!-- Floating Background Elements -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-neon-pink/10 rounded-full blur-2xl animate-float"></div>
    <div class="absolute bottom-20 right-10 w-48 h-48 bg-purple-600/10 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>
    <div class="absolute top-1/2 left-1/3 w-24 h-24 bg-neon-pink/5 rounded-full blur-xl animate-pulse"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron  mb-4">
                {{ $page->reviews_title ?? 'WHAT CLIENTS SAY' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->reviews_subtitle ?? 'Real experiences from real customers who transformed their business with us' }}
            </p>
        </div>

        <!-- Creative 3D Reviews Slider -->
        <div class="relative max-w-7xl mx-auto">
            <!-- Main Slider Container -->
            <div class="reviews-slider-container relative h-96 perspective-2000" id="reviewsSlider">
                <div class="slider-track absolute w-full h-full flex items-center justify-center">
                    
                    @if($reviewsItems && count($reviewsItems) > 0)
                        @foreach($reviewsItems as $index => $review)
                            @php
                                $position = '';
                                switch($index) {
                                    case 0: $position = 'active'; break;
                                    case 1: $position = 'next'; break;
                                    case count($reviewsItems)-1: $position = 'prev'; break;
                                    case count($reviewsItems)-2: $position = 'far-left'; break;
                                    case 2: $position = 'far-right'; break;
                                    default: $position = 'hidden'; break;
                                }
                            @endphp
                            
                            <div class="review-slide {{ $position }}" data-index="{{ $index }}">
                                <div class="review-card">
                                    <div class="card-glow"></div>
                                    <div class="quote-decoration">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= ($review['rating'] ?? 5); $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                    <p class="review-text">
                                        "{{ $review['text'] ?? $review['review'] ?? '' }}"
                                    </p>
                                    <div class="reviewer-info">
                                        <div class="avatar">
                                            @if(isset($review['avatar']) && $review['avatar'])
                                                <img src="{{ asset('storage/' . $review['avatar']) }}" alt="{{ $review['name'] ?? 'Customer' }}">
                                            @else
                                                {{ strtoupper(substr($review['name'] ?? 'C', 0, 1)) }}
                                            @endif
                                        </div>
                                        <div class="details">
                                            <h4>{{ $review['name'] ?? 'Anonymous Customer' }}</h4>
                                            <span>{{ $review['position'] ?? $review['job_title'] ?? 'Customer' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Default Reviews if no dynamic data available -->
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
                    @endif

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
                @if($reviewsItems && count($reviewsItems) > 0)
                    @foreach($reviewsItems as $index => $review)
                        <div class="dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                    @endforeach
                @else
                    <div class="dot active" data-index="0"></div>
                    <div class="dot" data-index="1"></div>
                    <div class="dot" data-index="2"></div>
                @endif
            </div>
        </div>
    </div>

<script>
(function() {
    let currentReviewSlide = 0;
    const totalReviewSlides = {{ $reviewsItems && count($reviewsItems) > 0 ? count($reviewsItems) : 3 }};
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
        if (totalReviewSlides > 1) {
            reviewAutoSlideInterval = setInterval(() => {
                slideReviews('next');
            }, 4000);
        }
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

  @endif
 @break

 @case('contact')
@if($page->hasActiveSection('contact'))
   <!-- Contact Form Section -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 to-pink-900/20"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                    {{ $page->contact_title ?? 'GET YOUR DISCOUNT NOW' }}
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    {{ $page->contact_subtitle ?? "Don't miss out on this limited-time offer. Contact us today and save big!" }}
                </p>
            </div>

            <!-- Contact Info Only -->
            <div class="flex justify-center">
                <div class="w-full max-w-7xl">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
    <!-- WhatsApp Support -->
    @if($page->contact_whatsapp)
        <div class="group h-full">
            <div class="bg-gradient-to-br from-dark-card/80 to-gray-900/80 backdrop-blur-md rounded-3xl p-8 border border-gray-700/50 shadow-xl hover:shadow-2xl hover:border-neon-pink/50 transition-all duration-300 text-center h-full flex flex-col justify-between">
                <div>
                    <div class="w-20 h-20 bg-gradient-neon rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 mx-auto mb-6">
                        <i class="fab fa-whatsapp text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">WhatsApp Support</h3>
                    <p class="text-gray-300 mb-4 text-sm">Instant responses for urgent inquiries</p>
                </div>
                <a href="https://wa.me/{{ str_replace(['+', ' ', '-', '(', ')'], '', $page->contact_whatsapp) }}" 
                   target="_blank" 
                   class="inline-block text-neon-pink hover:text-neon-red transition-colors font-bold text-lg">
                    {{ $page->contact_whatsapp }}
                </a>
            </div>
        </div>
    @endif

    <!-- Email Support -->
    @if($page->contact_email)
        <div class="group h-full">
            <div class="bg-gradient-to-br from-dark-card/80 to-gray-900/80 backdrop-blur-md rounded-3xl p-8 border border-gray-700/50 shadow-xl hover:shadow-2xl hover:border-neon-pink/50 transition-all duration-300 text-center h-full flex flex-col justify-between">
                <div>
                    <div class="w-20 h-20 bg-gradient-neon rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 mx-auto mb-6">
                        <i class="fas fa-envelope text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Email Support</h3>
                    <p class="text-gray-300 mb-4 text-sm">Professional assistance via email</p>
                </div>
                <a href="mailto:{{ $page->contact_email }}" 
                   class="inline-block text-neon-pink hover:text-neon-red transition-colors font-bold text-lg">
                    {{ $page->contact_email }}
                </a>
            </div>
        </div>
    @endif

    <!-- Phone Support -->
    @if($page->contact_phone)
        <div class="group h-full">
            <div class="bg-gradient-to-br from-dark-card/80 to-gray-900/80 backdrop-blur-md rounded-3xl p-8 border border-gray-700/50 shadow-xl hover:shadow-2xl hover:border-neon-pink/50 transition-all duration-300 text-center h-full flex flex-col justify-between">
                <div>
                    <div class="w-20 h-20 bg-gradient-neon rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 mx-auto mb-6">
                        <i class="fas fa-phone text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Phone Support</h3>
                    <p class="text-gray-300 mb-4 text-sm">Direct phone assistance</p>
                </div>
                <a href="tel:{{ str_replace(['+', ' ', '-', '(', ')'], '', $page->contact_phone) }}" 
                   class="inline-block text-neon-pink hover:text-neon-red transition-colors font-bold text-lg">
                    {{ $page->contact_phone }}
                </a>
            </div>
        </div>
    @endif

    <!-- 24/7 Availability (Static Info) -->
    <div class="group h-full {{ ($page->contact_whatsapp && $page->contact_email && $page->contact_phone) ? 'md:col-span-2 lg:col-span-3' : '' }}">
        <div class="bg-gradient-to-br from-dark-card/80 to-gray-900/80 backdrop-blur-md rounded-3xl p-8 border border-gray-700/50 shadow-xl hover:shadow-2xl hover:border-neon-pink/50 transition-all duration-300 text-center h-full flex flex-col justify-between">
            <div>
                <div class="w-20 h-20 bg-gradient-neon rounded-full flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 mx-auto mb-6">
                    <i class="fas fa-clock text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Available 24/7</h3>
                <p class="text-gray-300 mb-4 text-sm">Round-the-clock support</p>
            </div>
            <span class="text-neon-pink font-bold text-lg">Always online for you</span>
        </div>
    </div>

</div>

                    <!-- Call to Action Buttons -->
                    <div class="mt-12 text-center space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
                        @if($page->contact_whatsapp)
                            <a href="https://wa.me/{{ str_replace(['+', ' ', '-', '(', ')'], '', $page->contact_whatsapp) }}" 
                               target="_blank"
                               class="inline-block bg-gradient-to-r from-green-600 to-green-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-green-500/50">
                                <i class="fab fa-whatsapp mr-2"></i>
                                Chat on WhatsApp
                            </a>
                        @endif
                        
                        @if($page->contact_email)
                            <a href="mailto:{{ $page->contact_email }}" 
                               class="inline-block bg-gradient-neon text-white px-8 py-4 rounded-xl font-bold text-lg hover:scale-105 transition-all duration-300 neon-shadow">
                                <i class="fas fa-envelope mr-2"></i>
                                Send Email
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Commented Contact Form
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
    -->
</section>
  @endif
 @break

@case('footer')
@if($page->hasActiveSection('footer'))
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
                    @if($page->footer_logo_image)
                        <img src="{{ asset('storage/' . $page->footer_logo_image) }}" alt="Logo" class="h-12 w-auto mr-4 group-hover:scale-110 transition-transform">
                    @else
                        <div class="tv-startup-logo font-bebas text-4xl lg:text-5xl mr-4 group-hover:scale-110 transition-transform">
                            {{ $page->footer_logo_text ?? 'TKDS' }}
                        </div>
                    @endif
                    <div class="text-sm font-normal text-gray-300 font-oswald tracking-wider leading-tight">
                        @php
                            $logoSubtitle = $page->footer_logo_subtitle ?? 'SHAPING THE WORLD';
                            $parts = explode(' ', $logoSubtitle);
                            $lastWord = array_pop($parts);
                            $firstPart = implode(' ', $parts);
                        @endphp
                        {{ $firstPart }}<br>
                        <span class="text-neon-pink font-bold">{{ $lastWord }}</span>
                    </div>
                </div>
            </div>

            <!-- Marketing Message -->
            <div class="text-center">
                <div class="p-8 bg-dark-card/40 backdrop-blur-md rounded-3xl border border-gray-700/30 shadow-xl hover:shadow-2xl hover:border-neon-pink/40 transition-all duration-500">
                    @php
                        $titleLine1 = $page->footer_title_line1 ?? 'FUTURE OF';
                        $titleLine2 = $page->footer_title_line2 ?? 'STREAMING';
                    @endphp
                    <h3 class="text-xl font-black font-orbitron mb-4 bg-gradient-to-r from-white to-gray-200 bg-clip-text text-transparent drop-shadow-lg">
                        {{ $titleLine1 }}
                    </h3>
                    <h3 class="text-md font-black font-bebas text-gradient-red mb-6 tracking-wider">
                        {{ $titleLine2 }}
                    </h3>
                    <p class="text-lg text-gray-300 leading-relaxed max-w-md mx-auto md:mx-0">
                        {{ $page->footer_description ?? 'Enterprise-grade hosting & live streaming solutions trusted worldwide' }}
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
                            @php
                                $discountText = $page->footer_discount_badge_text ?? '80% OFF';
                                $percentageMatch = preg_match('/(\d+)%?\s*(OFF|خصم)?/i', $discountText, $matches);
                                $percentage = $percentageMatch ? $matches[1] : '80';
                                $suffix = $percentageMatch && isset($matches[2]) ? $matches[2] : 'OFF';
                            @endphp
                            <div class="text-6xl lg:text-7xl font-black font-orbitron text-white mb-2 drop-shadow-2xl leading-none">
                                {{ $percentage }}<span class="text-4xl">%</span>
                            </div>
                            <div class="text-sm uppercase tracking-wider text-red-200 font-oswald font-bold">
                                {{ strtoupper($suffix) }}
                            </div>
                            <div class="text-xs text-red-300 uppercase tracking-widest font-bold mt-2 opacity-75">
                                {{ $page->footer_discount_badge_subtext ?? 'LIMITED TIME' }}
                            </div>
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
                    @if($page->footer_social_links && is_array($page->footer_social_links))
                        @foreach($page->footer_social_links as $social)
                            @if(isset($social['icon']) && isset($social['url']))
                                <a href="{{ $social['url'] }}" target="_blank" class="w-12 h-12 bg-dark-card/50 backdrop-blur-sm rounded-2xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-gradient-neon hover:shadow-neon-pink transition-all duration-300 border border-gray-700/50 hover:border-neon-pink/50">
                                    <i class="{{ $social['icon'] }} text-xl"></i>
                                </a>
                            @endif
                        @endforeach
                    @else
                        <!-- Default Social Links -->
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
                    @endif
                </div>

                <!-- Copyright -->
                <div class="text-center md:text-right">
                    <p class="text-gray-400 text-sm font-oswald tracking-wider">
                        {{ $page->footer_copyright ?? '© 2025 TKDS Servers. All rights reserved.' }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1 font-oswald tracking-widest opacity-75">
                        {{ $page->footer_powered_by ?? 'POWERED BY INNOVATION' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
 @endif
@break

@endswitch
@endforeach

<script>
// في sales.js - إضافة دالة للتحكم في ظهور الأقسام
document.addEventListener('DOMContentLoaded', function() {
    // Handle section visibility based on status
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('section-visible');
            }
        });
    }, observerOptions);

    // Observe all sections
    document.querySelectorAll('section').forEach(section => {
        sectionObserver.observe(section);
    });
});
</script>
</body>
</html>