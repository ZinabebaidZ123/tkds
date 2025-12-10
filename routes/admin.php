<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BroadcastingSolutionController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\BlogAuthorController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ShopCategoryController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\OccasionController; 
use App\Http\Controllers\Admin\DynamicPageController;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Login Routes (Public)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Protected Routes 
    Route::middleware(['admin.auth'])->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Hero Sections Management Routes
        Route::resource('hero-sections', App\Http\Controllers\Admin\HeroSectionController::class);
        Route::post('hero-sections/{heroSection}/status', [App\Http\Controllers\Admin\HeroSectionController::class, 'updateStatus'])->name('hero-sections.status');

        // Perfect For Cards Management Routes  
        Route::resource('perfect-for-cards', App\Http\Controllers\Admin\PerfectForCardController::class);
        Route::post('perfect-for-cards/{perfectForCard}/status', [App\Http\Controllers\Admin\PerfectForCardController::class, 'updateStatus'])->name('perfect-for-cards.status');

        // Broadcasting Solutions Routes
        Route::resource('broadcasting-solutions', BroadcastingSolutionController::class);
        Route::post('broadcasting-solutions/{broadcastingSolution}/status', [BroadcastingSolutionController::class, 'updateStatus'])->name('broadcasting-solutions.status');
       
Route::get('broadcasting-solutions/get-section-title', [BroadcastingSolutionController::class, 'getSectionTitle'])->name('admin.broadcasting-solutions.get-section-title');
Route::post('broadcasting-solutions/update-section-title', [BroadcastingSolutionController::class, 'updateSectionTitle'])->name('admin.broadcasting-solutions.update-section-title');
        Route::post('broadcasting-solutions/sort-order', [BroadcastingSolutionController::class, 'updateSortOrder'])->name('broadcasting-solutions.sort-order');

        // Client Management Routes
        Route::resource('clients', ClientController::class);
        Route::post('clients/{client}/status', [ClientController::class, 'updateStatus'])->name('clients.status');

        // Team Members Routes
        Route::resource('team-members', TeamMemberController::class);
        Route::post('team-members/{teamMember}/status', [TeamMemberController::class, 'updateStatus'])->name('team-members.status');
        Route::post('team-members/sort-order', [TeamMemberController::class, 'updateSortOrder'])->name('team-members.sort-order');

