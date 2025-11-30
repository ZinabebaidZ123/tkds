@php
    $featuredPosts = \App\Models\BlogPost::published()
        ->featured()
        ->with(['category', 'author', 'tags'])
        ->latest('published_at')
        ->limit(3)
        ->get();
    
    $trendingPosts = collect();
    $regularPosts = collect();
    
    if ($featuredPosts->count() < 3) {
        $needed = 3 - $featuredPosts->count();
        $trendingPosts = \App\Models\BlogPost::published()
            ->trending()
            ->with(['category', 'author', 'tags'])
            ->whereNotIn('id', $featuredPosts->pluck('id'))
            ->latest('published_at')
            ->limit($needed)
            ->get();
    }
    
    $totalPosts = $featuredPosts->count() + $trendingPosts->count();
    if ($totalPosts < 3) {
        $needed = 3 - $totalPosts;
        $regularPosts = \App\Models\BlogPost::published()
            ->with(['category', 'author', 'tags'])
            ->whereNotIn('id', $featuredPosts->pluck('id')->merge($trendingPosts->pluck('id')))
            ->latest('published_at')
            ->limit($needed)
            ->get();
    }
    
    $allPosts = $featuredPosts->merge($trendingPosts)->merge($regularPosts);
    
    $mainFeaturedPost = $allPosts->first();
    $sidePosts = $allPosts->slice(1, 2);
    
    $firstPost = \App\Models\BlogPost::published()->with(['category', 'author'])->latest('published_at')->first();
    $titlePart1 = $firstPost && $firstPost->title_part1 ? $firstPost->title_part1 : 'Broadcast';
    $titlePart2 = $firstPost && $firstPost->title_part2 ? $firstPost->title_part2 : 'Smarts';
    $subtitle = $firstPost && $firstPost->subtitle ? $firstPost->subtitle : 'Explore expert insights, trends, and innovations in broadcasting.';
@endphp

