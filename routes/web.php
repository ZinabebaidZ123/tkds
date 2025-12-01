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
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OccasionFrontendController;

//  User 
use App\Http\Controllers\Auth\AuthController as UserAuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Models\UserProfile;



// ===================== MAIN PAGES =====================
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/services', function () {
    $services = \App\Models\Service::active()->ordered()->get();
    return view('services', compact('services'));
})->name('services');



Route::get('/about', function () {
    return view('about');
})->name('about');

// ✅ FIXED: Remove this duplicate route - shop is handled in SHOP FRONTEND ROUTES section
// Route::get('/shop', function () {
//     return view('shop');
// })->name('shop');

// ===================== PRICING & SUBSCRIPTION ROUTES =====================

// Public Pricing Routes (No Auth Required)
Route::get('/pricing', [App\Http\Controllers\PricingController::class, 'index'])->name('pricing');
Route::get('/pricing/{pricingPlan:slug}', [App\Http\Controllers\PricingController::class, 'show'])->name('pricing.show');
Route::get('/pricing/api', [App\Http\Controllers\PricingController::class, 'getPlansApi'])->name('pricing.api');

// Stripe Webhook Route (No middleware - Stripe needs direct access)
Route::post('/stripe/webhook', [App\Http\Controllers\StripeWebhookController::class, 'handle'])->name('stripe.webhook');

// Guest/Public Subscription Routes (Allow access before login)
Route::prefix('subscription')->name('subscription.')->group(function () {
    // ✅ These routes are accessible to guests (will redirect to login if needed)
    Route::get('/create/{pricingPlan:slug}', [App\Http\Controllers\SubscriptionController::class, 'create'])->name('create');
    Route::get('/success', [App\Http\Controllers\SubscriptionController::class, 'success'])->name('success');
});

// ===================== CONTACT ROUTES =====================
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/settings', [ContactController::class, 'getSettings'])->name('contact.settings.api');
Route::get('/contact/status', [ContactController::class, 'status'])->name('contact.status');
Route::post('/contact/ajax', [ContactController::class, 'ajaxStore'])->name('contact.ajax');
// ===================== SERVICE CONTACT ROUTES =====================
Route::post('/service/contact/send', [App\Http\Controllers\ServiceContactController::class, 'send'])
    ->name('service.contact.send');

Route::get('/service/contact/items', [App\Http\Controllers\ServiceContactController::class, 'getItems'])
    ->name('service.contact.items');

// ===================== AI CHAT ROUTES =====================
Route::get('/ai/chat', [App\Http\Controllers\AiController::class, 'showChat'])->name('ai.chat');
Route::post('/ai/chat', [App\Http\Controllers\AiController::class, 'chatWithAi'])->name('ai.chat.send');
Route::post('/ai/contact', [App\Http\Controllers\AiController::class, 'submitContactInfo'])->name('ai.contact');

// ===================== BLOG ROUTES =====================
Route::get('/blog/api', [BlogController::class, 'api'])->name('blog.api');
Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');
Route::post('/blog/post/{post}/like', [BlogController::class, 'like'])->name('blog.post.like')->where('post', '[0-9]+');
Route::post('/blog/post/{post}/share', [BlogController::class, 'share'])->name('blog.post.share')->where('post', '[0-9]+');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('tag');
    Route::get('/author/{author:slug}', [BlogController::class, 'author'])->name('author');
    Route::get('/{post:slug}', [BlogController::class, 'show'])->name('show');
});

// ===================== PRODUCTS ROUTES =====================
Route::get('/products', function () {
    $products = \App\Models\Product::active()->showInHomepage()->ordered()->get();
    return view('products', compact('products'));
})->name('products');

// ===================== LEGAL PAGES =====================
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');

Route::get('/cookie-policy', function () {
    return view('cookie-policy');
})->name('cookie-policy');

