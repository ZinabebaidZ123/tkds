@extends('admin.layouts.app')

@section('title', 'Edit Dynamic Page')
@section('page-title', 'Edit Dynamic Page')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span class="font-semibold">Please correct the following errors:</span>
            </div>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Page</h1>
            <p class="text-gray-600 text-sm mt-1">
                {{-- Manage sections for
                <span class="font-mono bg-gray-100 px-2 py-1 rounded text-xs">{{ $page->page_slug }}</span> --}}
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('occasions') }}" target="_blank"
               class="inline-flex items-center justify-center bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-primary text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-external-link-alt mr-2"></i> Preview
            </a>
            <a href="{{ route('admin.dynamic-pages.index') }}"
               class="inline-flex items-center justify-center bg-gray-700 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-gray-800 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Sections</p>
                    <p class="text-2xl font-bold">11</p>
                </div>
                <i class="fas fa-layer-group text-3xl text-blue-200"></i>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active Sections</p>
                    <p class="text-2xl font-bold">
                        {{ collect($page->sections_status)->filter(fn($s) => $s === 'active')->count() }}
                    </p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-200"></i>
            </div>
        </div>
    </div>

    @php
        $currentTab = request('tab', $tab ?? 'header');
        $whyChooseCards = $whyChooseCards ?? ($page->why_choose_cards ?? []);
        $clientLogos = $clientLogos ?? ($page->clients_logos ?? []);
        $reviewsItems = $reviewsItems ?? ($page->reviews_items ?? []);
    @endphp

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
 <div class="border-b border-gray-200 overflow-x-auto scrollable-nav">
    <nav class="-mb-px flex space-x-6 px-4 min-w-max" aria-label="Tabs">
        <a href="#header"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'header' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="header">
            <i class="fas fa-header w-5 h-5 mr-2 {{ $currentTab == 'header' ? 'text-primary' : 'text-gray-400' }}"></i>
            Header
        </a>
        <a href="#hero"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'hero' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="hero">
            <i class="fas fa-star w-5 h-5 mr-2 {{ $currentTab == 'hero' ? 'text-primary' : 'text-gray-400' }}"></i>
            Hero
        </a>
        <a href="#why-choose"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'why-choose' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="why-choose">
            <i class="fas fa-heart w-5 h-5 mr-2 {{ $currentTab == 'why-choose' ? 'text-primary' : 'text-gray-400' }}"></i>
            Why Choose Us
        </a>
        <a href="#services"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'services' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="services">
            <i class="fas fa-cogs w-5 h-5 mr-2 {{ $currentTab == 'services' ? 'text-primary' : 'text-gray-400' }}"></i>
            Services
        </a>
        <a href="#packages"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'packages' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="packages">
            <i class="fas fa-box w-5 h-5 mr-2 {{ $currentTab == 'packages' ? 'text-primary' : 'text-gray-400' }}"></i>
            Packages
        </a>
        <a href="#products"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'products' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="products">
            <i class="fas fa-cube w-5 h-5 mr-2 {{ $currentTab == 'products' ? 'text-primary' : 'text-gray-400' }}"></i>
            SaaS Products
        </a>
        <a href="#shop-products"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'shop-products' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="shop-products">
            <i class="fas fa-shopping-bag w-5 h-5 mr-2 {{ $currentTab == 'shop-products' ? 'text-primary' : 'text-gray-400' }}"></i>
            Shop Products
        </a>
        <a href="#video"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'video' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="video">
            <i class="fas fa-video w-5 h-5 mr-2 {{ $currentTab == 'video' ? 'text-primary' : 'text-gray-400' }}"></i>
            Video
        </a>
        <a href="#clients"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'clients' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="clients">
            <i class="fas fa-handshake w-5 h-5 mr-2 {{ $currentTab == 'clients' ? 'text-primary' : 'text-gray-400' }}"></i>
            Clients
        </a>
        <a href="#reviews"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'reviews' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="reviews">
            <i class="fas fa-comments w-5 h-5 mr-2 {{ $currentTab == 'reviews' ? 'text-primary' : 'text-gray-400' }}"></i>
            Reviews
        </a>
        <a href="#contact"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'contact' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="contact">
            <i class="fas fa-envelope w-5 h-5 mr-2 {{ $currentTab == 'contact' ? 'text-primary' : 'text-gray-400' }}"></i>
            Contact
        </a>
        <a href="#footer"
           class="tab-link inline-flex items-center pt-4 pb-3 border-b-2 text-sm font-medium {{ $currentTab == 'footer' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
           data-tab="footer">
            <i class="fas fa-columns w-5 h-5 mr-2 {{ $currentTab == 'footer' ? 'text-primary' : 'text-gray-400' }}"></i>
            Footer
        </a>
    </nav>
</div>

        <form action="{{ route('admin.dynamic-pages.update', $page) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="tab" id="currentTabInput" value="{{ $currentTab }}">

            {{-- HEADER TAB --}}
            <div id="header" class="tab-content p-8 {{ $currentTab == 'header' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo Image</label>
                        <input type="file"
                               name="header_logo_image"
                               accept="image/*"
                               data-preview="header-logo-preview"
                               class="image-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                        <div class="mt-2">
                            @if($page->header_logo_image)
                                <img id="header-logo-preview"
                                     src="{{ asset('storage/'.$page->header_logo_image) }}"
                                     class="w-32 h-16 object-contain rounded-lg border">
                            @else
                                <img id="header-logo-preview"
                                     class="w-32 h-16 object-contain rounded-lg border hidden">
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo Text</label>
                        <input type="text" name="header_logo_text"
                               value="{{ old('header_logo_text', $page->header_logo_text) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo Subtitle</label>
                        <input type="text" name="header_logo_subtitle"
                               value="{{ old('header_logo_subtitle', $page->header_logo_subtitle) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                        <input type="text" name="header_button_text"
                               value="{{ old('header_button_text', $page->header_button_text) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="text" name="header_phone"
                               value="{{ old('header_phone', $page->header_phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                            <input type="checkbox" name="header_status" value="active"
                                   {{ $page->header_status === 'active' ? 'checked' : '' }}
                                   class="mr-2 w-4 h-4">
                            Active
                        </label>
                    </div>
                </div>
            </div>

            {{-- HERO TAB --}}
            <div id="hero" class="tab-content p-8 {{ $currentTab == 'hero' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title Part 1</label>
                        <input type="text" name="hero_title_part1"
                               value="{{ old('hero_title_part1', $page->hero_title_part1) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title Part 2</label>
                        <input type="text" name="hero_title_part2"
                               value="{{ old('hero_title_part2', $page->hero_title_part2) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title Part 3</label>
                        <input type="text" name="hero_title_part3"
                               value="{{ old('hero_title_part3', $page->hero_title_part3) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                        <input type="text" name="hero_subtitle"
                               value="{{ old('hero_subtitle', $page->hero_subtitle) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="hero_description" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('hero_description', $page->hero_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                        <input type="text" name="hero_button_text"
                               value="{{ old('hero_button_text', $page->hero_button_text) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button URL</label>
                        <input type="text" name="hero_button_url"
                               value="{{ old('hero_button_url', $page->hero_button_url) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                        <p class="text-xs text-gray-500 mt-1">You can use any URL or anchor like #contact.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount %</label>
                        <input type="number" name="discount_percentage" min="0" max="100"
                               value="{{ old('discount_percentage', $page->discount_percentage) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Offer End Date</label>
                        <input type="datetime-local" name="offer_end_date"
                               value="{{ $page->offer_end_date ? $page->offer_end_date->format('Y-m-d\TH:i') : '' }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                            <input type="checkbox" name="hero_status" value="active"
                                   {{ $page->hero_status === 'active' ? 'checked' : '' }}
                                   class="mr-2 w-4 h-4">
                            Active
                        </label>
                    </div>
                </div>
            </div>

            {{-- WHY CHOOSE TAB --}}
            <div id="why-choose" class="tab-content p-8 {{ $currentTab == 'why-choose' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="why_choose_title"
                               value="{{ old('why_choose_title', $page->why_choose_title) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                        <input type="text" name="why_choose_subtitle"
                               value="{{ old('why_choose_subtitle', $page->why_choose_subtitle) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <input type="text" name="why_choose_description"
                               value="{{ old('why_choose_description', $page->why_choose_description) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Left Image</label>
                        <input type="file"
                               name="why_choose_left_image"
                               accept="image/*"
                               data-preview="why-left-preview"
                               class="image-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                        <div class="mt-2">
                            @if($page->why_choose_left_image)
                                <img id="why-left-preview"
                                     src="{{ asset('storage/'.$page->why_choose_left_image) }}"
                                     class="w-40 h-24 object-cover rounded-lg border">
                            @else
                                <img id="why-left-preview"
                                     class="w-40 h-24 object-cover rounded-lg border hidden">
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Background Image</label>
                        <input type="file"
                               name="why_choose_background_image"
                               accept="image/*"
                               data-preview="why-bg-preview"
                               class="image-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                        <div class="mt-2">
                            @if($page->why_choose_background_image)
                                <img id="why-bg-preview"
                                     src="{{ asset('storage/'.$page->why_choose_background_image) }}"
                                     class="w-40 h-24 object-cover rounded-lg border">
                            @else
                                <img id="why-bg-preview"
                                     class="w-40 h-24 object-cover rounded-lg border hidden">
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                        <input type="text" name="why_choose_button_text"
                               value="{{ old('why_choose_button_text', $page->why_choose_button_text) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button URL</label>
                        <input type="text" name="why_choose_button_url"
                               value="{{ old('why_choose_button_url', $page->why_choose_button_url) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                            <input type="checkbox" name="why_choose_status" value="active"
                                   {{ $page->why_choose_status === 'active' ? 'checked' : '' }}
                                   class="mr-2 w-4 h-4">
                            Active
                        </label>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-md font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-list-alt mr-2 text-primary"></i>
                            Features Cards
                        </h3>
                        <button type="button"
                                id="addWhyCardBtn"
                                class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl text-sm hover:bg-secondary transition">
                            <i class="fas fa-plus mr-2"></i>Add Feature
                        </button>
                    </div>

                    <div id="whyCardsContainer" class="space-y-4">
                        @forelse($whyChooseCards as $index => $card)
                            <div class="why-card-item bg-gray-50 border border-gray-200 rounded-xl p-4" data-index="{{ $index }}">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm font-semibold text-gray-700">Feature #{{ $index + 1 }}</span>
                                    <button type="button" class="remove-why-card text-red-600 text-xs hover:underline">
                                        Remove
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Title</label>
                                        <input type="text" name="why_cards_title[]" value="{{ $card['title'] ?? '' }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Description</label>
                                        <input type="text" name="why_cards_description[]" value="{{ $card['description'] ?? '' }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Icon (class)</label>
                                        <input type="text" name="why_cards_icon[]" value="{{ $card['icon'] ?? '' }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                               placeholder="fas fa-star">
                                    </div>
                                    <div class="flex space-x-2">
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Color From</label>
                                            <input type="color" name="why_cards_color_from[]"
                                                   value="{{ $card['color_from'] ?? '#000000' }}"
                                                   class="w-12 h-10 p-0 border border-gray-300 rounded">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Color To</label>
                                            <input type="color" name="why_cards_color_to[]"
                                                   value="{{ $card['color_to'] ?? '#000000' }}"
                                                   class="w-12 h-10 p-0 border border-gray-300 rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="why-card-item bg-gray-50 border border-gray-200 rounded-xl p-4" data-index="0">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm font-semibold text-gray-700">Feature #1</span>
                                    <button type="button" class="remove-why-card text-red-600 text-xs hover:underline">
                                        Remove
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Title</label>
                                        <input type="text" name="why_cards_title[]"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Description</label>
                                        <input type="text" name="why_cards_description[]"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Icon (class)</label>
                                        <input type="text" name="why_cards_icon[]"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                               placeholder="fas fa-star">
                                    </div>
                                    <div class="flex space-x-2">
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Color From</label>
                                            <input type="color" name="why_cards_color_from[]" value="#000000"
                                                   class="w-12 h-10 p-0 border border-gray-300 rounded">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Color To</label>
                                            <input type="color" name="why_cards_color_to[]" value="#000000"
                                                   class="w-12 h-10 p-0 border border-gray-300 rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        {{-- SERVICES TAB --}}
<div id="services" class="tab-content p-8 {{ $currentTab == 'services' ? '' : 'hidden' }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Services Title</label>
            <input type="text" name="services_title"
                   value="{{ old('services_title', $page->services_title) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Services Subtitle</label>
            <textarea name="services_subtitle" rows="2"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('services_subtitle', $page->services_subtitle) }}</textarea>
        </div>
        <div>
            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                <input type="checkbox" name="services_status" value="active"
                       {{ $page->services_status === 'active' ? 'checked' : '' }}
                       class="mr-2 w-4 h-4">
                Active
            </label>
        </div>
    </div>

    <!-- Services Selection -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Services to Display</h3>
        
        <!-- Filter -->
        <div class="mb-4">
            <input type="text" id="servicesFilter" placeholder="Filter services..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="servicesGrid">
            @foreach($services as $service)
                @php
                    $isSelected = $page->services->contains('id', $service->id);
                @endphp
                <div class="service-item p-4 border rounded-lg hover:bg-white transition-colors {{ $isSelected ? 'border-primary bg-blue-50' : 'border-gray-200 bg-white' }}"
                     data-service-id="{{ $service->id }}"
                     data-service-name="{{ strtolower($service->title) }}">
                    
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <input type="checkbox" name="selected_services[]" value="{{ $service->id }}"
                                   {{ $isSelected ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $service->title }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($service->description, 80) }}</p>
                            
                            @if($service->icon)
                                <div class="mt-2">
                                    <i class="{{ $service->icon }} text-primary"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Service Customization Options (shown when selected) -->
                    {{-- <div class="service-options mt-4 {{ $isSelected ? '' : 'hidden' }}">
                        <div class="border-t pt-4 space-y-3">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Custom Icon</label>
                                    <input type="text" name="service_custom_icon[{{ $service->id }}]"
                                           value="{{ $isSelected ? $page->services->find($service->id)?->pivot->custom_icon : '' }}"
                                           placeholder="fas fa-server"
                                           class="w-full px-2 py-1 text-xs border border-gray-300 rounded">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Discount Badge</label>
                                    <input type="text" name="service_discount_badge[{{ $service->id }}]"
                                           value="{{ $isSelected ? $page->services->find($service->id)?->pivot->discount_badge : '' }}"
                                           placeholder="20% OFF"
                                           class="w-full px-2 py-1 text-xs border border-gray-300 rounded">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Button Text</label>
                                    <input type="text" name="service_button_text[{{ $service->id }}]"
                                           value="{{ $isSelected ? $page->services->find($service->id)?->pivot->read_more_button_text : '' }}"
                                           placeholder="Learn More"
                                           class="w-full px-2 py-1 text-xs border border-gray-300 rounded">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Button URL</label>
                                    <input type="text" name="service_button_url[{{ $service->id }}]"
                                           value="{{ $isSelected ? $page->services->find($service->id)?->pivot->read_more_button_url : '' }}"
                                           placeholder="/services/{{ $service->slug }}"
                                           class="w-full px-2 py-1 text-xs border border-gray-300 rounded">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700">Custom Background</label>
                                <input type="text" name="service_background[{{ $service->id }}]"
                                       value="{{ $isSelected ? $page->services->find($service->id)?->pivot->custom_background : '' }}"
                                       placeholder="bg-gradient-to-r from-blue-500 to-purple-600"
                                       class="w-full px-2 py-1 text-xs border border-gray-300 rounded">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700">Sort Order</label>
                                <input type="number" name="service_sort_order[{{ $service->id }}]"
                                       value="{{ $isSelected ? $page->services->find($service->id)?->pivot->sort_order : 0 }}"
                                       min="0"
                                       class="w-full px-2 py-1 text-xs border border-gray-300 rounded">
                            </div>
                        </div>
                    </div> --}}
                </div>
            @endforeach
        </div>

        @if($services->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <p>No services available. Please create services first.</p>
                <a href="{{ route('admin.services.create') }}" class="text-primary hover:underline">Create Service</a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Services Filter
    const servicesFilter = document.getElementById('servicesFilter');
    const serviceItems = document.querySelectorAll('.service-item');

    if (servicesFilter) {
        servicesFilter.addEventListener('input', function() {
            const filterValue = this.value.toLowerCase();
            serviceItems.forEach(item => {
                const serviceName = item.dataset.serviceName;
                if (serviceName.includes(filterValue)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    // Service Selection Handler
    serviceItems.forEach(item => {
        const checkbox = item.querySelector('input[type="checkbox"]');
        const options = item.querySelector('.service-options');
        
        if (checkbox && options) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    item.classList.add('border-primary', 'bg-blue-50');
                    item.classList.remove('border-gray-200', 'bg-white');
                    options.classList.remove('hidden');
                } else {
                    item.classList.remove('border-primary', 'bg-blue-50');
                    item.classList.add('border-gray-200', 'bg-white');
                    options.classList.add('hidden');
                    // Clear customization fields
                    options.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            });
        }
    });

    // Select All / Deselect All functionality
    const selectAllBtn = document.createElement('button');
    selectAllBtn.type = 'button';
    selectAllBtn.className = 'mb-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark';
    selectAllBtn.textContent = 'Select All Services';
    
    const servicesGrid = document.getElementById('servicesGrid');
    if (servicesGrid) {
        servicesGrid.parentNode.insertBefore(selectAllBtn, servicesGrid);
        
        selectAllBtn.addEventListener('click', function() {
            const allCheckboxes = servicesGrid.querySelectorAll('input[type="checkbox"]');
            const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
            
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
                checkbox.dispatchEvent(new Event('change'));
            });
            
            this.textContent = allChecked ? 'Select All Services' : 'Deselect All Services';
        });
    }
});
</script>

         {{-- PACKAGES TAB --}}
