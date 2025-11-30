@extends('layouts.app')

@section('title', ($service->meta_title ?? $service->title) . ' - TKDS Media')
@section('meta_description', $service->meta_description ?? $service->description)

@section('content')

{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center justify-center bg-dark overflow-hidden mt-8">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-96 h-96 bg-{{ $service->color_from }}/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-{{ $service->color_to }}/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-{{ $service->border_color }}/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <!-- Content -->
            <div class="text-center lg:text-left" data-aos="fade-right">
                <div class="inline-flex items-center space-x-2 bg-{{ $service->getHeroBadgeColor() }}/10 rounded-full px-6 py-2 mb-6">
                    <i class="{{ $service->icon }} text-{{ $service->getHeroBadgeColor() }}"></i>
                    <span class="text-{{ $service->getHeroBadgeColor() }} font-medium">{{ $service->getHeroBadgeText() }}</span>
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-black text-white mb-6 leading-tight">
                    {{ $service->getHeroTitle() }}
                    @if($service->hero_subtitle)
                        <br><span class="text-gradient bg-gradient-to-r from-{{ $service->color_from }} via-{{ $service->color_to }} to-{{ $service->border_color }} bg-clip-text text-transparent">
                            {{ $service->hero_subtitle }}
                        </span>
                    @endif
                </h1>
                
                <p class="text-xl text-gray-400 mb-8 max-w-2xl">
                    {{ $service->getHeroDescription() }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#features" class="px-8 py-4 bg-gradient-to-r from-{{ $service->color_from }} to-{{ $service->color_to }} text-white font-bold rounded-full hover:from-{{ $service->color_to }} hover:to-{{ $service->border_color }} transition-all duration-300 transform hover:scale-105 hover:shadow-xl hover:shadow-{{ $service->color_from }}/30">
                        Explore Features
                    </a>
                    <a href="{{ $service->getCtaButtonLink() }}" class="px-8 py-4 glass-effect text-white font-bold rounded-full hover:bg-white/20 transition-all duration-300 border border-white/20">
                        Get Started
                    </a>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="relative" data-aos="fade-left" data-aos-delay="300">
                <div class="relative">
                    <img src="{{ $service->getHeroImageUrl() }}" 
                         alt="{{ $service->title }}" 
                         class="w-full h-96 object-cover rounded-3xl">
                    
                    <!-- Floating Cards -->
                    <div class="absolute -top-6 -left-6 glass-effect p-3 rounded-xl animate-float">
                        <i class="{{ $service->icon }} text-{{ $service->color_from }} text-xl"></i>
                    </div>
                    <div class="absolute -bottom-6 -right-6 glass-effect p-3 rounded-xl animate-float" style="animation-delay: 2s;">
                        <i class="fas fa-check text-{{ $service->color_to }} text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Key Features Section --}}
@if($service->getKeyFeatures())
<section id="features" class="py-20 bg-dark-light relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Key <span class="text-gradient">Features</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Discover the powerful features that make our {{ strtolower($service->title) }} service stand out from the competition.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 gap-12">
            @foreach($service->getKeyFeatures() as $index => $feature)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="glass-effect rounded-3xl p-8 h-full hover:bg-white/10 transition-all duration-500">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-r from-{{ $feature['color_from'] ?? $service->color_from }} to-{{ $feature['color_to'] ?? $service->color_to }} rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $feature['icon'] ?? 'fas fa-star' }} text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white">{{ $feature['title'] ?? 'Feature Title' }}</h3>
                        </div>
                        <p class="text-gray-400 mb-6 leading-relaxed">
                            {{ $feature['description'] ?? 'Feature description will appear here.' }}
                        </p>
                        @if(isset($feature['bullets']) && is_array($feature['bullets']))
                            <ul class="space-y-3">
                                @foreach($feature['bullets'] as $bullet)
                                    <li class="flex items-center text-gray-300">
                                        <i class="fas fa-check text-{{ $feature['bullet_color'] ?? 'accent' }} mr-3"></i>
                                        <span>{{ $bullet }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Benefits Section --}}
@if($service->getBenefits())
<section class="py-20 bg-dark relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Why Choose <span class="text-gradient">TKDS Media?</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Experience the benefits of working with industry-leading professionals who are dedicated to your success.
            </p>
        </div>

        <!-- Benefits Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($service->getBenefits() as $index => $benefit)
                <div class="text-center group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="w-20 h-20 bg-gradient-to-r from-{{ $benefit['color_from'] ?? $service->color_from }} to-{{ $benefit['color_to'] ?? $service->color_to }} rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $benefit['icon'] ?? 'fas fa-star' }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $benefit['title'] ?? 'Benefit Title' }}</h3>
                    <p class="text-gray-400 text-sm">
                        {{ $benefit['description'] ?? 'Benefit description will appear here.' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Use Cases Section --}}
