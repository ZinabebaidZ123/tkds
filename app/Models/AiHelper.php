<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class AiHelper
{
    /**
     * Get comprehensive site content summary
     */
    public static function getSiteContentSummary(): array
    {
        return [
            'services_count' => Service::where('status', 'active')->count(),
            'products_count' => ShopProduct::where('status', 'active')->count(),
            'pricing_plans_count' => PricingPlan::where('status', 'active')->count(),
            'blog_posts_count' => BlogPost::where('status', 'published')->count(),
            'team_members_count' => TeamMember::where('status', 'active')->count(),
        ];
    }

    /**
     * Get all active services with details
     */
    public static function getServices($limit = null)
    {
        $query = Service::where('status', 'active')
            ->orderBy('order', 'asc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get all active products with details
     */
    public static function getProducts($limit = null)
    {
        $query = ShopProduct::where('status', 'active')
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get product by ID or slug
     */
    public static function getProduct($identifier)
    {
        if (is_numeric($identifier)) {
            return ShopProduct::where('status', 'active')->find($identifier);
        }

        return ShopProduct::where('status', 'active')
            ->where('slug', $identifier)
            ->first();
    }

    /**
     * Get service by ID or slug
     */
    public static function getService($identifier)
    {
        if (is_numeric($identifier)) {
            return Service::where('status', 'active')->find($identifier);
        }

        return Service::where('status', 'active')
            ->where('slug', $identifier)
            ->first();
    }

    /**
     * Get all active pricing plans
     */
    public static function getPricingPlans()
    {
        return PricingPlan::where('status', 'active')
            ->orderBy('price', 'asc')
            ->get();
    }

    /**
     * Get product categories
     */
    public static function getProductCategories()
    {
        return ShopCategory::where('status', 'active')
            ->withCount('products')
            ->get();
    }

    /**
     * Search for content (services, products, blog posts)
     */
    public static function searchContent($query)
    {
        $searchTerm = strtolower(trim($query));

        $results = [
            'services' => [],
            'products' => [],
            'blog_posts' => [],
        ];

        // Search services
        $results['services'] = Service::where('status', 'active')
            ->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$searchTerm}%"]);
            })
            ->limit(5)
            ->get();

        // Search products
        $results['products'] = ShopProduct::where('status', 'active')
            ->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$searchTerm}%"]);
            })
            ->limit(5)
            ->get();

        // Search blog posts
        $results['blog_posts'] = BlogPost::where('status', 'published')
            ->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(content) LIKE ?', ["%{$searchTerm}%"]);
            })
            ->limit(5)
            ->get();

        return $results;
    }

    /**
     * Get recent blog posts
     */
    public static function getRecentBlogPosts($limit = 5)
    {
        return BlogPost::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get team members
     */
    public static function getTeamMembers($limit = null)
    {
        $query = TeamMember::where('status', 'active')
            ->orderBy('order', 'asc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get contact information
     */
    public static function getContactInfo()
    {
        return ContactSetting::first();
    }

    /**
     * Get about information
     */
    public static function getAboutInfo()
    {
        return AboutSetting::first();
    }

    /**
     * Get footer information
     */
    public static function getFooterInfo()
    {
        return FooterSetting::first();
    }
}
