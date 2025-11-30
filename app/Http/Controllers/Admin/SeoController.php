<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use App\Models\PageSeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    // ==================== GLOBAL SEO SETTINGS ====================
    
    public function globalSettings()
    {
        $settings = SeoSetting::getSettings();
        return view('admin.seo.global-settings', compact('settings'));
    }

    public function updateGlobalSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:500',
            'site_description' => 'required|string|max:1000',
            'site_keywords' => 'nullable|string|max:1000',
            'site_author' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'favicon' => 'nullable|file|mimes:ico,png|max:1024',
            'og_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'apple_touch_icon' => 'nullable|image|mimes:png|max:1024',
            'twitter_username' => 'nullable|string|max:100',
            'facebook_app_id' => 'nullable|string|max:100',
            'google_analytics_id' => 'nullable|string|max:100',
            'google_tag_manager_id' => 'nullable|string|max:100',
            'facebook_pixel_id' => 'nullable|string|max:100',
            'google_site_verification' => 'nullable|string|max:255',
            'bing_site_verification' => 'nullable|string|max:255',
            'yandex_site_verification' => 'nullable|string|max:255',
            'robots_txt' => 'nullable|string',
            'custom_head_code' => 'nullable|string',
            'custom_body_code' => 'nullable|string',
            'custom_footer_code' => 'nullable|string',
            'theme_color' => 'required|string|max:20',
            'background_color' => 'required|string|max:20',
            'default_language' => 'required|string|max:10',
            'rtl_support' => 'boolean',
            'sitemap_enabled' => 'boolean',
            'sitemap_auto_generate' => 'boolean',
            'breadcrumbs_enabled' => 'boolean',
            'canonical_urls_enabled' => 'boolean',
            'open_graph_enabled' => 'boolean',
            'twitter_cards_enabled' => 'boolean',
            'json_ld_enabled' => 'boolean',
            'amp_enabled' => 'boolean',
            'pwa_enabled' => 'boolean',
            'status' => 'required|in:active,inactive',
        ]);

        $settings = SeoSetting::getSettings();
        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            if ($settings->site_logo && !filter_var($settings->site_logo, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($settings->site_logo);
            }
            $data['site_logo'] = $request->file('site_logo')->store('seo/logos', 'public');
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            if ($settings->favicon && !filter_var($settings->favicon, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($settings->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('seo/favicons', 'public');
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            if ($settings->og_image && !filter_var($settings->og_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($settings->og_image);
            }
            $data['og_image'] = $request->file('og_image')->store('seo/og-images', 'public');
        }

        // Handle Apple touch icon upload
        if ($request->hasFile('apple_touch_icon')) {
            if ($settings->apple_touch_icon && !filter_var($settings->apple_touch_icon, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($settings->apple_touch_icon);
            }
            $data['apple_touch_icon'] = $request->file('apple_touch_icon')->store('seo/apple-icons', 'public');
        }

        // Handle JSON fields
        if ($request->has('social_links')) {
            $data['social_links'] = $request->input('social_links');
        }

        if ($request->has('contact_info')) {
            $data['contact_info'] = $request->input('contact_info');
        }

        if ($request->has('schema_organization')) {
            $data['schema_organization'] = $request->input('schema_organization');
        }

        if ($request->has('languages')) {
            $data['languages'] = $request->input('languages');
        }

        $settings->update($data);

        return redirect()->route('admin.seo.global-settings')
            ->with('success', 'Global SEO settings updated successfully.');
    }

    // ==================== PAGE SEO SETTINGS ====================
    
    public function pageSettings()
    {
        $pages = PageSeoSetting::orderBy('page_route')->paginate(15);
        return view('admin.seo.page-settings', compact('pages'));
    }

    public function createPageSetting()
    {
        return view('admin.seo.page-addedit');
    }

    public function storePageSetting(Request $request)
    {
        $request->validate([
            'page_route' => 'required|string|max:255|unique:page_seo_settings,page_route',
            'page_title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:1000',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'og_type' => 'nullable|string|max:50',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'twitter_card_type' => 'nullable|string|max:50',
            'canonical_url' => 'nullable|url|max:500',
            'robots' => 'nullable|string|max:100',
            'custom_head_code' => 'nullable|string',
            'custom_body_code' => 'nullable|string',
            'priority' => 'nullable|numeric|between:0.0,1.0',
            'change_frequency' => 'nullable|in:always,hourly,daily,weekly,monthly,yearly,never',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo/page-og-images', 'public');
        }

        // Handle Twitter image upload
        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $request->file('twitter_image')->store('seo/page-twitter-images', 'public');
        }

        // Handle JSON fields
        if ($request->has('breadcrumbs')) {
            $data['breadcrumbs'] = $request->input('breadcrumbs');
        }

        if ($request->has('schema_data')) {
            $data['schema_data'] = $request->input('schema_data');
        }

        PageSeoSetting::create($data);

        return redirect()->route('admin.seo.page-settings')
            ->with('success', 'Page SEO settings created successfully.');
    }

    public function editPageSetting(PageSeoSetting $pageSeoSetting)
    {
        return view('admin.seo.page-addedit', compact('pageSeoSetting'));
    }

    public function updatePageSetting(Request $request, PageSeoSetting $pageSeoSetting)
    {
        $request->validate([
            'page_route' => 'required|string|max:255|unique:page_seo_settings,page_route,' . $pageSeoSetting->id,
            'page_title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:1000',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'og_type' => 'nullable|string|max:50',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'twitter_card_type' => 'nullable|string|max:50',
            'canonical_url' => 'nullable|url|max:500',
            'robots' => 'nullable|string|max:100',
            'custom_head_code' => 'nullable|string',
            'custom_body_code' => 'nullable|string',
            'priority' => 'nullable|numeric|between:0.0,1.0',
            'change_frequency' => 'nullable|in:always,hourly,daily,weekly,monthly,yearly,never',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            if ($pageSeoSetting->og_image && !filter_var($pageSeoSetting->og_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($pageSeoSetting->og_image);
            }
            $data['og_image'] = $request->file('og_image')->store('seo/page-og-images', 'public');
        }

        // Handle Twitter image upload
        if ($request->hasFile('twitter_image')) {
            if ($pageSeoSetting->twitter_image && !filter_var($pageSeoSetting->twitter_image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($pageSeoSetting->twitter_image);
            }
            $data['twitter_image'] = $request->file('twitter_image')->store('seo/page-twitter-images', 'public');
        }

        // Handle JSON fields
        if ($request->has('breadcrumbs')) {
            $data['breadcrumbs'] = $request->input('breadcrumbs');
        }

        if ($request->has('schema_data')) {
            $data['schema_data'] = $request->input('schema_data');
        }

        $pageSeoSetting->update($data);

        return redirect()->route('admin.seo.page-settings')
            ->with('success', 'Page SEO settings updated successfully.');
    }

    public function destroyPageSetting(PageSeoSetting $pageSeoSetting)
    {
        // Delete images if they exist
        if ($pageSeoSetting->og_image && !filter_var($pageSeoSetting->og_image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($pageSeoSetting->og_image);
        }

        if ($pageSeoSetting->twitter_image && !filter_var($pageSeoSetting->twitter_image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($pageSeoSetting->twitter_image);
        }

        $pageSeoSetting->delete();

        return redirect()->route('admin.seo.page-settings')
            ->with('success', 'Page SEO settings deleted successfully.');
    }

    public function updatePageStatus(Request $request, PageSeoSetting $pageSeoSetting)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $pageSeoSetting->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $pageSeoSetting->status
        ]);
    }

    // ==================== SEO TOOLS ====================
    
    public function seoTools()
    {
        $globalSettings = SeoSetting::getSettings();
        $pageSettings = PageSeoSetting::getAllActive();
        
        $stats = [
            'total_pages' => $pageSettings->count(),
            'pages_with_meta' => $pageSettings->whereNotNull('meta_description')->count(),
            'pages_with_og' => $pageSettings->whereNotNull('og_title')->count(),
            'pages_with_twitter' => $pageSettings->whereNotNull('twitter_title')->count(),
        ];

        return view('admin.seo.tools', compact('globalSettings', 'pageSettings', 'stats'));
    }

    public function generateSitemap()
    {
        $globalSettings = SeoSetting::getSettings();
        
        if (!$globalSettings->sitemap_enabled) {
            return redirect()->route('admin.seo.tools')
                ->with('error', 'Sitemap generation is disabled in global settings.');
        }

        $pages = PageSeoSetting::getAllActive();
        $sitemapContent = $this->buildSitemapXml($pages);
        
        // Save sitemap to public directory
        file_put_contents(public_path('sitemap.xml'), $sitemapContent);

        return redirect()->route('admin.seo.tools')
            ->with('success', 'Sitemap generated successfully.');
    }

    public function generateRobotsTxt()
    {
        $globalSettings = SeoSetting::getSettings();
        $robotsContent = $globalSettings->generateRobotsTxt();
        
        // Save robots.txt to public directory
        file_put_contents(public_path('robots.txt'), $robotsContent);

        return redirect()->route('admin.seo.tools')
            ->with('success', 'Robots.txt file generated successfully.');
    }

    // ==================== HELPER METHODS ====================
    
    private function buildSitemapXml($pages)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($pages as $page) {
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . htmlspecialchars($page->getCanonicalUrl()) . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $page->updated_at->toISOString() . '</lastmod>' . PHP_EOL;
            $xml .= '    <changefreq>' . $page->getChangeFrequency() . '</changefreq>' . PHP_EOL;
            $xml .= '    <priority>' . $page->getSitemapPriority() . '</priority>' . PHP_EOL;
            $xml .= '  </url>' . PHP_EOL;
        }

        $xml .= '</urlset>';
        
        return $xml;
    }

    // ==================== ANALYTICS & REPORTS ====================
    
    public function seoAnalytics()
    {
        $globalSettings = SeoSetting::getSettings();
        $pageSettings = PageSeoSetting::getAllActive();
        
        $analytics = [
            'seo_score' => $this->calculateSeoScore($globalSettings, $pageSettings),
            'pages_analysis' => $this->analyzePages($pageSettings),
            'missing_elements' => $this->findMissingElements($pageSettings),
            'recommendations' => $this->generateRecommendations($globalSettings, $pageSettings),
        ];

        return view('admin.seo.analytics', compact('globalSettings', 'pageSettings', 'analytics'));
    }

    private function calculateSeoScore($globalSettings, $pageSettings): int
    {
        $score = 0;
        $maxScore = 100;

        // Global settings score (40%)
        if ($globalSettings->site_description) $score += 10;
        if ($globalSettings->site_keywords) $score += 5;
        if ($globalSettings->og_image) $score += 5;
        if ($globalSettings->google_analytics_id) $score += 5;
        if ($globalSettings->google_site_verification) $score += 5;
        if ($globalSettings->sitemap_enabled) $score += 5;
        if ($globalSettings->robots_txt) $score += 5;

        // Page settings score (60%)
        $totalPages = $pageSettings->count();
        if ($totalPages > 0) {
            $pagesWithMeta = $pageSettings->whereNotNull('meta_description')->count();
            $pagesWithOg = $pageSettings->whereNotNull('og_title')->count();
            $pagesWithTwitter = $pageSettings->whereNotNull('twitter_title')->count();
            
            $score += ($pagesWithMeta / $totalPages) * 20;
            $score += ($pagesWithOg / $totalPages) * 20;
            $score += ($pagesWithTwitter / $totalPages) * 20;
        }

        return min(100, round($score));
    }

    private function analyzePages($pageSettings): array
    {
        $analysis = [];
        
        foreach ($pageSettings as $page) {
            $pageScore = 0;
            $issues = [];
            
            // Check meta elements
            if (!$page->meta_title) {
                $issues[] = 'Missing meta title';
            } else {
                $pageScore += 20;
                if (strlen($page->meta_title) > 60) {
                    $issues[] = 'Meta title too long (>60 chars)';
                }
            }
            
            if (!$page->meta_description) {
                $issues[] = 'Missing meta description';
            } else {
                $pageScore += 20;
                if (strlen($page->meta_description) > 160) {
                    $issues[] = 'Meta description too long (>160 chars)';
                }
            }
            
            // Check Open Graph
            if ($page->og_title && $page->og_description) {
                $pageScore += 30;
            } else {
                $issues[] = 'Incomplete Open Graph data';
            }
            
            // Check Twitter Cards
            if ($page->twitter_title && $page->twitter_description) {
                $pageScore += 30;
            } else {
                $issues[] = 'Incomplete Twitter Card data';
            }
            
            $analysis[] = [
                'page' => $page,
                'score' => $pageScore,
                'issues' => $issues,
                'status' => $pageScore >= 80 ? 'good' : ($pageScore >= 60 ? 'warning' : 'error')
            ];
        }
        
        return $analysis;
    }

    private function findMissingElements($pageSettings): array
    {
        $missing = [
            'meta_title' => [],
            'meta_description' => [],
            'og_title' => [],
            'og_description' => [],
            'twitter_title' => [],
            'twitter_description' => [],
        ];

        foreach ($pageSettings as $page) {
            if (!$page->meta_title) $missing['meta_title'][] = $page->page_route;
            if (!$page->meta_description) $missing['meta_description'][] = $page->page_route;
            if (!$page->og_title) $missing['og_title'][] = $page->page_route;
            if (!$page->og_description) $missing['og_description'][] = $page->page_route;
            if (!$page->twitter_title) $missing['twitter_title'][] = $page->page_route;
            if (!$page->twitter_description) $missing['twitter_description'][] = $page->page_route;
        }

        return array_filter($missing);
    }

    private function generateRecommendations($globalSettings, $pageSettings): array
    {
        $recommendations = [];

        // Global recommendations
        if (!$globalSettings->google_analytics_id) {
            $recommendations[] = [
                'type' => 'global',
                'priority' => 'high',
                'title' => 'Add Google Analytics',
                'description' => 'Install Google Analytics to track website performance'
            ];
        }

        if (!$globalSettings->og_image) {
            $recommendations[] = [
                'type' => 'global',
                'priority' => 'medium',
                'title' => 'Add Default OG Image',
                'description' => 'Set a default Open Graph image for social media sharing'
            ];
        }

        // Page recommendations
        $pagesWithoutMeta = $pageSettings->whereNull('meta_description')->count();
        if ($pagesWithoutMeta > 0) {
            $recommendations[] = [
                'type' => 'pages',
                'priority' => 'high',
                'title' => 'Add Meta Descriptions',
                'description' => "$pagesWithoutMeta pages are missing meta descriptions"
            ];
        }

        return $recommendations;
    }
}