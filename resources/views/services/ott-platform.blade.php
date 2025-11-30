@extends('layouts.app')

@section('title', 'Cutting-Edge OTT Platform - TKDS Media')
@section('meta_description', 'Experience seamless content delivery with TKDS Media\'s cutting-edge OTT platform. User-friendly interface, customizable branding, multi-platform compatibility, and powerful analytics.')

@section('content')

{{-- Hero Section --}}
@include('components.services.hero', [
    'badgeIcon' => 'fas fa-tv',
    'badgeText' => 'OTT Platform',
    'badgeColor' => 'accent',
    'primaryColor' => 'accent',
    'secondaryColor' => 'primary',
    'accentColor' => 'secondary',
    'mainTitle' => 'Cutting-Edge',
    'highlightTitle' => 'OTT Platform',
    'subtitleLine' => 'That Fits Your Needs',
    'gradientFrom' => 'accent',
    'gradientVia' => 'primary',
    'gradientTo' => 'secondary',
    'description' => 'Experience seamless content delivery like never before with TKDS Media\'s state-of-the-art OTT platform. Designed to meet the evolving demands of modern audiences, our platform offers a comprehensive solution for distributing and managing your video content with ease.',
    'primaryButtonText' => 'Explore Features',
    'primaryButtonLink' => '#features',
    'primaryButtonFrom' => 'accent',
    'primaryButtonTo' => 'primary',
    'primaryButtonHoverFrom' => 'primary',
    'primaryButtonHoverTo' => 'secondary',
    'secondaryButtonText' => 'Get Started',
    'secondaryButtonLink' => route('contact'),
    'heroImage' => asset('images/ott-plateform.svg'),
    'imageAlt' => 'Video streaming platform illustration',
    'placeholderIcon' => 'fas fa-play-circle',
    'placeholderText' => 'OTT Streaming Platform',
    'placeholderSubtext' => 'Content Delivery Solution',
    'floatingElements' => [
        [
            'position' => 'top-32 right-32',
            'size' => '8',
            'color' => 'accent',
            'opacity' => '40',
            'icon' => 'fas fa-play',
            'iconSize' => 'sm',
            'delay' => '0'
        ],
        [
            'position' => 'bottom-40 left-20',
            'size' => '6',
            'color' => 'primary',
            'opacity' => '30',
            'icon' => 'fas fa-tv',
            'iconSize' => 'xs',
            'delay' => '1'
        ],
        [
            'position' => 'top-60 left-1/4',
            'size' => '10',
            'color' => 'secondary',
            'opacity' => '20',
            'icon' => 'fas fa-film',
            'iconSize' => 'sm',
            'delay' => '3'
        ]
    ],
    'floatingCards' => [
        [
            'position' => '-top-6 -left-6',
            'icon' => 'fas fa-video',
            'color' => 'accent'
        ],
        [
            'position' => '-bottom-6 -right-6',
            'icon' => 'fas fa-mobile-alt',
            'color' => 'primary',
            'delay' => '2'
        ],
        [
            'position' => 'top-1/2 -right-12',
            'icon' => 'fas fa-desktop',
            'color' => 'secondary',
            'delay' => '1'
        ]
    ]
])

