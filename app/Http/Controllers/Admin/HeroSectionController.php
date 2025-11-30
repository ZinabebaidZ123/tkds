<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function index()
    {
        $heroSections = HeroSection::ordered()->paginate(10);

        return view('admin.hero-sections.index', compact('heroSections'));
    }

    public function create()
    {
        return view('admin.hero-sections.addedit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'main_button_text' => 'required|string|max:100',
            'main_button_link' => 'required|string|max:255',
            'second_button_text' => 'nullable|string|max:100',
            'second_button_link' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'background_video' => 'nullable|mimes:mp4,avi,mov|max:51200',
            'text_color' => 'nullable|string|max:7',
            'gradient_color_1' => 'nullable|string|max:7',
            'gradient_color_2' => 'nullable|string|max:7',
            'gradient_color_3' => 'nullable|string|max:7',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer|min:0',
            'ai_badge_text' => 'nullable|string|max:255',
            'perfect_for_title' => 'nullable|string|max:255',
            'perfect_for_subtitle' => 'nullable|string|max:255',
            'custom_css' => 'nullable|string',
        ]);

        $data = $request->all();

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            $imagePath = $request->file('background_image')->store('hero/images', 'public');
            $data['background_image'] = $imagePath;
        }

        // Handle background video upload
        if ($request->hasFile('background_video')) {
            $videoPath = $request->file('background_video')->store('hero/videos', 'public');
            $data['background_video'] = $videoPath;
        }

        // Set default values for checkboxes
        $data['show_ai_badge'] = $request->has('show_ai_badge');
        $data['show_rotating_cards'] = $request->has('show_rotating_cards');
        $data['show_particles'] = $request->has('show_particles');

        HeroSection::create($data);

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section created successfully.');
    }

    public function show(HeroSection $heroSection)
    {
        return view('admin.hero-sections.show', compact('heroSection'));
    }

    public function edit(HeroSection $heroSection)
    {
        return view('admin.hero-sections.addedit', ['heroSection' => $heroSection]);
    }

    public function update(Request $request, HeroSection $heroSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'main_button_text' => 'required|string|max:100',
            'main_button_link' => 'required|string|max:255',
            'second_button_text' => 'nullable|string|max:100',
            'second_button_link' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'background_video' => 'nullable|mimes:mp4,avi,mov|max:51200',
            'text_color' => 'nullable|string|max:7',
            'gradient_color_1' => 'nullable|string|max:7',
            'gradient_color_2' => 'nullable|string|max:7',
            'gradient_color_3' => 'nullable|string|max:7',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer|min:0',
            'ai_badge_text' => 'nullable|string|max:255',
            'perfect_for_title' => 'nullable|string|max:255',
            'perfect_for_subtitle' => 'nullable|string|max:255',
            'custom_css' => 'nullable|string',
            'remove_background_image' => 'nullable|boolean',
            'remove_background_video' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Handle background image removal
        if ($request->input('remove_background_image')) {
            if ($heroSection->background_image && !filter_var($heroSection->background_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($heroSection->background_image);
            }
            $data['background_image'] = null;
        }

        // Handle background video removal  
        if ($request->input('remove_background_video')) {
            if ($heroSection->background_video && !filter_var($heroSection->background_video, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($heroSection->background_video);
            }
            $data['background_video'] = null;
        }

        // Handle new background image upload
        if ($request->hasFile('background_image')) {
            // Delete old image if it's not a URL and not already marked for removal
            if ($heroSection->background_image && !filter_var($heroSection->background_image, FILTER_VALIDATE_URL) && !$request->input('remove_background_image')) {
                Storage::disk('public')->delete($heroSection->background_image);
            }

            $imagePath = $request->file('background_image')->store('hero/images', 'public');
            $data['background_image'] = $imagePath;
        }

        // Handle new background video upload
        if ($request->hasFile('background_video')) {
            // Delete old video if it's not a URL and not already marked for removal
            if ($heroSection->background_video && !filter_var($heroSection->background_video, FILTER_VALIDATE_URL) && !$request->input('remove_background_video')) {
                Storage::disk('public')->delete($heroSection->background_video);
            }

            $videoPath = $request->file('background_video')->store('hero/videos', 'public');
            $data['background_video'] = $videoPath;
        }

        // Set default values for checkboxes
        $data['show_ai_badge'] = $request->has('show_ai_badge');
        $data['show_rotating_cards'] = $request->has('show_rotating_cards');
        $data['show_particles'] = $request->has('show_particles');

        // Remove the removal flags from data
        unset($data['remove_background_image'], $data['remove_background_video']);

        $heroSection->update($data);

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section updated successfully.');
    }
    public function destroy(HeroSection $heroSection)
    {
        // Delete background image if it's not a URL
        if ($heroSection->background_image && !filter_var($heroSection->background_image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($heroSection->background_image);
        }

        // Delete background video if it's not a URL
        if ($heroSection->background_video && !filter_var($heroSection->background_video, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($heroSection->background_video);
        }

        $heroSection->delete();

        return redirect()->route('admin.hero-sections.index')
            ->with('success', 'Hero section deleted successfully.');
    }

    public function updateStatus(Request $request, HeroSection $heroSection)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $heroSection->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $heroSection->status
        ]);
    }
}
