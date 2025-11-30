<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OccasionController extends Controller
{
    /**
     * Display all sections for the sales page
     */
    public function index()
    {
        try {
            Log::info('OccasionController: index() called');
            
            $sections = DB::table('sales_page_sections')
                ->orderBy('sort_order')
                ->get();

            Log::info('OccasionController: Retrieved ' . $sections->count() . ' sections');

            // Group sections by type for better organization
            $groupedSections = $sections->groupBy('section_type');

            return view('admin.occasions.index', compact('sections', 'groupedSections'));
        } catch (\Exception $e) {
            Log::error('OccasionController index() error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Error loading sections: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new section
     */
    public function create()
    {
        try {
            Log::info('OccasionController: create() called');
            
            $sectionTypes = [
                'header' => 'Header',
                'hero' => 'Hero Section',
                'why_choose' => 'Why Choose Us',
                'services' => 'Services',
                'packages' => 'Packages',
                'products' => 'Products',
                'video' => 'Video Section',
                'clients' => 'Client Logos',
                'reviews' => 'Customer Reviews',
                'contact' => 'Contact Form',
                'footer' => 'Footer'
            ];

            return view('admin.occasions.create', compact('sectionTypes'));
        } catch (\Exception $e) {
            Log::error('OccasionController create() error: ' . $e->getMessage());
            return back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created section
     */
    public function store(Request $request)
    {
        try {
            Log::info('OccasionController: store() called', $request->all());
            
            $request->validate([
                'section_type' => 'required|string|max:50',
                'section_title' => 'required|string|max:255',
                'section_subtitle' => 'nullable|string',
                'background_color' => 'nullable|string|max:50',
                'is_active' => 'boolean',
                'sort_order' => 'integer|min:0',
            ]);

            // Handle background image upload
            $backgroundImage = null;
            if ($request->hasFile('background_image')) {
                try {
                    $backgroundImage = $request->file('background_image')->store('occasions/backgrounds', 'public');
                    Log::info('Background image uploaded: ' . $backgroundImage);
                } catch (\Exception $e) {
                    Log::error('Background image upload failed: ' . $e->getMessage());
                    return back()->with('error', 'Background image upload failed: ' . $e->getMessage());
                }
            }

            // Prepare content data based on section type
            $contentData = $this->prepareContentData($request);
            Log::info('Content data prepared', $contentData);

            $sectionId = DB::table('sales_page_sections')->insertGetId([
                'section_type' => $request->section_type,
                'section_title' => $request->section_title,
                'section_subtitle' => $request->section_subtitle,
                'background_image' => $backgroundImage,
                'background_color' => $request->background_color ?? '#0a0a0a',
                'content_data' => json_encode($contentData),
                'is_active' => $request->has('is_active'),
                'sort_order' => $request->sort_order ?? 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Section created successfully with ID: ' . $sectionId);

            return redirect()->route('admin.occasions.index')
                ->with('success', 'Section created successfully!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error in store()', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('OccasionController store() error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->all()
            ]);
            
            return back()->with('error', 'Error creating section: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified section
     */
    public function show($id)
    {
        try {
            Log::info('OccasionController: show() called for ID: ' . $id);
            
            $section = DB::table('sales_page_sections')->where('id', $id)->first();
            
            if (!$section) {
                Log::warning('Section not found for ID: ' . $id);
                abort(404);
            }

            // Decode JSON content
            $section->content_data = json_decode($section->content_data, true);
            Log::info('Section loaded successfully: ' . $section->section_title);

            return view('admin.occasions.show', compact('section'));
        } catch (\Exception $e) {
            Log::error('OccasionController show() error: ' . $e->getMessage(), [
                'id' => $id,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return back()->with('error', 'Error loading section: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified section
     */
    public function edit($id)
    {
        try {
            Log::info('OccasionController: edit() called for ID: ' . $id);
            
            $section = DB::table('sales_page_sections')->where('id', $id)->first();
            
            if (!$section) {
                Log::warning('Section not found for edit, ID: ' . $id);
                abort(404);
            }

            // Decode JSON content
            $section->content_data = json_decode($section->content_data, true);
            Log::info('Section loaded for edit: ' . $section->section_title);

            $sectionTypes = [
                'header' => 'Header',
                'hero' => 'Hero Section',
                'why_choose' => 'Why Choose Us',
                'services' => 'Services',
                'packages' => 'Packages',
                'products' => 'Products',
                'video' => 'Video Section',
                'clients' => 'Client Logos',
                'reviews' => 'Customer Reviews',
                'contact' => 'Contact Form',
                'footer' => 'Footer'
            ];

            return view('admin.occasions.edit', compact('section', 'sectionTypes'));
        } catch (\Exception $e) {
            Log::error('OccasionController edit() error: ' . $e->getMessage(), [
                'id' => $id,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified section
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('OccasionController: update() called for ID: ' . $id, $request->all());
            
            $request->validate([
                'section_type' => 'required|string|max:50',
                'section_title' => 'required|string|max:255',
                'section_subtitle' => 'nullable|string',
                'background_color' => 'nullable|string|max:50',
                'is_active' => 'boolean',
                'sort_order' => 'integer|min:0',
            ]);

            $section = DB::table('sales_page_sections')->where('id', $id)->first();
            if (!$section) {
                Log::warning('Section not found for update, ID: ' . $id);
                return back()->with('error', 'Section not found!');
            }

            // Handle background image upload
            $backgroundImage = $section->background_image;
            if ($request->hasFile('background_image')) {
                try {
                    // Delete old image
                    if ($backgroundImage && Storage::disk('public')->exists($backgroundImage)) {
                        Storage::disk('public')->delete($backgroundImage);
                        Log::info('Old background image deleted: ' . $backgroundImage);
                    }
                    $backgroundImage = $request->file('background_image')->store('occasions/backgrounds', 'public');
                    Log::info('New background image uploaded: ' . $backgroundImage);
                } catch (\Exception $e) {
                    Log::error('Background image update failed: ' . $e->getMessage());
                    return back()->with('error', 'Background image update failed: ' . $e->getMessage());
                }
            }

            // Prepare content data based on section type
            $contentData = $this->prepareContentData($request);
            Log::info('Content data prepared for update', $contentData);

            $updated = DB::table('sales_page_sections')->where('id', $id)->update([
                'section_type' => $request->section_type,
                'section_title' => $request->section_title,
                'section_subtitle' => $request->section_subtitle,
                'background_image' => $backgroundImage,
                'background_color' => $request->background_color ?? '#0a0a0a',
                'content_data' => json_encode($contentData),
                'is_active' => $request->has('is_active'),
                'sort_order' => $request->sort_order ?? 0,
                'updated_at' => now()
            ]);

            if ($updated) {
                Log::info('Section updated successfully, ID: ' . $id);
                return redirect()->route('admin.occasions.index')
                    ->with('success', 'Section updated successfully!');
            } else {
                Log::warning('No rows updated for section ID: ' . $id);
                return back()->with('warning', 'No changes were made to the section.');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error in update()', ['id' => $id, 'errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('OccasionController update() error: ' . $e->getMessage(), [
                'id' => $id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->all()
            ]);
            
            return back()->with('error', 'Error updating section: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified section
     */
    public function destroy($id)
    {
        try {
            Log::info('OccasionController: destroy() called for ID: ' . $id);
            
            $section = DB::table('sales_page_sections')->where('id', $id)->first();
            
            if (!$section) {
                Log::warning('Section not found for delete, ID: ' . $id);
                return response()->json(['success' => false, 'message' => 'Section not found'], 404);
            }

            // Delete background image if exists
            if ($section->background_image && Storage::disk('public')->exists($section->background_image)) {
                try {
                    Storage::disk('public')->delete($section->background_image);
                    Log::info('Background image deleted: ' . $section->background_image);
                } catch (\Exception $e) {
                    Log::error('Failed to delete background image: ' . $e->getMessage());
                }
            }

            $deleted = DB::table('sales_page_sections')->where('id', $id)->delete();

            if ($deleted) {
                Log::info('Section deleted successfully, ID: ' . $id);
                return response()->json([
                    'success' => true,
                    'message' => 'Section deleted successfully'
                ]);
            } else {
                Log::warning('Failed to delete section, ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete section'
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('OccasionController destroy() error: ' . $e->getMessage(), [
                'id' => $id,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting section: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update status of a section
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            Log::info('OccasionController: updateStatus() called for ID: ' . $id);
            
            $section = DB::table('sales_page_sections')->where('id', $id)->first();
            
            if (!$section) {
                Log::warning('Section not found for status update, ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Section not found'
                ], 404);
            }

            $newStatus = !$section->is_active;
            $updated = DB::table('sales_page_sections')
                ->where('id', $id)
                ->update([
                    'is_active' => $newStatus,
                    'updated_at' => now()
                ]);

            if ($updated) {
                Log::info('Section status updated successfully', [
                    'id' => $id, 
                    'old_status' => $section->is_active, 
                    'new_status' => $newStatus
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Status updated successfully',
                    'status' => $newStatus
                ]);
            } else {
                Log::warning('Failed to update section status, ID: ' . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update status'
                ], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('OccasionController updateStatus() error: ' . $e->getMessage(), [
                'id' => $id,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update sort order of sections
     */
    public function updateSortOrder(Request $request)
    {
        try {
            Log::info('OccasionController: updateSortOrder() called', $request->all());
            
            $items = $request->input('items', []);
            
            if (empty($items)) {
                Log::warning('No items provided for sort order update');
                return response()->json([
                    'success' => false,
                    'message' => 'No items provided'
                ], 400);
            }

            DB::beginTransaction();

            foreach ($items as $item) {
                if (!isset($item['id']) || !isset($item['sort_order'])) {
                    Log::warning('Invalid item data in sort order update', $item);
                    continue;
                }

                DB::table('sales_page_sections')
                    ->where('id', $item['id'])
                    ->update([
                        'sort_order' => $item['sort_order'],
                        'updated_at' => now()
                    ]);
                    
                Log::info('Sort order updated for section ID: ' . $item['id'] . ' to order: ' . $item['sort_order']);
            }

            DB::commit();
            Log::info('All sort orders updated successfully');

            return response()->json([
                'success' => true,
                'message' => 'Sort order updated successfully'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('OccasionController updateSortOrder() error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update sort order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle file uploads for sections
     */
    public function uploadFile(Request $request)
    {
        try {
            Log::info('OccasionController: uploadFile() called', $request->all());
            
            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,avi,mov|max:50240', // 50MB max
                'type' => 'required|string|in:image,video,logo'
            ]);

            $file = $request->file('file');
            $type = $request->type;

            Log::info('File upload details', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'type' => $type
            ]);

            // Determine storage path based on file type
            $storagePath = match($type) {
                'image' => 'occasions/images',
                'video' => 'occasions/videos',
                'logo' => 'occasions/logos',
                default => 'occasions/files'
            };

            $filePath = $file->store($storagePath, 'public');
            Log::info('File uploaded successfully: ' . $filePath);

            return response()->json([
                'success' => true,
                'file_path' => $filePath,
                'file_url' => Storage::url($filePath),
                'file_name' => $file->getClientOriginalName(),
                'message' => 'File uploaded successfully'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('File upload validation error', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors())
            ], 422);
        } catch (\Exception $e) {
            Log::error('OccasionController uploadFile() error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Prepare content data based on section type
     */
private function prepareContentData(Request $request)
{
    try {
        $sectionType = $request->section_type;
        $contentData = [];

        Log::info('Preparing content data for section type: ' . $sectionType);

        switch ($sectionType) {
            case 'header':
                $contentData = [
                    'logo_text' => $request->input('content.logo_text', 'TKDS'),
                    'logo_subtitle' => $request->input('content.logo_subtitle', 'SHAPING THE WORLD'),
                    'logo_image' => $request->input('content.logo_image', ''),
                    'call_button_text' => $request->input('content.call_button_text', 'CALL SALES'),
                    'phone_number' => $request->input('content.phone_number', '+13252680040'),
                    'show_call_button' => $request->boolean('content.show_call_button')
                ];
                break;

            case 'hero':
                // Handle split title parts or full title
                $mainTitle = '';
                if ($request->has('content.main_title_part1') || $request->has('content.main_title_part2') || $request->has('content.main_title_part3')) {
                    $part1 = $request->input('content.main_title_part1', '');
                    $part2 = $request->input('content.main_title_part2', '');
                    $part3 = $request->input('content.main_title_part3', '');
                    $mainTitle = trim($part1 . ' ' . $part2 . ' ' . $part3);
                } else {
                    $mainTitle = $request->input('content.main_title', 'BLACK FRIDAY Sale');
                }
                
                $contentData = [
                    'main_title' => $mainTitle,
                    'main_title_part1' => $request->input('content.main_title_part1', ''),
                    'main_title_part2' => $request->input('content.main_title_part2', ''),
                    'main_title_part3' => $request->input('content.main_title_part3', ''),
                    'subtitle' => $request->input('content.subtitle', 'Expand Your TV Network'),
                    'description' => $request->input('content.description', 'To Additional Platforms'),
                    'discount_percentage' => $request->input('content.discount_percentage', '80'),
                    'cta_button_text' => $request->input('content.cta_button_text', 'START YOUR JOURNEY'),
                    'cta_button_link' => $request->input('content.cta_button_link', '#contact'),
                    'countdown_enabled' => $request->boolean('content.countdown_enabled'),
                    'countdown_end_date' => $request->input('content.countdown_end_date', '2025-12-31 23:59:59'),
                    'floating_elements' => $request->boolean('content.floating_elements'),
                    'wave_badge' => $request->boolean('content.wave_badge')
                ];
                break;

            case 'why_choose':
                // Handle features array
                $features = [];
                if ($request->has('content.features')) {
                    foreach ($request->input('content.features', []) as $feature) {
                        if (!empty($feature['title'])) {
                            $features[] = [
                                'icon' => $feature['icon'] ?? 'fas fa-star',
                                'title' => $feature['title'] ?? '',
                                'description' => $feature['description'] ?? ''
                            ];
                        }
                    }
                }

                // Handle split title parts or full title
                $mainTitle = '';
                if ($request->has('content.main_title_part1') || $request->has('content.main_title_part2')) {
                    $part1 = $request->input('content.main_title_part1', '');
                    $part2 = $request->input('content.main_title_part2', '');
                    $mainTitle = trim($part1 . ' ' . $part2);
                } else {
                    $mainTitle = $request->input('content.main_title', 'WHY CHOOSE TKDS');
                }

                $contentData = [
                    'main_title' => $mainTitle,
                    'main_title_part1' => $request->input('content.main_title_part1', ''),
                    'main_title_part2' => $request->input('content.main_title_part2', ''),
                    'subtitle' => $request->input('content.subtitle', 'UNMATCHED EXCELLENCE'),
                    'main_image' => $request->input('content.main_image', ''),
                    'features' => $features,
                    'cta_button_text' => $request->input('content.cta_button_text', 'GET STARTED NOW'),
                    'cta_button_link' => $request->input('content.cta_button_link', '#contact')
                ];
                break;

            case 'services':
                // Handle services array
                $services = [];
                if ($request->has('content.services')) {
                    foreach ($request->input('content.services', []) as $service) {
                        if (!empty($service['title'])) {
                            $services[] = [
                                'icon' => $service['icon'] ?? 'fas fa-cog',
                                'title' => $service['title'] ?? '',
                                'description' => $service['description'] ?? '',
                                'discount' => $service['discount'] ?? '0'
                            ];
                        }
                    }
                }

                $contentData = [
                    'main_title' => $request->input('content.main_title', 'PREMIUM SERVICES'),
                    'subtitle' => $request->input('content.subtitle', 'Experience cutting-edge technology with our professional solutions'),
                    'services' => $services
                ];
                break;

                // Handle packages array
          case 'packages':
    $packages = [];
    if ($request->has('content.packages')) {
        foreach ($request->input('content.packages', []) as $package) {
            if (!empty($package['name'])) {
                $packages[] = [
                    'name' => $package['name'] ?? '',
                    'price' => $package['price'] ?? '',
                    'original_price' => $package['original_price'] ?? '',
                    'discount' => $package['discount'] ?? '',
                    'featured' => isset($package['featured']) && $package['featured'],
                    'features' => $package['features'] ?? []
                ];
            }
        }
    }

    $contentData = [
        'main_title' => $request->input('content.main_title', 'EXPLOSIVE PACKAGES'),
        'subtitle' => $request->input('content.subtitle', 'Choose your perfect plan and save big with our special occasion discounts'),
        'packages' => $packages
    ];
    break;

case 'products':
    $products = [];
    if ($request->has('content.products')) {
        foreach ($request->input('content.products', []) as $product) {
            if (!empty($product['title'])) {
                $products[] = [
                    'title' => $product['title'] ?? '',
                    'price' => $product['price'] ?? '',
                    'original_price' => $product['original_price'] ?? '',
                    'icon' => $product['icon'] ?? 'fas fa-box',
                    'discount' => $product['discount'] ?? '0',
                    'description' => $product['description'] ?? ''
                ];
            }
        }
    }

    $contentData = [
        'main_title' => $request->input('content.main_title', 'FEATURED PRODUCTS'),
        'subtitle' => $request->input('content.subtitle', 'Discover our premium products with exclusive special occasion pricing'),
        'products' => $products
    ];
    break;

case 'video':
    $contentData = [
        'main_title' => $request->input('content.main_title', 'SEE MAGIC IN ACTION'),
        'subtitle' => $request->input('content.subtitle', 'Watch how our solutions transform businesses worldwide'),
        'video_title' => $request->input('content.video_title', 'TKDS Solutions Overview'),
        'video_description' => $request->input('content.video_description', 'Experience the future of hosting and streaming technology'),
        'video_url' => $request->input('content.video_url', ''),
        'video_thumbnail' => $request->input('content.video_thumbnail', ''),
        'play_button_text' => $request->input('content.play_button_text', 'Play Video')
    ];
    break;

case 'clients':
    $clients = [];
    if ($request->has('content.clients')) {
        foreach ($request->input('content.clients', []) as $client) {
            if (!empty($client['name'])) {
                $clients[] = [
                    'name' => $client['name'] ?? '',
                    'logo' => $client['logo'] ?? '',
                    'url' => $client['url'] ?? '#'
                ];
            }
        }
    }

    $contentData = [
        'main_title' => $request->input('content.main_title', 'TRUSTED BY GIANTS'),
        'subtitle' => $request->input('content.subtitle', 'Join thousands of satisfied clients who trust our solutions'),
        'clients' => $clients
    ];
    break;

case 'reviews':
    $reviews = [];
    if ($request->has('content.reviews')) {
        foreach ($request->input('content.reviews', []) as $review) {
            if (!empty($review['name'])) {
                $reviews[] = [
                    'name' => $review['name'] ?? '',
                    'position' => $review['position'] ?? '',
                    'avatar' => $review['avatar'] ?? strtoupper(substr($review['name'] ?? 'A', 0, 1)),
                    'rating' => $review['rating'] ?? 5,
                    'text' => $review['text'] ?? ''
                ];
            }
        }
    }

    $contentData = [
        'main_title_part1' => $request->input('content.main_title_part1', 'WHAT CLIENTS'),
        'main_title_part2' => $request->input('content.main_title_part2', 'SAY'),
        'subtitle' => $request->input('content.subtitle', 'Real experiences from real customers who transformed their business with us'),
        'reviews' => $reviews
    ];
    break;

                // Handle split title parts or full title
                $mainTitle = '';
                if ($request->has('content.main_title_part1') || $request->has('content.main_title_part2')) {
                    $part1 = $request->input('content.main_title_part1', '');
                    $part2 = $request->input('content.main_title_part2', '');
                    $mainTitle = trim($part1 . ' ' . $part2);
                } else {
                    $mainTitle = $request->input('content.main_title', 'WHAT CLIENTS SAY');
                }

                $contentData = [
                    'main_title' => $mainTitle,
                    'main_title_part1' => $request->input('content.main_title_part1', ''),
                    'main_title_part2' => $request->input('content.main_title_part2', ''),
                    'subtitle' => $request->input('content.subtitle', 'Real experiences from real customers who transformed their business with us'),
                    'reviews' => $reviews
                ];
                break;

            case 'contact':
                $contactInfo = [];
                if ($request->has('content.contact_info')) {
                    foreach ($request->input('content.contact_info', []) as $info) {
                        if (!empty($info['title'])) {
                            $contactInfo[] = [
                                'icon' => $info['icon'] ?? 'fas fa-phone',
                                'title' => $info['title'] ?? '',
                                'description' => $info['description'] ?? '',
                                'value' => $info['value'] ?? ''
                            ];
                        }
                    }
                }

                $contentData = [
                    'main_title' => $request->input('content.main_title', 'GET YOUR DISCOUNT NOW'),
                    'subtitle' => $request->input('content.subtitle', 'Don\'t miss out on this limited-time offer. Contact us today and save big!'),
                    'whatsapp_number' => $request->input('content.whatsapp_number', '+1234567890'),
                    'email' => $request->input('content.email', 'support@tkds.com'),
                    'form_enabled' => $request->boolean('content.form_enabled'),
                    'cta_button_text' => $request->input('content.cta_button_text', 'CLAIM MY DISCOUNT'),
                    'contact_info' => $contactInfo
                ];
                break;

            case 'footer':
                $socialLinks = [];
                if ($request->has('content.social_links')) {
                    foreach ($request->input('content.social_links', []) as $link) {
                        if (!empty($link['icon'])) {
                            $socialLinks[] = [
                                'icon' => $link['icon'] ?? 'fab fa-facebook',
                                'url' => $link['url'] ?? '#'
                            ];
                        }
                    }
                }

                $contentData = [
                    'logo_text' => $request->input('content.logo_text', 'TKDS'),
                    'logo_subtitle' => $request->input('content.logo_subtitle', 'SHAPING THE WORLD'),
                    'logo_image' => $request->input('content.logo_image', ''),
                    'marketing_title' => $request->input('content.marketing_title', 'FUTURE OF STREAMING'),
                    'marketing_subtitle' => $request->input('content.marketing_subtitle', 'Enterprise-grade hosting & live streaming solutions trusted worldwide'),
                    'discount_badge' => $request->input('content.discount_badge', '80% OFF'),
                    'discount_text' => $request->input('content.discount_text', 'LIMITED TIME'),
                    'social_links' => $socialLinks,
                    'copyright_text' => $request->input('content.copyright_text', '© 2025 TKDS Servers. All rights reserved.'),
                    'powered_by' => $request->input('content.powered_by', 'POWERED BY INNOVATION')
                ];
                break;

            default:
                $contentData = $request->input('content', []);
                break;
        }

        Log::info('Content data prepared successfully', $contentData);
        return $contentData;
        
    } catch (\Exception $e) {
        Log::error('Error preparing content data: ' . $e->getMessage(), [
            'section_type' => $sectionType ?? 'unknown',
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
        
        return [];
    }
}
    /**
     * Get section data for frontend display
     */
    public function getSectionData($sectionType)
    {
        try {
            Log::info('OccasionController: getSectionData() called for type: ' . $sectionType);
            
            $section = DB::table('sales_page_sections')
                ->where('section_type', $sectionType)
                ->where('is_active', true)
                ->first();

            if (!$section) {
                Log::warning('Active section not found for type: ' . $sectionType);
                return response()->json(['success' => false, 'message' => 'Section not found'], 404);
            }

            $section->content_data = json_decode($section->content_data, true);
            Log::info('Section data retrieved successfully for type: ' . $sectionType);

            return response()->json([
                'success' => true,
                'section' => $section
            ]);
            
        } catch (\Exception $e) {
            Log::error('OccasionController getSectionData() error: ' . $e->getMessage(), [
                'section_type' => $sectionType,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving section data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Duplicate a section
     */
    public function duplicate($id)
    {
        try {
            Log::info('OccasionController: duplicate() called for ID: ' . $id);
            
            $section = DB::table('sales_page_sections')->where('id', $id)->first();
            
            if (!$section) {
                Log::warning('Section not found for duplicate, ID: ' . $id);
                return response()->json(['success' => false, 'message' => 'Section not found'], 404);
            }

            // Create a copy with modified title
            $newSectionData = [
                'section_type' => $section->section_type,
                'section_title' => $section->section_title . ' (Copy)',
                'section_subtitle' => $section->section_subtitle,
                'background_image' => $section->background_image,
                'background_color' => $section->background_color,
                'content_data' => $section->content_data,
                'is_active' => false, // New sections start as inactive
                'sort_order' => $section->sort_order + 1,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $newId = DB::table('sales_page_sections')->insertGetId($newSectionData);
            Log::info('Section duplicated successfully', ['original_id' => $id, 'new_id' => $newId]);

            return response()->json([
                'success' => true,
                'message' => 'Section duplicated successfully',
                'new_id' => $newId
            ]);
            
        } catch (\Exception $e) {
            Log::error('OccasionController duplicate() error: ' . $e->getMessage(), [
                'id' => $id,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error duplicating section: ' . $e->getMessage()
            ], 500);
        }
    }
}