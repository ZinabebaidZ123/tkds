<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('category', 'asc')
                        ->orderBy('sort_order', 'asc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
        
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.addedit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_url' => 'nullable|url|max:255',
            'category' => 'required|in:streaming,news_sports,tech_gaming,other',
            'background_color' => 'required|string|max:7',
            'hover_background_color' => 'nullable|string|max:7',
            'border_color' => 'nullable|string|max:7',
            'hover_scale' => 'required|numeric|between:1.00,2.00',
            'opacity' => 'required|numeric|between:0.10,1.00',
            'hover_opacity' => 'required|numeric|between:0.10,1.00',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('clients', 'public');
            $data['logo'] = $logoPath;
        }

        Client::create($data);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        return view('admin.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('admin.clients.addedit', ['client' => $client]);
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_url' => 'nullable|url|max:255',
            'category' => 'required|in:streaming,news_sports,tech_gaming,other',
            'background_color' => 'required|string|max:7',
            'hover_background_color' => 'nullable|string|max:7',
            'border_color' => 'nullable|string|max:7',
            'hover_scale' => 'required|numeric|between:1.00,2.00',
            'opacity' => 'required|numeric|between:0.10,1.00',
            'hover_opacity' => 'required|numeric|between:0.10,1.00',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if it's not a URL
            if ($client->logo && !filter_var($client->logo, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($client->logo);
            }
            
            $logoPath = $request->file('logo')->store('clients', 'public');
            $data['logo'] = $logoPath;
        }

        $client->update($data);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        // Delete logo if it's not a URL
        if ($client->logo && !filter_var($client->logo, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($client->logo);
        }

        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    public function updateStatus(Request $request, Client $client)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $client->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $client->status
        ]);
    }
}