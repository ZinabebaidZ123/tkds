@extends('admin.layouts.app')

@section('title', 'Edit Section - Sales Page')
@section('page-title', 'Edit Sales Page Section')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Section</h1>
            <p class="mt-2 text-gray-600">{{ $section->section_title }} - {{ ucfirst(str_replace('_', ' ', $section->section_type)) }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.occasions.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
            <a href="{{ route('occasions') }}" target="_blank"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-external-link-alt mr-2"></i>
                Preview Page
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    @if(session('warning'))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Warning!</strong>
        <span class="block sm:inline">{{ session('warning') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Validation Errors:</strong>
        <ul class="mt-2">
            @foreach($errors->all() as $error)
            <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900 mr-4"></div>
            <span>Processing...</span>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.occasions.update', $section->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="editForm">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Section Type -->
                <div>
                    <label for="section_type" class="block text-sm font-medium text-gray-700">Section Type</label>
                    <select id="section_type" name="section_type" required 
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                        @foreach($sectionTypes as $value => $label)
                        <option value="{{ $value }}" {{ $section->section_type == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Section Title -->
                <div>
                    <label for="section_title" class="block text-sm font-medium text-gray-700">Section Title</label>
                    <input type="text" id="section_title" name="section_title" required
                           value="{{ old('section_title', $section->section_title) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>

                <!-- Section Subtitle -->
                <div class="md:col-span-2">
                    <label for="section_subtitle" class="block text-sm font-medium text-gray-700">Section Subtitle</label>
                    <input type="text" id="section_subtitle" name="section_subtitle"
                           value="{{ old('section_subtitle', $section->section_subtitle) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" min="0"
                           value="{{ old('sort_order', $section->sort_order) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Active (Section will be visible on the frontend)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Data -->
        <div class="bg-white rounded-lg shadow p-6" id="content-editor">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Content Settings</h3>
            <div id="content-fields">
                <!-- Content fields will be loaded here based on section type -->
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 bg-white rounded-lg shadow p-6">
            <a href="{{ route('admin.occasions.index') }}"
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                Cancel
            </a>
            <button type="submit" id="submitBtn"
                    class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-save mr-2"></i>
                Update Section
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Global variables
let formSubmitting = false;
const currentSection = @json($section);
const contentData = @json($section->content_data ?? []);

console.log('Section data loaded:', currentSection);
console.log('Content data loaded:', contentData);

// Enhanced error logging function
function logError(message, data = null) {
    console.error('[OccasionEdit] ' + message, data);
}

// Enhanced showAlert function with better styling and logging
function showAlert(message, type = 'info', duration = 5000) {
    console.log(`[OccasionEdit] Alert: ${type} - ${message}`);
    
    // Create alert element
    const alert = document.createElement('div');
    alert.className = `fixed top-4 right-4 p-4 rounded-lg shadow-xl z-50 transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
        type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
        type === 'warning' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' :
        'bg-blue-100 text-blue-800 border border-blue-200'
    }`;
    
    alert.innerHTML = `
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-${
                    type === 'success' ? 'check-circle' : 
                    type === 'error' ? 'exclamation-circle' : 
                    type === 'warning' ? 'exclamation-triangle' : 
                    'info-circle'
                } mr-2 text-lg"></i>
                <span class="font-medium">${message}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" 
                    class="ml-4 text-lg hover:opacity-75 transition-opacity">&times;</button>
        </div>
    `;
    
    document.body.appendChild(alert);
    
    // Animate in
    setTimeout(() => {
        alert.style.transform = 'translateX(0)';
    }, 10);
    
    // Auto remove
    setTimeout(() => {
        if (alert.parentNode) {
            alert.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 300);
        }
    }, duration);
}

// Enhanced form submission with better error handling
document.addEventListener('DOMContentLoaded', function() {
    console.log('[OccasionEdit] DOM Content Loaded');
    
    const form = document.getElementById('editForm');
    const submitBtn = document.getElementById('submitBtn');
    const loadingIndicator = document.getElementById('loadingIndicator');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            if (formSubmitting) {
                e.preventDefault();
                showAlert('Form is already being submitted. Please wait...', 'warning');
                return;
            }
            
            formSubmitting = true;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            loadingIndicator.classList.remove('hidden');
            
            console.log('[OccasionEdit] Form submission started');
            
            // Add timeout to reset if something goes wrong
            setTimeout(() => {
                if (formSubmitting) {
                    formSubmitting = false;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Update Section';
                    loadingIndicator.classList.add('hidden');
                    showAlert('Form submission timed out. Please try again.', 'error');
                    logError('Form submission timeout');
                }
            }, 30000); // 30 second timeout
        });
        
        console.log('[OccasionEdit] Form event listener attached');
    } else {
        logError('Form or submit button not found', {
            form: !!form,
            submitBtn: !!submitBtn
        });
    }
    
    // Load content fields and populate with existing data
    const sectionTypeSelect = document.getElementById('section_type');
    if (sectionTypeSelect) {
        // Load initial content fields
        loadContentFields(sectionTypeSelect.value);
        
        // Reload content fields when section type changes
        sectionTypeSelect.addEventListener('change', function() {
            console.log('[OccasionEdit] Section type changed to:', this.value);
            loadContentFields(this.value);
        });
        
        console.log('[OccasionEdit] Section type select event listener attached');
    } else {
        logError('Section type select not found');
    }
});

// Load content fields based on section type
function loadContentFields(sectionType) {
    try {
        console.log('[OccasionEdit] Loading content fields for:', sectionType);
        
        const contentContainer = document.getElementById('content-fields');
        if (!contentContainer) {
            logError('Content container not found');
            return;
        }
        
        contentContainer.innerHTML = '';

        switch(sectionType) {
            case 'header':
                contentContainer.innerHTML = getHeaderFields();
                break;
            case 'hero':
                contentContainer.innerHTML = getHeroFields();
                break;
            case 'why_choose':
                contentContainer.innerHTML = getWhyChooseFields();
                break;
            case 'services':
                contentContainer.innerHTML = getServicesFields();
                break;
            case 'packages':
                contentContainer.innerHTML = getPackagesFields();
                break;
            case 'products':
                contentContainer.innerHTML = getProductsFields();
                break;
            case 'video':
                contentContainer.innerHTML = getVideoFields();
                break;
            case 'clients':
                contentContainer.innerHTML = getClientsFields();
                break;
            case 'reviews':
                contentContainer.innerHTML = getReviewsFields();
                break;
            case 'contact':
                contentContainer.innerHTML = getContactFields();
                break;
            case 'footer':
                contentContainer.innerHTML = getFooterFields();
                break;
            default:
                contentContainer.innerHTML = getGenericFields();
                break;
        }
        
        // Populate fields with existing data
        setTimeout(() => {
            populateFields();
        }, 100);
        
        console.log('[OccasionEdit] Content fields loaded successfully for:', sectionType);
        
    } catch (error) {
        logError('Error loading content fields', {
            sectionType: sectionType,
            error: error.message
        });
        showAlert('Error loading content fields: ' + error.message, 'error');
    }
}

// Header fields - Complete form
function getHeaderFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Logo Text</label>
                    <input type="text" name="content[logo_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">Main logo text (e.g., "TKDS")</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Logo Subtitle</label>
                    <input type="text" name="content[logo_subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">Text below logo (e.g., "SHAPING THE WORLD")</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Logo Image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-image mx-auto h-12 w-12 text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="logo_image" class="relative cursor-pointer bg-white rounded-md font-medium text-red-600 hover:text-red-500">
                                    <span>Upload logo image</span>
                                    <input id="logo_image" name="content[logo_image]" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or leave empty to use text</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, SVG up to 10MB</p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Call Button Text</label>
                    <input type="text" name="content[call_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="content[phone_number]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="content[show_call_button]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Show Call Button</label>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Hero fields - Complete form
function getHeroFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (First Part)</label>
                    <input type="text" name="content[main_title_part1]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "BLACK"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (Second Part - Colored)</label>
                    <input type="text" name="content[main_title_part2]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "Sale" (will be colored)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (Third Part)</label>
                    <input type="text" name="content[main_title_part3]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "FRIDAY"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle (Colored)</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "Expand Your TV Network" (will be colored)</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="content[description]" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount Percentage</label>
                    <input type="number" name="content[discount_percentage]" min="0" max="100"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Text</label>
                    <input type="text" name="content[cta_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Link</label>
                    <input type="text" name="content[cta_button_link]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Countdown End Date</label>
                    <input type="datetime-local" name="content[countdown_end_date]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center">
                        <input type="checkbox" name="content[countdown_enabled]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Enable Countdown Timer</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="content[floating_elements]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Show Floating Elements</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="content[wave_badge]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Show Wave Badge</label>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Why choose fields - Complete form with features management
function getWhyChooseFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (First Part)</label>
                    <input type="text" name="content[main_title_part1]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "WHY CHOOSE"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (Second Part - Colored)</label>
                    <input type="text" name="content[main_title_part2]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "TKDS" (will be colored)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle (Colored)</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "UNMATCHED EXCELLENCE"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Image URL</label>
                    <input type="url" name="content[main_image]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Text</label>
                    <input type="text" name="content[cta_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Link</label>
                    <input type="text" name="content[cta_button_link]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>

            <!-- Features Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Features</h4>
                    <button type="button" onclick="addFeature()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Feature
                    </button>
                </div>
                <div id="features-container">
                    <!-- Features will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Services fields - Complete form
function getServicesFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "PREMIUM SERVICES"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Services Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Services</h4>
                    <button type="button" onclick="addService()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Service
                    </button>
                </div>
                <div id="services-container">
                    <!-- Services will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Packages fields - Complete form
// Packages fields - Complete form
function getPackagesFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "EXPLOSIVE PACKAGES"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Packages Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Packages</h4>
                    <button type="button" onclick="addPackage()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Package
                    </button>
                </div>
                <div id="packages-container">
                    <!-- Packages will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Products fields - Complete form
function getProductsFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "FEATURED PRODUCTS"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Products Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Products</h4>
                    <button type="button" onclick="addProduct()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Product
                    </button>
                </div>
                <div id="products-container">
                    <!-- Products will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Video fields - Complete form
function getVideoFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "SEE MAGIC IN ACTION"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Video Title</label>
                    <input type="text" name="content[video_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <textarea name="content[subtitle]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Video Description</label>
                    <textarea name="content[video_description]" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Video URL</label>
                    <input type="url" name="content[video_url]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Video Thumbnail URL</label>
                    <input type="url" name="content[video_thumbnail]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Play Button Text</label>
                    <input type="text" name="content[play_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
        </div>
    `;
}

// Clients fields - Complete form
function getClientsFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "TRUSTED BY GIANTS"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Clients Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Client Logos</h4>
                    <button type="button" onclick="addClient()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Client
                    </button>
                </div>
                <div id="clients-container">
                    <!-- Clients will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Reviews fields - Complete form
function getReviewsFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (First Part)</label>
                    <input type="text" name="content[main_title_part1]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "WHAT CLIENTS"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (Second Part - Colored)</label>
                    <input type="text" name="content[main_title_part2]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "SAY" (will be colored)</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <textarea name="content[subtitle]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
            </div>
            
            <!-- Reviews Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Customer Reviews</h4>
                    <button type="button" onclick="addReview()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Review
                    </button>
                </div>
                <div id="reviews-container">
                    <!-- Reviews will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Contact fields - Complete form
function getContactFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                    <input type="tel" name="content[whatsapp_number]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="content[email]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Text</label>
                    <input type="text" name="content[cta_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <textarea name="content[subtitle]" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="content[form_enabled]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Enable Contact Form</label>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Contact Information Items</h4>
                    <button type="button" onclick="addContactInfo()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Contact Info
                    </button>
                </div>
                <div id="contact-info-container">
                    <!-- Contact info will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Footer fields - Complete form
function getFooterFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Logo Text</label>
                    <input type="text" name="content[logo_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Logo Subtitle</label>
                    <input type="text" name="content[logo_subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Marketing Title</label>
                    <input type="text" name="content[marketing_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount Badge Text</label>
                    <input type="text" name="content[discount_badge]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount Sub Text</label>
                    <input type="text" name="content[discount_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "LIMITED TIME"</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Marketing Subtitle</label>
                    <textarea name="content[marketing_subtitle]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Copyright Text</label>
                    <input type="text" name="content[copyright_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Powered By Text</label>
                    <input type="text" name="content[powered_by]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Social Links Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Social Links</h4>
                    <button type="button" onclick="addSocialLink()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Social Link
                    </button>
                </div>
                <div id="social-links-container">
                    <!-- Social links will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Generic fields for unknown section types
function getGenericFields() {
    return `
        <div class="space-y-6">
            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                <p class="text-yellow-800 text-sm">
                    <i class="fas fa-info-circle mr-1"></i>
                    This section type doesn't have specific content fields defined. You can add custom content through the database or extend the controller.
                </p>
            </div>
        </div>
    `;
}

// Enhanced populate fields function
function populateFields() {
    try {
        if (!contentData) {
            console.log('[OccasionEdit] No content data to populate');
            return;
        }
        
        console.log('[OccasionEdit] Populating fields with data:', contentData);
        let fieldsPopulated = 0;

        Object.keys(contentData).forEach(key => {
            const input = document.querySelector(`[name="content[${key}]"]`);
            if (input) {
                try {
                    if (input.type === 'checkbox') {
                        input.checked = contentData[key] === true || contentData[key] === 1 || contentData[key] === '1';
                    } else if (input.type === 'datetime-local') {
                        if (contentData[key]) {
                            const date = new Date(contentData[key]);
                            if (!isNaN(date.getTime())) {
                                input.value = date.toISOString().slice(0, 16);
                            }
                        }
                    } else {
                        input.value = contentData[key] || '';
                    }
                    fieldsPopulated++;
                } catch (fieldError) {
                    logError(`Error populating field ${key}`, {
                        key: key,
                        value: contentData[key],
                        input: input,
                        error: fieldError.message
                    });
                }
            }
        });
        
        // Populate complex fields based on section type
        if (currentSection.section_type === 'hero' && contentData.main_title) {
            // Split the main title for hero section
            const titleParts = contentData.main_title.split(' ');
            if (titleParts.length >= 3) {
                setValue('content[main_title_part1]', titleParts[0]);
                setValue('content[main_title_part2]', titleParts[1]);
                setValue('content[main_title_part3]', titleParts.slice(2).join(' '));
            }
        }
        
        console.log(`[OccasionEdit] Populated ${fieldsPopulated} fields`);
        
    } catch (error) {
        logError('Error populating fields', {
            error: error.message,
            contentData: contentData
        });
        showAlert('Error populating form fields: ' + error.message, 'error');
    }
}

// Utility function to set field value safely
function setValue(fieldName, value) {
    const field = document.querySelector(`[name="${fieldName}"]`);
    if (field && value !== undefined && value !== null) {
        field.value = value;
    }
}

// Dynamic content management functions
function addFeature() {
    const container = document.getElementById('features-container');
    const featureIndex = container.children.length;
    
    const featureHTML = `
        <div class="feature-item bg-gray-50 p-4 rounded-lg border mb-4" data-index="${featureIndex}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Icon Class</label>
                    <input type="text" name="content[features][${featureIndex}][icon]" 
                           placeholder="e.g., fas fa-rocket"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="content[features][${featureIndex}][title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="content[features][${featureIndex}][description]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" onclick="removeFeature(${featureIndex})" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', featureHTML);
}

