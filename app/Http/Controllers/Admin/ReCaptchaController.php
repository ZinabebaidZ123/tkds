<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReCaptchaSettings;
use App\Services\ReCaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReCaptchaController extends Controller
{
    private ReCaptchaService $recaptchaService;

    public function __construct(ReCaptchaService $recaptchaService)
    {
        $this->recaptchaService = $recaptchaService;
    }

    /**
     * Show reCAPTCHA settings
     */
    public function index()
    {
        $settings = ReCaptchaSettings::getSettings();
        
        return view('admin.recaptcha.index', compact('settings'));
    }

    /**
     * Update reCAPTCHA settings
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_key' => 'nullable|string|max:500',
            'secret_key' => 'nullable|string|max:500',
            'enabled' => 'boolean',
            'login_enabled' => 'boolean',
            'register_enabled' => 'boolean',
            'contact_enabled' => 'boolean',
            'comment_enabled' => 'boolean',
            'version' => 'required|in:v2,v3',
            'v3_score_threshold' => 'required_if:version,v3|numeric|between:0.0,1.0',
            'theme' => 'required|in:light,dark',
            'size' => 'required|in:normal,compact',
            'language' => 'required|string|max:10',
            'custom_error_message' => 'nullable|string|max:1000',
            'invisible_badge' => 'boolean',
            'excluded_ips' => 'nullable|string'
        ], [
            'site_key.max' => 'Site key cannot exceed 500 characters.',
            'secret_key.max' => 'Secret key cannot exceed 500 characters.',
            'v3_score_threshold.required_if' => 'Score threshold is required for reCAPTCHA v3.',
            'v3_score_threshold.between' => 'Score threshold must be between 0.0 and 1.0.',
            'custom_error_message.max' => 'Error message cannot exceed 1000 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $settings = ReCaptchaSettings::getSettings();
            
            // Process excluded IPs
            $excludedIps = [];
            if ($request->excluded_ips) {
                $ips = explode("\n", $request->excluded_ips);
                foreach ($ips as $ip) {
                    $ip = trim($ip);
                    if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP)) {
                        $excludedIps[] = $ip;
                    }
                }
            }

            $data = [
                'site_key' => $request->site_key,
                'secret_key' => $request->secret_key,
                'enabled' => $request->boolean('enabled'),
                'login_enabled' => $request->boolean('login_enabled'),
                'register_enabled' => $request->boolean('register_enabled'),
                'contact_enabled' => $request->boolean('contact_enabled'),
                'comment_enabled' => $request->boolean('comment_enabled'),
                'version' => $request->version,
                'v3_score_threshold' => $request->version === 'v3' ? $request->v3_score_threshold : 0.5,
                'theme' => $request->theme,
                'size' => $request->size,
                'language' => $request->language,
                'custom_error_message' => $request->custom_error_message,
                'invisible_badge' => $request->boolean('invisible_badge'),
                'excluded_ips' => $excludedIps
            ];

            $settings->updateSettings($data);

            return redirect()->back()->with('success', 'reCAPTCHA settings updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Failed to update reCAPTCHA settings', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withErrors(['general' => 'Failed to update settings. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Test reCAPTCHA configuration
     */
    public function testConfiguration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_key' => 'required|string',
            'secret_key' => 'required|string',
            'test_response' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid test data provided.'
            ], 422);
        }

        try {
            // Temporarily create a service with test keys
            $testSettings = new ReCaptchaSettings([
                'site_key' => $request->site_key,
                'secret_key' => $request->secret_key,
                'enabled' => true,
                'version' => $request->version ?? 'v2'
            ]);

            // Mock the service for testing
            $success = $this->verifyTestResponse(
                $request->secret_key,
                $request->test_response,
                $request->ip()
            );

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'reCAPTCHA configuration is working correctly!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'reCAPTCHA verification failed. Please check your keys.'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error testing configuration: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get reCAPTCHA statistics
     */
    public function statistics()
    {
        // This would require additional logging/tracking
        // For now, return basic info
        $settings = ReCaptchaSettings::getSettings();
        
        $stats = [
            'enabled' => $settings->isEnabled(),
            'version' => $settings->version,
            'enabled_forms' => [
                'login' => $settings->login_enabled,
                'register' => $settings->register_enabled,
                'contact' => $settings->contact_enabled,
                'comment' => $settings->comment_enabled,
            ],
            'excluded_ips_count' => count($settings->excluded_ips ?? []),
            'last_updated' => $settings->updated_at?->diffForHumans(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Reset reCAPTCHA settings to default
     */
    public function reset()
    {
        try {
            $settings = ReCaptchaSettings::getSettings();
            
            $settings->updateSettings([
                'site_key' => '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
                'secret_key' => '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe',
                'enabled' => false,
                'login_enabled' => true,
                'register_enabled' => true,
                'contact_enabled' => true,
                'comment_enabled' => false,
                'version' => 'v2',
                'v3_score_threshold' => 0.5,
                'theme' => 'light',
                'size' => 'normal',
                'language' => 'en',
                'custom_error_message' => 'Please verify that you are not a robot.',
                'invisible_badge' => false,
                'excluded_ips' => ['127.0.0.1', '::1']
            ]);

            return redirect()->back()->with('success', 'reCAPTCHA settings reset to default values.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['general' => 'Failed to reset settings.']);
        }
    }

    /**
     * Helper method to verify test response
     */
    private function verifyTestResponse(string $secretKey, string $response, string $ip): bool
    {
        try {
            $httpResponse = \Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $response,
                'remoteip' => $ip
            ]);

            $result = $httpResponse->json();
            return $result['success'] ?? false;

        } catch (\Exception $e) {
            return false;
        }
    }
}