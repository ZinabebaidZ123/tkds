@extends('admin.layouts.app')

@section('title', isset($teamMember) ? 'Edit Team Member' : 'Add Team Member')
@section('page-title', isset($teamMember) ? 'Edit Team Member' : 'Add Team Member')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.team-members.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.team-members.index') }}" class="hover:text-primary transition-colors duration-200">Team Members</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($teamMember) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($teamMember) ? 'Edit' : 'Add New' }} Team Member
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($teamMember) ? 'Update the' : 'Create a new' }} team member profile</p>
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
                        <i class="fas fa-user mr-2 text-primary"></i>
                        Member Information
                    </h3>
                </div>
                
                <form action="{{ isset($teamMember) ? route('admin.team-members.update', $teamMember) : route('admin.team-members.store') }}" 
                      method="POST" enctype="multipart/form-data" class="p-6 space-y-6" id="memberForm">
                    @csrf
                    @if(isset($teamMember))
                        @method('PUT')
                    @endif
                    
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-user mr-2 text-primary"></i>
                                Full Name
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $teamMember->name ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="Enter full name"
                                   required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div class="space-y-2">
                            <label for="position" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-briefcase mr-2 text-primary"></i>
                                Position/Title
                            </label>
                            <input type="text" 
                                   id="position" 
                                   name="position" 
                                   value="{{ old('position', $teamMember->position ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('position') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="e.g., CEO & Founder"
                                   required>
                            @error('position')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-envelope mr-2 text-primary"></i>
                                Email Address
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $teamMember->email ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('email') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="email@company.com">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-phone mr-2 text-primary"></i>
                                Phone Number
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $teamMember->phone ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('phone') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="+1 (555) 123-4567">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="space-y-2">
                        <label for="bio" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-align-left mr-2 text-primary"></i>
                            Bio/Description
                        </label>
                        <textarea id="bio" 
                                  name="bio" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('bio') border-red-500 ring-2 ring-red-200 @enderror"
                                  placeholder="Brief description about the team member">{{ old('bio', $teamMember->bio ?? '') }}</textarea>
                        @error('bio')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Keep it concise and professional</p>
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-image mr-2 text-primary"></i>
                            Profile Photo {{ isset($teamMember) ? '(Optional - leave empty to keep current)' : '' }}
                        </label>
                        
                        <!-- Current Image Preview (Edit mode) -->
                        @if(isset($teamMember))
                            <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Photo:</p>
                                <img src="{{ $teamMember->getImageUrl() }}" 
                                     alt="{{ $teamMember->name }}"
                                     class="w-32 h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
                            </div>
                        @endif
                        
                        <!-- Upload Area -->
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5" id="dropZone">
                            <div class="space-y-4 text-center">
                                <div class="mx-auto h-16 w-16 text-gray-400">
                                    <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                </div>
                                <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary px-3 py-1 border border-primary/20">
                                        <span>Choose photo</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" 
                                               {{ !isset($teamMember) ? 'required' : '' }} onchange="previewImage(this)">
                                    </label>
                                    <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB • Recommended: 400x400px</p>
                            </div>
                        </div>
                        
                        <!-- New Image Preview -->
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">New Photo Preview:</p>
                            <div class="relative inline-block">
                                <img id="previewImg" class="w-32 h-32 object-cover rounded-lg border border-gray-300 shadow-sm" />
                                <button type="button" onclick="removePreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Social Media Links -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-share-alt mr-2 text-primary"></i>
                            Social Media Links
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- LinkedIn -->
                            <div class="space-y-2">
                                <label for="linkedin_url" class="block text-sm font-semibold text-gray-700">
                                    <i class="fab fa-linkedin mr-2 text-blue-600"></i>
                                    LinkedIn Profile
                                </label>
                                <input type="url" 
                                       id="linkedin_url" 
                                       name="linkedin_url" 
                                       value="{{ old('linkedin_url', $teamMember->linkedin_url ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('linkedin_url') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="https://linkedin.com/in/username">
                                @error('linkedin_url')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Twitter -->
                            <div class="space-y-2">
                                <label for="twitter_url" class="block text-sm font-semibold text-gray-700">
                                    <i class="fab fa-twitter mr-2 text-blue-400"></i>
                                    Twitter Profile
                                </label>
                                <input type="url" 
                                       id="twitter_url" 
                                       name="twitter_url" 
                                       value="{{ old('twitter_url', $teamMember->twitter_url ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('twitter_url') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="https://twitter.com/username">
                                @error('twitter_url')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Facebook -->
                            <div class="space-y-2">
                                <label for="facebook_url" class="block text-sm font-semibold text-gray-700">
                                    <i class="fab fa-facebook mr-2 text-blue-700"></i>
                                    Facebook Profile
                                </label>
                                <input type="url" 
                                       id="facebook_url" 
                                       name="facebook_url" 
                                       value="{{ old('facebook_url', $teamMember->facebook_url ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('facebook_url') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="https://facebook.com/username">
                                @error('facebook_url')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Instagram -->
                            <div class="space-y-2">
                                <label for="instagram_url" class="block text-sm font-semibold text-gray-700">
                                    <i class="fab fa-instagram mr-2 text-pink-600"></i>
                                    Instagram Profile
                                </label>
                                <input type="url" 
                                       id="instagram_url" 
                                       name="instagram_url" 
                                       value="{{ old('instagram_url', $teamMember->instagram_url ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('instagram_url') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="https://instagram.com/username">
                                @error('instagram_url')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Display Order & Status -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="sort_order" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-sort mr-2 text-primary"></i>
                                Display Order
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $teamMember->sort_order ?? 1) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror"
                                   required>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Lower numbers appear first in the team showcase</p>
                        </div>

                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-toggle-on mr-2 text-primary"></i>
                                Status
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="active" {{ old('status', $teamMember->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                    ✅ Active (Visible in team showcase)
                                </option>
                                <option value="inactive" {{ old('status', $teamMember->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                    ❌ Inactive (Hidden from team showcase)
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.team-members.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($teamMember) ? 'Update' : 'Create' }} Member</span>
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
                    <div class="bg-gray-900 rounded-xl overflow-hidden">
                        <div class="relative">
                            <div id="previewImage" class="w-full h-48 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                @if(isset($teamMember))
                                    <img src="{{ $teamMember->getImageUrl() }}" alt="Preview" class="w-full h-full object-cover">
                                @else
                                    <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-2xl text-primary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        </div>
                        <div class="p-4 text-center text-white">
                            <h4 id="previewName" class="text-lg font-bold">
                                {{ $teamMember->name ?? 'Member Name' }}
                            </h4>
                            <p id="previewPosition" class="text-sm text-gray-300">
                                {{ $teamMember->position ?? 'Position Title' }}
                            </p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">This is how the member will appear in the team carousel</p>
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
                            <p class="text-sm font-medium text-gray-800">Photo Quality</p>
                            <p class="text-xs text-gray-600">Use high-resolution square photos (400x400px) for best results</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Professional Look</p>
                            <p class="text-xs text-gray-600">Choose professional headshots with good lighting</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Bio Length</p>
                            <p class="text-xs text-gray-600">Keep bios concise and highlight key achievements</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Social Links</p>
                            <p class="text-xs text-gray-600">Add professional social media profiles to build trust</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Card -->
            @if(isset($teamMember))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Member Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Added</span>
                        <span class="text-sm font-medium text-gray-900">{{ $teamMember->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $teamMember->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $teamMember->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($teamMember->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Social Links</span>
                        <span class="text-sm font-medium text-gray-900">{{ count($teamMember->getSocialLinks()) }}</span>
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
// Image preview functionality
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('previewImg').src = e.target.result;
            
            // Update live preview
            const previewDiv = document.getElementById('previewImage');
            previewDiv.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove preview
function removePreview() {
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('previewImg').src = '';
    document.getElementById('image').value = '';
    
    // Reset live preview
    const previewDiv = document.getElementById('previewImage');
    previewDiv.innerHTML = `
        <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center">
            <i class="fas fa-user text-2xl text-primary"></i>
        </div>
    `;
}

// Live preview updates
document.getElementById('name').addEventListener('input', function() {
    const previewName = document.getElementById('previewName');
    previewName.textContent = this.value || 'Member Name';
});

document.getElementById('position').addEventListener('input', function() {
    const previewPosition = document.getElementById('previewPosition');
    previewPosition.textContent = this.value || 'Position Title';
});

// Drag and drop functionality
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('image');

dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-primary', 'bg-primary/10');
});

dropZone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-primary', 'bg-primary/10');
});

dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-primary', 'bg-primary/10');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        previewImage(fileInput);
    }
});

// Form submission with loading state
document.getElementById('memberForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
});

// URL validation for social links
const urlInputs = ['linkedin_url', 'twitter_url', 'facebook_url', 'instagram_url'];
urlInputs.forEach(inputId => {
    const input = document.getElementById(inputId);
    input.addEventListener('blur', function() {
        if (this.value && !this.value.startsWith('http')) {
            this.value = 'https://' + this.value;
        }
    });
});

// Character counters
function addCharacterCounter(inputId, maxLength) {
    const input = document.getElementById(inputId);
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
addCharacterCounter('name', 255);
addCharacterCounter('position', 255);
addCharacterCounter('bio', 1000);

// Auto-resize textarea
document.getElementById('bio').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});
</script>
@endpush