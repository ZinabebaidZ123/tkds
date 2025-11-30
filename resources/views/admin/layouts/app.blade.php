<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - TKDS Media</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#C53030',
                        'secondary': '#E53E3E',
                        'accent': '#FC8181',
                        'dark': '#0a0a0a',
                        'dark-light': '#1a1a1a',
                        'admin-bg': '#f8fafc',
                        'admin-sidebar': '#1e293b',
                        'admin-card': '#ffffff',
                    }
                }
            }
        }
    </script>

    <style>
        /* Toggle Switch Fixes */
        .status-toggle:checked+div {
            background-color: #10b981 !important;
        }

        .status-toggle:checked+div:after {
            transform: translateX(100%) !important;
        }

        .status-toggle+div {
            background-color: #e5e7eb !important;
            transition: all 0.3s ease !important;
        }

        .status-toggle+div:after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 50%;
            transition: all 0.3s ease !important;
            transform: translateX(0) !important;
        }

        .status-toggle+.w-11 {
            width: 2.75rem !important;
            height: 1.5rem !important;
        }

        .status-toggle+.w-11:after {
            width: 1.25rem !important;
            height: 1.25rem !important;
        }

        .status-toggle+.w-9 {
            width: 2.25rem !important;
            height: 1.25rem !important;
        }

        .status-toggle+.w-9:after {
            width: 1rem !important;
            height: 1rem !important;
        }

        .status-toggle+div:hover {
            opacity: 0.9;
        }

        .status-toggle:focus+div {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            outline: none;
        }

        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Firefox scrollbar */
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) rgba(255, 255, 255, 0.1);
        }

        /* Submenu Animation */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .submenu.open {
            max-height: 500px;
        }

        /* Section Header Styling */
        .section-header {
            position: relative;
            margin: 16px 0 8px 0;
            padding: 8px 16px;
            border-left: 3px solid #C53030;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0 8px 8px 0;
        }
    </style>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-admin-bg font-inter">

    <!-- Sidebar -->
    <div id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-admin-sidebar text-white transform -translate-x-full lg:translate-x-0 sidebar-transition flex flex-col">

        <!-- Header - Fixed -->
        <div class="flex items-center justify-center h-16 bg-gradient-to-r from-primary to-secondary flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <span class="text-primary font-black text-xl">T</span>
                </div>
                <div>
                    <h1 class="text-lg font-bold">TKDS Media</h1>
                    <p class="text-xs opacity-80">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation - Scrollable -->
        <div class="flex-1 overflow-y-auto sidebar-scroll">
            <nav class="py-6 px-4">
                
                <!-- DASHBOARD -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-all duration-200 mb-6 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-lg' : 'text-gray-300' }}">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>

                <!-- ================================ -->
                <!-- WEBSITE MANAGEMENT SECTION -->
                <!-- ================================ -->
                <div class="section-header">
                    <div class="flex items-center text-xs font-bold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-globe mr-2"></i>
                        Website Management
                    </div>
                </div>
                <!-- Newsletter Management -->
<div class="space-y-1 mb-4">
    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
        <i class="fas fa-newspaper mr-2"></i>
        Newsletter
    </div>

    <a href="{{ route('admin.newsletter.index') }}"
        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.newsletter.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
        <i class="fas fa-mail-bulk w-5 h-5 mr-3"></i>
        Newsletter Subscribers
        @php
        $activeSubscribers = \App\Models\Newsletter::active()->count();
        $recentSubscribers = \App\Models\Newsletter::recent(7)->count();
        @endphp
        @if ($recentSubscribers > 0)
        <span class="ml-auto text-xs bg-green-500 text-white px-2 py-1 rounded-full">+{{ $recentSubscribers }}</span>
        @elseif ($activeSubscribers > 0)
        <span class="ml-auto text-xs bg-blue-500 text-white px-2 py-1 rounded-full">{{ $activeSubscribers }}</span>
        @endif
    </a>

 
</div>

<!-- Home Page Management -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fas fa-home mr-2"></i>
                        Home Page
                    </div>
