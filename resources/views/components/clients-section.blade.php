@php
    use App\Models\Client;
    $clientsByCategory = Client::getGroupedByCategory();
@endphp

<section class="py-20 bg-dark relative overflow-hidden">
    <!-- Epic Background -->
    <div class="absolute inset-0 z-0">
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-secondary to-transparent opacity-30"></div>
        <div class="absolute top-10 left-10 w-72 h-72 bg-primary/8 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-secondary/6 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-accent/4 rounded-full blur-3xl animate-pulse"></div>
    </div>
    
    <div class="w-full px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Epic Header -->
        <div class="text-center mb-20">
            <h2 class="text-6xl md:text-7xl lg:text-8xl font-black mb-8 leading-none tracking-tight text-transparent bg-gradient-to-b from-red-500 to-red-900 bg-clip-text opacity-60">
                OUR CLIENTS
            </h2>
            <p class="text-xl text-gray-400 font-medium">
                The masterminds behind your success
            </p>
        </div>
        
        <!-- Epic Logo Showcase -->
        <div class="space-y-8 w-full overflow-hidden">
            
            @if($clientsByCategory->has('streaming') && $clientsByCategory['streaming']->count() > 0)
            <!-- First Row - Streaming Giants -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-black/40 via-primary/5 to-black/40 p-8 backdrop-blur-sm border border-white/5">
                <!-- Gradient Overlays for Smooth Effect -->
                <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-black/40 to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-black/40 to-transparent z-10 pointer-events-none"></div>
                
                <div class="marquee-container">
                    <!-- الصف الأول: من اليمين للشمال -->
                    <div class="marquee-content marquee-clients-right-to-left flex items-center gap-10" data-category="streaming">
                        @php
                            $streamingClients = $clientsByCategory['streaming'];
                            // تكرار العناصر للحصول على حلقة مستمرة - 30 بطاقة
                            $displayClients = collect();
                            for($i = 0; $i < 30; $i++) {
                                $displayClients->push($streamingClients[$i % $streamingClients->count()]);
                            }
                        @endphp
                        
                        @foreach($displayClients as $client)
                            <div class="flex-shrink-0 w-64 h-36 rounded-2xl flex items-center justify-center group transition-all duration-500 backdrop-blur-sm hover:scale-110 hover:rotate-1 cursor-pointer border border-white/10 hover:border-white/30 shadow-lg hover:shadow-2xl client-card p-4"
                                 style="background-color: {{ $client->background_color ?: 'rgba(255,255,255,0.05)' }}; border-color: {{ $client->border_color ?: 'rgba(255,255,255,0.2)' }};"
                                 @if($client->website_url) onclick="window.open('{{ $client->website_url }}', '_blank')" title="Visit {{ $client->name }}" @endif>
                                
                                @if($client->logo)
                                    <img src="{{ $client->getLogoUrl() }}" 
                                         alt="{{ $client->name }}" 
                                         class="max-h-16 max-w-[75%] object-contain transition-all duration-500 group-hover:scale-110 filter brightness-90 group-hover:brightness-110"
                                         loading="lazy">
                                @else
                                    <span class="text-white text-base font-bold transition-all duration-300 group-hover:text-red-400">{{ $client->name }}</span>
                                @endif
                                
                                <!-- Hover Overlay Effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-500/10 to-red-500/0 opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-2xl"></div>
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
                    <!-- الصف التاني: من الشمال لليمين (عكس الأول) -->
                    <div class="marquee-content marquee-clients-left-to-right flex items-center gap-10" data-category="news_sports">
                        @php
                            $newsClients = $clientsByCategory['news_sports'];
                            // نفس التكرار - 30 بطاقة
                            $displayNewsClients = collect();
                            for($i = 0; $i < 30; $i++) {
                                $displayNewsClients->push($newsClients[$i % $newsClients->count()]);
                            }
                        @endphp
                        
                        @foreach($displayNewsClients as $client)
                            <div class="flex-shrink-0 w-64 h-36 rounded-2xl flex items-center justify-center group transition-all duration-500 backdrop-blur-sm hover:scale-110 hover:rotate-1 cursor-pointer border border-white/10 hover:border-white/30 shadow-lg hover:shadow-2xl client-card p-4"
                                 style="background-color: {{ $client->background_color ?: 'rgba(255,255,255,0.05)' }}; border-color: {{ $client->border_color ?: 'rgba(255,255,255,0.2)' }};"
                                 @if($client->website_url) onclick="window.open('{{ $client->website_url }}', '_blank')" title="Visit {{ $client->name }}" @endif>
                                
                                @if($client->logo)
                                    <img src="{{ $client->getLogoUrl() }}" 
                                         alt="{{ $client->name }}" 
                                         class="max-h-16 max-w-[75%] object-contain transition-all duration-500 group-hover:scale-110 filter brightness-90 group-hover:brightness-110"
                                         loading="lazy">
                                @else
                                    <span class="text-white text-base font-bold transition-all duration-300 group-hover:text-red-400">{{ $client->name }}</span>
                                @endif
                                
                                <!-- Hover Overlay Effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-500/10 to-red-500/0 opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-2xl"></div>
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
                    <!-- الصف التالت: من اليمين للشمال (زي الأول) -->
                    <div class="marquee-content marquee-clients-right-to-left flex items-center gap-10" data-category="tech_gaming">
                        @php
                            $techClients = $clientsByCategory['tech_gaming'];
                            // نفس التكرار - 30 بطاقة
                            $displayTechClients = collect();
                            for($i = 0; $i < 30; $i++) {
                                $displayTechClients->push($techClients[$i % $techClients->count()]);
                            }
                        @endphp
                        
                        @foreach($displayTechClients as $client)
                            <div class="flex-shrink-0 w-64 h-36 rounded-2xl flex items-center justify-center group transition-all duration-500 backdrop-blur-sm hover:scale-110 hover:rotate-1 cursor-pointer border border-white/10 hover:border-white/30 shadow-lg hover:shadow-2xl client-card p-4"
                                 style="background-color: {{ $client->background_color ?: 'rgba(255,255,255,0.05)' }}; border-color: {{ $client->border_color ?: 'rgba(255,255,255,0.2)' }};"
                                 @if($client->website_url) onclick="window.open('{{ $client->website_url }}', '_blank')" title="Visit {{ $client->name }}" @endif>
                                
                                @if($client->logo)
                                    <img src="{{ $client->getLogoUrl() }}" 
                                         alt="{{ $client->name }}" 
                                         class="max-h-16 max-w-[75%] object-contain transition-all duration-500 group-hover:scale-110 filter brightness-90 group-hover:brightness-110"
                                         loading="lazy">
                                @else
                                    <span class="text-white text-base font-bold transition-all duration-300 group-hover:text-red-400">{{ $client->name }}</span>
                                @endif
                                
                                <!-- Hover Overlay Effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-500/10 to-red-500/0 opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-2xl"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            @if($clientsByCategory->has('other') && $clientsByCategory['other']->count() > 0)
            <!-- PARTNERS Section - Enhanced with Smooth Animation -->
            <div class="mt-8 md:mt-12 bg-gradient-to-br to-black rounded-3xl p-8 md:p-12 border border-white/10 shadow-2xl overflow-hidden relative">
                <!-- Background Effects -->
                <div class="absolute inset-0 opacity-30">
                    <div class="absolute top-0 left-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-secondary/8 rounded-full blur-3xl animate-pulse"></div>
                    <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-accent/6 rounded-full blur-3xl animate-pulse"></div>
                </div>

                <!-- Header -->
                <div class="text-center mb-8 md:mb-12 relative z-10">
                    <h2 class="text-5xl md:text-6xl lg:text-7xl font-extrabold bg-gradient-to-br from-red-400 via-red-500 to-red-700 text-transparent bg-clip-text drop-shadow-lg">
                        PARTNERS
                    </h2>
                    <div class="mt-4 h-1 w-32 bg-gradient-to-r from-transparent via-red-500 to-transparent mx-auto rounded-full"></div>
                    <p class="mt-4 md:mt-6 text-xl text-gray-300 font-medium tracking-wide">
                        Powerful collaborations that fuel our mission
                    </p>
                </div>

                <!-- Partners Logos Container -->
                <div class="relative z-10">
                    <!-- Gradient Overlays for Smooth Fade Effect -->
                    <div class="absolute left-0 top-0 bottom-0 w-20 bg-gradient-to-r from-[#1a1a1a] to-transparent z-20 pointer-events-none"></div>
                    <div class="absolute right-0 top-0 bottom-0 w-20 bg-gradient-to-l from-[#1a1a1a] to-transparent z-20 pointer-events-none"></div>
                    
                    <!-- Animated Logos Track -->
                    <div class="marquee-container">
                        <div class="marquee-content marquee-scroll-left flex items-center gap-10" data-category="partners">
                            @php
                                $otherClients = $clientsByCategory['other'];
                                // نفس التكرار للبارتنرز - 30 بطاقة
                                $displayOtherClients = collect();
                                for($i = 0; $i < 30; $i++) {
                                    $displayOtherClients->push($otherClients[$i % $otherClients->count()]);
                                }
                            @endphp
                            
                            @foreach($displayOtherClients as $client)
                                <div class="partner-logo-card flex-shrink-0 w-64 h-36 flex items-center justify-center rounded-2xl backdrop-blur-sm transition-all duration-500 hover:scale-110 hover:rotate-1 group cursor-pointer border border-white/10 hover:border-white/30 shadow-lg hover:shadow-2xl p-4"
                                     style="background-color: {{ $client->background_color ?: 'rgba(255,255,255,0.05)' }}; border-color: {{ $client->border_color ?: 'rgba(255,255,255,0.2)' }};"
                                     @if($client->website_url) 
                                         onclick="window.open('{{ $client->website_url }}', '_blank')"
                                         title="Visit {{ $client->name }}"
                                     @endif>
                                    
                                    @if($client->logo)
                                        <img src="{{ $client->getLogoUrl() }}"
                                             alt="{{ $client->name }}"
                                             class="max-h-16 max-w-[75%] object-contain transition-all duration-500 group-hover:scale-110 filter brightness-90 group-hover:brightness-110"
                                             loading="lazy">
                                    @else
                                        <span class="text-white text-base font-bold transition-all duration-300 group-hover:text-red-400">
                                            {{ $client->name }}
                                        </span>
                                    @endif
                                    
                                    <!-- Hover Overlay Effect -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-500/10 to-red-500/0 opacity-0 group-hover:opacity-100 transition-all duration-500 rounded-2xl"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Bottom Accent -->
                <div class="mt-6 md:mt-8 flex justify-center relative z-10">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full animate-bounce"></div>
                        <div class="w-3 h-3 bg-red-400 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                        <div class="w-3 h-3 bg-red-600 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Epic Closing -->
        <div class="text-center mt-12 md:mt-16">
            <p class="text-xl text-gray-400 font-medium">
                Ready to join the elite?
            </p>
        </div>
    </div>