// ===================== SHOP FRONTEND ROUTES =====================
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [App\Http\Controllers\ShopController::class, 'index'])->name('index');
    
    // Category pages
    Route::get('/category/{category:slug}', [App\Http\Controllers\ShopController::class, 'category'])->name('category');
    
    // Product pages
    Route::get('/product/{product:slug}', [App\Http\Controllers\ShopProductController::class, 'show'])->name('product');
    Route::get('/product/{product:slug}/quick-view', [App\Http\Controllers\ShopProductController::class, 'quickView'])->name('product.quick-view');
    Route::post('/product/{product:slug}/review', [App\Http\Controllers\ShopProductController::class, 'storeReview'])->name('product.review');
    Route::get('/product/{product:slug}/reviews', [App\Http\Controllers\ShopProductController::class, 'getReviews'])->name('product.reviews');
    Route::post('/products/compare', [App\Http\Controllers\ShopProductController::class, 'compare'])->name('products.compare');
    
    // Search
    Route::get('/search', [App\Http\Controllers\ShopController::class, 'search'])->name('search');
    Route::get('/api', [App\Http\Controllers\ShopController::class, 'api'])->name('api');
    
    // Cart routes (guest + auth)
    Route::post('/cart/add', [App\Http\Controllers\ShopCartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update', [App\Http\Controllers\ShopCartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [App\Http\Controllers\ShopCartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [App\Http\Controllers\ShopCartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart', [App\Http\Controllers\ShopCartController::class, 'index'])->name('cart');
    Route::get('/cart/count', [App\Http\Controllers\ShopCartController::class, 'count'])->name('cart.count');
    Route::get('/cart/items', [App\Http\Controllers\ShopCartController::class, 'items'])->name('cart.items');
    
    // Checkout routes (require auth)
    Route::middleware(['auth'])->group(function () {
        Route::get('/checkout', [App\Http\Controllers\ShopCheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout/process', [App\Http\Controllers\ShopCheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/checkout/success', [App\Http\Controllers\ShopCheckoutController::class, 'success'])->name('checkout.success');
        Route::get('/checkout/cancel', [App\Http\Controllers\ShopCheckoutController::class, 'cancel'])->name('checkout.cancel');
    });
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/download/{token}', [App\Http\Controllers\ShopDownloadController::class, 'download'])->name('download');
        Route::get('/download/{token}/preview', [App\Http\Controllers\ShopDownloadController::class, 'preview'])->name('download.preview');
        Route::post('/download/resend', [App\Http\Controllers\ShopDownloadController::class, 'resendDownloadLink'])->name('download.resend');
                Route::get('/download/{download}/preview', [App\Http\Controllers\ShopDownloadController::class, 'preview'])->name('download.info');
    });

    // Add these routes to your web.php for testing email functionality

// Test routes (add these temporarily)
Route::prefix('test')->group(function () {
    Route::get('/email/send', [App\Http\Controllers\TestEmailController::class, 'testEmail'])->name('test.email.send');
    Route::get('/email/config', [App\Http\Controllers\TestEmailController::class, 'checkEmailConfig'])->name('test.email.config');
    Route::get('/services/emails', [App\Http\Controllers\TestEmailController::class, 'checkServiceEmails'])->name('test.services.emails');
});
});


// ===================== DYNAMIC ROUTES - MUST BE LAST =====================
Route::get('/services/{service:slug}', function (\App\Models\Service $service) {
    if (!$service->isActive()) {
        abort(404);
    }
    return view('services.show', compact('service'));
})->name('services.show');

Route::get('/products/{product:slug}', function (\App\Models\Product $product) {
    if (!$product->isActive()) {
        abort(404);
    }
    return view('products.show', compact('product'));
})->name('products.show');