function removeFeature(index) {
    const item = document.querySelector(`.feature-item[data-index="${index}"]`);
    if (item) {
        item.remove();
    }
}

console.log('[OccasionEdit] Script loaded successfully');

</script>
@endpush


@push('scripts')
<script>
// Global variables
let formSubmitting = false;
const currentSection = @json($section);
const contentData = @json($section->content_data ?? []);

console.log('Section data loaded:', currentSection);
console.log('Content data loaded:', contentData);

// Enhanced error logging function
function logError(message, data = null) {
    console.error('[OccasionEdit] ' + message, data);
}

// Enhanced showAlert function with better styling and logging
function showAlert(message, type = 'info', duration = 5000) {
    console.log(`[OccasionEdit] Alert: ${type} - ${message}`);
    
    // Create alert element
    const alert = document.createElement('div');
    alert.className = `fixed top-4 right-4 p-4 rounded-lg shadow-xl z-50 transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
        type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
        type === 'warning' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' :
        'bg-blue-100 text-blue-800 border border-blue-200'
    }`;
    
    alert.innerHTML = `
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-${
                    type === 'success' ? 'check-circle' : 
                    type === 'error' ? 'exclamation-circle' : 
                    type === 'warning' ? 'exclamation-triangle' : 
                    'info-circle'
                } mr-2 text-lg"></i>
                <span class="font-medium">${message}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" 
                    class="ml-4 text-lg hover:opacity-75 transition-opacity">&times;</button>
        </div>
    `;
    
    document.body.appendChild(alert);
    
    // Animate in
    setTimeout(() => {
        alert.style.transform = 'translateX(0)';
    }, 10);
    
    // Auto remove
    setTimeout(() => {
        if (alert.parentNode) {
            alert.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 300);
        }
    }, duration);
}