<a href="{{ route('admin.dynamic-pages.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white10 transition-all duration-200 {{ request()->routeIs('admin.dynamic-pages.*') ? 'bg-white20 text-white' : 'text-gray-300' }}">
    <i class="fas fa-layer-group w-5 h-5 mr-3"></i>
    Dynamic Pages
</a>


                    <a href="{{ route('admin.hero-sections.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.hero-sections.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-image w-5 h-5 mr-3"></i>
                        Hero Sections
                    </a>
                    <a href="{{ route('admin.video-sections.index') }}"
    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.video-sections.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
    <i class="fas fa-video w-5 h-5 mr-3"></i>
    Video Sections
</a>

                    <a href="{{ route('admin.perfect-for-cards.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.perfect-for-cards.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-id-card w-5 h-5 mr-3"></i>
                        Perfect For Cards
                    </a>

                    <a href="{{ route('admin.broadcasting-solutions.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.broadcasting-solutions.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-broadcast-tower w-5 h-5 mr-3"></i>
                        Broadcasting Solutions
                    </a>

                    <a href="{{ route('admin.clients.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.clients.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-building w-5 h-5 mr-3"></i>
                        Client Logos
                    </a>

                    <a href="{{ route('admin.team-members.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.team-members.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-users w-5 h-5 mr-3"></i>
                        Team Members
                    </a>
                </div>

                <!-- Services & Products -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fas fa-briefcase mr-2"></i>
                        Services & Products
                    </div>

                    <a href="{{ route('admin.services.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.services.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-cogs w-5 h-5 mr-3"></i>
                        Services Management
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-cube w-5 h-5 mr-3"></i>
                        Products Management
                    </a>

                    <a href="{{ route('admin.about.settings') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.about.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-info-circle w-5 h-5 mr-3"></i>
                        About Page
                    </a>
                </div>

                <!-- Blog Management -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fas fa-newspaper mr-2"></i>
                        Blog Management
                    </div>

                    <a href="{{ route('admin.blog-analytics') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.blog-analytics') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                        Blog Analytics
                    </a>

                    <a href="{{ route('admin.blog.posts.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.blog.posts.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                        Blog Posts
                        @php
                        $draftCount = \App\Models\BlogPost::where('status', 'draft')->count();
                        @endphp
                        @if ($draftCount > 0)
                        <span class="ml-auto text-xs bg-yellow-500 text-white px-2 py-1 rounded-full">{{ $draftCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.blog.categories.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.blog.categories.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-folder w-5 h-5 mr-3"></i>
                        Categories
                    </a>

                    <a href="{{ route('admin.blog.tags.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.blog.tags.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-tags w-5 h-5 mr-3"></i>
                        Tags
                    </a>

                    <a href="{{ route('admin.blog.authors.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.blog.authors.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-user-edit w-5 h-5 mr-3"></i>
                        Authors
                    </a>
                </div>

                <!-- ================================ -->
                <!-- CUSTOMER MANAGEMENT SECTION -->
                <!-- ================================ -->
                <div class="section-header">
                    <div class="flex items-center text-xs font-bold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-users mr-2"></i>
                        Customer Management
                    </div>
                </div>

                <!-- User Management -->
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-users-cog w-5 h-5 mr-3"></i>
                    User Management
                    @php
                    $newUsersCount = \App\Models\User::where('created_at', '>=', now()->subDays(7))->count();
                    @endphp
                    @if ($newUsersCount > 0)
                    <span class="ml-auto text-xs bg-blue-500 text-white px-2 py-1 rounded-full">{{ $newUsersCount }}</span>
                    @endif
                </a>

                             <a href="{{ route('admin.service-contact.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.service-contact.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-mail-bulk w-5 h-5 mr-3"></i>
                       Contact Email Setup
                        @php
                        $servicesWithEmail = \App\Models\Service::whereNotNull('contact_email')->count();
                        $productsWithEmail = \App\Models\Product::whereNotNull('contact_email')->count();
                        $totalWithEmail = $servicesWithEmail + $productsWithEmail;
                        @endphp
                        @if ($totalWithEmail > 0)
                        <span class="ml-auto text-xs bg-green-500 text-white px-2 py-1 rounded-full">{{ $totalWithEmail }}</span>
                        @endif
                    </a>

                <!-- Contact Management -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fas fa-envelope mr-2"></i>
                        Contact & Support
                    </div>

                    <a href="{{ route('admin.contact.submissions.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.contact.submissions.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-inbox w-5 h-5 mr-3"></i>
                        Contact Submissions
                        @php
                        $unreadCount = \App\Models\ContactSubmission::unread()->count();
                        @endphp
                        @if ($unreadCount > 0)
                        <span class="ml-auto text-xs bg-red-500 text-white px-2 py-1 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.contact.settings') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.contact.settings*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-cog w-5 h-5 mr-3"></i>
                        Contact Settings
                    </a>

                    <a href="{{ route('admin.contact.faqs.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.contact.faqs.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-question-circle w-5 h-5 mr-3"></i>
                        FAQs Management
                    </a>
                </div>

                <!-- ================================ -->
                <!-- BILLING & SUBSCRIPTION SECTION -->
                <!-- ================================ -->
                <div class="section-header">
                    <div class="flex items-center text-xs font-bold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-credit-card mr-2"></i>
                        Billing & Subscriptions
                    </div>
                </div>

                <!-- Pricing Plans -->
                <a href="{{ route('admin.pricing-plans.index') }}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.pricing-plans.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-tags w-5 h-5 mr-3"></i>
                    Pricing Plans
                    @php
                    $activePlans = \App\Models\PricingPlan::active()->count();
                    @endphp
                    @if ($activePlans > 0)
                    <span class="ml-auto text-xs bg-blue-500 text-white px-2 py-1 rounded-full">{{ $activePlans }}</span>
                    @endif
                </a>

                <!-- Stripe Management -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fab fa-stripe mr-2"></i>
                        Stripe Management
                    </div>

                    <a href="{{ route('admin.stripe.dashboard') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.stripe.dashboard') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-chart-pie w-5 h-5 mr-3"></i>
                        Stripe Dashboard
                    </a>

                    <a href="{{ route('admin.stripe.subscriptions') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.stripe.subscriptions') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-user-friends w-5 h-5 mr-3"></i>
                        Subscriptions
                        @php
                        $activeSubscriptions = \App\Models\UserSubscription::active()->count();
                        @endphp
                        @if ($activeSubscriptions > 0)
                        <span class="ml-auto text-xs bg-green-500 text-white px-2 py-1 rounded-full">{{ $activeSubscriptions }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.stripe.payments') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.stripe.payments') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-receipt w-5 h-5 mr-3"></i>
                        Payment History
                    </a>

                    <a href="{{ route('admin.stripe.settings') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.stripe.settings*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-cog w-5 h-5 mr-3"></i>
                        Stripe Settings
                    </a>
                </div>

                <!-- ================================ -->
                <!-- E-COMMERCE SECTION -->
                <!-- ================================ -->
                <div class="section-header">
                    <div class="flex items-center text-xs font-bold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-store mr-2"></i>
                        E-Commerce Shop
                    </div>
                </div>

                <!-- Shop Dashboard -->
                <a href="{{ route('admin.shop.dashboard') }}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.dashboard') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    Shop Dashboard
                </a>

                <!-- Shop Analytics -->
                <a href="{{ route('admin.shop.analytics') }}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.analytics*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                    Shop Analytics
                </a>

                <!-- Products & Catalog -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fas fa-boxes mr-2"></i>
                        Products & Catalog
                    </div>

                    <a href="{{ route('admin.shop.products.index') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.products.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-cube w-5 h-5 mr-3"></i>
                        Shop Products
                        @php
                        $lowStockCount = \App\Models\ShopProduct::where('manage_stock', true)->where('stock_quantity', '<=', 5)->count();
                        @endphp
                        @if ($lowStockCount > 0)
                        <span class="ml-auto text-xs bg-red-500 text-white px-2 py-1 rounded-full">{{ $lowStockCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.shop.categories.index') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.categories.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-folder w-5 h-5 mr-3"></i>
                        Product Categories
                    </a>

                    <a href="{{ route('admin.shop.inventory.index') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.inventory.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-warehouse w-5 h-5 mr-3"></i>
                        Inventory Management
                        @if ($lowStockCount > 0)
                        <span class="ml-auto text-xs bg-orange-500 text-white px-2 py-1 rounded-full">{{ $lowStockCount }}</span>
                        @endif
                    </a>
                </div>

                <!-- Orders & Sales -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Orders & Sales
                    </div>

                    <a href="{{ route('admin.shop.orders.index') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.orders.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-shopping-bag w-5 h-5 mr-3"></i>
                        All Orders
                        @php
                        $pendingOrders = \App\Models\ShopOrder::pending()->count();
                        @endphp
                        @if ($pendingOrders > 0)
                        <span class="ml-auto text-xs bg-yellow-500 text-white px-2 py-1 rounded-full">{{ $pendingOrders }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.shop.carts.index') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.carts.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-shopping-cart w-5 h-5 mr-3"></i>
                        Shopping Carts
                    </a>

                    <a href="{{ route('admin.shop.carts.abandoned') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.carts.abandoned') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-cart-arrow-down w-5 h-5 mr-3"></i>
                        Abandoned Carts
                    </a>
                </div>

                <!-- Customer Reviews -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fas fa-star mr-2"></i>
                        Reviews & Ratings
                    </div>

                    <a href="{{ route('admin.shop.reviews.index') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.reviews.index') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-star w-5 h-5 mr-3"></i>
                        All Reviews
                        @php
                        $pendingReviews = \App\Models\ShopReview::pending()->count();
                        @endphp
                        @if ($pendingReviews > 0)
                        <span class="ml-auto text-xs bg-blue-500 text-white px-2 py-1 rounded-full">{{ $pendingReviews }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.shop.reviews.moderation') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.reviews.moderation') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-gavel w-5 h-5 mr-3"></i>
                        Moderation Queue
                        @if ($pendingReviews > 0)
                        <span class="ml-auto text-xs bg-yellow-500 text-white px-2 py-1 rounded-full">{{ $pendingReviews }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.shop.reviews.analytics') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.reviews.analytics') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                        Reviews Analytics
                    </a>
                </div>

                <!-- Digital Downloads -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fas fa-download mr-2"></i>
                        Digital Downloads
                    </div>

                    <a href="{{ route('admin.shop.downloads.index') }}"
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.downloads.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-cloud-download-alt w-5 h-5 mr-3"></i>
                        Download Manager
                    </a>
                </div>

                <!-- Shop Settings -->
                <a href="{{ route('admin.shop.settings.index') }}"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.shop.settings.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-store-alt w-5 h-5 mr-3"></i>
                    Shop Settings
                </a>

                <!-- ================================ -->
                <!-- SYSTEM & SETTINGS SECTION -->
                <!-- ================================ -->
                <div class="section-header">
                    <div class="flex items-center text-xs font-bold text-gray-300 uppercase tracking-wider">
                        <i class="fas fa-cogs mr-2"></i>
                        System & Settings
                    </div>
                </div>

                <!-- SEO Management -->
                <div class="space-y-1 mb-4">
                    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <i class="fas fa-search mr-2"></i>
                        SEO Management
                    </div>

                    <a href="{{ route('admin.seo.global-settings') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.seo.global-settings*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-globe w-5 h-5 mr-3"></i>
                        Global SEO Settings
                    </a>

                    <a href="{{ route('admin.seo.page-settings') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.seo.page-settings*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                        Page SEO Settings
                    </a>

                    <a href="{{ route('admin.seo.tools') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.seo.tools*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-tools w-5 h-5 mr-3"></i>
                        SEO Tools
                    </a>

                    <a href="{{ route('admin.seo.analytics') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.seo.analytics*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                        <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                        SEO Analytics
                    </a>
                </div>

                <!-- Security & Protection -->
<div class="space-y-1 mb-4">
    <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
        <i class="fas fa-shield-alt mr-2"></i>
        Security & Protection
    </div>

    <a href="{{ route('admin.security.recaptcha.index') }}"
        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.security.recaptcha.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
        <i class="fas fa-robot w-5 h-5 mr-3"></i>
        reCAPTCHA Settings
        @php
        $recaptchaSettings = \App\Models\ReCaptchaSettings::getSettings();
        @endphp
        @if($recaptchaSettings->isEnabled())
        <span class="ml-auto text-xs bg-green-500 text-white px-2 py-1 rounded-full">ON</span>
        @else
        <span class="ml-auto text-xs bg-red-500 text-white px-2 py-1 rounded-full">OFF</span>
        @endif
    </a>

    <a href="{{ route('admin.ai.settings') }}"
        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.ai.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
        <i class="fas fa-brain w-5 h-5 mr-3"></i>
        TKDS AI Settings
        @php
        $aiSettings = \App\Models\AiSettings::getSettings();
        @endphp
        @if($aiSettings->isEnabled())
        <span class="ml-auto text-xs bg-green-500 text-white px-2 py-1 rounded-full">ON</span>
        @else
        <span class="ml-auto text-xs bg-red-500 text-white px-2 py-1 rounded-full">OFF</span>
        @endif
    </a>

    {{-- Future security features --}}
    {{--
    <a href="{{ route('admin.security.firewall') }}"
        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.security.firewall*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
        <i class="fas fa-fire-alt w-5 h-5 mr-3"></i>
        Firewall Settings
    </a>

    <a href="{{ route('admin.security.activity-logs') }}"
        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.security.activity-logs*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
        <i class="fas fa-list-alt w-5 h-5 mr-3"></i>
        Activity Logs
    </a>
    --}}
</div>

                <!-- Site Structure -->
                <a href="{{ route('admin.footer.index') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-white/10 transition-colors duration-200 {{ request()->routeIs('admin.footer.*') ? 'bg-white/20 text-white' : 'text-gray-300' }}">
                    <i class="fas fa-columns w-5 h-5 mr-3"></i>
                    Footer Management
                </a>

                <!-- Bottom Spacing -->
                <div class="pb-4"></div>

            </nav>
        </div>

        <!-- User Info at Bottom - Fixed -->
        <div class="flex-shrink-0 p-4 border-t border-white/10 bg-admin-sidebar">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-bold">{{ substr(auth('admin')->user()->name, 0, 1) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth('admin')->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth('admin')->user()->email }}</p>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-white transition-colors duration-200"
                        title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <!-- Main Content -->
    <div class="lg:ml-64">

        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-4">

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn"
                    class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Page Title -->
                <div class="flex-1 min-w-0 lg:px-4">
                    <h1 class="text-2xl font-bold text-gray-900">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>

                <!-- Header Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Quick Actions Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors duration-200">
                            <i class="fas fa-plus text-lg"></i>
                        </button>
                        
                        <!-- Quick Actions Menu -->
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100">
                            <div class="py-1">
                                <a href="{{ route('admin.blog.posts.create') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-file-alt mr-3"></i>
                                    New Blog Post
                                </a>
                                <a href="{{ route('admin.shop.products.create') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cube mr-3"></i>
                                    New Product
                                </a>
                                <a href="{{ route('admin.users.create') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-plus mr-3"></i>
                                    New User
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors duration-200 relative">
                            <i class="fas fa-bell text-lg"></i>
                            @php
                            $totalNotifications = ($unreadCount ?? 0) + ($pendingOrders ?? 0) + ($pendingReviews ?? 0);
                            @endphp
                            @if($totalNotifications > 0)
                            <span class="absolute -top-1 -right-1 h-5 w-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                {{ $totalNotifications > 9 ? '9+' : $totalNotifications }}
                            </span>
                            @endif
                        </button>

                        <!-- Notifications Dropdown -->
                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                @if(($unreadCount ?? 0) > 0)
                                <a href="{{ route('admin.contact.submissions.index') }}" 
                                   class="flex items-center px-4 py-3 hover:bg-gray-50">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-envelope text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $unreadCount }} new messages</p>
                                        <p class="text-xs text-gray-500">Contact form submissions</p>
                                    </div>
                                </a>
                                @endif

                                @if(($pendingOrders ?? 0) > 0)
                                <a href="{{ route('admin.shop.orders.index') }}?status=pending" 
                                   class="flex items-center px-4 py-3 hover:bg-gray-50">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-shopping-cart text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $pendingOrders }} pending orders</p>
                                        <p class="text-xs text-gray-500">Need processing</p>
                                    </div>
                                </a>
                                @endif

                                @if(($pendingReviews ?? 0) > 0)
                                <a href="{{ route('admin.shop.reviews.moderation') }}" 
                                   class="flex items-center px-4 py-3 hover:bg-gray-50">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-star text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $pendingReviews }} reviews pending</p>
                                        <p class="text-xs text-gray-500">Awaiting moderation</p>
                                    </div>
                                </a>
                                @endif

                                @if($totalNotifications == 0)
                                <div class="px-4 py-8 text-center">
                                    <i class="fas fa-check-circle text-4xl text-green-500 mb-2"></i>
                                    <p class="text-gray-500">All caught up!</p>
                                </div>
                                @endif
                            </div>
                            @if($totalNotifications > 0)
                            <div class="p-4 border-t border-gray-200">
                                <a href="#" class="text-sm text-primary hover:text-secondary font-medium">
                                    View all notifications
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 p-2 rounded-md hover:bg-gray-100 transition-colors duration-200">
                            <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">{{ substr(auth('admin')->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="hidden md:block text-sm font-medium text-gray-700">{{ auth('admin')->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>

                        <!-- Profile Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100">
                            <div class="py-1">
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-3"></i>
                                    Profile Settings
                                </a>
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-3"></i>
                                    Account Settings
                                </a>
                                <div class="border-t border-gray-200"></div>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    <!-- Alpine.js for dropdowns -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- JavaScript -->
    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        mobileMenuBtn.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Close sidebar on window resize if desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }
        });

        // Add active states and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll to active menu item on page load
            const activeMenuItem = document.querySelector('.bg-white\\/20');
            if (activeMenuItem) {
                activeMenuItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            // Add hover animations to menu items
            const menuItems = document.querySelectorAll('nav a');
            menuItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(4px)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });

            // Auto-refresh notification counts every 30 seconds
            setInterval(function() {
                fetch('/admin/notifications/count')
                    .then(response => response.json())
                    .then(data => {
                        // Update notification badges
                        updateNotificationBadges(data);
                    })
                    .catch(error => {
                        console.log('Notification refresh failed:', error);
                    });
            }, 30000);
        });

        function updateNotificationBadges(data) {
            // Update sidebar badges
            const badges = {
                'contact-badge': data.unread_contacts || 0,
                'orders-badge': data.pending_orders || 0,
                'reviews-badge': data.pending_reviews || 0,
                'users-badge': data.new_users || 0,
                'plans-badge': data.active_plans || 0,
                'subscriptions-badge': data.active_subscriptions || 0,
                'stock-badge': data.low_stock || 0
            };

            Object.entries(badges).forEach(([id, count]) => {
                const element = document.getElementById(id);
                if (element) {
                    if (count > 0) {
                        element.textContent = count > 99 ? '99+' : count;
                        element.style.display = 'inline-flex';
                    } else {
                        element.style.display = 'none';
                    }
                }
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Alt + D = Dashboard
            if (e.altKey && e.key === 'd') {
                e.preventDefault();
                window.location.href = '{{ route("admin.dashboard") }}';
            }
            
            // Alt + S = Shop
            if (e.altKey && e.key === 's') {
                e.preventDefault();
                window.location.href = '{{ route("admin.shop.dashboard") }}';
            }
            
            // Alt + B = Blog
            if (e.altKey && e.key === 'b') {
                e.preventDefault();
                window.location.href = '{{ route("admin.blog-analytics") }}';
            }
        });
    </script>

    @stack('scripts')
</body>

</html>