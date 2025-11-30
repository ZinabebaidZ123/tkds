@php
    $teamMembers = \App\Models\TeamMember::getActiveOrdered();
@endphp

<section class="relative py-16 md:py-20 bg-gradient-to-br from-dark-light via-dark to-light overflow-hidden">
    <!-- EPIC Background Effects -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="team-title-tkds text-center">
            <h1 class="text-7xl md:text-6xl lg:text-8xl font-black uppercase tracking-tighter text-primary/20 select-none">
                OUR TEAM
            </h1>
        </div>

        <style>
            .team-title-tkds {
                text-transform: uppercase;
                letter-spacing: -0.02em;
                background: linear-gradient(
                    to bottom,
                    rgb(160, 40, 40) 30%,
                    rgba(247, 193, 193, 0) 76%
                );
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }
        </style>

        @if($teamMembers->count() > 0)
        <!-- TKDS 3D Team Carousel -->
        <div class="relative">
            <!-- Carousel Container -->
            <div class="relative h-[400px] lg:h-[500px] flex items-center justify-center perspective-1000 mt-8">
                
                @if($teamMembers->count() > 1)
                <!-- Navigation Arrows -->
                <button id="tkds-prev" class="absolute left-4 md:left-8 z-30 w-12 h-12 bg-primary/80 hover:bg-primary text-white rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-primary/50">
                    <i class="fas fa-chevron-left text-lg"></i>
                </button>
                
                <button id="tkds-next" class="absolute right-4 md:right-8 z-30 w-12 h-12 bg-primary/80 hover:bg-primary text-white rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-primary/50">
                    <i class="fas fa-chevron-right text-lg"></i>
                </button>
                @endif

                <!-- Cards Container -->
                <div class="relative w-full h-full flex items-center justify-center preserve-3d">
                    
                    @foreach($teamMembers as $index => $member)
                    <!-- Team Card {{ $index + 1 }} -->
                    <div class="tkds-team-card absolute w-72 h-96 bg-white rounded-2xl overflow-hidden shadow-2xl cursor-pointer transition-all duration-800 ease-out" data-index="{{ $index }}">
                        <div class="relative h-full">
                            <img src="{{ $member->getImageUrl() }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-full h-full object-cover transition-all duration-800">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Member Information Display -->
            <div class="text-center mt-12 transition-all duration-600 ease-out">
                <h2 id="tkds-member-name" class="text-4xl md:text-5xl font-black text-primary mb-4 relative inline-block">
                    {{ $teamMembers->first()->name }}
                    <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-20 h-1 bg-gradient-to-r from-primary to-secondary rounded-full"></span>
                </h2>
                <p id="tkds-member-role" class="text-xl text-gray-400 uppercase tracking-wider font-medium">
                    {{ $teamMembers->first()->position }}
                </p>
            </div>

            @if($teamMembers->count() > 1)
            <!-- Navigation Dots -->
            <div class="flex justify-center mt-8 space-x-3">
                @foreach($teamMembers as $index => $member)
                <button class="tkds-dot w-3 h-3 rounded-full {{ $index === 0 ? 'bg-primary transform scale-110' : 'bg-primary/30 hover:bg-primary/60' }} transition-all duration-300" data-index="{{ $index }}"></button>
                @endforeach
            </div>

            <!-- Progress Bar for Auto Play -->
            <div class="flex justify-center mt-4">
                <div class="w-64 h-1 bg-gray-700 rounded-full overflow-hidden">
                    <div id="progress-bar" class="h-full bg-primary transition-all duration-100 ease-linear" style="width: 0%"></div>
                </div>
            </div>
            @endif
        </div>
        @else
        <!-- No Team Members -->
        <div class="text-center mt-12">
            <div class="mx-auto h-24 w-24 bg-primary/20 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-users text-4xl text-primary"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">Our Amazing Team</h3>
            <p class="text-gray-400 max-w-2xl mx-auto">We're building something incredible with passionate professionals. Stay tuned to meet our team!</p>
        </div>
        @endif
    </div>

    <!-- Custom Styles for 3D Effects -->
    <style>
        .perspective-1000 {
            perspective: 1000px;
        }
        
        .preserve-3d {
            transform-style: preserve-3d;
        }
        
        /* Carousel Card Positions */
        .tkds-team-card:nth-child(1) { /* Center */
            z-index: 10;
            transform: translateZ(0) scale(1.1);
            filter: none;
        }
        
        .tkds-team-card:nth-child(2) { /* Right 1 */
            z-index: 5;
            transform: translateX(200px) translateZ(-100px) scale(0.9);
            filter: grayscale(80%) brightness(0.7);
        }
        
        .tkds-team-card:nth-child(3) { /* Right 2 */
            z-index: 1;
            transform: translateX(380px) translateZ(-300px) scale(0.75);
            filter: grayscale(100%) brightness(0.5);
            opacity: 0.6;
        }
        
        .tkds-team-card:nth-child(4) { /* Left 1 */
            z-index: 5;
            transform: translateX(-200px) translateZ(-100px) scale(0.9);
            filter: grayscale(80%) brightness(0.7);
        }
        
        .tkds-team-card:nth-child(5) { /* Left 2 */
            z-index: 1;
            transform: translateX(-380px) translateZ(-300px) scale(0.75);
            filter: grayscale(100%) brightness(0.5);
            opacity: 0.6;
        }
        
        .tkds-team-card:nth-child(6) { /* Hidden */
            z-index: 0;
            transform: translateX(600px) translateZ(-500px) scale(0.5);
            filter: grayscale(100%) brightness(0.3);
            opacity: 0;
        }

        @media (max-width: 768px) {
            .tkds-team-card {
                width: 250px;
                height: 320px;
            }
            
            .tkds-team-card:nth-child(2) {
                transform: translateX(140px) translateZ(-100px) scale(0.85);
            }
            
            .tkds-team-card:nth-child(3) {
                transform: translateX(250px) translateZ(-300px) scale(0.7);
            }
            
            .tkds-team-card:nth-child(4) {
                transform: translateX(-140px) translateZ(-100px) scale(0.85);
            }
            
            .tkds-team-card:nth-child(5) {
                transform: translateX(-250px) translateZ(-300px) scale(0.7);
            }
        }

        /* Auto play animations - بطيء */
        .tkds-team-card {
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes progress-animation {
            0% { width: 0%; }
            100% { width: 100%; }
        }
    </style>

    @if($teamMembers->count() > 1)
    <!-- TKDS Team Carousel JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const teamData = [
                @foreach($teamMembers as $member)
                {
                    name: "{{ $member->name }}",
                    role: "{{ $member->position }}"
                }{{ !$loop->last ? ',' : '' }}
                @endforeach
            ];

            const cards = document.querySelectorAll('.tkds-team-card');
            const dots = document.querySelectorAll('.tkds-dot');
            const nameEl = document.getElementById('tkds-member-name');
            const roleEl = document.getElementById('tkds-member-role');
            const prevBtn = document.getElementById('tkds-prev');
            const nextBtn = document.getElementById('tkds-next');
            const progressBar = document.getElementById('progress-bar');

            let currentIndex = 0;
            let isAnimating = false;
            let autoPlayInterval = null;
            let progressInterval = null;
            let progressValue = 0;

            // Auto Play Functions
            function startAutoPlay() {
                if (autoPlayInterval) clearInterval(autoPlayInterval);
                if (progressInterval) clearInterval(progressInterval);
                
                progressValue = 0;
                updateProgressBar();
                
                // تبديل كل 5 ثوان
                autoPlayInterval = setInterval(() => {
                    if (!isAnimating) {
                        updateCarousel(currentIndex + 1, 'next');
                        progressValue = 0;
                        updateProgressBar();
                    }
                }, 5000);

                // تحديث شريط التقدم كل 100ms
                progressInterval = setInterval(() => {
                    if (!isAnimating) {
                        progressValue += 2; // 100% / 50 = 2% every 100ms for 5 seconds
                        updateProgressBar();
                    }
                }, 100);
            }

            function updateProgressBar() {
                if (progressBar) {
                    progressBar.style.width = Math.min(progressValue, 100) + '%';
                }
            }

            function updateCarousel(newIndex, direction = 'next') {
                if (isAnimating) return;
                isAnimating = true;

                currentIndex = (newIndex + teamData.length) % teamData.length;

                // Update card positions
                cards.forEach((card, index) => {
                    const offset = (index - currentIndex + teamData.length) % teamData.length;
                    
                    card.classList.remove('z-10', 'z-0', 'z-0');
                    
                    if (offset === 0) { // Center
                        card.style.transform = 'translateZ(0) scale(1.1)';
                        card.style.filter = 'none';
                        card.style.opacity = '1';
                        card.style.zIndex = '10';
                    } else if (offset === 1) { // Right 1
                        card.style.transform = 'translateX(200px) translateZ(-100px) scale(0.9)';
                        card.style.filter = 'grayscale(80%) brightness(0.7)';
                        card.style.opacity = '1';
                        card.style.zIndex = '5';
                    } else if (offset === 2) { // Right 2
                        card.style.transform = 'translateX(380px) translateZ(-300px) scale(0.75)';
                        card.style.filter = 'grayscale(100%) brightness(0.5)';
                        card.style.opacity = '0.6';
                        card.style.zIndex = '1';
                    } else if (offset === teamData.length - 1) { // Left 1
                        card.style.transform = 'translateX(-200px) translateZ(-100px) scale(0.9)';
                        card.style.filter = 'grayscale(80%) brightness(0.7)';
                        card.style.opacity = '1';
                        card.style.zIndex = '5';
                    } else if (offset === teamData.length - 2) { // Left 2
                        card.style.transform = 'translateX(-380px) translateZ(-300px) scale(0.75)';
                        card.style.filter = 'grayscale(100%) brightness(0.5)';
                        card.style.opacity = '0.6';
                        card.style.zIndex = '1';
                    } else { // Hidden
                        card.style.transform = 'translateX(600px) translateZ(-500px) scale(0.5)';
                        card.style.filter = 'grayscale(100%) brightness(0.3)';
                        card.style.opacity = '0';
                        card.style.zIndex = '0';
                    }
                });

                // Update dots
                dots.forEach((dot, index) => {
                    if (index === currentIndex) {
                        dot.classList.remove('bg-primary/30');
                        dot.classList.add('bg-primary', 'transform', 'scale-110');
                    } else {
                        dot.classList.remove('bg-primary', 'transform', 'scale-110');
                        dot.classList.add('bg-primary/30');
                    }
                });

                // Update member info with animation
                nameEl.style.opacity = '0';
                roleEl.style.opacity = '0';

                setTimeout(() => {
                    const member = teamData[currentIndex];
                    nameEl.textContent = member.name;
                    roleEl.textContent = member.role;
                    
                    nameEl.style.opacity = '1';
                    roleEl.style.opacity = '1';
                }, 400);

                setTimeout(() => {
                    isAnimating = false;
                }, 800);
            }

            // Event listeners
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    updateCarousel(currentIndex - 1, 'prev');
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    updateCarousel(currentIndex + 1, 'next');
                });
            }

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    updateCarousel(index);
                });
            });

            cards.forEach((card, index) => {
                card.addEventListener('click', () => {
                    updateCarousel(index);
                });
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    updateCarousel(currentIndex - 1, 'prev');
                } else if (e.key === 'ArrowRight') {
                    updateCarousel(currentIndex + 1, 'next');
                }
            });

            // Touch navigation
            let touchStartX = 0;
            let touchEndX = 0;

            document.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            document.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                const diff = touchStartX - touchEndX;
                const threshold = 50;

                if (Math.abs(diff) > threshold) {
                    if (diff > 0) {
                        updateCarousel(currentIndex + 1, 'next');
                    } else {
                        updateCarousel(currentIndex - 1, 'prev');
                    }
                }
            });

            // Initialize
            updateCarousel(0);
            if (teamData.length > 1) {
                startAutoPlay();
            }
        });
    </script>
    @endif
</section>