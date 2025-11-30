<?php

// File: app/Http/Controllers/Admin/ContactController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\ContactSetting;
use App\Models\ContactFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // ==================== SUBMISSIONS MANAGEMENT ====================
    
    public function submissions(Request $request)
    {
        $query = ContactSubmission::with('repliedByAdmin')->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by service interest
        if ($request->service) {
            $query->where('service_interest', $request->service);
        }

        // Filter by date range
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->search) {
            $query->search($request->search);
        }

        // Sort by priority if requested
        if ($request->sort === 'priority') {
            $submissions = $query->get()->sortByDesc(function($submission) {
                return $submission->getPriorityScore();
            });
            $submissions = new \Illuminate\Pagination\LengthAwarePaginator(
                $submissions->forPage($request->page ?? 1, 15),
                $submissions->count(),
                15,
                $request->page ?? 1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $submissions = $query->paginate(15);
        }

        // Get stats
        $stats = [
            'total' => ContactSubmission::count(),
            'unread' => ContactSubmission::unread()->count(),
            'read' => ContactSubmission::read()->count(),
            'replied' => ContactSubmission::replied()->count(),
            'archived' => ContactSubmission::archived()->count(),
            'recent' => ContactSubmission::recent(7)->count(),
        ];

        return view('admin.contact.submissions.index', compact('submissions', 'stats'));
    }

    public function showSubmission(ContactSubmission $submission)
    {
        // Mark as read if unread
        if ($submission->isUnread()) {
            $submission->markAsRead(auth('admin')->id());
        }

        return view('admin.contact.submissions.show', compact('submission'));
    }

    public function updateSubmissionStatus(Request $request, ContactSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied,archived',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $data = ['status' => $request->status];
        
        if ($request->admin_notes) {
            $data['admin_notes'] = $request->admin_notes;
        }

        if ($request->status === 'replied') {
            $data['replied_at'] = now();
            $data['replied_by'] = auth('admin')->id();
        }

        $submission->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $submission->status
        ]);
    }

    public function deleteSubmission(ContactSubmission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.contact.submissions.index')
            ->with('success', 'Contact submission deleted successfully.');
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:read,replied,archived,delete',
            'submissions' => 'required|array',
            'submissions.*' => 'exists:contact_submissions,id'
        ]);

        $submissions = ContactSubmission::whereIn('id', $request->submissions);
        $count = $submissions->count();

        switch ($request->action) {
            case 'read':
                $submissions->update([
                    'status' => 'read',
                    'replied_by' => auth('admin')->id()
                ]);
                $message = "Marked {$count} submissions as read.";
                break;

            case 'replied':
                $submissions->update([
                    'status' => 'replied',
                    'replied_at' => now(),
                    'replied_by' => auth('admin')->id()
                ]);
                $message = "Marked {$count} submissions as replied.";
                break;

            case 'archived':
                $submissions->update(['status' => 'archived']);
                $message = "Archived {$count} submissions.";
                break;

            case 'delete':
                $submissions->delete();
                $message = "Deleted {$count} submissions.";
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function exportSubmissions(Request $request)
    {
        $query = ContactSubmission::with('repliedByAdmin');

        // Apply same filters as index
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        if ($request->service) {
            $query->where('service_interest', $request->service);
        }
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->search) {
            $query->search($request->search);
        }

        $submissions = $query->orderBy('created_at', 'desc')->get();

        $filename = 'contact_submissions_' . now()->format('Y_m_d_H_i_s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($submissions) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID', 'Date', 'Name', 'Email', 'Phone', 'Service Interest', 
                'Budget', 'Status', 'Priority', 'Message', 'Admin Notes', 
                'Replied At', 'Replied By'
            ]);

            // Data rows
            foreach ($submissions as $submission) {
                fputcsv($file, [
                    $submission->id,
                    $submission->created_at->format('Y-m-d H:i:s'),
                    $submission->full_name,
                    $submission->email,
                    $submission->phone,
                    $submission->getServiceInterestLabel(),
                    $submission->getBudgetLabel(),
                    ucfirst($submission->status),
                    $submission->getPriorityLabel(),
                    $submission->message,
                    $submission->admin_notes,
                    $submission->replied_at ? $submission->replied_at->format('Y-m-d H:i:s') : '',
                    $submission->repliedByAdmin ? $submission->repliedByAdmin->name : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ==================== SETTINGS MANAGEMENT ====================
    
    public function settings()
    {
        $settings = ContactSetting::getSettings();
        return view('admin.contact.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'hero_badge_text' => 'nullable|string|max:100',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'form_title' => 'nullable|string|max:255',
            'office_address' => 'nullable|string',
            'office_phone' => 'nullable|string|max:20',
            'office_email' => 'nullable|email|max:255',
            'support_email' => 'nullable|email|max:255',
            'sales_email' => 'nullable|email|max:255',
            'monday_friday_hours' => 'nullable|string|max:100',
            'saturday_hours' => 'nullable|string|max:100',
            'sunday_hours' => 'nullable|string|max:100',
            'emergency_support' => 'boolean',
            'emergency_text' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'google_maps_embed' => 'nullable|string',
            'auto_reply_enabled' => 'boolean',
            'auto_reply_subject' => 'nullable|string|max:255',
            'auto_reply_message' => 'nullable|string',
            'notification_emails' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $settings = ContactSetting::getSettings();
        $settings->update($request->all());

        return redirect()->route('admin.contact.settings')
            ->with('success', 'Contact settings updated successfully.');
    }

    // ==================== FAQ MANAGEMENT ====================
    
    public function faqs()
    {
        $faqs = ContactFaq::orderBy('category', 'asc')
                          ->orderBy('sort_order', 'asc')
                          ->paginate(15);
                          
        return view('admin.contact.faqs.index', compact('faqs'));
    }

    public function createFaq()
    {
        return view('admin.contact.faqs.addedit');
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'category' => 'required|string|max:100',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        ContactFaq::create($request->all());

        return redirect()->route('admin.contact.faqs.index')
            ->with('success', 'FAQ created successfully.');
    }

    public function editFaq(ContactFaq $faq)
    {
        return view('admin.contact.faqs.addedit', compact('faq'));
    }

    public function updateFaq(Request $request, ContactFaq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'category' => 'required|string|max:100',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $faq->update($request->all());

        return redirect()->route('admin.contact.faqs.index')
            ->with('success', 'FAQ updated successfully.');
    }

    public function destroyFaq(ContactFaq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.contact.faqs.index')
            ->with('success', 'FAQ deleted successfully.');
    }

    public function updateFaqStatus(Request $request, ContactFaq $faq)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $faq->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $faq->status
        ]);
    }

    public function updateFaqSortOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:contact_faqs,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            ContactFaq::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sort order updated successfully.'
        ]);
    }
}
