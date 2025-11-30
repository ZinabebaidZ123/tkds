{{-- File: resources/views/components/navigation.blade.php --}}

<!-- Desktop Navbar -->
<nav id="desktopNavbar" class="hidden lg:block fixed top-0 left-0 right-0 z-50 bg-transparent transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="TKDS Media" 
                         class="w-40 h-10 object-contain">
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Home
                </a>
                <a href="{{ route('services') }}" class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Services
                </a>
                
                <!-- Products Dropdown -->
                <div class="relative group">
                    <button class="flex items-center space-x-1 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                        <span>Products</span>
                        <i class="fas fa-chevron-down text-xs transform group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-0 mt-2 w-80 opacity-0 invisible group-hover:opacity-100 group-hover:visible transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <div class="glass-effect rounded-2xl p-6 border border-white/20 backdrop-blur-xl bg-dark/90 shadow-2xl">
                            <!-- Dropdown Header -->
                            <div class="mb-4 pb-4 border-b border-white/10">
                                <h3 class="text-white font-bold text-lg mb-1">Our Products</h3>
                                <p class="text-gray-400 text-sm">Professional SaaS solutions</p>
                            </div>
                            
                            <!-- Products Grid -->
                            <div class="grid grid-cols-1 gap-3">
                                @php
                                    $navbarProducts = \App\Models\Product::active()
                                        ->showInNavbar()
                                        ->ordered()
                                        ->get();
                                @endphp
                                
                                @forelse($navbarProducts as $product)
                                    <a href="{{ $product->getUrl() }}" class="group/item flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 transition-all duration-300 border border-transparent hover:border-white/10">
                                        <div class="w-10 h-10 bg-gradient-to-r {{ $product->getGradientClass() }} rounded-lg flex items-center justify-center group-hover/item:scale-110 transition-transform duration-300">
                                            <i class="{{ $product->icon }} text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-white font-semibold text-sm group-hover/item:text-{{ $product->color_from }} transition-colors duration-300">
                                                {{ $product->title }}
                                            </h4>
                                            <p class="text-gray-400 text-xs truncate">{{ $product->subtitle ?: substr($product->short_description, 0, 50) }}</p>
                                        </div>
                                        <i class="fas fa-arrow-right text-gray-400 group-hover/item:text-{{ $product->color_from }} group-hover/item:translate-x-1 transition-all duration-300 text-xs"></i>
                                    </a>
                                @empty
                                    <div class="text-center py-4">
                                        <div class="text-gray-400 text-sm mb-2">
                                            <i class="fas fa-cube text-lg"></i>
                                        </div>
                                        <p class="text-gray-400 text-xs">Products coming soon</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            <!-- Dropdown Footer -->
                            <div class="mt-4 pt-4 border-t border-white/10">
                                <a href="{{ route('products') }}" class="flex items-center justify-center space-x-2 bg-gradient-to-r from-primary to-secondary text-white px-4 py-2.5 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-grid text-sm"></i>
                                    <span>View All Products</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Shop Link -->
                <a href="{{ route('shop.index') }}" class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium flex items-center space-x-1">
                    <i class="fas fa-shopping-bag text-sm"></i>
                    <span>Shop</span>
                </a>

                <a href="{{ route('occasions') }}" class="relative group text-transparent bg-gradient-to-r from-red-400 via-pink-500 to-red-600 bg-clip-text hover:from-pink-400 hover:via-red-500 hover:to-pink-600 transition-all duration-300 font-bold animate-pulse">
    <span class="flex items-center space-x-1">
        <i class="fas fa-fire text-sm text-red-500 group-hover:text-pink-500"></i>
        <span>Special Sale</span>
    </span>
    <!-- Glow effect -->
    <div class="absolute -inset-1 bg-gradient-to-r from-red-400 via-pink-500 to-red-600 rounded-lg blur opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
