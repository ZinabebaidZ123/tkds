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

 @php
    use App\Models\Client;
    $clientsByCategory = Client::getGroupedByCategory();
@endphp 
@php
    $footerSettings = \App\Models\FooterSetting::getSettings();
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
            alt="" 
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
<!-- Premium Services Section -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-red-900/10 to-red-900/10"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                {{ $page->services_title ?? 'PREMIUM SERVICES' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->services_subtitle ?? 'Experience cutting-edge technology with our professional solutions' }}
            </p>
        </div>

        <!-- Services Slider Container -->
        <div class="relative max-w-7xl mx-auto">
            <div class="services-slider-container relative h-96" id="servicesSlider">
                <div class="slider-track absolute w-full h-full flex items-center justify-center">
                    
                    @foreach($services as $index => $service)
                        @php
                            $position = '';
                            switch($index) {
                                case 0: $position = 'active'; break;
                                case 1: $position = 'next'; break;
                                case count($services)-1: $position = 'prev'; break;
                                case count($services)-2: $position = 'far-left'; break;
                                case 2: $position = 'far-right'; break;
                                default: $position = 'hidden'; break;
                            }
                        @endphp
                        
                        <div class="services-slide {{ $position }}" data-index="{{ $index }}">
                            <div class="services-card">
                                <!-- Card Background -->
                                <div class="absolute inset-0">
                                    @if($service->featured_image)
                                        <img src="{{ asset('storage/' . $service->featured_image) }}" 
                                             alt="{{ $service->title }}"
                                             class="w-full h-full object-cover opacity-20">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-800/50 to-dark-card/50"
                                             style="background-image: url('https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'); background-size: cover; background-position: center;">
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-br from-dark-card/90 to-gray-900/90"></div>
                                </div>

                                <!-- Card Content -->
                                <div class="relative z-10 p-8 h-full flex flex-col justify-between">
                                    <!-- Header -->
                                    <div class="text-center">
                                        <!-- Service Icon -->
                                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center bg-gradient-to-br from-red-600 to-red-800 shadow-lg">
                                            @if($service->icon)
                                                <i class="{{ $service->icon }} text-2xl text-white"></i>
                                            @else
                                                <i class="fas fa-server text-2xl text-white"></i>
                                            @endif
                                        </div>

                                        <!-- Service Title -->
                                        <h3 class="text-2xl font-bold text-white mb-2 font-orbitron">
                                            {{ $service->title }}
                                        </h3>

                                        <!-- Service Category -->
                                        @if($service->category)
                                            <span class="inline-block px-3 py-1 bg-red-500/20 text-emerald-400 rounded-full text-xs font-medium mb-4">
                                                {{ ucfirst($service->category) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Description -->
                                    <div class="text-center mb-6">
                                        <p class="text-gray-300 text-sm leading-relaxed">
                                            {{ Str::limit($service->short_description ?? $service->description, 120) }}
                                        </p>
                                    </div>


                                    <!-- Pricing -->
                                    {{-- <div class="text-center mb-6">
                                        @if($service->starting_price && $service->starting_price > 0)
                                            <div class="text-3xl font-black text-white mb-1 font-orbitron">
                                                ${{ number_format($service->starting_price, 0) }}+
                                            </div>
                                            <div class="text-gray-400 text-xs">Starting from</div>
                                        @else
                                           
                                        @endif
                                    </div> --}}

                                    <!-- Action Button -->
                                    <div class="text-center">
                                        <a href="{{ route('services.show', $service->slug) }}" 
                                           class="inline-block bg-gradient-to-r from-red-600 to-red-800 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-emerald-500/50">
                                            <i class="fas fa-arrow-right mr-2"></i>Learn More
                                        </a>
                                    </div>

                                    <!-- Status Badges -->
                                    <div class="absolute top-4 right-4 flex flex-col space-y-1">
                                        @if($service->is_featured)
                                            <span class="bg-yellow-500/20 text-yellow-400 text-xs px-2 py-1 rounded-full font-medium">
                                                Featured
                                            </span>
                                        @endif
                                        @if($service->is_popular)
                                            <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded-full font-medium">
                                                Popular
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Glow Effect -->
                                <div class="absolute -inset-1 bg-gradient-to-br from-emerald-500/30 to-cyan-600/30 rounded-3xl blur-xl opacity-0 group-hover:opacity-60 transition-opacity duration-300 -z-10"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button class="services-nav-button prev" type="button" id="servicesPrevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="services-nav-button next" type="button" id="servicesNextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Dots Indicator -->
            {{-- <div class="services-dots-indicator" id="servicesDotsIndicator">
                @foreach($services as $index => $service)
                    <div class="services-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                @endforeach
            </div> --}}
        </div>

        <!-- Global CTA -->
        <div class="text-center mt-12">
            <a href="{{ route('services') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-800 text-white font-bold rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-emerald-500/50">
                <i class="fas fa-layer-group mr-3"></i>
                Explore All Services
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const servicesSection = document.querySelector('#servicesSlider');
    if (!servicesSection) return;

    const servicesSlides = servicesSection.querySelectorAll('.services-slide');
    const servicesDots = servicesSection.querySelectorAll('.services-dot');
    const servicesPrevBtn = document.getElementById('servicesPrevBtn');
    const servicesNextBtn = document.getElementById('servicesNextBtn');
    const totalServicesSlides = servicesSlides.length;

    if (!totalServicesSlides) return;

    let currentServicesSlide = 0;
    let servicesAutoRotateInterval = null;
    const servicesSlideClasses = ['far-left', 'prev', 'active', 'next', 'far-right', 'hidden'];
    const SERVICES_AUTO_INTERVAL = 5000; // 5 seconds

    function updateServicesSlides() {
        servicesSlides.forEach((slide, index) => {
            servicesSlideClasses.forEach(c => slide.classList.remove(c));

            let position = index - currentServicesSlide;
            if (position < -2) position += totalServicesSlides;
            if (position > 2) position -= totalServicesSlides;

            switch (position) {
                case -2: slide.classList.add('far-left'); break;
                case -1: slide.classList.add('prev'); break;
                case 0: slide.classList.add('active'); break;
                case 1: slide.classList.add('next'); break;
                case 2: slide.classList.add('far-right'); break;
                default: slide.classList.add('hidden'); break;
            }
        });

        servicesDots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentServicesSlide);
        });
    }

    function slideServices(direction) {
        if (direction === 'next') {
            currentServicesSlide = (currentServicesSlide + 1) % totalServicesSlides;
        } else {
            currentServicesSlide = (currentServicesSlide - 1 + totalServicesSlides) % totalServicesSlides;
        }
        updateServicesSlides();
        resetServicesAutoRotate();
    }

    function slideToServices(index) {
        if (index < 0 || index >= totalServicesSlides) return;
        currentServicesSlide = index;
        updateServicesSlides();
        resetServicesAutoRotate();
    }

    function startServicesAutoRotate() {
        if (totalServicesSlides <= 1 || servicesAutoRotateInterval) return;
        servicesAutoRotateInterval = setInterval(() => {
            slideServices('next');
        }, SERVICES_AUTO_INTERVAL);
    }

    function stopServicesAutoRotate() {
        if (!servicesAutoRotateInterval) return;
        clearInterval(servicesAutoRotateInterval);
        servicesAutoRotateInterval = null;
    }

    function resetServicesAutoRotate() {
        stopServicesAutoRotate();
        startServicesAutoRotate();
    }

    // Event Listeners
    if (servicesPrevBtn) servicesPrevBtn.addEventListener('click', () => slideServices('prev'));
    if (servicesNextBtn) servicesNextBtn.addEventListener('click', () => slideServices('next'));

    servicesDots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.dataset.index, 10);
            slideToServices(index);
        });
    });

    servicesSlides.forEach((slide, index) => {
        slide.addEventListener('click', function () {
            if (!this.classList.contains('active')) {
                slideToServices(index);
            }
        });
    });

    // Hover events
    if (servicesSection) {
        servicesSection.addEventListener('mouseenter', stopServicesAutoRotate);
        servicesSection.addEventListener('mouseleave', startServicesAutoRotate);
    }

    // Touch support
    let servicesStartX = 0;
    let servicesEndX = 0;

    if (servicesSection) {
        servicesSection.addEventListener('touchstart', function (e) {
            servicesStartX = e.touches[0].clientX;
        });

        servicesSection.addEventListener('touchend', function (e) {
            servicesEndX = e.changedTouches[0].clientX;
            const threshold = 50;
            const diff = servicesStartX - servicesEndX;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0) slideServices('next');
                else slideServices('prev');
            }
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') slideServices('prev');
        if (e.key === 'ArrowRight') slideServices('next');
    });

    // Initialize
    updateServicesSlides();
    startServicesAutoRotate();
});
</script>
@endif
@break

