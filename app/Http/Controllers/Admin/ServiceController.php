<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $services = Service::orderBy('sort_order', 'asc')
                              ->orderBy('created_at', 'desc')
                              ->paginate(12);
            
            return view('admin.services.index', compact('services'));
        } catch (Exception $e) {
            Log::error('Error loading services index: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Failed to load services. Please try again.');
        }
    }

    public function create()
    {
        return view('admin.services.addedit');
    }

    public function store(Request $request)
    {
        try {
            Log::info('Starting service creation', ['request_data' => $request->all()]);
            
            // تنظيف البيانات قبل الvalidation
            $requestData = $request->all();
            if (isset($requestData['features'])) {
                $requestData['features'] = array_filter($requestData['features'], function($value) {
                    return !is_null($value) && trim($value) !== '';
                });
                $request->merge($requestData);
            }

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:services,slug',
                'description' => 'required|string|max:1000',
                'icon' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'color_from' => 'required|string|max:20',
                'color_to' => 'required|string|max:20',
                'border_color' => 'required|string|max:20',
                'route_name' => 'nullable|string|max:255',
                'external_url' => 'nullable|url|max:500',
                'features' => 'nullable|array',
                'features.*' => 'nullable|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'status' => 'required|in:active,inactive',
                'is_featured' => 'nullable|boolean',
                'sort_order' => 'required|integer|min:0',
            ]);

            Log::info('Validation passed', ['validated_data' => $validatedData]);

            DB::beginTransaction();

            $data = $validatedData;
            $data['slug'] = $request->slug ?: Str::slug($request->title);
            $data['is_featured'] = $request->has('is_featured') ? true : false;

            // Handle main image upload
            if ($request->hasFile('image')) {
                Log::info('Processing main image upload');
                try {
                    $imagePath = $request->file('image')->store('services', 'public');
                    $data['image'] = $imagePath;
                    Log::info('Main image uploaded successfully', ['path' => $imagePath]);
                } catch (Exception $e) {
                    Log::error('Failed to upload main image: ' . $e->getMessage());
                    throw new Exception('Failed to upload main image');
                }
            }

            // Handle features array - تأكد من تحويلها لـ JSON string
            if (isset($data['features']) && is_array($data['features'])) {
                $cleanFeatures = array_filter($data['features'], function($feature) {
                    return !empty(trim($feature));
                });
                $data['features'] = json_encode(array_values($cleanFeatures));
                Log::info('Features processed', ['features' => $data['features']]);
            } else {
                $data['features'] = '[]'; // JSON string فارغ
            }

            // Set default hero values
            $this->setDefaultValues($data);

            Log::info('Creating service with data', ['final_data' => $data]);
            $service = Service::create($data);
            Log::info('Service created successfully', ['service_id' => $service->id]);

            DB::commit();

            return redirect()->route('admin.services.index')
                ->with('success', 'Service created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Error creating service: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create service: ' . $e->getMessage());
        }
    }

    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.addedit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        try {
            Log::info('Starting service update', [
                'service_id' => $service->id,
                'request_data' => $request->all()
            ]);

            // تنظيف البيانات قبل الvalidation
            $requestData = $request->all();
            if (isset($requestData['features'])) {
                $requestData['features'] = array_filter($requestData['features'], function($value) {
                    return !is_null($value) && trim($value) !== '';
                });
                $request->merge($requestData);
            }

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:services,slug,' . $service->id,
                'description' => 'required|string|max:1000',
                'icon' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'color_from' => 'required|string|max:20',
                'color_to' => 'required|string|max:20',
                'border_color' => 'required|string|max:20',
                'route_name' => 'nullable|string|max:255',
                'external_url' => 'nullable|url|max:500',
                'features' => 'nullable|array',
                'features.*' => 'nullable|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'status' => 'required|in:active,inactive',
                'is_featured' => 'nullable|boolean',
                'sort_order' => 'required|integer|min:0',
            ]);

            DB::beginTransaction();

            $data = $validatedData;
            $data['slug'] = $request->slug ?: Str::slug($request->title);
            $data['is_featured'] = $request->has('is_featured') ? true : false;

            // Handle main image upload
            if ($request->hasFile('image')) {
                Log::info('Processing main image update');
                try {
                    // Delete old image
                    if ($service->image && !filter_var($service->image, FILTER_VALIDATE_URL)) {
                        Storage::disk('public')->delete($service->image);
                        Log::info('Old main image deleted', ['path' => $service->image]);
                    }
                    
                    $imagePath = $request->file('image')->store('services', 'public');
                    $data['image'] = $imagePath;
                    Log::info('New main image uploaded', ['path' => $imagePath]);
                } catch (Exception $e) {
                    Log::error('Failed to update main image: ' . $e->getMessage());
                    throw new Exception('Failed to update main image');
                }
            }

            // Handle features array - تأكد من تحويلها لـ JSON string
            if ($request->has('features')) {
                $cleanFeatures = array_filter($request->features ?: [], function($feature) {
                    return !empty(trim($feature));
                });
                $data['features'] = json_encode(array_values($cleanFeatures));
                Log::info('Features updated', ['features' => $data['features']]);
            } else {
                $data['features'] = '[]'; // JSON string فارغ
            }

            Log::info('Updating service with data', ['service_id' => $service->id]);
            $service->update($data);
            Log::info('Service updated successfully', ['service_id' => $service->id]);

            DB::commit();

            return redirect()->route('admin.services.index')
                ->with('success', 'Service updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed during update: ', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Error updating service: ' . $e->getMessage(), [
                'service_id' => $service->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

   public function destroy(Service $service)
{
    try {
        Log::info('DELETE request received', [
            'service_id' => $service->id,
            'service_title' => $service->title,
            'request_method' => request()->method(),
            'request_url' => request()->url(),
            'user_ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        DB::beginTransaction();

        // Delete main image
        if ($service->image && !filter_var($service->image, FILTER_VALIDATE_URL)) {
            try {
                if (Storage::disk('public')->exists($service->image)) {
                    Storage::disk('public')->delete($service->image);
                    Log::info('Main image deleted successfully', ['path' => $service->image]);
                } else {
                    Log::warning('Main image file not found', ['path' => $service->image]);
                }
            } catch (Exception $e) {
                Log::warning('Failed to delete main image: ' . $e->getMessage(), ['path' => $service->image]);
            }
        }

        // Delete hero image if exists
        if ($service->hero_image && !filter_var($service->hero_image, FILTER_VALIDATE_URL)) {
            try {
                if (Storage::disk('public')->exists($service->hero_image)) {
                    Storage::disk('public')->delete($service->hero_image);
                    Log::info('Hero image deleted successfully', ['path' => $service->hero_image]);
                } else {
                    Log::warning('Hero image file not found', ['path' => $service->hero_image]);
                }
            } catch (Exception $e) {
                Log::warning('Failed to delete hero image: ' . $e->getMessage(), ['path' => $service->hero_image]);
            }
        }

        // Store service info before deletion
        $serviceInfo = [
            'id' => $service->id,
            'title' => $service->title,
            'slug' => $service->slug
        ];

        // Delete the service
        $service->delete();
        Log::info('Service deleted successfully from database', $serviceInfo);

        DB::commit();

        // Return success response for AJAX or redirect for regular form submission
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully.',
                'service' => $serviceInfo
            ]);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service "' . $serviceInfo['title'] . '" deleted successfully.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        DB::rollBack();
        Log::error('Service not found for deletion', [
            'requested_service_id' => request()->route('service'),
            'error' => $e->getMessage(),
            'request_url' => request()->url()
        ]);

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found.'
            ], 404);
        }

        return redirect()->route('admin.services.index')
            ->with('error', 'Service not found.');

    } catch (Exception $e) {
        DB::rollBack();
        
        Log::error('Error deleting service', [
            'service_id' => $service->id ?? 'unknown',
            'error_message' => $e->getMessage(),
            'error_file' => $e->getFile(),
            'error_line' => $e->getLine(),
            'request_data' => request()->all(),
            'stack_trace' => $e->getTraceAsString()
        ]);

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete service: ' . $e->getMessage()
            ], 500);
        }

        return redirect()->back()
            ->with('error', 'Failed to delete service: ' . $e->getMessage());
    }
}

    public function updateStatus(Request $request, Service $service)
    {
        try {
            $request->validate([
                'status' => 'required|in:active,inactive',
            ]);

            $service->update(['status' => $request->status]);
            Log::info('Service status updated', [
                'service_id' => $service->id,
                'new_status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'status' => $service->status
            ]);

        } catch (Exception $e) {
            Log::error('Error updating service status: ' . $e->getMessage(), [
                'service_id' => $service->id,
                'request_status' => $request->status ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSortOrder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:services,id',
                'items.*.sort_order' => 'required|integer|min:0',
            ]);

            DB::beginTransaction();

            foreach ($request->items as $item) {
                Service::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
            }

            DB::commit();

            Log::info('Sort order updated successfully', ['items' => $request->items]);

            return response()->json([
                'success' => true,
                'message' => 'Sort order updated successfully.'
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Error updating sort order: ' . $e->getMessage(), [
                'request_items' => $request->items ?? [],
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update sort order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function pageContent(Service $service)
    {
        return view('admin.services.page-content', compact('service'));
    }

    public function updatePageContent(Request $request, Service $service)
    {
        try {
            Log::info('Starting page content update', ['service_id' => $service->id]);

            $validatedData = $request->validate([
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
                'cta_title' => 'nullable|string|max:255',
                'cta_description' => 'nullable|string',
                'cta_button_text' => 'nullable|string|max:100',
                'cta_button_link' => 'nullable|string|max:500',
            ]);

            DB::beginTransaction();

            $data = $validatedData;

            // Handle hero image upload
            if ($request->hasFile('hero_image')) {
                Log::info('Processing hero image update for page content');
                try {
                    if ($service->hero_image && !filter_var($service->hero_image, FILTER_VALIDATE_URL)) {
                        Storage::disk('public')->delete($service->hero_image);
                    }
                    
                    $heroImagePath = $request->file('hero_image')->store('services/hero', 'public');
                    $data['hero_image'] = $heroImagePath;
                    Log::info('Hero image updated for page content', ['path' => $heroImagePath]);
                } catch (Exception $e) {
                    Log::error('Failed to update hero image for page content: ' . $e->getMessage());
                    throw new Exception('Failed to update hero image');
                }
            }

            // Handle arrays - تحويلها لـ JSON strings
            if (isset($data['key_features']) && is_array($data['key_features'])) {
                $data['key_features'] = json_encode($data['key_features']);
            }
            if (isset($data['benefits']) && is_array($data['benefits'])) {
                $data['benefits'] = json_encode($data['benefits']);
            }
            if (isset($data['use_cases']) && is_array($data['use_cases'])) {
                $data['use_cases'] = json_encode($data['use_cases']);
            }

            $service->update($data);
            Log::info('Page content updated successfully', ['service_id' => $service->id]);

            DB::commit();

            return redirect()->route('admin.services.page-content', $service)
                ->with('success', 'Page content updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for page content: ', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (Exception $e) {
            DB::rollBack();
            
            Log::error('Error updating page content: ' . $e->getMessage(), [
                'service_id' => $service->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update page content: ' . $e->getMessage());
        }
    }

    private function setDefaultValues(&$data)
    {
        // Set default hero values if not provided, using safe array access
        if (!isset($data['hero_title']) || empty($data['hero_title'])) {
            $data['hero_title'] = $data['title'] ?? '';
        }
        
        if (!isset($data['hero_description']) || empty($data['hero_description'])) {
            $data['hero_description'] = $data['description'] ?? '';
        }
        
        if (!isset($data['hero_badge_text']) || empty($data['hero_badge_text'])) {
            $data['hero_badge_text'] = $data['title'] ?? 'Service';
        }
        
        if (!isset($data['hero_badge_color']) || empty($data['hero_badge_color'])) {
            $data['hero_badge_color'] = $data['color_from'] ?? 'primary';
        }
        
        // Set default CTA values
        if (!isset($data['cta_title']) || empty($data['cta_title'])) {
            $data['cta_title'] = 'Ready to Get Started?';
        }
        
        if (!isset($data['cta_description']) || empty($data['cta_description'])) {
            $serviceName = !empty($data['title']) ? strtolower($data['title']) : 'our';
            $data['cta_description'] = "Transform your business with our professional {$serviceName} solutions.";
        }
        
        if (!isset($data['cta_button_text']) || empty($data['cta_button_text'])) {
            $data['cta_button_text'] = 'Get Started Today';
        }
        
        if (!isset($data['cta_button_link']) || empty($data['cta_button_link'])) {
            $data['cta_button_link'] = '/contact';
        }
        
        // Ensure other fields have default values
        if (!isset($data['hero_subtitle'])) {
            $data['hero_subtitle'] = '';
        }
        
        if (!isset($data['page_content'])) {
            $data['page_content'] = '';
        }
        
        if (!isset($data['key_features'])) {
            $data['key_features'] = '[]';
        }
        
        if (!isset($data['benefits'])) {
            $data['benefits'] = '[]';
        }
        
        if (!isset($data['use_cases'])) {
            $data['use_cases'] = '[]';
        }
    }

    // أضف هذا الmethod الجديد في ServiceController.php
public function deleteService($id)
{
    try {
        // Find service by ID manually instead of model binding
        $service = Service::findOrFail($id);
        
        Log::info('DELETE request received', [
            'service_id' => $service->id,
            'service_title' => $service->title,
            'request_method' => request()->method(),
            'request_url' => request()->url(),
        ]);

        DB::beginTransaction();

        // Delete main image
        if ($service->image && !filter_var($service->image, FILTER_VALIDATE_URL)) {
            try {
                if (Storage::disk('public')->exists($service->image)) {
                    Storage::disk('public')->delete($service->image);
                    Log::info('Main image deleted successfully', ['path' => $service->image]);
                } else {
                    Log::warning('Main image file not found', ['path' => $service->image]);
                }
            } catch (Exception $e) {
                Log::warning('Failed to delete main image: ' . $e->getMessage(), ['path' => $service->image]);
            }
        }

        // Delete hero image if exists
        if ($service->hero_image && !filter_var($service->hero_image, FILTER_VALIDATE_URL)) {
            try {
                if (Storage::disk('public')->exists($service->hero_image)) {
                    Storage::disk('public')->delete($service->hero_image);
                    Log::info('Hero image deleted successfully', ['path' => $service->hero_image]);
                } else {
                    Log::warning('Hero image file not found', ['path' => $service->hero_image]);
                }
            } catch (Exception $e) {
                Log::warning('Failed to delete hero image: ' . $e->getMessage(), ['path' => $service->hero_image]);
            }
        }

        // Store service info before deletion
        $serviceInfo = [
            'id' => $service->id,
            'title' => $service->title,
            'slug' => $service->slug
        ];

        // Delete the service
        $service->delete();
        Log::info('Service deleted successfully from database', $serviceInfo);

        DB::commit();

        // Always return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully.',
            'service' => $serviceInfo
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        DB::rollBack();
        Log::error('Service not found for deletion', [
            'requested_service_id' => $id,
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Service not found.'
        ], 404);

    } catch (Exception $e) {
        DB::rollBack();
        
        Log::error('Error deleting service', [
            'service_id' => $id,
            'error_message' => $e->getMessage(),
            'error_file' => $e->getFile(),
            'error_line' => $e->getLine(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete service: ' . $e->getMessage()
        ], 500);
    }
}
}