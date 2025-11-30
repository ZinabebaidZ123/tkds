<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSession;
use App\Services\ReCaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private ReCaptchaService $recaptchaService;

    public function __construct(ReCaptchaService $recaptchaService)
    {
        $this->recaptchaService = $recaptchaService;
    }

    /**
     * Show the registration form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        
        return view('auth.register');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ];

        // Add reCAPTCHA validation if enabled
        $recaptchaRules = $this->recaptchaService->getValidationRule('register');
        $rules = array_merge($rules, $recaptchaRules);

        $messages = [
            'name.required' => 'Full name is required.',
            'name.min' => 'Name must be at least 2 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms.required' => 'You must agree to the terms and conditions.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            // Create the user
            $user = User::create([
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'status' => 'active',
                'email_verified_at' => now(), // Auto-verify for now
            ]);

            // Log the registration
            \Log::info('New user registered', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'ip' => $request->ip(),
                'recaptcha_enabled' => $this->recaptchaService->shouldShow('register', $request)
            ]);

            // Log the user in
            Auth::login($user);

            // Create session record
            $this->createUserSession($user, $request);

            // Update last login
            $user->updateLastLogin();

            return redirect()->route('user.dashboard')
                ->with('success', 'Welcome to TKDS Media! Your account has been created successfully.');

        } catch (\Exception $e) {
            \Log::error('User registration failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return redirect()->back()
                ->withErrors(['registration' => 'Registration failed. Please try again.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    /**
     * Show the login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        // Base validation rules
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        // Add reCAPTCHA validation if enabled
        $recaptchaRules = $this->recaptchaService->getValidationRule('login');
        $rules = array_merge($rules, $recaptchaRules);

        $messages = [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = [
            'email' => strtolower(trim($request->email)),
            'password' => $request->password
        ];
        
        $remember = $request->has('remember');

        try {
            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();
                
                // Check if user is active
                if (!$user->isActive()) {
                    Auth::logout();
                    return redirect()->back()
                        ->withErrors(['email' => 'Your account is inactive. Please contact support.'])
                        ->withInput($request->except('password'));
                }

                $request->session()->regenerate();

                // Create session record
                $this->createUserSession($user, $request);

                // Update last login
                $user->updateLastLogin();

                // Log successful login
                \Log::info('User logged in', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $request->ip(),
                    'recaptcha_enabled' => $this->recaptchaService->shouldShow('login', $request)
                ]);

                return redirect()->intended(route('user.dashboard'))
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            }

            // Invalid credentials
            return redirect()->back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->withInput($request->except('password'));

        } catch (\Exception $e) {
            \Log::error('Login error', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return redirect()->back()
                ->withErrors(['email' => 'Something went wrong. Please try again.'])
                ->withInput($request->except('password'));
        }
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            // Mark session as logged out
            UserSession::where('user_id', $user->id)
                ->where('session_id', session()->getId())
                ->where('is_active', true)
                ->update([
                    'logout_at' => now(),
                    'is_active' => false
                ]);

            \Log::info('User logged out', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Create a session record for the user
     */
    private function createUserSession(User $user, Request $request)
    {
        try {
            $userAgent = $request->userAgent();
            $deviceInfo = $this->parseUserAgent($userAgent);

            UserSession::create([
                'user_id' => $user->id,
                'session_id' => session()->getId(),
                'ip_address' => $request->ip(),
                'user_agent' => $userAgent,
                'device_type' => $deviceInfo['device_type'],
                'browser' => $deviceInfo['browser'],
                'platform' => $deviceInfo['platform'],
                'location_country' => null, // You can add GeoIP later
                'location_city' => null,
                'login_at' => now(),
                'is_active' => true
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create user session', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Parse user agent to get device info
     */
    private function parseUserAgent($userAgent): array
    {
        $deviceType = 'desktop';
        $browser = 'Unknown';
        $platform = 'Unknown';

        // Detect device type
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            if (preg_match('/iPad/', $userAgent)) {
                $deviceType = 'tablet';
            } else {
                $deviceType = 'mobile';
            }
        }

        // Detect browser
        if (preg_match('/Chrome/', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox/', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari/', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge/', $userAgent)) {
            $browser = 'Edge';
        }

        // Detect platform
        if (preg_match('/Windows/', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/Mac/', $userAgent)) {
            $platform = 'macOS';
        } elseif (preg_match('/Linux/', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/Android/', $userAgent)) {
            $platform = 'Android';
        } elseif (preg_match('/iOS/', $userAgent)) {
            $platform = 'iOS';
        }

        return [
            'device_type' => $deviceType,
            'browser' => $browser,
            'platform' => $platform
        ];
    }
}