@case('packages')
@if($page->hasActiveSection('packages') && $packages && $packages->count() > 0)
<!-- Pricing Plans Section - Slider Design -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-red-900/10 to-red-800/10"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                {{ $page->packages_title ?? 'EXPLOSIVE PACKAGES' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->packages_subtitle ?? 'Discover our premium packages with special occasion pricing' }}
            </p>
        </div>

        @php
            $hasMonthlyPlans = $packages->filter(function($plan) {
                return !empty($plan->price_monthly) && $plan->price_monthly > 0;
            })->count() > 0;
            
            $hasYearlyPlans = $packages->filter(function($plan) {
                return !empty($plan->price_yearly) && $plan->price_yearly > 0;
            })->count() > 0;
            
            $showBillingToggle = $hasMonthlyPlans && $hasYearlyPlans;
        @endphp

        <!-- Billing Toggle (Only show if both monthly and yearly plans exist) -->
        @if($showBillingToggle)
            <div class="flex justify-center mb-12">
                <div class="bg-gradient-to-r from-red-900/80 to-red-800/80 backdrop-blur-md rounded-2xl p-2 border border-red-600/50 shadow-xl">
                    <div class="flex items-center space-x-1">
                        <button id="monthlyBtn" class="billing-toggle-btn active px-8 py-3 rounded-xl font-bold text-sm transition-all duration-300 relative overflow-hidden group">
                            <span class="relative z-10">Monthly</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700 opacity-0 group-hover:opacity-20 transition-opacity"></div>
                        </button>
                        <button id="yearlyBtn" class="billing-toggle-btn px-8 py-3 rounded-xl font-bold text-sm transition-all duration-300 relative overflow-hidden group">
                            <span class="relative z-10">Yearly</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700 opacity-0 group-hover:opacity-20 transition-opacity"></div>
                            <span class="ml-2 text-xs bg-green-500 text-white px-2 py-1 rounded-full">Save up to 30%</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Pricing Plans Slider Container -->
        <div class="relative max-w-7xl mx-auto">
            <div class="packages-slider-container relative h-[500px]" id="packagesSlider">
                <div class="slider-track absolute w-full h-full flex items-center justify-center">
                    
                    @foreach($packages as $index => $package)
                        @php
                            $position = '';
                            switch($index) {
                                case 0: $position = 'active'; break;
                                case 1: $position = 'next'; break;
                                case count($packages)-1: $position = 'prev'; break;
                                case count($packages)-2: $position = 'far-left'; break;
                                case 2: $position = 'far-right'; break;
                                default: $position = 'hidden'; break;
                            }
                            
                            // Handle both pivot relationship and direct model access
                            if (isset($package->pivot)) {
                                $pivotData = $package->pivot;
                                $isPackageFeatured = ($pivotData->is_featured ?? false) || $package->is_featured;
                                $discountPercentage = $pivotData->discount_percentage ?? null;
                            } else {
                                $isPackageFeatured = $package->is_featured;
                                $discountPercentage = null;
                            }
                            $originalMonthlyPrice = $package->price_monthly;
                            $originalYearlyPrice = $package->price_yearly;
                            $discountedMonthlyPrice = $discountPercentage ? $originalMonthlyPrice * (1 - $discountPercentage / 100) : $originalMonthlyPrice;
                            $discountedYearlyPrice = $discountPercentage ? $originalYearlyPrice * (1 - $discountPercentage / 100) : $originalYearlyPrice;
                        @endphp
                        
                        <div class="packages-slide {{ $position }}" 
                             data-index="{{ $index }}"
                             data-has-monthly="{{ !empty($package->price_monthly) && $package->price_monthly > 0 ? 'true' : 'false' }}"
                             data-has-yearly="{{ !empty($package->price_yearly) && $package->price_yearly > 0 ? 'true' : 'false' }}"
                             data-monthly-price="{{ $originalMonthlyPrice }}"
                             data-yearly-price="{{ $originalYearlyPrice }}"
                             data-discounted-monthly="{{ $discountedMonthlyPrice }}"
                             data-discounted-yearly="{{ $discountedYearlyPrice }}"
                             data-discount="{{ $discountPercentage }}">
                            
                            <div class="packages-card group {{ $isPackageFeatured ? 'featured-plan' : '' }}">
                                <!-- Featured Badge -->
                                @if($isPackageFeatured)
                                    <div class=" flex items-center justify-center">
                                        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                            <i class="fas fa-crown mr-1"></i> MOST POPULAR
                                        </div>
                                    </div>
                                @endif

                                <!-- Discount Badge -->
                                @if($discountPercentage)
                                    <div class="absolute -top-2 -right-2 z-10">
                                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg transform rotate-12 animate-pulse">
                                            <div class="text-center">
                                                <div class="text-xs">{{ $discountPercentage }}%</div>
                                                <div class="text-xs">OFF</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Scrollable Card Content -->
                                <div class="packages-card-content h-full {{ $isPackageFeatured ? 'border-red-500/50 shadow-red-600/30' : '' }}">
                                    <!-- Glow Effect for Featured -->
                                    @if($isPackageFeatured)
                                        <div class="absolute -inset-1 bg-gradient-to-r from-red-500/30 to-red-600/30 rounded-3xl blur-xl opacity-60 -z-10 animate-pulse"></div>
                                    @endif

                                    <div class="scrollable-content">
                                        <!-- Card Header -->
                                        <div class="p-8 text-center border-b border-gray-700/50">
                                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center {{ $isPackageFeatured ? 'bg-gradient-to-br from-red-500 to-red-600' : 'bg-gradient-to-br from-gray-600 to-gray-700' }} shadow-lg">
                                                @if($package->icon)
                                                    <i class="{{ $package->icon }} text-2xl text-white"></i>
                                                @else
                                                    <i class="fas fa-server text-2xl text-white"></i>
                                                @endif
                                            </div>
                                            
                                            <h3 class="text-2xl font-bold text-white mb-2 font-orbitron">{{ $package->name }}</h3>
                                            <p class="text-gray-400 text-sm leading-relaxed">{{ $package->short_description }}</p>
                                        </div>

                                        <!-- Pricing -->
                                        <div class="p-8 text-center border-b border-gray-700/50">
                                            <div class="pricing-display">
                                                <!-- Monthly Pricing -->
                                                @if(!empty($package->price_monthly) && $package->price_monthly > 0)
                                                    <div class="monthly-price {{ $showBillingToggle ? '' : 'block' }}">
                                                        @if($discountPercentage)
                                                            <div class="text-gray-500 text-lg line-through mb-1">
                                                                ${{ number_format($originalMonthlyPrice, 2) }}
                                                            </div>
                                                        @endif
                                                        <div class="text-5xl font-black text-white mb-2 font-orbitron">
                                                            ${{ number_format($discountedMonthlyPrice, 0) }}
                                                        </div>
                                                        <div class="text-gray-400 text-sm">per month</div>
                                                    </div>
                                                @endif

                                                <!-- Yearly Pricing -->
                                                @if(!empty($package->price_yearly) && $package->price_yearly > 0)
                                                    <div class="yearly-price {{ $showBillingToggle ? 'hidden' : 'block' }}">
                                                        @if($discountPercentage)
                                                            <div class="text-gray-500 text-lg line-through mb-1">
                                                                ${{ number_format($originalYearlyPrice, 2) }}
                                                            </div>
                                                        @endif
                                                        <div class="text-5xl font-black text-white mb-2 font-orbitron">
                                                            ${{ number_format($discountedYearlyPrice, 0) }}
                                                        </div>
                                                        <div class="text-gray-400 text-sm">per year</div>
                                                        @if($package->getYearlySavingsPercentage() > 0)
                                                            <div class="text-green-400 text-sm font-medium mt-1">
                                                                Save {{ $package->getYearlySavingsPercentage() }}% annually
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif

                                                <!-- Free Plan -->
                                                @if(empty($package->price_monthly) && empty($package->price_yearly))
                                                    <div class="text-5xl font-black text-white mb-2 font-orbitron">FREE</div>
                                                    <div class="text-gray-400 text-sm">forever</div>
                                                @endif
                                            </div>

                                            <!-- Setup Fee -->
                                            @if($package->hasSetupFee())
                                                <div class="mt-4 text-sm text-yellow-400">
                                                    + {{ $package->getFormattedSetupFee() }}
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Features -->
                                        <div class="p-8 flex-1">
                                            <h4 class="text-white font-bold mb-4 text-center">What's Included:</h4>
                                            <ul class="space-y-3">
                                                @if($package->features && count($package->features) > 0)
                                                    @foreach($package->features as $feature)
                                                        <li class="flex items-center text-gray-300 text-sm">
                                                            <i class="fas fa-check text-green-400 mr-3 flex-shrink-0"></i>
                                                            <span>{{ $feature }}</span>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li class="flex items-center text-gray-300 text-sm">
                                                        <i class="fas fa-check text-green-400 mr-3"></i>
                                                        <span>Full access to platform</span>
                                                    </li>
                                                    <li class="flex items-center text-gray-300 text-sm">
                                                        <i class="fas fa-check text-green-400 mr-3"></i>
                                                        <span>24/7 customer support</span>
                                                    </li>
                                                    <li class="flex items-center text-gray-300 text-sm">
                                                        <i class="fas fa-check text-green-400 mr-3"></i>
                                                        <span>Premium features included</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>

                                        <!-- CTA Button -->
                                        <div class="p-8 pt-0 mt-auto">
                                            <a href="{{ route('subscription.create', $package->slug) }}" 
                                               class="block w-full text-center py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 {{ $isPackageFeatured ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-lg hover:shadow-red-500/50' : 'bg-gradient-to-r from-gray-700 to-gray-600 text-white hover:from-gray-600 hover:to-gray-500' }}">
                                                @if(empty($package->price_monthly) && empty($package->price_yearly))
                                                    Get Started Free
                                                @else
                                                    Start {{ $package->trial_days ? $package->trial_days . '-Day' : '' }} Trial
                                                @endif
                                            </a>

                                            @if($package->trial_days)
                                                <p class="text-center text-gray-500 text-xs mt-2">
                                                    {{ $package->trial_days }}-day free trial • No credit card required
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Glow Effect -->
                                <div class="absolute -inset-1 bg-gradient-to-br from-red-500/30 to-red-600/30 rounded-3xl blur-xl opacity-0 group-hover:opacity-60 transition-opacity duration-300 -z-10"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button class="packages-nav-button prev" type="button" id="packagesPrevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="packages-nav-button next" type="button" id="packagesNextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Dots Indicator -->
            {{-- <div class="packages-dots-indicator" id="packagesDotsIndicator">
                @foreach($packages as $index => $package)
                    <div class="packages-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                @endforeach
            </div> --}}
        </div>

        <!-- Additional Info -->
        <div class="text-center mt-16">
            <div class="flex justify-center space-x-8 text-sm text-gray-500">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-green-400 mr-2"></i>
                    SSL Security
                </div>
                <div class="flex items-center">
                    <i class="fas fa-headset text-red-400 mr-2"></i>
                    24/7 Support
                </div>
                <div class="flex items-center">
                    <i class="fas fa-sync-alt text-red-400 mr-2"></i>
                    Easy Migration
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Packages Slider Styles */
.packages-slider-container {
    perspective: 2000px;
    overflow: visible;
}

