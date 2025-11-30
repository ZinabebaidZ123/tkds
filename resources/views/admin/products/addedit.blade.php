@extends('admin.layouts.app')

@section('title', isset($product) ? 'Edit Product' : 'Add New Product')
@section('page-title', isset($product) ? 'Edit Product' : 'Add New Product')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.products.index') }}" class="hover:text-primary transition-colors duration-200">Products</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($product) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($product) ? 'Edit' : 'Add New' }} Product
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($product) ? 'Update the' : 'Create a new' }} product for your website</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-edit mr-2 text-primary"></i>
                    Product Details
                </h3>
            </div>
            
            <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="p-6 space-y-6" 
                  id="productForm"
                  accept-charset="UTF-8">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif
                
                <!-- Title & Slug -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-heading mr-2 text-primary"></i>
                            Title *
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $product->title ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('title') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="Enter product title"
                               required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="slug" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-link mr-2 text-primary"></i>
                            Slug (URL)
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $product->slug ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('slug') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="auto-generated from title">
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Leave empty to auto-generate from title</p>
                    </div>
                </div>

                <!-- Subtitle -->
                <div class="space-y-2">
                    <label for="subtitle" class="block text-sm font-semibold text-gray-700">
                        <i class="fas fa-text-width mr-2 text-primary"></i>
                        Subtitle
                    </label>
                    <input type="text" 
                           id="subtitle" 
                           name="subtitle" 
                           value="{{ old('subtitle', $product->subtitle ?? '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('subtitle') border-red-500 ring-2 ring-red-200 @enderror"
                           placeholder="Product subtitle or tagline">
                    @error('subtitle')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-semibold text-gray-700">
                        <i class="fas fa-align-left mr-2 text-primary"></i>
                        Description *
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('description') border-red-500 ring-2 ring-red-200 @enderror"
                              placeholder="Detailed product description"
                              required>{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Short Description -->
                <div class="space-y-2">
                    <label for="short_description" class="block text-sm font-semibold text-gray-700">
                        <i class="fas fa-file-alt mr-2 text-primary"></i>
                        Short Description
                    </label>
                    <textarea id="short_description" 
                              name="short_description" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('short_description') border-red-500 ring-2 ring-red-200 @enderror"
                              placeholder="Brief description for cards and listings">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                    @error('short_description')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Icon & Colors -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <label for="icon" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-icons mr-2 text-primary"></i>
                            Icon Class *
                        </label>
                        <input type="text" 
                               id="icon" 
                               name="icon" 
                               value="{{ old('icon', $product->icon ?? 'fas fa-cube') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('icon') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="fas fa-cube"
                               required>
                        @error('icon')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="color_from" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-palette mr-2 text-primary"></i>
                            Color From *
                        </label>
                        <select id="color_from" 
                                name="color_from" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('color_from') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            <option value="primary" {{ old('color_from', $product->color_from ?? 'primary') === 'primary' ? 'selected' : '' }}>Primary</option>
                            <option value="secondary" {{ old('color_from', $product->color_from ?? '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                            <option value="accent" {{ old('color_from', $product->color_from ?? '') === 'accent' ? 'selected' : '' }}>Accent</option>
                            <option value="blue-500" {{ old('color_from', $product->color_from ?? '') === 'blue-500' ? 'selected' : '' }}>Blue</option>
                            <option value="green-500" {{ old('color_from', $product->color_from ?? '') === 'green-500' ? 'selected' : '' }}>Green</option>
                            <option value="purple-500" {{ old('color_from', $product->color_from ?? '') === 'purple-500' ? 'selected' : '' }}>Purple</option>
                            <option value="red-500" {{ old('color_from', $product->color_from ?? '') === 'red-500' ? 'selected' : '' }}>Red</option>
                            <option value="yellow-500" {{ old('color_from', $product->color_from ?? '') === 'yellow-500' ? 'selected' : '' }}>Yellow</option>
                            <option value="indigo-500" {{ old('color_from', $product->color_from ?? '') === 'indigo-500' ? 'selected' : '' }}>Indigo</option>
                            <option value="pink-500" {{ old('color_from', $product->color_from ?? '') === 'pink-500' ? 'selected' : '' }}>Pink</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="color_to" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-palette mr-2 text-secondary"></i>
                            Color To *
                        </label>
                        <select id="color_to" 
                                name="color_to" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('color_to') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            <option value="secondary" {{ old('color_to', $product->color_to ?? 'secondary') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                            <option value="primary" {{ old('color_to', $product->color_to ?? '') === 'primary' ? 'selected' : '' }}>Primary</option>
                            <option value="accent" {{ old('color_to', $product->color_to ?? '') === 'accent' ? 'selected' : '' }}>Accent</option>
                            <option value="blue-600" {{ old('color_to', $product->color_to ?? '') === 'blue-600' ? 'selected' : '' }}>Blue</option>
                            <option value="green-600" {{ old('color_to', $product->color_to ?? '') === 'green-600' ? 'selected' : '' }}>Green</option>
                            <option value="purple-600" {{ old('color_to', $product->color_to ?? '') === 'purple-600' ? 'selected' : '' }}>Purple</option>
                            <option value="red-600" {{ old('color_to', $product->color_to ?? '') === 'red-600' ? 'selected' : '' }}>Red</option>
                            <option value="yellow-600" {{ old('color_to', $product->color_to ?? '') === 'yellow-600' ? 'selected' : '' }}>Yellow</option>
                            <option value="indigo-600" {{ old('color_to', $product->color_to ?? '') === 'indigo-600' ? 'selected' : '' }}>Indigo</option>
                            <option value="pink-600" {{ old('color_to', $product->color_to ?? '') === 'pink-600' ? 'selected' : '' }}>Pink</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="border_color" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-border-style mr-2 text-accent"></i>
                            Border Color *
                        </label>
                        <select id="border_color" 
                                name="border_color" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('border_color') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            <option value="primary" {{ old('border_color', $product->border_color ?? 'primary') === 'primary' ? 'selected' : '' }}>Primary</option>
                            <option value="secondary" {{ old('border_color', $product->border_color ?? '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                            <option value="accent" {{ old('border_color', $product->border_color ?? '') === 'accent' ? 'selected' : '' }}>Accent</option>
                            <option value="blue-500" {{ old('border_color', $product->border_color ?? '') === 'blue-500' ? 'selected' : '' }}>Blue</option>
                            <option value="green-500" {{ old('border_color', $product->border_color ?? '') === 'green-500' ? 'selected' : '' }}>Green</option>
                            <option value="purple-500" {{ old('border_color', $product->border_color ?? '') === 'purple-500' ? 'selected' : '' }}>Purple</option>
                            <option value="red-500" {{ old('border_color', $product->border_color ?? '') === 'red-500' ? 'selected' : '' }}>Red</option>
                            <option value="yellow-500" {{ old('border_color', $product->border_color ?? '') === 'yellow-500' ? 'selected' : '' }}>Yellow</option>
                            <option value="indigo-500" {{ old('border_color', $product->border_color ?? '') === 'indigo-500' ? 'selected' : '' }}>Indigo</option>
                            <option value="pink-500" {{ old('border_color', $product->border_color ?? '') === 'pink-500' ? 'selected' : '' }}>Pink</option>
                        </select>
                    </div>
                </div>

                <!-- Category & Pricing -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <label for="category" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-tags mr-2 text-primary"></i>
                            Category *
                        </label>
                        <select id="category" 
                                name="category" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('category') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            <option value="saas" {{ old('category', $product->category ?? 'saas') === 'saas' ? 'selected' : '' }}>SaaS Platform</option>
                            <option value="software" {{ old('category', $product->category ?? '') === 'software' ? 'selected' : '' }}>Software</option>
                            <option value="hardware" {{ old('category', $product->category ?? '') === 'hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="service" {{ old('category', $product->category ?? '') === 'service' ? 'selected' : '' }}>Service</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="pricing_model" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-dollar-sign mr-2 text-primary"></i>
                            Pricing Model *
                        </label>
                        <select id="pricing_model" 
                                name="pricing_model" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('pricing_model') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            <option value="subscription" {{ old('pricing_model', $product->pricing_model ?? 'subscription') === 'subscription' ? 'selected' : '' }}>Subscription</option>
                            <option value="one_time" {{ old('pricing_model', $product->pricing_model ?? '') === 'one_time' ? 'selected' : '' }}>One-time Purchase</option>
                            <option value="free" {{ old('pricing_model', $product->pricing_model ?? '') === 'free' ? 'selected' : '' }}>Free</option>
                            <option value="quote" {{ old('pricing_model', $product->pricing_model ?? '') === 'quote' ? 'selected' : '' }}>Contact for Quote</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="price" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-money-bill mr-2 text-primary"></i>
                            Price
                        </label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               step="0.01"
                               min="0"
                               value="{{ old('price', $product->price ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('price') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="0.00">
                        @error('price')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="currency" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-coins mr-2 text-primary"></i>
                            Currency
                        </label>
                        <select id="currency" 
                                name="currency" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                            <option value="USD" {{ old('currency', $product->currency ?? 'USD') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                            <option value="EUR" {{ old('currency', $product->currency ?? '') === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                            <option value="GBP" {{ old('currency', $product->currency ?? '') === 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        </select>
                    </div>
                </div>

                <!-- Image Uploads -->
                <div class="space-y-6">
                    <!-- Main Image -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-image mr-2 text-primary"></i>
                            Product Image {{ isset($product) ? '(Optional - leave empty to keep current)' : '' }}
                        </label>
                        
                        @if(isset($product) && $product->image)
                            <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                                <img src="{{ $product->getImageUrl() }}" 
                                     alt="{{ $product->title }}"
                                     class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
                            </div>
                        @endif
                        
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5">
                            <div class="space-y-4 text-center">
                                <div class="mx-auto h-16 w-16 text-gray-400">
                                    <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                </div>
                                <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary px-3 py-1 border border-primary/20">
                                        <span>Choose file</span>
                                        <input id="image" 
                                               name="image" 
                                               type="file" 
                                               class="sr-only" 
                                               accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp">
                                    </label>
                                    <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG, WebP up to 10MB</p>
                            </div>
                        </div>
                        
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Hero Image -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-star mr-2 text-primary"></i>
                            Hero Image {{ isset($product) ? '(Optional - leave empty to keep current)' : '' }}
                        </label>
                        
                        @if(isset($product) && $product->hero_image)
                            <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Hero Image:</p>
                                <img src="{{ $product->getHeroImageUrl() }}" 
                                     alt="{{ $product->title }}"
                                     class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
                            </div>
                        @endif
                        
                        <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-secondary transition-colors duration-300 bg-gray-50 hover:bg-secondary/5">
                            <div class="space-y-4 text-center">
                                <div class="mx-auto h-16 w-16 text-gray-400">
                                    <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                </div>
                                <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                    <label for="hero_image" class="relative cursor-pointer bg-white rounded-lg font-semibold text-secondary hover:text-accent focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-secondary px-3 py-1 border border-secondary/20">
                                        <span>Choose hero image</span>
                                        <input id="hero_image" 
                                               name="hero_image" 
                                               type="file" 
                                               class="sr-only" 
                                               accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp">
                                    </label>
                                    <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG, WebP up to 10MB</p>
                            </div>
                        </div>
                        
                        @error('hero_image')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- URLs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="route_name" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-route mr-2 text-primary"></i>
                            Route Name
                        </label>
                        <input type="text" 
                               id="route_name" 
                               name="route_name" 
                               value="{{ old('route_name', $product->route_name ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="products.streaming">
                        <p class="text-xs text-gray-500">Laravel route name (optional)</p>
                    </div>

                    <div class="space-y-2">
                        <label for="external_url" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-external-link-alt mr-2 text-primary"></i>
                            External URL
                        </label>
                        <input type="url" 
                               id="external_url" 
                               name="external_url" 
                               value="{{ old('external_url', $product->external_url ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="https://example.com">
                        <p class="text-xs text-gray-500">External URL (overrides route name)</p>
                    </div>
                </div>

                <!-- Additional URLs -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <label for="demo_url" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-play mr-2 text-primary"></i>
                            Demo URL
                        </label>
                        <input type="url" 
                               id="demo_url" 
                               name="demo_url" 
                               value="{{ old('demo_url', $product->demo_url ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="https://demo.example.com">
                    </div>

                    <div class="space-y-2">
                        <label for="video_url" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-video mr-2 text-primary"></i>
                            Video URL
                        </label>
                        <input type="url" 
                               id="video_url" 
                               name="video_url" 
                               value="{{ old('video_url', $product->video_url ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="https://youtube.com/watch?v=...">
                    </div>

                    <div class="space-y-2">
                        <label for="documentation_url" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-book mr-2 text-primary"></i>
                            Documentation
                        </label>
                        <input type="url" 
                               id="documentation_url" 
                               name="documentation_url" 
                               value="{{ old('documentation_url', $product->documentation_url ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="https://docs.example.com">
                    </div>

                    <div class="space-y-2">
                        <label for="github_url" class="block text-sm font-semibold text-gray-700">
                            <i class="fab fa-github mr-2 text-primary"></i>
                            GitHub URL
                        </label>
                        <input type="url" 
                               id="github_url" 
                               name="github_url" 
                               value="{{ old('github_url', $product->github_url ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="https://github.com/username/repo">
                    </div>
                </div>

                <!-- Features -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <i class="fas fa-list mr-2 text-primary"></i>
                        Features
                    </label>
                    <div id="featuresContainer" class="space-y-3">
                        @if(isset($product) && $product->getFeatures() && count($product->getFeatures()) > 0)
                            @foreach($product->getFeatures() as $index => $feature)
                                @if(!empty(trim($feature)))
                                <div class="flex items-center space-x-2 feature-item">
                                    <input type="text" 
                                           name="features[]" 
                                           value="{{ $feature }}"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                           placeholder="Enter feature">
                                    <button type="button" onclick="removeFeature(this)" class="p-3 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl transition-colors duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <button type="button" onclick="addFeature()" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Add Feature
                    </button>
                </div>

                <!-- Specifications -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        <i class="fas fa-cogs mr-2 text-primary"></i>
                        Specifications
                    </label>
                    <div id="specificationsContainer" class="space-y-3">
                        @if(isset($product) && $product->getSpecifications() && count($product->getSpecifications()) > 0)
                            @foreach($product->getSpecifications() as $index => $specification)
                                @if(!empty(trim($specification)))
                                <div class="flex items-center space-x-2 specification-item">
                                    <input type="text" 
                                           name="specifications[]" 
                                           value="{{ $specification }}"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                           placeholder="Enter specification">
                                    <button type="button" onclick="removeSpecification(this)" class="p-3 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl transition-colors duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <button type="button" onclick="addSpecification()" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Add Specification
                    </button>
                </div>

                <!-- Display Settings -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Featured -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-star mr-2 text-yellow-500"></i>
                            Featured
                        </label>
                        <div class="flex items-center space-x-3">
                            <label class="flex items-center cursor-pointer">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       id="is_featured"
                                       value="1"
                                       class="w-4 h-4 text-yellow-600 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 focus:ring-2" 
                                       {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm font-medium text-gray-700">Mark as featured</span>
                            </label>
                        </div>
                    </div>

                    <!-- Show in Navbar -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-bars mr-2 text-blue-500"></i>
                            Show in Navbar
                        </label>
                        <div class="flex items-center space-x-3">
                            <label class="flex items-center cursor-pointer">
                                <input type="hidden" name="show_in_navbar" value="0">
                                <input type="checkbox" 
                                       name="show_in_navbar" 
                                       id="show_in_navbar"
                                       value="1"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" 
                                       {{ old('show_in_navbar', $product->show_in_navbar ?? false) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm font-medium text-gray-700">Show in navigation</span>
                            </label>
                        </div>
                    </div>

                    <!-- Show in Homepage -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-home mr-2 text-green-500"></i>
                            Show in Homepage
                        </label>
                        <div class="flex items-center space-x-3">
                            <label class="flex items-center cursor-pointer">
                                <input type="hidden" name="show_in_homepage" value="0">
                                <input type="checkbox" 
                                       name="show_in_homepage" 
                                       id="show_in_homepage"
                                       value="1"
                                       class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2" 
                                       {{ old('show_in_homepage', $product->show_in_homepage ?? false) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm font-medium text-gray-700">Show in homepage</span>
                            </label>
                        </div>
                    </div>

                    <!-- Show Pricing -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-dollar-sign mr-2 text-purple-500"></i>
                            Show Pricing
                        </label>
                        <div class="flex items-center space-x-3">
                            <label class="flex items-center cursor-pointer">
                                <input type="hidden" name="show_pricing" value="0">
                                <input type="checkbox" 
                                       name="show_pricing" 
                                       id="show_pricing"
                                       value="1"
                                       class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 focus:ring-2" 
                                       {{ old('show_pricing', $product->show_pricing ?? false) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm font-medium text-gray-700">Show pricing info</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- SEO Fields -->
                <div class="space-y-4 p-4 bg-gray-50 rounded-xl">
                    <h4 class="text-sm font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-search mr-2 text-primary"></i>
                        SEO Settings
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                            <input type="text" 
                                   id="meta_title" 
                                   name="meta_title" 
                                   value="{{ old('meta_title', $product->meta_title ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="SEO title for search engines">
                        </div>

                        <div class="space-y-2">
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700">Meta Keywords</label>
                            <input type="text" 
                                   id="meta_keywords" 
                                   name="meta_keywords" 
                                   value="{{ old('meta_keywords', $product->meta_keywords ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="keyword1, keyword2, keyword3">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                        <textarea id="meta_description" 
                                  name="meta_description" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                  placeholder="SEO description for search engines">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Status & Settings -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-toggle-on mr-2 text-primary"></i>
                            Status *
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            <option value="active" {{ old('status', $product->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                Active (Visible on website)
                            </option>
                            <option value="inactive" {{ old('status', $product->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                Inactive (Hidden from website)
                            </option>
                            <option value="coming_soon" {{ old('status', $product->status ?? '') === 'coming_soon' ? 'selected' : '' }}>
                                Coming Soon (Show as coming soon)
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="sort_order" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-sort mr-2 text-primary"></i>
                            Display Order *
                        </label>
                        <input type="number" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $product->sort_order ?? 1) }}"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror"
                               required>
                        @error('sort_order')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Lower numbers appear first</p>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                            id="submitBtn">
                        <i class="fas fa-save mr-2"></i>
                        <span>{{ isset($product) ? 'Update' : 'Create' }} Product</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission handler to clean arrays before submit
    const form = document.getElementById('productForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission started');
            
            // Clean features array - remove empty inputs before submission
            const featureInputs = document.querySelectorAll('input[name="features[]"]');
            featureInputs.forEach(function(input, index) {
                if (!input.value || input.value.trim() === '') {
                    console.log('Removing empty feature input at index:', index);
                    input.remove();
                }
            });
            
            // Clean specifications array - remove empty inputs before submission
            const specInputs = document.querySelectorAll('input[name="specifications[]"]');
            specInputs.forEach(function(input, index) {
                if (!input.value || input.value.trim() === '') {
                    console.log('Removing empty specification input at index:', index);
                    input.remove();
                }
            });
            
            // Debug: Log remaining inputs
            const remainingFeatures = document.querySelectorAll('input[name="features[]"]');
            const remainingSpecs = document.querySelectorAll('input[name="specifications[]"]');
            
            console.log('Remaining features:', remainingFeatures.length);
            console.log('Remaining specifications:', remainingSpecs.length);
            
            // Continue with form submission
            console.log('Form submission continuing...');
        });
    }

    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function() {
            if (!slugInput.value || slugInput.dataset.autoGenerated !== 'false') {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with dashes
                    .replace(/-+/g, '-') // Replace multiple dashes with single dash
                    .replace(/^-|-$/g, ''); // Remove leading/trailing dashes
                
                slugInput.value = slug;
                slugInput.dataset.autoGenerated = 'true';
            }
        });
        
        // Mark as manually edited if user types in slug field
        slugInput.addEventListener('input', function() {
            this.dataset.autoGenerated = 'false';
        });
    }
});

// Feature management functions
function addFeature() {
    const container = document.getElementById('featuresContainer');
    if (container) {
        const newFeature = document.createElement('div');
        newFeature.className = 'flex items-center space-x-2 feature-item';
        newFeature.innerHTML = `
            <input type="text" 
                   name="features[]" 
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                   placeholder="Enter feature">
            <button type="button" onclick="removeFeature(this)" class="p-3 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl transition-colors duration-200">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(newFeature);
    }
}

function removeFeature(button) {
    const featureItem = button.closest('.feature-item');
    if (featureItem) {
        featureItem.remove();
    }
}

// Specification management functions
function addSpecification() {
    const container = document.getElementById('specificationsContainer');
    if (container) {
        const newSpec = document.createElement('div');
        newSpec.className = 'flex items-center space-x-2 specification-item';
        newSpec.innerHTML = `
            <input type="text" 
                   name="specifications[]" 
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                   placeholder="Enter specification">
            <button type="button" onclick="removeSpecification(this)" class="p-3 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl transition-colors duration-200">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(newSpec);
    }
}

function removeSpecification(button) {
    const specItem = button.closest('.specification-item');
    if (specItem) {
        specItem.remove();
    }
}
</script>
@endpush