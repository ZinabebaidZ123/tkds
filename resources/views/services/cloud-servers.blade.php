@extends('layouts.app')

@section('title', 'Cloud 24/7 Playout Servers - TKDS Media')
@section('meta_description', 'Professional cloud 24/7 playout servers for IPTV and satellite broadcasting. Reliable, scalable infrastructure with remote management and monitoring.')

@section('content')

{{-- Hero Section --}}
@include('components.services.hero', [
    'badgeIcon' => 'fas fa-cloud',
    'badgeText' => 'Cloud Infrastructure',
    'badgeColor' => 'primary',
    'primaryColor' => 'primary',
    'secondaryColor' => 'secondary',
    'accentColor' => 'accent',
    'mainTitle' => 'Cloud 24/7',
    'highlightTitle' => 'Playout Servers',
    'gradientFrom' => 'primary',
    'gradientVia' => 'secondary',
    'gradientTo' => 'accent',
    'description' => 'Experience uninterrupted broadcasting with TKDS Media\'s cloud 24/7 playout servers. Our state-of-the-art infrastructure delivers reliable, high-quality streaming around the clock, ensuring your content reaches your audience when and where they want it.',
    'primaryButtonText' => 'Explore Features',
    'primaryButtonLink' => '#features',
    'primaryButtonFrom' => 'primary',
    'primaryButtonTo' => 'secondary',
    'primaryButtonHoverFrom' => 'secondary',
    'primaryButtonHoverTo' => 'accent',
    'secondaryButtonText' => 'View Pricing',
    'secondaryButtonLink' => '#pricing',
    'heroImage' =>  asset('images/Cloud-hosting-amico.svg'),
    'imageAlt' => 'Cloud hosting illustration',
    'placeholderIcon' => 'fas fa-cloud-upload-alt',
    'placeholderText' => 'Cloud 24/7 Servers',
    'placeholderSubtext' => 'Professional Broadcasting Infrastructure',
    'floatingElements' => [
        [
            'position' => 'top-32 right-32',
            'size' => '8',
            'color' => 'primary',
            'opacity' => '40',
            'icon' => 'fas fa-server',
            'iconSize' => 'sm',
            'delay' => '0'
        ],
        [
            'position' => 'bottom-40 left-20',
            'size' => '6',
            'color' => 'secondary',
            'opacity' => '30',
            'icon' => 'fas fa-cloud',
            'iconSize' => 'xs',
            'delay' => '1'
        ],
        [
            'position' => 'top-60 left-1/4',
            'size' => '10',
            'color' => 'accent',
            'opacity' => '20',
            'icon' => 'fas fa-database',
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
            'icon' => 'fas fa-shield-alt',
            'color' => 'secondary',
            'delay' => '2'
        ],
        [
            'position' => 'top-1/2 -right-12',
            'icon' => 'fas fa-globe',
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
    'headerDescription' => 'Say goodbye to downtime and buffering with our robust cloud infrastructure, built on cutting-edge technology and backed by redundant systems.',
    'gridCols' => '2',
    'features' => [
        [
            'icon' => 'fas fa-shield-alt',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Reliable Performance',
            'description' => 'Say goodbye to downtime and buffering with our robust cloud infrastructure. Built on cutting-edge technology and backed by redundant systems, our playout servers guarantee uninterrupted streaming, even during peak traffic periods.',
            'bulletColor' => 'primary',
            'bullets' => [
                'Zero downtime guarantee',
                'Redundant system architecture',
                'Peak traffic optimization'
            ]
        ],
        [
            'icon' => 'fas fa-expand-arrows-alt',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Scalability',
            'description' => 'Whether you\'re broadcasting to a small audience or millions of viewers worldwide, our cloud playout servers can scale to meet your needs. With flexible resource allocation and on-demand capacity expansion, you can seamlessly accommodate growing viewership.',
            'bulletColor' => 'secondary',
            'bullets' => [
                'Flexible resource allocation',
                'On-demand capacity expansion',
                'Global audience support'
            ]
        ],
        [
            'icon' => 'fas fa-headset',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => '24/7 Monitoring & Support',
            'description' => 'Our dedicated team of experts monitors your playout servers around the clock, ensuring optimal performance and addressing any issues promptly. With proactive monitoring and rapid response times, we keep your broadcasts running smoothly.',
            'bulletColor' => 'accent',
            'bullets' => [
                'Round-the-clock monitoring',
                'Expert technical support',
                'Proactive issue resolution'
            ]
        ],
        [
            'icon' => 'fas fa-laptop-code',
            'colorFrom' => 'primary',
            'colorTo' => 'accent',
            'title' => 'Remote Management',
            'description' => 'Manage your playout servers from anywhere in the world with our intuitive remote management tools. Whether you need to schedule playlists, monitor performance metrics, or troubleshoot issues, you can do it all from your computer or mobile device.',
            'bulletColor' => 'primary',
            'bullets' => [
                'Global remote access',
                'Playlist scheduling',
                'Real-time performance monitoring'
            ]
        ]
    ]
])

<!-- Infrastructure Showcase -->
<section class="py-20 bg-dark relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                State-of-the-Art <span class="text-gradient">Infrastructure</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Built on cutting-edge technology and industry best practices to deliver unmatched performance and reliability for your broadcasting needs.
            </p>
        </div>

        <!-- Infrastructure Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
            
            <!-- Cloud Architecture -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-cloud text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Cloud-Native Architecture</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Built from the ground up for the cloud, ensuring maximum efficiency, scalability, and reliability for your broadcasting operations.
                </p>
            </div>

            <!-- Global CDN -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-globe text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Global CDN Network</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Worldwide content delivery network ensures your content reaches viewers with minimal latency, regardless of their location.
                </p>
            </div>

            <!-- Security -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-r from-secondary to-accent rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-lock text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Enterprise Security</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Advanced security measures including encryption, access controls, and monitoring protect your content and infrastructure.
                </p>
            </div>

            <!-- High Availability -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-gradient-to-r from-accent to-primary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-sync-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">High Availability</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Redundant systems and automatic failover mechanisms ensure your broadcasts continue even if individual components fail.
                </p>
            </div>

            <!-- Performance Monitoring -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Real-Time Analytics</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Comprehensive monitoring and analytics provide insights into performance, viewer engagement, and system health.
                </p>
            </div>

            <!-- API Integration -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="600">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-plug text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">API Integration</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Robust APIs enable seamless integration with existing systems and third-party tools for enhanced workflow automation.
                </p>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="glass-effect rounded-3xl p-12 text-center" data-aos="fade-up" data-aos-delay="700">
            <div class="mb-8">
                <h3 class="text-3xl font-bold text-white mb-4">Unmatched Performance Metrics</h3>
                <p class="text-gray-400 mb-6">Industry-leading specifications that power professional broadcasting operations</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-4xl font-black text-primary mb-2">99.9%</div>
                    <p class="text-white font-medium">Uptime Guarantee</p>
                    <p class="text-gray-400 text-sm mt-1">SLA-backed reliability</p>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl font-black text-secondary mb-2">&lt;50ms</div>
                    <p class="text-white font-medium">Ultra-Low Latency</p>
                    <p class="text-gray-400 text-sm mt-1">Global edge locations</p>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl font-black text-accent mb-2">24/7</div>
                    <p class="text-white font-medium">Expert Support</p>
                    <p class="text-gray-400 text-sm mt-1">Round-the-clock assistance</p>
                </div>
                
                <div class="text-center">
                    <div class="text-4xl font-black text-primary mb-2">∞</div>
                    <p class="text-white font-medium">Scalability</p>
                    <p class="text-gray-400 text-sm mt-1">Unlimited growth potential</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Why Choose Us Section --}}
