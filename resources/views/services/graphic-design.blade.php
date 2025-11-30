@extends('layouts.app')

@section('title', 'Broadcast Graphic Design - TKDS Media')
@section('meta_description', 'Dynamic Graphic XAML for vMix 27 and broadcasting platforms. Custom interactive graphics, real-time data integration, and professional design solutions.')

@section('content')

{{-- Hero Section --}}
@include('components.services.hero', [
    'badgeIcon' => 'fas fa-palette',
    'badgeText' => 'Broadcast Graphics',
    'badgeColor' => 'accent',
    'primaryColor' => 'accent',
    'secondaryColor' => 'primary',
    'accentColor' => 'secondary',
    'mainTitle' => 'Dynamic',
    'highlightTitle' => 'Graphic XAML',
    'subtitleLine' => 'for vMix 27',
    'gradientFrom' => 'accent',
    'gradientVia' => 'primary',
    'gradientTo' => 'secondary',
    'description' => 'Unlock the full potential of your live productions with stunning, interactive graphics that captivate your audience and elevate your brand across all broadcasting platforms.',
    'primaryButtonText' => 'Explore Graphics',
    'primaryButtonLink' => '#features',
    'primaryButtonFrom' => 'accent',
    'primaryButtonTo' => 'primary',
    'primaryButtonHoverFrom' => 'primary',
    'primaryButtonHoverTo' => 'secondary',
    'secondaryButtonText' => 'View Portfolio',
    'secondaryButtonLink' => '#portfolio',
    'heroImage' => asset('images/graphic-design-hero.svg'),
    'imageAlt' => 'Graphic Design Hero Image',
    'floatingElements' => [
        [
            'position' => 'top-32 right-32',
            'size' => '8',
            'color' => 'accent',
            'opacity' => '40',
            'rotate' => 'rotate-12',
            'icon' => 'fas fa-palette',
            'iconSize' => 'sm',
            'delay' => '0'
        ],
        [
            'position' => 'bottom-40 left-20',
            'size' => '6',
            'color' => 'primary',
            'opacity' => '30',
            'rotate' => '-rotate-12',
            'icon' => 'fas fa-brush',
            'iconSize' => 'xs',
            'delay' => '1'
        ],
        [
            'position' => 'top-60 left-1/4',
            'size' => '10',
            'color' => 'secondary',
            'opacity' => '20',
            'rotate' => 'rotate-45',
            'icon' => 'fas fa-layer-group',
            'iconSize' => 'sm',
            'delay' => '3'
        ]
    ],
    'floatingCards' => [
        [
            'position' => '-top-6 -left-6',
            'icon' => 'fas fa-vector-square',
            'color' => 'accent'
        ],
        [
            'position' => '-bottom-6 -right-6',
            'icon' => 'fas fa-layer-group',
            'color' => 'primary',
            'delay' => '2'
        ],
        [
            'position' => 'top-1/2 -right-12',
            'icon' => 'fas fa-magic',
            'color' => 'secondary',
            'delay' => '1'
        ]
    ]
])

