@extends('admin.layouts.app')

@section('title', isset($user) ? 'Edit User' : 'Add New User')
@section('page-title', isset($user) ? 'Edit User' : 'Add New User')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.users.index') }}" class="hover:text-primary transition-colors duration-200">User Management</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($user) ? 'Edit User' : 'Add New User' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($user) ? 'Edit User' : 'Add New User' }}
                </h2>
                <p class="text-gray-600 text-sm mt-1">
                    {{ isset($user) ? 'Update user information and settings' : 'Create a new user account' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" 
                  method="POST" enctype="multipart/form-data" class="space-y-6" id="userForm">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif
                
                <!-- Basic Information Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Basic Information
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Avatar Upload -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-image mr-2 text-primary"></i>
                                Profile Picture
                            </label>
                            
                            <div class="flex items-center space-x-6">
                                <!-- Current Avatar -->
                                <div class="flex-shrink-0">
                                    <img id="avatarPreview" 
                                         src="{{ isset($user) ? $user->getAvatarUrl() : 'https://ui-avatars.com/api/?name=New+User&color=fff&background=C53030&size=200' }}" 
                                         alt="Avatar" 
                                         class="w-20 h-20 rounded-full object-cover border-4 border-gray-200 shadow-sm">
                                </div>
                                
                                <!-- Upload Button -->
                                <div class="flex-1">
                                    <label for="avatar" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <i class="fas fa-upload mr-2"></i>
                                        Choose Photo
                                    </label>
                                    <input id="avatar" name="avatar" type="file" class="sr-only" accept="image/*" onchange="previewAvatar(this)">
                                    <p class="mt-2 text-xs text-gray-500">JPG, PNG, GIF up to 2MB</p>
                                    @error('avatar')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Name and Email -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-user mr-2 text-primary"></i>
                                    Full Name *
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="Enter full name"
                                       required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-envelope mr-2 text-primary"></i>
                                    Email Address *
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('email') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="Enter email address"
                                       required>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone and Date of Birth -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-phone mr-2 text-primary"></i>
                                    Phone Number
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('phone') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="Enter phone number">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="date_of_birth" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-calendar mr-2 text-primary"></i>
                                    Date of Birth
                                </label>
                                <input type="date" 
                                       id="date_of_birth" 
                                       name="date_of_birth" 
                                       value="{{ old('date_of_birth', isset($user) && $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('date_of_birth') border-red-500 ring-2 ring-red-200 @enderror"
                                       max="{{ now()->subYears(13)->format('Y-m-d') }}">
                                @error('date_of_birth')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="space-y-2">
                            <label for="gender" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-venus-mars mr-2 text-primary"></i>
                                Gender
                            </label>
                            <select id="gender" 
                                    name="gender" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('gender') border-red-500 ring-2 ring-red-200 @enderror">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Security Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-shield-alt mr-2 text-red-600"></i>
                            Account Security
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="password" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-lock mr-2 text-primary"></i>
                                    Password {{ isset($user) ? '(Leave empty to keep current)' : '*' }}
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('password') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="Enter password"
                                       {{ !isset($user) ? 'required' : '' }}>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-lock mr-2 text-primary"></i>
                                    Confirm Password {{ isset($user) ? '' : '*' }}
                                </label>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                                       placeholder="Confirm password"
                                       {{ !isset($user) ? 'required' : '' }}>
                            </div>
                        </div>

                        <!-- Status and Email Verification -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="status" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-toggle-on mr-2 text-primary"></i>
                                    Account Status *
                                </label>
                                <select id="status" 
                                        name="status" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 ring-2 ring-red-200 @enderror"
                                        required>
                                    <option value="active" {{ old('status', $user->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                        ✅ Active (User can login)
                                    </option>
                                    <option value="inactive" {{ old('status', $user->status ?? '') === 'inactive' ? 'selected' : '' }}>
                                        ❌ Inactive (User cannot login)
                                    </option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-shield-check mr-2 text-primary"></i>
                                    Email Verification
                                </label>
                                <div class="flex items-center space-x-3 pt-2">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               name="email_verified" 
                                               value="1"
                                               class="sr-only"
                                               {{ old('email_verified', isset($user) && $user->isVerified() ? '1' : '0') === '1' ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-200"></div>
                                        <span class="ml-3 text-sm font-medium text-gray-700">Mark email as verified</span>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">Verified users can access all features</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Information Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-id-card mr-2 text-green-600"></i>
                            Additional Information
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Bio -->
                        <div class="space-y-2">
                            <label for="bio" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-user-edit mr-2 text-primary"></i>
                                Bio
                            </label>
                            <textarea id="bio" 
                                      name="bio" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('bio') border-red-500 ring-2 ring-red-200 @enderror"
                                      placeholder="Tell us about this user...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                            @error('bio')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website and Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="website" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-globe mr-2 text-primary"></i>
                                    Website
                                </label>
                                <input type="url" 
                                       id="website" 
                                       name="website" 
                                       value="{{ old('website', $user->profile->website ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('website') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="https://example.com">
                                @error('website')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="location" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                                    Location
                                </label>
                                <input type="text" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location', $user->profile->location ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('location') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="City, Country">
                                @error('location')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Company and Job Title -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="company" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-building mr-2 text-primary"></i>
                                    Company
                                </label>
                                <input type="text" 
                                       id="company" 
                                       name="company" 
                                       value="{{ old('company', $user->profile->company ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('company') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="Company name">
                                @error('company')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="job_title" class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-briefcase mr-2 text-primary"></i>
                                    Job Title
                                </label>
                                <input type="text" 
                                       id="job_title" 
                                       name="job_title" 
                                       value="{{ old('job_title', $user->profile->job_title ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('job_title') border-red-500 ring-2 ring-red-200 @enderror"
                                       placeholder="Job title">
                                @error('job_title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6">
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                            id="submitBtn">
                        <i class="fas fa-save mr-2"></i>
                        <span>{{ isset($user) ? 'Update User' : 'Create User' }}</span>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- User Stats (Edit mode only) -->
            @if(isset($user))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                        User Statistics
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">User ID</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $user->id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Member Since</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Login</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Sessions</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->sessions()->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Tips
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Strong Passwords</p>
                            <p class="text-xs text-gray-600">Use at least 8 characters with numbers and special characters</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Email Verification</p>
                            <p class="text-xs text-gray-600">Verified users have access to all platform features</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Profile Pictures</p>
                            <p class="text-xs text-gray-600">Use square images (1:1 ratio) for best results</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Account Status</p>
                            <p class="text-xs text-gray-600">Inactive users cannot login or access their accounts</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions (Edit mode only) -->
            @if(isset($user))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-2 text-purple-600"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.users.show', $user) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-eye mr-2"></i>
                        View Full Profile
                    </a>
                    @if(!$user->isVerified())
                        <button onclick="verifyUserEmail()" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                            <i class="fas fa-shield-check mr-2"></i>
                            Verify Email
                        </button>
                    @endif
                    <button onclick="sendPasswordReset()" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                        <i class="fas fa-key mr-2"></i>
                        Send Password Reset
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Avatar preview functionality
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Form submission with loading state
document.getElementById('userForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
});

// Quick actions for edit mode
@if(isset($user))
function verifyUserEmail() {
    if (confirm('Are you sure you want to verify this user\'s email?')) {
        fetch(`{{ route('admin.users.index') }}/{{ $user->id }}/verify-email`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email verified successfully!');
                location.reload();
            } else {
                alert('Failed to verify email: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while verifying email');
        });
    }
}

function sendPasswordReset() {
    alert('Password reset functionality would be implemented here.\nThis would send a password reset email to the user.');
    }
@endif

// Password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strength = calculatePasswordStrength(password);
    updatePasswordStrengthIndicator(strength);
});

function calculatePasswordStrength(password) {
    let score = 0;
    
    if (password.length >= 8) score++;
    if (password.match(/[a-z]/)) score++;
    if (password.match(/[A-Z]/)) score++;
    if (password.match(/[0-9]/)) score++;
    if (password.match(/[^a-zA-Z0-9]/)) score++;
    
    return score;
}

function updatePasswordStrengthIndicator(strength) {
    const indicator = document.getElementById('passwordStrength') || createPasswordStrengthIndicator();
    const colors = ['bg-red-500', 'bg-red-400', 'bg-yellow-400', 'bg-yellow-300', 'bg-green-500'];
    const texts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
    
    indicator.className = `mt-2 h-2 rounded-full transition-all duration-300 ${colors[strength - 1] || 'bg-gray-300'}`;
    indicator.style.width = `${(strength / 5) * 100}%`;
    
    const textElement = document.getElementById('passwordStrengthText') || createPasswordStrengthText();
    textElement.textContent = strength > 0 ? texts[strength - 1] : '';
    textElement.className = `text-xs mt-1 ${strength >= 4 ? 'text-green-600' : strength >= 3 ? 'text-yellow-600' : 'text-red-600'}`;
}

function createPasswordStrengthIndicator() {
    const passwordField = document.getElementById('password');
    const container = document.createElement('div');
    container.className = 'w-full bg-gray-200 rounded-full h-2 mt-2';
    
    const indicator = document.createElement('div');
    indicator.id = 'passwordStrength';
    indicator.className = 'h-2 rounded-full bg-gray-300 transition-all duration-300';
    indicator.style.width = '0%';
    
    const textElement = document.createElement('div');
    textElement.id = 'passwordStrengthText';
    textElement.className = 'text-xs mt-1 text-gray-500';
    
    container.appendChild(indicator);
    passwordField.parentNode.appendChild(container);
    passwordField.parentNode.appendChild(textElement);
    
    return indicator;
}

function createPasswordStrengthText() {
    return document.getElementById('passwordStrengthText');
}

// Real-time validation feedback
const formFields = ['name', 'email', 'phone'];
formFields.forEach(fieldName => {
    const field = document.getElementById(fieldName);
    if (field) {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            clearFieldError(this);
        });
    }
});

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    
    clearFieldError(field);
    
    switch(fieldName) {
        case 'name':
            if (value.length < 2) {
                showFieldError(field, 'Name must be at least 2 characters long');
            }
            break;
            
        case 'email':
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (value && !emailRegex.test(value)) {
                showFieldError(field, 'Please enter a valid email address');
            }
            break;
            
        case 'phone':
            if (value && value.length < 10) {
                showFieldError(field, 'Phone number should be at least 10 digits');
            }
            break;
    }
}

function showFieldError(field, message) {
    field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
    
    const existingError = field.parentNode.querySelector('.field-error');
    if (!existingError) {
        const errorElement = document.createElement('p');
        errorElement.className = 'mt-2 text-sm text-red-600 field-error';
        errorElement.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${message}`;
        field.parentNode.appendChild(errorElement);
    }
}

function clearFieldError(field) {
    field.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
    
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// Auto-save draft functionality (for long forms)
let autoSaveTimer;
const formData = {};

function startAutoSave() {
    if (autoSaveTimer) clearInterval(autoSaveTimer);
    
    autoSaveTimer = setInterval(() => {
        const form = document.getElementById('userForm');
        const formDataObj = new FormData(form);
        
        // Only save if there are changes
        let hasChanges = false;
        for (let [key, value] of formDataObj.entries()) {
            if (formData[key] !== value) {
                formData[key] = value;
                hasChanges = true;
            }
        }
        
        if (hasChanges) {
            localStorage.setItem('userFormDraft', JSON.stringify(formData));
            showAutoSaveIndicator();
        }
    }, 30000); // Auto-save every 30 seconds
}

function showAutoSaveIndicator() {
    const indicator = document.getElementById('autoSaveIndicator') || createAutoSaveIndicator();
    indicator.classList.remove('hidden');
    indicator.innerHTML = '<i class="fas fa-save mr-1"></i>Draft saved';
    
    setTimeout(() => {
        indicator.classList.add('hidden');
    }, 2000);
}

function createAutoSaveIndicator() {
    const indicator = document.createElement('div');
    indicator.id = 'autoSaveIndicator';
    indicator.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-3 py-2 rounded-lg text-sm shadow-lg hidden';
    document.body.appendChild(indicator);
    return indicator;
}

// Load draft on page load
window.addEventListener('DOMContentLoaded', function() {
    const draft = localStorage.getItem('userFormDraft');
    if (draft && !document.querySelector('input[name="_method"][value="PUT"]')) { // Only for new users
        try {
            const draftData = JSON.parse(draft);
            
            if (confirm('A draft was found. Would you like to restore it?')) {
                Object.keys(draftData).forEach(key => {
                    const field = document.querySelector(`[name="${key}"]`);
                    if (field && field.type !== 'password') {
                        if (field.type === 'checkbox') {
                            field.checked = draftData[key] === 'on';
                        } else {
                            field.value = draftData[key];
                        }
                    }
                });
            }
        } catch (e) {
            localStorage.removeItem('userFormDraft');
        }
    }
    
    // Start auto-save for new users
    if (!document.querySelector('input[name="_method"][value="PUT"]')) {
        startAutoSave();
    }
});

// Clear draft when form is successfully submitted
document.getElementById('userForm').addEventListener('submit', function() {
    localStorage.removeItem('userFormDraft');
    if (autoSaveTimer) clearInterval(autoSaveTimer);
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to save
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('userForm').dispatchEvent(new Event('submit'));
    }
    
    // Ctrl/Cmd + Z to go back
    if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
        if (confirm('Are you sure you want to go back? Any unsaved changes will be lost.')) {
            window.location.href = '{{ route("admin.users.index") }}';
        }
    }
});

// Warn about unsaved changes
let formChanged = false;
const formInputs = document.querySelectorAll('#userForm input, #userForm select, #userForm textarea');

formInputs.forEach(input => {
    input.addEventListener('change', () => {
        formChanged = true;
    });
});

window.addEventListener('beforeunload', function(e) {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
    }
});

// Form submitted, don't warn about changes
document.getElementById('userForm').addEventListener('submit', function() {
    formChanged = false;
});

// Enhanced form validation
function validateForm() {
    let isValid = true;
    const requiredFields = document.querySelectorAll('#userForm [required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'This field is required');
            isValid = false;
        }
    });
    
    // Email format validation
    const emailField = document.getElementById('email');
    if (emailField.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value)) {
            showFieldError(emailField, 'Please enter a valid email address');
            isValid = false;
        }
    }
    
    // Password confirmation validation
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');
    
    if (passwordField.value || confirmField.value) {
        if (passwordField.value !== confirmField.value) {
            showFieldError(confirmField, 'Passwords do not match');
            isValid = false;
        }
        
        if (passwordField.value.length < 8) {
            showFieldError(passwordField, 'Password must be at least 8 characters long');
            isValid = false;
        }
    }
    
    return isValid;
}

// Override form submission to include validation
document.getElementById('userForm').addEventListener('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
        
        // Focus on first error field
        const firstError = document.querySelector('.border-red-500');
        if (firstError) {
            firstError.focus();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        // Reset submit button
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i><span>{{ isset($user) ? "Update User" : "Create User" }}</span>';
    }
});

// Notification function for quick actions
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white max-w-sm`;
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
    }, 4000);
}

console.log('User form enhanced with validation, auto-save, and keyboard shortcuts');
</script>
@endpush