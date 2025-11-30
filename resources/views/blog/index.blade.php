@extends('layouts.app')

@section('title', 'TKDS Media - Broadcasting Industry Blog & Insights')
@section('meta_description', 'Stay updated with the latest broadcasting trends, industry insights, and expert tips from TKDS Media.')

@section('content')

<!-- Hero Section with Featured Post -->
@if($featuredPost)
<section class="relative py-24 bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden mt-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-gradient-to-r from-primary via-secondary to-accent rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-gradient-to-l from-accent via-primary to-secondary rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div data-aos="fade-right">
                <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-6 py-3 border border-primary/20 mb-6">
                    <i class="fas fa-star text-primary text-lg"></i>
                    <span class="text-sm font-semibold tracking-wider uppercase text-primary">Featured Article</span>
                </div>
                
                <div class="flex items-center space-x-4 mb-4">
                    @if($featuredPost->category)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold" 
                              style="background-color: {{ $featuredPost->category->color }}20; color: {{ $featuredPost->category->color }};">
                            <i class="{{ $featuredPost->category->icon }} mr-2"></i>
                            {{ $featuredPost->category->name }}
                        </span>
                    @endif
                    <span class="text-gray-400 text-sm">{{ $featuredPost->published_at->format('M d, Y') }}</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-4 leading-tight">
                    {{ $featuredPost->title }}
                </h1>
                
                <p class="text-lg text-gray-300 mb-6 leading-relaxed">
                    {{ $featuredPost->getExcerpt(150) }}
                </p>

                <div class="flex items-center space-x-6 mb-6">
                    @if($featuredPost->author)
                        <div class="flex items-center space-x-3">
                            <img src="{{ $featuredPost->author->getAvatarUrl() }}" 
                                 alt="{{ $featuredPost->author->name }}"
                                 class="w-10 h-10 rounded-full border-2 border-primary/30">
                            <div>
                                <div class="text-white font-semibold text-sm">{{ $featuredPost->author->name }}</div>
                                <div class="text-gray-400 text-xs">{{ $featuredPost->getReadingTime() }}</div>
                            </div>
                        </div>
                    @endif
                    <div class="flex items-center space-x-4 text-gray-400 text-sm">
                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($featuredPost->view_count) }}</span>
                        <span><i class="fas fa-heart mr-1"></i>{{ number_format($featuredPost->like_count) }}</span>
                    </div>
                </div>
                
                <a href="{{ route('blog.show', $featuredPost->slug) }}" 
                   class="group inline-flex items-center space-x-3 px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span class="font-semibold">Read Full Article</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform duration-300"></i>
                </a>
            </div>
            
            <!-- Featured Image -->
            <div data-aos="fade-left" data-aos-delay="200">
                <div class="relative">
                    <img src="{{ $featuredPost->getFeaturedImageUrl() }}" 
                         alt="{{ $featuredPost->title }}"
                         class="w-full h-80 object-cover rounded-2xl shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        @if($featuredPost->tags->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($featuredPost->tags->take(3) as $tag)
                                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-medium rounded-full border border-white/30">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@else
<!-- Default Hero Section -->
<section class="relative py-24 bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden mt-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-gradient-to-r from-primary via-secondary to-accent rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-gradient-to-l from-accent via-primary to-secondary rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-8 py-4 border border-primary/20 mb-8">
                <i class="fas fa-newspaper text-primary text-xl"></i>
                <span class="text-sm font-semibold tracking-wider uppercase text-primary">Industry Insights</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight">
                Broadcasting 
                <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">Blog</span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                Expert insights and professional tips from the world of 
                <span class="text-primary font-semibold">digital broadcasting</span>
            </p>
        </div>
    </div>
</section>
@endif

