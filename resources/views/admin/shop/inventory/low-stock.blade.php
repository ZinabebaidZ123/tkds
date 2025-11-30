{{-- File: resources/views/admin/shop/inventory/low-stock.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Low Stock Products')
@section('page-title', 'Low Stock Products')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.shop.inventory.index') }}" 
               class="p-2 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Low Stock Alert</h2>
                <p class="text-gray-600 text-sm mt-1">Products with stock level ≤ 5 units</p>
            </div>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.shop.inventory.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-boxes mr-2"></i>
                All Inventory
            </a>
            <button onclick="bulkRestock()" 
                    class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Bulk Restock
            </button>
        </div>
    </div>

    <!-- Alert Banner -->
    @if($products->count() > 0)
        <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-400 p-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-red-800 font-bold text-lg">⚠️ Low Stock Alert!</h3>
                    <p class="text-red-700 mt-1">
                        You have <strong>{{ $products->count() }}</strong> products running low on stock. 
                        Consider restocking these items to avoid stockouts.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Low Stock Products -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        @if($products->count() > 0)
            <!-- Bulk Actions Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="selectAll" 
                               class="w-5 h-5 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
                        <label for="selectAll" class="text-sm font-medium text-gray-700">Select All</label>
                        <span class="text-sm text-gray-500">({{ $products->count() }} products)</span>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="bulkUpdateSelected()" 
                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200 disabled:opacity-50"
                                id="bulkUpdateBtn" disabled>
                            <i class="fas fa-edit mr-2"></i>
                            Update Selected
                        </button>
                        <button onclick="exportLowStock()" 
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>
                            Export List
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                                <input type="checkbox" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Current Stock</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Last Sale</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors duration-200" data-product-id="{{ $product->id }}">
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="product-checkbox w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded" 
                                           value="{{ $product->id }}">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $product->getFeaturedImageUrl() }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                                            @if($product->sku)
                                                <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                                            @endif
                                            <p class="text-sm font-medium text-primary">{{ $product->getFormattedPrice() }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->category)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $product->category->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">No Category</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <input type="number" 
                                               value="{{ $product->stock_quantity }}" 
                                               min="0"
                                               class="stock-input w-20 px-2 py-1 border border-gray-300 rounded text-center focus:ring-2 focus:ring-primary focus:border-primary"
                                               data-product-id="{{ $product->id }}"
                                               data-original="{{ $product->stock_quantity }}">
                                        <div class="text-center">
                                            @if($product->stock_quantity == 0)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Out of Stock
                                                </span>
                                            @elseif($product->stock_quantity <= 2)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    Critical
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Low Stock
                                                </span>
                                            @endif
                                        </div>
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
                                    @php $lastOrder = $product->orderItems()->with('order')->latest()->first() @endphp
                                    @if($lastOrder)
                                        <div class="text-sm">
                                            <p class="font-medium text-gray-900">{{ $lastOrder->order->created_at->format('M j, Y') }}</p>
                                            <p class="text-gray-500">Qty: {{ $lastOrder->quantity }}</p>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">No sales yet</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="quickUpdate({{ $product->id }})" 
                                                class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200"
                                                title="Quick Update">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <button onclick="restockProduct({{ $product->id }})" 
                                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200"
                                                title="Quick Restock">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <a href="{{ route('admin.shop.products.show', $product) }}" 
                                           class="text-gray-600 hover:text-gray-800 p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                                           title="View Product">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-check-circle text-4xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">All Good! 🎉</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">
                    No products are running low on stock. All your inventory levels are healthy.
                </p>
                <a href="{{ route('admin.shop.inventory.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-xl hover:bg-secondary transition-colors duration-200">
                    <i class="fas fa-boxes mr-2"></i>
                    View All Inventory
                </a>
            </div>
        @endif
    </div>

    <!-- Quick Tips -->
    @if($products->count() > 0)
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-lightbulb text-yellow-500 mr-3"></i>
                Inventory Management Tips
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-line text-white text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Monitor Trends</h4>
                        <p class="text-sm text-gray-600">Track sales patterns to predict when to restock.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-bell text-white text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Set Alerts</h4>
                        <p class="text-sm text-gray-600">Configure automatic low stock notifications.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-sync text-white text-sm"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Auto Reorder</h4>
                        <p class="text-sm text-gray-600">Consider setting up automatic reorder points.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Restock Modal -->
<div id="restockModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Restock</h3>
        <form id="restockForm">
            <input type="hidden" id="restockProductId">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Add Stock Quantity</label>
                    <input type="number" id="restockQuantity" min="1" value="10"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <p class="text-xs text-gray-500 mt-1">Enter quantity to add to current stock</p>
                </div>
            </div>
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeRestockModal()" 
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-primary text-white rounded-xl hover:bg-secondary">
                    Add Stock
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Update Modal -->
<div id="bulkModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl p-6 max-w-lg w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bulk Stock Update</h3>
        <form id="bulkForm">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                    <select id="bulkAction" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="add">Add to current stock</option>
                        <option value="set">Set exact stock level</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <input type="number" id="bulkQuantity" min="1" value="10"
                           class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                <div id="selectedProducts" class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-sm text-gray-600">No products selected</p>
                </div>
            </div>
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeBulkModal()" 
                        class="px-4 py-2 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-primary text-white rounded-xl hover:bg-secondary">
                    Update All
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const bulkUpdateBtn = document.getElementById('bulkUpdateBtn');

    selectAllCheckbox.addEventListener('change', function() {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkButton();
    });

    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkButton);
    });

    function updateBulkButton() {
        const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
        bulkUpdateBtn.disabled = checkedBoxes.length === 0;
        
        if (checkedBoxes.length > 0) {
            bulkUpdateBtn.textContent = `Update Selected (${checkedBoxes.length})`;
        } else {
            bulkUpdateBtn.textContent = 'Update Selected';
        }
    }

    // Stock input change detection
    const stockInputs = document.querySelectorAll('.stock-input');
    stockInputs.forEach(input => {
        input.addEventListener('change', function() {
            const original = parseInt(this.dataset.original);
            const current = parseInt(this.value);
            
            if (current !== original) {
                this.classList.add('border-yellow-500', 'bg-yellow-50');
                this.parentElement.parentElement.classList.add('bg-yellow-50');
            } else {
                this.classList.remove('border-yellow-500', 'bg-yellow-50');
                this.parentElement.parentElement.classList.remove('bg-yellow-50');
            }
        });
    });
});

