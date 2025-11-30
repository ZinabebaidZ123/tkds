@extends('layouts.app')

@section('title', $post->meta_title ?: $post->title . ' - TKDS Media')
@section('meta_description', $post->meta_description ?: $post->getExcerpt(160))

@push('styles')
<style>
/* Enhanced Article Content Styling with Red Theme */
.article-content {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    line-height: 1.8;
    color: #e5e7eb;
    max-width: none;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    color: #ffffff;
    font-weight: 700;
    margin: 2rem 0 1rem;
    line-height: 1.3;
    scroll-margin-top: 100px;
}

.article-content h1 {
    font-size: 2.5rem;
    margin: 3rem 0 1.5rem;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.article-content h2 {
    font-size: 2rem;
    margin: 2.5rem 0 1.25rem;
    border-bottom: 2px solid rgba(239, 68, 68, 0.4);
    padding-bottom: 0.5rem;
    color: #f87171;
}

.article-content h3 {
    font-size: 1.75rem;
    margin: 2rem 0 1rem;
    color: #d60c00;
}

.article-content h4 {
    font-size: 1.5rem;
    margin: 1.75rem 0 0.875rem;
    color: #fecaca;
}

.article-content h5 {
    font-size: 1.25rem;
    margin: 1.5rem 0 0.75rem;
    color: #fed7d7;
}

.article-content h6 {
    font-size: 1.125rem;
    margin: 1.25rem 0 0.625rem;
    color: #fee2e2;
}

.article-content p {
    margin: 1.5rem 0;
    font-size: 1.125rem;
    line-height: 1.8;
    color: #d1d5db;
}

.article-content strong,
.article-content b {
    font-weight: 700;
    color: #ffffff;
}

.article-content em,
.article-content i {
    font-style: italic;
    color: #f3f4f6;
}

.article-content a {
    color: #60a5fa;
    text-decoration: none;
    font-weight: 500;
    border-bottom: 1px solid rgba(96, 165, 250, 0.3);
    transition: all 0.3s ease;
}

.article-content a:hover {
    color: #93c5fd;
    border-bottom-color: #93c5fd;
    background: rgba(96, 165, 250, 0.1);
    padding: 2px 4px;
    border-radius: 4px;
}

/* Lists Styling with Red Theme */
.article-content ul,
.article-content ol {
    margin: 1.5rem 0;
    padding-left: 2rem;
    color: #d1d5db;
}

.article-content ul {
    list-style: none;
}

.article-content ul li {
    position: relative;
    margin: 0.75rem 0;
    padding-left: 1.5rem;
}

.article-content ul li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0.75rem;
    width: 6px;
    height: 6px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border-radius: 50%;
    transform: translateY(-50%);
}

.article-content ol {
    list-style: none;
    counter-reset: item;
}

.article-content ol li {
    margin: 0.75rem 0;
    padding-left: 1.5rem;
    position: relative;
    counter-increment: item;
}

.article-content ol li::before {
    content: counter(item);
    position: absolute;
    left: 0;
    top: 0;
    width: 1.25rem;
    height: 1.25rem;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border-radius: 50%;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: translateY(0.125rem);
}

.article-content ul ul,
.article-content ol ol,
.article-content ul ol,
.article-content ol ul {
    margin: 0.5rem 0;
    padding-left: 1.5rem;
}

.article-content li p {
    margin: 0.5rem 0;
    display: inline;
}

