@extends('admin.layouts.app')

@section('title', 'Global SEO Settings')
@section('page-title', 'Global SEO Settings')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Global SEO Settings</h2>
            <p class="text-gray-600 text-sm mt-1">Control the global SEO settings for your entire website</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.seo.page-settings') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-file-alt mr-2"></i>
                Page Settings
            </a>
            <a href="{{ route('admin.seo.tools') }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-tools mr-2"></i>
                SEO Tools
            </a>
        </div>
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

    <!-- Form Container -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.seo.global-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-0">
            @csrf
            @method('PUT')
            
            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6 pt-4" aria-label="Tabs">
                    <button type="button" class="tab-button active" data-tab="basic">
                        <i class="fas fa-globe mr-2"></i>
                        Basic Settings
                    </button>
                    <button type="button" class="tab-button" data-tab="social">
                        <i class="fas fa-share-alt mr-2"></i>
                        Social Media
                    </button>
                    <button type="button" class="tab-button" data-tab="tracking">
                        <i class="fas fa-chart-line mr-2"></i>
                        Analytics & Tracking
                    </button>
                    <button type="button" class="tab-button" data-tab="verification">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Site Verification
                    </button>
                    <button type="button" class="tab-button" data-tab="technical">
                        <i class="fas fa-cog mr-2"></i>
                        Technical
                    </button>
                    <button type="button" class="tab-button" data-tab="advanced">
                        <i class="fas fa-code mr-2"></i>
                        Advanced
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                
                <!-- Basic Settings Tab -->
                <div class="tab-content active" id="basic-tab">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-globe mr-2 text-primary"></i>
                        Basic SEO Information
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Site Name -->
                        <div class="space-y-2">
                            <label for="site_name" class="block text-sm font-semibold text-gray-700">
                                Site Name *
                            </label>
                            <input type="text" id="site_name" name="site_name" 
                                   value="{{ old('site_name', $settings->site_name) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('site_name') border-red-500 @enderror"
                                   required>
                            @error('site_name')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Site Author -->
                        <div class="space-y-2">
                            <label for="site_author" class="block text-sm font-semibold text-gray-700">
                                Site Author
                            </label>
                            <input type="text" id="site_author" name="site_author" 
                                   value="{{ old('site_author', $settings->site_author) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        </div>

                        <!-- Site Tagline -->
                        <div class="lg:col-span-2 space-y-2">
                            <label for="site_tagline" class="block text-sm font-semibold text-gray-700">
                                Site Tagline
                            </label>
                            <input type="text" id="site_tagline" name="site_tagline" 
                                   value="{{ old('site_tagline', $settings->site_tagline) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="Your World, Live and Direct">
                        </div>

                        <!-- Site Description -->
                        <div class="lg:col-span-2 space-y-2">
                            <label for="site_description" class="block text-sm font-semibold text-gray-700">
                                Site Description *
                            </label>
                            <textarea id="site_description" name="site_description" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('site_description') border-red-500 @enderror"
                                      required>{{ old('site_description', $settings->site_description) }}</textarea>
                            @error('site_description')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Site Keywords -->
                        <div class="lg:col-span-2 space-y-2">
                            <label for="site_keywords" class="block text-sm font-semibold text-gray-700">
                                Site Keywords
                            </label>
                            <input type="text" id="site_keywords" name="site_keywords" 
                                   value="{{ old('site_keywords', $settings->site_keywords) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="streaming, broadcasting, OTT platform">
                            <p class="text-xs text-gray-500">Separate keywords with commas</p>
                        </div>

                        <!-- Logo Upload -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Site Logo
                            </label>
                            @if($settings->site_logo)
                                <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Current Logo:</p>
                                    <img src="{{ $settings->getSiteLogoUrl() }}" alt="Current Logo" class="max-h-16">
                                </div>
                            @endif
                            <input type="file" id="site_logo" name="site_logo" accept="image/*"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                        </div>

                        <!-- Favicon Upload -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Favicon
                            </label>
                            @if($settings->favicon)
                                <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Current Favicon:</p>
                                    <img src="{{ $settings->getFaviconUrl() }}" alt="Current Favicon" class="w-8 h-8">
                                </div>
                            @endif
                            <input type="file" id="favicon" name="favicon" accept=".ico,.png"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                            <p class="text-xs text-gray-500">Recommended: 32x32 ICO or PNG file</p>
                        </div>

                        <!-- OG Image Upload -->
                        <div class="lg:col-span-2 space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Default Open Graph Image
                            </label>
                            @if($settings->og_image)
                                <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Current OG Image:</p>
                                    <img src="{{ $settings->getOgImageUrl() }}" alt="Current OG Image" class="max-h-32 rounded-lg">
                                </div>
                            @endif
                            <input type="file" id="og_image" name="og_image" accept="image/*"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                            <p class="text-xs text-gray-500">Recommended: 1200x630 pixels for optimal social media sharing</p>
                        </div>

                        <!-- Theme Colors -->
                        <div class="space-y-2">
                            <label for="theme_color" class="block text-sm font-semibold text-gray-700">
                                Theme Color *
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="color" id="theme_color" name="theme_color" 
                                       value="{{ old('theme_color', $settings->theme_color) }}"
                                       class="w-16 h-12 border border-gray-300 rounded-lg">
                                <input type="text" value="{{ old('theme_color', $settings->theme_color) }}"
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       readonly>
                            </div>
                        </div>

                        <!-- Background Color -->
                        <div class="space-y-2">
                            <label for="background_color" class="block text-sm font-semibold text-gray-700">
                                Background Color *
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="color" id="background_color" name="background_color" 
                                       value="{{ old('background_color', $settings->background_color) }}"
                                       class="w-16 h-12 border border-gray-300 rounded-lg">
                                <input type="text" value="{{ old('background_color', $settings->background_color) }}"
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Tab -->
                <div class="tab-content" id="social-tab">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-share-alt mr-2 text-primary"></i>
                        Social Media Settings
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Twitter Username -->
                        <div class="space-y-2">
                            <label for="twitter_username" class="block text-sm font-semibold text-gray-700">
                                <i class="fab fa-twitter mr-2 text-blue-400"></i>
                                Twitter Username
                            </label>
                            <input type="text" id="twitter_username" name="twitter_username" 
                                   value="{{ old('twitter_username', $settings->twitter_username) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="@tkdsmedia">
                        </div>

                        <!-- Facebook App ID -->
                        <div class="space-y-2">
                            <label for="facebook_app_id" class="block text-sm font-semibold text-gray-700">
                                <i class="fab fa-facebook mr-2 text-blue-600"></i>
                                Facebook App ID
                            </label>
                            <input type="text" id="facebook_app_id" name="facebook_app_id" 
                                   value="{{ old('facebook_app_id', $settings->facebook_app_id) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="123456789012345">
                        </div>
                    </div>
                </div>

                <!-- Analytics & Tracking Tab -->
                <div class="tab-content" id="tracking-tab">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-chart-line mr-2 text-primary"></i>
                        Analytics & Tracking
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Google Analytics -->
                        <div class="space-y-2">
                            <label for="google_analytics_id" class="block text-sm font-semibold text-gray-700">
                                <i class="fab fa-google mr-2 text-red-500"></i>
                                Google Analytics ID
                            </label>
                            <input type="text" id="google_analytics_id" name="google_analytics_id" 
                                   value="{{ old('google_analytics_id', $settings->google_analytics_id) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="G-XXXXXXXXXX">
                        </div>

                        <!-- Google Tag Manager -->
                        <div class="space-y-2">
                            <label for="google_tag_manager_id" class="block text-sm font-semibold text-gray-700">
                                <i class="fab fa-google mr-2 text-blue-500"></i>
                                Google Tag Manager ID
                            </label>
                            <input type="text" id="google_tag_manager_id" name="google_tag_manager_id" 
                                   value="{{ old('google_tag_manager_id', $settings->google_tag_manager_id) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="GTM-XXXXXXX">
                        </div>

                        <!-- Facebook Pixel -->
                        <div class="lg:col-span-2 space-y-2">
                            <label for="facebook_pixel_id" class="block text-sm font-semibold text-gray-700">
                                <i class="fab fa-facebook mr-2 text-blue-600"></i>
                                Facebook Pixel ID
                            </label>
                            <input type="text" id="facebook_pixel_id" name="facebook_pixel_id" 
                                   value="{{ old('facebook_pixel_id', $settings->facebook_pixel_id) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="123456789012345">
                        </div>
                    </div>
                </div>

                <!-- Site Verification Tab -->
                <div class="tab-content" id="verification-tab">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-shield-alt mr-2 text-primary"></i>
                        Site Verification
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Google Verification -->
                        <div class="space-y-2">
                            <label for="google_site_verification" class="block text-sm font-semibold text-gray-700">
                                <i class="fab fa-google mr-2 text-red-500"></i>
                                Google Site Verification
                            </label>
                            <input type="text" id="google_site_verification" name="google_site_verification" 
                                   value="{{ old('google_site_verification', $settings->google_site_verification) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="google-site-verification code">
                        </div>

                        <!-- Bing Verification -->
                        <div class="space-y-2">
                            <label for="bing_site_verification" class="block text-sm font-semibold text-gray-700">
                                <i class="fab fa-microsoft mr-2 text-blue-500"></i>
                                Bing Site Verification
                            </label>
                            <input type="text" id="bing_site_verification" name="bing_site_verification" 
                                   value="{{ old('bing_site_verification', $settings->bing_site_verification) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="msvalidate.01 code">
                        </div>

                        <!-- Yandex Verification -->
                        <div class="lg:col-span-2 space-y-2">
                            <label for="yandex_site_verification" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-search mr-2 text-red-600"></i>
                                Yandex Site Verification
                            </label>
                            <input type="text" id="yandex_site_verification" name="yandex_site_verification" 
                                   value="{{ old('yandex_site_verification', $settings->yandex_site_verification) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="yandex-verification code">
                        </div>
                    </div>
                </div>

                <!-- Technical Tab -->
                <div class="tab-content" id="technical-tab">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-cog mr-2 text-primary"></i>
                        Technical SEO Settings
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- SEO Features -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                <input type="checkbox" name="sitemap_enabled" value="1" 
                                       {{ old('sitemap_enabled', $settings->sitemap_enabled) ? 'checked' : '' }}
                                       class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Enable Sitemap</div>
                                    <div class="text-xs text-gray-500">Generate XML sitemap</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                <input type="checkbox" name="breadcrumbs_enabled" value="1" 
                                       {{ old('breadcrumbs_enabled', $settings->breadcrumbs_enabled) ? 'checked' : '' }}
                                       class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Enable Breadcrumbs</div>
                                    <div class="text-xs text-gray-500">Show navigation breadcrumbs</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                <input type="checkbox" name="canonical_urls_enabled" value="1" 
                                       {{ old('canonical_urls_enabled', $settings->canonical_urls_enabled) ? 'checked' : '' }}
                                       class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Canonical URLs</div>
                                    <div class="text-xs text-gray-500">Prevent duplicate content</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                <input type="checkbox" name="open_graph_enabled" value="1" 
                                       {{ old('open_graph_enabled', $settings->open_graph_enabled) ? 'checked' : '' }}
                                       class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Open Graph</div>
                                    <div class="text-xs text-gray-500">Social media optimization</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                <input type="checkbox" name="twitter_cards_enabled" value="1" 
                                       {{ old('twitter_cards_enabled', $settings->twitter_cards_enabled) ? 'checked' : '' }}
                                       class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Twitter Cards</div>
                                    <div class="text-xs text-gray-500">Twitter sharing optimization</div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                <input type="checkbox" name="json_ld_enabled" value="1" 
                                       {{ old('json_ld_enabled', $settings->json_ld_enabled) ? 'checked' : '' }}
                                       class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">JSON-LD Schema</div>
                                    <div class="text-xs text-gray-500">Structured data markup</div>
                                </div>
                            </label>
                        </div>

                        <!-- Language Settings -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="default_language" class="block text-sm font-semibold text-gray-700">
                                    Default Language *
                                </label>
                                <select id="default_language" name="default_language" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                        required>
                                    <option value="en" {{ old('default_language', $settings->default_language) === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="ar" {{ old('default_language', $settings->default_language) === 'ar' ? 'selected' : '' }}>العربية</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="rtl_support" value="1" 
                                           {{ old('rtl_support', $settings->rtl_support) ? 'checked' : '' }}
                                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary mr-3">
                                    <span class="text-sm font-semibold text-gray-700">Enable RTL Support</span>
                                </label>
                                <p class="text-xs text-gray-500 ml-8">Support for right-to-left languages</p>
                            </div>
                        </div>

                        <!-- Robots.txt -->
                        <div class="space-y-2">
                            <label for="robots_txt" class="block text-sm font-semibold text-gray-700">
                                Custom Robots.txt Content
                            </label>
                            <textarea id="robots_txt" name="robots_txt" rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none font-mono text-sm"
                                      placeholder="User-agent: *&#10;Allow: /&#10;Disallow: /admin/">{{ old('robots_txt', $settings->robots_txt) }}</textarea>
                            <p class="text-xs text-gray-500">Leave empty to use auto-generated robots.txt</p>
                        </div>
                    </div>
                </div>

                <!-- Advanced Tab -->
                <div class="tab-content" id="advanced-tab">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-code mr-2 text-primary"></i>
                        Advanced Custom Code
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Custom Head Code -->
                        <div class="space-y-2">
                            <label for="custom_head_code" class="block text-sm font-semibold text-gray-700">
                                Custom Head Code
                            </label>
                            <textarea id="custom_head_code" name="custom_head_code" rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none font-mono text-sm"
                                      placeholder="<!-- Custom meta tags, scripts, etc. -->">{{ old('custom_head_code', $settings->custom_head_code) }}</textarea>
                            <p class="text-xs text-gray-500">Custom HTML code to be inserted in the &lt;head&gt; section</p>
                        </div>

                        <!-- Custom Body Code -->
                        <div class="space-y-2">
                            <label for="custom_body_code" class="block text-sm font-semibold text-gray-700">
                                Custom Body Code (After Opening &lt;body&gt;)
                            </label>
                            <textarea id="custom_body_code" name="custom_body_code" rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none font-mono text-sm"
                                      placeholder="<!-- Custom tracking scripts, etc. -->">{{ old('custom_body_code', $settings->custom_body_code) }}</textarea>
                            <p class="text-xs text-gray-500">Custom HTML code to be inserted after the opening &lt;body&gt; tag</p>
                        </div>

                        <!-- Custom Footer Code -->
                        <div class="space-y-2">
                            <label for="custom_footer_code" class="block text-sm font-semibold text-gray-700">
                                Custom Footer Code (Before Closing &lt;/body&gt;)
                            </label>
                            <textarea id="custom_footer_code" name="custom_footer_code" rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none font-mono text-sm"
                                      placeholder="<!-- Custom scripts, analytics, etc. -->">{{ old('custom_footer_code', $settings->custom_footer_code) }}</textarea>
                            <p class="text-xs text-gray-500">Custom HTML code to be inserted before the closing &lt;/body&gt; tag</p>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                SEO Settings Status
                            </label>
                            <select id="status" name="status" 
                                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                    required>
                                <option value="active" {{ old('status', $settings->status) === 'active' ? 'selected' : '' }}>
                                    ✅ Active (SEO features enabled)
                                </option>
                                <option value="inactive" {{ old('status', $settings->status) === 'inactive' ? 'selected' : '' }}>
                                    ❌ Inactive (SEO features disabled)
                                </option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            Save SEO Settings
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
    
    // Color picker sync
    const colorInputs = document.querySelectorAll('input[type="color"]');
    colorInputs.forEach(colorInput => {
        const textInput = colorInput.nextElementSibling;
        
        colorInput.addEventListener('change', function() {
            textInput.value = this.value;
        });
        
        textInput.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                colorInput.value = this.value;
            }
        });
    });
});
</script>
@endsection