@extends('admin.layouts.app')

@section('title', 'TKDS AI Settings')
@section('page-title', 'TKDS AI Settings')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-900">TKDS AI Management</h2>
            <p class="text-gray-600 text-sm mt-1">Configure TKDS AI Assistant for your website</p>
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

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-gradient-to-r from-red-50 to-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-red-800 font-medium">Please fix the following errors:</h3>
                    <ul class="mt-2 text-red-700 text-sm list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Form -->
    <form action="{{ route('admin.ai.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Basic Configuration -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-robot mr-2 text-blue-600"></i>
                        AI Configuration
                    </h3>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Enable AI -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Enable TKDS AI</label>
                            <p class="text-xs text-gray-500">Turn on/off AI chat assistant</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="enabled" value="1"
                                   {{ $settings->enabled ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer relative peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all after:duration-200 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- TKDS AI Token -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">TKDS AI Token</label>
                        <input type="text" name="tkds_ai_token"
                               value="{{ old('tkds_ai_token', $settings->tkds_ai_token) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                               placeholder="6f94afec-4299-44c9-9d50-3aa596e7b418">
                        <p class="text-xs text-gray-500 mt-1">Enter your TKDS AI Token (UUID format)</p>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-900 mb-2 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            How to Get Your Token
                        </h4>
                        <p class="text-xs text-blue-800">
                            Contact TKDS support to get your unique AI token. This token is required to use the AI chat features.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Status & Info -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-purple-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-purple-600"></i>
                        Status & Information
                    </h3>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Current Status -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Current Status</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Status:</span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $settings->isEnabled() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $settings->isEnabled() ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Token Status:</span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $settings->tkds_ai_token ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $settings->tkds_ai_token ? 'Configured' : 'Not Set' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Last Updated:</span>
                                <span class="font-medium">{{ $settings->updated_at?->diffForHumans() ?? 'Never' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">AI Features</h4>
                        <ul class="space-y-2 text-xs text-gray-600">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                <span>Answers questions about your services and products</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                <span>Provides pricing information and recommendations</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                <span>Helps users navigate your website</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                <span>Collects contact info when unable to help</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Warning -->
                    @if(!$settings->isEnabled() && $settings->tkds_ai_token)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-2 mt-0.5"></i>
                                <p class="text-xs text-yellow-800">
                                    You have a token configured but the AI is disabled. Enable it to activate the AI chat feature.
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($settings->enabled && !$settings->tkds_ai_token)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-times-circle text-red-500 mr-2 mt-0.5"></i>
                                <p class="text-xs text-red-800">
                                    AI is enabled but no token is configured. Please add a token to use the AI features.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
            <button type="button" onclick="window.location.reload()"
                    class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-200">
                Cancel
            </button>
            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Settings
            </button>
        </div>
    </form>
</div>

@endsection
