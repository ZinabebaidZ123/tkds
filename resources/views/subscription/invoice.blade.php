@extends('layouts.user')

@section('title', 'Invoice #' . $payment->stripe_invoice_id . ' - TKDS Media')
@section('meta_description', 'View and download your TKDS Media invoice')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark via-dark-light to-dark py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
            <a href="{{ route('user.subscription') }}" class="inline-flex items-center text-gray-400 hover:text-primary transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Subscription
            </a>
            
            <div class="flex flex-col sm:flex-row gap-3">
                @if($payment->receipt_url)
                    <a href="{{ $payment->receipt_url }}" 
                       target="_blank"
                       class="inline-flex items-center justify-center bg-white/10 backdrop-blur-sm border border-white/20 text-white px-4 py-2 rounded-lg font-medium hover:bg-white/20 transition-all duration-300">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        View Receipt
                    </a>
                @endif
                
                <button onclick="window.print()" 
                        class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-lg font-medium hover:from-secondary hover:to-accent transition-all duration-300">
                    <i class="fas fa-print mr-2"></i>
                    Print Invoice
                </button>
            </div>
        </div>

        <!-- Invoice Card -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-2xl" id="invoice-content">
            
            <!-- Invoice Header -->
            <div class="bg-gradient-to-r from-primary to-secondary p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-6">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center">
                                <span class="text-primary font-black text-xl">T</span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-black">TKDS Media</h1>
                                <p class="text-white/80 text-sm">Your World, Live and Direct</p>
                            </div>
                        </div>
                        <div class="text-white/90 text-sm">
                            <p>Digital Broadcasting Solutions</p>
                            <p>contact@tkdsmedia.com</p>
                            <p>+1 (555) 123-4567</p>
                        </div>
                    </div>
                    
                    <!-- Invoice Info -->
                    <div class="text-right">
                        <h2 class="text-3xl font-black mb-2">INVOICE</h2>
                        <div class="space-y-1 text-white/90">
                            <p><span class="font-medium">Invoice #:</span> {{ $payment->stripe_invoice_id }}</p>
                            <p><span class="font-medium">Date:</span> {{ $payment->processed_at->format('M d, Y') }}</p>
                            <p><span class="font-medium">Due Date:</span> {{ $payment->processed_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Body -->
            <div class="p-8">
                
                <!-- Bill To Section -->
                <div class="grid lg:grid-cols-2 gap-8 mb-8">
                    <!-- Customer Info -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">Bill To:</h3>
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                            <p class="text-white font-semibold">{{ $subscription->user->name }}</p>
                            <p class="text-gray-400">{{ $subscription->user->email }}</p>
                            @if($subscription->user->phone)
                                <p class="text-gray-400">{{ $subscription->user->phone }}</p>
                            @endif
                            
                            @if($subscription->user->defaultBillingInfo)
                                <div class="mt-3 pt-3 border-t border-white/10">
                                    <p class="text-gray-400 text-sm">{{ $subscription->user->defaultBillingInfo->getFullAddress() }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Payment Info -->
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">Payment Details:</h3>
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Payment Method</span>
                                <span class="text-white flex items-center">
                                    <i class="{{ $payment->getPaymentMethodIcon() }} mr-2"></i>
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Transaction ID</span>
                                <span class="text-white font-mono text-sm">{{ $payment->stripe_payment_intent_id }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Status</span>
                                @php $statusBadge = $payment->getStatusBadge() @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusBadge['class'] }}">
                                    <i class="{{ $statusBadge['icon'] }} mr-1"></i>
                                    {{ $statusBadge['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-white mb-4">Invoice Items:</h3>
                    
                    <div class="bg-white/5 rounded-xl border border-white/10 overflow-hidden">
                        <!-- Table Header -->
                        <div class="bg-white/5 px-6 py-4 border-b border-white/10">
                            <div class="grid grid-cols-12 gap-4 text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <div class="col-span-6">Description</div>
                                <div class="col-span-2 text-center">Period</div>
                                <div class="col-span-2 text-center">Quantity</div>
                                <div class="col-span-2 text-right">Amount</div>
                            </div>
                        </div>
                        
                        <!-- Table Body -->
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-12 gap-4 items-center">
                                <div class="col-span-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-r {{ $subscription->pricingPlan->getColorClass() }} rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="{{ $subscription->pricingPlan->icon }} text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ $subscription->pricingPlan->name }}</p>
                                            <p class="text-gray-400 text-sm">{{ ucfirst($subscription->billing_cycle) }} subscription</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-span-2 text-center text-gray-400 text-sm">
                                    @if($subscription->current_period_start && $subscription->current_period_end)
                                        {{ $subscription->current_period_start->format('M d') }} - {{ $subscription->current_period_end->format('M d, Y') }}
                                    @else
                                        -
                                    @endif
                                </div>
                                
                                <div class="col-span-2 text-center text-white">
                                    1
                                </div>
                                
                                <div class="col-span-2 text-right text-white font-semibold">
                                    {{ $payment->getFormattedAmount() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Summary -->
                <div class="flex justify-end">
                    <div class="w-full max-w-sm">
                        <div class="bg-white/5 rounded-xl p-6 border border-white/10 space-y-4">
                            <div class="flex justify-between items-center text-gray-400">
                                <span>Subtotal</span>
                                <span>{{ $payment->getFormattedAmount() }}</span>
                            </div>
                            
                            @if($payment->refund_amount)
                                <div class="flex justify-between items-center text-red-400">
                                    <span>Refunded</span>
                                    <span>-{{ $payment->getFormattedRefundAmount() }}</span>
                                </div>
                            @endif
                            
                            <div class="border-t border-white/20 pt-4">
                                <div class="flex justify-between items-center text-white font-bold text-lg">
                                    <span>Total {{ $payment->currency }}</span>
                                    <span>{{ $payment->getFormattedNetAmount() }}</span>
                                </div>
                            </div>
                            
                            @if($payment->isSucceeded())
                                <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-3 text-center">
                                    <p class="text-green-400 font-semibold text-sm">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Payment Completed
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Invoice Footer -->
                <div class="mt-12 pt-8 border-t border-white/20">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Payment Terms -->
                        <div>
                            <h4 class="text-white font-semibold mb-3">Payment Terms</h4>
                            <div class="text-gray-400 text-sm space-y-1">
                                <p>• Payment is due immediately upon receipt</p>
                                <p>• Subscriptions are auto-renewed unless cancelled</p>
                                <p>• Refunds are subject to our terms and conditions</p>
                                <p>• All payments are processed securely through Stripe</p>
                            </div>
                        </div>
                        
                        <!-- Contact Info -->
                        <div>
                            <h4 class="text-white font-semibold mb-3">Questions?</h4>
                            <div class="text-gray-400 text-sm space-y-1">
                                <p>Email: billing@tkdsmedia.com</p>
                                <p>Phone: +1 (555) 123-4567</p>
                                <p>Support: {{ route('contact') }}</p>
                                <p>Hours: Monday - Friday, 9AM - 6PM EST</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <p class="text-gray-500 text-xs">
                            This invoice was generated automatically by TKDS Media billing system.
                            For technical support, please visit our support center.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Actions -->
        <div class="mt-8 bg-white/5 backdrop-blur-xl rounded-2xl p-6 border border-white/10">
            <h3 class="text-lg font-bold text-white mb-4">Need Help?</h3>
            <div class="grid md:grid-cols-3 gap-4">
                <a href="{{ route('contact') }}" 
                   class="flex items-center space-x-3 p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                        <i class="fas fa-headset text-white"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium group-hover:text-primary transition-colors duration-200">Contact Support</p>
                        <p class="text-gray-400 text-sm">Get help with billing</p>
                    </div>
                </a>
                
                <a href="{{ route('user.subscription') }}" 
                   class="flex items-center space-x-3 p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gradient-to-r from-secondary to-accent rounded-lg flex items-center justify-center">
                        <i class="fas fa-credit-card text-white"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium group-hover:text-secondary transition-colors duration-200">Manage Subscription</p>
                        <p class="text-gray-400 text-sm">Update payment info</p>
                    </div>
                </a>
                
                <a href="{{ route('user.dashboard') }}" 
                   class="flex items-center space-x-3 p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-gradient-to-r from-accent to-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-white"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium group-hover:text-accent transition-colors duration-200">Dashboard</p>
                        <p class="text-gray-400 text-sm">View account overview</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('head')
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #invoice-content, #invoice-content * {
        visibility: visible;
    }
    #invoice-content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white !important;
        color: black !important;
    }
    .bg-gradient-to-r {
        background: #C53030 !important;
    }
    .text-white {
        color: black !important;
    }
    .text-gray-400 {
        color: #666 !important;
    }
    .bg-white\/5, .bg-white\/10 {
        background: #f5f5f5 !important;
        border: 1px solid #ddd !important;
    }
    .border-white\/10, .border-white\/20 {
        border-color: #ddd !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Auto-print if print parameter is present
if (new URLSearchParams(window.location.search).get('print') === 'true') {
    window.addEventListener('load', function() {
        setTimeout(() => {
            window.print();
        }, 1000);
    });
}

// Download invoice as PDF (using browser's print to PDF)
function downloadPDF() {
    const printWindow = window.open('', '_blank');
    const invoiceContent = document.getElementById('invoice-content').cloneNode(true);
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Invoice #{{ $payment->stripe_invoice_id }}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                .bg-gradient-to-r { background: #C53030 !important; }
                .text-white { color: white !important; }
                .text-gray-400 { color: #666 !important; }
                .bg-white\\/5, .bg-white\\/10 { background: #f5f5f5 !important; border: 1px solid #ddd !important; }
                .border-white\\/10, .border-white\\/20 { border-color: #ddd !important; }
                .rounded-xl, .rounded-lg { border-radius: 8px; }
                .p-8 { padding: 2rem; }
                .p-6 { padding: 1.5rem; }
                .p-4 { padding: 1rem; }
                .mb-8 { margin-bottom: 2rem; }
                .mb-4 { margin-bottom: 1rem; }
                .grid { display: grid; }
                .grid-cols-12 { grid-template-columns: repeat(12, 1fr); }
                .col-span-6 { grid-column: span 6; }
                .col-span-2 { grid-column: span 2; }
                .gap-4 { gap: 1rem; }
                .text-right { text-align: right; }
                .text-center { text-align: center; }
                .font-bold { font-weight: bold; }
                .font-semibold { font-weight: 600; }
                .text-lg { font-size: 1.125rem; }
                .text-sm { font-size: 0.875rem; }
                .text-xs { font-size: 0.75rem; }
            </style>
        </head>
        <body>
            ${invoiceContent.outerHTML}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.print();
}
</script>
@endpush