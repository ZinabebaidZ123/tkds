@extends('layouts.app')

@section('title', $tag->name . ' Articles - TKDS Media')
@section('meta_description', 'Browse articles tagged with ' . $tag->name . ' from TKDS Media blog.')

@section('content')

<!-- Hero Section -->
<section class="relative py-32 bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden mt-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-gradient-to-r from-primary via-secondary to-accent rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-gradient-to-l from-accent via-primary to-secondary rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            
            <!-- Breadcrumb -->
            <nav class="flex items-center justify-center space-x-2 text-sm text-gray-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors duration-300">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors duration-300">Blog</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-300">{{ $tag->name }}</span>
            </nav>

            <!-- Tag Badge -->
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-8 py-4 border border-primary/20 mb-8">
                <i class="fas fa-tag text-primary text-xl"></i>
                <span class="text-sm font-semibold tracking-wider uppercase text-primary">Tag</span>
            </div>
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white mb-8 leading-tight">
                #{{ $tag->name }}
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed mb-8">
                Articles and insights tagged with 
                <span class="px-4 py-2 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-full font-semibold text-primary">
                    {{ $tag->name }}
                </span>
            </p>

            <!-- Stats -->
            <div class="flex flex-wrap items-center justify-center gap-8 text-gray-400">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-newspaper text-primary"></i>
                    <span>{{ $posts->total() }} {{ Str::plural('Article', $posts->total()) }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-eye text-secondary"></i>
                    <span>{{ number_format($posts->sum('view_count')) }} Total Views</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $tag->color }};"></div>
                    <span>Tag Color</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Sort Section -->
<section class="py-8 bg-dark-light border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
            
            <!-- Search in Tag -->
            <div class="w-full lg:w-96">
                <form action="{{ route('blog.tag', $tag->slug) }}" method="GET" class="relative">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search in #{{ $tag->name }}..." 
                           class="w-full px-6 py-3 pl-12 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-primary to-secondary text-white px-4 py-1.5 rounded-lg font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                        Search
                    </button>
                </form>
            </div>
            
            <!-- Sort Options -->
            <div class="flex items-center space-x-4">
                <span class="text-gray-400 text-sm">Sort by:</span>
                <div class="flex space-x-2">
                    <a href="{{ route('blog.tag', array_merge(['tag' => $tag->slug], request()->except(['sort', 'page']))) }}" 
                       class="px-4 py-2 {{ !request('sort') || request('sort') === 'latest' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300">
                        Latest
                    </a>
                    <a href="{{ route('blog.tag', array_merge(['tag' => $tag->slug, 'sort' => 'popular'], request()->except('page'))) }}" 
                       class="px-4 py-2 {{ request('sort') === 'popular' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300">
                        Popular
                    </a>
                    <a href="{{ route('blog.tag', array_merge(['tag' => $tag->slug, 'sort' => 'oldest'], request()->except('page'))) }}" 
                       class="px-4 py-2 {{ request('sort') === 'oldest' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300">
                        Oldest
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Articles Grid -->
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($posts->count() > 0)
            <!-- Results Info -->
            <div class="flex items-center justify-between mb-12" data-aos="fade-up">
                <h2 class="text-2xl font-bold text-white">
                    @if(request('search'))
                        Search results for "<span class="text-primary">{{ request('search') }}</span>" in #{{ $tag->name }}
                    @else
                        Articles tagged with #{{ $tag->name }}
                    @endif
                </h2>
                <span class="text-gray-400">{{ $posts->total() }} {{ Str::plural('article', $posts->total()) }} found</span>
            </div>

            <!-- Posts Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($posts as $index => $post)
                    <article class="blog-post group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-xl hover:shadow-primary/10">
                            
                            <!-- Featured Image -->
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ $post->getFeaturedImageUrl() }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                
                                <!-- Category Badge -->
                                @if($post->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" 
                                              style="background-color: {{ $post->category->color }}90; color: white;">
                                            <i class="{{ $post->category->icon }} mr-1"></i>
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                                
                                <!-- Tag Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold"
                                          style="background-color: {{ $tag->color }}90; color: white;">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $tag->name }}
                                    </span>
                                </div>

                                <!-- Featured Badge -->
                                @if($post->is_featured)
                                    <div class="absolute bottom-4 right-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-yellow-500 text-white">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <div class="flex items-center space-x-4 text-xs text-gray-400 mb-3">
                                    <span><i class="fas fa-calendar mr-1"></i> {{ $post->published_at->format('M d, Y') }}</span>
                                    @if($post->author)
                                        <span><i class="fas fa-user mr-1"></i> {{ $post->author->name }}</span>
                                    @endif
                                    <span><i class="fas fa-clock mr-1"></i> {{ $post->getReadingTime() }}</span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300 leading-tight">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                
                                <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                                    {{ $post->getExcerpt(120) }}
                                </p>

                                <!-- Other Tags -->
                                @if($post->tags->where('id', '!=', $tag->id)->count() > 0)
                                    <div class="flex flex-wrap gap-2 mb-6">
                                        @foreach($post->tags->where('id', '!=', $tag->id)->take(3) as $otherTag)
                                            <a href="{{ route('blog.tag', $otherTag->slug) }}" 
                                               class="px-2 py-1 bg-white/10 hover:bg-primary/20 text-gray-300 hover:text-white text-xs rounded-full transition-colors duration-300">
                                                #{{ $otherTag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('blog.show', $post->slug) }}" 
                                       class="inline-flex items-center text-primary hover:text-white font-semibold transition-colors duration-300 group/link">
                                        <span>Read More</span>
                                        <i class="fas fa-chevron-right ml-2 text-xs group-hover/link:translate-x-1 transition-transform duration-300"></i>
                                    </a>
                                    
                                    <div class="flex items-center space-x-3 text-xs text-gray-400">
                                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->view_count) }}</span>
                                        <span><i class="fas fa-heart mr-1"></i>{{ number_format($post->like_count) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center" data-aos="fade-up">
                {{ $posts->appends(request()->query())->links('blog.partials.pagination') }}
            </div>
        @else
            <!-- No Posts Found -->
            <div class="text-center py-16" data-aos="fade-up">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-tag text-4xl text-primary"></i>
                </div>
                <h3 class="text-2xl font-semibold text-white mb-4">
                    @if(request('search'))
                        No articles found for "{{ request('search') }}"
                    @else
                        No articles tagged with #{{ $tag->name }} yet
                    @endif
                </h3>
                <p class="text-gray-400 mb-6 max-w-md mx-auto">
                    @if(request('search'))
                        Try different keywords or browse all articles with this tag.
                    @else
                        We're working on bringing you amazing content. Check back soon!
                    @endif
                </p>
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                    @if(request('search'))
<a href="{{ route('blog.tag', $tag->slug) }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-tag mr-2"></i>
                            Browse All #{{ $tag->name }} Articles
                        </a>
                    @endif
                    <a href="{{ route('blog.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-all duration-300 border border-white/20">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to All Articles
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Related Tags -->
<section class="py-16 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-white mb-4">Related Tags</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary rounded-full mx-auto"></div>
        </div>

        @php
            $relatedTags = \App\Models\BlogTag::active()
                ->where('id', '!=', $tag->id)
                ->withCount('posts')
                ->having('posts_count', '>', 0)
                ->orderBy('posts_count', 'desc')
                ->limit(12)
                ->get();
        @endphp
        
        @if($relatedTags->count() > 0)
            <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                @foreach($relatedTags as $relatedTag)
                    <a href="{{ route('blog.tag', $relatedTag->slug) }}" 
                       class="group inline-flex items-center px-6 py-3 bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-xl border border-white/10 hover:border-primary/30 transition-all duration-300 hover:transform hover:scale-105"
                       style="font-size: {{ min(16, 12 + ($relatedTag->posts_count * 1)) }}px;">
                        <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $relatedTag->color }};"></div>
                        <span class="text-white group-hover:text-primary transition-colors duration-300 font-medium">
                            #{{ $relatedTag->name }}
                        </span>
                        <span class="ml-2 text-xs text-gray-400 bg-white/10 px-2 py-1 rounded-full">
                            {{ $relatedTag->posts_count }}
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <p class="text-gray-400">No related tags found.</p>
            </div>
        @endif
    </div>
