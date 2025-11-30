{{-- Path: resources/views/about.blade.php --}}
@extends('layouts.app')

@php
    $settings = \App\Models\AboutSetting::getSettings();
    $values = \App\Models\AboutValue::getActiveOrdered();
    $timeline = \App\Models\AboutTimeline::getActiveOrdered();
@endphp

@section('title', $settings->meta_title ?: 'TKDS Media - About Us')
@section('meta_description', $settings->meta_description ?: 'Leading digital broadcasting solutions with professional streaming, cloud production, and OTT platforms. Transform your content with TKDS Media.')

@section('content')

<section class="py-20 bg-dark-light relative overflow-hidden mt-20">
    <!-- Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-secondary/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-accent/5 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            @if($settings->hero_badge_text)
            <div class="inline-flex items-center space-x-2 bg-accent/10 rounded-full px-6 py-2 mb-6">
                <i class="fas fa-info-circle text-accent"></i>
                <span class="text-accent font-medium">{{ $settings->hero_badge_text }}</span>
            </div>
            @endif
            
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                {!! str_replace('Digital Broadcasting', '<span class="text-gradient">Digital Broadcasting</span>', $settings->hero_title) !!}
            </h2>
            
            @if($settings->hero_subtitle)
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                {{ $settings->hero_subtitle }}
            </p>
            @endif
        </div>
        
        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-20">
            <!-- Content -->
            <div class="space-y-8" data-aos="fade-right">
                @if($settings->mission_title && $settings->mission_content)
                <div>
                    <h3 class="text-3xl font-black text-white mb-4">{{ $settings->mission_title }}</h3>
                    <p class="text-gray-400 text-lg leading-relaxed">
                        {{ $settings->mission_content }}
                    </p>
                </div>
                @endif
                
                @if($settings->innovation_title && $settings->innovation_content)
                <div>
                    <h3 class="text-3xl font-black text-white mb-4">{{ $settings->innovation_title }}</h3>
                    <p class="text-gray-400 text-lg leading-relaxed">
                        {{ $settings->innovation_content }}
                    </p>
                </div>
                @endif
                
                <!-- Key Stats -->
                @if($settings->stat_1_number || $settings->stat_2_number)
                <div class="grid grid-cols-2 gap-6">
                    @if($settings->stat_1_number && $settings->stat_1_label)
                    <div class="glass-effect rounded-xl p-6 text-center group hover:bg-white/10 transition-all duration-300">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white mb-2">{{ $settings->stat_1_number }}</h4>
                        <p class="text-gray-400 text-sm">{{ $settings->stat_1_label }}</p>
                    </div>
                    @endif
                    
                    @if($settings->stat_2_number && $settings->stat_2_label)
                    <div class="glass-effect rounded-xl p-6 text-center group hover:bg-white/10 transition-all duration-300">
                        <div class="w-12 h-12 bg-gradient-to-r from-secondary to-accent rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-globe text-white"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white mb-2">{{ $settings->stat_2_number }}</h4>
                        <p class="text-gray-400 text-sm">{{ $settings->stat_2_label }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            
            <!-- Visual Element -->
            <div class="relative" data-aos="fade-left">
                <div class="glass-effect rounded-2xl p-8 relative overflow-hidden">
                    <!-- Video/Image Section -->
                    @if($settings->video_enabled && $settings->video_url)
                    <div class="aspect-video bg-gradient-to-br from-primary/20 to-secondary/20 rounded-xl mb-6 relative overflow-hidden" id="video-container">
                        <!-- Thumbnail View -->
                        <div id="video-thumbnail" class="w-full h-full relative cursor-pointer">
                            <img src="{{ $settings->getVideoThumbnailUrl() }}" alt="Video Thumbnail" class="w-full h-full object-cover rounded-xl">
                            <div class="absolute inset-0 flex items-center justify-center bg-black/30 hover:bg-black/40 transition-colors duration-300">
                                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 hover:scale-110 transition-all duration-300">
                                    <i class="fas fa-play text-white text-2xl ml-1"></i>
                                </div>
                            </div>
                            <div class="absolute top-4 left-4">
                                <div class="flex items-center space-x-2 bg-black/50 backdrop-blur-sm rounded-full px-3 py-1">
                                    <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                                    <span class="text-white text-sm font-medium">LIVE</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video Player (Hidden by default) -->
                        <div id="video-player" class="w-full h-full hidden">
                            @if(str_contains($settings->video_url, 'youtube.com') || str_contains($settings->video_url, 'youtu.be'))
                                @php
                                    $video_id = '';
                                    if(str_contains($settings->video_url, 'youtube.com/watch?v=')) {
                                        $video_id = explode('v=', $settings->video_url)[1];
                                        $video_id = explode('&', $video_id)[0];
                                    } elseif(str_contains($settings->video_url, 'youtu.be/')) {
                                        $video_id = explode('youtu.be/', $settings->video_url)[1];
                                        $video_id = explode('?', $video_id)[0];
                                    }
                                @endphp
                                <iframe 
                                    class="w-full h-full rounded-xl" 
                                    src="https://www.youtube.com/embed/{{ $video_id }}?autoplay=1&rel=0&modestbranding=1" 
                                    frameborder="0" 
                                    allowfullscreen
                                    allow="autoplay; encrypted-media">
                                </iframe>
                            @elseif(str_contains($settings->video_url, 'vimeo.com'))
                                @php
                                    $video_id = explode('vimeo.com/', $settings->video_url)[1];
                                    $video_id = explode('?', $video_id)[0];
                                @endphp
                                <iframe 
                                    class="w-full h-full rounded-xl" 
                                    src="https://player.vimeo.com/video/{{ $video_id }}?autoplay=1&title=0&byline=0&portrait=0" 
                                    frameborder="0" 
                                    allowfullscreen
                                    allow="autoplay; encrypted-media">
                                </iframe>
                            @else
                                <!-- For MP4 or other direct video files -->
                                <video 
                                    class="w-full h-full rounded-xl object-cover" 
                                    controls 
                                    autoplay
                                    preload="metadata">
                                    <source src="{{ $settings->video_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                            
                            <!-- Close Button -->
                            <button 
                                id="close-video" 
                                class="absolute top-4 right-4 w-10 h-10 bg-black/50 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-black/70 transition-colors duration-300">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-primary/20 to-secondary/20 rounded-xl mb-6 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center cursor-pointer hover:bg-white/30 transition-all duration-300">
                                <i class="fas fa-play text-white text-2xl ml-1"></i>
                            </div>
                        </div>
                        <div class="absolute top-4 left-4">
                            <div class="flex items-center space-x-2 bg-black/50 rounded-full px-3 py-1">
                                <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                                <span class="text-white text-sm font-medium">LIVE</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Performance Stats -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-black text-gradient">{{ $settings->uptime_percentage }}</div>
                            <div class="text-xs text-gray-400">Uptime</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-black text-gradient">{{ $settings->latency_time }}</div>
                            <div class="text-xs text-gray-400">Latency</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-black text-gradient">{{ $settings->quality_level }}</div>
                            <div class="text-xs text-gray-400">Quality</div>
                        </div>
                    </div>
                </div>
                
                <!-- Floating Elements -->
                <div class="absolute -top-6 -right-6 w-12 h-12 bg-primary/20 rounded-full blur-xl animate-float"></div>
                <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-secondary/20 rounded-full blur-xl animate-float" style="animation-delay: 2s;"></div>
            </div>
        </div>
        
        <!-- Values Section -->
        @if($values->count() > 0)
        <div class="mb-20" data-aos="fade-up">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-black text-white mb-4">Our Core Values</h3>
                <p class="text-gray-400">The principles that guide everything we do</p>
            </div>
            
            <div class="grid md:grid-cols-{{ min($values->count(), 3) }} gap-8">
                @foreach($values as $value)
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-r {{ $value->getGradientClass() }} rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        {!! $value->getIconHtml() !!} <span class="text-white text-2xl"></span>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">{{ $value->title }}</h4>
                    <p class="text-gray-400">{{ $value->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Timeline Section -->
        @if($timeline->count() > 0)
        <div class="mb-20" data-aos="fade-up">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-black text-white mb-4">Our Journey</h3>
                <p class="text-gray-400">Milestones that shaped our company</p>
            </div>
            
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gradient-to-b from-primary via-secondary to-accent rounded-full"></div>
                
                <div class="space-y-12">
                    @foreach($timeline as $index => $item)
                    <!-- Timeline Item -->
                    <div class="flex items-center relative">
                        @if($item->isLeftPosition())
                        <div class="w-1/2 pr-8 text-right">
                            <div class="glass-effect rounded-xl p-6">
                                <h4 class="text-xl font-bold text-white mb-2">{{ $item->year }}</h4>
                                <h5 class="text-lg font-semibold text-{{ $item->color }} mb-2">{{ $item->title }}</h5>
                                <p class="text-gray-400">{{ $item->description }}</p>
                            </div>
                        </div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 {{ $item->getColorClass() }} rounded-full border-4 border-dark-light"></div>
                        <div class="w-1/2 pl-8"></div>
                        @else
                        <div class="w-1/2 pr-8"></div>
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 {{ $item->getColorClass() }} rounded-full border-4 border-dark-light"></div>
                        <div class="w-1/2 pl-8">
                            <div class="glass-effect rounded-xl p-6">
                                <h4 class="text-xl font-bold text-white mb-2">{{ $item->year }}</h4>
                                <h5 class="text-lg font-semibold text-{{ $item->color }} mb-2">{{ $item->title }}</h5>
                                <p class="text-gray-400">{{ $item->description }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        
        <!-- CTA Section -->
        <div class="text-center" data-aos="fade-up">
            <div class="glass-effect rounded-2xl p-12 max-w-4xl mx-auto">
                <h3 class="text-3xl font-black text-white mb-4">Ready to Join Our Community?</h3>
                <p class="text-gray-400 mb-8 text-lg">
                    Become part of a growing community of creators, broadcasters, and innovators who are shaping the future of digital media
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('pricing') }}" class="px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105">
                        Start Your Journey
                    </a>
                    <a href="{{ route('contact') }}" class="px-8 py-4 glass-effect text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for Video Control -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoThumbnail = document.getElementById('video-thumbnail');
    const videoPlayer = document.getElementById('video-player');
    const closeVideo = document.getElementById('close-video');
    
    if (videoThumbnail && videoPlayer && closeVideo) {
        // Show video when thumbnail is clicked
        videoThumbnail.addEventListener('click', function() {
            videoThumbnail.classList.add('hidden');
            videoPlayer.classList.remove('hidden');
        });
        
        // Hide video when close button is clicked
        closeVideo.addEventListener('click', function() {
            videoPlayer.classList.add('hidden');
            videoThumbnail.classList.remove('hidden');
            
            // Stop video if it's an iframe (YouTube/Vimeo)
            const iframe = videoPlayer.querySelector('iframe');
            if (iframe) {
                const src = iframe.src;
                iframe.src = '';
                iframe.src = src.replace('autoplay=1', 'autoplay=0');
            }
            
            // Pause video if it's a video element
            const video = videoPlayer.querySelector('video');
            if (video) {
                video.pause();
                video.currentTime = 0;
            }
        });
    }
});
</script>

@endsection