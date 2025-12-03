<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Models\Service;
use App\Models\PricingPlan;
use App\Models\ShopProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage;


class DynamicPageController extends Controller
{
    public function index()
    {
        $pages = DynamicPage::withCount(['services', 'pricingPlans', 'products', 'shopProducts'])
            ->orderBy('id')
            ->get();

        return view('admin.dynamic-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.dynamic-pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page_name'        => 'required|max:255',
            'page_slug'        => 'required|max:255|unique:dynamic_pages,page_slug',
            'page_title'       => 'nullable|max:255',
            'page_description' => 'nullable',
            'status'           => 'nullable|in:active,inactive',
            'offer_end_date'   => 'nullable|date|after:now',
        ]);

        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }

        $data['is_active'] = false;

        $page = DynamicPage::create($data);

        return redirect()
            ->route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => 'header'])
            ->with('success', 'Page created successfully.');
    }

public function edit(DynamicPage $page, Request $request)
{
    $page->load(['services', 'pricingPlans', 'products', 'shopProducts']);

    $tab = $request->get('tab', 'header');

    // Debug video file information مع المقارنة بين asset و Storage::url
    if (!empty($page->video_file)) {
        Log::info('=== VIDEO DEBUG INFO ===');
        Log::info('Raw video_file value: ' . $page->video_file);
        Log::info('Video file type: ' . gettype($page->video_file));
        Log::info('Video file length: ' . strlen($page->video_file));
        
        // Check if file exists
        $fileExists = Storage::disk('public')->exists($page->video_file);
        Log::info('File exists: ' . ($fileExists ? 'YES' : 'NO'));
        
        if ($fileExists) {
            try {
                // 🔥 مقارنة بين الطريقتين
                $assetUrl = asset('storage/' . $page->video_file);
                $storageUrl = Storage::disk('public')->url($page->video_file);
                
                Log::info('Asset URL (recommended): ' . $assetUrl);
                Log::info('Storage URL (problematic): ' . $storageUrl);
                Log::info('URLs match: ' . ($assetUrl === $storageUrl ? 'YES' : 'NO'));
                Log::info('Asset URL length: ' . strlen($assetUrl));
                Log::info('Storage URL length: ' . strlen($storageUrl));
                
                // Test if URLs are accessible
                $assetPath = public_path('storage/' . $page->video_file);
                Log::info('Asset file exists: ' . (file_exists($assetPath) ? 'YES' : 'NO'));
                
            } catch (Exception $e) {
                Log::error('Error generating URLs: ' . $e->getMessage());
            }
        }
        
        // Check storage paths
        Log::info('Storage root: ' . storage_path('app/public'));
        Log::info('Public storage: ' . public_path('storage'));
        Log::info('APP_URL: ' . config('app.url'));
        Log::info('Symlink exists: ' . (is_link(public_path('storage')) ? 'YES' : 'NO'));
        
        if (is_link(public_path('storage'))) {
            Log::info('Symlink target: ' . readlink(public_path('storage')));
        }
        
        Log::info('=== END VIDEO DEBUG ===');
    }

    $services = Service::where('status', 'active')->orderBy('title')->get();
    $packages = PricingPlan::where('status', 'active')->orderBy('name')->get();
    $products = Product::where('status', 'active')->orderBy('title')->get();
    $shopProducts = ShopProduct::where('status', 'active')->orderBy('name')->get();

    $selectedServices = $page->services->pluck('id')->toArray();
    $selectedPackages = $page->pricingPlans->pluck('id')->toArray();
    $selectedProducts = $page->products->pluck('id')->toArray();
    $selectedShopProducts = $page->shopProducts->pluck('id')->toArray();

    $whyChooseCards = $page->why_choose_cards ?? [];
    $clientLogos    = $page->clients_logos ?? [];
    $reviewsItems   = $page->reviews_items ?? [];

    return view('admin.dynamic-pages.edit', compact(
        'page',
        'tab',
        'services',
        'packages',
        'products',
        'shopProducts',
        'selectedServices',
        'selectedPackages',
        'selectedProducts',
        'selectedShopProducts',
        'whyChooseCards',
        'clientLogos',
        'reviewsItems'
    ));
}

