@php
    $videoSections = App\Models\VideoSection::active()->ordered()->get();
    $activeVideo = $videoSections->first();
@endphp

@if($videoSections->count() > 0)
<section class="min-h-screen relative flex items-center bg-gradient-to-br from-gray-900 via-gray-800 to-black overflow-hidden">
    
    <!-- Animated Background -->
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-20 left-20 w-96 h-96 bg-gradient-to-r from-red-500/20 to-orange-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-gradient-to-r from-green-500/20 to-teal-500/20 rounded-full blur-2xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <!-- Floating Particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="particle absolute w-2 h-2 bg-white/10 rounded-full" style="top: 20%; left: 10%; animation: float 6s infinite;"></div>
        <div class="particle absolute w-1 h-1 bg-red-500/30 rounded-full" style="top: 40%; left: 80%; animation: float 8s infinite 1s;"></div>
        <div class="particle absolute w-3 h-3 bg-blue-500/20 rounded-full" style="top: 60%; left: 30%; animation: float 7s infinite 2s;"></div>
        <div class="particle absolute w-2 h-2 bg-yellow-500/20 rounded-full" style="top: 80%; left: 70%; animation: float 9s infinite 3s;"></div>
    </div>

    <div class="container mx-auto px-4 py-12 relative z-10">
        
        @if($activeVideo)
        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center min-h-[80vh]">
            
            <!-- Left Column - Content -->
            <div class="lg:col-span-5 order-2 lg:order-1 space-y-8" data-aos="fade-right" data-aos-duration="800">
                
                <!-- Live Badge - FIXED CENTERING -->
                <div id="video-badge">
                    @if($activeVideo->isLiveStream())
                    <div class="inline-flex items-center justify-center space-x-3 px-6 py-3 bg-gradient-to-r from-red-600/20 to-red-500/20 border border-red-500/30 rounded-full backdrop-blur-sm">
                        <div class="relative flex items-center justify-center">
                            <span class="w-3 h-3 bg-red-500 rounded-full animate-ping absolute"></span>
                            <span class="w-3 h-3 bg-red-600 rounded-full relative"></span>
                        </div>
                        <span class="text-red-400 font-semibold text-sm tracking-wider">LIVE STREAMING</span>
                    </div>
                    @else
                    <div class="inline-flex items-center justify-center space-x-3 px-6 py-3 bg-gradient-to-r from-blue-600/20 to-purple-500/20 border border-blue-500/30 rounded-full backdrop-blur-sm">
                        <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
                        <span class="text-blue-400 font-semibold text-sm tracking-wider">PROFESSIONAL VIDEO</span>
                    </div>
                    @endif
                </div>
                
                <!-- Main Title -->
                <div class="space-y-4">
                    <h1 id="video-title" class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black leading-tight">
                        <span class="bg-gradient-to-r from-white via-gray-100 to-gray-300 bg-clip-text text-transparent">
                            {!! $activeVideo->title !!}
                        </span>
                    </h1>
                    
                    <h2 id="video-subtitle" class="text-xl sm:text-2xl lg:text-3xl text-gray-300 font-medium {{ $activeVideo->subtitle ? '' : 'hidden' }}">
                        {{ $activeVideo->subtitle }}
                    </h2>
                </div>
                
                <!-- Description -->
                <p id="video-description" class="text-gray-400 text-lg leading-relaxed max-w-xl {{ $activeVideo->description ? '' : 'hidden' }}">
                    {{ $activeVideo->description }}
                </p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a id="video-button" href="{{ $activeVideo->button_link }}" 
                       class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold rounded-xl hover:from-red-500 hover:to-red-400 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-red-500/25 {{ $activeVideo->button_text && $activeVideo->button_link ? '' : 'hidden' }}">
                        <span id="video-button-text">{{ $activeVideo->button_text }}</span>
                        <svg class="w-5 h-5 ml-3 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    
                    <button onclick="toggleVideo()" 
                            class="group inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-gray-600 text-white font-semibold rounded-xl hover:border-red-500 hover:bg-red-500/10 transition-all duration-300 backdrop-blur-sm">
                        <svg id="play-icon" class="w-5 h-5 mr-3 transform group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                        </svg>
                        <span id="play-text">Watch Demo</span>
                    </button>
                </div>
                
                <!-- Video Navigation - FIXED CENTERING -->
                @if($videoSections->count() > 1)
                <div class="space-y-4">
                    <h3 class="text-gray-400 text-sm font-medium uppercase tracking-wider">More Videos</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($videoSections as $index => $video)
                        <button class="video-nav-pill group px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 backdrop-blur-sm border
                            {{ $index === 0 ? 'bg-gradient-to-r from-red-600/20 to-red-500/20 border-red-500/30 text-red-400' : 'bg-gray-800/30 border-gray-700/50 text-gray-300 hover:bg-gray-700/40 hover:border-gray-600/50 hover:text-white' }}"
                            onclick="switchVideo({{ $index }})">
                            
                            <div class="flex items-center justify-center space-x-2">
                                @if($video->isLiveStream())
                                    <div class="flex items-center justify-center">
                                        <div class="w-2 h-2 bg-red-500 rounded-full {{ $index === 0 ? 'animate-pulse' : '' }}"></div>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                                <span>{{ Str::limit($video->title, 20) }}</span>
                            </div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
                
            </div>
            
            <!-- Right Column - Video Player -->
            <div class="lg:col-span-7 order-1 lg:order-2" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200">
                <div class="relative">
                    
                    <!-- Video Container with Glass Effect -->
                    <div class="relative bg-black/20 backdrop-blur-xl rounded-3xl overflow-hidden shadow-2xl border border-white/10">
                        
                        <!-- Video Player -->
                        <div class="aspect-video relative">
                            @if($activeVideo->hasVideo())
                                @if($activeVideo->isLiveStream())
                                    <!-- Live Stream Video -->
                                    <video id="main-video" 
                                           class="w-full h-full object-cover"
                                           {{ $activeVideo->shouldAutoplay() ? 'autoplay' : '' }}
                                           {{ $activeVideo->shouldLoop() ? 'loop' : '' }}
                                           {{ $activeVideo->isMuted() ? 'muted' : '' }}
                                           {{ $activeVideo->hasControls() ? 'controls' : '' }}
                                           poster="{{ $activeVideo->thumbnail_url }}">
                                        <source src="{{ $activeVideo->video_source }}" type="application/x-mpegURL">
                                        <p class="text-white text-center p-8">Your browser doesn't support video playback.</p>
                                    </video>
                                @else
                                    <!-- Uploaded Video -->
                                    <video id="main-video" 
                                           class="w-full h-full object-cover"
                                           {{ $activeVideo->shouldAutoplay() ? 'autoplay' : '' }}
                                           {{ $activeVideo->shouldLoop() ? 'loop' : '' }}
                                           {{ $activeVideo->isMuted() ? 'muted' : '' }}
                                           {{ $activeVideo->hasControls() ? 'controls' : '' }}
                                           poster="{{ $activeVideo->thumbnail_url }}">
                                        <source src="{{ $activeVideo->video_source }}" type="video/mp4">
                                        <p class="text-white text-center p-8">Your browser doesn't support video playback.</p>
                                    </video>
                                @endif
                            @else
                                <!-- Placeholder -->
                                <div class="flex items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900 h-96">
                                    <div class="text-center text-gray-400">
                                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        <h3 class="text-xl font-semibold mb-2">Video Coming Soon</h3>
                                        <p>Professional content will be available here</p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Live Badge Overlay - FIXED CENTERING -->
                            <div id="live-overlay" class="absolute top-6 left-6 {{ $activeVideo->isLiveStream() ? '' : 'hidden' }}">
                                <div class="flex items-center justify-center space-x-2 px-4 py-2 bg-red-600/90 backdrop-blur-sm text-white text-sm font-bold rounded-full shadow-lg">
                                    <div class="flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    </div>
                                    <span>LIVE</span>
                                </div>
                            </div>

                            <!-- Quality Badge -->
                            <div class="absolute top-6 right-6">
                                <div class="px-3 py-1 bg-black/70 backdrop-blur-sm text-white text-xs font-bold rounded-full border border-white/20">
                                    4K HDR
                                </div>
                            </div>
                            
                            <!-- Custom Play Button Overlay -->
                            <div id="play-overlay" class="absolute inset-0 flex items-center justify-center bg-black/30 cursor-pointer hover:bg-black/40 transition-all duration-300 backdrop-blur-sm {{ $activeVideo->shouldAutoplay() ? 'hidden' : '' }}" onclick="toggleVideo()">
                                <div class="group w-24 h-24 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center shadow-2xl transform hover:scale-110 transition-all duration-300 border border-white/30">
                                    <svg class="w-8 h-8 text-white ml-1 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Stats Cards -->
                    <div class="absolute -bottom-8 -left-8 hidden xl:block">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-transform duration-300">
                            <div class="grid grid-cols-1 gap-4 text-center min-w-[120px]">
                                <div>
                                    <div class="text-2xl font-bold text-white">99.9%</div>
                                    <div class="text-xs text-gray-300 uppercase tracking-wider">Uptime</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-white">&lt;1s</div>
                                    <div class="text-xs text-gray-300 uppercase tracking-wider">Latency</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quality Stats -->
                    <div class="absolute -bottom-8 -right-8 hidden xl:block">
                        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 shadow-xl transform hover:scale-105 transition-transform duration-300">
                            <div class="text-center min-w-[100px]">
                                <div class="text-2xl font-bold text-white">4K</div>
                                <div class="text-xs text-gray-300 uppercase tracking-wider">Quality</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Background Glow Effect -->
                    <div class="absolute -inset-8 bg-gradient-to-r from-red-500/20 via-purple-500/20 to-blue-500/20 rounded-3xl blur-2xl -z-10 opacity-60 animate-pulse"></div>
                    
                </div>
            </div>
            
        </div>
        @endif
        
        <!-- Mobile Stats Grid -->
        <div class="grid grid-cols-3 gap-6 mt-16 lg:hidden" data-aos="fade-up" data-aos-delay="400">
            @php
                $stats = [
                    ['99.9%', 'Uptime'],
                    ['<1s', 'Latency'], 
                    ['4K', 'Quality']
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="text-center p-6 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10">
                <div class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ $stat[0] }}</div>
                <div class="text-gray-400 text-sm uppercase tracking-wider">{{ $stat[1] }}</div>
            </div>
            @endforeach
        </div>
        
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white/50 animate-bounce">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { 
        transform: translateY(0px) rotate(0deg); 
        opacity: 0.7;
    }
    50% { 
        transform: translateY(-30px) rotate(180deg); 
        opacity: 1;
    }
}

