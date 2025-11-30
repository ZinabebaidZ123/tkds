@extends('layouts.app')

@section('title', 'Products - TKDS Media SaaS Solutions')
@section('meta_description', 'Explore our cutting-edge SaaS products including streaming platforms, OTT pipelines, ad servers, and analytics solutions.')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden">
    <!-- Dynamic Background -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-96 h-96 bg-gradient-to-r from-primary/20 via-secondary/20 to-accent/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-32 right-32 w-[500px] h-[500px] bg-gradient-to-l from-accent/15 via-primary/15 to-secondary/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s;"></div>
        <div class="absolute top-1/2 left-1/3 w-[400px] h-[400px] bg-gradient-to-tr from-secondary/10 to-primary/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 6s;"></div>
    </div>

    <!-- Floating Tech Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        @for($i = 0; $i < 15; $i++)
            <div class="absolute animate-float opacity-10" 
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5000) }}ms; animation-duration: {{ rand(15000, 25000) }}ms;">
                <i class="fas {{ ['fa-cube', 'fa-server', 'fa-cloud', 'fa-code', 'fa-database', 'fa-rocket'][array_rand(['fa-cube', 'fa-server', 'fa-cloud', 'fa-code', 'fa-database', 'fa-rocket'])] }} text-primary text-3xl"></i>
            </div>
        @endfor
    </div>

    <!-- Main Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div data-aos="fade-up">
            
            <!-- Badge -->
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-8 py-4 border border-primary/20 mb-8">
                <i class="fas fa-cube text-primary text-xl"></i>
                <span class="text-sm font-semibold tracking-wider uppercase text-primary">SaaS Solutions</span>
            </div>
            
            <!-- Title -->
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white mb-8 leading-tight">
                Our 
                <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">Products</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed mb-12">
                Cutting-edge <span class="text-primary font-semibold">SaaS platforms</span> and 
                <span class="text-secondary font-semibold">solutions</span> designed to revolutionize your broadcasting experience
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center group">
                    <div class="text-3xl md:text-4xl font-black text-primary mb-2">{{ $products->count() }}+</div>
                    <div class="text-sm md:text-base text-gray-400">Products</div>
                </div>
                <div class="text-center group">
                    <div class="text-3xl md:text-4xl font-black text-secondary mb-2">99.9%</div>
                    <div class="text-sm md:text-base text-gray-400">Uptime</div>
                </div>
                <div class="text-center group">
                    <div class="text-3xl md:text-4xl font-black text-accent mb-2">24/7</div>
                    <div class="text-sm md:text-base text-gray-400">Support</div>
                </div>
                <div class="text-center group">
                    <div class="text-3xl md:text-4xl font-black text-primary mb-2">1000+</div>
                    <div class="text-sm md:text-base text-gray-400">Clients</div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center" data-aos="fade-up" data-aos-delay="400">
                <a href="#products-grid" class="inline-flex items-center space-x-3 px-10 py-5 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-2xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-rocket"></i>
                    <span>Explore Products</span>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center space-x-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-comments"></i>
                    <span>Get Demo</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2">
        <div class="flex flex-col items-center space-y-2 animate-bounce">
            <div class="text-primary text-sm font-medium">Discover Our Solutions</div>
            <div class="w-6 h-10 border-2 border-primary/50 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-primary rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section id="products-grid" class="py-20 bg-gradient-to-b from-dark-light to-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">Our Product Suite</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                Comprehensive solutions designed to empower broadcasters, content creators, and media companies
            </p>
        </div>

        @if($products->count() > 0)
            <!-- Products -->
            <div class="grid md:grid-cols-2 gap-12">
                @foreach($products as $index => $product)
                    <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="relative bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl overflow-hidden border border-white/10 hover:border-{{ $product->color_from }}/30 transition-all duration-700 hover:shadow-2xl hover:-translate-y-2">
                            
                            <!-- Product Image -->
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ $product->getImageUrl() }}" 
                                     alt="{{ $product->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                
                                <!-- Floating Icon -->
                                <div class="absolute top-6 left-6">
                                    <div class="w-16 h-16 bg-gradient-to-r {{ $product->getGradientClass() }} rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <i class="{{ $product->icon }} text-white text-2xl"></i>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="absolute top-6 right-6">
                                    @if($product->status === 'active')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500/90 text-white">
                                            <div class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></div>
                                            Available
                                        </span>
                                    @elseif($product->status === 'coming_soon')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/90 text-white">
                                            <div class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></div>
                                            Coming Soon
                                        </span>
                                    @endif
                                </div>

                                @if($product->is_featured)
                                    <div class="absolute bottom-6 left-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-400 to-orange-500 text-white">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-8">
                                <div class="mb-4">
                                    <h3 class="text-2xl font-black text-white mb-2 group-hover:bg-gradient-to-r group-hover:{{ $product->getGradientClass() }} group-hover:bg-clip-text group-hover:text-transparent transition-all duration-500">
                                        {{ $product->title }}
                                    </h3>
                                    @if($product->subtitle)
                                        <p class="text-{{ $product->color_from }} font-semibold text-sm">{{ $product->subtitle }}</p>
                                    @endif
                                </div>
                                
                                <p class="text-gray-300 mb-6 leading-relaxed">
                                    {{ $product->short_description ?: substr($product->description, 0, 150) . '...' }}
                                </p>
                                
                                <!-- Features -->
                                @if($product->getFeatures())
                                    <div class="mb-8">
                                        <h4 class="text-white font-bold mb-3">Key Features:</h4>
                                        <div class="grid grid-cols-1 gap-2">
                                            @foreach(array_slice($product->getFeatures(), 0, 4) as $feature)
                                                <div class="flex items-center text-sm text-gray-400">
                                                    <i class="fas fa-check text-green-400 mr-3"></i>
                                                    <span>{{ $feature }}</span>
                                                </div>
                                            @endforeach
                                            @if(count($product->getFeatures()) > 4)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    +{{ count($product->getFeatures()) - 4 }} more features
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Pricing -->
                                @if($product->show_pricing)
                                    <div class="mb-6 text-center">
                                        <div class="text-2xl font-black text-{{ $product->color_from }}">
                                            {{ $product->getFormattedPrice() }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $product->getPricingModelLabel() }}</div>
                                    </div>
                                @endif
                                
                                <!-- Actions -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <a href="{{ route('products.show', $product->slug) }}" class="flex-1 inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r {{ $product->getGradientClass() }} text-white font-bold rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                        <span>Learn More</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                    @if($product->demo_url)
                                        <a href="{{ $product->demo_url }}" target="_blank" class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
                                            <i class="fas fa-play"></i>
                                            <span>Demo</span>
                                        </a>
                                    @else
                                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center space-x-2 px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
                                            <i class="fas fa-envelope"></i>
                                            <span>Contact</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Products Available -->
            <div class="text-center py-16" data-aos="fade-up">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-cube text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No products found</h3>
                <p class="text-gray-400 mb-6 max-w-sm mx-auto">
                    We're working on amazing SaaS solutions. Please check back soon!
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center space-x-3 px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-bell"></i>
                    <span>Notify Me</span>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Why Choose Our Products -->
