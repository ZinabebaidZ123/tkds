@extends('layouts.auth')

@section('title', 'Create Account - TKDS Media')
@section('meta_description', 'Join TKDS Media and access premium broadcasting solutions. Create your account today.')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-dark via-dark-light to-dark">
    
    <!-- Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-72 h-72 bg-primary/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-secondary/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-accent/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10">
        
        <!-- Header -->
        <div class="text-center">
            <!-- Logo -->
            <div class="mx-auto mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary via-secondary to-accent rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                        <span class="text-white font-black text-2xl">T</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-white">
                            <span class="text-primary">TKDS</span> 
                            <span class="text-gray-300">MEDIA</span>
                        </h1>
                        <p class="text-xs text-gray-400 -mt-1">Your World, Live and Direct</p>
                    </div>
                </a>
            </div>
            
            <h2 class="text-3xl font-black text-white mb-2">Create Your Account</h2>
            <p class="text-gray-400">Join thousands of creators transforming their content</p>
        </div>

        <!-- Registration Form -->
        <div class="bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 shadow-2xl">
            <form method="POST" action="{{ route('auth.register') }}" class="space-y-6" id="registerForm">
                @csrf
                
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-white mb-2">
                        Full Name <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input id="name" 
                               name="name" 
                               type="text" 
                               autocomplete="name" 
                               required 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('name') border-red-500 @enderror"
                               placeholder="Enter your full name">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-white mb-2">
                        Email Address <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input id="email" 
                               name="email" 
                               type="email" 
                               autocomplete="email" 
                               required 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('email') border-red-500 @enderror"
                               placeholder="Enter your email address">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-white mb-2">
                        Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input id="password" 
                               name="password" 
                               type="password" 
                               autocomplete="new-password" 
                               required
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('password') border-red-500 @enderror"
                               placeholder="Create a secure password">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('password')" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fas fa-eye" id="password-toggle"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Password Strength Indicator -->
                    <div class="mt-2">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 h-2 bg-gray-700 rounded-full overflow-hidden">
                                <div id="password-strength" class="h-full bg-red-500 transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <span id="password-strength-text" class="text-xs text-gray-400">Weak</span>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-white mb-2">
                        Confirm Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               autocomplete="new-password" 
                               required
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('password_confirmation') border-red-500 @enderror"
                               placeholder="Confirm your password">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fas fa-eye" id="password_confirmation-toggle"></i>
                            </button>
                        </div>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start space-x-3">
                    <div class="flex items-center h-5">
                        <input id="terms" 
                               name="terms" 
                               type="checkbox" 
                               required
                               class="w-4 h-4 text-primary bg-white/10 border-white/20 rounded focus:ring-primary focus:ring-2">
                    </div>
                    <label for="terms" class="text-sm text-gray-400">
                        I agree to the 
                        <a href="{{ route('terms-conditions') }}" target="_blank" class="text-primary hover:text-secondary transition-colors duration-200 underline">Terms & Conditions</a> 
                        and 
                        <a href="{{ route('privacy-policy') }}" target="_blank" class="text-primary hover:text-secondary transition-colors duration-200 underline">Privacy Policy</a>
                    </label>
                </div>

                <!-- General Errors -->
                @if($errors->has('registration'))
                    <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-400 mr-3"></i>
                            <p class="text-red-400 text-sm">{{ $errors->first('registration') }}</p>
                        </div>
                    </div>
                @endif
                
<x-recaptcha form="register" />

                <!-- Submit Button -->
                <button type="submit" 
                        id="submitButton"
                        class="w-full flex justify-center items-center space-x-3 py-4 px-6 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-user-plus" id="submitIcon"></i>
                    <span id="submitText">Create Account</span>
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    Already have an account? 
                    <a href="{{ route('auth.login') }}" class="text-primary hover:text-secondary transition-colors duration-200 font-semibold">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>

        <!-- Social Links -->
        <div class="text-center">
            <p class="text-gray-500 text-sm mb-4">Join our community</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-200">
                    <i class="fab fa-twitter text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-200">
                    <i class="fab fa-facebook text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-200">
                    <i class="fab fa-linkedin text-xl"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-200">
                    <i class="fab fa-youtube text-xl"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Password visibility toggle
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = document.getElementById(fieldId + '-toggle');
    
    if (field.type === 'password') {
        field.type = 'text';
        toggle.classList.remove('fa-eye');
        toggle.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        toggle.classList.remove('fa-eye-slash');
        toggle.classList.add('fa-eye');
    }
}

// Password strength checker
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthBar = document.getElementById('password-strength');
    const strengthText = document.getElementById('password-strength-text');
    
    let strength = 0;
    let strengthLabel = 'Weak';
    let strengthColor = 'bg-red-500';
    
    // Check password criteria
    if (password.length >= 8) strength += 25;
    if (password.match(/[a-z]/)) strength += 25;
    if (password.match(/[A-Z]/)) strength += 25;
    if (password.match(/[0-9]/)) strength += 25;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 10;
    
    // Determine strength level
    if (strength >= 80) {
        strengthLabel = 'Strong';
        strengthColor = 'bg-green-500';
    } else if (strength >= 60) {
        strengthLabel = 'Good';
        strengthColor = 'bg-yellow-500';
    } else if (strength >= 40) {
        strengthLabel = 'Fair';
        strengthColor = 'bg-orange-500';
    }
    
    // Update UI
    strengthBar.style.width = Math.min(strength, 100) + '%';
    strengthBar.className = `h-full transition-all duration-300 ${strengthColor}`;
    strengthText.textContent = strengthLabel;
});

// Form submission
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const submitButton = document.getElementById('submitButton');
    const submitIcon = document.getElementById('submitIcon');
    const submitText = document.getElementById('submitText');
    
    // Disable button and show loading
    submitButton.disabled = true;
    submitIcon.className = 'fas fa-spinner fa-spin';
    submitText.textContent = 'Creating Account...';
});

// Real-time validation
document.addEventListener('DOMContentLoaded', function() {
    const fields = ['name', 'email', 'password', 'password_confirmation'];
    
    fields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            field.addEventListener('blur', function() {
                validateField(this);
            });
        }
    });
});

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    switch (field.name) {
        case 'name':
            if (value.length < 2) {
                isValid = false;
                errorMessage = 'Name must be at least 2 characters long.';
            }
            break;
        case 'email':
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address.';
            }
            break;
        case 'password':
            if (value.length < 8) {
                isValid = false;
                errorMessage = 'Password must be at least 8 characters long.';
            }
            break;
        case 'password_confirmation':
            const password = document.getElementById('password').value;
            if (value !== password) {
                isValid = false;
                errorMessage = 'Password confirmation does not match.';
            }
            break;
    }
    
    // Update field styling
    if (isValid) {
        field.classList.remove('border-red-500');
        field.classList.add('border-green-500');
    } else {
        field.classList.remove('border-green-500');
        field.classList.add('border-red-500');
    }
}
</script>
@endsection