@extends('layouts.app')

@section('title', 'Stream & Restream Services - TKDS Media')
@section('meta_description', 'Professional streaming and restreaming solutions with social media publication. Live streaming, on-demand content, and multi-platform distribution.')

@section('content')

{{-- Hero Section --}}
@include('components.services.hero', [
    'badgeIcon' => 'fas fa-broadcast-tower',
    'badgeText' => 'Streaming Solutions',
    'badgeColor' => 'primary',
    'primaryColor' => 'primary',
    'secondaryColor' => 'secondary',
    'accentColor' => 'accent',
    'mainTitle' => 'Stream &',
    'highlightTitle' => 'Restream',
    'subtitleLine' => 'Like a Pro',
    'gradientFrom' => 'primary',
    'gradientVia' => 'secondary',
    'gradientTo' => 'accent',
    'description' => 'Professional streaming solutions with social media publication. Broadcast live events, engage global audiences, and amplify your reach across all platforms simultaneously.',
    'primaryButtonText' => 'Explore Features',
    'primaryButtonLink' => '#features',
    'primaryButtonFrom' => 'primary',
    'primaryButtonTo' => 'secondary',
    'primaryButtonHoverFrom' => 'secondary',
    'primaryButtonHoverTo' => 'accent',
    'secondaryButtonText' => 'View Pricing',
    'secondaryButtonLink' => '#pricing',
    'heroImage' => asset('images/streaming-illustration.svg'),
    'imageAlt' => 'Streaming Illustration',
    'floatingElements' => [
        [
            'position' => 'top-32 right-32',
            'size' => '6',
            'color' => 'primary',
            'opacity' => '40',
            'icon' => 'fas fa-play',
            'iconSize' => 'sm',
            'delay' => '0'
        ],
        [
            'position' => 'bottom-40 left-20',
            'size' => '4',
            'color' => 'secondary',
            'opacity' => '30',
            'icon' => 'fas fa-share-alt',
            'iconSize' => 'xs',
            'delay' => '1'
        ],
        [
            'position' => 'top-60 left-1/4',
            'size' => '8',
            'color' => 'accent',
            'opacity' => '20',
            'icon' => 'fas fa-broadcast-tower',
            'iconSize' => 'sm',
            'delay' => '3'
        ]
    ],
    'floatingCards' => [
        [
            'position' => '-top-6 -left-6',
            'icon' => 'fas fa-play',
            'color' => 'primary'
        ],
        [
            'position' => '-bottom-6 -right-6',
            'icon' => 'fas fa-share-alt',
            'color' => 'secondary',
            'delay' => '2'
        ]
    ]
])

