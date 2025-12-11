@extends('admin.layouts.app')

@section('title', 'SEO Analytics')
@section('page-title', 'SEO Analytics')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">SEO Analytics & Reports</h2>
            <p class="text-gray-600 text-sm mt-1">Comprehensive SEO analysis and optimization recommendations</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.seo.tools') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-tools mr-2"></i>
                SEO Tools
            </a>
            <button id="exportReportBtn" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-file-export mr-2"></i>
                Export Report
            </button>
        </div>
    </div>

    <!-- Overall SEO Score -->
    <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-2">Overall SEO Score</h3>
                <p class="text-white/80">Your website's current SEO performance</p>
            </div>
            <div class="text-right">
                <div class="text-5xl font-black mb-2">{{ $analytics['seo_score'] }}%</div>
                @php
                    $scoreLabel = $analytics['seo_score'] >= 80 ? 'Excellent' : ($analytics['seo_score'] >= 60 ? 'Good' : 'Needs Improvement');
                    $scoreIcon = $analytics['seo_score'] >= 80 ? 'fa-star' : ($analytics['seo_score'] >= 60 ? 'fa-thumbs-up' : 'fa-exclamation-triangle');
                @endphp
                <div class="flex items-center justify-end">
                    <i class="fas {{ $scoreIcon }} mr-2"></i>
                    <span class="text-lg font-medium">{{ $scoreLabel }}</span>
                </div>
            </div>
        </div>
        
        <!-- Score Breakdown -->
        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold">{{ $globalSettings->isActive() ? '100' : '0' }}%</div>
                <div class="text-sm text-white/80">Global Settings</div>
            </div>
            <div class="text-center">
@php $metaScore = $pageSettings->count() > 0 ? round((collect($analytics['pages_analysis'])->where('score', '>=', 70)->count() / $pageSettings->count()) * 100) : 0; @endphp                <div class="text-2xl font-bold">{{ $metaScore }}%</div>
                <div class="text-sm text-white/80">Meta Optimization</div>
            </div>
            <div class="text-center">
