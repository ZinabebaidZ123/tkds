<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiSettings;
use Illuminate\Http\Request;

class AiSettingsController extends Controller
{
    /**
     * Show AI settings page
     */
    public function index()
    {
        $settings = AiSettings::getSettings();
        return view('admin.ai.settings', compact('settings'));
    }

    /**
     * Update AI settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'tkds_ai_token' => 'nullable|string|max:255',
            'enabled' => 'boolean',
        ]);

        $settings = AiSettings::getSettings();

        $settings->updateSettings([
            'tkds_ai_token' => $request->input('tkds_ai_token'),
            'enabled' => $request->has('enabled'),
        ]);

        return redirect()
            ->route('admin.ai.settings')
            ->with('success', 'AI settings updated successfully.');
    }
}
