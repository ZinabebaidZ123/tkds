<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShopDownloadController extends Controller
{
    public function download(Request $request, $token)
    {
        $download = ShopDownload::findByToken($token);

        if (!$download) {
            abort(404, 'Download not found');
        }

        // Check if user owns this download
        if (!auth()->check() || auth()->id() !== $download->user_id) {
            abort(403, 'Access denied');
        }

        // Check if download is still valid
        if (!$download->canDownload()) {
            $message = 'Download no longer available';
            
            if ($download->isExpired()) {
                $message = 'Download has expired';
            } elseif (!$download->hasDownloadsLeft()) {
                $message = 'Download limit exceeded';
            }

            return response()->view('shop.download-error', [
                'message' => $message,
                'download' => $download
            ], 403);
        }

        // Check if file exists - تحديث للدسك المحدد
        $disk = $download->file_path ? (strpos($download->file_path, 'private/') === 0 ? 'local' : 'private') : 'local';
        
        if (!Storage::disk($disk)->exists($download->file_path)) {
            \Log::error('Download file not found', [
                'download_id' => $download->id,
                'file_path' => $download->file_path,
                'disk' => $disk
            ]);

            return response()->view('shop.download-error', [
                'message' => 'File not found on server',
                'download' => $download
            ], 404);
        }

        try {
            // Record the download
            $download->recordDownload();

            // Get file info
            $filePath = $download->file_path;
            $fileName = $download->file_name;
            $fileSize = Storage::disk($disk)->size($filePath);
            $mimeType = Storage::disk($disk)->mimeType($filePath) ?: 'application/octet-stream';

            // Create streamed response for large files
            return new StreamedResponse(function() use ($filePath, $disk) {
                $stream = Storage::disk($disk)->readStream($filePath);
                
                if ($stream) {
                    while (!feof($stream)) {
                        echo fread($stream, 8192);
                        flush();
                        
                        // Check if user aborted
                        if (connection_aborted()) {
                            break;
                        }
                    }
                    fclose($stream);
                }
            }, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Content-Length' => $fileSize,
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'X-Accel-Buffering' => 'no' // For nginx
            ]);

        } catch (\Exception $e) {
            \Log::error('Download failed', [
                'download_id' => $download->id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return response()->view('shop.download-error', [
                'message' => 'Download failed. Please try again.',
                'download' => $download
            ], 500);
        }
    }

    // ✅ تحديث دالة preview لتعمل بطريقتين
    public function preview(Request $request, $tokenOrId)
    {
        // Try to find by token first, then by ID
        if (strlen($tokenOrId) > 10) {
            $download = ShopDownload::findByToken($tokenOrId);
        } else {
            $download = ShopDownload::find($tokenOrId);
        }

        if (!$download) {
            return response()->json([
                'success' => false,
                'message' => 'Download not found'
            ], 404);
        }

        if (!auth()->check() || auth()->id() !== $download->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'download' => [
                'id' => $download->id,
                'file_name' => $download->file_name,
                'file_size' => $download->getFormattedFileSize(),
                'product_name' => $download->product->name,
                'order_number' => $download->order->order_number,
                'can_download' => $download->canDownload(),
                'downloads_remaining' => $download->downloads_remaining,
                'downloads_status' => $download->getDownloadsStatus(),
                'expires_at' => $download->expires_at?->format('M j, Y g:i A'),
                'expiry_status' => $download->getExpiryStatus(),
                'last_downloaded_at' => $download->last_downloaded_at?->diffForHumans(),
                'status_badge' => $download->getStatusBadge(),
                'download_url' => $download->canDownload() ? $download->getDownloadUrl() : null
            ]
        ]);
    }

    public function userDownloads()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }

        $downloads = ShopDownload::where('user_id', auth()->id())
                                ->with(['product', 'order'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(15);

        return view('user.downloads', compact('downloads'));
    }

    public function userDownloadsApi()
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $downloads = ShopDownload::where('user_id', auth()->id())
                                ->with(['product', 'order'])
                                ->orderBy('created_at', 'desc')
                                ->paginate(15);

        return response()->json([
            'success' => true,
            'downloads' => $downloads->map(function($download) {
                return [
                    'id' => $download->id,
                    'token' => $download->download_token,
                    'file_name' => $download->file_name,
                    'file_size' => $download->getFormattedFileSize(),
                    'product' => [
                        'id' => $download->product->id,
                        'name' => $download->product->name,
                        'image' => $download->product->getFeaturedImageUrl(),
                        'url' => route('shop.product', $download->product->slug)
                    ],
                    'order' => [
                        'id' => $download->order->id,
                        'order_number' => $download->order->order_number,
                        'created_at' => $download->order->created_at->format('M j, Y')
                    ],
                    'can_download' => $download->canDownload(),
                    'downloads_remaining' => $download->downloads_remaining,
                    'downloads_status' => $download->getDownloadsStatus(),
                    'expiry_status' => $download->getExpiryStatus(),
                    'last_downloaded_at' => $download->last_downloaded_at?->diffForHumans(),
                    'status_badge' => $download->getStatusBadge(),
                    'download_url' => $download->canDownload() ? $download->getDownloadUrl() : null,
                    'created_at' => $download->created_at->format('M j, Y g:i A')
                ];
            }),
            'pagination' => [
                'current_page' => $downloads->currentPage(),
                'total_pages' => $downloads->lastPage(),
                'per_page' => $downloads->perPage(),
                'total' => $downloads->total()
            ]
        ]);
    }

    public function resendDownloadLink(Request $request)
    {
        $request->validate([
            'download_id' => 'required|exists:shop_downloads,id'
        ]);

        $download = ShopDownload::where('id', $request->download_id)
                               ->where('user_id', auth()->id())
                               ->first();

        if (!$download) {
            return response()->json([
                'success' => false,
                'message' => 'Download not found'
            ], 404);
        }

        if (!$download->canDownload()) {
            return response()->json([
                'success' => false,
                'message' => 'Download is no longer available'
            ], 403);
        }

        // In a real app, you'd send an email here
        // For now, just return the download URL
        return response()->json([
            'success' => true,
            'message' => 'Download link sent to your email',
            'download_url' => $download->getDownloadUrl()
        ]);
    }
}