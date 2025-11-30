<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController as UserAuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;


// ===================== USER AUTHENTICATION ROUTES =====================

// Guest Routes (Only for non-authenticated users)
Route::middleware(['guest'])->group(function () {
    // Registration Routes
    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [UserAuthController::class, 'register']);

    // Login Routes  
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [UserAuthController::class, 'login']);
});

// ===================== AUTHENTICATED USER ROUTES =====================

Route::middleware(['auth'])->group(function () {
    // Logout Route
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('auth.logout');

    // ✅ PROTECTED SUBSCRIPTION ROUTES (Require Authentication)
    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::post('/store', [App\Http\Controllers\SubscriptionController::class, 'store'])->name('store');
        Route::get('/cancel', [App\Http\Controllers\SubscriptionController::class, 'cancel'])->name('cancel');
        Route::post('/cancel', [App\Http\Controllers\SubscriptionController::class, 'processCancel'])->name('process-cancel');
        Route::post('/resume', [App\Http\Controllers\SubscriptionController::class, 'resume'])->name('resume');
        Route::post('/change-plan', [App\Http\Controllers\SubscriptionController::class, 'changePlan'])->name('change-plan');
        Route::get('/data', [App\Http\Controllers\SubscriptionController::class, 'getSubscriptionData'])->name('data');
    });

   // ✅ FIXED: User Dashboard Routes with correct naming
    Route::prefix('dashboard')->name('user.')->group(function () {
        // Main Dashboard
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');

        // Profile Management
        Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
        Route::put('/profile/personal', [UserProfileController::class, 'updatePersonal'])->name('profile.personal');
        Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');

        // ✅ FIXED: SUBSCRIPTION MANAGEMENT INSIDE DASHBOARD
        Route::get('/subscription', [App\Http\Controllers\SubscriptionController::class, 'show'])->name('subscription');
        Route::get('/subscription/manage', [App\Http\Controllers\SubscriptionController::class, 'show'])->name('subscription.show');
        Route::get('/subscription/{subscription}/invoice/{invoiceId}', [App\Http\Controllers\SubscriptionController::class, 'invoice'])->name('subscription.invoice');

        // Billing Information Management
        Route::post('/profile/billing', [UserProfileController::class, 'storeBilling'])->name('profile.billing.store');
        Route::put('/profile/billing/{billing}', [UserProfileController::class, 'updateBilling'])->name('profile.billing.update');
        Route::delete('/profile/billing/{billing}', [UserProfileController::class, 'deleteBilling'])->name('profile.billing.delete');

        // Shipping Information Management
        Route::post('/profile/shipping', [UserProfileController::class, 'storeShipping'])->name('profile.shipping.store');
        Route::put('/profile/shipping/{shipping}', [UserProfileController::class, 'updateShipping'])->name('profile.shipping.update');
        Route::delete('/profile/shipping/{shipping}', [UserProfileController::class, 'deleteShipping'])->name('profile.shipping.delete');

        // Session Management
        Route::get('/sessions', [UserProfileController::class, 'sessions'])->name('sessions');
        Route::delete('/sessions/{sessionId}', [UserProfileController::class, 'terminateSession'])->name('sessions.terminate');

        // Account Deletion
        Route::delete('/account', [UserProfileController::class, 'deleteAccount'])->name('account.delete');

        // AJAX Routes for Dashboard
        Route::get('/stats', function () {
            $user = Auth::user()->load(['profile', 'billingInfo', 'shippingInfo']);

            $stats = [
                'profile_completion' => calculateProfileCompletion($user),
                'total_logins' => $user->sessions()->count(),
                'billing_addresses' => $user->billingInfo()->count(),
                'shipping_addresses' => $user->shippingInfo()->count(),
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        })->name('dashboard.stats');
    });

    // ✅ FIXED: User Shop Orders Management Routes - MOVED OUTSIDE dashboard prefix
    Route::prefix('user')->name('user.')->group(function () {
        // Orders Management Routes
        Route::get('/orders', [App\Http\Controllers\User\ShopOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [App\Http\Controllers\User\ShopOrderController::class, 'show'])->name('orders.show')->where('order', '[0-9]+');
        Route::post('/orders/{order}/cancel', [App\Http\Controllers\User\ShopOrderController::class, 'cancel'])->name('orders.cancel')->where('order', '[0-9]+');
        Route::post('/orders/{order}/reorder', [App\Http\Controllers\User\ShopOrderController::class, 'reorder'])->name('orders.reorder')->where('order', '[0-9]+');
        Route::get('/orders/{order}/invoice', [App\Http\Controllers\User\ShopOrderController::class, 'downloadInvoice'])->name('orders.invoice')->where('order', '[0-9]+');
        Route::get('/orders/{order}/track', [App\Http\Controllers\User\ShopOrderController::class, 'trackOrder'])->name('orders.track')->where('order', '[0-9]+');
        Route::post('/orders/{order}/return', [App\Http\Controllers\User\ShopOrderController::class, 'requestReturn'])->name('orders.return')->where('order', '[0-9]+');
        Route::post('/orders/{order}/review', [App\Http\Controllers\User\ShopOrderController::class, 'leaveReview'])->name('orders.review')->where('order', '[0-9]+');
        
        // Downloads Management
        Route::get('/downloads', [App\Http\Controllers\ShopDownloadController::class, 'userDownloads'])->name('downloads');
        Route::get('/downloads/api', [App\Http\Controllers\ShopDownloadController::class, 'userDownloadsApi'])->name('downloads.api');
    });
});