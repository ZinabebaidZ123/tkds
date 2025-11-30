<!-- Services Section Component -->
<section id="services" class="py-16 bg-dark relative overflow-hidden">
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
        </div>

        <!-- Services Grid from Database (Latest 8 Services) -->
        @php
            $latestServices = \App\Models\Service::active()->ordered()->limit(8)->get();
        @endphp

        @if($latestServices->count() > 0)
            <!-- First Row (4 Services) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestServices->take(4) as $index => $service)
                    <div class="group relative" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
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
            </div>

            <!-- Second Row (Remaining 4 Services) -->
            @if($latestServices->count() > 4)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                    @foreach($latestServices->skip(4)->take(4) as $index => $service)
                        <div class="group relative" data-aos="fade-up" data-aos-delay="{{ ($index + 5) * 100 }}">
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
                </div>
            @endif
        @else
            <!-- Fallback to Static Services (if no services in database) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Service 1 - Streaming -->
                <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative h-80 bg-gradient-to-br from-gray-900/50 to-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 hover:border-primary/50 transition-all duration-500 hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-primary/20">
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-broadcast-tower text-white text-2xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300">
                            Stream & Restream
                        </h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                            Professional streaming and social media publication services
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('services') }}" class="absolute bottom-6 left-6 right-6 bg-primary/10 hover:bg-primary text-primary hover:text-white border border-primary/30 hover:border-primary rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center block">
                            View Services
                        </a>
                    </div>
                </div>

                <!-- Service 2 - OTT Apps -->
                <div class="group relative" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative h-80 bg-gradient-to-br from-gray-900/50 to-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 hover:border-secondary/50 transition-all duration-500 hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-secondary/20">
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-mobile-alt text-white text-2xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-secondary transition-colors duration-300">
                            OTT APPS
                        </h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                            Roku, iOS, Android, SmartTV, FireTV and more platforms
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('services') }}" class="absolute bottom-6 left-6 right-6 bg-secondary/10 hover:bg-secondary text-secondary hover:text-white border border-secondary/30 hover:border-secondary rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center block">
                            View Services
                        </a>
                    </div>
                </div>

                <!-- Service 3 - Graphic Design -->
                <div class="group relative" data-aos="fade-up" data-aos-delay="300">
                    <div class="relative h-80 bg-gradient-to-br from-gray-900/50 to-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 hover:border-accent/50 transition-all duration-500 hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-accent/20">
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-accent to-primary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-palette text-white text-2xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent transition-colors duration-300">
                            Graphic Design
                        </h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                            Professional designs for production and VMIX special graphics
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('services') }}" class="absolute bottom-6 left-6 right-6 bg-accent/10 hover:bg-accent text-accent hover:text-white border border-accent/30 hover:border-accent rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center block">
                            View Services
                        </a>
                    </div>
                </div>

                <!-- Service 4 - Cloud Servers -->
                <div class="group relative" data-aos="fade-up" data-aos-delay="400">
                    <div class="relative h-80 bg-gradient-to-br from-gray-900/50 to-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 hover:border-primary/50 transition-all duration-500 hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-primary/20">
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-cloud text-white text-2xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300">
                            Cloud 24/7 Servers
                        </h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                            Professional playout servers for IPTV and satellite needs
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('services') }}" class="absolute bottom-6 left-6 right-6 bg-primary/10 hover:bg-primary text-primary hover:text-white border border-primary/30 hover:border-primary rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center block">
                            View Services
                        </a>
                    </div>
                </div>

            </div>

            <!-- Second Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                
                <!-- Service 5 - Radio & Podcast -->
                <div class="group relative" data-aos="fade-up" data-aos-delay="500">
                    <div class="relative h-80 bg-gradient-to-br from-gray-900/50 to-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 hover:border-secondary/50 transition-all duration-500 hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-secondary/20">
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-microphone text-white text-2xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-secondary transition-colors duration-300">
                            Radio & PODCAST
                        </h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                            Professional radio stations and podcast services
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('services') }}" class="absolute bottom-6 left-6 right-6 bg-secondary/10 hover:bg-secondary text-secondary hover:text-white border border-secondary/30 hover:border-secondary rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center block">
                            View Services
                        </a>
                    </div>
                </div>

                <!-- Service 6 - OTT Platform -->
                <div class="group relative" data-aos="fade-up" data-aos-delay="600">
                    <div class="relative h-80 bg-gradient-to-br from-gray-900/50 to-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 hover:border-accent/50 transition-all duration-500 hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-accent/20">
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-accent to-primary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-tv text-white text-2xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent transition-colors duration-300">
                            OTT PLATFORM
                        </h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                            Cutting-edge OTT platform that fits your specific needs
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('services') }}" class="absolute bottom-6 left-6 right-6 bg-accent/10 hover:bg-accent text-accent hover:text-white border border-accent/30 hover:border-accent rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center block">
                            View Services
                        </a>
                    </div>
                </div>

                <!-- Service 7 - Streaming Service -->
                <div class="group relative" data-aos="fade-up" data-aos-delay="700">
                    <div class="relative h-80 bg-gradient-to-br from-gray-900/50 to-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 hover:border-primary/50 transition-all duration-500 hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-primary/20">
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-server text-white text-2xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300">
                            Streaming Service
                        </h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                            Best streaming servers with premium cluster technology
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('services') }}" class="absolute bottom-6 left-6 right-6 bg-primary/10 hover:bg-primary text-primary hover:text-white border border-primary/30 hover:border-primary rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center block">
                            View Services
                        </a>
                    </div>
                </div>

                <!-- Service 8 - Sports Production -->
                <div class="group relative" data-aos="fade-up" data-aos-delay="800">
                    <div class="relative h-80 bg-gradient-to-br from-gray-900/50 to-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 hover:border-secondary/50 transition-all duration-500 hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-secondary/20">
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-secondary to-accent rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-futbol text-white text-2xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-secondary transition-colors duration-300">
                            Sports LIVE Production
                        </h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                            Professional live sports production for all types of events
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('services') }}" class="absolute bottom-6 left-6 right-6 bg-secondary/10 hover:bg-secondary text-secondary hover:text-white border border-secondary/30 hover:border-secondary rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center block">
                            View Services
                        </a>
                    </div>
                </div>

            </div>
        @endif

        <!-- Call to Action -->
        <div class="text-center mt-16" data-aos="fade-up" data-aos-delay="900">
            <a href="{{ route('services') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-full hover:from-secondary hover:to-primary transition-all duration-300 transform hover:scale-105 hover:shadow-xl hover:shadow-primary/30 group">
                <span>Explore All Services</span>
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
        </div>
    </div>
</section>