.particle {
    animation-timing-function: ease-in-out;
    animation-iteration-count: infinite;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: rgba(239, 68, 68, 0.5);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(239, 68, 68, 0.7);
}

/* Video player enhancements */
video::-webkit-media-controls {
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
}

/* Glass morphism effects */
.video-nav-pill {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

/* Responsive text scaling */
@media (max-width: 640px) {
    .aspect-video {
        aspect-ratio: 16 / 9;
    }
}

/* Enhanced animations */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.05);
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<script>
// Enhanced video data with all content
@php
    $videoDataArray = $videoSections->map(function($video) {
        return [
            'id' => $video->id,
            'title' => $video->title,
            'subtitle' => $video->subtitle,
            'description' => $video->description,
            'button_text' => $video->button_text,
            'button_link' => $video->button_link,
            'video_type' => $video->video_type,
            'video_source' => $video->video_source,
            'thumbnail_url' => $video->thumbnail_url,
            'autoplay' => $video->shouldAutoplay(),
            'loop' => $video->shouldLoop(),
            'muted' => $video->isMuted(),
            'controls' => $video->hasControls(),
            'is_live_stream' => $video->isLiveStream()
        ];
    });
@endphp

const videoData = @json($videoDataArray);

let isPlaying = false;

function switchVideo(index) {
    const video = document.getElementById('main-video');
    const pills = document.querySelectorAll('.video-nav-pill');
    const playOverlay = document.getElementById('play-overlay');
    const liveOverlay = document.getElementById('live-overlay');
    
    // Update pill states
    pills.forEach((pill, i) => {
        pill.classList.remove('bg-gradient-to-r', 'from-red-600/20', 'to-red-500/20', 'border-red-500/30', 'text-red-400');
        pill.classList.remove('bg-gray-800/30', 'border-gray-700/50', 'text-gray-300');
        
        if (i === index) {
            pill.classList.add('bg-gradient-to-r', 'from-red-600/20', 'to-red-500/20', 'border-red-500/30', 'text-red-400');
        } else {
            pill.classList.add('bg-gray-800/30', 'border-gray-700/50', 'text-gray-300');
        }
    });
    
    // Update video and content
    if (video && videoData[index]) {
        const newVideoData = videoData[index];
        
        // Update video source
        video.style.opacity = '0.5';
        video.pause();
        video.src = newVideoData.video_source;
        
        if (newVideoData.is_live_stream) {
            video.setAttribute('type', 'application/x-mpegURL');
        } else {
            video.setAttribute('type', 'video/mp4');
        }
        
        video.load();
        
        video.addEventListener('loadeddata', function onLoad() {
            video.style.opacity = '1';
            video.removeEventListener('loadeddata', onLoad);
        });
        
        // Update content elements
        updateVideoContent(newVideoData);
        
        // Handle autoplay and overlay
        if (playOverlay) {
            if (newVideoData.autoplay) {
                playOverlay.style.display = 'none';
                video.play().catch(e => console.log('Autoplay prevented:', e));
                isPlaying = true;
            } else {
                playOverlay.style.display = 'flex';
                isPlaying = false;
            }
        }
        
        // Update live overlay
        if (liveOverlay) {
            if (newVideoData.is_live_stream) {
                liveOverlay.classList.remove('hidden');
            } else {
                liveOverlay.classList.add('hidden');
            }
        }
        
        updatePlayButton();
    }
}

function updateVideoContent(videoData) {
    // Update badge
    const badge = document.getElementById('video-badge');
    if (badge) {
        badge.innerHTML = videoData.is_live_stream ? `
            <div class="inline-flex items-center justify-center space-x-3 px-6 py-3 bg-gradient-to-r from-red-600/20 to-red-500/20 border border-red-500/30 rounded-full backdrop-blur-sm">
                <div class="relative flex items-center justify-center">
                    <span class="w-3 h-3 bg-red-500 rounded-full animate-ping absolute"></span>
                    <span class="w-3 h-3 bg-red-600 rounded-full relative"></span>
                </div>
                <span class="text-red-400 font-semibold text-sm tracking-wider">LIVE STREAMING</span>
            </div>
        ` : `
            <div class="inline-flex items-center justify-center space-x-3 px-6 py-3 bg-gradient-to-r from-blue-600/20 to-purple-500/20 border border-blue-500/30 rounded-full backdrop-blur-sm">
                <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
                <span class="text-blue-400 font-semibold text-sm tracking-wider">PROFESSIONAL VIDEO</span>
            </div>
        `;
    }
    
    // Update title
    const title = document.getElementById('video-title');
    if (title && videoData.title) {
        title.innerHTML = `<span class="bg-gradient-to-r from-white via-gray-100 to-gray-300 bg-clip-text text-transparent">${videoData.title}</span>`;
    }
    
    // Update subtitle
    const subtitle = document.getElementById('video-subtitle');
    if (subtitle) {
        if (videoData.subtitle) {
            subtitle.textContent = videoData.subtitle;
            subtitle.classList.remove('hidden');
        } else {
            subtitle.classList.add('hidden');
        }
    }
    
    // Update description
    const description = document.getElementById('video-description');
    if (description) {
        if (videoData.description) {
            description.textContent = videoData.description;
            description.classList.remove('hidden');
        } else {
            description.classList.add('hidden');
        }
    }
    
    // Update button
    const button = document.getElementById('video-button');
    const buttonText = document.getElementById('video-button-text');
    if (button && buttonText) {
        if (videoData.button_text && videoData.button_link) {
            button.href = videoData.button_link;
            buttonText.textContent = videoData.button_text;
            button.classList.remove('hidden');
        } else {
            button.classList.add('hidden');
        }
    }
}

