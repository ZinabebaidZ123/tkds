@extends('layouts.app')

@section('title', 'Radio Stations & Podcast Services - TKDS Media')
@section('meta_description', 'Launch and manage online radio stations and podcasts with TKDS Media. Live broadcasting, podcast publishing, automatic live features, and cross-platform distribution.')

@section('content')

{{-- Hero Section --}}
@include('components.services.hero', [
    'badgeIcon' => 'fas fa-microphone',
    'badgeText' => 'Radio & Podcast',
    'badgeColor' => 'secondary',
    'primaryColor' => 'secondary',
    'secondaryColor' => 'accent',
    'accentColor' => 'primary',
    'mainTitle' => 'Online Radio &',
    'highlightTitle' => 'Podcast Platform',
    'gradientFrom' => 'secondary',
    'gradientVia' => 'accent',
    'gradientTo' => 'primary',
    'description' => 'Welcome to TKDS Media, your one-stop solution for launching and managing online radio stations and podcasts. Broadcast live radio shows and publish podcasts, reaching audiences worldwide with your captivating content.',
    'primaryButtonText' => 'Explore Features',
    'primaryButtonLink' => '#features',
    'primaryButtonFrom' => 'secondary',
    'primaryButtonTo' => 'accent',
    'primaryButtonHoverFrom' => 'accent',
    'primaryButtonHoverTo' => 'primary',
    'secondaryButtonText' => 'Start Broadcasting',
    'secondaryButtonLink' => '#start',
    'heroImage' => asset('images/Podcast-cuate.svg'),
    'imageAlt' => 'Podcast broadcasting illustration',
    'placeholderIcon' => 'fas fa-microphone-alt',
    'placeholderText' => 'Radio & Podcast Studio',
    'placeholderSubtext' => 'Professional Broadcasting Platform',
    'floatingElements' => [
        [
            'position' => 'top-32 right-32',
            'size' => '8',
            'color' => 'secondary',
            'opacity' => '40',
            'icon' => 'fas fa-radio',
            'iconSize' => 'sm',
            'delay' => '0'
        ],
        [
            'position' => 'bottom-40 left-20',
            'size' => '6',
            'color' => 'accent',
            'opacity' => '30',
            'icon' => 'fas fa-podcast',
            'iconSize' => 'xs',
            'delay' => '1'
        ],
        [
            'position' => 'top-60 left-1/4',
            'size' => '10',
            'color' => 'primary',
            'opacity' => '20',
            'icon' => 'fas fa-headphones',
            'iconSize' => 'sm',
            'delay' => '3'
        ]
    ],
    'floatingCards' => [
        [
            'position' => '-top-6 -left-6',
            'icon' => 'fas fa-microphone',
            'color' => 'secondary'
        ],
        [
            'position' => '-bottom-6 -right-6',
            'icon' => 'fas fa-broadcast-tower',
            'color' => 'accent',
            'delay' => '2'
        ],
        [
            'position' => 'top-1/2 -right-12',
            'icon' => 'fas fa-headphones',
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
    'headerDescription' => 'Everything you need to create professional radio stations and podcasts that engage audiences worldwide.',
    'gridCols' => '2',
    'features' => [
        [
            'icon' => 'fas fa-radio',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Online Radio Stations',
            'description' => 'Create your own radio station and stream live shows to listeners across the globe. Whether you\'re hosting music programs, talk shows, news segments, or interviews, our platform provides the tools you need to engage your audience and build a loyal following.',
            'bulletColor' => 'secondary',
            'bullets' => [
                'Live streaming capabilities',
                'Global audience reach',
                'Multiple show formats support'
            ]
        ],
        [
            'icon' => 'fas fa-podcast',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Podcast Service',
            'description' => 'Amplify your message and expand your reach with our podcast service. Easily record, edit, and publish episodes on your preferred schedule, making your content accessible to listeners on-demand. Share stories, insights, or interviews with your audience.',
            'bulletColor' => 'accent',
            'bullets' => [
                'Easy recording & editing tools',
                'Flexible publishing schedule',
                'On-demand accessibility'
            ]
        ],
        [
            'icon' => 'fas fa-broadcast-tower',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Automatic Live Feature',
            'description' => 'Stand out from the crowd with our automatic live feature, seamlessly integrating your TV broadcasts with your online radio station. Simply go live on TV, and your radio station will automatically switch to live mode, ensuring your audience never misses a moment.',
            'bulletColor' => 'primary',
            'bullets' => [
                'TV-radio integration',
                'Automatic live switching',
                'Seamless audience experience'
            ]
        ],
        [
            'icon' => 'fas fa-globe',
            'colorFrom' => 'secondary',
            'colorTo' => 'primary',
            'title' => 'Cross-Platform Distribution',
            'description' => 'Reach audiences wherever they are with our cross-platform distribution capabilities. Whether listeners prefer our website, mobile app, smart speakers, or third-party platforms, we ensure a seamless listening experience across all devices and channels.',
            'bulletColor' => 'secondary',
            'bullets' => [
                'Website & mobile apps',
                'Smart speaker integration',
                'Third-party platform support'
            ]
        ]
    ]
])

<!-- Platform Integration Showcase -->
<section class="py-20 bg-dark relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Broadcast <span class="text-gradient">Everywhere</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Reach your audience across all platforms and devices with our comprehensive distribution network and seamless integration capabilities.
            </p>
        </div>

        <!-- Platform Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
            
            <!-- Website & Web Players -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-globe text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Website Integration</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Embed radio players and podcast widgets directly into your website for seamless user experience.
                </p>
            </div>

            <!-- Mobile Apps -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-r from-secondary to-accent rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-mobile-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Mobile Apps</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Dedicated iOS and Android apps ensure your content is accessible on all mobile devices.
                </p>
            </div>

            <!-- Smart Speakers -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-r from-accent to-primary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-volume-up text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Smart Speakers</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Integration with Alexa, Google Assistant, and other smart speakers for voice-activated listening.
                </p>
            </div>

            <!-- Podcast Platforms -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-gradient-to-r from-primary to-secondary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-rss text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Podcast Platforms</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Automatic distribution to Spotify, Apple Podcasts, Google Podcasts, and other major platforms.
                </p>
            </div>
        </div>

        <!-- Live Broadcasting Features -->
        <div class="glass-effect rounded-3xl p-12" data-aos="fade-up" data-aos-delay="500">
            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-white mb-4">Professional Broadcasting Tools</h3>
                <p class="text-gray-400">Advanced features designed for professional radio and podcast production</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Live Mixing -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-purple-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sliders-h text-white text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Live Audio Mixing</h4>
                    <p class="text-gray-400 text-sm">Professional mixing console with real-time audio processing and effects.</p>
                </div>

                <!-- Scheduling -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Content Scheduling</h4>
                    <p class="text-gray-400 text-sm">Schedule shows, podcasts, and automated playlists in advance.</p>
                </div>

                <!-- Analytics -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-orange-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Listener Analytics</h4>
                    <p class="text-gray-400 text-sm">Detailed insights into listener behavior, demographics, and engagement.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Types & Applications -->
<section class="py-20 bg-dark-light relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Perfect for <span class="text-gradient">Every Content Type</span>
            </h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                Whether you're creating music shows, talk radio, educational content, or branded podcasts, our platform adapts to your unique broadcasting needs.
            </p>
        </div>

        <!-- Content Types Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Music Programs -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-pink-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-music text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Music Programs</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Curate and broadcast music shows with seamless playlist management, live DJ mixing, and artist information display.
                </p>
            </div>

            <!-- Talk Shows -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-comments text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Talk Shows</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Host engaging talk shows with call-in features, guest management, and interactive audience participation tools.
                </p>
            </div>

            <!-- News Segments -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-red-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-newspaper text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">News Segments</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Deliver breaking news and updates with automated RSS feeds, live reporting tools, and news ticker integration.
                </p>
            </div>

            <!-- Educational Content -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Educational Content</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Create educational podcasts and radio programs with lesson planning, resource sharing, and student engagement features.
                </p>
            </div>

            <!-- Interviews -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-user-friends text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Interviews</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Conduct professional interviews with remote guest connectivity, recording quality optimization, and editing tools.
                </p>
            </div>

            <!-- Corporate Podcasts -->
            <div class="group glass-effect rounded-3xl p-8 hover:bg-white/10 transition-all duration-500" data-aos="fade-up" data-aos-delay="600">
                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-yellow-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-building text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Corporate Podcasts</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Enhance internal communications and brand storytelling with professional corporate podcast production and distribution.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Why Choose Us Section --}}