// Newsletter Frontend Routes
Route::prefix('newsletter')->name('newsletter.')->group(function () {
    Route::post('/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('subscribe');
    Route::post('/unsubscribe', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('unsubscribe');
    Route::get('/unsubscribe/{email}', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('unsubscribe.get');
});

Route::get('/test-email-spam-prevention/{email}', function($email) {
    return app(ServiceContactController::class)->testDelivery(request(['email' => $email, 'test_type' => 'basic']));
});


// ===================== HELPER FUNCTIONS =====================

// Helper function for profile completion calculation
if (!function_exists('calculateProfileCompletion')) {
    function calculateProfileCompletion($user): int
    {
        $fields = [
            'name' => !empty($user->name),
            'email' => !empty($user->email),
            'phone' => !empty($user->phone),
            'avatar' => !empty($user->avatar),
            'date_of_birth' => !empty($user->date_of_birth),
            'bio' => !empty($user->profile?->bio),
            'location' => !empty($user->profile?->location),
            'website' => !empty($user->profile?->website),
        ];

        $completed = array_sum($fields);
        $total = count($fields);

        return round(($completed / $total) * 100);
    }

    
}
Route::prefix('debug')->name('debug.')->group(function () {
    
    Route::get('/service-emails', function() {
        $services = DB::table('services')->select('id', 'title', 'contact_email')->get();
        return response()->json([
            'count' => $services->count(),
            'services' => $services,
            'with_emails' => $services->whereNotNull('contact_email')->where('contact_email', '!=', '')->values()
        ]);
    });

    Route::get('/product-emails', function() {
        $products = DB::table('products')->select('id', 'title', 'name', 'contact_email')->get();
        return response()->json([
            'count' => $products->count(),
            'products' => $products,
            'with_emails' => $products->whereNotNull('contact_email')->where('contact_email', '!=', '')->values()
        ]);
    });

    Route::get('/test-update/{service_id}/{email?}', function($service_id, $email = 'test@example.com') {
        try {
            $before = DB::table('services')->where('id', $service_id)->value('contact_email');
            
            $updated = DB::table('services')
                ->where('id', $service_id)
                ->update(['contact_email' => $email]);
                
            $after = DB::table('services')->where('id', $service_id)->value('contact_email');
            
            return response()->json([
                'service_id' => $service_id,
                'before' => $before,
                'after' => $after,
                'rows_affected' => $updated,
                'success' => $updated > 0 && $after === $email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'service_id' => $service_id
            ]);
        }
    });

    Route::get('/table-structure', function() {
        try {
            $servicesColumns = Schema::getColumnListing('services');
            $productsColumns = Schema::getColumnListing('products');
            
            return response()->json([
                'services_columns' => $servicesColumns,
                'products_columns' => $productsColumns,
                'services_has_contact_email' => in_array('contact_email', $servicesColumns),
                'products_has_contact_email' => in_array('contact_email', $productsColumns)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    });
}); 




Route::prefix('occasions')->name('occasions.')->group(function () {
    Route::get('section/{sectionType}', [App\Http\Controllers\OccasionFrontendController::class, 'getSection'])
        ->name('section');
    Route::get('countdown', [App\Http\Controllers\OccasionFrontendController::class, 'getCountdown'])
        ->name('countdown');
    Route::post('contact', [App\Http\Controllers\OccasionFrontendController::class, 'contactSubmit'])
        ->name('contact');
    Route::get('test-db', [App\Http\Controllers\OccasionFrontendController::class, 'testDatabase'])
        ->name('test.db');
});

Route::get('/test-occasions-simple', function () {
    $viewPath = resource_path('views/occasions.blade.php');
    $viewExists = file_exists($viewPath);
    
    try {
        $controller = new \App\Http\Controllers\OccasionFrontendController();
        $controllerExists = true;
    } catch (\Exception $e) {
        $controllerExists = false;
    }
    
    try {
        return view('occasions', [
            'sections' => collect([]),
            'groupedSections' => collect([]),
            'stats' => ['clients_count' => 0, 'uptime' => '0', 'partners_count' => 0, 'datacenters' => 0]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'View Test Failed',
            'message' => $e->getMessage(),
            'view_path' => $viewPath,
            'view_exists' => $viewExists,
            'controller_exists' => $controllerExists
        ]);
    }
});


Route::get('/test-occasions-simple', function () {
    // اختبار 1: هل البليد موجود؟
    $viewPath = resource_path('views/occasions.blade.php');
    $viewExists = file_exists($viewPath);
    
    // اختبار 2: هل الكنترولر يعمل؟
    try {
        $controller = new \App\Http\Controllers\OccasionFrontendController();
        $controllerExists = true;
    } catch (\Exception $e) {
        $controllerExists = false;
    }
    
    try {
        return view('occasions', [
            'sections' => collect([]),
            'groupedSections' => collect([]),
            'stats' => ['clients_count' => 0, 'uptime' => '0', 'partners_count' => 0, 'datacenters' => 0]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'View Test Failed',
            'message' => $e->getMessage(),
            'view_path' => $viewPath,
            'view_exists' => $viewExists,
            'controller_exists' => $controllerExists,
            'trace' => $e->getTraceAsString()
        ]);
    }
});



Route::get('/special-occasions', [App\Http\Controllers\OccasionFrontendController::class, 'index'])
    ->name('occasions');
