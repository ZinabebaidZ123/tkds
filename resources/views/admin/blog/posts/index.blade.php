@extends('admin.layouts.app')

@section('title', 'Blog Posts')
@section('page-title', 'Blog Posts')

@section('content')
<div class="space-y-6">
    
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manage Blog Posts</h2>
            <p class="text-gray-600 text-sm mt-1">Create, edit and manage your blog content</p>
        </div>
        <a href="{{ route('admin.blog.posts.create') }}" 
           class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            <span>Create New Post</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Newsletter Messages --}}
@if(session('newsletter_success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
        <div class="flex items-center">
            <i class="fas fa-envelope-check mr-2 text-green-600"></i>
            <span class="font-medium">{{ session('newsletter_success') }}</span>
        </div>
    </div>
@endif

@if(session('newsletter_info'))
    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl mb-4">
        <div class="flex items-center">
            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
            <span class="font-medium">{{ session('newsletter_info') }}</span>
        </div>
    </div>
@endif

@if(session('newsletter_error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
            <span class="font-medium">{{ session('newsletter_error') }}</span>
        </div>
    </div>
@endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Posts</p>
                    <p class="text-2xl font-bold">{{ $posts->total() }}</p>
                </div>
                <i class="fas fa-newspaper text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Published</p>
                    <p class="text-2xl font-bold">{{ $posts->where('status', 'published')->count() }}</p>
                </div>
                <i class="fas fa-eye text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Drafts</p>
                    <p class="text-2xl font-bold">{{ $posts->where('status', 'draft')->count() }}</p>
                </div>
                <i class="fas fa-edit text-3xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Scheduled</p>
                    <p class="text-2xl font-bold">{{ $posts->where('status', 'scheduled')->count() }}</p>
                </div>
                <i class="fas fa-clock text-3xl text-purple-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Archived</p>
                    <p class="text-2xl font-bold">{{ $posts->where('status', 'archived')->count() }}</p>
                </div>
                <i class="fas fa-archive text-3xl text-red-200"></i>
            </div>
        </div>
    </div>


<!-- Section Title & Subtitle Form -->
@php
    $firstPost = $posts->first();
    $defaultTitlePart1 = $firstPost->title_part1 ?? 'Broadcast';
    $defaultTitlePart2 = $firstPost->title_part2 ?? 'Smarts';
    $defaultSubtitle = $firstPost->subtitle ?? 'Explore expert insights, trends, and innovations in broadcasting.';
@endphp

<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 bg-gradient-to-r from-primary/10 to-secondary/10 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-heading mr-2 text-primary"></i>
            Section Title & Subtitle
        </h3>
        <p class="text-gray-600 text-sm mt-1">Edit the main title and subtitle for the blog section on homepage</p>
    </div>
    
    <form id="sectionTitleForm" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Left Column - Title Parts -->
            <div class="space-y-6">
                <div class="bg-gradient-to-r from-primary/5 to-secondary/5 p-4 rounded-xl border border-primary/10">
                    <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-heading mr-2 text-primary"></i>
                        Section Title
                    </h4>
                    <p class="text-sm text-gray-600 mb-4">
                        Create a dynamic title like "Broadcast <span class="text-primary font-semibold">Smarts</span>"
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="title_part1" class="block text-sm font-medium text-gray-700 mb-2">
                                First Part
                            </label>
                            <input type="text" 
                                   id="title_part1"
                                   name="title_part1"
                                   value="{{ $defaultTitlePart1 }}"
                                   placeholder="e.g., Broadcast"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">
                        </div>
                        
                        <div>
                            <label for="title_part2" class="block text-sm font-medium text-gray-700 mb-2">
                                Second Part (Highlighted)
                            </label>
                            <input type="text" 
                                   id="title_part2"
                                   name="title_part2"
                                   value="{{ $defaultTitlePart2 }}"
                                   placeholder="e.g., Smarts"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">
                        </div>
                    </div>
                    
                    <!-- Preview -->
                    <div class="mt-4 p-3 bg-white rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Preview:</p>
                        <div id="titlePreview" class="text-xl font-bold text-gray-900">
                            <span id="part1Preview">{{ $defaultTitlePart1 }}</span>
                            <span id="part2Preview" class="bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">{{ $defaultTitlePart2 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Subtitle -->
            <div class="space-y-6">
                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                        Section Subtitle
                        <span class="text-gray-500 font-normal">- Appears below the main title</span>
                    </label>
                    <textarea id="subtitle" 
                              name="subtitle"
                              rows="4"
                              placeholder="e.g., Explore expert insights, trends, and innovations in broadcasting."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">{{ $defaultSubtitle }}</textarea>
                </div>

                <!-- Save Button -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <form method="GET" action="{{ route('admin.blog.posts.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search posts..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Author</label>
                <select name="author" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Authors</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition-colors">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.blog.posts.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Posts Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list mr-2 text-primary"></i>
                    All Posts ({{ $posts->total() }})
                </h3>
            </div>
        </div>
        
        @if($posts->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Post</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stats</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($posts as $post)
                            <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="flex items-start space-x-4">
                                        <div class="relative group">
                                            <img src="{{ $post->getFeaturedImageUrl() }}" 
                                                 alt="{{ $post->title }}" 
                                                 class="w-20 h-16 object-cover rounded-lg border-2 border-gray-200 shadow-sm group-hover:shadow-md transition-shadow duration-200">
                                            @if($post->is_featured)
                                                <span class="absolute -top-1 -right-1 bg-yellow-400 text-white text-xs px-1 py-0.5 rounded-full">
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-semibold text-gray-900 hover:text-primary transition-colors">
                                                <a href="{{ route('admin.blog.posts.show', $post) }}">{{ $post->title }}</a>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $post->getExcerpt(80) }}</div>
                                            <div class="flex items-center space-x-3 mt-2 text-xs text-gray-400">
                                                <span><i class="fas fa-calendar mr-1"></i>{{ $post->created_at->format('M d, Y') }}</span>
                                                <span><i class="fas fa-clock mr-1"></i>{{ $post->getReadingTime() }}</span>
                                                @if($post->tags->count() > 0)
                                                    <span class="flex items-center space-x-1">
                                                        <i class="fas fa-tags mr-1"></i>
                                                        @foreach($post->tags->take(2) as $tag)
                                                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $tag->name }}</span>
                                                        @endforeach
                                                        @if($post->tags->count() > 2)
                                                            <span class="text-gray-500">+{{ $post->tags->count() - 2 }}</span>
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($post->category)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" 
                                              style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                                            <i class="{{ $post->category->icon }} mr-1"></i>
                                            {{ $post->category->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">No Category</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($post->author)
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $post->author->getAvatarUrl() }}" 
                                                 alt="{{ $post->author->name }}"
                                                 class="w-8 h-8 rounded-full border border-gray-200">
                                            <span class="text-sm font-medium text-gray-900">{{ $post->author->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">No Author</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <select class="status-select appearance-none bg-transparent border-0 text-sm font-medium rounded-lg px-3 py-1 focus:outline-none cursor-pointer
                                                 @if($post->status === 'published') text-green-800 bg-green-100 
                                                 @elseif($post->status === 'draft') text-yellow-800 bg-yellow-100
                                                 @elseif($post->status === 'scheduled') text-blue-800 bg-blue-100
                                                 @else text-red-800 bg-red-100 @endif"
                                            data-id="{{ $post->id }}">
                                        <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="scheduled" {{ $post->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="archived" {{ $post->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                    @if($post->scheduled_at && $post->status === 'scheduled')
                                        <div class="text-xs text-gray-500 mt-1">{{ $post->scheduled_at->format('M d, Y H:i') }}</div>
                                    @endif
                                    @if($post->published_at && $post->status === 'published')
                                        <div class="text-xs text-gray-500 mt-1">{{ $post->published_at->format('M d, Y H:i') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1 text-xs text-gray-500">
                                        <div><i class="fas fa-eye mr-1"></i>{{ number_format($post->view_count) }} views</div>
                                        <div><i class="fas fa-heart mr-1"></i>{{ number_format($post->like_count) }} likes</div>
                                        <div><i class="fas fa-share mr-1"></i>{{ number_format($post->share_count) }} shares</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                                           class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                           title="View Post">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <a href="{{ route('admin.blog.posts.edit', $post) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="duplicatePost({{ $post->id }})" 
                                                class="text-purple-600 hover:text-purple-800 p-2 rounded-lg hover:bg-purple-50 transition-colors duration-200"
                                                title="Duplicate">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button onclick="deletePost({{ $post->id }})" 
                                                class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Cards -->
            <div class="lg:hidden divide-y divide-gray-100">
                @foreach($posts as $post)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0 relative">
                                <img src="{{ $post->getFeaturedImageUrl() }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-20 h-16 object-cover rounded-lg border border-gray-200">
                                @if($post->is_featured)
                                    <span class="absolute -top-1 -right-1 bg-yellow-400 text-white text-xs px-1 py-0.5 rounded-full">
                                        <i class="fas fa-star"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $post->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $post->getExcerpt(60) }}</p>
                                <div class="flex items-center mt-2 space-x-3 text-xs text-gray-400">
                                    @if($post->category)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full" 
                                              style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                 @if($post->status === 'published') bg-green-100 text-green-800 
                                                 @elseif($post->status === 'draft') bg-yellow-100 text-yellow-800
                                                 @elseif($post->status === 'scheduled') bg-blue-100 text-blue-800
                                                 @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center mt-2 space-x-4 text-xs text-gray-400">
                                    <span><i class="fas fa-eye mr-1"></i>{{ number_format($post->view_count) }}</span>
                                    <span><i class="fas fa-calendar mr-1"></i>{{ $post->created_at->format('M d') }}</span>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex items-center space-x-2 text-xs">
                                        @if($post->author)
                                            <img src="{{ $post->author->getAvatarUrl() }}" 
                                                 alt="{{ $post->author->name }}"
                                                 class="w-6 h-6 rounded-full border border-gray-200">
                                            <span class="text-gray-600">{{ $post->author->name }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="text-green-600 hover:text-green-800 p-1">
                                            <i class="fas fa-external-link-alt text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.blog.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800 p-1">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="duplicatePost({{ $post->id }})" class="text-purple-600 hover:text-purple-800 p-1">
                                            <i class="fas fa-copy text-sm"></i>
                                        </button>
                                        <button onclick="deletePost({{ $post->id }})" class="text-red-600 hover:text-red-800 p-1">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-newspaper text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No posts found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by creating your first blog post to share your insights.</p>
                <a href="{{ route('admin.blog.posts.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Post
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl transform transition-all duration-300 scale-95">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirm Delete</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this post? This action cannot be undone.</p>
            <div class="flex space-x-3">
                <button id="confirmDelete" class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium shadow-lg">
                    <i class="fas fa-trash mr-2"></i>
                    Delete
                </button>
                <button onclick="closeDeleteModal()" class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

let deleteId = null;

// Title Preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const titlePart1 = document.getElementById('title_part1');
    const titlePart2 = document.getElementById('title_part2');
    const part1Preview = document.getElementById('part1Preview');
    const part2Preview = document.getElementById('part2Preview');
    
    if (titlePart1 && titlePart2 && part1Preview && part2Preview) {
        function updateTitlePreview() {
            const part1 = titlePart1.value || 'Broadcast';
            const part2 = titlePart2.value || 'Smarts';
            
            part1Preview.textContent = part1;
            part2Preview.textContent = part2;
        }
        
        titlePart1.addEventListener('input', updateTitlePreview);
        titlePart2.addEventListener('input', updateTitlePreview);
    }
});

// Section Title Form Submit
const sectionTitleForm = document.getElementById('sectionTitleForm');
if (sectionTitleForm) {
    sectionTitleForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        
        const formData = {
            title_part1: document.getElementById('title_part1').value,
            title_part2: document.getElementById('title_part2').value,
            subtitle: document.getElementById('subtitle').value
        };
        
        fetch('{{ route("admin.blog.posts.index") }}/update-section-title', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Section title updated successfully!', 'success');
            } else {
                throw new Error(data.message || 'Failed to update section title');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update section title', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
}

// Status change functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.status-select').forEach(select => {
        select.dataset.original = select.value;
    });

    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const status = this.value;
            const originalValue = this.dataset.original || this.value;
            
            console.log('Status change triggered:', { id, status, originalValue });
            
            if (!id) {
                console.error('Post ID is missing');
                showNotification('Post ID is missing', 'error');
                this.value = originalValue;
                return;
            }
            
            this.disabled = true;
            const originalHTML = this.outerHTML;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token not found');
                showNotification('Security token missing', 'error');
                this.disabled = false;
                this.value = originalValue;
                return;
            }
            
            fetch(`/admin/blog/posts/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ 
                    status: status,
                    _method: 'POST'
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                
                if (data.success) {
                    this.className = this.className.replace(/text-\w+-800|bg-\w+-100/g, '');
                    
                    switch(status) {
                        case 'published':
                            this.classList.add('text-green-800', 'bg-green-100');
                            break;
                        case 'draft':
                            this.classList.add('text-yellow-800', 'bg-yellow-100');
                            break;
                        case 'scheduled':
                            this.classList.add('text-blue-800', 'bg-blue-100');
                            break;
                        case 'archived':
                            this.classList.add('text-red-800', 'bg-red-100');
                            break;
                    }
                    
                    this.dataset.original = status;
                    showNotification(data.message || 'Status updated successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to update status');
                }
            })
            .catch(error => {
                console.error('Status update error:', error);
                this.value = originalValue;
                
                let errorMessage = 'Failed to update status';
                if (error.message.includes('422')) {
                    errorMessage = 'Invalid status value';
                } else if (error.message.includes('404')) {
                    errorMessage = 'Post not found';
                } else if (error.message.includes('403')) {
                    errorMessage = 'Permission denied';
                } else if (error.message.includes('419')) {
                    errorMessage = 'Session expired. Please refresh the page.';
                }
                
                showNotification(errorMessage, 'error');
            })
            .finally(() => {
                this.disabled = false;
            });
        });
    });
});

function deletePost(id) {
    if (!id) {
        console.error('Post ID is missing for delete');
        showNotification('Post ID is missing', 'error');
        return;
    }
    
    deleteId = id;
    const modal = document.getElementById('deleteModal');
    
    if (!modal) {
        console.error('Delete modal not found');
        showNotification('Delete dialog not available', 'error');
        return;
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    setTimeout(() => {
        const modalContent = modal.querySelector('.bg-white');
        if (modalContent) {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (!modal) return;
    
    const modalContent = modal.querySelector('.bg-white');
    if (modalContent) {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
    }
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        deleteId = null;
    }, 300);
}

document.addEventListener('DOMContentLoaded', function() {
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            if (!deleteId) {
                console.error('No post ID selected for deletion');
                showNotification('No post selected', 'error');
                closeDeleteModal();
                return;
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token not found');
                showNotification('Security token missing', 'error');
                closeDeleteModal();
                return;
            }
            
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';
            
            console.log('Attempting to delete post:', deleteId);
            
            fetch(`/admin/blog/posts/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Delete response status:', response.status);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Delete success response:', data);
                
                if (data.success) {
                    showNotification(data.message || 'Post deleted successfully!', 'success');
                    
                    closeDeleteModal();
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    throw new Error(data.message || 'Failed to delete post');
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                
                let errorMessage = 'Failed to delete post';
                if (error.message.includes('404')) {
                    errorMessage = 'Post not found';
                } else if (error.message.includes('403')) {
                    errorMessage = 'Permission denied';
                } else if (error.message.includes('419')) {
                    errorMessage = 'Session expired. Please refresh the page.';
                }
                
                showNotification(errorMessage, 'error');
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-trash mr-2"></i>Delete';
                closeDeleteModal();
            });
        });
    }
});

