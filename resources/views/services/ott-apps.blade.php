@extends('layouts.app')

@section('title', 'OTT Apps Development - TKDS Media')
@section('meta_description', 'Professional OTT app development for Roku, iOS, Android, Smart TV, Fire TV and all platforms. Custom streaming apps with seamless user experience.')

@section('content')

{{-- Hero Section --}}
@include('components.services.hero', [
    'badgeIcon' => 'fas fa-mobile-alt',
    'badgeText' => 'OTT App Development',
    'badgeColor' => 'secondary',
    'primaryColor' => 'secondary',
    'secondaryColor' => 'accent',
    'accentColor' => 'primary',
    'mainTitle' => 'OTT APPS for',
    'highlightTitle' => 'Every Platform',
    'gradientFrom' => 'secondary',
    'gradientVia' => 'accent',
    'gradientTo' => 'primary',
    'description' => 'Empower your audience to access your content anytime, anywhere with comprehensive OTT apps across Roku, iOS, Android, Smart TVs, Fire TV, and beyond.',
    'primaryButtonText' => 'Explore Platforms',
    'primaryButtonLink' => '#platforms',
    'primaryButtonFrom' => 'secondary',
    'primaryButtonTo' => 'accent',
    'primaryButtonHoverFrom' => 'accent',
    'primaryButtonHoverTo' => 'primary',
    'secondaryButtonText' => 'View Features',
    'secondaryButtonLink' => '#features',
    'heroImage' => asset('images/ott-apps-hero.svg'),
    'imageAlt' => 'OTT Apps Hero Image',
    'floatingElements' => [
        [
            'position' => 'top-32 right-32',
            'size' => '8',
            'color' => 'secondary',
            'opacity' => '40',
            'icon' => 'fab fa-apple',
            'iconSize' => 'sm',
            'delay' => '0'
        ],
        [
            'position' => 'bottom-40 left-20',
            'size' => '6',
            'color' => 'primary',
            'opacity' => '30',
            'icon' => 'fab fa-android',
            'iconSize' => 'xs',
            'delay' => '1'
        ],
        [
            'position' => 'top-60 left-1/4',
            'size' => '10',
            'color' => 'accent',
            'opacity' => '20',
            'icon' => 'fas fa-tv',
            'iconSize' => 'sm',
            'delay' => '3'
        ]
    ],
    'floatingCards' => [
        [
            'position' => '-top-6 -left-6',
            'icon' => 'fab fa-android',
            'color' => 'green-500'
        ],
        [
            'position' => '-bottom-6 -right-6',
            'icon' => 'fab fa-apple',
            'color' => 'gray-300',
            'delay' => '2'
        ],
        [
            'position' => 'top-1/2 -right-12',
            'icon' => 'fas fa-tv',
            'color' => 'blue-500',
            'delay' => '1'
        ]
    ]
])

{{-- Platforms Showcase Section --}}
@include('components.services.platforms-showcase', [
    'sectionId' => 'platforms',
    'bgColor' => 'dark-light',
    'headerHighlight' => 'Multi-Platform',
    'headerTitle' => 'Excellence',
    'headerDescription' => 'Reach your audience wherever they are with our comprehensive OTT app solutions across all major platforms and devices.',
    'gridCols' => '3',
    'platforms' => [
        [
            'icon' => 'fas fa-tv',
            'colorFrom' => 'purple-600',
            'colorTo' => 'purple-800',
            'borderColor' => 'purple-500',
            'title' => 'Roku App',
            'description' => 'Dive into the world of streaming with our Roku app. Offering an intuitive user interface and seamless navigation, it\'s never been easier for Roku users to discover and enjoy your content.',
            'checkColor' => 'purple-400',
            'features' => [
                'Intuitive user interface',
                'Seamless navigation',
                'Easy content discovery'
            ]
        ],
        [
            'icon' => 'fab fa-apple',
            'colorFrom' => 'gray-400',
            'colorTo' => 'gray-600',
            'borderColor' => 'gray-300',
            'title' => 'iOS App',
            'description' => 'Cater to Apple enthusiasts with our iOS app. Designed for optimal performance on iPhones and iPads, it provides a smooth and immersive streaming experience.',
            'checkColor' => 'gray-400',
            'features' => [
                'Optimized for iPhone & iPad',
                'Customizable features',
                'Intuitive controls'
            ]
        ],
        [
            'icon' => 'fab fa-android',
            'colorFrom' => 'green-500',
            'colorTo' => 'green-700',
            'borderColor' => 'green-500',
            'title' => 'Android App',
            'description' => 'Reach the vast Android user base with our feature-rich Android app. Compatible with smartphones, tablets, and Android TV devices for seamless content access.',
            'checkColor' => 'green-400',
            'features' => [
                'Multi-device compatibility',
                'User-friendly interface',
                'Robust streaming capabilities'
            ]
        ],
        [
            'icon' => 'fas fa-desktop',
            'colorFrom' => 'blue-500',
            'colorTo' => 'blue-700',
            'borderColor' => 'blue-500',
            'title' => 'Smart TV App',
            'description' => 'Make your content easily accessible on Smart TVs. Compatible with a wide range of manufacturers and models, ensuring stunning HD viewing experiences.',
            'checkColor' => 'blue-400',
            'features' => [
                'Wide manufacturer support',
                'High-definition streaming',
                'Living room optimized'
            ]
        ],
        [
            'icon' => 'fab fa-amazon',
            'colorFrom' => 'orange-500',
            'colorTo' => 'orange-700',
            'borderColor' => 'orange-500',
            'title' => 'Fire TV App',
            'description' => 'Tap into the Amazon ecosystem with our Fire TV app. Optimized for Fire TV devices with seamless Alexa voice controls integration.',
            'checkColor' => 'orange-400',
            'features' => [
                'Alexa voice integration',
                'Fire TV optimized',
                'Rich content selection'
            ]
        ],
        [
            'icon' => 'fas fa-plus',
            'colorFrom' => 'accent',
            'colorTo' => 'secondary',
            'borderColor' => 'accent',
            'title' => 'More Platforms',
            'description' => 'We support additional platforms including Apple TV, Xbox, PlayStation, Samsung Tizen, LG webOS, and emerging platforms as they develop.',
            'checkColor' => 'accent',
            'features' => [
                'Apple TV & Gaming consoles',
                'Samsung Tizen & LG webOS',
                'Future platform support'
            ]
        ]
    ]
])

