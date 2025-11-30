@extends('admin.layouts.app')

@section('title', 'View Post - ' . $post->title)
@section('page-title', 'View Post')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.blog.posts.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.blog.posts.index') }}" class="hover:text-primary transition-colors duration-200">Blog Posts</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">View Post</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h2>
                <p class="text-gray-600 text-sm mt-1">Preview and manage post details</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ route('blog.show', $post->slug) }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-colors duration-200">
                <i class="fas fa-external-link-alt mr-2"></i>
                View Live
            </a>
            <a href="{{ route('admin.blog.posts.edit', $post) }}" 
               class="inline-flex items-center px-4 py-2 bg-primary hover:bg-secondary text-white rounded-xl transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit Post
            </a>
        </div>
    </div>

    <!-- Post Status & Info -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Status</p>
                    <p class="text-lg font-bold {{ $post->status === 'published' ? 'text-green-600' : ($post->status === 'draft' ? 'text-yellow-600' : ($post->status === 'scheduled' ? 'text-blue-600' : 'text-red-600')) }}">
                        {{ ucfirst($post->status) }}
                    </p>
                </div>
                <div class="w-12 h-12 {{ $post->status === 'published' ? 'bg-green-100' : ($post->status === 'draft' ? 'bg-yellow-100' : ($post->status === 'scheduled' ? 'bg-blue-100' : 'bg-red-100')) }} rounded-xl flex items-center justify-center">
                    <i class="fas fa-{{ $post->status === 'published' ? 'check-circle' : ($post->status === 'draft' ? 'edit' : ($post->status === 'scheduled' ? 'clock' : 'archive')) }} text-xl {{ $post->status === 'published' ? 'text-green-600' : ($post->status === 'draft' ? 'text-yellow-600' : ($post->status === 'scheduled' ? 'text-blue-600' : 'text-red-600')) }}"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Views</p>
                    <p class="text-lg font-bold text-blue-600">{{ number_format($post->view_count) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-eye text-xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Likes</p>
                    <p class="text-lg font-bold text-pink-600">{{ number_format($post->like_count) }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-heart text-xl text-pink-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Shares</p>
                    <p class="text-lg font-bold text-purple-600">{{ number_format($post->share_count) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-share text-xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Post Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Featured Image -->
            @if($post->featured_image)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-image mr-2 text-primary"></i>
                            Featured Image
                        </h3>
                    </div>
                    <div class="p-6">
                        <img src="{{ $post->getFeaturedImageUrl() }}" 
                             alt="{{ $post->featured_image_alt ?: $post->title }}"
                             class="w-full h-64 object-cover rounded-xl border border-gray-200">
                        @if($post->featured_image_alt)
                            <p class="text-sm text-gray-600 mt-3">
                                <strong>Alt Text:</strong> {{ $post->featured_image_alt }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Post Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-file-text mr-2 text-primary"></i>
                        Content
                    </h3>
                </div>
                <div class="p-6">
                    @if($post->excerpt)
                        <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Excerpt:</h4>
                            <p class="text-gray-600 italic">{{ $post->excerpt }}</p>
                        </div>
                    @endif
                    
                    <div class="prose prose-lg max-w-none">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>

            <!-- Gallery -->
            @if($post->gallery && count($post->getGalleryImages()) > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-images mr-2 text-primary"></i>
                            Gallery ({{ count($post->getGalleryImages()) }} images)
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($post->getGalleryImages() as $image)
                                <div class="relative group cursor-pointer" onclick="openImageModal('{{ $image }}')">
                                    <img src="{{ $image }}" 
                                         alt="Gallery image"
                                         class="w-full h-32 object-cover rounded-lg border border-gray-200 group-hover:scale-105 transition-transform duration-200">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-200 flex items-center justify-center">
                                        <i class="fas fa-expand text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Media Files -->
            @if($post->media->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-file mr-2 text-primary"></i>
                            Media Files ({{ $post->media->count() }})
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($post->media as $media)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center">
                                            <i class="fas fa-{{ $media->isImage() ? 'image' : ($media->isVideo() ? 'video' : 'file') }} text-white"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-900">{{ $media->file_name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $media->getFileSizeFormatted() }} • {{ ucfirst($media->file_type) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ $media->getFileUrl() }}" 
                                       download
                                       class="px-4 py-2 bg-primary hover:bg-secondary text-white rounded-lg transition-colors duration-200 text-sm">
                                        <i class="fas fa-download mr-1"></i>
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Post Details -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-primary"></i>
                        Post Details
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Category</p>
                        @if($post->category)
                            <div class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                                 style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                                <i class="{{ $post->category->icon }} mr-2"></i>
                                {{ $post->category->name }}
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No category assigned</p>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-700">Author</p>
                        @if($post->author)
                            <div class="mt-1 flex items-center space-x-3">
                                <img src="{{ $post->author->getAvatarUrl() }}" 
                                     alt="{{ $post->author->name }}"
                                     class="w-8 h-8 rounded-full border border-gray-200">
                                <span class="text-sm text-gray-900">{{ $post->author->name }}</span>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No author assigned</p>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-700">Reading Time</p>
                        <p class="text-sm text-gray-900 mt-1">{{ $post->getReadingTime() }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-700">URL Slug</p>
                        <p class="text-sm text-gray-900 mt-1 font-mono bg-gray-100 px-2 py-1 rounded">{{ $post->slug }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Featured</p>
                            <span class="inline-flex items-center mt-1 px-2 py-1 rounded-full text-xs font-medium {{ $post->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                <i class="fas fa-{{ $post->is_featured ? 'star' : 'star-o' }} mr-1"></i>
                                {{ $post->is_featured ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Trending</p>
                            <span class="inline-flex items-center mt-1 px-2 py-1 rounded-full text-xs font-medium {{ $post->is_trending ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800' }}">
                                <i class="fas fa-{{ $post->is_trending ? 'fire' : 'minus' }} mr-1"></i>
                                {{ $post->is_trending ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            @if($post->tags->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-tags mr-2 text-primary"></i>
                            Tags ({{ $post->tags->count() }})
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                    <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $tag->color }};"></div>
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- SEO Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-search mr-2 text-primary"></i>
                        SEO Information
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Meta Title</p>
                        <p class="text-sm text-gray-900 mt-1">{{ $post->meta_title ?: $post->title }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-700">Meta Description</p>
                        <p class="text-sm text-gray-900 mt-1">{{ $post->meta_description ?: $post->getExcerpt(160) }}</p>
                    </div>

                    @if($post->meta_keywords)
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Meta Keywords</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $post->meta_keywords }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Dates & History -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-history mr-2 text-primary"></i>
                        Timeline
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-blue-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Created</p>
                            <p class="text-xs text-gray-600">{{ $post->created_at->format('M d, Y - H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-edit text-yellow-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Last Updated</p>
                            <p class="text-xs text-gray-600">{{ $post->updated_at->format('M d, Y - H:i') }}</p>
                        </div>
                    </div>

                    @if($post->published_at)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Published</p>
                                <p class="text-xs text-gray-600">{{ $post->published_at->format('M d, Y - H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($post->scheduled_at && $post->status === 'scheduled')
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock text-purple-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Scheduled For</p>
                                <p class="text-xs text-gray-600">{{ $post->scheduled_at->format('M d, Y - H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300 transition-colors duration-200">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Close modal on background click
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endpush