<div id="packages" class="tab-content p-8 {{ $currentTab == 'packages' ? '' : 'hidden' }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Packages Title</label>
            <input type="text" name="packages_title"
                   value="{{ old('packages_title', $page->packages_title) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Packages Subtitle</label>
            <textarea name="packages_subtitle" rows="2"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('packages_subtitle', $page->packages_subtitle) }}</textarea>
        </div>
        <div>
            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                <input type="checkbox" name="packages_status" value="active"
                       {{ $page->packages_status === 'active' ? 'checked' : '' }}
                       class="mr-2 w-4 h-4">
                Active
            </label>
        </div>
    </div>

    <!-- Packages Selection -->
    <div class="bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Pricing Plans to Display</h3>
        
        <!-- Filters -->
        <div class="flex flex-wrap gap-4 mb-4">
            <div class="flex-1 min-w-64">
                <input type="text" id="packagesFilter" placeholder="Filter packages..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <select id="packagesPricingFilter" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Plans</option>
                    <option value="monthly">Monthly Plans</option>
                    <option value="yearly">Yearly Plans</option>
                    <option value="both">Both Monthly & Yearly</option>
                </select>
            </div>
            <div>
                <select id="packagesPopularFilter" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Plans</option>
                    <option value="popular">Popular Only</option>
                    <option value="featured">Featured Only</option>
                </select>
            </div>
        </div>

        <!-- Packages Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="packagesGrid">
            @foreach($packages as $package)
                @php
                    $isSelected = $page->pricingPlans->contains('id', $package->id);
                    $hasMonthly = !empty($package->price_monthly) && $package->price_monthly > 0;
                    $hasYearly = !empty($package->price_yearly) && $package->price_yearly > 0;
                    $pricingType = $hasMonthly && $hasYearly ? 'both' : ($hasMonthly ? 'monthly' : 'yearly');
                @endphp
                <div class="package-item p-4 border rounded-lg hover:bg-white transition-colors {{ $isSelected ? 'border-primary bg-blue-50' : 'border-gray-200 bg-white' }}"
                     data-package-id="{{ $package->id }}"
                     data-package-name="{{ strtolower($package->name) }}"
                     data-pricing-type="{{ $pricingType }}"
                     data-is-popular="{{ $package->is_popular ? 'true' : 'false' }}"
                     data-is-featured="{{ $package->is_featured ? 'true' : 'false' }}">
                    
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <input type="checkbox" name="selected_packages[]" value="{{ $package->id }}"
                                   {{ $isSelected ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="font-semibold text-gray-900">{{ $package->name }}</h4>
                                <div class="flex space-x-1">
                                    @if($package->is_popular)
                                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Popular</span>
                                    @endif
                                    @if($package->is_featured)
                                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">Featured</span>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($package->description, 80) }}</p>
                            
                            <div class="mt-2 space-y-1">
                                @if($hasMonthly)
                                    <div class="text-sm">
                                        <span class="font-medium text-primary">{{ $package->getFormattedPriceMonthly() }}</span>
                                    </div>
                                @endif
                                @if($hasYearly)
                                    <div class="text-sm">
                                        <span class="font-medium text-secondary">{{ $package->getFormattedPriceYearly() }}</span>
                                        @if($package->getYearlySavingsPercentage() > 0)
                                            <span class="text-xs text-green-600">(Save {{ $package->getYearlySavingsPercentage() }}%)</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            @if($package->features && count($package->features) > 0)
                                <div class="mt-2">
                                    <span class="text-xs text-gray-500">{{ count($package->features) }} features</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Package Customization Options -->
                    {{-- <div class="package-options mt-4 {{ $isSelected ? '' : 'hidden' }}">
                        <div class="border-t pt-4 space-y-3">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Discount %</label>
                                    <input type="number" name="package_discount[{{ $package->id }}]"
                                           value="{{ $isSelected ? $page->pricingPlans->find($package->id)?->pivot->discount_percentage : '' }}"
                                           min="0" max="100"
                                           class="w-full px-2 py-1 text-xs border border-gray-300 rounded">
                                </div>
                                <div>
                                    <label class="flex items-center text-xs font-medium text-gray-700">
                                        <input type="checkbox" name="package_featured[{{ $package->id }}]" value="1"
                                               {{ $isSelected && $page->pricingPlans->find($package->id)?->pivot->is_featured ? 'checked' : '' }}
                                               class="mr-1 w-3 h-3">
                                        Mark as Featured
                                    </label>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-xs font-medium text-gray-700">Sort Order</label>
                                    <input type="number" name="package_sort_order[{{ $package->id }}]"
                                           value="{{ $isSelected ? $page->pricingPlans->find($package->id)?->pivot->sort_order : 0 }}"
                                           min="0"
                                           class="w-full px-2 py-1 text-xs border border-gray-300 rounded">
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            @endforeach
        </div>

        @if($packages->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <p>No pricing plans available. Please create pricing plans first.</p>
                <a href="{{ route('admin.pricing-plans.create') }}" class="text-primary hover:underline">Create Pricing Plan</a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Packages Filters
    const packagesFilter = document.getElementById('packagesFilter');
    const packagesPricingFilter = document.getElementById('packagesPricingFilter');
    const packagesPopularFilter = document.getElementById('packagesPopularFilter');
    const packageItems = document.querySelectorAll('.package-item');

    function filterPackages() {
        const nameFilter = packagesFilter?.value.toLowerCase() || '';
        const pricingFilter = packagesPricingFilter?.value || '';
        const popularFilter = packagesPopularFilter?.value || '';

        packageItems.forEach(item => {
            const packageName = item.dataset.packageName;
            const pricingType = item.dataset.pricingType;
            const isPopular = item.dataset.isPopular === 'true';
            const isFeatured = item.dataset.isFeatured === 'true';

            const nameMatch = packageName.includes(nameFilter);
            const pricingMatch = !pricingFilter || 
                (pricingFilter === 'both' && pricingType === 'both') ||
                (pricingFilter === 'monthly' && (pricingType === 'monthly' || pricingType === 'both')) ||
                (pricingFilter === 'yearly' && (pricingType === 'yearly' || pricingType === 'both'));
            const popularMatch = !popularFilter ||
                (popularFilter === 'popular' && isPopular) ||
                (popularFilter === 'featured' && isFeatured);

            if (nameMatch && pricingMatch && popularMatch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    if (packagesFilter) {
        packagesFilter.addEventListener('input', filterPackages);
    }
    if (packagesPricingFilter) {
        packagesPricingFilter.addEventListener('change', filterPackages);
    }
    if (packagesPopularFilter) {
        packagesPopularFilter.addEventListener('change', filterPackages);
    }

    // Package Selection Handler
    packageItems.forEach(item => {
        const checkbox = item.querySelector('input[type="checkbox"]');
        const options = item.querySelector('.package-options');
        
        if (checkbox && options) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    item.classList.add('border-primary', 'bg-blue-50');
                    item.classList.remove('border-gray-200', 'bg-white');
                    options.classList.remove('hidden');
                } else {
                    item.classList.remove('border-primary', 'bg-blue-50');
                    item.classList.add('border-gray-200', 'bg-white');
                    options.classList.add('hidden');
                    options.querySelectorAll('input').forEach(input => {
                        if (input.type !== 'checkbox') {
                            input.value = '';
                        } else {
                            input.checked = false;
                        }
                    });
                }
            });
        }
    });
});
</script>

{{-- PRODUCTS (SaaS) TAB --}}
<div id="products" class="tab-content p-8 {{ $currentTab == 'products' ? '' : 'hidden' }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">SaaS Products Title</label>
            <input type="text" name="products_title"
                   value="{{ old('products_title', $page->products_title) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">SaaS Products Subtitle</label>
            <textarea name="products_subtitle" rows="2"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('products_subtitle', $page->products_subtitle) }}</textarea>
        </div>
        <div>
            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                <input type="checkbox" name="products_status" value="active"
                       {{ $page->products_status === 'active' ? 'checked' : '' }}
                       class="mr-2 w-4 h-4">
                Active
            </label>
        </div>
    </div>

    <!-- SaaS Products Selection -->
    <div class="bg-gray-50 rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Select SaaS Products</h3>
            <div class="flex space-x-2">
                <button type="button" id="selectAllProducts" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                    Select All
                </button>
                <button type="button" id="clearAllProducts" class="px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600">
                    Clear All
                </button>
            </div>
        </div>
        
        <!-- Search and Filters -->
        <div class="flex space-x-4 mb-4">
            <input type="text" id="productsSearch" placeholder="Search products..." 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
            <select id="productsCategoryFilter" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Categories</option>
                @foreach($products->pluck('category')->unique()->filter() as $category)
                    <option value="{{ strtolower($category) }}">{{ ucfirst($category) }}</option>
                @endforeach
            </select>
            <select id="productsPricingFilter" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Pricing</option>
                <option value="free">Free</option>
                <option value="subscription">Subscription</option>
                <option value="one_time">One-time</option>
                <option value="quote">Contact for Quote</option>
            </select>
        </div>

        <!-- Products List -->
        <div class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
            @foreach($products as $product)
                <div class="product-item p-4 border-b border-gray-100 hover:bg-gray-50 flex items-center space-x-3"
                     data-name="{{ strtolower($product->title) }}"
                     data-category="{{ strtolower($product->category) }}"
                     data-pricing="{{ $product->pricing_model }}">
                    <input type="checkbox" 
                           name="selected_products[]" 
                           value="{{ $product->id }}"
                           {{ in_array($product->id, $selectedProducts) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600">
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $product->title }}</h4>
                                <p class="text-sm text-gray-600">{{ Str::limit($product->short_description ?? $product->subtitle, 60) }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    @if($product->getFormattedPrice())
                                        <span class="text-sm text-gray-500">{{ $product->getFormattedPrice() }}</span>
                                    @endif
                                    @if($product->category)
                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-800 rounded">{{ $product->getCategoryLabel() }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-1">
                                @if($product->is_featured)
                                    <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded">Featured</span>
                                @endif
                                @if($product->show_in_homepage)
                                    <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">Homepage</span>
                                @endif
                                @if($product->show_in_navbar)
                                    <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">Navbar</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-sm text-gray-600">
            Selected: <span id="productsCount">{{ count($selectedProducts) }}</span> of {{ count($products) }} products
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Products filters
    const productsSearch = document.getElementById('productsSearch');
    const productsCategoryFilter = document.getElementById('productsCategoryFilter');
    const productsPricingFilter = document.getElementById('productsPricingFilter');

    function filterProducts() {
        const searchTerm = productsSearch?.value.toLowerCase() || '';
        const categoryFilter = productsCategoryFilter?.value || '';
        const pricingFilter = productsPricingFilter?.value || '';
        
        const items = document.querySelectorAll('.product-item');
        
        items.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            const category = item.getAttribute('data-category') || '';
            const pricing = item.getAttribute('data-pricing') || '';
            
            const nameMatch = name.includes(searchTerm);
            const categoryMatch = !categoryFilter || category === categoryFilter;
            const pricingMatch = !pricingFilter || pricing === pricingFilter;
            
            if (nameMatch && categoryMatch && pricingMatch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
        
        updateProductsCount();
    }

    function updateProductsCount() {
        const checked = document.querySelectorAll('input[name="selected_products[]"]:checked').length;
        const total = document.querySelectorAll('.product-item:not([style*="display: none"])').length;
        const countEl = document.getElementById('productsCount');
        if (countEl) countEl.textContent = checked;
    }

    // Attach event listeners
    if (productsSearch) {
        productsSearch.addEventListener('input', filterProducts);
    }
    if (productsCategoryFilter) {
        productsCategoryFilter.addEventListener('change', filterProducts);
    }
    if (productsPricingFilter) {
        productsPricingFilter.addEventListener('change', filterProducts);
    }

    // Select All / Clear All
    const selectAllProducts = document.getElementById('selectAllProducts');
    const clearAllProducts = document.getElementById('clearAllProducts');
    
    if (selectAllProducts) {
        selectAllProducts.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            const visibleCheckboxes = Array.from(checkboxes).filter(cb => 
                !cb.closest('.product-item').style.display.includes('none')
            );
            visibleCheckboxes.forEach(cb => cb.checked = true);
            updateProductsCount();
        });
    }
    
    if (clearAllProducts) {
        clearAllProducts.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            checkboxes.forEach(cb => cb.checked = false);
            updateProductsCount();
        });
    }

    // Listen for checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.name === 'selected_products[]') {
            updateProductsCount();
        }
    });

    // Initial count update
    updateProductsCount();
});
</script>