<section id="blog" class="relative py-20 bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-30"></div>

    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-gradient-to-r from-primary via-secondary to-accent rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/3 right-1/4 w-96 h-96 bg-gradient-to-l from-accent via-primary to-secondary rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-gradient-to-tr from-secondary via-accent to-primary rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>
    
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        @for($i = 0; $i < 20; $i++)
            <div class="absolute w-2 h-2 bg-primary/20 rounded-full animate-float" 
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 3000) }}ms; animation-duration: {{ rand(4000, 8000) }}ms;"></div>
        @endfor
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-8 py-4 border border-primary/20 mb-8 group hover:border-primary/40 transition-all duration-500">
                <div class="w-3 h-3 bg-primary rounded-full animate-pulse"></div>
                <span class="text-sm font-semibold tracking-wider uppercase text-primary">Latest from our blog</span>
                <i class="fas fa-newspaper text-primary group-hover:rotate-12 transition-transform duration-300"></i>
            </div>
            
            <h2 class="text-5xl md:text-6xl lg:text-7xl font-black text-white mb-8 leading-tight">
                {{ $titlePart1 }} 
                <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">{{ $titlePart2 }}</span>
            </h2>
            
            <p class="text-xl md:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                {{ $subtitle }}
            </p>
        </div>
        
        @if($allPosts->count() > 0)
            <div class="grid lg:grid-cols-12 gap-8 lg:gap-10">
                
                @if($mainFeaturedPost)
                    <div class="lg:col-span-8" data-aos="fade-right" data-aos-delay="200">
                        <article class="group relative bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-700 hover:shadow-2xl hover:shadow-primary/10">
                            
                            <div class="relative h-96 overflow-hidden">
                                <img src="{{ $mainFeaturedPost->getFeaturedImageUrl() }}" 
                                     alt="{{ $mainFeaturedPost->featured_image_alt ?? $mainFeaturedPost->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                                
                                <div class="absolute top-8 left-8">
                                    @if($mainFeaturedPost->is_featured)
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-primary/90 text-white backdrop-blur-sm shadow-lg group-hover:bg-primary transition-colors duration-300">
                                            <i class="fas fa-star mr-2"></i>
                                            Featured
                                        </span>
                                    @elseif($mainFeaturedPost->is_trending)
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-secondary/90 text-white backdrop-blur-sm shadow-lg group-hover:bg-secondary transition-colors duration-300">
                                            <i class="fas fa-fire mr-2"></i>
                                            Trending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-accent/90 text-white backdrop-blur-sm shadow-lg group-hover:bg-accent transition-colors duration-300">
                                            <i class="fas fa-newspaper mr-2"></i>
                                            Latest
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="absolute top-8 right-8">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white backdrop-blur-sm border" 
                                          style="background-color: {{ $mainFeaturedPost->category->color }}20; border-color: {{ $mainFeaturedPost->category->color }}40;">
                                        <i class="{{ $mainFeaturedPost->category->icon }} mr-2"></i>
                                        {{ $mainFeaturedPost->category->name }}
                                    </span>
                                </div>
                                
                                <div class="absolute bottom-8 left-8 right-8">
                                    <div class="flex items-center space-x-6 text-sm text-gray-300 mb-4">
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                            {{ $mainFeaturedPost->published_at->format('M j, Y') }}
                                        </span>
                                        <span class="flex items-center">
                                            <img src="{{ $mainFeaturedPost->author->getAvatarUrl() }}" 
                                                 alt="{{ $mainFeaturedPost->author->name }}" 
                                                 class="w-6 h-6 rounded-full mr-2">
                                            {{ $mainFeaturedPost->author->name }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-eye mr-2 text-accent"></i>
                                            {{ number_format($mainFeaturedPost->view_count) }} views
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-clock mr-2 text-secondary"></i>
                                            {{ $mainFeaturedPost->getReadingTime() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-10">
                                <h3 class="text-3xl md:text-4xl font-black text-white mb-6 group-hover:text-primary transition-colors duration-500 leading-tight">
                                    {{ $mainFeaturedPost->title }}
                                </h3>
                                
                                <p class="text-gray-300 text-lg mb-8 leading-relaxed">
                                    {{ $mainFeaturedPost->getExcerpt(200) }}
                                </p>
                                
                                @if($mainFeaturedPost->tags->count() > 0)
                                    <div class="flex flex-wrap gap-2 mb-8">
                                        @foreach($mainFeaturedPost->tags->take(3) as $tag)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white border" 
                                                  style="background-color: {{ $tag->color }}20; border-color: {{ $tag->color }}40; color: {{ $tag->color }};">
                                                #{{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('blog.show', $mainFeaturedPost->slug) }}" 
                                       class="group/btn inline-flex items-center space-x-3 text-lg font-bold text-primary hover:text-white transition-all duration-300">
                                        <span>Read Full Article</span>
                                        <i class="fas fa-arrow-right group-hover/btn:translate-x-2 transition-transform duration-300"></i>
                                    </a>
                                    
                                    <div class="flex items-center space-x-4 text-gray-400">
                                        <span class="flex items-center">
                                            <i class="fas fa-heart mr-1"></i>
                                            {{ $mainFeaturedPost->like_count }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-share-alt mr-1"></i>
                                            {{ $mainFeaturedPost->share_count }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @endif
                
                @if($sidePosts->count() > 0)
                    <div class="lg:col-span-4 space-y-8">
                        @foreach($sidePosts as $index => $post)
                            <article class="group" data-aos="fade-left" data-aos-delay="{{ 300 + ($index * 100) }}">
                                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-secondary/40 transition-all duration-500 hover:shadow-xl hover:shadow-secondary/10">
                                    <div class="relative h-48 overflow-hidden">
                                        <img src="{{ $post->getFeaturedImageUrl() }}" 
                                             alt="{{ $post->featured_image_alt ?? $post->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                        
                                        <div class="absolute top-4 left-4">
                                            @if($post->is_featured)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-primary/90 text-white">
                                                    <i class="fas fa-star mr-1"></i>
                                                    Featured
                                                </span>
                                            @elseif($post->is_trending)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-secondary/90 text-white">
                                                    <i class="fas fa-fire mr-1"></i>
                                                    Trending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-accent/90 text-white">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Latest
                                                </span>
                                            @endif
                                        </div>

                                        <div class="absolute top-4 right-4">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white backdrop-blur-sm" 
                                                  style="background-color: {{ $post->category->color }}40;">
                                                <i class="{{ $post->category->icon }} mr-1"></i>
                                                {{ $post->category->name }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="p-6">
                                        <div class="flex items-center space-x-4 text-xs text-gray-400 mb-3">
                                            <span><i class="fas fa-calendar mr-1"></i> {{ $post->published_at->format('M j, Y') }}</span>
                                            <span><i class="fas fa-clock mr-1"></i> {{ $post->getReadingTime() }}</span>
                                            <span><i class="fas fa-eye mr-1"></i> {{ number_format($post->view_count) }}</span>
                                        </div>
                                        
                                        <h4 class="text-xl font-bold text-white mb-3 group-hover:text-secondary transition-colors duration-300 leading-tight">
                                            {{ Str::limit($post->title, 80) }}
                                        </h4>
                                        
                                        <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                                            {{ $post->getExcerpt(120) }}
                                        </p>

                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-2">
                                                <img src="{{ $post->author->getAvatarUrl() }}" 
                                                     alt="{{ $post->author->name }}" 
                                                     class="w-6 h-6 rounded-full">
                                                <span class="text-sm text-gray-400">{{ $post->author->name }}</span>
                                            </div>
                                            <div class="flex items-center space-x-3 text-xs text-gray-500">
                                                <span><i class="fas fa-heart mr-1"></i>{{ $post->like_count }}</span>
                                                <span><i class="fas fa-share mr-1"></i>{{ $post->share_count }}</span>
                                            </div>
                                        </div>
                                        
                                        @if($post->tags->count() > 0)
                                            <div class="flex flex-wrap gap-1 mb-4">
                                                @foreach($post->tags->take(2) as $tag)
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium" 
                                                          style="background-color: {{ $tag->color }}15; color: {{ $tag->color }};">
                                                        #{{ $tag->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <a href="{{ route('blog.show', $post->slug) }}" 
                                           class="inline-flex items-center text-secondary hover:text-accent font-semibold transition-colors duration-300 group/link">
                                            <span>Read More</span>
                                            <i class="fas fa-chevron-right ml-2 text-xs group-hover/link:translate-x-1 transition-transform duration-300"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
                
            </div>
        @else
            <div class="text-center py-20" data-aos="fade-up">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-8 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-newspaper text-4xl text-primary"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">No Posts Available</h3>
                    <p class="text-gray-400 mb-8">We're working on bringing you amazing content. Check back soon!</p>
                    <a href="{{ route('blog.index') }}" 
                       class="inline-flex items-center space-x-2 px-6 py-3 bg-primary/20 text-primary font-semibold rounded-lg hover:bg-primary/30 transition-all duration-300">
                        <i class="fas fa-plus"></i>
                        <span>View All Posts</span>
                    </a>
                </div>
            </div>
        @endif
        
        @if($allPosts->count() > 0)
            <div class="text-center mt-16" data-aos="fade-up" data-aos-delay="500">
                <a href="{{ route('blog.index') }}" 
                   class="group inline-flex items-center space-x-4 px-10 py-5 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-xl text-white font-bold rounded-2xl border border-primary/30 hover:border-primary/60 hover:from-primary/20 hover:to-secondary/20 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/20 transform hover:-translate-y-1">
                    <i class="fas fa-newspaper text-primary text-xl"></i>
                    <span class="text-lg">Explore All Articles</span>
                    <i class="fas fa-arrow-right text-primary group-hover:translate-x-2 transition-transform duration-300"></i>
                </a>
            </div>
        @endif
        
    </div>
</section>