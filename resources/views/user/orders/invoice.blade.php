{{-- File: resources/views/user/orders/invoice.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} - TKDS Media</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#C53030',
                        'secondary': '#E53E3E',
                        'accent': '#FC8181',
                    }
                }
            }
        }
    </script>
    
    <style>
        @media print {
            .no-print { display: none !important; }
            .print-break { page-break-after: always; }
            body { font-size: 12px; }
            .invoice-container { box-shadow: none !important; margin: 0 !important; }
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            color: #1f2937;
        }
    </style>
</head>
<body class="bg-gray-100 font-inter">
    
    <!-- Print/Download Actions -->
    <div class="no-print bg-white border-b border-gray-200 py-4 sticky top-0 z-10">
        <div class="max-w-4xl mx-auto px-4 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">Invoice #{{ $order->order_number }}</h1>
                <p class="text-sm text-gray-600">Order placed on {{ $order->created_at->format('M j, Y') }}</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="window.print()" 
                        class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                    <i class="fas fa-print mr-2"></i>
                    Print Invoice
                </button>
                <a href="{{ route('user.orders.show', $order) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Order
                </a>
            </div>
        </div>
    </div>

    <!-- Invoice Content -->
    <div class="py-8 px-4">
        <div class="invoice-container bg-white shadow-lg rounded-lg overflow-hidden">
            
            <!-- Invoice Header -->
            <div class="bg-gradient-to-r from-primary to-secondary text-white p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">INVOICE</h1>
                        <p class="text-lg">#{!! $order->order_number !!}</p>
                    </div>
                    <div class="text-right">
                        <div class="bg-black">
                        <img src="{{ asset('images/logo.png') }}" alt="TKDS Media Logo" class="h-10">
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                    <div>
                        <h3 class="font-semibold mb-2">Invoice Date</h3>
                        <p>{{ $order->created_at->format('M j, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Payment Status</h3>
                        <p>{{ ucfirst($order->payment_status) }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Order Status</h3>
                        <p>{{ ucfirst($order->status) }}</p>
                    </div>
                </div>
            </div>

            <!-- Company & Customer Info -->
            <div class="p-8 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Company Info -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">From</h3>
                        <div class="text-gray-700">
                            <p class="font-semibold">TKDS Media</p>
                            <p>Professional Broadcasting Solutions</p>
                            <p class="mt-2">
                                Email: support@tkdsmedia.com<br>
                                Phone: +1 (555) 123-4567<br>
                                Website: www.tkdsmedia.com
                            </p>
                        </div>
                    </div>
                    
                    <!-- Customer Info -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bill To</h3>
                        <div class="text-gray-700">
                            <p class="font-semibold">{{ $order->billing_address['name'] ?? ($order->billing_address['first_name'] . ' ' . $order->billing_address['last_name']) }}</p>
                            @if(!empty($order->billing_address['company_name']))
                                <p>{{ $order->billing_address['company_name'] }}</p>
                            @endif
                            <p class="mt-2">
                                {{ $order->billing_address['address_line_1'] }}<br>
                                @if(!empty($order->billing_address['address_line_2']))
                                    {{ $order->billing_address['address_line_2'] }}<br>
                                @endif
                                {{ $order->billing_address['city'] }}, {{ $order->billing_address['state'] }} {{ $order->billing_address['postal_code'] }}<br>
                                {{ $order->billing_address['country'] }}
                            </p>
                            @if(!empty($order->billing_address['email']))
                                <p class="mt-2">{{ $order->billing_address['email'] }}</p>
                            @endif
                            @if(!empty($order->billing_address['phone']))
                                <p>{{ $order->billing_address['phone'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Items</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-2 font-semibold text-gray-700">Item</th>
                                <th class="text-center py-3 px-2 font-semibold text-gray-700">Type</th>
                                <th class="text-center py-3 px-2 font-semibold text-gray-700">Qty</th>
                                <th class="text-right py-3 px-2 font-semibold text-gray-700">Unit Price</th>
                                <th class="text-right py-3 px-2 font-semibold text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr class="border-b border-gray-100">
                                <td class="py-4 px-2">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                        <p class="text-sm text-gray-600">SKU: {{ $item->product_sku }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        {{ $item->product_type === 'software' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        <i class="fas fa-{{ $item->product_type === 'software' ? 'download' : 'box' }} mr-1"></i>
                                        {{ $item->product_type === 'software' ? 'Digital' : 'Physical' }}
                                    </span>
                                </td>
                                <td class="py-4 px-2 text-center text-gray-900">{{ $item->quantity }}</td>
                                <td class="py-4 px-2 text-right text-gray-900">{{ $item->getFormattedPrice() }}</td>
                                <td class="py-4 px-2 text-right font-semibold text-gray-900">{{ $item->getFormattedTotal() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 p-8">
                <div class="max-w-md ml-auto">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal:</span>
                            <span>${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        
                        @if($order->shipping_amount > 0)
                        <div class="flex justify-between text-gray-700">
                            <span>Shipping:</span>
                            <span>${{ number_format($order->shipping_amount, 2) }}</span>
                        </div>
                        @endif
                        
                        @if($order->tax_amount > 0)
                        <div class="flex justify-between text-gray-700">
                            <span>Tax:</span>
                            <span>${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        @endif
                        
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between text-gray-700">
                            <span>Discount:</span>
                            <span>-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        
                        <div class="border-t-2 border-gray-300 pt-3">
                            <div class="flex justify-between text-xl font-bold text-gray-900">
                                <span>Total:</span>
                                <span class="text-primary">{{ $order->getFormattedTotal() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            @if($order->isPaid())
            <div class="p-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <div>
                            <p class="font-semibold text-green-800">Payment Completed</p>
                            <p class="text-sm text-green-700">
                                Paid via {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }} on {{ $order->created_at->format('M j, Y \a\t g:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Digital Downloads -->
            @if($order->hasDigitalProducts() && $order->isPaid())
            <div class="p-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Digital Downloads</h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-download text-blue-500 mr-3 mt-1"></i>
                        <div>
                            <p class="font-semibold text-blue-800">Downloads Available</p>
                            <p class="text-sm text-blue-700 mb-2">
                                Your digital products are ready for download. Access them through your account dashboard.
                            </p>
                            <a href="{{ route('user.downloads') }}" 
                               class="no-print inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                Go to Downloads
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Shipping Information -->
            @if($order->hasPhysicalProducts())
            <div class="p-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Ship To</h4>
                        <div class="text-gray-700">
                            <p class="font-semibold">{{ $order->shipping_address['name'] ?? ($order->shipping_address['first_name'] . ' ' . $order->shipping_address['last_name']) }}</p>
                            <p>
                                {{ $order->shipping_address['address_line_1'] }}<br>
                                @if(!empty($order->shipping_address['address_line_2']))
                                    {{ $order->shipping_address['address_line_2'] }}<br>
                                @endif
                                {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['postal_code'] }}<br>
                                {{ $order->shipping_address['country'] }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Shipping Status</h4>
                        <div class="text-gray-700">
                            @php $statusBadge = $order->getStatusBadge() @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusBadge['class'] }}">
                                <i class="{{ $statusBadge['icon'] }} mr-1"></i>
                                {{ $statusBadge['text'] }}
                            </span>
                            
                            @if($order->shipped_at)
                                <p class="mt-2 text-sm">Shipped: {{ $order->shipped_at->format('M j, Y') }}</p>
                            @endif
                            @if($order->delivered_at)
                                <p class="text-sm">Delivered: {{ $order->delivered_at->format('M j, Y') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Footer -->
            <div class="bg-gray-800 text-white p-8">
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-2">Thank you for your business!</h3>
                    <p class="text-gray-300 mb-4">
                        If you have any questions about this invoice, please contact us at support@tkdsmedia.com
                    </p>
                    <div class="flex items-center justify-center space-x-6 text-sm text-gray-400">
                        <span>support@tkdsmedia.com</span>
                        <span>•</span>
                        <span>+1 (555) 123-4567</span>
                        <span>•</span>
                        <span>www.tkdsmedia.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Footer for Print -->
    <div class="print-only text-center mt-8 text-sm text-gray-600" style="display: none;">
        <p>This is a computer-generated invoice. No signature required.</p>
        <p>Generated on {{ now()->format('M j, Y \a\t g:i A') }}</p>
    </div>

    <script>
        // Show print footer only when printing
        window.addEventListener('beforeprint', function() {
            document.querySelector('.print-only').style.display = 'block';
        });
        
        window.addEventListener('afterprint', function() {
            document.querySelector('.print-only').style.display = 'none';
        });
        
        // Auto-print if URL has print parameter
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === 'true') {
            window.print();
        }
    </script>
</body>
</html>