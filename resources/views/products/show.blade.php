@extends('layouts.app')

@section('title', $product->getMetaTitle())
@section('meta_description', $product->getMetaDescription())

@section('content')

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden">
    <!-- Dynamic Background -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-96 h-96 bg-gradient-to-r from-{{ $product->color_from }}/20 via-{{ $product->color_to }}/20 to-accent/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-32 right-32 w-[500px] h-[500px] bg-gradient-to-l from-accent/15 via-{{ $product->color_from }}/15 to-{{ $product->color_to }}/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s;"></div>
        <div class="absolute top-1/2 left-1/3 w-[400px] h-[400px] bg-gradient-to-tr from-{{ $product->color_to }}/10 to-{{ $product->color_from }}/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 6s;"></div>
    </div>

    <!-- Floating Tech Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        @for($i = 0; $i < 12; $i++)
            <div class="absolute animate-float opacity-10" 
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5000) }}ms; animation-duration: {{ rand(15000, 25000) }}ms;">
                <i class="{{ $product->icon }} text-{{ $product->color_from }} text-2xl"></i>
            </div>
        @endfor
    </div>

    <!-- Main Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Content -->
            <div data-aos="fade-right">
                
                <!-- Badge -->
                <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-{{ $product->getHeroBadgeColor() }}/10 to-{{ $product->color_to }}/10 backdrop-blur-lg rounded-full px-8 py-4 border border-{{ $product->getHeroBadgeColor() }}/20 mb-8">
                    <i class="{{ $product->icon }} text-{{ $product->getHeroBadgeColor() }} text-xl"></i>
                    <span class="text-sm font-semibold tracking-wider uppercase text-{{ $product->getHeroBadgeColor() }}">{{ $product->getHeroBadgeText() }}</span>
                </div>
                
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight">
                    {{ $product->getHeroTitle() }}
                </h1>
                
                <!-- Subtitle -->
                @if($product->getHeroSubtitle())
                    <h2 class="text-xl md:text-2xl font-bold text-{{ $product->color_from }} mb-6">
                        {{ $product->getHeroSubtitle() }}
                    </h2>
                @endif
                
                <!-- Description -->
                <p class="text-lg md:text-xl text-gray-300 max-w-2xl leading-relaxed mb-8">
                    {{ $product->getHeroDescription() }}
                </p>

                <!-- Key Stats/Features - FIXED -->
                @if(count($product->getSpecifications()) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8" data-aos="fade-up" data-aos-delay="200">
                        @foreach(array_slice($product->getSpecifications(), 0, 6) as $key => $value)
                            <div class="text-center group">
                                <div class="text-2xl md:text-3xl font-black text-{{ $product->color_from }} mb-2">
                                    {{ is_string($value) ? $value : (is_numeric($value) ? $value : '---') }}
                                </div>
                                <div class="text-xs md:text-sm text-gray-400 uppercase tracking-wider">
                                    {{ is_numeric($key) ? 'Feature ' . ($key + 1) : ucfirst(str_replace('_', ' ', $key)) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-6" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ $product->getCtaButtonLink() }}" class="inline-flex items-center space-x-3 px-10 py-5 bg-gradient-to-r from-{{ $product->color_from }} to-{{ $product->color_to }} text-white font-bold rounded-2xl hover:from-{{ $product->color_to }} hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl">
                        <i class="fas fa-rocket"></i>
                        <span>{{ $product->getCtaButtonText() }}</span>
                    </a>
                    @if($product->demo_url)
                        <a href="{{ $product->demo_url }}" target="_blank" class="inline-flex items-center space-x-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-play"></i>
                            <span>Live Demo</span>
                        </a>
                    @endif
                </div>

                <!-- Additional Links -->
                @if($product->documentation_url || $product->github_url || $product->video_url)
                    <div class="flex items-center space-x-6 mt-8 pt-8 border-t border-white/10">
                        @if($product->documentation_url)
                            <a href="{{ $product->documentation_url }}" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center space-x-2">
                                <i class="fas fa-book"></i>
                                <span>Documentation</span>
                            </a>
                        @endif
                        @if($product->github_url)
                            <a href="{{ $product->github_url }}" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center space-x-2">
                                <i class="fab fa-github"></i>
                                <span>GitHub</span>
                            </a>
                        @endif
                        @if($product->video_url)
                            <a href="{{ $product->video_url }}" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center space-x-2">
                                <i class="fas fa-video"></i>
                                <span>Watch Video</span>
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Right Content - Hero Image -->
            <div class="relative" data-aos="fade-left">
                <div class="relative">
                    <!-- Main Hero Image -->
                    <div class="relative z-10">
                        <img src="{{ $product->getHeroImageUrl() }}" 
                             alt="{{ $product->title }}" 
                             class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-500">
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute -top-10 -right-10 w-20 h-20 bg-gradient-to-r from-{{ $product->color_from }} to-{{ $product->color_to }} rounded-full opacity-20 animate-pulse"></div>
                    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-gradient-to-r from-{{ $product->color_to }} to-accent rounded-full opacity-15 animate-pulse" style="animation-delay: 2s;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2">
        <div class="flex flex-col items-center space-y-2 animate-bounce">
            <div class="text-{{ $product->color_from }} text-sm font-medium">Explore Features</div>
            <div class="w-6 h-10 border-2 border-{{ $product->color_from }}/50 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-{{ $product->color_from }} rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </div>
</section>

<!-- Key Features Section - COMPLETELY FIXED -->
@php
$keyFeatures = $product->getKeyFeatures();
@endphp
@if(is_array($keyFeatures) && count($keyFeatures) > 0)
<section class="py-20 bg-gradient-to-b from-dark-light to-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">Key Features</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                Powerful features designed to enhance your experience
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($keyFeatures as $index => $feature)
                @php
                    $isArray = is_array($feature);
                    $featureIcon = $isArray && isset($feature['icon']) ? $feature['icon'] : 'fas fa-star';
                    $featureTitle = $isArray && isset($feature['title']) ? $feature['title'] : (is_string($feature) ? $feature : 'Feature');
                    $featureDescription = $isArray && isset($feature['description']) ? $feature['description'] : '';
                    $colorFrom = $isArray && isset($feature['color_from']) ? $feature['color_from'] : $product->color_from;
                    $colorTo = $isArray && isset($feature['color_to']) ? $feature['color_to'] : $product->color_to;
                @endphp
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="relative bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-8 border border-white/10 hover:border-{{ $colorFrom }}/30 transition-all duration-700 hover:shadow-2xl hover:-translate-y-2">
                        
                        <!-- Feature Icon -->
                        <div class="w-16 h-16 bg-gradient-to-r from-{{ $colorFrom }} to-{{ $colorTo }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-2xl">
                            <i class="{{ $featureIcon }} text-white text-2xl"></i>
                        </div>
                        
                        <!-- Feature Content -->
                        <h3 class="text-xl font-bold text-white mb-4 group-hover:text-{{ $colorFrom }} transition-colors duration-300">
                            {{ $featureTitle }}
                        </h3>
                        
                        @if(!empty($featureDescription))
                            <p class="text-gray-300 leading-relaxed">
                                {{ $featureDescription }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Benefits Section - COMPLETELY FIXED -->
@php
$benefits = $product->getBenefits();
@endphp
@if(is_array($benefits) && count($benefits) > 0)
<section class="py-20 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-black text-white mb-6">Why Choose {{ $product->title }}?</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                The benefits that make us stand out from the competition
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($benefits as $index => $benefit)
                @php
                    $isArray = is_array($benefit);
                    $benefitIcon = $isArray && isset($benefit['icon']) ? $benefit['icon'] : 'fas fa-check';
                    $benefitTitle = $isArray && isset($benefit['title']) ? $benefit['title'] : (is_string($benefit) ? $benefit : 'Benefit');
                    $benefitDescription = $isArray && isset($benefit['description']) ? $benefit['description'] : '';
                    $colorFrom = $isArray && isset($benefit['color_from']) ? $benefit['color_from'] : $product->color_from;
                    $colorTo = $isArray && isset($benefit['color_to']) ? $benefit['color_to'] : $product->color_to;
                @endphp
                <div class="text-center group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="w-20 h-20 bg-gradient-to-r from-{{ $colorFrom }} to-{{ $colorTo }} rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-2xl">
                        <i class="{{ $benefitIcon }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">{{ $benefitTitle }}</h3>
                    @if(!empty($benefitDescription))
                        <p class="text-gray-400 leading-relaxed">{{ $benefitDescription }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Use Cases Section - COMPLETELY FIXED -->
@php
$useCases = $product->getUseCases();
@endphp
@if(is_array($useCases) && count($useCases) > 0)
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-black text-white mb-6">Perfect For</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                Discover how {{ $product->title }} can transform your business
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($useCases as $index => $useCase)
                @php
                    $isArray = is_array($useCase);
                    $useCaseIcon = $isArray && isset($useCase['icon']) ? $useCase['icon'] : 'fas fa-lightbulb';
                    $useCaseTitle = $isArray && isset($useCase['title']) ? $useCase['title'] : (is_string($useCase) ? $useCase : 'Use Case');
                    $useCaseDescription = $isArray && isset($useCase['description']) ? $useCase['description'] : '';
                    $colorFrom = $isArray && isset($useCase['color_from']) ? $useCase['color_from'] : $product->color_from;
                    $colorTo = $isArray && isset($useCase['color_to']) ? $useCase['color_to'] : $product->color_to;
                @endphp
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-8 border border-white/10 hover:border-{{ $colorFrom }}/30 transition-all duration-500">
                        
                        <div class="w-16 h-16 bg-gradient-to-r from-{{ $colorFrom }} to-{{ $colorTo }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="{{ $useCaseIcon }} text-white text-2xl"></i>
                        </div>
                        
                        <h3 class="text-xl font-bold text-white mb-4">{{ $useCaseTitle }}</h3>
                        @if(!empty($useCaseDescription))
                            <p class="text-gray-300 leading-relaxed">{{ $useCaseDescription }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Tech Stack Section - COMPLETELY FIXED -->
@php
$techStack = $product->getTechStack();
@endphp
@if(is_array($techStack) && count($techStack) > 0)
<section class="py-20 bg-gradient-to-b from-dark-light to-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-black text-white mb-6">Built With Modern Technology</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                Powered by the latest and most reliable technologies
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($techStack as $index => $tech)
                @php
                    $isArray = is_array($tech);
                    $techName = $isArray && isset($tech['name']) ? $tech['name'] : (is_string($tech) ? $tech : 'Technology');
                    $techIcon = $isArray && isset($tech['icon']) ? $tech['icon'] : '';
                    $techVersion = $isArray && isset($tech['version']) ? $tech['version'] : '';
                @endphp
                <div class="group text-center" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 50 }}">
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:border-{{ $product->color_from }}/30 transition-all duration-300 hover:bg-white/10">
                        @if(!empty($techIcon))
                            <i class="{{ $techIcon }} text-3xl text-{{ $product->color_from }} mb-4"></i>
                        @endif
                        <h4 class="text-white font-semibold text-sm">{{ $techName }}</h4>
                        @if(!empty($techVersion))
                            <p class="text-xs text-gray-400 mt-1">{{ $techVersion }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Pricing Section - FIXED -->
@if($product->show_pricing && ($product->price || $product->pricing_model === 'free' || $product->pricing_model === 'quote'))
<section class="py-20 bg-dark-light">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
        <div class="bg-gradient-to-r from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-12 border border-white/10">
            
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-{{ $product->color_from }}/10 to-{{ $product->color_to }}/10 backdrop-blur-lg rounded-full px-6 py-3 border border-{{ $product->color_from }}/20 mb-8">
                <i class="fas fa-tag text-{{ $product->color_from }}"></i>
                <span class="text-sm font-semibold text-{{ $product->color_from }}">{{ $product->getCategoryLabel() }}</span>
            </div>

            <h3 class="text-3xl font-black text-white mb-4">{{ $product->title }}</h3>
            
            <div class="text-5xl font-black text-{{ $product->color_from }} mb-6">
                {{ $product->getFormattedPrice() }}
            </div>
            
            @php
            $features = $product->getFeatures();
            @endphp
            @if(is_array($features) && count($features) > 0)
                <div class="grid md:grid-cols-2 gap-4 mb-8 max-w-2xl mx-auto">
                    @foreach(array_slice($features, 0, 6) as $feature)
                        <div class="flex items-center text-gray-300">
                            <i class="fas fa-check text-green-400 mr-3"></i>
                            <span>{{ is_string($feature) ? $feature : 'Feature' }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ $product->getCtaButtonLink() }}" class="inline-flex items-center space-x-3 px-10 py-5 bg-gradient-to-r from-{{ $product->color_from }} to-{{ $product->color_to }} text-white font-bold rounded-2xl hover:from-{{ $product->color_to }} hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-rocket"></i>
                    <span>{{ $product->pricing_model === 'free' ? 'Get Started Free' : ($product->pricing_model === 'quote' ? 'Get Quote' : 'Start Now') }}</span>
                </a>
                @if($product->demo_url)
                    <a href="{{ $product->demo_url }}" target="_blank" class="inline-flex items-center space-x-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                        <i class="fas fa-play"></i>
                        <span>Try Demo</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<!-- Additional Content -->
@if($product->page_content)
<section class="py-20 bg-dark">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg prose-invert max-w-none" data-aos="fade-up">
            {!! $product->page_content !!}
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-{{ $product->color_from }}/10 to-{{ $product->color_to }}/10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
        <div class="bg-gradient-to-r from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-12 border border-white/10">
            <h3 class="text-3xl font-black text-white mb-6">{{ $product->getCtaTitle() }}</h3>
            <p class="text-gray-400 mb-8 text-lg max-w-2xl mx-auto">
                {{ $product->getCtaDescription() }}
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ $product->getCtaButtonLink() }}" class="inline-flex items-center space-x-3 px-10 py-5 bg-gradient-to-r from-{{ $product->color_from }} to-{{ $product->color_to }} text-white font-bold rounded-2xl hover:from-{{ $product->color_to }} hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-rocket"></i>
                    <span>{{ $product->getCtaButtonText() }}</span>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center space-x-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-comments"></i>
                    <span>Contact Sales</span>
                </a>
            </div>
        </div>
    </div>
</section>

<x-service-contact-form 
    type="product" 
    :item="$product" 
    title="Inquire about {{ $product->name }}" />

@endsection

@push('scripts')
<script>
// Product page interactions
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
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

    // Track product view for analytics
    if (typeof gtag !== 'undefined') {
        gtag('event', 'page_view', {
            event_category: 'Product',
            event_label: '{{ $product->title }}',
            product_id: '{{ $product->id }}',
            product_name: '{{ $product->title }}',
            product_category: '{{ $product->category }}',
            value: {{ $product->price ?: 0 }}
        });
    }

    // Track CTA clicks
    document.querySelectorAll('a[href*="contact"], a[href*="demo"]').forEach(link => {
        link.addEventListener('click', function() {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    event_category: 'Product CTA',
                    event_label: this.textContent.trim(),
                    product_name: '{{ $product->title }}'
                });
            }
        });
    });
});
</script>
@endpush