{{-- SHOP PRODUCTS TAB --}}
<div id="shop-products" class="tab-content p-8 {{ $currentTab == 'shop-products' ? '' : 'hidden' }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Shop Products Title</label>
            <input type="text" name="shop_products_title"
                   value="{{ old('shop_products_title', $page->shop_products_title) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Shop Products Subtitle</label>
            <textarea name="shop_products_subtitle" rows="2"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('shop_products_subtitle', $page->shop_products_subtitle) }}</textarea>
        </div>
        <div>
            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                <input type="checkbox" name="shop_products_status" value="active"
                       {{ $page->shop_products_status === 'active' ? 'checked' : '' }}
                       class="mr-2 w-4 h-4">
                Active
            </label>
        </div>
    </div>

    <!-- Shop Products Selection -->
    <div class="bg-gray-50 rounded-xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Select Shop Products</h3>
            <div class="flex space-x-2">
                <button type="button" id="selectAllShopProducts" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                    Select All
                </button>
                <button type="button" id="clearAllShopProducts" class="px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600">
                    Clear All
                </button>
            </div>
        </div>
        
        <!-- Search -->
        <div class="mb-4">
            <input type="text" id="shopProductsSearch" placeholder="Search shop products..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <!-- Shop Products List -->
        <div class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
            @foreach($shopProducts as $shopProduct)
                <div class="shop-product-item p-4 border-b border-gray-100 hover:bg-gray-50 flex items-center space-x-3"
                     data-name="{{ strtolower($shopProduct->name) }}">
                    <input type="checkbox" 
                           name="selected_shop_products[]" 
                           value="{{ $shopProduct->id }}"
                           {{ in_array($shopProduct->id, $selectedShopProducts) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600">
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $shopProduct->name }}</h4>
                                <p class="text-sm text-gray-600">{{ Str::limit($shopProduct->short_description, 60) }}</p>
                                <div class="text-sm text-gray-500 mt-1">{{ $shopProduct->getFormattedPrice() }}</div>
                            </div>
                            <div class="flex space-x-1">
                                <span class="text-xs px-2 py-1 rounded {{ $shopProduct->type === 'physical' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($shopProduct->type) }}
                                </span>
                                @if($shopProduct->is_featured)
                                    <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded">Featured</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-sm text-gray-600">
            Selected: <span id="shopProductsCount">{{ count($selectedShopProducts) }}</span> of {{ count($shopProducts) }} shop products
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shop Products Filters
    const shopProductsFilter = document.getElementById('shopProductsFilter');
    const shopProductsTypeFilter = document.getElementById('shopProductsTypeFilter');
    const shopProductsCategoryFilter = document.getElementById('shopProductsCategoryFilter');
    const shopProductItems = document.querySelectorAll('.shop-product-item');

    function filterShopProducts() {
        const nameFilter = shopProductsFilter?.value.toLowerCase() || '';
        const typeFilter = shopProductsTypeFilter?.value || '';
        const categoryFilter = shopProductsCategoryFilter?.value || '';

        shopProductItems.forEach(item => {
            const productName = item.dataset.productName;
            const productType = item.dataset.productType;
            const categoryId = item.dataset.categoryId;

            const nameMatch = productName.includes(nameFilter);
            const typeMatch = !typeFilter || productType === typeFilter;
            const categoryMatch = !categoryFilter || categoryId === categoryFilter;

            if (nameMatch && typeMatch && categoryMatch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    if (shopProductsFilter) {
        shopProductsFilter.addEventListener('input', filterShopProducts);
    }
    if (shopProductsTypeFilter) {
        shopProductsTypeFilter.addEventListener('change', filterShopProducts);
    }
    if (shopProductsCategoryFilter) {
        shopProductsCategoryFilter.addEventListener('change', filterShopProducts);
    }

    // Shop Product Selection Handler
    shopProductItems.forEach(item => {
        const checkbox = item.querySelector('input[type="checkbox"]');
        const options = item.querySelector('.shop-product-options');
        
        if (checkbox && options) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    item.classList.add('border-primary', 'bg-blue-50');
                    item.classList.remove('border-gray-200', 'bg-white');
                    options.classList.remove('hidden');
                } else {
                    item.classList.remove('border-primary', 'bg-blue-50');
                    item.classList.add('border-gray-200', 'bg-white');
                    options.classList.add('hidden');
                    options.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            });
        }
    });
});
</script>

  {{-- VIDEO TAB --}}
