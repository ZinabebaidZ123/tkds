<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use Illuminate\Http\Request;

class ShopInventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopProduct::with(['category'])
                           ->where('type', 'physical')
                           ->where('manage_stock', true);

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by stock level
        if ($request->filled('stock_level')) {
            switch ($request->stock_level) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 5);
                    break;
                case 'low_stock':
                    $query->where('stock_quantity', '<=', 5)
                          ->where('stock_quantity', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', 0);
                    break;
            }
        }

        $products = $query->orderBy('stock_quantity', 'asc')->paginate(20);

        // Stats
        $stats = [
            'total_products' => ShopProduct::physical()->where('manage_stock', true)->count(),
            'in_stock' => ShopProduct::physical()->where('manage_stock', true)->where('stock_quantity', '>', 5)->count(),
            'low_stock' => ShopProduct::physical()->where('manage_stock', true)->where('stock_quantity', '<=', 5)->where('stock_quantity', '>', 0)->count(),
            'out_of_stock' => ShopProduct::physical()->where('manage_stock', true)->where('stock_quantity', 0)->count(),
            'total_value' => ShopProduct::physical()->where('manage_stock', true)->sum(\DB::raw('price * stock_quantity')),
        ];

        return view('admin.shop.inventory.index', compact('products', 'stats'));
    }

    public function lowStock()
    {
        $products = ShopProduct::with(['category'])
                              ->where('type', 'physical')
                              ->where('manage_stock', true)
                              ->where('stock_quantity', '<=', 5)
                              ->where('stock_quantity', '>', 0)
                              ->orderBy('stock_quantity', 'asc')
                              ->paginate(20);

        return view('admin.shop.inventory.low-stock', compact('products'));
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'updates' => 'required|array',
            'updates.*.product_id' => 'required|exists:shop_products,id',
            'updates.*.stock_quantity' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->updates as $update) {
                $product = ShopProduct::find($update['product_id']);
                
                if ($product && $product->manage_stock) {
                    $product->update([
                        'stock_quantity' => $update['stock_quantity'],
                        'in_stock' => $update['stock_quantity'] > 0,
                        'status' => $update['stock_quantity'] > 0 ? 'active' : 'out_of_stock'
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Inventory updated successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Bulk inventory update failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update inventory'
            ], 500);
        }
    }
}