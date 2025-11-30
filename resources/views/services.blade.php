@extends('layouts.app')

@section('title', 'Our Services - TKDS Media')
@section('meta_description', 'Comprehensive broadcasting solutions including streaming, OTT apps, graphic design, cloud servers, radio, and sports production services.')

@section('content')

<section id="services" class="py-20 bg-dark-light relative overflow-hidden mt-20">
    <!-- Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-accent/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-block">
                <span class="text-primary text-sm font-semibold uppercase tracking-wider mb-2 block">Our Services</span>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-4">
                    <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent uppercase opacity-60">
                        achieve your goals
                    </span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
            </div>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto mt-6">
                From live streaming to cloud production, we provide everything you need to create, manage, and distribute professional content
            </p>
        </div>

        <!-- Services Grid from Database -->
@if($services->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($services->chunk(4) as $row)
                    @foreach($row as $index => $service)
                        <!-- Service Card -->
                        <div class="group relative" data-aos="fade-up" data-aos-delay="{{ ($loop->parent->index * 4 + $index + 1) * 100 }}">
                            <div class="relative h-100 bg-gradient-to-br from-gray-900/50 to-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 {{ $service->getHoverBorderClass() }} transition-all duration-500 hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-{{ $service->color_from }}/20 flex flex-col">
                                
                                <!-- Featured Badge -->
                                @if($service->is_featured)
                                    <div class="absolute -top-2 -right-2 z-10">
                                        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </div>
                                    </div>
                                @endif

                                <!-- Icon -->
                                <div class="w-16 h-16 bg-gradient-to-br {{ $service->getGradientClass() }} rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <i class="{{ $service->icon }} text-white text-2xl"></i>
                                </div>
                                
                                <!-- Content Container - grows to fill space -->
                                <div class="flex-1 flex flex-col">
                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-{{ $service->color_from }} transition-colors duration-300">
                                        {{ $service->title }}
                                    </h3>
                                    
                                    <!-- Description -->
                                    <p class="text-gray-400 text-sm mb-4 leading-relaxed">
                                        {{ $service->description }}
                                    </p>
                                    
                                    <!-- Features Preview -->
                                    @if($service->getFeatures())
                                        <div class="space-y-2 mb-4 flex-1">
                                            @foreach(array_slice($service->getFeatures(), 0, 2) as $feature)
                                                <div class="flex items-center text-gray-300 text-xs">
                                                    <i class="fas fa-check text-{{ $service->color_from }} mr-2"></i>
                                                    <span>{{ $feature }}</span>
                                                </div>
                                            @endforeach
                                            @if(count($service->getFeatures()) > 2)
                                                <div class="text-xs text-gray-500">
                                                    +{{ count($service->getFeatures()) - 2 }} more features
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <!-- Button - Always at bottom -->
                                    <div class="mt-auto">
                                        <a href="{{ $service->getUrl() }}" class="w-full {{ $service->getButtonClass() }} rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center block">
                                            Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        @else
            <!-- No Services Available -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-cogs text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Services Coming Soon</h3>
                <p class="text-gray-400 mb-6 max-w-sm mx-auto">We're working hard to bring you amazing services. Stay tuned!</p>
            </div>
        @endif

        <!-- Features Section -->
        <div class="mt-20" data-aos="fade-up">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-black text-white mb-4">Why Choose TKDS Media?</h3>
                <p class="text-gray-400">Industry-leading features that set us apart</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-globe text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">Global CDN</h4>
                    <p class="text-gray-400 text-sm">Worldwide content delivery network for maximum reach</p>
                </div>
                
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-r from-secondary to-accent rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">99.9% Uptime</h4>
                    <p class="text-gray-400 text-sm">Reliable infrastructure with guaranteed uptime</p>
                </div>
                
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-r from-accent to-primary rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">24/7 Support</h4>
                    <p class="text-gray-400 text-sm">Round-the-clock technical support and assistance</p>
                </div>
                
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-rocket text-white text-2xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">Low Latency</h4>
                    <p class="text-gray-400 text-sm">Ultra-low latency streaming for real-time interaction</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-16" data-aos="fade-up" data-aos-delay="900">
            <div class="glass-effect rounded-2xl p-8 max-w-4xl mx-auto">
                <h3 class="text-3xl font-black text-white mb-4">Ready to Start Broadcasting?</h3>
                <p class="text-gray-400 mb-8">Join thousands of content creators who trust TKDS Media for their broadcasting needs</p>
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('pricing') }}" class="px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105">
                        View Packages
                    </a>
                    <a href="{{ route('contact') }}" class="px-8 py-4 glass-effect text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection