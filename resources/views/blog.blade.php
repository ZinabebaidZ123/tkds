@extends('layouts.app')

@section('title', 'TKDS Media - Broadcasting Industry Blog & Insights')
@section('meta_description', 'Stay updated with the latest broadcasting trends, industry insights, and expert tips.')

@section('content')

<!-- Hero Section -->
<section class="relative py-32 bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden mt-20">
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
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white mb-8 leading-tight">
                Broadcasting 
                <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">Blog</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed mb-12">
                Expert insights and professional tips from the world of 
                <span class="text-primary font-semibold">digital broadcasting</span>
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto relative" data-aos="fade-up" data-aos-delay="200">
                <div class="relative">
                    <input type="text" id="blogSearchInput" placeholder="Search articles..." 
                           class="w-full px-6 py-4 pl-14 pr-20 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300">
                    <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-8 bg-dark-light border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-center gap-3">
            @php
                $categories = [
                    ['all', 'All Articles', 'active'],
                    ['technology', 'Technology', ''],
                    ['tutorials', 'Tutorials', ''],
                    ['industry', 'Industry News', ''],
                    ['tips', 'Pro Tips', ''],
                    ['reviews', 'Reviews', '']
                ];
            @endphp
            
            @foreach($categories as $category)
                <button class="blog-category-btn {{ $category[2] }} px-6 py-3 {{ $category[2] ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-300 hover:bg-primary/20 hover:text-white' }} rounded-xl font-semibold transition-all duration-300" data-category="{{ $category[0] }}">
                    {{ $category[1] }}
                </button>
            @endforeach
        </div>
    </div>
</section>

