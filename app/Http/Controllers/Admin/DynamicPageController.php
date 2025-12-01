<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Models\Service;
use App\Models\PricingPlan;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DynamicPageController extends Controller
{
    public function index()
    {
        $pages = DynamicPage::withCount(['services', 'pricingPlans', 'products'])
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
        ]);

        if (! isset($data['status'])) {
            $data['status'] = 'active';
        }

        $page = DynamicPage::create($data);

        return redirect()
            ->route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => 'header'])
            ->with('success', 'Page created successfully.');
    }

    public function edit(DynamicPage $page, Request $request)
    {
        $page->load(['services', 'pricingPlans', 'products']);

        $tab = $request->get('tab', 'header');

        $services = Service::where('status', 'active')->get();
        $packages = PricingPlan::where('status', 'active')->get();
        $products = ShopProduct::where('status', 'active')->get();

        // decode JSON arrays if needed
        $whyChooseCards = $page->why_choose_cards ?? [];
        $clientLogos    = $page->clients_logos ?? [];
        $reviewsItems   = $page->reviews_items ?? [];

        return view('admin.dynamic-pages.edit', compact(
            'page',
            'tab',
            'services',
            'packages',
            'products',
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

            // Header
            'header_logo_text'      => 'nullable|max:100',
            'header_logo_subtitle'  => 'nullable|max:255',
            'header_button_text'    => 'nullable|max:100',
            'header_phone'          => 'nullable|max:50',

            // Hero
            'hero_title_part1'      => 'nullable|max:255',
            'hero_title_part2'      => 'nullable|max:255',
            'hero_title_part3'      => 'nullable|max:255',
            'hero_subtitle'         => 'nullable|max:255',
            'hero_description'      => 'nullable',
            'hero_button_text'      => 'nullable|max:100',
            'hero_button_url'       => 'nullable|max:255',
            'discount_percentage'   => 'nullable|integer|min:0|max:100',
            'offer_end_date'        => 'nullable|date',

            // Why choose
            'why_choose_title'          => 'nullable|max:255',
            'why_choose_subtitle'       => 'nullable|max:255',
            'why_choose_description'    => 'nullable|max:255',
            'why_choose_button_text'    => 'nullable|max:100',
            'why_choose_button_url'     => 'nullable|max:255',

            // Services
            'services_title'           => 'nullable|max:255',
            'services_subtitle'        => 'nullable',

            // Packages
            'packages_title'           => 'nullable|max:255',
            'packages_subtitle'        => 'nullable',

            // Products
            'products_title'           => 'nullable|max:255',
            'products_subtitle'        => 'nullable',

            // Video
            'video_title'              => 'nullable|max:255',
            'video_subtitle'           => 'nullable',
            'video_url'                => 'nullable|max:255',
            'video_thumbnail'          => 'nullable|max:255',
            'video_info_title'         => 'nullable|max:255',
            'video_info_description'   => 'nullable|max:255',

            // Clients
            'clients_title'            => 'nullable|max:255',
            'clients_subtitle'         => 'nullable',

            // Reviews
            'reviews_title'            => 'nullable|max:255',
            'reviews_subtitle'         => 'nullable',

            // Contact
            'contact_title'            => 'nullable|max:255',
            'contact_subtitle'         => 'nullable',
            'contact_whatsapp'         => 'nullable|max:50',
            'contact_email'            => 'nullable|max:255',
            'contact_phone'            => 'nullable|max:50',

            // Footer
            'footer_logo_text'        => 'nullable|max:100',
            'footer_logo_subtitle'    => 'nullable|max:255',
            'footer_title_line1'      => 'nullable|max:255',
            'footer_title_line2'      => 'nullable|max:255',
            'footer_description'      => 'nullable',
            'footer_discount_badge_text'    => 'nullable|max:50',
            'footer_discount_badge_subtext' => 'nullable|max:50',
            'footer_copyright'        => 'nullable|max:255',
            'footer_powered_by'       => 'nullable|max:255',
        ]);

        // statuses (checkboxes)
        $data['header_status']      = $request->has('header_status') ? 'active' : 'inactive';
        $data['hero_status']        = $request->has('hero_status') ? 'active' : 'inactive';
        $data['why_choose_status']  = $request->has('why_choose_status') ? 'active' : 'inactive';
        $data['services_status']    = $request->has('services_status') ? 'active' : 'inactive';
        $data['packages_status']    = $request->has('packages_status') ? 'active' : 'inactive';
        $data['products_status']    = $request->has('products_status') ? 'active' : 'inactive';
        $data['video_status']       = $request->has('video_status') ? 'active' : 'inactive';
        $data['clients_status']     = $request->has('clients_status') ? 'active' : 'inactive';
        $data['reviews_status']     = $request->has('reviews_status') ? 'active' : 'inactive';
        $data['contact_status']     = $request->has('contact_status') ? 'active' : 'inactive';
        $data['footer_status']      = $request->has('footer_status') ? 'active' : 'inactive';

        // images
        if ($request->hasFile('header_logo_image')) {
            $data['header_logo_image'] = $request->file('header_logo_image')
                ->store('dynamic-pages/header', 'public');
        }

        if ($request->hasFile('why_choose_left_image')) {
            $data['why_choose_left_image'] = $request->file('why_choose_left_image')
                ->store('dynamic-pages/why-choose', 'public');
        }

        if ($request->hasFile('why_choose_background_image')) {
            $data['why_choose_background_image'] = $request->file('why_choose_background_image')
                ->store('dynamic-pages/why-choose', 'public');
        }

        if ($request->hasFile('video_thumbnail')) {
            $data['video_thumbnail'] = $request->file('video_thumbnail')
                ->store('dynamic-pages/video', 'public');
        }

        if ($request->hasFile('footer_logo_image')) {
            $data['footer_logo_image'] = $request->file('footer_logo_image')
                ->store('dynamic-pages/footer', 'public');
        }

        // why_choose_cards (features) from dynamic form arrays
        $featureTitles       = $request->input('why_cards_title', []);
        $featureDescriptions = $request->input('why_cards_description', []);
        $featureIcons        = $request->input('why_cards_icon', []);
        $featureColorFrom    = $request->input('why_cards_color_from', []);
        $featureColorTo      = $request->input('why_cards_color_to', []);

        $cards = [];
        foreach ($featureTitles as $index => $title) {
            if (! $title && ! ($featureDescriptions[$index] ?? null)) {
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

        // clients logos (array of image paths)
        $clientLogos = $page->clients_logos ?? [];

        if ($request->hasFile('clients_logos')) {
            foreach ($request->file('clients_logos') as $file) {
                if (! $file) {
                    continue;
                }
                $clientLogos[] = $file->store('dynamic-pages/clients', 'public');
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

        // reviews items (JSON)
        $reviewNames    = $request->input('reviews_name', []);
        $reviewRoles    = $request->input('reviews_role', []);
        $reviewCompany  = $request->input('reviews_company', []);
        $reviewRating   = $request->input('reviews_rating', []);
        $reviewText     = $request->input('reviews_review', []);
        $existingAvatar = $request->input('reviews_avatar_existing', []);

        $reviews = $page->reviews_items ?? [];

        $reviews = [];
        foreach ($reviewNames as $index => $name) {
            if (! $name && ! ($reviewText[$index] ?? null)) {
                continue;
            }

            $avatarPath = $existingAvatar[$index] ?? null;

            if ($request->hasFile("reviews_avatar.$index")) {
                $avatarPath = $request->file("reviews_avatar.$index")
                    ->store('dynamic-pages/reviews', 'public');
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

        $page->update($data);

        $tab = $request->get('tab', 'header');

        return redirect()
            ->route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => $tab])
            ->with('success', 'Page section updated successfully.');
    }

public function toggleSection(Request $request, DynamicPage $page, string $section)
{
    $statusField = $section . '_status';
    
    if (!\Schema::hasColumn($page->getTable(), $statusField)) {
        return response()->json([
            'success' => false,
            'message' => 'Section field not found.',
        ], 422);
    }
    
    // Toggle the status
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
    $order = $request->input('order', []);
    
    // التحقق من أن جميع السيكشنز صالحة
    $validSections = [
        'header', 'hero', 'why_choose', 'services', 
        'packages', 'products', 'video', 'clients', 
        'reviews', 'contact', 'footer'
    ];
    
    $filteredOrder = array_intersect($order, $validSections);
    
    // التأكد من وجود جميع السيكشنز
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
}

    public function services(DynamicPage $page)
    {
        $services = Service::where('status', 'active')->get();
        $selectedServices = $page->services()->with('service')->get();

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

    public function servicesDestroy(int $id)
    {
        DB::table('dynamic_page_services')
            ->where('id', $id)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function packages(DynamicPage $page)
    {
        $packages = PricingPlan::where('status', 'active')->get();
        $selectedPackages = $page->pricingPlans()->with('pricingPlan')->get();

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

    public function packagesDestroy(int $id)
    {
        DB::table('dynamic_page_pricing_plans')
            ->where('id', $id)
            ->delete();

        return response()->json(['success' => true]);
    }

    public function products(DynamicPage $page)
    {
        $products = ShopProduct::where('status', 'active')->get();
        $selectedProducts = $page->products()->with('product')->get();

        return view('admin.dynamic-pages.products', compact('page', 'products', 'selectedProducts'));
    }

    public function productsStore(Request $request, DynamicPage $page)
    {
        $request->validate([
            'product_ids'   => 'required|array',
            'product_ids.*' => 'exists:shop_products,id',
        ]);

        $page->products()->sync($request->product_ids);

        return redirect()->back()->with('success', 'Products updated successfully.');
    }

    public function productsDestroy(int $id)
    {
        DB::table('dynamic_page_products')
            ->where('id', $id)
            ->delete();

        return response()->json(['success' => true]);
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
}