/* Nested lists with different red shades */
.article-content ul ul li::before {
    background: linear-gradient(135deg, #f87171, #ef4444);
}

.article-content ul ul ul li::before {
    background: linear-gradient(135deg, #fca5a5, #f87171);
}

.article-content ol ol li::before {
    background: linear-gradient(135deg, #f87171, #ef4444);
}

.article-content ol ol ol li::before {
    background: linear-gradient(135deg, #fca5a5, #f87171);
}

/* Blockquotes with Red Theme */
.article-content blockquote {
    margin: 2rem 0;
    padding: 1.5rem 2rem;
    border-left: 4px solid #ef4444;
    background: rgba(239, 68, 68, 0.05);
    border-radius: 0 8px 8px 0;
    font-style: italic;
    color: #f3f4f6;
    position: relative;
}

.article-content blockquote::before {
    content: '"';
    font-size: 4rem;
    color: rgba(239, 68, 68, 0.3);
    position: absolute;
    top: -0.5rem;
    left: 1rem;
    font-family: serif;
}

.article-content blockquote p {
    margin: 0.5rem 0;
    font-size: 1.125rem;
    line-height: 1.7;
}

.article-content blockquote cite {
    display: block;
    margin-top: 1rem;
    font-size: 0.9rem;
    color: #9ca3af;
    font-style: normal;
}

/* Code Blocks */
.article-content code {
    background: rgba(255, 255, 255, 0.1);
    color: #fbbf24;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-family: 'Fira Code', 'Monaco', 'Menlo', monospace;
    font-size: 0.9em;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.article-content pre {
    background: #1f2937;
    color: #f9fafb;
    padding: 1.5rem;
    border-radius: 8px;
    overflow-x: auto;
    margin: 1.5rem 0;
    border: 1px solid rgba(239, 68, 68, 0.2);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.article-content pre code {
    background: none;
    color: inherit;
    padding: 0;
    border-radius: 0;
    border: none;
}

/* Tables with Red Theme */
.article-content table {
    width: 100%;
    margin: 2rem 0;
    border-collapse: collapse;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.article-content th,
.article-content td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.article-content th {
    background: rgba(239, 68, 68, 0.1);
    font-weight: 700;
    color: #ffffff;
    border-bottom: 2px solid rgba(239, 68, 68, 0.3);
}

.article-content tr:hover {
    background: rgba(239, 68, 68, 0.05);
}

/* Horizontal Rules with Red Theme */
.article-content hr {
    border: none;
    height: 2px;
    background: linear-gradient(to right, transparent, #ef4444, transparent);
    margin: 3rem auto;
    border-radius: 2px;
}

/* Images in Content */
.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem auto;
    display: block;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease;
    border: 1px solid rgba(239, 68, 68, 0.1);
}

.article-content img:hover {
    transform: scale(1.02);
    border-color: rgba(239, 68, 68, 0.3);
}

/* Figure and Figcaption */
.article-content figure {
    margin: 2rem 0;
    text-align: center;
}

.article-content figcaption {
    margin-top: 0.5rem;
    font-size: 0.9rem;
    color: #9ca3af;
    font-style: italic;
}

/* Text Alignment Classes */
.article-content .text-center { text-align: center; }
.article-content .text-left { text-align: left; }
.article-content .text-right { text-align: right; }
.article-content .text-justify { text-align: justify; }

/* Responsive Typography */
@media (max-width: 768px) {
    .article-content {
        font-size: 1rem;
        line-height: 1.7;
    }
    
    .article-content h1 { 
        font-size: 1.75rem;
        margin: 2rem 0 1rem;
    }
    .article-content h2 { 
        font-size: 1.5rem;
        margin: 1.75rem 0 1rem;
    }
    .article-content h3 { 
        font-size: 1.375rem;
        margin: 1.5rem 0 0.875rem;
    }
    .article-content h4 { 
        font-size: 1.25rem;
        margin: 1.25rem 0 0.75rem;
    }
    .article-content h5 { 
        font-size: 1.125rem;
        margin: 1.125rem 0 0.625rem;
    }
    .article-content h6 { 
        font-size: 1rem;
        margin: 1rem 0 0.5rem;
    }
    
    .article-content p {
        font-size: 1rem;
        margin: 1.25rem 0;
    }
    
    .article-content ul,
    .article-content ol {
        padding-left: 1.5rem;
        margin: 1.25rem 0;
    }
    
    .article-content ul li,
    .article-content ol li {
        padding-left: 1.25rem;
        margin: 0.5rem 0;
    }
    
    .article-content blockquote {
        margin: 1.5rem 0;
        padding: 1rem 1.5rem;
        font-size: 1rem;
    }
    
    .article-content table {
        font-size: 0.875rem;
        overflow-x: auto;
        display: block;
        white-space: nowrap;
    }
    
    .article-content th,
    .article-content td {
        padding: 0.75rem 0.5rem;
        min-width: 120px;
    }
    
    .article-content pre {
        padding: 1rem;
        font-size: 0.875rem;
        overflow-x: auto;
    }
    
    .article-content code {
        font-size: 0.8rem;
        padding: 0.2rem 0.4rem;
    }
}

@media (max-width: 480px) {
    .article-content {
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    .article-content h1 { font-size: 1.5rem; }
    .article-content h2 { font-size: 1.375rem; }
    .article-content h3 { font-size: 1.25rem; }
    .article-content h4 { font-size: 1.125rem; }
    .article-content h5 { font-size: 1rem; }
    .article-content h6 { font-size: 0.95rem; }
    
    .article-content ul,
    .article-content ol {
        padding-left: 1.25rem;
    }
    
    .article-content ul li,
    .article-content ol li {
        padding-left: 1rem;
    }
    
    .article-content blockquote {
        padding: 0.875rem 1.25rem;
        margin: 1.25rem 0;
    }
}

/* Content Container */
.content-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 0;
}

@media (min-width: 1024px) {
    .content-container {
        max-width: 900px;
    }
}

@media (max-width: 768px) {
    .content-container {
        max-width: 100%;
        padding: 0 1rem;
    }
}

/* Selection styling with Red Theme */
.article-content ::selection {
    background: rgba(239, 68, 68, 0.3);
    color: #ffffff;
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Print styles */
@media print {
    .article-content {
        color: #000;
        background: #fff;
        font-size: 12pt;
        line-height: 1.5;
    }
    
    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4,
    .article-content h5,
    .article-content h6 {
        color: #000;
        page-break-after: avoid;
    }
    
    .article-content blockquote {
        border-left: 2px solid #000;
        background: #f5f5f5;
    }
    
    .article-content a {
        color: #000;
        text-decoration: underline;
    }
}

/* Additional Red Theme Elements */
.article-content mark {
    background: rgba(239, 68, 68, 0.2);
    color: #ffffff;
    padding: 0.125rem 0.25rem;
    border-radius: 3px;
}

.article-content kbd {
    background: #1f2937;
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 4px;
    padding: 0.125rem 0.375rem;
    font-family: 'Fira Code', monospace;
    font-size: 0.875rem;
    color: #ef4444;
}

.article-content details {
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 8px;
    padding: 1rem;
    margin: 1.5rem 0;
    background: rgba(239, 68, 68, 0.05);
}

.article-content summary {
    font-weight: 600;
    color: #ef4444;
    cursor: pointer;
    margin-bottom: 0.5rem;
}

.article-content summary:hover {
    color: #dc2626;
}
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="relative py-32 bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden mt-20">
    <div class="absolute inset-0 opacity-30">
        <img src="{{ $post->getFeaturedImageUrl() }}" 
             alt="{{ $post->title }}"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-400 mb-8" data-aos="fade-up">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors duration-300">Home</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('blog.index') }}" class="hover:text-primary transition-colors duration-300">Blog</a>
            @if($post->category)
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('blog.category', $post->category->slug) }}" 
                   class="hover:text-primary transition-colors duration-300">{{ $post->category->name }}</a>
            @endif
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-300">{{ Str::limit($post->title, 30) }}</span>
        </nav>

        <!-- Category Badge -->
        @if($post->category)
            <div class="mb-6" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('blog.category', $post->category->slug) }}"
                   class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold hover:scale-105 transition-transform duration-300" 
                   style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                    <i class="{{ $post->category->icon }} mr-2"></i>
                    {{ $post->category->name }}
                </a>
            </div>
        @endif

        <!-- Title -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight" data-aos="fade-up" data-aos-delay="200">
            {{ $post->title }}
        </h1>

        <!-- Excerpt -->
        @if($post->excerpt)
            <p class="text-xl text-gray-300 mb-8 leading-relaxed" data-aos="fade-up" data-aos-delay="300">
                {{ $post->excerpt }}
            </p>
        @endif

        <!-- Meta Info -->
        <div class="flex flex-wrap items-center gap-6 text-gray-400 mb-6" data-aos="fade-up" data-aos-delay="400">
            @if($post->author)
                <div class="flex items-center space-x-3">
                    <img src="{{ $post->author->getAvatarUrl() }}" 
                         alt="{{ $post->author->name }}"
                         class="w-12 h-12 rounded-full border-2 border-primary/30">
                    <div>
                        <div class="text-white font-semibold">{{ $post->author->name }}</div>
                        <div class="text-sm">Author</div>
                    </div>
                </div>
            @endif
            <div class="flex items-center space-x-6">
                <span><i class="fas fa-calendar mr-2"></i>{{ $post->published_at->format('M d, Y') }}</span>
                <span><i class="fas fa-clock mr-2"></i>{{ $post->getReadingTime() }}</span>
                <span><i class="fas fa-eye mr-2"></i>{{ number_format($post->view_count) }} views</span>
            </div>
        </div>

        <!-- Enhanced Social Stats & Actions -->
        <div class="flex flex-wrap items-center gap-4 mb-6" data-aos="fade-up" data-aos-delay="500">
            <!-- Like Button -->
            <button class="like-btn flex items-center space-x-2 px-4 py-2 bg-white/10 hover:bg-red-500/20 text-gray-300 hover:text-red-400 rounded-xl transition-all duration-300 hover:scale-105" 
                    data-post-id="{{ $post->id }}">
                <i class="fas fa-heart"></i>
                <span class="like-count font-semibold">{{ number_format($post->like_count) }}</span>
                <span class="text-sm">Likes</span>
            </button>

            <!-- Share Dropdown -->
            <div class="relative share-dropdown">
                <button class="share-toggle flex items-center space-x-2 px-4 py-2 bg-white/10 hover:bg-blue-500/20 text-gray-300 hover:text-blue-400 rounded-xl transition-all duration-300 hover:scale-105">
                    <i class="fas fa-share"></i>
                    <span class="share-count font-semibold">{{ number_format($post->share_count) }}</span>
                    <span class="text-sm">Shares</span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                
                <div class="share-menu absolute top-full left-0 mt-2 bg-dark-light border border-white/20 rounded-xl shadow-xl opacity-0 invisible transform translate-y-2 transition-all duration-300 z-50">
                    <div class="p-2 space-y-1">
                        <button class="share-btn w-full flex items-center space-x-3 px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-colors duration-300" 
                                data-platform="twitter" 
                                data-url="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}">
                            <i class="fab fa-twitter text-blue-400"></i>
                            <span>Twitter</span>
                        </button>
                        <button class="share-btn w-full flex items-center space-x-3 px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-colors duration-300" 
                                data-platform="facebook" 
                                data-url="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}">
                            <i class="fab fa-facebook text-blue-600"></i>
                            <span>Facebook</span>
                        </button>
                        <button class="share-btn w-full flex items-center space-x-3 px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-colors duration-300" 
                                data-platform="linkedin" 
                                data-url="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}">
                            <i class="fab fa-linkedin text-blue-700"></i>
                            <span>LinkedIn</span>
                        </button>
                        <button class="share-btn w-full flex items-center space-x-3 px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-colors duration-300" 
                                data-platform="whatsapp" 
                                data-url="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}">
                            <i class="fab fa-whatsapp text-green-500"></i>
                            <span>WhatsApp</span>
                        </button>
                        <button class="copy-link-btn w-full flex items-center space-x-3 px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-colors duration-300" 
                                data-url="{{ request()->url() }}">
                            <i class="fas fa-copy text-gray-400"></i>
                            <span>Copy Link</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Additional Stats -->
            <div class="flex items-center space-x-4 text-gray-400">
                @if($post->is_featured)
                    <span class="flex items-center space-x-1 px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm">
                        <i class="fas fa-star"></i>
                        <span>Featured</span>
                    </span>
                @endif
                @if($post->is_trending)
                    <span class="flex items-center space-x-1 px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm">
                        <i class="fas fa-fire"></i>
                        <span>Trending</span>
                    </span>
                @endif
            </div>
        </div>

        <!-- Tags -->
        @if($post->tags->count() > 0)
            <div class="flex flex-wrap gap-2" data-aos="fade-up" data-aos-delay="600">
                @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag->slug) }}" 
                       class="px-3 py-1 bg-white/10 hover:bg-primary/20 text-gray-300 hover:text-white text-sm rounded-full transition-colors duration-300">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Article Content -->
