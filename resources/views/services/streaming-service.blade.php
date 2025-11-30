@extends('layouts.app')

@section('title', 'Premium Streaming Service - TKDS Media')
@section('meta_description', 'Harness the power of TKDS Media\'s streaming server clusters. Best-in-class streaming infrastructure with global reach, scalability, and redundancy for seamless content delivery.')

@section('content')

{{-- Hero Section --}}
@include('components.services.hero', [
    'badgeIcon' => 'fas fa-server',
    'badgeText' => 'Streaming Infrastructure',
    'badgeColor' => 'primary',
    'primaryColor' => 'primary',
    'secondaryColor' => 'secondary',
    'accentColor' => 'accent',
    'mainTitle' => 'Premium',
    'highlightTitle' => 'Streaming Service',
    'subtitleLine' => 'Powered by Server Clusters',
    'gradientFrom' => 'primary',
    'gradientVia' => 'secondary',
    'gradientTo' => 'accent',
    'description' => 'At TKDS Media, we take streaming to the next level with our cutting-edge streaming service powered by our best-in-class streaming server clusters. Experience unmatched reliability and scalability for broadcasting live events, delivering on-demand content, or hosting interactive experiences.',
    'primaryButtonText' => 'Explore Infrastructure',
    'primaryButtonLink' => '#features',
    'primaryButtonFrom' => 'primary',
    'primaryButtonTo' => 'secondary',
    'primaryButtonHoverFrom' => 'secondary',
    'primaryButtonHoverTo' => 'accent',
    'secondaryButtonText' => 'Get Started',
    'secondaryButtonLink' => route('contact'),
    'heroImage' => asset('images/Server-bro.svg'),
    'imageAlt' => 'Server infrastructure illustration',
    'placeholderIcon' => 'fas fa-server',
    'placeholderText' => 'Streaming Server Clusters',
    'placeholderSubtext' => 'Premium Infrastructure',
    'floatingElements' => [
        [
            'position' => 'top-32 right-32',
            'size' => '8',
            'color' => 'primary',
            'opacity' => '40',
            'icon' => 'fas fa-database',
            'iconSize' => 'sm',
            'delay' => '0'
        ],
        [
            'position' => 'bottom-40 left-20',
            'size' => '6',
            'color' => 'secondary',
            'opacity' => '30',
            'icon' => 'fas fa-network-wired',
            'iconSize' => 'xs',
            'delay' => '1'
        ],
        [
            'position' => 'top-60 left-1/4',
            'size' => '10',
            'color' => 'accent',
            'opacity' => '20',
            'icon' => 'fas fa-globe',
            'iconSize' => 'sm',
            'delay' => '3'
        ]
    ],
    'floatingCards' => [
        [
            'position' => '-top-6 -left-6',
            'icon' => 'fas fa-server',
            'color' => 'primary'
        ],
        [
            'position' => '-bottom-6 -right-6',
            'icon' => 'fas fa-sync-alt',
            'color' => 'secondary',
            'delay' => '2'
        ],
        [
            'position' => 'top-1/2 -right-12',
            'icon' => 'fas fa-shield-alt',
            'color' => 'accent',
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
    'headerDescription' => 'Our robust infrastructure ensures seamless streaming with unmatched reliability and scalability for audiences of any size, anywhere in the world.',
    'gridCols' => '2',
    'features' => [
        [
            'icon' => 'fas fa-server',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Streaming Server Clusters',
            'description' => 'Experience unparalleled performance and reliability with our state-of-the-art streaming server clusters. Built on top-tier hardware and optimized for high-throughput streaming, our clusters ensure smooth delivery of your content to audiences of any size.',
            'bulletColor' => 'primary',
            'bullets' => [
                'Top-tier hardware infrastructure',
                'High-throughput optimization',
                'Unlimited audience capacity'
            ]
        ],
        [
            'icon' => 'fas fa-globe',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Global Reach',
            'description' => 'Reach audiences worldwide with our extensive network of streaming servers strategically located across multiple regions. Whether your viewers are in New York, London, Tokyo, or anywhere in between, our global infrastructure ensures optimal performance.',
            'bulletColor' => 'secondary',
            'bullets' => [
                'Strategic global server locations',
                'Low-latency streaming worldwide',
                'High-quality playback guarantee'
            ]
        ],
        [
            'icon' => 'fas fa-expand-arrows-alt',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Scalability',
            'description' => 'Scale your streaming infrastructure on demand to accommodate fluctuations in viewership and traffic. Our flexible architecture allows you to seamlessly expand or contract server capacity as needed, ensuring optimal performance and cost efficiency.',
            'bulletColor' => 'accent',
            'bullets' => [
                'On-demand capacity scaling',
                'Peak traffic optimization',
                'Cost-efficient resource management'
            ]
        ],
        [
            'icon' => 'fas fa-shield-alt',
            'colorFrom' => 'primary',
            'colorTo' => 'accent',
            'title' => 'Redundancy & Failover',
            'description' => 'Rest easy knowing that your streams are protected by our redundant server architecture and failover mechanisms. In the unlikely event of a server failure, our system automatically switches to backup servers, ensuring uninterrupted streaming.',
            'bulletColor' => 'primary',
            'bullets' => [
                'Redundant server architecture',
                'Automatic failover protection',
                'Uninterrupted streaming guarantee'
            ]
        ]
    ]
])

{{-- Why Choose Us Section --}}
@include('components.services.why-choose-us', [
    'bgColor' => 'dark',
    'companyName' => 'TKDS Media',
    'description' => 'With TKDS Media\'s streaming service, you can focus on creating compelling content while we handle the complexities of streaming infrastructure management. Our team of experts is dedicated to providing you with the best-in-class streaming solutions.',
    'benefits' => [
        [
            'icon' => 'fas fa-rocket',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Best-in-Class Performance',
            'description' => 'Industry-leading streaming infrastructure that delivers exceptional performance and reliability for all your content delivery needs.'
        ],
        [
            'icon' => 'fas fa-headset',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Expert Support',
            'description' => 'Dedicated team of streaming experts providing unparalleled support and guidance for your streaming initiatives.'
        ],
        [
            'icon' => 'fas fa-cogs',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Seamless Management',
            'description' => 'We handle all the complexities of infrastructure management, allowing you to focus on content creation and audience engagement.'
        ],
        [
            'icon' => 'fas fa-trophy',
            'colorFrom' => 'primary',
            'colorTo' => 'accent',
            'title' => 'Proven Success',
            'description' => 'Join leading brands and broadcasters who trust TKDS Media to power their streaming initiatives and engage audiences worldwide.'
        ]
    ]
])

{{-- CTA Section --}}
@include('components.services.cta-section', [
    'bgColor' => 'dark-light',
    'bgEffect1' => 'primary',
    'bgEffect2' => 'secondary',
    'titleStart' => 'Ready to',
    'highlightText' => 'Elevate',
    'titleEnd' => 'Your Streaming Experience?',
    'description' => 'Partner with TKDS Media and harness the power of our streaming server clusters to deliver seamless, high-quality streaming to your audience. Contact us today to learn more and take your streaming to the next level!',
    'primaryButtonText' => 'Get Started Today',
    'primaryButtonLink' => route('contact'),
    'buttonFrom' => 'primary',
    'buttonTo' => 'secondary',
    'buttonHoverFrom' => 'secondary',
    'buttonHoverTo' => 'accent',
    'secondaryButtonText' => 'Learn More',
    'secondaryButtonLink' => '#features'
])

{{-- Related Services Section --}}
@include('components.services.related-services', [
    'bgColor' => 'dark',
    'title' => 'Complete Your Streaming Infrastructure',
    'subtitle' => 'Enhance your streaming service with these complementary solutions',
    'services' => [
        [
            'icon' => 'fas fa-cloud',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Cloud Servers',
            'description' => '24/7 cloud playout servers for continuous streaming',
            'link' => route('services.cloud-servers'),
            'linkColor' => 'secondary',
            'linkHoverColor' => 'accent'
        ],
        [
            'icon' => 'fas fa-tv',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'OTT Platform',
            'description' => 'Complete platform to manage your streaming content',
            'link' => route('services.ott-platform'),
            'linkColor' => 'accent',
            'linkHoverColor' => 'primary'
        ],
        [
            'icon' => 'fas fa-broadcast-tower',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Stream & Restream',
            'description' => 'Professional streaming and social media distribution',
            'link' => route('services.streaming'),
            'linkColor' => 'primary',
            'linkHoverColor' => 'secondary'
        ]
    ]
])

@endsection