@extends('admin.layouts.app')

@section('title', 'Footer Settings')
@section('page-title', 'Footer Settings')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Footer Management</h2>
            <p class="text-gray-600 text-sm mt-1">Control all footer content and display settings</p>
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
    <form action="{{ route('admin.footer.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Newsletter Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bell mr-2 text-blue-600"></i>
                        Newsletter Section
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- Newsletter Enabled -->
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-700">Enable Newsletter</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="newsletter_enabled" value="1" 
                                   {{ $settings->newsletter_enabled ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    
                    <!-- Newsletter Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Newsletter Title</label>
                        <input type="text" name="newsletter_title" 
                               value="{{ old('newsletter_title', $settings->newsletter_title) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Newsletter Subtitle -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Newsletter Subtitle</label>
                        <textarea name="newsletter_subtitle" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('newsletter_subtitle', $settings->newsletter_subtitle) }}</textarea>
                    </div>
                    
                    <!-- Newsletter Button Text -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                        <input type="text" name="newsletter_button_text" 
                               value="{{ old('newsletter_button_text', $settings->newsletter_button_text) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Company Info Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-green-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-building mr-2 text-green-600"></i>
                        Company Information
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- Company Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                        <input type="text" name="company_name" 
                               value="{{ old('company_name', $settings->company_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    </div>
                    
                    <!-- Company Tagline -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company Tagline</label>
                        <input type="text" name="company_tagline" 
                               value="{{ old('company_tagline', $settings->company_tagline) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    
                    <!-- Company Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Company Description</label>
                        <textarea name="company_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('company_description', $settings->company_description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Contact Info Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-yellow-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-phone mr-2 text-yellow-600"></i>
                        Contact Information
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- Contact Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                        <input type="email" name="contact_email" 
                               value="{{ old('contact_email', $settings->contact_email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    
                    <!-- Contact Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                        <input type="text" name="contact_phone" 
                               value="{{ old('contact_phone', $settings->contact_phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    
                    <!-- Support Hours -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Support Hours</label>
                        <input type="text" name="support_hours" 
                               value="{{ old('support_hours', $settings->support_hours) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-share-alt mr-2 text-purple-600"></i>
                        Social Media Links
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- Show Social Media Toggle -->
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-700">Show Social Media</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="show_social_media" value="1" 
                                   {{ $settings->show_social_media ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                    
                    <!-- Social Links -->
                    @foreach(['twitter', 'linkedin', 'youtube', 'instagram', 'facebook'] as $social)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-{{ $social }} mr-2"></i>
                                {{ ucfirst($social) }} URL
                            </label>
                            <input type="url" name="social_{{ $social }}" 
                                   value="{{ old('social_' . $social, $settings->{'social_' . $social}) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="https://{{ $social }}.com/your-profile">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Display Settings -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-indigo-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-2 text-indigo-600"></i>
                        Display Settings
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    @php
                        $displayOptions = [
                            'show_services_section' => 'Show Services Section',
                            'show_company_section' => 'Show Company Section', 
                            'show_legal_section' => 'Show Legal Section',
                            'show_trust_badges' => 'Show Trust Badges'
                        ];
                    @endphp
                    
                    @foreach($displayOptions as $field => $label)
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">{{ $label }}</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="{{ $field }}" value="1" 
                                       {{ $settings->$field ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer Text Settings -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-red-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-text-height mr-2 text-red-600"></i>
                        Footer Text Settings
                    </h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <!-- Copyright Text -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Copyright Text</label>
                        <input type="text" name="copyright_text" 
                               value="{{ old('copyright_text', $settings->copyright_text) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                    
                    <!-- Footer Subtitle -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Subtitle</label>
                        <input type="text" name="footer_subtitle" 
                               value="{{ old('footer_subtitle', $settings->footer_subtitle) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                    
                    <!-- Back to Top Text -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Back to Top Text</label>
                        <input type="text" name="back_to_top_text" 
                               value="{{ old('back_to_top_text', $settings->back_to_top_text) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="active" {{ $settings->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $settings->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Update Footer Settings
            </button>
        </div>
    </form>
</div>
@endsection