<!-- Enhanced Search and Filters Section -->
<section class="py-8 bg-dark-light border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Search Bar -->
        <div class="mb-8" data-aos="fade-up">
            <form action="{{ route('blog.search') }}" method="GET" class="relative max-w-3xl mx-auto">
                <input type="text" name="q" value="{{ request('q') }}" 
                       placeholder="Search articles, topics, authors..." 
                       class="w-full px-8 py-4 pl-16 pr-24 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 text-lg">
                <i class="fas fa-search absolute left-6 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-primary to-secondary text-white px-6 py-2.5 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                    Search
                </button>
            </form>
        </div>

        <!-- Categories Filter -->
        <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
            
            <!-- Category Pills -->
            <div class="w-full">
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3">
                    <span class="text-gray-400 text-sm mr-2">Categories:</span>
                    <a href="{{ route('blog.index') }}" 
                       class="category-filter {{ !request('category') ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} px-4 py-2 rounded-full font-medium transition-all duration-300 text-sm">
                        All Articles
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}" 
                           class="category-filter {{ request('category') === $category->slug ? 'text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} px-4 py-2 rounded-full font-medium transition-all duration-300 text-sm inline-flex items-center"
                           style="{{ request('category') === $category->slug ? 'background: linear-gradient(to right, ' . $category->color . ', ' . $category->color . '90);' : '' }}">
                            <i class="{{ $category->icon }} mr-2 text-xs"></i>
                            {{ $category->name }}
                            <span class="ml-2 text-xs opacity-75 bg-white/20 px-1.5 py-0.5 rounded-full">{{ $category->active_posts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            
            <!-- Sort Options -->
            <div class="flex items-center space-x-4 flex-shrink-0">
                <span class="text-gray-400 text-sm">Sort:</span>
                <div class="flex space-x-2">
                    <a href="{{ route('blog.index', array_merge(request()->except(['sort', 'page']), [])) }}" 
                       class="px-3 py-1.5 {{ !request('sort') || request('sort') === 'latest' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300 text-sm">
                        Latest
                    </a>
                    <a href="{{ route('blog.index', array_merge(request()->except('page'), ['sort' => 'popular'])) }}" 
                       class="px-3 py-1.5 {{ request('sort') === 'popular' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300 text-sm">
                        Popular
                    </a>
                    <a href="{{ route('blog.index', array_merge(request()->except('page'), ['sort' => 'trending'])) }}" 
                       class="px-3 py-1.5 {{ request('sort') === 'trending' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300 text-sm">
                        Trending
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Posts Grid -->
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid lg:grid-cols-12 gap-12">
            
            <!-- Main Content -->
            <div class="lg:col-span-8">
                @if($posts->count() > 0)
                    <!-- Results Info -->
                    @if(request('category') || request('search') || request('sort'))
                        <div class="flex items-center justify-between mb-8" data-aos="fade-up">
                            <div>
                                <h2 class="text-xl font-bold text-white mb-1">
                                    @if(request('search'))
                                        Search results for "<span class="text-primary">{{ request('search') }}</span>"
                                    @elseif(request('category'))
                                        @php
                                            $currentCategory = $categories->where('slug', request('category'))->first();
                                        @endphp
                                        @if($currentCategory)
                                            {{ $currentCategory->name }} Articles
                                        @else
                                            Filtered Articles
                                        @endif
                                    @else
                                        All Articles
                                    @endif
                                </h2>
                                <p class="text-gray-400 text-sm">{{ $posts->total() }} {{ Str::plural('article', $posts->total()) }} found</p>
                            </div>
                            @if(request()->hasAny(['category', 'search', 'sort']))
                                <a href="{{ route('blog.index') }}" 
                                   class="text-primary hover:text-white transition-colors duration-300 text-sm">
                                    <i class="fas fa-times mr-1"></i> Clear filters
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Posts Grid -->
                    <div class="grid md:grid-cols-2 gap-8 mb-12">
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
                                                <a href="{{ route('blog.category', $post->category->slug) }}"
                                                   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold hover:scale-105 transition-transform duration-300" 
                                                   style="background-color: {{ $post->category->color }}90; color: white;">
                                                    <i class="{{ $post->category->icon }} mr-1"></i>
                                                    {{ $post->category->name }}
                                                </a>
                                            </div>
                                        @endif
                                        
                                        <!-- Reading Time -->
                                        <div class="absolute top-4 right-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $post->getReadingTime() }}
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

                                        <!-- Trending Badge -->
                                        @if($post->is_trending)
                                            <div class="absolute bottom-4 left-4">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-500 text-white">
                                                    <i class="fas fa-fire mr-1"></i>
                                                    Trending
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="p-6">
                                        <div class="flex items-center space-x-4 text-xs text-gray-400 mb-3">
                                            <span><i class="fas fa-calendar mr-1"></i> {{ $post->published_at->format('M d, Y') }}</span>
                                            @if($post->author)
                                                <a href="{{ route('blog.author', $post->author->slug) }}" 
                                                   class="hover:text-primary transition-colors duration-300">
                                                    <i class="fas fa-user mr-1"></i> {{ $post->author->name }}
                                                </a>
                                            @endif
                                        </div>
                                        
                                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300 leading-tight">
                                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                        </h3>
                                        
                                        <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                                            {{ $post->getExcerpt(120) }}
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
                                            
                                            <!-- Enhanced Stats with Interactions -->
                                            <div class="flex items-center space-x-3 text-xs text-gray-400">
                                                <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->view_count) }}</span>
                                                <button class="like-btn hover:text-red-400 transition-colors duration-300" 
                                                        data-post-id="{{ $post->id }}">
                                                    <i class="fas fa-heart mr-1"></i><span class="like-count">{{ number_format($post->like_count) }}</span>
                                                </button>
                                                <span><i class="fas fa-share mr-1"></i>{{ number_format($post->share_count) }}</span>
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
                            <i class="fas fa-search text-4xl text-primary"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-white mb-4">No articles found</h3>
                        <p class="text-gray-400 mb-6 max-w-md mx-auto">
                            @if(request('q'))
                                No articles match your search for "<span class="text-primary font-semibold">{{ request('q') }}</span>". Try different keywords.
                            @elseif(request('category'))
                                No articles found in this category. Check back soon for new content!
                            @else
                                We're working on bringing you amazing content. Check back soon!
                            @endif
                        </p>
                        <a href="{{ route('blog.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to All Articles
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Enhanced Sidebar -->
            <div class="lg:col-span-4">
                <div class="sticky top-8 space-y-8">
                    
                    <!-- Popular Posts -->
                    @if($popularPosts->count() > 0)
                        <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-6 border border-white/10" data-aos="fade-left">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                                <i class="fas fa-fire text-orange-500 mr-2"></i>
                                Popular Articles
                            </h3>
                            <div class="space-y-4">
                                @foreach($popularPosts as $index => $popularPost)
                                    <article class="group flex space-x-4 p-3 rounded-xl hover:bg-white/5 transition-colors duration-300">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $popularPost->getFeaturedImageUrl() }}" 
                                                 alt="{{ $popularPost->title }}"
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2 text-xs text-gray-400 mb-1">
                                                <span class="bg-orange-500/20 text-orange-400 px-2 py-0.5 rounded-full font-bold">{{ $index + 1 }}</span>
                                                <span>{{ number_format($popularPost->view_count) }} views</span>
                                            </div>
                                            <h4 class="text-sm font-semibold text-white group-hover:text-primary transition-colors duration-300 line-clamp-2 leading-tight">
                                                <a href="{{ route('blog.show', $popularPost->slug) }}">{{ $popularPost->title }}</a>
                                            </h4>
                                            <div class="text-xs text-gray-400 mt-1">
                                                {{ $popularPost->published_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Categories -->
                    @if($categories->count() > 0)
                        <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-6 border border-white/10" data-aos="fade-left" data-aos-delay="100">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                                <i class="fas fa-folder text-blue-500 mr-2"></i>
                                Categories
                            </h3>
                            <div class="space-y-3">
                                @foreach($categories as $category)
                                    <a href="{{ route('blog.category', $category->slug) }}" 
                                       class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-colors duration-300 group">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }};"></div>
                                            <span class="text-white group-hover:text-primary transition-colors duration-300">{{ $category->name }}</span>
                                        </div>
                                        <span class="text-xs text-gray-400 bg-white/10 px-2 py-1 rounded-full">{{ $category->active_posts_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Tags Cloud -->
                    @if($tags->count() > 0)
                        <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-6 border border-white/10" data-aos="fade-left" data-aos-delay="200">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                                <i class="fas fa-tags text-green-500 mr-2"></i>
                                Popular Tags
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $tag)
                                    <a href="{{ route('blog.tag', $tag->slug) }}" 
                                       class="px-3 py-1 bg-white/10 hover:bg-primary/20 text-gray-300 hover:text-white text-sm rounded-full transition-colors duration-300"
                                       style="font-size: {{ min(16, 12 + ($tag->posts_count * 2)) }}px;">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced search functionality
    const searchForm = document.querySelector('form[action*="search"]');
    if (searchForm) {
        const searchInput = searchForm.querySelector('input[name="q"]');
        searchInput?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (this.value.trim()) {
                    searchForm.submit();
                }
            }
        });
    }
    
    // Like functionality
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const likeCountSpan = this.querySelector('.like-count');
            
            fetch(`/blog/post/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    likeCountSpan.textContent = data.like_count.toLocaleString();
                    this.classList.add('text-red-400');
                    
                    // Add animation
                    this.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                } else {
                    // Show message for already liked
                    showNotification(data.message, 'info');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Something went wrong. Please try again.', 'error');
            });
        });
    });
    
    // Newsletter subscription
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            if (email) {
                showNotification('Thank you for subscribing! We\'ll keep you updated with the latest insights.', 'success');
                this.reset();
            }
        });
    }
    
    // Category filter animations
    document.querySelectorAll('.category-filter').forEach(filter => {
        filter.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        filter.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endpush