// Enhanced form submission with better error handling
document.addEventListener('DOMContentLoaded', function() {
    console.log('[OccasionEdit] DOM Content Loaded');
    
    const form = document.getElementById('editForm');
    const submitBtn = document.getElementById('submitBtn');
    const loadingIndicator = document.getElementById('loadingIndicator');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            if (formSubmitting) {
                e.preventDefault();
                showAlert('Form is already being submitted. Please wait...', 'warning');
                return;
            }
            
            formSubmitting = true;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            loadingIndicator.classList.remove('hidden');
            
            console.log('[OccasionEdit] Form submission started');
            
            // Add timeout to reset if something goes wrong
            setTimeout(() => {
                if (formSubmitting) {
                    formSubmitting = false;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Update Section';
                    loadingIndicator.classList.add('hidden');
                    showAlert('Form submission timed out. Please try again.', 'error');
                    logError('Form submission timeout');
                }
            }, 30000); // 30 second timeout
        });
        
        console.log('[OccasionEdit] Form event listener attached');
    } else {
        logError('Form or submit button not found', {
            form: !!form,
            submitBtn: !!submitBtn
        });
    }
    
    // Load content fields and populate with existing data
    const sectionTypeSelect = document.getElementById('section_type');
    if (sectionTypeSelect) {
        // Load initial content fields
        loadContentFields(sectionTypeSelect.value);
        
        // Reload content fields when section type changes
        sectionTypeSelect.addEventListener('change', function() {
            console.log('[OccasionEdit] Section type changed to:', this.value);
            loadContentFields(this.value);
        });
        
        console.log('[OccasionEdit] Section type select event listener attached');
    } else {
        logError('Section type select not found');
    }
});

