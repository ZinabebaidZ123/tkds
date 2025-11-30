@extends('admin.layouts.app')

@section('title', isset($author) ? 'Edit Author' : 'Add New Author')
@section('page-title', isset($author) ? 'Edit Author' : 'Add New Author')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.blog.authors.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.blog.authors.index') }}" class="hover:text-primary transition-colors duration-200">Blog Authors</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($author) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($author) ? 'Edit' : 'Add New' }} Author
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($author) ? 'Update the' : 'Create a new' }} author profile</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-edit mr-2 text-primary"></i>
                        Author Details
                    </h3>
                </div>
                
                <form action="{{ isset($author) ? route('admin.blog.authors.update', $author) : route('admin.blog.authors.store') }}" 
                      method="POST" enctype="multipart/form-data" class="p-6 space-y-6" id="authorForm">
                    @csrf
                    @if(isset($author))
                        @method('PUT')
                    @endif
                    
                    <!-- Admin User Connection -->
                    <div class="space-y-2">
                        <label for="admin_user_id" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-user-tie mr-2 text-primary"></i>
                            Link to Admin User
                        </label>
                        <select id="admin_user_id" 
                                name="admin_user_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                            <option value="">No admin user linked</option>
                            @foreach($adminUsers as $adminUser)
                                <option value="{{ $adminUser->id }}" {{ old('admin_user_id', $author->admin_user_id ?? '') == $adminUser->id ? 'selected' : '' }}>
                                    {{ $adminUser->name }} ({{ $adminUser->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500">Optional - Link this author to an admin account</p>
                    </div>

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-user mr-2 text-primary"></i>
                            Full Name *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $author->name ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="Enter author's full name"
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
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
                               value="{{ old('slug', $author->slug ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('slug') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="auto-generated-from-name">
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Leave empty to auto-generate from name</p>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-envelope mr-2 text-primary"></i>
                            Email Address
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $author->email ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('email') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="author@example.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Optional - will be displayed on author page</p>
                    </div>

                    <!-- Bio -->
                    <div class="space-y-2">
                        <label for="bio" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-user-circle mr-2 text-primary"></i>
                            Biography
                        </label>
                        <textarea id="bio" 
                                  name="bio" 
                                  rows="5"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('bio') border-red-500 ring-2 ring-red-200 @enderror"
                                  placeholder="Tell us about this author...">{{ old('bio', $author->bio ?? '') }}</textarea>
                        @error('bio')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Brief description about the author</p>
                    </div>

                    <!-- Avatar Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-camera mr-2 text-primary"></i>
                            Avatar Image {{ isset($author) ? '(Optional - leave empty to keep current)' : '' }}
                        </label>
                        
                        @if(isset($author) && $author->avatar)
                            <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Avatar:</p>
                                <img src="{{ $author->getAvatarUrl() }}" 
                                     alt="{{ $author->name }}"
                                     class="w-24 h-24 rounded-full border border-gray-300 shadow-sm">
                            </div>
                        @endif
                        
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5" id="avatarDropZone">
                            <div class="space-y-4 text-center">
                                <div class="mx-auto h-16 w-16 text-gray-400">
                                    <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                </div>
                                <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                    <label for="avatar" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary px-3 py-1 border border-primary/20">
                                        <span>Choose file</span>
                                        <input id="avatar" name="avatar" type="file" class="sr-only" accept="image/*" onchange="previewAvatar(this)">
                                    </label>
                                    <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB • Recommended: Square image</p>
                            </div>
                        </div>
                        
                        <div id="avatarPreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">New Avatar Preview:</p>
                            <div class="relative inline-block">
                                <img id="previewAvatarImg" class="w-24 h-24 rounded-full border border-gray-300 shadow-sm" />
                                <button type="button" onclick="removeAvatarPreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        @error('avatar')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Social Links -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-share-alt mr-2 text-primary"></i>
                            Social Media Links
                        </label>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- LinkedIn -->
                            <div class="space-y-2">
                                <label for="linkedin_url" class="block text-sm font-medium text-gray-700 flex items-center">
                                    <i class="fab fa-linkedin text-blue-600 mr-2"></i>
                                    LinkedIn
                                </label>
                                <input type="url" 
                                       id="linkedin_url" 
                                       name="social_links[linkedin]" 
                                       value="{{ old('social_links.linkedin', isset($author) && $author->social_links ? $author->social_links['linkedin'] ?? '' : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="https://linkedin.com/in/username">
                            </div>

                            <!-- Twitter -->
                            <div class="space-y-2">
                                <label for="twitter_url" class="block text-sm font-medium text-gray-700 flex items-center">
                                    <i class="fab fa-twitter text-blue-400 mr-2"></i>
                                    Twitter
                                </label>
                                <input type="url" 
                                       id="twitter_url" 
                                       name="social_links[twitter]" 
                                       value="{{ old('social_links.twitter', isset($author) && $author->social_links ? $author->social_links['twitter'] ?? '' : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="https://twitter.com/username">
                            </div>

                            <!-- Facebook -->
                            <div class="space-y-2">
                                <label for="facebook_url" class="block text-sm font-medium text-gray-700 flex items-center">
                                    <i class="fab fa-facebook text-blue-700 mr-2"></i>
                                    Facebook
                                </label>
                                <input type="url" 
                                       id="facebook_url" 
                                       name="social_links[facebook]" 
                                       value="{{ old('social_links.facebook', isset($author) && $author->social_links ? $author->social_links['facebook'] ?? '' : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="https://facebook.com/username">
                            </div>

                            <!-- Instagram -->
                            <div class="space-y-2">
                                <label for="instagram_url" class="block text-sm font-medium text-gray-700 flex items-center">
                                    <i class="fab fa-instagram text-pink-600 mr-2"></i>
                                    Instagram
                                </label>
                                <input type="url" 
                                       id="instagram_url" 
                                       name="social_links[instagram]" 
                                       value="{{ old('social_links.instagram', isset($author) && $author->social_links ? $author->social_links['instagram'] ?? '' : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="https://instagram.com/username">
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-search mr-2 text-primary"></i>
                            SEO Settings
                        </h4>
                        
                        <div class="space-y-6">
                            <!-- Meta Title -->
                            <div class="space-y-2">
                                <label for="meta_title" class="block text-sm font-semibold text-gray-700">
                                    Meta Title
                                </label>
                                <input type="text" 
                                       id="meta_title" 
                                       name="meta_title" 
                                       value="{{ old('meta_title', $author->meta_title ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="Leave empty to use author name">
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
                                          placeholder="Brief description for search engines">{{ old('meta_description', $author->meta_description ?? '') }}</textarea>
                                <p class="text-xs text-gray-500">Recommended: 150-160 characters</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-toggle-on mr-2 text-primary"></i>
                            Status *
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            <option value="active" {{ old('status', $author->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                ✅ Active (Can publish posts)
                            </option>
                            <option value="inactive" {{ old('status', $author->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                ❌ Inactive (Cannot publish posts)
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.blog.authors.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($author) ? 'Update' : 'Create' }} Author</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar with Preview & Tips -->
        <div class="space-y-6">
            
            <!-- Live Preview Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-2 text-blue-600"></i>
                        Live Preview
                    </h3>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        <div class="relative inline-block mb-4">
                            <img id="previewAvatar" 
                                 src="{{ isset($author) ? $author->getAvatarUrl() : 'https://ui-avatars.com/api/?name=Author&color=fff&background=C53030' }}" 
                                 alt="Author Avatar"
                                 class="w-20 h-20 rounded-full border-2 border-primary/30 shadow-lg">
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center border-2 border-white">
                                <i class="fas fa-pen text-white text-xs"></i>
                            </div>
                        </div>
                        <h4 id="previewName" class="text-xl font-bold text-gray-900 mb-2">
                            {{ $author->name ?? 'Author Name' }}
                        </h4>
                        <p id="previewSlug" class="text-sm text-gray-500 font-mono mb-3">
                            {{ $author->slug ?? 'author-slug' }}
                        </p>
                        <p id="previewEmail" class="text-sm text-gray-600 mb-4" style="{{ isset($author) && $author->email ? '' : 'display: none;' }}">
                            <i class="fas fa-envelope mr-1"></i>
                            {{ $author->email ?? '' }}
                        </p>
                        <p id="previewBio" class="text-gray-600 text-sm leading-relaxed mb-4">
                            {{ $author->bio ?? 'Author biography will appear here' }}
                        </p>
                        <div id="previewSocial" class="flex justify-center space-x-3" style="{{ (isset($author) && $author->getSocialLinks()) ? '' : 'display: none;' }}">
                            @if(isset($author) && $author->getSocialLinks())
                                @foreach($author->getSocialLinks() as $platform => $link)
                                    <a href="{{ $link }}" target="_blank" class="text-gray-400 hover:text-primary">
                                        <i class="fab fa-{{ $platform }} text-lg"></i>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4 text-center">This is how the author will appear on the blog</p>
                </div>
            </div>
            
            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Pro Tips
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Professional Photo</p>
                            <p class="text-xs text-gray-600">Use a clear, professional headshot for better engagement</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Compelling Bio</p>
                            <p class="text-xs text-gray-600">Write an engaging biography that builds trust with readers</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Social Presence</p>
                            <p class="text-xs text-gray-600">Add social links to help readers connect with the author</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">SEO Optimization</p>
                            <p class="text-xs text-gray-600">Fill in meta descriptions for better search visibility</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Card (Edit Mode) -->
            @if(isset($author))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Author Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                            <div class="text-2xl font-bold text-blue-600">{{ $author->getPostsCount() }}</div>
                            <div class="text-sm text-blue-700">Posts</div>
                        </div>
                        <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                            <div class="text-2xl font-bold text-green-600">{{ $author->isActive() ? 'Active' : 'Inactive' }}</div>
                            <div class="text-sm text-green-700">Status</div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Created:</span>
                            <span>{{ $author->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Last Updated:</span>
                            <span>{{ $author->updated_at->diffForHumans() }}</span>
                        </div>
                        @if($author->getPostsCount() > 0)
                            <div class="pt-2 border-t border-gray-200">
                                <a href="{{ route('admin.blog.posts.index', ['author' => $author->id]) }}" 
                                   class="text-primary hover:text-secondary text-sm font-medium">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    View Author's Posts
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('blog.author', $author->slug) }}" 
                                   target="_blank"
                                   class="text-green-600 hover:text-green-700 text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>
                                    View Author Page
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('slug').value = slug;
    
    // Update preview
    document.getElementById('previewName').textContent = name || 'Author Name';
    document.getElementById('previewSlug').textContent = slug || 'author-slug';
    
    // Update avatar URL if no custom avatar
    if (!document.getElementById('avatar').files.length) {
        document.getElementById('previewAvatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name || 'Author')}&color=fff&background=C53030`;
    }
});

// Email preview
document.getElementById('email').addEventListener('input', function() {
    const email = this.value;
    const previewEmail = document.getElementById('previewEmail');
    if (email) {
        previewEmail.innerHTML = `<i class="fas fa-envelope mr-1"></i>${email}`;
        previewEmail.style.display = 'block';
    } else {
        previewEmail.style.display = 'none';
    }
});

// Bio preview
document.getElementById('bio').addEventListener('input', function() {
    const bio = this.value;
    document.getElementById('previewBio').textContent = bio || 'Author biography will appear here';
});

// Avatar preview
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').classList.remove('hidden');
            document.getElementById('previewAvatarImg').src = e.target.result;
            document.getElementById('previewAvatar').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAvatarPreview() {
    document.getElementById('avatarPreview').classList.add('hidden');
    document.getElementById('avatar').value = '';
    
    // Reset to default avatar
    const name = document.getElementById('name').value || 'Author';
    document.getElementById('previewAvatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&color=fff&background=C53030`;
}

// Social links preview
function updateSocialPreview() {
    const socialContainer = document.getElementById('previewSocial');
    const platforms = ['linkedin', 'twitter', 'facebook', 'instagram'];
    let hasLinks = false;
    let socialHTML = '';
    
    platforms.forEach(platform => {
        const input = document.querySelector(`input[name="social_links[${platform}]"]`);
        if (input && input.value.trim()) {
            hasLinks = true;
            socialHTML += `<a href="${input.value}" target="_blank" class="text-gray-400 hover:text-primary">
                <i class="fab fa-${platform} text-lg"></i>
            </a>`;
        }
    });
    
    if (hasLinks) {
        socialContainer.innerHTML = socialHTML;
        socialContainer.style.display = 'flex';
    } else {
        socialContainer.style.display = 'none';
    }
}

// Add event listeners for social links
['linkedin', 'twitter', 'facebook', 'instagram'].forEach(platform => {
    const input = document.querySelector(`input[name="social_links[${platform}]"]`);
    if (input) {
        input.addEventListener('input', updateSocialPreview);
    }
});

// Drag and drop for avatar
const avatarDropZone = document.getElementById('avatarDropZone');
if (avatarDropZone) {
    avatarDropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-primary', 'bg-primary/10');
    });

    avatarDropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-primary', 'bg-primary/10');
    });

    avatarDropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-primary', 'bg-primary/10');
        
        const files = e.dataTransfer.files;
        if (files.length > 0 && files[0].type.startsWith('image/')) {
            const input = document.getElementById('avatar');
            input.files = files;
            previewAvatar(input);
        }
    });
}

// Form submission with loading state
document.getElementById('authorForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
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
addCharacterCounter('bio', 1000);
addCharacterCounter('meta_title', 60);
addCharacterCounter('meta_description', 160);

// Initialize preview on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial preview values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const bio = document.getElementById('bio').value;
    
    if (name) {
        document.getElementById('previewName').textContent = name;
        document.getElementById('previewSlug').textContent = document.getElementById('slug').value || name.toLowerCase().replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-');
    }
    if (email) {
        const previewEmail = document.getElementById('previewEmail');
        previewEmail.innerHTML = `<i class="fas fa-envelope mr-1"></i>${email}`;
        previewEmail.style.display = 'block';
    }
    if (bio) {
        document.getElementById('previewBio').textContent = bio;
    }
    
    // Update social preview
    updateSocialPreview();
});

// URL validation for social links
function validateSocialUrl(input, platform) {
    const value = input.value.trim();
    if (value && !value.startsWith('http')) {
        input.value = 'https://' + value;
    }
}

// Add URL validation to social inputs
['linkedin', 'twitter', 'facebook', 'instagram'].forEach(platform => {
    const input = document.querySelector(`input[name="social_links[${platform}]"]`);
    if (input) {
        input.addEventListener('blur', function() {
            validateSocialUrl(this, platform);
            updateSocialPreview();
        });
    }
});
</script>
@endpush