// Blog Management Routes
Route::prefix('blog')->name('blog.')->group(function () {

    // Categories
    Route::resource('categories', BlogCategoryController::class);
    Route::post('categories/{category}/status', [BlogCategoryController::class, 'updateStatus'])->name('categories.status');
    Route::post('categories/sort-order', [BlogCategoryController::class, 'updateSortOrder'])->name('categories.sort-order');

    // Tags - Fixed explicit routes
    Route::get('tags', [BlogTagController::class, 'index'])->name('tags.index');
    Route::post('tags', [BlogTagController::class, 'store'])->name('tags.store');
    Route::get('tags/search', [BlogTagController::class, 'search'])->name('tags.search');
    Route::get('tags/{tag}', [BlogTagController::class, 'show'])->name('tags.show');
    Route::get('tags/{tag}/edit', [BlogTagController::class, 'edit'])->name('tags.edit');
    Route::put('tags/{tag}', [BlogTagController::class, 'update'])->name('tags.update');
    Route::delete('tags/{tag}', [BlogTagController::class, 'destroy'])->name('tags.destroy');
    Route::post('tags/{tag}/status', [BlogTagController::class, 'updateStatus'])->name('tags.status');

    // Authors - FIXED ROUTES
    Route::get('authors', [BlogAuthorController::class, 'index'])->name('authors.index');
    Route::get('authors/create', [BlogAuthorController::class, 'create'])->name('authors.create');
    Route::post('authors', [BlogAuthorController::class, 'store'])->name('authors.store');
    Route::get('authors/{author}', [BlogAuthorController::class, 'show'])->name('authors.show');
    Route::get('authors/{author}/edit', [BlogAuthorController::class, 'edit'])->name('authors.edit');
    Route::put('authors/{author}', [BlogAuthorController::class, 'update'])->name('authors.update');
    Route::delete('authors/{author}', [BlogAuthorController::class, 'destroy'])->name('authors.destroy');
    Route::post('authors/{author}/status', [BlogAuthorController::class, 'updateStatus'])->name('authors.status');

    // Blog Posts - Section Title Management Routes (MUST BE FIRST)
    Route::get('posts/get-section-title', [BlogPostController::class, 'getSectionTitle'])
        ->name('posts.get-section-title');
    Route::post('posts/update-section-title', [BlogPostController::class, 'updateSectionTitle'])
        ->name('posts.update-section-title');

    // Blog Posts - Index and Create routes (no parameters)
    Route::get('posts', [BlogPostController::class, 'index'])->name('posts.index');
    Route::get('posts/create', [BlogPostController::class, 'create'])->name('posts.create');
    Route::post('posts', [BlogPostController::class, 'store'])->name('posts.store');
    
    // Custom action routes with explicit parameter binding
    Route::post('posts/{post}/status', [BlogPostController::class, 'updateStatus'])
        ->name('posts.status')
        ->where('post', '[0-9]+');
        
    Route::post('posts/{post}/duplicate', [BlogPostController::class, 'duplicate'])
        ->name('posts.duplicate')
        ->where('post', '[0-9]+');

    // Gallery image removal route
    Route::delete('posts/{post}/gallery-image', [BlogPostController::class, 'removeGalleryImage'])
        ->name('posts.gallery.remove')
        ->where('post', '[0-9]+');
        
    Route::delete('posts/{post}/media/{media}', [BlogPostController::class, 'deleteMedia'])
        ->name('posts.media.delete')
        ->where(['post' => '[0-9]+', 'media' => '[0-9]+']);
    
    // Show, Edit, Update, Delete routes (ID-based) - LAST
    Route::get('posts/{post}', [BlogPostController::class, 'show'])
        ->name('posts.show')
        ->where('post', '[0-9]+');
        
    Route::get('posts/{post}/edit', [BlogPostController::class, 'edit'])
        ->name('posts.edit')
        ->where('post', '[0-9]+');
        
    Route::put('posts/{post}', [BlogPostController::class, 'update'])
        ->name('posts.update')
        ->where('post', '[0-9]+');
        
    Route::delete('posts/{post}', [BlogPostController::class, 'destroy'])
        ->name('posts.destroy')
        ->where('post', '[0-9]+');
});
        // Blog Analytics/Dashboard
        Route::get('blog-analytics', function () {
            $totalPosts = \App\Models\BlogPost::count();
            $publishedPosts = \App\Models\BlogPost::published()->count();
            $draftPosts = \App\Models\BlogPost::draft()->count();
            $totalViews = \App\Models\BlogPost::sum('view_count');
            $totalCategories = \App\Models\BlogCategory::active()->count();
            $totalTags = \App\Models\BlogTag::active()->count();
            $totalAuthors = \App\Models\BlogAuthor::active()->count();

            $recentPosts = \App\Models\BlogPost::with(['category', 'author'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            $popularPosts = \App\Models\BlogPost::published()
                ->with(['category', 'author'])
                ->orderBy('view_count', 'desc')
                ->limit(10)
                ->get();

            return view('admin.blog.analytics', compact(
                'totalPosts',
                'publishedPosts',
                'draftPosts',
                'totalViews',
                'totalCategories',
                'totalTags',
                'totalAuthors',
                'recentPosts',
                'popularPosts'
            ));
        })->name('blog-analytics');

        // Services Management Routes
        Route::post('services/{id}/delete', [ServiceController::class, 'deleteService'])->name('services.delete');
        Route::resource('services', ServiceController::class);
        Route::post('services/{service}/status', [ServiceController::class, 'updateStatus'])->name('services.status');
        Route::post('services/sort-order', [ServiceController::class, 'updateSortOrder'])->name('services.sort-order');

        // Service Page Content Management
        Route::get('services/{service}/page-content', [ServiceController::class, 'pageContent'])->name('services.page-content');
        Route::put('services/{service}/page-content', [ServiceController::class, 'updatePageContent'])->name('services.update-page-content');

        Route::get('products/get-section-title', [App\Http\Controllers\Admin\ProductController::class, 'getSectionTitle'])
    ->name('products.get-section-title');
Route::post('products/update-section-title', [App\Http\Controllers\Admin\ProductController::class, 'updateSectionTitle'])
    ->name('products.update-section-title');

        // Status update route
        Route::post('products/{product}/status', [App\Http\Controllers\Admin\ProductController::class, 'updateStatus'])->name('products.status');

        // Duplicate route
        Route::post('products/{product}/duplicate', [App\Http\Controllers\Admin\ProductController::class, 'duplicate'])->name('products.duplicate');

        // Sort order route
        Route::post('products/sort-order', [App\Http\Controllers\Admin\ProductController::class, 'updateSortOrder'])->name('products.sort-order');

        // Page content routes
        Route::get('products/{product}/page-content', [App\Http\Controllers\Admin\ProductController::class, 'pageContent'])->name('products.page-content');
        Route::put('products/{product}/page-content', [App\Http\Controllers\Admin\ProductController::class, 'updatePageContent'])->name('products.update-page-content');

        // Resource routes LAST
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);

        // About Page Management Routes
        Route::prefix('about')->name('about.')->group(function () {

            // About Settings
            Route::get('settings', [App\Http\Controllers\Admin\AboutController::class, 'settings'])->name('settings');
            Route::put('settings', [App\Http\Controllers\Admin\AboutController::class, 'updateSettings'])->name('settings.update');

            // About Values Management
            Route::prefix('values')->name('values.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\AboutController::class, 'values'])->name('index');
                Route::get('create', [App\Http\Controllers\Admin\AboutController::class, 'createValue'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\AboutController::class, 'storeValue'])->name('store');
                Route::get('{value}/edit', [App\Http\Controllers\Admin\AboutController::class, 'editValue'])->name('edit');
                Route::put('{value}', [App\Http\Controllers\Admin\AboutController::class, 'updateValue'])->name('update');
                Route::delete('{value}', [App\Http\Controllers\Admin\AboutController::class, 'destroyValue'])->name('destroy');
                Route::post('{value}/status', [App\Http\Controllers\Admin\AboutController::class, 'updateValueStatus'])->name('status');
                Route::post('sort-order', [App\Http\Controllers\Admin\AboutController::class, 'updateValuesSortOrder'])->name('sort-order');
            });

            // About Timeline Management
            Route::prefix('timeline')->name('timeline.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\AboutController::class, 'timeline'])->name('index');
                Route::get('create', [App\Http\Controllers\Admin\AboutController::class, 'createTimeline'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\AboutController::class, 'storeTimeline'])->name('store');
                Route::get('{timeline}/edit', [App\Http\Controllers\Admin\AboutController::class, 'editTimeline'])->name('edit');
                Route::put('{timeline}', [App\Http\Controllers\Admin\AboutController::class, 'updateTimeline'])->name('update');
                Route::delete('{timeline}', [App\Http\Controllers\Admin\AboutController::class, 'destroyTimeline'])->name('destroy');
                Route::post('{timeline}/status', [App\Http\Controllers\Admin\AboutController::class, 'updateTimelineStatus'])->name('status');
                Route::post('sort-order', [App\Http\Controllers\Admin\AboutController::class, 'updateTimelineSortOrder'])->name('sort-order');
            });
        });

        // Contact Management Routes
        Route::prefix('contact')->name('contact.')->group(function () {

            // Contact Submissions Management
            Route::prefix('submissions')->name('submissions.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\ContactController::class, 'submissions'])->name('index');
                Route::get('/{submission}', [App\Http\Controllers\Admin\ContactController::class, 'showSubmission'])->name('show');
                Route::post('/{submission}/status', [App\Http\Controllers\Admin\ContactController::class, 'updateSubmissionStatus'])->name('update-status');
                Route::delete('/{submission}', [App\Http\Controllers\Admin\ContactController::class, 'deleteSubmission'])->name('destroy');
                Route::post('/bulk-actions', [App\Http\Controllers\Admin\ContactController::class, 'bulkActions'])->name('bulk-actions');
                Route::get('/export/csv', [App\Http\Controllers\Admin\ContactController::class, 'exportSubmissions'])->name('export');
            });

            // Contact Settings Management
            Route::get('settings', [App\Http\Controllers\Admin\ContactController::class, 'settings'])->name('settings');
            Route::put('settings', [App\Http\Controllers\Admin\ContactController::class, 'updateSettings'])->name('settings.update');

            // Contact FAQ Management
            Route::prefix('faqs')->name('faqs.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\ContactController::class, 'faqs'])->name('index');
                Route::get('create', [App\Http\Controllers\Admin\ContactController::class, 'createFaq'])->name('create');
                Route::post('/', [App\Http\Controllers\Admin\ContactController::class, 'storeFaq'])->name('store');
                Route::get('{faq}/edit', [App\Http\Controllers\Admin\ContactController::class, 'editFaq'])->name('edit');
                Route::put('{faq}', [App\Http\Controllers\Admin\ContactController::class, 'updateFaq'])->name('update');
                Route::delete('{faq}', [App\Http\Controllers\Admin\ContactController::class, 'destroyFaq'])->name('destroy');
                Route::post('{faq}/status', [App\Http\Controllers\Admin\ContactController::class, 'updateFaqStatus'])->name('status');
                Route::post('sort-order', [App\Http\Controllers\Admin\ContactController::class, 'updateFaqSortOrder'])->name('sort-order');
            });
        });

        Route::prefix('seo')->name('seo.')->group(function () {

            // Global SEO Settings
            Route::get('global-settings', [App\Http\Controllers\Admin\SeoController::class, 'globalSettings'])->name('global-settings');
            Route::put('global-settings', [App\Http\Controllers\Admin\SeoController::class, 'updateGlobalSettings'])->name('global-settings.update');

            // Page SEO Settings
            Route::get('page-settings', [App\Http\Controllers\Admin\SeoController::class, 'pageSettings'])->name('page-settings');
            Route::get('page-settings/create', [App\Http\Controllers\Admin\SeoController::class, 'createPageSetting'])->name('page-settings.create');
            Route::post('page-settings', [App\Http\Controllers\Admin\SeoController::class, 'storePageSetting'])->name('page-settings.store');
            Route::get('page-settings/{pageSeoSetting}/edit', [App\Http\Controllers\Admin\SeoController::class, 'editPageSetting'])->name('page-settings.edit');
            Route::put('page-settings/{pageSeoSetting}', [App\Http\Controllers\Admin\SeoController::class, 'updatePageSetting'])->name('page-settings.update');
            Route::delete('page-settings/{pageSeoSetting}', [App\Http\Controllers\Admin\SeoController::class, 'destroyPageSetting'])->name('page-settings.destroy');
            Route::post('page-settings/{pageSeoSetting}/status', [App\Http\Controllers\Admin\SeoController::class, 'updatePageStatus'])->name('page-settings.status');

            // SEO Tools
            Route::get('tools', [App\Http\Controllers\Admin\SeoController::class, 'seoTools'])->name('tools');
            Route::post('tools/generate-sitemap', [App\Http\Controllers\Admin\SeoController::class, 'generateSitemap'])->name('tools.generate-sitemap');
            Route::post('tools/generate-robots', [App\Http\Controllers\Admin\SeoController::class, 'generateRobotsTxt'])->name('tools.generate-robots');

            // SEO Analytics
            Route::get('analytics', [App\Http\Controllers\Admin\SeoController::class, 'seoAnalytics'])->name('analytics');
        });

        // Footer Management Routes
        Route::prefix('footer')->name('footer.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\FooterController::class, 'index'])->name('index');
            Route::put('/update', [App\Http\Controllers\Admin\FooterController::class, 'update'])->name('update');
        });

        // User Management Routes
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::post('users/{user}/status', [App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('users.status');
        Route::post('users/{user}/verify-email', [App\Http\Controllers\Admin\UserController::class, 'verifyEmail'])->name('users.verify-email');
        Route::post('users/bulk-actions', [App\Http\Controllers\Admin\UserController::class, 'bulkActions'])->name('users.bulk-actions');
        Route::get('users/export/csv', [App\Http\Controllers\Admin\UserController::class, 'exportUsers'])->name('users.export');

 // ===================== PRICING PLANS MANAGEMENT =====================
        Route::prefix('pricing-plans')->name('pricing-plans.')->group(function () {
            // Section Title Management Routes 
            Route::get('/get-section-title', [App\Http\Controllers\Admin\PricingPlanController::class, 'getSectionTitle'])->name('get-section-title');
            Route::post('/update-section-title', [App\Http\Controllers\Admin\PricingPlanController::class, 'updateSectionTitle'])->name('update-section-title');
            
            // Non-parameter routes FIRST - these are static routes that don't conflict
            Route::get('/', [App\Http\Controllers\Admin\PricingPlanController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\PricingPlanController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\PricingPlanController::class, 'store'])->name('store');
            Route::post('/sort-order', [App\Http\Controllers\Admin\PricingPlanController::class, 'updateSortOrder'])->name('sort-order');
            
            // Parameter-based routes LAST - these use model binding and can conflict
            Route::get('/{pricingPlan}', [App\Http\Controllers\Admin\PricingPlanController::class, 'show'])->name('show');
            Route::get('/{pricingPlan}/edit', [App\Http\Controllers\Admin\PricingPlanController::class, 'edit'])->name('edit');
            Route::put('/{pricingPlan}', [App\Http\Controllers\Admin\PricingPlanController::class, 'update'])->name('update');
            Route::delete('/{pricingPlan}', [App\Http\Controllers\Admin\PricingPlanController::class, 'destroy'])->name('destroy');
            Route::post('/{pricingPlan}/status', [App\Http\Controllers\Admin\PricingPlanController::class, 'updateStatus'])->name('status');
            Route::post('/{pricingPlan}/duplicate', [App\Http\Controllers\Admin\PricingPlanController::class, 'duplicate'])->name('duplicate');
            Route::post('/{pricingPlan}/sync-stripe', [App\Http\Controllers\Admin\PricingPlanController::class, 'syncStripe'])->name('sync-stripe');
        });

        // Stripe Management
        Route::prefix('stripe')->name('stripe.')->group(function () {
            // Dashboard & Analytics
            Route::get('dashboard', [App\Http\Controllers\Admin\StripeController::class, 'dashboard'])->name('dashboard');

            // Settings
            Route::get('settings', [App\Http\Controllers\Admin\StripeController::class, 'settings'])->name('settings');
            Route::put('settings', [App\Http\Controllers\Admin\StripeController::class, 'updateSettings'])->name('settings.update');

            // Subscriptions Management
            Route::get('subscriptions', [App\Http\Controllers\Admin\StripeController::class, 'subscriptions'])->name('subscriptions');

            // Payments Management
            Route::get('payments', [App\Http\Controllers\Admin\StripeController::class, 'payments'])->name('payments');

            // Utilities
            Route::post('test-connection', [App\Http\Controllers\Admin\StripeController::class, 'testConnection'])->name('test-connection');
            Route::get('webhook-url', [App\Http\Controllers\Admin\StripeController::class, 'generateWebhookUrl'])->name('webhook-url');
        });

        // Add notification count route for auto-refresh
        Route::get('notifications/count', function () {
            return response()->json([
                'unread_contacts' => \App\Models\ContactSubmission::where('status', 'unread')->count(),
                'pending_orders' => \App\Models\ShopOrder::where('status', 'pending')->count(),
                'pending_reviews' => \App\Models\ShopReview::where('status', 'pending')->count(),
                'new_users' => \App\Models\User::where('created_at', '>=', now()->subDays(7))->count(),
                'active_plans' => \App\Models\PricingPlan::where('status', 'active')->count(),
                'active_subscriptions' => \App\Models\UserSubscription::where('status', 'active')->count(),
                'low_stock' => \App\Models\ShopProduct::where('manage_stock', true)->where('stock_quantity', '<=', 5)->count(),
            ]);
        })->name('notifications.count');

        // ===================== SHOP MANAGEMENT ROUTES - FIXED ORDER =====================
        Route::prefix('shop')->name('shop.')->group(function () {

            // Shop Dashboard
            Route::get('/', [App\Http\Controllers\Admin\ShopDashboardController::class, 'index'])->name('dashboard');

            // Shop Settings
            Route::get('settings', [App\Http\Controllers\Admin\ShopSettingsController::class, 'index'])->name('settings.index');
            Route::put('settings', [App\Http\Controllers\Admin\ShopSettingsController::class, 'update'])->name('settings.update');

            // Shop Analytics
            Route::get('analytics', [App\Http\Controllers\Admin\ShopAnalyticsController::class, 'index'])->name('analytics');
            Route::get('analytics/revenue', [App\Http\Controllers\Admin\ShopAnalyticsController::class, 'revenue'])->name('analytics.revenue');
            Route::get('analytics/products', [App\Http\Controllers\Admin\ShopAnalyticsController::class, 'products'])->name('analytics.products');
            Route::get('analytics/customers', [App\Http\Controllers\Admin\ShopAnalyticsController::class, 'customers'])->name('analytics.customers');
            Route::get('analytics/inventory', [App\Http\Controllers\Admin\ShopAnalyticsController::class, 'inventory'])->name('analytics.inventory');
            Route::get('analytics/export', [App\Http\Controllers\Admin\ShopAnalyticsController::class, 'export'])->name('analytics.export');

            // Shop Categories Management - Special routes BEFORE resource routes
            Route::post('categories/{category}/status', [App\Http\Controllers\Admin\ShopCategoryController::class, 'updateStatus'])->name('categories.status');
            Route::post('categories/sort-order', [App\Http\Controllers\Admin\ShopCategoryController::class, 'updateSortOrder'])->name('categories.sort-order');
            Route::post('categories/bulk-actions', [App\Http\Controllers\Admin\ShopCategoryController::class, 'bulkActions'])->name('categories.bulk-actions');
            Route::get('categories/tree-data', [App\Http\Controllers\Admin\ShopCategoryController::class, 'getTreeData'])->name('categories.tree-data');
            // Resource routes LAST for categories
            Route::resource('categories', App\Http\Controllers\Admin\ShopCategoryController::class);

            // Shop Products Management - Special routes BEFORE resource routes
            Route::post('products/{product}/status', [App\Http\Controllers\Admin\ShopProductController::class, 'updateStatus'])->name('products.status');
            Route::post('products/{product}/duplicate', [App\Http\Controllers\Admin\ShopProductController::class, 'duplicate'])->name('products.duplicate');
            Route::post('products/bulk-actions', [App\Http\Controllers\Admin\ShopProductController::class, 'bulkActions'])->name('products.bulk-actions');
            Route::get('products/export/csv', [App\Http\Controllers\Admin\ShopProductController::class, 'export'])->name('products.export');
            Route::get('products/analytics', [App\Http\Controllers\Admin\ShopProductController::class, 'analytics'])->name('products.analytics');
            // Resource routes LAST for products
            Route::resource('products', App\Http\Controllers\Admin\ShopProductController::class);

            // Shop Orders Management - Special routes BEFORE resource routes
            Route::post('orders/{order}/status', [App\Http\Controllers\Admin\ShopOrderController::class, 'updateStatus'])->name('orders.status');
            Route::post('orders/{order}/payment-status', [App\Http\Controllers\Admin\ShopOrderController::class, 'updatePaymentStatus'])->name('orders.payment-status');
            Route::post('orders/{order}/note', [App\Http\Controllers\Admin\ShopOrderController::class, 'addNote'])->name('orders.note');
            Route::get('orders/{order}/invoice', [App\Http\Controllers\Admin\ShopOrderController::class, 'generateInvoice'])->name('orders.invoice');
            Route::post('orders/bulk-actions', [App\Http\Controllers\Admin\ShopOrderController::class, 'bulkActions'])->name('orders.bulk-actions');
            Route::get('orders/export/csv', [App\Http\Controllers\Admin\ShopOrderController::class, 'export'])->name('orders.export');
            Route::get('orders/analytics', [App\Http\Controllers\Admin\ShopOrderController::class, 'analytics'])->name('orders.analytics');
            // Resource routes LAST for orders
            Route::resource('orders', App\Http\Controllers\Admin\ShopOrderController::class);

            // Shop Reviews Management - Special routes BEFORE resource routes
            Route::get('reviews/analytics', [App\Http\Controllers\Admin\ShopReviewController::class, 'analytics'])->name('reviews.analytics');
            Route::get('reviews/moderation', [App\Http\Controllers\Admin\ShopReviewController::class, 'moderationQueue'])->name('reviews.moderation');
            Route::get('reviews/export/csv', [App\Http\Controllers\Admin\ShopReviewController::class, 'export'])->name('reviews.export');
            Route::post('reviews/{review}/quick-moderate', [App\Http\Controllers\Admin\ShopReviewController::class, 'quickModerate'])->name('reviews.quick-moderate');
            Route::post('reviews/{review}/status', [App\Http\Controllers\Admin\ShopReviewController::class, 'updateStatus'])->name('reviews.status');
            Route::post('reviews/bulk-actions', [App\Http\Controllers\Admin\ShopReviewController::class, 'bulkActions'])->name('reviews.bulk-actions');
            // Resource routes LAST for reviews
            Route::resource('reviews', App\Http\Controllers\Admin\ShopReviewController::class);

            // Inventory Management
            Route::get('inventory', [App\Http\Controllers\Admin\ShopInventoryController::class, 'index'])->name('inventory.index');
            Route::post('inventory/bulk-update', [App\Http\Controllers\Admin\ShopInventoryController::class, 'bulkUpdate'])->name('inventory.bulk-update');
            Route::get('inventory/low-stock', [App\Http\Controllers\Admin\ShopInventoryController::class, 'lowStock'])->name('inventory.low-stock');

            // Cart Management (Abandoned Carts)
            Route::get('carts', [App\Http\Controllers\Admin\ShopCartController::class, 'index'])->name('carts.index');
            Route::get('carts/abandoned', [App\Http\Controllers\Admin\ShopCartController::class, 'abandoned'])->name('carts.abandoned');
            Route::delete('carts/{cart}', [App\Http\Controllers\Admin\ShopCartController::class, 'destroy'])->name('carts.destroy');

            // Downloads Management
            Route::get('downloads', [App\Http\Controllers\Admin\ShopDownloadController::class, 'index'])->name('downloads.index');
            Route::post('downloads/{download}/reset', [App\Http\Controllers\Admin\ShopDownloadController::class, 'reset'])->name('downloads.reset');
            Route::post('downloads/bulk-actions', [App\Http\Controllers\Admin\ShopDownloadController::class, 'bulkActions'])->name('downloads.bulk-actions');
        });

        Route::prefix('recaptcha')->name('recaptcha.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\ReCaptchaController::class, 'index'])->name('index');
            Route::put('/update', [App\Http\Controllers\Admin\ReCaptchaController::class, 'update'])->name('update');
            Route::post('/test', [App\Http\Controllers\Admin\ReCaptchaController::class, 'testConfiguration'])->name('test');
            Route::get('/statistics', [App\Http\Controllers\Admin\ReCaptchaController::class, 'statistics'])->name('statistics');
            Route::post('/reset', [App\Http\Controllers\Admin\ReCaptchaController::class, 'reset'])->name('reset');
        });

        // Video Sections Management Routes
Route::resource('video-sections', App\Http\Controllers\Admin\VideoSectionController::class);
Route::post('video-sections/{videoSection}/status', [App\Http\Controllers\Admin\VideoSectionController::class, 'updateStatus'])->name('video-sections.status');
Route::post('video-sections/sort-order', [App\Http\Controllers\Admin\VideoSectionController::class, 'updateSortOrder'])->name('video-sections.sort-order');

        Route::prefix('security')->name('security.')->group(function () {

            // reCAPTCHA Management
            Route::get('recaptcha', [App\Http\Controllers\Admin\ReCaptchaController::class, 'index'])->name('recaptcha.index');
            Route::put('recaptcha', [App\Http\Controllers\Admin\ReCaptchaController::class, 'update'])->name('recaptcha.update');
            Route::post('recaptcha/test', [App\Http\Controllers\Admin\ReCaptchaController::class, 'testConfiguration'])->name('recaptcha.test');
            Route::get('recaptcha/statistics', [App\Http\Controllers\Admin\ReCaptchaController::class, 'statistics'])->name('recaptcha.statistics');
            Route::post('recaptcha/reset', [App\Http\Controllers\Admin\ReCaptchaController::class, 'reset'])->name('recaptcha.reset');

            // Future security features can be added here
            // Route::get('firewall', [SecurityController::class, 'firewall'])->name('firewall');
            // Route::get('activity-logs', [SecurityController::class, 'activityLogs'])->name('activity-logs');
        });
        
    });

    