@php $socialScore = $pageSettings->count() > 0 ? round(((collect($analytics['pages_analysis'])->sum(function($p) { return $p['score']; }) / $pageSettings->count()) / 100) * 100) : 0; @endphp                <div class="text-2xl font-bold">{{ min(100, $socialScore) }}%</div>
                <div class="text-sm text-white/80">Social Media</div>
            </div>
            <div class="text-center">
                @php $technicalScore = ($globalSettings->json_ld_enabled ? 25 : 0) + ($globalSettings->canonical_urls_enabled ? 25 : 0) + ($globalSettings->sitemap_enabled ? 25 : 0) + ($globalSettings->breadcrumbs_enabled ? 25 : 0); @endphp
                <div class="text-2xl font-bold">{{ $technicalScore }}%</div>
                <div class="text-sm text-white/80">Technical SEO</div>
            </div>
        </div>
    </div>

    <!-- Key Recommendations -->
    @if(count($analytics['recommendations']) > 0)
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-amber-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-lightbulb mr-2 text-yellow-600"></i>
                Priority Recommendations
            </h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach(array_slice($analytics['recommendations'], 0, 5) as $recommendation)
                    <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        @php
                            $priorityColors = [
                                'high' => 'bg-red-100 text-red-600',
                                'medium' => 'bg-yellow-100 text-yellow-600',
                                'low' => 'bg-green-100 text-green-600'
                            ];
                        @endphp
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityColors[$recommendation['priority']] }}">
                                {{ ucfirst($recommendation['priority']) }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">{{ $recommendation['title'] }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $recommendation['description'] }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Pages Analysis -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-file-alt mr-2 text-blue-600"></i>
                Page-by-Page Analysis
            </h3>
        </div>
        <div class="p-6">
            @if(count($analytics['pages_analysis']) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Page</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEO Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issues</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($analytics['pages_analysis'] as $analysis)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $analysis['page']->page_title }}</div>
                                            <div class="text-sm text-gray-500">{{ $analysis['page']->page_route }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $scoreColor = $analysis['score'] >= 80 ? 'text-green-600 bg-green-100' : ($analysis['score'] >= 60 ? 'text-yellow-600 bg-yellow-100' : 'text-red-600 bg-red-100');
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $scoreColor }}">
                                            {{ $analysis['score'] }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            @if(count($analysis['issues']) > 0)
                                                <ul class="space-y-1">
                                                    @foreach(array_slice($analysis['issues'], 0, 3) as $issue)
                                                        <li class="text-xs text-red-600">• {{ $issue }}</li>
                                                    @endforeach
                                                    @if(count($analysis['issues']) > 3)
                                                        <li class="text-xs text-gray-500">+ {{ count($analysis['issues']) - 3 }} more</li>
                                                    @endif
                                                </ul>
                                            @else
                                                <span class="text-xs text-green-600">✅ No issues found</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'good' => 'bg-green-100 text-green-800',
                                                'warning' => 'bg-yellow-100 text-yellow-800',
                                                'error' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$analysis['status']] }}">
                                            {{ ucfirst($analysis['status']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.seo.page-settings.edit', $analysis['page']) }}" 
                                           class="text-primary hover:text-secondary mr-3"
                                           title="Edit SEO Settings">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ $analysis['page']->getCanonicalUrl() }}" 
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800"
                                           title="View Page">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-chart-bar text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No pages to analyze</h3>
                    <p class="text-gray-600">Add some pages to get detailed SEO analysis.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Missing Elements -->
    @if(count($analytics['missing_elements']) > 0)
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
                Missing SEO Elements
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($analytics['missing_elements'] as $element => $pages)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                            @php
                                $elementIcons = [
                                    'meta_title' => 'fas fa-heading',
                                    'meta_description' => 'fas fa-align-left',
                                    'og_title' => 'fab fa-facebook',
                                    'og_description' => 'fab fa-facebook',
                                    'twitter_title' => 'fab fa-twitter',
                                    'twitter_description' => 'fab fa-twitter'
                                ];
                                $elementLabels = [
                                    'meta_title' => 'Meta Title',
                                    'meta_description' => 'Meta Description',
                                    'og_title' => 'Open Graph Title',
                                    'og_description' => 'Open Graph Description',
                                    'twitter_title' => 'Twitter Title',
                                    'twitter_description' => 'Twitter Description'
                                ];
                            @endphp
                            <i class="{{ $elementIcons[$element] ?? 'fas fa-tag' }} mr-2 text-red-600"></i>
                            {{ $elementLabels[$element] ?? ucfirst(str_replace('_', ' ', $element)) }}
                        </h4>
                        <p class="text-sm text-gray-600 mb-3">{{ count($pages) }} pages missing this element</p>
                        <div class="space-y-1">
                            @foreach(array_slice($pages, 0, 5) as $page)
                                <div class="text-xs text-gray-500">• {{ $page }}</div>
                            @endforeach
                            @if(count($pages) > 5)
                                <div class="text-xs text-gray-400">+ {{ count($pages) - 5 }} more pages</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Technical SEO Status -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Global Settings Status -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-globe mr-2 text-green-600"></i>
                    Global SEO Features
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $features = [
                            'sitemap_enabled' => 'XML Sitemap Generation',
                            'canonical_urls_enabled' => 'Canonical URLs',
                            'open_graph_enabled' => 'Open Graph Tags',
                            'twitter_cards_enabled' => 'Twitter Cards',
                            'json_ld_enabled' => 'JSON-LD Schema',
                            'breadcrumbs_enabled' => 'Breadcrumbs'
                        ];
                    @endphp
                    @foreach($features as $feature => $label)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                            @if($globalSettings->$feature)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Enabled
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>
                                    Disabled
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.seo.global-settings') }}" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 inline-flex items-center justify-center">
                        <i class="fas fa-cog mr-2"></i>
                        Configure Global Settings
                    </a>
                </div>
            </div>
        </div>

        <!-- Analytics & Tracking -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-indigo-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-purple-600"></i>
                    Tracking & Analytics
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $trackingFeatures = [
                            'google_analytics_id' => 'Google Analytics',
                            'google_tag_manager_id' => 'Google Tag Manager',
                            'facebook_pixel_id' => 'Facebook Pixel',
                            'google_site_verification' => 'Google Search Console',
                        ];
                    @endphp
                    @foreach($trackingFeatures as $feature => $label)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                            @if($globalSettings->$feature)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Connected
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Not Set
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.seo.global-settings') }}" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors duration-200 inline-flex items-center justify-center">
                        <i class="fas fa-link mr-2"></i>
                        Configure Tracking
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-bolt mr-2 text-primary"></i>
                Quick Actions [ SOON IN FUTURE ]
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <button id="generateSitemapBtn" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-sitemap text-2xl text-blue-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-900">Generate Sitemap</span>
                </button>
                
                <button id="testPageSpeedBtn" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-tachometer-alt text-2xl text-green-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-900">Test Page Speed</span>
                </button>
                
                <button id="validateStructuredDataBtn" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-code text-2xl text-purple-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-900">Test Schema</span>
                </button>
                
                <button id="checkMobileBtn" class="flex flex-col items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-mobile-alt text-2xl text-orange-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-900">Mobile Test</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden data for JavaScript -->
<script id="seo-data" type="application/json">
{!! json_encode([
    'seo_score' => $analytics['seo_score'] ?? 0,
    'total_pages' => $pageSettings->count() ?? 0,
    'recommendations' => $analytics['recommendations'] ?? [],
    'sitemap_url' => route('admin.seo.tools.generate-sitemap'),
    'site_url' => url('/')
]) !!}
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get data from PHP
    const seoDataElement = document.getElementById('seo-data');
    let seoData = {};
    
    try {
        seoData = JSON.parse(seoDataElement.textContent);
    } catch (error) {
        console.error('Error parsing SEO data:', error);
        seoData = {
            seo_score: 0,
            total_pages: 0,
            recommendations: [],
            sitemap_url: '',
            site_url: ''
        };
    }

    // Export Report Function
    function generateReport() {
        try {
            const reportData = {
                timestamp: new Date().toLocaleString(),
                seo_score: seoData.seo_score || 0,
                total_pages: seoData.total_pages || 0,
                recommendations: seoData.recommendations || []
            };
            
            const reportHtml = `
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>SEO Report - ${reportData.timestamp}</title>
                    <style>
                        body { 
                            font-family: Arial, sans-serif; 
                            padding: 20px; 
                            line-height: 1.6;
                            color: #333;
                        }
                        .header {
                            background: #f8f9fa;
                            padding: 20px;
                            border-radius: 8px;
                            margin-bottom: 20px;
                        }
                        .score {
                            font-size: 24px;
                            font-weight: bold;
                            color: #28a745;
                        }
                        .recommendation {
                            background: #f1f3f4;
                            padding: 15px;
                            margin: 10px 0;
                            border-radius: 5px;
                            border-left: 4px solid #007bff;
                        }
                        .priority-high { border-left-color: #dc3545; }
                        .priority-medium { border-left-color: #ffc107; }
                        .priority-low { border-left-color: #28a745; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>SEO Analysis Report</h1>
                        <p><strong>Generated on:</strong> ${reportData.timestamp}</p>
                        <p><strong>Website:</strong> {{ config('app.name', 'Website') }}</p>
                    </div>
                    
                    <div class="score">
                        Overall SEO Score: ${reportData.seo_score}%
                    </div>
                    
                    <h2>Summary</h2>
                    <ul>
                        <li><strong>Total Pages Analyzed:</strong> ${reportData.total_pages}</li>
                        <li><strong>Recommendations:</strong> ${reportData.recommendations.length}</li>
                    </ul>
                    
                    <h2>Recommendations</h2>
                    ${reportData.recommendations.map(rec => `
                        <div class="recommendation priority-${rec.priority}">
                            <h3>${rec.title}</h3>
                            <p><strong>Priority:</strong> ${rec.priority.toUpperCase()}</p>
                            <p>${rec.description}</p>
                        </div>
                    `).join('')}
                    
                    ${reportData.recommendations.length === 0 ? '<p>No specific recommendations at this time. Great job!</p>' : ''}
                </body>
                </html>
            `;
            
            const blob = new Blob([reportHtml], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `seo-report-${new Date().toISOString().split('T')[0]}.html`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            
            showNotification('Report exported successfully!', 'success');
        } catch (error) {
            console.error('Error generating report:', error);
            showNotification('Failed to export report', 'error');
        }
    }

    // Quick Actions Functions
    function generateSitemap() {
        if (!seoData.sitemap_url) {
            showNotification('Sitemap URL not available', 'error');
            return;
        }
        
        fetch(seoData.sitemap_url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                showNotification('Sitemap generated successfully!', 'success');
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to generate sitemap', 'error');
        });
    }

    function testPageSpeed() {
        if (!seoData.site_url) {
            showNotification('Site URL not available', 'error');
            return;
        }
        const url = encodeURIComponent(seoData.site_url);
        window.open(`https://pagespeed.web.dev/report?url=${url}`, '_blank');
    }

    function validateStructuredData() {
        if (!seoData.site_url) {
            showNotification('Site URL not available', 'error');
            return;
        }
        const url = encodeURIComponent(seoData.site_url);
        window.open(`https://search.google.com/test/rich-results?url=${url}`, '_blank');
    }

    function checkMobile() {
        if (!seoData.site_url) {
            showNotification('Site URL not available', 'error');
            return;
        }
        const url = encodeURIComponent(seoData.site_url);
        window.open(`https://search.google.com/test/mobile-friendly?url=${url}`, '_blank');
    }

    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
        
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${bgColor} text-white`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${icon} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Attach event listeners
    const exportBtn = document.getElementById('exportReportBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', generateReport);
    }

    const generateSitemapBtn = document.getElementById('generateSitemapBtn');
    if (generateSitemapBtn) {
        generateSitemapBtn.addEventListener('click', generateSitemap);
    }

    const testPageSpeedBtn = document.getElementById('testPageSpeedBtn');
    if (testPageSpeedBtn) {
        testPageSpeedBtn.addEventListener('click', testPageSpeed);
    }

    const validateStructuredDataBtn = document.getElementById('validateStructuredDataBtn');
    if (validateStructuredDataBtn) {
        validateStructuredDataBtn.addEventListener('click', validateStructuredData);
    }

    const checkMobileBtn = document.getElementById('checkMobileBtn');
    if (checkMobileBtn) {
        checkMobileBtn.addEventListener('click', checkMobile);
    }
});
</script>
@endpush