@if($service->getUseCases())
<section class="py-20 bg-dark-light relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Perfect for <span class="text-gradient">Every Need</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Discover how our {{ strtolower($service->title) }} service can benefit different industries and use cases.
            </p>
        </div>

<!-- Use Cases Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($service->getUseCases() as $index => $useCase)
                <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="w-16 h-16 bg-gradient-to-r from-{{ $useCase['color_from'] ?? $service->color_from }} to-{{ $useCase['color_to'] ?? $service->color_to }} rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $useCase['icon'] ?? 'fas fa-star' }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">{{ $useCase['title'] ?? 'Use Case Title' }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        {{ $useCase['description'] ?? 'Use case description will appear here.' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Page Content Section --}}
@if($service->page_content)
<section class="py-20 bg-dark relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg prose-invert max-w-none" data-aos="fade-up">
            {!! $service->page_content !!}
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="py-20 bg-dark-light relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-20 right-20 w-72 h-72 bg-{{ $service->color_from }}/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-{{ $service->color_to }}/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-aos="fade-up">
        <h2 class="text-4xl font-black text-white mb-6">
            {{ $service->getCtaTitle() }}
        </h2>
        <p class="text-xl text-gray-400 mb-8">
            {{ $service->getCtaDescription() }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ $service->getCtaButtonLink() }}" class="px-8 py-4 bg-gradient-to-r from-{{ $service->color_from }} to-{{ $service->color_to }} text-white font-bold rounded-full hover:from-{{ $service->color_to }} hover:to-{{ $service->border_color }} transition-all duration-300 transform hover:scale-105">
                {{ $service->getCtaButtonText() }}
            </a>
            <a href="{{ route('contact') }}" class="px-8 py-4 glass-effect text-white font-bold rounded-full hover:bg-white/20 transition-all duration-300 border border-white/20">
                Contact Us
            </a>
        </div>
    </div>
</section>

{{-- Related Services Section --}}
@if($service->getRelatedServices())
<section class="py-16 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h3 class="text-3xl font-bold text-white mb-4">Explore Other Services</h3>
            <p class="text-gray-400">Discover more ways TKDS Media can transform your content</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($service->getRelatedServices() as $relatedService)
                <div class="group glass-effect rounded-2xl p-6 hover:bg-white/10 transition-all duration-300" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="w-12 h-12 bg-gradient-to-r from-{{ $relatedService['color_from'] ?? 'primary' }} to-{{ $relatedService['color_to'] ?? 'secondary' }} rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $relatedService['icon'] ?? 'fas fa-star' }} text-white"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">{{ $relatedService['title'] ?? 'Related Service' }}</h4>
                    <p class="text-gray-400 text-sm mb-4">{{ $relatedService['description'] ?? 'Service description' }}</p>
                    <a href="{{ $relatedService['link'] ?? '#' }}" class="text-{{ $relatedService['link_color'] ?? 'primary' }} hover:text-{{ $relatedService['link_hover_color'] ?? 'secondary' }} transition-colors duration-300 text-sm font-medium">
                        Learn More <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<x-service-contact-form 
    type="service" 
    :item="$service" 
    title="Get Started with {{ $service->title }}" />

@endsection

@push('styles')
<style>
.animate-float {
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.text-gradient {
    background: linear-gradient(135deg, #C53030, #E53E3E, #FC8181);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.glass-effect {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.prose-invert {
    color: #e5e7eb;
}

.prose-invert h1,
.prose-invert h2,
.prose-invert h3,
.prose-invert h4,
.prose-invert h5,
.prose-invert h6 {
    color: #ffffff;
}

.prose-invert a {
    color: #C53030;
}

.prose-invert a:hover {
    color: #E53E3E;
}

.prose-invert code {
    background-color: rgba(255, 255, 255, 0.1);
    color: #FC8181;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
}

.prose-invert blockquote {
    border-left: 4px solid #C53030;
    background-color: rgba(197, 48, 48, 0.1);
    padding: 1rem;
    border-radius: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
// Smooth scrolling for anchor links
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

// Add animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
        }
    });
}, observerOptions);

// Observe all elements with data-aos attribute
document.querySelectorAll('[data-aos]').forEach(el => {
    observer.observe(el);
});
</script>
@endpush