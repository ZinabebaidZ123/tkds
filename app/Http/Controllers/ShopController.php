<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Get categories for filtering
        $categories = ShopCategory::active()->ordered()->get();

        // Build query for products
        $query = ShopProduct::with(['category'])
            ->active()
            ->inStock();

        // Apply category filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply type filter (physical/software)
        if ($request->filled('type')) {
            if ($request->type === 'physical') {
                $query->physical();
            } elseif ($request->type === 'software') {
                $query->software();
            }
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'price-low':
                $query->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END ASC');
                break;
            case 'price-high':
                $query->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END DESC');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc')
                    ->orderBy('views_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('created_at', 'desc'); // You can implement rating sorting later
                break;
            default: // featured
                $query->orderBy('is_featured', 'desc')
                    ->orderBy('sort_order', 'asc')
                    ->orderBy('created_at', 'desc');
                break;
        }

        // Paginate results
        $products = $query->paginate(12)->appends($request->query());

        // Get featured products for sidebar/recommendations
        $featuredProducts = ShopProduct::getFeaturedProducts(6);

        // Get popular products
        $popularProducts = ShopProduct::getPopularProducts(4);

        // Stats for display
        $stats = [
            'total_products' => ShopProduct::active()->inStock()->count(),
            'categories_count' => ShopCategory::active()->count(),
            'physical_count' => ShopProduct::active()->inStock()->physical()->count(),
            'software_count' => ShopProduct::active()->inStock()->software()->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'products' => $products,
                'stats' => $stats,
                'html' => view('shop.partials.product-grid', compact('products'))->render(),
                'pagination' => $products->links()->render()
            ]);
        }

        return view('shop.index', compact(
            'products',
            'categories',
            'featuredProducts',
            'popularProducts',
            'stats'
        ));
    }

    public function category(ShopCategory $category, Request $request)
    {
        if (!$category->isActive()) {
            abort(404);
        }

        // Build query for products in this category
        $query = ShopProduct::with(['category'])
            ->active()
            ->inStock()
            ->where('category_id', $category->id);

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply type filter
        if ($request->filled('type')) {
            if ($request->type === 'physical') {
                $query->physical();
            } elseif ($request->type === 'software') {
                $query->software();
            }
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'price-low':
                $query->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END ASC');
                break;
            case 'price-high':
                $query->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END DESC');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc')
                    ->orderBy('views_count', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')
                    ->orderBy('sort_order', 'asc')
                    ->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->appends($request->query());

        // Get other categories for navigation
        $categories = ShopCategory::active()->ordered()->get();

        // Get related products from same category - FIX THE ISSUE HERE
        $relatedProducts = ShopProduct::active()
            ->inStock()
            ->where('category_id', $category->id)
            ->where('id', '!=', $products->pluck('id')->toArray()) // Convert collection to array
            ->orderBy('sales_count', 'desc')
            ->orderBy('views_count', 'desc')
            ->limit(4)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'products' => $products,
                'html' => view('shop.partials.product-grid', compact('products'))->render(),
                'pagination' => $products->links()->render()
            ]);
        }

        return view('shop.category', compact('category', 'products', 'categories', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search term must be at least 2 characters'
                ]);
            }

            // Redirect back with error for regular requests
            return redirect()->route('shop.index')->with('error', 'Search term must be at least 2 characters');
        }

        // Search products
        $products = ShopProduct::active()
            ->inStock()
            ->search($query)
            ->with(['category'])
            ->paginate(12);

        // Search categories for sidebar
        $categories = ShopCategory::active()
            ->where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        // Get all categories for filter
        $allCategories = ShopCategory::active()->ordered()->get();

        // Get featured products for sidebar
        $featuredProducts = ShopProduct::getFeaturedProducts(6);

        // Get popular products
        $popularProducts = ShopProduct::getPopularProducts(4);

        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'products' => $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'price' => $product->getFormattedPrice(),
                        'image' => $product->getFeaturedImageUrl(),
                        'category' => $product->category?->name,
                        'type' => $product->type,
                        'url' => route('shop.product', $product->slug)
                    ];
                }),
                'categories' => $categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'products_count' => $category->getProductsCount(),
                        'url' => route('shop.category', $category->slug)
                    ];
                }),
                'total_found' => $products->total(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'total_pages' => $products->lastPage(),
                    'total' => $products->total()
                ]
            ]);
        }

        // For regular requests, return the search view
        return view('shop.search', compact(
            'products',
            'categories',
            'allCategories',
            'featuredProducts',
            'popularProducts',
            'query'
        ));
    }


    public function api(Request $request)
    {
        $query = ShopProduct::with(['category'])
            ->active()
            ->inStock();

        // Apply filters
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('type')) {
            if ($request->type === 'physical') {
                $query->physical();
            } elseif ($request->type === 'software') {
                $query->software();
            }
        }

        if ($request->filled('featured')) {
            $query->featured();
        }

        if ($request->filled('popular')) {
            $query->orderBy('sales_count', 'desc');
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'price-low':
                $query->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END ASC');
                break;
            case 'price-high':
                $query->orderByRaw('CASE WHEN sale_price > 0 THEN sale_price ELSE price END DESC');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('sales_count', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')
                    ->orderBy('sort_order', 'asc');
                break;
        }

        $products = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'short_description' => $product->short_description,
                    'price' => $product->getPrice(),
                    'formatted_price' => $product->getFormattedPrice(),
                    'original_price' => $product->getFormattedOriginalPrice(),
                    'discount_percentage' => $product->getDiscountPercentage(),
                    'image' => $product->getFeaturedImageUrl(),
                    'gallery' => $product->getGalleryImages(),
                    'category' => $product->category?->name,
                    'type' => $product->type,
                    'type_badge' => $product->getTypeBadge(),
                    'stock_badge' => $product->getStockBadge(),
                    'is_featured' => $product->is_featured,
                    'is_popular' => $product->is_popular,
                    'rating' => $product->getAverageRating(),
                    'reviews_count' => $product->getReviewsCount(),
                    'can_purchase' => $product->canPurchase(),
                    'url' => route('shop.product', $product->slug)
                ];
            }),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'total_pages' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem()
            ]
        ]);
    }
}