public function update(Request $request, DynamicPage $page)
{
    $data = $request->validate([
        'page_title'        => 'nullable|max:255',
        'page_description'  => 'nullable',
        'is_active'         => 'nullable|boolean',
        'offer_end_date'    => 'nullable|date|after:now',

        'header_logo_text'      => 'nullable|max:100',
        'header_logo_subtitle'  => 'nullable|max:255',
        'header_button_text'    => 'nullable|max:100',
        'header_phone'          => 'nullable|max:50',

        'hero_title_part1'      => 'nullable|max:255',
        'hero_title_part2'      => 'nullable|max:255',
        'hero_title_part3'      => 'nullable|max:255',
        'hero_subtitle'         => 'nullable|max:255',
        'hero_description'      => 'nullable',
        'hero_button_text'      => 'nullable|max:100',
        'hero_button_url'       => 'nullable|max:255',
        'discount_percentage'   => 'nullable|integer|min:0|max:100',

        'why_choose_title'          => 'nullable|max:255',
        'why_choose_subtitle'       => 'nullable|max:255',
        'why_choose_description'    => 'nullable|max:255',
        'why_choose_button_text'    => 'nullable|max:100',
        'why_choose_button_url'     => 'nullable|max:255',

        'services_title'           => 'nullable|max:255',
        'services_subtitle'        => 'nullable',

        'packages_title'           => 'nullable|max:255',
        'packages_subtitle'        => 'nullable',

        'products_title'           => 'nullable|max:255',
        'products_subtitle'        => 'nullable',

        'shop_products_title'      => 'nullable|max:255',
        'shop_products_subtitle'   => 'nullable',

        'video_title'              => 'nullable|max:255',
        'video_subtitle'           => 'nullable',
        'video_info_title'         => 'nullable|max:255',
        'video_info_description'   => 'nullable|max:255',

        'clients_title'            => 'nullable|max:255',
        'clients_subtitle'         => 'nullable',

        'reviews_title'            => 'nullable|max:255',
        'reviews_subtitle'         => 'nullable',

        'contact_title'            => 'nullable|max:255',
        'contact_subtitle'         => 'nullable',
        'contact_whatsapp'         => 'nullable|max:50',
        'contact_email'            => 'nullable|max:255',
        'contact_phone'            => 'nullable|max:50',

        'footer_logo_text'        => 'nullable|max:100',
        'footer_logo_subtitle'    => 'nullable|max:255',
        'footer_title_line1'      => 'nullable|max:255',
        'footer_title_line2'      => 'nullable|max:255',
        'footer_description'      => 'nullable',
        'footer_discount_badge_text'    => 'nullable|max:50',
        'footer_discount_badge_subtext' => 'nullable|max:50',
        'footer_copyright'        => 'nullable|max:255',
        'footer_powered_by'       => 'nullable|max:255',

        'selected_services'       => 'nullable|array',
        'selected_packages'       => 'nullable|array',
        'selected_products'       => 'nullable|array',
        'selected_shop_products'  => 'nullable|array',

        'remove_current_video'    => 'nullable|boolean',
        'video_file'              => 'nullable|file|mimetypes:video/mp4,video/avi,video/mov,video/quicktime,video/x-msvideo|max:204800', // 200MB
    ]);

    // Fix: Only set is_active to true if explicitly checked, otherwise keep current value
    if ($request->has('is_active')) {
        $data['is_active'] = true;
    }

    // Handle section status checkboxes
    $data['header_status']      = $request->has('header_status') ? 'active' : 'inactive';
    $data['hero_status']        = $request->has('hero_status') ? 'active' : 'inactive';
    $data['why_choose_status']  = $request->has('why_choose_status') ? 'active' : 'inactive';
    $data['services_status']    = $request->has('services_status') ? 'active' : 'inactive';
    $data['packages_status']    = $request->has('packages_status') ? 'active' : 'inactive';
    $data['products_status']    = $request->has('products_status') ? 'active' : 'inactive';
    $data['shop_products_status'] = $request->has('shop_products_status') ? 'active' : 'inactive';
    $data['video_status']       = $request->has('video_status') ? 'active' : 'inactive';
    $data['clients_status']     = $request->has('clients_status') ? 'active' : 'inactive';
    $data['reviews_status']     = $request->has('reviews_status') ? 'active' : 'inactive';
    $data['contact_status']     = $request->has('contact_status') ? 'active' : 'inactive';
    $data['footer_status']      = $request->has('footer_status') ? 'active' : 'inactive';

    try {
        if ($request->has('selected_services')) {
            $serviceIds = $request->input('selected_services', []);
            $page->services()->sync($serviceIds);
        }

        if ($request->has('selected_packages')) {
            $packageIds = $request->input('selected_packages', []);
            $page->pricingPlans()->sync($packageIds);
        }

        if ($request->has('selected_products')) {
            $productIds = $request->input('selected_products', []);
            $page->products()->sync($productIds);
        }

        if ($request->has('selected_shop_products')) {
            $shopProductIds = $request->input('selected_shop_products', []);
            $page->shopProducts()->sync($shopProductIds);
        }
    } catch (\Exception $e) {
        Log::error('Error updating selections: ' . $e->getMessage());
    }

    // Handle file uploads
    if ($request->hasFile('header_logo_image')) {
        $data['header_logo_image'] = Storage::disk('public')->putFile('dynamic-pages/header', $request->file('header_logo_image'));
    }

    if ($request->hasFile('why_choose_left_image')) {
        $data['why_choose_left_image'] = Storage::disk('public')->putFile('dynamic-pages/why-choose', $request->file('why_choose_left_image'));
    }

    if ($request->hasFile('why_choose_background_image')) {
        $data['why_choose_background_image'] = Storage::disk('public')->putFile('dynamic-pages/why-choose', $request->file('why_choose_background_image'));
    }

    if ($request->hasFile('footer_logo_image')) {
        $data['footer_logo_image'] = Storage::disk('public')->putFile('dynamic-pages/footer', $request->file('footer_logo_image'));
    }

    if ($request->filled('remove_current_video') && $request->remove_current_video) {
        // Remove current video file
        if ($page->video_file && \Storage::disk('public')->exists($page->video_file)) {
            \Storage::disk('public')->delete($page->video_file);
            Log::info('Video file deleted: ' . $page->video_file);
        }
        $data['video_file'] = null;
        $data['video_url'] = null;
    } elseif ($request->hasFile('video_file')) {
        try {
            $file = $request->file('video_file');
            
            // Validate file
            if (!$file->isValid()) {
                throw new \Exception('Invalid video file uploaded');
            }
            
            // Check file size (200MB = 209715200 bytes)
            if ($file->getSize() > 209715200) {
                throw new \Exception('Video file is too large. Maximum size is 200MB');
            }
            
            // Check file type
            $allowedMimeTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/quicktime', 'video/x-msvideo'];
            if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                throw new \Exception('Invalid video format. Allowed: MP4, AVI, MOV');
            }
            
            // Remove old video file if exists
            if ($page->video_file && \Storage::disk('public')->exists($page->video_file)) {
                \Storage::disk('public')->delete($page->video_file);
                Log::info('Old video file deleted: ' . $page->video_file);
            }
            
            // Store new video with timestamp and original name
            $fileName = time() . '_' . $file->getClientOriginalName();
            $fileName = preg_replace('/[^A-Za-z0-9\-_.]/u', '_', $fileName); // Clean filename
            $path = $file->storeAs('dynamic-pages/video', $fileName, 'public');
            
            if (!$path) {
                throw new \Exception('Failed to store video file');
            }
            
            // Verify file was actually stored
            if (!\Storage::disk('public')->exists($path)) {
                throw new \Exception('Video file was not saved properly');
            }
            
            $data['video_file'] = $path;
            $data['video_url'] = null;
            
            $assetUrl = asset('storage/' . $path);
            $storageUrl = \Storage::disk('public')->url($path);
            $fullSystemPath = \Storage::disk('public')->path($path);
            
            Log::info('Video uploaded successfully', [
                'original_name' => $file->getClientOriginalName(),
                'stored_path' => $path,
                'size_mb' => round($file->getSize() / 1024 / 1024, 2),
                'mime_type' => $file->getMimeType(),
                'full_system_path' => $fullSystemPath,
                'asset_url' => $assetUrl,
                'storage_url' => $storageUrl,
                'urls_match' => $assetUrl === $storageUrl ? 'YES' : 'NO',
                'asset_url_length' => strlen($assetUrl),
                'storage_url_length' => strlen($storageUrl),
                'app_url' => config('app.url'),
                'expected_url' => config('app.url') . '/storage/' . $path,
                'file_exists_in_public' => file_exists(public_path('storage/' . $path)) ? 'YES' : 'NO'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Video upload failed: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['video_file' => 'Video upload failed: ' . $e->getMessage()])
                ->withInput();
        }
    }

    if ($request->hasFile('video_thumbnail')) {
        $data['video_thumbnail'] = Storage::disk('public')->putFile('dynamic-pages/video', $request->file('video_thumbnail'));
        
        if (isset($data['video_thumbnail'])) {
            $thumbnailAssetUrl = asset('storage/' . $data['video_thumbnail']);
            $thumbnailStorageUrl = Storage::disk('public')->url($data['video_thumbnail']);
            
            Log::info('Video thumbnail uploaded', [
                'path' => $data['video_thumbnail'],
                'asset_url' => $thumbnailAssetUrl,
                'storage_url' => $thumbnailStorageUrl,
                'urls_match' => $thumbnailAssetUrl === $thumbnailStorageUrl ? 'YES' : 'NO'
            ]);
        }
    }

    // Handle why choose cards
    $featureTitles       = $request->input('why_cards_title', []);
    $featureDescriptions = $request->input('why_cards_description', []);
    $featureIcons        = $request->input('why_cards_icon', []);
    $featureColorFrom    = $request->input('why_cards_color_from', []);
    $featureColorTo      = $request->input('why_cards_color_to', []);

    $cards = [];
    foreach ($featureTitles as $index => $title) {
        if (!$title && !($featureDescriptions[$index] ?? null)) {
            continue;
        }

        $cards[] = [
            'title'        => $title,
            'description'  => $featureDescriptions[$index] ?? '',
            'icon'         => $featureIcons[$index] ?? '',
            'color_from'   => $featureColorFrom[$index] ?? '#000000',
            'color_to'     => $featureColorTo[$index] ?? '#000000',
        ];
    }
    $data['why_choose_cards'] = $cards;

    // Handle client logos
    $clientLogos = $page->clients_logos ?? [];

    if ($request->hasFile('clients_logos')) {
        foreach ($request->file('clients_logos') as $file) {
            if (!$file) {
                continue;
            }
            $clientLogos[] = Storage::disk('public')->putFile('dynamic-pages/clients', $file);
        }
    }

    if ($request->filled('remove_client_indexes')) {
        $indexesToRemove = explode(',', $request->input('remove_client_indexes'));
        foreach ($indexesToRemove as $idx) {
            $i = (int) $idx;
            if (isset($clientLogos[$i])) {
                unset($clientLogos[$i]);
            }
        }
        $clientLogos = array_values($clientLogos);
    }

    $data['clients_logos'] = $clientLogos;

    // Handle reviews
    $reviewNames    = $request->input('reviews_name', []);
    $reviewRoles    = $request->input('reviews_role', []);
    $reviewCompany  = $request->input('reviews_company', []);
    $reviewRating   = $request->input('reviews_rating', []);
    $reviewText     = $request->input('reviews_review', []);
    $existingAvatar = $request->input('reviews_avatar_existing', []);

    $reviews = [];
    foreach ($reviewNames as $index => $name) {
        if (!$name && !($reviewText[$index] ?? null)) {
            continue;
        }

        $avatarPath = $existingAvatar[$index] ?? null;

        if ($request->hasFile("reviews_avatar.$index")) {
            $avatarPath = Storage::disk('public')->putFile('dynamic-pages/reviews', $request->file("reviews_avatar.$index"));
        }

        $reviews[] = [
            'name'    => $name,
            'role'    => $reviewRoles[$index] ?? '',
            'company' => $reviewCompany[$index] ?? '',
            'rating'  => (int) ($reviewRating[$index] ?? 5),
            'review'  => $reviewText[$index] ?? '',
            'avatar'  => $avatarPath,
        ];
    }
    $data['reviews_items'] = $reviews;

    // Remove form fields that shouldn't be saved to database
    unset($data['selected_services'], $data['selected_packages'], $data['selected_products'], $data['selected_shop_products'], $data['remove_current_video']);

    $page->update($data);

    $tab = $request->get('tab', 'header');

    return redirect()
        ->route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => $tab])
        ->with('success', 'Page section updated successfully.');
}
/**
 * Get video URL using asset() method like VideoSection
 */
