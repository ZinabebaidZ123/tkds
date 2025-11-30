@extends('layouts.user')

@section('title', 'Dashboard - TKDS Media')
@section('meta_description', 'Manage your TKDS Media account, view statistics, and access your broadcasting tools.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark">
    
    <!-- Dashboard Header -->
    <div class="bg-white/5 backdrop-blur-xl border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
            <div class="flex flex-col space-y-4 lg:flex-row lg:items-center lg:justify-between lg:space-y-0">
                
                <!-- User Info Section -->
                <div class="flex items-center space-x-4">
                    <div class="relative flex-shrink-0">
                        <img src="{{ $user->getAvatarUrl() }}" 
                             alt="{{ $user->name }}" 
                             class="w-16 h-16 lg:w-20 lg:h-20 rounded-2xl object-cover border-4 border-primary/20 shadow-2xl">
                        <div class="absolute -bottom-1 -right-1 lg:-bottom-2 lg:-right-2 w-6 h-6 lg:w-8 lg:h-8 bg-green-500 rounded-full border-2 lg:border-4 border-dark flex items-center justify-center">
                            <i class="fas fa-check text-white text-xs"></i>
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-xl lg:text-3xl font-black text-white mb-1 truncate">
                            Welcome back, <span class="text-gradient bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">{{ $user->name }}</span>
                        </h1>
                        <p class="text-gray-400 flex items-center space-x-2 text-sm lg:text-base">
                            <i class="fas fa-calendar-alt flex-shrink-0"></i>
                            <span class="truncate">Member since {{ $user->created_at->format('M Y') }}</span>
                        </p>
                        @if($user->last_login_at)
                            <p class="text-gray-500 text-xs lg:text-sm mt-1 truncate">
                                Last login: {{ $user->last_login_at->diffForHumans() }}
                            </p>
                        @endif
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full lg:w-auto">
                    <a href="{{ route('user.profile') }}" 
                       class="inline-flex items-center justify-center space-x-2 px-4 lg:px-6 py-2 lg:py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300 text-sm lg:text-base">
                        <i class="fas fa-user-edit"></i>
                        <span>Edit Profile</span>
                    </a>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center justify-center space-x-2 px-4 lg:px-6 py-2 lg:py-3 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl text-sm lg:text-base">
                        <i class="fas fa-home"></i>
                        <span>Visit Site</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
        
        <!-- Quick Stats - Responsive Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
            
            <!-- Profile Completion -->
            <div class="bg-white/5 backdrop-blur-xl rounded-xl lg:rounded-2xl p-4 lg:p-6 border border-white/10 hover:border-primary/30 transition-all duration-500">
                <div class="flex flex-col space-y-3 lg:space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 lg:w-12 lg:h-12 bg-gradient-to-r from-primary to-secondary rounded-lg lg:rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-check text-white text-sm lg:text-xl"></i>
                        </div>
                        <span class="text-lg lg:text-2xl font-black text-primary">{{ $stats['profile_completion'] }}%</span>
                    </div>
                    <div>
                        <h3 class="text-sm lg:text-lg font-bold text-white mb-1 lg:mb-2">Profile Completion</h3>
                        <div class="w-full bg-gray-700 rounded-full h-1.5 lg:h-2 mb-2">
                            <div class="bg-gradient-to-r from-primary to-secondary h-1.5 lg:h-2 rounded-full transition-all duration-1000" 
                                 style="width: {{ $stats['profile_completion'] }}%"></div>
                        </div>
                        <p class="text-gray-400 text-xs lg:text-sm">
                            @if($stats['profile_completion'] < 100)
                                Complete your profile
                            @else
                                Profile complete!
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Sessions -->
            <div class="bg-white/5 backdrop-blur-xl rounded-xl lg:rounded-2xl p-4 lg:p-6 border border-white/10 hover:border-secondary/30 transition-all duration-500">
                <div class="flex flex-col space-y-3 lg:space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 lg:w-12 lg:h-12 bg-gradient-to-r from-secondary to-accent rounded-lg lg:rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-sign-in-alt text-white text-sm lg:text-xl"></i>
                        </div>
                        <span class="text-lg lg:text-2xl font-black text-secondary">{{ number_format($stats['total_logins']) }}</span>
                    </div>
                    <div>
                        <h3 class="text-sm lg:text-lg font-bold text-white mb-1 lg:mb-2">Total Sessions</h3>
                        <p class="text-gray-400 text-xs lg:text-sm">
                            Active user
                        </p>
                    </div>
                </div>
            </div>

            <!-- Billing Info -->
            <div class="bg-white/5 backdrop-blur-xl rounded-xl lg:rounded-2xl p-4 lg:p-6 border border-white/10 hover:border-accent/30 transition-all duration-500">
                <div class="flex flex-col space-y-3 lg:space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 lg:w-12 lg:h-12 bg-gradient-to-r from-accent to-primary rounded-lg lg:rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-credit-card text-white text-sm lg:text-xl"></i>
                        </div>
                        <span class="text-lg lg:text-2xl font-black text-accent">{{ $stats['billing_addresses'] }}</span>
                    </div>
                    <div>
                        <h3 class="text-sm lg:text-lg font-bold text-white mb-1 lg:mb-2">Billing Info</h3>
                        <p class="text-gray-400 text-xs lg:text-sm">
                            @if($stats['billing_addresses'] > 0)
                                Payment configured
                            @else
                                No billing info
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-white/5 backdrop-blur-xl rounded-xl lg:rounded-2xl p-4 lg:p-6 border border-white/10 hover:border-green-500/30 transition-all duration-500">
                <div class="flex flex-col space-y-3 lg:space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 lg:w-12 lg:h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg lg:rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shipping-fast text-white text-sm lg:text-xl"></i>
                        </div>
                        <span class="text-lg lg:text-2xl font-black text-green-400">{{ $stats['shipping_addresses'] }}</span>
                    </div>
                    <div>
                        <h3 class="text-sm lg:text-lg font-bold text-white mb-1 lg:mb-2">Shipping Info</h3>
                        <p class="text-gray-400 text-xs lg:text-sm">
                            @if($stats['shipping_addresses'] > 0)
                                Addresses saved
                            @else
                                No shipping info
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

<!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            
            <!-- Quick Actions & Recent Activity -->
            <div class="xl:col-span-2 space-y-4 sm:space-y-6">
                
                <!-- Quick Actions Grid -->
                <div class="bg-white/5 backdrop-blur-xl rounded-xl lg:rounded-2xl p-4 sm:p-6 lg:p-8 border border-white/10">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center">
                        <i class="fas fa-bolt text-primary mr-2 sm:mr-3"></i>
                        Quick Actions
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4">
                        
                        <!-- Edit Profile -->
                        <a href="{{ route('user.profile') }}" 
                           class="group p-3 sm:p-4 bg-white/5 rounded-lg xl:rounded-xl border border-white/10 hover:border-primary/30 hover:bg-white/10 transition-all duration-300 min-h-[100px] sm:min-h-[120px] flex flex-col justify-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300 mx-auto sm:mx-0">
                                <i class="fas fa-user-edit text-white text-base sm:text-lg"></i>
                            </div>
                            <h3 class="font-semibold text-white mb-1 text-sm sm:text-base text-center sm:text-left">Edit Profile</h3>
                            <p class="text-gray-400 text-xs sm:text-sm text-center sm:text-left">Update personal info</p>
                        </a>

                        <!-- Payment Info -->
                        <a href="{{ route('user.profile') }}#billing" 
                           class="group p-3 sm:p-4 bg-white/5 rounded-lg xl:rounded-xl border border-white/10 hover:border-secondary/30 hover:bg-white/10 transition-all duration-300 min-h-[100px] sm:min-h-[120px] flex flex-col justify-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-secondary to-accent rounded-lg flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300 mx-auto sm:mx-0">
                                <i class="fas fa-credit-card text-white text-base sm:text-lg"></i>
                            </div>
                            <h3 class="font-semibold text-white mb-1 text-sm sm:text-base text-center sm:text-left">Payment Info</h3>
                            <p class="text-gray-400 text-xs sm:text-sm text-center sm:text-left">Billing & shipping</p>
                        </a>

                        <!-- Security -->
                        <a href="{{ route('user.profile') }}#security" 
                           class="group p-3 sm:p-4 bg-white/5 rounded-lg xl:rounded-xl border border-white/10 hover:border-accent/30 hover:bg-white/10 transition-all duration-300 min-h-[100px] sm:min-h-[120px] flex flex-col justify-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-accent to-primary rounded-lg flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300 mx-auto sm:mx-0">
                                <i class="fas fa-shield-alt text-white text-base sm:text-lg"></i>
                            </div>
                            <h3 class="font-semibold text-white mb-1 text-sm sm:text-base text-center sm:text-left">Security</h3>
                            <p class="text-gray-400 text-xs sm:text-sm text-center sm:text-left">Password settings</p>
                        </a>

                        <!-- Products -->
                        <a href="{{ route('products') }}" 
                           class="group p-3 sm:p-4 bg-white/5 rounded-lg xl:rounded-xl border border-white/10 hover:border-blue-500/30 hover:bg-white/10 transition-all duration-300 min-h-[100px] sm:min-h-[120px] flex flex-col justify-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300 mx-auto sm:mx-0">
                                <i class="fas fa-cube text-white text-base sm:text-lg"></i>
                            </div>
                            <h3 class="font-semibold text-white mb-1 text-sm sm:text-base text-center sm:text-left">Our Products</h3>
                            <p class="text-gray-400 text-xs sm:text-sm text-center sm:text-left">SaaS solutions</p>
                        </a>

                        <!-- Services -->
                        <a href="{{ route('services') }}" 
                           class="group p-3 sm:p-4 bg-white/5 rounded-lg xl:rounded-xl border border-white/10 hover:border-purple-500/30 hover:bg-white/10 transition-all duration-300 min-h-[100px] sm:min-h-[120px] flex flex-col justify-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300 mx-auto sm:mx-0">
                                <i class="fas fa-cogs text-white text-base sm:text-lg"></i>
                            </div>
                            <h3 class="font-semibold text-white mb-1 text-sm sm:text-base text-center sm:text-left">Our Services</h3>
                            <p class="text-gray-400 text-xs sm:text-sm text-center sm:text-left">Broadcasting</p>
                        </a>

                        <!-- Support -->
                        <a href="{{ route('contact') }}" 
                           class="group p-3 sm:p-4 bg-white/5 rounded-lg xl:rounded-xl border border-white/10 hover:border-green-500/30 hover:bg-white/10 transition-all duration-300 min-h-[100px] sm:min-h-[120px] flex flex-col justify-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform duration-300 mx-auto sm:mx-0">
                                <i class="fas fa-headset text-white text-base sm:text-lg"></i>
                            </div>
                            <h3 class="font-semibold text-white mb-1 text-sm sm:text-base text-center sm:text-left">Support</h3>
                            <p class="text-gray-400 text-xs sm:text-sm text-center sm:text-left">Get help</p>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                @if($stats['recent_sessions']->count() > 0)
                <div class="bg-white/5 backdrop-blur-xl rounded-xl lg:rounded-2xl p-4 sm:p-6 lg:p-8 border border-white/10">
                    <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center">
                        <i class="fas fa-history text-secondary mr-2 sm:mr-3"></i>
                        Recent Activity
                    </h2>
                    
                    <div class="space-y-3 sm:space-y-4">
                        @foreach($stats['recent_sessions']->take(5) as $session)
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 sm:p-4 bg-white/5 rounded-lg xl:rounded-xl border border-white/10 space-y-2 sm:space-y-0">
                                <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-gray-600 to-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-{{ $session->device_type === 'mobile' ? 'mobile-alt' : ($session->device_type === 'tablet' ? 'tablet-alt' : 'desktop') }} text-white text-sm sm:text-base"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-semibold text-white text-sm sm:text-base truncate">{{ $session->getDeviceInfo() }}</h4>
                                        <p class="text-gray-400 text-xs sm:text-sm truncate">{{ $session->getLocationInfo() }}</p>
                                    </div>
                                </div>
                                <div class="text-left sm:text-right flex-shrink-0 sm:ml-2">
                                    <p class="text-gray-400 text-xs sm:text-sm">{{ $session->login_at->diffForHumans() }}</p>
                                    @if($session->is_active)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 mt-1">
                                            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-400 rounded-full mr-1 animate-pulse"></div>
                                            Active
                                        </span>
                                    @else
                                        <span class="text-gray-500 text-xs block mt-1">{{ $session->getDuration() }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 sm:mt-6 text-center">
                        <a href="{{ route('user.sessions') }}" 
                           class="text-primary hover:text-secondary transition-colors duration-200 text-sm font-medium">
                            View All Sessions <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Account Overview Sidebar -->
            <div class="space-y-4 sm:space-y-6">
                
                <!-- Account Status -->
                <div class="bg-white/5 backdrop-blur-xl rounded-xl lg:rounded-2xl p-4 sm:p-6 border border-white/10">
                    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fas fa-user-circle text-primary mr-2 sm:mr-3"></i>
                        Account Status
                    </h3>
                    
                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 text-sm sm:text-base">Status</span>
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400">
                                <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-400 rounded-full mr-1 sm:mr-2 animate-pulse"></div>
                                Active
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 text-sm sm:text-base">Email</span>
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400">
                                <i class="fas fa-check mr-1"></i>
                                Verified
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 text-sm sm:text-base">Profile</span>
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-bold {{ $stats['profile_completion'] >= 80 ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                {{ $stats['profile_completion'] }}% Complete
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 text-sm sm:text-base">Member Since</span>
                            <span class="text-white text-sm sm:text-base">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Profile -->
                <div class="bg-white/5 backdrop-blur-xl rounded-xl lg:rounded-2xl p-4 sm:p-6 border border-white/10">
                    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fas fa-id-card text-secondary mr-2 sm:mr-3"></i>
                        Profile Summary
                    </h3>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-gray-400 text-xs sm:text-sm block mb-1">Full Name</span>
                            <p class="text-white font-medium text-sm sm:text-base truncate">{{ $user->name }}</p>
                        </div>
                        
                        <div>
                            <span class="text-gray-400 text-xs sm:text-sm block mb-1">Email</span>
                            <p class="text-white font-medium text-sm sm:text-base truncate">{{ $user->email }}</p>
                        </div>
                        
                        @if($user->phone)
                        <div>
                            <span class="text-gray-400 text-xs sm:text-sm block mb-1">Phone</span>
                            <p class="text-white font-medium text-sm sm:text-base">{{ $user->phone }}</p>
                        </div>
                        @endif
                        
                        @if($user->profile?->location)
                        <div>
                            <span class="text-gray-400 text-xs sm:text-sm block mb-1">Location</span>
                            <p class="text-white font-medium text-sm sm:text-base truncate">{{ $user->profile->location }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-white/10">
                        <a href="{{ route('user.profile') }}" 
                           class="w-full inline-flex items-center justify-center space-x-2 px-3 sm:px-4 py-2 sm:py-3 bg-gradient-to-r from-primary/20 to-secondary/20 text-primary font-semibold rounded-lg hover:from-primary/30 hover:to-secondary/30 transition-all duration-300 text-sm sm:text-base">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                    </div>
                </div>

                <!-- Latest Updates -->
                <div class="bg-white/5 backdrop-blur-xl rounded-xl lg:rounded-2xl p-4 sm:p-6 border border-white/10">
                    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-white mb-4 flex items-center">
                        <i class="fas fa-bell text-accent mr-2 sm:mr-3"></i>
                        Latest Updates
                    </h3>
                    
                    <div class="space-y-3 sm:space-y-4">
                        <div class="p-3 sm:p-4 bg-white/5 rounded-lg border border-white/10">
                            <h4 class="font-semibold text-white text-sm sm:text-base mb-1 sm:mb-2">New Features Released!</h4>
                            <p class="text-gray-400 text-xs sm:text-sm mb-2 sm:mb-3">Check out our latest broadcasting tools and enhanced streaming capabilities.</p>
                            <a href="{{ route('blog.index') }}" 
                               class="text-primary text-xs sm:text-sm hover:text-secondary transition-colors duration-200">Read More</a>
                        </div>
                        
                        <div class="p-3 sm:p-4 bg-white/5 rounded-lg border border-white/10">
                            <h4 class="font-semibold text-white text-sm sm:text-base mb-1 sm:mb-2">Security Update</h4>
                            <p class="text-gray-400 text-xs sm:text-sm mb-2 sm:mb-3">We've enhanced our security measures to protect your account better.</p>
                            <a href="{{ route('user.profile') }}#security" 
                               class="text-primary text-xs sm:text-sm hover:text-secondary transition-colors duration-200">Review Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile-Optimized JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh stats every 30 seconds (only on desktop to save mobile data)
    if (window.innerWidth > 768) {
        setInterval(function() {
            // updateDashboardStats(); // Uncomment when implementing AJAX stats
        }, 30000);
    }
    
    // Add smooth animations to stat cards with staggered delay
    const statCards = document.querySelectorAll('[data-stat-card]');
    statCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('animate-fade-in');
    });
    
    // Optimize for touch devices
    if ('ontouchstart' in window) {
        document.body.classList.add('touch-device');
    }
    
    // Handle orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(() => {
            window.scrollTo(0, 0);
        }, 100);
    });
});

// Responsive utility functions
function updateStatCard(statId, newValue) {
    const element = document.getElementById(statId);
    if (element) {
        element.style.transform = 'scale(1.05)';
        setTimeout(() => {
            element.textContent = newValue;
            element.style.transform = 'scale(1)';
        }, 150);
    }
}

// Intersection Observer for animations (performance optimization)
if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.bg-white\\/5').forEach(el => {
        observer.observe(el);
    });
}
</script>

<!-- Mobile-Specific Styles -->
<style>
@media (max-width: 768px) {
    .text-gradient {
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        background-image: linear-gradient(135deg, #C53030, #E53E3E);
    }
    
    /* Improve touch targets */
    .touch-device a, .touch-device button {
        min-height: 44px;
        min-width: 44px;
    }
    
    /* Optimize animations for mobile */
    .group:hover .group-hover\\:scale-110 {
        transform: scale(1.05);
    }
}

@media (max-width: 640px) {
    /* Further mobile optimizations */
    .grid-cols-2 > div {
        min-height: 120px;
    }
    
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
}

/* Loading states */
.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
    opacity: 0;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Focus states for accessibility */
.focus\\:ring-2:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(197, 48, 48, 0.5);
}
</style>
@endsection