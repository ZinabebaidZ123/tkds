{{-- File: resources/views/admin/contact/settings.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Contact Page Settings')
@section('page-title', 'Contact Page Settings')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Contact Page Settings</h2>
            <p class="text-gray-600 text-sm mt-1">Customize your contact page content and configuration</p>
        </div>
        <a href="{{ route('contact') }}" 
           target="_blank"
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
            <i class="fas fa-external-link-alt mr-2"></i>
            Preview Page
        </a>
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

    <!-- Settings Form -->
    <form action="{{ route('admin.contact.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Hero Section Settings -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-star mr-2 text-blue-600"></i>
                    Hero Section
                </h3>
            </div>
            <div class="p-6 space-y-6">
                
                <!-- Badge Text -->
                <div>
                    <label for="hero_badge_text" class="block text-sm font-medium text-gray-700 mb-2">Badge Text</label>
                    <input type="text" id="hero_badge_text" name="hero_badge_text" 
                           value="{{ old('hero_badge_text', $settings->hero_badge_text) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('hero_badge_text') border-red-500 @enderror"
                           placeholder="Contact Us">
                    @error('hero_badge_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hero Title -->
                <div>
                    <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-2">Hero Title</label>
                    <input type="text" id="hero_title" name="hero_title" 
                           value="{{ old('hero_title', $settings->hero_title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('hero_title') border-red-500 @enderror"
                           placeholder="Let's Start Your Broadcasting Journey"
                           required>
                    @error('hero_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hero Subtitle -->
                <div>
                    <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 mb-2">Hero Subtitle</label>
                    <textarea id="hero_subtitle" name="hero_subtitle" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none @error('hero_subtitle') border-red-500 @enderror"
                              placeholder="Ready to transform your content strategy? Our experts are here to help you every step of the way">{{ old('hero_subtitle', $settings->hero_subtitle) }}</textarea>
                    @error('hero_subtitle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Title -->
                <div>
                    <label for="form_title" class="block text-sm font-medium text-gray-700 mb-2">Contact Form Title</label>
                    <input type="text" id="form_title" name="form_title" 
                           value="{{ old('form_title', $settings->form_title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('form_title') border-red-500 @enderror"
                           placeholder="Send us a Message">
                    @error('form_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
<!-- Contact Information -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-address-book mr-2 text-green-600"></i>
                    Contact Information
                </h3>
            </div>
            <div class="p-6 space-y-6">
                
                <!-- Office Address -->
                <div>
                    <label for="office_address" class="block text-sm font-medium text-gray-700 mb-2">Office Address</label>
                    <textarea id="office_address" name="office_address" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none @error('office_address') border-red-500 @enderror"
                              placeholder="123 Business Street, Suite 100, City, State 12345">{{ old('office_address', $settings->office_address) }}</textarea>
                    @error('office_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Office Phone -->
                    <div>
                        <label for="office_phone" class="block text-sm font-medium text-gray-700 mb-2">Office Phone</label>
                        <input type="text" id="office_phone" name="office_phone" 
                               value="{{ old('office_phone', $settings->office_phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('office_phone') border-red-500 @enderror"
                               placeholder="+1 (555) 123-4567">
                        @error('office_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Office Email -->
                    <div>
                        <label for="office_email" class="block text-sm font-medium text-gray-700 mb-2">Office Email</label>
                        <input type="email" id="office_email" name="office_email" 
                               value="{{ old('office_email', $settings->office_email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('office_email') border-red-500 @enderror"
                               placeholder="info@tkdsmedia.com">
                        @error('office_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Support Email -->
                    <div>
                        <label for="support_email" class="block text-sm font-medium text-gray-700 mb-2">Support Email</label>
                        <input type="email" id="support_email" name="support_email" 
                               value="{{ old('support_email', $settings->support_email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('support_email') border-red-500 @enderror"
                               placeholder="support@tkdsmedia.com">
                        @error('support_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Sales Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sales_email" class="block text-sm font-medium text-gray-700 mb-2">Sales Email</label>
                        <input type="email" id="sales_email" name="sales_email" 
                               value="{{ old('sales_email', $settings->sales_email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('sales_email') border-red-500 @enderror"
                               placeholder="sales@tkdsmedia.com">
                        @error('sales_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notification Emails -->
                    <div>
                        <label for="notification_emails" class="block text-sm font-medium text-gray-700 mb-2">Notification Emails</label>
                        <input type="text" id="notification_emails" name="notification_emails" 
                               value="{{ old('notification_emails', $settings->notification_emails) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('notification_emails') border-red-500 @enderror"
                               placeholder="admin@tkdsmedia.com, manager@tkdsmedia.com">
                        @error('notification_emails')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Separate multiple emails with commas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Hours -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-violet-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-clock mr-2 text-purple-600"></i>
                    Support Hours
                </h3>
            </div>
            <div class="p-6 space-y-6">
                
                <!-- Support Hours Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Monday-Friday -->
                    <div>
                        <label for="monday_friday_hours" class="block text-sm font-medium text-gray-700 mb-2">Monday - Friday</label>
                        <input type="text" id="monday_friday_hours" name="monday_friday_hours" 
                               value="{{ old('monday_friday_hours', $settings->monday_friday_hours) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('monday_friday_hours') border-red-500 @enderror"
                               placeholder="9:00 AM - 6:00 PM">
                        @error('monday_friday_hours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Saturday -->
                    <div>
                        <label for="saturday_hours" class="block text-sm font-medium text-gray-700 mb-2">Saturday</label>
                        <input type="text" id="saturday_hours" name="saturday_hours" 
                               value="{{ old('saturday_hours', $settings->saturday_hours) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('saturday_hours') border-red-500 @enderror"
                               placeholder="10:00 AM - 4:00 PM">
                        @error('saturday_hours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sunday -->
                    <div>
                        <label for="sunday_hours" class="block text-sm font-medium text-gray-700 mb-2">Sunday</label>
                        <input type="text" id="sunday_hours" name="sunday_hours" 
                               value="{{ old('sunday_hours', $settings->sunday_hours) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('sunday_hours') border-red-500 @enderror"
                               placeholder="Emergency Only">
                        @error('sunday_hours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Emergency Support -->
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex items-center space-x-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="emergency_support" value="0">
                            <input type="checkbox" name="emergency_support" value="1" 
                                   class="sr-only" {{ old('emergency_support', $settings->emergency_support) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-green-500 peer-focus:outline-none"></div>
                        </label>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Emergency Support Available</p>
                            <p class="text-xs text-gray-500">Show 24/7 emergency support message</p>
                        </div>
                    </div>
                </div>

                <!-- Emergency Text -->
                <div>
                    <label for="emergency_text" class="block text-sm font-medium text-gray-700 mb-2">Emergency Support Text</label>
                    <input type="text" id="emergency_text" name="emergency_text" 
                           value="{{ old('emergency_text', $settings->emergency_text) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('emergency_text') border-red-500 @enderror"
                           placeholder="24/7 Emergency Support Available">
                    @error('emergency_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-share-alt mr-2 text-blue-600"></i>
                    Social Media Links
                </h3>
            </div>
            <div class="p-6 space-y-6">
                
                <!-- Social Links Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Twitter -->
                    <div>
                        <label for="social_twitter" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-twitter mr-2 text-blue-400"></i>
                            Twitter URL
                        </label>
                        <input type="url" id="social_twitter" name="social_twitter" 
                               value="{{ old('social_twitter', $settings->social_twitter) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('social_twitter') border-red-500 @enderror"
                               placeholder="https://twitter.com/tkdsmedia">
                        @error('social_twitter')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- LinkedIn -->
                    <div>
                        <label for="social_linkedin" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-linkedin mr-2 text-blue-600"></i>
                            LinkedIn URL
                        </label>
                        <input type="url" id="social_linkedin" name="social_linkedin" 
                               value="{{ old('social_linkedin', $settings->social_linkedin) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('social_linkedin') border-red-500 @enderror"
                               placeholder="https://linkedin.com/company/tkdsmedia">
                        @error('social_linkedin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- YouTube -->
                    <div>
                        <label for="social_youtube" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-youtube mr-2 text-red-600"></i>
                            YouTube URL
                        </label>
                        <input type="url" id="social_youtube" name="social_youtube" 
                               value="{{ old('social_youtube', $settings->social_youtube) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('social_youtube') border-red-500 @enderror"
                               placeholder="https://youtube.com/@tkdsmedia">
                        @error('social_youtube')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label for="social_instagram" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-instagram mr-2 text-pink-600"></i>
                            Instagram URL
                        </label>
                        <input type="url" id="social_instagram" name="social_instagram" 
                               value="{{ old('social_instagram', $settings->social_instagram) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('social_instagram') border-red-500 @enderror"
                               placeholder="https://instagram.com/tkdsmedia">
                        @error('social_instagram')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Facebook -->
                    <div>
                        <label for="social_facebook" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-facebook mr-2 text-blue-700"></i>
                            Facebook URL
                        </label>
                        <input type="url" id="social_facebook" name="social_facebook" 
                               value="{{ old('social_facebook', $settings->social_facebook) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('social_facebook') border-red-500 @enderror"
                               placeholder="https://facebook.com/tkdsmedia">
                        @error('social_facebook')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Configuration -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-envelope-open mr-2 text-orange-600"></i>
                    Email Configuration
                </h3>
            </div>
            <div class="p-6 space-y-6">
                
                <!-- Auto Reply Toggle -->
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center space-x-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="auto_reply_enabled" value="0">
                            <input type="checkbox" name="auto_reply_enabled" value="1" 
                                   class="sr-only" {{ old('auto_reply_enabled', $settings->auto_reply_enabled) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-blue-500 peer-focus:outline-none"></div>
                        </label>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Auto Reply Email</p>
                            <p class="text-xs text-gray-500">Send automatic confirmation emails to users</p>
                        </div>
                    </div>
                </div>

                <!-- Auto Reply Subject -->
                <div>
                    <label for="auto_reply_subject" class="block text-sm font-medium text-gray-700 mb-2">Auto Reply Subject</label>
                    <input type="text" id="auto_reply_subject" name="auto_reply_subject" 
                           value="{{ old('auto_reply_subject', $settings->auto_reply_subject) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('auto_reply_subject') border-red-500 @enderror"
                           placeholder="Thank you for contacting TKDS Media">
                    @error('auto_reply_subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Auto Reply Message -->
                <div>
                    <label for="auto_reply_message" class="block text-sm font-medium text-gray-700 mb-2">Auto Reply Message</label>
                    <textarea id="auto_reply_message" name="auto_reply_message" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none @error('auto_reply_message') border-red-500 @enderror"
                              placeholder="Thank you for reaching out to us. We have received your message and will get back to you within 24 hours.">{{ old('auto_reply_message', $settings->auto_reply_message) }}</textarea>
                    @error('auto_reply_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Google Maps Integration -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-teal-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                    Google Maps Integration
                </h3>
            </div>
            <div class="p-6 space-y-6">
                
                <!-- Google Maps Embed -->
                <div>
                    <label for="google_maps_embed" class="block text-sm font-medium text-gray-700 mb-2">Google Maps Embed Code</label>
                    <textarea id="google_maps_embed" name="google_maps_embed" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none font-mono text-sm @error('google_maps_embed') border-red-500 @enderror"
                              placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'>{{ old('google_maps_embed', $settings->google_maps_embed) }}</textarea>
                    @error('google_maps_embed')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Get embed code from <a href="https://maps.google.com" target="_blank" class="text-primary hover:underline">Google Maps</a> → Share → Embed a map
                    </p>
                </div>
            </div>
        </div>

        <!-- SEO Settings -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-search mr-2 text-indigo-600"></i>
                    SEO Settings
                </h3>
            </div>
            <div class="p-6 space-y-6">
                
                <!-- Meta Title -->
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" 
                           value="{{ old('meta_title', $settings->meta_title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('meta_title') border-red-500 @enderror"
                           placeholder="Contact Us - TKDS Media"
                           maxlength="60">
                    @error('meta_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Recommended: 50-60 characters</p>
                </div>

                <!-- Meta Description -->
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none @error('meta_description') border-red-500 @enderror"
                              placeholder="Get in touch with TKDS Media for professional broadcasting solutions. Contact our experts today."
                              maxlength="160">{{ old('meta_description', $settings->meta_description) }}</textarea>
                    @error('meta_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Recommended: 150-160 characters</p>
                </div>
            </div>
        </div>

        <!-- Status & Submit -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Page Status</label>
                        <select id="status" name="status" 
                                class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary @error('status') border-red-500 @enderror">
                            <option value="active" {{ old('status', $settings->status) === 'active' ? 'selected' : '' }}>
                                ✅ Active (Contact page is live)
                            </option>
                            <option value="inactive" {{ old('status', $settings->status) === 'inactive' ? 'selected' : '' }}>
                                ❌ Inactive (Contact page is disabled)
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" 
                            class="px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i>
                        Save Settings
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// Character counters for meta fields
function addCharacterCounter(inputId, maxLength, recommendedLength = null) {
    const input = document.getElementById(inputId);
    const counter = document.createElement('div');
    counter.className = 'text-xs text-right mt-1';
    input.parentNode.appendChild(counter);
    
    function updateCounter() {
        const length = input.value.length;
        const remaining = maxLength - length;
        let className = 'text-xs text-right mt-1 ';
        
        if (recommendedLength) {
            if (length < recommendedLength - 10) {
                className += 'text-gray-500';
            } else if (length <= recommendedLength) {
                className += 'text-green-600';
            } else if (length <= maxLength) {
                className += 'text-yellow-600';
            } else {
                className += 'text-red-600';
            }
        } else {
            className += remaining < 10 ? 'text-red-500' : 'text-gray-500';
        }
        
        counter.className = className;
        counter.textContent = `${length}/${maxLength}`;
    }
    
    input.addEventListener('input', updateCounter);
    updateCounter();
}

// Add character counters
addCharacterCounter('meta_title', 60, 55);
addCharacterCounter('meta_description', 160, 155);

// URL validation for social links
const urlInputs = ['social_twitter', 'social_linkedin', 'social_youtube', 'social_instagram', 'social_facebook'];
urlInputs.forEach(inputId => {
    const input = document.getElementById(inputId);
    input.addEventListener('blur', function() {
        if (this.value && !this.value.startsWith('http')) {
            this.value = 'https://' + this.value;
        }
    });
});

// Form submission loading state
document.querySelector('form').addEventListener('submit', function() {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
});

// Live preview functionality
document.getElementById('hero_title').addEventListener('input', function() {
    console.log('Hero title updated:', this.value);
});

document.getElementById('hero_subtitle').addEventListener('input', function() {
    console.log('Hero subtitle updated:', this.value);
});

// Validate notification emails format
document.getElementById('notification_emails').addEventListener('blur', function() {
    const emails = this.value.split(',');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let hasInvalid = false;
    
    emails.forEach(email => {
        const trimmedEmail = email.trim();
        if (trimmedEmail && !emailRegex.test(trimmedEmail)) {
            hasInvalid = true;
        }
    });
    
    if (hasInvalid) {
        this.classList.add('border-red-500');
        this.classList.remove('border-gray-300');
    } else {
        this.classList.remove('border-red-500');
        this.classList.add('border-gray-300');
    }
});
</script>
@endpush


