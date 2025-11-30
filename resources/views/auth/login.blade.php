@extends('layouts.auth')

@section('title', 'Sign In - TKDS Media')
@section('meta_description', 'Sign in to your TKDS Media account and access your broadcasting dashboard.')

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
            
            <h2 class="text-3xl font-black text-white mb-2">Welcome Back</h2>
            <p class="text-gray-400">Sign in to your broadcasting dashboard</p>
        </div>

        <!-- Success Messages -->
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 animate-fade-in">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                    <p class="text-green-400 text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Login Form -->
        <div class="bg-white/5 backdrop-blur-xl rounded-3xl p-8 border border-white/10 shadow-2xl">
            <form method="POST" action="{{ route('auth.login') }}" class="space-y-6" id="loginForm">
                @csrf
                
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
                               autocomplete="current-password" 
                               required
                               class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent backdrop-blur-sm transition-all duration-300 @error('password') border-red-500 @enderror"
                               placeholder="Enter your password">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('password')" class="text-gray-400 hover:text-white transition-colors duration-200">
                                <i class="fas fa-eye" id="password-toggle"></i>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" 
                               name="remember" 
                               type="checkbox" 
                               class="w-4 h-4 text-primary bg-white/10 border-white/20 rounded focus:ring-primary focus:ring-2">
                        <label for="remember" class="ml-2 text-sm text-gray-400">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="text-primary hover:text-secondary transition-colors duration-200">
                            Forgot password?
                        </a>
                    </div>
                </div>
{{-- Captcha Wall --}}
<x-recaptcha form="login" />
                <!-- Submit Button -->
                <button type="submit" 
                        id="submitButton"
                        class="w-full flex justify-center items-center space-x-3 py-4 px-6 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-sign-in-alt" id="submitIcon"></i>
                    <span id="submitText">Sign In</span>
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/20"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white/5 text-gray-400">Or continue with</span>
                    </div>
                </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="mt-6 grid grid-cols-2 gap-3">
                <button class="w-full inline-flex justify-center items-center px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white hover:bg-white/20 transition-all duration-300 backdrop-blur-sm">
                    <i class="fab fa-google mr-2"></i>
                    Google
                </button>
                <button class="w-full inline-flex justify-center items-center px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white hover:bg-white/20 transition-all duration-300 backdrop-blur-sm">
                    <i class="fab fa-facebook mr-2"></i>
                    Facebook
                </button>
            </div>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    Don't have an account? 
                    <a href="{{ route('auth.register') }}" class="text-primary hover:text-secondary transition-colors duration-200 font-semibold">
                        Create account
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 text-gray-400 hover:text-primary transition-colors duration-200">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Home</span>
            </a>
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

// Form submission
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const submitButton = document.getElementById('submitButton');
    const submitIcon = document.getElementById('submitIcon');
    const submitText = document.getElementById('submitText');
    
    // Disable button and show loading
    submitButton.disabled = true;
    submitIcon.className = 'fas fa-spinner fa-spin';
    submitText.textContent = 'Signing In...';
});

// Real-time validation
document.addEventListener('DOMContentLoaded', function() {
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    
    emailField.addEventListener('blur', function() {
        validateEmail(this);
    });
    
    passwordField.addEventListener('blur', function() {
        validatePassword(this);
    });
});

function validateEmail(field) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = emailRegex.test(field.value);
    
    if (isValid) {
        field.classList.remove('border-red-500');
        field.classList.add('border-green-500');
    } else if (field.value.length > 0) {
        field.classList.remove('border-green-500');
        field.classList.add('border-red-500');
    }
}

function validatePassword(field) {
    const isValid = field.value.length >= 8;
    
    if (isValid) {
        field.classList.remove('border-red-500');
        field.classList.add('border-green-500');
    } else if (field.value.length > 0) {
        field.classList.remove('border-green-500');
        field.classList.add('border-red-500');
    }
}

// Auto-focus on first field
document.addEventListener('DOMContentLoaded', function() {
    const emailField = document.getElementById('email');
    if (emailField && !emailField.value) {
        emailField.focus();
    }
});
</script>
@endsection