{{-- resources/views/components/preloader.blade.php --}}
<div id="preloader" class="fixed inset-0 z-50 bg-dark flex items-center justify-center">
    <!-- Background Effects -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Dynamic gradient backgrounds -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-primary/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-accent/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        
        <!-- Floating particles -->
        <div class="absolute inset-0">
            <div class="floating-particle absolute w-2 h-2 bg-primary rounded-full opacity-60" style="top: 20%; left: 15%; animation-delay: 0s;"></div>
            <div class="floating-particle absolute w-1 h-1 bg-secondary rounded-full opacity-40" style="top: 40%; left: 85%; animation-delay: 0.5s;"></div>
            <div class="floating-particle absolute w-3 h-3 bg-accent rounded-full opacity-30" style="top: 70%; left: 25%; animation-delay: 1s;"></div>
            <div class="floating-particle absolute w-1 h-1 bg-primary rounded-full opacity-50" style="top: 80%; left: 75%; animation-delay: 1.5s;"></div>
            <div class="floating-particle absolute w-2 h-2 bg-secondary rounded-full opacity-35" style="top: 30%; left: 50%; animation-delay: 2s;"></div>
            <div class="floating-particle absolute w-1 h-1 bg-accent rounded-full opacity-45" style="top: 60%; left: 10%; animation-delay: 2.5s;"></div>
        </div>
    </div>

    <!-- Main loader content -->
    <div class="relative text-center">
        
        <!-- Logo/Brand Container -->
        <div class="mb-8 loader-content-show" style="animation-delay: 0.2s;">
            <div class="relative inline-block">
                <!-- Rotating rings around logo -->
                <div class="absolute inset-0 w-32 h-32 mx-auto">
                    <div class="loader-ring-1 absolute inset-0 border-4 border-transparent border-t-primary rounded-full animate-spin"></div>
                    <div class="loader-ring-2 absolute inset-2 border-4 border-transparent border-r-secondary rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
                    <div class="loader-ring-3 absolute inset-4 border-4 border-transparent border-b-accent rounded-full animate-spin" style="animation-duration: 2s;"></div>
                </div>
                
                <!-- TKDS Logo/Text -->
                <div class="relative z-10 w-32 h-32 mx-auto flex items-center justify-center  rounded-full shadow-2xl">
                            <img src="{{ asset('images/TKDSFAV.png') }}" alt="TKDS Media" class="w-20 h-20 object-contain ml-1">
                </div>
            </div>
        </div>

        <!-- Brand name with typing effect -->
        <div class="mb-6 loader-content-show" style="animation-delay: 0.8s;">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-2">
                <span class="typing-text" id="typingText">TKDS Media</span>
            </h1>
            <p class="text-lg text-gray-400 font-medium tracking-wider">
                <span class="tagline-text" id="taglineText">Your World, Live and Direct</span>
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8 loader-content-show" style="animation-delay: 1.2s;">
            <div class="w-64 mx-auto">
                <div class="flex justify-between text-sm text-gray-400 mb-2">
                    <span>Loading</span>
                    <span class="loading-percentage">0%</span>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-2 overflow-hidden">
                    <div class="progress-bar h-full bg-gradient-to-r from-primary via-secondary to-accent rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                </div>
                
                <!-- Loading Speed Indicator -->
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span class="connection-speed">Detecting connection...</span>
                    <span class="resources-loaded">0/0 resources</span>
                </div>
            </div>
        </div>

        <!-- Loading dots -->
        <div class="flex justify-center space-x-2 loader-content-show" style="animation-delay: 1.6s;">
            <div class="loading-dot w-3 h-3 bg-primary rounded-full animate-bounce"></div>
            <div class="loading-dot w-3 h-3 bg-secondary rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
            <div class="loading-dot w-3 h-3 bg-accent rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
        </div>

        <!-- Loading status text -->
        <div class="mt-6 loader-content-show" style="animation-delay: 2s;">
            <p class="loading-status text-gray-500 text-sm tracking-wide">Initializing...</p>
        </div>
    </div>
</div>

<style>
/* Show loader content with fade in animation */
.loader-content-show {
    opacity: 0;
    transform: translateY(20px);
    animation: loaderFadeIn 0.8s ease-out forwards;
}

@keyframes loaderFadeIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Custom animations for preloader */
@keyframes float-particle {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg); 
        opacity: 0.3;
    }
    50% { 
        transform: translateY(-20px) rotate(180deg); 
        opacity: 0.8;
    }
}

.floating-particle {
    animation: float-particle 4s ease-in-out infinite;
}

/* Logo glow effect */
.logo-glow {
    text-shadow: 
        0 0 5px rgba(197, 48, 48, 0.5),
        0 0 10px rgba(197, 48, 48, 0.3),
        0 0 15px rgba(197, 48, 48, 0.2);
    animation: logo-pulse 2s ease-in-out infinite;
}