{{-- Why Choose Us Section (Features Style) --}}
@include('components.services.why-choose-us', [
    'bgColor' => 'dark',
    'companyName' => 'TKDS Media',
    'description' => 'Deliver an unparalleled streaming experience across all platforms with our meticulously crafted OTT apps.',
    'benefits' => [
        [
            'icon' => 'fas fa-rocket',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Smooth Performance',
            'description' => 'Optimized apps ensuring smooth streaming and responsive performance across all devices and platforms.'
        ],
        [
            'icon' => 'fas fa-compass',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Intuitive Navigation',
            'description' => 'User-friendly interfaces designed for easy content discovery and seamless browsing experiences.'
        ],
        [
            'icon' => 'fas fa-user-cog',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Personalized Features',
            'description' => 'Customizable features and personalized recommendations to maximize user engagement and satisfaction.'
        ],
        [
            'icon' => 'fas fa-headset',
            'colorFrom' => 'primary',
            'colorTo' => 'accent',
            'title' => 'End-to-End Support',
            'description' => 'Complete support from development to maintenance, with ongoing updates and enhancements.'
        ]
    ],
    'process' => [
        'title' => 'Our Development Process',
        'description' => 'From concept to launch, we provide comprehensive app development services',
        'steps' => [
            [
                'color' => 'primary',
                'title' => 'Planning & Design',
                'description' => 'UI/UX design and platform-specific optimization'
            ],
            [
                'color' => 'secondary',
                'title' => 'Development',
                'description' => 'Native app development for each platform'
            ],
            [
                'color' => 'accent',
                'title' => 'Testing & QA',
                'description' => 'Comprehensive testing across all target devices'
            ],
            [
                'color' => 'primary',
                'title' => 'Launch & Support',
                'description' => 'App store deployment and ongoing maintenance'
            ]
        ]
    ]
])

{{-- CTA Section --}}
@include('components.services.cta-section', [
    'bgColor' => 'dark-light',
    'bgEffect1' => 'secondary',
    'bgEffect2' => 'accent',
    'titleStart' => 'Ready to',
    'highlightText' => 'Expand Your Reach',
    'titleEnd' => '?',
    'description' => 'Partner with TKDS Media and unlock the full potential of OTT apps for your production. Revolutionize the way you connect with your audience across all platforms.',
    'primaryButtonText' => 'Start Your Project',
    'primaryButtonLink' => route('contact'),
    'buttonFrom' => 'secondary',
    'buttonTo' => 'accent',
    'buttonHoverFrom' => 'accent',
    'buttonHoverTo' => 'primary',
    'secondaryButtonText' => 'View Pricing',
    'secondaryButtonLink' => route('pricing')
])

{{-- Related Services Section --}}
@include('components.services.related-services', [
    'bgColor' => 'dark',
    'title' => 'Complete Your OTT Ecosystem',
    'subtitle' => 'Combine our OTT apps with these complementary services',
    'services' => [
        [
            'icon' => 'fas fa-tv',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'OTT Platform',
            'description' => 'Complete backend platform to power your apps',
            'link' => route('services.ott-platform'),
            'linkColor' => 'accent',
            'linkHoverColor' => 'primary'
        ],
        [
            'icon' => 'fas fa-server',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Streaming Service',
            'description' => 'High-performance streaming infrastructure',
            'link' => route('services.streaming-service'),
            'linkColor' => 'primary',
            'linkHoverColor' => 'secondary'
        ],
        [
            'icon' => 'fas fa-cloud',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Cloud Servers',
            'description' => '24/7 cloud infrastructure for your content',
            'link' => route('services.cloud-servers'),
            'linkColor' => 'secondary',
            'linkHoverColor' => 'accent'
        ]
    ]
])

@endsection