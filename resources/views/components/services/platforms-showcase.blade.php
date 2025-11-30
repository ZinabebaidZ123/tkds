{{-- resources/views/components/services/platforms-showcase.blade.php --}}
<section id="{{ $sectionId ?? 'platforms' }}" class="py-20 bg-{{ $bgColor ?? 'dark-light' }} relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                <span class="text-gradient">{{ $headerHighlight ?? 'Multi-Platform' }}</span> {{ $headerTitle ?? 'Excellence' }}
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                {{ $headerDescription ?? 'Reach your audience wherever they are with our comprehensive solutions across all major platforms and devices.' }}
            </p>
        </div>

        <!-- Platforms Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-{{ $gridCols ?? '3' }} gap-8 {{ isset($extraContent) ? 'mb-20' : '' }}">
            @foreach($platforms as $index => $platform)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="glass-effect rounded-3xl p-8 h-full hover:bg-white/10 transition-all duration-500 border border-{{ $platform['borderColor'] ?? 'gray-700' }}/20 hover:border-{{ $platform['borderColor'] ?? 'primary' }}/50">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-r from-{{ $platform['colorFrom'] }} to-{{ $platform['colorTo'] }} rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $platform['icon'] }} text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white">{{ $platform['title'] }}</h3>
                        </div>
                        <p class="text-gray-400 mb-6 leading-relaxed">
                            {{ $platform['description'] }}
                        </p>
                        @if(isset($platform['features']))
                            <ul class="space-y-3">
                                @foreach($platform['features'] as $feature)
                                    <li class="flex items-center text-gray-300">
                                        <i class="fas fa-check text-{{ $platform['checkColor'] ?? 'accent' }} mr-3"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Extra Content Section (Demo, Integration, etc.) -->
        @if(isset($extraContent))
            <div class="glass-effect rounded-3xl p-12 text-center" data-aos="fade-up" data-aos-delay="{{ (count($platforms) + 1) * 100 }}">
                <div class="mb-8">
                    <h3 class="text-3xl font-bold text-white mb-4">{{ $extraContent['title'] }}</h3>
                    <p class="text-gray-400 mb-6">{{ $extraContent['description'] }}</p>
                </div>
                
                <!-- Demo Grid -->
                <div class="grid md:grid-cols-{{ $extraContent['gridCols'] ?? '3' }} gap-6">
                    @foreach($extraContent['items'] as $item)
                        <div class="bg-dark/50 rounded-2xl p-6 border border-{{ $item['borderColor'] ?? 'accent' }}/20">
                            <i class="{{ $item['icon'] }} text-{{ $item['iconColor'] ?? 'accent' }} text-3xl mb-4"></i>
                            <h4 class="text-lg font-bold text-white mb-2">{{ $item['title'] }}</h4>
                            <p class="text-gray-400 text-sm">{{ $item['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Social Media Integration (for streaming services) -->
        @if(isset($socialIntegration))
            <div class="glass-effect rounded-3xl p-12 mb-20" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center mb-12">
                    <div class="w-20 h-20 bg-gradient-to-r from-{{ $socialIntegration['colorFrom'] ?? 'accent' }} to-{{ $socialIntegration['colorTo'] ?? 'primary' }} rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="{{ $socialIntegration['icon'] ?? 'fas fa-share-alt' }} text-white text-3xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-white mb-4">{{ $socialIntegration['title'] }}</h3>
                    <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                        {{ $socialIntegration['description'] }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($socialIntegration['platforms'] as $social)
                        <div class="text-center group">
                            <div class="w-16 h-16 bg-{{ $social['bgColor'] }} rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $social['icon'] }} text-white text-xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-white">{{ $social['name'] }}</h4>
                            <p class="text-gray-400 text-sm">{{ $social['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>