// Service Contact Management Routes
Route::prefix('service-contact')->name('service-contact.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\ServiceContactManagementController::class, 'index'])->name('index');
    
    // استخدم ID بدلاً من model binding
    Route::post('services/{id}/email', [App\Http\Controllers\Admin\ServiceContactManagementController::class, 'updateServiceEmail'])
        ->name('services.email')
        ->where('id', '[0-9]+');
        
    Route::post('products/{id}/email', [App\Http\Controllers\Admin\ServiceContactManagementController::class, 'updateProductEmail'])
        ->name('products.email')
        ->where('id', '[0-9]+');
        
    Route::post('bulk-update', [App\Http\Controllers\Admin\ServiceContactManagementController::class, 'bulkUpdateEmails'])->name('bulk-update');
    Route::post('test-email', [App\Http\Controllers\Admin\ServiceContactManagementController::class, 'testEmail'])->name('test-email');
    Route::get('check-status', [App\Http\Controllers\Admin\ServiceContactManagementController::class, 'checkEmailStatus'])->name('check-status');
});

// Newsletter Frontend Routes
Route::prefix('newsletter')->name('newsletter.')->group(function () {
    Route::post('/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('subscribe');
    Route::post('/unsubscribe', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('unsubscribe');
    Route::get('/unsubscribe/{email}', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('unsubscribe.get');
});

  Route::prefix('newsletter')->name('newsletter.')->group(function () {
        Route::get('/', [NewsletterController::class, 'index'])->name('index');
        Route::get('/analytics', [NewsletterController::class, 'analytics'])->name('analytics');
        Route::get('/subscribers', [NewsletterController::class, 'subscribers'])->name('subscribers');
        Route::get('/create', [NewsletterController::class, 'create'])->name('create');
        Route::post('/', [NewsletterController::class, 'store'])->name('store');
        Route::get('/{newsletter}', [NewsletterController::class, 'show'])->name('show');
        Route::get('/{newsletter}/edit', [NewsletterController::class, 'edit'])->name('edit');
        Route::put('/{newsletter}', [NewsletterController::class, 'update'])->name('update');
        Route::delete('/{newsletter}', [NewsletterController::class, 'destroy'])->name('destroy');
        Route::post('/send/{newsletter}', [NewsletterController::class, 'send'])->name('send');
        
        // Subscriber management
        Route::post('/subscribers/import', [NewsletterController::class, 'importSubscribers'])->name('subscribers.import');
        Route::delete('/subscribers/{subscriber}', [NewsletterController::class, 'deleteSubscriber'])->name('subscribers.delete');
    });
// Occasion Management Routes


Route::prefix('dynamic-pages')->name('dynamic-pages.')->group(function () {
    // Index - Sections Cards
    Route::get('/', [DynamicPageController::class, 'index'])->name('index');
    
    // Create & Store
    Route::get('/create', [DynamicPageController::class, 'create'])->name('create');
    Route::post('/', [DynamicPageController::class, 'store'])->name('store');
    
    // Edit Page Settings
    Route::get('/{page}/edit', [DynamicPageController::class, 'edit'])->name('edit');
    Route::put('/{page}', [DynamicPageController::class, 'update'])->name('update');
    
    // ✅ Routes الجديدة لإدارة تفعيل الصفحة
    Route::patch('/{page}/toggle-status', [DynamicPageController::class, 'toggleStatus'])->name('toggle-status');
    Route::put('/{page}/status', [DynamicPageController::class, 'updatePageStatus'])->name('update-status');
    Route::get('/{page}/status', [DynamicPageController::class, 'getPageStatus'])->name('get-status');
    Route::put('/{page}/offer-end-date', [DynamicPageController::class, 'updateOfferEndDate'])->name('update-offer-end-date');
    
    // Toggle Section Status - Fixed route
    Route::patch('/{page}/sections/{section}', [DynamicPageController::class, 'toggleSection'])->name('toggle-section');
    
    // Reorder Sections - Fixed route  
    Route::post('/{page}/reorder-sections', [DynamicPageController::class, 'reorderSections'])->name('reorder-sections');
    
    // Services Management
    Route::get('/{page}/services', [DynamicPageController::class, 'services'])->name('services.index');
    Route::post('/{page}/services', [DynamicPageController::class, 'servicesStore'])->name('services.store');
    Route::put('/{page}/services/{serviceId}', [DynamicPageController::class, 'servicesUpdate'])->name('services.update');
    Route::delete('/services/{id}', [DynamicPageController::class, 'servicesDestroy'])->name('services.destroy');
    
    // Packages Management
    Route::get('/{page}/packages', [DynamicPageController::class, 'packages'])->name('packages.index');
    Route::post('/{page}/packages', [DynamicPageController::class, 'packagesStore'])->name('packages.store');
    Route::put('/{page}/packages/{packageId}', [DynamicPageController::class, 'packagesUpdate'])->name('packages.update');
    Route::delete('/packages/{id}', [DynamicPageController::class, 'packagesDestroy'])->name('packages.destroy');
    
    // Products Management
    Route::get('/{page}/products', [DynamicPageController::class, 'products'])->name('products.index');
    Route::post('/{page}/products', [DynamicPageController::class, 'productsStore'])->name('products.store');
    Route::put('/{page}/products/{productId}', [DynamicPageController::class, 'productsUpdate'])->name('products.update');
    Route::delete('/products/{id}', [DynamicPageController::class, 'productsDestroy'])->name('products.destroy');

    // Shop Products Management
    Route::get('/{page}/shop-products', [DynamicPageController::class, 'shopProducts'])->name('shop-products.index');
    Route::post('/{page}/shop-products', [DynamicPageController::class, 'shopProductsStore'])->name('shop-products.store');
    Route::put('/{page}/shop-products/{shopProductId}', [DynamicPageController::class, 'shopProductsUpdate'])->name('shop-products.update');
    Route::delete('/shop-products/{id}', [DynamicPageController::class, 'shopProductsDestroy'])->name('shop-products.destroy');
});
    
    // Additional custom routes for occasions
    Route::post('occasions/{id}/status', [App\Http\Controllers\Admin\OccasionController::class, 'updateStatus'])
        ->name('occasions.status')
        ->where('id', '[0-9]+');
    
  Route::post('occasions/upload-file', [OccasionController::class, 'uploadFile'])
    ->name('occasions.uploadFile');
        
    Route::put('occasions/sort-order', [App\Http\Controllers\Admin\OccasionController::class, 'updateSortOrder'])
        ->name('occasions.updateSortOrder');
        
    Route::post('occasions/{id}/duplicate', [App\Http\Controllers\Admin\OccasionController::class, 'duplicate'])
        ->name('occasions.duplicate')
        ->where('id', '[0-9]+');

    // Get section data for frontend
    Route::get('occasions/section-data/{sectionType}', [App\Http\Controllers\Admin\OccasionController::class, 'getSectionData'])
        ->name('occasions.sectionData');

    // AI Settings Routes
    Route::prefix('ai')->name('ai.')->group(function () {
        Route::get('/settings', [App\Http\Controllers\Admin\AiSettingsController::class, 'index'])->name('settings');
        Route::put('/settings', [App\Http\Controllers\Admin\AiSettingsController::class, 'update'])->name('settings.update');
    });

});