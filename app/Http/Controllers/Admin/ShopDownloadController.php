<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopDownload;
use Illuminate\Http\Request;

class ShopDownloadController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopDownload::with(['user', 'product', 'order']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('file_name', 'like', '%' . $request->search . '%')
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
            switch ($request->status) {
                case 'active':
                    $query->active();
                    break;
                case 'expired':
                    $query->expired();
                    break;
                case 'no_downloads_left':
                    $query->noDownloadsLeft();
                    break;
            }
        }

        $downloads = $query->orderBy('created_at', 'desc')->paginate(20);

        // Stats
        $stats = [
            'total_downloads' => ShopDownload::count(),
            'active_downloads' => ShopDownload::active()->count(),
            'expired_downloads' => ShopDownload::expired()->count(),
            'exhausted_downloads' => ShopDownload::noDownloadsLeft()->count(),
            'total_file_size' => ShopDownload::sum('file_size'),
        ];

        return view('admin.shop.downloads.index', compact('downloads', 'stats'));
    }

    public function reset(ShopDownload $download)
    {
        try {
            $download->update([
                'downloads_remaining' => $download->product->download_limit ?? -1,
                'expires_at' => $download->product->download_expiry_days > 0 
                    ? now()->addDays($download->product->download_expiry_days) 
                    : null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Download limits reset successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Download reset failed', [
                'download_id' => $download->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to reset download'
            ], 500);
        }
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:reset,delete,extend_expiry',
            'download_ids' => 'required|array',
            'download_ids.*' => 'exists:shop_downloads,id',
            'extend_days' => 'nullable|integer|min:1|max:365'
        ]);

        try {
            $downloads = ShopDownload::whereIn('id', $request->download_ids);

            switch ($request->action) {
                case 'reset':
                    foreach ($downloads->get() as $download) {
                        $download->update([
                            'downloads_remaining' => $download->product->download_limit ?? -1,
                            'expires_at' => $download->product->download_expiry_days > 0 
                                ? now()->addDays($download->product->download_expiry_days) 
                                : null
                        ]);
                    }
                    $message = 'Downloads reset successfully';
                    break;

                case 'delete':
                    $downloads->delete();
                    $message = 'Downloads deleted successfully';
                    break;

                case 'extend_expiry':
                    $days = $request->extend_days ?? 30;
                    $downloads->update([
                        'expires_at' => now()->addDays($days)
                    ]);
                    $message = "Expiry extended by {$days} days";
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
}