function quickUpdate(productId) {
    const input = document.querySelector(`input[data-product-id="${productId}"]`);
    const newStock = parseInt(input.value);
    
    updateStock(productId, newStock);
}

function restockProduct(productId) {
    document.getElementById('restockProductId').value = productId;
    document.getElementById('restockModal').classList.remove('hidden');
}

function closeRestockModal() {
    document.getElementById('restockModal').classList.add('hidden');
}

function bulkRestock() {
    // Quick bulk restock all visible products
    if (confirm('Add 10 units to all low stock products?')) {
        const productIds = Array.from(document.querySelectorAll('[data-product-id]')).map(el => el.dataset.productId);
        
        const updates = productIds.map(id => {
            const input = document.querySelector(`input[data-product-id="${id}"]`);
            return {
                product_id: parseInt(id),
                stock_quantity: parseInt(input.value) + 10
            };
        });

        bulkUpdateStock(updates);
    }
}

function bulkUpdateSelected() {
    const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        alert('Please select products to update');
        return;
    }

    // Update selected products display
    const selectedProducts = document.getElementById('selectedProducts');
    selectedProducts.innerHTML = `<p class="text-sm text-gray-900 font-medium">${selectedIds.length} products selected</p>`;
    
    document.getElementById('bulkModal').classList.remove('hidden');
}

function closeBulkModal() {
    document.getElementById('bulkModal').classList.add('hidden');
}

function exportLowStock() {
    window.location.href = '{{ route("admin.shop.products.export") }}?stock_level=low';
}

// Form submissions
document.getElementById('restockForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const productId = document.getElementById('restockProductId').value;
    const addQuantity = parseInt(document.getElementById('restockQuantity').value);
    const currentInput = document.querySelector(`input[data-product-id="${productId}"]`);
    const newStock = parseInt(currentInput.value) + addQuantity;
    
    updateStock(productId, newStock);
    closeRestockModal();
});

document.getElementById('bulkForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
    const action = document.getElementById('bulkAction').value;
    const quantity = parseInt(document.getElementById('bulkQuantity').value);
    
    const updates = selectedIds.map(id => {
        const input = document.querySelector(`input[data-product-id="${id}"]`);
        const currentStock = parseInt(input.value);
        const newStock = action === 'add' ? currentStock + quantity : quantity;
        
        return {
            product_id: parseInt(id),
            stock_quantity: newStock
        };
    });

    bulkUpdateStock(updates);
    closeBulkModal();
});

function updateStock(productId, newStock) {
    fetch('/admin/shop/inventory/bulk-update', {
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

function bulkUpdateStock(updates) {
    fetch('/admin/shop/inventory/bulk-update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ updates: updates })
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
</script>
@endsection