@extends('layouts.user')

@section('title', 'Profile Settings - TKDS Media')
@section('meta_description', 'Manage your TKDS Media account settings, personal information, and preferences.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('user.dashboard') }}" class="text-gray-400 hover:text-primary transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
            </div>
            <h1 class="text-3xl font-black text-white mb-2">Profile Settings</h1>
            <p class="text-gray-400">Manage your account information and preferences</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 mb-6 animate-fade-in">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                    <p class="text-green-400">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-6 animate-fade-in">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-400 mr-3"></i>
                    <p class="text-red-400">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="grid lg:grid-cols-4 gap-8">
            
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10 sticky top-24">
                    <nav class="space-y-2">
                        <a href="#personal" onclick="showTab('personal')" class="profile-tab active flex items-center space-x-3 px-4 py-3 rounded-xl text-white hover:bg-white/10 transition-all duration-200">
                            <i class="fas fa-user"></i>
                            <span>Personal Info</span>
                        </a>
                        <a href="#security" onclick="showTab('security')" class="profile-tab flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-all duration-200">
                            <i class="fas fa-lock"></i>
                            <span>Security</span>
                        </a>
                        <a href="#billing" onclick="showTab('billing')" class="profile-tab flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-all duration-200">
                            <i class="fas fa-credit-card"></i>
                            <span>Billing Info</span>
                        </a>
                        <a href="#shipping" onclick="showTab('shipping')" class="profile-tab flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-all duration-200">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Shipping Info</span>
                        </a>
                        <a href="#sessions" onclick="showTab('sessions')" class="profile-tab flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-all duration-200">
                            <i class="fas fa-shield-alt"></i>
                            <span>Active Sessions</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                
                <!-- Personal Information Tab -->
                <div id="personal-tab" class="profile-content">
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                        <h2 class="text-2xl font-bold text-white mb-6">Personal Information</h2>
                        
                        <form method="POST" action="{{ route('user.profile.personal') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Avatar Upload -->
                            <div class="flex items-center space-x-6">
                                <div class="relative">
                                    <img id="avatarPreview" src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-2xl object-cover border-4 border-primary/20">
                                    <label for="avatar" class="absolute -bottom-2 -right-2 w-8 h-8 bg-primary rounded-full flex items-center justify-center cursor-pointer hover:bg-secondary transition-colors duration-200">
                                        <i class="fas fa-camera text-white text-xs"></i>
                                    </label>
                                    <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold">Profile Picture</h3>
                                    <p class="text-gray-400 text-sm">Upload a new avatar. Max 2MB.</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Full Name -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-white mb-2">
                                        Full Name <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-white mb-2">
                                        Email Address <span class="text-red-400">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-white mb-2">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('phone') border-red-500 @enderror">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-semibold text-white mb-2">Date of Birth</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('date_of_birth') border-red-500 @enderror">
                                    @error('date_of_birth')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="block text-sm font-semibold text-white mb-2">Gender</label>
                                    <select id="gender" name="gender"
                                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('gender') border-red-500 @enderror">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Location -->
                                <div>
                                    <label for="location" class="block text-sm font-semibold text-white mb-2">Location</label>
                                    <input type="text" id="location" name="location" value="{{ old('location', $user->profile?->location) }}" placeholder="City, Country"
                                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('location') border-red-500 @enderror">
                                    @error('location')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bio -->
                            <div>
                                <label for="bio" class="block text-sm font-semibold text-white mb-2">Bio</label>
                                <textarea id="bio" name="bio" rows="4" placeholder="Tell us about yourself..."
                                          class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('bio') border-red-500 @enderror">{{ old('bio', $user->profile?->bio) }}</textarea>
                                @error('bio')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website & Company -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="website" class="block text-sm font-semibold text-white mb-2">Website</label>
                                    <input type="url" id="website" name="website" value="{{ old('website', $user->profile?->website) }}" placeholder="https://example.com"
                                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('website') border-red-500 @enderror">
                                    @error('website')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="company" class="block text-sm font-semibold text-white mb-2">Company</label>
                                    <input type="text" id="company" name="company" value="{{ old('company', $user->profile?->company) }}"
                                           class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('company') border-red-500 @enderror">
                                    @error('company')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-8 py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Tab -->
                <div id="security-tab" class="profile-content hidden">
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                        <h2 class="text-2xl font-bold text-white mb-6">Security Settings</h2>
                        
                        <form method="POST" action="{{ route('user.profile.password') }}" class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-white mb-2">
                                    Current Password <span class="text-red-400">*</span>
                                </label>
                                <input type="password" id="current_password" name="current_password" required
                                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-white mb-2">
                                    New Password <span class="text-red-400">*</span>
                                </label>
                                <input type="password" id="password" name="password" required
                                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-white mb-2">
                                    Confirm New Password <span class="text-red-400">*</span>
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="bg-gradient-to-r from-secondary to-accent text-white px-8 py-3 rounded-xl font-semibold hover:from-accent hover:to-primary transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Billing Info Tab -->
                <div id="billing-tab" class="profile-content hidden">
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-white">Billing Information</h2>
                            <button onclick="showBillingForm()" class="bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-lg font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                                <i class="fas fa-plus mr-2"></i>Add New
                            </button>
                        </div>

                        <!-- Billing Addresses -->
                        <div class="space-y-4">
                            @forelse($user->billingInfo as $billing)
                                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-white font-semibold mb-2">{{ $billing->billing_name }}</h3>
                                            <p class="text-gray-400 text-sm">{{ $billing->getFullAddress() }}</p>
                                            @if($billing->is_default)
                                                <span class="inline-block bg-primary/20 text-primary px-3 py-1 rounded-full text-xs font-medium mt-2">Default</span>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            <button onclick="editBilling({{ $billing->id }})" class="text-gray-400 hover:text-white">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form method="POST" action="{{ route('user.profile.billing.delete', $billing) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-400" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <i class="fas fa-credit-card text-gray-600 text-4xl mb-4"></i>
                                    <h3 class="text-white font-semibold mb-2">No billing information</h3>
                                    <p class="text-gray-400">Add your billing details to make purchases easier.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Add Billing Form (Hidden by default) -->
                        <div id="billingForm" class="hidden mt-6 pt-6 border-t border-white/20">
                            <form method="POST" action="{{ route('user.profile.billing.store') }}" class="space-y-6">
                                @csrf
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Billing Name *</label>
                                        <input type="text" name="billing_name" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Email *</label>
                                        <input type="email" name="billing_email" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Address Line 1 *</label>
                                        <input type="text" name="address_line_1" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Address Line 2</label>
                                        <input type="text" name="address_line_2" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">City *</label>
                                        <input type="text" name="city" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Postal Code *</label>
                                        <input type="text" name="postal_code" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Country *</label>
                                        <input type="text" name="country" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_default_billing" name="is_default" class="w-4 h-4 text-primary bg-white/10 border-white/20 rounded focus:ring-primary">
                                        <label for="is_default_billing" class="ml-2 text-white text-sm">Set as default</label>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-4">
                                    <button type="button" onclick="hideBillingForm()" class="px-6 py-3 border border-white/20 text-white rounded-xl hover:bg-white/10 transition-colors duration-200">Cancel</button>
                                    <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info Tab -->
                <div id="shipping-tab" class="profile-content hidden">
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-white">Shipping Information</h2>
                            <button onclick="showShippingForm()" class="bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-lg font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                                <i class="fas fa-plus mr-2"></i>Add New
                            </button>
                        </div>

                        <!-- Shipping Addresses -->
                        <div class="space-y-4">
                            @forelse($user->shippingInfo as $shipping)
                                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-white font-semibold mb-2">{{ $shipping->shipping_name }}</h3>
                                            <p class="text-gray-400 text-sm">{{ $shipping->getFullAddress() }}</p>
                                            @if($shipping->is_default)
                                                <span class="inline-block bg-primary/20 text-primary px-3 py-1 rounded-full text-xs font-medium mt-2">Default</span>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            <button onclick="editShipping({{ $shipping->id }})" class="text-gray-400 hover:text-white">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form method="POST" action="{{ route('user.profile.shipping.delete', $shipping) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-400" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <i class="fas fa-shipping-fast text-gray-600 text-4xl mb-4"></i>
                                    <h3 class="text-white font-semibold mb-2">No shipping information</h3>
                                    <p class="text-gray-400">Add your delivery addresses for faster checkout.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Add Shipping Form (Hidden by default) -->
                        <div id="shippingForm" class="hidden mt-6 pt-6 border-t border-white/20">
                            <form method="POST" action="{{ route('user.profile.shipping.store') }}" class="space-y-6">
                                @csrf
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Recipient Name *</label>
                                        <input type="text" name="shipping_name" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Phone Number</label>
                                        <input type="tel" name="shipping_phone" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Address Line 1 *</label>
                                        <input type="text" name="address_line_1" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Address Line 2</label>
                                        <input type="text" name="address_line_2" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                        </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">City *</label>
                                        <input type="text" name="city" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Postal Code *</label>
                                        <input type="text" name="postal_code" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-white mb-2">Country *</label>
                                        <input type="text" name="country" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_default_shipping" name="is_default" class="w-4 h-4 text-primary bg-white/10 border-white/20 rounded focus:ring-primary">
                                        <label for="is_default_shipping" class="ml-2 text-white text-sm">Set as default</label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-white mb-2">Delivery Instructions</label>
                                    <textarea name="delivery_instructions" rows="3" placeholder="Special delivery instructions..."
                                              class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                                </div>
                                <div class="flex justify-end space-x-4">
                                    <button type="button" onclick="hideShippingForm()" class="px-6 py-3 border border-white/20 text-white rounded-xl hover:bg-white/10 transition-colors duration-200">Cancel</button>
                                    <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sessions Tab -->
                <div id="sessions-tab" class="profile-content hidden">
                    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">
                        <h2 class="text-2xl font-bold text-white mb-6">Active Sessions</h2>
                        
                        <div class="space-y-4">
                            @forelse($sessions as $session)
                                <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-r from-gray-600 to-gray-700 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-{{ $session->device_type === 'mobile' ? 'mobile-alt' : ($session->device_type === 'tablet' ? 'tablet-alt' : 'desktop') }} text-white"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-white font-semibold">{{ $session->getDeviceInfo() }}</h3>
                                                <p class="text-gray-400 text-sm">{{ $session->getLocationInfo() }}</p>
                                                <p class="text-gray-500 text-xs mt-1">
                                                    {{ $session->login_at->diffForHumans() }}
                                                    @if($session->is_active)
                                                        • <span class="text-green-400">Active now</span>
                                                    @else
                                                        • Duration: {{ $session->getDuration() }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            @if($session->is_active)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                                    Active
                                                </span>
                                                @if($session->session_id !== session()->getId())
                                                    <form method="POST" action="{{ route('user.sessions.terminate', $session->session_id) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-400 hover:text-red-300 text-sm" onclick="return confirm('Terminate this session?')">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-primary text-sm font-medium">Current Session</span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400">
                                                    Ended
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <i class="fas fa-shield-alt text-gray-600 text-4xl mb-4"></i>
                                    <h3 class="text-white font-semibold mb-2">No active sessions</h3>
                                    <p class="text-gray-400">Your login sessions will appear here.</p>
                                </div>
                            @endforelse
                        </div>

                        @if($sessions->hasPages())
                            <div class="mt-6">
                                {{ $sessions->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching functionality
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.profile-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active state from all tab buttons
    document.querySelectorAll('.profile-tab').forEach(button => {
        button.classList.remove('active', 'text-white', 'bg-white/10');
        button.classList.add('text-gray-400');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active state to clicked tab button
    const activeButton = document.querySelector(`.profile-tab[onclick="showTab('${tabName}')"]`);
    activeButton.classList.add('active', 'text-white', 'bg-white/10');
    activeButton.classList.remove('text-gray-400');
}

// Avatar preview
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Billing form functions
function showBillingForm() {
    document.getElementById('billingForm').classList.remove('hidden');
}

function hideBillingForm() {
    document.getElementById('billingForm').classList.add('hidden');
}

// Shipping form functions
function showShippingForm() {
    document.getElementById('shippingForm').classList.remove('hidden');
}

function hideShippingForm() {
    document.getElementById('shippingForm').classList.add('hidden');
}

// Edit functions (you can implement these later)
function editBilling(id) {
    // Implement edit billing functionality
    console.log('Edit billing:', id);
}

function editShipping(id) {
    // Implement edit shipping functionality
    console.log('Edit shipping:', id);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a hash in URL to show specific tab
    const hash = window.location.hash.substring(1);
    if (hash && document.getElementById(hash + '-tab')) {
        showTab(hash);
    }
    
    // Update URL when tab changes
    document.querySelectorAll('.profile-tab').forEach(tab => {
        tab.addEventListener('click', function(e) {
            const tabName = this.getAttribute('onclick').match(/'(.+?)'/)[1];
            window.history.replaceState(null, null, '#' + tabName);
        });
    });
});
</script>
@endsection