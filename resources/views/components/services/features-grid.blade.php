<section id="{{ $sectionId ?? 'features' }}" class="py-20 bg-{{ $bgColor ?? 'dark' }} relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                {{ $headerTitle ?? 'Powerful' }} <span class="text-gradient">{{ $headerHighlight ?? 'Features' }}</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                {{ $headerDescription ?? 'Everything you need to create amazing experiences for your audience.' }}
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-{{ $gridCols ?? '2' }} gap-12 {{ isset($extraContent) ? 'mb-20' : '' }}">
            @foreach($features as $index => $feature)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="glass-effect rounded-3xl p-8 h-full hover:bg-white/10 transition-all duration-500">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-r from-{{ $feature['colorFrom'] }} to-{{ $feature['colorTo'] }} rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $feature['icon'] }} text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white">{{ $feature['title'] }}</h3>
                        </div>
                        <p class="text-gray-400 mb-6 leading-relaxed">
                            {{ $feature['description'] }}
                        </p>
                        @if(isset($feature['bullets']))
                            <ul class="space-y-3">
                                @foreach($feature['bullets'] as $bullet)
                                    <li class="flex items-center text-gray-300">
                                        <i class="fas fa-check text-{{ $feature['bulletColor'] ?? 'accent' }} mr-3"></i>
                                        <span>{{ $bullet }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Extra Content (Applications, Demo, etc.) -->
        @if(isset($extraContent))
            <div class="glass-effect rounded-3xl p-12" data-aos="fade-up" data-aos-delay="{{ (count($features) + 1) * 100 }}">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-white mb-4">{{ $extraContent['title'] }}</h3>
                    <p class="text-gray-400">{{ $extraContent['description'] }}</p>
                </div>

                <div class="grid md:grid-cols-{{ $extraContent['gridCols'] ?? '4' }} gap-6">
                    @foreach($extraContent['items'] as $item)
                        <div class="text-center group">
                            <div class="w-20 h-20 bg-gradient-to-r from-{{ $item['colorFrom'] }} to-{{ $item['colorTo'] }} rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $item['icon'] }} text-white text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-white mb-2">{{ $item['title'] }}</h4>
                            <p class="text-gray-400 text-sm">{{ $item['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>