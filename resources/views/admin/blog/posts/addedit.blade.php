@extends('admin.layouts.app')

@section('title', isset($post) ? 'Edit Post' : 'Add New Post')
@section('page-title', isset($post) ? 'Edit Post' : 'Add New Post')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.blog.posts.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.blog.posts.index') }}" class="hover:text-primary transition-colors duration-200">Blog Posts</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($post) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($post) ? 'Edit' : 'Add New' }} Blog Post
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($post) ? 'Update the' : 'Create a new' }} blog post with rich content</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ isset($post) ? route('admin.blog.posts.update', $post) : route('admin.blog.posts.store') }}" 
          method="POST" enctype="multipart/form-data" id="postForm">
        @csrf
        @if(isset($post))
            @method('PUT')
        @endif
        
        <!-- ✅ Hidden field for images to remove -->
        <div id="removeGalleryImagesContainer"></div>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-edit mr-2 text-primary"></i>
                            Post Content
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        
                        <!-- Title -->
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-heading mr-2 text-primary"></i>
                                Title *
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $post->title ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('title') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="Enter an engaging title"
                                   required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">This will also generate the URL slug automatically</p>
                        </div>

                        <!-- Slug -->
                        <div class="space-y-2">
                            <label for="slug" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-link mr-2 text-primary"></i>
                                URL Slug
                            </label>
                            <input type="text" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug', $post->slug ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('slug') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="auto-generated-from-title">
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Leave empty to auto-generate from title</p>
                        </div>

                        <!-- Excerpt -->
                        <div class="space-y-2">
                            <label for="excerpt" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-quote-left mr-2 text-primary"></i>
                                Excerpt
                            </label>
                            <textarea id="excerpt" 
                                      name="excerpt" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('excerpt') border-red-500 ring-2 ring-red-200 @enderror"
                                      placeholder="Brief description for preview cards and SEO">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                            @error('excerpt')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Optional - leave empty to auto-generate from content</p>
                        </div>

                        <!-- Content Editor -->
                        <div class="space-y-2">
                            <label for="content" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-file-text mr-2 text-primary"></i>
                                Content *
                            </label>
                            <div class="border border-gray-300 rounded-xl overflow-hidden @error('content') border-red-500 ring-2 ring-red-200 @enderror">
                                <textarea id="content" 
                                          name="content" 
                                          class="w-full min-h-[500px] border-0 focus:ring-0 focus:outline-none"
                                          required>{{ old('content', $post->content ?? '') }}</textarea>
                            </div>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Media Section -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-images mr-2 text-primary"></i>
                            Media & Gallery
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        
                        <!-- Featured Image -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-image mr-2 text-primary"></i>
                                Featured Image {{ isset($post) ? '(Optional - leave empty to keep current)' : '' }}
                            </label>
                            
                            @if(isset($post) && $post->featured_image)
                                <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                                    <img src="{{ $post->getFeaturedImageUrl() }}" 
                                         alt="{{ $post->title }}"
                                         class="max-w-full h-48 object-cover rounded-lg border border-gray-300 shadow-sm">
                                </div>
                            @endif
                            
                            <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5" id="featuredImageDropZone">
                                <div class="space-y-4 text-center">
                                    <div class="mx-auto h-16 w-16 text-gray-400">
                                        <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                    </div>
                                    <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                        <label for="featured_image" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary px-3 py-1 border border-primary/20">
                                            <span>Choose file</span>
                                            <input id="featured_image" name="featured_image" type="file" class="sr-only" accept="image/*" 
                                                   onchange="previewFeaturedImage(this)">
                                        </label>
                                        <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB • Recommended: 1200x600px</p>
                                </div>
                            </div>
                            
                            <div id="featuredImagePreview" class="mt-4 hidden">
                                <p class="text-sm font-medium text-gray-700 mb-2">New Image Preview:</p>
                                <div class="relative inline-block">
                                    <img id="featuredPreviewImg" class="max-w-full h-48 object-cover rounded-lg border border-gray-300 shadow-sm" />
                                    <button type="button" onclick="removeFeaturedPreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            
                            @error('featured_image')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Featured Image Alt -->
                        <div class="space-y-2">
                            <label for="featured_image_alt" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-eye mr-2 text-primary"></i>
                                Featured Image Alt Text
                            </label>
                            <input type="text" 
                                   id="featured_image_alt" 
                                   name="featured_image_alt" 
                                   value="{{ old('featured_image_alt', $post->featured_image_alt ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="Describe the image for accessibility">
                            <p class="text-xs text-gray-500">Important for SEO and accessibility</p>
                        </div>

                        <!-- ✅ COMPLETELY FIXED: Gallery Section -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-images mr-2 text-primary"></i>
                                Gallery Images (Optional)
                            </label>
                            
                            @if(isset($post) && $post->gallery && count($post->getGalleryImages()) > 0)
                                <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200" id="existingGallery">
                                    <div class="flex items-center justify-between mb-3">
                                        <p class="text-sm font-medium text-gray-700">Current Gallery ({{ count($post->getGalleryImages()) }} images):</p>
                                        <p class="text-xs text-gray-500">Click × to remove images</p>
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3" id="currentGalleryGrid">
                                        @foreach($post->gallery as $index => $imagePath)
                                            <div class="relative group gallery-image-item" data-image-path="{{ $imagePath }}">
                                                <img src="{{ filter_var($imagePath, FILTER_VALIDATE_URL) ? $imagePath : asset('storage/' . $imagePath) }}" 
                                                     alt="Gallery image {{ $index + 1 }}"
                                                     class="w-full h-24 object-cover rounded border border-gray-300 group-hover:opacity-75 transition-opacity">
                                                <button type="button" 
                                                        onclick="markImageForRemoval('{{ $imagePath }}', this)"
                                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200 opacity-0 group-hover:opacity-100">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Upload New Gallery Images -->
                            <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5" id="galleryDropZone">
                                <div class="space-y-4 text-center">
                                    <div class="mx-auto h-16 w-16 text-gray-400">
                                        <i class="fas fa-images text-4xl"></i>
                                    </div>
                                    <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                        <label for="gallery" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary px-3 py-1 border border-primary/20">
                                            <span id="galleryUploadText">{{ isset($post) ? 'Add More Images' : 'Choose files' }}</span>
                                            <input id="gallery" name="gallery[]" type="file" class="sr-only" accept="image/*" multiple>
                                        </label>
                                        <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        Multiple images • PNG, JPG, GIF up to 5MB each
                                        @if(isset($post))
                                            <br><span class="text-blue-600">New images will be added to existing gallery</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <!-- New Images Preview Container -->
                            <div id="newGalleryPreview" class="mt-4 hidden">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-sm font-medium text-gray-700">New Images Preview:</p>
                                    <button type="button" onclick="clearAllNewImages()" class="text-sm text-red-600 hover:text-red-800 flex items-center">
                                        <i class="fas fa-trash mr-1"></i>
                                        Clear All New
                                    </button>
                                </div>
                                <div id="newGalleryContainer" class="grid grid-cols-2 md:grid-cols-4 gap-3"></div>
                                <div class="mt-2 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-sm text-blue-800">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <span id="newImagesCount">0</span> new images selected
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- ✅ ENHANCED: Additional Media Files with Preview -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-file mr-2 text-primary"></i>
                                Additional Media Files (Optional)
                            </label>
                            
                            @if(isset($post) && $post->media->count() > 0)
                                <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Current Media Files:</p>
                                    <div class="space-y-2">
                                        @foreach($post->media as $media)
                                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200" id="media-{{ $media->id }}">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded flex items-center justify-center">
                                                        <i class="fas fa-{{ $media->isImage() ? 'image' : ($media->isVideo() ? 'video' : 'file') }} text-white text-xs"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $media->file_name }}</p>
                                                        <p class="text-xs text-gray-500">{{ $media->getFileSizeFormatted() }}</p>
                                                    </div>
                                                </div>
                                                <button type="button" onclick="deleteMediaFile({{ $media->id }})" class="text-red-600 hover:text-red-800 text-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Media Upload Zone -->
                            <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5" id="mediaDropZone">
                                <div class="space-y-4 text-center">
                                    <div class="mx-auto h-16 w-16 text-gray-400">
                                        <i class="fas fa-file-upload text-4xl"></i>
                                    </div>
                                    <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                        <label for="media_files" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary px-3 py-1 border border-primary/20">
                                            <span id="mediaUploadText">Choose files</span>
                                            <input id="media_files" name="media_files[]" type="file" class="sr-only" multiple>
                                        </label>
                                        <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">Documents, videos, audio files up to 10MB each</p>
                                </div>
                            </div>

                            <!-- ✅ NEW: Media Files Preview Container -->
                            <div id="newMediaPreview" class="mt-4 hidden">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-sm font-medium text-gray-700">Selected Media Files:</p>
                                    <button type="button" onclick="clearAllMediaFiles()" class="text-sm text-red-600 hover:text-red-800 flex items-center">
                                        <i class="fas fa-trash mr-1"></i>
                                        Clear All
                                    </button>
                                </div>
                                <div id="newMediaContainer" class="space-y-2"></div>
                                <div class="mt-2 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-sm text-blue-800">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <span id="newMediaCount">0</span> files selected
                                        • Total size: <span id="newMediaSize">0 KB</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Publish Settings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-cog mr-2 text-primary"></i>
                            Publish Settings
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-toggle-on mr-2 text-primary"></i>
                                Status
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                    required onchange="toggleScheduleField()">
                                <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>
                                    📝 Draft
                                </option>
                                <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>
                                    ✅ Published
                                </option>
                                <option value="scheduled" {{ old('status', $post->status ?? '') === 'scheduled' ? 'selected' : '' }}>
                                    ⏰ Scheduled
                                </option>
                                <option value="archived" {{ old('status', $post->status ?? '') === 'archived' ? 'selected' : '' }}>
                                    📦 Archived
                                </option>
                            </select>
                        </div>

                        <!-- Scheduled Date -->
                        <div class="space-y-2" id="scheduleField" style="display: none;">
                            <label for="scheduled_at" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-calendar mr-2 text-primary"></i>
                                Schedule For
                            </label>
                            <input type="datetime-local" 
                                   id="scheduled_at" 
                                   name="scheduled_at" 
                                   value="{{ old('scheduled_at', isset($post) && $post->scheduled_at ? $post->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        </div>

                        <!-- Category -->
                        <div class="space-y-2">
                            <label for="category_id" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-folder mr-2 text-primary"></i>
                                Category *
                            </label>
                            <select id="category_id" 
                                    name="category_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                    required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}
                                            data-color="{{ $category->color }}">
                                        {{ $category->icon ? '📂' : '📂' }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Author -->
                        <div class="space-y-2">
                            <label for="author_id" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-user mr-2 text-primary"></i>
                                Author *
                            </label>
                            <select id="author_id" 
                                    name="author_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                    required>
                                <option value="">Select an author</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ old('author_id', $post->author_id ?? '') == $author->id ? 'selected' : '' }}>
                                        👤 {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Featured & Trending -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" 
                                           name="is_featured" 
                                           value="1"
                                           {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}
                                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                    <span class="text-sm font-semibold text-gray-700">
                                        <i class="fas fa-star mr-1 text-yellow-500"></i>
                                        Featured
                                    </span>
                                </label>
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" 
                                           name="is_trending" 
                                           value="1"
                                           {{ old('is_trending', $post->is_trending ?? false) ? 'checked' : '' }}
                                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                    <span class="text-sm font-semibold text-gray-700">
                                        <i class="fas fa-fire mr-1 text-orange-500"></i>
                                        Trending
                                    </span>
                                </label>
                            </div>

                        </div>
                                                    <!-- Newsletter Notification -->
<div class="space-y-2 mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
    <label class="flex items-center space-x-3">
        <input type="checkbox" 
               name="send_newsletter" 
               value="1"
               {{ old('send_newsletter', false) ? 'checked' : '' }}
               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
        <div class="flex-1">
            <span class="text-sm font-semibold text-gray-700">
                <i class="fas fa-envelope mr-1 text-blue-500"></i>
                Send Newsletter to Subscribers
            </span>
            <p class="text-xs text-gray-600 mt-1">
                Send email notification to all active newsletter subscribers when this post is published
            </p>
        </div>
    </label>
    <div class="text-xs text-blue-700 bg-blue-100 p-2 rounded">
        <i class="fas fa-info-circle mr-1"></i>
        Newsletter will only be sent when post status is "Published" and this option is checked
    </div>
</div>
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-tags mr-2 text-primary"></i>
                            Tags
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="relative">
                                <input type="text" 
                                       id="tagSearch" 
                                       placeholder="Search or create tags..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                <div id="tagDropdown" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-xl shadow-lg hidden max-h-48 overflow-y-auto"></div>
                            </div>
                            
                            <div id="selectedTags" class="flex flex-wrap gap-2">
                                @if(isset($post) && $post->tags)
                                    @foreach($post->tags as $tag)
                                        <span class="tag-item inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary border border-primary/20">
                                            {{ $tag->name }}
                                            <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                                            <button type="button" onclick="removeTag(this)" class="ml-2 text-primary/60 hover:text-primary">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="text-xs text-gray-500">
                                <p>💡 Start typing to search existing tags or create new ones</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-search mr-2 text-primary"></i>
                            SEO Settings
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        <!-- Meta Title -->
                        <div class="space-y-2">
                            <label for="meta_title" class="block text-sm font-semibold text-gray-700">
                                Meta Title
                            </label>
                            <input type="text" 
                                   id="meta_title" 
                                   name="meta_title" 
                                   value="{{ old('meta_title', $post->meta_title ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="Leave empty to use post title">
                            <p class="text-xs text-gray-500">Recommended: 50-60 characters</p>
                        </div>

                        <!-- Meta Description -->
                        <div class="space-y-2">
                            <label for="meta_description" class="block text-sm font-semibold text-gray-700">
                                Meta Description
                            </label>
                            <textarea id="meta_description" 
                                      name="meta_description" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                      placeholder="Brief description for search engines">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                            <p class="text-xs text-gray-500">Recommended: 150-160 characters</p>
                        </div>

                        <!-- Meta Keywords -->
                        <div class="space-y-2">
                            <label for="meta_keywords" class="block text-sm font-semibold text-gray-700">
                                Meta Keywords
                            </label>
                            <input type="text" 
                                   id="meta_keywords" 
                                   name="meta_keywords" 
                                   value="{{ old('meta_keywords', $post->meta_keywords ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="keyword1, keyword2, keyword3">
                            <p class="text-xs text-gray-500">Separate keywords with commas</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-6 space-y-4">
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($post) ? 'Update' : 'Create' }} Post</span>
                        </button>
                        
                        <a href="{{ route('admin.blog.posts.index') }}" 
                           class="w-full inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        
                        @if(isset($post))
                            <button type="button" 
                                    onclick="previewPost()"
                                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 font-medium">
                                <i class="fas fa-eye mr-2"></i>
                                Preview Post
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Post Stats (Edit Mode) -->
                @if(isset($post))
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-chart-bar mr-2 text-primary"></i>
                                Post Statistics
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                                    <div class="text-2xl font-bold text-blue-600">{{ number_format($post->view_count) }}</div>
                                    <div class="text-sm text-blue-700">Views</div>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                                    <div class="text-2xl font-bold text-green-600">{{ number_format($post->like_count) }}</div>
                                    <div class="text-sm text-green-700">Likes</div>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl">
                                    <div class="text-2xl font-bold text-purple-600">{{ number_format($post->share_count) }}</div>
                                    <div class="text-sm text-purple-700">Shares</div>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl">
                                    <div class="text-2xl font-bold text-yellow-600">{{ $post->getReadingTime() }}</div>
                                    <div class="text-sm text-yellow-700">Reading</div>
                                </div>
                            </div>
                            
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Created:</span>
                                    <span>{{ $post->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Last Updated:</span>
                                    <span>{{ $post->updated_at->diffForHumans() }}</span>
                                </div>
                                @if($post->published_at)
                                    <div class="flex justify-between">
                                        <span>Published:</span>
                                        <span>{{ $post->published_at->format('M d, Y H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- Include TinyMCE -->
<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>

@endsection

@push('scripts')
<script>
// ✅ COMPLETELY FIXED GALLERY MANAGEMENT SYSTEM + MEDIA PREVIEW SYSTEM
let removedGalleryImages = [];
let galleryFilesArray = []; // Array to hold all selected files
let fileIndexCounter = 0; // Counter for unique file identification

// ✅ NEW: Media Files Management System
let mediaFilesArray = []; // Array to hold all selected media files
let mediaFileIndexCounter = 0; // Counter for unique media file identification

// Initialize TinyMCE Editor
tinymce.init({
    selector: '#content',
    height: 500,
    menubar: true,
    license_key: 'gpl',
    
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'table', 'help', 'wordcount', 'emoticons'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link table | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | code preview | help',
    content_style: 'body { font-family: Inter, Arial, sans-serif; font-size: 14px; line-height: 1.6; }',
    
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
});

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('slug').value = slug;
});

// Toggle schedule field
function toggleScheduleField() {
    const status = document.getElementById('status').value;
    const scheduleField = document.getElementById('scheduleField');
    
    if (status === 'scheduled') {
        scheduleField.style.display = 'block';
        document.getElementById('scheduled_at').required = true;
    } else {
        scheduleField.style.display = 'none';
        document.getElementById('scheduled_at').required = false;
    }
}

// Initialize schedule field visibility
document.addEventListener('DOMContentLoaded', function() {
    toggleScheduleField();
});

// Tags Management
let availableTags = @json($tags ?? []);

document.getElementById('tagSearch').addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const dropdown = document.getElementById('tagDropdown');
    
    if (query.length < 2) {
        dropdown.classList.add('hidden');
        return;
    }
    
    const filtered = availableTags.filter(tag => 
        tag.name.toLowerCase().includes(query) && 
        !isTagSelected(tag.id)
    );
    
    if (filtered.length > 0 || query.length > 2) {
        dropdown.innerHTML = '';
        dropdown.classList.remove('hidden');
        
        filtered.forEach(tag => {
            const div = document.createElement('div');
            div.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100';
            div.innerHTML = `<span class="w-3 h-3 rounded-full inline-block mr-2" style="background-color: ${tag.color || '#3B82F6'}"></span>${tag.name}`;
            div.onclick = () => addTag(tag.id, tag.name);
            dropdown.appendChild(div);
        });
        
        if (query.length > 2 && !filtered.some(tag => tag.name.toLowerCase() === query)) {
            const div = document.createElement('div');
            div.className = 'px-4 py-2 hover:bg-primary/10 cursor-pointer text-primary font-medium';
            div.innerHTML = `<i class="fas fa-plus mr-2"></i>Create "${query}"`;
            div.onclick = () => createAndAddTag(query);
            dropdown.appendChild(div);
        }
    } else {
        dropdown.classList.add('hidden');
    }
});

function isTagSelected(tagId) {
    return document.querySelector(`input[name="tags[]"][value="${tagId}"]`) !== null;
}

function addTag(tagId, tagName) {
    if (isTagSelected(tagId)) return;
    
    const container = document.getElementById('selectedTags');
    const span = document.createElement('span');
    span.className = 'tag-item inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary border border-primary/20';
    span.innerHTML = `
        ${tagName}
        <input type="hidden" name="tags[]" value="${tagId}">
        <button type="button" onclick="removeTag(this)" class="ml-2 text-primary/60 hover:text-primary">
            <i class="fas fa-times text-xs"></i>
        </button>
    `;
    container.appendChild(span);
    
    document.getElementById('tagSearch').value = '';
    document.getElementById('tagDropdown').classList.add('hidden');
}

function createAndAddTag(tagName) {
    const tempId = 'temp_' + Date.now();
    addTag(tempId, tagName);
}

function removeTag(button) {
    button.closest('.tag-item').remove();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#tagSearch') && !e.target.closest('#tagDropdown')) {
        document.getElementById('tagDropdown').classList.add('hidden');
    }
});

