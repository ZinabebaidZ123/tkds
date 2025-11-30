@extends('admin.layouts.app')

@section('title', 'Product Details - ' . $product->title)
@section('page-title', 'Product Details')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.products.index') }}" class="hover:text-primary transition-colors duration-200">Products</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ $product->title }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">{{ $product->title }}</h2>
                <p class="text-gray-600 text-sm mt-1">{{ $product->getCategoryLabel() }} • Created {{ $product->created_at->diffForHumans() }}</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ $product->getUrl() }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-external-link-alt mr-2"></i>
                View Live
            </a>
            <a href="{{ route('admin.products.page-content', $product) }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Manage Content
            </a>
            <a href="{{ route('admin.products.edit', $product) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                <i class="fas fa-pencil-alt mr-2"></i>
                Edit Product
            </a>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="bg-gradient-to-r 
        @if($product->status === 'active') from-green-50 to-emerald-50 border-green-200 
        @elseif($product->status === 'coming_soon') from-yellow-50 to-orange-50 border-yellow-200 
        @else from-red-50 to-pink-50 border-red-200 @endif 
        border rounded-xl p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 rounded-full 
                    @if($product->status === 'active') bg-green-500 animate-pulse 
                    @elseif($product->status === 'coming_soon') bg-yellow-500 animate-pulse 
                    @else bg-red-500 @endif">
                </div>
                <div>
                    <h3 class="font-medium 
                        @if($product->status === 'active') text-green-800 
                        @elseif($product->status === 'coming_soon') text-yellow-800 
                        @else text-red-800 @endif">
                        Status: {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                    </h3>
                    <p class="text-sm 
                        @if($product->status === 'active') text-green-600 
                        @elseif($product->status === 'coming_soon') text-yellow-600 
                        @else text-red-600 @endif">
                        @if($product->status === 'active') 
                            This product is live and visible to users
                        @elseif($product->status === 'coming_soon') 
                            This product will be available soon
                        @else 
                            This product is hidden from users
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                @if($product->is_featured)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-star mr-1"></i>
                        Featured
                    </span>
                @endif
                @if($product->show_in_navbar)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-bars mr-1"></i>
                        In Navbar
                    </span>
                @endif
                @if($product->show_in_homepage)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-home mr-1"></i>
                        On Homepage
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Main Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Product Overview -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r {{ $product->getGradientClass() }} rounded-lg flex items-center justify-center mr-3">
                            <i class="{{ $product->icon }} text-white text-sm"></i>
                        </div>
                        Product Overview
                    </h3>
                </div>
                <div class="p-6">
                    
                    <!-- Product Images -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        @if($product->image)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Main Image</h4>
                                <img src="{{ $product->getImageUrl() }}" 
                                     alt="{{ $product->title }}"
                                     class="w-full h-48 object-cover rounded-lg border border-gray-200 shadow-sm">
                            </div>
                        @endif
                        
                        @if($product->hero_image)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Hero Image</h4>
                                <img src="{{ $product->getHeroImageUrl() }}" 
                                     alt="{{ $product->title }}"
                                     class="w-full h-48 object-cover rounded-lg border border-gray-200 shadow-sm">
                            </div>
                        @endif
                    </div>

                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Title</h4>
                            <p class="text-gray-900 font-semibold">{{ $product->title }}</p>
                        </div>
                        
                        @if($product->subtitle)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Subtitle</h4>
                                <p class="text-gray-900">{{ $product->subtitle }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Description</h4>
                        <div class="prose prose-sm max-w-none text-gray-900">
                            {{ $product->description }}
                        </div>
                    </div>

                    @if($product->short_description)
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Short Description</h4>
                            <p class="text-gray-900">{{ $product->short_description }}</p>
                        </div>
                    @endif

                    <!-- Pricing Info -->
                    @if($product->show_pricing)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Pricing Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Price</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $product->getFormattedPrice() }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Pricing Model</p>
                                    <p class="text-sm text-gray-900">{{ $product->getPricingModelLabel() }}</p>
                                </div>
                                @if($product->currency)
                                    <div>
                                        <p class="text-xs text-gray-500">Currency</p>
                                        <p class="text-sm text-gray-900">{{ $product->currency }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Features Section -->
            @if($product->getFeatures())
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-list mr-3 text-primary"></i>
                            Features ({{ count($product->getFeatures()) }})
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($product->getFeatures() as $feature)
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-check text-green-500 mr-3 text-sm"></i>
                                    <span class="text-sm">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

@if($product->getKeyFeatures() && count($product->getKeyFeatures()) > 0)
<section class="py-20 bg-gradient-to-b from-dark-light to-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">Key Features</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                Powerful features designed to enhance your experience
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($product->getKeyFeatures() as $index => $feature)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="relative bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-8 border border-white/10 hover:border-{{ is_array($feature) && isset($feature['color_from']) ? $feature['color_from'] : $product->color_from }}/30 transition-all duration-700 hover:shadow-2xl hover:-translate-y-2">
                        
                        <!-- Feature Icon -->
                        <div class="w-16 h-16 bg-gradient-to-r from-{{ is_array($feature) && isset($feature['color_from']) ? $feature['color_from'] : $product->color_from }} to-{{ is_array($feature) && isset($feature['color_to']) ? $feature['color_to'] : $product->color_to }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-2xl">
                            <i class="{{ is_array($feature) && isset($feature['icon']) ? $feature['icon'] : 'fas fa-star' }} text-white text-2xl"></i>
                        </div>
                        
                        <!-- Feature Content -->
                        <h3 class="text-xl font-bold text-white mb-4 group-hover:text-{{ is_array($feature) && isset($feature['color_from']) ? $feature['color_from'] : $product->color_from }} transition-colors duration-300">
                            {{ is_array($feature) && isset($feature['title']) ? $feature['title'] : (is_string($feature) ? $feature : 'Feature') }}
                        </h3>
                        
                        @if(is_array($feature) && isset($feature['description']) && !empty($feature['description']))
                            <p class="text-gray-300 leading-relaxed">
                                {{ $feature['description'] }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Benefits Section - FIXED -->
@if($product->getBenefits() && count($product->getBenefits()) > 0)
<section class="py-20 bg-dark-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-black text-white mb-6">Why Choose {{ $product->title }}?</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                The benefits that make us stand out from the competition
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($product->getBenefits() as $index => $benefit)
                <div class="text-center group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="w-20 h-20 bg-gradient-to-r from-{{ is_array($benefit) && isset($benefit['color_from']) ? $benefit['color_from'] : $product->color_from }} to-{{ is_array($benefit) && isset($benefit['color_to']) ? $benefit['color_to'] : $product->color_to }} rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-2xl">
                        <i class="{{ is_array($benefit) && isset($benefit['icon']) ? $benefit['icon'] : 'fas fa-check' }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">
                        {{ is_array($benefit) && isset($benefit['title']) ? $benefit['title'] : (is_string($benefit) ? $benefit : 'Benefit') }}
                    </h3>
                    @if(is_array($benefit) && isset($benefit['description']) && !empty($benefit['description']))
                        <p class="text-gray-400 leading-relaxed">{{ $benefit['description'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Use Cases Section - FIXED -->
@if($product->getUseCases() && count($product->getUseCases()) > 0)
<section class="py-20 bg-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-black text-white mb-6">Perfect For</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                Discover how {{ $product->title }} can transform your business
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($product->getUseCases() as $index => $useCase)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-8 border border-white/10 hover:border-{{ is_array($useCase) && isset($useCase['color_from']) ? $useCase['color_from'] : $product->color_from }}/30 transition-all duration-500">
                        
                        <div class="w-16 h-16 bg-gradient-to-r from-{{ is_array($useCase) && isset($useCase['color_from']) ? $useCase['color_from'] : $product->color_from }} to-{{ is_array($useCase) && isset($useCase['color_to']) ? $useCase['color_to'] : $product->color_to }} rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="{{ is_array($useCase) && isset($useCase['icon']) ? $useCase['icon'] : 'fas fa-lightbulb' }} text-white text-2xl"></i>
                        </div>
                        
                        <h3 class="text-xl font-bold text-white mb-4">
                            {{ is_array($useCase) && isset($useCase['title']) ? $useCase['title'] : (is_string($useCase) ? $useCase : 'Use Case') }}
                        </h3>
                        @if(is_array($useCase) && isset($useCase['description']) && !empty($useCase['description']))
                            <p class="text-gray-300 leading-relaxed">{{ $useCase['description'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif


<!-- Tech Stack Section - FIXED -->
@if($product->getTechStack() && count($product->getTechStack()) > 0)
<section class="py-20 bg-gradient-to-b from-dark-light to-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-black text-white mb-6">Built With Modern Technology</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                Powered by the latest and most reliable technologies
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($product->getTechStack() as $index => $tech)
                <div class="group text-center" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 50 }}">
                    <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:border-{{ $product->color_from }}/30 transition-all duration-300 hover:bg-white/10">
                        @if(is_array($tech) && isset($tech['icon']) && !empty($tech['icon']))
                            <i class="{{ $tech['icon'] }} text-3xl text-{{ $product->color_from }} mb-4"></i>
                        @endif
                        <h4 class="text-white font-semibold text-sm">
                            {{ is_array($tech) && isset($tech['name']) ? $tech['name'] : (is_string($tech) ? $tech : 'Technology') }}
                        </h4>
                        @if(is_array($tech) && isset($tech['version']) && !empty($tech['version']))
                            <p class="text-xs text-gray-400 mt-1">{{ $tech['version'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

            <!-- System Requirements Section -->
            @if($product->getSystemRequirements())
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-server mr-3 text-primary"></i>
                            System Requirements
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($product->getSystemRequirements() as $requirement)
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                                    <span class="font-medium text-gray-700">{{ $requirement['category'] ?? 'Requirement' }}:</span>
                                    <span class="text-gray-900">{{ $requirement['value'] ?? $requirement }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content Preview -->
            @if($product->page_content)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-file-alt mr-3 text-primary"></i>
                            Page Content Preview
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="prose prose-sm max-w-none text-gray-700 bg-gray-50 rounded-lg p-4 max-h-64 overflow-y-auto">
                            {!! Str::limit(strip_tags($product->page_content), 500) !!}
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.products.page-content', $product) }}" 
                               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Full Content
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">
            
            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-3 text-primary"></i>
                        Quick Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->getStatusBadge()['class'] }}">
                            {{ $product->getStatusBadge()['text'] }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Category</span>
                        <span class="text-sm font-medium text-gray-900">{{ $product->getCategoryLabel() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Sort Order</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $product->sort_order }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $product->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $product->updated_at->diffForHumans() }}</span>
                    </div>
                    @if($product->slug)
                        <div class="pt-3 border-t border-gray-100">
                            <span class="text-sm text-gray-600">URL Slug</span>
                            <p class="text-sm font-mono bg-gray-100 rounded px-2 py-1 mt-1 break-all">{{ $product->slug }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Display Settings -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-3 text-primary"></i>
                        Display Settings
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Featured</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $product->is_featured ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Show in Navbar</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->show_in_navbar ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $product->show_in_navbar ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Show in Homepage</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->show_in_homepage ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $product->show_in_homepage ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Show Pricing</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->show_pricing ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $product->show_pricing ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- URLs & Links -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-link mr-3 text-primary"></i>
                        URLs & Links
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($product->external_url)
                        <div>
                            <label class="text-sm text-gray-600">External URL</label>
                            <a href="{{ $product->external_url }}" target="_blank" class="block text-sm text-blue-600 hover:text-blue-800 break-all">
                                {{ $product->external_url }}
                                <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    @endif
                    
                    @if($product->demo_url)
                        <div>
                            <label class="text-sm text-gray-600">Demo URL</label>
                            <a href="{{ $product->demo_url }}" target="_blank" class="block text-sm text-blue-600 hover:text-blue-800 break-all">
                                {{ $product->demo_url }}
                                <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    @endif
                    
                    @if($product->video_url)
                        <div>
                            <label class="text-sm text-gray-600">Video URL</label>
                            <a href="{{ $product->video_url }}" target="_blank" class="block text-sm text-blue-600 hover:text-blue-800 break-all">
                                {{ $product->video_url }}
                                <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    @endif
                    
                    @if($product->documentation_url)
                        <div>
                            <label class="text-sm text-gray-600">Documentation</label>
                            <a href="{{ $product->documentation_url }}" target="_blank" class="block text-sm text-blue-600 hover:text-blue-800 break-all">
                                {{ $product->documentation_url }}
                                <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    @endif
                    
                    @if($product->github_url)
                        <div>
                            <label class="text-sm text-gray-600">GitHub Repository</label>
                            <a href="{{ $product->github_url }}" target="_blank" class="block text-sm text-blue-600 hover:text-blue-800 break-all">
                                {{ $product->github_url }}
                                <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

<!-- SEO Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-search mr-3 text-primary"></i>
                        SEO Information
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($product->meta_title)
                        <div>
                            <label class="text-sm text-gray-600">Meta Title</label>
                            <p class="text-sm text-gray-900 mt-1">{{ $product->meta_title }}</p>
                        </div>
                    @endif

                    @if($product->meta_description)
                        <div>
                            <label class="text-sm text-gray-600">Meta Description</label>
                            <p class="text-sm text-gray-900 mt-1">{{ $product->meta_description }}</p>
                        </div>
                    @endif

                    @if($product->meta_keywords)
                        <div>
                            <label class="text-sm text-gray-600">Meta Keywords</label>
                            <p class="text-sm text-gray-900 mt-1">{{ $product->meta_keywords }}</p>
                        </div>
                    @endif

                    @if(!$product->meta_title && !$product->meta_description && !$product->meta_keywords)
                        <div class="text-center py-4">
                            <i class="fas fa-info-circle text-gray-400 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-500">No SEO information available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-3 text-primary"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <button onclick="duplicateProduct({{ $product->id }})" 
                            class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-copy"></i>
                        <span>Duplicate Product</span>
                    </button>

                    <button onclick="toggleStatus({{ $product->id }}, '{{ $product->status }}')" 
                            class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                        <i class="fas fa-toggle-on"></i>
                        <span>{{ $product->isActive() ? 'Deactivate' : 'Activate' }} Product</span>
                    </button>

                    <button onclick="deleteProduct({{ $product->id }})" 
                            class="w-full flex items-center justify-center space-x-2 px-4 py-3 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200">
                        <i class="fas fa-trash"></i>
                        <span>Delete Product</span>
                    </button>
                </div>
            </div>
        </div>
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
            <p class="text-gray-600 mb-6">Are you sure you want to delete this product? This action cannot be undone.</p>
            <div class="flex space-x-3">
                <button id="confirmDelete"
                    class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 font-medium shadow-lg">
                    <i class="fas fa-trash mr-2"></i>
                    Delete
                </button>
                <button onclick="closeDeleteModal()"
                    class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium">
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

    // Duplicate functionality
    function duplicateProduct(id) {
        if (confirm('Are you sure you want to duplicate this product?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ route('admin.products.index') }}/${id}/duplicate`;
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Toggle status functionality
    function toggleStatus(id, currentStatus) {
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        const statusText = newStatus === 'active' ? 'activate' : 'deactivate';
        
        if (confirm(`Are you sure you want to ${statusText} this product?`)) {
            fetch(`{{ route('admin.products.index') }}/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Status updated successfully!', 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification('Failed to update status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to update status', 'error');
            });
        }
    }

    // Delete functionality
    function deleteProduct(id) {
        deleteId = id;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.querySelector('.bg-white').classList.remove('scale-95');
            modal.querySelector('.bg-white').classList.add('scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.querySelector('.bg-white').classList.remove('scale-100');
        modal.querySelector('.bg-white').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            deleteId = null;
        }, 300);
    }

    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (deleteId) {
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Deleting...';

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ route('admin.products.index') }}/${deleteId}`;
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });

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

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Close modal on background click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endpush