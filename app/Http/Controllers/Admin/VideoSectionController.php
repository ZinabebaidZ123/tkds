<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class VideoSectionController extends Controller
{
    public function index()
    {
        $videoSections = VideoSection::orderBy('sort_order')->orderBy('id')->paginate(10);
        
        return view('admin.video-sections.index', compact('videoSections'));
    }

    public function create()
    {
        return view('admin.video-sections.form');
    }

    public function store(Request $request)
    {
        try {
            Log::info('Video section store attempt', [
                'request_data' => $request->except(['video_file', 'thumbnail']),
                'has_video_file' => $request->hasFile('video_file'),
                'has_thumbnail' => $request->hasFile('thumbnail'),
                'video_type' => $request->get('video_type'),
                'app_url' => config('app.url'), 
                'filesystem_disk' => config('filesystems.default') 
            ]);

            // Validate the request
            $validatedData = $this->validateVideoSection($request);
            
            $data = [
                'title' => $request->get('title'),
                'subtitle' => $request->get('subtitle'),
                'description' => $request->get('description'),
                'video_type' => $request->get('video_type'),
                'video_url' => $request->get('video_url'),
                'background_color' => $request->get('background_color'),
                'text_color' => $request->get('text_color'),
                'overlay_opacity' => $request->get('overlay_opacity', 0.5),
                'button_text' => $request->get('button_text'),
                'button_link' => $request->get('button_link'),
                'sort_order' => $request->get('sort_order', 0),
                'status' => 'active'
            ];

            // Handle boolean values properly
            $data['autoplay'] = $request->has('autoplay') ? 1 : 0;
            $data['loop'] = $request->has('loop') ? 1 : 0;
            $data['muted'] = $request->has('muted') ? 1 : 0;
            $data['controls'] = $request->has('controls') ? 1 : 0;
            $data['overlay_enabled'] = $request->has('overlay_enabled') ? 1 : 0;

            // Handle video file upload
            if ($request->hasFile('video_file') && $request->get('video_type') === 'upload') {
                $videoPath = $this->handleVideoUpload($request->file('video_file'));
                if (!$videoPath) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Failed to upload video file. Please check file size and format.')
                        ->withErrors(['video_file' => 'Failed to upload video file. Please try again.']);
                }
                $data['video_file'] = $videoPath;
                $data['video_url'] = null; // Clear URL when uploading file
            } else {
                $data['video_file'] = null;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $this->handleThumbnailUpload($request->file('thumbnail'));
                if ($thumbnailPath) {
                    $data['thumbnail'] = $thumbnailPath;
                }
            }

            // Set default sort order if not provided
            if (empty($data['sort_order'])) {
                $data['sort_order'] = (VideoSection::max('sort_order') ?? 0) + 1;
            }

            Log::info('Creating video section with data', $data);

            $videoSection = VideoSection::create($data);

            Log::info('Video section created successfully', [
                'id' => $videoSection->id,
                'title' => $videoSection->title,
                'type' => $videoSection->video_type,
                'video_url' => $videoSection->video_url, // 🔥 لتسجيل الرابط النهائي
                'video_source' => $videoSection->video_source // 🔥 لتسجيل المصدر الكامل
            ]);

            return redirect()->route('admin.video-sections.edit', $videoSection)
                ->with('success', 'Video section created successfully.');

        } catch (ValidationException $e) {
            Log::warning('Video section validation failed', [
                'errors' => $e->errors(),
                'input' => $request->except(['video_file', 'thumbnail'])
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Please check the form for validation errors.');
                
        } catch (\Exception $e) {
            Log::error('Failed to create video section', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['video_file', 'thumbnail'])
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create video section: ' . $e->getMessage())
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(VideoSection $videoSection)
    {
        return view('admin.video-sections.show', compact('videoSection'));
    }

    public function edit(VideoSection $videoSection)
    {
        return view('admin.video-sections.form', compact('videoSection'));
    }

    public function update(Request $request, VideoSection $videoSection)
    {
        try {
            Log::info('Video section update attempt', [
                'id' => $videoSection->id,
                'request_data' => $request->except(['video_file', 'thumbnail']),
                'has_video_file' => $request->hasFile('video_file'),
                'has_thumbnail' => $request->hasFile('thumbnail'),
                'app_url' => config('app.url'), 
                'current_video_url' => $videoSection->video_source 
            ]);

            // Validate the request
            $validatedData = $this->validateVideoSection($request, $videoSection);

            $data = [
                'title' => $request->get('title'),
                'subtitle' => $request->get('subtitle'),
                'description' => $request->get('description'),
                'video_type' => $request->get('video_type'),
                'video_url' => $request->get('video_url'),
                'background_color' => $request->get('background_color'),
                'text_color' => $request->get('text_color'),
                'overlay_opacity' => $request->get('overlay_opacity', 0.5),
                'button_text' => $request->get('button_text'),
                'button_link' => $request->get('button_link'),
                'sort_order' => $request->get('sort_order', $videoSection->sort_order)
            ];

            // Handle boolean values properly
            $data['autoplay'] = $request->has('autoplay') ? 1 : 0;
            $data['loop'] = $request->has('loop') ? 1 : 0;
            $data['muted'] = $request->has('muted') ? 1 : 0;
            $data['controls'] = $request->has('controls') ? 1 : 0;
            $data['overlay_enabled'] = $request->has('overlay_enabled') ? 1 : 0;

            // Handle video file upload
            if ($request->hasFile('video_file') && $request->get('video_type') === 'upload') {
                // Delete old video file
                if ($videoSection->video_file && Storage::disk('public')->exists($videoSection->video_file)) {
                    Storage::disk('public')->delete($videoSection->video_file);
                    Log::info('Old video file deleted', ['path' => $videoSection->video_file]);
                }
                
                $videoPath = $this->handleVideoUpload($request->file('video_file'));
                if (!$videoPath) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Failed to upload video file. Please check file size and format.')
                        ->withErrors(['video_file' => 'Failed to upload video file. Please try again.']);
                }
                $data['video_file'] = $videoPath;
                $data['video_url'] = null; // Clear URL when uploading file
            }

            // Clear video file if changing to live stream
            if ($request->get('video_type') === 'live_stream') {
                if ($videoSection->video_file && Storage::disk('public')->exists($videoSection->video_file)) {
                    Storage::disk('public')->delete($videoSection->video_file);
                }
                $data['video_file'] = null;
            }

            // Clear video URL if changing to upload
            if ($request->get('video_type') === 'upload') {
                $data['video_url'] = null;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($videoSection->thumbnail && Storage::disk('public')->exists($videoSection->thumbnail)) {
                    Storage::disk('public')->delete($videoSection->thumbnail);
                }
                
                $thumbnailPath = $this->handleThumbnailUpload($request->file('thumbnail'));
                if ($thumbnailPath) {
                    $data['thumbnail'] = $thumbnailPath;
                }
            }

            Log::info('Updating video section with data', $data);

            $videoSection->update($data);

            $videoSection->refresh();

            Log::info('Video section updated successfully', [
                'id' => $videoSection->id,
                'title' => $videoSection->title,
                'video_url' => $videoSection->video_url, 
                'video_source' => $videoSection->video_source 
            ]);

            return redirect()->route('admin.video-sections.edit', $videoSection)
                ->with('success', 'Video section updated successfully.');

        } catch (ValidationException $e) {
            Log::warning('Video section update validation failed', [
                'errors' => $e->errors(),
                'video_section_id' => $videoSection->id
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Please check the form for validation errors.');
                
        } catch (\Exception $e) {
            Log::error('Failed to update video section', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
                'video_section_id' => $videoSection->id
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update video section: ' . $e->getMessage())
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(VideoSection $videoSection)
    {
        try {
            // Delete associated files
            if ($videoSection->video_file && Storage::disk('public')->exists($videoSection->video_file)) {
                Storage::disk('public')->delete($videoSection->video_file);
                Log::info('Video file deleted', ['path' => $videoSection->video_file]);
            }
            
            if ($videoSection->thumbnail && Storage::disk('public')->exists($videoSection->thumbnail)) {
                Storage::disk('public')->delete($videoSection->thumbnail);
                Log::info('Thumbnail deleted', ['path' => $videoSection->thumbnail]);
            }

            $videoSection->delete();

            Log::info('Video section deleted successfully', [
                'id' => $videoSection->id,
                'title' => $videoSection->title
            ]);

            return redirect()->route('admin.video-sections.index')
                ->with('success', 'Video section deleted successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to delete video section', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'video_section_id' => $videoSection->id
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to delete video section: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, VideoSection $videoSection)
    {
        try {
            $request->validate([
                'status' => 'required|in:active,inactive'
            ]);

            $videoSection->update(['status' => $request->status]);

            Log::info('Video section status updated', [
                'id' => $videoSection->id,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'status' => $videoSection->status
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update video section status', [
                'error' => $e->getMessage(),
                'video_section_id' => $videoSection->id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }

    public function updateSortOrder(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|exists:video_sections,id',
                'items.*.sort_order' => 'required|integer|min:0'
            ]);

            foreach ($request->items as $item) {
                VideoSection::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
            }

            Log::info('Video sections sort order updated', [
                'items_count' => count($request->items)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sort order updated successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update video sections sort order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update sort order.'
            ], 500);
        }
    }

    /**
     * Validate video section request
     */
    private function validateVideoSection(Request $request, $videoSection = null)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:2000',
            'video_type' => 'required|in:upload,live_stream',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv,webm,flv,mkv|max:512000', // 500MB max
            'video_url' => 'nullable|url|max:500',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:10240', // 10MB
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'overlay_opacity' => 'nullable|numeric|between:0,1',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ];

        // Conditional validation based on video type
        if ($request->get('video_type') === 'upload') {
            // If it's a new video section or existing one doesn't have a video file, require upload
            if (!$videoSection || (!$videoSection->video_file && !$request->hasFile('video_file'))) {
                $rules['video_file'] = 'required|file|mimes:mp4,mov,avi,wmv,webm,flv,mkv|max:512000';
            }
        } elseif ($request->get('video_type') === 'live_stream') {
            $rules['video_url'] = 'required|url|max:500';
        }

        $messages = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title cannot exceed 255 characters.',
            'video_type.required' => 'Video type is required.',
            'video_type.in' => 'Invalid video type.',
            'video_file.required' => 'Video file is required when selecting "Upload File".',
            'video_file.file' => 'Must be a valid video file.',
            'video_file.mimes' => 'Video must be: mp4, mov, avi, wmv, webm, flv, mkv.',
            'video_file.max' => 'Video size cannot exceed 500MB.',
            'video_url.required' => 'Video URL is required when selecting "Live Stream".',
            'video_url.url' => 'Must be a valid URL.',
            'thumbnail.image' => 'Must be a valid image.',
            'thumbnail.mimes' => 'Image must be: jpg, jpeg, png, webp, gif.',
            'thumbnail.max' => 'Image size cannot exceed 10MB.',
        ];

        return $request->validate($rules, $messages);
    }

    /**
     * Handle video file upload with enhanced logging
     */
    private function handleVideoUpload($videoFile)
    {
        try {
            // Check if file is valid
            if (!$videoFile->isValid()) {
                Log::error('Invalid video file uploaded', [
                    'error' => $videoFile->getError(),
                    'error_message' => $videoFile->getErrorMessage()
                ]);
                return false;
            }

            // Validate MIME type
            $allowedMimes = [
                'video/mp4',
                'video/quicktime', // MOV
                'video/x-msvideo', // AVI
                'video/x-ms-wmv', // WMV
                'video/webm',
                'video/x-flv',
                'video/x-matroska' // MKV
            ];

            $mimeType = $videoFile->getMimeType();
            if (!in_array($mimeType, $allowedMimes)) {
                Log::warning('Unsupported video mime type', [
                    'mime_type' => $mimeType,
                    'allowed_mimes' => $allowedMimes
                ]);
                return false;
            }

            // Check file size (500MB = 524,288,000 bytes)
            if ($videoFile->getSize() > 524288000) {
                Log::warning('Video file too large', [
                    'size' => $videoFile->getSize(),
                    'max_size' => 524288000,
                    'size_mb' => round($videoFile->getSize() / 1024 / 1024, 2)
                ]);
                return false;
            }

            // Generate unique filename
            $extension = $videoFile->getClientOriginalExtension();
            $filename = time() . '_' . Str::random(10) . '_' . Str::slug(pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
            
            Log::info('Attempting to store video file', [
                'original_name' => $videoFile->getClientOriginalName(),
                'new_filename' => $filename,
                'size' => $videoFile->getSize(),
                'size_mb' => round($videoFile->getSize() / 1024 / 1024, 2),
                'mime' => $videoFile->getMimeType(),
                'app_url' => config('app.url'), // 🔥
                'filesystem_disk' => config('filesystems.default') // 🔥
            ]);

            // Create directories if they don't exist
            if (!Storage::disk('public')->exists('videos')) {
                Storage::disk('public')->makeDirectory('videos');
                Log::info('Created videos directory');
            }
            
            // Store file
            $videoPath = $videoFile->storeAs('videos', $filename, 'public');
            
            if (!$videoPath) {
                Log::error('Failed to store video file - storeAs returned false');
                return false;
            }
            
            // Verify file was stored
            if (!Storage::disk('public')->exists($videoPath)) {
                Log::error('Video file was not stored successfully', [
                    'path' => $videoPath,
                    'expected_full_path' => Storage::disk('public')->path($videoPath)
                ]);
                return false;
            }
            
            Log::info('Video file uploaded successfully', [
                'original_name' => $videoFile->getClientOriginalName(),
                'stored_path' => $videoPath,
                'size' => $videoFile->getSize(),
                'size_mb' => round($videoFile->getSize() / 1024 / 1024, 2),
                'full_system_path' => Storage::disk('public')->path($videoPath),
                'storage_url' => Storage::disk('public')->url($videoPath), 
                'asset_url' => asset('storage/' . $videoPath),
                'app_url' => config('app.url'),
                'expected_public_url' => config('app.url') . '/storage/' . $videoPath 
            ]);
            
            return $videoPath;
            
        } catch (\Exception $e) {
            Log::error('Video upload failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Handle thumbnail upload with enhanced logging
     */
    private function handleThumbnailUpload($thumbnailFile)
    {
        try {
            // Check if file is valid
            if (!$thumbnailFile->isValid()) {
                Log::error('Invalid thumbnail file uploaded', [
                    'error' => $thumbnailFile->getError(),
                    'error_message' => $thumbnailFile->getErrorMessage()
                ]);
                return false;
            }

            // Check file size (10MB = 10,485,760 bytes)
            if ($thumbnailFile->getSize() > 10485760) {
                Log::warning('Thumbnail file too large', [
                    'size' => $thumbnailFile->getSize(),
                    'max_size' => 10485760,
                    'size_mb' => round($thumbnailFile->getSize() / 1024 / 1024, 2)
                ]);
                return false;
            }

            // Generate unique filename
            $extension = $thumbnailFile->getClientOriginalExtension();
            $thumbnailFilename = time() . '_thumb_' . Str::random(8) . '_' . Str::slug(pathinfo($thumbnailFile->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
            
            Log::info('Attempting to store thumbnail file', [
                'original_name' => $thumbnailFile->getClientOriginalName(),
                'new_filename' => $thumbnailFilename,
                'size' => $thumbnailFile->getSize(),
                'mime' => $thumbnailFile->getMimeType()
            ]);

            // Create directories if they don't exist
            if (!Storage::disk('public')->exists('videos/thumbnails')) {
                Storage::disk('public')->makeDirectory('videos/thumbnails');
                Log::info('Created thumbnails directory');
            }
            
            // Store file
            $thumbnailPath = $thumbnailFile->storeAs('videos/thumbnails', $thumbnailFilename, 'public');
            
            if (!$thumbnailPath) {
                Log::error('Failed to store thumbnail file');
                return false;
            }
            
            // Verify file was stored
            if (!Storage::disk('public')->exists($thumbnailPath)) {
                Log::error('Thumbnail file was not stored successfully', [
                    'path' => $thumbnailPath
                ]);
                return false;
            }
            
            // 🔥 تسجيل كل المعلومات المهمة
            Log::info('Thumbnail uploaded successfully', [
                'original_name' => $thumbnailFile->getClientOriginalName(),
                'stored_path' => $thumbnailPath,
                'size' => $thumbnailFile->getSize(),
                'full_system_path' => Storage::disk('public')->path($thumbnailPath),
                'storage_url' => Storage::disk('public')->url($thumbnailPath), // 🔥
                'asset_url' => asset('storage/' . $thumbnailPath), // 🔥
                'expected_public_url' => config('app.url') . '/storage/' . $thumbnailPath // 🔥
            ]);
            
            return $thumbnailPath;
            
        } catch (\Exception $e) {
            Log::error('Thumbnail upload failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}