.packages-slide {
    position: absolute;
    width: 350px;
    height: 100%;
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

/* Slide Positions */
.packages-slide.active {
    transform: translateX(-50%) translateZ(0) scale(1);
    left: 50%;
    opacity: 1;
    z-index: 20;
}

.packages-slide.next {
    transform: translateX(0) translateZ(-200px) scale(0.85);
    left: 60%;
    opacity: 0.7;
    z-index: 15;
}

.packages-slide.prev {
    transform: translateX(-100%) translateZ(-200px) scale(0.85);
    left: 40%;
    opacity: 0.7;
    z-index: 15;
}

.packages-slide.far-right {
    transform: translateX(50%) translateZ(-400px) scale(0.7);
    left: 75%;
    opacity: 0.4;
    z-index: 10;
}

.packages-slide.far-left {
    transform: translateX(-150%) translateZ(-400px) scale(0.7);
    left: 25%;
    opacity: 0.4;
    z-index: 10;
}

.packages-slide.hidden {
    opacity: 0;
    z-index: 1;
}

/* Card Styles */
.packages-card {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 24px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.packages-card-content {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(26, 26, 26, 0.9) 0%, rgba(50, 50, 50, 0.9) 100%);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(107, 114, 128, 0.5);
    border-radius: 24px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: relative;
}

.scrollable-content {
    height: 100%;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    scrollbar-width: thin;
    scrollbar-color: rgba(220, 38, 38, 0.5) rgba(26, 26, 26, 0.3);
}

/* Custom Scrollbar for Webkit Browsers */
.scrollable-content::-webkit-scrollbar {
    width: 6px;
}

.scrollable-content::-webkit-scrollbar-track {
    background: rgba(26, 26, 26, 0.3);
    border-radius: 3px;
}

.scrollable-content::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    border-radius: 3px;
    box-shadow: 0 2px 4px rgba(220, 38, 38, 0.3);
}

.scrollable-content::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

/* Navigation Buttons */
.packages-nav-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 30;
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.4);
}

.packages-nav-button:hover {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 15px 35px -5px rgba(220, 38, 38, 0.6);
}



.packages-nav-button.next {
    right: 0px;
}

/* Dots Indicator */
.packages-dots-indicator {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 40px;
}

.packages-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(107, 114, 128, 0.4);
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.packages-dot.active {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    box-shadow: 0 0 20px rgba(220, 38, 38, 0.6);
}

.packages-dot:hover {
    background: rgba(220, 38, 38, 0.7);
    transform: scale(1.2);
}

/* Billing Toggle Active State */
.billing-toggle-btn.active {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
}

