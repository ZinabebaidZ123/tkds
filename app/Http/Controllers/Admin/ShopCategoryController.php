<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShopCategoryController extends Controller
{
    public function index()
    {
        $categories = ShopCategory::with(['parent', 'children'])
                                  ->withCount(['products', 'activeProducts'])
                                  ->orderBy('sort_order', 'asc')
                                  ->paginate(20);

        $stats = [
            'total' => ShopCategory::count(),
            'active' => ShopCategory::active()->count(),
            'inactive' => ShopCategory::where('status', 'inactive')->count(),
            'featured' => ShopCategory::featured()->count(),
        ];

        return view('admin.shop.categories.index', compact('categories', 'stats'));
    }

    public function create()
    {
        $parentCategories = ShopCategory::active()->parent()->ordered()->get();
        return view('admin.shop.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:shop_categories,slug',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:shop_categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        try {
            $data = $request->all();

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('shop/categories', 'public');
            }

            // Set default sort order
            if (!isset($data['sort_order'])) {
                $maxOrder = ShopCategory::max('sort_order') ?? 0;
                $data['sort_order'] = $maxOrder + 1;
            }

            ShopCategory::create($data);

            return redirect()->route('admin.shop.categories.index')
                           ->with('success', 'Category created successfully!');

        } catch (\Exception $e) {
            \Log::error('Category creation failed', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()
                           ->withErrors(['error' => 'Failed to create category: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    public function show(ShopCategory $category)
    {
        $category->load(['parent', 'children', 'products']);
        
        $stats = [
            'total_products' => $category->products()->count(),
            'active_products' => $category->activeProducts()->count(),
            'featured_products' => $category->products()->where('is_featured', true)->count(),
            'total_revenue' => $category->products()
                                      ->join('shop_order_items', 'shop_products.id', '=', 'shop_order_items.product_id')
                                      ->sum('shop_order_items.total'),
        ];

        return view('admin.shop.categories.show', compact('category', 'stats'));
    }

    public function edit(ShopCategory $category)
    {
        $parentCategories = ShopCategory::active()
                                       ->parent()
                                       ->where('id', '!=', $category->id)
                                       ->ordered()
                                       ->get();
        
        return view('admin.shop.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, ShopCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:shop_categories,slug,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:100',
            'parent_id' => 'nullable|exists:shop_categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        // Prevent setting parent to self or descendant
        if ($request->parent_id) {
            if ($request->parent_id == $category->id) {
                return redirect()->back()
                               ->withErrors(['parent_id' => 'Category cannot be its own parent'])
                               ->withInput();
            }

            // Check if parent_id is a descendant
            $descendants = $this->getDescendantIds($category);
            if (in_array($request->parent_id, $descendants)) {
                return redirect()->back()
                               ->withErrors(['parent_id' => 'Cannot set descendant as parent'])
                               ->withInput();
            }
        }

        try {
            $data = $request->all();

            // Generate slug if not provided
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $data['image'] = $request->file('image')->store('shop/categories', 'public');
            }

            $category->update($data);

            return redirect()->route('admin.shop.categories.index')
                           ->with('success', 'Category updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Category update failed', [
                'category_id' => $category->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                           ->withErrors(['error' => 'Failed to update category: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    public function destroy(ShopCategory $category)
    {
        try {
            // Check if category has products
            if ($category->products()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with products. Please reassign or delete products first.'
                ], 400);
            }

            // Check if category has children
            if ($category->children()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with subcategories. Please delete subcategories first.'
                ], 400);
            }

            // Delete image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Category deletion failed', [
                'category_id' => $category->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category'
            ], 500);
        }
    }
public function updateStatus(Request $request, ShopCategory $category)
{
    $request->validate([
        'status' => 'required|in:active,inactive'
    ]);

    try {
        $category->update(['status' => $request->status]);

        \Log::info('Category status updated', [
            'category_id' => $category->id,
            'new_status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category status updated successfully',
            'data' => [
                'id' => $category->id,
                'status' => $category->status
            ]
        ]);

    } catch (\Exception $e) {
        \Log::error('Category status update failed', [
            'category_id' => $category->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to update category status: ' . $e->getMessage()
        ], 500);
    }
}

    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:shop_categories,id',
            'categories.*.sort_order' => 'required|integer|min:0'
        ]);

        try {
            foreach ($request->categories as $categoryData) {
                ShopCategory::where('id', $categoryData['id'])
                           ->update(['sort_order' => $categoryData['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Sort order updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update sort order'
            ], 500);
        }
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,mark_featured,unmark_featured',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:shop_categories,id'
        ]);

        try {
            $categories = ShopCategory::whereIn('id', $request->category_ids);

            switch ($request->action) {
                case 'delete':
                    // Check if any categories have products or children
                    $hasProducts = $categories->whereHas('products')->exists();
                    $hasChildren = $categories->whereHas('children')->exists();
                    
                    if ($hasProducts || $hasChildren) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot delete categories with products or subcategories'
                        ], 400);
                    }
                    
                    $categories->delete();
                    $message = 'Categories deleted successfully';
                    break;

                case 'activate':
                    $categories->update(['status' => 'active']);
                    $message = 'Categories activated successfully';
                    break;

                case 'deactivate':
                    $categories->update(['status' => 'inactive']);
                    $message = 'Categories deactivated successfully';
                    break;

                case 'mark_featured':
                    $categories->update(['is_featured' => true]);
                    $message = 'Categories marked as featured';
                    break;

                case 'unmark_featured':
                    $categories->update(['is_featured' => false]);
                    $message = 'Categories unmarked as featured';
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

    public function getTreeData()
    {
        $categories = ShopCategory::with('children')->parent()->ordered()->get();
        
        return response()->json([
            'success' => true,
            'data' => $this->buildCategoryTree($categories)
        ]);
    }

    // Helper Methods

    private function getDescendantIds(ShopCategory $category): array
    {
        $descendants = [];
        
        foreach ($category->children as $child) {
            $descendants[] = $child->id;
            $descendants = array_merge($descendants, $this->getDescendantIds($child));
        }
        
        return $descendants;
    }

    private function buildCategoryTree($categories): array
    {
        return $categories->map(function($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'status' => $category->status,
                'products_count' => $category->getProductsCount(),
                'children' => $this->buildCategoryTree($category->children)
            ];
        })->toArray();
    }
}