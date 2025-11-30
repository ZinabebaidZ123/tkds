@extends('layouts.app')

@section('title', 'Search Results for "' . $query . '" - TKDS Media')
@section('meta_description', 'Search results for "' . $query . '" on TKDS Media blog.')

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
                <span class="text-gray-300">Search Results</span>
            </nav>

            <!-- Search Badge -->
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-8 py-4 border border-primary/20 mb-8">
                <i class="fas fa-search text-primary text-xl"></i>
                <span class="text-sm font-semibold tracking-wider uppercase text-primary">Search Results</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-8 leading-tight">
                Search Results for
                <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent block mt-2">
                    "{{ $query }}"
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed mb-8">
                @if($posts->count() > 0)
                    Found {{ $posts->total() }} {{ Str::plural('result', $posts->total()) }} matching your search
                @else
                    No articles found matching your search query
                @endif
            </p>

            <!-- New Search -->
            <div class="max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ route('blog.search') }}" method="GET" class="relative">
                    <input type="text" name="q" value="{{ $query }}" 
                           placeholder="Try a different search..." 
                           class="w-full px-6 py-4 pl-14 pr-20 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                    <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Sort Section -->
@if($posts->count() > 0)
    <section class="py-8 bg-dark-light border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
                
                <!-- Results Info -->
                <div class="text-gray-400">
                    <span class="text-lg font-semibold text-white">{{ $posts->total() }}</span> 
                    {{ Str::plural('result', $posts->total()) }} found for 
                    <span class="text-primary font-semibold">"{{ $query }}"</span>
                </div>
                
                <!-- Sort Options -->
                <div class="flex items-center space-x-4">
                    <span class="text-gray-400 text-sm">Sort by:</span>
                    <div class="flex space-x-2">
                        <a href="{{ route('blog.search', array_merge(['q' => $query], request()->except(['sort', 'page']))) }}" 
                           class="px-4 py-2 {{ !request('sort') || request('sort') === 'relevance' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300">
                            Relevance
                        </a>
                        <a href="{{ route('blog.search', array_merge(['q' => $query, 'sort' => 'latest'], request()->except('page'))) }}" 
                           class="px-4 py-2 {{ request('sort') === 'latest' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300">
                            Latest
                        </a>
                        <a href="{{ route('blog.search', array_merge(['q' => $query, 'sort' => 'popular'], request()->except('page'))) }}" 
                           class="px-4 py-2 {{ request('sort') === 'popular' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300">
                            Popular
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- Search Results -->
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($posts->count() > 0)
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
                                
                                <!-- Reading Time -->
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $post->getReadingTime() }}
                                    </span>
                                </div>

                                <!-- Match Badge -->
                                <div class="absolute bottom-4 left-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500/90 text-white">
                                        <i class="fas fa-check mr-1"></i>
                                        Match
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <div class="flex items-center space-x-4 text-xs text-gray-400 mb-3">
                                    <span><i class="fas fa-calendar mr-1"></i> {{ $post->published_at->format('M d, Y') }}</span>
                                    @if($post->author)
                                        <span><i class="fas fa-user mr-1"></i> {{ $post->author->name }}</span>
                                    @endif
                                </div>
                                
                                <h3 class="text-xl font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300 leading-tight">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        {!! str_ireplace($query, '<mark class="bg-primary/30 text-primary font-bold">' . $query . '</mark>', $post->title) !!}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                                    {!! str_ireplace($query, '<mark class="bg-primary/30 text-primary font-bold">' . $query . '</mark>', $post->getExcerpt(120)) !!}
                                </p>

                                <!-- Tags -->
                                @if($post->tags->count() > 0)
                                    <div class="flex flex-wrap gap-2 mb-6">
                                        @foreach($post->tags->take(3) as $tag)
                                            <a href="{{ route('blog.tag', $tag->slug) }}" 
                                               class="px-2 py-1 bg-white/10 hover:bg-primary/20 text-gray-300 hover:text-white text-xs rounded-full transition-colors duration-300">
                                                #{{ $tag->name }}
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
            <!-- No Results Found -->
            <div class="text-center py-16" data-aos="fade-up">
                <div class="mx-auto h-32 w-32 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-8">
                    <i class="fas fa-search text-6xl text-primary opacity-50"></i>
                </div>
                <h3 class="text-3xl font-semibold text-white mb-6">No articles found</h3>
                <p class="text-gray-400 mb-8 max-w-2xl mx-auto text-lg leading-relaxed">
                    We couldn't find any articles matching "<span class="text-primary font-semibold">{{ $query }}</span>". 
                    Try adjusting your search terms or browse our categories below.
                </p>
                
                <!-- Search Suggestions -->
                <div class="max-w-4xl mx-auto mb-12">
                    <h4 class="text-xl font-bold text-white mb-6">Search Suggestions:</h4>
                    <div class="grid md:grid-cols-2 gap-6 text-left">
                        <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-xl p-6 border border-white/10">
                            <h5 class="text-lg font-semibold text-primary mb-3">
                                <i class="fas fa-lightbulb mr-2"></i>
                                Try These Tips:
                            </h5>
                            <ul class="space-y-2 text-gray-300">
                                <li><i class="fas fa-check text-green-400 mr-2"></i>Check your spelling</li>
                                <li><i class="fas fa-check text-green-400 mr-2"></i>Use different keywords</li>
                                <li><i class="fas fa-check text-green-400 mr-2"></i>Try more general terms</li>
                                <li><i class="fas fa-check text-green-400 mr-2"></i>Use fewer keywords</li>
                            </ul>
                        </div>
                        <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-xl p-6 border border-white/10">
                            <h5 class="text-lg font-semibold text-secondary mb-3">
                                <i class="fas fa-tags mr-2"></i>
                                Popular Topics:
                            </h5>
                            @php
                                $popularTags = \App\Models\BlogTag::active()
                                    ->withCount('posts')
                                    ->having('posts_count', '>', 0)
                                    ->orderBy('posts_count', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp
                            <div class="flex flex-wrap gap-2">
                                @foreach($popularTags as $tag)
                                    <a href="{{ route('blog.tag', $tag->slug) }}" 
                                       class="px-3 py-1 bg-white/10 hover:bg-primary/20 text-gray-300 hover:text-white text-sm rounded-full transition-colors duration-300">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                    <a href="{{ route('blog.index') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-list mr-2"></i>
                        Browse All Articles
                    </a>
                    <button onclick="document.querySelector('input[name=q]').focus()" 
                            class="inline-flex items-center px-8 py-4 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-all duration-300 border border-white/20">
                        <i class="fas fa-search mr-2"></i>
                        Try New Search
                    </button>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Popular Articles -->
@if($posts->count() === 0)
    <section class="py-16 bg-dark-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-white mb-4">Popular Articles</h2>
                <p class="text-gray-400 mb-6">Maybe you'll find what you're looking for here</p>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary rounded-full mx-auto"></div>
            </div>

            @php
                $popularPosts = \App\Models\BlogPost::published()
                    ->with(['category', 'author'])
                    ->orderBy('view_count', 'desc')
                    ->limit(6)
                    ->get();
            @endphp
            
            @if($popularPosts->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($popularPosts as $index => $popularPost)
                        <article class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                            <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2">
                                
                                <!-- Featured Image -->
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ $popularPost->getFeaturedImageUrl() }}" 
                                         alt="{{ $popularPost->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                    
                                    @if($popularPost->category)
                                        <div class="absolute top-4 left-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" 
                                                  style="background-color: {{ $popularPost->category->color }}90; color: white;">
                                                <i class="{{ $popularPost->category->icon }} mr-1"></i>
                                                {{ $popularPost->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute top-4 right-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-orange-500 text-white">
                                            <i class="fas fa-fire mr-1"></i>
                                            Popular
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-6">
                                    <div class="text-xs text-gray-400 mb-3">
                                        {{ $popularPost->published_at->format('M d, Y') }} • {{ $popularPost->getReadingTime() }}
                                    </div>
                                    
                                    <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300 leading-tight">
                                        <a href="{{ route('blog.show', $popularPost->slug) }}">{{ $popularPost->title }}</a>
                                    </h3>
                                    
                                    <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                                        {{ $popularPost->getExcerpt(100) }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('blog.show', $popularPost->slug) }}" 
                                           class="inline-flex items-center text-primary hover:text-white font-semibold transition-colors duration-300 group/link">
                                            <span>Read More</span>
                                            <i class="fas fa-chevron-right ml-2 text-xs group-hover/link:translate-x-1 transition-transform duration-300"></i>
                                        </a>
                                        
                                        <div class="text-xs text-gray-400">
                                            <i class="fas fa-eye mr-1"></i>{{ number_format($popularPost->view_count) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus search input
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput && !searchInput.value) {
        setTimeout(() => {
            searchInput.focus();
        }, 1000);
    }
    
    // Search form submission
    const searchForm = document.querySelector('form[action*="search"]');
    if (searchForm) {
        searchInput?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (this.value.trim()) {
                    searchForm.submit();
                }
            }
        });
    }
    
    // Highlight search terms in results
    const query = '{{ $query }}';
    if (query && query.length > 2) {
        const regex = new RegExp(`(${query})`, 'gi');
        const elements = document.querySelectorAll('h3 a, p');
        
        elements.forEach(element => {
            if (element.innerHTML && !element.querySelector('mark')) {
                element.innerHTML = element.innerHTML.replace(regex, '<mark class="bg-primary/30 text-primary font-bold">$1</mark>');
            }
        });
    }
});
</script>
@endpush