// ✅ COMPLETELY FIXED: Gallery Image Management System

// Mark existing image for removal
function markImageForRemoval(imagePath, button) {
    if (confirm('Are you sure you want to remove this image from the gallery?')) {
        // Add to removed images array
        if (!removedGalleryImages.includes(imagePath)) {
            removedGalleryImages.push(imagePath);
        }
        
        // Visually mark the image as removed
        const imageContainer = button.closest('.gallery-image-item');
        imageContainer.style.opacity = '0.3';
        imageContainer.style.pointerEvents = 'none';
        
        // Change button to indicate removal
        button.innerHTML = '<i class="fas fa-undo"></i>';
        button.className = 'absolute -top-2 -right-2 bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-green-600 transition-colors duration-200';
        button.setAttribute('onclick', `undoImageRemoval('${imagePath}', this)`);
        button.setAttribute('title', 'Click to undo removal');
        
        console.log('Marked for removal:', imagePath);
    }
}

// Undo image removal
function undoImageRemoval(imagePath, button) {
    // Remove from removed images array
    removedGalleryImages = removedGalleryImages.filter(path => path !== imagePath);
    
    // Restore visual appearance
    const imageContainer = button.closest('.gallery-image-item');
    imageContainer.style.opacity = '1';
    imageContainer.style.pointerEvents = 'auto';
    
    // Restore original button
    button.innerHTML = '<i class="fas fa-times"></i>';
    button.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200 opacity-0 group-hover:opacity-100';
    button.setAttribute('onclick', `markImageForRemoval('${imagePath}', this)`);
    button.setAttribute('title', 'Remove image');
}