{{-- Key Features Section --}}
@include('components.services.features-grid', [
    'sectionId' => 'features',
    'bgColor' => 'dark-light',
    'headerTitle' => 'Key',
    'headerHighlight' => 'Features',
    'headerDescription' => 'Our OTT platform combines ease of use with powerful functionality to deliver exceptional content experiences.',
    'gridCols' => '2',
    'features' => [
        [
            'icon' => 'fas fa-mouse-pointer',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'User-Friendly Interface',
            'description' => 'Our intuitive interface makes content management a breeze, allowing you to upload, organize, and schedule videos with just a few clicks. Say goodbye to complex workflows and hello to streamlined content management.',
            'bulletColor' => 'accent',
            'bullets' => [
                'Simple content upload & organization',
                'Easy video scheduling',
                'Streamlined workflow management'
            ]
        ],
        [
            'icon' => 'fas fa-palette',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Customizable Branding',
            'description' => 'Showcase your brand identity across every touchpoint with customizable branding options. From logos and color schemes to personalized user interfaces, our platform ensures a cohesive brand experience for your viewers.',
            'bulletColor' => 'primary',
            'bullets' => [
                'Custom logos & color schemes',
                'Personalized user interfaces',
                'Cohesive brand experience'
            ]
        ],
        [
            'icon' => 'fas fa-devices',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Multi-Platform Compatibility',
            'description' => 'Reach audiences across a variety of devices and platforms, including smart TVs, mobile devices, and desktop computers. Our platform supports seamless streaming on iOS, Android, Roku, Apple TV, and more.',
            'bulletColor' => 'secondary',
            'bullets' => [
                'Smart TVs & mobile devices',
                'iOS, Android, Roku, Apple TV',
                'Desktop & laptop compatibility'
            ]
        ],
        [
            'icon' => 'fas fa-chart-line',
            'colorFrom' => 'accent',
            'colorTo' => 'secondary',
            'title' => 'Powerful Analytics',
            'description' => 'Gain valuable insights into viewer behavior and engagement with our robust analytics dashboard. Track metrics such as viewer demographics, viewing duration, and content performance to inform your content strategy.',
            'bulletColor' => 'accent',
            'bullets' => [
                'Viewer demographics & behavior',
                'Viewing duration analytics',
                'Content performance tracking'
            ]
        ]
    ]
])

{{-- Why Choose Us Section --}}
@include('components.services.why-choose-us', [
    'bgColor' => 'dark',
    'companyName' => 'TKDS Media',
    'description' => 'With TKDS Media\'s OTT platform, you can focus on creating compelling content while we handle the rest. Our team of experts is dedicated to providing top-notch support and guidance every step of the way.',
    'benefits' => [
        [
            'icon' => 'fas fa-rocket',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Focus on Content',
            'description' => 'Concentrate on creating compelling content while we handle all the technical complexities and platform management.'
        ],
        [
            'icon' => 'fas fa-headset',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Expert Support',
            'description' => 'Dedicated team of experts providing top-notch support and guidance every step of the way.'
        ],
        [
            'icon' => 'fas fa-cogs',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Hassle-Free Experience',
            'description' => 'Smooth, efficient, and hassle-free OTT experience designed for content creators and distributors.'
        ],
        [
            'icon' => 'fas fa-trophy',
            'colorFrom' => 'accent',
            'colorTo' => 'secondary',
            'title' => 'Proven Success',
            'description' => 'Join successful broadcasters who rely on TKDS Media to deliver high-quality video content worldwide.'
        ]
    ]
])

{{-- CTA Section --}}
@include('components.services.cta-section', [
    'bgColor' => 'dark-light',
    'bgEffect1' => 'accent',
    'bgEffect2' => 'primary',
    'titleStart' => 'Ready to',
    'highlightText' => 'Transform',
    'titleEnd' => 'Your Content Distribution?',
    'description' => 'Get started with TKDS Media\'s OTT platform today and unlock new opportunities for audience engagement and growth. Whether you\'re a content creator, distributor, or media company, our platform is tailored to meet your unique needs.',
    'primaryButtonText' => 'Get Started Today',
    'primaryButtonLink' => route('contact'),
    'buttonFrom' => 'accent',
    'buttonTo' => 'primary',
    'buttonHoverFrom' => 'primary',
    'buttonHoverTo' => 'secondary',
    'secondaryButtonText' => 'Learn More',
    'secondaryButtonLink' => '#features'
])

{{-- Related Services Section --}}
@include('components.services.related-services', [
    'bgColor' => 'dark',
    'title' => 'Complete Your OTT Ecosystem',
    'subtitle' => 'Enhance your OTT platform with these complementary services',
    'services' => [
        [
            'icon' => 'fas fa-mobile-alt',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'OTT Apps',
            'description' => 'Custom mobile and TV apps for your platform',
            'link' => route('services.ott-apps'),
            'linkColor' => 'primary',
            'linkHoverColor' => 'secondary'
        ],
        [
            'icon' => 'fas fa-cloud',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Cloud Servers',
            'description' => '24/7 infrastructure to power your platform',
            'link' => route('services.cloud-servers'),
            'linkColor' => 'secondary',
            'linkHoverColor' => 'accent'
        ],
        [
            'icon' => 'fas fa-server',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Streaming Service',
            'description' => 'High-performance content delivery network',
            'link' => route('services.streaming-service'),
            'linkColor' => 'accent',
            'linkHoverColor' => 'primary'
        ]
    ]
])

@endsection