@keyframes logo-pulse {
    0%, 100% { 
        text-shadow: 
            0 0 5px rgba(197, 48, 48, 0.5),
            0 0 10px rgba(197, 48, 48, 0.3),
            0 0 15px rgba(197, 48, 48, 0.2);
    }
    50% { 
        text-shadow: 
            0 0 10px rgba(197, 48, 48, 0.8),
            0 0 20px rgba(197, 48, 48, 0.6),
            0 0 30px rgba(197, 48, 48, 0.4);
    }
}

/* Typing effect - will be controlled by JavaScript */
.typing-text {
    border-right: 3px solid #C53030;
    overflow: hidden;
    white-space: nowrap;
    width: 0;
}

.typing-text.typing {
    animation: typing 2s steps(10, end), blink 1s infinite;
}

@keyframes typing {
    from { width: 0; }
    to { width: 100%; }
}

@keyframes blink {
    0%, 50% { border-color: #C53030; }
    51%, 100% { border-color: transparent; }
}

/* Tagline fade in - will be controlled by JavaScript */
.tagline-text {
    opacity: 0;
}

.tagline-text.show {
    animation: fadeInUp 1s ease-out forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced progress bar */
.progress-bar {
    position: relative;
    overflow: hidden;
}

.progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        90deg, 
        transparent, 
        rgba(255, 255, 255, 0.4), 
        transparent
    );
    animation: progress-shine 2s infinite;
}

@keyframes progress-shine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Loading dots enhanced */
.loading-dot {
    animation-duration: 1.4s;
    animation-iteration-count: infinite;
    animation-timing-function: ease-in-out;
}

/* Progress bar speed indication */
.progress-bar.slow {
    transition-duration: 800ms;
}

.progress-bar.fast {
    transition-duration: 100ms;
}

/* Preloader fade out */
.preloader-fade-out {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.8s ease-out, visibility 0.8s ease-out;
    transform: scale(0.95);
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .typing-text {
        font-size: 2rem;
    }
    
    .loader-ring-1, 
    .loader-ring-2, 
    .loader-ring-3 {
        width: 24px;
        height: 24px;
    }
}
</style>

<script>
class SmartPreloader {
    constructor() {
        this.preloader = document.getElementById('preloader');
        this.progressBar = document.querySelector('.progress-bar');
        this.loadingPercentage = document.querySelector('.loading-percentage');
        this.loadingStatus = document.querySelector('.loading-status');
        this.connectionSpeed = document.querySelector('.connection-speed');
        this.resourcesLoaded = document.querySelector('.resources-loaded');
        this.typingText = document.getElementById('typingText');
        this.taglineText = document.getElementById('taglineText');
        
        this.startTime = performance.now();
        this.currentProgress = 0;
        this.targetProgress = 0;
        this.resources = [];
        this.loadedResources = 0;
        this.connectionType = 'unknown';
        this.isComplete = false;
        
        this.init();
    }

    init() {
        this.detectConnection();
        this.gatherResources();
        this.startTypingEffect();
        this.startResourceTracking();
        this.startProgressAnimation();
    }

    detectConnection() {
        // Detect connection speed
        if (navigator.connection) {
            const conn = navigator.connection;
            this.connectionType = conn.effectiveType || conn.type || 'unknown';
            
            if (this.connectionSpeed) {
                const speedText = {
                    'slow-2g': 'Slow connection detected',
                    '2g': 'Limited connection',
                    '3g': 'Good connection',
                    '4g': 'Fast connection',
                    '5g': 'Ultra-fast connection'
                };
                this.connectionSpeed.textContent = speedText[this.connectionType] || 'Detecting connection...';
            }
        }

        // Speed test using image loading
        this.performSpeedTest();
    }

    performSpeedTest() {
        const startTime = performance.now();
        const testImage = new Image();
        testImage.onload = () => {
            const loadTime = performance.now() - startTime;
            if (loadTime < 100) {
                this.connectionType = 'fast';
                if (this.connectionSpeed) this.connectionSpeed.textContent = 'Fast connection';
            } else if (loadTime < 500) {
                this.connectionType = 'medium';
                if (this.connectionSpeed) this.connectionSpeed.textContent = 'Good connection';
            } else {
                this.connectionType = 'slow';
                if (this.connectionSpeed) this.connectionSpeed.textContent = 'Slow connection';
            }
        };
        testImage.src = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwA/8n//2Q==';
    }

    gatherResources() {
        // Gather all resources that need to be loaded
        this.resources = [
            ...document.querySelectorAll('img[src]'),
            ...document.querySelectorAll('link[rel="stylesheet"]'),
            ...document.querySelectorAll('script[src]'),
            ...document.querySelectorAll('link[rel="preload"]')
        ];

        // Add critical resources manually
        this.resources.push(
            { type: 'font', name: 'Google Fonts' },
            { type: 'css', name: 'Tailwind CSS' },
            { type: 'js', name: 'AOS Library' },
            { type: 'content', name: 'Page Content' }
        );

        if (this.resourcesLoaded) {
            this.resourcesLoaded.textContent = `0/${this.resources.length} resources`;
        }
    }

