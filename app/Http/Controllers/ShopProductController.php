<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\Models\ShopReview;
use Illuminate\Http\Request;

class ShopProductController extends Controller
{
    public function show(ShopProduct $product, Request $request)
    {
        if (!$product->isActive()) {
            abort(404);
        }

        // Increment view count
        $product->incrementViews();

        // Get related products from same category
        $relatedProducts = ShopProduct::active()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        // If not enough related products, get popular ones
        if ($relatedProducts->count() < 4) {
            $additionalProducts = ShopProduct::getPopularProducts(4 - $relatedProducts->count())
                ->reject(function ($p) use ($product, $relatedProducts) {
                    return $p->id === $product->id ||
                        $relatedProducts->contains('id', $p->id);
                });
            $relatedProducts = $relatedProducts->merge($additionalProducts);
        }

        // Get product reviews
        $reviews = $product->reviews()
            ->approved()
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Review statistics
        $reviewStats = [
            'average_rating' => $product->getAverageRating(),
            'total_reviews' => $product->getReviewsCount(),
            'rating_breakdown' => []
        ];

        // Calculate rating breakdown (5 star, 4 star, etc.)
        for ($i = 5; $i >= 1; $i--) {
            $count = $product->reviews()->approved()->where('rating', $i)->count();
            $percentage = $reviewStats['total_reviews'] > 0
                ? round(($count / $reviewStats['total_reviews']) * 100)
                : 0;

            $reviewStats['rating_breakdown'][$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        // Check if user can review (must have purchased and not already reviewed)
        $canReview = false;
        if (auth()->check()) {
            $hasPurchased = $product->orderItems()
                ->whereHas('order', function ($q) {
                    $q->where('user_id', auth()->id())
                        ->where('payment_status', 'paid');
                })->exists();

            $hasReviewed = $product->reviews()
                ->where('user_id', auth()->id())
                ->exists();

            $canReview = $hasPurchased && !$hasReviewed;
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'short_description' => $product->short_description,
                    'price' => $product->getPrice(),
                    'formatted_price' => $product->getFormattedPrice(),
                    'original_price' => $product->getFormattedOriginalPrice(),
                    'discount_percentage' => $product->getDiscountPercentage(),
                    'sku' => $product->sku,
                    'type' => $product->type,
                    'type_badge' => $product->getTypeBadge(),
                    'stock_status' => $product->getStockStatus(),
                    'stock_badge' => $product->getStockBadge(),
                    'featured_image' => $product->getFeaturedImageUrl(),
                    'gallery' => $product->getGalleryImages(),
                    'specifications' => $product->specifications,
                    'features' => $product->features,
                    'category' => $product->category?->name,
                    'can_purchase' => $product->canPurchase(),
                    'is_software' => $product->isSoftware(),
                    'downloadable_files' => $product->getDownloadableFiles(),
                    'download_info' => $product->isSoftware() ? [
                        'download_limit' => $product->download_limit,
                        'download_expiry_days' => $product->download_expiry_days
                    ] : null
                ],
                'review_stats' => $reviewStats,
                'can_review' => $canReview
            ]);
        }

        return view('shop.product', compact(
            'product',
            'relatedProducts',
            'reviews',
            'reviewStats',
            'canReview'
        ));
    }




    public function quickView(ShopProduct $product)
    {
        if (!$product->isActive()) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'short_description' => $product->short_description,
                'price' => $product->getPrice(),
                'formatted_price' => $product->getFormattedPrice(),
                'original_price' => $product->getFormattedOriginalPrice(),
                'discount_percentage' => $product->getDiscountPercentage(),
                'sku' => $product->sku,
                'type' => $product->type,
                'type_badge' => $product->getTypeBadge(),
                'stock_status' => $product->getStockStatus(),
                'stock_badge' => $product->getStockBadge(),
                'featured_image' => $product->getFeaturedImageUrl(),
                'gallery' => $product->getGalleryImages(),
                'category' => $product->category?->name,
                'features' => array_slice($product->features ?? [], 0, 5), // First 5 features
                'rating' => $product->getAverageRating(),
                'reviews_count' => $product->getReviewsCount(),
                'can_purchase' => $product->canPurchase(),
                'is_software' => $product->isSoftware(),
                'url' => route('shop.product', $product->slug)
            ]
        ]);
    }

    public function storeReview(Request $request, ShopProduct $product)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to leave a review'
            ], 401);
        }

        // Check if user has purchased this product
        $hasPurchased = $product->orderItems()
            ->whereHas('order', function ($q) {
                $q->where('user_id', auth()->id())
                    ->where('payment_status', 'paid');
            })->exists();

        if (!$hasPurchased) {
            return response()->json([
                'success' => false,
                'message' => 'You can only review products you have purchased'
            ], 403);
        }

        // Check if user has already reviewed
        $hasReviewed = $product->reviews()
            ->where('user_id', auth()->id())
            ->exists();

        if ($hasReviewed) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product'
            ], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|max:1000'
        ]);

        $review = $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'status' => 'pending' // Reviews need approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your review! It will be published after approval.',
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'title' => $review->title,
                'comment' => $review->comment,
                'user_name' => auth()->user()->name,
                'created_at' => $review->created_at->format('M j, Y'),
                'status' => $review->status
            ]
        ]);
    }

    public function getReviews(ShopProduct $product, Request $request)
    {
        $reviews = $product->reviews()
            ->approved()
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'reviews' => $reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'title' => $review->title,
                    'comment' => $review->comment,
                    'user_name' => $review->user->name,
                    'user_avatar' => $review->user->getAvatarUrl(),
                    'created_at' => $review->created_at->format('M j, Y'),
                    'helpful_count' => $review->helpful_count,
                    'star_rating' => $review->getStarRating()
                ];
            }),
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'total_pages' => $reviews->lastPage(),
                'total' => $reviews->total()
            ]
        ]);
    }

    public function compare(Request $request)
    {
        $productIds = $request->get('products', []);

        if (empty($productIds) || count($productIds) > 4) {
            return response()->json([
                'success' => false,
                'message' => 'Please select 2-4 products to compare'
            ]);
        }

        $products = ShopProduct::active()
            ->whereIn('id', $productIds)
            ->with(['category'])
            ->get();

        if ($products->count() !== count($productIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Some products are not available'
            ]);
        }

        return response()->json([
            'success' => true,
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->getFormattedPrice(),
                    'original_price' => $product->getFormattedOriginalPrice(),
                    'image' => $product->getFeaturedImageUrl(),
                    'category' => $product->category?->name,
                    'type' => $product->type,
                    'specifications' => $product->specifications,
                    'features' => $product->features,
                    'rating' => $product->getAverageRating(),
                    'reviews_count' => $product->getReviewsCount(),
                    'url' => route('shop.product', $product->slug)
                ];
            })
        ]);
    }
}
