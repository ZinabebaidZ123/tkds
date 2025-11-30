{{-- File: resources/views/admin/shop/orders/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.shop.orders.index') }}" 
               class="p-2 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Order {{ $order->order_number }}</h2>
                <p class="text-gray-600 text-sm mt-1">Placed {{ $order->created_at->format('M j, Y \a\t g:i A') }}</p>
            </div>
        </div>
        <div class="flex space-x-4">
            <button onclick="generateInvoice({{ $order->id }})" 
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors duration-200">
                <i class="fas fa-file-pdf mr-2"></i>
                Generate Invoice
            </button>
            @if($order->canCancel())
                <button onclick="updateOrderStatus({{ $order->id }}, 'cancelled')" 
                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel Order
                </button>
            @endif
        </div>
    </div>

    <!-- Order Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Order Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Order Status Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Order Status</h3>
                    <div class="flex space-x-2">
                        @php $statusBadge = $order->getStatusBadge() @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusBadge['class'] }}">
                            <i class="{{ $statusBadge['icon'] }} mr-2"></i>
                            {{ $statusBadge['text'] }}
                        </span>
                        @php $paymentBadge = $order->getPaymentStatusBadge() @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $paymentBadge['class'] }}">
                            <i class="{{ $paymentBadge['icon'] }} mr-2"></i>
                            {{ $paymentBadge['text'] }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Order Status</label>
                        <select onchange="updateOrderStatus({{ $order->id }}, this.value)" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Status</label>
                        <select onchange="updatePaymentStatus({{ $order->id }}, this.value)" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            <option value="partially_refunded" {{ $order->payment_status == 'partially_refunded' ? 'selected' : '' }}>Partially Refunded</option>
                        </select>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="mt-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4">Order Timeline</h4>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Order Placed</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('M j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                        
                        @if($order->isPaid())
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Payment Received</p>
                                    <p class="text-xs text-gray-500">Payment confirmed</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($order->shipped_at)
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Order Shipped</p>
                                    <p class="text-xs text-gray-500">{{ $order->shipped_at->format('M j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($order->delivered_at)
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Order Delivered</p>
                                    <p class="text-xs text-gray-500">{{ $order->delivered_at->format('M j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Items ({{ $order->items->count() }})</h3>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="flex items-center space-x-4">
                                @if($item->product)
                                    <img src="{{ $item->product->getFeaturedImageUrl() }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-cube text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $item->product_name }}</h4>
                                    @if($item->product_sku)
                                        <p class="text-sm text-gray-500">SKU: {{ $item->product_sku }}</p>
                                    @endif
                                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                                        <span>{{ $item->getFormattedPrice() }} × {{ $item->quantity }}</span>
                                        @php $typeBadge = $item->isSoftware() ? ['text' => 'Digital', 'class' => 'bg-purple-100 text-purple-800'] : ['text' => 'Physical', 'class' => 'bg-blue-100 text-blue-800'] @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $typeBadge['class'] }}">
                                            {{ $typeBadge['text'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">{{ $item->getFormattedTotal() }}</p>
                                @if($item->product)
                                    <a href="{{ route('admin.shop.products.show', $item->product) }}" 
                                       class="text-sm text-primary hover:text-secondary">
                                        View Product →
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->tax_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax:</span>
                                <span class="font-medium text-gray-900">${{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                        @endif
                        @if($order->shipping_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping:</span>
                                <span class="font-medium text-gray-900">${{ number_format($order->shipping_amount, 2) }}</span>
                            </div>
                        @endif
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount:</span>
                                <span class="font-medium text-red-600">-${{ number_format($order->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200">
                            <span class="text-gray-900">Total:</span>
                            <span class="text-gray-900">{{ $order->getFormattedTotal() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Digital Downloads -->
            @if($order->downloads->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-download text-primary mr-3"></i>
                        Digital Downloads ({{ $order->downloads->count() }})
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($order->downloads as $download)
                            <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl border border-purple-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-file text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $download->file_name }}</h4>
                                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                                            <span>{{ $download->getFormattedFileSize() }}</span>
                                            <span>{{ $download->getDownloadsStatus() }}</span>
                                            <span>{{ $download->getExpiryStatus() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    @php $downloadBadge = $download->getStatusBadge() @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $downloadBadge['class'] }}">
                                        <i class="{{ $downloadBadge['icon'] }} mr-1"></i>
                                        {{ $downloadBadge['text'] }}
                                    </span>
                                    @if($download->canDownload())
                                        <button onclick="resetDownload({{ $download->id }})" 
                                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50"
                                                title="Reset Download">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Order Notes -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Notes</h3>
                
                @if($order->notes)
                    <div class="mb-6 p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                        <h4 class="text-sm font-semibold text-yellow-800 mb-2">Existing Notes:</h4>
                        <div class="text-yellow-700 text-sm whitespace-pre-wrap">{{ $order->notes }}</div>
                    </div>
                @endif

                <form onsubmit="addNote(event, {{ $order->id }})" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Add Note</label>
                        <textarea name="note" rows="3" 
                                  placeholder="Add internal notes about this order..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
                    </div>
                    <button type="submit" 
                            class="px-6 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Add Note
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user text-primary mr-3"></i>
                    Customer Information
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($order->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $order->user->name }}</h4>
                            <p class="text-gray-600 text-sm">{{ $order->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Customer Since</p>
                            <p class="font-semibold text-gray-900">{{ $order->user->created_at->format('M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Total Orders</p>
                            <p class="font-semibold text-gray-900">{{ $order->user->orders()->count() }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.users.show', $order->user) }}" 
                       class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                        View Customer Profile
                    </a>
                </div>
            </div>

            <!-- Billing Address -->
            @if($order->billing_address)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-credit-card text-primary mr-3"></i>
                        Billing Address
                    </h3>
                    
                    <div class="text-sm text-gray-700 space-y-1">
                        @if(isset($order->billing_address['name']))
                            <p class="font-semibold">{{ $order->billing_address['name'] }}</p>
                        @endif
                        @if(isset($order->billing_address['address']))
                            <p>{{ $order->billing_address['address'] }}</p>
                        @endif
                        @if(isset($order->billing_address['city']))
                            <p>{{ $order->billing_address['city'] }}, {{ $order->billing_address['state'] ?? '' }} {{ $order->billing_address['zip'] ?? '' }}</p>
                        @endif
                        @if(isset($order->billing_address['country']))
                            <p>{{ $order->billing_address['country'] }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Shipping Address -->
            @if($order->shipping_address && $order->hasPhysicalProducts())
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-shipping-fast text-primary mr-3"></i>
                        Shipping Address
                    </h3>
                    
                    <div class="text-sm text-gray-700 space-y-1">
                        @if(isset($order->shipping_address['name']))
                            <p class="font-semibold">{{ $order->shipping_address['name'] }}</p>
                        @endif
                        @if(isset($order->shipping_address['address']))
                            <p>{{ $order->shipping_address['address'] }}</p>
                        @endif
                        @if(isset($order->shipping_address['city']))
                            <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['zip'] ?? '' }}</p>
                        @endif
                        @if(isset($order->shipping_address['country']))
                            <p>{{ $order->shipping_address['country'] }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Payment Information -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-credit-card text-primary mr-3"></i>
                    Payment Information
                </h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-medium text-gray-900">{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
                    </div>
                    @if($order->stripe_payment_intent_id)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Intent:</span>
                            <span class="font-medium text-gray-900 text-xs">{{ $order->stripe_payment_intent_id }}</span>
                        </div>
                    @endif
                    @if($order->stripe_session_id)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Session ID:</span>
                            <span class="font-medium text-gray-900 text-xs">{{ $order->stripe_session_id }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Currency:</span>
                        <span class="font-medium text-gray-900">{{ strtoupper($order->currency) }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bolt text-primary mr-3"></i>
                    Quick Actions
                </h3>
                
                <div class="space-y-3">
                    <button onclick="generateInvoice({{ $order->id }})" 
                            class="w-full flex items-center justify-center p-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors duration-200">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Download Invoice
                    </button>
                    
                    @if(!$order->isPaid())
                        <button onclick="updatePaymentStatus({{ $order->id }}, 'paid')" 
                                class="w-full flex items-center justify-center p-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200">
                            <i class="fas fa-credit-card mr-2"></i>
                            Mark as Paid
                        </button>
                    @endif
                    
                    @if($order->canRefund())
                        <button onclick="processRefund({{ $order->id }})" 
                                class="w-full flex items-center justify-center p-3 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition-colors duration-200">
                            <i class="fas fa-undo mr-2"></i>
                            Process Refund
                        </button>
                    @endif
                    
                    @if($order->canCancel())
                        <button onclick="updateOrderStatus({{ $order->id }}, 'cancelled')" 
                                class="w-full flex items-center justify-center p-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Cancel Order
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateOrderStatus(orderId, status) {
    if (confirm(`Are you sure you want to change the order status to ${status}?`)) {
        fetch(`/admin/shop/orders/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                status: status,
                notes: `Status changed to ${status} by admin`
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update order status');
            }
        });
    }
}

function updatePaymentStatus(orderId, status) {
    if (confirm(`Are you sure you want to change the payment status to ${status}?`)) {
        fetch(`/admin/shop/orders/${orderId}/payment-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ payment_status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update payment status');
            }
        });
    }
}

function addNote(event, orderId) {
    event.preventDefault();
    
    const form = event.target;
    const note = form.note.value.trim();
    
    if (!note) {
        alert('Please enter a note');
        return;
    }
    
    fetch(`/admin/shop/orders/${orderId}/note`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ note: note })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to add note');
        }
    });
}

function generateInvoice(orderId) {
    window.open(`/admin/shop/orders/${orderId}/invoice`, '_blank');
}

function resetDownload(downloadId) {
    if (confirm('Are you sure you want to reset this download?')) {
        fetch(`/admin/shop/downloads/${downloadId}/reset`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to reset download');
            }
        });
    }
}

function processRefund(orderId) {
    if (confirm('Are you sure you want to process a refund for this order?')) {
        // This would integrate with Stripe API
        alert('Refund processing would be implemented here with Stripe API');
    }
}
</script>
@endsection