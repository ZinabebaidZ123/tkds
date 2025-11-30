@extends('admin.layouts.app')

@section('title', 'Payment History')
@section('page-title', 'Payment Management')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Payment History</h2>
            <p class="text-gray-600 text-sm mt-1">Track all payment transactions and invoices</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary"
                       placeholder="Email or transaction ID">
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Statuses</option>
                    <option value="succeeded" {{ request('status') === 'succeeded' ? 'selected' : '' }}>Succeeded</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>
            
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            
            <div class="md:col-span-4 flex space-x-3">
                <button type="submit" 
                        class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl font-medium transition-all duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Search
                </button>
                <a href="{{ route('admin.stripe.payments') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        @if($payments->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Transaction ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Method</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold mr-3">
                                            {{ substr($payment->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $payment->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $payment->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-mono text-sm text-gray-900">
                                        {{ $payment->stripe_payment_intent_id ? substr($payment->stripe_payment_intent_id, 0, 20) . '...' : 'N/A' }}
                                    </div>
                                    @if($payment->stripe_invoice_id)
                                        <div class="font-mono text-xs text-gray-500">
                                            Invoice: {{ substr($payment->stripe_invoice_id, 0, 15) }}...
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $payment->getFormattedAmount() }}</div>
                                    @if($payment->refund_amount > 0)
                                        <div class="text-sm text-red-600">
                                            Refunded: {{ $payment->getFormattedRefundAmount() }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php $badge = $payment->getStatusBadge() @endphp
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $badge['class'] }}">
                                        <i class="{{ $badge['icon'] }} mr-1"></i>
                                        {{ $badge['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <i class="{{ $payment->getPaymentMethodIcon() }} text-gray-600 mr-2"></i>
                                        <span class="capitalize text-gray-900">{{ $payment->payment_method ?? 'Card' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $payment->processed_at?->format('M j, Y g:i A') ?? 'Pending' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        @if($payment->receipt_url)
                                            <a href="{{ $payment->receipt_url }}" target="_blank"
                                               class="text-blue-600 hover:text-blue-800 p-1"
                                               title="View Receipt">
                                                <i class="fas fa-receipt"></i>
                                            </a>
                                        @endif
                                        @if($payment->canRefund())
                                            <button onclick="showRefundModal({{ $payment->id }})" 
                                                    class="text-red-600 hover:text-red-800 p-1"
                                                    title="Process Refund">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="lg:hidden divide-y divide-gray-100">
                @foreach($payments as $payment)
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ substr($payment->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900 truncate">{{ $payment->user->name }}</h3>
                                        <p class="text-sm text-gray-500 truncate">{{ $payment->user->email }}</p>
                                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $payment->getFormattedAmount() }}</p>
                                    </div>
                                    @php $badge = $payment->getStatusBadge() @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badge['class'] }}">
                                        {{ $badge['text'] }}
                                    </span>
                                </div>
                                <div class="mt-3 flex items-center justify-between text-sm">
                                    <span class="text-gray-500">{{ $payment->processed_at?->format('M j, Y') ?? 'Pending' }}</span>
                                    <div class="flex items-center space-x-3">
                                        @if($payment->receipt_url)
                                            <a href="{{ $payment->receipt_url }}" target="_blank" class="text-blue-600">
                                                <i class="fas fa-receipt"></i>
                                            </a>
                                        @endif
                                        @if($payment->canRefund())
                                            <button onclick="showRefundModal({{ $payment->id }})" class="text-red-600">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t">
                {{ $payments->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-credit-card text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No payments found</h3>
                <p class="text-gray-500">Payment transactions will appear here once processed.</p>
            </div>
        @endif
    </div>

</div>

<!-- Refund Modal -->
<div id="refundModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-undo text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Process Refund</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to refund this payment? This action cannot be undone.</p>
            <div class="flex space-x-3">
                <button onclick="processRefund()" 
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-xl font-medium transition-all duration-200">
                    Process Refund
                </button>
                <button onclick="closeRefundModal()" 
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-medium hover:bg-gray-200 transition-all duration-200">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPaymentId = null;

function showRefundModal(paymentId) {
    currentPaymentId = paymentId;
    const modal = document.getElementById('refundModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeRefundModal() {
    const modal = document.getElementById('refundModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    currentPaymentId = null;
}

function processRefund() {
    if (!currentPaymentId) return;
    
    // Here you would make an AJAX call to process the refund
    alert('Refund processing functionality would be implemented here');
    closeRefundModal();
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRefundModal();
    }
});
</script>
@endpush