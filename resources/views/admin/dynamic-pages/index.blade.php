@extends('admin.layouts.app')

@section('title', 'Dynamic Pages Manager')
@section('page-title', 'Dynamic Pages Manager')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dynamic Pages</h1>
            <p class="text-gray-600 text-sm mt-1">Manage all sections of your dynamic landing pages</p>
        </div>
        <a href="{{ route('occasions') }}" target="_blank" 
           class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-external-link-alt mr-2"></i>
            <span>Preview Page</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Pages -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Pages</p>
                    <p class="text-2xl font-bold">{{ $pages->count() }}</p>
                </div>
                <i class="fas fa-layer-group text-3xl text-blue-200"></i>
            </div>
        </div>

        <!-- Active Pages -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active Pages</p>
                    <p class="text-2xl font-bold">{{ $pages->where('status', 'active')->count() }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-200"></i>
            </div>
        </div>

        <!-- Inactive Pages -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Inactive Pages</p>
                    <p class="text-2xl font-bold">{{ $pages->where('status', 'inactive')->count() }}</p>
                </div>
                <i class="fas fa-eye-slash text-3xl text-yellow-200"></i>
            </div>
        </div>

        <!-- Total Sections -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Sections</p>
                    <p class="text-2xl font-bold">
                        {{ $pages->sum(fn($page) => $page->services_count + $page->pricing_plans_count + $page->products_count) }}
                    </p>
                </div>
                <i class="fas fa-cogs text-3xl text-purple-200"></i>
            </div>
        </div>
    </div>

    @forelse($pages as $page)
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Page Header -->
        <div class="px-6 py-6 bg-gradient-to-r from-primary/5 to-secondary/5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-r from-primary to-secondary rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $page->page_title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Slug: <span class="font-mono bg-gray-100 px-2 py-1 rounded text-xs">{{ $page->page_slug }}</span></p>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $page->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($page->status) }}
                </span>
            </div>
        </div>

        <div class="p-8 divide-y divide-gray-100">
            <!-- Header Section -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-header text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Header</h4>
                            <p class="text-sm text-gray-600">{{ $page->header_logo_text ?? 'TKDS Media' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'header')" 
                                class="w-10 h-10 rounded-xl {{ $page->header_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                        <a href="{{ route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => 'header']) }}" 
                           class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center hover:bg-blue-600 shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full font-medium">
                        {{ ucfirst($page->header_status) }}
                    </span>
                </div>
            </div>

            <!-- Hero Section -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-star text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Hero</h4>
                            <p class="text-sm text-gray-600 truncate">{{ $page->hero_title_part1 ?? '' }} {{ $page->hero_title_part2 ?? '' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'hero')"
                                class="w-10 h-10 rounded-xl {{ $page->hero_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                        <a href="{{ route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => 'hero']) }}"
                           class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center hover:bg-blue-600 shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-purple-100 text-purple-800 rounded-full font-medium">
                        {{ ucfirst($page->hero_status) }}
                    </span>
                </div>
            </div>

            <!-- Why Choose Us Section (Index Only - No Edit) -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-check-circle text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Why Choose Us <span class="text-xs text-gray-400 ml-2">(Index Only)</span></h4>
                            <p class="text-sm text-gray-600">{{ $page->why_choose_title ?? 'Why Choose Us Section' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'why_choose')"
                                class="w-10 h-10 rounded-xl {{ $page->why_choose_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-cyan-100 text-cyan-800 rounded-full font-medium">
                        {{ ucfirst($page->why_choose_status) }}
                    </span>
                </div>
            </div>

            <!-- Services Section -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-cogs text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Services</h4>
                            <p class="text-sm text-gray-600">{{ $page->services_count }} Items</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'services')" 
                                class="w-10 h-10 rounded-xl {{ $page->services_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                        <a href="{{ route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => 'services']) }}" 
                           class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center hover:bg-blue-600 shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full font-medium">
                        {{ ucfirst($page->services_status) }}
                    </span>
                </div>
            </div>

            <!-- Packages Section -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-box text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Packages</h4>
                            <p class="text-sm text-gray-600">{{ $page->pricing_plans_count }} Items</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'packages')" 
                                class="w-10 h-10 rounded-xl {{ $page->packages_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                        <a href="{{ route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => 'packages']) }}" 
                           class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center hover:bg-blue-600 shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-orange-100 text-orange-800 rounded-full font-medium">
                        {{ ucfirst($page->packages_status) }}
                    </span>
                </div>
            </div>

            <!-- Products Section -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-shopping-bag text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Products</h4>
                            <p class="text-sm text-gray-600">{{ $page->products_count }} Items</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'products')"
                                class="w-10 h-10 rounded-xl {{ $page->products_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                        <a href="{{ route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => 'products']) }}"
                           class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center hover:bg-blue-600 shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-indigo-100 text-indigo-800 rounded-full font-medium">
                        {{ ucfirst($page->products_status) }}
                    </span>
                </div>
            </div>

            <!-- Video Section -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-play-circle text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Video</h4>
                            <p class="text-sm text-gray-600">{{ $page->video_title ?? 'Video Section' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'video')"
                                class="w-10 h-10 rounded-xl {{ $page->video_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                        <a href="{{ route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => 'video']) }}"
                           class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center hover:bg-blue-600 shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-red-100 text-red-800 rounded-full font-medium">
                        {{ ucfirst($page->video_status) }}
                    </span>
                </div>
            </div>

            <!-- Reviews Section (Index Only - No Edit) -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-star-half-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Reviews <span class="text-xs text-gray-400 ml-2">(Index Only)</span></h4>
                            <p class="text-sm text-gray-600">{{ $page->reviews_title ?? 'Reviews Section' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'reviews')"
                                class="w-10 h-10 rounded-xl {{ $page->reviews_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full font-medium">
                        {{ ucfirst($page->reviews_status) }}
                    </span>
                </div>
            </div>

            <!-- Clients Section (Index Only - No Edit) -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-green-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Clients <span class="text-xs text-gray-400 ml-2">(Index Only)</span></h4>
                            <p class="text-sm text-gray-600">{{ $page->clients_title ?? 'Clients Section' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'clients')"
                                class="w-10 h-10 rounded-xl {{ $page->clients_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-teal-100 text-teal-800 rounded-full font-medium">
                        {{ ucfirst($page->clients_status) }}
                    </span>
                </div>
            </div>

            <!-- Contact Section (Index Only - No Edit) -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-envelope text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Contact <span class="text-xs text-gray-400 ml-2">(Index Only)</span></h4>
                            <p class="text-sm text-gray-600">{{ $page->contact_title ?? 'Contact Section' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'contact')"
                                class="w-10 h-10 rounded-xl {{ $page->contact_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-rose-100 text-rose-800 rounded-full font-medium">
                        {{ ucfirst($page->contact_status) }}
                    </span>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="group py-6 hover:bg-gray-50 transition-all duration-200 border-t border-gray-100 pt-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-columns text-white text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-base">Footer</h4>
                            <p class="text-sm text-gray-600">{{ $page->footer_logo_text ?? 'TKDS Media' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-all ml-4">
                        <button onclick="toggleSection({{ $page->id }}, 'footer')" 
                                class="w-10 h-10 rounded-xl {{ $page->footer_status == 'active' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }} flex items-center justify-center shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-power-off text-sm"></i>
                        </button>
                        <a href="{{ route('admin.dynamic-pages.edit', ['page' => $page->id, 'tab' => 'footer']) }}" 
                           class="w-10 h-10 bg-blue-500 text-white rounded-xl flex items-center justify-center hover:bg-blue-600 shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-edit text-sm"></i>
                        </a>
                    </div>
                </div>
                <div class="flex items-center mt-3 ml-16">
                    <span class="text-xs px-2.5 py-1 bg-gray-100 text-gray-800 rounded-full font-medium">
                        {{ ucfirst($page->footer_status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-16">
        <div class="mx-auto h-24 w-24 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-2xl flex items-center justify-center mb-6">
            <i class="fas fa-layer-group text-4xl text-primary"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No pages found</h3>
        <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by creating your first dynamic page.</p>
        <a href="{{ route('admin.dynamic-pages.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            Create First Page
        </a>
    </div>
    @endforelse
</div>

<script>
function toggleSection(pageId, section) {
    fetch(`/admin/dynamic-pages/${pageId}/sections/${section}`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: 'toggle' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong!');
    });
}
</script>
@endsection