// Load content fields based on section type
function loadContentFields(sectionType) {
    try {
        console.log('[OccasionEdit] Loading content fields for:', sectionType);
        
        const contentContainer = document.getElementById('content-fields');
        if (!contentContainer) {
            logError('Content container not found');
            return;
        }
        
        contentContainer.innerHTML = '';

        switch(sectionType) {
            case 'header':
                contentContainer.innerHTML = getHeaderFields();
                break;
            case 'hero':
                contentContainer.innerHTML = getHeroFields();
                break;
            case 'why_choose':
                contentContainer.innerHTML = getWhyChooseFields();
                break;
            case 'services':
                contentContainer.innerHTML = getServicesFields();
                break;
            case 'packages':
                contentContainer.innerHTML = getPackagesFields();
                break;
            case 'products':
                contentContainer.innerHTML = getProductsFields();
                break;
            case 'video':
                contentContainer.innerHTML = getVideoFields();
                break;
            case 'clients':
                contentContainer.innerHTML = getClientsFields();
                break;
            case 'reviews':
                contentContainer.innerHTML = getReviewsFields();
                break;
            case 'contact':
                contentContainer.innerHTML = getContactFields();
                break;
            case 'footer':
                contentContainer.innerHTML = getFooterFields();
                break;
            default:
                contentContainer.innerHTML = getGenericFields();
                break;
        }
        
        // Populate fields with existing data
        setTimeout(() => {
            populateFields();
        }, 100);
        
        console.log('[OccasionEdit] Content fields loaded successfully for:', sectionType);
        
    } catch (error) {
        logError('Error loading content fields', {
            sectionType: sectionType,
            error: error.message
        });
        showAlert('Error loading content fields: ' + error.message, 'error');
    }
}