<!-- Services Overview -->
<section id="features" class="py-20 bg-dark-light relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Comprehensive <span class="text-gradient">Streaming Solutions</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                At TKDS Media, we offer cutting-edge streaming solutions tailored to meet the dynamic needs of modern media consumption.
            </p>
        </div>

        <!-- Main Services Grid -->
        <div class="grid md:grid-cols-2 gap-12 mb-20">
            
            <!-- Live Streaming -->
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-effect rounded-3xl p-8 h-full hover:bg-white/10 transition-all duration-500">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-video text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white">Live Streaming</h3>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        Seamlessly broadcast your events, presentations, webinars, and more to a global audience in high-definition quality. Our robust infrastructure ensures reliable streaming without buffering, providing an immersive experience for viewers.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-accent mr-3"></i>
                            <span>High-definition quality streaming</span>
                        </li>
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-accent mr-3"></i>
                            <span>Global audience reach</span>
                        </li>
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-accent mr-3"></i>
                            <span>Zero buffering guarantee</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- On-Demand Streaming -->
            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-effect rounded-3xl p-8 h-full hover:bg-white/10 transition-all duration-500">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-secondary to-accent rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-play-circle text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white">On-Demand Streaming</h3>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        Cater to diverse viewer preferences with on-demand access to your pre-recorded content. Our platform supports smooth playback across devices, allowing audiences to enjoy your videos at their convenience.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-accent mr-3"></i>
                            <span>Cross-device compatibility</span>
                        </li>
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-accent mr-3"></i>
                            <span>Smooth playback experience</span>
                        </li>
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-accent mr-3"></i>
                            <span>Flexible viewing schedules</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Restreaming Section with Social Integration -->
        @include('components.services.platforms-showcase', [
            'sectionId' => 'social-restreaming',
            'bgColor' => 'transparent',
            'headerHighlight' => '',
            'headerTitle' => '',
            'headerDescription' => '',
            'platforms' => [],
            'socialIntegration' => [
                'title' => 'Restreaming to Social Media',
                'description' => 'Extend your reach and amplify your message with our restreaming capabilities. Effortlessly distribute your live streams to popular social media platforms simultaneously.',
                'colorFrom' => 'accent',
                'colorTo' => 'primary',
                'icon' => 'fas fa-share-alt',
                'platforms' => [
                    [
                        'name' => 'Facebook',
                        'description' => 'Live to Facebook Pages & Groups',
                        'icon' => 'fab fa-facebook-f',
                        'bgColor' => 'blue-600'
                    ],
                    [
                        'name' => 'YouTube',
                        'description' => 'Stream to YouTube Live',
                        'icon' => 'fab fa-youtube',
                        'bgColor' => 'red-600'
                    ],
                    [
                        'name' => 'Twitter',
                        'description' => 'Broadcast on Twitter Spaces',
                        'icon' => 'fab fa-twitter',
                        'bgColor' => 'blue-400'
                    ],
                    [
                        'name' => 'LinkedIn',
                        'description' => 'Professional live streaming',
                        'icon' => 'fab fa-linkedin',
                        'bgColor' => 'blue-700'
                    ]
                ]
            ]
        ])

        <!-- Key Features -->
        <div class="mb-20" data-aos="fade-up" data-aos-delay="400">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-white mb-4">Key Features</h3>
                <p class="text-gray-400">Advanced capabilities that set our streaming solutions apart</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Multi-Platform -->
                <div class="glass-effect rounded-2xl p-6 text-center hover:bg-white/10 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sitemap text-white text-xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">Multi-Platform Compatibility</h4>
                    <p class="text-gray-400 text-sm">
                        Our versatile platform seamlessly integrates with leading social media networks, enabling hassle-free restreaming with just a few clicks.
                    </p>
                </div>

                <!-- Analytics -->
                <div class="glass-effect rounded-2xl p-6 text-center hover:bg-white/10 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-secondary to-accent rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">Real-Time Analytics</h4>
                    <p class="text-gray-400 text-sm">
                        Gain valuable insights into viewer engagement and performance metrics with our intuitive analytics dashboard.
                    </p>
                </div>

                <!-- Branding -->
                <div class="glass-effect rounded-2xl p-6 text-center hover:bg-white/10 transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-accent to-primary rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-paint-brush text-white text-xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">Custom Branding</h4>
                    <p class="text-gray-400 text-sm">
                        Maintain brand consistency across all channels with customizable branding options, logos, overlays, and graphics.
                    </p>
                </div>
            </div>
        </div>

        {{-- Why Choose Us with Stats --}}
        @include('components.services.why-choose-us', [
            'bgColor' => 'transparent',
            'companyName' => 'TKDS Media',
            'description' => 'With years of expertise in the streaming industry, TKDS Media is your trusted partner for all your streaming needs. Our dedicated support team ensures a smooth streaming experience from setup to delivery, providing expert guidance and technical assistance every step of the way.',
            'benefits' => [],
            'stats' => [
                'title' => 'Why Choose TKDS Media?',
                'description' => 'With years of expertise in the streaming industry, TKDS Media is your trusted partner for all your streaming needs.',
                'items' => [
                    [
                        'number' => '24/7',
                        'label' => 'Expert Support',
                        'color' => 'primary'
                    ],
                    [
                        'number' => '99.9%',
                        'label' => 'Uptime Guarantee',
                        'color' => 'secondary'
                    ],
                    [
                        'number' => '50+',
                        'label' => 'Platforms Supported',
                        'color' => 'accent'
                    ],
                    [
                        'number' => '1000+',
                        'label' => 'Happy Clients',
                        'color' => 'primary'
                    ]
                ]
            ]
        ])
    </div>
</section>

{{-- CTA Section --}}
@include('components.services.cta-section', [
    'bgColor' => 'dark',
    'bgEffect1' => 'primary',
    'bgEffect2' => 'secondary',
    'titleStart' => 'Ready to',
    'highlightText' => 'Revolutionize',
    'titleEnd' => 'Your Streaming?',
    'description' => 'Elevate your online presence and captivate audiences worldwide with TKDS Media\'s comprehensive streaming and restreaming solutions.',
    'primaryButtonText' => 'Get Started Today',
    'primaryButtonLink' => route('contact'),
    'buttonFrom' => 'primary',
    'buttonTo' => 'secondary',
    'buttonHoverFrom' => 'secondary',
    'buttonHoverTo' => 'accent',
    'secondaryButtonText' => 'View Pricing Plans',
    'secondaryButtonLink' => route('pricing')
])

{{-- Related Services Section --}}
@include('components.services.related-services', [
    'bgColor' => 'dark-light',
    'title' => 'Explore Other Services',
    'subtitle' => 'Discover more ways TKDS Media can transform your content',
    'services' => [
        [
            'icon' => 'fas fa-tv',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'OTT Platform',
            'description' => 'Complete OTT solution with custom apps and monetization',
            'link' => route('services.ott-platform'),
            'linkColor' => 'primary',
            'linkHoverColor' => 'secondary'
        ],
        [
            'icon' => 'fas fa-cloud',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Cloud Servers',
            'description' => 'Professional 24/7 playout servers for IPTV',
            'link' => route('services.cloud-servers'),
            'linkColor' => 'secondary',
            'linkHoverColor' => 'accent'
        ],
        [
            'icon' => 'fas fa-futbol',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Sports Production',
            'description' => 'Professional live sports production services',
            'link' => route('services.sports-production'),
            'linkColor' => 'accent',
            'linkHoverColor' => 'primary'
        ]
    ]
])

@endsection