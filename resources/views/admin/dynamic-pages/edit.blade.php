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
        <div class="border-b border-gray-200 overflow-x-auto">
            <nav class="-mb-px flex space-x-6 px-4" aria-label="Tabs">
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
                    <i class="fas fa-shopping-bag w-5 h-5 mr-2 {{ $currentTab == 'products' ? 'text-primary' : 'text-gray-400' }}"></i>
                    Products
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                <div class="mt-6 p-4 bg-blue-50 rounded-xl">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Manage services items from
                        <a href="{{ route('admin.services.index') }}" class="text-blue-600 hover:underline">
                            Services Management
                        </a>
                    </p>
                </div>
            </div>

            {{-- PACKAGES TAB --}}
            <div id="packages" class="tab-content p-8 {{ $currentTab == 'packages' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
            </div>

            {{-- PRODUCTS TAB --}}
            <div id="products" class="tab-content p-8 {{ $currentTab == 'products' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Products Title</label>
                        <input type="text" name="products_title"
                               value="{{ old('products_title', $page->products_title) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Products Subtitle</label>
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
            </div>

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
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
                        <input type="text" name="video_url"
                               value="{{ old('video_url', $page->video_url) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary">
                    </div>
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
                    </div>
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

            {{-- CLIENTS TAB --}}
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
</script>
@endpush
