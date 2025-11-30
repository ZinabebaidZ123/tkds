@extends('admin.layouts.app')

@section('title', isset($service) ? 'Edit Service' : 'Add New Service')
@section('page-title', isset($service) ? 'Edit Service' : 'Add New Service')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.services.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.services.index') }}" class="hover:text-primary transition-colors duration-200">Services</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($service) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($service) ? 'Edit' : 'Add New' }} Service
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($service) ? 'Update the' : 'Create a new' }} service for your website</p>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
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

    <!-- Form Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-edit mr-2 text-primary"></i>
                        Service Details
                    </h3>
                </div>
                
                <form action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}" 
                      method="POST" enctype="multipart/form-data" class="p-6 space-y-6" id="serviceForm">
                    @csrf
                    @if(isset($service))
                        @method('PUT')
                    @endif
                    
                    <!-- Title & Slug -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-heading mr-2 text-primary"></i>
                                Title
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', isset($service) ? $service->title : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('title') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="Enter service title"
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
                                   value="{{ old('slug', isset($service) ? $service->slug : '') }}"
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

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-align-left mr-2 text-primary"></i>
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('description') border-red-500 ring-2 ring-red-200 @enderror"
                                  placeholder="Describe this service"
                                  required>{{ old('description', isset($service) ? $service->description : '') }}</textarea>
                        @error('description')
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
                                Icon Class
                            </label>
                            <input type="text" 
                                   id="icon" 
                                   name="icon" 
                                   value="{{ old('icon', isset($service) ? $service->icon : 'fas fa-cog') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('icon') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="fas fa-cog"
                                   required>
                            @error('icon')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">FontAwesome class (e.g., fas fa-cog)</p>
                        </div>

                        <div class="space-y-2">
                            <label for="color_from" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-palette mr-2 text-primary"></i>
                                Color From
                            </label>
                            <select id="color_from" 
                                    name="color_from" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('color_from') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="primary" {{ old('color_from', isset($service) ? $service->color_from : 'primary') === 'primary' ? 'selected' : '' }}>Primary</option>
                                <option value="secondary" {{ old('color_from', isset($service) ? $service->color_from : '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                <option value="accent" {{ old('color_from', isset($service) ? $service->color_from : '') === 'accent' ? 'selected' : '' }}>Accent</option>
                                <option value="blue-500" {{ old('color_from', isset($service) ? $service->color_from : '') === 'blue-500' ? 'selected' : '' }}>Blue</option>
                                <option value="green-500" {{ old('color_from', isset($service) ? $service->color_from : '') === 'green-500' ? 'selected' : '' }}>Green</option>
                                <option value="purple-500" {{ old('color_from', isset($service) ? $service->color_from : '') === 'purple-500' ? 'selected' : '' }}>Purple</option>
                                <option value="yellow-500" {{ old('color_from', isset($service) ? $service->color_from : '') === 'yellow-500' ? 'selected' : '' }}>Yellow</option>
                                <option value="red-500" {{ old('color_from', isset($service) ? $service->color_from : '') === 'red-500' ? 'selected' : '' }}>Red</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="color_to" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-palette mr-2 text-secondary"></i>
                                Color To
                            </label>
                            <select id="color_to" 
                                    name="color_to" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('color_to') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="secondary" {{ old('color_to', isset($service) ? $service->color_to : 'secondary') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                <option value="primary" {{ old('color_to', isset($service) ? $service->color_to : '') === 'primary' ? 'selected' : '' }}>Primary</option>
                                <option value="accent" {{ old('color_to', isset($service) ? $service->color_to : '') === 'accent' ? 'selected' : '' }}>Accent</option>
                                <option value="blue-600" {{ old('color_to', isset($service) ? $service->color_to : '') === 'blue-600' ? 'selected' : '' }}>Blue</option>
                                <option value="green-600" {{ old('color_to', isset($service) ? $service->color_to : '') === 'green-600' ? 'selected' : '' }}>Green</option>
                                <option value="purple-600" {{ old('color_to', isset($service) ? $service->color_to : '') === 'purple-600' ? 'selected' : '' }}>Purple</option>
                                <option value="yellow-600" {{ old('color_to', isset($service) ? $service->color_to : '') === 'yellow-600' ? 'selected' : '' }}>Yellow</option>
                                <option value="red-600" {{ old('color_to', isset($service) ? $service->color_to : '') === 'red-600' ? 'selected' : '' }}>Red</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="border_color" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-border-style mr-2 text-accent"></i>
                                Border Color
                            </label>
                            <select id="border_color" 
                                    name="border_color" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('border_color') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="primary" {{ old('border_color', isset($service) ? $service->border_color : 'primary') === 'primary' ? 'selected' : '' }}>Primary</option>
                                <option value="secondary" {{ old('border_color', isset($service) ? $service->border_color : '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                <option value="accent" {{ old('border_color', isset($service) ? $service->border_color : '') === 'accent' ? 'selected' : '' }}>Accent</option>
                                <option value="blue-500" {{ old('border_color', isset($service) ? $service->border_color : '') === 'blue-500' ? 'selected' : '' }}>Blue</option>
                                <option value="green-500" {{ old('border_color', isset($service) ? $service->border_color : '') === 'green-500' ? 'selected' : '' }}>Green</option>
                                <option value="purple-500" {{ old('border_color', isset($service) ? $service->border_color : '') === 'purple-500' ? 'selected' : '' }}>Purple</option>
                            </select>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-image mr-2 text-primary"></i>
                            Service Image {{ isset($service) ? '(Optional - leave empty to keep current)' : '' }}
                        </label>
                        
                        <!-- Current Image Preview (Edit mode only) -->
                        @if(isset($service) && $service->image)
                            <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                                <img src="{{ $service->getImageUrl() }}" 
                                     alt="{{ $service->title }}"
                                     class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
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
                                        <span>Choose file</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                    </label>
                                    <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG up to 2MB</p>
                            </div>
                        </div>
                        
                        <!-- New Image Preview -->
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">New Image Preview:</p>
                            <div class="relative inline-block">
                                <img id="previewImg" class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm" />
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

                    <!-- Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="route_name" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-route mr-2 text-primary"></i>
                                Route Name
                            </label>
                            <input type="text" 
                                   id="route_name" 
                                   name="route_name" 
                                   value="{{ old('route_name', isset($service) ? $service->route_name : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('route_name') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="services.streaming">
                            @error('route_name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Laravel route name (e.g., services.streaming)</p>
                        </div>

                        <div class="space-y-2">
                            <label for="external_url" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-external-link-alt mr-2 text-primary"></i>
                                External URL
                            </label>
                            <input type="url" 
                                   id="external_url" 
                                   name="external_url" 
                                   value="{{ old('external_url', isset($service) ? $service->external_url : '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('external_url') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="https://example.com">
                            @error('external_url')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">External URL (overrides route name)</p>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-list mr-2 text-primary"></i>
                            Features
                        </label>
                        <div id="featuresContainer" class="space-y-3">
                            @php
                                $existingFeatures = [];
                                if(isset($service) && $service->getFeatures()) {
                                    $existingFeatures = array_filter($service->getFeatures(), function($feature) {
                                        return !empty(trim($feature));
                                    });
                                }
                                $hasValidFeatures = !empty($existingFeatures);
                            @endphp
                            
                            @if($hasValidFeatures)
                                @foreach($existingFeatures as $index => $feature)
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
                                @endforeach
                            @else
                                <div class="flex items-center space-x-2 feature-item">
                                    <input type="text" 
                                           name="features[]" 
                                           value=""
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                           placeholder="Enter feature">
                                    <button type="button" onclick="removeFeature(this)" class="p-3 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl transition-colors duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="button" onclick="addFeature()" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                                <i class="fas fa-plus mr-2"></i>
                                Add Feature
                            </button>
                            <p class="text-xs text-gray-500">Empty features will be removed automatically</p>
                        </div>
                        @error('features')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        @error('features.*')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
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
                                       value="{{ old('meta_title', isset($service) ? $service->meta_title : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="SEO title for search engines">
                            </div>

                            <div class="space-y-2">
                                <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                                <textarea id="meta_description" 
                                          name="meta_description" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                          placeholder="SEO description for search engines">{{ old('meta_description', isset($service) ? $service->meta_description : '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Status & Settings -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-toggle-on mr-2 text-primary"></i>
                                Status
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="active" {{ old('status', isset($service) ? $service->status : 'active') === 'active' ? 'selected' : '' }}>
                                    ✅ Active (Visible on website)
                                </option>
                                <option value="inactive" {{ old('status', isset($service) ? $service->status : '') === 'inactive' ? 'selected' : '' }}>
                                    ❌ Inactive (Hidden from website)
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
                            <label for="is_featured" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-star mr-2 text-yellow-500"></i>
                                Featured
                            </label>
                            <div class="flex items-center space-x-3">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="is_featured" 
                                           value="1"
                                           class="sr-only" 
                                           {{ old('is_featured', isset($service) ? $service->is_featured : false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-yellow-500"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Mark as featured</span>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">Featured services get special highlighting</p>
                        </div>

                        <div class="space-y-2">
                            <label for="sort_order" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-sort mr-2 text-primary"></i>
                                Display Order
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', isset($service) ? $service->sort_order : 1) }}"
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
                        <a href="{{ route('admin.services.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($service) ? 'Update' : 'Create' }} Service</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar with Preview -->
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
                    <!-- Service Card Preview -->
                    <div class="group relative h-80 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200 transition-all duration-300" id="servicePreview">
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300" id="previewIcon">
                            <i class="fas fa-cog text-white text-2xl" id="iconDisplay"></i>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors duration-300" id="previewTitle">
                            {{ isset($service) ? $service->title : 'Service Title' }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed" id="previewDescription">
                            {{ isset($service) ? $service->description : 'Your service description will appear here...' }}
                        </p>
                        
                        <!-- Features Preview -->
                        <div id="previewFeatures" class="space-y-2 mb-6">
                            <!-- Features will be populated by JS -->
                        </div>
                        
                        <!-- Button -->
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="bg-primary/10 hover:bg-primary text-primary hover:text-white border border-primary/30 hover:border-primary rounded-lg px-4 py-2 text-sm font-medium transition-all duration-300 text-center" id="previewButton">
                                Learn More
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-3 text-center">This is how your service will appear on the website</p>
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
                            <p class="text-sm font-medium text-gray-800">SEO Optimization</p>
                            <p class="text-xs text-gray-600">Include relevant keywords in title and description for better search rankings</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Clear Features</p>
                            <p class="text-xs text-gray-600">List 3-5 key features that highlight your service benefits</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Color Harmony</p>
                            <p class="text-xs text-gray-600">Choose colors that match your brand and create visual appeal</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Image Quality</p>
                            <p class="text-xs text-gray-600">Use high-quality images that represent your service professionally</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Icon Reference -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-icons mr-2 text-primary"></i>
                        Popular Icons
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-4 gap-3">
                        <button type="button" onclick="setIcon('fas fa-broadcast-tower')" class="p-3 bg-gray-50 hover:bg-primary/10 rounded-lg transition-colors duration-200 text-center group">
                            <i class="fas fa-broadcast-tower text-lg text-gray-600 group-hover:text-primary mb-1"></i>
                            <p class="text-xs text-gray-500">Streaming</p>
                        </button>
                        <button type="button" onclick="setIcon('fas fa-mobile-alt')" class="p-3 bg-gray-50 hover:bg-primary/10 rounded-lg transition-colors duration-200 text-center group">
                            <i class="fas fa-mobile-alt text-lg text-gray-600 group-hover:text-primary mb-1"></i>
                            <p class="text-xs text-gray-500">Mobile</p>
                        </button>
                        <button type="button" onclick="setIcon('fas fa-palette')" class="p-3 bg-gray-50 hover:bg-primary/10 rounded-lg transition-colors duration-200 text-center group">
                            <i class="fas fa-palette text-lg text-gray-600 group-hover:text-primary mb-1"></i>
                            <p class="text-xs text-gray-500">Design</p>
                        </button>
                        <button type="button" onclick="setIcon('fas fa-cloud')" class="p-3 bg-gray-50 hover:bg-primary/10 rounded-lg transition-colors duration-200 text-center group">
                            <i class="fas fa-cloud text-lg text-gray-600 group-hover:text-primary mb-1"></i>
                            <p class="text-xs text-gray-500">Cloud</p>
                        </button>
                        <button type="button" onclick="setIcon('fas fa-microphone')" class="p-3 bg-gray-50 hover:bg-primary/10 rounded-lg transition-colors duration-200 text-center group">
                            <i class="fas fa-microphone text-lg text-gray-600 group-hover:text-primary mb-1"></i>
                            <p class="text-xs text-gray-500">Audio</p>
                        </button>
                        <button type="button" onclick="setIcon('fas fa-tv')" class="p-3 bg-gray-50 hover:bg-primary/10 rounded-lg transition-colors duration-200 text-center group">
                            <i class="fas fa-tv text-lg text-gray-600 group-hover:text-primary mb-1"></i>
                            <p class="text-xs text-gray-500">OTT</p>
                        </button>
                        <button type="button" onclick="setIcon('fas fa-server')" class="p-3 bg-gray-50 hover:bg-primary/10 rounded-lg transition-colors duration-200 text-center group">
                            <i class="fas fa-server text-lg text-gray-600 group-hover:text-primary mb-1"></i>
                            <p class="text-xs text-gray-500">Server</p>
                        </button>
                        <button type="button" onclick="setIcon('fas fa-futbol')" class="p-3 bg-gray-50 hover:bg-primary/10 rounded-lg transition-colors duration-200 text-center group">
                            <i class="fas fa-futbol text-lg text-gray-600 group-hover:text-primary mb-1"></i>
                            <p class="text-xs text-gray-500">Sports</p>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Click any icon to use it for your service</p>
                </div>
            </div>
            
            <!-- Stats Card (Edit mode only) -->
            @if(isset($service))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        Service Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $service->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $service->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $service->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                    @if($service->is_featured)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Featured</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-star mr-1"></i>
                            Yes
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('serviceForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // تنظيف Features من القيم الفارغة أو null
            const featureInputs = document.querySelectorAll('input[name="features[]"]');
            const validFeatures = [];
            
            featureInputs.forEach(function(input, index) {
                if (input.value && input.value.trim() !== '') {
                    validFeatures.push(input);
                } else {
                    // إزالة المدخل الفارغ من DOM
                    input.closest('.feature-item').remove();
                }
            });
            
            // إذا لم تبق أي features صالحة، أضف حقل فارغ واحد
            if (validFeatures.length === 0) {
                const container = document.getElementById('featuresContainer');
                const emptyInput = document.createElement('input');
                emptyInput.type = 'hidden';
                emptyInput.name = 'features[]';
                emptyInput.value = '';
                container.appendChild(emptyInput);
            }
        });
    }
});

function updatePreview() {
    try {
        const title = document.getElementById('title')?.value || 'Service Title';
        const description = document.getElementById('description')?.value || 'Your service description will appear here...';
        const icon = document.getElementById('icon')?.value || 'fas fa-cog';
        const colorFrom = document.getElementById('color_from')?.value || 'primary';
        const colorTo = document.getElementById('color_to')?.value || 'secondary';
        
        // Update preview elements safely
        const previewTitle = document.getElementById('previewTitle');
        const previewDescription = document.getElementById('previewDescription');
        const iconDisplay = document.getElementById('iconDisplay');
        const previewIcon = document.getElementById('previewIcon');
        
        if (previewTitle) previewTitle.textContent = title;
        if (previewDescription) previewDescription.textContent = description;
        if (iconDisplay) iconDisplay.className = icon + ' text-white text-2xl';
        
        if (previewIcon) {
            previewIcon.className = `w-16 h-16 bg-gradient-to-r from-${colorFrom} to-${colorTo} rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300`;
        }
        
        updateFeaturesPreview();
    } catch (error) {
        console.warn('Error updating preview:', error);
    }
}

function updateFeaturesPreview() {
    try {
        const features = Array.from(document.querySelectorAll('input[name="features[]"]'))
            .map(input => input.value)
            .filter(value => value && value.trim() !== '');
        
        const previewFeatures = document.getElementById('previewFeatures');
        if (!previewFeatures) return;
        
        if (features.length > 0) {
            const featuresList = features.slice(0, 3).map(feature => 
                `<div class="flex items-center text-gray-600">
                    <i class="fas fa-check text-accent mr-2 text-xs"></i>
                    <span class="text-xs">${escapeHtml(feature)}</span>
                </div>`
            ).join('');
            
            let additionalText = '';
            if (features.length > 3) {
                additionalText = `<div class="text-xs text-gray-500">+${features.length - 3} more features</div>`;
            }
            
            previewFeatures.innerHTML = featuresList + additionalText;
        } else {
            previewFeatures.innerHTML = '<div class="text-xs text-gray-500">No features added yet</div>';
        }
    } catch (error) {
        console.warn('Error updating features preview:', error);
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function addFeature() {
    try {
        const container = document.getElementById('featuresContainer');
        if (!container) return;
        
        const newFeature = document.createElement('div');
        newFeature.className = 'flex items-center space-x-2 feature-item';
        newFeature.innerHTML = `
            <input type="text" 
                   name="features[]" 
                   value=""
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                   placeholder="Enter feature">
            <button type="button" onclick="removeFeature(this)" class="p-3 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-xl transition-colors duration-200">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(newFeature);
        
        // Add event listeners for the new input
        const newInput = newFeature.querySelector('input');
        newInput.addEventListener('input', updateFeaturesPreview);
        newInput.addEventListener('blur', handleFeatureBlur);
        
        // Focus on the new input
        newInput.focus();
        updateFeaturesPreview();
    } catch (error) {
        console.warn('Error adding feature:', error);
    }
}

function removeFeature(button) {
    try {
        const container = document.getElementById('featuresContainer');
        const featureItems = container.querySelectorAll('.feature-item');
        
        if (featureItems.length > 1) {
            button.closest('.feature-item').remove();
        } else {
            // إذا كان العنصر الوحيد، امسح قيمته فقط
            const input = button.closest('.feature-item').querySelector('input');
            if (input) input.value = '';
        }
        updateFeaturesPreview();
    } catch (error) {
        console.warn('Error removing feature:', error);
    }
}

function handleFeatureBlur(event) {
    // إزالة المدخلات الفارغة عند فقدان التركيز
    const input = event.target;
    if (!input.value || input.value.trim() === '') {
        const container = document.getElementById('featuresContainer');
        const allInputs = container.querySelectorAll('input[name="features[]"]');
        
        if (allInputs.length > 1) {
            input.closest('.feature-item').remove();
            updateFeaturesPreview();
        }
    }
}

function initializeFeatureListeners() {
    document.querySelectorAll('input[name="features[]"]').forEach(input => {
        input.addEventListener('input', updateFeaturesPreview);
        input.addEventListener('blur', handleFeatureBlur);
    });
}

// Event listeners for live preview
function initializePreviewListeners() {
    const fieldsToWatch = [
        { id: 'title', event: 'input' },
        { id: 'description', event: 'input' },
        { id: 'icon', event: 'input' },
        { id: 'color_from', event: 'change' },
        { id: 'color_to', event: 'change' }
    ];
    
    fieldsToWatch.forEach(field => {
        const element = document.getElementById(field.id);
        if (element) {
            element.addEventListener(field.event, updatePreview);
        }
    });
}

// Icon setter function
function setIcon(iconClass) {
    const iconField = document.getElementById('icon');
    if (iconField) {
        iconField.value = iconClass;
        updatePreview();
    }
}

function initializeSlugGeneration() {
    const titleField = document.getElementById('title');
    const slugField = document.getElementById('slug');
    
    if (titleField && slugField) {
        titleField.addEventListener('input', function() {
            const title = this.value;
            if (!slugField.value || slugField.value === slugField.getAttribute('data-original')) {
                const slug = title.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // إزالة الأحرف الخاصة
                    .replace(/\s+/g, '-') // استبدال المسافات بـ -
                    .replace(/-+/g, '-') // إزالة - المتكررة
                    .replace(/^-+|-+$/g, ''); // إزالة - من البداية والنهاية
                
                slugField.value = slug;
                slugField.setAttribute('data-original', slug);
            }
        });
    }
}

function previewImage(input) {
    try {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // التحقق من حجم الملف (2MB)
            if (file.size > 2048 * 1024) {
                alert('Image size is too large. Maximum allowed size is 2MB');
                input.value = '';
                return;
            }
            
            // التحقق من نوع الملف
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
            if (!allowedTypes.includes(file.type)) {
                alert('File type not supported. Supported types: JPG, PNG, GIF, SVG');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                const previewImg = document.getElementById('previewImg');
                
                if (imagePreview && previewImg) {
                    imagePreview.classList.remove('hidden');
                    previewImg.src = e.target.result;
                }
            }
            reader.readAsDataURL(file);
        }
    } catch (error) {
        console.warn('Error previewing image:', error);
    }
}

function removePreview() {
    try {
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const imageInput = document.getElementById('image');
        
        if (imagePreview) imagePreview.classList.add('hidden');
        if (previewImg) previewImg.src = '';
        if (imageInput) imageInput.value = '';
    } catch (error) {
        console.warn('Error removing preview:', error);
    }
}

// Drag and drop functionality - محسن
function initializeDragAndDrop() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('image');
    
    if (!dropZone || !fileInput) return;
    
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
}

function initializeFormSubmission() {
    const form = document.getElementById('serviceForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
            
            // إعادة تفعيل الزر بعد وقت معين كإجراء احترازي
            setTimeout(() => {
                submitBtn.disabled = false;
                const isUpdate = {{ isset($service) ? 'true' : 'false' }};
                submitBtn.innerHTML = `<i class="fas fa-save mr-2"></i><span>${isUpdate ? 'Update' : 'Create'} Service</span>`;
            }, 10000);
        });
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    try {
        initializeFeatureListeners();
        initializePreviewListeners();
        initializeSlugGeneration();
        initializeDragAndDrop();
        initializeFormSubmission();
        
        // Initialize preview
        updatePreview();
        
        console.log('Service form JavaScript initialized successfully');
    } catch (error) {
        console.error('Error initializing service form:', error);
    }
});
</script>
@endpush