// Header fields - Complete form
function getHeaderFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Logo Text</label>
                    <input type="text" name="content[logo_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">Main logo text (e.g., "TKDS")</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Logo Subtitle</label>
                    <input type="text" name="content[logo_subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">Text below logo (e.g., "SHAPING THE WORLD")</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Logo Image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-image mx-auto h-12 w-12 text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="logo_image" class="relative cursor-pointer bg-white rounded-md font-medium text-red-600 hover:text-red-500">
                                    <span>Upload logo image</span>
                                    <input id="logo_image" name="content[logo_image]" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or leave empty to use text</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, SVG up to 10MB</p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Call Button Text</label>
                    <input type="text" name="content[call_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="content[phone_number]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="content[show_call_button]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Show Call Button</label>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Hero fields - Complete form
function getHeroFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (First Part)</label>
                    <input type="text" name="content[main_title_part1]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "BLACK"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (Second Part - Colored)</label>
                    <input type="text" name="content[main_title_part2]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "Sale" (will be colored)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (Third Part)</label>
                    <input type="text" name="content[main_title_part3]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "FRIDAY"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle (Colored)</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "Expand Your TV Network" (will be colored)</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="content[description]" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount Percentage</label>
                    <input type="number" name="content[discount_percentage]" min="0" max="100"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Text</label>
                    <input type="text" name="content[cta_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Link</label>
                    <input type="text" name="content[cta_button_link]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Countdown End Date</label>
                    <input type="datetime-local" name="content[countdown_end_date]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center">
                        <input type="checkbox" name="content[countdown_enabled]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Enable Countdown Timer</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="content[floating_elements]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Show Floating Elements</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="content[wave_badge]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Show Wave Badge</label>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Why choose fields - Complete form with features management
function getWhyChooseFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (First Part)</label>
                    <input type="text" name="content[main_title_part1]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "WHY CHOOSE"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (Second Part - Colored)</label>
                    <input type="text" name="content[main_title_part2]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "TKDS" (will be colored)</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle (Colored)</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "UNMATCHED EXCELLENCE"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Image URL</label>
                    <input type="url" name="content[main_image]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Text</label>
                    <input type="text" name="content[cta_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Link</label>
                    <input type="text" name="content[cta_button_link]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>

            <!-- Features Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Features</h4>
                    <button type="button" onclick="addFeature()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Feature
                    </button>
                </div>
                <div id="features-container">
                    <!-- Features will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Services fields - Complete form
function getServicesFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "PREMIUM SERVICES"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Services Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Services</h4>
                    <button type="button" onclick="addService()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Service
                    </button>
                </div>
                <div id="services-container">
                    <!-- Services will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Packages fields - Complete form
function getPackagesFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "EXPLOSIVE PACKAGES"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Packages Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Packages</h4>
                    <button type="button" onclick="addPackage()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Package
                    </button>
                </div>
                <div id="packages-container">
                    <!-- Packages will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Products fields - Complete form
function getProductsFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "FEATURED PRODUCTS"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Products Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Products</h4>
                    <button type="button" onclick="addProduct()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Product
                    </button>
                </div>
                <div id="products-container">
                    <!-- Products will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Video fields - Complete form
function getVideoFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "SEE MAGIC IN ACTION"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Video Title</label>
                    <input type="text" name="content[video_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <textarea name="content[subtitle]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Video Description</label>
                    <textarea name="content[video_description]" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Video URL</label>
                    <input type="url" name="content[video_url]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Video Thumbnail URL</label>
                    <input type="url" name="content[video_thumbnail]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Play Button Text</label>
                    <input type="text" name="content[play_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
        </div>
    `;
}

// Clients fields - Complete form
function getClientsFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "TRUSTED BY GIANTS"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <input type="text" name="content[subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Clients Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Client Logos</h4>
                    <button type="button" onclick="addClient()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Client
                    </button>
                </div>
                <div id="clients-container">
                <!-- Clients will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Reviews fields - Complete form
function getReviewsFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (First Part)</label>
                    <input type="text" name="content[main_title_part1]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "WHAT CLIENTS"</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title (Second Part - Colored)</label>
                    <input type="text" name="content[main_title_part2]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "SAY" (will be colored)</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <textarea name="content[subtitle]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
            </div>
            
            <!-- Reviews Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Customer Reviews</h4>
                    <button type="button" onclick="addReview()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Review
                    </button>
                </div>
                <div id="reviews-container">
                    <!-- Reviews will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Contact fields - Complete form
function getContactFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Main Title</label>
                    <input type="text" name="content[main_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                    <input type="tel" name="content[whatsapp_number]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="content[email]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">CTA Button Text</label>
                    <input type="text" name="content[cta_button_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                    <textarea name="content[subtitle]" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="content[form_enabled]" value="1" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Enable Contact Form</label>
                    </div>
                </div>
            </div>
            
            <!-- Contact Info Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Contact Information Items</h4>
                    <button type="button" onclick="addContactInfo()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Contact Info
                    </button>
                </div>
                <div id="contact-info-container">
                    <!-- Contact info will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Footer fields - Complete form
function getFooterFields() {
    return `
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Logo Text</label>
                    <input type="text" name="content[logo_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Logo Subtitle</label>
                    <input type="text" name="content[logo_subtitle]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Marketing Title</label>
                    <input type="text" name="content[marketing_title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount Badge Text</label>
                    <input type="text" name="content[discount_badge]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount Sub Text</label>
                    <input type="text" name="content[discount_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                    <p class="text-xs text-gray-500 mt-1">e.g., "LIMITED TIME"</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Marketing Subtitle</label>
                    <textarea name="content[marketing_subtitle]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Copyright Text</label>
                    <input type="text" name="content[copyright_text]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Powered By Text</label>
                    <input type="text" name="content[powered_by]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            
            <!-- Social Links Management -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-md font-medium text-gray-900">Social Links</h4>
                    <button type="button" onclick="addSocialLink()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Social Link
                    </button>
                </div>
                <div id="social-links-container">
                    <!-- Social links will be loaded here -->
                </div>
            </div>
        </div>
    `;
}

// Generic fields for unknown section types
function getGenericFields() {
    return `
        <div class="space-y-6">
            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                <p class="text-yellow-800 text-sm">
                    <i class="fas fa-info-circle mr-1"></i>
                    This section type doesn't have specific content fields defined. You can add custom content through the database or extend the controller.
                </p>
            </div>
        </div>
    `;
}

// Enhanced populate fields function
function populateFields() {
    try {
        if (!contentData) {
            console.log('[OccasionEdit] No content data to populate');
            return;
        }
        
        console.log('[OccasionEdit] Populating fields with data:', contentData);
        let fieldsPopulated = 0;

        Object.keys(contentData).forEach(key => {
            const input = document.querySelector(`[name="content[${key}]"]`);
            if (input) {
                try {
                    if (input.type === 'checkbox') {
                        input.checked = contentData[key] === true || contentData[key] === 1 || contentData[key] === '1';
                    } else if (input.type === 'datetime-local') {
                        if (contentData[key]) {
                            const date = new Date(contentData[key]);
                            if (!isNaN(date.getTime())) {
                                input.value = date.toISOString().slice(0, 16);
                            }
                        }
                    } else {
                        input.value = contentData[key] || '';
                    }
                    fieldsPopulated++;
                } catch (fieldError) {
                    logError(`Error populating field ${key}`, {
                        key: key,
                        value: contentData[key],
                        input: input,
                        error: fieldError.message
                    });
                }
            }
        });
        
        // Populate complex fields based on section type
        if (currentSection.section_type === 'hero' && contentData.main_title) {
            const titleParts = contentData.main_title.split(' ');
            if (titleParts.length >= 3) {
                setValue('content[main_title_part1]', titleParts[0]);
                setValue('content[main_title_part2]', titleParts[1]);
                setValue('content[main_title_part3]', titleParts.slice(2).join(' '));
            }
        }

        if (currentSection.section_type === 'why_choose' && contentData.main_title) {
            const titleParts = contentData.main_title.split(' ');
            if (titleParts.length >= 2) {
                setValue('content[main_title_part1]', titleParts.slice(0, -1).join(' '));
                setValue('content[main_title_part2]', titleParts[titleParts.length - 1]);
            }
        }

        if (currentSection.section_type === 'reviews' && contentData.main_title) {
            const titleParts = contentData.main_title.split(' ');
            if (titleParts.length >= 2) {
                setValue('content[main_title_part1]', titleParts.slice(0, -1).join(' '));
                setValue('content[main_title_part2]', titleParts[titleParts.length - 1]);
            }
        }

        // تحميل البيانات المعقدة
        if (contentData.features && Array.isArray(contentData.features)) {
            contentData.features.forEach((feature, index) => {
                addFeature();
                setTimeout(() => {
                    setValue(`content[features][${index}][icon]`, feature.icon);
                    setValue(`content[features][${index}][title]`, feature.title);
                    setValue(`content[features][${index}][description]`, feature.description);
                }, 100);
            });
        }

        if (contentData.services && Array.isArray(contentData.services)) {
            contentData.services.forEach((service, index) => {
                addService();
                setTimeout(() => {
                    setValue(`content[services][${index}][icon]`, service.icon);
                    setValue(`content[services][${index}][title]`, service.title);
                    setValue(`content[services][${index}][description]`, service.description);
                    setValue(`content[services][${index}][discount]`, service.discount);
                }, 100);
            });
        }

        if (contentData.packages && Array.isArray(contentData.packages)) {
            contentData.packages.forEach((pkg, index) => {
                addPackage();
                setTimeout(() => {
                    setValue(`content[packages][${index}][name]`, pkg.name);
                    setValue(`content[packages][${index}][price]`, pkg.price);
                    setValue(`content[packages][${index}][original_price]`, pkg.original_price);
                    setValue(`content[packages][${index}][discount]`, pkg.discount);
                    const featuredCheckbox = document.querySelector(`[name="content[packages][${index}][featured]"]`);
                    if (featuredCheckbox) featuredCheckbox.checked = pkg.featured;
                }, 100);
            });
        }

        if (contentData.products && Array.isArray(contentData.products)) {
            contentData.products.forEach((product, index) => {
                addProduct();
                setTimeout(() => {
                    setValue(`content[products][${index}][title]`, product.title);
                    setValue(`content[products][${index}][price]`, product.price);
                    setValue(`content[products][${index}][original_price]`, product.original_price);
                    setValue(`content[products][${index}][icon]`, product.icon);
                    setValue(`content[products][${index}][discount]`, product.discount);
                    setValue(`content[products][${index}][description]`, product.description);
                }, 100);
            });
        }

        if (contentData.clients && Array.isArray(contentData.clients)) {
            contentData.clients.forEach((client, index) => {
                addClient();
                setTimeout(() => {
                    setValue(`content[clients][${index}][name]`, client.name);
                    setValue(`content[clients][${index}][logo]`, client.logo);
                    setValue(`content[clients][${index}][url]`, client.url);
                }, 100);
            });
        }

        if (contentData.reviews && Array.isArray(contentData.reviews)) {
            contentData.reviews.forEach((review, index) => {
                addReview();
                setTimeout(() => {
                    setValue(`content[reviews][${index}][name]`, review.name);
                    setValue(`content[reviews][${index}][position]`, review.position);
                    setValue(`content[reviews][${index}][text]`, review.text);
                    const ratingSelect = document.querySelector(`[name="content[reviews][${index}][rating]"]`);
                    if (ratingSelect) ratingSelect.value = review.rating || 5;
                }, 100);
            });
        }

        if (contentData.contact_info && Array.isArray(contentData.contact_info)) {
            contentData.contact_info.forEach((info, index) => {
                addContactInfo();
                setTimeout(() => {
                    setValue(`content[contact_info][${index}][icon]`, info.icon);
                    setValue(`content[contact_info][${index}][title]`, info.title);
                    setValue(`content[contact_info][${index}][description]`, info.description);
                    setValue(`content[contact_info][${index}][value]`, info.value);
                }, 100);
            });
        }

        if (contentData.social_links && Array.isArray(contentData.social_links)) {
            contentData.social_links.forEach((link, index) => {
                addSocialLink();
                setTimeout(() => {
                    setValue(`content[social_links][${index}][icon]`, link.icon);
                    setValue(`content[social_links][${index}][url]`, link.url);
                }, 100);
            });
        }
        
        console.log(`[OccasionEdit] Populated ${fieldsPopulated} fields`);
        
    } catch (error) {
        logError('Error populating fields', {
            error: error.message,
            contentData: contentData
        });
        showAlert('Error populating form fields: ' + error.message, 'error');
    }
}

// Utility function to set field value safely
function setValue(fieldName, value) {
    const field = document.querySelector(`[name="${fieldName}"]`);
    if (field && value !== undefined && value !== null) {
        field.value = value;
    }
}

// Dynamic content management functions
function addFeature() {
    const container = document.getElementById('features-container');
    const featureIndex = container.children.length;
    
    const featureHTML = `
        <div class="feature-item bg-gray-50 p-4 rounded-lg border mb-4" data-index="${featureIndex}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Icon Class</label>
                    <input type="text" name="content[features][${featureIndex}][icon]" 
                           placeholder="e.g., fas fa-rocket"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="content[features][${featureIndex}][title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="content[features][${featureIndex}][description]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" onclick="removeItem('feature', ${featureIndex})" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', featureHTML);
}