<section class="py-20 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-black text-white mb-6">Why Choose Our Products?</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                Built with cutting-edge technology and years of broadcasting expertise
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
                $benefits = [
                    [
                        'title' => 'Scalable Architecture',
                        'description' => 'Built to handle millions of users with auto-scaling cloud infrastructure',
                        'icon' => 'fa-expand-arrows-alt',
                        'color' => 'from-primary to-secondary'
                    ],
                    [
                        'title' => 'Advanced Security',
                        'description' => 'Enterprise-grade security with DRM, encryption, and access controls',
                        'icon' => 'fa-shield-alt',
                        'color' => 'from-secondary to-accent'
                    ],
                    [
                        'title' => 'Easy Integration',
                        'description' => 'RESTful APIs and comprehensive documentation for seamless integration',
                        'icon' => 'fa-plug',
                        'color' => 'from-accent to-primary'
                    ]
                ];
            @endphp

            @foreach($benefits as $index => $benefit)
                <div class="text-center group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="w-20 h-20 bg-gradient-to-r {{ $benefit['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-2xl">
                        <i class="fas {{ $benefit['icon'] }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">{{ $benefit['title'] }}</h3>
                    <p class="text-gray-400 leading-relaxed">{{ $benefit['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-dark">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
        <div class="bg-gradient-to-r from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-12 border border-white/10">
            <h3 class="text-3xl font-black text-white mb-6">Ready to Get Started?</h3>
            <p class="text-gray-400 mb-8 text-lg">
                Transform your broadcasting business with our powerful SaaS solutions
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('contact') }}" class="inline-flex items-center space-x-3 px-10 py-5 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-2xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-rocket"></i>
                    <span>Start Your Journey</span>
                </a>
                <a href="{{ route('pricing') }}" class="inline-flex items-center space-x-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-dollar-sign"></i>
                    <span>View Pricing</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection