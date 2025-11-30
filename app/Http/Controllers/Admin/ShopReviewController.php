<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopReview;
use App\Models\ShopProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopReview::with(['product', 'user', 'order']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('comment', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQ) use ($request) {
                      $userQ->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('product', function($productQ) use ($request) {
                      $productQ->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $reviews = $query->paginate(20);
        $products = ShopProduct::where('status', 'active')->orderBy('name')->get();

        // Stats
        $stats = [
            'total' => ShopReview::count(),
            'pending' => ShopReview::where('status', 'pending')->count(),
            'approved' => ShopReview::where('status', 'approved')->count(),
            'rejected' => ShopReview::where('status', 'rejected')->count(),
            'average_rating' => round(ShopReview::where('status', 'approved')->avg('rating'), 1),
            'five_star' => ShopReview::where('status', 'approved')->where('rating', 5)->count(),
            'four_star' => ShopReview::where('status', 'approved')->where('rating', 4)->count(),
            'three_star' => ShopReview::where('status', 'approved')->where('rating', 3)->count(),
            'two_star' => ShopReview::where('status', 'approved')->where('rating', 2)->count(),
            'one_star' => ShopReview::where('status', 'approved')->where('rating', 1)->count(),
        ];

        return view('admin.shop.reviews.index', compact('reviews', 'products', 'stats'));
    }

    public function show(ShopReview $review)
    {
        $review->load(['product', 'user', 'order']);
        
        // Get other reviews by the same user
        $userReviews = ShopReview::where('user_id', $review->user_id)
                                ->where('id', '!=', $review->id)
                                ->with('product')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();

        // Get other reviews for the same product
        $productReviews = ShopReview::where('product_id', $review->product_id)
                                   ->where('id', '!=', $review->id)
                                   ->with('user')
                                   ->where('status', 'approved')
                                   ->orderBy('created_at', 'desc')
                                   ->limit(5)
                                   ->get();

        return view('admin.shop.reviews.show', compact('review', 'userReviews', 'productReviews'));
    }

    public function updateStatus(Request $request, ShopReview $review)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        try {
            $updateData = ['status' => $request->status];
            
            if ($request->admin_notes) {
                $updateData['admin_notes'] = $request->admin_notes;
            }

            $review->update($updateData);

            // Send notification to user if review is approved or rejected
            if (in_array($request->status, ['approved', 'rejected'])) {
                // Mail::to($review->user->email)->send(new ReviewStatusUpdatedMail($review));
            }

            $message = match($request->status) {
                'approved' => 'Review approved successfully',
                'rejected' => 'Review rejected successfully',
                'pending' => 'Review marked as pending',
            };

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            \Log::error('Review status update failed', [
                'review_id' => $review->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update review status'
            ], 500);
        }
    }

    public function destroy(ShopReview $review)
    {
        try {
            $review->delete();

            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Review deletion failed', [
                'review_id' => $review->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete review'
            ], 500);
        }
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete,mark_pending',
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:shop_reviews,id'
        ]);

        try {
            $reviews = ShopReview::whereIn('id', $request->review_ids);

            switch ($request->action) {
                case 'approve':
                    $reviews->update(['status' => 'approved']);
                    $message = 'Reviews approved successfully';
                    break;

                case 'reject':
                    $reviews->update(['status' => 'rejected']);
                    $message = 'Reviews rejected successfully';
                    break;

                case 'delete':
                    $reviews->delete();
                    $message = 'Reviews deleted successfully';
                    break;

                case 'mark_pending':
                    $reviews->update(['status' => 'pending']);
                    $message = 'Reviews marked as pending';
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
        $reviews = ShopReview::with(['product', 'user'])
                            ->when($request->status, fn($q) => $q->where('status', $request->status))
                            ->when($request->rating, fn($q) => $q->where('rating', $request->rating))
                            ->when($request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
                            ->when($request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
                            ->orderBy('created_at', 'desc')
                            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reviews-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($reviews) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'ID', 'Product', 'Customer', 'Email', 'Rating', 'Title', 
                'Comment', 'Status', 'Created At'
            ]);

            // Data
            foreach ($reviews as $review) {
                fputcsv($file, [
                    $review->id,
                    $review->product->name,
                    $review->user->name,
                    $review->user->email,
                    $review->rating,
                    $review->title,
                    $review->comment,
                    $review->status,
                    $review->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function analytics()
    {
        // Review statistics
        $stats = [
            'total_reviews' => ShopReview::count(),
            'approved_reviews' => ShopReview::where('status', 'approved')->count(),
            'pending_reviews' => ShopReview::where('status', 'pending')->count(),
            'rejected_reviews' => ShopReview::where('status', 'rejected')->count(),
            'average_rating' => round(ShopReview::where('status', 'approved')->avg('rating'), 2),
            'this_month' => ShopReview::whereBetween('created_at', [
                now()->startOfMonth(), 
                now()->endOfMonth()
            ])->count(),
        ];

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = ShopReview::where('status', 'approved')->where('rating', $i)->count();
            $percentage = $stats['approved_reviews'] > 0 ? 
                round(($count / $stats['approved_reviews']) * 100, 1) : 0;
            
            $ratingDistribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        // Top reviewed products - FIXED QUERY
        $topReviewedProducts = ShopProduct::select([
                'shop_products.id',
                'shop_products.name',
                'shop_products.slug',
                'shop_products.featured_image',
                'shop_products.price',
                'shop_products.category_id'
            ])
            ->leftJoin(DB::raw('(
                SELECT product_id, 
                       COUNT(*) as reviews_count,
                       AVG(rating) as reviews_avg_rating
                FROM shop_reviews 
                WHERE status = "approved"
                GROUP BY product_id
            ) as review_stats'), 'shop_products.id', '=', 'review_stats.product_id')
            ->selectRaw('
                COALESCE(review_stats.reviews_count, 0) as reviews_count,
                COALESCE(review_stats.reviews_avg_rating, 0) as reviews_avg_rating
            ')
            ->having('reviews_count', '>', 0)
            ->orderBy('reviews_count', 'desc')
            ->limit(10)
            ->get();

        // Recent reviews
        $recentReviews = ShopReview::with(['product', 'user'])
                                  ->orderBy('created_at', 'desc')
                                  ->limit(10)
                                  ->get();

        // Reviews trend (last 30 days)
        $reviewsTrend = ShopReview::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                                 ->where('created_at', '>=', now()->subDays(30))
                                 ->groupBy(DB::raw('DATE(created_at)'))
                                 ->orderBy('date')
                                 ->get();

        // Most active reviewers - FIXED QUERY
        $topReviewers = User::select([
                'users.id',
                'users.name',
                'users.email',
                'users.created_at'
            ])
            ->leftJoin(DB::raw('(
                SELECT user_id, COUNT(*) as shop_reviews_count
                FROM shop_reviews 
                WHERE status = "approved"
                GROUP BY user_id
            ) as review_stats'), 'users.id', '=', 'review_stats.user_id')
            ->selectRaw('COALESCE(review_stats.shop_reviews_count, 0) as shop_reviews_count')
            ->having('shop_reviews_count', '>', 0)
            ->orderBy('shop_reviews_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.shop.reviews.analytics', compact(
            'stats', 'ratingDistribution', 'topReviewedProducts', 
            'recentReviews', 'reviewsTrend', 'topReviewers'
        ));
    }

    public function moderationQueue()
    {
        $pendingReviews = ShopReview::where('status', 'pending')
                                   ->with(['product', 'user'])
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(20);

        return view('admin.shop.reviews.moderation', compact('pendingReviews'));
    }

    public function quickModerate(Request $request, ShopReview $review)
    {
        $request->validate([
            'action' => 'required|in:approved,rejected'
        ]);

        try {
            $status = $request->action;
            $review->update(['status' => $status]);

            return response()->json([
                'success' => true,
                'message' => 'Review ' . $status . ' successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to moderate review'
            ], 500);
        }
    }
}