// ✅ COMPLETELY FIXED: Gallery Files Management
function updateGalleryFilesList() {
    console.log('Updating gallery files list:', galleryFilesArray.length, 'files');
    
    const galleryInput = document.getElementById('gallery');
    const dataTransfer = new DataTransfer();
    
    // Add all files from our array to the DataTransfer
    galleryFilesArray.forEach(fileObj => {
        if (fileObj && fileObj.file) {
            dataTransfer.items.add(fileObj.file);
        }
    });
    
    // Update the input files
    galleryInput.files = dataTransfer.files;
    
    // Update UI
    updateGalleryPreviewDisplay();
    updateUploadText();
}

function updateGalleryPreviewDisplay() {
    const previewContainer = document.getElementById('newGalleryContainer');
    const previewDiv = document.getElementById('newGalleryPreview');
    const countElement = document.getElementById('newImagesCount');
    
    // Clear existing previews
    previewContainer.innerHTML = '';
    
    if (galleryFilesArray.length > 0) {
        previewDiv.classList.remove('hidden');
        countElement.textContent = galleryFilesArray.length;
        
        galleryFilesArray.forEach((fileObj, index) => {
            if (fileObj && fileObj.file && fileObj.file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageDiv = document.createElement('div');
                    imageDiv.className = 'relative group';
                    imageDiv.setAttribute('data-file-id', fileObj.id);
                    imageDiv.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="New gallery image ${index + 1}"
                             class="w-full h-24 object-cover rounded border border-gray-300 group-hover:opacity-75 transition-opacity">
                        <div class="absolute inset-0 bg-green-500 bg-opacity-20 rounded flex items-center justify-center">
                            <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-medium">NEW ${index + 1}</span>
                        </div>
                        <button type="button" 
                                onclick="removeGalleryFile(${fileObj.id})" 
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200 opacity-0 group-hover:opacity-100">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    previewContainer.appendChild(imageDiv);
                };
                reader.readAsDataURL(fileObj.file);
            }
        });
    } else {
        previewDiv.classList.add('hidden');
    }
}

