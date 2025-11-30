<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\User;
use Illuminate\Http\Request;

class ShopOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = ShopOrder::with(['user', 'items.product']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQ) use ($request) {
                      $userQ->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
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

        $orders = $query->paginate(20);

        // Stats
        $stats = [
            'total' => ShopOrder::count(),
            'pending' => ShopOrder::pending()->count(),
            'processing' => ShopOrder::processing()->count(),
            'completed' => ShopOrder::completed()->count(),
            'cancelled' => ShopOrder::where('status', 'cancelled')->count(),
            'total_revenue' => ShopOrder::paid()->sum('total_amount'),
            'today_orders' => ShopOrder::whereDate('created_at', today())->count(),
            'today_revenue' => ShopOrder::paid()->whereDate('created_at', today())->sum('total_amount'),
        ];

        return view('admin.shop.orders.index', compact('orders', 'stats'));
    }

    public function show(ShopOrder $order)
    {
        $order->load(['user', 'items.product', 'downloads']);

        return view('admin.shop.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, ShopOrder $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $oldStatus = $order->status;
            $newStatus = $request->status;

            // Update order
            $updateData = ['status' => $newStatus];
            
            // Add timestamp for status changes
            switch ($newStatus) {
                case 'shipped':
                    $updateData['shipped_at'] = now();
                    break;
                case 'delivered':
                    $updateData['delivered_at'] = now();
                    if (!$order->shipped_at) {
                        $updateData['shipped_at'] = now();
                    }
                    break;
            }

            // Add notes if provided
            if ($request->notes) {
                $updateData['notes'] = ($order->notes ? $order->notes . "\n\n" : '') . 
                                     "[" . now()->format('Y-m-d H:i:s') . "] " . $request->notes;
            }

            $order->update($updateData);

            // Handle status-specific actions
            $this->handleStatusChange($order, $oldStatus, $newStatus);

            // Send notification to customer
            // Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Order status update failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status'
            ], 500);
        }
    }

    public function updatePaymentStatus(Request $request, ShopOrder $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded,partially_refunded'
        ]);

        try {
            $oldPaymentStatus = $order->payment_status;
            $newPaymentStatus = $request->payment_status;

            $order->update(['payment_status' => $newPaymentStatus]);

            // Handle payment status changes
            if ($newPaymentStatus === 'paid' && $oldPaymentStatus !== 'paid') {
                // Mark order as paid and create downloads
                $order->markAsPaid();
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment status'
            ], 500);
        }
    }

    public function addNote(Request $request, ShopOrder $order)
    {
        $request->validate([
            'note' => 'required|string|max:500'
        ]);

        try {
            $newNote = "[" . now()->format('Y-m-d H:i:s') . "] " . $request->note;
            $order->update([
                'notes' => ($order->notes ? $order->notes . "\n\n" : '') . $newNote
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note added successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add note'
            ], 500);
        }
    }

    public function generateInvoice(ShopOrder $order)
    {
        try {
            // Generate PDF invoice
            $pdf = $this->generateInvoicePdf($order);
            
            return $pdf->download("invoice-{$order->order_number}.pdf");

        } catch (\Exception $e) {
            \Log::error('Invoice generation failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate invoice'
            ], 500);
        }
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,mark_processing,mark_shipped,mark_delivered,cancel',
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:shop_orders,id'
        ]);

        try {
            $orders = ShopOrder::whereIn('id', $request->order_ids);

            switch ($request->action) {
                case 'delete':
                    // Only allow deletion of cancelled/refunded orders
                    $orders->whereIn('status', ['cancelled', 'refunded'])->delete();
                    $message = 'Selected orders deleted successfully';
                    break;

                case 'mark_processing':
                    $orders->update(['status' => 'processing']);
                    $message = 'Orders marked as processing';
                    break;

                case 'mark_shipped':
                    $orders->update([
                        'status' => 'shipped',
                        'shipped_at' => now()
                    ]);
                    $message = 'Orders marked as shipped';
                    break;

                case 'mark_delivered':
                    $orders->update([
                        'status' => 'delivered',
                        'delivered_at' => now()
                    ]);
                    $message = 'Orders marked as delivered';
                    break;

                case 'cancel':
                    $orders->whereIn('status', ['pending', 'processing'])->update(['status' => 'cancelled']);
                    $message = 'Orders cancelled successfully';
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
        $orders = ShopOrder::with(['user', 'items'])
                          ->when($request->status, fn($q) => $q->where('status', $request->status))
                          ->when($request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
                          ->when($request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
                          ->orderBy('created_at', 'desc')
                          ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'Order Number', 'Customer Name', 'Customer Email', 'Status', 
                'Payment Status', 'Items Count', 'Total Amount', 'Currency', 'Created At'
            ]);

            // Data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user->name,
                    $order->user->email,
                    $order->status,
                    $order->payment_status,
                    $order->items->count(),
                    $order->total_amount,
                    $order->currency,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function analytics()
    {
        // Today's stats
        $todayStats = [
            'orders' => ShopOrder::whereDate('created_at', today())->count(),
            'revenue' => ShopOrder::paid()->whereDate('created_at', today())->sum('total_amount'),
            'pending' => ShopOrder::pending()->whereDate('created_at', today())->count(),
            'completed' => ShopOrder::completed()->whereDate('created_at', today())->count(),
        ];

        // This month's stats
        $monthStats = [
            'orders' => ShopOrder::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'revenue' => ShopOrder::paid()->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('total_amount'),
            'average_order' => ShopOrder::paid()->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->avg('total_amount'),
        ];

        // Top customers
        $topCustomers = User::withCount('orders')
                           ->withSum('orders', 'total_amount')
                           ->orderBy('orders_sum_total_amount', 'desc')
                           ->limit(10)
                           ->get();

        // Recent orders
        $recentOrders = ShopOrder::with(['user', 'items'])
                                ->orderBy('created_at', 'desc')
                                ->limit(10)
                                ->get();

        // Orders by status
        $ordersByStatus = ShopOrder::selectRaw('status, COUNT(*) as count')
                                  ->groupBy('status')
                                  ->pluck('count', 'status')
                                  ->toArray();

        // Revenue trend (last 30 days)
        $revenueTrend = ShopOrder::paid()
                               ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
                               ->where('created_at', '>=', now()->subDays(30))
                               ->groupBy('date')
                               ->orderBy('date')
                               ->get();

        return view('admin.shop.orders.analytics', compact(
            'todayStats', 'monthStats', 'topCustomers', 'recentOrders', 
            'ordersByStatus', 'revenueTrend'
        ));
    }

    // Helper Methods

    private function handleStatusChange(ShopOrder $order, string $oldStatus, string $newStatus): void
    {
        switch ($newStatus) {
            case 'cancelled':
                // Restore stock for cancelled items
                foreach ($order->items as $item) {
                    if ($item->product && $item->isPhysical()) {
                        $item->product->restoreStock($item->quantity);
                    }
                }
                break;

            case 'processing':
                // Create downloads for software products if paid
                if ($order->isPaid() && $order->hasDigitalProducts()) {
                    $order->createDownloads();
                }
                break;

            case 'delivered':
                // Mark order as completed
                // Send delivery confirmation email
                break;
        }
    }

    private function generateInvoicePdf(ShopOrder $order)
    {
        // Generate invoice PDF using DomPDF or similar
        $html = view('admin.shop.orders.invoice', compact('order'))->render();
        
        // Using DomPDF (install: composer require barryvdh/laravel-dompdf)
        $pdf = \PDF::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf;
    }
}