/* Featured Plan Enhancements */
.featured-plan .packages-card-content {
    border: 2px solid rgba(220, 38, 38, 0.6);
    box-shadow: 0 0 40px rgba(220, 38, 38, 0.3);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .packages-slide {
        width: 300px;
    }
    
    .packages-nav-button {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    
    .packages-nav-button.prev {
        left: -20px;
    }
    
    .packages-nav-button.next {
        right: -20px;
    }
}

@media (max-width: 480px) {
    .packages-slide {
        width: 280px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const packagesSection = document.querySelector('#packagesSlider');
    if (!packagesSection) return;

    const packagesSlides = packagesSection.querySelectorAll('.packages-slide');
    const packagesDots = packagesSection.querySelectorAll('.packages-dot');
    const packagesPrevBtn = document.getElementById('packagesPrevBtn');
    const packagesNextBtn = document.getElementById('packagesNextBtn');
    const totalPackagesSlides = packagesSlides.length;

    if (!totalPackagesSlides) return;

    let currentPackagesSlide = 0;
    let packagesAutoRotateInterval = null;
    const packagesSlideClasses = ['far-left', 'prev', 'active', 'next', 'far-right', 'hidden'];
    const PACKAGES_AUTO_INTERVAL = 5000; // 5 seconds

    // Billing Toggle Elements
    const monthlyBtn = document.getElementById('monthlyBtn');
    const yearlyBtn = document.getElementById('yearlyBtn');

    function updatePackagesSlides() {
        packagesSlides.forEach((slide, index) => {
            packagesSlideClasses.forEach(c => slide.classList.remove(c));

            let position = index - currentPackagesSlide;
            if (position < -2) position += totalPackagesSlides;
            if (position > 2) position -= totalPackagesSlides;

            switch (position) {
                case -2: slide.classList.add('far-left'); break;
                case -1: slide.classList.add('prev'); break;
                case 0: slide.classList.add('active'); break;
                case 1: slide.classList.add('next'); break;
                case 2: slide.classList.add('far-right'); break;
                default: slide.classList.add('hidden'); break;
            }
        });

        packagesDots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentPackagesSlide);
        });
    }

    function slidePackages(direction) {
        if (direction === 'next') {
            currentPackagesSlide = (currentPackagesSlide + 1) % totalPackagesSlides;
        } else {
            currentPackagesSlide = (currentPackagesSlide - 1 + totalPackagesSlides) % totalPackagesSlides;
        }
        updatePackagesSlides();
        resetPackagesAutoRotate();
    }

    function slideToPackage(index) {
        if (index < 0 || index >= totalPackagesSlides) return;
        currentPackagesSlide = index;
        updatePackagesSlides();
        resetPackagesAutoRotate();
    }

    function startPackagesAutoRotate() {
        if (totalPackagesSlides <= 1 || packagesAutoRotateInterval) return;
        packagesAutoRotateInterval = setInterval(() => {
            slidePackages('next');
        }, PACKAGES_AUTO_INTERVAL);
    }

    function stopPackagesAutoRotate() {
        if (!packagesAutoRotateInterval) return;
        clearInterval(packagesAutoRotateInterval);
        packagesAutoRotateInterval = null;
    }

    function resetPackagesAutoRotate() {
        stopPackagesAutoRotate();
        startPackagesAutoRotate();
    }

    // Billing Toggle Functionality
    function switchBilling(isYearly) {
        // Toggle button states
        if (isYearly) {
            monthlyBtn?.classList.remove('active');
            yearlyBtn?.classList.add('active');
        } else {
            yearlyBtn?.classList.remove('active');
            monthlyBtn?.classList.add('active');
        }
        
        // Show/hide pricing
        packagesSlides.forEach(slide => {
            const monthlyPrice = slide.querySelector('.monthly-price');
            const yearlyPrice = slide.querySelector('.yearly-price');
            const hasMonthly = slide.dataset.hasMonthly === 'true';
            const hasYearly = slide.dataset.hasYearly === 'true';
            
            if (isYearly && hasYearly) {
                if (monthlyPrice) monthlyPrice.classList.add('hidden');
                if (yearlyPrice) yearlyPrice.classList.remove('hidden');
            } else if (!isYearly && hasMonthly) {
                if (yearlyPrice) yearlyPrice.classList.add('hidden');
                if (monthlyPrice) monthlyPrice.classList.remove('hidden');
            }
            
            // Hide cards that don't have the selected billing option
            if ((isYearly && !hasYearly) || (!isYearly && !hasMonthly)) {
                slide.style.opacity = '0.5';
                slide.style.pointerEvents = 'none';
            } else {
                slide.style.opacity = '1';
                slide.style.pointerEvents = 'auto';
            }
        });
    }

    // Event Listeners
    if (packagesPrevBtn) packagesPrevBtn.addEventListener('click', () => slidePackages('prev'));
    if (packagesNextBtn) packagesNextBtn.addEventListener('click', () => slidePackages('next'));

    // Billing toggle events
    if (monthlyBtn) monthlyBtn.addEventListener('click', () => switchBilling(false));
    if (yearlyBtn) yearlyBtn.addEventListener('click', () => switchBilling(true));

    packagesDots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.dataset.index, 10);
            slideToPackage(index);
        });
    });

    packagesSlides.forEach((slide, index) => {
        slide.addEventListener('click', function () {
            if (!this.classList.contains('active')) {
                slideToPackage(index);
            }
        });
    });

    // Hover events
    if (packagesSection) {
        packagesSection.addEventListener('mouseenter', stopPackagesAutoRotate);
        packagesSection.addEventListener('mouseleave', startPackagesAutoRotate);
    }

    // Touch support
    let packagesStartX = 0;
    let packagesEndX = 0;

    if (packagesSection) {
        packagesSection.addEventListener('touchstart', function (e) {
            packagesStartX = e.touches[0].clientX;
        });

        packagesSection.addEventListener('touchend', function (e) {
            packagesEndX = e.changedTouches[0].clientX;
            const threshold = 50;
            const diff = packagesStartX - packagesEndX;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0) slidePackages('next');
                else slidePackages('prev');
            }
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') slidePackages('prev');
        if (e.key === 'ArrowRight') slidePackages('next');
    });

    // Initialize
    updatePackagesSlides();
    startPackagesAutoRotate();
});
</script>
@endif
@break