@include('components.services.why-choose-us', [
    'bgColor' => 'dark',
    'companyName' => 'TKDS Media',
    'description' => 'At TKDS Media, we\'re committed to empowering broadcasters and content creators with innovative solutions that simplify their workflow and maximize their impact. With our intuitive platform, you can focus on creating compelling content while we handle the technicalities.',
    'benefits' => [
        [
            'icon' => 'fas fa-rocket',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Innovative Solutions',
            'description' => 'Cutting-edge technology that simplifies broadcasting and maximizes your content\'s impact on audiences worldwide.'
        ],
        [
            'icon' => 'fas fa-cogs',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'Intuitive Platform',
            'description' => 'User-friendly interface that lets you focus on content creation while we handle all the technical complexities.'
        ],
        [
            'icon' => 'fas fa-users',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Expert Support',
            'description' => 'Dedicated support team with broadcasting expertise to help you succeed in the competitive radio and podcast landscape.'
        ],
        [
            'icon' => 'fas fa-trophy',
            'colorFrom' => 'secondary',
            'colorTo' => 'primary',
            'title' => 'Proven Success',
            'description' => 'Join leading broadcasters who trust TKDS Media to bring their vision to life and engage audiences around the world.'
        ]
    ],
    'process' => [
        'title' => 'Getting Started is Simple',
        'description' => 'From setup to broadcast, we guide you through every step of launching your radio station or podcast',
        'steps' => [
            [
                'color' => 'secondary',
                'title' => 'Setup',
                'description' => 'Create your station and configure your broadcasting preferences'
            ],
            [
                'color' => 'accent',
                'title' => 'Content',
                'description' => 'Upload your shows, music, and create your programming schedule'
            ],
            [
                'color' => 'primary',
                'title' => 'Distribute',
                'description' => 'Launch across all platforms and reach your global audience'
            ],
            [
                'color' => 'secondary',
                'title' => 'Grow',
                'description' => 'Analyze performance and expand your listener base'
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
    'highlightText' => 'Take Your Content',
    'titleEnd' => 'to the Next Level?',
    'description' => 'Partner with TKDS Media and unlock new opportunities for audience engagement and growth. Get started today and experience the power of seamless broadcasting and podcasting with TKDS Media!',
    'primaryButtonText' => 'Start Broadcasting',
    'primaryButtonLink' => route('contact'),
    'buttonFrom' => 'secondary',
    'buttonTo' => 'accent',
    'buttonHoverFrom' => 'accent',
    'buttonHoverTo' => 'primary',
    'secondaryButtonText' => 'Explore Features',
    'secondaryButtonLink' => '#features'
])

{{-- Related Services Section --}}
@include('components.services.related-services', [
    'bgColor' => 'dark',
    'title' => 'Complete Your Media Ecosystem',
    'subtitle' => 'Enhance your radio and podcast services with these complementary solutions',
    'services' => [
        [
            'icon' => 'fas fa-broadcast-tower',
            'colorFrom' => 'primary',
            'colorTo' => 'secondary',
            'title' => 'Stream & Restream',
            'description' => 'Professional streaming services for your radio content',
            'link' => route('services.streaming'),
            'linkColor' => 'primary',
            'linkHoverColor' => 'secondary'
        ],
        [
            'icon' => 'fas fa-mobile-alt',
            'colorFrom' => 'accent',
            'colorTo' => 'primary',
            'title' => 'OTT Apps',
            'description' => 'Dedicated mobile apps for your radio and podcast content',
            'link' => route('services.ott-apps'),
            'linkColor' => 'accent',
            'linkHoverColor' => 'primary'
        ],
        [
            'icon' => 'fas fa-cloud',
            'colorFrom' => 'secondary',
            'colorTo' => 'accent',
            'title' => 'Cloud Servers',
            'description' => '24/7 cloud infrastructure for continuous broadcasting',
            'link' => route('services.cloud-servers'),
            'linkColor' => 'secondary',
            'linkHoverColor' => 'accent'
        ]
    ]
])

@endsection