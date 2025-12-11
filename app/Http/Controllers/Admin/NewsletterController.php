<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = Newsletter::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Source filter
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Verification filter
        if ($request->filled('verified')) {
            if ($request->verified === 'yes') {
                $query->whereNotNull('verified_at');
            } else {
                $query->whereNull('verified_at');
            }
        }

        $newsletters = $query->orderBy('created_at', 'desc')->paginate(15);
        $stats = Newsletter::getStats();
        $sources = Newsletter::getSourceStats();

        return view('admin.newsletter.index', compact('newsletters', 'stats', 'sources'));
    }

    public function show(Newsletter $newsletter)
    {
        return view('admin.newsletter.show', compact('newsletter'));
    }

    public function updateStatus(Request $request, Newsletter $newsletter)
    {
        $request->validate([
            'status' => 'required|in:active,unsubscribed,bounced,blocked'
        ]);

        try {
            $oldStatus = $newsletter->status;
            
            if ($request->status === 'unsubscribed') {
                $newsletter->unsubscribe();
            } elseif ($request->status === 'active' && $newsletter->isUnsubscribed()) {
                $newsletter->resubscribe();
            } else {
                $newsletter->update(['status' => $request->status]);
            }

            Log::info('Newsletter status updated', [
                'id' => $newsletter->id,
                'email' => $newsletter->email,
                'old_status' => $oldStatus,
                'new_status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update newsletter status', [
                'id' => $newsletter->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    public function destroy(Newsletter $newsletter)
    {
        try {
            $email = $newsletter->email;
            $newsletter->delete();

            Log::info('Newsletter subscriber deleted', [
                'email' => $email,
                'deleted_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subscriber deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to delete newsletter subscriber', [
                'id' => $newsletter->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete subscriber'
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,unsubscribe,block,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:newsletters,id'
        ]);

        try {
            $newsletters = Newsletter::whereIn('id', $request->ids)->get();
            $count = 0;

            foreach ($newsletters as $newsletter) {
                switch ($request->action) {
                    case 'activate':
                        if (!$newsletter->isActive()) {
                            $newsletter->resubscribe();
                            $count++;
                        }
                        break;
                    case 'unsubscribe':
                        if ($newsletter->isActive()) {
                            $newsletter->unsubscribe();
                            $count++;
                        }
                        break;
                    case 'block':
                        $newsletter->update(['status' => Newsletter::STATUS_BLOCKED]);
                        $count++;
                        break;
                    case 'delete':
                        $newsletter->delete();
                        $count++;
                        break;
                }
            }

            Log::info('Newsletter bulk action completed', [
                'action' => $request->action,
                'count' => $count,
                'total_selected' => count($request->ids)
            ]);

            return response()->json([
                'success' => true,
                'message' => "Successfully {$request->action}d {$count} subscribers"
            ]);

        } catch (\Exception $e) {
            Log::error('Newsletter bulk action failed', [
                'action' => $request->action,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Bulk action failed'
            ], 500);
        }
    }

    public function export(Request $request)
    {
        try {
            $query = Newsletter::query();

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $newsletters = $query->orderBy('created_at', 'desc')->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="newsletter_subscribers_' . now()->format('Y-m-d') . '.csv"',
            ];

            $callback = function() use ($newsletters) {
                $file = fopen('php://output', 'w');
                
                // Headers
                fputcsv($file, [
                    'ID', 'Email', 'Name', 'Status', 'Source', 
                    'Verified', 'Created At', 'Last Sent', 'Bounce Count'
                ]);

                // Data
                foreach ($newsletters as $newsletter) {
                    fputcsv($file, [
                        $newsletter->id,
                        $newsletter->email,
                        $newsletter->name ?: 'N/A',
                        $newsletter->status,
                        $newsletter->source,
                        $newsletter->verified_at ? 'Yes' : 'No',
                        $newsletter->created_at->format('Y-m-d H:i:s'),
                        $newsletter->last_sent_at ? $newsletter->last_sent_at->format('Y-m-d H:i:s') : 'Never',
                        $newsletter->bounce_count
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Newsletter export failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Export failed. Please try again.');
        }
    }

    public function analytics()
    {
        $stats = Newsletter::getStats();
        $growthData = Newsletter::getGrowthData(30);
        $sourceStats = Newsletter::getSourceStats();

        return view('admin.newsletter.analytics', compact('stats', 'growthData', 'sourceStats'));
    }
}