</a>
                
                <a href="{{ route('pricing') }}" class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Pricing
                </a>
                <a href="{{ route('about') }}" class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    About
                </a>
                <a href="{{ route('blog.index') }}" class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Blog
                </a>
                <a href="{{ route('contact') }}" class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Contact
                </a>
            </div>

            <!-- Auth Section -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- User Menu Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" 
                                class="flex items-center space-x-3 glass-effect rounded-full pl-1 pr-3 py-1 border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <img src="{{ auth()->user()->getAvatarUrl() }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-8 h-8 rounded-full object-cover">
                            <div class="hidden sm:block text-left">
                                <p class="text-white text-sm font-medium">{{ auth()->user()->name }}</p>
                                @if(auth()->user()->hasActiveSubscription())
                                    <p class="text-gray-400 text-xs">{{ auth()->user()->getSubscriptionDisplayName() }}</p>
                                @else
                                    <p class="text-gray-400 text-xs">Free Account</p>
                                @endif
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs transform transition-transform duration-200" 
                               :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-1 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-1 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-72 glass-effect rounded-2xl shadow-2xl border border-white/10 overflow-hidden backdrop-blur-xl bg-dark/95"
                             style="display: none;">
                            
                            <!-- User Info Header -->
                            <div class="p-4 border-b border-white/10">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ auth()->user()->getAvatarUrl() }}" 
                                         alt="{{ auth()->user()->name }}" 
                                         class="w-12 h-12 rounded-xl object-cover">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-white font-semibold truncate">{{ auth()->user()->name }}</h4>
                                        <p class="text-gray-400 text-sm truncate">{{ auth()->user()->email }}</p>
                                        @if(auth()->user()->hasActiveSubscription())
                                            @php 
                                                $statusBadge = auth()->user()->getSubscriptionStatusBadge();
                                            @endphp
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                                    <i class="{{ $statusBadge['icon'] }} mr-1"></i>
                                                    {{ $statusBadge['text'] }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Subscription Section -->
                            @if(auth()->user()->hasActiveSubscription())
                                <div class="p-4 border-b border-white/10 bg-primary/5">
                                    @php $subscription = auth()->user()->getCurrentSubscription(); @endphp
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-white font-semibold text-sm">{{ $subscription->pricingPlan->name }}</span>
                                        <span class="text-primary text-sm font-bold">{{ $subscription->getFormattedAmount() }}/{{ $subscription->billing_cycle }}</span>
                                    </div>
                                    
                                    @if($subscription->isTrialing())
                                        <p class="text-blue-300 text-xs mb-2">
                                            <i class="fas fa-gift mr-1"></i>
                                            {{ auth()->user()->getTrialDaysRemaining() }} days of trial left
                                        </p>
                                    @elseif($subscription->next_payment_date)
                                        <p class="text-gray-400 text-xs mb-2">
                                            Next payment: {{ $subscription->next_payment_date->format('M j, Y') }}
                                        </p>
                                    @endif
                                    
                                    <a href="{{ route('user.subscription.show') }}" 
                                       class="inline-flex items-center text-primary hover:text-secondary text-xs font-medium">
                                        <i class="fas fa-cog mr-1"></i>
                                        Manage Subscription
                                    </a>
                                </div>
                            @else
                                <div class="p-4 border-b border-white/10 bg-gradient-to-r from-primary/10 to-secondary/10">
                                    <p class="text-white font-semibold text-sm mb-1">No Active Plan</p>
                                    <p class="text-gray-400 text-xs mb-3">Upgrade to unlock premium features</p>
                                    <a href="{{ route('pricing') }}" 
                                       class="inline-flex items-center bg-gradient-to-r from-primary to-secondary text-white px-3 py-1.5 rounded-lg font-semibold hover:from-secondary hover:to-accent transition-all duration-300 text-xs">
                                        <i class="fas fa-star mr-1"></i>
                                        Choose Plan
                                    </a>
                                </div>
                            @endif

                            <!-- Menu Links -->
                            <div class="py-2">
                                <a href="{{ route('user.dashboard') }}" 
                                   class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-200">
                                    <i class="fas fa-tachometer-alt w-5"></i>
                                    <span class="text-sm">Dashboard</span>
                                </a>
                                
                                <a href="{{ route('user.profile') }}" 
                                   class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-200">
                                    <i class="fas fa-user-edit w-5"></i>
                                    <span class="text-sm">Profile Settings</span>
                                </a>

                                @php
                                // Cart and user data for authenticated users
                                $cartCount = 0;
                                $ordersCount = 0;
                                $downloadsCount = 0;

                                if (auth()->check()) {
                                    $user = auth()->user();
                                    
                                    // Cart count
                                    $cartCount = \App\Models\ShopCart::forUser($user->id)->sum('quantity');
                                    
                                    // Orders count (only pending/processing orders)
                                    $ordersCount = $user->orders()
                                        ->whereIn('status', ['pending', 'processing', 'shipped'])
                                        ->count();
                                    
                                    // Downloads count (available downloads)
                                    $downloadsCount = $user->downloads()
                                        ->where(function($q) {
                                            $q->whereNull('expires_at')
                                              ->orWhere('expires_at', '>', now());
                                        })
                                        ->where(function($q) {
                                            $q->where('downloads_remaining', '>', 0)
                                              ->orWhere('downloads_remaining', -1);
                                        })
                                        ->count();
                                }
                                @endphp

                                <!-- Shop Related Links -->
                                <div class="border-t border-white/10 mt-2 pt-2">
                                    <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Shopping</p>
                                    
                                    <a href="{{ route('user.orders') }}" 
                                       class="flex items-center justify-between px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-200">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-shopping-bag w-5"></i>
                                            <span class="text-sm">My Orders</span>
                                        </div>
                                        @if($ordersCount > 0)
                                            <span class="bg-primary text-white text-xs font-bold rounded-full px-2 py-1 min-w-[20px] text-center">
                                                {{ $ordersCount }}
                                            </span>
                                        @endif
                                    </a>
                                    
                                    <a href="{{ route('user.downloads') }}" 
                                       class="flex items-center justify-between px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-200">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-download w-5"></i>
                                            <span class="text-sm">Downloads</span>
                                        </div>
                                        @if($downloadsCount > 0)
                                            <span class="bg-green-500 text-white text-xs font-bold rounded-full px-2 py-1 min-w-[20px] text-center">
                                                {{ $downloadsCount }}
                                            </span>
                                        @endif
                                    </a>

                                    <a href="{{ route('shop.cart') }}" 
                                       class="flex items-center justify-between px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-200">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-shopping-cart w-5"></i>
                                            <span class="text-sm">Shopping Cart</span>
                                        </div>
                                        @if($cartCount > 0)
                                            <span class="bg-blue-500 text-white text-xs font-bold rounded-full px-2 py-1 min-w-[20px] text-center cart-count">
                                                {{ $cartCount }}
                                            </span>
                                        @endif
                                    </a>
                                </div>

                                <!-- Subscription Links -->
                                <div class="border-t border-white/10 mt-2 pt-2">
                                    @if(auth()->user()->hasActiveSubscription())
                                        <a href="{{ route('user.subscription.show') }}" 
                                           class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-200">
                                            <i class="fas fa-credit-card w-5"></i>
                                            <span class="text-sm">My Subscription</span>
                                        </a>
                                    @else
                                        <a href="{{ route('pricing') }}" 
                                           class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 transition-colors duration-200">
                                            <i class="fas fa-star w-5"></i>
                                            <span class="text-sm">Upgrade Account</span>
                                        </a>
                                    @endif
                                </div>

                                <div class="border-t border-white/10 mt-2 pt-2">
                                    <form method="POST" action="{{ route('auth.logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center space-x-3 px-4 py-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors duration-200 w-full text-left">
                                            <i class="fas fa-sign-out-alt w-5"></i>
                                            <span class="text-sm">Sign Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Guest Menu -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('auth.login') }}" 
                           class="text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                            Sign In
                        </a>
                        <a href="{{ route('auth.register') }}" 
                           class="inline-flex items-center bg-gradient-to-r from-primary to-secondary text-white px-6 py-2 rounded-full font-semibold hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 btn-hover-effect">
                            Get Started
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Navbar -->
<nav id="mobileNavbar" class="lg:hidden fixed top-0 left-0 right-0 z-[9999] glass-effect">
    
    <div class="flex items-center justify-between h-16 px-4">
        <!-- Mobile Logo -->
        <div class="flex-shrink-0">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="TKDS Media" 
                     class="w-32 h-8 object-contain">
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuBtn" class="flex items-center p-2 text-gray-400 hover:text-white transition-colors duration-200">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="lg:hidden fixed inset-0 z-[99999] glass-effect transform translate-x-full transition-transform duration-300 overflow-y-auto">
        <div class="flex flex-col h-full">
        <!-- Mobile Header -->
        <div class="flex items-center justify-between p-6 border-b border-white/10">
            <div class="flex items-center space-x-3">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}" 
                             alt="TKDS Media" 
                             class="w-40 h-10 object-contain">
                    </a>
                </div>                   
            </div>
            <button id="closeMobileMenu" class="p-2 text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Mobile User Info -->
        @auth
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center space-x-4 mb-4">
                    <img src="{{ auth()->user()->getAvatarUrl() }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="w-12 h-12 rounded-xl object-cover">
                    <div class="flex-1">
                        <h3 class="text-white font-semibold">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-400 text-sm">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                @if(auth()->user()->hasActiveSubscription())
                    @php 
                        $subscription = auth()->user()->getCurrentSubscription();
                        $statusBadge = $subscription->getStatusBadge();
                    @endphp
                    <div class="glass-effect rounded-xl p-3 border border-white/10">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-white font-semibold text-sm">{{ $subscription->pricingPlan->name }}</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                {{ $statusBadge['text'] }}
                            </span>
                        </div>
                        <p class="text-gray-400 text-xs">{{ $subscription->getFormattedAmount() }}/{{ $subscription->billing_cycle }}</p>
                    </div>
                @else
                    <div class="glass-effect rounded-xl p-3 border border-white/10 bg-gradient-to-r from-primary/20 to-secondary/20">
                        <p class="text-white font-semibold text-sm mb-1">No Active Plan</p>
                        <p class="text-gray-400 text-xs">Upgrade for premium features</p>
                    </div>
                @endif
            </div>
        @endauth

        <!-- Mobile Navigation -->
        <div class="flex-1 py-6">
            <div class="space-y-2 px-6">
                <a href="{{ route('home') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Home
                </a>
                <a href="{{ route('services') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Services
                </a>
                <a href="{{ route('products') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Products
                </a>
                <a href="{{ route('shop.index') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    <i class="fas fa-shopping-bag mr-2"></i>Shop
                </a>
                <a href="{{ route('pricing') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Pricing
                </a>
                <a href="{{ route('about') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    About
                </a>
                <a href="{{ route('blog.index') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Blog
                </a>
                <a href="{{ route('contact') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                    Contact
                </a>
                <a href="{{ route('occasions') }}" class="block py-3 text-transparent bg-gradient-to-r from-red-400 via-pink-500 to-red-600 bg-clip-text font-bold animate-pulse">
    <i class="fas fa-fire mr-2 text-red-500"></i>Special Sale
