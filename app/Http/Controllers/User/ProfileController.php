<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBillingInfo;
use App\Models\UserShippingInfo;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the profile page
     */
    public function index()
    {
        $user = Auth::user()->load(['profile', 'billingInfo', 'shippingInfo']);
        $sessions = $user->sessions()->orderBy('login_at', 'desc')->paginate(10);
        
        return view('user.profile', compact('user', 'sessions'));
    }

    /**
     * Update personal information
     */
    public function updatePersonal(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:10',
        ]);

        try {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            // Update user basic info
            $user->update([
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'avatar' => $user->avatar,
            ]);

            // Update or create profile
            $user->profile()->updateOrCreate([], [
                'bio' => $request->bio,
                'website' => $request->website,
                'location' => $request->location,
                'company' => $request->company,
                'job_title' => $request->job_title,
                'timezone' => $request->timezone,
                'language' => $request->language,
            ]);

            return redirect()->route('user.profile')
                ->with('success', 'Profile updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Profile update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Store billing information
     */
    public function storeBilling(Request $request)
    {
        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'boolean',
        ]);

        $user = Auth::user();
        
        $billingInfo = $user->billingInfo()->create($request->all());

        if ($request->is_default || $user->billingInfo()->count() === 1) {
            $billingInfo->makeDefault();
        }

        return redirect()->route('user.profile')
            ->with('success', 'Billing information added successfully.');
    }

    /**
     * Update billing information
     */
    public function updateBilling(Request $request, UserBillingInfo $billing)
    {
        if ($billing->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'boolean',
        ]);

        $billing->update($request->all());

        if ($request->is_default) {
            $billing->makeDefault();
        }

        return redirect()->route('user.profile')
            ->with('success', 'Billing information updated successfully.');
    }

    /**
     * Delete billing information
     */
    public function deleteBilling(UserBillingInfo $billing)
    {
        if ($billing->user_id !== Auth::id()) {
            abort(403);
        }

        $billing->delete();

        return redirect()->route('user.profile')
            ->with('success', 'Billing information deleted successfully.');
    }

    /**
     * Store shipping information
     */
    public function storeShipping(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'nullable|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'delivery_instructions' => 'nullable|string|max:500',
            'is_default' => 'boolean',
        ]);

        $user = Auth::user();
        
        $shippingInfo = $user->shippingInfo()->create($request->all());

        if ($request->is_default || $user->shippingInfo()->count() === 1) {
            $shippingInfo->makeDefault();
        }

        return redirect()->route('user.profile')
            ->with('success', 'Shipping information added successfully.');
    }

    /**
     * Update shipping information
     */
    public function updateShipping(Request $request, UserShippingInfo $shipping)
    {
        if ($shipping->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'nullable|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'delivery_instructions' => 'nullable|string|max:500',
            'is_default' => 'boolean',
        ]);

        $shipping->update($request->all());

        if ($request->is_default) {
            $shipping->makeDefault();
        }

        return redirect()->route('user.profile')
            ->with('success', 'Shipping information updated successfully.');
    }

    /**
     * Delete shipping information
     */
    public function deleteShipping(UserShippingInfo $shipping)
    {
        if ($shipping->user_id !== Auth::id()) {
            abort(403);
        }

        $shipping->delete();

        return redirect()->route('user.profile')
            ->with('success', 'Shipping information deleted successfully.');
    }

    /**
     * Show sessions page
     */
    public function sessions()
    {
        $user = Auth::user();
        $sessions = $user->sessions()
            ->orderBy('login_at', 'desc')
            ->paginate(15);

        return view('user.sessions', compact('user', 'sessions'));
    }

    /**
     * Terminate a session
     */
    public function terminateSession(Request $request, $sessionId)
    {
        $user = Auth::user();
        $session = $user->sessions()->where('session_id', $sessionId)->first();

        if ($session) {
            $session->markAsLoggedOut();
            return redirect()->route('user.sessions')
                ->with('success', 'Session terminated successfully.');
        }

        return redirect()->route('user.sessions')
            ->with('error', 'Session not found.');
    }

    /**
     * Delete user account
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirmation' => 'required|in:DELETE',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Password is incorrect.']);
        }

        try {
            // Delete avatar if exists
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Log account deletion
            \Log::info('User account deleted', [
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
            ]);

            // Logout and delete
            Auth::logout();
            $user->delete();

            return redirect()->route('home')
                ->with('success', 'Your account has been deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Account deletion failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to delete account. Please try again.');
        }
    }
}