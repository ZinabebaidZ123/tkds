@extends('admin.layouts.app')

@section('title', 'Service Page Content - ' . $service->title)
@section('page-title', 'Service Page Content')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.services.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.services.index') }}" class="hover:text-primary transition-colors duration-200">Services</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('admin.services.show', $service) }}" class="hover:text-primary transition-colors duration-200">{{ $service->title }}</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">Page Content</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">{{ $service->title }} - Page Content</h2>
                <p class="text-gray-600 text-sm mt-1">Manage the internal page content and layout</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ $service->getUrl() }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-external-link-alt mr-2"></i>
                Preview Page
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

    <!-- Form Container -->
    <form action="{{ route('admin.services.update-page-content', $service) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Hero Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-star mr-2 text-primary"></i>
                    Hero Section
                </h3>
            </div>
            <div class="p-6 space-y-6">
                
                <!-- Hero Title & Subtitle -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="hero_title" class="block text-sm font-semibold text-gray-700">Hero Title</label>
                        <input type="text" 
                               id="hero_title" 
                               name="hero_title" 
                               value="{{ old('hero_title', $service->hero_title) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="Main hero title">
                    </div>

                    <div class="space-y-2">
                        <label for="hero_subtitle" class="block text-sm font-semibold text-gray-700">Hero Subtitle</label>
                        <input type="text" 
                               id="hero_subtitle" 
                               name="hero_subtitle" 
                               value="{{ old('hero_subtitle', $service->hero_subtitle) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="Hero subtitle">
                    </div>
                </div>

                <!-- Hero Description -->
                <div class="space-y-2">
                    <label for="hero_description" class="block text-sm font-semibold text-gray-700">Hero Description</label>
                    <textarea id="hero_description" 
                              name="hero_description" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                              placeholder="Hero section description">{{ old('hero_description', $service->hero_description) }}</textarea>
                </div>

                <!-- Badge & Image -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="hero_badge_text" class="block text-sm font-semibold text-gray-700">Badge Text</label>
                        <input type="text" 
                               id="hero_badge_text" 
                               name="hero_badge_text" 
                               value="{{ old('hero_badge_text', $service->hero_badge_text) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="Badge text">
                    </div>

                    <div class="space-y-2">
                        <label for="hero_badge_color" class="block text-sm font-semibold text-gray-700">Badge Color</label>
                        <select id="hero_badge_color" 
                                name="hero_badge_color" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
                            <option value="primary" {{ old('hero_badge_color', $service->hero_badge_color) === 'primary' ? 'selected' : '' }}>Primary</option>
                            <option value="secondary" {{ old('hero_badge_color', $service->hero_badge_color) === 'secondary' ? 'selected' : '' }}>Secondary</option>
                            <option value="accent" {{ old('hero_badge_color', $service->hero_badge_color) === 'accent' ? 'selected' : '' }}>Accent</option>
                        </select>
                    </div>
                </div>

                <!-- Hero Image Upload -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Hero Image</label>
                    
                    @if($service->hero_image)
                        <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">Current Hero Image:</p>
                            <img src="{{ $service->getHeroImageUrl() }}" 
                                 alt="{{ $service->title }}"
                                 class="max-w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
                        </div>
                    @endif
                    
                    <div class="mt-1 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-primary transition-colors duration-300 bg-gray-50 hover:bg-primary/5">
                        <div class="space-y-4 text-center">
                            <div class="mx-auto h-16 w-16 text-gray-400">
                                <i class="fas fa-cloud-upload-alt text-4xl"></i>
                            </div>
                            <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                <label for="hero_image" class="relative cursor-pointer bg-white rounded-lg font-semibold text-primary hover:text-secondary focus-within:outline-none px-3 py-1 border border-primary/20">
                                    <span>Choose hero image</span>
                                    <input id="hero_image" name="hero_image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1 sm:pl-2 mt-1 sm:mt-0">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG up to 5MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content Editor -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-edit mr-2 text-primary"></i>
                    Page Content
                </h3>
            </div>
            <div class="p-6">
                <textarea id="page_content" 
                          name="page_content" 
                          rows="15"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none font-mono text-sm"
                          placeholder="Page content (HTML allowed)">{{ old('page_content', $service->page_content) }}</textarea>
                <p class="text-xs text-gray-500 mt-2">You can use HTML tags for formatting</p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-bullhorn mr-2 text-primary"></i>
                    Call to Action Section
                </h3>
            </div>
            <div class="p-6 space-y-6">
                
                <!-- CTA Title & Button Text -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="cta_title" class="block text-sm font-semibold text-gray-700">CTA Title</label>
                        <input type="text" 
                               id="cta_title" 
                               name="cta_title" 
                               value="{{ old('cta_title', $service->cta_title) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="Ready to Get Started?">
                    </div>

                    <div class="space-y-2">
                        <label for="cta_button_text" class="block text-sm font-semibold text-gray-700">Button Text</label>
                        <input type="text" 
                               id="cta_button_text" 
                               name="cta_button_text" 
                               value="{{ old('cta_button_text', $service->cta_button_text) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                               placeholder="Get Started Today">
                    </div>
                </div>

                <!-- CTA Description -->
                <div class="space-y-2">
                    <label for="cta_description" class="block text-sm font-semibold text-gray-700">CTA Description</label>
                    <textarea id="cta_description" 
                              name="cta_description" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none"
                              placeholder="Transform your business with our professional solutions.">{{ old('cta_description', $service->cta_description) }}</textarea>
                </div>

                <!-- CTA Button Link -->
                <div class="space-y-2">
                    <label for="cta_button_link" class="block text-sm font-semibold text-gray-700">Button Link</label>
                    <input type="text" 
                           id="cta_button_link" 
                           name="cta_button_link" 
                           value="{{ old('cta_button_link', $service->cta_button_link) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200"
                           placeholder="/contact">
                    <p class="text-xs text-gray-500">Leave empty to use default contact link</p>
                </div>
            </div>
        </div>

        <!-- Key Features Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-orange-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-star mr-2 text-primary"></i>
                    Key Features
                </h3>
            </div>
            <div class="p-6">
                <div id="keyFeaturesContainer" class="space-y-4">
                    @if($service->getKeyFeatures())
                        @foreach($service->getKeyFeatures() as $index => $feature)
                            <div class="feature-item bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                                    <input type="text" 
                                           name="key_features[{{ $index }}][icon]" 
                                           value="{{ $feature['icon'] ?? '' }}"
                                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                           placeholder="fas fa-star">
                                    <input type="text" 
                                           name="key_features[{{ $index }}][title]" 
                                           value="{{ $feature['title'] ?? '' }}"
                                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                           placeholder="Feature Title">
                                    <div class="flex space-x-2">
                                        <select name="key_features[{{ $index }}][color_from]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            <option value="primary" {{ ($feature['color_from'] ?? '') === 'primary' ? 'selected' : '' }}>Primary</option>
                                            <option value="secondary" {{ ($feature['color_from'] ?? '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                            <option value="accent" {{ ($feature['color_from'] ?? '') === 'accent' ? 'selected' : '' }}>Accent</option>
                                        </select>
                                        <select name="key_features[{{ $index }}][color_to]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            <option value="secondary" {{ ($feature['color_to'] ?? '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                            <option value="primary" {{ ($feature['color_to'] ?? '') === 'primary' ? 'selected' : '' }}>Primary</option>
                                            <option value="accent" {{ ($feature['color_to'] ?? '') === 'accent' ? 'selected' : '' }}>Accent</option>
                                        </select>
                                    </div>
                                </div>
                                <textarea name="key_features[{{ $index }}][description]" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none mb-3"
                                          placeholder="Feature description">{{ $feature['description'] ?? '' }}</textarea>
                                <button type="button" onclick="removeFeature(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i>Remove Feature
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" onclick="addKeyFeature()" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>Add Key Feature
                </button>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-teal-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-check-circle mr-2 text-primary"></i>
                    Benefits
                </h3>
            </div>
            <div class="p-6">
                <div id="benefitsContainer" class="space-y-4">
                    @if($service->getBenefits())
                        @foreach($service->getBenefits() as $index => $benefit)
                            <div class="benefit-item bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                                    <input type="text" 
                                           name="benefits[{{ $index }}][icon]" 
                                           value="{{ $benefit['icon'] ?? '' }}"
                                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                           placeholder="fas fa-rocket">
                                    <input type="text" 
                                           name="benefits[{{ $index }}][title]" 
                                           value="{{ $benefit['title'] ?? '' }}"
                                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                           placeholder="Benefit Title">
                                    <div class="flex space-x-2">
                                        <select name="benefits[{{ $index }}][color_from]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            <option value="primary" {{ ($benefit['color_from'] ?? '') === 'primary' ? 'selected' : '' }}>Primary</option>
                                            <option value="secondary" {{ ($benefit['color_from'] ?? '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                            <option value="accent" {{ ($benefit['color_from'] ?? '') === 'accent' ? 'selected' : '' }}>Accent</option>
                                        </select>
                                        <select name="benefits[{{ $index }}][color_to]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            <option value="secondary" {{ ($benefit['color_to'] ?? '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                            <option value="primary" {{ ($benefit['color_to'] ?? '') === 'primary' ? 'selected' : '' }}>Primary</option>
                                            <option value="accent" {{ ($benefit['color_to'] ?? '') === 'accent' ? 'selected' : '' }}>Accent</option>
                                        </select>
                                    </div>
                                </div>
                                <textarea name="benefits[{{ $index }}][description]" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none mb-3"
                                          placeholder="Benefit description">{{ $benefit['description'] ?? '' }}</textarea>
                                <button type="button" onclick="removeBenefit(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i>Remove Benefit
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" onclick="addBenefit()" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>Add Benefit
                </button>
            </div>
        </div>

        <!-- Use Cases Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-lightbulb mr-2 text-primary"></i>
                    Use Cases
                </h3>
            </div>
            <div class="p-6">
                <div id="useCasesContainer" class="space-y-4">
                    @if($service->getUseCases())
                        @foreach($service->getUseCases() as $index => $useCase)
                            <div class="use-case-item bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                                    <input type="text" 
                                           name="use_cases[{{ $index }}][icon]" 
                                           value="{{ $useCase['icon'] ?? '' }}"
                                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                           placeholder="fas fa-building">
                                    <input type="text" 
                                           name="use_cases[{{ $index }}][title]" 
                                           value="{{ $useCase['title'] ?? '' }}"
                                           class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                           placeholder="Use Case Title">
                                    <div class="flex space-x-2">
                                        <select name="use_cases[{{ $index }}][color_from]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            <option value="primary" {{ ($useCase['color_from'] ?? '') === 'primary' ? 'selected' : '' }}>Primary</option>
                                            <option value="secondary" {{ ($useCase['color_from'] ?? '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                            <option value="accent" {{ ($useCase['color_from'] ?? '') === 'accent' ? 'selected' : '' }}>Accent</option>
                                        </select>
                                        <select name="use_cases[{{ $index }}][color_to]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            <option value="secondary" {{ ($useCase['color_to'] ?? '') === 'secondary' ? 'selected' : '' }}>Secondary</option>
                                            <option value="primary" {{ ($useCase['color_to'] ?? '') === 'primary' ? 'selected' : '' }}>Primary</option>
                                            <option value="accent" {{ ($useCase['color_to'] ?? '') === 'accent' ? 'selected' : '' }}>Accent</option>
                                        </select>
                                    </div>
                                </div>
                                <textarea name="use_cases[{{ $index }}][description]" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none mb-3"
                                          placeholder="Use case description">{{ $useCase['description'] ?? '' }}</textarea>
                                <button type="button" onclick="removeUseCase(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    <i class="fas fa-trash mr-1"></i>Remove Use Case
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" onclick="addUseCase()" class="mt-4 inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>Add Use Case
                </button>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6">
            <a href="{{ route('admin.services.show', $service) }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Page Content
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let featureIndex = {{ count($service->getKeyFeatures()) }};
let benefitIndex = {{ count($service->getBenefits()) }};
let useCaseIndex = {{ count($service->getUseCases()) }};

function addKeyFeature() {
    const container = document.getElementById('keyFeaturesContainer');
    const newFeature = document.createElement('div');
    newFeature.className = 'feature-item bg-gray-50 p-4 rounded-lg border border-gray-200';
    newFeature.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            <input type="text" 
                   name="key_features[${featureIndex}][icon]" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                   placeholder="fas fa-star">
            <input type="text" 
                   name="key_features[${featureIndex}][title]" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                   placeholder="Feature Title">
            <div class="flex space-x-2">
                <select name="key_features[${featureIndex}][color_from]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="accent">Accent</option>
                </select>
                <select name="key_features[${featureIndex}][color_to]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="secondary">Secondary</option>
                    <option value="primary">Primary</option>
                    <option value="accent">Accent</option>
                </select>
            </div>
        </div>
        <textarea name="key_features[${featureIndex}][description]" 
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none mb-3"
                  placeholder="Feature description"></textarea>
        <button type="button" onclick="removeFeature(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">
            <i class="fas fa-trash mr-1"></i>Remove Feature
        </button>
    `;
    container.appendChild(newFeature);
    featureIndex++;
}

function addBenefit() {
    const container = document.getElementById('benefitsContainer');
    const newBenefit = document.createElement('div');
    newBenefit.className = 'benefit-item bg-gray-50 p-4 rounded-lg border border-gray-200';
    newBenefit.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            <input type="text" 
                   name="benefits[${benefitIndex}][icon]" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                   placeholder="fas fa-rocket">
            <input type="text" 
                   name="benefits[${benefitIndex}][title]" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                   placeholder="Benefit Title">
            <div class="flex space-x-2">
                <select name="benefits[${benefitIndex}][color_from]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="accent">Accent</option>
                </select>
                <select name="benefits[${benefitIndex}][color_to]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="secondary">Secondary</option>
                    <option value="primary">Primary</option>
                    <option value="accent">Accent</option>
                </select>
            </div>
        </div>
        <textarea name="benefits[${benefitIndex}][description]" 
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none mb-3"
                  placeholder="Benefit description"></textarea>
        <button type="button" onclick="removeBenefit(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">
            <i class="fas fa-trash mr-1"></i>Remove Benefit
        </button>
    `;
    container.appendChild(newBenefit);
    benefitIndex++;
}

function addUseCase() {
    const container = document.getElementById('useCasesContainer');
    const newUseCase = document.createElement('div');
    newUseCase.className = 'use-case-item bg-gray-50 p-4 rounded-lg border border-gray-200';
    newUseCase.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            <input type="text" 
                   name="use_cases[${useCaseIndex}][icon]" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                   placeholder="fas fa-building">
            <input type="text" 
                   name="use_cases[${useCaseIndex}][title]" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                   placeholder="Use Case Title">
            <div class="flex space-x-2">
                <select name="use_cases[${useCaseIndex}][color_from]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="accent">Accent</option>
                </select>
                <select name="use_cases[${useCaseIndex}][color_to]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="secondary">Secondary</option>
                    <option value="primary">Primary</option>
                    <option value="accent">Accent</option>
                </select>
            </div>
        </div>
        <textarea name="use_cases[${useCaseIndex}][description]" 
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none mb-3"
                  placeholder="Use case description"></textarea>
        <button type="button" onclick="removeUseCase(this)" class="text-red-600 hover:text-red-800 text-sm font-medium">
            <i class="fas fa-trash mr-1"></i>Remove Use Case
        </button>
    `;
    container.appendChild(newUseCase);
    useCaseIndex++;
}

function removeFeature(button) {
    button.closest('.feature-item').remove();
}

function removeBenefit(button) {
    button.closest('.benefit-item').remove();
}

function removeUseCase(button) {
    button.closest('.use-case-item').remove();
}
</script>
@endpush