@case('products')
@if($page->hasActiveSection('products') && $products && $products->count() > 0)
<!-- SaaS Products Section -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/10 to-purple-900/10"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                {{ $page->products_title ?? 'SAAS SOLUTIONS' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->products_subtitle ?? 'Powerful software solutions to transform your business operations' }}
            </p>
        </div>

        <!-- SaaS Products Slider Container -->
        <div class="relative max-w-7xl mx-auto">
            <div class="saas-slider-container relative h-96" id="saasProductsSlider">
                <div class="slider-track absolute w-full h-full flex items-center justify-center">
                    
                    @foreach($products as $index => $product)
                        @php
                            $position = '';
                            switch($index) {
                                case 0: $position = 'active'; break;
                                case 1: $position = 'next'; break;
                                case count($products)-1: $position = 'prev'; break;
                                case count($products)-2: $position = 'far-left'; break;
                                case 2: $position = 'far-right'; break;
                                default: $position = 'hidden'; break;
                            }
                        @endphp
                        
                        <div class="saas-slide {{ $position }}" data-index="{{ $index }}">
                            <div class="saas-card">
                                <!-- Card Background -->
                                <div class="absolute inset-0">
                                    @if($product->hero_image)
                                        <img src="{{ asset('storage/' . $product->hero_image) }}" 
                                             alt="{{ $product->title }}"
                                             class="w-full h-full object-cover opacity-20">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-800/50 to-dark-card/50"
                                             style="background-image: url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'); background-size: cover; background-position: center;">
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-br from-dark-card/90 to-gray-900/90"></div>
                                </div>

                                <!-- Card Content -->
                                <div class="relative z-10 p-8 h-full flex flex-col justify-between">
                                    <!-- Header -->
                                    <div class="text-center">
                                        <!-- Product Icon -->
                                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center bg-gradient-to-br from-red-500 to-red-700 shadow-lg">
                                            @if($product->icon)
                                                <i class="{{ $product->icon }} text-2xl text-white"></i>
                                            @else
                                                <i class="fas fa-cube text-2xl text-white"></i>
                                            @endif
                                        </div>

                                        <!-- Product Title -->
                                        <h3 class="text-2xl font-bold text-white mb-2 font-orbitron">
                                            {{ $product->title }}
                                        </h3>

                                        <!-- Product Subtitle -->
                                        @if($product->subtitle)
                                            <p class="text-gray-400 text-sm mb-4">{{ $product->subtitle }}</p>
                                        @endif

                                        <!-- Category Badge -->
                                        @if($product->category)
                                            <span class="inline-block px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-medium mb-4">
                                                {{ $product->getCategoryLabel() }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Description -->
                                    <div class="text-center mb-6">
                                        <p class="text-gray-300 text-sm leading-relaxed">
                                            {{ Str::limit($product->short_description ?? $product->description, 120) }}
                                        </p>
                                    </div>


                                    <!-- Pricing -->
                                    <div class="text-center mb-6">
                                        @if($product->price && $product->price > 0)
                                            <div class="text-3xl font-black text-white mb-1 font-orbitron">
                                                {{ $product->getFormattedPrice() }}
                                            </div>
                                        @elseif($product->pricing_model === 'free')
                                            <div class="text-3xl font-black text-green-400 mb-1 font-orbitron">
                                                FREE
                                            </div>
                                        @elseif($product->pricing_model === 'quote')
                                            <div class="text-lg font-bold text-yellow-400 mb-1 font-orbitron">
                                                Contact for Quote
                                            </div>
                                        @endif
                                        
                                        @if($product->pricing_model)
                                            <div class="text-gray-400 text-xs">
                                                {{ ucfirst(str_replace('_', ' ', $product->pricing_model)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Action Button -->
                                    <div class="text-center">
                                        <a href="{{ $product->getUrl() }}" 
                                           class="inline-block bg-gradient-to-r from-red-600 to-red-800 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-blue-500/50">
                                            @if($product->pricing_model === 'free')
                                                <i class="fas fa-download mr-2"></i>Get Started Free
                                            @elseif($product->pricing_model === 'quote')
                                                <i class="fas fa-envelope mr-2"></i>Request Quote
                                            @else
                                                <i class="fas fa-eye mr-2"></i>View Details
                                            @endif
                                        </a>
                                    </div>

                                    <!-- Status Badges -->
                                    <div class="absolute top-4 right-4 flex flex-col space-y-1 ">
                                        @if($product->is_featured)
                                            <span class="bg-yellow-500/20 text-yellow-400 text-xs px-2 py-1 rounded-full font-medium">
                                                Featured
                                            </span>
                                        @endif
                                        @if($product->show_in_homepage)
                                            <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded-full font-medium">
                                                Popular
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Glow Effect -->
                                <div class="absolute -inset-1 bg-gradient-to-br from-red-500/30 to-red-600/30 rounded-3xl blur-xl opacity-0 group-hover:opacity-60 transition-opacity duration-300 -z-10"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button class="saas-nav-button prev" type="button" id="saasPrevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="saas-nav-button next" type="button" id="saasNextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Dots Indicator -->
            {{-- <div class="saas-dots-indicator" id="saasDotsIndicator">
                @foreach($products as $index => $product)
                    <div class="saas-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                @endforeach
            </div> --}}
        </div>

        <!-- Global CTA -->
        <div class="text-center mt-32">
            <a href="{{ route('products') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-800 text-white font-bold rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-blue-500/50">
                <i class="fas fa-rocket mr-3"></i>
                Explore All SaaS Solutions
            </a>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const saasSection = document.querySelector('#saasProductsSlider');
    if (!saasSection) return;

    const saasSlides = saasSection.querySelectorAll('.saas-slide');
    const saasDots = saasSection.querySelectorAll('.saas-dot');
    const saasPrevBtn = document.getElementById('saasPrevBtn');
    const saasNextBtn = document.getElementById('saasNextBtn');
    const totalSaasSlides = saasSlides.length;

    if (!totalSaasSlides) return;

    let currentSaasSlide = 0;
    let saasAutoRotateInterval = null;
    const saasSlideClasses = ['far-left', 'prev', 'active', 'next', 'far-right', 'hidden'];
    const SAAS_AUTO_INTERVAL = 6000; // 6 seconds

    function updateSaasSlides() {
        saasSlides.forEach((slide, index) => {
            saasSlideClasses.forEach(c => slide.classList.remove(c));

            let position = index - currentSaasSlide;
            if (position < -2) position += totalSaasSlides;
            if (position > 2) position -= totalSaasSlides;

            switch (position) {
                case -2: slide.classList.add('far-left'); break;
                case -1: slide.classList.add('prev'); break;
                case 0: slide.classList.add('active'); break;
                case 1: slide.classList.add('next'); break;
                case 2: slide.classList.add('far-right'); break;
                default: slide.classList.add('hidden'); break;
            }
        });

        saasDots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSaasSlide);
        });
    }

    function slideSaas(direction) {
        if (direction === 'next') {
            currentSaasSlide = (currentSaasSlide + 1) % totalSaasSlides;
        } else {
            currentSaasSlide = (currentSaasSlide - 1 + totalSaasSlides) % totalSaasSlides;
        }
        updateSaasSlides();
        resetSaasAutoRotate();
    }

    function slideToSaas(index) {
        if (index < 0 || index >= totalSaasSlides) return;
        currentSaasSlide = index;
        updateSaasSlides();
        resetSaasAutoRotate();
    }

    function startSaasAutoRotate() {
        if (totalSaasSlides <= 1 || saasAutoRotateInterval) return;
        saasAutoRotateInterval = setInterval(() => {
            slideSaas('next');
        }, SAAS_AUTO_INTERVAL);
    }

    function stopSaasAutoRotate() {
        if (!saasAutoRotateInterval) return;
        clearInterval(saasAutoRotateInterval);
        saasAutoRotateInterval = null;
    }

    function resetSaasAutoRotate() {
        stopSaasAutoRotate();
        startSaasAutoRotate();
    }

    // Event Listeners
    if (saasPrevBtn) saasPrevBtn.addEventListener('click', () => slideSaas('prev'));
    if (saasNextBtn) saasNextBtn.addEventListener('click', () => slideSaas('next'));

    saasDots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.dataset.index, 10);
            slideToSaas(index);
        });
    });

    saasSlides.forEach((slide, index) => {
        slide.addEventListener('click', function () {
            if (!this.classList.contains('active')) {
                slideToSaas(index);
            }
        });
    });

    // Hover events
    if (saasSection) {
        saasSection.addEventListener('mouseenter', stopSaasAutoRotate);
        saasSection.addEventListener('mouseleave', startSaasAutoRotate);
    }

    // Touch support
    let saasStartX = 0;
    let saasEndX = 0;

    if (saasSection) {
        saasSection.addEventListener('touchstart', function (e) {
            saasStartX = e.touches[0].clientX;
        });

        saasSection.addEventListener('touchend', function (e) {
            saasEndX = e.changedTouches[0].clientX;
            const threshold = 50;
            const diff = saasStartX - saasEndX;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0) slideSaas('next');
                else slideSaas('prev');
            }
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') slideSaas('prev');
        if (e.key === 'ArrowRight') slideSaas('next');
    });

    // Initialize
    updateSaasSlides();
    startSaasAutoRotate();
});
</script>
@endif
@break