</section>

<style>
/* 🚀 ZERO DELAY MARQUEE SYSTEM - Updated for 30 cards */
.marquee-container {
    overflow: hidden;
    position: relative;
    width: 100%;
    /* CRITICAL: GPU acceleration */
    transform: translateZ(0);
    will-change: transform;
    contain: layout style paint;
}

.marquee-content {
    display: flex;
    align-items: center;
    white-space: nowrap;
    
    /* 🎯 CRITICAL: Remove all fill modes that cause delays */
    animation-fill-mode: none !important;
    animation-delay: 0s !important;
    animation-play-state: running !important;
    animation-timing-function: linear !important;
    animation-iteration-count: infinite !important;
    
    /* PERFORMANCE OPTIMIZATIONS */
    will-change: transform;
    backface-visibility: hidden;
    perspective: 1000px;
    transform: translateZ(0);
    
    /* FIXED WIDTH: 30 cards * (256px + 40px gap) = 8880px */
    width: 8880px !important;
    min-width: 8880px !important;
}

/* 🔥 SEAMLESS ANIMATIONS - ZERO DELAYS */
.marquee-clients-right-to-left {
    animation: zero-delay-rtl 75s linear infinite !important;
}

.marquee-clients-left-to-right {
    animation: zero-delay-ltr 75s linear infinite !important;
}

.marquee-scroll-left {
    animation: zero-delay-partners 75s linear infinite !important;
}

/* 🎯 CRITICAL: Perfect keyframes calculations */
@keyframes zero-delay-rtl {
    0% {
        transform: translate3d(0, 0, 0);
    }
    100% {
        /* Move exactly half the width for seamless loop */
        transform: translate3d(-4440px, 0, 0); /* Half of 8880px */
    }
}

@keyframes zero-delay-ltr {
    0% {
        transform: translate3d(-4440px, 0, 0);
    }
    100% {
        transform: translate3d(0, 0, 0);
    }
}

@keyframes zero-delay-partners {
    0% {
        transform: translate3d(0, 0, 0);
    }
    100% {
        transform: translate3d(-4440px, 0, 0);
    }
}

/* CARD STYLES */
.client-card,
.partner-logo-card {
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    
    /* EXACT FIXED DIMENSIONS */
    width: 256px !important;
    height: 144px !important;
    flex-shrink: 0 !important;
    
    /* PERFORMANCE */
    backface-visibility: hidden;
    transform: translateZ(0);
}

.client-card::before,
.partner-logo-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.6s ease;
}

.client-card:hover::before,
.partner-logo-card:hover::before {
    left: 100%;
}

.client-card:hover,
.partner-logo-card:hover {
    box-shadow: 
        0 20px 25px -5px rgba(0, 0, 0, 0.3),
        0 25px 50px -12px rgba(197, 48, 48, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    border-color: rgba(197, 48, 48, 0.5);
}

.client-card img,
.client-card span,
.partner-logo-card img,
.partner-logo-card span {
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.client-card:hover img,
.client-card:hover span,
.partner-logo-card:hover img,
.partner-logo-card:hover span {
    transform: scale(1.1);
    filter: brightness(110%);
}

/* RESPONSIVE BREAKPOINTS */
@media (max-width: 768px) {
    .marquee-content {
        /* MOBILE: 30 cards * (200px + 32px gap) = 6960px */
        width: 6960px !important;
        min-width: 6960px !important;
    }
    
    .client-card,
    .partner-logo-card {
        width: 200px !important;
        height: 100px !important;
    }
    
    @keyframes zero-delay-rtl {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-3480px, 0, 0); } /* Half of 6960px */
    }
    
    @keyframes zero-delay-ltr {
        0% { transform: translate3d(-3480px, 0, 0); }
        100% { transform: translate3d(0, 0, 0); }
    }
    
    @keyframes zero-delay-partners {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-3480px, 0, 0); }
    }
    
    .marquee-clients-right-to-left,
    .marquee-clients-left-to-right,
    .marquee-scroll-left {
        animation-duration: 55s !important;
    }
}

@media (max-width: 480px) {
    .marquee-content {
        /* SMALL MOBILE: 30 cards * (180px + 24px gap) = 6120px */
        width: 6120px !important;
        min-width: 6120px !important;
    }
    
    .client-card,
    .partner-logo-card {
        width: 180px !important;
        height: 90px !important;
    }
    
    @keyframes zero-delay-rtl {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-3060px, 0, 0); } /* Half of 6120px */
    }
    
    @keyframes zero-delay-ltr {
        0% { transform: translate3d(-3060px, 0, 0); }
        100% { transform: translate3d(0, 0, 0); }
    }
    
    @keyframes zero-delay-partners {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-3060px, 0, 0); }
    }
    
    .marquee-clients-right-to-left,
    .marquee-clients-left-to-right,
    .marquee-scroll-left {
        animation-duration: 45s !important;
    }
}

/* LOAD STATE OPTIMIZATION */
.client-card img,
.partner-logo-card img {
    opacity: 0;
    animation: fadeInImage 0.5s ease-in-out 0.2s forwards;
}

@keyframes fadeInImage {
    to { opacity: 1; }
}

/* SAFARI COMPATIBILITY */
@supports (-webkit-appearance: none) {
    .marquee-content {
        -webkit-animation-fill-mode: none !important;
        -webkit-animation-play-state: running !important;
        -webkit-transform: translateZ(0);
    }
}

