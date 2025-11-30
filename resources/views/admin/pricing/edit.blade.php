@extends('admin.layouts.app')

@section('title', 'Edit Pricing Plan')
@section('page-title', 'Edit Pricing Plan')

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
</style>

<div class="space-y-6">
    
    <!-- Header -->
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
                    <span class="text-gray-900">Edit {{ $pricingPlan->name }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">Edit {{ $pricingPlan->name }}</h2>
                <p class="text-gray-600 text-sm mt-1">Update subscription plan details and pricing</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3 sm:ml-auto">
            <a href="{{ route('admin.pricing-plans.show', $pricingPlan->id) }}" 
               class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium transition-all duration-200">
                <i class="fas fa-eye mr-2"></i>View Plan
            </a>
            @if($pricingPlan->stripe_product_id)
                <button onclick="syncStripe()" 
                        class="inline-flex items-center bg-purple-100 hover:bg-purple-200 text-purple-700 px-4 py-2 rounded-xl font-medium transition-all duration-200">
                    <i class="fab fa-stripe mr-2"></i>Sync Stripe
                </button>
            @endif
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.pricing-plans.update', $pricingPlan->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Basic Information -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-primary"></i>Basic Information
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Plan Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $pricingPlan->name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="e.g., Professional Plan" required onchange="generateSlug()">
                                @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">URL Slug <span class="text-red-500">*</span></label>
                                <input type="text" id="slug" name="slug" value="{{ old('slug', $pricingPlan->slug) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('slug') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="professional-plan" required>
                                @error('slug')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                <p class="text-xs text-gray-500 mt-1">Used in URLs: /pricing/{{ $pricingPlan->slug }}</p>
                            </div>
                        </div>

                        <div>
                            <label for="short_description" class="block text-sm font-semibold text-gray-700 mb-2">Short Description</label>
                            <input type="text" id="short_description" name="short_description" value="{{ old('short_description', $pricingPlan->short_description) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('short_description') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="Perfect for growing businesses" maxlength="500">
                            @error('short_description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Full Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('description') border-red-500 ring-2 ring-red-200 @enderror"
                                      placeholder="Detailed description of the plan benefits and features">{{ old('description', $pricingPlan->description) }}</textarea>
                            @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-dollar-sign mr-2 text-green-600"></i>Pricing
                            @if($pricingPlan->stripe_product_id)
                                <span class="ml-3 bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-medium">
                                    <i class="fab fa-stripe mr-1"></i>Synced
                                </span>
                            @endif
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        @if($pricingPlan->stripe_product_id)
                            <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                                <div class="flex items-start space-x-3">
                                    <i class="fab fa-stripe text-purple-600 mt-1"></i>
                                    <div>
                                        <p class="text-purple-800 font-medium">Stripe Integration Active</p>
                                        <p class="text-purple-700 text-sm mt-1">
                                            This plan is synced with Stripe. Price changes will update Stripe products.
                                            Product ID: <code class="bg-purple-100 px-2 py-1 rounded text-xs">{{ $pricingPlan->stripe_product_id }}</code>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div>
                            <label for="currency" class="block text-sm font-semibold text-gray-700 mb-2">Currency <span class="text-red-500">*</span></label>
                            <select id="currency" name="currency" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('currency') border-red-500 ring-2 ring-red-200 @enderror" required>
                                @foreach([
                                    'USD' => 'USD - US Dollar',
                                    'EUR' => 'EUR - Euro', 
                                    'GBP' => 'GBP - British Pound',
                                    'CAD' => 'CAD - Canadian Dollar',
                                    'AUD' => 'AUD - Australian Dollar'
                                ] as $code => $label)
                                    <option value="{{ $code }}" {{ old('currency', $pricingPlan->currency) === $code ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('currency')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="price_monthly" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Monthly Price
                                    @if($pricingPlan->stripe_price_id_monthly)
                                        <span class="ml-2 bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Synced</span>
                                    @endif
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                    <input type="number" id="price_monthly" name="price_monthly" value="{{ old('price_monthly', $pricingPlan->price_monthly) }}"
                                           step="0.01" min="0"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('price_monthly') border-red-500 ring-2 ring-red-200 @enderror"
                                           placeholder="29.99" onchange="calculateYearlySavings()">
                                </div>
                                @error('price_monthly')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                @if($pricingPlan->stripe_price_id_monthly)
                                    <p class="text-xs text-gray-500 mt-1">Price ID: {{ $pricingPlan->stripe_price_id_monthly }}</p>
                                @endif
                            </div>

                            <div>
                                <label for="price_yearly" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Yearly Price
                                    @if($pricingPlan->stripe_price_id_yearly)
                                        <span class="ml-2 bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Synced</span>
                                    @endif
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                    <input type="number" id="price_yearly" name="price_yearly" value="{{ old('price_yearly', $pricingPlan->price_yearly) }}"
                                           step="0.01" min="0"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('price_yearly') border-red-500 ring-2 ring-red-200 @enderror"
                                           placeholder="299.99" onchange="calculateYearlySavings()">
                                </div>
                                @error('price_yearly')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                <div id="yearlySavings" class="text-xs text-green-600 mt-1"></div>
                                @if($pricingPlan->stripe_price_id_yearly)
                                    <p class="text-xs text-gray-500 mt-1">Price ID: {{ $pricingPlan->stripe_price_id_yearly }}</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label for="trial_days" class="block text-sm font-semibold text-gray-700 mb-2">Free Trial (Days)</label>
                            <input type="number" id="trial_days" name="trial_days" value="{{ old('trial_days', $pricingPlan->trial_days) }}"
                                   min="0" max="365"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('trial_days') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="14">
                            @error('trial_days')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            <p class="text-xs text-gray-500 mt-1">Leave 0 for no trial period</p>
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
                                       value="{{ old('setup_fee', $pricingPlan->setup_fee ?? 0) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="0.00">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Leave 0 for no setup fee</p>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-list-ul mr-2 text-blue-600"></i>Features & Limits
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Plan Features</label>
                            <div id="featuresContainer" class="space-y-3">
                                @php $features = is_array($pricingPlan->features) ? $pricingPlan->features : json_decode($pricingPlan->features ?? '[]', true) ?? []; @endphp
                                @forelse($features as $index => $feature)
                                    <div class="flex items-center space-x-3 feature-item">
                                        <input type="text" name="features[]" value="{{ $feature }}"
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                               placeholder="e.g., 5 Live TV Channels" onchange="updatePreview()">
                                        <button type="button" onclick="removeFeature(this)" class="text-red-600 hover:text-red-800 p-2">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @empty
                                    <div class="flex items-center space-x-3 feature-item">
                                        <input type="text" name="features[]" 
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                               placeholder="e.g., 5 Live TV Channels" onchange="updatePreview()">
                                        <button type="button" onclick="removeFeature(this)" class="text-red-600 hover:text-red-800 p-2">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" onclick="addFeature()" class="mt-3 text-primary hover:text-secondary font-medium text-sm">
                                <i class="fas fa-plus mr-2"></i>Add Feature
                            </button>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach([
                                'max_users' => 'Max Viewers',
                                'max_projects' => 'Max Bitrate', 
                                'storage_limit' => 'Storage Limit',
                                'bandwidth_limit' => 'Bandwidth Limit'
                            ] as $field => $label)
                                <div>
                                    <label for="{{ $field }}" class="block text-sm font-semibold text-gray-700 mb-2">{{ $label }}</label>
                                    <input type="{{ in_array($field, ['max_users', 'max_projects']) ? 'number' : 'text' }}" 
                                           id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $pricingPlan->$field) }}"
                                           {{ in_array($field, ['max_users', 'max_projects']) ? 'min="1"' : '' }}
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error($field) border-red-500 ring-2 ring-red-200 @enderror"
                                           placeholder="{{ in_array($field, ['max_users', 'max_projects']) ? 'Leave empty for unlimited' : 'e.g., 100 GB' }}">
                                    @error($field)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            @endforeach
                        </div>

                        <div>
                            <label for="support_level" class="block text-sm font-semibold text-gray-700 mb-2">Support Level <span class="text-red-500">*</span></label>
                            <select id="support_level" name="support_level" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('support_level') border-red-500 ring-2 ring-red-200 @enderror" required>
                                @foreach(['basic' => 'Basic Support', 'priority' => 'Priority Support', 'premium' => 'Premium Support'] as $value => $text)
                                    <option value="{{ $value }}" {{ old('support_level', $pricingPlan->support_level) === $value ? 'selected' : '' }}>{{ $text }}</option>
                                @endforeach
                            </select>
                            @error('support_level')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Live Preview -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-eye mr-2 text-blue-600"></i>Live Preview
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-900 rounded-xl p-6 text-white text-center" id="planPreview">
                            <div class="w-12 h-12 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mx-auto mb-4">
                                <i id="previewIcon" class="{{ $pricingPlan->icon }} text-white"></i>
                            </div>
                            <h3 id="previewName" class="text-xl font-bold mb-2">{{ $pricingPlan->name }}</h3>
                            <p id="previewShortDesc" class="text-gray-400 text-sm mb-4">{{ $pricingPlan->short_description }}</p>
                            <div id="previewPrice" class="text-2xl font-black mb-4">${{ number_format($pricingPlan->price_monthly ?? 0) }}/month</div>
                            <div id="previewFeatures" class="text-left space-y-2">
                                @foreach($features as $feature)
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-check text-green-400"></i>
                                        <span class="text-sm">{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plan Stats -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-green-600"></i>Plan Statistics
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @foreach([
                            'Active Subscribers' => '0',
                            'Created' => $pricingPlan->created_at->format('M d, Y'),
                            'Last Updated' => $pricingPlan->updated_at->diffForHumans(),
                            'Display Order' => '#' . $pricingPlan->sort_order
                        ] as $label => $value)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ $label }}</span>
                                <span class="font-semibold text-gray-900">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Display Settings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-cog mr-2 text-gray-600"></i>Display Settings
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">Icon Class</label>
                                <input type="text" id="icon" name="icon" value="{{ old('icon', $pricingPlan->icon) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="fas fa-star" onchange="updatePreview()">
                                <p class="text-xs text-gray-500 mt-1">FontAwesome icon class</p>
                            </div>

                            <div>
                                <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">Color Scheme</label>
                                <select id="color" name="color" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                        onchange="updatePreview()">
                                    @foreach([
                                        'primary' => 'Primary (Red)',
                                        'secondary' => 'Secondary',
                                        'accent' => 'Accent',
                                        'blue' => 'Blue',
                                        'green' => 'Green',
                                        'purple' => 'Purple'
                                    ] as $value => $text)
                                        <option value="{{ $value }}" {{ old('color', $pricingPlan->color) === $value ? 'selected' : '' }}>{{ $text }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach([
                                'is_popular' => 'Popular Plan',
                                'is_featured' => 'Featured Plan', 
                                'show_in_home' => 'Show on Homepage',
                                'show_in_pricing' => 'Show on Pricing Page'
                            ] as $field => $label)
                                <div class="flex items-center justify-between">
                                    <label for="{{ $field }}" class="text-sm font-medium text-gray-700">{{ $label }}</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="{{ $field }}" name="{{ $field }}" value="1" 
                                               {{ old($field, $pricingPlan->$field) ? 'checked' : '' }} class="sr-only toggle-input">
                                        <div class="toggle-switch {{ old($field, $pricingPlan->$field) ? 'active' : '' }}">
                                            <div class="toggle-circle {{ old($field, $pricingPlan->$field) ? 'active' : '' }}"></div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">Display Order</label>
                                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $pricingPlan->sort_order) }}"
                                       min="0" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200" required>
                                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first</p>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select id="status" name="status" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200" required>
                                    <option value="active" {{ old('status', $pricingPlan->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $pricingPlan->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-search mr-2 text-green-600"></i>SEO Settings
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-2">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $pricingPlan->meta_title) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                   placeholder="Auto-generated if empty" maxlength="255">
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-2">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                                      placeholder="Auto-generated if empty">{{ old('meta_description', $pricingPlan->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-primary to-secondary text-white px-6 py-4 rounded-xl font-bold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-save mr-2"></i>Update Pricing Plan
                    </button>
                    
                    <a href="{{ route('admin.pricing-plans.index') }}" 
                       class="w-full inline-block text-center bg-gray-100 text-gray-700 px-6 py-4 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    
                    @if(!isset($pricingPlan->subscriptions) || $pricingPlan->subscriptions->where('status', 'active')->count() === 0)
                        <button type="button" onclick="deletePlan()"
                                class="w-full bg-red-100 text-red-700 px-6 py-4 rounded-xl font-semibold hover:bg-red-200 transition-all duration-300">
                            <i class="fas fa-trash mr-2"></i>Delete Plan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
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

// Feature management
function addFeature() {
    const container = document.getElementById('featuresContainer');
    const newFeature = document.createElement('div');
    newFeature.className = 'flex items-center space-x-3 feature-item';
    newFeature.innerHTML = `
        <input type="text" name="features[]" 
               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
               placeholder="Enter feature description" onchange="updatePreview()">
        <button type="button" onclick="removeFeature(this)" class="text-red-600 hover:text-red-800 p-2">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(newFeature);
}

function removeFeature(button) {
    const featureItem = button.closest('.feature-item');
    featureItem.remove();
    updatePreview();
}

// Update live preview
function updatePreview() {
    const name = document.getElementById('name').value || '{{ $pricingPlan->name }}';
    const shortDesc = document.getElementById('short_description').value || '{{ $pricingPlan->short_description }}';
    const monthlyPrice = parseFloat(document.getElementById('price_monthly').value) || 0;
    const yearlyPrice = parseFloat(document.getElementById('price_yearly').value) || 0;
    const icon = document.getElementById('icon').value || '{{ $pricingPlan->icon }}';
    
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
                <span class="text-sm">No features added</span>
            </div>
        `;
    }
}

// Enhanced API request helper
async function makeApiRequest(url, options = {}) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        throw new Error('CSRF token not found');
    }

    const defaultOptions = {
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    };

    const mergedOptions = {
        ...defaultOptions,
        ...options,
        headers: {
            ...defaultOptions.headers,
            ...options.headers
        }
    };

    try {
        const response = await fetch(url, mergedOptions);
        
        const responseText = await response.text();
        let data;
        
        try {
            data = JSON.parse(responseText);
        } catch (parseError) {
            if (responseText.includes('<!DOCTYPE html>')) {
                if (responseText.includes('404')) {
                    throw new Error('Resource not found (404). The pricing plan may have been deleted.');
                } else if (responseText.includes('500')) {
                    throw new Error('Server error (500). Please try again later.');
                } else {
                    throw new Error('Server returned an unexpected response. Please refresh the page.');
                }
            } else {
                throw new Error(`Invalid response: ${responseText.substring(0, 100)}...`);
            }
        }
        
        if (!response.ok) {
            const errorMessage = data?.message || data?.error || `HTTP ${response.status}`;
            throw new Error(errorMessage);
        }

        return data;

    } catch (error) {
        console.error('API request failed:', error);
        throw error;
    }
}