@include('components.services.why-choose-us', [
    'bgColor' => 'dark-light',
    'companyName' => 'TKDS Media',
    'description' => 'At TKDS Media, we understand the importance of reliable broadcasting infrastructure in today\'s digital landscape. That\'s why we\'ve invested in state-of-the-art technology and a team of experienced professionals to deliver industry-leading cloud playout solutions.',
    'benefits' => [
        [
            'icon' => 'fas fa-award',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Industry Leader',
            'description' => 'Leading the market with cutting-edge cloud playout technology and innovative broadcasting solutions.'
        ],
        [
            'icon' => 'fas fa-users',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Expert Team',
            'description' => 'Experienced professionals dedicated to delivering exceptional performance and support for your broadcasting needs.'
        ],
        [
            'icon' => 'fas fa-rocket',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Innovation Focus',
            'description' => 'Continuous investment in new technologies to stay ahead of industry trends and deliver future-ready solutions.'
        ],
        [
            'icon' => 'fas fa-handshake',
            'colorFrom' => 'primary',
            'colorTo' => 'accent',
            'title' => 'Trusted Partner',
            'description' => 'Join leading broadcasters and content providers who trust TKDS Media to power their operations worldwide.'
        ]
    ],
    'process' => [
        'title' => 'Simple Deployment Process',
        'description' => 'Get your cloud playout servers up and running quickly with our streamlined process',
        'steps' => [
            [
                'color' => 'primary',
                'title' => 'Consultation',
                'description' => 'Assess your requirements and design the optimal solution'
            ],
            [
                'color' => 'secondary',
                'title' => 'Setup',
                'description' => 'Deploy and configure your cloud infrastructure'
            ],
            [
                'color' => 'accent',
                'title' => 'Integration',
                'description' => 'Connect your existing systems and workflows'
            ],
            [
                'color' => 'primary',
                'title' => 'Go Live',
                'description' => 'Launch your broadcasts with full support'
            ]
        ]
    ]
])

