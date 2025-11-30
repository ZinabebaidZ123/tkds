@php
    $heroSection = App\Models\HeroSection::active()->ordered()->first();
    $perfectForCards = App\Models\PerfectForCard::active()->ordered()->get(); // Get all cards
@endphp

@if($heroSection)
<style>
.hero-gradient {
    background: 
        radial-gradient(circle at 20% 80%, rgba(197, 48, 48, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(229, 62, 62, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(252, 129, 129, 0.08) 0%, transparent 50%),
        linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #2d1b4e 50%, #1a1a1a 75%, #0a0a0a 100%);
    position: relative;
    overflow: hidden;
}

.text-gradient {
    background: linear-gradient(135deg, {{ $heroSection->gradient_color_1 }}, {{ $heroSection->gradient_color_2 }}, {{ $heroSection->gradient_color_3 }});
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.glass-effect {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.ai-badge {
    background: linear-gradient(135deg, #1e40af, #7c3aed, #1e40af);
    background-size: 200% 200%;
    animation: gradient-flow 4s ease infinite;
}

@keyframes gradient-flow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Enhanced Background Effects */
@if($heroSection->show_particles)
.floating-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
}

.shape {
    position: absolute;
    opacity: 0.1;
    animation: float-around 20s linear infinite;
}

.shape.circle {
    border-radius: 50%;
    background: linear-gradient(45deg, {{ $heroSection->gradient_color_1 }}, {{ $heroSection->gradient_color_2 }});
}

.shape.square {
    background: linear-gradient(45deg, {{ $heroSection->gradient_color_2 }}, {{ $heroSection->gradient_color_3 }});
    transform: rotate(45deg);
}

@keyframes float-around {
    0% {
        transform: translateY(100vh) translateX(-100px) rotate(0deg);
    }
    100% {
        transform: translateY(-100px) translateX(100px) rotate(360deg);
    }
}

.particle-system {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.particle {
    position: absolute;
    background: {{ $heroSection->gradient_color_1 }};
    border-radius: 50%;
    pointer-events: none;
    animation: particle-float 15s linear infinite;
}

@keyframes particle-float {
    0% {
        transform: translateY(100vh) translateX(0) scale(0);
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    90% {
        opacity: 1;
    }
    100% {
        transform: translateY(-100px) translateX(200px) scale(1);
        opacity: 0;
    }
}
@endif

/* Mouse Follow Effect */
.mouse-follower {
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(197, 48, 48, 0.1) 0%, transparent 70%);
    pointer-events: none;
    transition: transform 0.3s ease;
    z-index: 1;
}

/* Spotlight Effect */
.spotlight {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(ellipse 800px 600px at 30% 50%, transparent 0%, rgba(0, 0, 0, 0.4) 70%);
    pointer-events: none;
    animation: spotlight-move 10s ease-in-out infinite;
}

@keyframes spotlight-move {
    0%, 100% {
        background: radial-gradient(ellipse 800px 600px at 30% 50%, transparent 0%, rgba(0, 0, 0, 0.4) 70%);
    }
    50% {
        background: radial-gradient(ellipse 800px 600px at 35% 45%, transparent 0%, rgba(0, 0, 0, 0.3) 70%);
    }
}

/* Wave Animation */
.wave-layer {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 200%;
    height: 200px;
    background: linear-gradient(45deg, rgba(197, 48, 48, 0.05), rgba(229, 62, 62, 0.03));
    clip-path: polygon(0 50%, 100% 80%, 100% 100%, 0% 100%);
    animation: wave-flow 8s ease-in-out infinite;
}

@keyframes wave-flow {
    0%, 100% {
        transform: translateX(-25%) rotate(0deg);
        clip-path: polygon(0 50%, 100% 80%, 100% 100%, 0% 100%);
    }
    50% {
        transform: translateX(-25%) rotate(0.5deg);
        clip-path: polygon(0 60%, 100% 70%, 100% 100%, 0% 100%);
    }
}

@if($heroSection->show_rotating_cards)
/* Rotating Cards */
.rotating-cards {
    position: relative;
    width: 450px;
    height: 550px;
    margin: 0 auto;
    perspective: 1000px;
}

/* Responsive widths and heights for rotating cards */
@media (max-width: 768px) {
    .rotating-cards {
        width: 380px;
        height: 450px;
    }
}

@media (max-width: 640px) {
    .rotating-cards {
        width: 340px;
        height: 420px;
    }
}

@media (max-width: 480px) {
    .rotating-cards {
        width: 300px;
        height: 380px;
    }
}

.rotating-cards::before {
    content: '';
    position: absolute;
    top: -20px;
    left: -20px;
    right: -20px;
    bottom: -20px;
    background: radial-gradient(circle, rgba(197, 48, 48, 0.1) 0%, transparent 70%);
    border-radius: 30px;
    z-index: -1;
    animation: card-glow 4s ease-in-out infinite;
}

@keyframes card-glow {
    0%, 100% {
        opacity: 0.3;
        transform: scale(1);
    }
    50% {
        opacity: 0.6;
        transform: scale(1.05);
    }
}

.audience-card {
    position: absolute;
    width: 420px;
    height: 160px;
    background: rgba(20, 20, 20, 0.9);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
    transition: all 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
    cursor: pointer;
    border: 2px solid;
    text-align: center;
    padding: 25px;
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    opacity: 0;
    visibility: hidden;
}

/* Responsive sizes for audience cards */
@media (max-width: 768px) {
    .audience-card {
        width: 350px;
        height: 140px;
        padding: 20px;
    }
}

@media (max-width: 640px) {
    .audience-card {
        width: 310px;
        height: 130px;
        padding: 18px;
    }
}

@media (max-width: 480px) {
    .audience-card {
        width: 270px;
        height: 120px;
        padding: 15px;
    }
}

/* Visible cards class */
.audience-card.visible {
    opacity: 1;
    visibility: visible;
}

/* Position the 3 visible cards */
.audience-card.visible.pos-1 {
    top: 0;
    transform: translateX(-50%) scale(0.8);
    z-index: 1;
    opacity: 0.7;
}

.audience-card.visible.pos-2 {
    top: 195px;
    transform: translateX(-50%) scale(1.1);
    z-index: 3;
    opacity: 1;
}

.audience-card.visible.pos-3 {
    top: 390px;
    transform: translateX(-50%) scale(0.8);
    z-index: 1;
    opacity: 0.7;
}

/* Responsive positioning for smaller screens */
@media (max-width: 768px) {
    .audience-card.visible.pos-2 {
        top: 155px;
    }
    .audience-card.visible.pos-3 {
        top: 310px;
    }
}

@media (max-width: 640px) {
    .audience-card.visible.pos-2 {
        top: 145px;
    }
    .audience-card.visible.pos-3 {
        top: 290px;
    }
}

@media (max-width: 480px) {
    .audience-card.visible.pos-2 {
        top: 130px;
    }
    .audience-card.visible.pos-3 {
        top: 260px;
    }
}

/* Rotation animation */
.rotating-cards.rotating .audience-card.visible.pos-1 {
    top: 390px;
    transform: translateX(-50%) scale(0.8);
    z-index: 1;
    opacity: 0.7;
}

.rotating-cards.rotating .audience-card.visible.pos-2 {
    top: 0;
    transform: translateX(-50%) scale(0.8);
    z-index: 1;
    opacity: 0.7;
}

.rotating-cards.rotating .audience-card.visible.pos-3 {
    top: 195px;
    transform: translateX(-50%) scale(1.1);
    z-index: 3;
    opacity: 1;
}

/* Responsive rotation animation positioning */
@media (max-width: 768px) {
    .rotating-cards.rotating .audience-card.visible.pos-1 {
        top: 310px;
    }
    .rotating-cards.rotating .audience-card.visible.pos-3 {
        top: 155px;
    }
}

@media (max-width: 640px) {
    .rotating-cards.rotating .audience-card.visible.pos-1 {
        top: 290px;
    }
    .rotating-cards.rotating .audience-card.visible.pos-3 {
        top: 145px;
    }
}

@media (max-width: 480px) {
    .rotating-cards.rotating .audience-card.visible.pos-1 {
        top: 260px;
    }
    .rotating-cards.rotating .audience-card.visible.pos-3 {
        top: 130px;
    }
}

.card-title {
    font-size: 18px;
    font-weight: 900;
    margin-bottom: 8px;
    background: linear-gradient(135deg, {{ $heroSection->gradient_color_1 }}, {{ $heroSection->gradient_color_2 }}, {{ $heroSection->gradient_color_3 }});
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.card-subtitle {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 600;
}

/* Responsive card text sizes */
@media (max-width: 768px) {
    .card-title {
        font-size: 16px;
    }
    .card-subtitle {
        font-size: 15px;
    }
}

@media (max-width: 640px) {
    .card-title {
        font-size: 15px;
    }
    .card-subtitle {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .card-title {
        font-size: 14px;
    }
    .card-subtitle {
        font-size: 13px;
    }
}
@endif

/* Custom CSS from admin */
{!! $heroSection->custom_css !!}
</style>

<section id="home" class="relative min-h-screen hero-gradient pt-20" 
         @if($heroSection->background_image) 
             style="background-image: url('{{ $heroSection->getBackgroundImageUrl() }}'); background-size: cover; background-position: center;"
         @endif>
    
    @if($heroSection->background_video)
        <video autoplay muted loop class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ $heroSection->getBackgroundVideoUrl() }}" type="video/mp4">
        </video>
    @endif
    
    @if($heroSection->show_particles)
    {{-- Background Effects --}}
    <div class="floating-shapes">
        @for($i = 0; $i < 8; $i++)
            <div class="shape circle" 
                 style="width: {{ rand(20, 60) }}px; height: {{ rand(20, 60) }}px; 
                        left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; 
                        animation-delay: {{ rand(0, 10) }}s; 
                        animation-duration: {{ rand(15, 25) }}s;">
            </div>
        @endfor
        
        @for($i = 0; $i < 6; $i++)
            <div class="shape square" 
                 style="width: {{ rand(15, 40) }}px; height: {{ rand(15, 40) }}px; 
                        left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; 
                        animation-delay: {{ rand(0, 8) }}s; 
                        animation-duration: {{ rand(18, 28) }}s;">
            </div>
        @endfor
    </div>
    
    <div class="particle-system">
        @for($i = 0; $i < 15; $i++)
            <div class="particle" 
                 style="width: {{ rand(2, 6) }}px; height: {{ rand(2, 6) }}px; 
                        left: {{ rand(0, 100) }}%; 
                        animation-delay: {{ rand(0, 15) }}s; 
                        animation-duration: {{ rand(10, 20) }}s;">
            </div>
        @endfor
    </div>
    
    <div class="spotlight"></div>
    <div class="wave-layer"></div>
    <div class="mouse-follower hidden lg:block" id="mouseFollower"></div>
    @endif
    
    <div class="relative z-10 min-h-screen flex flex-col justify-center">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                
                {{-- Left Side - Text Content --}}
                <div class="text-center lg:text-left">
                    
                    {{-- Main Headline --}}
                    <div class="space-y-6 mb-8" data-aos="fade-up">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black text-white leading-tight">
                            @if($heroSection->subtitle)
                                {{ $heroSection->subtitle }},
                                <span class="lg:inline block text-gradient">{{ $heroSection->title }}</span>
                            @else
                                Your World,
                                <span class="lg:inline block text-gradient">{{ $heroSection->title }}</span>
                            @endif
                        </h1>
                        @if($heroSection->description)
                            <p class="text-lg sm:text-xl text-gray-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                                {!! nl2br(e($heroSection->description)) !!}
                            </p>
                        @endif
                    </div>

                    @if($heroSection->show_ai_badge && $heroSection->ai_badge_text)
                    {{-- AI Badge --}}
                    <div class="mb-8" data-aos="fade-up" data-aos-delay="200">
                        <a href="/ai/chat" class="ai-badge inline-flex items-center space-x-3 rounded-2xl px-16 py-3 shadow-2xl hover:scale-105 transform transition-all duration-300 cursor-pointer">
                            <i class="fas fa-robot text-white text-xl"></i>
                            <span class="text-white font-bold text-sm sm:text-base tracking-wide">{{ $heroSection->ai_badge_text }}</span>
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                <div class="w-2 h-2 bg-white rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                                <div class="w-2 h-2 bg-white rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                            </div>
                        </a>
                    </div>
                    @endif
                    
                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row items-center lg:items-start justify-center lg:justify-start space-y-3 sm:space-y-0 sm:space-x-4" data-aos="fade-up" data-aos-delay="400">
                        <a href="{{ $heroSection->main_button_link }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white font-bold text-lg rounded-xl hover:shadow-2xl hover:shadow-red-600/30 transition-all duration-300">
                            <span class="flex items-center justify-center space-x-2">
                                <i class="fas fa-play"></i>
                                <span>{{ $heroSection->main_button_text }}</span>
                            </span>
                        </a>
                        
                        @if($heroSection->second_button_text && $heroSection->second_button_link)
                        @php
                            // If button text contains "AI" and link is not set to AI chat, use AI chat link
                            $buttonLink = $heroSection->second_button_link;
                            if (stripos($heroSection->second_button_text, 'AI') !== false && !str_contains($buttonLink, '/ai/chat')) {
                                $buttonLink = '/ai/chat';
                            }
                        @endphp
                        <a href="{{ $buttonLink }}" class="w-full sm:w-auto px-8 py-4 glass-effect text-white font-bold text-lg rounded-xl hover:bg-white/20 transition-all duration-300">
                            <span class="flex items-center justify-center space-x-2">
                                <i class="fas fa-comments text-blue-400"></i>
                                <span>{{ $heroSection->second_button_text }}</span>
                            </span>
                        </a>
                        @endif
                    </div>
                    
                </div>
                
                @if($heroSection->show_rotating_cards && $perfectForCards->count() > 0)
                {{-- Right Side - Rotating Cards --}}
                <div class="flex flex-col items-center" data-aos="fade-left" data-aos-delay="400">
                    
                    <div class="text-center mb-6">
                        <h2 class="text-2xl sm:text-3xl font-black text-white mb-2">
                            <span class="text-gradient">{{ $heroSection->perfect_for_title ?? 'Perfect For' }}</span>
                        </h2>
                        <p class="text-gray-400">{{ $heroSection->perfect_for_subtitle ?? 'Real-World Broadcasting Scenarios' }}</p>
                    </div>
                    
                    <div class="rotating-cards" id="rotatingCards">
                        @foreach($perfectForCards as $index => $card)
                        <div class="audience-card" data-card-index="{{ $index }}"
                             style="background: {{ $card->background_color }}15; color: {{ $card->text_color }}; border-color: {{ $card->border_color }};">
                            @if($card->icon)
                                <div class="card-icon mb-2">
                                    <i class="{{ $card->icon }}" style="color: {{ $card->text_color }};"></i>
                                </div>
                            @endif
                            <div class="card-title">{{ $card->title }}</div>
                            <div class="card-subtitle">{{ $card->subtitle }}</div>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
                @endif
                
            </div>
            
        </div>
        
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($heroSection->show_rotating_cards && $perfectForCards->count() > 0)
            
            const cards = document.querySelectorAll('.audience-card');
            const container = document.getElementById('rotatingCards');
            const totalCards = cards.length;
            let currentStartIndex = 0;
            
            function updateVisibleCards() {
                // Clear all classes first
                cards.forEach(card => {
                    card.classList.remove('visible', 'pos-1', 'pos-2', 'pos-3');
                });
                
                // Show 3 cards starting from currentStartIndex
                for (let i = 0; i < 3 && i < totalCards; i++) {
                    const cardIndex = (currentStartIndex + i) % totalCards;
                    const card = cards[cardIndex];
                    if (card) {
                        card.classList.add('visible', `pos-${i + 1}`);
                    }
                }
            }
            
            function rotateToNext() {
                if (totalCards <= 3) return; // No need to rotate if 3 or fewer cards
                
                container.classList.add('rotating');
                
                setTimeout(() => {
                    currentStartIndex = (currentStartIndex + 1) % totalCards;
                    updateVisibleCards();
                    container.classList.remove('rotating');
                }, 800);
            }
            
            // Initialize first set
            updateVisibleCards();
            
            // Auto-rotate every 4 seconds
            if (totalCards > 3) {
                setInterval(rotateToNext, 4000);
            }
            
            @endif

            @if($heroSection->show_particles)
            // Mouse follower effect (desktop only)
            const mouseFollower = document.getElementById('mouseFollower');
            if (mouseFollower && window.innerWidth > 1024) {
                document.addEventListener('mousemove', (e) => {
                    const x = e.clientX;
                    const y = e.clientY;
                    mouseFollower.style.transform = `translate(${x - 100}px, ${y - 100}px)`;
                });
            }
            @endif
        });
    </script>
    
</section>
@endif