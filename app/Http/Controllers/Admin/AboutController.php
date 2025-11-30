<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use App\Models\AboutValue;
use App\Models\AboutTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    // About Settings Management
    public function settings()
    {
        $settings = AboutSetting::getSettings();
        return view('admin.about.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'hero_badge_text' => 'nullable|string|max:100',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_description' => 'nullable|string',
            'mission_title' => 'nullable|string|max:255',
            'mission_content' => 'nullable|string',
            'innovation_title' => 'nullable|string|max:255',
            'innovation_content' => 'nullable|string',
            'stat_1_number' => 'nullable|string|max:20',
            'stat_1_label' => 'nullable|string|max:50',
            'stat_2_number' => 'nullable|string|max:20',
            'stat_2_label' => 'nullable|string|max:50',
            'video_enabled' => 'boolean',
            'video_url' => 'nullable|url|max:500',
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'uptime_percentage' => 'nullable|string|max:10',
            'latency_time' => 'nullable|string|max:10',
            'quality_level' => 'nullable|string|max:10',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $settings = AboutSetting::getSettings();
        $data = $request->all();

        // Handle video thumbnail upload
        if ($request->hasFile('video_thumbnail')) {
            // Delete old thumbnail if exists
            if ($settings->video_thumbnail && !filter_var($settings->video_thumbnail, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($settings->video_thumbnail);
            }
            
            $thumbnailPath = $request->file('video_thumbnail')->store('about/video', 'public');
            $data['video_thumbnail'] = $thumbnailPath;
        }

        $settings->update($data);

        return redirect()->route('admin.about.settings')
            ->with('success', 'About settings updated successfully.');
    }

    // About Values Management
    public function values()
    {
        $values = AboutValue::ordered()->paginate(10);
        return view('admin.about.values.index', compact('values'));
    }

    public function createValue()
    {
        return view('admin.about.values.addedit');
    }

    public function storeValue(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:100',
            'color_from' => 'required|string|max:20',
            'color_to' => 'required|string|max:20',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        AboutValue::create($request->all());

        return redirect()->route('admin.about.values.index')
            ->with('success', 'Value added successfully.');
    }

    public function editValue(AboutValue $value)
    {
        return view('admin.about.values.addedit', compact('value'));
    }

    public function updateValue(Request $request, AboutValue $value)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:100',
            'color_from' => 'required|string|max:20',
            'color_to' => 'required|string|max:20',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $value->update($request->all());

        return redirect()->route('admin.about.values.index')
            ->with('success', 'Value updated successfully.');
    }

    public function destroyValue(AboutValue $value)
    {
        $value->delete();

        return redirect()->route('admin.about.values.index')
            ->with('success', 'Value deleted successfully.');
    }

    public function updateValueStatus(Request $request, AboutValue $value)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $value->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $value->status
        ]);
    }

    // About Timeline Management  
    public function timeline()
    {
        $timeline = AboutTimeline::ordered()->paginate(10);
        return view('admin.about.timeline.index', compact('timeline'));
    }

    public function createTimeline()
    {
        return view('admin.about.timeline.addedit');
    }

    public function storeTimeline(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:10',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'color' => 'required|in:primary,secondary,accent',
            'position' => 'required|in:left,right',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        AboutTimeline::create($request->all());

        return redirect()->route('admin.about.timeline.index')
            ->with('success', 'Timeline item added successfully.');
    }

    public function editTimeline(AboutTimeline $timeline)
    {
        return view('admin.about.timeline.addedit', compact('timeline'));
    }

    public function updateTimeline(Request $request, AboutTimeline $timeline)
    {
        $request->validate([
            'year' => 'required|string|max:10',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'color' => 'required|in:primary,secondary,accent',
            'position' => 'required|in:left,right',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $timeline->update($request->all());

        return redirect()->route('admin.about.timeline.index')
            ->with('success', 'Timeline item updated successfully.');
    }

    public function destroyTimeline(AboutTimeline $timeline)
    {
        $timeline->delete();

        return redirect()->route('admin.about.timeline.index')
            ->with('success', 'Timeline item deleted successfully.');
    }

    public function updateTimelineStatus(Request $request, AboutTimeline $timeline)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $timeline->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $timeline->status
        ]);
    }

    // Sort Order Updates
    public function updateValuesSortOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:about_values,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            AboutValue::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sort order updated successfully.'
        ]);
    }

    public function updateTimelineSortOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:about_timeline,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            AboutTimeline::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sort order updated successfully.'
        ]);
    }
}