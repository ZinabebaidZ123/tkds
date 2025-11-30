{{-- File: resources/views/admin/contact/submissions/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'View Contact Submission')
@section('page-title', 'Contact Submission Details')

@section('content')
<div class="space-y-6">
    
    <!-- Header with Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.contact.submissions.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 group">
                <i class="fas fa-arrow-left text-gray-600 group-hover:text-gray-800 transition-colors duration-200"></i>
            </a>
            <div>
                <nav class="text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.contact.submissions.index') }}" class="hover:text-primary transition-colors duration-200">Contact Submissions</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">View Details</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-900">Contact from {{ $submission->full_name }}</h2>
                <p class="text-gray-600 text-sm mt-1">Submitted {{ $submission->created_at->format('M d, Y \a\t g:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Message Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-message mr-2 text-blue-600"></i>
                        Message Content
                    </h3>
                </div>
                <div class="p-6">
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $submission->message }}</p>
                    </div>
                </div>
            </div>

            <!-- Admin Notes Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-orange-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-sticky-note mr-2 text-yellow-600"></i>
                        Admin Notes
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.contact.submissions.update-status', $submission) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Current Notes -->
                        @if($submission->admin_notes)
                            <div class="mb-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <p class="text-sm font-medium text-yellow-800 mb-2">Current Notes:</p>
                                <p class="text-yellow-700 whitespace-pre-wrap">{{ $submission->admin_notes }}</p>
                            </div>
                        @endif
                        
                        <!-- Add/Update Notes -->
                        <div>
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $submission->admin_notes ? 'Update Notes' : 'Add Notes' }}
                            </label>
                            <textarea id="admin_notes" name="admin_notes" rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none"
                                      placeholder="Add internal notes about this submission...">{{ old('admin_notes') }}</textarea>
                        </div>
                        
                        <!-- Status Update -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                                <select name="status" id="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    <option value="unread" {{ $submission->status === 'unread' ? 'selected' : '' }}>Unread</option>
                                    <option value="read" {{ $submission->status === 'read' ? 'selected' : '' }}>Read</option>
                                    <option value="replied" {{ $submission->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                    <option value="archived" {{ $submission->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:from-secondary hover:to-primary transition-all duration-300 font-medium">
                                <i class="fas fa-save mr-2"></i>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Contact Info -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user mr-2 text-primary"></i>
                        Contact Information
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Full Name</label>
                        <p class="text-gray-900 font-medium">{{ $submission->full_name }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email Address</label>
                        <p class="text-gray-900">
                            <a href="mailto:{{ $submission->email }}" class="hover:text-primary transition-colors duration-200">
                                {{ $submission->email }}
                            </a>
                        </p>
                    </div>
                    
                    @if($submission->phone)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Phone Number</label>
                            <p class="text-gray-900">
                                <a href="tel:{{ $submission->phone }}" class="hover:text-primary transition-colors duration-200">
                                    {{ $submission->phone }}
                                </a>
                            </p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">IP Address</label>
                        <p class="text-gray-900 font-mono text-sm">{{ $submission->ip_address }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Inquiry Details -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-green-600"></i>
                        Inquiry Details
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($submission->service_interest)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Service Interest</label>
                            <p class="text-gray-900 font-medium">{{ $submission->getServiceInterestLabel() }}</p>
                        </div>
                    @endif
                    
                    @if($submission->budget)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Budget Range</label>
                            <p class="text-gray-900 font-medium">{{ $submission->getBudgetLabel() }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Priority Level</label>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $submission->getPriorityClass() }}">
                            {{ $submission->getPriorityLabel() }} Priority
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Status & Timeline -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-violet-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-clock mr-2 text-purple-600"></i>
                        Status & Timeline
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Current Status</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $submission->getStatusBadgeClass() }}">
                                <i class="{{ $submission->getStatusIcon() }} mr-2"></i>
                                {{ ucfirst($submission->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Submitted</label>
                        <p class="text-gray-900">{{ $submission->created_at->format('M d, Y \a\t g:i A') }}</p>
                        <p class="text-xs text-gray-500">{{ $submission->created_at->diffForHumans() }}</p>
                    </div>
                    
                    @if($submission->replied_at)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Replied</label>
                            <p class="text-gray-900">{{ $submission->replied_at->format('M d, Y \a\t g:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $submission->replied_at->diffForHumans() }}</p>
                            @if($submission->repliedByAdmin)
                                <p class="text-xs text-gray-500">by {{ $submission->repliedByAdmin->name }}</p>
                            @endif
                        </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Last Updated</label>
                        <p class="text-gray-900">{{ $submission->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        <p class="text-xs text-gray-500">{{ $submission->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-2 text-blue-600"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="mailto:{{ $submission->email }}?subject=Re: Your inquiry to TKDS Media&body=Hi {{ $submission->first_name }},%0D%0A%0D%0AThank you for contacting TKDS Media..." 
                       class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-envelope mr-2"></i>
                        Send Email Reply
                    </a>
                    
                    @if($submission->phone)
                        <a href="tel:{{ $submission->phone }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-phone mr-2"></i>
                            Call {{ $submission->first_name }}
                        </a>
                    @endif
                    
                    <button onclick="markAsReplied()" 
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-check mr-2"></i>
                        Mark as Replied
                    </button>
                    
                    <button onclick="deleteSubmission()" 
                            class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Submission
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function markAsReplied() {
    if (confirm('Mark this submission as replied?')) {
        fetch('{{ route("admin.contact.submissions.update-status", $submission) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: 'replied' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update status');
        });
    }
}

function deleteSubmission() {
    if (confirm('Are you sure you want to delete this submission? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.contact.submissions.destroy", $submission) }}';
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
