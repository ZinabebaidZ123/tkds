@extends('admin.layouts.app')

@section('title', 'Create Pricing Plan')
@section('page-title', 'Create New Pricing Plan')

@section('content')
<style>
/* Toggle Styles */
.toggle-switch {
    position: relative;
    width: 2.75rem;
    height: 1.5rem;
    background-color: #e5e7eb;
    border-radius: 9999px;
    transition: all 0.3s ease;
}

.toggle-switch.active {
    background-color: #C53030 !important;
}

.toggle-circle {
    position: absolute;
    top: 2px;
    left: 2px;
    width: 1.25rem;
    height: 1.25rem;
    background-color: white;
    border-radius: 50%;
    transition: transform 0.3s ease;
    border: 1px solid #d1d5db;
}

.toggle-circle.active {
    transform: translateX(1.25rem);
}

/* Form in submission state */
.form-submitting {
    pointer-events: none;
    opacity: 0.7;
}

.submission-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.submission-spinner {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
}
</style>

<div class="space-y-6">
    
    <!-- Form Submission Overlay -->
    <div id="submissionOverlay" class="submission-overlay">
        <div class="submission-spinner">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto mb-4"></div>
            <p class="text-lg font-semibold text-gray-900">Creating Pricing Plan...</p>
            <p class="text-sm text-gray-600 mt-2">Please wait, do not close this page</p>
        </div>
    </div>

    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.pricing-plans.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.pricing-plans.index') }}" class="hover:text-primary transition-colors duration-200">Pricing Plans</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">Create New</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">Create New Pricing Plan</h2>
                <p class="text-gray-600 text-sm mt-1">Set up a new subscription plan for your customers</p>
            </div>
        </div>
    </div>

    <!-- Show Validation Errors -->
    @if ($errors->any() || session('form_error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        @if(session('form_error'))
                            {{ session('form_error') }}
                        @else
                            There {{ $errors->count() === 1 ? 'is' : 'are' }} {{ $errors->count() }} error{{ $errors->count() === 1 ? '' : 's' }} with your submission
                        @endif
                    </h3>
                    @if($errors->any())
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Form Container -->
    <form action="{{ route('admin.pricing-plans.store') }}" method="POST" class="space-y-8" id="pricingPlanForm" novalidate autocomplete="off">
        @csrf
        
        <!-- Form State Indicator -->
        <input type="hidden" id="formStateIndicator" value="ready">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Basic Information -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-primary"></i>
                            Basic Information
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Plan Name & Slug -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Plan Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="e.g., Professional Plan"
                                       required
                                       onchange="generateSlug()"
                                       autocomplete="off">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                                    URL Slug <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="slug" 
                                       name="slug" 
                                       value="{{ old('slug') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('slug') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="professional-plan"
                                       required
                                       autocomplete="off">
                                @error('slug')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Used in URLs: /pricing/professional-plan</p>
                            </div>
                        </div>

                        <!-- Description Fields -->
                        <div>
                            <label for="short_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Short Description
                            </label>
                            <input type="text" 
                                   id="short_description" 
                                   name="short_description" 
                                   value="{{ old('short_description') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('short_description') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="Perfect for growing businesses"
                                   maxlength="500"
                                   autocomplete="off">
                            @error('short_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Brief tagline shown on pricing cards</p>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('description') border-red-500 ring-2 ring-red-200 @enderror"
                                      placeholder="Detailed description of the plan benefits and features">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-dollar-sign mr-2 text-green-600"></i>
                            Pricing
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Currency -->
                        <div>
                            <label for="currency" class="block text-sm font-semibold text-gray-700 mb-2">
                                Currency <span class="text-red-500">*</span>
                            </label>
                            <select id="currency" 
                                    name="currency" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('currency') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="CAD" {{ old('currency') === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                <option value="AUD" {{ old('currency') === 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                            </select>
                            @error('currency')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pricing Options -->
                        <div class="grid md:grid-cols-3 gap-6">
                            <div>
                                <label for="price_monthly" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Monthly Price
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                    <input type="number" 
                                           id="price_monthly" 
                                           name="price_monthly" 
                                           value="{{ old('price_monthly') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('price_monthly') border-red-500 ring-2 ring-red-200 @enderror"
                                           placeholder="29.99"
                                           onchange="calculateYearlySavings()"
                                           autocomplete="off">
                                </div>
                                @error('price_monthly')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="price_yearly" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Yearly Price
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                    <input type="number" 
                                           id="price_yearly" 
                                           name="price_yearly" 
                                           value="{{ old('price_yearly') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('price_yearly') border-red-500 ring-2 ring-red-200 @enderror"
                                           placeholder="299.99"
                                           onchange="calculateYearlySavings()"
                                           autocomplete="off">
                                </div>
                                @error('price_yearly')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div id="yearlySavings" class="text-xs text-green-600 mt-1 hidden"></div>
                            </div>

                            <!-- Setup Fee -->
                            <div>
                                <label for="setup_fee" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Setup Fee (One-time)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                    <input type="number" 
                                           id="setup_fee" 
                                           name="setup_fee" 
                                           value="{{ old('setup_fee', 0) }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                           placeholder="0.00"
                                           autocomplete="off">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Leave 0 for no setup fee</p>
                            </div>
                        </div>

                        <!-- Trial Period -->
                        <div>
                            <label for="trial_days" class="block text-sm font-semibold text-gray-700 mb-2">
                                Free Trial (Days)
                            </label>
                            <input type="number" 
                                   id="trial_days" 
                                   name="trial_days" 
                                   value="{{ old('trial_days', 0) }}"
                                   min="0"
                                   max="365"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('trial_days') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="14"
                                   autocomplete="off">
                            @error('trial_days')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Leave 0 for no trial period</p>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-list-ul mr-2 text-blue-600"></i>
                            Features & Limits
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Features List -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Plan Features
                            </label>
                            <div id="featuresContainer" class="space-y-3">
                                <div class="flex items-center space-x-3 feature-item">
                                    <input type="text" 
                                           name="features[]" 
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                           placeholder="e.g., 5 Live TV Channels"
                                           autocomplete="off">
                                    <button type="button" onclick="removeFeature(this)" class="text-red-600 hover:text-red-800 p-2">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addFeature()" class="mt-3 text-primary hover:text-secondary font-medium text-sm">
                                <i class="fas fa-plus mr-2"></i>Add Feature
                            </button>
                        </div>

                        <!-- Limits -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="max_users" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Max Viewers
                                </label>
                                <input type="number" 
                                       id="max_users" 
                                       name="max_users" 
                                       value="{{ old('max_users') }}"
                                       min="1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('max_users') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="Leave empty for unlimited"
                                       autocomplete="off">
                                @error('max_users')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="max_projects" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Max Bitrate
                                </label>
                                <input type="number" 
                                       id="max_projects" 
                                       name="max_projects" 
                                       value="{{ old('max_projects') }}"
                                       min="1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('max_projects') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="Leave empty for unlimited"
                                       autocomplete="off">
                                @error('max_projects')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="storage_limit" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Storage Limit
                                </label>
                                <input type="text" 
                                       id="storage_limit" 
                                       name="storage_limit" 
                                       value="{{ old('storage_limit') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('storage_limit') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="e.g., 100 GB"
                                       autocomplete="off">
                                @error('storage_limit')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="bandwidth_limit" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Bandwidth Limit
                                </label>
                                <input type="text" 
                                       id="bandwidth_limit" 
                                       name="bandwidth_limit" 
                                       value="{{ old('bandwidth_limit') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('bandwidth_limit') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="e.g., 1 TB"
                                       autocomplete="off">
                                @error('bandwidth_limit')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Support Level -->
                        <div>
                            <label for="support_level" class="block text-sm font-semibold text-gray-700 mb-2">
                                Support Level <span class="text-red-500">*</span>
                            </label>
                            <select id="support_level" 
                                    name="support_level" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('support_level') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="basic" {{ old('support_level', 'basic') === 'basic' ? 'selected' : '' }}>Basic Support</option>
                                <option value="priority" {{ old('support_level') === 'priority' ? 'selected' : '' }}>Priority Support</option>
                                <option value="premium" {{ old('support_level') === 'premium' ? 'selected' : '' }}>Premium Support</option>
                            </select>
                            @error('support_level')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Preview Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-eye mr-2 text-blue-600"></i>
                            Live Preview
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-900 rounded-xl p-6 text-white text-center" id="planPreview">
                            <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mx-auto mb-4">
                                <i id="previewIcon" class="fas fa-star text-white"></i>
                            </div>
                            <h3 id="previewName" class="text-xl font-bold mb-2">Plan Name</h3>
                            <p id="previewShortDesc" class="text-gray-400 text-sm mb-4">Short description</p>
                            <div id="previewPrice" class="text-2xl font-black mb-4">$0/month</div>
                            <div id="previewFeatures" class="text-left space-y-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-check text-green-400"></i>
                                    <span class="text-sm">Feature preview</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Display Settings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-cog mr-2 text-gray-600"></i>
                            Display Settings
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Appearance -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Icon Class
                                </label>
                                <input type="text" 
                                       id="icon" 
                                       name="icon" 
                                       value="{{ old('icon', 'fas fa-star') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="fas fa-star"
                                       onchange="updatePreview()"
                                       autocomplete="off">
                                <p class="text-xs text-gray-500 mt-1">FontAwesome icon class</p>
                            </div>

                            <div>
                                <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Color Scheme
                                </label>
                                <select id="color" 
                                        name="color" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                        onchange="updatePreview()">
                                    <option value="primary" {{ old('color', 'primary') === 'primary' ? 'selected' : '' }}>Primary (Red)</option>
                                    <option value="secondary" {{ old('color') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                    <option value="accent" {{ old('color') === 'accent' ? 'selected' : '' }}>Accent</option>
                                    <option value="blue" {{ old('color') === 'blue' ? 'selected' : '' }}>Blue</option>
                                    <option value="green" {{ old('color') === 'green' ? 'selected' : '' }}>Green</option>
                                    <option value="purple" {{ old('color') === 'purple' ? 'selected' : '' }}>Purple</option>
                                </select>
                            </div>
                        </div>

                        <!-- Flags -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label for="is_popular" class="text-sm font-medium text-gray-700">
                                    Popular Plan
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="is_popular" name="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }} class="sr-only toggle-input">
                                    <div class="toggle-switch {{ old('is_popular') ? 'active' : '' }}">
                                        <div class="toggle-circle {{ old('is_popular') ? 'active' : '' }}"></div>
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <label for="is_featured" class="text-sm font-medium text-gray-700">
                                    Featured Plan
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="sr-only toggle-input">
                                    <div class="toggle-switch {{ old('is_featured') ? 'active' : '' }}">
                                        <div class="toggle-circle {{ old('is_featured') ? 'active' : '' }}"></div>
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <label for="show_in_home" class="text-sm font-medium text-gray-700">
                                    Show on Homepage
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="show_in_home" name="show_in_home" value="1" {{ old('show_in_home', 1) ? 'checked' : '' }} class="sr-only toggle-input">
                                    <div class="toggle-switch {{ old('show_in_home', 1) ? 'active' : '' }}">
                                        <div class="toggle-circle {{ old('show_in_home', 1) ? 'active' : '' }}"></div>
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <label for="show_in_pricing" class="text-sm font-medium text-gray-700">
                                    Show on Pricing Page
                                </label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="show_in_pricing" name="show_in_pricing" value="1" {{ old('show_in_pricing', 1) ? 'checked' : '' }} class="sr-only toggle-input">
                                    <div class="toggle-switch {{ old('show_in_pricing', 1) ? 'active' : '' }}">
                                        <div class="toggle-circle {{ old('show_in_pricing', 1) ? 'active' : '' }}"></div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Sort Order & Status -->
                        <div class="space-y-4">
                            <div>
                                <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Display Order
                                </label>
                                <input type="number" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', 1) }}"
                                       min="0"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       required
                                       autocomplete="off">
                                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Status
                                </label>
                                <select id="status" 
                                        name="status" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                        required>
                                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-search mr-2 text-green-600"></i>
                            SEO Settings
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Meta Title
                            </label>
                            <input type="text" 
                                   id="meta_title" 
                                   name="meta_title" 
                                   value="{{ old('meta_title') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="Auto-generated if empty"
                                   maxlength="255"
                                   autocomplete="off">
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Meta Description
                            </label>
                            <textarea id="meta_description" 
                                      name="meta_description" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                      placeholder="Auto-generated if empty">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-primary to-secondary text-white px-6 py-4 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg"
                            id="submitButton">
                        <i class="fas fa-save mr-2"></i>
                        <span id="submitText">Create Pricing Plan</span>
                    </button>
                    
                    <a href="{{ route('admin.pricing-plans.index') }}" 
                       class="w-full inline-block text-center bg-gray-100 text-gray-700 px-6 py-4 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// Form state management
let formIsSubmitting = false;
let formHasUnsavedChanges = false;
let initialFormData = {};

// Initialize form state tracking
function initializeFormState() {
    const form = document.getElementById('pricingPlanForm');
    if (form) {
        // Capture initial form data
        initialFormData = captureFormData();
        
        // Track changes to form fields
        const formElements = form.querySelectorAll('input, select, textarea');
        formElements.forEach(element => {
            element.addEventListener('input', function() {
                if (!formIsSubmitting) {
                    formHasUnsavedChanges = hasFormChanged();
                }
            });
            
            element.addEventListener('change', function() {
                if (!formIsSubmitting) {
                    formHasUnsavedChanges = hasFormChanged();
                }
            });
        });
    }
}

// Capture current form data
function captureFormData() {
    const form = document.getElementById('pricingPlanForm');
    const formData = new FormData(form);
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    return data;
}

// Check if form has changed
function hasFormChanged() {
    const currentData = captureFormData();
    
    // Compare with initial data
    const initialKeys = Object.keys(initialFormData);
    const currentKeys = Object.keys(currentData);
    
    if (initialKeys.length !== currentKeys.length) {
        return true;
    }
    
    for (let key of initialKeys) {
        if (initialFormData[key] !== currentData[key]) {
            return true;
        }
    }
    
    return false;
}

// Enhanced beforeunload handler
function handleBeforeUnload(e) {
    // Only show warning if form has changes and is not being submitted
    if (formHasUnsavedChanges && !formIsSubmitting) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        return e.returnValue;
    }
}

// Reset form state
function resetFormState() {
    formIsSubmitting = false;
    formHasUnsavedChanges = false;
    
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');
    const overlay = document.getElementById('submissionOverlay');
    const form = document.getElementById('pricingPlanForm');
    
    if (submitButton) {
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
    }
    
    if (submitText) {
        submitText.textContent = 'Create Pricing Plan';
    }
    
    if (overlay) {
        overlay.style.display = 'none';
    }
    
    if (form) {
        form.classList.remove('form-submitting');
    }
    
    // Remove any spinners
    const spinners = document.querySelectorAll('.fa-spinner');
    spinners.forEach(spinner => spinner.remove());
}

// Generate slug from name
function generateSlug() {
    const name = document.getElementById('name').value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('slug').value = slug;
    updatePreview();
}

// Calculate yearly savings
function calculateYearlySavings() {
    const monthlyPrice = parseFloat(document.getElementById('price_monthly').value) || 0;
    const yearlyPrice = parseFloat(document.getElementById('price_yearly').value) || 0;
    const savingsDiv = document.getElementById('yearlySavings');
    
    if (monthlyPrice > 0 && yearlyPrice > 0) {
        const monthlyTotal = monthlyPrice * 12;
        const savings = monthlyTotal - yearlyPrice;
        const percentage = Math.round((savings / monthlyTotal) * 100);
        
        if (savings > 0) {
            savingsDiv.textContent = `Save ${savings.toFixed(2)} (${percentage}%) with yearly billing`;
            savingsDiv.classList.remove('hidden');
        } else {
            savingsDiv.classList.add('hidden');
        }
    } else {
        savingsDiv.classList.add('hidden');
    }
    
    updatePreview();
}

// Add feature input
function addFeature() {
    const container = document.getElementById('featuresContainer');
    const newFeature = document.createElement('div');
    newFeature.className = 'flex items-center space-x-3 feature-item';
    newFeature.innerHTML = `
        <input type="text" 
               name="features[]" 
               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
               placeholder="Enter feature description"
               onchange="updatePreview()"
               autocomplete="off">
        <button type="button" onclick="removeFeature(this)" class="text-red-600 hover:text-red-800 p-2">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(newFeature);
    
    // Add event listener to new input for change tracking
    const newInput = newFeature.querySelector('input');
    newInput.addEventListener('input', function() {
        if (!formIsSubmitting) {
            formHasUnsavedChanges = hasFormChanged();
        }
    });
}

// Remove feature input
function removeFeature(button) {
    const featureItem = button.closest('.feature-item');
    featureItem.remove();
    updatePreview();
    
    // Update unsaved changes status
    if (!formIsSubmitting) {
        formHasUnsavedChanges = hasFormChanged();
    }
}

// Update live preview
function updatePreview() {
    const name = document.getElementById('name').value || 'Plan Name';
    const shortDesc = document.getElementById('short_description').value || 'Short description';
    const monthlyPrice = parseFloat(document.getElementById('price_monthly').value) || 0;
    const yearlyPrice = parseFloat(document.getElementById('price_yearly').value) || 0;
    const icon = document.getElementById('icon').value || 'fas fa-star';
    
    // Update preview elements
    document.getElementById('previewName').textContent = name;
    document.getElementById('previewShortDesc').textContent = shortDesc;
    document.getElementById('previewIcon').className = icon + ' text-white';
    
    // Update price display
    let priceText = 'Free';
    if (monthlyPrice > 0) {
        priceText = `${monthlyPrice.toFixed(0)}/month`;
        if (yearlyPrice > 0) {
            const monthlyFromYearly = yearlyPrice / 12;
            if (monthlyFromYearly < monthlyPrice) {
                priceText += ` (${monthlyFromYearly.toFixed(0)}/month yearly)`;
            }
        }
    } else if (yearlyPrice > 0) {
        priceText = `${(yearlyPrice / 12).toFixed(0)}/month (yearly)`;
    }
    document.getElementById('previewPrice').textContent = priceText;
    
    // Update features
    const features = Array.from(document.querySelectorAll('input[name="features[]"]'))
        .map(input => input.value)
        .filter(value => value.trim() !== '');
    
    const featuresContainer = document.getElementById('previewFeatures');
    if (features.length > 0) {
        featuresContainer.innerHTML = features.map(feature => `
            <div class="flex items-center space-x-2">
                <i class="fas fa-check text-green-400"></i>
                <span class="text-sm">${feature}</span>
            </div>
        `).join('');
    } else {
        featuresContainer.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fas fa-check text-green-400"></i>
                <span class="text-sm">Feature preview</span>
            </div>
        `;
    }
}

// Initialize toggles
function initializeToggles() {
    document.querySelectorAll('.toggle-input').forEach(checkbox => {
        const toggleSwitch = checkbox.nextElementSibling;
        const toggleCircle = toggleSwitch.querySelector('.toggle-circle');
        
        // Add click event listener
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                toggleSwitch.classList.add('active');
                toggleCircle.classList.add('active');
            } else {
                toggleSwitch.classList.remove('active');
                toggleCircle.classList.remove('active');
            }
            
            // Track changes
            if (!formIsSubmitting) {
                formHasUnsavedChanges = hasFormChanged();
            }
        });
        
        // Initialize based on current state
        if (checkbox.checked) {
            toggleSwitch.classList.add('active');
            toggleCircle.classList.add('active');
        }
    });
}

// Enhanced form submission handler
function handleFormSubmission(e) {
    // Prevent double submission
    if (formIsSubmitting) {
        e.preventDefault();
        return false;
    }
    
    const form = e.target;
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');
    const overlay = document.getElementById('submissionOverlay');
    
    // Basic validation
    const name = document.getElementById('name').value.trim();
    const slug = document.getElementById('slug').value.trim();
    
    if (!name) {
        e.preventDefault();
        alert('Plan name is required.');
        document.getElementById('name').focus();
        return false;
    }
    
    if (!slug) {
        e.preventDefault();
        alert('URL slug is required.');
        document.getElementById('slug').focus();
        return false;
    }
    
    // Check if at least one price is set
    const monthlyPrice = parseFloat(document.getElementById('price_monthly').value) || 0;
    const yearlyPrice = parseFloat(document.getElementById('price_yearly').value) || 0;
    
    if (monthlyPrice === 0 && yearlyPrice === 0) {
        const confirm = window.confirm('No pricing set. This will create a free plan. Continue?');
        if (!confirm) {
            e.preventDefault();
            return false;
        }
    }
    
    // Set submitting state
    formIsSubmitting = true;
    formHasUnsavedChanges = false;
    
    // Show loading state
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
    }
    
    if (submitText) {
        submitText.textContent = 'Creating Plan...';
    }
    
    if (overlay) {
        overlay.style.display = 'flex';
    }
    
    form.classList.add('form-submitting');
    
    // Add spinner to button
    if (submitText && submitText.parentNode) {
        const spinner = document.createElement('i');
        spinner.className = 'fas fa-spinner fa-spin mr-2';
        submitText.parentNode.insertBefore(spinner, submitText);
    }
    
    // Set timeout to reset if submission fails
    setTimeout(() => {
        if (formIsSubmitting) {
            console.warn('Form submission timeout - resetting state');
            resetFormState();
        }
    }, 30000); // 30 seconds timeout
}

// Document ready initialization
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeFormState();
    initializeToggles();
    
    // Add event listeners for real-time preview updates
    ['name', 'short_description', 'price_monthly', 'price_yearly', 'icon'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updatePreview);
        }
    });
    
    // Add event listeners for existing feature inputs
    document.querySelectorAll('input[name="features[]"]').forEach(input => {
        input.addEventListener('input', updatePreview);
    });
    
    // Initial preview update
    updatePreview();
    
    // Form submission handling
    const form = document.getElementById('pricingPlanForm');
    if (form) {
        form.addEventListener('submit', handleFormSubmission);
    }
    
    // Window beforeunload handling
    window.addEventListener('beforeunload', handleBeforeUnload);
    
    // Reset state if page is reloaded due to validation errors
    if (window.performance) {
        const navigation = performance.getEntriesByType('navigation')[0];
        if (navigation && navigation.type === 'reload') {
            resetFormState();
        }
    }
    
    // Handle browser back/forward buttons
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            resetFormState();
        }
    });
    
    // Auto-save form state to sessionStorage (optional)
    setInterval(() => {
        if (formHasUnsavedChanges && !formIsSubmitting) {
            try {
                const formData = captureFormData();
                sessionStorage.setItem('pricingPlanFormDraft', JSON.stringify(formData));
            } catch (e) {
                console.warn('Could not save form draft:', e);
            }
        }
    }, 10000); // Save every 10 seconds
});

// Handle page visibility change (when user switches tabs)
document.addEventListener('visibilitychange', function() {
    if (document.visibilityState === 'visible' && formIsSubmitting) {
        // Check if we're still submitting after coming back to tab
        setTimeout(() => {
            if (formIsSubmitting) {
                resetFormState();
            }
        }, 1000);
    }
});

// Clean up on page unload
window.addEventListener('unload', function() {
    formIsSubmitting = false;
    formHasUnsavedChanges = false;
});

// Global error handler
window.addEventListener('error', function(e) {
    if (formIsSubmitting) {
        console.error('Error during form submission:', e);
        resetFormState();
    }
});
</script>
@endpush