    startTypingEffect() {
        setTimeout(() => {
            if (this.typingText) {
                this.typingText.classList.add('typing');
                setTimeout(() => {
                    if (this.taglineText) {
                        this.taglineText.classList.add('show');
                    }
                }, 2500);
            }
        }, 1000);
    }

    startResourceTracking() {
        let checkInterval = setInterval(() => {
            this.checkResourcesLoaded();
            
            if (this.loadedResources >= this.resources.length * 0.9 || this.isComplete) {
                clearInterval(checkInterval);
                this.completeLoading();
            }
        }, 100);

        // Track document ready state
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.updateProgress(50, 'DOM loaded...');
            });
        } else {
            this.updateProgress(50, 'DOM ready...');
        }

        // Track window load
        window.addEventListener('load', () => {
            this.updateProgress(90, 'All resources loaded...');
            setTimeout(() => this.completeLoading(), 500);
        });
    }

    checkResourcesLoaded() {
        let loaded = 0;
        
        // Check images
        document.querySelectorAll('img').forEach(img => {
            if (img.complete && img.naturalHeight !== 0) loaded++;
        });

        // Check stylesheets
        document.querySelectorAll('link[rel="stylesheet"]').forEach(link => {
            if (link.sheet) loaded++;
        });

        // Simulate other resource loading based on time and connection
        const elapsed = performance.now() - this.startTime;
        const baseProgress = Math.min(elapsed / this.getExpectedLoadTime() * 70, 70);
        
        this.loadedResources = loaded;
        this.targetProgress = Math.max(baseProgress, (loaded / this.resources.length) * 80);

        if (this.resourcesLoaded) {
            this.resourcesLoaded.textContent = `${loaded}/${this.resources.length} resources`;
        }

        this.updateProgressBar();
    }

    getExpectedLoadTime() {
        // Adjust expected load time based on connection
        const baseTimes = {
            'fast': 1000,
            'medium': 2500,
            '4g': 2000,
            '3g': 4000,
            '2g': 8000,
            'slow': 6000,
            'unknown': 3000
        };
        return baseTimes[this.connectionType] || 3000;
    }

    updateProgressBar() {
        if (this.currentProgress < this.targetProgress) {
            // Adjust speed based on connection
            const speed = this.getProgressSpeed();
            this.currentProgress = Math.min(this.currentProgress + speed, this.targetProgress);
            
            if (this.progressBar) {
                this.progressBar.style.width = this.currentProgress + '%';
                
                // Add speed class for visual feedback
                this.progressBar.className = this.progressBar.className.replace(/\b(fast|slow)\b/g, '');
                this.progressBar.classList.add(this.connectionType === 'fast' ? 'fast' : 
                                                 this.connectionType === 'slow' ? 'slow' : '');
            }
            
            if (this.loadingPercentage) {
                this.loadingPercentage.textContent = Math.round(this.currentProgress) + '%';
            }

            this.updateStatus();
            
            requestAnimationFrame(() => this.updateProgressBar());
        }
    }

    getProgressSpeed() {
        const speeds = {
            'fast': 2.5,
            'medium': 1.5,
            '4g': 2,
            '3g': 1,
            '2g': 0.5,
            'slow': 0.8,
            'unknown': 1.2
        };
        return speeds[this.connectionType] || 1.2;
    }

    updateStatus() {
        if (!this.loadingStatus) return;

        const progress = this.currentProgress;
        let status = 'Initializing...';

        if (progress < 20) status = 'Loading assets...';
        else if (progress < 40) status = 'Connecting to servers...';
        else if (progress < 60) status = 'Preparing content...';
        else if (progress < 80) status = 'Optimizing experience...';
        else if (progress < 95) status = 'Almost ready...';
        else status = 'Welcome to TKDS Media!';

        this.loadingStatus.textContent = status;
    }

    updateProgress(percent, status) {
        this.targetProgress = Math.max(this.targetProgress, percent);
        if (status && this.loadingStatus) {
            this.loadingStatus.textContent = status;
        }
    }

    startProgressAnimation() {
        setTimeout(() => {
            this.updateProgressBar();
        }, 2000);
    }

    completeLoading() {
        if (this.isComplete) return;
        this.isComplete = true;

        this.targetProgress = 100;
        this.updateProgress(100, 'Welcome to TKDS Media!');

        setTimeout(() => {
            if (this.preloader) {
                this.preloader.classList.add('preloader-fade-out');
                setTimeout(() => {
                    this.preloader.style.display = 'none';
                    window.dispatchEvent(new Event('preloaderComplete'));
                }, 800);
            }
        }, 800);
    }
}

// Initialize Smart Preloader
document.addEventListener('DOMContentLoaded', function() {
    new SmartPreloader();
    
    // Fallback completion after maximum time
    setTimeout(() => {
        const preloader = document.getElementById('preloader');
        if (preloader && !preloader.classList.contains('preloader-fade-out')) {
            preloader.classList.add('preloader-fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
                window.dispatchEvent(new Event('preloaderComplete'));
            }, 800);
        }
    }, 12000); // 12 second absolute maximum
});
</script>