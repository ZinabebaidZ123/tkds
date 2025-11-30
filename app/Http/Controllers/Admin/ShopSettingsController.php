<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopSettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'shop_name' => config('shop.name', 'TKDS Media Shop'),
            'shop_description' => config('shop.description', 'Your Digital Products Store'),
            'shop_email' => config('shop.email', 'shop@tkdsmedia.com'),
            'shop_phone' => config('shop.phone', '+1234567890'),
            'shop_address' => config('shop.address', ''),
            'default_currency' => config('shop.currency', 'USD'),
            'tax_rate' => config('shop.tax_rate', 0),
            'shipping_enabled' => config('shop.shipping_enabled', true),
            'digital_products_enabled' => config('shop.digital_products_enabled', true),
            'reviews_enabled' => config('shop.reviews_enabled', true),
            'auto_approve_reviews' => config('shop.auto_approve_reviews', false),
            'inventory_tracking' => config('shop.inventory_tracking', true),
            'low_stock_threshold' => config('shop.low_stock_threshold', 5),
            'terms_url' => config('shop.terms_url', ''),
            'privacy_url' => config('shop.privacy_url', ''),
            'return_policy_url' => config('shop.return_policy_url', ''),
        ];

        return view('admin.shop.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_description' => 'nullable|string|max:500',
            'shop_email' => 'required|email|max:255',
            'shop_phone' => 'nullable|string|max:50',
            'shop_address' => 'nullable|string|max:500',
            'default_currency' => 'required|string|size:3',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'shipping_enabled' => 'boolean',
            'digital_products_enabled' => 'boolean',
            'reviews_enabled' => 'boolean',
            'auto_approve_reviews' => 'boolean',
            'inventory_tracking' => 'boolean',
            'low_stock_threshold' => 'nullable|integer|min:1',
            'terms_url' => 'nullable|url',
            'privacy_url' => 'nullable|url',
            'return_policy_url' => 'nullable|url',
        ]);

        try {
            // Save settings to .env or database
            $settings = $request->only([
                'shop_name', 'shop_description', 'shop_email', 'shop_phone',
                'shop_address', 'default_currency', 'tax_rate', 'shipping_enabled',
                'digital_products_enabled', 'reviews_enabled', 'auto_approve_reviews',
                'inventory_tracking', 'low_stock_threshold', 'terms_url',
                'privacy_url', 'return_policy_url'
            ]);

            // Clear cache
            Cache::forget('shop_settings');

            return redirect()->route('admin.shop.settings.index')
                           ->with('success', 'Shop settings updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Shop settings update failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                           ->withErrors(['error' => 'Failed to update settings: ' . $e->getMessage()])
                           ->withInput();
        }
    }
}