// دوال إدارة الخدمات
function addService() {
    const container = document.getElementById('services-container');
    const serviceIndex = container.children.length;
    
    const serviceHTML = `
        <div class="service-item bg-gray-50 p-4 rounded-lg border mb-4" data-index="${serviceIndex}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Icon</label>
                    <input type="text" name="content[services][${serviceIndex}][icon]" 
                           placeholder="fas fa-server" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="content[services][${serviceIndex}][title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount %</label>
                    <input type="number" name="content[services][${serviceIndex}][discount]" 
                           min="0" max="100" placeholder="50"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="content[services][${serviceIndex}][description]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
                </div>
                <div class="md:col-span-3 flex justify-end">
                    <button type="button" onclick="removeItem('service', ${serviceIndex})" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', serviceHTML);
}

// دوال إدارة الباقات
function addPackage() {
    const container = document.getElementById('packages-container');
    const packageIndex = container.children.length;
    
    const packageHTML = `
        <div class="package-item bg-gray-50 p-4 rounded-lg border mb-4" data-index="${packageIndex}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Package Name</label>
                    <input type="text" name="content[packages][${packageIndex}][name]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="text" name="content[packages][${packageIndex}][price]" 
                           placeholder="$99" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Original Price</label>
                    <input type="text" name="content[packages][${packageIndex}][original_price]" 
                           placeholder="$199" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount %</label>
                    <input type="text" name="content[packages][${packageIndex}][discount]" 
                           placeholder="50%" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="content[packages][${packageIndex}][featured]" value="1" 
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label class="ml-2 text-sm text-gray-700">Featured Package</label>
                    </div>
                </div>
                <div class="md:col-span-3 flex justify-end">
                    <button type="button" onclick="removeItem('package', ${packageIndex})" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', packageHTML);
}