function toggleVideo() {
    const video = document.getElementById('main-video');
    const playOverlay = document.getElementById('play-overlay');
    
    if (video) {
        if (video.paused) {
            video.play().then(() => {
                if (playOverlay) playOverlay.style.display = 'none';
                isPlaying = true;
                updatePlayButton();
            }).catch(e => {
                console.log('Play failed:', e);
            });
        } else {
            video.pause();
            if (playOverlay) playOverlay.style.display = 'flex';
            isPlaying = false;
            updatePlayButton();
        }
    }
}

function updatePlayButton() {
    const playIcon = document.getElementById('play-icon');
    const playText = document.getElementById('play-text');
    
    if (playIcon && playText) {
        if (isPlaying) {
            playIcon.innerHTML = '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>';
            playText.textContent = 'Pause Video';
        } else {
            playIcon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>';
            playText.textContent = 'Watch Demo';
        }
    }
}

// Enhanced video event handling
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('main-video');
    
    // Initialize HLS for live streams
    if (video && video.src.includes('.m3u8')) {
        if (typeof Hls !== 'undefined' && Hls.isSupported()) {
            const hls = new Hls({
                enableWorker: false,
                lowLatencyMode: true
            });
            hls.loadSource(video.src);
            hls.attachMedia(video);
            
            hls.on(Hls.Events.ERROR, function(event, data) {
                console.error('HLS Error:', data);
            });
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = video.src;
        }
    }
    
    // Enhanced video event listeners
    if (video) {
        video.addEventListener('play', function() {
            isPlaying = true;
            updatePlayButton();
            const playOverlay = document.getElementById('play-overlay');
            if (playOverlay) {
                playOverlay.style.opacity = '0';
                setTimeout(() => playOverlay.style.display = 'none', 300);
            }
        });
        
        video.addEventListener('pause', function() {
            isPlaying = false;
            updatePlayButton();
        });
        
        video.addEventListener('ended', function() {
            isPlaying = false;
            updatePlayButton();
            const playOverlay = document.getElementById('play-overlay');
            if (playOverlay) {
                playOverlay.style.display = 'flex';
                playOverlay.style.opacity = '1';
            }
        });
        
        video.addEventListener('waiting', function() {
            // Show loading indicator if needed
        });
        
        video.addEventListener('canplay', function() {
            // Hide loading indicator
        });
    }
    
    // Add smooth scrolling
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
});
</script>

<!-- HLS.js for live streaming support -->
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
@endif