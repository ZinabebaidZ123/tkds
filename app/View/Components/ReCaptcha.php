<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\ReCaptchaService;

class ReCaptcha extends Component
{
    public string $form;
    public array $customAttributes;
    private ReCaptchaService $recaptchaService;

    /**
     * Create a new component instance.
     */
    public function __construct(string $form = 'default', array $customAttributes = [])
    {
        $this->form = $form;
        $this->customAttributes = $customAttributes;
        $this->recaptchaService = app(ReCaptchaService::class);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $settings = $this->recaptchaService->getSettings();
        
        // Check if reCAPTCHA should be shown
        if (!$this->recaptchaService->shouldShow($this->form, request())) {
            return '';
        }

        $config = $settings->getFrontendConfig();
        $html = $this->recaptchaService->generateHtml($this->form, $this->customAttributes);
        $javascript = $this->recaptchaService->getJavaScript($this->form);

        return view('components.recaptcha', compact('config', 'html', 'javascript', 'settings'));
    }

    /**
     * Check if reCAPTCHA is enabled for this form
     */
    public function isEnabled(): bool
    {
        return $this->recaptchaService->shouldShow($this->form, request());
    }
}