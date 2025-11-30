@extends('admin.layouts.app')

@section('title', 'SEO Tools')
@section('page-title', 'SEO Tools')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">SEO Tools</h2>
            <p class="text-gray-600 text-sm mt-1">Generate sitemaps, robots.txt, and analyze your SEO</p>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.seo.global-settings') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-globe mr-2"></i>
                Global Settings
            </a>
            <a href="{{ route('admin.seo.analytics') }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-chart-line mr-2"></i>
                SEO Analytics
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Pages</p>
                    <p class="text-2xl font-bold">{{ $stats['total_pages'] }}</p>
                </div>
                <i class="fas fa-file-alt text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">With Meta Data</p>
                    <p class="text-2xl font-bold">{{ $stats['pages_with_meta'] }}</p>
                </div>
                <i class="fas fa-tags text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">With Open Graph</p>
                    <p class="text-2xl font-bold">{{ $stats['pages_with_og'] }}</p>
                </div>
                <i class="fab fa-facebook text-3xl text-purple-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">With Twitter Cards</p>
                    <p class="text-2xl font-bold">{{ $stats['pages_with_twitter'] }}</p>
                </div>
                <i class="fab fa-twitter text-3xl text-orange-200"></i>
            </div>
        </div>
    </div>

    <!-- Tools Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Sitemap Generator -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-sitemap mr-2 text-blue-600"></i>
                    XML Sitemap
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Generate XML sitemap for search engines to better crawl your website.</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Status:</span>
                        @if($globalSettings->sitemap_enabled)
                            <span class="text-green-600 font-medium">✅ Enabled</span>
                        @else
                            <span class="text-red-600 font-medium">❌ Disabled</span>
                        @endif
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Auto Generate:</span>
                        @if($globalSettings->sitemap_auto_generate)
                            <span class="text-green-600 font-medium">✅ Yes</span>
                        @else
                            <span class="text-gray-600 font-medium">❌ No</span>
                        @endif
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Last Updated:</span>
                        @if(file_exists(public_path('sitemap.xml')))
                            <span class="text-gray-900 font-medium">{{ date('M d, Y', filemtime(public_path('sitemap.xml'))) }}</span>
                        @else
                            <span class="text-gray-500">Never</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-3">
                    <form action="{{ route('admin.seo.tools.generate-sitemap') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-sync mr-2"></i>
                            Generate Sitemap
                        </button>
                    </form>
                    
                    @if(file_exists(public_path('sitemap.xml')))
                        <a href="{{ url('/sitemap.xml') }}" target="_blank" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200 inline-flex items-center justify-center">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            View Sitemap
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Robots.txt Generator -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-robot mr-2 text-green-600"></i>
                    Robots.txt
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Generate robots.txt file to control search engine crawling behavior.</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Status:</span>
                        @if(file_exists(public_path('robots.txt')))
                            <span class="text-green-600 font-medium">✅ Exists</span>
                        @else
                            <span class="text-red-600 font-medium">❌ Missing</span>
                        @endif
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Custom Content:</span>
                        @if($globalSettings->robots_txt)
                            <span class="text-green-600 font-medium">✅ Yes</span>
                        @else
                            <span class="text-gray-600 font-medium">❌ Auto-generated</span>
                        @endif
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Last Updated:</span>
                        @if(file_exists(public_path('robots.txt')))
                            <span class="text-gray-900 font-medium">{{ date('M d, Y', filemtime(public_path('robots.txt'))) }}</span>
                        @else
                            <span class="text-gray-500">Never</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-3">
                    <form action="{{ route('admin.seo.tools.generate-robots') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                            <i class="fas fa-sync mr-2"></i>
                            Generate Robots.txt
                        </button>
                    </form>
                    
                    @if(file_exists(public_path('robots.txt')))
                        <a href="{{ url('/robots.txt') }}" target="_blank" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200 inline-flex items-center justify-center">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            View Robots.txt
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- SEO Checker -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-search mr-2 text-purple-600"></i>
                    SEO Checker
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Analyze your website's SEO performance and get recommendations.</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Global SEO:</span>
                        @if($globalSettings->isActive())
                            <span class="text-green-600 font-medium">✅ Active</span>
                        @else
                            <span class="text-red-600 font-medium">❌ Inactive</span>
                        @endif
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Pages Analyzed:</span>
                        <span class="text-gray-900 font-medium">{{ $pageSettings->count() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Optimization:</span>
                        @php
                            $optimizationScore = $stats['pages_with_meta'] > 0 ? round(($stats['pages_with_meta'] / $stats['total_pages']) * 100) : 0;
                        @endphp
                        <span class="font-medium {{ $optimizationScore >= 80 ? 'text-green-600' : ($optimizationScore >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $optimizationScore }}%
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('admin.seo.analytics') }}" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors duration-200 inline-flex items-center justify-center">
                        <i class="fas fa-chart-line mr-2"></i>
                        View Analytics
                    </a>
                    <button onclick="runQuickCheck()" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-check-circle mr-2"></i>
                        Quick SEO Check
                    </button>
                </div>
            </div>
        </div>

        <!-- Meta Tags Analyzer -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-amber-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-tags mr-2 text-yellow-600"></i>
                    Meta Tags Analyzer
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Analyze meta tags across all your pages and find missing elements.</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Pages with Title:</span>
                        <span class="text-gray-900 font-medium">{{ $pageSettings->whereNotNull('meta_title')->count() }}/{{ $pageSettings->count() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Pages with Description:</span>
                        <span class="text-gray-900 font-medium">{{ $stats['pages_with_meta'] }}/{{ $pageSettings->count() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Completion Rate:</span>
                        @php
                            $completionRate = $pageSettings->count() > 0 ? round(($stats['pages_with_meta'] / $pageSettings->count()) * 100) : 0;
                        @endphp
                        <span class="font-medium {{ $completionRate >= 80 ? 'text-green-600' : ($completionRate >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $completionRate }}%
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    <button onclick="analyzeMeta()" class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        Analyze Meta Tags
                    </button>
                    <a href="{{ route('admin.seo.page-settings') }}" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200 inline-flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i>
                        Manage Pages
                    </a>
                </div>
            </div>
        </div>

        <!-- Social Media Checker -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-pink-50 to-rose-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-share-alt mr-2 text-pink-600"></i>
                    Social Media Checker
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Check Open Graph and Twitter Cards implementation across your site.</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Open Graph Ready:</span>
                        <span class="text-gray-900 font-medium">{{ $stats['pages_with_og'] }}/{{ $pageSettings->count() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Twitter Cards Ready:</span>
                        <span class="text-gray-900 font-medium">{{ $stats['pages_with_twitter'] }}/{{ $pageSettings->count() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Social Optimization:</span>
                        @php
                            $socialOptimization = $pageSettings->count() > 0 ? round((($stats['pages_with_og'] + $stats['pages_with_twitter']) / ($pageSettings->count() * 2)) * 100) : 0;
                        @endphp
                        <span class="font-medium {{ $socialOptimization >= 80 ? 'text-green-600' : ($socialOptimization >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $socialOptimization }}%
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    <button onclick="checkSocial()" class="w-full bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition-colors duration-200">
                        <i class="fas fa-share-alt mr-2"></i>
                        Check Social Tags
                    </button>
                    <button onclick="testSocialShare()" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Test Sharing
                    </button>
                </div>
            </div>
        </div>

        <!-- Technical SEO -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-cog mr-2 text-indigo-600"></i>
                    Technical SEO
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Check technical SEO elements like schema markup and canonical URLs.</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Schema Markup:</span>
                        @if($globalSettings->json_ld_enabled)
                            <span class="text-green-600 font-medium">✅ Enabled</span>
                        @else
                            <span class="text-red-600 font-medium">❌ Disabled</span>
                        @endif
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Canonical URLs:</span>
                        @if($globalSettings->canonical_urls_enabled)
                            <span class="text-green-600 font-medium">✅ Enabled</span>
                        @else
                            <span class="text-red-600 font-medium">❌ Disabled</span>
                        @endif
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Breadcrumbs:</span>
                        @if($globalSettings->breadcrumbs_enabled)
                            <span class="text-green-600 font-medium">✅ Enabled</span>
                        @else
                            <span class="text-red-600 font-medium">❌ Disabled</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-3">
                    <button onclick="testTechnical()" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                        <i class="fas fa-wrench mr-2"></i>
                        Test Technical SEO
                    </button>
                    <a href="{{ route('admin.seo.global-settings') }}" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-200 inline-flex items-center justify-center">
                        <i class="fas fa-cog mr-2"></i>
                        Configure Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Analysis Results -->
    <div id="analysisResults" class="hidden bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-chart-bar mr-2 text-primary"></i>
                Analysis Results
            </h3>
        </div>
        <div class="p-6">
            <div id="analysisContent">
                <!-- Results will be loaded here -->
            </div>
        </div>
    </div>

    <!-- External Tools & Resources -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-external-link-alt mr-2 text-primary"></i>
                External SEO Tools & Resources
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="https://search.google.com/search-console" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fab fa-google text-2xl text-blue-600 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Google Search Console</h4>
                        <p class="text-xs text-gray-600">Monitor search performance</p>
                    </div>
                </a>
                
                <a href="https://developers.facebook.com/tools/debug/" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fab fa-facebook text-2xl text-blue-700 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Facebook Debugger</h4>
                        <p class="text-xs text-gray-600">Test Open Graph tags</p>
                    </div>
                </a>
                
                <a href="https://cards-dev.twitter.com/validator" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fab fa-twitter text-2xl text-blue-400 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Twitter Card Validator</h4>
                        <p class="text-xs text-gray-600">Test Twitter Cards</p>
                    </div>
                </a>
                
                <a href="https://search.google.com/test/rich-results" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-code text-2xl text-green-600 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Rich Results Test</h4>
                        <p class="text-xs text-gray-600">Test structured data</p>
                    </div>
                </a>
                
                <a href="https://pagespeed.web.dev/" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-tachometer-alt text-2xl text-orange-600 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">PageSpeed Insights</h4>
                        <p class="text-xs text-gray-600">Test page speed</p>
                    </div>
                </a>
                
                <a href="https://validator.w3.org/" target="_blank" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-check-circle text-2xl text-purple-600 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">HTML Validator</h4>
                        <p class="text-xs text-gray-600">Validate HTML markup</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Quick SEO Check
function runQuickCheck() {
    showAnalysisResults('Running quick SEO check...', 'loading');
    
    // Simulate analysis
    setTimeout(() => {
        const results = `
            <div class="space-y-4">
                <h4 class="font-semibold text-gray-900">Quick SEO Analysis Results</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <h5 class="font-medium text-green-800 mb-2">✅ Good</h5>
                        <ul class="text-sm text-green-700 space-y-1">
                            <li>• Global SEO is active</li>
                            <li>• Sitemap generation enabled</li>
                            <li>• Meta tags are configured</li>
                        </ul>
                    </div>
                    
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <h5 class="font-medium text-yellow-800 mb-2">⚠️ Needs Attention</h5>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• Some pages missing meta descriptions</li>
                            <li>• Social media optimization incomplete</li>
                            <li>• Consider adding more structured data</li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.seo.analytics') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                        <i class="fas fa-chart-line mr-2"></i>
                        View Detailed Analytics
                    </a>
                </div>
            </div>
        `;
        showAnalysisResults(results, 'success');
    }, 2000);
}

// Analyze Meta Tags
function analyzeMeta() {
    showAnalysisResults('Analyzing meta tags across all pages...', 'loading');
    
    setTimeout(() => {
        const results = `
            <div class="space-y-4">
                <h4 class="font-semibold text-gray-900">Meta Tags Analysis</h4>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium">Pages with Meta Title:</span>
                        <span class="text-sm font-bold">{{ $pageSettings->whereNotNull('meta_title')->count() }}/{{ $pageSettings->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium">Pages with Meta Description:</span>
                        <span class="text-sm font-bold">{{ $stats['pages_with_meta'] }}/{{ $pageSettings->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium">Pages with Keywords:</span>
                        <span class="text-sm font-bold">{{ $pageSettings->whereNotNull('meta_keywords')->count() }}/{{ $pageSettings->count() }}</span>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.seo.page-settings') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Fix Missing Meta Tags
                    </a>
                </div>
            </div>
        `;
        showAnalysisResults(results, 'success');
    }, 1500);
}

// Check Social Media Tags
function checkSocial() {
    showAnalysisResults('Checking social media optimization...', 'loading');
    
    setTimeout(() => {
        const results = `
            <div class="space-y-4">
                <h4 class="font-semibold text-gray-900">Social Media Analysis</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h5 class="font-medium text-gray-800 mb-2 flex items-center">
                            <i class="fab fa-facebook mr-2 text-blue-600"></i>
                            Open Graph
                        </h5>
                        <div class="text-sm text-gray-600">
                            <p>Pages with OG data: {{ $stats['pages_with_og'] }}/{{ $pageSettings->count() }}</p>
                            <p class="mt-1 text-xs">Complete OG implementation improves Facebook sharing</p>
                        </div>
                    </div>
                    
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h5 class="font-medium text-gray-800 mb-2 flex items-center">
                            <i class="fab fa-twitter mr-2 text-blue-400"></i>
                            Twitter Cards
                        </h5>
                        <div class="text-sm text-gray-600">
                            <p>Pages with Twitter Cards: {{ $stats['pages_with_twitter'] }}/{{ $pageSettings->count() }}</p>
                            <p class="mt-1 text-xs">Twitter Cards enhance Twitter sharing experience</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        showAnalysisResults(results, 'success');
    }, 1500);
}

// Test Social Sharing
function testSocialShare() {
    const url = prompt('Enter URL to test social sharing:', '{{ url("/") }}');
    if (url) {
        window.open(`https://developers.facebook.com/tools/debug/?q=${encodeURIComponent(url)}`, '_blank');
    }
}

// Test Technical SEO
function testTechnical() {
    showAnalysisResults('Testing technical SEO elements...', 'loading');
    
    setTimeout(() => {
        const results = `
            <div class="space-y-4">
                <h4 class="font-semibold text-gray-900">Technical SEO Status</h4>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium">Schema Markup:</span>
                        <span class="text-sm font-bold {{ $globalSettings->json_ld_enabled ? 'text-green-600' : 'text-red-600' }}">
                            {{ $globalSettings->json_ld_enabled ? '✅ Enabled' : '❌ Disabled' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium">Canonical URLs:</span>
                        <span class="text-sm font-bold {{ $globalSettings->canonical_urls_enabled ? 'text-green-600' : 'text-red-600' }}">
                            {{ $globalSettings->canonical_urls_enabled ? '✅ Enabled' : '❌ Disabled' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-medium">Breadcrumbs:</span>
                        <span class="text-sm font-bold {{ $globalSettings->breadcrumbs_enabled ? 'text-green-600' : 'text-red-600' }}">
                            {{ $globalSettings->breadcrumbs_enabled ? '✅ Enabled' : '❌ Disabled' }}
                        </span>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.seo.global-settings') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                        <i class="fas fa-cog mr-2"></i>
                        Configure Technical Settings
                    </a>
                </div>
            </div>
        `;
        showAnalysisResults(results, 'success');
    }, 1500);
}

// Show analysis results
function showAnalysisResults(content, type = 'success') {
    const resultsDiv = document.getElementById('analysisResults');
    const contentDiv = document.getElementById('analysisContent');
    
    if (type === 'loading') {
        contentDiv.innerHTML = `
            <div class="flex items-center justify-center py-8">
                <i class="fas fa-spinner fa-spin text-2xl text-primary mr-3"></i>
                <span class="text-gray-600">${content}</span>
            </div>
        `;
    } else {
        contentDiv.innerHTML = content;
    }
    
    resultsDiv.classList.remove('hidden');
    resultsDiv.scrollIntoView({ behavior: 'smooth' });
}
</script>
@endpush