<div id="video" class="tab-content p-8 {{ $currentTab == 'video' ? '' : 'hidden' }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Video Title</label>
            <input type="text" name="video_title"
                   value="{{ old('video_title', $page->video_title) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Video Subtitle</label>
            <textarea name="video_subtitle" rows="2"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('video_subtitle', $page->video_subtitle) }}</textarea>
        </div>
        
                <!-- Video Source Selection -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-4">Video Source</label>
            <div class="space-y-4">
                <!-- Video URL Option -->
                <div class="border border-gray-200 rounded-xl p-4">
                    <div class="flex items-center mb-3">
                        <input type="radio" name="video_source" value="url" id="video_url_option"
                               {{ empty($page->video_file) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                        <label for="video_url_option" class="ml-2 text-sm font-medium text-gray-900">
                            <i class="fas fa-link mr-2 text-primary"></i>Video URL (YouTube, Vimeo, Direct Link)
                        </label>
                    </div>
                    <input type="text" name="video_url"
                           value="{{ old('video_url', $page->video_url) }}"
                           placeholder="https://www.youtube.com/watch?v=... or direct MP4 URL"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary"
                           id="video_url_input">
                    <p class="text-xs text-gray-500 mt-1">YouTube, Vimeo, or direct video file URL</p>
                </div>

                <!-- Video Upload Option -->
                <div class="border border-gray-200 rounded-xl p-4">
                    <div class="flex items-center mb-3">
                        <input type="radio" name="video_source" value="upload" id="video_upload_option"
                               {{ !empty($page->video_file) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary border-gray-300 focus:ring-primary">
                        <label for="video_upload_option" class="ml-2 text-sm font-medium text-gray-900">
                            <i class="fas fa-upload mr-2 text-primary"></i>Upload Video File
                        </label>
                    </div>
                    
                    <!-- Video Upload Area -->
                    <div class="video-upload-area border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary transition-colors"
                         id="videoUploadArea">
                        <input type="file" name="video_file" accept="video/*" id="videoFileInput" class="hidden">
                        
                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <i class="fas fa-video text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-2">Click to upload or drag and drop</p>
                            <p class="text-sm text-gray-500">MP4, AVI, MOV up to 200MB</p>
                        </div>
                        
                        <!-- Current Video Display -->
                        @if($page->video_file)
                            <div class="current-video" id="currentVideo">
                                <div class="flex items-center justify-center space-x-4 p-4 bg-green-50 rounded-lg">
                                    <i class="fas fa-file-video text-green-600 text-2xl"></i>
                                    <div class="text-left">
                                        <p class="text-sm font-medium text-gray-900">Current Video File</p>
                                        <p class="text-xs text-gray-600">{{ basename($page->video_file) }}</p>
                                    </div>
                                    <button type="button" class="text-red-600 hover:text-red-800 text-sm" id="removeCurrentVideo">
                                        <i class="fas fa-trash mr-1"></i>Remove
                                    </button>
                                </div>
                                <input type="hidden" name="remove_current_video" id="removeCurrentInput" value="0">
                            </div>
                        @endif
                        
                        <!-- Video Preview -->
                        <div class="video-preview hidden" id="videoPreview">
                            <div class="flex items-center justify-center space-x-4 p-4 bg-blue-50 rounded-lg">
                                <i class="fas fa-file-video text-blue-600 text-2xl"></i>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-gray-900">New Video Selected</p>
                                    <p class="text-xs text-gray-600" id="videoFileName"></p>
                                </div>
                                <button type="button" class="text-red-600 hover:text-red-800 text-sm" id="removeNewVideo">
                                    <i class="fas fa-trash mr-1"></i>Remove
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-2">
                        Supported formats: MP4, AVI, MOV, QuickTime. Maximum size: 200MB
                    </p>
                </div>
            </div>
        </div>

        <!-- Video Thumbnail -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Video Thumbnail</label>
            <input type="file"
                   name="video_thumbnail"
                   accept="image/*"
                   data-preview="video-thumb-preview"
                   class="image-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
            <div class="mt-2">
                @if($page->video_thumbnail)
                    <img id="video-thumb-preview"
                         src="{{ asset('storage/'.$page->video_thumbnail) }}"
                         class="w-40 h-24 object-cover rounded-lg border">
                @else
                    <img id="video-thumb-preview"
                         class="w-40 h-24 object-cover rounded-lg border hidden">
                @endif
            </div>
            <p class="text-xs text-gray-500 mt-1">Optional: Custom thumbnail for video</p>
        </div>

        <!-- Video Info -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Info Title</label>
            <input type="text" name="video_info_title"
                   value="{{ old('video_info_title', $page->video_info_title) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Info Description</label>
            <input type="text" name="video_info_description"
                   value="{{ old('video_info_description', $page->video_info_description) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
        </div>
        <div>
            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                <input type="checkbox" name="video_status" value="active"
                       {{ $page->video_status === 'active' ? 'checked' : '' }}
                       class="mr-2 w-4 h-4">
                Active
            </label>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoUploadArea = document.getElementById('videoUploadArea');
    const videoFileInput = document.getElementById('videoFileInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const videoPreview = document.getElementById('videoPreview');
    const currentVideo = document.getElementById('currentVideo');
    const videoUrlOption = document.getElementById('video_url_option');
    const videoUploadOption = document.getElementById('video_upload_option');
    const videoUrlInput = document.getElementById('video_url_input');
    const removeNewVideo = document.getElementById('removeNewVideo');
    const removeCurrentVideo = document.getElementById('removeCurrentVideo');
    const removeCurrentInput = document.getElementById('removeCurrentInput');
    const videoFileName = document.getElementById('videoFileName');

    function toggleVideoSource() {
        if (videoUrlOption && videoUrlOption.checked) {
            videoUrlInput.disabled = false;
            videoFileInput.disabled = true;
            videoUploadArea.style.opacity = '0.5';
            videoUploadArea.style.pointerEvents = 'none';
        } else if (videoUploadOption && videoUploadOption.checked) {
            videoUrlInput.disabled = true;
            videoFileInput.disabled = false;
            videoUploadArea.style.opacity = '1';
            videoUploadArea.style.pointerEvents = 'auto';
        }
    }

    if (videoUrlOption) videoUrlOption.addEventListener('change', toggleVideoSource);
    if (videoUploadOption) videoUploadOption.addEventListener('change', toggleVideoSource);
    
    toggleVideoSource();

    if (videoUploadArea) {
        videoUploadArea.addEventListener('click', function(e) {
            if (videoUploadOption && videoUploadOption.checked && !videoFileInput.disabled) {
                videoFileInput.click();
            }
        });
    }

    if (videoUploadArea) {
        videoUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-primary', 'bg-blue-50');
        });

        videoUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary', 'bg-blue-50');
        });

        videoUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary', 'bg-blue-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0 && videoUploadOption && videoUploadOption.checked) {
                handleVideoFile(files[0]);
            }
        });
    }

    if (videoFileInput) {
        videoFileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleVideoFile(this.files[0]);
            }
        });
    }

    function handleVideoFile(file) {
        const maxSize = 200 * 1024 * 1024;
        const allowedTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/quicktime', 'video/x-msvideo'];

        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid video file (MP4, AVI, MOV)');
            videoFileInput.value = '';
            return;
        }

        if (file.size > maxSize) {
            alert('File size must be less than 200MB');
            videoFileInput.value = '';
            return;
        }

        if (videoFileName) videoFileName.textContent = file.name;
        
        if (uploadPlaceholder) uploadPlaceholder.classList.add('hidden');
        if (currentVideo) currentVideo.classList.add('hidden');
        if (videoPreview) videoPreview.classList.remove('hidden');
    }

    if (removeNewVideo) {
        removeNewVideo.addEventListener('click', function() {
            videoFileInput.value = '';
            if (videoPreview) videoPreview.classList.add('hidden');
            if (uploadPlaceholder) uploadPlaceholder.classList.remove('hidden');
            if (currentVideo) currentVideo.classList.remove('hidden');
        });
    }

    if (removeCurrentVideo) {
        removeCurrentVideo.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove the current video?')) {
                if (currentVideo) currentVideo.classList.add('hidden');
                if (removeCurrentInput) removeCurrentInput.value = '1';
                if (uploadPlaceholder) uploadPlaceholder.classList.remove('hidden');
            }
        });
    }
});
</script>

          
       {{-- CLIENTS TAB --}}
