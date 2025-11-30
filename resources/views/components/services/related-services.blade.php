<section class="py-16 bg-{{ $bgColor ?? 'dark-light' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h3 class="text-3xl font-bold text-white mb-4">{{ $title ?? 'Explore Other Services' }}</h3>
            <p class="text-gray-400">{{ $subtitle ?? 'Discover more ways TKDS Media can transform your content' }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="group glass-effect rounded-2xl p-6 hover:bg-white/10 transition-all duration-300" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="w-12 h-12 bg-gradient-to-r from-{{ $service['colorFrom'] }} to-{{ $service['colorTo'] }} rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $service['icon'] }} text-white"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">{{ $service['title'] }}</h4>
                    <p class="text-gray-400 text-sm mb-4">{{ $service['description'] }}</p>
                    <a href="{{ $service['link'] }}" class="text-{{ $service['linkColor'] }} hover:text-{{ $service['linkHoverColor'] }} transition-colors duration-300 text-sm font-medium">
                        Learn More <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>