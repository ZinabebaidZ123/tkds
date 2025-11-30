@extends('layouts.app')

@section('title', 'Privacy Policy - TKDS Media')
@section('meta_description', 'Learn how TKDS Media protects your privacy and handles your personal information.')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-32 right-32 w-96 h-96 bg-gradient-to-l from-accent/20 to-primary/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-tr from-secondary/10 to-accent/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <!-- Floating Privacy Icons -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        @for($i = 0; $i < 15; $i++)
            <div class="absolute animate-float opacity-20" 
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5000) }}ms; animation-duration: {{ rand(8000, 15000) }}ms;">
                <i class="fas {{ ['fa-shield-alt', 'fa-lock', 'fa-user-shield', 'fa-eye-slash', 'fa-key'][array_rand(['fa-shield-alt', 'fa-lock', 'fa-user-shield', 'fa-eye-slash', 'fa-key'])] }} text-primary text-3xl"></i>
            </div>
        @endfor
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div data-aos="fade-up">

            <!-- Main Title -->
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-black text-white mb-8 leading-tight">
                Privacy
                <span class="relative">
                    <span class="text-gradient bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent">Policy</span>
                    <div class="absolute -bottom-4 left-0 right-0 h-2 bg-gradient-to-r from-primary via-secondary to-accent rounded-full opacity-50"></div>
                </span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-2xl md:text-3xl text-gray-300 max-w-4xl mx-auto leading-relaxed mb-12">
                We believe in <span class="text-primary font-bold">transparency</span> and 
                <span class="text-secondary font-bold">protection</span> when it comes to your personal data
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center">
                    <div class="text-4xl font-black text-primary mb-2">100%</div>
                    <div class="text-gray-400 text-sm">Transparent</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-black text-secondary mb-2">256</div>
                    <div class="text-gray-400 text-sm">Encryption</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-black text-accent mb-2">GDPR</div>
                    <div class="text-gray-400 text-sm">Compliant</div>
                </div>
            </div>

            <!-- CTA -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400">
                <a href="#content" class="inline-flex items-center space-x-3 px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-2xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-book-open"></i>
                    <span>Read Policy</span>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center space-x-3 px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Us</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center">
            <div class="w-1 h-3 bg-primary rounded-full mt-2 animate-pulse"></div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section id="content" class="py-20 bg-gradient-to-b from-dark-light to-dark">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Last Updated -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-white/5 to-white/10 backdrop-blur-xl rounded-full px-6 py-3 border border-white/10">
                <i class="fas fa-calendar-alt text-primary"></i>
                <span class="text-gray-300">Last updated: December 2024</span>
            </div>
        </div>

        <!-- Privacy Sections -->
        <div class="space-y-16">
            @php
                $sections = [
                    [
                        'icon' => 'fa-info-circle',
                        'title' => 'Information We Collect',
                        'gradient' => 'from-primary to-secondary',
                        'content' => [
                            'Personal Information: Name, email address, phone number, and postal address when you register or contact us.',
                            'Usage Data: Information about how you use our website, including pages visited, time spent, and interaction patterns.',
                            'Device Information: IP address, browser type, device type, and operating system for security and optimization purposes.',
                            'Communication Records: Records of your communications with our support team for quality assurance and improvement.'
                        ]
                    ],
                    [
                        'icon' => 'fa-cogs',
                        'title' => 'How We Use Your Information',
                        'gradient' => 'from-secondary to-accent',
                        'content' => [
                            'Service Delivery: To provide, maintain, and improve our broadcasting services and platform functionality.',
                            'Customer Support: To respond to your inquiries, provide technical support, and resolve any issues you may encounter.',
                            'Communications: To send you important updates, security alerts, and promotional content (with your consent).',
                            'Analytics: To understand user behavior, improve our services, and develop new features that better serve your needs.'
                        ]
                    ],
                    [
                        'icon' => 'fa-shield-alt',
                        'title' => 'Data Protection & Security',
                        'gradient' => 'from-accent to-primary',
                        'content' => [
                            'Encryption: All sensitive data is encrypted using industry-standard 256-bit SSL encryption during transmission.',
                            'Access Controls: Strict access controls ensure only authorized personnel can access your personal information.',
                            'Regular Audits: We conduct regular security audits and assessments to identify and address potential vulnerabilities.',
                            'Incident Response: We have comprehensive incident response procedures to quickly address any security concerns.'
                        ]
                    ],
                    [
                        'icon' => 'fa-share-alt',
                        'title' => 'Information Sharing',
                        'gradient' => 'from-primary to-accent',
                        'content' => [
                            'Service Providers: We may share information with trusted third-party service providers who assist in our operations.',
                            'Legal Requirements: We may disclose information when required by law, court order, or government request.',
                            'Business Transfers: In the event of a merger or acquisition, your information may be transferred to the new entity.',
                            'Consent: We will never sell your personal information or share it for marketing purposes without your explicit consent.'
                        ]
                    ],
                    [
                        'icon' => 'fa-user-cog',
                        'title' => 'Your Rights & Choices',
                        'gradient' => 'from-secondary to-primary',
                        'content' => [
                            'Access: You have the right to request access to the personal information we hold about you.',
                            'Correction: You can request corrections to any inaccurate or incomplete personal information.',
                            'Deletion: You have the right to request deletion of your personal information, subject to legal requirements.',
                            'Portability: You can request a copy of your data in a structured, machine-readable format.'
                        ]
                    ],
                    [
                        'icon' => 'fa-cookie-bite',
                        'title' => 'Cookies & Tracking',
                        'gradient' => 'from-accent to-secondary',
                        'content' => [
                            'Essential Cookies: Necessary for website functionality, including login sessions and security features.',
                            'Analytics Cookies: Help us understand how visitors interact with our website to improve user experience.',
                            'Marketing Cookies: Used to deliver relevant advertisements and track campaign effectiveness.',
                            'Cookie Control: You can manage cookie preferences through your browser settings or our cookie consent tool.'
                        ]
                    ]
                ];
            @endphp

            @foreach($sections as $index => $section)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="relative bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-3xl p-10 border border-white/10 hover:border-white/20 transition-all duration-700 hover:shadow-2xl overflow-hidden">
                        <!-- Background Decoration -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br {{ $section['gradient'] }} opacity-10 rounded-full blur-xl transform translate-x-16 -translate-y-16 group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <!-- Header -->
                        <div class="flex items-center space-x-6 mb-8">
                            <div class="w-20 h-20 bg-gradient-to-r {{ $section['gradient'] }} rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <i class="fas {{ $section['icon'] }} text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-3xl font-black text-white group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:{{ $section['gradient'] }} group-hover:bg-clip-text transition-all duration-500">
                                    {{ $section['title'] }}
                                </h3>
                                <div class="w-0 h-1 bg-gradient-to-r {{ $section['gradient'] }} rounded-full group-hover:w-32 transition-all duration-700 mt-2"></div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="space-y-6">
                            @foreach($section['content'] as $item)
                                <div class="flex items-start space-x-4 group/item">
                                    <div class="w-2 h-2 bg-gradient-to-r {{ $section['gradient'] }} rounded-full mt-3 group-hover/item:scale-150 transition-transform duration-300"></div>
                                    <p class="text-gray-300 text-lg leading-relaxed group-hover/item:text-white transition-colors duration-300">
                                        {{ $item }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Contact Section -->
        <div class="mt-20" data-aos="fade-up">
            <div class="relative bg-gradient-to-r from-primary/10 via-secondary/10 to-accent/10 backdrop-blur-xl rounded-3xl p-12 border border-primary/20 text-center overflow-hidden">
                <!-- Background Animation -->
                <div class="absolute inset-0 bg-gradient-to-r from-primary/5 to-secondary/5 opacity-0 hover:opacity-100 transition-opacity duration-1000"></div>
                
                <!-- Content -->
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl">
                        <i class="fas fa-envelope text-white text-3xl"></i>
                    </div>
                    <h3 class="text-4xl font-black text-white mb-6">Questions About Your Privacy?</h3>
                    <p class="text-gray-300 mb-10 text-xl max-w-3xl mx-auto leading-relaxed">
                        We're committed to transparency. If you have any questions about how we handle your data, 
                        our dedicated privacy team is here to help.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center">
                        <a href="{{ route('contact') }}" class="inline-flex items-center space-x-3 px-10 py-5 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-2xl hover:from-secondary hover:to-accent transition-all duration-300 transform hover:scale-105 shadow-2xl">
                            <i class="fas fa-phone"></i>
                            <span>Contact Privacy Team</span>
                        </a>
                        <a href="mailto:privacy@tkdsmedia.com" class="inline-flex items-center space-x-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-envelope"></i>
                            <span>privacy@tkdsmedia.com</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection