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
            
            @if($clientsByCategory->has('other') && $clientsByCategory['other']->count() > 0)
            <!-- PARTNERS Section - Enhanced with Smooth Animation -->
            <div class="mt-16 bg-gradient-to-br  to-black rounded-3xl p-12 border border-white/10 shadow-2xl overflow-hidden relative">
                <!-- Background Effects -->
                <div class="absolute inset-0 opacity-30">
                    <div class="absolute top-0 left-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-secondary/8 rounded-full blur-3xl animate-pulse"></div>
                    <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-accent/6 rounded-full blur-3xl animate-pulse"></div>
                </div>

                <!-- Header -->
                <div class="text-center mb-12 relative z-10">
                    <h2 class="text-5xl md:text-6xl lg:text-7xl font-extrabold bg-gradient-to-br from-red-400 via-red-500 to-red-700 text-transparent bg-clip-text drop-shadow-lg">
                        PARTNERS
                    </h2>
                    <div class="mt-4 h-1 w-32 bg-gradient-to-r from-transparent via-red-500 to-transparent mx-auto rounded-full"></div>
                    <p class="mt-6 text-xl text-gray-300 font-medium tracking-wide">
                        Powerful collaborations that fuel our mission
                    </p>
                </div>

<!-- Partners Logos Container -->
                <div class="relative z-10">
                    <!-- Gradient Overlays for Smooth Fade Effect -->
                    <div class="absolute left-0 top-0 bottom-0 w-20 bg-gradient-to-r from-[#1a1a1a] to-transparent z-20 pointer-events-none"></div>
                    <div class="absolute right-0 top-0 bottom-0 w-20 bg-gradient-to-l from-[#1a1a1a] to-transparent z-20 pointer-events-none"></div>
                    
                    <!-- Animated Logos Track -->
                    <div class="partners-track-container overflow-hidden">
                        <div class="partners-track flex items-center gap-10">
                            @php
                                $otherClients = $clientsByCategory['other'];
                                $tripleOtherClients = $otherClients->concat($otherClients)->concat($otherClients);
                            @endphp
                            
                            @foreach($tripleOtherClients as $client)
                                <div class="partner-logo-card flex-shrink-0 w-64 h-36 flex items-center justify-center rounded-2xl backdrop-blur-sm transition-all duration-500 hover:scale-110 hover:rotate-1 group cursor-pointer border border-white/10 hover:border-white/30 shadow-lg hover:shadow-2xl"
                                     style="background: linear-gradient(135deg, {{ $client->background_color ?: 'rgba(255,255,255,0.05)' }}, {{ $client->hover_background_color ?: 'rgba(255,255,255,0.1)' }});"
                                     @if($client->website_url) 
                                         onclick="window.open('{{ $client->website_url }}', '_blank')"
                                         title="Visit {{ $client->name }}"
                                     @endif>
                                    
                                    @if($client->logo)
                                        <img src="{{ $client->getLogoUrl() }}"
                                             alt="{{ $client->name }}"
                                             class="max-h-20 max-w-[85%] object-contain transition-all duration-500 group-hover:scale-110 filter brightness-90 group-hover:brightness-110"
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
                <div class="mt-8 flex justify-center relative z-10">
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
        <div class="text-center mt-20">
            <p class="text-xl text-gray-400 font-medium">
                Ready to join the elite?
            </p>
        </div>
    </div>
</section>

<style>
/* Perfect seamless infinite marquee - ENHANCED */
.marquee-container {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.marquee-content {
    display: flex;
    align-items: center;
    white-space: nowrap;
    will-change: transform;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    backface-visibility: hidden;
    perspective: 1000px;
    transform: translateZ(0);
}

/* Smooth Left Scroll - No Gaps - SAME AS PARTNERS */
.marquee-left-smooth {
    animation: marquee-smooth-left 80s linear infinite;
}

/* Smooth Right Scroll - No Gaps - SAME AS PARTNERS */
.marquee-right-smooth {
    animation: marquee-smooth-right 80s linear infinite;
}

@keyframes marquee-smooth-left {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-33.333%);
    }
}

@keyframes marquee-smooth-right {
    0% {
        transform: translateX(-33.333%);
    }
    100% {
        transform: translateX(0);
    }
}

/* Partners Track Animation - EXACT SAME LOGIC */
.partners-track-container {
    width: 100%;
    overflow: hidden;
    position: relative;
}

.partners-track {
    width: max-content;
    animation: smooth-scroll-partners 80s linear infinite;
    will-change: transform;
    backface-visibility: hidden;
    perspective: 1000px;
    transform: translateZ(0);
}

@keyframes smooth-scroll-partners {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-33.333%);
    }
}

/* Hover Effects for Client Cards */
.client-card:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(197, 48, 48, 0.1);
    transform: translateY(-2px);
}

.client-card:hover img,
.client-card:hover span {
    transform: scale(1.05);
}

/* Partner Logo Card Enhancements */
.partner-logo-card {
    position: relative;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

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

.partner-logo-card:hover::before {
    left: 100%;
}

.partner-logo-card:hover {
    box-shadow: 
        0 20px 25px -5px rgba(0, 0, 0, 0.3),
        0 25px 50px -12px rgba(197, 48, 48, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    border-color: rgba(197, 48, 48, 0.5);
}

/* Pause animations on container hover for better UX */
.marquee-container:hover .marquee-content,
.partners-track-container:hover .partners-track {
    animation-play-state: paused;
}

/* Performance optimizations */
.marquee-content *,
.partners-track * {
    backface-visibility: hidden;
    transform: translateZ(0);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .marquee-left-smooth,
    .marquee-right-smooth {
        animation-duration: 50s;
    }
    
    .partners-track {
        animation-duration: 50s;
    }
    
    .client-card,
    .partner-logo-card {
        width: 180px;
        height: 80px;
    }
    
    .partner-logo-card {
        height: 100px;
    }
}

@media (max-width: 480px) {
    .marquee-left-smooth,
    .marquee-right-smooth {
        animation-duration: 35s;
    }
    
    .partners-track {
        animation-duration: 35s;
    }
    
    .client-card,
    .partner-logo-card {
        width: 160px;
        height: 70px;
    }
    
    .partner-logo-card {
        height: 90px;
    }
}

/* Enhanced loading state */
.client-card img,
.partner-logo-card img {
    opacity: 0;
    animation: fadeInImage 0.5s ease-in-out 0.2s forwards;
}

@keyframes fadeInImage {
    to {
        opacity: 1;
    }
}

/* Smooth logo transitions */
.client-card img,
.partner-logo-card img {
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
</style>

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