</section>

<!-- Tag Cloud -->
<section class="py-16 bg-dark">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-12 border border-white/10" data-aos="fade-up">
            <h3 class="text-3xl font-black text-white mb-6">Explore More Tags</h3>
            <p class="text-gray-400 mb-8 text-lg">
                Discover more articles by exploring our popular tags
            </p>
            
            @php
                $allTags = \App\Models\BlogTag::active()
                    ->withCount('posts')
                    ->having('posts_count', '>', 0)
                    ->orderBy('posts_count', 'desc')
                    ->limit(20)
                    ->get();
            @endphp
            
            @if($allTags->count() > 0)
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach($allTags as $cloudTag)
                        <a href="{{ route('blog.tag', $cloudTag->slug) }}" 
                           class="inline-flex items-center px-4 py-2 {{ $cloudTag->id === $tag->id ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 hover:bg-primary/20 text-gray-300 hover:text-white' }} rounded-full transition-colors duration-300"
                           style="font-size: {{ min(16, 12 + ($cloudTag->posts_count * 1.5)) }}px;">
                            #{{ $cloudTag->name }}
                            @if($cloudTag->posts_count > 1)
                                <span class="ml-2 text-xs opacity-75">({{ $cloudTag->posts_count }})</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
            
            <div class="mt-8">
                <a href="{{ route('blog.index') }}" 
                   class="inline-flex items-center space-x-3 px-8 py-4 bg-gradient-to-r from-primary/20 to-secondary/20 backdrop-blur-sm text-white font-bold rounded-xl border border-primary/30 hover:border-primary/60 hover:from-primary/30 hover:to-secondary/30 transition-all duration-300 transform hover:scale-105">
                    <span>View All Articles</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchForm = document.querySelector('form[action*="tag"]');
    if (searchForm) {
        const searchInput = searchForm.querySelector('input[name="search"]');
        searchInput?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchForm.submit();
            }
        });
    }
    
    // Tag cloud dynamic sizing
    const tagLinks = document.querySelectorAll('a[href*="blog/tag"]');
    tagLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endpush