<div id="clients" class="tab-content p-8 {{ $currentTab == 'clients' ? '' : 'hidden' }}">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Clients Title</label>
            <input type="text" name="clients_title"
                   value="{{ old('clients_title', $page->clients_title) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Clients Subtitle</label>
            <textarea name="clients_subtitle" rows="2"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('clients_subtitle', $page->clients_subtitle) }}</textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Client Logos</label>
            <input type="file" name="clients_logos[]" multiple accept="image/*" id="clientsLogosInput"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
            <p class="text-xs text-gray-500 mt-1">You can upload multiple logos at once.</p>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-4">Current Client Logos</label>
            <div class="flex flex-wrap gap-4" id="clientLogosContainer">
                @if($page->clients_logos && is_array($page->clients_logos))
                    @foreach($page->clients_logos as $index => $logo)
                        <div class="relative client-logo-item" data-index="{{ $index }}">
                            @if(is_string($logo))
                                <img src="{{ asset('storage/' . $logo) }}"
                                     class="w-20 h-20 object-contain rounded-lg border bg-white">
                            @elseif(is_array($logo) && isset($logo['logo']))
                                <img src="{{ asset('storage/' . $logo['logo']) }}"
                                     class="w-20 h-20 object-contain rounded-lg border bg-white">
                                @if(isset($logo['name']))
                                    <p class="text-xs text-center mt-1 text-gray-600">{{ $logo['name'] }}</p>
                                @endif
                            @endif
                            <button type="button" 
                                    class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer text-xs hover:bg-red-700 remove-client-btn">
                                ×
                            </button>
                            <input type="hidden" name="existing_clients_logos[]" value="{{ is_string($logo) ? $logo : (isset($logo['logo']) ? $logo['logo'] : '') }}">
                        </div>
                    @endforeach
                @endif
            </div>
            
            <!-- Preview for new uploads -->
            <div class="flex flex-wrap gap-4 mt-4" id="newClientLogosPreview"></div>
            
            <input type="hidden" name="remove_client_indexes" id="removeClientIndexes">
        </div>

        <div>
            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                <input type="checkbox" name="clients_status" value="active"
                       {{ $page->clients_status === 'active' ? 'checked' : '' }}
                       class="mr-2 w-4 h-4">
                Active
            </label>
        </div>
    </div>