function addProduct() {
    const container = document.getElementById('products-container');
    const productIndex = container.children.length;
    
    const productHTML = `
        <div class="product-item bg-gray-50 p-4 rounded-lg border mb-4" data-index="${productIndex}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Title</label>
                    <input type="text" name="content[products][${productIndex}][title]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="text" name="content[products][${productIndex}][price]" 
                           placeholder="$50" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Icon</label>
                    <input type="text" name="content[products][${productIndex}][icon]" 
                           placeholder="fas fa-hdd" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Original Price</label>
                    <input type="text" name="content[products][${productIndex}][original_price]" 
                           placeholder="$100" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount %</label>
                    <input type="number" name="content[products][${productIndex}][discount]" 
                           min="0" max="100" placeholder="50"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="content[products][${productIndex}][description]" rows="2"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
                </div>
                <div class="md:col-span-3 flex justify-end">
                    <button type="button" onclick="removeItem('product', ${productIndex})" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', productHTML);
}

// دالة إضافة عميل جديد
function addClient() {
    const container = document.getElementById('clients-container');
    const clientIndex = container.children.length;
    
    const clientHTML = `
        <div class="client-item bg-gray-50 p-4 rounded-lg border mb-4" data-index="${clientIndex}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Client Name</label>
                    <input type="text" name="content[clients][${clientIndex}][name]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Logo URL</label>
                    <input type="url" name="content[clients][${clientIndex}][logo]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Website URL</label>
                    <input type="url" name="content[clients][${clientIndex}][url]" 
                           placeholder="https://example.com"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div class="md:col-span-3 flex justify-end">
                    <button type="button" onclick="removeItem('client', ${clientIndex})" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', clientHTML);
}

// دالة إضافة تقييم جديد
function addReview() {
    const container = document.getElementById('reviews-container');
    const reviewIndex = container.children.length;
    
    const reviewHTML = `
        <div class="review-item bg-gray-50 p-4 rounded-lg border mb-4" data-index="${reviewIndex}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <input type="text" name="content[reviews][${reviewIndex}][name]" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Position/Company</label>
                    <input type="text" name="content[reviews][${reviewIndex}][position]" 
                           placeholder="CEO, Company Name"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Review Text</label>
                    <textarea name="content[reviews][${reviewIndex}][text]" rows="3" 
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rating (1-5)</label>
                    <select name="content[reviews][${reviewIndex}][rating]" 
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                        <option value="5" selected>5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" onclick="removeItem('review', ${reviewIndex})" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', reviewHTML);
}

// دالة إضافة معلومات اتصال
function addContactInfo() {
    const container = document.getElementById('contact-info-container');
    const infoIndex = container.children.length;
    
    const infoHTML = `
        <div class="contact-info-item bg-gray-50 p-4 rounded-lg border mb-4" data-index="${infoIndex}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Icon Class</label>
                    <input type="text" name="content[contactinfo][${infoIndex}][icon]" 
                           placeholder="fas fa-phone"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="content[contactinfo][${infoIndex}][title]" 
                           placeholder="Phone"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Value</label>
                    <input type="text" name="content[contactinfo][${infoIndex}][value]" 
                           placeholder="+1 234 567 890"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" name="content[contactinfo][${infoIndex}][description]" 
                           placeholder="Call us anytime"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div class="md:col-span-4 flex justify-end">
                    <button type="button" onclick="removeItem('contact-info', ${infoIndex})" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', infoHTML);
}

// دالة إضافة رابط social
function addSocialLink() {
    const container = document.getElementById('social-links-container');
    const linkIndex = container.children.length;
    
    const linkHTML = `
        <div class="social-link-item bg-gray-50 p-4 rounded-lg border mb-4" data-index="${linkIndex}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Icon Class</label>
                    <input type="text" name="content[sociallinks][${linkIndex}][icon]" 
                           placeholder="fab fa-facebook"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">URL</label>
                    <input type="url" name="content[sociallinks][${linkIndex}][url]" 
                           placeholder="https://facebook.com/yourpage"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" onclick="removeItem('social-link', ${linkIndex})" 
                            class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', linkHTML);
}

// دالة عامة لحذف العناصر
function removeItem(type, index) {
    const item = document.querySelector(`.${type}-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        console.log(`OccasionEdit: Removed ${type} item at index ${index}`);
    }
}

@endsection