<section class="bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Featured Image -->
        @if($post->featured_image)
            <div class="content-container mb-12" data-aos="fade-up">
                <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                    <img src="{{ $post->getFeaturedImageUrl() }}" 
                         alt="{{ $post->featured_image_alt ?: $post->title }}"
                         class="w-full h-auto">
                    @if($post->featured_image_alt)
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white text-sm">{{ $post->featured_image_alt }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Article Body -->
        <div class="content-container">
            <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden mb-12" data-aos="fade-up" data-aos-delay="200">
                <article class="article-content p-6 sm:p-8 lg:p-12">
                    {!! $post->content !!}
                </article>
            </div>
        </div>

        <!-- Gallery -->
        @if($post->gallery && count($post->getGalleryImages()) > 0)
            <div class="content-container mb-12" data-aos="fade-up">
                <h3 class="text-2xl font-bold text-white mb-6">Gallery</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($post->getGalleryImages() as $index => $image)
                        <div class="relative overflow-hidden rounded-xl hover:scale-105 transition-transform duration-300 cursor-pointer gallery-item">
                            <img src="{{ $image }}" 
                                 alt="Gallery image {{ $index + 1 }}"
                                 class="w-full h-48 object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <i class="fas fa-expand text-white text-2xl"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Media Files -->
        @if($post->media->count() > 0)
            <div class="content-container mb-12" data-aos="fade-up">
                <h3 class="text-2xl font-bold text-white mb-6">Downloads & Resources</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($post->media as $media)
                        <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-xl p-6 border border-white/10 hover:border-primary/30 transition-colors duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center">
                                    <i class="fas fa-{{ $media->isImage() ? 'image' : ($media->isVideo() ? 'video' : 'file') }} text-white"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-semibold truncate">{{ $media->file_name }}</h4>
                                    <p class="text-gray-400 text-sm">{{ $media->getFileSizeFormatted() }}</p>
                                    @if($media->caption)
                                        <p class="text-gray-300 text-xs mt-1">{{ $media->caption }}</p>
                                    @endif
                                </div>
                                <a href="{{ $media->getFileUrl() }}" 
                                   download
                                   class="px-4 py-2 bg-primary hover:bg-secondary text-white rounded-lg transition-colors duration-300 hover:scale-105 transform">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Enhanced Social Share Section -->
        <div class="content-container mb-12 pt-8 border-t border-white/10" data-aos="fade-up">
            <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                <h3 class="text-2xl font-bold text-white mb-6 text-center">Share this article</h3>
                
                <div class="flex flex-wrap justify-center gap-4 mb-6">
                    <button class="share-btn group flex items-center space-x-3 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-300 hover:scale-105" 
                            data-platform="twitter" 
                            data-url="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}">
                        <i class="fab fa-twitter text-xl"></i>
                        <span class="font-semibold">Twitter</span>
                    </button>
                    
                    <button class="share-btn group flex items-center space-x-3 px-6 py-3 bg-blue-800 hover:bg-blue-900 text-white rounded-xl transition-all duration-300 hover:scale-105" 
                            data-platform="facebook" 
                            data-url="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}">
                        <i class="fab fa-facebook text-xl"></i>
                        <span class="font-semibold">Facebook</span>
                    </button>
                    
                    <button class="share-btn group flex items-center space-x-3 px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-xl transition-all duration-300 hover:scale-105" 
                            data-platform="linkedin" 
                            data-url="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}">
                        <i class="fab fa-linkedin text-xl"></i>
                        <span class="font-semibold">LinkedIn</span>
                    </button>
                    
                    <button class="share-btn group flex items-center space-x-3 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-all duration-300 hover:scale-105" 
                            data-platform="whatsapp" 
                            data-url="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}">
                        <i class="fab fa-whatsapp text-xl"></i>
                        <span class="font-semibold">WhatsApp</span>
                    </button>
                    
                    <button class="copy-link-btn group flex items-center space-x-3 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-all duration-300 hover:scale-105" 
                            data-url="{{ request()->url() }}">
                        <i class="fas fa-copy text-xl"></i>
                        <span class="font-semibold">Copy Link</span>
                    </button>
                </div>

                <!-- Share Counter -->
                <div class="text-center">
                    <p class="text-gray-400 text-sm">
                        This article has been shared <span class="share-count text-primary font-bold">{{ number_format($post->share_count) }}</span> times
                    </p>
                </div>
            </div>
        </div>

        <!-- Author Bio -->
        @if($post->author && $post->author->bio)
            <div class="content-container mb-12 pt-8 border-t border-white/10" data-aos="fade-up">
                <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                    <div class="flex items-start space-x-6">
                        <img src="{{ $post->author->getAvatarUrl() }}" 
                             alt="{{ $post->author->name }}"
                             class="w-20 h-20 rounded-full border-2 border-primary/30">
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-white mb-3">About {{ $post->author->name }}</h3>
                            <p class="text-gray-300 mb-4 leading-relaxed">{{ $post->author->bio }}</p>
                            
                            @if($post->author->email)
                                <div class="mb-4">
                                    <a href="mailto:{{ $post->author->email }}" 
                                       class="inline-flex items-center space-x-2 text-primary hover:text-white transition-colors duration-300">
                                        <i class="fas fa-envelope"></i>
                                        <span>{{ $post->author->email }}</span>
                                    </a>
                                </div>
                            @endif
                            
                            @if($post->author->getSocialLinks())
                                <div class="flex space-x-4">
                                    @foreach($post->author->getSocialLinks() as $platform => $link)
                                        <a href="{{ $link }}" 
                                           target="_blank"
                                           class="w-10 h-10 bg-white/10 hover:bg-primary/20 rounded-lg flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300 hover:scale-110">
                                            <i class="fab fa-{{ $platform }} text-lg"></i>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Related Posts -->
