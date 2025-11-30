<section class="relative min-h-screen flex items-center justify-center bg-dark overflow-hidden mt-8">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-96 h-96 bg-{{ $primaryColor ?? 'primary' }}/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-{{ $secondaryColor ?? 'secondary' }}/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-{{ $accentColor ?? 'accent' }}/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
        
        <!-- Floating Elements -->
        @if(isset($floatingElements))
            @foreach($floatingElements as $element)
                <div class="absolute {{ $element['position'] }} w-{{ $element['size'] }} h-{{ $element['size'] }} bg-{{ $element['color'] }} rounded-lg animate-float opacity-{{ $element['opacity'] }} flex items-center justify-center transform {{ $element['rotate'] ?? '' }}" style="animation-delay: {{ $element['delay'] ?? '0' }}s;">
                    <i class="{{ $element['icon'] }} text-white text-{{ $element['iconSize'] ?? 'sm' }}"></i>
                </div>
            @endforeach
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <!-- Content -->
            <div class="text-center lg:text-left" data-aos="fade-right">
                <div class="inline-flex items-center space-x-2 bg-{{ $badgeColor ?? 'primary' }}/10 rounded-full px-6 py-2 mb-6">
                    <i class="{{ $badgeIcon }} text-{{ $badgeColor ?? 'primary' }}"></i>
                    <span class="text-{{ $badgeColor ?? 'primary' }} font-medium">{{ $badgeText }}</span>
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-black text-white mb-6 leading-tight">
                    {{ $mainTitle }}
                    <span class="text-gradient bg-gradient-to-r from-{{ $gradientFrom ?? 'primary' }} via-{{ $gradientVia ?? 'secondary' }} to-{{ $gradientTo ?? 'accent' }} bg-clip-text text-transparent">
                        {{ $highlightTitle }}
                    </span>
                    @if(isset($subtitleLine))
                        <br>{{ $subtitleLine }}
                    @endif
                </h1>
                
                <p class="text-xl text-gray-400 mb-8 max-w-2xl">
                    {{ $description }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ $primaryButtonLink }}" class="px-8 py-4 bg-gradient-to-r from-{{ $primaryButtonFrom ?? 'primary' }} to-{{ $primaryButtonTo ?? 'secondary' }} text-white font-bold rounded-full hover:from-{{ $primaryButtonHoverFrom ?? 'secondary' }} hover:to-{{ $primaryButtonHoverTo ?? 'accent' }} transition-all duration-300 transform hover:scale-105 hover:shadow-xl hover:shadow-{{ $primaryButtonFrom ?? 'primary' }}/30">
                        {{ $primaryButtonText }}
                    </a>
                    <a href="{{ $secondaryButtonLink }}" class="px-8 py-4 glass-effect text-white font-bold rounded-full hover:bg-white/20 transition-all duration-300 border border-white/20">
                        {{ $secondaryButtonText }}
                    </a>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="relative" data-aos="fade-left" data-aos-delay="300">
                <div class="relative">
                    <!-- Image Placeholder or Actual Image -->
                    @if(isset($heroImage))
                        <img src="{{ $heroImage }}" alt="{{ $imageAlt ?? 'Service Illustration' }}" class="w-full h-full object-cover rounded-3xl">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-{{ $imageGradientFrom ?? 'primary' }}/20 to-{{ $imageGradientTo ?? 'secondary' }}/20 rounded-3xl flex items-center justify-center">
                            <div class="text-center">
                                <i class="{{ $placeholderIcon }} text-6xl text-white/60 mb-4"></i>
                                <p class="text-white/60">{{ $placeholderText }}</p>
                                <p class="text-sm text-white/40">{{ $placeholderSubtext ?? 'Replace with Storyset SVG' }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Floating Cards -->
                    @if(isset($floatingCards))
                        @foreach($floatingCards as $index => $card)
                            <div class="absolute {{ $card['position'] }} glass-effect p-3 rounded-xl animate-float" style="animation-delay: {{ $card['delay'] ?? ($index * 2) }}s;">
                                <i class="{{ $card['icon'] }} text-{{ $card['color'] }} text-xl"></i>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>