@case('shop_products')
@if($page->hasActiveSection('shop_products') && isset($shopProducts) && $shopProducts->count() > 0)
<!-- Shop Products Section -->
<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-orange-900/10 to-pink-900/10"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                {{ $page->shop_products_title ?? 'PREMIUM SHOP PRODUCTS' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->shop_products_subtitle ?? 'Discover our premium shop products with exclusive special occasion pricing' }}
            </p>
        </div>

        <!-- Shop Products Slider Container -->
        <div class="relative max-w-7xl mx-auto">
            <div class="shop-products-slider-container relative h-96" id="shopProductsSlider">
                <div class="slider-track absolute w-full h-full flex items-center justify-center">
                    
                    @foreach($shopProducts as $index => $shopProduct)
                        @php
                            $position = '';
                            switch($index) {
                                case 0: $position = 'active'; break;
                                case 1: $position = 'next'; break;
                                case count($shopProducts)-1: $position = 'prev'; break;
                                case count($shopProducts)-2: $position = 'far-left'; break;
                                case 2: $position = 'far-right'; break;
                                default: $position = 'hidden'; break;
                            }
                        @endphp
                        
                        <div class="shop-products-slide {{ $position }}" data-index="{{ $index }}">
                            <div class="shop-products-card">
                                <!-- Card Background -->
                                <div class="absolute inset-0">
                                    @if($shopProduct->image)
                                        <img src="{{ asset('storage/' . $shopProduct->image) }}" 
                                             alt="{{ $shopProduct->title ?? $shopProduct->name }}"
                                             class="w-full h-full object-cover opacity-20">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-800/50 to-dark-card/50"
                                             style="background-image: url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80'); background-size: cover; background-position: center;">
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-br from-dark-card/90 to-gray-900/90"></div>
                                </div>

                                <!-- Card Content -->
                                <div class="relative z-10 p-8 h-full flex flex-col justify-between">
                                    <!-- Header -->
                                    <div class="text-center">
                                        <!-- Product Icon -->
                                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center bg-gradient-to-br from-orange-500 to-pink-600 shadow-lg">
                                            @if($shopProduct->icon)
                                                <i class="{{ $shopProduct->icon }} text-2xl text-white"></i>
                                            @else
                                                <i class="fas fa-shopping-bag text-2xl text-white"></i>
                                            @endif
                                        </div>

                                        <!-- Product Title -->
                                        <h3 class="text-2xl font-bold text-white mb-2 font-orbitron">
                                     

                                             {{ Str::limit($shopProduct->title ?? $shopProduct->name, 30) }}
                                        </h3>

                                        <!-- Product Category -->
                                        @if($shopProduct->category)
                                        <span class="inline-block px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-medium mb-4">
                                                {{ $shopProduct->category->name ?? ucfirst($shopProduct->category) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Description -->
                                    <div class="text-center mb-6">
                                        <p class="text-gray-300 text-sm leading-relaxed">
                                            {{ Str::limit($shopProduct->short_description ?? $shopProduct->description, 60) }}
                                        </p>
                                    </div>

                                    <!-- Features -->
                                    @php
                                        $features = $shopProduct->key_features ?? [];
                                        if (is_string($features)) {
                                            $features = json_decode($features, true) ?? [];
                                        }
                                        // If no key_features, create some based on product attributes
                                        if (empty($features)) {
                                            $features = [];
                                            if ($shopProduct->digital_download) $features[] = 'Digital Download';
                                            if ($shopProduct->instant_delivery) $features[] = 'Instant Delivery';
                                            if ($shopProduct->money_back_guarantee) $features[] = 'Money Back Guarantee';
                                            if (empty($features)) $features = ['Premium Quality', 'Customer Support', 'Easy Installation'];
                                        }
                                    @endphp
                                    @if($features && count($features) > 0)
                                        <div class="mb-6">
                                            <ul class="space-y-2">
                                                @foreach(array_slice($features, 0, 3) as $feature)
                                                    <li class="flex items-center text-gray-300 text-sm">
                                                        <i class="fas fa-check text-green-400 mr-2 flex-shrink-0"></i>
                                                        <span>{{ is_string($feature) ? $feature : $feature['name'] ?? 'Feature' }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Pricing -->
                                    {{-- <div class="text-center mb-6">
                                        @if($shopProduct->price && $shopProduct->price > 0)
                                            <div class="flex items-center justify-center space-x-2">
                                                @if($shopProduct->compare_price && $shopProduct->compare_price > $shopProduct->price)
                                                    <div class="text-gray-500 text-lg line-through">
                                                        ${{ number_format($shopProduct->compare_price, 2) }}
                                                    </div>
                                                @endif
                                                <div class="text-3xl font-black text-white mb-1 font-orbitron">
                                                    ${{ number_format($shopProduct->price, 2) }}
                                                </div>
                                            </div>
                                            @if($shopProduct->compare_price && $shopProduct->compare_price > $shopProduct->price)
                                                @php
                                                    $discount = round((($shopProduct->compare_price - $shopProduct->price) / $shopProduct->compare_price) * 100);
                                                @endphp
                                                <div class="text-yellow-400 text-sm font-medium">
                                                    Save {{ $discount }}%
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-lg font-bold text-yellow-400 mb-1 font-orbitron">
                                                Contact for Price
                                            </div>
                                        @endif
                                    </div> --}}

                                    <!-- Action Button -->
                                    <div class="text-center">
                                        <a href="{{ route('shop.product', $shopProduct->slug) }}" 
                                           class="inline-block bg-gradient-to-r from-red-600 to-red-800 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-red-500/50">
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            @if($shopProduct->price > 0)
                                                Add to Cart
                                            @else
                                                View Details
                                            @endif
                                        </a>
                                    </div>

                                    <!-- Status Badges -->
                                    <div class="absolute top-4 right-4 flex flex-col space-y-1">
                                        @if($shopProduct->is_featured)
                                            <span class="bg-yellow-500/20 text-yellow-400 text-xs px-2 py-1 rounded-full font-medium">
                                                Featured
                                            </span>
                                        @endif
                                        @if($shopProduct->on_sale)
                                            <span class="bg-red-500/20 text-red-400 text-xs px-2 py-1 rounded-full font-medium">
                                                On Sale
                                            </span>
                                        @endif
                                        @if($shopProduct->digital_download)
                                            <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-1 rounded-full font-medium">
                                                Digital
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Glow Effect -->
                                <div class="absolute -inset-1 bg-gradient-to-br from-red-500/30 to-red-600/30 rounded-3xl blur-xl opacity-0 group-hover:opacity-60 transition-opacity duration-300 -z-10"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button class="shop-products-nav-button prev" type="button" id="shopProductsPrevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="shop-products-nav-button next" type="button" id="shopProductsNextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>

                
              
            </div>

            <!-- Dots Indicator -->
            {{-- <div class="shop-products-dots-indicator" id="shopProductsDotsIndicator">
                @foreach($shopProducts as $index => $shopProduct)
                    <div class="shop-products-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                @endforeach
            </div> --}}
        </div>

        <!-- Global CTA -->
        <div class="text-center mt-12">
            <a href="{{ route('shop.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-800 text-white font-bold rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-red-500/50">
                <i class="fas fa-shopping-bag mr-3"></i>
                View All Shop Products
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const shopProductsSection = document.querySelector('#shopProductsSlider');
    if (!shopProductsSection) return;

    const shopProductsSlides = shopProductsSection.querySelectorAll('.shop-products-slide');
    const shopProductsDots = shopProductsSection.querySelectorAll('.shop-products-dot');
    const shopProductsPrevBtn = document.getElementById('shopProductsPrevBtn');
    const shopProductsNextBtn = document.getElementById('shopProductsNextBtn');
    const totalShopProductsSlides = shopProductsSlides.length;

    if (!totalShopProductsSlides) return;

    let currentShopProductsSlide = 0;
    let shopProductsAutoRotateInterval = null;
    const shopProductsSlideClasses = ['far-left', 'prev', 'active', 'next', 'far-right', 'hidden'];
    const SHOP_PRODUCTS_AUTO_INTERVAL = 6000; // 6 seconds

    function updateShopProductsSlides() {
        shopProductsSlides.forEach((slide, index) => {
            shopProductsSlideClasses.forEach(c => slide.classList.remove(c));

            let position = index - currentShopProductsSlide;
            if (position < -2) position += totalShopProductsSlides;
            if (position > 2) position -= totalShopProductsSlides;

            switch (position) {
                case -2: slide.classList.add('far-left'); break;
                case -1: slide.classList.add('prev'); break;
                case 0: slide.classList.add('active'); break;
                case 1: slide.classList.add('next'); break;
                case 2: slide.classList.add('far-right'); break;
                default: slide.classList.add('hidden'); break;
            }
        });

        shopProductsDots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentShopProductsSlide);
        });
    }

    function slideShopProducts(direction) {
        if (direction === 'next') {
            currentShopProductsSlide = (currentShopProductsSlide + 1) % totalShopProductsSlides;
        } else {
            currentShopProductsSlide = (currentShopProductsSlide - 1 + totalShopProductsSlides) % totalShopProductsSlides;
        }
        updateShopProductsSlides();
        resetShopProductsAutoRotate();
    }

    function slideToShopProducts(index) {
        if (index < 0 || index >= totalShopProductsSlides) return;
        currentShopProductsSlide = index;
        updateShopProductsSlides();
        resetShopProductsAutoRotate();
    }

    function startShopProductsAutoRotate() {
        if (totalShopProductsSlides <= 1 || shopProductsAutoRotateInterval) return;
        shopProductsAutoRotateInterval = setInterval(() => {
            slideShopProducts('next');
        }, SHOP_PRODUCTS_AUTO_INTERVAL);
    }

    function stopShopProductsAutoRotate() {
        if (!shopProductsAutoRotateInterval) return;
        clearInterval(shopProductsAutoRotateInterval);
        shopProductsAutoRotateInterval = null;
    }

    function resetShopProductsAutoRotate() {
        stopShopProductsAutoRotate();
        startShopProductsAutoRotate();
    }

    // Event Listeners
    if (shopProductsPrevBtn) shopProductsPrevBtn.addEventListener('click', () => slideShopProducts('prev'));
    if (shopProductsNextBtn) shopProductsNextBtn.addEventListener('click', () => slideShopProducts('next'));

    shopProductsDots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.dataset.index, 10);
            slideToShopProducts(index);
        });
    });

    shopProductsSlides.forEach((slide, index) => {
        slide.addEventListener('click', function () {
            if (!this.classList.contains('active')) {
                slideToShopProducts(index);
            }
        });
    });

    // Hover events
    if (shopProductsSection) {
        shopProductsSection.addEventListener('mouseenter', stopShopProductsAutoRotate);
        shopProductsSection.addEventListener('mouseleave', startShopProductsAutoRotate);
    }

    // Touch support
    let shopProductsStartX = 0;
    let shopProductsEndX = 0;

    if (shopProductsSection) {
        shopProductsSection.addEventListener('touchstart', function (e) {
            shopProductsStartX = e.touches[0].clientX;
        });

        shopProductsSection.addEventListener('touchend', function (e) {
            shopProductsEndX = e.changedTouches[0].clientX;
            const threshold = 50;
            const diff = shopProductsStartX - shopProductsEndX;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0) slideShopProducts('next');
                else slideShopProducts('prev');
            }
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') slideShopProducts('prev');
        if (e.key === 'ArrowRight') slideShopProducts('next');
    });

    // Initialize
    updateShopProductsSlides();
    startShopProductsAutoRotate();
});
</script>
@endif
@break