/* FORCE HARDWARE ACCELERATION */
.marquee-content,
.client-card,
.partner-logo-card {
    transform: translateZ(0);
    backface-visibility: hidden;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 🚀 ZERO DELAY ANIMATION SYSTEM - UPDATED FOR 30 CARDS
    class ZeroDelayMarquee {
        constructor() {
            this.marquees = document.querySelectorAll('.marquee-content');
            this.isVisible = true;
            this.animationController = null;
            
            this.init();
        }

        init() {
            console.log('🚀 Initializing Zero Delay Marquee System for 30 cards...');
            
            // WAIT FOR STYLES TO LOAD
            this.waitForStyles().then(() => {
                this.setupMarquees();
                this.setupVisibilityHandling();
                this.setupResizeHandling();
                this.startMonitoring();
                this.forceAnimations();
                
                console.log('✅ Zero Delay Marquee System Active - 30 cards display ready!');
            });
        }

        waitForStyles() {
            return new Promise((resolve) => {
                // Check if styles are loaded
                if (document.styleSheets.length > 0) {
                    setTimeout(resolve, 100); // Small delay for CSS to apply
                } else {
                    setTimeout(() => this.waitForStyles().then(resolve), 50);
                }
            });
        }

        setupMarquees() {
            this.marquees.forEach((marquee, index) => {
                // 🎯 CRITICAL: Force all animation properties
                marquee.style.animationFillMode = 'none';
                marquee.style.animationDelay = '0s';
                marquee.style.animationPlayState = 'running';
                marquee.style.animationTimingFunction = 'linear';
                marquee.style.animationIterationCount = 'infinite';
                
                // FORCE GPU ACCELERATION
                marquee.style.transform = 'translateZ(0)';
                marquee.style.willChange = 'transform';
                marquee.style.backfaceVisibility = 'hidden';
                
                // ENSURE PROPER DIMENSIONS
                this.updateMarqueeDimensions(marquee);
                
                console.log(`✅ Marquee ${index + 1} configured for zero delays with 30 cards`);
            });
        }

        updateMarqueeDimensions(marquee) {
            const screenWidth = window.innerWidth;
            let totalWidth, animationDuration;
            
            if (screenWidth <= 480) {
                totalWidth = 6120; // 30 * (180 + 24)
                animationDuration = '45s';
            } else if (screenWidth <= 768) {
                totalWidth = 6960; // 30 * (200 + 32)
                animationDuration = '55s';
            } else {
                totalWidth = 8880; // 30 * (256 + 40)
                animationDuration = '75s';
            }
            
            marquee.style.width = totalWidth + 'px';
            marquee.style.minWidth = totalWidth + 'px';
            marquee.style.animationDuration = animationDuration;
            
            // UPDATE CARD DIMENSIONS
            const cards = marquee.querySelectorAll('.client-card, .partner-logo-card');
            cards.forEach(card => {
                if (screenWidth <= 480) {
                    card.style.width = '180px';
                    card.style.height = '90px';
                } else if (screenWidth <= 768) {
                    card.style.width = '200px';
                    card.style.height = '100px';
                } else {
                    card.style.width = '256px';
                    card.style.height = '144px';
                }
                card.style.flexShrink = '0';
            });
        }

        setupVisibilityHandling() {
            // HANDLE TAB VISIBILITY CHANGE
            document.addEventListener('visibilitychange', () => {
                this.isVisible = !document.hidden;
                if (this.isVisible) {
                    setTimeout(() => {
                        this.forceAnimations();
                        console.log('🔄 Animations restored after tab focus');
                    }, 100);
                }
            });

            // HANDLE WINDOW FOCUS/BLUR
            window.addEventListener('focus', () => {
                this.isVisible = true;
                setTimeout(() => this.forceAnimations(), 50);
            });

            window.addEventListener('blur', () => {
                this.isVisible = false;
            });
        }

        setupResizeHandling() {
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    this.handleResize();
                    console.log('🔄 Animations updated for new screen size');
                }, 150);
            });

            // HANDLE ORIENTATION CHANGE (Mobile)
            window.addEventListener('orientationchange', () => {
                setTimeout(() => {
                    this.handleResize();
                    console.log('🔄 Animations updated for orientation change');
                }, 300);
            });
        }

        handleResize() {
            this.marquees.forEach(marquee => {
                this.updateMarqueeDimensions(marquee);
                
                // RESTART ANIMATIONS AFTER RESIZE
                const currentAnimation = marquee.style.animationName;
                marquee.style.animationName = 'none';
                marquee.offsetHeight; // Force reflow
                marquee.style.animationName = currentAnimation;
            });
            
            this.forceAnimations();
        }

        forceAnimations() {
            this.marquees.forEach(marquee => {
                // 🎯 CRITICAL: Force animation properties
                marquee.style.animationPlayState = 'running';
                marquee.style.animationFillMode = 'none';
                marquee.style.animationDelay = '0s';
                
                // Force reflow to ensure animation continues
                marquee.offsetHeight;
            });
        }

        // 🔥 CONTINUOUS MONITORING SYSTEM
        startMonitoring() {
            // Main monitoring loop
            this.animationController = setInterval(() => {
                if (this.isVisible) {
                    this.checkAnimationHealth();
                }
            }, 1000);

            // Performance monitoring
            this.startPerformanceMonitoring();
            
            console.log('🔍 Animation monitoring started for 30-card system');
        }

        checkAnimationHealth() {
            let needsRestart = false;
            
            this.marquees.forEach((marquee, index) => {
                // CHECK CRITICAL ANIMATION PROPERTIES
                if (marquee.style.animationPlayState !== 'running') {
                    marquee.style.animationPlayState = 'running';
                    needsRestart = true;
                    console.warn(`🔧 Fixed paused animation on marquee ${index + 1}`);
                }
                
                if (marquee.style.animationFillMode !== 'none') {
                    marquee.style.animationFillMode = 'none';
                    needsRestart = true;
                    console.warn(`🔧 Fixed animation fill mode on marquee ${index + 1}`);
                }
                
                if (marquee.style.animationDelay !== '0s') {
                    marquee.style.animationDelay = '0s';
                    needsRestart = true;
                    console.warn(`🔧 Fixed animation delay on marquee ${index + 1}`);
                }
                
                // CHECK IF ANIMATION IS ACTUALLY RUNNING
                const computedStyle = window.getComputedStyle(marquee);
                if (computedStyle.animationPlayState !== 'running') {
                    marquee.style.animationPlayState = 'running';
                    marquee.offsetHeight; // Force reflow
                    needsRestart = true;
                    console.warn(`🔧 Force restarted animation on marquee ${index + 1}`);
                }
            });
            
            if (needsRestart) {
                console.log('🚀 Animation health check completed with fixes');
            }
        }

        startPerformanceMonitoring() {
            let frameCount = 0;
            let lastTime = performance.now();
            
            const monitor = () => {
                frameCount++;
                const currentTime = performance.now();
                
                if (currentTime - lastTime >= 2000) { // Check every 2 seconds
                    const fps = Math.round(frameCount * 1000 / (currentTime - lastTime));
                    
                    if (fps < 30 && this.isVisible) {
                        console.warn(`⚠️ Low FPS detected: ${fps}. Optimizing animations...`);
                        this.optimizeAnimations();
                    }
                    
                    frameCount = 0;
                    lastTime = currentTime;
                }
                
                if (this.animationController) {
                    requestAnimationFrame(monitor);
                }
            };
            
            monitor();
        }

        optimizeAnimations() {
            this.marquees.forEach(marquee => {
                // REDUCE ANIMATION COMPLEXITY DURING LOW PERFORMANCE
                marquee.style.willChange = 'transform';
                marquee.style.backfaceVisibility = 'hidden';
                marquee.style.perspective = '1000px';
                
                // ENSURE GPU ACCELERATION
                marquee.style.transform = 'translateZ(0)';
            });
        }

        // PUBLIC METHODS FOR MANUAL CONTROL
        pause() {
            this.marquees.forEach(marquee => {
                marquee.style.animationPlayState = 'paused';
            });
            console.log('⏸️ Animations paused');
        }

        resume() {
            this.forceAnimations();
            console.log('▶️ Animations resumed');
        }

        restart() {
            this.marquees.forEach(marquee => {
                const currentAnimation = marquee.style.animationName;
                marquee.style.animationName = 'none';
                marquee.offsetHeight; // Force reflow
                marquee.style.animationName = currentAnimation;
            });
            this.forceAnimations();
            console.log('🔄 Animations restarted');
        }

        destroy() {
            if (this.animationController) {
                clearInterval(this.animationController);
                this.animationController = null;
            }
            console.log('🛑 Animation controller destroyed');
        }
    }

    // 🚀 INITIALIZE THE SYSTEM
    let marqueeSystem;
    
    // MULTIPLE INITIALIZATION METHODS
    const initializeSystem = () => {
        if (!marqueeSystem) {
            marqueeSystem = new ZeroDelayMarquee();
            
            // EXPOSE TO GLOBAL SCOPE FOR DEBUGGING
            window.marqueeSystem = marqueeSystem;
        }
    };

    // METHOD 1: DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSystem);
    } else {
        // METHOD 2: Document already loaded
        initializeSystem();
    }

    // METHOD 3: Window load as backup
    window.addEventListener('load', () => {
        if (!marqueeSystem) {
            setTimeout(initializeSystem, 100);
        }
    });

    // METHOD 4: Immediate execution for modern browsers
    if (document.readyState === 'complete') {
        setTimeout(initializeSystem, 50);
    }

    // CLEANUP ON PAGE UNLOAD
    window.addEventListener('beforeunload', () => {
        if (marqueeSystem) {
            marqueeSystem.destroy();
        }
    });

    // EMERGENCY RESTART FUNCTION (for debugging)
    window.restartMarquees = () => {
        if (marqueeSystem) {
            marqueeSystem.restart();
        } else {
            initializeSystem();
        }
    };

    console.log('🎯 Zero Delay Marquee Script Loaded - Ready for 30 cards display!');
});
</script>