@extends('layouts.app')

@section('title', 'Sports Live Production - TKDS Media')
@section('meta_description', 'Premier sports live production services with TKDS Sports Network. Comprehensive coverage, multi-camera setups, live graphics, instant replay, and professional sports broadcasting solutions.')

@section('content')

{{-- Hero Section --}}
@include('components.services.hero', [
    'badgeIcon' => 'fas fa-futbol',
    'badgeText' => 'Sports Production',
    'badgeColor' => 'secondary',
    'primaryColor' => 'secondary',
    'secondaryColor' => 'accent',
    'accentColor' => 'primary',
    'mainTitle' => 'Sports LIVE',
    'highlightTitle' => 'Production',
    'subtitleLine' => 'with TKDS Sports Network',
    'gradientFrom' => 'secondary',
    'gradientVia' => 'accent',
    'gradientTo' => 'primary',
    'description' => 'At TKDS Media, we are passionate about sports and committed to delivering top-tier live production services for all kinds of sporting events. Whether it\'s football, basketball, tennis, or any other sport, we have the expertise, technology, and creativity to bring your event to life like never before.',
    'primaryButtonText' => 'Explore Features',
    'primaryButtonLink' => '#features',
    'primaryButtonFrom' => 'secondary',
    'primaryButtonTo' => 'accent',
    'primaryButtonHoverFrom' => 'accent',
    'primaryButtonHoverTo' => 'primary',
    'secondaryButtonText' => 'View Pricing',
    'secondaryButtonLink' => '/pricing',
    'heroImage' => asset('images/Fans-bro.svg'),
    'imageAlt' => 'Sports football production illustration',
    'placeholderIcon' => 'fas fa-video',
    'placeholderText' => 'Sports Live Production',
    'placeholderSubtext' => 'Professional Sports Broadcasting',
    'floatingElements' => [
        [
            'position' => 'top-32 right-32',
            'size' => '8',
            'color' => 'secondary',
            'opacity' => '40',
            'icon' => 'fas fa-camera',
            'iconSize' => 'sm',
            'delay' => '0'
        ],
        [
            'position' => 'bottom-40 left-20',
            'size' => '6',
            'color' => 'accent',
            'opacity' => '30',
            'icon' => 'fas fa-trophy',
            'iconSize' => 'xs',
            'delay' => '1'
        ],
        [
            'position' => 'top-60 left-1/4',
            'size' => '10',
            'color' => 'primary',
            'opacity' => '20',
            'icon' => 'fas fa-chart-line',
            'iconSize' => 'sm',
            'delay' => '3'
        ]
    ],
    'floatingCards' => [
        [
            'position' => '-top-6 -left-6',
            'icon' => 'fas fa-play',
            'color' => 'secondary'
        ],
        [
            'position' => '-bottom-6 -right-6',
            'icon' => 'fas fa-history',
            'color' => 'accent',
            'delay' => '2'
        ],
        [
            'position' => 'top-1/2 -right-12',
            'icon' => 'fas fa-video',
            'color' => 'primary',
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
    'headerDescription' => 'Professional sports production services that capture every moment with precision and flair, delivering exceptional viewing experiences.',
    'gridCols' => '2',
    'features' => [
        [
            'icon' => 'fas fa-video',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Comprehensive Coverage',
            'description' => 'From pre-game analysis to post-match highlights, we provide end-to-end coverage of your sporting event. Our team of experienced professionals handles everything from camera operation and audio mixing to graphics overlay and instant replay.',
            'bulletColor' => 'secondary',
            'bullets' => [
                'Pre-game analysis & post-match highlights',
                'Professional camera & audio operation',
                'Graphics overlay & instant replay'
            ]
        ],
        [
            'icon' => 'fas fa-camera',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Multi-Camera Setup',
            'description' => 'Elevate the viewing experience with our multi-camera setups, allowing viewers to immerse themselves in the action from every angle. From close-ups of players to wide shots of the field and aerial drone views.',
            'bulletColor' => 'accent',
            'bullets' => [
                'Multiple camera angles & perspectives',
                'Close-ups & wide field shots',
                'Aerial drone footage'
            ]
        ],
        [
            'icon' => 'fas fa-chart-bar',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Live Graphics & Stats',
            'description' => 'Keep your audience informed and engaged with our live graphics and stats overlays. From scoreboards and player stats to in-game analytics and real-time updates, we provide interactive visuals that enhance the viewing experience.',
            'bulletColor' => 'primary',
            'bullets' => [
                'Live scoreboards & player statistics',
                'In-game analytics & real-time updates',
                'Interactive visual overlays'
            ]
        ],
        [
            'icon' => 'fas fa-history',
            'colorFrom' => 'secondary',
            'colorTo' => 'primary',
            'title' => 'Instant Replay & Highlights',
            'description' => 'Capture the most memorable moments of the game with our instant replay and highlights capabilities. Every key moment is replayed and analyzed from multiple angles, allowing viewers to relive the excitement again and again.',
            'bulletColor' => 'secondary',
            'bullets' => [
                'Game-winning moments capture',
                'Multi-angle replay analysis',
                'Highlight reel creation'
            ]
        ]
    ]
])

{{-- Why Choose Us Section --}}
@include('components.services.why-choose-us', [
    'bgColor' => 'dark',
    'companyName' => 'TKDS Media',
    'description' => 'At TKDS Media, we understand the unique challenges and requirements of sports live production, and we\'re dedicated to delivering exceptional results that exceed your expectations. With our state-of-the-art equipment, experienced crew, and commitment to excellence.',
    'benefits' => [
        [
            'icon' => 'fas fa-award',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Sports Expertise',
            'description' => 'Deep understanding of sports production requirements with experienced professionals who know how to capture every crucial moment.'
        ],
        [
            'icon' => 'fas fa-cogs',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'State-of-the-Art Equipment',
            'description' => 'Cutting-edge production equipment and technology to ensure your sporting event is presented in the best possible light.'
        ],
        [
            'icon' => 'fas fa-users',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Experienced Crew',
            'description' => 'Professional team with extensive experience in sports broadcasting, ensuring smooth production and exceptional results.'
        ],
        [
            'icon' => 'fas fa-trophy',
            'colorFrom' => 'secondary',
            'colorTo' => 'primary',
            'title' => 'Excellence Commitment',
            'description' => 'Dedicated to delivering results that exceed expectations, enhancing your brand\'s reputation and captivating audiences.'
        ]
    ]
])

{{-- CTA Section --}}
@include('components.services.cta-section', [
    'bgColor' => 'dark-light',
    'bgEffect1' => 'secondary',
    'bgEffect2' => 'accent',
    'titleStart' => 'Ready to',
    'highlightText' => 'Elevate',
    'titleEnd' => 'Your Sports Production?',
    'description' => 'Whether you\'re hosting a local tournament, regional championship, or international sporting event, TKDS Media has the expertise and resources to handle all aspects of your live production needs. Contact us today to bring your sporting event to life with style and professionalism.',
    'primaryButtonText' => 'Get Started Today',
    'primaryButtonLink' => '/pricing',
    'buttonFrom' => 'secondary',
    'buttonTo' => 'accent',
    'buttonHoverFrom' => 'accent',
    'buttonHoverTo' => 'primary',
    'secondaryButtonText' => 'Learn More',
    'secondaryButtonLink' => '#features'
])

{{-- Related Services Section --}}
@include('components.services.related-services', [
    'bgColor' => 'dark',
    'title' => 'Complete Your Sports Broadcasting Setup',
    'subtitle' => 'Enhance your sports production with these complementary services',
    'services' => [
        [
            'icon' => 'fas fa-palette',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Graphic Design',
            'description' => 'Dynamic graphics and scoreboards for sports broadcasts',
            'link' => route('services.graphic-design'),
            'linkColor' => 'accent',
            'linkHoverColor' => 'primary'
        ],
        [
            'icon' => 'fas fa-broadcast-tower',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Stream & Restream',
            'description' => 'Live streaming and social media distribution',
            'link' => route('services.streaming'),
            'linkColor' => 'primary',
            'linkHoverColor' => 'secondary'
        ],
        [
            'icon' => 'fas fa-cloud',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Cloud Servers',
            'description' => '24/7 infrastructure for sports broadcasting',
            'link' => route('services.cloud-servers'),
            'linkColor' => 'secondary',
            'linkHoverColor' => 'accent'
        ]
    ]
])

@endsection