</div>

            {{-- REVIEWS TAB --}}
            <div id="reviews" class="tab-content p-8 {{ $currentTab == 'reviews' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reviews Title</label>
                        <input type="text" name="reviews_title"
                               value="{{ old('reviews_title', $page->reviews_title) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reviews Subtitle</label>
                        <textarea name="reviews_subtitle" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('reviews_subtitle', $page->reviews_subtitle) }}</textarea>
                    </div>
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                            <input type="checkbox" name="reviews_status" value="active"
                                   {{ $page->reviews_status === 'active' ? 'checked' : '' }}
                                   class="mr-2 w-4 h-4">
                            Active
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-md font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-users mr-2 text-primary"></i>
                        Reviews Items
                    </h3>
                    <button type="button"
                            id="addReviewBtn"
                            class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl text-sm hover:bg-secondary transition">
                        <i class="fas fa-plus mr-2"></i>Add Review
                    </button>
                </div>

                <div id="reviewsContainer" class="space-y-4">
                    @forelse($reviewsItems as $index => $item)
                        <div class="review-item bg-gray-50 border border-gray-200 rounded-xl p-4" data-index="{{ $index }}">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm font-semibold text-gray-700">Review #{{ $index + 1 }}</span>
                                <button type="button" class="remove-review text-red-600 text-xs hover:underline">
                                    Remove
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Name</label>
                                    <input type="text" name="reviews_name[]" value="{{ $item['name'] ?? '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Role</label>
                                    <input type="text" name="reviews_role[]" value="{{ $item['role'] ?? '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Company</label>
                                    <input type="text" name="reviews_company[]" value="{{ $item['company'] ?? '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Rating (1-5)</label>
                                    <input type="number" min="1" max="5" name="reviews_rating[]"
                                           value="{{ $item['rating'] ?? 5 }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Review</label>
                                    <textarea name="reviews_review[]" rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">{{ $item['review'] ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Avatar</label>
                                    <input type="file" name="reviews_avatar[{{ $index }}]" accept="image/*"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    <input type="hidden" name="reviews_avatar_existing[]" value="{{ $item['avatar'] ?? '' }}">
                                    @if(!empty($item['avatar']))
                                        <img src="{{ asset('storage/'.$item['avatar']) }}"
                                             class="w-16 h-16 rounded-full object-cover border mt-2">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="review-item bg-gray-50 border border-gray-200 rounded-xl p-4" data-index="0">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm font-semibold text-gray-700">Review #1</span>
                                <button type="button" class="remove-review text-red-600 text-xs hover:underline">
                                    Remove
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Name</label>
                                    <input type="text" name="reviews_name[]"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Role</label>
                                    <input type="text" name="reviews_role[]"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Company</label>
                                    <input type="text" name="reviews_company[]"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Rating (1-5)</label>
                                    <input type="number" min="1" max="5" name="reviews_rating[]" value="5"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Review</label>
                                    <textarea name="reviews_review[]" rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Avatar</label>
                                    <input type="file" name="reviews_avatar[0]" accept="image/*"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    <input type="hidden" name="reviews_avatar_existing[]" value="">
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- CONTACT TAB --}}
            <div id="contact" class="tab-content p-8 {{ $currentTab == 'contact' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Title</label>
                        <input type="text" name="contact_title"
                               value="{{ old('contact_title', $page->contact_title) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Subtitle</label>
                        <textarea name="contact_subtitle" rows="2"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('contact_subtitle', $page->contact_subtitle) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                        <input type="text" name="contact_whatsapp"
                               value="{{ old('contact_whatsapp', $page->contact_whatsapp) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="contact_email"
                               value="{{ old('contact_email', $page->contact_email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input type="text" name="contact_phone"
                               value="{{ old('contact_phone', $page->contact_phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                            <input type="checkbox" name="contact_status" value="active"
                                   {{ $page->contact_status === 'active' ? 'checked' : '' }}
                                   class="mr-2 w-4 h-4">
                            Active
                        </label>
                    </div>
                </div>
            </div>

            {{-- FOOTER TAB --}}
            <div id="footer" class="tab-content p-8 {{ $currentTab == 'footer' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Logo Image</label>
                        <input type="file"
                               name="footer_logo_image"
                               accept="image/*"
                               data-preview="footer-logo-preview"
                               class="image-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                        <div class="mt-2">
                            @if($page->footer_logo_image)
                                <img id="footer-logo-preview"
                                     src="{{ asset('storage/'.$page->footer_logo_image) }}"
                                     class="w-32 h-16 object-contain rounded-lg border">
                            @else
                                <img id="footer-logo-preview"
                                     class="w-32 h-16 object-contain rounded-lg border hidden">
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Logo Text</label>
                        <input type="text" name="footer_logo_text"
                               value="{{ old('footer_logo_text', $page->footer_logo_text) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Logo Subtitle</label>
                        <input type="text" name="footer_logo_subtitle"
                               value="{{ old('footer_logo_subtitle', $page->footer_logo_subtitle) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Title Line 1</label>
                        <input type="text" name="footer_title_line1"
                               value="{{ old('footer_title_line1', $page->footer_title_line1) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Title Line 2</label>
                        <input type="text" name="footer_title_line2"
                               value="{{ old('footer_title_line2', $page->footer_title_line2) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Description</label>
                        <textarea name="footer_description" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">{{ old('footer_description', $page->footer_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount Badge Text</label>
                        <input type="text" name="footer_discount_badge_text"
                               value="{{ old('footer_discount_badge_text', $page->footer_discount_badge_text) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount Badge Subtext</label>
                        <input type="text" name="footer_discount_badge_subtext"
                               value="{{ old('footer_discount_badge_subtext', $page->footer_discount_badge_subtext) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Copyright</label>
                        <input type="text" name="footer_copyright"
                               value="{{ old('footer_copyright', $page->footer_copyright) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Powered By</label>
                        <input type="text" name="footer_powered_by"
                               value="{{ old('footer_powered_by', $page->footer_powered_by) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                            <input type="checkbox" name="footer_status" value="active"
                                   {{ $page->footer_status === 'active' ? 'checked' : '' }}
                                   class="mr-2 w-4 h-4">
                            Active
                        </label>
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 bg-gray-50 border-top border-gray-200">
                <button type="submit"
                        class="w-full md:w-auto bg-gradient-to-r from-primary to-secondary text-white px-8 py-3 rounded-xl hover:from-secondary hover:to-primary transition-all shadow-lg hover:shadow-xl font-medium flex items-center justify-center mx-auto md:ml-0">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
.scrollable-nav {
    scrollbar-width: thin;
    scrollbar-color: #3B82F6 #E5E7EB;
}

.scrollable-nav::-webkit-scrollbar {
    height: 6px;
}

.scrollable-nav::-webkit-scrollbar-track {
    background: #E5E7EB;
    border-radius: 3px;
}

.scrollable-nav::-webkit-scrollbar-thumb {
    background: #3B82F6;
    border-radius: 3px;
}

