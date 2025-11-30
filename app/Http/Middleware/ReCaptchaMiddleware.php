<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ReCaptchaService;
use Symfony\Component\HttpFoundation\Response;

class ReCaptchaMiddleware
{
    private ReCaptchaService $recaptchaService;

    public function __construct(ReCaptchaService $recaptchaService)
    {
        $this->recaptchaService = $recaptchaService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $form = null): Response
    {
        // Only check POST requests
        if (!$request->isMethod('POST')) {
            return $next($request);
        }

        // Determine form type if not provided
        if (!$form) {
            $form = $this->detectFormType($request);
        }

        // Skip if form type not supported
        if (!$form) {
            return $next($request);
        }

        // Verify reCAPTCHA
        if (!$this->recaptchaService->verifyForForm($form, $request)) {
            return $this->handleFailure($request, $form);
        }

        return $next($request);
    }

    /**
     * Detect form type from request
     */
    private function detectFormType(Request $request): ?string
    {
        $route = $request->route();
        if (!$route) {
            return null;
        }

        $routeName = $route->getName();
        $uri = $request->getRequestUri();

        // Detect based on route name
        if (str_contains($routeName, 'login')) {
            return 'login';
        }
        
        if (str_contains($routeName, 'register')) {
            return 'register';
        }
        
        if (str_contains($routeName, 'contact')) {
            return 'contact';
        }
        
        if (str_contains($routeName, 'comment')) {
            return 'comment';
        }

        // Detect based on URI
        if (str_contains($uri, '/login')) {
            return 'login';
        }
        
        if (str_contains($uri, '/register')) {
            return 'register';
        }
        
        if (str_contains($uri, '/contact')) {
            return 'contact';
        }

        return null;
    }

    /**
     * Handle reCAPTCHA verification failure
     */
    private function handleFailure(Request $request, string $form): Response
    {
        $settings = $this->recaptchaService->getSettings();
        $errorMessage = $settings->custom_error_message ?: 'Please verify that you are not a robot.';

        // Handle AJAX requests
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'errors' => [
                    'g-recaptcha-response' => [$errorMessage]
                ]
            ], 422);
        }

        // Handle regular form submissions
        return redirect()->back()
            ->withErrors(['g-recaptcha-response' => $errorMessage])
            ->withInput($request->except(['password', 'password_confirmation', 'g-recaptcha-response']));
    }
}