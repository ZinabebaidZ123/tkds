@extends('layouts.app')

@section('title', $author->meta_title ?: $author->name . ' - TKDS Media')
@section('meta_description', $author->meta_description ?: 'Browse articles by ' . $author->name . ' on TKDS Media blog.')

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
                <span class="text-gray-300">{{ $author->name }}</span>
            </nav>

            <!-- Author Avatar -->
            <div class="mb-8" data-aos="fade-up" data-aos-delay="100">
                <div class="relative inline-block">
                    <img src="{{ $author->getAvatarUrl() }}" 
                         alt="{{ $author->name }}"
                         class="w-32 h-32 rounded-full border-4 border-primary/30 shadow-2xl mx-auto">
                    <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center border-4 border-dark">
                        <i class="fas fa-pen text-white text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Author Badge -->
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-lg rounded-full px-8 py-4 border border-primary/20 mb-8" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-user-edit text-primary text-xl"></i>
                <span class="text-sm font-semibold tracking-wider uppercase text-primary">Author</span>
            </div>
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white mb-8 leading-tight" data-aos="fade-up" data-aos-delay="300">
                {{ $author->name }}
            </h1>
            
            @if($author->bio)
                <p class="text-xl md:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed mb-8" data-aos="fade-up" data-aos-delay="400">
                    {{ $author->bio }}
                </p>
            @endif

            <!-- Author Meta -->
            <div class="flex flex-wrap items-center justify-center gap-8 text-gray-400 mb-8" data-aos="fade-up" data-aos-delay="500">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-newspaper text-primary"></i>
                    <span>{{ $posts->total() }} {{ Str::plural('Article', $posts->total()) }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-eye text-secondary"></i>
                    <span>{{ number_format($posts->sum('view_count')) }} Total Views</span>
                </div>
                @if($author->email)
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-envelope text-accent"></i>
                        <span>{{ $author->email }}</span>
                    </div>
                @endif
            </div>

            <!-- Social Links -->
            @if($author->getSocialLinks())
                <div class="flex items-center justify-center space-x-4" data-aos="fade-up" data-aos-delay="600">
                    @foreach($author->getSocialLinks() as $platform => $link)
                        <a href="{{ $link }}" 
                           target="_blank"
                           class="w-12 h-12 bg-white/10 hover:bg-primary/20 rounded-full flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300 hover:scale-110">
                            <i class="fab fa-{{ $platform }} text-lg"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Filter & Sort Section -->
<section class="py-8 bg-dark-light border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
            
            <!-- Search in Author's Posts -->
            <div class="w-full lg:w-96">
                <form action="{{ route('blog.author', $author->slug) }}" method="GET" class="relative">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search {{ $author->name }}'s articles..." 
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
                    <a href="{{ route('blog.author', array_merge(['author' => $author->slug], request()->except(['sort', 'page']))) }}" 
                       class="px-4 py-2 {{ !request('sort') || request('sort') === 'latest' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300">
                        Latest
                    </a>
                    <a href="{{ route('blog.author', array_merge(['author' => $author->slug, 'sort' => 'popular'], request()->except('page'))) }}" 
                       class="px-4 py-2 {{ request('sort') === 'popular' ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-lg font-medium transition-all duration-300">
                        Popular
                    </a>
                    <a href="{{ route('blog.author', array_merge(['author' => $author->slug, 'sort' => 'oldest'], request()->except('page'))) }}" 
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
                        Search results for "<span class="text-primary">{{ request('search') }}</span>" by {{ $author->name }}
                    @else
                        Articles by {{ $author->name }}
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
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <div class="flex items-center space-x-4 text-xs text-gray-400 mb-3">
                                    <span><i class="fas fa-calendar mr-1"></i> {{ $post->published_at->format('M d, Y') }}</span>
                                    <span><i class="fas fa-user mr-1"></i> {{ $author->name }}</span>
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
                    <i class="fas fa-user-edit text-4xl text-primary"></i>
                </div>
                <h3 class="text-2xl font-semibold text-white mb-4">
                    @if(request('search'))
                        No articles found for "{{ request('search') }}"
                    @else
                        No articles by {{ $author->name }} yet
                    @endif
                </h3>
                <p class="text-gray-400 mb-6 max-w-md mx-auto">
                    @if(request('search'))
                        Try different keywords or browse all articles by this author.
                    @else
                        {{ $author->name }} hasn't published any articles yet. Check back soon!
                    @endif
                </p>
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                    @if(request('search'))
                        <a href="{{ route('blog.author', $author->slug) }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-user mr-2"></i>
                            Browse All Articles by {{ $author->name }}
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

<!-- Author Stats & Info -->
@if($posts->count() > 0)
    <section class="py-16 bg-dark-light">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-12 border border-white/10" data-aos="fade-up">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Author Info -->
                    <div>
                        <h3 class="text-3xl font-black text-white mb-6">About {{ $author->name }}</h3>
                        @if($author->bio)
                            <p class="text-gray-300 mb-6 leading-relaxed">{{ $author->bio }}</p>
                        @endif
                        
                        @if($author->getSocialLinks())
                            <div class="flex space-x-4 mb-6">
                                @foreach($author->getSocialLinks() as $platform => $link)
                                    <a href="{{ $link }}" 
                                       target="_blank"
                                       class="w-10 h-10 bg-white/10 hover:bg-primary/20 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300">
                                        <i class="fab fa-{{ $platform }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        
                        @if($author->email)
                            <a href="mailto:{{ $author->email }}" 
                               class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-primary/20 to-secondary/20 text-white rounded-xl hover:from-primary/30 hover:to-secondary/30 transition-all duration-300">
                                <i class="fas fa-envelope"></i>
                                <span>Contact {{ $author->name }}</span>
                            </a>
                        @endif
                    </div>
                    
                    <!-- Author Stats -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center p-6 bg-gradient-to-br from-primary/10 to-primary/20 rounded-2xl">
                            <div class="text-3xl font-black text-primary mb-2">{{ $posts->total() }}</div>
                            <div class="text-gray-300 text-sm">{{ Str::plural('Article', $posts->total()) }}</div>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-secondary/10 to-secondary/20 rounded-2xl">
                            <div class="text-3xl font-black text-secondary mb-2">{{ number_format($posts->sum('view_count')) }}</div>
                            <div class="text-gray-300 text-sm">Total Views</div>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-accent/10 to-accent/20 rounded-2xl">
                            <div class="text-3xl font-black text-accent mb-2">{{ number_format($posts->sum('like_count')) }}</div>
                            <div class="text-gray-300 text-sm">Total Likes</div>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-green-500/10 to-green-500/20 rounded-2xl">
                            <div class="text-3xl font-black text-green-400 mb-2">{{ $posts->where('is_featured', true)->count() }}</div>
                            <div class="text-gray-300 text-sm">Featured</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- Other Authors -->
<section class="py-16 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-white mb-4">Other Authors</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary rounded-full mx-auto"></div>
        </div>

        @php
            $otherAuthors = \App\Models\BlogAuthor::active()
                ->where('id', '!=', $author->id)
                ->withCount('activePosts')
                ->having('active_posts_count', '>', 0)
                ->orderBy('active_posts_count', 'desc')
                ->limit(4)
                ->get();
        @endphp
        
        @if($otherAuthors->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($otherAuthors as $index => $otherAuthor)
<a href="{{ route('blog.author', $otherAuthor->slug) }}" 
                       class="group block text-center p-6 bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl border border-white/10 hover:border-primary/30 transition-all duration-500 hover:transform hover:scale-105"
                       data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="relative inline-block mb-4">
                            <img src="{{ $otherAuthor->getAvatarUrl() }}" 
                                 alt="{{ $otherAuthor->name }}"
                                 class="w-16 h-16 rounded-full border-2 border-primary/30 group-hover:border-primary/60 transition-colors duration-300">
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                                <i class="fas fa-pen text-white text-xs"></i>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-white group-hover:text-primary transition-colors duration-300 mb-2">
                            {{ $otherAuthor->name }}
                        </h3>
                        <p class="text-sm text-gray-400 mb-3">{{ $otherAuthor->active_posts_count }} {{ Str::plural('article', $otherAuthor->active_posts_count) }}</p>
                        @if($otherAuthor->bio)
                            <p class="text-xs text-gray-500 line-clamp-2">{{ Str::limit($otherAuthor->bio, 80) }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center" data-aos="fade-up">
                <p class="text-gray-400">No other authors found.</p>
            </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchForm = document.querySelector('form[action*="author"]');
    if (searchForm) {
        const searchInput = searchForm.querySelector('input[name="search"]');
        searchInput?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchForm.submit();
            }
        });
    }
    
    // Social links hover effects
    const socialLinks = document.querySelectorAll('a[href*="twitter.com"], a[href*="facebook.com"], a[href*="linkedin.com"], a[href*="instagram.com"]');
    socialLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1) rotate(5deg)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    });
});
</script>
@endpush