<!-- vMix Integration Showcase -->
<section class="py-20 bg-dark-light relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Designed for <span class="text-gradient">vMix 27</span> & Beyond
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Professional XAML graphics specifically optimized for vMix 27 and other leading broadcasting platforms, ensuring seamless integration and maximum performance.
            </p>
        </div>

        <!-- vMix Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
            
            <!-- vMix Compatibility -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-desktop text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">vMix 27 Optimized</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Specifically designed and tested for vMix 27, ensuring perfect compatibility and optimal performance for your live productions.
                </p>
            </div>

            <!-- XAML Technology -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-r from-accent to-primary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-code text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Advanced XAML</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Utilizing the latest XAML technology for dynamic, interactive graphics with smooth animations and responsive elements.
                </p>
            </div>

            <!-- Cross-Platform -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-broadcast-tower text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Multi-Platform Support</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Compatible with other leading broadcasting platforms, ensuring versatility across your production workflow.
                </p>
            </div>
        </div>

        <!-- Demo Section -->
        <div class="glass-effect rounded-3xl p-12 text-center" data-aos="fade-up" data-aos-delay="400">
            <div class="mb-8">
                <h3 class="text-3xl font-bold text-white mb-4">See Our Graphics in Action</h3>
                <p class="text-gray-400 mb-6">Experience the power of dynamic XAML graphics in real broadcast scenarios</p>
            </div>
            
            <!-- Demo Grid -->
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-dark/50 rounded-2xl p-6 border border-accent/20">
                    <i class="fas fa-futbol text-accent text-3xl mb-4"></i>
                    <h4 class="text-lg font-bold text-white mb-2">Sports Graphics</h4>
                    <p class="text-gray-400 text-sm">Live scoreboards, player stats, and match information</p>
                </div>
                
                <div class="bg-dark/50 rounded-2xl p-6 border border-primary/20">
                    <i class="fas fa-newspaper text-primary text-3xl mb-4"></i>
                    <h4 class="text-lg font-bold text-white mb-2">News Graphics</h4>
                    <p class="text-gray-400 text-sm">Breaking news tickers, weather updates, and live feeds</p>
                </div>
                
                <div class="bg-dark/50 rounded-2xl p-6 border border-secondary/20">
                    <i class="fas fa-music text-secondary text-3xl mb-4"></i>
                    <h4 class="text-lg font-bold text-white mb-2">Event Graphics</h4>
                    <p class="text-gray-400 text-sm">Concert overlays, conference branding, and show graphics</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features Grid Section --}}
@include('components.services.features-grid', [
    'sectionId' => 'features',
    'bgColor' => 'dark',
    'headerTitle' => 'Powerful',
    'headerHighlight' => 'Features',
    'headerDescription' => 'Everything you need to create stunning, interactive graphics that captivate your audience and elevate your productions.',
    'gridCols' => '2',
    'features' => [
        [
            'icon' => 'fas fa-paint-brush',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Customizable Graphics',
            'description' => 'Choose from a wide range of professionally-designed packs or work with our team to create bespoke designs tailored to your brand identity and production requirements.',
            'bulletColor' => 'accent',
            'bullets' => [
                'Professional design packs',
                'Bespoke custom designs',
                'Brand identity integration'
            ]
        ],
        [
            'icon' => 'fas fa-database',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Real-Time Data Integration',
            'description' => 'Seamlessly integrate dynamic data sources such as scoreboards, social media feeds, weather updates, and more directly into your graphics, keeping your audience informed and engaged.',
            'bulletColor' => 'primary',
            'bullets' => [
                'Live scoreboards & statistics',
                'Social media feeds',
                'Weather & news updates'
            ]
        ],
        [
            'icon' => 'fas fa-mouse-pointer',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Interactive Elements',
            'description' => 'Enhance viewer interaction with interactive elements such as clickable buttons, animated overlays, and dynamic text fields, allowing you to deliver immersive experiences.',
            'bulletColor' => 'secondary',
            'bullets' => [
                'Clickable interactive buttons',
                'Animated overlay graphics',
                'Dynamic text fields'
            ]
        ],
        [
            'icon' => 'fas fa-expand-arrows-alt',
            'colorFrom' => 'accent',
            'colorTo' => 'secondary',
            'title' => 'Scalability & Flexibility',
            'description' => 'Our XAML solutions are scalable and flexible, allowing you to easily adapt and customize graphics for different events, shows, and broadcasts across various production types.',
            'bulletColor' => 'accent',
            'bullets' => [
                'Easy customization',
                'Multi-event adaptability',
                'Versatile applications'
            ]
        ]
    ],
    'extraContent' => [
        'title' => 'Perfect for Every Production',
        'description' => 'Whether you\'re streaming sports events, news segments, conferences, or concerts, our dynamic graphics will elevate your productions to new heights.',
        'gridCols' => '4',
        'items' => [
            [
                'icon' => 'fas fa-futbol',
                'colorFrom' => 'green-500',
                'colorTo' => 'green-700',
                'title' => 'Sports Events',
                'description' => 'Live scores, player stats, match graphics'
            ],
            [
                'icon' => 'fas fa-newspaper',
                'colorFrom' => 'blue-500',
                'colorTo' => 'blue-700',
                'title' => 'News Segments',
                'description' => 'Breaking news, weather, live updates'
            ],
            [
                'icon' => 'fas fa-users',
                'colorFrom' => 'purple-500',
                'colorTo' => 'purple-700',
                'title' => 'Conferences',
                'description' => 'Speaker graphics, agenda displays'
            ],
            [
                'icon' => 'fas fa-music',
                'colorFrom' => 'pink-500',
                'colorTo' => 'pink-700',
                'title' => 'Concerts',
                'description' => 'Artist info, song titles, visual effects'
            ]
        ]
    ]
])

