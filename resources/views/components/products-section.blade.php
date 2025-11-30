@php
    $homepageProducts = \App\Models\Product::getHomepageProducts();
    
    $firstProduct = \App\Models\Product::active()->showInHomepage()->ordered()->first();
    $titlePart1 = $firstProduct && $firstProduct->title_part1 ? $firstProduct->title_part1 : 'Your Streaming Empire';
    $titlePart2 = $firstProduct && $firstProduct->title_part2 ? $firstProduct->title_part2 : 'Starts Here';
    $subtitle = $firstProduct && $firstProduct->subtitle_section ? $firstProduct->subtitle_section : 'Premium SaaS solutions for high-quality streaming, global reliability, and a seamless user experience.';
@endphp

<section class="py-20 bg-dark-light relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-96 h-96 bg-gradient-to-r from-primary/10 via-secondary/10 to-accent/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-32 right-32 w-[500px] h-[500px] bg-gradient-to-l from-accent/5 via-primary/5 to-secondary/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-8 py-4 border border-primary/20 mb-8">
                <i class="fas fa-cube text-primary text-xl"></i>
                <span class="text-sm font-semibold tracking-wider uppercase text-primary">Our Products</span>
            </div>
            
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                {{ $titlePart1 }} 
                <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">{{ $titlePart2 }}</span>
            </h2>
            
            <p class="text-gray-400 text-lg max-w-3xl mx-auto leading-relaxed">
                {{ $subtitle }}
            </p>
        </div>

        @if($homepageProducts->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-{{ $homepageProducts->count() > 2 ? '3' : '2' }} gap-8 mb-12">
                @foreach($homepageProducts as $index => $product)
                    <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="relative bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl overflow-hidden border border-white/10 hover:border-{{ $product->color_from }}/30 transition-all duration-700 hover:shadow-2xl hover:-translate-y-2">
                            
                            <div class="relative p-8 pb-6">
                                <div class="w-20 h-20 bg-gradient-to-r {{ $product->getGradientClass() }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-2xl mx-auto">
                                    <i class="{{ $product->icon }} text-white text-3xl"></i>
                                </div>

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
                                    <div class="absolute top-6 left-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-yellow-400 to-orange-500 text-white">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="px-8 pb-8">
                                <div class="text-center mb-6">
                                    <h3 class="text-2xl font-black text-white mb-2 group-hover:bg-gradient-to-r group-hover:{{ $product->getGradientClass() }} group-hover:bg-clip-text group-hover:text-transparent transition-all duration-500">
                                        {{ $product->title }}
                                    </h3>
                                    @if($product->subtitle)
                                        <p class="text-{{ $product->color_from }} font-semibold text-sm">{{ $product->subtitle }}</p>
                                    @endif
                                </div>
                                
                                <p class="text-gray-300 mb-6 leading-relaxed text-center">
                                    {{ $product->short_description ?: substr($product->description, 0, 120) . '...' }}
                                </p>
                                
                                @if($product->getFeatures())
                                    <div class="mb-6">
                                        <div class="grid grid-cols-1 gap-2">
                                            @foreach(array_slice($product->getFeatures(), 0, 3) as $feature)
                                                <div class="flex items-center text-sm text-gray-400">
                                                    <i class="fas fa-check text-green-400 mr-3"></i>
                                                    <span>{{ $feature }}</span>
                                                </div>
                                            @endforeach
                                            @if(count($product->getFeatures()) > 3)
                                                <div class="text-xs text-gray-500 mt-2 text-center">
                                                    +{{ count($product->getFeatures()) - 3 }} more features
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($product->show_pricing)
                                    <div class="text-center mb-6">
                                        <div class="text-2xl font-black text-{{ $product->color_from }}">
                                            {{ $product->getFormattedPrice() }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $product->getPricingModelLabel() }}</div>
                                    </div>
                                @endif
                                
                                <div class="flex flex-col gap-3">
                                    <a href="{{ $product->getUrl() }}" class="w-full inline-flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r {{ $product->getGradientClass() }} text-white font-bold rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                        <span>Explore {{ $product->title }}</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                    
                                    <div class="flex gap-2">
                                        @if($product->demo_url)
                                            <a href="{{ $product->demo_url }}" target="_blank" class="flex-1 inline-flex items-center justify-center space-x-2 px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-lg hover:bg-white/20 transition-all duration-300 text-sm">
                                                <i class="fas fa-play"></i>
                                                <span>Demo</span>
                                            </a>
                                        @endif
                                        
                                        @if($product->documentation_url)
                                            <a href="{{ $product->documentation_url }}" target="_blank" class="flex-1 inline-flex items-center justify-center space-x-2 px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-lg hover:bg-white/20 transition-all duration-300 text-sm">
                                                <i class="fas fa-book"></i>
                                                <span>Docs</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                <div class="bg-gradient-to-r from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/10 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-black text-white mb-4">Ready to Transform Your Business?</h3>
                    <p class="text-gray-400 mb-6">
                        Discover our complete suite of SaaS solutions designed for modern broadcasters
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('products') }}" class="inline-flex items-center space-x-3 px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl">
                            <i class="fas fa-cube"></i>
                            <span>View All Products</span>
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center space-x-3 px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-comments"></i>
                            <span>Get Custom Quote</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-16" data-aos="fade-up">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-cube text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Products Coming Soon</h3>
                <p class="text-gray-400 mb-6 max-w-sm mx-auto">
                    We're working hard to bring you amazing SaaS solutions. Stay tuned!
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center space-x-3 px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-bell"></i>
                    <span>Notify Me</span>
                </a>
            </div>
        @endif
    </div>
</section>