@case('video')
@if($page->hasActiveSection('video'))
<!-- Video Section -->
<section class="py-20 relative overflow-hidden" 
         style="background-image: url('https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2500&q=80'); background-size: cover; background-position: center;">
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
                        @php
                            // Determine video source priority: uploaded file takes precedence over URL
                            $hasUploadedVideo = !empty($page->video_file) && \Storage::disk('public')->exists($page->video_file);
                            $hasVideoUrl = !empty($page->video_url);
                            
                            // Check if URL is YouTube/Vimeo embed
                            $isYoutube = $hasVideoUrl && (str_contains($page->video_url, 'youtube.com') || str_contains($page->video_url, 'youtu.be'));
                            $isVimeo = $hasVideoUrl && str_contains($page->video_url, 'vimeo.com');
                            $isEmbed = $isYoutube || $isVimeo;
                        @endphp

                        @if($hasUploadedVideo)
                            {{-- Uploaded MP4 video with custom controls --}}
                            <video id="videoPlayer" 
                                   class="w-full h-full object-cover" 
                                   poster="{{ $page->video_thumbnail ? asset('storage/'.$page->video_thumbnail) : 'https://media.istockphoto.com/id/1041174316/photo/european-telecommunication-network-connected-over-europe-france-germany-uk-italy-concept.webp?a=1&b=1&s=612x612&w=0&k=20&c=elHHTOV7XD6d4QpDljTBsUabpbCHudVhv9xXaj6UBnM=' }}"
                                   preload="metadata">
                                <source src="{{ asset('storage/'.$page->video_file) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            
                        @elseif($hasVideoUrl)
                            @if($isEmbed)
                                {{-- YouTube/Vimeo iframe --}}
                                <iframe id="videoIframe" 
                                        src="{{ $page->video_url }}?enablejsapi=1&controls=0&rel=0&modestbranding=1&showinfo=0"
                                        class="w-full h-full"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            @else
                                {{-- Direct URL MP4 video with custom controls --}}
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

                        <!-- Video Controls Overlay (Only for MP4 videos, not iframes) -->
                        @if(($hasUploadedVideo || ($hasVideoUrl && !$isEmbed)) && ($hasUploadedVideo || $hasVideoUrl))
                            <div class="absolute inset-0 flex flex-col opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none group-hover:pointer-events-auto" id="videoControls">
                                <!-- Top Controls -->
                                <div class="flex justify-between items-center p-4 pt-2">
                                    <div class="flex items-center space-x-2">
                                        <button id="playPauseBtn" class="video-control-btn w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-white text-xl transition-all duration-200" data-action="playpause">
                                            <i class="fas fa-play"></i>
                                        </button>
                                        <button id="muteBtn" class="video-control-btn w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-white text-xl transition-all duration-200" data-action="mute">
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
                        @endif

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

    // Only work with native video (not iframes)
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

    // Mute/Unmute
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

    // Event Listeners
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
@endif
@break




    @case('clients')
     @if($page->hasActiveSection('clients'))
<!-- Clients Slider -->


