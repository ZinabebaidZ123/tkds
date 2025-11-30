<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ReCaptchaService;

class ReCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ReCaptchaService::class, function ($app) {
            return new ReCaptchaService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}