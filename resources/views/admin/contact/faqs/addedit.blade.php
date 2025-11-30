{{-- File: resources/views/admin/contact/faqs/addedit.blade.php - FIXED VERSION --}}
@extends('admin.layouts.app')

@section('title', isset($faq) ? 'Edit FAQ' : 'Add FAQ')
@section('page-title', isset($faq) ? 'Edit FAQ' : 'Add FAQ')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.contact.faqs.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.contact.faqs.index') }}" class="hover:text-primary transition-colors duration-200">Contact FAQs</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ isset($faq) ? 'Edit' : 'Add New' }}</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($faq) ? 'Edit' : 'Add New' }} FAQ
                </h2>
                <p class="text-gray-600 text-sm mt-1">{{ isset($faq) ? 'Update the' : 'Create a new' }} frequently asked question</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-question-circle mr-2 text-primary"></i>
                        FAQ Information
                    </h3>
                </div>
                
                <form action="{{ isset($faq) ? route('admin.contact.faqs.update', $faq) : route('admin.contact.faqs.store') }}" 
                      method="POST" class="p-6 space-y-6" id="faqForm">
                    @csrf
                    @if(isset($faq))
                        @method('PUT')
                    @endif
                    
                    <!-- Question -->
                    <div class="space-y-2">
                        <label for="question" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-question mr-2 text-primary"></i>
                            Question
                        </label>
                        <input type="text" 
                               id="question" 
                               name="question" 
                               value="{{ old('question', isset($faq) ? $faq->question : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('question') border-red-500 ring-2 ring-red-200 @enderror"
                               placeholder="What is your question?"
                               required>
                        @error('question')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Answer -->
                    <div class="space-y-2">
                        <label for="answer" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-comment mr-2 text-primary"></i>
                            Answer
                        </label>
                        <textarea id="answer" 
                                  name="answer" 
                                  rows="6"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 resize-none @error('answer') border-red-500 ring-2 ring-red-200 @enderror"
                                  placeholder="Provide a detailed answer to the question..."
                                  required>{{ old('answer', isset($faq) ? $faq->answer : '') }}</textarea>
                        @error('answer')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500">Provide a clear and helpful answer</p>
                    </div>

                    <!-- Category and Sort Order -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category -->
                        <div class="space-y-2">
                            <label for="category" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-folder mr-2 text-primary"></i>
                                Category
                            </label>
                            <select id="category" 
                                    name="category" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('category') border-red-500 ring-2 ring-red-200 @enderror"
                                    required>
                                <option value="">Select Category</option>
                                <option value="general" {{ old('category', isset($faq) ? $faq->category : '') === 'general' ? 'selected' : '' }}>General</option>
                                <option value="technical" {{ old('category', isset($faq) ? $faq->category : '') === 'technical' ? 'selected' : '' }}>Technical</option>
                                <option value="billing" {{ old('category', isset($faq) ? $faq->category : '') === 'billing' ? 'selected' : '' }}>Billing</option>
                                <option value="support" {{ old('category', isset($faq) ? $faq->category : '') === 'support' ? 'selected' : '' }}>Support</option>
                                <option value="services" {{ old('category', isset($faq) ? $faq->category : '') === 'services' ? 'selected' : '' }}>Services</option>
                            </select>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div class="space-y-2">
                            <label for="sort_order" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-sort mr-2 text-primary"></i>
                                Display Order
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', isset($faq) ? $faq->sort_order : 1) }}"
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('sort_order') border-red-500 ring-2 ring-red-200 @enderror"
                                   required>
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500">Lower numbers appear first</p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-toggle-on mr-2 text-primary"></i>
                            Status
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 @error('status') border-red-500 ring-2 ring-red-200 @enderror"
                                required>
                            <option value="active" {{ old('status', isset($faq) ? $faq->status : 'active') === 'active' ? 'selected' : '' }}>
                                ✅ Active (Visible on contact page)
                            </option>
                            <option value="inactive" {{ old('status', isset($faq) ? $faq->status : '') === 'inactive' ? 'selected' : '' }}>
                                ❌ Inactive (Hidden from contact page)
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.contact.faqs.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 font-medium">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-xl hover:from-secondary hover:to-primary transition-all duration-300 font-medium shadow-lg hover:shadow-xl transform hover:scale-105"
                                id="submitBtn">
                            <i class="fas fa-save mr-2"></i>
                            <span>{{ isset($faq) ? 'Update' : 'Create' }} FAQ</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Sidebar with Preview & Tips -->
        <div class="space-y-6">
            
            <!-- Live Preview Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-eye mr-2 text-blue-600"></i>
                        Live Preview
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="mb-4">
                            <span id="previewCategory" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                {{ isset($faq) ? $faq->getCategoryLabel() : 'General' }}
                            </span>
                        </div>
                        <h4 id="previewQuestion" class="text-lg font-semibold text-gray-900 mb-3">
                            {{ isset($faq) ? $faq->question : 'Your question will appear here' }}
                        </h4>
                        <p id="previewAnswer" class="text-gray-600 text-sm leading-relaxed">
                            {{ isset($faq) ? $faq->answer : 'Your answer will appear here with proper formatting and spacing.' }}
                        </p>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">This is how the FAQ will appear on the contact page</p>
                </div>
            </div>
            
            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl border border-yellow-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Best Practices
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Clear Questions</p>
                            <p class="text-xs text-gray-600">Write questions as customers would ask them</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Detailed Answers</p>
                            <p class="text-xs text-gray-600">Provide comprehensive yet concise answers</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Proper Categorization</p>
                            <p class="text-xs text-gray-600">Group related questions under appropriate categories</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Regular Updates</p>
                            <p class="text-xs text-gray-600">Keep answers current with your services</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Category Guide -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-violet-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-tags mr-2 text-purple-600"></i>
                        Category Guide
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-3">
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <h4 class="text-sm font-semibold text-blue-800">General</h4>
                            <p class="text-xs text-blue-600">Basic information about your company and services</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                            <h4 class="text-sm font-semibold text-green-800">Technical</h4>
                            <p class="text-xs text-green-600">Technical requirements and setup questions</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <h4 class="text-sm font-semibold text-yellow-800">Billing</h4>
                            <p class="text-xs text-yellow-600">Pricing, payment methods, and billing inquiries</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg border border-purple-200">
                            <h4 class="text-sm font-semibold text-purple-800">Support</h4>
                            <p class="text-xs text-purple-600">Customer support and troubleshooting</p>
                        </div>
                        <div class="p-3 bg-red-50 rounded-lg border border-red-200">
                            <h4 class="text-sm font-semibold text-red-800">Services</h4>
                            <p class="text-xs text-red-600">Specific service offerings and features</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Card - Only show if editing -->
            @if(isset($faq))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-primary"></i>
                        FAQ Stats
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $faq->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $faq->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $faq->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($faq->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Category</span>
                        <span class="text-sm font-medium text-gray-900">{{ $faq->getCategoryLabel() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Display Order</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $faq->sort_order }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Live preview functionality
document.getElementById('question').addEventListener('input', function() {
    const previewQuestion = document.getElementById('previewQuestion');
    previewQuestion.textContent = this.value || 'Your question will appear here';
});

document.getElementById('answer').addEventListener('input', function() {
    const previewAnswer = document.getElementById('previewAnswer');
    previewAnswer.textContent = this.value || 'Your answer will appear here with proper formatting and spacing.';
});

document.getElementById('category').addEventListener('change', function() {
    const previewCategory = document.getElementById('previewCategory');
    const categoryLabels = {
        'general': 'General',
        'technical': 'Technical',
        'billing': 'Billing',
        'support': 'Support',
        'services': 'Services'
    };
    previewCategory.textContent = categoryLabels[this.value] || 'General';
});

// Form submission with loading state
document.getElementById('faqForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i><span>Saving...</span>';
});

// Character counters
function addCharacterCounter(inputId, maxLength, recommendedMin = null) {
    const input = document.getElementById(inputId);
    const counter = document.createElement('div');
    counter.className = 'text-xs text-right mt-1';
    input.parentNode.appendChild(counter);
    
    function updateCounter() {
        const length = input.value.length;
        let className = 'text-xs text-right mt-1 ';
        
        if (recommendedMin && length < recommendedMin) {
            className += 'text-red-500';
        } else if (length > maxLength * 0.8) {
            className += 'text-yellow-600';
        } else {
            className += 'text-gray-500';
        }
        
        counter.className = className;
        counter.textContent = `${length}/${maxLength}`;
        
        if (recommendedMin && length < recommendedMin) {
            counter.textContent += ` (min: ${recommendedMin})`;
        }
    }
    
    input.addEventListener('input', updateCounter);
    updateCounter();
}

// Add character counters
addCharacterCounter('question', 500, 10);
addCharacterCounter('answer', 2000, 20);

// Auto-resize textarea
document.getElementById('answer').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// Form validation
document.getElementById('faqForm').addEventListener('submit', function(e) {
    const question = document.getElementById('question').value.trim();
    const answer = document.getElementById('answer').value.trim();
    const category = document.getElementById('category').value;
    
    if (question.length < 10) {
        e.preventDefault();
        alert('Question must be at least 10 characters long.');
        document.getElementById('question').focus();
        return false;
    }
    
    if (answer.length < 20) {
        e.preventDefault();
        alert('Answer must be at least 20 characters long.');
        document.getElementById('answer').focus();
        return false;
    }
    
    if (!category) {
        e.preventDefault();
        alert('Please select a category.');
        document.getElementById('category').focus();
        return false;
    }
});

// Question formatting helper
document.getElementById('question').addEventListener('blur', function() {
    let value = this.value.trim();
    
    // Capitalize first letter
    if (value.length > 0) {
        value = value.charAt(0).toUpperCase() + value.slice(1);
    }
    
    // Add question mark if not present
    if (value.length > 0 && !value.endsWith('?')) {
        value += '?';
    }
    
    this.value = value;
    
    // Update preview
    document.getElementById('previewQuestion').textContent = value || 'Your question will appear here';
});

// Answer formatting helper
document.getElementById('answer').addEventListener('blur', function() {
    let value = this.value.trim();
    
    // Capitalize first letter
    if (value.length > 0) {
        value = value.charAt(0).toUpperCase() + value.slice(1);
    }
    
    // Add period if not present and doesn't end with punctuation
    if (value.length > 0 && !/[.!?]$/.test(value)) {
        value += '.';
    }
    
    this.value = value;
    
    // Update preview
    document.getElementById('previewAnswer').textContent = value || 'Your answer will appear here with proper formatting and spacing.';
});

// Auto-save functionality
let autoSaveTimer;
function autoSave() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
        const formData = new FormData(document.getElementById('faqForm'));
        
        // Only auto-save if we have content
        if (formData.get('question').trim() && formData.get('answer').trim()) {
            localStorage.setItem('faq_draft', JSON.stringify({
                question: formData.get('question'),
                answer: formData.get('answer'),
                category: formData.get('category'),
                sort_order: formData.get('sort_order'),
                status: formData.get('status'),
                timestamp: Date.now()
            }));
        }
    }, 2000);
}