public function getVideoSourceAttribute()
{
    if (!empty($this->video_file) && Storage::disk('public')->exists($this->video_file)) {
        return asset('storage/' . $this->video_file);
    }
    return null;
}

/**
 * Get thumbnail URL using asset() method
 */
public function getThumbnailSourceAttribute()
{
    if (!empty($this->video_thumbnail) && Storage::disk('public')->exists($this->video_thumbnail)) {
        return asset('storage/' . $this->video_thumbnail);
    }
    return null;
}

/**
 * Check if video file exists and is accessible
 */
public function hasVideo()
{
    return !empty($this->video_file) && Storage::disk('public')->exists($this->video_file);
}

    public function toggleStatus(Request $request, DynamicPage $page)
    {
        $page->update([
            'is_active' => !$page->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => $page->is_active ? 'Page activated successfully' : 'Page deactivated successfully',
            'is_active' => $page->is_active,
            'is_available' => $page->isAvailable()
        ]);
    }

    public function updatePageStatus(Request $request, DynamicPage $page)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $page->update([
            'is_active' => $request->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => $request->is_active ? 'Page activated successfully' : 'Page deactivated successfully',
            'data' => [
                'is_active' => $page->is_active,
                'is_available' => $page->isAvailable(),
                'is_expired' => $page->isExpired(),
                'time_remaining' => $page->getTimeRemaining()
            ]
        ]);
    }

    public function getPageStatus(DynamicPage $page)
    {
        return response()->json([
            'is_active' => $page->is_active,
            'is_available' => $page->isAvailable(),
            'is_expired' => $page->isExpired(),
            'offer_end_date' => $page->offer_end_date?->toDateTimeString(),
            'time_remaining' => $page->getTimeRemaining()
        ]);
    }

    public function updateOfferEndDate(Request $request, DynamicPage $page)
    {
        $request->validate([
            'offer_end_date' => 'nullable|date|after:now'
        ]);

        $page->update([
            'offer_end_date' => $request->offer_end_date
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Offer end date updated successfully',
            'data' => [
                'offer_end_date' => $page->offer_end_date?->toDateTimeString(),
                'is_available' => $page->isAvailable(),
                'time_remaining' => $page->getTimeRemaining()
            ]
        ]);
    }

    public function destroy(DynamicPage $page)
    {
        try {
            $page->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Page deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete page'
            ], 500);
        }
    }

    public function toggleSection(Request $request, DynamicPage $page, string $section)
    {
        $statusField = $section . '_status';
        
        if (!in_array($statusField, $page->getFillable())) {
            return response()->json([
                'success' => false,
                'message' => 'Section field not found.',
            ], 422);
        }
        
        $currentStatus = $page->$statusField;
        $newStatus = $currentStatus === 'active' ? 'inactive' : 'active';
        
        $page->update([$statusField => $newStatus]);

        return response()->json([
            'success' => true,
            'status'  => $newStatus,
            'message' => "Section {$section} is now {$newStatus}",
        ]);
    }

    public function reorderSections(Request $request, DynamicPage $page)
    {
        try {
            $order = $request->input('order', []);
            $validSections = [
                'header', 'hero', 'why_choose', 'services', 
                'packages', 'products', 'shop_products', 'video', 'clients', 
                'reviews', 'contact', 'footer'
            ];
            
            $filteredOrder = array_intersect($order, $validSections);
            
            if (count($filteredOrder) !== count($validSections)) {
                $missingSections = array_diff($validSections, $filteredOrder);
                $filteredOrder = array_merge($filteredOrder, $missingSections);
            }
            
            $page->update(['sections_order' => $filteredOrder]);

            return response()->json([
                'success' => true,
                'message' => 'Sections order updated successfully',
                'new_order' => $filteredOrder
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating sections order: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update sections order: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function services(DynamicPage $page)
    {
        $services = Service::where('status', 'active')->get();
        $selectedServices = $page->services()->get();

        return view('admin.dynamic-pages.services', compact('page', 'services', 'selectedServices'));
    }

    public function servicesStore(Request $request, DynamicPage $page)
    {
        $request->validate([
            'service_ids'   => 'required|array',
            'service_ids.*' => 'exists:services,id',
        ]);

        $page->services()->sync($request->service_ids);

        return redirect()->back()->with('success', 'Services updated successfully.');
    }

    public function packages(DynamicPage $page)
    {
        $packages = PricingPlan::where('status', 'active')->get();
        $selectedPackages = $page->pricingPlans()->get();

        return view('admin.dynamic-pages.packages', compact('page', 'packages', 'selectedPackages'));
    }
    
    public function packagesStore(Request $request, DynamicPage $page)
    {
        $request->validate([
            'pricing_plan_ids'   => 'required|array',
            'pricing_plan_ids.*' => 'exists:pricing_plans,id',
        ]);

        $page->pricingPlans()->sync($request->pricing_plan_ids);

        return redirect()->back()->with('success', 'Packages updated successfully.');
    }

    public function products(DynamicPage $page)
    {
        $products = Product::where('status', 'active')->get();
        $selectedProducts = $page->products()->get();

        return view('admin.dynamic-pages.products', compact('page', 'products', 'selectedProducts'));
    }

    public function productsStore(Request $request, DynamicPage $page)
    {
        $request->validate([
            'product_ids'   => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $page->products()->sync($request->product_ids);

        return redirect()->back()->with('success', 'Products updated successfully.');
    }
       
    public function shopProducts(DynamicPage $page)
    {
        $shopProducts = ShopProduct::where('status', 'active')->get();
        $selectedShopProducts = $page->shopProducts()->get();

        return view('admin.dynamic-pages.shop-products', compact('page', 'shopProducts', 'selectedShopProducts'));
    }

    public function shopProductsStore(Request $request, DynamicPage $page)
    {
        $request->validate([
            'shop_product_ids'   => 'required|array',
            'shop_product_ids.*' => 'exists:shop_products,id',
        ]);

        $page->shopProducts()->sync($request->shop_product_ids);

        return redirect()->back()->with('success', 'Shop Products updated successfully.');
    }

    public function servicesUpdate(Request $request, DynamicPage $page, int $serviceId)
    {
        $request->validate([
            'custom_icon'           => 'nullable|max:100',
            'custom_background'     => 'nullable|max:255',
            'discount_badge'        => 'nullable|max:50',
            'read_more_button_text' => 'nullable|max:100',
            'read_more_button_url'  => 'nullable|max:255',
            'sort_order'            => 'nullable|integer',
        ]);

        DB::table('dynamic_page_services')
            ->where('dynamic_page_id', $page->id)
            ->where('service_id', $serviceId)
            ->update($request->only([
                'custom_icon',
                'custom_background',
                'discount_badge',
                'read_more_button_text',
                'read_more_button_url',
                'sort_order',
            ]));

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function packagesUpdate(Request $request, DynamicPage $page, int $packageId)
    {
        $request->validate([
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'is_featured'         => 'boolean',
            'sort_order'          => 'nullable|integer',
        ]);

        DB::table('dynamic_page_pricing_plans')
            ->where('dynamic_page_id', $page->id)
            ->where('pricing_plan_id', $packageId)
            ->update($request->only([
                'discount_percentage',
                'is_featured',
                'sort_order',
            ]));

        return redirect()->back()->with('success', 'Package updated successfully.');
    }

    public function productsUpdate(Request $request, DynamicPage $page, int $productId)
    {
        $request->validate([
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'order_button_text'   => 'nullable|max:100',
            'order_button_url'    => 'nullable|max:255',
            'sort_order'          => 'nullable|integer',
        ]);

        DB::table('dynamic_page_products')
            ->where('dynamic_page_id', $page->id)
            ->where('product_id', $productId)
            ->update($request->only([
                'discount_percentage',
                'order_button_text',
                'order_button_url',
                'sort_order',
            ]));

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function shopProductsUpdate(Request $request, DynamicPage $page, int $shopProductId)
    {
        $request->validate([
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'order_button_text'   => 'nullable|max:100',
            'order_button_url'    => 'nullable|max:255',
            'sort_order'          => 'nullable|integer',
        ]);

        DB::table('dynamic_page_shop_products')
            ->where('dynamic_page_id', $page->id)
            ->where('shop_product_id', $shopProductId)
            ->update($request->only([
                'discount_percentage',
                'order_button_text',
                'order_button_url',
                'sort_order',
            ]));

        return redirect()->back()->with('success', 'Shop Product updated successfully.');
    }

    public function servicesDestroy(int $id)
    {
        DB::table('dynamic_page_services')
            ->where('id', $id)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function packagesDestroy(int $id)
    {
        DB::table('dynamic_page_pricing_plans')
            ->where('id', $id)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function productsDestroy(int $id)
    {
        DB::table('dynamic_page_products')
            ->where('id', $id)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function shopProductsDestroy(int $id)
    {
        DB::table('dynamic_page_shop_products')
            ->where('id', $id)
            ->delete();

        return response()->json(['success' => true]);
    }
}