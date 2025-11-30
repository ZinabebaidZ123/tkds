<?php

// Frontend Newsletter Controller
namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Exception;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255'
        ], [
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'name.max' => 'Name cannot exceed 255 characters'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Rate limiting
            $key = 'newsletter_subscribe_' . $request->ip();
            if (RateLimiter::tooManyAttempts($key, 3)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many attempts. Please try again later.'
                ], 429);
            }

            $email = strtolower(trim($request->email));
            $name = trim($request->name);

            // Check if already subscribed
            $existing = Newsletter::where('email', $email)->first();
            
            if ($existing) {
                if ($existing->isActive()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are already subscribed to our newsletter!'
                    ], 409);
                } else {
                    // Reactivate subscription
                    $existing->resubscribe();
                    if ($name) {
                        $existing->update(['name' => $name]);
                    }
                    
                    Log::info('Newsletter resubscription', [
                        'email' => $email,
                        'previous_status' => $existing->status
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Welcome back! Your subscription has been reactivated.'
                    ]);
                }
            }

            // Create new subscription
            $newsletter = Newsletter::create([
                'email' => $email,
                'name' => $name,
                'status' => Newsletter::STATUS_ACTIVE,
                'source' => 'website',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'metadata' => [
                    'subscribed_at' => now()->toISOString(),
                    'referrer' => $request->header('referer'),
                    'user_agent' => $request->userAgent()
                ]
            ]);

            RateLimiter::hit($key, 300); // 5 minutes

            Log::info('Newsletter subscription created', [
                'id' => $newsletter->id,
                'email' => $email,
                'source' => 'website'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing! Welcome to our newsletter.'
            ]);

        } catch (Exception $e) {
            Log::error('Newsletter subscription failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function unsubscribe(Request $request, $email = null)
    {
        $email = $email ?: $request->email;
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Email address is required'
            ], 400);
        }

        try {
            $newsletter = Newsletter::where('email', strtolower(trim($email)))->first();
            
            if (!$newsletter) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not found in our records'
                ], 404);
            }

            if ($newsletter->isUnsubscribed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already unsubscribed'
                ], 409);
            }

            $newsletter->unsubscribe();

            Log::info('Newsletter unsubscription', [
                'id' => $newsletter->id,
                'email' => $email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'You have been successfully unsubscribed'
            ]);

        } catch (Exception $e) {
            Log::error('Newsletter unsubscription failed', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }
}