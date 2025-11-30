@extends('layouts.app')

@section('title', 'Cookie Policy - TKDS Media')
@section('meta_description', 'Learn about how TKDS Media uses cookies to enhance your browsing experience and protect your privacy.')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden">
    <!-- Magical Background -->
    <div class="absolute inset-0">
        <div class="absolute top-24 left-24 w-96 h-96 bg-gradient-to-r from-accent/20 to-primary/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-32 right-32 w-80 h-80 bg-gradient-to-l from-secondary/20 to-accent/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-primary/10 to-secondary/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 5s;"></div>
    </div>

    <!-- Floating Cookie Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        @for($i = 0; $i < 18; $i++)
            <div class="absolute animate-float opacity-20" 
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 6000) }}ms; animation-duration: {{ rand(12000, 25000) }}ms;">
                <i class="fas {{ ['fa-cookie-bite', 'fa-cookie', 'fa-user-shield', 'fa-cog', 'fa-chart-line', 'fa-eye'][array_rand(['fa-cookie-bite', 'fa-cookie', 'fa-user-shield', 'fa-cog', 'fa-chart-line', 'fa-eye'])] }} text-accent text-3xl"></i>
            </div>
        @endfor
    </div>

    <!-- Main Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div data-aos="fade-up">

            
            <!-- Stunning Title -->
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-black text-white mb-8 leading-tight">
                Cookie
                <span class="relative inline-block">
                    <span class="text-gradient bg-gradient-to-r from-accent via-primary to-secondary bg-clip-text text-transparent">Policy</span>
                    <!-- Animated Underline -->
                    <div class="absolute -bottom-4 left-0 right-0 h-3 bg-gradient-to-r from-accent via-primary to-secondary rounded-full opacity-60 animate-pulse"></div>
                    <!-- Cookie Crumbs -->
                    <div class="absolute -top-2 -right-2 w-4 h-4 bg-accent rounded-full animate-bounce"></div>
                    <div class="absolute -top-4 right-4 w-3 h-3 bg-primary rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
                    <div class="absolute -top-1 right-8 w-2 h-2 bg-secondary rounded-full animate-bounce" style="animation-delay: 1s;"></div>
                </span>
            </h1>
            
            <!-- Epic Subtitle -->
            <p class="text-2xl md:text-3xl text-gray-300 max-w-5xl mx-auto leading-relaxed mb-12">
                We use cookies to make your experience <span class="text-accent font-bold">sweeter</span>, 
                <span class="text-primary font-bold">faster</span>, and more <span class="text-secondary font-bold">personalized</span>
            </p>

            <!-- Cookie Types Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="200">
                @php
                    $cookieTypes = [
                        ['Essential', 'fa-shield-alt', 'from-primary to-secondary'],
                        ['Analytics', 'fa-chart-bar', 'from-secondary to-accent'],
                        ['Marketing', 'fa-bullhorn', 'from-accent to-primary'],
                        ['Preferences', 'fa-sliders-h', 'from-primary to-accent']
                    ];
                @endphp
                
                @foreach($cookieTypes as $type)
                    <div class="text-center group cursor-pointer">
                        <div class="w-18 h-18 bg-gradient-to-r {{ $type[2] }} rounded-3xl flex items-center justify-center mx-auto mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 shadow-xl">
                            <i class="fas {{ $type[1] }} text-white text-xl"></i>
                        </div>
                        <div class="text-lg font-bold text-white group-hover:text-accent transition-colors duration-300">{{ $type[0] }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center" data-aos="fade-up" data-aos-delay="400">
                <a href="#cookie-details" class="inline-flex items-center space-x-3 px-10 py-5 bg-gradient-to-r from-accent to-primary text-white font-bold rounded-2xl hover:from-primary hover:to-secondary transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-info-circle"></i>
                    <span>Learn About Cookies</span>
                </a>
                <button onclick="manageCookies()" class="inline-flex items-center space-x-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-cog"></i>
                    <span>Manage Preferences</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
        <div class="flex flex-col items-center space-y-3 animate-bounce">
            <div class="text-accent text-sm font-medium">Discover Cookie Details</div>
            <div class="w-8 h-12 border-2 border-accent/50 rounded-full flex justify-center">
                <div class="w-1 h-4 bg-accent rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </div>
</section>

<!-- Cookie Details Section -->
<section id="cookie-details" class="py-20 bg-gradient-to-b from-dark-light to-dark">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-white/5 to-white/10 backdrop-blur-xl rounded-full px-8 py-4 border border-white/10 mb-6">
                <i class="fas fa-info-circle text-accent"></i>
                <span class="text-gray-300">Last updated: December 2024</span>
            </div>
            <h2 class="text-5xl font-black text-white mb-6">What Are Cookies?</h2>
            <p class="text-gray-400 text-xl max-w-4xl mx-auto leading-relaxed">
                Cookies are small text files that websites place on your device to remember information about you. 
                Think of them as helpful digital assistants that make your browsing experience smoother and more personalized.
            </p>
        </div>

        <!-- Cookie Categories -->
        <div class="space-y-12">
            @php
                $cookieCategories = [
                    [
                        'title' => 'Essential Cookies',
                        'icon' => 'fa-shield-alt',
                        'gradient' => 'from-primary to-secondary',
                        'required' => true,
                        'description' => 'These cookies are absolutely necessary for our website to function properly. They enable core functionality like security, network management, and accessibility.',
                        'examples' => [
                            'Authentication - Keep you logged into your account',
                            'Security - Protect against cross-site request forgery',
                            'Load balancing - Distribute traffic across our servers',
                            'Accessibility - Remember your accessibility preferences'
                        ]
                    ],
                    [
                        'title' => 'Performance & Analytics Cookies',
                        'icon' => 'fa-chart-line',
                        'gradient' => 'from-secondary to-accent',
                        'required' => false,
                        'description' => 'These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously.',
                        'examples' => [
                            'Page views - Track which pages are most popular',
                            'User journey - Understand how users navigate our site',
                            'Performance metrics - Monitor loading times and errors',
                            'Traffic sources - See where our visitors come from'
                        ]
                    ],
                    [
                        'title' => 'Functional Cookies',
                        'icon' => 'fa-sliders-h',
                        'gradient' => 'from-accent to-primary',
                        'required' => false,
                        'description' => 'These cookies allow our website to remember choices you make and provide enhanced, more personal features.',
                        'examples' => [
                            'Language preferences - Remember your chosen language',
                            'Region settings - Store your location preferences',
                            'Theme selection - Keep your dark/light mode choice',
                            'Form data - Remember information you\'ve entered'
                        ]
                    ],
                    [
                        'title' => 'Marketing & Advertising Cookies',
                        'icon' => 'fa-bullhorn',
                        'gradient' => 'from-primary to-accent',
                        'required' => false,
                        'description' => 'These cookies track your browsing habits to enable us to show advertising which is more likely to be of interest to you.',
                        'examples' => [
                            'Ad personalization - Show relevant advertisements',
                            'Campaign tracking - Measure ad campaign effectiveness',
                            'Social media integration - Enable social sharing features',
                            'Retargeting - Display ads based on your interests'
                        ]
                    ]
                ];
            @endphp

            @foreach($cookieCategories as $index => $category)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="relative bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-10 border border-white/10 hover:border-white/20 transition-all duration-700 hover:shadow-2xl overflow-hidden">
                        <!-- Background Effects -->
                        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br {{ $category['gradient'] }} opacity-10 rounded-full blur-2xl transform translate-x-20 -translate-y-20 group-hover:scale-150 transition-transform duration-1000"></div>
                        
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-8">
                            <div class="flex items-center space-x-6">
                                <div class="w-20 h-20 bg-gradient-to-r {{ $category['gradient'] }} rounded-3xl flex items-center justify-center shadow-xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                    <i class="fas {{ $category['icon'] }} text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-black text-white group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:{{ $category['gradient'] }} group-hover:bg-clip-text transition-all duration-500 mb-2">
                                        {{ $category['title'] }}
                                    </h3>
                                    <div class="flex items-center space-x-3">
                                        @if($category['required'])
                                            <span class="inline-flex items-center px-3 py-1 bg-red-500/20 text-red-400 text-sm font-bold rounded-full border border-red-500/30">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                                Required
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-green-500/20 text-green-400 text-sm font-bold rounded-full border border-green-500/30">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                Optional
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @if(!$category['required'])
                                <div class="flex items-center space-x-3">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" checked>
                                        <div class="relative w-14 h-8 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-7 after:w-7 after:transition-all peer-checked:bg-gradient-to-r peer-checked:{{ $category['gradient'] }}"></div>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        <p class="text-gray-300 text-lg leading-relaxed mb-8 group-hover:text-white transition-colors duration-500">
                            {{ $category['description'] }}
                        </p>

                        <!-- Examples -->
                        <div class="space-y-4">
                            <h4 class="text-xl font-bold text-white mb-4">What we use these cookies for:</h4>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($category['examples'] as $example)
                                    <div class="flex items-start space-x-3 group/item">
                                        <div class="w-2 h-2 bg-gradient-to-r {{ $category['gradient'] }} rounded-full mt-3 group-hover/item:scale-150 transition-transform duration-300"></div>
                                        <p class="text-gray-400 group-hover/item:text-white transition-colors duration-300">
                                            <span class="font-semibold">{{ explode(' - ', $example)[0] }}</span> - {{ explode(' - ', $example)[1] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Cookie Management Section -->
        <div class="mt-20" data-aos="fade-up">
            <div class="relative bg-gradient-to-r from-accent/10 via-primary/10 to-secondary/10 backdrop-blur-xl rounded-3xl p-12 border border-accent/20 text-center overflow-hidden">
                <!-- Animated Background -->
                <div class="absolute inset-0 bg-gradient-to-r from-accent/5 to-primary/5 opacity-0 hover:opacity-100 transition-opacity duration-1000"></div>
                
                <!-- Content -->
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-gradient-to-r from-accent to-primary rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl">
                        <i class="fas fa-cog text-white text-3xl animate-spin" style="animation-duration: 3s;"></i>
                    </div>
                    <h3 class="text-4xl font-black text-white mb-6">Take Control of Your Cookies</h3>
                    <p class="text-gray-300 mb-10 text-xl max-w-3xl mx-auto leading-relaxed">
                        You have full control over your cookie preferences. Customize your experience by choosing which types of cookies you want to allow.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center">
                        <button onclick="manageCookies()" class="inline-flex items-center space-x-3 px-10 py-5 bg-gradient-to-r from-accent to-primary text-white font-bold rounded-2xl hover:from-primary hover:to-secondary transition-all duration-300 transform hover:scale-105 shadow-2xl">
                            <i class="fas fa-cog"></i>
                            <span>Manage Cookie Preferences</span>
                        </button>
                        <button onclick="acceptAllCookies()" class="inline-flex items-center space-x-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-check"></i>
                            <span>Accept All Cookies</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function manageCookies() {
    // Cookie management modal would open here
    alert('Cookie preference center would open here. This would allow users to toggle different cookie categories on/off.');
}

function acceptAllCookies() {
    // Accept all cookies
    alert('All cookies accepted! Thank you for trusting us with your data.');
}

// Animate cookie preference toggles
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('input[type="checkbox"]');
    toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            if (this.checked) {
                console.log('Cookie category enabled');
            } else {
                console.log('Cookie category disabled');
            }
        });
    });
});
</script>

@endsection