{{-- Why Choose Us Section --}}
@include('components.services.why-choose-us', [
    'bgColor' => 'dark-light',
    'companyName' => 'TKDS Media',
    'description' => 'With years of experience in the broadcasting industry, we combine technical expertise with creative flair to deliver exceptional results.',
    'benefits' => [
        [
            'icon' => 'fas fa-award',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Industry Experience',
            'description' => 'Years of broadcasting expertise ensuring professional results that exceed expectations.'
        ],
        [
            'icon' => 'fas fa-cogs',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Custom Solutions',
            'description' => 'Tailored graphic solutions designed specifically for your brand and production needs.'
        ],
        [
            'icon' => 'fas fa-users',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Creative Team',
            'description' => 'Skilled designers and developers combining technical expertise with creative flair.'
        ],
        [
            'icon' => 'fas fa-headset',
            'colorFrom' => 'accent',
            'colorTo' => 'secondary',
            'title' => 'End-to-End Support',
            'description' => 'Complete support from concept to execution, ensuring seamless integration with your workflow.'
        ]
    ],
    'process' => [
        'title' => 'Our Design Process',
        'description' => 'From concept to execution, we work closely with you to understand your vision and objectives',
        'steps' => [
            [
                'color' => 'accent',
                'title' => 'Consultation',
                'description' => 'Understanding your brand, objectives, and production requirements'
            ],
            [
                'color' => 'primary',
                'title' => 'Design',
                'description' => 'Creating custom graphics and XAML solutions tailored to your needs'
            ],
            [
                'color' => 'secondary',
                'title' => 'Integration',
                'description' => 'Seamless integration with vMix and your broadcasting workflow'
            ],
            [
                'color' => 'accent',
                'title' => 'Support',
                'description' => 'Ongoing support and updates to ensure optimal performance'
            ]
        ]
    ]
])

{{-- CTA Section --}}
@include('components.services.cta-section', [
    'bgColor' => 'dark',
    'bgEffect1' => 'accent',
    'bgEffect2' => 'primary',
    'titleStart' => 'Ready to',
    'highlightText' => 'Elevate',
    'titleEnd' => 'Your Productions?',
    'description' => 'Experience the power of visually stunning, interactive graphics that captivate audiences and leave a lasting impression. Contact us today to learn more and take your productions to the next level!',
    'primaryButtonText' => 'Start Your Project',
    'primaryButtonLink' => route('contact'),
    'buttonFrom' => 'accent',
    'buttonTo' => 'primary',
    'buttonHoverFrom' => 'primary',
    'buttonHoverTo' => 'secondary',
    'secondaryButtonText' => 'View Pricing Plans',
    'secondaryButtonLink' => '/pricing',
])

{{-- Related Services Section --}}
@include('components.services.related-services', [
    'bgColor' => 'dark-light',
    'title' => 'Complete Your Production Setup',
    'subtitle' => 'Enhance your graphic design with these complementary production services',
    'services' => [
        [
            'icon' => 'fas fa-broadcast-tower',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Stream & Restream',
            'description' => 'Professional streaming with your custom graphics',
            'link' => route('services.streaming'),
            'linkColor' => 'primary',
            'linkHoverColor' => 'secondary'
        ],
        [
            'icon' => 'fas fa-cloud',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Cloud Servers',
            'description' => '24/7 cloud production with graphics integration',
            'link' => route('services.cloud-servers'),
            'linkColor' => 'secondary',
            'linkHoverColor' => 'accent'
        ],
        [
            'icon' => 'fas fa-futbol',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Sports Production',
            'description' => 'Live sports with dynamic scoreboard graphics',
            'link' => route('services.sports-production'),
            'linkColor' => 'accent',
            'linkHoverColor' => 'primary'
        ]
    ]
])

@endsection