// Auto-save on input
['question', 'answer', 'category', 'sort_order', 'status'].forEach(fieldId => {
    document.getElementById(fieldId).addEventListener('input', autoSave);
});

// Load draft on page load (only for new FAQs)
window.addEventListener('load', function() {
    const draft = localStorage.getItem('faq_draft');
    const isEditing = {{ isset($faq) ? 'true' : 'false' }};
    
    if (draft && !isEditing) { // Only for new FAQs
        try {
            const draftData = JSON.parse(draft);
            const now = Date.now();
            const draftAge = now - draftData.timestamp;
            
            // Only load if draft is less than 1 hour old
            if (draftAge < 3600000) {
                if (confirm('A draft was found. Would you like to restore it?')) {
                    document.getElementById('question').value = draftData.question || '';
                    document.getElementById('answer').value = draftData.answer || '';
                    document.getElementById('category').value = draftData.category || '';
                    document.getElementById('sort_order').value = draftData.sort_order || 1;
                    document.getElementById('status').value = draftData.status || 'active';
                    
                    // Trigger preview updates
                    document.getElementById('question').dispatchEvent(new Event('input'));
                    document.getElementById('answer').dispatchEvent(new Event('input'));
                    document.getElementById('category').dispatchEvent(new Event('change'));
                }
            }
        } catch (e) {
            console.error('Error loading draft:', e);
        }
    }
});

// Clear draft on successful submit
document.getElementById('faqForm').addEventListener('submit', function() {
    localStorage.removeItem('faq_draft');
});
</script>
@endpush