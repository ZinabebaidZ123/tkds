<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\ShopSetting;

class ShopSettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'shop_name' => ShopSetting::get('shop.name', 'TKDS Media Shop'),
            'shop_description' => ShopSetting::get('shop.description', 'Your Digital Products Store'),
            'shop_email' => ShopSetting::get('shop.email', 'shop@tkdsmedia.com'),
            'shop_phone' => ShopSetting::get('shop.phone', '+1234567890'),
            'shop_address' => ShopSetting::get('shop.address', ''),
            'default_currency' => ShopSetting::get('shop.currency', 'USD'),
            'tax_rate' => ShopSetting::get('shop.tax_rate', 0),
            'shipping_enabled' => ShopSetting::get('shop.shipping_enabled', true),
            'digital_products_enabled' => ShopSetting::get('shop.digital_products_enabled', true),
            'reviews_enabled' => ShopSetting::get('shop.reviews_enabled', true),
            'auto_approve_reviews' => ShopSetting::get('shop.auto_approve_reviews', false),
            'inventory_tracking' => ShopSetting::get('shop.inventory_tracking', true),
            'low_stock_threshold' => ShopSetting::get('shop.low_stock_threshold', 5),
            'terms_url' => ShopSetting::get('shop.terms_url', ''),
            'privacy_url' => ShopSetting::get('shop.privacy_url', ''),
            'return_policy_url' => ShopSetting::get('shop.return_policy_url', ''),
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
            DB::beginTransaction();

            // حفظ الإعدادات
            ShopSetting::set('shop.name', $request->input('shop_name'));
            ShopSetting::set('shop.description', $request->input('shop_description'));
            ShopSetting::set('shop.email', $request->input('shop_email'));
            ShopSetting::set('shop.phone', $request->input('shop_phone'));
            ShopSetting::set('shop.address', $request->input('shop_address'));
            ShopSetting::set('shop.currency', $request->input('default_currency'));
            ShopSetting::set('shop.tax_rate', $request->input('tax_rate', 0));
            ShopSetting::set('shop.shipping_enabled', $request->boolean('shipping_enabled'));
            ShopSetting::set('shop.digital_products_enabled', $request->boolean('digital_products_enabled'));
            ShopSetting::set('shop.reviews_enabled', $request->boolean('reviews_enabled'));
            ShopSetting::set('shop.auto_approve_reviews', $request->boolean('auto_approve_reviews'));
            ShopSetting::set('shop.inventory_tracking', $request->boolean('inventory_tracking'));
            ShopSetting::set('shop.low_stock_threshold', $request->input('low_stock_threshold', 5));
            ShopSetting::set('shop.terms_url', $request->input('terms_url'));
            ShopSetting::set('shop.privacy_url', $request->input('privacy_url'));
            ShopSetting::set('shop.return_policy_url', $request->input('return_policy_url'));

            DB::commit();

            // مسح الكاش
            ShopSetting::clearCache();

            \Log::info('Shop settings updated successfully', [
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.shop.settings.index')
                           ->with('success', 'Shop settings updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Shop settings update failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return redirect()->back()
                           ->withErrors(['error' => 'Failed to update settings: ' . $e->getMessage()])
                           ->withInput();
        }
    }
}