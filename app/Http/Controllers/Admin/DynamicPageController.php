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
    // Validation Rules
    $data = $request->validate([
        // Basic Page Data
        'page_title'        => 'nullable|max:255',
        'page_description'  => 'nullable',
        'is_active'         => 'nullable|boolean',
        'offer_end_date'    => 'nullable|date|after:now',

        // Header Section
        'header_logo_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        'header_logo_text'      => 'nullable|max:100',
        'header_logo_subtitle'  => 'nullable|max:255',
        'header_button_text'    => 'nullable|max:100',
        'header_phone'          => 'nullable|max:50',

        // Hero Section
        'hero_title_part1'      => 'nullable|max:255',
        'hero_title_part2'      => 'nullable|max:255',
        'hero_title_part3'      => 'nullable|max:255',
        'hero_subtitle'         => 'nullable|max:255',
        'hero_description'      => 'nullable',
        'hero_button_text'      => 'nullable|max:100',
        'hero_button_url'       => 'nullable|max:255',
        'discount_percentage'   => 'nullable|integer|min:0|max:100',

        // Why Choose Section
        'why_choose_title'          => 'nullable|max:255',
        'why_choose_subtitle'       => 'nullable|max:255',
        'why_choose_description'    => 'nullable|max:255',
        'why_choose_left_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        'why_choose_background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        'why_choose_button_text'    => 'nullable|max:100',
        'why_choose_button_url'     => 'nullable|max:255',

        // Services Section
        'services_title'           => 'nullable|max:255',
        'services_subtitle'        => 'nullable',

        // Packages Section
        'packages_title'           => 'nullable|max:255',
        'packages_subtitle'        => 'nullable',

        // Products Section
        'products_title'           => 'nullable|max:255',
        'products_subtitle'        => 'nullable',

        // Shop Products Section
        'shop_products_title'      => 'nullable|max:255',
        'shop_products_subtitle'   => 'nullable',

        // Video Section - Enhanced Validation
        'video_title'              => 'nullable|max:255',
        'video_subtitle'           => 'nullable',
        'video_url'                => 'nullable|url|max:500',
        'video_file'               => 'nullable|file|mimetypes:video/mp4,video/avi,video/mov,video/quicktime,video/x-msvideo,video/webm|max:204800', // 200MB max
        'video_source'             => 'nullable|in:url,upload',
        'remove_current_video'     => 'nullable|boolean',
        'video_thumbnail'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        'video_info_title'         => 'nullable|max:255',
        'video_info_description'   => 'nullable|max:255',

        // Clients Section
        'clients_title'            => 'nullable|max:255',
        'clients_subtitle'         => 'nullable',
        'clients_logos'            => 'nullable|array',
        'clients_logos.*'          => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',

        // Reviews Section
        'reviews_title'            => 'nullable|max:255',
        'reviews_subtitle'         => 'nullable',

        // Contact Section
        'contact_title'            => 'nullable|max:255',
        'contact_subtitle'         => 'nullable',
        'contact_whatsapp'         => 'nullable|max:50',
        'contact_email'            => 'nullable|email|max:255',
        'contact_phone'            => 'nullable|max:50',

        // Footer Section
        'footer_logo_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        'footer_logo_text'         => 'nullable|max:100',
        'footer_logo_subtitle'     => 'nullable|max:255',
        'footer_title_line1'       => 'nullable|max:255',
        'footer_title_line2'       => 'nullable|max:255',
        'footer_description'       => 'nullable',
        'footer_discount_badge_text'    => 'nullable|max:50',
        'footer_discount_badge_subtext' => 'nullable|max:50',
        'footer_copyright'         => 'nullable|max:255',
        'footer_powered_by'        => 'nullable|max:255',

        // Dynamic Arrays
        'why_cards_title'          => 'nullable|array',
        'why_cards_description'    => 'nullable|array',
        'why_cards_icon'           => 'nullable|array',
        'why_cards_color_from'     => 'nullable|array',
        'why_cards_color_to'       => 'nullable|array',

        'reviews_name'             => 'nullable|array',
        'reviews_role'             => 'nullable|array',
        'reviews_company'          => 'nullable|array',
        'reviews_rating'           => 'nullable|array',
        'reviews_review'           => 'nullable|array',
        'reviews_avatar_existing'  => 'nullable|array',

        // Selections
        'selected_services'        => 'nullable|array',
        'selected_packages'        => 'nullable|array',
        'selected_products'        => 'nullable|array',
        'selected_shop_products'   => 'nullable|array',

        // Clients Management
        'remove_client_indexes'    => 'nullable|string',
    ]);

    try {
        \Log::info('Starting page update', [
            'page_id' => $page->id,
            'request_video_source' => $request->input('video_source'),
            'has_video_file' => $request->hasFile('video_file'),
            'video_url' => $request->input('video_url'),
            'remove_current_video' => $request->boolean('remove_current_video')
        ]);

        // Set basic status fields
        $data['is_active'] = $request->has('is_active');

        // Set section status fields
        $data['header_status']        = $request->has('header_status') ? 'active' : 'inactive';
        $data['hero_status']          = $request->has('hero_status') ? 'active' : 'inactive';
        $data['why_choose_status']    = $request->has('why_choose_status') ? 'active' : 'inactive';
        $data['services_status']      = $request->has('services_status') ? 'active' : 'inactive';
        $data['packages_status']      = $request->has('packages_status') ? 'active' : 'inactive';
        $data['products_status']      = $request->has('products_status') ? 'active' : 'inactive';
        $data['shop_products_status'] = $request->has('shop_products_status') ? 'active' : 'inactive';
        $data['video_status']         = $request->has('video_status') ? 'active' : 'inactive';
        $data['clients_status']       = $request->has('clients_status') ? 'active' : 'inactive';
        $data['reviews_status']       = $request->has('reviews_status') ? 'active' : 'inactive';
        $data['contact_status']       = $request->has('contact_status') ? 'active' : 'inactive';
        $data['footer_status']        = $request->has('footer_status') ? 'active' : 'inactive';

        // ========================================
        // VIDEO HANDLING - Enhanced Logic
        // ========================================
        $videoSource = $request->input('video_source', 'url');
        
        // Handle video file removal first
        if ($request->boolean('remove_current_video')) {
            if ($page->video_file && \Storage::disk('public')->exists($page->video_file)) {
                \Storage::disk('public')->delete($page->video_file);
                \Log::info('Removed current video file', ['file' => $page->video_file]);
            }
            $data['video_file'] = null;
        }

        // Handle new video file upload
        if ($request->hasFile('video_file') && $videoSource === 'upload') {
            // Delete old video file if exists and not already deleted
            if ($page->video_file && \Storage::disk('public')->exists($page->video_file) && !$request->boolean('remove_current_video')) {
                \Storage::disk('public')->delete($page->video_file);
                \Log::info('Deleted old video file for replacement', ['file' => $page->video_file]);
            }
            
            try {
                $videoFile = $request->file('video_file');
                
                // Additional validation
                $maxSize = 200 * 1024 * 1024; // 200MB
                if ($videoFile->getSize() > $maxSize) {
                    return redirect()->back()->withErrors(['video_file' => 'Video file size must be less than 200MB.']);
                }
                
                $allowedMimes = ['video/mp4', 'video/avi', 'video/mov', 'video/quicktime', 'video/x-msvideo', 'video/webm'];
                if (!in_array($videoFile->getMimeType(), $allowedMimes)) {
                    return redirect()->back()->withErrors(['video_file' => 'Invalid video format. Please upload MP4, AVI, MOV, or WebM files only.']);
                }

                // Store the video file
                $data['video_file'] = $videoFile->store('dynamic-pages/videos', 'public');
                $data['video_url'] = null; // Clear URL when uploading file
                
                \Log::info('Video file uploaded successfully', [
                    'file' => $data['video_file'],
                    'size' => $videoFile->getSize(),
                    'mime' => $videoFile->getMimeType()
                ]);
                
            } catch (\Exception $e) {
                \Log::error('Video upload failed', ['error' => $e->getMessage()]);
                return redirect()->back()->withErrors(['video_file' => 'Failed to upload video file: ' . $e->getMessage()]);
            }
        }

        // Handle video URL vs Upload logic
        if ($videoSource === 'url' && $request->filled('video_url')) {
            // URL source selected
            $data['video_url'] = $request->input('video_url');
            // Keep existing video_file unless explicitly removing or uploading new file
            if (!$request->hasFile('video_file') && !$request->boolean('remove_current_video')) {
                $data['video_file'] = $page->video_file;
            }
        } elseif ($videoSource === 'upload') {
            // Upload source selected, clear URL unless already handled above
            if (!$request->hasFile('video_file')) {
                // No new file uploaded, keep existing if not removing
                $data['video_file'] = $request->boolean('remove_current_video') ? null : $page->video_file;
            }
            // Clear URL when upload source is selected
            $data['video_url'] = null;
        }

        // ========================================
        // OTHER FILE UPLOADS
        // ========================================

        // Header logo image
        if ($request->hasFile('header_logo_image')) {
            if ($page->header_logo_image && \Storage::disk('public')->exists($page->header_logo_image)) {
                \Storage::disk('public')->delete($page->header_logo_image);
            }
            $data['header_logo_image'] = $request->file('header_logo_image')->store('dynamic-pages/header', 'public');
        }

        // Why choose images
        if ($request->hasFile('why_choose_left_image')) {
            if ($page->why_choose_left_image && \Storage::disk('public')->exists($page->why_choose_left_image)) {
                \Storage::disk('public')->delete($page->why_choose_left_image);
            }
            $data['why_choose_left_image'] = $request->file('why_choose_left_image')->store('dynamic-pages/why-choose', 'public');
        }

        if ($request->hasFile('why_choose_background_image')) {
            if ($page->why_choose_background_image && \Storage::disk('public')->exists($page->why_choose_background_image)) {
                \Storage::disk('public')->delete($page->why_choose_background_image);
            }
            $data['why_choose_background_image'] = $request->file('why_choose_background_image')->store('dynamic-pages/why-choose', 'public');
        }

        // Video thumbnail
        if ($request->hasFile('video_thumbnail')) {
            if ($page->video_thumbnail && \Storage::disk('public')->exists($page->video_thumbnail)) {
                \Storage::disk('public')->delete($page->video_thumbnail);
            }
            $data['video_thumbnail'] = $request->file('video_thumbnail')->store('dynamic-pages/video', 'public');
        }

        // Footer logo image
        if ($request->hasFile('footer_logo_image')) {
            if ($page->footer_logo_image && \Storage::disk('public')->exists($page->footer_logo_image)) {
                \Storage::disk('public')->delete($page->footer_logo_image);
            }
            $data['footer_logo_image'] = $request->file('footer_logo_image')->store('dynamic-pages/footer', 'public');
        }

        // ========================================
        // WHY CHOOSE CARDS HANDLING
        // ========================================
        $featureTitles       = $request->input('why_cards_title', []);
        $featureDescriptions = $request->input('why_cards_description', []);
        $featureIcons        = $request->input('why_cards_icon', []);
        $featureColorFrom    = $request->input('why_cards_color_from', []);
        $featureColorTo      = $request->input('why_cards_color_to', []);

        $cards = [];
        foreach ($featureTitles as $index => $title) {
            if (!empty($title) || !empty($featureDescriptions[$index] ?? null)) {
                $cards[] = [
                    'title'        => $title,
                    'description'  => $featureDescriptions[$index] ?? '',
                    'icon'         => $featureIcons[$index] ?? '',
                    'color_from'   => $featureColorFrom[$index] ?? '#000000',
                    'color_to'     => $featureColorTo[$index] ?? '#000000',
                ];
            }
        }
        $data['why_choose_cards'] = $cards;

        // ========================================
        // CLIENT LOGOS HANDLING
        // ========================================
        $clientLogos = $page->clients_logos ?? [];

        // Add new client logos
        if ($request->hasFile('clients_logos')) {
            foreach ($request->file('clients_logos') as $file) {
                if ($file && $file->isValid()) {
                    try {
                        $clientLogos[] = $file->store('dynamic-pages/clients', 'public');
                    } catch (\Exception $e) {
                        \Log::error('Client logo upload failed', ['error' => $e->getMessage()]);
                        // Continue with other uploads
                    }
                }
            }
        }

        // Remove specified client logos
        if ($request->filled('remove_client_indexes')) {
            $indexesToRemove = array_map('intval', explode(',', $request->input('remove_client_indexes')));
            foreach ($indexesToRemove as $index) {
                if (isset($clientLogos[$index])) {
                    // Delete file from storage
                    if (\Storage::disk('public')->exists($clientLogos[$index])) {
                        \Storage::disk('public')->delete($clientLogos[$index]);
                    }
                    unset($clientLogos[$index]);
                }
            }
            $clientLogos = array_values($clientLogos); // Re-index array
        }

        $data['clients_logos'] = $clientLogos;

        // ========================================
        // REVIEWS HANDLING
        // ========================================
        $reviewNames    = $request->input('reviews_name', []);
        $reviewRoles    = $request->input('reviews_role', []);
        $reviewCompany  = $request->input('reviews_company', []);
        $reviewRating   = $request->input('reviews_rating', []);
        $reviewText     = $request->input('reviews_review', []);
        $existingAvatar = $request->input('reviews_avatar_existing', []);

        $reviews = [];
        foreach ($reviewNames as $index => $name) {
            if (!empty($name) || !empty($reviewText[$index] ?? null)) {
                $avatarPath = $existingAvatar[$index] ?? null;

                // Handle avatar upload
                if ($request->hasFile("reviews_avatar.$index")) {
                    try {
                        $avatarPath = $request->file("reviews_avatar.$index")->store('dynamic-pages/reviews', 'public');
                    } catch (\Exception $e) {
                        \Log::error('Review avatar upload failed', ['index' => $index, 'error' => $e->getMessage()]);
                        // Use existing avatar or null
                    }
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
        }
        $data['reviews_items'] = $reviews;

        // ========================================
        // RELATIONS HANDLING
        // ========================================
        
        // Update services relation
        if ($request->has('selected_services')) {
            $serviceIds = array_filter($request->input('selected_services', []));
            $page->services()->sync($serviceIds);
            \Log::info('Services synced', ['services' => $serviceIds]);
        }

        // Update packages relation
        if ($request->has('selected_packages')) {
            $packageIds = array_filter($request->input('selected_packages', []));
            $page->pricingPlans()->sync($packageIds);
            \Log::info('Packages synced', ['packages' => $packageIds]);
        }

        // Update products relation
        if ($request->has('selected_products')) {
            $productIds = array_filter($request->input('selected_products', []));
            $page->products()->sync($productIds);
            \Log::info('Products synced', ['products' => $productIds]);
        }

        // Update shop products relation
        if ($request->has('selected_shop_products')) {
            $shopProductIds = array_filter($request->input('selected_shop_products', []));
            $page->shopProducts()->sync($shopProductIds);
            \Log::info('Shop products synced', ['shop_products' => $shopProductIds]);
        }

        // ========================================
        // CLEAN UP DATA BEFORE SAVING
        // ========================================
        unset(
            $data['selected_services'], 
            $data['selected_packages'], 
            $data['selected_products'], 
            $data['selected_shop_products'],
            $data['remove_current_video'], 
            $data['video_source'],
            $data['why_cards_title'],
            $data['why_cards_description'], 
            $data['why_cards_icon'],
            $data['why_cards_color_from'], 
            $data['why_cards_color_to'],
            $data['reviews_name'], 
            $data['reviews_role'], 
            $data['reviews_company'],
            $data['reviews_rating'], 
            $data['reviews_review'], 
            $data['reviews_avatar_existing'],
            $data['clients_logos'],
            $data['remove_client_indexes']
        );

        // ========================================
        // SAVE TO DATABASE
        // ========================================
        $page->update($data);

        \Log::info('Page updated successfully', [
            'page_id' => $page->id,
            'video_file' => $page->fresh()->video_file,
            'video_url' => $page->fresh()->video_url,
            'video_status' => $page->fresh()->video_status,
            'video_source_used' => $videoSource
        ]);

        $tab = $request->get('tab', 'header');

        return redirect()
            ->route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => $tab])
            ->with('success', 'Page updated successfully.');

    } catch (\Exception $e) {
        \Log::error('Page update failed', [
            'page_id' => $page->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['error' => 'Failed to update page: ' . $e->getMessage()]);
    }
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