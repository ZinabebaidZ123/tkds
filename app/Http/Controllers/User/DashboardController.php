<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard
     */
    public function index()
    {
        $user = Auth::user()->load(['profile', 'billingInfo', 'shippingInfo']);
        
        // Calculate statistics
        $stats = [
            'profile_completion' => $this->calculateProfileCompletion($user),
            'total_logins' => $user->sessions()->count(),
            'billing_addresses' => $user->billingInfo()->count(),
            'shipping_addresses' => $user->shippingInfo()->count(),
            'recent_sessions' => $user->sessions()
                ->orderBy('login_at', 'desc')
                ->limit(5)
                ->get(),
        ];

        return view('user.dashboard', compact('user', 'stats'));
    }

    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion(User $user): int
    {
        $fields = [
            'name' => !empty($user->name),
            'email' => !empty($user->email),
            'phone' => !empty($user->phone),
            'avatar' => !empty($user->avatar),
            'date_of_birth' => !empty($user->date_of_birth),
            'bio' => !empty($user->profile?->bio),
            'location' => !empty($user->profile?->location),
            'website' => !empty($user->profile?->website),
        ];

        $completed = array_sum($fields);
        $total = count($fields);

        return round(($completed / $total) * 100);
    }
}