<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShopProductController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopProduct::with(['category']);

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(20);
        $categories = ShopCategory::active()->ordered()->get();

        // Stats
        $stats = [
            'total' => ShopProduct::count(),
            'active' => ShopProduct::active()->count(),
            'out_of_stock' => ShopProduct::where('status', 'out_of_stock')->count(),
            'physical' => ShopProduct::physical()->count(),
            'software' => ShopProduct::software()->count(),
        ];

        return view('admin.shop.products.index', compact('products', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = ShopCategory::active()->ordered()->get();
        return view('admin.shop.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:shop_products,slug',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'currency' => 'required|string|size:3',
            'sku' => 'nullable|string|max:100|unique:shop_products,sku',
            'stock_quantity' => 'nullable|integer|min:0',
            'manage_stock' => 'boolean',
            'type' => 'required|in:physical,software',
            'category_id' => 'nullable|exists:shop_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'downloadable_files.*' => 'nullable|file|max:10240', // 10MB max
            'download_limit' => 'nullable|integer|min:-1',
            'download_expiry_days' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_popular' => 'boolean',
            'status' => 'required|in:active,inactive,out_of_stock',
            'specifications' => 'nullable|array',
            'features' => 'nullable|array',
            'tags' => 'nullable|array',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|array',
            'shipping_required' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        try {
            $data = $request->all();

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $data['featured_image'] = $request->file('featured_image')->store('shop/products', 'public');
            }

            // Handle gallery images
            if ($request->hasFile('gallery')) {
                $galleryPaths = [];
                foreach ($request->file('gallery') as $file) {
                    $galleryPaths[] = $file->store('shop/products/gallery', 'public');
                }
                $data['gallery'] = $galleryPaths;
            }

            // Handle downloadable files for software products
            if ($data['type'] === 'software' && $request->hasFile('downloadable_files')) {
                $downloadableFiles = [];
                foreach ($request->file('downloadable_files') as $file) {
                    $path = $file->store('shop/downloads', 'private');
                    $downloadableFiles[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize()
                    ];
                }
                $data['downloadable_files'] = $downloadableFiles;
            }

            // Set stock management defaults
            if ($data['type'] === 'software') {
                $data['manage_stock'] = false;
                $data['in_stock'] = true;
                $data['shipping_required'] = false;
            } else {
                $data['in_stock'] = $data['manage_stock'] ? ($data['stock_quantity'] > 0) : true;
                $data['shipping_required'] = true;
            }

            $product = ShopProduct::create($data);

            return redirect()->route('admin.shop.products.index')
                           ->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            \Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()
                           ->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    public function show(ShopProduct $product)
    {
        $product->load(['category', 'reviews.user', 'orderItems.order']);
        
        // Get product statistics
        $stats = [
            'total_sales' => $product->orderItems()->sum('quantity'),
            'total_revenue' => $product->orderItems()->sum('total'),
            'average_rating' => $product->getAverageRating(),
            'total_reviews' => $product->getReviewsCount(),
            'total_views' => $product->views_count,
        ];

        return view('admin.shop.products.show', compact('product', 'stats'));
    }

    public function edit(ShopProduct $product)
    {
        $categories = ShopCategory::active()->ordered()->get();
        return view('admin.shop.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, ShopProduct $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:shop_products,slug,' . $product->id,
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'currency' => 'required|string|size:3',
            'sku' => 'nullable|string|max:100|unique:shop_products,sku,' . $product->id,
            'stock_quantity' => 'nullable|integer|min:0',
            'manage_stock' => 'boolean',
            'type' => 'required|in:physical,software',
            'category_id' => 'nullable|exists:shop_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'downloadable_files.*' => 'nullable|file|max:10240',
            'download_limit' => 'nullable|integer|min:-1',
            'download_expiry_days' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_popular' => 'boolean',
            'status' => 'required|in:active,inactive,out_of_stock',
            'specifications' => 'nullable|array',
            'features' => 'nullable|array',
            'tags' => 'nullable|array',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|array',
            'shipping_required' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        try {
            $data = $request->all();

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                // Delete old image
                if ($product->featured_image) {
                    Storage::disk('public')->delete($product->featured_image);
                }
                $data['featured_image'] = $request->file('featured_image')->store('shop/products', 'public');
            }

            // Handle gallery images
            if ($request->hasFile('gallery')) {
                // Delete old gallery images
                if ($product->gallery) {
                    foreach ($product->gallery as $imagePath) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
                
                $galleryPaths = [];
                foreach ($request->file('gallery') as $file) {
                    $galleryPaths[] = $file->store('shop/products/gallery', 'public');
                }
                $data['gallery'] = $galleryPaths;
            }

            // Handle downloadable files
            if ($data['type'] === 'software' && $request->hasFile('downloadable_files')) {
                // Delete old files
                if ($product->downloadable_files) {
                    foreach ($product->downloadable_files as $file) {
                        if (isset($file['path'])) {
                            Storage::disk('private')->delete($file['path']);
                        }
                    }
                }
                
                $downloadableFiles = [];
                foreach ($request->file('downloadable_files') as $file) {
                    $path = $file->store('shop/downloads', 'private');
                    $downloadableFiles[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize()
                    ];
                }
                $data['downloadable_files'] = $downloadableFiles;
            }

            // Set stock management
            if ($data['type'] === 'software') {
                $data['manage_stock'] = false;
                $data['in_stock'] = true;
                $data['shipping_required'] = false;
            } else {
                $data['in_stock'] = $data['manage_stock'] ? ($data['stock_quantity'] > 0) : true;
                $data['shipping_required'] = true;
            }

            $product->update($data);

            return redirect()->route('admin.shop.products.index')
                           ->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Product update failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                           ->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    public function destroy(ShopProduct $product)
    {
        try {
            // Check if product has orders
            if ($product->orderItems()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete product with existing orders'
                ], 400);
            }

            // Delete images
            if ($product->featured_image) {
                Storage::disk('public')->delete($product->featured_image);
            }

            if ($product->gallery) {
                foreach ($product->gallery as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            // Delete downloadable files
            if ($product->downloadable_files) {
                foreach ($product->downloadable_files as $file) {
                    if (isset($file['path'])) {
                        Storage::disk('private')->delete($file['path']);
                    }
                }
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Product deletion failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product'
            ], 500);
        }
    }

public function updateStatus(Request $request, ShopProduct $product)
{
    $request->validate([
        'status' => 'required|in:active,inactive,out_of_stock'
    ]);

    try {
        $oldStatus = $product->status;
        $newStatus = $request->status;
        
        $updateData = ['status' => $newStatus];
        
        // Handle stock status changes
        if ($newStatus === 'active' && $product->manage_stock && $product->stock_quantity > 0) {
            $updateData['in_stock'] = true;
        } elseif ($newStatus === 'out_of_stock') {
            $updateData['in_stock'] = false;
        } elseif ($newStatus === 'inactive') {
            $updateData['in_stock'] = false;
        }
        
        $product->update($updateData);

        \Log::info('Product status updated', [
            'product_id' => $product->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully',
            'data' => [
                'id' => $product->id,
                'status' => $product->status,
                'in_stock' => $product->in_stock
            ]
        ]);

    } catch (\Exception $e) {
        \Log::error('Product status update failed', [
            'product_id' => $product->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to update product status: ' . $e->getMessage()
        ], 500);
    }
}

    public function duplicate(ShopProduct $product)
    {
        try {
            $newProduct = $product->replicate();
            $newProduct->name = $product->name . ' (Copy)';
            $newProduct->slug = $product->slug . '-copy-' . time();
            $newProduct->sku = $product->sku ? $product->sku . '-copy' : null;
            $newProduct->sales_count = 0;
            $newProduct->views_count = 0;
            $newProduct->save();

            return response()->json([
                'success' => true,
                'message' => 'Product duplicated successfully',
                'redirect' => route('admin.shop.products.edit', $newProduct)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to duplicate product'
            ], 500);
        }
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,mark_featured,unmark_featured',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:shop_products,id'
        ]);

        try {
            $products = ShopProduct::whereIn('id', $request->product_ids);

            switch ($request->action) {
                case 'delete':
                    // Check if any products have orders
                    $hasOrders = $products->whereHas('orderItems')->exists();
                    if ($hasOrders) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot delete products with existing orders'
                        ], 400);
                    }
                    
                    $products->delete();
                    $message = 'Products deleted successfully';
                    break;

                case 'activate':
                    $products->update(['status' => 'active']);
                    $message = 'Products activated successfully';
                    break;

                case 'deactivate':
                    $products->update(['status' => 'inactive']);
                    $message = 'Products deactivated successfully';
                    break;

                case 'mark_featured':
                    $products->update(['is_featured' => true]);
                    $message = 'Products marked as featured';
                    break;

                case 'unmark_featured':
                    $products->update(['is_featured' => false]);
                    $message = 'Products unmarked as featured';
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk action failed'
            ], 500);
        }
    }

    public function export(Request $request)
    {
        $products = ShopProduct::with(['category'])
                               ->when($request->category, fn($q) => $q->where('category_id', $request->category))
                               ->when($request->status, fn($q) => $q->where('status', $request->status))
                               ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'ID', 'Name', 'SKU', 'Category', 'Type', 'Price', 'Sale Price', 
                'Stock', 'Status', 'Featured', 'Created At'
            ]);

            // Data
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->category?->name,
                    $product->type,
                    $product->price,
                    $product->sale_price,
                    $product->stock_quantity,
                    $product->status,
                    $product->is_featured ? 'Yes' : 'No',
                    $product->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function analytics()
    {
        // Top selling products
        $topSelling = ShopProduct::withSum('orderItems', 'quantity')
                                 ->orderBy('order_items_sum_quantity', 'desc')
                                 ->limit(10)
                                 ->get();

        // Revenue by product
        $topRevenue = ShopProduct::withSum('orderItems', 'total')
                                 ->orderBy('order_items_sum_total', 'desc')
                                 ->limit(10)
                                 ->get();

        // Low stock products
        $lowStock = ShopProduct::where('manage_stock', true)
                              ->where('stock_quantity', '<=', 5)
                              ->where('stock_quantity', '>', 0)
                              ->orderBy('stock_quantity', 'asc')
                              ->get();

        // Out of stock products
        $outOfStock = ShopProduct::where('status', 'out_of_stock')
                                ->orWhere(function($q) {
                                    $q->where('manage_stock', true)
                                      ->where('stock_quantity', 0);
                                })->get();

        return view('admin.shop.products.analytics', compact(
            'topSelling', 'topRevenue', 'lowStock', 'outOfStock'
        ));
    }
}