</a>
            </div>

            @auth
                <div class="border-t border-white/10 mt-6 pt-6 px-6">
                    <div class="space-y-2">
                        <a href="{{ route('user.dashboard') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('user.profile') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                            <i class="fas fa-user-edit mr-3"></i>
                            Profile Settings
                        </a>
                        <a href="{{ route('user.orders') }}" class="flex items-center justify-between py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                            <div class="flex items-center">
                                <i class="fas fa-shopping-bag mr-3"></i>
                                My Orders
                            </div>
                            @if($ordersCount > 0)
                                <span class="bg-primary text-white text-xs font-bold rounded-full px-2 py-1">{{ $ordersCount }}</span>
                            @endif
                        </a>

                        <a href="{{ route('user.downloads') }}" class="flex items-center justify-between py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                            <div class="flex items-center">
                                <i class="fas fa-download mr-3"></i>
                                Downloads
                            </div>
                            @if($downloadsCount > 0)
                                <span class="bg-green-500 text-white text-xs font-bold rounded-full px-2 py-1">{{ $downloadsCount }}</span>
                            @endif
                        </a>

                        <a href="{{ route('shop.cart') }}" class="flex items-center justify-between py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                            <div class="flex items-center">
                                <i class="fas fa-shopping-cart mr-3"></i>
                                Shopping Cart
                            </div>
                            @if($cartCount > 0)
                                <span class="bg-blue-500 text-white text-xs font-bold rounded-full px-2 py-1 cart-count">{{ $cartCount }}</span>
                            @endif
                        </a>
                        @if(auth()->user()->hasActiveSubscription())
                            <a href="{{ route('user.subscription.show') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                                <i class="fas fa-credit-card mr-3"></i>
                                My Subscription
                            </a>
                        @else
                            <a href="{{ route('pricing') }}" class="block py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                                <i class="fas fa-star mr-3"></i>
                                Upgrade Account
                            </a>
                        @endif
                    </div>
                </div>
            @endauth
        </div>

        <!-- Mobile Footer -->
        <div class="p-6 border-t border-white/10">
            @auth
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center bg-red-500/20 text-red-400 py-3 rounded-xl font-semibold hover:bg-red-500/30 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Sign Out
                    </button>
                </form>
            @else
                <div class="space-y-3">
                    <a href="{{ route('auth.login') }}" class="block text-center py-3 text-gray-300 hover:text-primary transition-colors duration-200 font-medium">
                        Sign In
                    </a>
                    <a href="{{ route('auth.register') }}" class="block text-center bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-xl font-semibold hover:from-secondary hover:to-accent transition-all duration-300">
                        Get Started
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- Alpine.js for dropdown functionality -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
/* Enhanced Glass Effect */
.glass-effect {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.glass-effect:hover {
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(255, 255, 255, 0.25);
}

/* Button hover effect */
.btn-hover-effect {
    position: relative;
    overflow: hidden;
}

.btn-hover-effect::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-hover-effect:hover::before {
    left: 100%;
}

/* Dropdown animation improvements */
.group:hover .group-hover\:opacity-100 {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Mobile menu specific styles */
.mobile-menu-overlay {
    backdrop-filter: blur(20px);
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Mobile navbar always visible and stable */
#mobileNavbar {
    transform: translateY(0) !important;
    position: fixed !important;
    top: 0 !important;
}

/* Desktop navbar with scroll effects */
#desktopNavbar {
    transition: all 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const closeMobileMenu = document.getElementById('closeMobileMenu');

    function openMobileMenu() {
        mobileMenuOverlay.classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenuFunc() {
        mobileMenuOverlay.classList.add('translate-x-full');
        document.body.style.overflow = '';
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', openMobileMenu);
    }

    if (closeMobileMenu) {
        closeMobileMenu.addEventListener('click', closeMobileMenuFunc);
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMobileMenuFunc();
        }
    });

    // Close when clicking on menu links
    mobileMenuOverlay?.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            closeMobileMenuFunc();
        }
    });

    // Desktop navbar scroll effect only
    let lastScrollY = window.scrollY;
    
    window.addEventListener('scroll', function() {
        const desktopNavbar = document.getElementById('desktopNavbar');
        const currentScrollY = window.scrollY;
        
        if (desktopNavbar && window.innerWidth > 1024) {
            // Background effect
            if (currentScrollY > 100) {
                desktopNavbar.classList.add('bg-dark/95', 'backdrop-blur-lg', 'border-b', 'border-white/10', 'shadow-xl');
                desktopNavbar.classList.remove('bg-transparent');
            } else {
                desktopNavbar.classList.remove('bg-dark/95', 'backdrop-blur-lg', 'border-b', 'border-white/10', 'shadow-xl');
                desktopNavbar.classList.add('bg-transparent');
            }
            
            // Hide/show navbar on scroll
            if (currentScrollY > lastScrollY && currentScrollY > 100) {
                desktopNavbar.style.transform = 'translateY(-100%)';
            } else {
                desktopNavbar.style.transform = 'translateY(0)';
            }
        }
        
        lastScrollY = currentScrollY;
    });
});
</script>