function updateUploadText() {
    const uploadText = document.getElementById('galleryUploadText');
    const isEdit = uploadText.textContent.includes('Add More Images');
    const baseText = isEdit ? 'Add More Images' : 'Choose files';
    
    if (galleryFilesArray.length > 0) {
        uploadText.textContent = `${baseText} (${galleryFilesArray.length} selected)`;
    } else {
        uploadText.textContent = baseText;
    }
}

function addGalleryFiles(files) {
    console.log('Adding', files.length, 'files to gallery');
    
    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const fileObj = {
                id: fileIndexCounter++,
                file: file,
                name: file.name
            };
            galleryFilesArray.push(fileObj);
            console.log('Added file:', file.name, 'with ID:', fileObj.id);
        } else {
            showNotification(`Skipped ${file.name}: Not an image file`, 'error');
        }
    });
    
    updateGalleryFilesList();
}

function removeGalleryFile(fileId) {
    console.log('Removing gallery file with ID:', fileId);
    
    const index = galleryFilesArray.findIndex(fileObj => fileObj.id === fileId);
    if (index > -1) {
        const removedFile = galleryFilesArray.splice(index, 1)[0];
        console.log('Removed file:', removedFile.name);
        updateGalleryFilesList();
    }
}

function clearAllNewImages() {
    if (confirm('Are you sure you want to clear all new images?')) {
        galleryFilesArray = [];
        updateGalleryFilesList();
        showNotification('All new images cleared', 'success');
    }
}