@if($relatedPosts && $relatedPosts->count() > 0)
    <section class="py-20 bg-dark-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Related Articles</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary rounded-full mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-{{ min(3, $relatedPosts->count()) }} gap-8">
                @foreach($relatedPosts as $index => $relatedPost)
                    <article class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-primary/40 transition-all duration-500 hover:transform hover:-translate-y-2">
                            
                            <!-- Featured Image -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $relatedPost->getFeaturedImageUrl() }}" 
                                     alt="{{ $relatedPost->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                
                                @if($relatedPost->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold" 
                                              style="background-color: {{ $relatedPost->category->color }}90; color: white;">
                                            <i class="{{ $relatedPost->category->icon }} mr-1"></i>
                                            {{ $relatedPost->category->name }}
                                        </span>
                                    </div>
                                @endif
                                
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm">
                                        {{ $relatedPost->getReadingTime() }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <div class="text-xs text-gray-400 mb-3">
                                    {{ $relatedPost->published_at->format('M d, Y') }}
                                </div>
                                
                                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300 leading-tight">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                                </h3>
                                
                                <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                                    {{ $relatedPost->getExcerpt(100) }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}" 
                                       class="inline-flex items-center text-primary hover:text-white font-semibold transition-colors duration-300 group/link">
                                        <span>Read More</span>
                                        <i class="fas fa-chevron-right ml-2 text-xs group-hover/link:translate-x-1 transition-transform duration-300"></i>
                                    </a>
                                    
                                    <div class="flex items-center space-x-3 text-xs text-gray-400">
                                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($relatedPost->view_count) }}</span>
                                        <span><i class="fas fa-heart mr-1"></i>{{ number_format($relatedPost->like_count) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Navigation -->
@if($nextPost || $previousPost)
    <section class="py-12 bg-dark border-t border-white/10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8">
                
                <!-- Previous Post -->
                @if($previousPost)
                    <a href="{{ route('blog.show', $previousPost->slug) }}" 
                       class="group flex items-center space-x-4 p-6 bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-xl border border-white/10 hover:border-primary/30 transition-all duration-300"
                       data-aos="fade-right">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-xl flex items-center justify-center group-hover:from-primary/30 group-hover:to-secondary/30 transition-all duration-300">
                            <i class="fas fa-chevron-left text-primary"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs text-gray-400 mb-1">Previous Article</div>
                            <h4 class="text-white font-semibold group-hover:text-primary transition-colors duration-300 truncate">
                                {{ $previousPost->title }}
                            </h4>
                        </div>
                    </a>
                @endif
                
                <!-- Next Post -->
                @if($nextPost)
                    <a href="{{ route('blog.show', $nextPost->slug) }}" 
                       class="group flex items-center space-x-4 p-6 bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-xl border border-white/10 hover:border-primary/30 transition-all duration-300 {{ !$previousPost ? 'md:col-start-2' : '' }}"
                       data-aos="fade-left">
                        <div class="flex-1 min-w-0 text-right">
                            <div class="text-xs text-gray-400 mb-1">Next Article</div>
                            <h4 class="text-white font-semibold group-hover:text-primary transition-colors duration-300 truncate">
                                {{ $nextPost->title }}
                            </h4>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-xl flex items-center justify-center group-hover:from-primary/30 group-hover:to-secondary/30 transition-all duration-300">
                            <i class="fas fa-chevron-right text-primary"></i>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </section>
@endif

<!-- Floating Action Buttons -->
<div class="fixed right-6 bottom-6 flex flex-col space-y-3 z-40" id="floating-actions">
    <!-- Scroll to Top -->
    <button id="scroll-top" class="w-12 h-12 bg-primary hover:bg-secondary text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Quick Like -->
    <button class="like-btn w-12 h-12 bg-red-500/20 hover:bg-red-500 text-red-400 hover:text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110" 
            data-post-id="{{ $post->id }}">
        <i class="fas fa-heart"></i>
    </button>
    
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Blog show page loaded');
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }
    
    const token = csrfToken.getAttribute('content');
    console.log('CSRF Token found');
    
    // Like functionality - FIXED
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;
            console.log('Like clicked for post:', postId);
            
            if (!postId) {
                console.error('Post ID not found');
                return;
            }
            
            // Show loading state
            const originalHtml = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            fetch(`/blog/post/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
                })
            .then(response => {
                console.log('Like response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Like success:', data);
                
                // Reset button
                this.disabled = false;
                this.innerHTML = originalHtml;
                
                if (data.success) {
                    // Update like count everywhere
                    document.querySelectorAll('.like-count').forEach(span => {
                        span.textContent = Number(data.like_count).toLocaleString();
                    });
                    
                    // Visual feedback
                    this.classList.add('text-red-400');
                    this.style.transform = 'scale(1.1)';
                    
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 300);
                    
                    showNotification('Thank you for liking this article!', 'success');
                } else {
                    showNotification(data.message || 'Already liked', 'info');
                }
            })
            .catch(error => {
                console.error('Like error:', error);
                
                // Reset button
                this.disabled = false;
                this.innerHTML = originalHtml;
                
                showNotification('Error liking post. Please try again.', 'error');
            });
        });
    });
    
    // Share functionality - FIXED
    document.querySelectorAll('.share-btn').forEach(button => {
        button.addEventListener('click', function() {
            const platform = this.dataset.platform;
            const url = this.dataset.url;
            const postId = document.querySelector('.like-btn')?.dataset.postId;
            
            console.log('Share clicked:', platform, 'Post ID:', postId);
            
            // Record share if we have post ID
            if (postId) {
                fetch(`/blog/post/${postId}/share`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ platform: platform })
                })
                .then(response => {
                    console.log('Share response status:', response.status);
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then(data => {
                    console.log('Share success:', data);
                    
                    if (data.success) {
                        // Update share counts everywhere
                        document.querySelectorAll('.share-count').forEach(span => {
                            span.textContent = Number(data.share_count).toLocaleString();
                        });
                        
                        showNotification('Thanks for sharing!', 'success');
                    }
                })
                .catch(error => {
                    console.error('Share recording error:', error);
                });
            }
            
            // Open share window
            if (url) {
                const width = 600;
                const height = 400;
                const left = (window.innerWidth - width) / 2;
                const top = (window.innerHeight - height) / 2;
                
                window.open(url, 'share', `width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes`);
            }
        });
    });
    
    // Copy link functionality
    document.querySelectorAll('.copy-link-btn').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.dataset.url || window.location.href;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    showNotification('Link copied to clipboard!', 'success');
                    
                    // Visual feedback
                    const icon = this.querySelector('i');
                    if (icon) {
                        const originalClass = icon.className;
                        icon.className = 'fas fa-check text-green-400';
                        
                        setTimeout(() => {
                            icon.className = originalClass;
                        }, 2000);
                    }
                }).catch(() => {
                    fallbackCopyText(url);
                });
            } else {
                fallbackCopyText(url);
            }
        });
    });
    
    // Fallback copy function
    function fallbackCopyText(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showNotification('Link copied to clipboard!', 'success');
        } catch (err) {
            console.error('Fallback copy failed:', err);
            showNotification('Could not copy link. Please copy manually.', 'error');
        }
        
        document.body.removeChild(textArea);
    }
    
    // Share dropdown functionality
    document.querySelectorAll('.share-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.closest('.share-dropdown');
            if (dropdown) {
                const menu = dropdown.querySelector('.share-menu');
                if (menu) {
                    menu.classList.toggle('opacity-0');
                    menu.classList.toggle('invisible');
                    menu.classList.toggle('translate-y-2');
                }
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.share-menu').forEach(menu => {
            menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
        });
    });
    
    // Simple gallery lightbox
    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', function() {
            const img = this.querySelector('img');
            if (!img) return;
            
            const lightbox = document.createElement('div');
            lightbox.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4';
            lightbox.innerHTML = `
                <div class="relative max-w-4xl max-h-full">
                    <img src="${img.src}" alt="${img.alt}" class="max-w-full max-h-full object-contain">
                    <button class="absolute top-4 right-4 text-white text-2xl hover:text-red-400 transition-colors duration-300 w-10 h-10 bg-black bg-opacity-50 rounded-full flex items-center justify-center">
                        ×
                    </button>
                </div>
            `;
            
            document.body.appendChild(lightbox);
            document.body.style.overflow = 'hidden';
            
            // Close lightbox
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox || e.target.tagName === 'BUTTON') {
                    document.body.removeChild(lightbox);
                    document.body.style.overflow = 'auto';
                }
            });
        });
    });
    
    // Scroll to top
    const scrollTopBtn = document.getElementById('scroll-top');
    if (scrollTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.remove('opacity-0', 'invisible');
            } else {
                scrollTopBtn.classList.add('opacity-0', 'invisible');
            }
        });
        
        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});

// Simple notification function
function showNotification(message, type = 'success') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(n => n.remove());
    
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white max-w-sm`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
            <span>${message}</span>
            <button class="ml-4 text-white hover:text-gray-200 text-lg" onclick="this.parentElement.parentElement.remove()">
                ×
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        if (document.body.contains(notification)) {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }
    }, 5000);
}
</script>
@endpush