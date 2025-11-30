<section class="py-20 bg-{{ $bgColor ?? 'dark-light' }} relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Why Choose <span class="text-gradient">{{ $companyName ?? 'TKDS Media' }}?</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                {{ $description ?? 'With years of experience in the industry, we combine technical expertise with creative flair to deliver exceptional results.' }}
            </p>
        </div>

        <!-- Benefits Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 {{ isset($process) ? 'mb-16' : '' }}">
            @foreach($benefits as $index => $benefit)
                <div class="text-center group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="w-20 h-20 bg-gradient-to-r from-{{ $benefit['colorFrom'] }} to-{{ $benefit['colorTo'] }} rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $benefit['icon'] }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $benefit['title'] }}</h3>
                    <p class="text-gray-400 text-sm">
                        {{ $benefit['description'] }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Process Section (Optional) -->
        @if(isset($process))
            <div class="glass-effect rounded-3xl p-12" data-aos="fade-up" data-aos-delay="{{ (count($benefits) + 1) * 100 }}">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-white mb-4">{{ $process['title'] ?? 'Our Process' }}</h3>
                    <p class="text-gray-400">{{ $process['description'] ?? 'From concept to execution, we provide comprehensive support' }}</p>
                </div>

                <div class="grid md:grid-cols-{{ count($process['steps']) }} gap-8">
                    @foreach($process['steps'] as $index => $step)
                        <div class="text-center">
                            <div class="w-16 h-16 bg-{{ $step['color'] ?? 'primary' }} rounded-full flex items-center justify-center mx-auto mb-4 text-white font-bold text-xl">{{ $index + 1 }}</div>
                            <h4 class="text-lg font-bold text-white mb-2">{{ $step['title'] }}</h4>
                            <p class="text-gray-400 text-sm">{{ $step['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Stats Section (Optional) -->
        @if(isset($stats))
            <div class="glass-effect rounded-3xl p-12 text-center" data-aos="fade-up" data-aos-delay="500">
                <h3 class="text-3xl font-bold text-white mb-6">{{ $stats['title'] ?? 'Trusted by Industry Leaders' }}</h3>
                <p class="text-xl text-gray-400 mb-8 max-w-4xl mx-auto">
                    {{ $stats['description'] ?? 'Join thousands of satisfied clients who trust our expertise.' }}
                </p>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
                    @foreach($stats['items'] as $stat)
                        <div class="text-center">
                            <div class="text-3xl font-black text-{{ $stat['color'] }} mb-2">{{ $stat['number'] }}</div>
                            <p class="text-white font-medium">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>