// Sync with Stripe
function syncStripe() {
    if (confirm('Sync this plan with Stripe? This will create or update products and prices.')) {
        makeApiRequest('/admin/pricing-plans/{{ $pricingPlan->id }}/sync-stripe', {
            method: 'POST'
        })
        .then(data => {
            alert(data.message || 'Stripe sync completed');
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to sync with Stripe: ' + error.message);
        });
    }
}

// Delete plan
function deletePlan() {
    if (confirm('Are you sure you want to delete this pricing plan? This action cannot be undone.')) {
        makeApiRequest('/admin/pricing-plans/{{ $pricingPlan->id }}', {
            method: 'DELETE'
        })
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("admin.pricing-plans.index") }}';
            } else {
                alert(data.message || 'Failed to delete plan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete plan: ' + error.message);
        });
    }
}

// Enhanced notification function
function showNotification(message, type = 'success') {
    if (!message) return;
    
    const existingNotifications = document.querySelectorAll('.notification-toast');
    existingNotifications.forEach(notification => {
        if (document.body.contains(notification)) {
            document.body.removeChild(notification);
        }
    });
    
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white max-w-md`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
            <span class="text-sm font-medium">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white/80 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => notification.classList.remove('translate-x-full'), 100);
    
    setTimeout(() => {
        if (document.body.contains(notification)) {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }
    }, 5000);
}

// Toggle functionality
function initializeToggles() {
    document.querySelectorAll('.toggle-input').forEach(checkbox => {
        const toggleSwitch = checkbox.nextElementSibling;
        const toggleCircle = toggleSwitch.querySelector('.toggle-circle');
        
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                toggleSwitch.classList.add('active');
                toggleCircle.classList.add('active');
            } else {
                toggleSwitch.classList.remove('active');
                toggleCircle.classList.remove('active');
            }
        });
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize toggles
    initializeToggles();
    
    // Calculate initial savings
    calculateYearlySavings();
    
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
});

// Add CSS for notification
const style = document.createElement('style');
style.textContent = `
    .notification-toast {
        word-wrap: break-word;
        max-width: 400px;
    }
`;
document.head.appendChild(style);
</script>
@endpush