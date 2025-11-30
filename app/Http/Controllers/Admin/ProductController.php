<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return view('admin.products.index', compact('products'));
        } catch (Exception $e) {
            Log::error('Products Index Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading products: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.products.addedit');
        } catch (Exception $e) {
            Log::error('Product Create View Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // Log the incoming request for debugging
            Log::info('Product Store Request', [
                'request_data' => $request->except(['image', 'hero_image']), // Don't log file contents
                'has_image' => $request->hasFile('image'),
                'has_hero_image' => $request->hasFile('hero_image'),
                'image_info' => $request->hasFile('image') ? [
                    'name' => $request->file('image')->getClientOriginalName(),
                    'size' => $request->file('image')->getSize(),
                    'mime' => $request->file('image')->getMimeType(),
                    'extension' => $request->file('image')->getClientOriginalExtension()
                ] : 'No image',
                'hero_image_info' => $request->hasFile('hero_image') ? [
                    'name' => $request->file('hero_image')->getClientOriginalName(),
                    'size' => $request->file('hero_image')->getSize(),
                    'mime' => $request->file('hero_image')->getMimeType(),
                    'extension' => $request->file('hero_image')->getClientOriginalExtension()
                ] : 'No hero image'
            ]);

            // Clean the features and specifications arrays BEFORE validation
            $requestData = $request->all();

            // Clean features array - remove empty/null values
            if (isset($requestData['features']) && is_array($requestData['features'])) {
                $requestData['features'] = array_filter($requestData['features'], function ($value) {
                    return !is_null($value) && trim($value) !== '';
                });
                $requestData['features'] = array_values($requestData['features']); // Re-index array
            }

            // Clean specifications array - remove empty/null values  
            if (isset($requestData['specifications']) && is_array($requestData['specifications'])) {
                $requestData['specifications'] = array_filter($requestData['specifications'], function ($value) {
                    return !is_null($value) && trim($value) !== '';
                });
                $requestData['specifications'] = array_values($requestData['specifications']); // Re-index array
            }

            // Replace the request data with cleaned data (but keep original files)
            $originalFiles = $request->allFiles();
            $request->replace($requestData);

            // Re-attach files to request
            foreach ($originalFiles as $key => $file) {
                $request->files->set($key, $file);
            }

            Log::info('Cleaned request data', [
                'features' => $requestData['features'] ?? [],
                'specifications' => $requestData['specifications'] ?? [],
                'files_reattached' => array_keys($originalFiles)
            ]);

            // More lenient file validation
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:products,slug',
                'subtitle' => 'nullable|string|max:500',
                'description' => 'required|string',
                'short_description' => 'nullable|string|max:1000',
                'icon' => 'required|string|max:100',
                // More lenient file validation
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:10240', // 10MB max
                'hero_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:10240', // 10MB max
                'color_from' => 'required|string|max:50',
                'color_to' => 'required|string|max:50',
                'border_color' => 'required|string|max:50',
                'category' => 'required|in:saas,software,hardware,service',
                'price' => 'nullable|numeric|min:0',
                'currency' => 'nullable|string|max:10',
                'pricing_model' => 'required|in:free,one_time,subscription,quote',
                'route_name' => 'nullable|string|max:255',
                'external_url' => 'nullable|url|max:500',
                'features' => 'nullable|array',
                'features.*' => 'nullable|string|max:255',
                'specifications' => 'nullable|array',
                'specifications.*' => 'nullable|string|max:255',
                'demo_url' => 'nullable|url|max:500',
                'video_url' => 'nullable|url|max:500',
                'documentation_url' => 'nullable|url|max:500',
                'github_url' => 'nullable|url|max:500',
                'is_featured' => 'sometimes|boolean',
                'show_in_navbar' => 'sometimes|boolean',
                'show_in_homepage' => 'sometimes|boolean',
                'show_pricing' => 'sometimes|boolean',
                'status' => 'required|in:active,inactive,coming_soon',
                'sort_order' => 'required|integer|min:0',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:1000',
            ]);

            Log::info('Validation passed', [
                'title' => $validatedData['title'],
                'has_image_in_validated' => isset($validatedData['image']),
                'has_hero_image_in_validated' => isset($validatedData['hero_image'])
            ]);

            // Start database transaction
            DB::beginTransaction();

            // Prepare the data array
            $data = $validatedData;

            // Generate slug if not provided
            $data['slug'] = $request->slug ?: Str::slug($request->title);

            // Ensure slug is unique
            $originalSlug = $data['slug'];
            $count = 1;
            while (Product::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $count;
                $count++;
            }

            // Handle boolean fields - Convert string values to boolean
            $data['is_featured'] = $request->has('is_featured') && $request->is_featured !== '0' ? true : false;
            $data['show_in_navbar'] = $request->has('show_in_navbar') && $request->show_in_navbar !== '0' ? true : false;
            $data['show_in_homepage'] = $request->has('show_in_homepage') && $request->show_in_homepage !== '0' ? true : false;
            $data['show_pricing'] = $request->has('show_pricing') && $request->show_pricing !== '0' ? true : false;

            // Handle main image upload with better error handling
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    Log::info('Processing main image', [
                        'original_name' => $image->getClientOriginalName(),
                        'size' => $image->getSize(),
                        'mime_type' => $image->getMimeType(),
                        'is_valid' => $image->isValid()
                    ]);

                    if (!$image->isValid()) {
                        throw new Exception('Uploaded image is not valid');
                    }

                    // Create directory if it doesn't exist
                    $directory = storage_path('app/public/products');
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    $imagePath = $image->store('products', 'public');
                    $data['image'] = $imagePath;
                    Log::info('Main image uploaded successfully', ['path' => $imagePath]);
                } catch (Exception $e) {
                    Log::error('Main image upload failed', [
                        'error' => $e->getMessage(),
                        'file_info' => $request->hasFile('image') ? [
                            'name' => $request->file('image')->getClientOriginalName(),
                            'size' => $request->file('image')->getSize(),
                            'error' => $request->file('image')->getError()
                        ] : 'No file'
                    ]);
                    throw new Exception('Failed to upload main image: ' . $e->getMessage());
                }
            }

            // Handle hero image upload with better error handling
            if ($request->hasFile('hero_image')) {
                try {
                    $heroImage = $request->file('hero_image');
                    Log::info('Processing hero image', [
                        'original_name' => $heroImage->getClientOriginalName(),
                        'size' => $heroImage->getSize(),
                        'mime_type' => $heroImage->getMimeType(),
                        'is_valid' => $heroImage->isValid()
                    ]);

                    if (!$heroImage->isValid()) {
                        throw new Exception('Uploaded hero image is not valid');
                    }

                    // Create directory if it doesn't exist
                    $directory = storage_path('app/public/products/hero');
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    $heroImagePath = $heroImage->store('products/hero', 'public');
                    $data['hero_image'] = $heroImagePath;
                    Log::info('Hero image uploaded successfully', ['path' => $heroImagePath]);
                } catch (Exception $e) {
                    Log::error('Hero image upload failed', [
                        'error' => $e->getMessage(),
                        'file_info' => $request->hasFile('hero_image') ? [
                            'name' => $request->file('hero_image')->getClientOriginalName(),
                            'size' => $request->file('hero_image')->getSize(),
                            'error' => $request->file('hero_image')->getError()
                        ] : 'No file'
                    ]);
                    throw new Exception('Failed to upload hero image: ' . $e->getMessage());
                }
            }

            // Handle features array - Already cleaned above
            $data['features'] = isset($requestData['features']) && !empty($requestData['features'])
                ? array_values($requestData['features'])
                : [];

            // Handle specifications array - Already cleaned above
            $data['specifications'] = isset($requestData['specifications']) && !empty($requestData['specifications'])
                ? array_values($requestData['specifications'])
                : [];

            Log::info('Final data prepared for creation', [
                'features_count' => count($data['features']),
                'specifications_count' => count($data['specifications']),
                'has_image' => isset($data['image']),
                'has_hero_image' => isset($data['hero_image'])
            ]);

            // Create the product
            $product = Product::create($data);

            Log::info('Product created successfully', [
                'product_id' => $product->id,
                'slug' => $product->slug
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            Log::error('Validation Error in Product Store', [
                'errors' => $e->errors(),
                'request_files' => $request->hasFile('image') || $request->hasFile('hero_image') ? 'Has files' : 'No files'
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Product Store Error', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Error creating product: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Product $product)
    {
        try {
            return view('admin.products.show', compact('product'));
        } catch (Exception $e) {
            Log::error('Product Show Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading product: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        try {
            return view('admin.products.addedit', compact('product'));
        } catch (Exception $e) {
            Log::error('Product Edit Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            Log::info('Product Update Request', [
                'product_id' => $product->id,
                'request_data' => $request->except(['image', 'hero_image']),
                'has_image' => $request->hasFile('image'),
                'has_hero_image' => $request->hasFile('hero_image')
            ]);

            // Clean arrays like in store method
            $requestData = $request->all();

            if (isset($requestData['features']) && is_array($requestData['features'])) {
                $requestData['features'] = array_filter($requestData['features'], function ($value) {
                    return !is_null($value) && trim($value) !== '';
                });
                $requestData['features'] = array_values($requestData['features']);
            }

            if (isset($requestData['specifications']) && is_array($requestData['specifications'])) {
                $requestData['specifications'] = array_filter($requestData['specifications'], function ($value) {
                    return !is_null($value) && trim($value) !== '';
                });
                $requestData['specifications'] = array_values($requestData['specifications']);
            }

            // Replace request data but keep files
            $originalFiles = $request->allFiles();
            $request->replace($requestData);
            foreach ($originalFiles as $key => $file) {
                $request->files->set($key, $file);
            }

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
                'subtitle' => 'nullable|string|max:500',
                'description' => 'required|string',
                'short_description' => 'nullable|string|max:1000',
                'icon' => 'required|string|max:100',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
                'hero_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
                'color_from' => 'required|string|max:50',
                'color_to' => 'required|string|max:50',
                'border_color' => 'required|string|max:50',
                'category' => 'required|in:saas,software,hardware,service',
                'price' => 'nullable|numeric|min:0',
                'currency' => 'nullable|string|max:10',
                'pricing_model' => 'required|in:free,one_time,subscription,quote',
                'route_name' => 'nullable|string|max:255',
                'external_url' => 'nullable|url|max:500',
                'features' => 'nullable|array',
                'features.*' => 'nullable|string|max:255',
                'specifications' => 'nullable|array',
                'specifications.*' => 'nullable|string|max:255',
                'demo_url' => 'nullable|url|max:500',
                'video_url' => 'nullable|url|max:500',
                'documentation_url' => 'nullable|url|max:500',
                'github_url' => 'nullable|url|max:500',
                'is_featured' => 'sometimes|boolean',
                'show_in_navbar' => 'sometimes|boolean',
                'show_in_homepage' => 'sometimes|boolean',
                'show_pricing' => 'sometimes|boolean',
                'status' => 'required|in:active,inactive,coming_soon',
                'sort_order' => 'required|integer|min:0',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:1000',
            ]);

            DB::beginTransaction();

            $data = $validatedData;
            $data['slug'] = $request->slug ?: Str::slug($request->title);

            // Handle boolean fields
            $data['is_featured'] = $request->has('is_featured') && $request->is_featured !== '0' ? true : false;
            $data['show_in_navbar'] = $request->has('show_in_navbar') && $request->show_in_navbar !== '0' ? true : false;
            $data['show_in_homepage'] = $request->has('show_in_homepage') && $request->show_in_homepage !== '0' ? true : false;
            $data['show_pricing'] = $request->has('show_pricing') && $request->show_pricing !== '0' ? true : false;

            // Handle main image upload
            if ($request->hasFile('image')) {
                // Delete old image if it's not a URL
                if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($product->image);
                }

                $imagePath = $request->file('image')->store('products', 'public');
                $data['image'] = $imagePath;
            }

            // Handle hero image upload
            if ($request->hasFile('hero_image')) {
                // Delete old hero image if it's not a URL
                if ($product->hero_image && !filter_var($product->hero_image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($product->hero_image);
                }

                $heroImagePath = $request->file('hero_image')->store('products/hero', 'public');
                $data['hero_image'] = $heroImagePath;
            }

            // Handle arrays
            $data['features'] = isset($requestData['features']) && !empty($requestData['features'])
                ? array_values($requestData['features'])
                : [];

            $data['specifications'] = isset($requestData['specifications']) && !empty($requestData['specifications'])
                ? array_values($requestData['specifications'])
                : [];

            $product->update($data);

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            Log::error('Validation Error in Product Update', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Product Update Error: ' . $e->getMessage());
            return back()->with('error', 'Error updating product: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Delete main image if it's not a URL
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->image);
            }

            // Delete hero image if it's not a URL
            if ($product->hero_image && !filter_var($product->hero_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->hero_image);
            }

            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Product Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    /**
     * Update product status
     */
    public function updateStatus(Request $request, Product $product)
    {
        try {
            Log::info('updateStatus called', [
                'product_id' => $product->id,
                'request_data' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            $request->validate([
                'status' => 'required|in:active,inactive,coming_soon',
            ]);

            $product->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'status' => $product->status
            ]);
        } catch (Exception $e) {
            Log::error('Update Status Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update products sort order
     */
    public function updateSortOrder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:products,id',
                'items.*.sort_order' => 'required|integer|min:0',
            ]);

            DB::beginTransaction();

            foreach ($request->items as $item) {
                Product::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sort order updated successfully.'
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Update Sort Order Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating sort order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Duplicate a product
     */
    public function duplicate(Product $product)
    {
        try {
            DB::beginTransaction();

            $newProduct = $product->replicate();
            $newProduct->title = $product->title . ' (Copy)';
            $newProduct->slug = Str::slug($newProduct->title);

            // Ensure unique slug
            $originalSlug = $newProduct->slug;
            $count = 1;
            while (Product::where('slug', $newProduct->slug)->exists()) {
                $newProduct->slug = $originalSlug . '-' . $count;
                $count++;
            }

            $newProduct->status = 'inactive';
            $newProduct->is_featured = false;
            $newProduct->save();

            DB::commit();

            return redirect()->route('admin.products.edit', $newProduct)
                ->with('success', 'Product duplicated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Product Duplicate Error: ' . $e->getMessage());
            return back()->with('error', 'Error duplicating product: ' . $e->getMessage());
        }
    }

    /**
     * Show page content editor for product
     */
    public function pageContent(Product $product)
    {
        try {
            return view('admin.products.page-content', compact('product'));
        } catch (Exception $e) {
            Log::error('Page Content View Error: ' . $e->getMessage());
            return back()->with('error', 'Error loading page content: ' . $e->getMessage());
        }
    }

    /**
     * Update page content for product
     */
    public function updatePageContent(Request $request, Product $product)
    {
        try {
            $request->validate([
                'hero_title' => 'nullable|string|max:255',
                'hero_subtitle' => 'nullable|string|max:255',
                'hero_description' => 'nullable|string',
                'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'hero_badge_text' => 'nullable|string|max:100',
                'hero_badge_color' => 'nullable|string|max:50',
                'page_content' => 'nullable|string',
                'key_features' => 'nullable|array',
                'benefits' => 'nullable|array',
                'use_cases' => 'nullable|array',
                'tech_stack' => 'nullable|array',
                'system_requirements' => 'nullable|array',
                'cta_title' => 'nullable|string|max:255',
                'cta_description' => 'nullable|string',
                'cta_button_text' => 'nullable|string|max:100',
                'cta_button_link' => 'nullable|string|max:500',
            ]);

            DB::beginTransaction();

            $data = $request->only([
                'hero_title',
                'hero_subtitle',
                'hero_description',
                'hero_badge_text',
                'hero_badge_color',
                'page_content',
                'key_features',
                'benefits',
                'use_cases',
                'tech_stack',
                'system_requirements',
                'cta_title',
                'cta_description',
                'cta_button_text',
                'cta_button_link'
            ]);

            // Handle hero image upload
            if ($request->hasFile('hero_image')) {
                // Delete old hero image if it's not a URL
                if ($product->hero_image && !filter_var($product->hero_image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($product->hero_image);
                }

                $heroImagePath = $request->file('hero_image')->store('products/hero', 'public');
                $data['hero_image'] = $heroImagePath;
            }

            $product->update($data);

            DB::commit();

            return redirect()->route('admin.products.page-content', $product)
                ->with('success', 'Page content updated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Update Page Content Error: ' . $e->getMessage());
            return back()->with('error', 'Error updating page content: ' . $e->getMessage())->withInput();
        }
    }

    public function getSectionTitle()
{
    $firstProduct = Product::active()->showInHomepage()->ordered()->first();
    
    return response()->json([
        'success' => true,
        'title_part1' => $firstProduct->title_part1 ?? '',
        'title_part2' => $firstProduct->title_part2 ?? '',
        'subtitle' => $firstProduct->subtitle_section ?? ''
    ]);
}

public function updateSectionTitle(Request $request)
{
    try {
        $request->validate([
            'title_part1' => 'nullable|string|max:255',
            'title_part2' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        $firstProduct = Product::active()->showInHomepage()->ordered()->first();
        
        if ($firstProduct) {
            $firstProduct->update([
                'title_part1' => $request->title_part1,
                'title_part2' => $request->title_part2,
                'subtitle_section' => $request->subtitle
            ]);
        } else {
            Product::create([
                'title_part1' => $request->title_part1,
                'title_part2' => $request->title_part2,
                'subtitle_section' => $request->subtitle,
                'title' => 'Default Product',
                'slug' => 'default-product',
                'description' => 'This is a default product created for section title management.',
                'short_description' => 'Default product for section title.',
                'icon' => 'fas fa-cube',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800',
                'color_from' => 'blue-500',
                'color_to' => 'purple-600',
                'border_color' => 'blue-500',
                'category' => 'saas',
                'pricing_model' => 'subscription',
                'status' => 'active',
                'show_in_homepage' => true,
                'sort_order' => 0
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Section title updated successfully.'
        ]);
    } catch (Exception $e) {
        DB::rollback();
        Log::error('Update Section Title Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error updating section title: ' . $e->getMessage()
        ], 500);
    }
}
}
