<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['profile', 'sessions']);

        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by verification status
        if ($request->verified && $request->verified !== 'all') {
            if ($request->verified === 'verified') {
                $query->whereNotNull('email_verified_at');
            } else {
                $query->whereNull('email_verified_at');
            }
        }

        // Filter by date range
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(15);

        // Get stats
        $stats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'recent' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('admin.users.addedit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'email_verified' => 'boolean',
            // Profile fields
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
        ]);

        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            
            // Set email verification
            if ($request->email_verified) {
                $data['email_verified_at'] = now();
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $avatarPath;
            }

            $user = User::create($data);

            // Update profile if profile fields provided
            if ($request->bio || $request->website || $request->location || $request->company || $request->job_title) {
                $user->profile()->update($request->only([
                    'bio', 'website', 'location', 'company', 'job_title'
                ]));
            }

            Log::info('Admin created new user', [
                'admin_id' => auth('admin')->id(),
                'user_id' => $user->id,
                'user_email' => $user->email
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');

        } catch (\Exception $e) {
            Log::error('User creation failed', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);

            return redirect()->back()
                ->with('error', 'Failed to create user. Please try again.')
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function show(User $user)
    {
        $user->load(['profile', 'billingInfo', 'shippingInfo', 'sessions' => function($query) {
            $query->orderBy('login_at', 'desc')->limit(10);
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('profile');
        return view('admin.users.addedit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'email_verified' => 'boolean',
            // Profile fields
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
        ]);

        try {
            $data = $request->except(['password', 'password_confirmation']);

            // Handle password update
            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            // Handle email verification
            if ($request->email_verified && !$user->email_verified_at) {
                $data['email_verified_at'] = now();
            } elseif (!$request->email_verified && $user->email_verified_at) {
                $data['email_verified_at'] = null;
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $avatarPath;
            }

            $user->update($data);

            // Update profile
            $user->profile()->updateOrCreate([], $request->only([
                'bio', 'website', 'location', 'company', 'job_title'
            ]));

            Log::info('Admin updated user', [
                'admin_id' => auth('admin')->id(),
                'user_id' => $user->id,
                'user_email' => $user->email
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully.');

        } catch (\Exception $e) {
            Log::error('User update failed', [
                'admin_id' => auth('admin')->id(),
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to update user. Please try again.')
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function destroy(User $user)
    {
        try {
            // Delete avatar if exists
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Log before deletion
            Log::info('Admin deleted user', [
                'admin_id' => auth('admin')->id(),
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_name' => $user->name
            ]);

            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');

        } catch (\Exception $e) {
            Log::error('User deletion failed', [
                'admin_id' => auth('admin')->id(),
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to delete user. Please try again.');
        }
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $user->update(['status' => $request->status]);

            Log::info('Admin updated user status', [
                'admin_id' => auth('admin')->id(),
                'user_id' => $user->id,
                'old_status' => $user->getOriginal('status'),
                'new_status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
                'status' => $user->status
            ]);

        } catch (\Exception $e) {
            Log::error('User status update failed', [
                'admin_id' => auth('admin')->id(),
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }

    public function verifyEmail(User $user)
    {
        try {
            $user->update(['email_verified_at' => now()]);

            Log::info('Admin verified user email', [
                'admin_id' => auth('admin')->id(),
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Email verification failed', [
                'admin_id' => auth('admin')->id(),
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify email.'
            ], 500);
        }
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,verify_email,delete',
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        try {
            $users = User::whereIn('id', $request->users);
            $count = $users->count();

            switch ($request->action) {
                case 'activate':
                    $users->update(['status' => 'active']);
                    $message = "Activated {$count} users.";
                    break;

                case 'deactivate':
                    $users->update(['status' => 'inactive']);
                    $message = "Deactivated {$count} users.";
                    break;

                case 'verify_email':
                    $users->whereNull('email_verified_at')->update(['email_verified_at' => now()]);
                    $message = "Verified email for {$count} users.";
                    break;

                case 'delete':
                    // Delete avatars
                    foreach ($users->get() as $user) {
                        if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                            Storage::disk('public')->delete($user->avatar);
                        }
                    }
                    $users->delete();
                    $message = "Deleted {$count} users.";
                    break;
            }

            Log::info('Admin performed bulk action on users', [
                'admin_id' => auth('admin')->id(),
                'action' => $request->action,
                'users_count' => $count,
                'user_ids' => $request->users
            ]);

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk action failed', [
                'admin_id' => auth('admin')->id(),
                'action' => $request->action,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Bulk action failed.'
            ], 500);
        }
    }

    public function exportUsers(Request $request)
    {
        try {
            $query = User::with('profile');

            // Apply same filters as index
            if ($request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            if ($request->status && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            if ($request->verified && $request->verified !== 'all') {
                if ($request->verified === 'verified') {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            }

            $users = $query->orderBy('created_at', 'desc')->get();

            $filename = 'users_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function() use ($users) {
                $file = fopen('php://output', 'w');
                
                // CSV Headers
                fputcsv($file, [
                    'ID', 'Name', 'Email', 'Phone', 'Status', 'Email Verified', 
                    'Date of Birth', 'Gender', 'Company', 'Job Title', 
                    'Location', 'Website', 'Registered At', 'Last Login'
                ]);

                // Data rows
                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->phone,
                        ucfirst($user->status),
                        $user->email_verified_at ? 'Yes' : 'No',
                        $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '',
                        $user->gender ? ucfirst($user->gender) : '',
                        $user->profile?->company ?? '',
                        $user->profile?->job_title ?? '',
                        $user->profile?->location ?? '',
                        $user->profile?->website ?? '',
                        $user->created_at->format('Y-m-d H:i:s'),
                        $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never'
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('User export failed', [
                'admin_id' => auth('admin')->id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Export failed. Please try again.');
        }
    }
}