<section class="py-20 bg-dark relative overflow-hidden">
    <!-- Epic Background -->
    <div class="absolute inset-0 z-0">
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-secondary to-transparent opacity-30"></div>
        <div class="absolute top-10 left-10 w-72 h-72 bg-primary/8 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-secondary/6 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-accent/4 rounded-full blur-3xl animate-pulse"></div>
    </div>
    
    <div class="w-full px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black font-orbitron mb-4">
                {{ $page->clients_title ?? 'TRUSTED BY GIANTS' }}
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                {{ $page->clients_subtitle ?? 'Join thousands of satisfied clients who trust our solutions' }}
            </p>
        </div>
        
        <!-- Epic Logo Showcase -->
        <div class="space-y-12 w-full overflow-hidden">
            
            @if($clientsByCategory->has('streaming') && $clientsByCategory['streaming']->count() > 0)
            <!-- First Row - Streaming Giants -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-black/40 via-primary/5 to-black/40 p-8 backdrop-blur-sm border border-white/5">
                <!-- Gradient Overlays for Smooth Effect -->
                <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-black/40 to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-black/40 to-transparent z-10 pointer-events-none"></div>
                
                <div class="marquee-container">
                    <div class="marquee-content marquee-left-smooth">
                        @php
                            $streamingClients = $clientsByCategory['streaming'];
                            $tripleClients = $streamingClients->concat($streamingClients)->concat($streamingClients);
                        @endphp
                        
                        @foreach($tripleClients as $client)
                            <div class="flex-shrink-0 w-48 h-24 rounded-2xl flex items-center justify-center group transition-all duration-500 border backdrop-blur-sm mx-6 client-card"
                                 style="background-color: {{ $client->background_color ?: '#FFFFFF' }}; 
                                        border-color: {{ $client->border_color ?: 'rgba(255,255,255,0.2)' }};
                                        opacity: {{ $client->opacity ?: '1' }};"
                                 data-hover-bg="{{ $client->hover_background_color ?: '#F5F5F5' }}"
                                 data-hover-opacity="{{ $client->hover_opacity ?: '0.8' }}"
                                 data-hover-scale="{{ $client->hover_scale ?: '1.1' }}"
                                 @if($client->website_url) onclick="window.open('{{ $client->website_url }}', '_blank')" style="cursor: pointer;" @endif>
                                @if($client->logo)
                                    <img src="{{ $client->getLogoUrl() }}" 
                                         alt="{{ $client->name }}" 
                                         class="max-w-[75%] max-h-[55%] object-contain transition-transform duration-300"
                                         loading="lazy">
                                @else
                                    <span class="text-lg font-bold transition-transform duration-300">{{ $client->name }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            @if($clientsByCategory->has('news_sports') && $clientsByCategory['news_sports']->count() > 0)
            <!-- Second Row - News & Sports -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-black/40 via-secondary/5 to-black/40 p-8 backdrop-blur-sm border border-white/5">
                <!-- Gradient Overlays for Smooth Effect -->
                <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-black/40 to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-black/40 to-transparent z-10 pointer-events-none"></div>
                
                <div class="marquee-container">
                    <div class="marquee-content marquee-right-smooth">
                        @php
                            $newsClients = $clientsByCategory['news_sports'];
                            $tripleNewsClients = $newsClients->concat($newsClients)->concat($newsClients);
                        @endphp
                        
                        @foreach($tripleNewsClients as $client)
                            <div class="flex-shrink-0 w-48 h-24 rounded-2xl flex items-center justify-center group transition-all duration-500 border backdrop-blur-sm mx-6 client-card"
                                 style="background-color: {{ $client->background_color ?: '#FFFFFF' }}; 
                                        border-color: {{ $client->border_color ?: 'rgba(255,255,255,0.2)' }};
                                        opacity: {{ $client->opacity ?: '1' }};"
                                 data-hover-bg="{{ $client->hover_background_color ?: '#F5F5F5' }}"
                                 data-hover-opacity="{{ $client->hover_opacity ?: '0.8' }}"
                                 data-hover-scale="{{ $client->hover_scale ?: '1.1' }}"
                                 @if($client->website_url) onclick="window.open('{{ $client->website_url }}', '_blank')" style="cursor: pointer;" @endif>
                                @if($client->logo)
                                    <img src="{{ $client->getLogoUrl() }}" 
                                         alt="{{ $client->name }}" 
                                         class="max-w-[75%] max-h-[55%] object-contain transition-transform duration-300"
                                         loading="lazy">
                                @else
                                    <span class="text-lg font-bold transition-transform duration-300">{{ $client->name }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            @if($clientsByCategory->has('tech_gaming') && $clientsByCategory['tech_gaming']->count() > 0)
            <!-- Third Row - Tech & Gaming -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-black/40 via-accent/5 to-black/40 p-8 backdrop-blur-sm border border-white/5">
                <!-- Gradient Overlays for Smooth Effect -->
                <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-black/40 to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-black/40 to-transparent z-10 pointer-events-none"></div>
                
                <div class="marquee-container">
                    <div class="marquee-content marquee-left-smooth">
                        @php
                            $techClients = $clientsByCategory['tech_gaming'];
                            $tripleTechClients = $techClients->concat($techClients)->concat($techClients);
                        @endphp
                        
                        @foreach($tripleTechClients as $client)
                            <div class="flex-shrink-0 w-48 h-24 rounded-2xl flex items-center justify-center group transition-all duration-500 border backdrop-blur-sm mx-6 client-card"
                                 style="background-color: {{ $client->background_color ?: '#FFFFFF' }}; 
                                        border-color: {{ $client->border_color ?: 'rgba(255,255,255,0.2)' }};
                                        opacity: {{ $client->opacity ?: '1' }};"
                                 data-hover-bg="{{ $client->hover_background_color ?: '#F5F5F5' }}"
                                 data-hover-opacity="{{ $client->hover_opacity ?: '0.8' }}"
                                 data-hover-scale="{{ $client->hover_scale ?: '1.1' }}"
                                 @if($client->website_url) onclick="window.open('{{ $client->website_url }}', '_blank')" style="cursor: pointer;" @endif>
                                @if($client->logo)
                                    <img src="{{ $client->getLogoUrl() }}" 
                                         alt="{{ $client->name }}" 
                                         class="max-w-[75%] max-h-[55%] object-contain transition-transform duration-300"
                                         loading="lazy">
                                @else
                                    <span class="text-lg font-bold transition-transform duration-300">{{ $client->name }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        
        </div>
        
        <!-- Epic Closing -->
        <div class="text-center mt-20">
            <p class="text-xl text-gray-400 font-medium">
                Ready to join the elite?
            </p>
        </div>
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle all optional hover effects from admin settings
    const clientCards = document.querySelectorAll('.client-card');
    
    clientCards.forEach(card => {
        const hoverBg = card.dataset.hoverBg;
        const hoverOpacity = card.dataset.hoverOpacity;
        const hoverScale = card.dataset.hoverScale;
        
        const originalBg = card.style.backgroundColor;
        const originalOpacity = card.style.opacity;
        
        card.addEventListener('mouseenter', function() {
            // Apply hover background if set
            if (hoverBg && hoverBg !== originalBg) {
                this.style.backgroundColor = hoverBg;
            }
            
            // Apply hover opacity if set
            if (hoverOpacity && hoverOpacity !== originalOpacity) {
                this.style.opacity = hoverOpacity;
            }
            
            // Apply hover scale if set
            if (hoverScale && hoverScale !== '1') {
                this.style.transform = `scale(${hoverScale}) translateY(-2px)`;
            }
        });
        
        card.addEventListener('mouseleave', function() {
            // Reset to original values
            this.style.backgroundColor = originalBg;
            this.style.opacity = originalOpacity;
            this.style.transform = 'scale(1) translateY(0)';
        });
    });
    
    // Intersection Observer for performance - only animate when visible
    const marqueeElements = document.querySelectorAll('.marquee-content, .partners-track');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            } else {
                entry.target.style.animationPlayState = 'paused';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });
    
    marqueeElements.forEach(element => {
        observer.observe(element);
    });

    // Prevent animation jank on page load
    window.addEventListener('load', function() {
        document.body.classList.add('animations-ready');
    });

    // Add smooth scroll behavior for better performance
    let ticking = false;
    
    function updateAnimations() {
        // Update any dynamic animations here if needed
        ticking = false;
    }

    function requestAnimationUpdate() {
        if (!ticking) {
            requestAnimationFrame(updateAnimations);
            ticking = true;
        }
    }

    // Optimize scroll performance
    window.addEventListener('scroll', requestAnimationUpdate, { passive: true });
});
</script>
  @endif
 @break


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
            <div class="text-center ">
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
        <div class="border-t border-gray-800/50 pt-12 ">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Social Links -->
                <div class="flex space-x-6">
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