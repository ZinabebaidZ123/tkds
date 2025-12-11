{{-- File: resources/views/admin/shop/settings/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Shop Settings')
@section('page-title', 'Shop Settings')

@section('content')
<div class="space-y-6">
   
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Shop Settings</h2>
            <p class="text-gray-600 text-sm mt-1">Configure your shop preferences and policies</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.shop.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
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

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-red-800 font-medium">Please fix the following errors:</h3>
                    <ul class="text-red-700 text-sm mt-1 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Settings Form -->
    <form action="{{ route('admin.shop.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- General Information -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-store text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">General Information</h3>
                    <p class="text-gray-600 text-sm">Basic shop details and contact information</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Shop Name *
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="shop_name" value="{{ old('shop_name', $settings['shop_name']) }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('shop_name') border-red-500 @enderror">
                    @error('shop_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Shop Email *
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="shop_email" value="{{ old('shop_email', $settings['shop_email']) }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('shop_email') border-red-500 @enderror">
                    @error('shop_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Shop Description</label>
                    <textarea name="shop_description" rows="3"
                              placeholder="Describe your shop and what you sell..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('shop_description') border-red-500 @enderror">{{ old('shop_description', $settings['shop_description']) }}</textarea>
                    @error('shop_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="shop_phone" value="{{ old('shop_phone', $settings['shop_phone']) }}" 
                           placeholder="+1 (555) 123-4567"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('shop_phone') border-red-500 @enderror">
                    @error('shop_phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Default Currency *
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="default_currency" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('default_currency') border-red-500 @enderror">
                        <option value="USD" {{ old('default_currency', $settings['default_currency']) == 'USD' ? 'selected' : '' }}>🇺🇸 USD - US Dollar</option>
                        <option value="EUR" {{ old('default_currency', $settings['default_currency']) == 'EUR' ? 'selected' : '' }}>🇪🇺 EUR - Euro</option>
                        <option value="GBP" {{ old('default_currency', $settings['default_currency']) == 'GBP' ? 'selected' : '' }}>🇬🇧 GBP - British Pound</option>
                        <option value="CAD" {{ old('default_currency', $settings['default_currency']) == 'CAD' ? 'selected' : '' }}>🇨🇦 CAD - Canadian Dollar</option>
                        <option value="AUD" {{ old('default_currency', $settings['default_currency']) == 'AUD' ? 'selected' : '' }}>🇦🇺 AUD - Australian Dollar</option>
                        <option value="JPY" {{ old('default_currency', $settings['default_currency']) == 'JPY' ? 'selected' : '' }}>🇯🇵 JPY - Japanese Yen</option>
                    </select>
                    @error('default_currency')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Business Address</label>
                    <textarea name="shop_address" rows="2"
                              placeholder="Enter your business address..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('shop_address') border-red-500 @enderror">{{ old('shop_address', $settings['shop_address']) }}</textarea>
                    @error('shop_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Business Settings -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Business Settings</h3>
                    <p class="text-gray-600 text-sm">Financial and operational configurations</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tax Rate (%)</label>
                    <input type="number" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate']) }}" 
                           min="0" max="100" step="0.01"
                           placeholder="0.00"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('tax_rate') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Leave empty or 0 for no tax</p>
                    @error('tax_rate')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Low Stock Threshold</label>
                    <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', $settings['low_stock_threshold']) }}" 
                           min="1" placeholder="5"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('low_stock_threshold') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Alert when products reach this quantity</p>
                    @error('low_stock_threshold')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Feature Settings -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-toggle-on text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Feature Settings</h3>
                    <p class="text-gray-600 text-sm">Enable or disable shop features</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shipping-fast text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Enable Shipping</h4>
                                <p class="text-xs text-gray-500">Allow physical product shipping</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="shipping_enabled" value="1" 
                                   class="sr-only peer" 
                                   {{ old('shipping_enabled', $settings['shipping_enabled']) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-download text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Digital Products</h4>
                                <p class="text-xs text-gray-500">Enable downloadable products</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="digital_products_enabled" value="1" 
                                   class="sr-only peer" 
                                   {{ old('digital_products_enabled', $settings['digital_products_enabled']) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-boxes text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Inventory Tracking</h4>
                                <p class="text-xs text-gray-500">Track product stock levels</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="inventory_tracking" value="1" 
                                   class="sr-only peer" 
                                   {{ old('inventory_tracking', $settings['inventory_tracking']) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-star text-yellow-600"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Customer Reviews</h4>
                                <p class="text-xs text-gray-500">Allow product reviews</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="reviews_enabled" value="1" 
                                   class="sr-only peer" 
                                   {{ old('reviews_enabled', $settings['reviews_enabled']) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-double text-indigo-600"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Auto-Approve Reviews</h4>
                                <p class="text-xs text-gray-500">Automatically approve new reviews</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="auto_approve_reviews" value="1" 
                                   class="sr-only peer" 
                                   {{ old('auto_approve_reviews', $settings['auto_approve_reviews']) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Legal & Policy Pages -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-gavel text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Legal & Policy Pages</h3>
                    <p class="text-gray-600 text-sm">Important legal page links for compliance</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-file-contract mr-2 text-blue-500"></i>
                        Terms of Service URL
                    </label>
                    <input type="url" name="terms_url" value="{{ old('terms_url', $settings['terms_url']) }}" 
                           placeholder="https://yoursite.com/terms"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('terms_url') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Link to your terms of service page</p>
                    @error('terms_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                        Privacy Policy URL
                    </label>
                    <input type="url" name="privacy_url" value="{{ old('privacy_url', $settings['privacy_url']) }}" 
                           placeholder="https://yoursite.com/privacy"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('privacy_url') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Link to your privacy policy page</p>
                    @error('privacy_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-undo mr-2 text-orange-500"></i>
                        Return Policy URL
                    </label>
                    <input type="url" name="return_policy_url" value="{{ old('return_policy_url', $settings['return_policy_url']) }}" 
                           placeholder="https://yoursite.com/returns"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('return_policy_url') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Link to your return/refund policy</p>
                    @error('return_policy_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-200">
            <div class="text-sm text-gray-600">
                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                Changes will be applied immediately after saving.
            </div>
            <div class="flex space-x-4">
                <button type="reset" 
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 transition-all duration-200 font-medium">
                    <i class="fas fa-undo mr-2"></i>
                    Reset Form
                </button>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Save Settings
                </button>
            </div>
        </div>
    </form>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 border border-blue-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-rocket text-primary mr-3"></i>
            Quick Actions
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.shop.products.index') }}" 
               class="flex items-center justify-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-cube text-2xl text-primary mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                    <p class="font-medium text-gray-900">Manage Products</p>
                </div>
            </a>
            
            <a href="{{ route('admin.shop.orders.index') }}" 
               class="flex items-center justify-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-shopping-cart text-2xl text-primary mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                    <p class="font-medium text-gray-900">View Orders</p>
                </div>
            </a>
            
            <a href="{{ route('admin.shop.analytics') }}" 
               class="flex items-center justify-center p-4 bg-white rounded-xl border border-gray-200 hover:border-primary hover:shadow-lg transition-all duration-200 group">
                <div class="text-center">
                    <i class="fas fa-chart-line text-2xl text-primary mb-2 group-hover:scale-110 transition-transform duration-200"></i>
                    <p class="font-medium text-gray-900">Analytics</p>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
// Form validation and enhancement
document.addEventListener('DOMContentLoaded', function() {
    // Auto-save draft (optional)
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea, select');
    
    // Add smooth transitions to toggles
    const toggles = document.querySelectorAll('input[type="checkbox"]');
    toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            // Add visual feedback
            const label = this.nextElementSibling;
            if (label) {
                label.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    label.style.transform = 'scale(1)';
                }, 100);
            }
        });
    });

    // Form submission enhancement
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        submitBtn.disabled = true;
    });

    // Reset form functionality
    const resetBtn = form.querySelector('button[type="reset"]');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to reset all changes? This will restore the original values.')) {
                form.reset();
                // Reset any custom styling
                inputs.forEach(input => {
                    input.classList.remove('border-red-500');
                });
            }
        });
    }
});
</script>
@endsection