<!-- Blog Articles Grid -->
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Latest Articles</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary rounded-full mx-auto"></div>
        </div>

        <!-- Articles Grid -->
        <div id="blogArticlesGrid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $articles = [
                    [
                        'title' => 'Building Your Perfect Home Studio',
                        'category' => 'tutorials',
                        'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&h=300&fit=crop',
                        'excerpt' => 'Essential equipment and setup strategies for broadcast-quality content.',
                        'author' => 'Sarah Johnson',
                        'date' => 'Dec 12, 2024',
                        'readTime' => '5 min',
                        'views' => '2.3k',
                        'categoryColor' => 'secondary',
                        'categoryIcon' => 'graduation-cap'
                    ],
                    [
                        'title' => '5G Revolution in Live Streaming',
                        'category' => 'technology',
                        'image' => 'https://images.unsplash.com/photo-1551818255-e6e10975bc17?w=500&h=300&fit=crop',
                        'excerpt' => 'How 5G networks are transforming broadcasting capabilities.',
                        'author' => 'Ahmed Hassan',
                        'date' => 'Dec 10, 2024',
                        'readTime' => '7 min',
                        'views' => '4.1k',
                        'categoryColor' => 'primary',
                        'categoryIcon' => 'bolt'
                    ],
                    [
                        'title' => 'Mastering Viewer Analytics',
                        'category' => 'tips',
                        'image' => 'https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=500&h=300&fit=crop',
                        'excerpt' => 'Key metrics every broadcaster should monitor for growth.',
                        'author' => 'Mike Chen',
                        'date' => 'Dec 8, 2024',
                        'readTime' => '6 min',
                        'views' => '1.8k',
                        'categoryColor' => 'accent',
                        'categoryIcon' => 'chart-bar'
                    ],
                    [
                        'title' => 'Best Cameras for Streaming 2024',
                        'category' => 'reviews',
                        'image' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=500&h=300&fit=crop',
                        'excerpt' => 'Comprehensive review of top broadcasting cameras.',
                        'author' => 'Lisa Parker',
                        'date' => 'Dec 6, 2024',
                        'readTime' => '8 min',
                        'views' => '3.2k',
                        'categoryColor' => 'primary',
                        'categoryIcon' => 'star'
                    ],
                    [
                        'title' => 'Audio Setup for Professionals',
                        'category' => 'tutorials',
                        'image' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?w=500&h=300&fit=crop',
                        'excerpt' => 'Complete guide to professional audio equipment.',
                        'author' => 'David Wilson',
                        'date' => 'Dec 4, 2024',
                        'readTime' => '4 min',
                        'views' => '1.5k',
                        'categoryColor' => 'secondary',
                        'categoryIcon' => 'microphone'
                    ],
                    [
                        'title' => 'Industry Trends 2025',
                        'category' => 'industry',
                        'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&h=300&fit=crop',
                        'excerpt' => 'What to expect in the broadcasting industry next year.',
                        'author' => 'Emma Davis',
                        'date' => 'Dec 2, 2024',
                        'readTime' => '9 min',
                        'views' => '5.7k',
                        'categoryColor' => 'accent',
                        'categoryIcon' => 'trending-up'
                    ]
                ];
            @endphp
            
            @foreach($articles as $index => $article)
                <article class="blog-article group" data-category="{{ $article['category'] }}" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-{{ $article['categoryColor'] }}/40 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-xl hover:shadow-{{ $article['categoryColor'] }}/10">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ $article['image'] }}" 
                                 alt="{{ $article['title'] }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-{{ $article['categoryColor'] }}/90 text-white">
                                    <i class="fas fa-{{ $article['categoryIcon'] }} mr-1"></i>
                                    {{ ucfirst($article['category']) }}
                                </span>
                            </div>
                            
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $article['readTime'] }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center space-x-4 text-xs text-gray-400 mb-3">
                                <span><i class="fas fa-calendar mr-1"></i> {{ $article['date'] }}</span>
                                <span><i class="fas fa-user mr-1"></i> {{ $article['author'] }}</span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-{{ $article['categoryColor'] }} transition-colors duration-300 leading-tight">
                                {{ $article['title'] }}
                            </h3>
                            
                            <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                                {{ $article['excerpt'] }}
                            </p>
                            
                            <div class="flex items-center justify-between">
                                <a href="#" class="inline-flex items-center text-{{ $article['categoryColor'] }} hover:text-white font-semibold transition-colors duration-300 group/link">
                                    <span>Read More</span>
                                    <i class="fas fa-chevron-right ml-2 text-xs group-hover/link:translate-x-1 transition-transform duration-300"></i>
                                </a>
                                
                                <div class="flex items-center space-x-3 text-xs text-gray-400">
                                    <span><i class="fas fa-eye mr-1"></i>{{ $article['views'] }}</span>
                                    <button class="hover:text-red-400 transition-colors duration-300">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-16" data-aos="fade-up">
            <button id="loadMoreBtn" class="group inline-flex items-center space-x-4 px-10 py-5 bg-gradient-to-r from-primary/10 to-secondary/10 backdrop-blur-xl text-white font-bold rounded-2xl border border-primary/30 hover:border-primary/60 hover:from-primary/20 hover:to-secondary/20 transition-all duration-500 hover:shadow-2xl hover:shadow-primary/20 transform hover:-translate-y-1">
                <i class="fas fa-plus text-primary text-xl"></i>
                <span class="text-lg">Load More Articles</span>
                <i class="fas fa-arrow-down text-primary group-hover:translate-y-2 transition-transform duration-300"></i>
            </button>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-center space-x-2 mt-12" data-aos="fade-up">
            <button class="pagination-btn px-4 py-2 bg-white/10 text-gray-400 rounded-lg hover:bg-primary/20 hover:text-white transition-all duration-300" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            @for($i = 1; $i <= 5; $i++)
                <button class="pagination-btn px-4 py-2 {{ $i === 1 ? 'bg-gradient-to-r from-primary to-secondary text-white' : 'bg-white/10 text-gray-400 hover:bg-primary/20 hover:text-white' }} rounded-lg {{ $i === 1 ? 'font-semibold' : '' }} transition-all duration-300">{{ $i }}</button>
            @endfor
            <button class="pagination-btn px-4 py-2 bg-white/10 text-gray-400 rounded-lg hover:bg-primary/20 hover:text-white transition-all duration-300">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryBtns = document.querySelectorAll('.blog-category-btn');
    const articleCards = document.querySelectorAll('.blog-article');
    const searchInput = document.getElementById('blogSearchInput');
    
    // Category filtering
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryBtns.forEach(b => {
                b.classList.remove('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
                b.classList.add('bg-white/10', 'text-gray-300');
            });
            btn.classList.remove('bg-white/10', 'text-gray-300');
            btn.classList.add('bg-gradient-to-r', 'from-primary', 'to-secondary', 'text-white');
            
            const category = btn.dataset.category;
            articleCards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Search functionality
    searchInput?.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        articleCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const excerpt = card.querySelector('p').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Load more functionality
    document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin text-primary mr-2"></i>Loading...';
        
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-plus text-primary text-xl"></i><span class="text-lg">Load More Articles</span><i class="fas fa-arrow-down text-primary group-hover:translate-y-2 transition-transform duration-300"></i>';
            alert('More articles would be loaded here');
        }, 1500);
    });
});
</script>

@endsection