function duplicatePost(id) {
    if (!id) {
        console.error('Post ID is missing for duplicate');
        showNotification('Post ID is missing', 'error');
        return;
    }
    
    if (!confirm('Are you sure you want to duplicate this post?')) {
        return;
    }
    
    const button = event.target.closest('button');
    if (!button) {
        console.error('Button element not found');
        showNotification('Button not found', 'error');
        return;
    }
    
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token not found');
        showNotification('Security token missing', 'error');
        button.innerHTML = originalContent;
        button.disabled = false;
        return;
    }
    
    console.log('Attempting to duplicate post:', id);
    
    fetch(`/admin/blog/posts/${id}/duplicate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            _method: 'POST'
        })
    })
    .then(response => {
        console.log('Duplicate response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Duplicate success response:', data);
        
        if (data.success) {
            showNotification(data.message || 'Post duplicated successfully!', 'success');
            
            if (data.redirect_url) {
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 1000);
            } else {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } else {
            throw new Error(data.message || 'Failed to duplicate post');
        }
    })
    .catch(error => {
        console.error('Duplicate error:', error);
        
        let errorMessage = 'Failed to duplicate post';
        if (error.message.includes('404')) {
            errorMessage = 'Post not found';
        } else if (error.message.includes('403')) {
            errorMessage = 'Permission denied';
        } else if (error.message.includes('419')) {
            errorMessage = 'Session expired. Please refresh the page.';
        } else if (error.message.includes('500')) {
            errorMessage = 'Server error. Please try again.';
        }
        
        showNotification(errorMessage, 'error');
    })
    .finally(() => {
        button.innerHTML = originalContent;
        button.disabled = false;
    });
}

function showNotification(message, type = 'success') {
    const existingNotifications = document.querySelectorAll('.custom-notification');
    existingNotifications.forEach(notification => {
        notification.remove();
    });
    
    const notification = document.createElement('div');
    let bgColor, icon, borderColor;
    
    switch(type) {
        case 'success':
            bgColor = 'bg-green-500';
            borderColor = 'border-green-600';
            icon = 'fa-check-circle';
            break;
        case 'error':
            bgColor = 'bg-red-500';
            borderColor = 'border-red-600';
            icon = 'fa-exclamation-circle';
            break;
        case 'warning':
            bgColor = 'bg-yellow-500';
            borderColor = 'border-yellow-600';
            icon = 'fa-exclamation-triangle';
            break;
        default:
            bgColor = 'bg-blue-500';
            borderColor = 'border-blue-600';
            icon = 'fa-info-circle';
    }
    
    notification.className = `custom-notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-xl transform transition-all duration-300 translate-x-full ${bgColor} ${borderColor} border-2 text-white max-w-md`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-3 text-lg"></i>
            <span class="font-medium">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        if (document.body.contains(notification)) {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    notification.remove();
                }
            }, 300);
        }
    }, 5000);
}

document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    }

    window.addEventListener('error', function(e) {
        console.error('JavaScript Error:', {
            message: e.message,
            filename: e.filename,
            lineno: e.lineno,
            colno: e.colno,
            error: e.error
        });
    });

    window.addEventListener('unhandledrejection', function(e) {
        console.error('Unhandled Promise Rejection:', e.reason);
        
        if (e.reason && e.reason.message) {
            if (e.reason.message.includes('NetworkError') || e.reason.message.includes('fetch')) {
                showNotification('Network error. Please check your connection.', 'error');
            }
        }
    });
});

function debugInfo() {
    console.log('=== Blog Posts Debug Info ===');
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ? 'Present' : 'Missing');
    console.log('Status Selects:', document.querySelectorAll('.status-select').length);
    console.log('Delete Modal:', document.getElementById('deleteModal') ? 'Present' : 'Missing');
    console.log('Confirm Delete Button:', document.getElementById('confirmDelete') ? 'Present' : 'Missing');
    console.log('Current URL:', window.location.href);
    console.log('=== End Debug Info ===');
}

window.debugBlogPosts = debugInfo;
</script>
@endpush