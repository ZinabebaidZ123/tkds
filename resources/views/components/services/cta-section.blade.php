<section class="py-20 bg-{{ $bgColor ?? 'dark' }} relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-20 right-20 w-72 h-72 bg-{{ $bgEffect1 ?? 'primary' }}/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-{{ $bgEffect2 ?? 'secondary' }}/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-aos="fade-up">
        <h2 class="text-4xl font-black text-white mb-6">
            {{ $titleStart ?? 'Ready to' }} <span class="text-gradient">{{ $highlightText }}</span> {{ $titleEnd ?? 'Your Business?' }}
        </h2>
        <p class="text-xl text-gray-400 mb-8">
            {{ $description }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ $primaryButtonLink }}" class="px-8 py-4 bg-gradient-to-r from-{{ $buttonFrom ?? 'primary' }} to-{{ $buttonTo ?? 'secondary' }} text-white font-bold rounded-full hover:from-{{ $buttonHoverFrom ?? 'secondary' }} hover:to-{{ $buttonHoverTo ?? 'accent' }} transition-all duration-300 transform hover:scale-105">
                {{ $primaryButtonText }}
            </a>
            <a href="{{ $secondaryButtonLink }}" class="px-8 py-4 glass-effect text-white font-bold rounded-full hover:bg-white/20 transition-all duration-300 border border-white/20">
                {{ $secondaryButtonText }}
            </a>
        </div>
    </div>
</section>