{{-- Use Cases Section --}}
<section class="py-20 bg-dark relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Perfect for <span class="text-gradient">Every Broadcaster</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Whether you're a broadcaster, content provider, or media company, our cloud 24/7 playout servers provide the flexibility, scalability, and reliability you need to succeed.
            </p>
        </div>

        <!-- Use Cases Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- IPTV Providers -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-tv text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">IPTV Providers</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Deliver reliable IPTV services to your subscribers with our robust cloud infrastructure and 24/7 playout capabilities.
                </p>
            </div>

            <!-- Satellite Broadcasters -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-satellite text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Satellite Broadcasters</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Support your satellite broadcasting operations with cloud-based playout servers that ensure continuous content delivery.
                </p>
            </div>

            <!-- Content Providers -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-film text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Content Providers</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Distribute your content globally with scalable cloud servers that adapt to your growing audience and content library.
                </p>
            </div>

            <!-- Media Companies -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-red-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-building text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Media Companies</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Streamline your media operations with enterprise-grade cloud infrastructure designed for professional broadcasting.
                </p>
            </div>

            <!-- Educational Institutions -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-yellow-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Educational Institutions</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Enable distance learning and educational broadcasting with reliable cloud servers that support continuous content delivery.
                </p>
            </div>

            <!-- Religious Organizations -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="600">
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-indigo-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-hands text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Religious Organizations</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Reach your community with 24/7 broadcasting capabilities that ensure your message is always available to viewers.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
@include('components.services.cta-section', [
    'bgColor' => 'dark-light',
    'bgEffect1' => 'primary',
    'bgEffect2' => 'secondary',
    'titleStart' => 'Ready to',
    'highlightText' => 'Elevate',
    'titleEnd' => 'Your Broadcasting?',
    'description' => 'Partner with TKDS Media for cloud 24/7 playout servers that deliver unmatched performance, reliability, and scalability. Contact us today to learn more and start broadcasting with confidence!',
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
    'bgColor' => 'dark',
    'title' => 'Complete Your Broadcasting Setup',
    'subtitle' => 'Enhance your cloud servers with these complementary services',
    'services' => [
        [
            'icon' => 'fas fa-broadcast-tower',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Stream & Restream',
            'description' => 'Professional streaming services to complement your servers',
            'link' => route('services.streaming'),
            'linkColor' => 'secondary',
            'linkHoverColor' => 'accent'
        ],
        [
            'icon' => 'fas fa-tv',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'OTT Platform',
            'description' => 'Complete platform to distribute your cloud content',
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
        ]
    ]
])

@endsection