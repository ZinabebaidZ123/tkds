{{-- Path: resources/views/admin/about/settings.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'About Page Settings')
@section('page-title', 'About Page Settings')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">About Page Settings</h2>
            <p class="text-gray-600 text-sm mt-1">Configure the content displayed on your About page</p>
        </div>
        <a href="{{ route('about') }}" target="_blank" 
           class="inline-flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-external-link-alt mr-2"></i>
            Preview Page
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

    <!-- Settings Form -->
    <form action="{{ route('admin.about.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Hero Section -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-star mr-2 text-blue-600"></i>
                            Hero Section
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        <!-- Hero Badge -->
                        <div class="space-y-2">
                            <label for="hero_badge_text" class="block text-sm font-semibold text-gray-700">
                                Badge Text
                            </label>
                            <input type="text" 
                                   id="hero_badge_text" 
                                   name="hero_badge_text" 
                                   value="{{ old('hero_badge_text', $settings->hero_badge_text) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="About Us">
                            @error('hero_badge_text')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hero Title -->
                        <div class="space-y-2">
                            <label for="hero_title" class="block text-sm font-semibold text-gray-700">
                                Main Title *
                            </label>
                            <input type="text" 
                                   id="hero_title" 
                                   name="hero_title" 
                                   value="{{ old('hero_title', $settings->hero_title) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="Leading the Future of Digital Broadcasting"
                                   required>
                            @error('hero_title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hero Subtitle -->
                        <div class="space-y-2">
                            <label for="hero_subtitle" class="block text-sm font-semibold text-gray-700">
                                Subtitle
                            </label>
                            <textarea id="hero_subtitle" 
                                      name="hero_subtitle" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                      placeholder="Brief description under the main title">{{ old('hero_subtitle', $settings->hero_subtitle) }}</textarea>
                            @error('hero_subtitle')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hero Description -->
                        <div class="space-y-2">
                            <label for="hero_description" class="block text-sm font-semibold text-gray-700">
                                Description
                            </label>
                            <textarea id="hero_description" 
                                      name="hero_description" 
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                      placeholder="Longer description for the hero section">{{ old('hero_description', $settings->hero_description) }}</textarea>
                            @error('hero_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Mission & Innovation Section -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-bullseye mr-2 text-green-600"></i>
                            Mission & Innovation
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        <!-- Mission Section -->
                        <div class="grid grid-cols-1 gap-6">
                            <div class="space-y-2">
                                <label for="mission_title" class="block text-sm font-semibold text-gray-700">
                                    Mission Title
                                </label>
                                <input type="text" 
                                       id="mission_title" 
                                       name="mission_title" 
                                       value="{{ old('mission_title', $settings->mission_title) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="Our Mission">
                            </div>
                            
                            <div class="space-y-2">
                                <label for="mission_content" class="block text-sm font-semibold text-gray-700">
                                    Mission Content
                                </label>
                                <textarea id="mission_content" 
                                          name="mission_content" 
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                          placeholder="Describe your company's mission">{{ old('mission_content', $settings->mission_content) }}</textarea>
                            </div>
                        </div>

                        <!-- Innovation Section -->
                        <div class="grid grid-cols-1 gap-6">
                            <div class="space-y-2">
                                <label for="innovation_title" class="block text-sm font-semibold text-gray-700">
                                    Innovation Title
                                </label>
                                <input type="text" 
                                       id="innovation_title" 
                                       name="innovation_title" 
                                       value="{{ old('innovation_title', $settings->innovation_title) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="Innovation at Our Core">
                            </div>
                            
                            <div class="space-y-2">
                                <label for="innovation_content" class="block text-sm font-semibold text-gray-700">
                                    Innovation Content
                                </label>
                                <textarea id="innovation_content" 
                                          name="innovation_content" 
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                          placeholder="Describe your innovation approach">{{ old('innovation_content', $settings->innovation_content) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-purple-600"></i>
                            Statistics & Performance
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        <!-- Key Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-800">Stat 1</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="stat_1_number" class="block text-sm font-medium text-gray-700">Number</label>
                                        <input type="text" 
                                               id="stat_1_number" 
                                               name="stat_1_number" 
                                               value="{{ old('stat_1_number', $settings->stat_1_number) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                               placeholder="10K+">
                                    </div>
                                    <div class="space-y-2">
                                        <label for="stat_1_label" class="block text-sm font-medium text-gray-700">Label</label>
                                        <input type="text" 
                                               id="stat_1_label" 
                                               name="stat_1_label" 
                                               value="{{ old('stat_1_label', $settings->stat_1_label) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                               placeholder="Active Users">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-800">Stat 2</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="stat_2_number" class="block text-sm font-medium text-gray-700">Number</label>
                                        <input type="text" 
                                               id="stat_2_number" 
                                               name="stat_2_number" 
                                               value="{{ old('stat_2_number', $settings->stat_2_number) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                               placeholder="50+">
                                    </div>
                                    <div class="space-y-2">
                                        <label for="stat_2_label" class="block text-sm font-medium text-gray-700">Label</label>
                                        <input type="text" 
                                               id="stat_2_label" 
                                               name="stat_2_label" 
                                               value="{{ old('stat_2_label', $settings->stat_2_label) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                               placeholder="Countries">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Stats -->
                        <div class="border-t pt-6">
                            <h4 class="font-semibold text-gray-800 mb-4">Performance Metrics</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label for="uptime_percentage" class="block text-sm font-medium text-gray-700">Uptime</label>
                                    <input type="text" 
                                           id="uptime_percentage" 
                                           name="uptime_percentage" 
                                           value="{{ old('uptime_percentage', $settings->uptime_percentage) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                           placeholder="99.9%">
                                </div>
                                <div class="space-y-2">
                                    <label for="latency_time" class="block text-sm font-medium text-gray-700">Latency</label>
                                    <input type="text" 
                                           id="latency_time" 
                                           name="latency_time" 
                                           value="{{ old('latency_time', $settings->latency_time) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                           placeholder="<1s">
                                </div>
                                <div class="space-y-2">
                                    <label for="quality_level" class="block text-sm font-medium text-gray-700">Quality</label>
                                    <input type="text" 
                                           id="quality_level" 
                                           name="quality_level" 
                                           value="{{ old('quality_level', $settings->quality_level) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                           placeholder="4K">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Section -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-video mr-2 text-red-600"></i>
                            Video Section
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        <!-- Video Enabled Toggle -->
                        <div class="flex items-center space-x-3">
                            <input type="hidden" name="video_enabled" value="0">
                            <input type="checkbox" 
                                   id="video_enabled" 
                                   name="video_enabled" 
                                   value="1"
                                   {{ old('video_enabled', $settings->video_enabled) ? 'checked' : '' }}
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <label for="video_enabled" class="text-sm font-medium text-gray-700">
                                Enable Video Section
                            </label>
                        </div>

                        <!-- Video URL -->
                        <div class="space-y-2">
                            <label for="video_url" class="block text-sm font-semibold text-gray-700">
                                Video URL
                            </label>
                            <input type="url" 
                                   id="video_url" 
                                   name="video_url" 
                                   value="{{ old('video_url', $settings->video_url) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="https://youtube.com/watch?v=...">
                            @error('video_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Video Thumbnail -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Video Thumbnail
                            </label>
                            
                            @if($settings->video_thumbnail)
                            <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Thumbnail:</p>
                                <img src="{{ $settings->getVideoThumbnailUrl() }}" 
                                     alt="Video Thumbnail"
                                     class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
                            </div>
                            @endif
                            
                            <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5">
                                <div class="space-y-4 text-center">
                                    <div class="mx-auto h-16 w-16 text-gray-400">
                                        <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                    </div>
                                    <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                        <label for="video_thumbnail" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary px-3 py-1 border border-primary/20">
                                            <span>Choose file</span>
                                            <input id="video_thumbnail" name="video_thumbnail" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                            
                            @error('video_thumbnail')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO & Meta Section -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-search mr-2 text-indigo-600"></i>
                            SEO & Meta Data
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
                                   value="{{ old('meta_title', $settings->meta_title) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="TKDS Media - About Us"
                                   maxlength="60">
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Recommended: 50-60 characters</span>
                                <span id="meta-title-count">{{ strlen($settings->meta_title ?? '') }}/60</span>
                            </div>
                            @error('meta_title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="space-y-2">
                            <label for="meta_description" class="block text-sm font-semibold text-gray-700">
                                Meta Description
                            </label>
                            <textarea id="meta_description" 
                                      name="meta_description" 
                                      rows="3"
                                      maxlength="160"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                      placeholder="Leading digital broadcasting solutions...">{{ old('meta_description', $settings->meta_description) }}</textarea>
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Recommended: 150-160 characters</span>
                                <span id="meta-description-count">{{ strlen($settings->meta_description ?? '') }}/160</span>
                            </div>
                            @error('meta_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Status & Actions -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-cog mr-2 text-gray-600"></i>
                            Settings
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        <!-- Status -->
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">
                                Page Status
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                    required>
                                <option value="active" {{ old('status', $settings->status) === 'active' ? 'selected' : '' }}>
                                    ✅ Active (Page is live)
                                </option>
                                <option value="inactive" {{ old('status', $settings->status) === 'inactive' ? 'selected' : '' }}>
                                    ❌ Inactive (Page is hidden)
                                </option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3 pt-4 border-t border-gray-200">
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>
                                Save Settings
                            </button>
                            
                            <a href="{{ route('about') }}" 
                               target="_blank"
                               class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200 font-medium">
                                <i class="fas fa-eye mr-2"></i>
                                Preview Page
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-link mr-2 text-blue-600"></i>
                            Quick Links
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.about.values.index') }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-heart text-red-500"></i>
                            <span class="text-gray-700">Manage Values</span>
                            <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                        </a>
                        
                        <a href="{{ route('admin.about.timeline.index') }}" 
                           class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-history text-blue-500"></i>
                            <span class="text-gray-700">Manage Timeline</span>
                            <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
                        </a>
                    </div>
                </div>

                <!-- Tips -->
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
                                <p class="text-sm font-medium text-gray-800">SEO Optimization</p>
                                <p class="text-xs text-gray-600">Keep titles under 60 characters and descriptions under 160 for best results</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Content Quality</p>
                                <p class="text-xs text-gray-600">Use clear, compelling language that reflects your brand voice</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Video Tips</p>
                                <p class="text-xs text-gray-600">Use high-quality thumbnails and ensure video URLs are accessible</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Character counters
document.getElementById('meta_title').addEventListener('input', function() {
    document.getElementById('meta-title-count').textContent = this.value.length + '/60';
});

document.getElementById('meta_description').addEventListener('input', function() {
    document.getElementById('meta-description-count').textContent = this.value.length + '/160';
});

// Form submission with loading state
document.querySelector('form').addEventListener('submit', function() {
    const submitBtn = document.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
});

// Video thumbnail preview
document.getElementById('video_thumbnail').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Create preview if it doesn't exist
            let preview = document.getElementById('thumbnail-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'thumbnail-preview';
                preview.className = 'mt-4 p-4 bg-gray-50 rounded-xl border border-gray-200';
                preview.innerHTML = `
                    <p class="text-sm font-medium text-gray-700 mb-2">New Thumbnail Preview:</p>
                    <div class="relative inline-block">
                        <img id="preview-img" class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm" />
                        <button type="button" onclick="removePreview()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors duration-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                e.target.closest('.space-y-2').appendChild(preview);
            }
            
            document.getElementById('preview-img').src = e.target.result;
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// Remove thumbnail preview
function removePreview() {
    const preview = document.getElementById('thumbnail-preview');
    if (preview) {
        preview.remove();
    }
    document.getElementById('video_thumbnail').value = '';
}

// Auto-save draft functionality (optional)
let autoSaveTimeout;
function autoSave() {
    clearTimeout(autoSaveTimeout);
    autoSaveTimeout = setTimeout(() => {
        // You can implement auto-save functionality here
        console.log('Auto-saving draft...');
    }, 5000); // Save after 5 seconds of inactivity
}

// Add auto-save to major fields
['hero_title', 'hero_subtitle', 'mission_content', 'innovation_content'].forEach(fieldId => {
    const field = document.getElementById(fieldId);
    if (field) {
        field.addEventListener('input', autoSave);
    }
});

// Confirm before leaving if form has changes
let formChanged = false;
document.querySelectorAll('input, textarea, select').forEach(element => {
    element.addEventListener('change', () => {
        formChanged = true;
    });
});

window.addEventListener('beforeunload', function(e) {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
    }
});

// Reset form changed flag on successful submit
document.querySelector('form').addEventListener('submit', function() {
    formChanged = false;
});
</script>
@endpush