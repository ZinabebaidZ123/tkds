<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Active Offers - TKDS Servers</title>
    <meta name="description" content="Currently no active special offers available. Stay tuned for future deals!">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Exo+2:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dark-bg text-white font-exo">
  <!-- No Offers Available Section -->
<section class="min-h-screen flex items-center justify-center relative overflow-hidden bg-dark-bg">
    <!-- Epic Background Effects -->
    <div class="absolute inset-0">
        <!-- Animated Grid Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="grid grid-cols-12 h-full">
                @for($i = 0; $i < 12; $i++)
                    <div class="border-r border-white/20"></div>
                @endfor
            </div>
            <div class="absolute inset-0 grid grid-rows-12 w-full">
                @for($i = 0; $i < 12; $i++)
                    <div class="border-b border-white/10"></div>
                @endfor
            </div>
        </div>

        <!-- Floating Orbs -->
        <div class="floating-dots large" style="top: 10%; left: 15%; animation-delay: 0s;"></div>
        <div class="floating-dots" style="top: 25%; right: 20%; animation-delay: -1s;"></div>
        <div class="floating-dots large" style="bottom: 20%; left: 25%; animation-delay: -2s;"></div>
        <div class="floating-dots" style="bottom: 35%; right: 15%; animation-delay: -1.5s;"></div>
        <div class="floating-dots large" style="top: 60%; left: 70%; animation-delay: -0.5s;"></div>

        <!-- Gradient Overlays -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-neon-pink/10 to-red-600/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-red-600/10 to-neon-pink/10 rounded-full blur-3xl animate-pulse" style="animation-delay: -2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-gradient-to-r from-neon-pink/5 to-red-600/5 rounded-full blur-2xl animate-pulse" style="animation-delay: -1s;"></div>
    </div>

    <div class="container mx-auto px-6 text-center relative z-10">
        <!-- Main Icon Container -->
        <div class="relative mb-12 group">
            <!-- Glow Effect -->
            <div class="absolute -inset-4 bg-gradient-to-r from-neon-pink/30 to-red-600/30 rounded-full blur-2xl opacity-60 group-hover:opacity-80 transition-opacity duration-500 animate-pulse"></div>
            
            <!-- Icon -->
            <div class="relative w-48 h-48 mx-auto bg-gradient-to-br from-dark-card/90 to-gray-900/90 backdrop-blur-md rounded-full border-2 border-gray-700/50 shadow-2xl flex items-center justify-center group-hover:scale-105 transition-all duration-500">
                <!-- Corner Decorations -->
                <div class="absolute top-4 left-4 w-8 h-8 border-t-2 border-l-2 border-neon-pink/50"></div>
                <div class="absolute top-4 right-4 w-8 h-8 border-t-2 border-r-2 border-neon-pink/50"></div>
                <div class="absolute bottom-4 left-4 w-8 h-8 border-b-2 border-l-2 border-neon-pink/50"></div>
                <div class="absolute bottom-4 right-4 w-8 h-8 border-b-2 border-r-2 border-neon-pink/50"></div>
                
                <!-- Main Icon -->
                <div class="text-8xl text-gradient-red opacity-70">
                    <i class="fas fa-calendar-times"></i>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Main Title -->
            <h1 class="text-6xl md:text-8xl font-black font-orbitron text-white mb-6 leading-tight">
                NO ACTIVE
                <span class="block text-transparent bg-gradient-to-r from-neon-pink via-pink-400 to-red-500 bg-clip-text animate-pulse">
                    OFFERS
                </span>
            </h1>

            <!-- Subtitle -->
            <div class="text-2xl md:text-4xl font-bold text-gray-300 mb-8 font-bebas tracking-wider">
                All Special Occasions Have Ended
            </div>

            <!-- Description -->
            <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto leading-relaxed font-oswald">
                Currently, there are no active special offer pages available. 
                <span class="text-neon-pink font-medium">Stay tuned</span> for our next amazing deals and exclusive discounts!
            </p>

            <!-- Decorative Elements -->
            <div class="flex justify-center items-center space-x-4 my-12">
                <div class="w-16 h-0.5 bg-gradient-to-r from-transparent to-neon-pink"></div>
                <div class="w-3 h-3 bg-neon-pink rounded-full animate-pulse"></div>
                <div class="w-16 h-0.5 bg-gradient-to-r from-neon-pink to-transparent"></div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mt-12">
                <!-- Primary CTA -->
                <a href="{{ route('home') }}" 
                   class="group relative inline-flex items-center bg-gradient-to-r from-neon-pink to-red-600 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:scale-105 transition-all duration-300 shadow-2xl hover:shadow-neon-pink/50 backdrop-blur-sm border border-neon-pink/50 hover:border-neon-pink">
                    <i class="fas fa-home mr-3 group-hover:scale-110 transition-transform"></i>
                    Back To Home Page
                    <!-- Button Glow -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-neon-pink/40 to-red-600/40 rounded-2xl blur opacity-60 group-hover:opacity-80 transition-opacity -z-10"></div>
                </a>

                <!-- Secondary CTA -->
                <a href="{{ route('services') }}" 
                   class="group relative inline-flex items-center bg-transparent border-2 border-gray-600 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:scale-105 hover:border-neon-pink hover:bg-neon-pink/10 transition-all duration-300 backdrop-blur-sm">
                    <i class="fas fa-layer-group mr-3 group-hover:scale-110 transition-transform"></i>
                    View Our Services
                </a>
            </div>

            <!-- Newsletter Signup -->
            {{-- <div class="mt-16 p-8 bg-gradient-to-br from-dark-card/60 to-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-700/50 shadow-xl max-w-2xl mx-auto">
                <h3 class="text-2xl font-bold text-white mb-4 font-orbitron">
                    Get Notified About New Offers
                </h3>
                <p class="text-gray-400 mb-6 text-sm">
                    Be the first to know when our next special occasion sale goes live!
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <input type="email" 
                           placeholder="Enter your email address" 
                           class="flex-1 bg-dark-card/80 border border-gray-600 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:border-neon-pink focus:outline-none transition-all backdrop-blur-sm">
                    <button type="button" 
                            class="bg-gradient-to-r from-neon-pink to-red-600 text-white px-8 py-3 rounded-xl font-bold hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-neon-pink/50 whitespace-nowrap">
                        <i class="fas fa-bell mr-2"></i>
                        Notify Me
                    </button>
                </div>
            </div> --}}

            <!-- Social Proof -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="text-center p-6 bg-dark-card/40 rounded-2xl border border-gray-700/30">
                    <div class="text-3xl font-black text-neon-pink mb-2 font-orbitron">5000+</div>
                    <div class="text-gray-400 text-sm font-oswald">Happy Customers</div>
                </div>
                <div class="text-center p-6 bg-dark-card/40 rounded-2xl border border-gray-700/30">
                    <div class="text-3xl font-black text-red-400 mb-2 font-orbitron">99.9%</div>
                    <div class="text-gray-400 text-sm font-oswald">Uptime Guarantee</div>
                </div>
                <div class="text-center p-6 bg-dark-card/40 rounded-2xl border border-gray-700/30">
                    <div class="text-3xl font-black text-pink-400 mb-2 font-orbitron">24/7</div>
                    <div class="text-gray-400 text-sm font-oswald">Expert Support</div>
                </div>
            </div>
        </div>

        <!-- Bottom Decoration -->
        <div class="mt-20">
            <div class="flex justify-center items-center">
                <div class="w-32 h-0.5 bg-gradient-to-r from-transparent via-neon-pink to-transparent opacity-50"></div>
            </div>
        </div>
    </div>

    <!-- Animated Background Particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-neon-pink/30 rounded-full animate-ping" style="animation-delay: 0s;"></div>
        <div class="absolute top-3/4 right-1/4 w-1 h-1 bg-red-500/40 rounded-full animate-ping" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-3/4 w-3 h-3 bg-pink-400/20 rounded-full animate-ping" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-1/4 left-1/2 w-2 h-2 bg-neon-pink/25 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
    </div>
</section>

<style>
/* Additional CSS for floating dots and animations */
.floating-dots {
    position: absolute;
    width: 8px;
    height: 8px;
    background: linear-gradient(45deg, #ff0040, #8b5cf6);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.floating-dots.large {
    width: 12px;
    height: 12px;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.text-gradient-red {
    background: linear-gradient(45deg, #ff0040, #ff4060, #ff6080);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Hover effects for interactive elements */
.group:hover .floating-dots {
    animation-duration: 3s;
}
</style>
</body>
</html>