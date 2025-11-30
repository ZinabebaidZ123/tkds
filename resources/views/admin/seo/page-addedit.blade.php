@extends('admin.layouts.app')

@section('title', isset($pageSeoSetting) ? 'Edit Page SEO' : 'Add Page SEO')
@section('page-title', isset($pageSeoSetting) ? 'Edit Page SEO' : 'Add Page SEO')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.seo.page-settings') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.seo.page-settings') }}" class="hover:text-primary transition-colors duration-200">Page SEO Settings</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($pageSeoSetting) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($pageSeoSetting) ? 'Edit' : 'Add New' }} Page SEO
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($pageSeoSetting) ? 'Update the' : 'Create new' }} SEO settings for this page</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <form action="{{ isset($pageSeoSetting) ? route('admin.seo.page-settings.update', $pageSeoSetting) : route('admin.seo.page-settings.store') }}" 
                      method="POST" enctype="multipart/form-data" class="space-y-0" id="seoForm">
                    @csrf
                    @if(isset($pageSeoSetting))
                        @method('PUT')
                    @endif
                    
                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200">
                        <nav class="flex space-x-8 px-6 pt-4" aria-label="Tabs">
                            <button type="button" class="tab-button active" data-tab="basic">
                                <i class="fas fa-info-circle mr-2"></i>
                                Basic Info
                            </button>
                            <button type="button" class="tab-button" data-tab="meta">
                                <i class="fas fa-tags mr-2"></i>
                                Meta Tags
                            </button>
                            <button type="button" class="tab-button" data-tab="social">
                                <i class="fas fa-share-alt mr-2"></i>
                                Social Media
                            </button>
                            <button type="button" class="tab-button" data-tab="advanced">
                                <i class="fas fa-cog mr-2"></i>
                                Advanced
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        
                        <!-- Basic Info Tab -->
                        <div class="tab-content active" id="basic-tab">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-primary"></i>
                                Basic Page Information
                            </h3>
                            
                            <div class="space-y-6">
                                <!-- Page Route -->
                                <div class="space-y-2">
                                    <label for="page_route" class="block text-sm font-semibold text-gray-700">
                                        Page Route *
                                    </label>
                                    <input type="text" 
                                           id="page_route" 
                                           name="page_route" 
                                           value="{{ old('page_route', $pageSeoSetting->page_route ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('page_route') border-red-500 ring-2 ring-red-200 @enderror"
                                           placeholder="e.g., home, about, services"
                                           required>
                                    @error('page_route')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="text-xs text-gray-500">Internal route name (e.g., home, about, contact)</p>
                                </div>

                                <!-- Page Title -->
                                <div class="space-y-2">
                                    <label for="page_title" class="block text-sm font-semibold text-gray-700">
                                        Page Title *
                                    </label>
                                    <input type="text" 
                                           id="page_title" 
                                           name="page_title" 
                                           value="{{ old('page_title', $pageSeoSetting->page_title ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('page_title') border-red-500 ring-2 ring-red-200 @enderror"
                                           placeholder="e.g., Home Page"
                                           required>
                                    @error('page_title')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Canonical URL -->
                                <div class="space-y-2">
                                    <label for="canonical_url" class="block text-sm font-semibold text-gray-700">
                                        Canonical URL
                                    </label>
                                    <input type="url" 
                                           id="canonical_url" 
                                           name="canonical_url" 
                                           value="{{ old('canonical_url', $pageSeoSetting->canonical_url ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('canonical_url') border-red-500 ring-2 ring-red-200 @enderror"
                                           placeholder="https://example.com/page">
                                    @error('canonical_url')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="text-xs text-gray-500">Leave empty to auto-generate</p>
                                </div>

                                <!-- Robots -->
                                <div class="space-y-2">
                                    <label for="robots" class="block text-sm font-semibold text-gray-700">
                                        Robots Meta Tag
                                    </label>
                                    <select id="robots" 
                                            name="robots" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                        <option value="index,follow" {{ old('robots', $pageSeoSetting->robots ?? 'index,follow') === 'index,follow' ? 'selected' : '' }}>
                                            Index, Follow (Default)
                                        </option>
                                        <option value="index,nofollow" {{ old('robots', $pageSeoSetting->robots ?? '') === 'index,nofollow' ? 'selected' : '' }}>
                                            Index, No Follow
                                        </option>
                                        <option value="noindex,follow" {{ old('robots', $pageSeoSetting->robots ?? '') === 'noindex,follow' ? 'selected' : '' }}>
                                            No Index, Follow
                                        </option>
                                        <option value="noindex,nofollow" {{ old('robots', $pageSeoSetting->robots ?? '') === 'noindex,nofollow' ? 'selected' : '' }}>
                                            No Index, No Follow
                                        </option>
                                    </select>
                                </div>

                                <!-- Sitemap Settings -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="priority" class="block text-sm font-semibold text-gray-700">
                                            Sitemap Priority
                                        </label>
                                        <input type="number" 
                                               id="priority" 
                                               name="priority" 
                                               value="{{ old('priority', $pageSeoSetting->priority ?? 0.8) }}"
                                               min="0.0" max="1.0" step="0.1"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                        <p class="text-xs text-gray-500">0.0 - 1.0 (1.0 = highest priority)</p>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="change_frequency" class="block text-sm font-semibold text-gray-700">
                                            Change Frequency
                                        </label>
                                        <select id="change_frequency" 
                                                name="change_frequency" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                            <option value="weekly" {{ old('change_frequency', $pageSeoSetting->change_frequency ?? 'weekly') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                            <option value="daily" {{ old('change_frequency', $pageSeoSetting->change_frequency ?? '') === 'daily' ? 'selected' : '' }}>Daily</option>
                                            <option value="monthly" {{ old('change_frequency', $pageSeoSetting->change_frequency ?? '') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="yearly" {{ old('change_frequency', $pageSeoSetting->change_frequency ?? '') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                            <option value="never" {{ old('change_frequency', $pageSeoSetting->change_frequency ?? '') === 'never' ? 'selected' : '' }}>Never</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Meta Tags Tab -->
                        <div class="tab-content" id="meta-tab">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-tags mr-2 text-primary"></i>
                                Meta Tags
                            </h3>
                            
                            <div class="space-y-6">
                                <!-- Meta Title -->
                                <div class="space-y-2">
                                    <label for="meta_title" class="block text-sm font-semibold text-gray-700">
                                        Meta Title
                                    </label>
                                    <input type="text" 
                                           id="meta_title" 
                                           name="meta_title" 
                                           value="{{ old('meta_title', $pageSeoSetting->meta_title ?? '') }}"
                                           maxlength="60"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                           placeholder="SEO title for search engines">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-500">Optimal: 50-60 characters</span>
                                        <span id="meta-title-count" class="text-gray-500">0/60</span>
                                    </div>
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
                                              placeholder="Brief description for search results">{{ old('meta_description', $pageSeoSetting->meta_description ?? '') }}</textarea>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-500">Optimal: 150-160 characters</span>
                                        <span id="meta-description-count" class="text-gray-500">0/160</span>
                                    </div>
                                </div>

                                <!-- Meta Keywords -->
                                <div class="space-y-2">
                                    <label for="meta_keywords" class="block text-sm font-semibold text-gray-700">
                                        Meta Keywords
                                    </label>
                                    <input type="text" 
                                           id="meta_keywords" 
                                           name="meta_keywords" 
                                           value="{{ old('meta_keywords', $pageSeoSetting->meta_keywords ?? '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                           placeholder="keyword1, keyword2, keyword3">
                                    <p class="text-xs text-gray-500">Separate keywords with commas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Tab -->
                        <div class="tab-content" id="social-tab">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-share-alt mr-2 text-primary"></i>
                                Social Media Optimization
                            </h3>
                            
                            <div class="space-y-8">
                                <!-- Open Graph -->
                                <div class="space-y-4">
                                    <h4 class="text-md font-semibold text-gray-800 flex items-center">
                                        <i class="fab fa-facebook mr-2 text-blue-600"></i>
                                        Open Graph (Facebook)
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 gap-4">
                                        <!-- OG Title -->
                                        <div class="space-y-2">
                                            <label for="og_title" class="block text-sm font-semibold text-gray-700">
                                                OG Title
                                            </label>
                                            <input type="text" 
                                                   id="og_title" 
                                                   name="og_title" 
                                                   value="{{ old('og_title', $pageSeoSetting->og_title ?? '') }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                                   placeholder="Title for social media sharing">
                                        </div>

                                        <!-- OG Description -->
                                        <div class="space-y-2">
                                            <label for="og_description" class="block text-sm font-semibold text-gray-700">
                                                OG Description
                                            </label>
                                            <textarea id="og_description" 
                                                      name="og_description" 
                                                      rows="3"
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                                      placeholder="Description for social media sharing">{{ old('og_description', $pageSeoSetting->og_description ?? '') }}</textarea>
                                        </div>

                                        <!-- OG Image -->
                                        <div class="space-y-2">
                                            <label class="block text-sm font-semibold text-gray-700">
                                                OG Image
                                            </label>
                                            @if(isset($pageSeoSetting) && $pageSeoSetting->og_image)
                                                <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                                    <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                                                    <img src="{{ $pageSeoSetting->getOgImageUrl() }}" alt="Current OG Image" class="max-h-32 rounded-lg">
                                                </div>
                                            @endif
                                            <input type="file" 
                                                   id="og_image" 
                                                   name="og_image" 
                                                   accept="image/*"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                            <p class="text-xs text-gray-500">Recommended: 1200x630 pixels</p>
                                        </div>

                                        <!-- OG Type -->
                                        <div class="space-y-2">
                                            <label for="og_type" class="block text-sm font-semibold text-gray-700">
                                                OG Type
                                            </label>
                                            <select id="og_type" 
                                                    name="og_type" 
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                                <option value="website" {{ old('og_type', $pageSeoSetting->og_type ?? 'website') === 'website' ? 'selected' : '' }}>Website</option>
                                                <option value="article" {{ old('og_type', $pageSeoSetting->og_type ?? '') === 'article' ? 'selected' : '' }}>Article</option>
                                                <option value="product" {{ old('og_type', $pageSeoSetting->og_type ?? '') === 'product' ? 'selected' : '' }}>Product</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Twitter Cards -->
                                <div class="space-y-4">
                                    <h4 class="text-md font-semibold text-gray-800 flex items-center">
                                        <i class="fab fa-twitter mr-2 text-blue-400"></i>
                                        Twitter Cards
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 gap-4">
                                        <!-- Twitter Title -->
                                        <div class="space-y-2">
                                            <label for="twitter_title" class="block text-sm font-semibold text-gray-700">
                                                Twitter Title
                                            </label>
                                            <input type="text" 
                                                   id="twitter_title" 
                                                   name="twitter_title" 
                                                   value="{{ old('twitter_title', $pageSeoSetting->twitter_title ?? '') }}"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                                   placeholder="Title for Twitter sharing">
                                        </div>

                                        <!-- Twitter Description -->
                                        <div class="space-y-2">
                                            <label for="twitter_description" class="block text-sm font-semibold text-gray-700">
                                                Twitter Description
                                            </label>
                                            <textarea id="twitter_description" 
                                                      name="twitter_description" 
                                                      rows="3"
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                                      placeholder="Description for Twitter sharing">{{ old('twitter_description', $pageSeoSetting->twitter_description ?? '') }}</textarea>
                                        </div>

                                        <!-- Twitter Image -->
                                        <div class="space-y-2">
                                            <label class="block text-sm font-semibold text-gray-700">
                                                Twitter Image
                                            </label>
                                            @if(isset($pageSeoSetting) && $pageSeoSetting->twitter_image)
                                                <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                                    <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                                                    <img src="{{ $pageSeoSetting->getTwitterImageUrl() }}" alt="Current Twitter Image" class="max-h-32 rounded-lg">
                                                </div>
                                            @endif
                                            <input type="file" 
                                                   id="twitter_image" 
                                                   name="twitter_image" 
                                                   accept="image/*"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                            <p class="text-xs text-gray-500">Recommended: 1200x600 pixels</p>
                                        </div>

                                        <!-- Twitter Card Type -->
                                        <div class="space-y-2">
                                            <label for="twitter_card_type" class="block text-sm font-semibold text-gray-700">
                                                Twitter Card Type
                                            </label>
                                            <select id="twitter_card_type" 
                                                    name="twitter_card_type" 
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                                                <option value="summary_large_image" {{ old('twitter_card_type', $pageSeoSetting->twitter_card_type ?? 'summary_large_image') === 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
                                                <option value="summary" {{ old('twitter_card_type', $pageSeoSetting->twitter_card_type ?? '') === 'summary' ? 'selected' : '' }}>Summary</option>
                                                <option value="app" {{ old('twitter_card_type', $pageSeoSetting->twitter_card_type ?? '') === 'app' ? 'selected' : '' }}>App</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Tab -->
                        <div class="tab-content" id="advanced-tab">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-cog mr-2 text-primary"></i>
                                Advanced Settings
                            </h3>
                            
                            <div class="space-y-6">
                                <!-- Custom Head Code -->
                                <div class="space-y-2">
                                    <label for="custom_head_code" class="block text-sm font-semibold text-gray-700">
                                        Custom Head Code
                                    </label>
                                    <textarea id="custom_head_code" 
                                              name="custom_head_code" 
                                              rows="6"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none font-mono text-sm"
                                              placeholder="<!-- Custom meta tags, scripts, etc. -->">{{ old('custom_head_code', $pageSeoSetting->custom_head_code ?? '') }}</textarea>
                                    <p class="text-xs text-gray-500">Custom HTML code for this page's &lt;head&gt; section</p>
                                </div>

                                <!-- Custom Body Code -->
                                <div class="space-y-2">
                                    <label for="custom_body_code" class="block text-sm font-semibold text-gray-700">
                                        Custom Body Code
                                    </label>
                                    <textarea id="custom_body_code" 
                                              name="custom_body_code" 
                                              rows="6"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none font-mono text-sm"
                                              placeholder="<!-- Custom tracking scripts, etc. -->">{{ old('custom_body_code', $pageSeoSetting->custom_body_code ?? '') }}</textarea>
                                    <p class="text-xs text-gray-500">Custom HTML code after opening &lt;body&gt; tag</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Submit -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Status
                                    </label>
                                    <select id="status" 
                                            name="status" 
                                            class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                            required>
                                        <option value="active" {{ old('status', $pageSeoSetting->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                            ✅ Active (SEO enabled)
                                        </option>
                                        <option value="inactive" {{ old('status', $pageSeoSetting->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                            ❌ Inactive (SEO disabled)
                                        </option>
                                    </select>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                                    <a href="{{ route('admin.seo.page-settings') }}" 
                                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                            id="submitBtn">
                                        <i class="fas fa-save mr-2"></i>
                                        <span>{{ isset($pageSeoSetting) ? 'Update' : 'Create' }} SEO Settings</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar with Preview & Tips -->
        <div class="space-y-6">
            
            <!-- SEO Preview Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-search mr-2 text-blue-600"></i>
                        Search Preview
                    </h3>
                </div>
                <div class="p-6">
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div id="search-preview">
                            <div class="text-blue-600 text-lg hover:underline cursor-pointer" id="preview-title">
                                {{ $pageSeoSetting->meta_title ?? 'Page Title' }}
                            </div>
                            <div class="text-green-600 text-sm" id="preview-url">
                                {{ url('/') }}/{{ $pageSeoSetting->page_route ?? 'page' }}
                            </div>
                            <div class="text-gray-600 text-sm mt-1" id="preview-description">
                                {{ $pageSeoSetting->meta_description ?? 'Meta description will appear here...' }}
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">This is how your page will appear in search results</p>
                </div>
            </div>
            
            <!-- SEO Tips Card -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        SEO Tips
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Meta Title</p>
                            <p class="text-xs text-gray-600">Keep it under 60 characters and include your main keyword</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Meta Description</p>
                            <p class="text-xs text-gray-600">Write compelling descriptions under 160 characters</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Social Media</p>
                            <p class="text-xs text-gray-600">Add Open Graph and Twitter Card data for better sharing</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Images</p>
                            <p class="text-xs text-gray-600">Use high-quality images sized correctly for each platform</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Card -->
            @if(isset($pageSeoSetting))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        SEO Status
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $pageSeoSetting->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $pageSeoSetting->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $pageSeoSetting->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($pageSeoSetting->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">SEO Score</span>
                        @php
                            $score = 0;
                            if($pageSeoSetting->meta_title) $score += 25;
                            if($pageSeoSetting->meta_description) $score += 25;
                            if($pageSeoSetting->og_title && $pageSeoSetting->og_description) $score += 25;
                            if($pageSeoSetting->twitter_title && $pageSeoSetting->twitter_description) $score += 25;
                            
                            $scoreColor = $score >= 80 ? 'text-green-600 bg-green-100' : ($score >= 60 ? 'text-yellow-600 bg-yellow-100' : 'text-red-600 bg-red-100');
                        @endphp
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $scoreColor }}">
                            {{ $score }}%
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-2 text-primary"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <button type="button" onclick="copyFromMeta()" class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-copy mr-2"></i>
                        Copy Meta to Social
                    </button>
                    <button type="button" onclick="generateSlug()" class="w-full flex items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                        <i class="fas fa-magic mr-2"></i>
                        Generate Slug
                    </button>
                    <button type="button" onclick="previewPage()" class="w-full flex items-center justify-center px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors duration-200">
                        <i class="fas fa-eye mr-2"></i>
                        Preview Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tab-button {
    @apply py-2 px-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors duration-200;
}

.tab-button.active {
    @apply border-primary text-primary;
}

.tab-content {
    @apply hidden;
}

.tab-content.active {
    @apply block;
}
</style>

@endsection

@push('scripts')
<script>
// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab + '-tab').classList.add('active');
        });
    });
    
    // Character counters
    setupCharacterCounter('meta_title', 'meta-title-count', 60);
    setupCharacterCounter('meta_description', 'meta-description-count', 160);
    
    // Live preview updates
    setupLivePreview();
    
    // Initial preview update
    updatePreview();
});

// Character counter setup
function setupCharacterCounter(inputId, counterId, maxLength) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(counterId);
    
    if (input && counter) {
        function updateCounter() {
            const currentLength = input.value.length;
            counter.textContent = currentLength + '/' + maxLength;
            
            if (currentLength > maxLength * 0.9) {
                counter.classList.add('text-red-500');
                counter.classList.remove('text-gray-500');
            } else {
                counter.classList.add('text-gray-500');
                counter.classList.remove('text-red-500');
            }
        }
        
        input.addEventListener('input', updateCounter);
        updateCounter(); // Initial count
    }
}

// Live preview setup
function setupLivePreview() {
    const titleInput = document.getElementById('meta_title');
    const descInput = document.getElementById('meta_description');
    const routeInput = document.getElementById('page_route');
    
    if (titleInput) {
        titleInput.addEventListener('input', updatePreview);
    }
    if (descInput) {
        descInput.addEventListener('input', updatePreview);
    }
    if (routeInput) {
        routeInput.addEventListener('input', updatePreview);
    }
}

// Update preview
function updatePreview() {
    const titleInput = document.getElementById('meta_title');
    const descInput = document.getElementById('meta_description');
    const routeInput = document.getElementById('page_route');
    
    const previewTitle = document.getElementById('preview-title');
    const previewUrl = document.getElementById('preview-url');
    const previewDesc = document.getElementById('preview-description');
    
    if (previewTitle && titleInput) {
        previewTitle.textContent = titleInput.value || 'Page Title';
    }
    
    if (previewUrl && routeInput) {
        previewUrl.textContent = '{{ url("/") }}/' + (routeInput.value || 'page');
    }
    
    if (previewDesc && descInput) {
        previewDesc.textContent = descInput.value || 'Meta description will appear here...';
    }
}

// Quick actions
function copyFromMeta() {
    const metaTitle = document.getElementById('meta_title').value;
    const metaDesc = document.getElementById('meta_description').value;
    
    // Copy to Open Graph
    if (metaTitle) {
        document.getElementById('og_title').value = metaTitle;
    }
    if (metaDesc) {
        document.getElementById('og_description').value = metaDesc;
    }
    
    // Copy to Twitter
    if (metaTitle) {
        document.getElementById('twitter_title').value = metaTitle;
    }
    if (metaDesc) {
        document.getElementById('twitter_description').value = metaDesc;
    }
    
    showNotification('Meta data copied to social media fields!', 'success');
}

function generateSlug() {
    const pageTitle = document.getElementById('page_title').value;
    if (pageTitle) {
        const slug = pageTitle.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        
        document.getElementById('page_route').value = slug;
        updatePreview();
        showNotification('Slug generated from page title!', 'success');
    } else {
        showNotification('Please enter a page title first', 'error');
    }
}

function previewPage() {
    const route = document.getElementById('page_route').value;
    if (route) {
        const url = '{{ url("/") }}/' + route;
        window.open(url, '_blank');
    } else {
        showNotification('Please set a page route first', 'error');
    }
}

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
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

// Form submission with loading state
document.getElementById('seoForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
});

// Auto-resize textareas
document.querySelectorAll('textarea').forEach(textarea => {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});

// Validate URLs
document.querySelectorAll('input[type="url"]').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.value && !this.value.startsWith('http')) {
            this.value = 'https://' + this.value;
        }
    });
});
</script>
@endpush