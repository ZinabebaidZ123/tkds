<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BroadcastingSolution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BroadcastingSolutionController extends Controller
{
    public function index()
    {
        $solutions = BroadcastingSolution::orderBy('sort_order', 'asc')
                                       ->orderBy('created_at', 'desc')
                                       ->paginate(10);
        
        return view('admin.broadcasting-solutions.index', compact('solutions'));
    }

    public function create()
    {
        return view('admin.broadcasting-solutions.addedit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_part1' => 'nullable|string|max:255',
            'title_part2' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('broadcasting', 'public');
            $data['image'] = $imagePath;
        }

        BroadcastingSolution::create($data);

        return redirect()->route('admin.broadcasting-solutions.index')
            ->with('success', 'Broadcasting solution created successfully.');
    }

    public function show(BroadcastingSolution $broadcastingSolution)
    {
        return view('admin.broadcasting-solutions.show', compact('broadcastingSolution'));
    }

    public function edit(BroadcastingSolution $broadcastingSolution)
    {
        return view('admin.broadcasting-solutions.addedit', ['solution' => $broadcastingSolution]);
    }

    public function update(Request $request, BroadcastingSolution $broadcastingSolution)
    {
        $request->validate([
            'title_part1' => 'nullable|string|max:255',
            'title_part2' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it's not a URL
            if ($broadcastingSolution->image && !filter_var($broadcastingSolution->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($broadcastingSolution->image);
            }
            
            $imagePath = $request->file('image')->store('broadcasting', 'public');
            $data['image'] = $imagePath;
        }

        $broadcastingSolution->update($data);

        return redirect()->route('admin.broadcasting-solutions.index')
            ->with('success', 'Broadcasting solution updated successfully.');
    }

    public function destroy(BroadcastingSolution $broadcastingSolution)
    {
        // Delete image if it's not a URL
        if ($broadcastingSolution->image && !filter_var($broadcastingSolution->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($broadcastingSolution->image);
        }

        $broadcastingSolution->delete();

        return redirect()->route('admin.broadcasting-solutions.index')
            ->with('success', 'Broadcasting solution deleted successfully.');
    }

    public function updateStatus(Request $request, BroadcastingSolution $broadcastingSolution)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $broadcastingSolution->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $broadcastingSolution->status
        ]);
    }

    public function getSectionTitle()
    {
        $firstSolution = BroadcastingSolution::active()->ordered()->first();
        
        return response()->json([
            'success' => true,
            'title_part1' => $firstSolution->title_part1 ?? '',
            'title_part2' => $firstSolution->title_part2 ?? '',
            'subtitle' => $firstSolution->subtitle ?? ''
        ]);
    }

    public function updateSectionTitle(Request $request)
    {
        $request->validate([
            'title_part1' => 'nullable|string|max:255',
            'title_part2' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
        ]);

        // Update the first active solution or create a new one if none exists
        $firstSolution = BroadcastingSolution::active()->ordered()->first();
        
        if ($firstSolution) {
            $firstSolution->update([
                'title_part1' => $request->title_part1,
                'title_part2' => $request->title_part2,
                'subtitle' => $request->subtitle
            ]);
        } else {
            // If no solution exists, create a default one with section title data
            BroadcastingSolution::create([
                'title_part1' => $request->title_part1,
                'title_part2' => $request->title_part2,
                'subtitle' => $request->subtitle,
                'title' => 'Default Broadcasting Solution',
                'description' => 'This is a default solution created for section title management.',
                'image' => 'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=800',
                'status' => 'active',
                'sort_order' => 0
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Section title updated successfully.'
        ]);
    }
}