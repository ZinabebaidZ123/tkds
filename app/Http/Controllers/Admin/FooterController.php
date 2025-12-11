<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $settings = FooterSetting::getSettings();
        return view('admin.footer.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Define boolean fields that might not be sent when unchecked
        $booleanFields = [
            'newsletter_enabled',
            'show_services_section',
            'show_company_section', 
            'show_legal_section',
            'show_social_media',
            'show_trust_badges'
        ];

        // Merge boolean fields with default false values
        $mergedRequest = $request->all();
        foreach ($booleanFields as $field) {
            if (!$request->has($field)) {
                $mergedRequest[$field] = false;
            } else {
                $mergedRequest[$field] = true;
            }
        }

        // Create a new request with merged data for validation
        $request->merge($mergedRequest);

        $validatedData = $request->validate([
            // Newsletter
            'newsletter_enabled' => 'boolean',
            'newsletter_title' => 'required|string|max:255',
            'newsletter_subtitle' => 'nullable|string',
            'newsletter_placeholder' => 'nullable|string|max:255',
            'newsletter_button_text' => 'nullable|string|max:100',
            'newsletter_privacy_text' => 'nullable|string',
            
            // Company
            'company_name' => 'required|string|max:255',
            'company_tagline' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
            
            // Contact
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'support_hours' => 'nullable|string|max:255',
            
            // Social Media
            'social_twitter' => 'nullable|url|max:500',
            'social_linkedin' => 'nullable|url|max:500',
            'social_youtube' => 'nullable|url|max:500',
            'social_instagram' => 'nullable|url|max:500',
            'social_facebook' => 'nullable|url|max:500',
            'social_tiktok' => 'nullable|url|max:500',
            
            // Display Control
            'show_services_section' => 'boolean',
            'show_company_section' => 'boolean',
            'show_legal_section' => 'boolean',
            'show_social_media' => 'boolean',
            'show_trust_badges' => 'boolean',
            
            // Footer Text
            'copyright_text' => 'nullable|string|max:500',
            'footer_subtitle' => 'nullable|string|max:500',
            
            // Trust Badges
            'ssl_secured_text' => 'nullable|string|max:100',
            'iso_certified_text' => 'nullable|string|max:100',
            'global_cdn_text' => 'nullable|string|max:100',
            'back_to_top_text' => 'nullable|string|max:100',
            
            'status' => 'required|in:active,inactive',
        ]);

        $settings = FooterSetting::getSettings();
        $settings->update($validatedData);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer settings updated successfully.');
    }
}