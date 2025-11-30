<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerfectForCard;
use Illuminate\Http\Request;

class PerfectForCardController extends Controller
{
    public function index()
    {
        $cards = PerfectForCard::ordered()->paginate(10);
        
        return view('admin.perfect-for-cards.index', compact('cards'));
    }

    public function create()
    {
        return view('admin.perfect-for-cards.addedit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'border_color' => 'required|string|max:7',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer|min:0',
        ]);

        PerfectForCard::create($request->all());

        return redirect()->route('admin.perfect-for-cards.index')
            ->with('success', 'Perfect For card created successfully.');
    }

    public function show(PerfectForCard $perfectForCard)
    {
        return view('admin.perfect-for-cards.show', compact('perfectForCard'));
    }

    public function edit(PerfectForCard $perfectForCard)
    {
        return view('admin.perfect-for-cards.addedit', ['card' => $perfectForCard]);
    }

    public function update(Request $request, PerfectForCard $perfectForCard)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
            'border_color' => 'required|string|max:7',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer|min:0',
        ]);

        $perfectForCard->update($request->all());

        return redirect()->route('admin.perfect-for-cards.index')
            ->with('success', 'Perfect For card updated successfully.');
    }

    public function destroy(PerfectForCard $perfectForCard)
    {
        $perfectForCard->delete();

        return redirect()->route('admin.perfect-for-cards.index')
            ->with('success', 'Perfect For card deleted successfully.');
    }

    public function updateStatus(Request $request, PerfectForCard $perfectForCard)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $perfectForCard->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $perfectForCard->status
        ]);
    }
}