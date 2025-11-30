{{-- File: resources/views/admin/shop/inventory/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Inventory Management')
@section('page-title', 'Inventory Management')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Inventory Management</h2>
            <p class="text-gray-600 text-sm mt-1">Track and manage your product stock levels</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.shop.inventory.low-stock') }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition-colors duration-200">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Low Stock Alert
            </a>
            <button onclick="bulkUpdateInventory()" 
                    class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Bulk Update
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Products</p>
                    <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
                </div>
                <i class="fas fa-cube text-2xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">In Stock</p>
                    <p class="text-2xl font-bold">{{ $stats['in_stock'] }}</p>
                </div>
                <i class="fas fa-check-circle text-2xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Low Stock</p>
                    <p class="text-2xl font-bold">{{ $stats['low_stock'] }}</p>
                </div>
                <i class="fas fa-exclamation-triangle text-2xl text-yellow-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Out of Stock</p>
                    <p class="text-2xl font-bold">{{ $stats['out_of_stock'] }}</p>
                </div>
                <i class="fas fa-times-circle text-2xl text-red-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Value</p>
                    <p class="text-2xl font-bold">${{ number_format($stats['total_value'], 0) }}</p>
                </div>
                <i class="fas fa-dollar-sign text-2xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search products..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            <div>
                <select name="stock_level" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Stock Levels</option>
                    <option value="in_stock" {{ request('stock_level') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low_stock" {{ request('stock_level') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" {{ request('stock_level') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="flex-1 bg-primary text-white px-4 py-3 rounded-xl hover:bg-secondary transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.shop.inventory.index') }}" 
                   class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-primary focus:ring-primary">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">SKU</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Current Stock</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="selected_products[]" value="{{ $product->id }}" 
                                           class="product-checkbox rounded border-gray-300 text-primary focus:ring-primary">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $product->getFeaturedImageUrl() }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $product->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900">{{ $product->category?->name ?? 'No Category' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-mono text-gray-900">{{ $product->sku ?: 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-gray-900">{{ $product->getFormattedPrice() }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <input type="number" 
                                               value="{{ $product->stock_quantity }}" 
                                               min="0"
                                               data-product-id="{{ $product->id }}"
                                               class="stock-input w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary focus:border-primary">
                                        
                                        @if($product->stock_quantity <= 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Out
                                            </span>
                                        @elseif($product->stock_quantity <= 5)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Low
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Good
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php $stockBadge = $product->getStockBadge() @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $stockBadge['class'] }}">
                                        <i class="{{ $stockBadge['icon'] }} mr-1"></i>
                                        {{ $stockBadge['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <button onclick="updateSingleStock({{ $product->id }})" 
                                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                                title="Update Stock">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <a href="{{ route('admin.shop.products.edit', $product) }}" 
                                           class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                           title="Edit Product">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-boxes text-4xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No inventory found</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">No physical products with inventory tracking enabled.</p>
            </div>
        @endif
    </div>
</div>

<!-- Bulk Update Modal -->
<div id="bulkUpdateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bulk Update Inventory</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                <select id="bulkAction" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="set">Set to specific value</option>
                    <option value="increase">Increase by amount</option>
                    <option value="decrease">Decrease by amount</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                <input type="number" id="bulkAmount" min="0" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
        </div>
        <div class="flex justify-end space-x-4 mt-6">
            <button onclick="closeBulkModal()" 
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50">
                Cancel
            </button>
            <button onclick="executeBulkUpdate()" 
                    class="px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary">
                Update
            </button>
        </div>
    </div>
</div>

<script>
// Select All functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Update single product stock
function updateSingleStock(productId) {
    const input = document.querySelector(`input[data-product-id="${productId}"]`);
    const newStock = parseInt(input.value);
    
    if (isNaN(newStock) || newStock < 0) {
        alert('Please enter a valid stock quantity');
        return;
    }
    
    fetch(`{{ route('admin.shop.inventory.bulk-update') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            updates: [{
                product_id: productId,
                stock_quantity: newStock
            }]
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to update stock');
        }
    });
}

// Bulk update functionality
function bulkUpdateInventory() {
    const selected = document.querySelectorAll('.product-checkbox:checked');
    if (selected.length === 0) {
        alert('Please select products to update');
        return;
    }
    document.getElementById('bulkUpdateModal').classList.remove('hidden');
}

function closeBulkModal() {
    document.getElementById('bulkUpdateModal').classList.add('hidden');
}

function executeBulkUpdate() {
    const selected = document.querySelectorAll('.product-checkbox:checked');
    const action = document.getElementById('bulkAction').value;
    const amount = parseInt(document.getElementById('bulkAmount').value);
    
    if (isNaN(amount) || amount < 0) {
        alert('Please enter a valid amount');
        return;
    }
    
    const updates = Array.from(selected).map(checkbox => {
        const productId = checkbox.value;
        const currentStock = parseInt(document.querySelector(`input[data-product-id="${productId}"]`).value);
        
        let newStock;
        switch (action) {
            case 'set':
                newStock = amount;
                break;
            case 'increase':
                newStock = currentStock + amount;
                break;
            case 'decrease':
                newStock = Math.max(0, currentStock - amount);
                break;
        }
        
        return {
            product_id: productId,
            stock_quantity: newStock
        };
    });
    
    fetch(`{{ route('admin.shop.inventory.bulk-update') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ updates })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to update inventory');
        }
    });
}
</script>
@endsection