.scrollable-nav::-webkit-scrollbar-thumb:hover {
    background: #2563EB;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tab-link').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const tab = this.dataset.tab;

            document.getElementById('currentTabInput').value = tab;

            document.querySelectorAll('.tab-content').forEach(function (c) {
                c.classList.add('hidden');
            });
            document.querySelectorAll('.tab-link').forEach(function (t) {
                t.classList.remove('border-primary', 'text-primary');
                t.classList.add('border-transparent', 'text-gray-500');
            });

            document.getElementById(tab).classList.remove('hidden');
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-primary', 'text-primary');

            const url = new URL(window.location.href);
            url.searchParams.set('tab', tab);
            window.history.replaceState({}, '', url);
        });
    });

    document.querySelectorAll('.image-input').forEach(function (input) {
        input.addEventListener('change', function () {
            const previewId = this.dataset.preview;
            const previewEl = document.getElementById(previewId);
            if (!previewEl || !this.files || !this.files[0]) {
                return;
            }
            const reader = new FileReader();
            reader.onload = function (e) {
                previewEl.src = e.target.result;
                previewEl.classList.remove('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        });
    });

    // Client Logos Management - Updated Code
    const clientLogosInput = document.getElementById('clientsLogosInput');
    const newClientLogosPreview = document.getElementById('newClientLogosPreview');
    const clientLogosContainer = document.getElementById('clientLogosContainer');
    const removeClientIndexesInput = document.getElementById('removeClientIndexes');
    let removedIndexes = [];

    // Handle new file uploads preview
    if (clientLogosInput) {
        clientLogosInput.addEventListener('change', function() {
            newClientLogosPreview.innerHTML = '';
            
            if (this.files && this.files.length > 0) {
                Array.from(this.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'relative new-client-preview';
                        previewDiv.dataset.fileIndex = index;
                        previewDiv.innerHTML = `
                            <img src="${e.target.result}" class="w-20 h-20 object-contain rounded-lg border bg-white">
                            <p class="text-xs text-center mt-1 text-gray-600 truncate w-20" title="${file.name}">${file.name}</p>
                            <button type="button" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer text-xs hover:bg-red-700 remove-new-client" data-file-index="${index}">×</button>
                        `;
                        newClientLogosPreview.appendChild(previewDiv);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    }

    // Handle removing new uploaded files
    if (newClientLogosPreview) {
        newClientLogosPreview.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-new-client')) {
                e.preventDefault();
                const fileIndex = parseInt(e.target.dataset.fileIndex);
                const previewDiv = e.target.closest('.new-client-preview');
                
                // Remove preview
                previewDiv.remove();
                
                // Create new file input without the removed file
                if (clientLogosInput.files.length > 1) {
                    const dt = new DataTransfer();
                    Array.from(clientLogosInput.files).forEach((file, index) => {
                        if (index !== fileIndex) {
                            dt.items.add(file);
                        }
                    });
                    clientLogosInput.files = dt.files;
                    
                    // Refresh preview
                    clientLogosInput.dispatchEvent(new Event('change'));
                } else {
                    // If only one file, clear input
                    clientLogosInput.value = '';
                    newClientLogosPreview.innerHTML = '';
                }
            }
        });
    }

    // Handle removing existing client logos
    if (clientLogosContainer) {
        clientLogosContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-client-btn')) {
                e.preventDefault();
                const logoItem = e.target.closest('.client-logo-item');
                const index = parseInt(logoItem.dataset.index);
                
                // Add to removal list if not already there
                if (!removedIndexes.includes(index)) {
                    removedIndexes.push(index);
                    removeClientIndexesInput.value = removedIndexes.join(',');
                }
                
                // Hide the logo item with animation
                logoItem.style.opacity = '0.5';
                logoItem.style.transform = 'scale(0.8)';
                logoItem.style.transition = 'all 0.3s ease';
                
                // Change button to restore button
                e.target.innerHTML = '↻';
                e.target.className = 'absolute -top-2 -right-2 bg-green-600 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer text-xs hover:bg-green-700 restore-client-btn';
                e.target.title = 'Click to restore';
            } else if (e.target.classList.contains('restore-client-btn')) {
                e.preventDefault();
                const logoItem = e.target.closest('.client-logo-item');
                const index = parseInt(logoItem.dataset.index);
                
                // Remove from removal list
                removedIndexes = removedIndexes.filter(i => i !== index);
                removeClientIndexesInput.value = removedIndexes.join(',');
                
                // Restore the logo item
                logoItem.style.opacity = '1';
                logoItem.style.transform = 'scale(1)';
                
                // Change button back to remove button
                e.target.innerHTML = '×';
                e.target.className = 'absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer text-xs hover:bg-red-700 remove-client-btn';
                e.target.title = 'Click to remove';
            }
        });
    }

    const whyContainer = document.getElementById('whyCardsContainer');
    const addWhyCardBtn = document.getElementById('addWhyCardBtn');

    if (whyContainer && addWhyCardBtn) {
        addWhyCardBtn.addEventListener('click', function () {
            const items = whyContainer.querySelectorAll('.why-card-item');
            const index = items.length;
            const template = items[items.length - 1].cloneNode(true);

            template.dataset.index = index;
            template.querySelector('span.text-sm').textContent = 'Feature #' + (index + 1);
            template.querySelectorAll('input').forEach(function (input) {
                if (input.type === 'color') {
                    if (!input.name.endsWith('color_from[]') && !input.name.endsWith('color_to[]')) {
                        input.value = '';
                    }
                } else {
                    input.value = '';
                }
            });

            whyContainer.appendChild(template);
        });

        whyContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-why-card')) {
                const item = e.target.closest('.why-card-item');
                if (whyContainer.querySelectorAll('.why-card-item').length > 1) {
                    item.remove();
                }
            }
        });
    }

    const reviewsContainer = document.getElementById('reviewsContainer');
    const addReviewBtn = document.getElementById('addReviewBtn');

    if (reviewsContainer && addReviewBtn) {
        addReviewBtn.addEventListener('click', function () {
            const items = reviewsContainer.querySelectorAll('.review-item');
            const index = items.length;
            const template = items[items.length - 1].cloneNode(true);

            template.dataset.index = index;
            template.querySelector('span.text-sm').textContent = 'Review #' + (index + 1);

            template.querySelectorAll('input, textarea').forEach(function (input) {
                if (input.name.startsWith('reviews_avatar_existing')) {
                    input.value = '';
                } else if (input.type === 'number') {
                    input.value = 5;
                } else if (input.type === 'file') {
                    input.value = '';
                    if (input.name.startsWith('reviews_avatar[')) {
                        input.name = 'reviews_avatar[' + index + ']';
                    }
                } else {
                    input.value = '';
                }
            });

            reviewsContainer.appendChild(template);
        });

        reviewsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-review')) {
                const item = e.target.closest('.review-item');
                if (reviewsContainer.querySelectorAll('.review-item').length > 1) {
                    item.remove();
                }
            }
        });
    }

    // Form validation before submit
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
                submitButton.disabled = true;
                
                // Re-enable after 10 seconds as fallback
                setTimeout(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }, 10000);
            }
        });
    }

    // Auto-save functionality (optional)
    let autoSaveTimeout;
    const autoSaveInputs = document.querySelectorAll('input[type="text"], textarea');
    autoSaveInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Add visual indicator that changes are being saved
                const indicator = document.createElement('div');
                indicator.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg z-50 text-sm';
                indicator.innerHTML = '<i class="fas fa-check mr-2"></i>Changes detected';
                document.body.appendChild(indicator);
                
                setTimeout(() => {
                    indicator.remove();
                }, 2000);
            }, 1000);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Simple search and filter functionality
    function setupSearch(searchId, itemsSelector, nameAttribute = 'data-name') {
        const searchInput = document.getElementById(searchId);
        if (!searchInput) return;

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll(itemsSelector);
            
            items.forEach(item => {
                const name = item.getAttribute(nameAttribute) || '';
                if (name.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            updateCounts();
        });
    }

    // Setup filters for packages
    function setupPackageFilter() {
        const filter = document.getElementById('packagesFilter');
        if (!filter) return;

        filter.addEventListener('change', function() {
            const filterValue = this.value;
            const items = document.querySelectorAll('.package-item');
            
            items.forEach(item => {
                const pricing = item.getAttribute('data-pricing');
                
                if (!filterValue || 
                    (filterValue === 'monthly' && (pricing === 'monthly' || pricing === 'both')) ||
                    (filterValue === 'yearly' && (pricing === 'yearly' || pricing === 'both')) ||
                    (filterValue === 'both' && pricing === 'both')) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            updateCounts();
        });
    }

    // Setup select all/clear all functionality
    function setupSelectButtons(selectAllId, clearAllId, checkboxesSelector, countId) {
        const selectAllBtn = document.getElementById(selectAllId);
        const clearAllBtn = document.getElementById(clearAllId);
        
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll(checkboxesSelector + ':not([style*="display: none"])');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                updateCounts();
            });
        }
        
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll(checkboxesSelector);
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                updateCounts();
            });
        }
    }

    // Update selection counts
    function updateCounts() {
        // Services count
        const servicesChecked = document.querySelectorAll('input[name="selected_services[]"]:checked').length;
        const servicesTotal = document.querySelectorAll('.service-item:not([style*="display: none"])').length;
        const servicesCount = document.getElementById('servicesCount');
        if (servicesCount) servicesCount.textContent = servicesChecked;

        // Packages count
        const packagesChecked = document.querySelectorAll('input[name="selected_packages[]"]:checked').length;
        const packagesTotal = document.querySelectorAll('.package-item:not([style*="display: none"])').length;
        const packagesCount = document.getElementById('packagesCount');
        if (packagesCount) packagesCount.textContent = packagesChecked;

        // Products count
        const productsChecked = document.querySelectorAll('input[name="selected_products[]"]:checked').length;
        const productsTotal = document.querySelectorAll('.product-item:not([style*="display: none"])').length;
        const productsCount = document.getElementById('productsCount');
        if (productsCount) productsCount.textContent = productsChecked;

        // Shop Products count
        const shopProductsChecked = document.querySelectorAll('input[name="selected_shop_products[]"]:checked').length;
        const shopProductsTotal = document.querySelectorAll('.shop-product-item:not([style*="display: none"])').length;
        const shopProductsCount = document.getElementById('shopProductsCount');
        if (shopProductsCount) shopProductsCount.textContent = shopProductsChecked;
    }

    // Initialize all functionality
    setupSearch('servicesSearch', '.service-item');
    setupSearch('packagesSearch', '.package-item');
    setupSearch('productsSearch', '.product-item');
    setupSearch('shopProductsSearch', '.shop-product-item');

    setupPackageFilter();

    setupSelectButtons('selectAllServices', 'clearAllServices', 'input[name="selected_services[]"]', 'servicesCount');
    setupSelectButtons('selectAllPackages', 'clearAllPackages', 'input[name="selected_packages[]"]', 'packagesCount');
    setupSelectButtons('selectAllProducts', 'clearAllProducts', 'input[name="selected_products[]"]', 'productsCount');
    setupSelectButtons('selectAllShopProducts', 'clearAllShopProducts', 'input[name="selected_shop_products[]"]', 'shopProductsCount');

    // Listen for checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox' && (
            e.target.name === 'selected_services[]' || 
            e.target.name === 'selected_packages[]' || 
            e.target.name === 'selected_products[]' || 
            e.target.name === 'selected_shop_products[]'
        )) {
            updateCounts();
        }
    });

    // Initial count update
    updateCounts();

    // Log selections for debugging
    document.querySelector('form').addEventListener('submit', function() {
        const selections = {
            services: Array.from(document.querySelectorAll('input[name="selected_services[]"]:checked')).map(cb => cb.value),
            packages: Array.from(document.querySelectorAll('input[name="selected_packages[]"]:checked')).map(cb => cb.value),
            products: Array.from(document.querySelectorAll('input[name="selected_products[]"]:checked')).map(cb => cb.value),
            shopProducts: Array.from(document.querySelectorAll('input[name="selected_shop_products[]"]:checked')).map(cb => cb.value)
        };
        
        console.log('Form submitting with selections:', selections);
    });
});
</script>

@endpush