// ✅ NEW: Media Files Management System
function updateMediaFilesList() {
    console.log('Updating media files list:', mediaFilesArray.length, 'files');
    
    const mediaInput = document.getElementById('media_files');
    const dataTransfer = new DataTransfer();
    
    // Add all files from our array to the DataTransfer
    mediaFilesArray.forEach(fileObj => {
        if (fileObj && fileObj.file) {
            dataTransfer.items.add(fileObj.file);
        }
    });
    
    // Update the input files
    mediaInput.files = dataTransfer.files;
    
    // Update UI
    updateMediaPreviewDisplay();
    updateMediaUploadText();
}

function updateMediaPreviewDisplay() {
    const previewContainer = document.getElementById('newMediaContainer');
    const previewDiv = document.getElementById('newMediaPreview');
    const countElement = document.getElementById('newMediaCount');
    const sizeElement = document.getElementById('newMediaSize');
    
    // Clear existing previews
    previewContainer.innerHTML = '';
    
    if (mediaFilesArray.length > 0) {
        previewDiv.classList.remove('hidden');
        countElement.textContent = mediaFilesArray.length;
        
        // Calculate total size
        let totalSize = 0;
        mediaFilesArray.forEach(fileObj => {
            if (fileObj && fileObj.file) {
                totalSize += fileObj.file.size;
            }
        });
        
        sizeElement.textContent = formatFileSize(totalSize);
        
        mediaFilesArray.forEach((fileObj, index) => {
            if (fileObj && fileObj.file) {
                const fileDiv = document.createElement('div');
                fileDiv.className = 'flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200 hover:border-primary transition-all duration-200 group';
                fileDiv.setAttribute('data-file-id', fileObj.id);
                
                const fileType = getFileType(fileObj.file);
                const icon = getFileIcon(fileType, fileObj.file.type);
                
                fileDiv.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded flex items-center justify-center">
                            <i class="fas ${icon} text-white text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${fileObj.file.name}</p>
                            <div class="flex items-center space-x-2 text-xs text-gray-500">
                                <span>${formatFileSize(fileObj.file.size)}</span>
                                <span>•</span>
                                <span class="capitalize">${fileType}</span>
                                <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                                <span class="text-green-600 font-medium">NEW</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" 
                            onclick="removeMediaFile(${fileObj.id})" 
                            class="text-red-600 hover:text-red-800 opacity-0 group-hover:opacity-100 transition-all duration-200 p-2">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                `;
                previewContainer.appendChild(fileDiv);
            }
        });
    } else {
        previewDiv.classList.add('hidden');
    }
}

function updateMediaUploadText() {
    const uploadText = document.getElementById('mediaUploadText');
    
    if (mediaFilesArray.length > 0) {
        uploadText.textContent = `Choose files (${mediaFilesArray.length} selected)`;
    } else {
        uploadText.textContent = 'Choose files';
    }
}

function addMediaFiles(files) {
    console.log('Adding', files.length, 'media files');
    
    const maxSize = 10 * 1024 * 1024; // 10MB
    const allowedTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'text/plain',
        'text/csv',
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp',
        'video/mp4',
        'video/avi',
        'video/mov',
        'video/wmv',
        'audio/mp3',
        'audio/wav',
        'audio/ogg',
        'application/zip',
        'application/rar'
    ];
    
    Array.from(files).forEach(file => {
        if (!allowedTypes.includes(file.type)) {
            showNotification(`Skipped ${file.name}: File type not supported`, 'error');
            return;
        }
        
        if (file.size > maxSize) {
            showNotification(`Skipped ${file.name}: File too large (max 10MB)`, 'error');
            return;
        }
        
        const fileObj = {
            id: mediaFileIndexCounter++,
            file: file,
            name: file.name
        };
        mediaFilesArray.push(fileObj);
        console.log('Added media file:', file.name, 'with ID:', fileObj.id);
    });
    
    updateMediaFilesList();
    
    if (mediaFilesArray.length > 0) {
        showNotification(`Added ${mediaFilesArray.length} file(s) successfully`, 'success');
    }
}

function removeMediaFile(fileId) {
    console.log('Removing media file with ID:', fileId);
    
    const index = mediaFilesArray.findIndex(fileObj => fileObj.id === fileId);
    if (index > -1) {
        const removedFile = mediaFilesArray.splice(index, 1)[0];
        console.log('Removed file:', removedFile.name);
        updateMediaFilesList();
        showNotification('File removed', 'success');
    }
}

function clearAllMediaFiles() {
    if (confirm('Are you sure you want to clear all selected files?')) {
        mediaFilesArray = [];
        updateMediaFilesList();
        showNotification('All files cleared', 'success');
    }
}

// Helper functions for media files
function getFileType(file) {
    const type = file.type.toLowerCase();
    
    if (type.startsWith('image/')) return 'image';
    if (type.startsWith('video/')) return 'video';
    if (type.startsWith('audio/')) return 'audio';
    if (type.includes('pdf')) return 'document';
    if (type.includes('word') || type.includes('doc')) return 'document';
    if (type.includes('excel') || type.includes('sheet')) return 'spreadsheet';
    if (type.includes('powerpoint') || type.includes('presentation')) return 'presentation';
    if (type.includes('zip') || type.includes('rar')) return 'archive';
    if (type.includes('text')) return 'text';
    
    return 'file';
}

function getFileIcon(fileType, mimeType) {
    switch (fileType) {
        case 'image': return 'fa-image';
        case 'video': return 'fa-video';
        case 'audio': return 'fa-music';
        case 'document': return 'fa-file-alt';
        case 'spreadsheet': return 'fa-file-excel';
        case 'presentation': return 'fa-file-powerpoint';
        case 'archive': return 'fa-file-archive';
        case 'text': return 'fa-file-alt';
        default: return 'fa-file';
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// ✅ FIXED: Gallery Input Event Handler
document.getElementById('gallery').addEventListener('change', function(e) {
    console.log('Gallery input change event triggered');
    
    if (e.target.files && e.target.files.length > 0) {
        // Add new files to our array (don't replace existing ones)
        addGalleryFiles(e.target.files);
    }
});

// ✅ NEW: Media Files Input Event Handler
document.getElementById('media_files').addEventListener('change', function(e) {
    console.log('Media files input change event triggered');
    
    if (e.target.files && e.target.files.length > 0) {
        addMediaFiles(e.target.files);
    }
});

// ✅ FIXED: Form submission preparation
function addRemovedImagesToForm() {
    const container = document.getElementById('removeGalleryImagesContainer');
    container.innerHTML = '';
    
    removedGalleryImages.forEach(imagePath => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_gallery_images[]';
        input.value = imagePath;
        container.appendChild(input);
    });
    
    console.log('Added to form for removal:', removedGalleryImages);
}

// ✅ FIXED: Featured Image Functions
function previewFeaturedImage(input) {
    const previewDiv = document.getElementById('featuredImagePreview');
    const previewImg = document.getElementById('featuredPreviewImg');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file
        if (!file.type.startsWith('image/')) {
            showNotification('Please select only image files', 'error');
            input.value = '';
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) { // 5MB limit
            showNotification('Image file is too large. Maximum size is 5MB.', 'error');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewDiv.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        previewDiv.classList.add('hidden');
    }
}

function removeFeaturedPreview() {
    const previewDiv = document.getElementById('featuredImagePreview');
    const input = document.getElementById('featured_image');
    
    previewDiv.classList.add('hidden');
    input.value = '';
}

// Preview post
function previewPost() {
    const form = document.getElementById('postForm');
    const originalAction = form.action;
    const originalTarget = form.target;
    
    form.action = '{{ route("admin.blog.posts.index") }}/preview';
    form.target = '_blank';
    form.submit();
    
    form.action = originalAction;
    form.target = originalTarget;
}

// ✅ FIXED: Form submission handler
document.getElementById('postForm').addEventListener('submit', function(e) {
    console.log('Form submission started');
    console.log('Images marked for removal:', removedGalleryImages);
    console.log('New images to upload:', galleryFilesArray.length);
    console.log('New media files to upload:', mediaFilesArray.length);
    
    // Add removed images to form
    addRemovedImagesToForm();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
    
    // Update TinyMCE content before submission
    if (typeof tinymce !== 'undefined') {
        tinymce.triggerSave();
    }
    
    // Show processing notification
    showNotification('Processing your post...', 'info');
});

// Character counters
function addCharacterCounter(inputId, maxLength) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    const counter = document.createElement('div');
    counter.className = 'text-xs text-gray-500 text-right mt-1';
    input.parentNode.appendChild(counter);
    
    function updateCounter() {
        const remaining = maxLength - input.value.length;
        counter.textContent = `${input.value.length}/${maxLength}`;
        counter.className = `text-xs text-right mt-1 ${remaining < 10 ? 'text-red-500' : 'text-gray-500'}`;
    }
    
    input.addEventListener('input', updateCounter);
    updateCounter();
}

// Add character counters
addCharacterCounter('meta_title', 60);
addCharacterCounter('meta_description', 160);

// ✅ FIXED: Delete media file function
function deleteMediaFile(mediaId) {
    if (confirm('Are you sure you want to delete this media file?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
            alert('Security token missing');
            return;
        }
        
        @if(isset($post))
        fetch(`{{ route('admin.blog.posts.index') }}/{{ $post->id }}/media/${mediaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`media-${mediaId}`).remove();
                showNotification('Media file deleted successfully', 'success');
            } else {
                alert('Failed to delete media file: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete media file');
        });
        @else
        alert('Cannot delete media files for new posts');
        @endif
    }
}

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    let bgColor, icon;
    
    switch(type) {
        case 'success':
            bgColor = 'bg-green-500';
            icon = 'fa-check-circle';
            break;
        case 'error':
            bgColor = 'bg-red-500';
            icon = 'fa-exclamation-circle';
            break;
        default:
            bgColor = 'bg-blue-500';
            icon = 'fa-info-circle';
    }
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-xl transform transition-all duration-300 translate-x-full ${bgColor} text-white max-w-md`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-3 text-lg"></i>
            <span class="font-medium">${message}</span>
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
    }, 3000);
}

// ✅ ENHANCED DRAG AND DROP FUNCTIONALITY
const galleryDropZone = document.getElementById('galleryDropZone');
const featuredDropZone = document.getElementById('featuredImageDropZone');
const mediaDropZone = document.getElementById('mediaDropZone');

// Prevent default drag behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    galleryDropZone.addEventListener(eventName, preventDefaults, false);
    featuredDropZone.addEventListener(eventName, preventDefaults, false);
    mediaDropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

// Gallery drop zone styling
['dragenter', 'dragover'].forEach(eventName => {
    galleryDropZone.addEventListener(eventName, () => {
        galleryDropZone.classList.add('border-primary', 'bg-primary/10');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    galleryDropZone.addEventListener(eventName, () => {
        galleryDropZone.classList.remove('border-primary', 'bg-primary/10');
    }, false);
});

// Featured image drop zone styling
['dragenter', 'dragover'].forEach(eventName => {
    featuredDropZone.addEventListener(eventName, () => {
        featuredDropZone.classList.add('border-primary', 'bg-primary/10');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    featuredDropZone.addEventListener(eventName, () => {
        featuredDropZone.classList.remove('border-primary', 'bg-primary/10');
    }, false);
});

// ✅ NEW: Media drop zone styling
['dragenter', 'dragover'].forEach(eventName => {
    mediaDropZone.addEventListener(eventName, () => {
        mediaDropZone.classList.add('border-primary', 'bg-primary/10');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    mediaDropZone.addEventListener(eventName, () => {
        mediaDropZone.classList.remove('border-primary', 'bg-primary/10');
    }, false);
});

// Handle gallery drop
galleryDropZone.addEventListener('drop', function(e) {
    const files = e.dataTransfer.files;
    
    if (files.length > 0) {
        console.log('Gallery files dropped:', files.length);
        
        // Filter only image files
        const imageFiles = Array.from(files).filter(file => file.type.startsWith('image/'));
        
        if (imageFiles.length > 0) {
            addGalleryFiles(imageFiles);
            showNotification(`Added ${imageFiles.length} image(s) to gallery`, 'success');
        } else {
            showNotification('Please drop only image files (PNG, JPG, GIF)', 'error');
        }
    }
}, false);

// Handle featured image drop
featuredDropZone.addEventListener('drop', function(e) {
    const files = e.dataTransfer.files;
    
    if (files.length > 0) {
        const file = files[0];
        
        if (file.type.startsWith('image/')) {
            console.log('Featured image file dropped:', file.name);
            
            const featuredInput = document.getElementById('featured_image');
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            
            featuredInput.files = dataTransfer.files;
            previewFeaturedImage(featuredInput);
            
            showNotification('Featured image added successfully', 'success');
        } else {
            showNotification('Please drop only image files for featured image', 'error');
        }
    }
}, false);

// ✅ NEW: Handle media files drop
mediaDropZone.addEventListener('drop', function(e) {
    const files = e.dataTransfer.files;
    
    if (files.length > 0) {
        console.log('Media files dropped:', files.length);
        addMediaFiles(files);
    }
}, false);

// ✅ FILE VALIDATION FUNCTIONS
function validateImageFiles(files) {
    const validFiles = [];
    const invalidFiles = [];
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    
    Array.from(files).forEach(file => {
        if (!allowedTypes.includes(file.type)) {
            invalidFiles.push(`${file.name}: Invalid file type`);
        } else if (file.size > maxSize) {
            invalidFiles.push(`${file.name}: File too large (max 5MB)`);
        } else {
            validFiles.push(file);
        }
    });
    
    if (invalidFiles.length > 0) {
        showNotification(`Some files were skipped:\n${invalidFiles.join('\n')}`, 'error');
    }
    
    return validFiles;
}

// ✅ FORM VALIDATION
function validateForm() {
    const requiredFields = [
        { id: 'title', name: 'Title' },
        { id: 'content', name: 'Content' },
        { id: 'category_id', name: 'Category' },
        { id: 'author_id', name: 'Author' }
    ];
    
    const errors = [];
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (!element.value.trim()) {
            errors.push(field.name + ' is required');
        }
    });
    
    // Validate scheduled date if status is scheduled
    const status = document.getElementById('status').value;
    if (status === 'scheduled') {
        const scheduledDate = document.getElementById('scheduled_at').value;
        if (!scheduledDate) {
            errors.push('Schedule date is required for scheduled posts');
        } else if (new Date(scheduledDate) <= new Date()) {
            errors.push('Schedule date must be in the future');
        }
    }
    
    if (errors.length > 0) {
        showNotification('Please fix the following errors:\n' + errors.join('\n'), 'error');
        return false;
    }
    
    return true;
}

// ✅ ENHANCED FORM SUBMISSION WITH VALIDATION
document.getElementById('postForm').addEventListener('submit', function(e) {
    console.log('Form submission started');
    
    // Validate form first
    if (!validateForm()) {
        e.preventDefault();
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i><span>{{ isset($post) ? 'Update' : 'Create' }} Post</span>';
        return false;
    }
    
    console.log('Form validation passed');
    console.log('Images marked for removal:', removedGalleryImages);
    console.log('New images to upload:', galleryFilesArray.length);
    console.log('New media files to upload:', mediaFilesArray.length);
    
    // Add removed images to form
    addRemovedImagesToForm();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
    
    // Update TinyMCE content before submission
    if (typeof tinymce !== 'undefined') {
        tinymce.triggerSave();
    }
    
    // Show processing notification
    showNotification('Processing your post...', 'info');
});

// ✅ PREVENT ACCIDENTAL PAGE LEAVE
let formChanged = false;

// Track form changes
document.getElementById('postForm').addEventListener('input', function() {
    formChanged = true;
});

document.getElementById('postForm').addEventListener('change', function() {
    formChanged = true;
});

// Warn before leaving if form has changes
window.addEventListener('beforeunload', function(e) {
    if (formChanged && !document.getElementById('submitBtn').disabled) {
        const message = 'You have unsaved changes. Are you sure you want to leave?';
        e.returnValue = message;
        return message;
    }
});

// Clear the warning after successful submission
document.getElementById('postForm').addEventListener('submit', function() {
    formChanged = false;
});

// ✅ AUTO-SAVE FUNCTIONALITY (For existing posts)
let autoSaveTimer;
const AUTO_SAVE_INTERVAL = 30000; // 30 seconds

function autoSave() {
    @if(isset($post))
    if (formChanged && typeof tinymce !== 'undefined') {
        console.log('Auto-saving post...');
        
        tinymce.triggerSave();
        
        const formData = new FormData(document.getElementById('postForm'));
        formData.append('auto_save', '1');
        
        fetch('{{ route("admin.blog.posts.update", $post) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Auto-save successful');
                showNotification('Draft auto-saved', 'info');
                formChanged = false;
            }
        })
        .catch(error => {
            console.error('Auto-save failed:', error);
        });
    }
    @endif
}

// Start auto-save timer for existing posts
@if(isset($post))
autoSaveTimer = setInterval(autoSave, AUTO_SAVE_INTERVAL);
@endif

// ✅ KEYBOARD SHORTCUTS
document.addEventListener('keydown', function(e) {
    // Ctrl+S to save
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        if (validateForm()) {
            document.getElementById('postForm').submit();
        }
    }
    
    // Ctrl+P to preview (for existing posts)
    @if(isset($post))
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        previewPost();
    }
    @endif
});

// ✅ CLEANUP ON PAGE UNLOAD
window.addEventListener('beforeunload', function() {
    if (autoSaveTimer) {
        clearInterval(autoSaveTimer);
    }
    
    // Cleanup any object URLs created for previews
    const previewImages = document.querySelectorAll('#newGalleryContainer img, #featuredPreviewImg');
    previewImages.forEach(img => {
        if (img.src && img.src.startsWith('blob:')) {
            URL.revokeObjectURL(img.src);
        }
    });
});

// ✅ INITIALIZE FORM
document.addEventListener('DOMContentLoaded', function() {
    console.log('Blog post form initialized with complete gallery and media management');
    console.log('Features loaded:');
    console.log('✅ Multiple image gallery upload');
    console.log('✅ Individual file management');
    console.log('✅ Media files preview system');
    console.log('✅ Drag and drop support');
    console.log('✅ File validation');
    console.log('✅ Form validation');
    console.log('✅ Auto-save functionality');
    console.log('✅ Keyboard shortcuts');
    console.log('✅ Progress tracking');
    
    // Initialize any existing state
    toggleScheduleField();
    
    // Reset form state tracking
    formChanged = false;
});

console.log('Gallery & Media Management System v3.0 - Ready with complete preview system!');

function initializeNewsletterValidation() {
    const newsletterCheckbox = document.querySelector('input[name="send_newsletter"]');
    const statusSelect = document.getElementById('status');
    const submitButton = document.getElementById('submitBtn');
    const newsletterContainer = newsletterCheckbox?.closest('.space-y-2');
    
    if (newsletterCheckbox && statusSelect) {
        
        // ✅ NEW: Add real-time validation
        function validateNewsletterSelection() {
            const isNewsletterChecked = newsletterCheckbox.checked;
            const currentStatus = statusSelect.value;
            
            // Remove any existing error styling
            newsletterContainer?.classList.remove('border-red-500', 'bg-red-50');
            let existingError = newsletterContainer?.querySelector('.newsletter-error-message');
            if (existingError) {
                existingError.remove();
            }
            
            // Check for conflict
            if (isNewsletterChecked && currentStatus !== 'published') {
                // Add error styling
                if (newsletterContainer) {
                    newsletterContainer.classList.add('border-red-500', 'bg-red-50');
                    
                    // Add error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'newsletter-error-message mt-2 p-2 text-sm text-red-600 bg-red-100 border border-red-300 rounded flex items-center';
                    errorDiv.innerHTML = `
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Newsletter can only be sent when status is "Published". Please change status to Published or uncheck this option.
                    `;
                    newsletterContainer.appendChild(errorDiv);
                }
                
                return false;
            }
            
            return true;
        }
        
        // ✅ NEW: Validate on checkbox change
        newsletterCheckbox.addEventListener('change', function() {
            console.log('Newsletter checkbox changed:', this.checked);
            sessionStorage.setItem('newsletter_checkbox_state', this.checked);
            sessionStorage.setItem('newsletter_checkbox_manual', 'true');
            
            // Validate immediately
            validateNewsletterSelection();
        });
        
        // ✅ NEW: Validate on status change
        statusSelect.addEventListener('change', function() {
            console.log('Status changed to:', this.value);
            
            // Auto-check newsletter for published status (only if not manually set)
            if (this.value === 'published' && !sessionStorage.getItem('newsletter_checkbox_manual')) {
                newsletterCheckbox.checked = true;
                sessionStorage.setItem('newsletter_checkbox_state', 'true');
                console.log('Auto-checked newsletter for published status');
            }
            
            // Validate immediately
            validateNewsletterSelection();
        });
        
        // ✅ ENHANCED: Form validation with newsletter check
        const originalFormValidation = window.validateForm;
        window.validateForm = function() {
            // Run original validation first
            let isValid = true;
            if (originalFormValidation) {
                isValid = originalFormValidation();
            }
            
            // Add newsletter validation
            if (!validateNewsletterSelection()) {
                showNotification('Please fix the newsletter configuration before submitting', 'error');
                isValid = false;
            }
            
            return isValid;
        };
        
        // ✅ NEW: Prevent form submission if newsletter validation fails
        document.getElementById('postForm').addEventListener('submit', function(e) {
            if (!validateNewsletterSelection()) {
                e.preventDefault();
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i><span>{{ isset($post) ? 'Update' : 'Create' }} Post</span>';
                
                showNotification('Cannot submit: Newsletter can only be sent with Published status', 'error');
                return false;
            }
        });
        
        // ✅ NEW: Initial validation on page load
        setTimeout(() => {
            validateNewsletterSelection();
        }, 500);
        
        console.log('Newsletter validation system initialized');
    }
}

// ✅ ENHANCED: Smart status change suggestions
function addSmartStatusSuggestions() {
    const newsletterCheckbox = document.querySelector('input[name="send_newsletter"]');
    const statusSelect = document.getElementById('status');
    
    if (newsletterCheckbox && statusSelect) {
        newsletterCheckbox.addEventListener('change', function() {
            if (this.checked && statusSelect.value !== 'published') {
                // Show helpful suggestion
                const suggestionDiv = document.createElement('div');
                suggestionDiv.className = 'newsletter-suggestion mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-start space-x-3';
                suggestionDiv.innerHTML = `
                    <i class="fas fa-lightbulb text-blue-500 mt-0.5"></i>
                    <div class="flex-1">
                        <p class="text-sm text-blue-800 font-medium">Newsletter selected!</p>
                        <p class="text-xs text-blue-600 mt-1">Would you like to change the status to "Published" to send the newsletter?</p>
                        <button type="button" onclick="setStatusToPublished()" class="mt-2 text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors">
                            Yes, set to Published
                        </button>
                        <button type="button" onclick="dismissSuggestion(this)" class="mt-2 ml-2 text-xs text-blue-600 hover:text-blue-800">
                            No, keep current status
                        </button>
                    </div>
                `;
                
                // Remove any existing suggestions
                const existingSuggestion = document.querySelector('.newsletter-suggestion');
                if (existingSuggestion) {
                    existingSuggestion.remove();
                }
                
                // Add suggestion after the newsletter container
                const newsletterContainer = this.closest('.space-y-2');
                if (newsletterContainer) {
                    newsletterContainer.appendChild(suggestionDiv);
                }
            }
        });
    }
}

// Helper functions for suggestions
window.setStatusToPublished = function() {
    const statusSelect = document.getElementById('status');
    if (statusSelect) {
        statusSelect.value = 'published';
        statusSelect.dispatchEvent(new Event('change')); // Trigger change event
        
        // Remove suggestion
        const suggestion = document.querySelector('.newsletter-suggestion');
        if (suggestion) {
            suggestion.remove();
        }
        
        showNotification('Status changed to Published. Newsletter will be sent when post is saved!', 'success');
    }
};

window.dismissSuggestion = function(button) {
    const suggestionDiv = button.closest('.newsletter-suggestion');
    if (suggestionDiv) {
        suggestionDiv.remove();
    }
};

// ✅ Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        initializeNewsletterValidation();
        addSmartStatusSuggestions();
        console.log('Newsletter validation and suggestions initialized');
    }, 200);
});
</script>
@endpush 