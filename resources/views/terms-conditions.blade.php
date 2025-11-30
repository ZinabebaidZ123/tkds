@extends('layouts.app')

@section('title', 'Terms & Conditions - TKDS Media')
@section('meta_description', 'Read the terms and conditions for using TKDS Media services and platform.')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-dark via-dark-light to-dark overflow-hidden">
    <!-- Dynamic Background -->
    <div class="absolute inset-0">
        <div class="absolute top-32 left-32 w-80 h-80 bg-gradient-to-r from-secondary/20 to-accent/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-[400px] h-[400px] bg-gradient-to-l from-primary/20 to-secondary/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s;"></div>
        <div class="absolute top-1/3 left-1/3 w-[300px] h-[300px] bg-gradient-to-tr from-accent/15 to-primary/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 6s;"></div>
    </div>

    <!-- Floating Legal Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        @for($i = 0; $i < 12; $i++)
            <div class="absolute animate-float opacity-10" 
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 4000) }}ms; animation-duration: {{ rand(10000, 20000) }}ms;">
                <i class="fas {{ ['fa-gavel', 'fa-balance-scale', 'fa-file-contract', 'fa-handshake', 'fa-stamp'][array_rand(['fa-gavel', 'fa-balance-scale', 'fa-file-contract', 'fa-handshake', 'fa-stamp'])] }} text-secondary text-4xl"></i>
            </div>
        @endfor
    </div>

    <!-- Main Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div data-aos="fade-up">

            
            <!-- Epic Title -->
            <h1 class="text-4xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white mb-6 md:mb-8 leading-tight">
                Terms &
                <span class="relative block md:inline">
                    <span class="text-gradient bg-gradient-to-r from-secondary via-accent to-primary bg-clip-text text-transparent">Conditions</span>
                    <svg class="absolute -bottom-6 left-0 w-full h-8" viewBox="0 0 400 40" fill="none">
                        <path d="M10 20 Q500 5 390 20  35 10 20" stroke="url(#gradient)" stroke-width="3" fill="none"/>
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color:#E53E3E"/>
                                <stop offset="50%" style="stop-color:#FC8181"/>
                                <stop offset="100%" style="stop-color:#C53030"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-lg md:text-xl lg:text-2xl xl:text-3xl text-gray-300 max-w-5xl mx-auto leading-relaxed mb-8 md:mb-12 px-4">
                Our mutual <span class="text-secondary font-bold">agreement</span> that ensures 
                <span class="text-accent font-bold">fair use</span> and <span class="text-primary font-bold">protection</span> for everyone
            </p>

            <!-- Key Points -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-4xl mx-auto mb-8 md:mb-12 px-4" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center group">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-r from-secondary to-accent rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-2 md:mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-handshake text-white text-lg md:text-xl"></i>
                    </div>
                    <div class="text-sm md:text-lg font-bold text-white">Fair Use</div>
                </div>
                <div class="text-center group">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-r from-accent to-primary rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-2 md:mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-white text-lg md:text-xl"></i>
                    </div>
                    <div class="text-sm md:text-lg font-bold text-white">Protection</div>
                </div>
                <div class="text-center group">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-r from-primary to-secondary rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-2 md:mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-balance-scale text-white text-lg md:text-xl"></i>
                    </div>
                    <div class="text-sm md:text-lg font-bold text-white">Balanced</div>
                </div>
                <div class="text-center group">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-r from-secondary to-primary rounded-xl md:rounded-2xl flex items-center justify-center mx-auto mb-2 md:mb-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-check-circle text-white text-lg md:text-xl"></i>
                    </div>
                    <div class="text-sm md:text-lg font-bold text-white">Clear</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 md:gap-6 justify-center px-4" data-aos="fade-up" data-aos-delay="400">
                <a href="#terms-content" class="inline-flex items-center space-x-3 px-10 py-5 bg-gradient-to-r from-secondary to-accent text-white font-bold rounded-2xl hover:from-accent hover:to-primary transition-all duration-300 transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-scroll"></i>
                    <span>Read Terms</span>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center space-x-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-question-circle"></i>
                    <span>Ask Questions</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Animated Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2">
        <div class="flex flex-col items-center space-y-2 animate-bounce">
            <div class="text-secondary text-sm font-medium">Scroll to Read</div>
            <div class="w-6 h-10 border-2 border-secondary/50 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-secondary rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </div>
</section>

<!-- Terms Content -->
<section id="terms-content" class="py-20 bg-gradient-to-b from-dark-light to-dark">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-white/5 to-white/10 backdrop-blur-xl rounded-full px-8 py-4 border border-white/10 mb-6">
                <i class="fas fa-calendar-check text-secondary"></i>
                <span class="text-gray-300">Effective Date: December 2024</span>
            </div>
            <h2 class="text-4xl font-black text-white mb-4">Service Agreement</h2>
            <p class="text-gray-400 text-lg max-w-3xl mx-auto">
                By using TKDS Media services, you agree to these terms and conditions. 
                Please read them carefully as they govern your use of our platform.
            </p>
        </div>

        <!-- Terms List -->
        <div class="space-y-8">
            @php
                $terms = [
                    [
                        'title' => 'Acceptance of Terms',
                        'content' => 'Your use constitutes acceptance of these Terms and Conditions as at the date of your first use of the site. By accessing or using any part of our service, you agree to be bound by these terms.',
                        'icon' => 'fa-check-circle',
                        'color' => 'from-primary to-secondary'
                    ],
                    [
                        'title' => 'Modifications to Terms',
                        'content' => 'TKDS MEDIA reserves the rights to change these Terms and Conditions at any time by posting changes online. Your continued use of this site after changes are posted constitutes your acceptance of this agreement as modified.',
                        'icon' => 'fa-edit',
                        'color' => 'from-secondary to-accent'
                    ],
                    [
                        'title' => 'Acceptable Use Policy',
                        'content' => 'You agree to use this site only for lawful purposes, and in a manner which does not infringe the rights, or restrict, or inhibit the use and enjoyment of the site by any third party. This includes respecting intellectual property rights and maintaining professional conduct.',
                        'icon' => 'fa-user-check',
                        'color' => 'from-accent to-primary'
                    ],
                    [
                        'title' => 'Service Availability',
                        'content' => 'This site and the information, names, images, pictures, logos regarding or relating to TKDS MEDIA are provided "as is" without any representation or endorsement made and without warranty of any kind whether express or implied.',
                        'icon' => 'fa-server',
                        'color' => 'from-primary to-accent'
                    ],
                    [
                        'title' => 'Technical Performance',
                        'content' => 'TKDS MEDIA does not warrant that the functions contained in the material contained in this site will be uninterrupted or error free, that defects will be corrected, or that this site or the server that makes it available are free of viruses or bugs.',
                        'icon' => 'fa-cogs',
                        'color' => 'from-secondary to-primary'
                    ],
                    [
                        'title' => 'Intellectual Property',
                        'content' => 'Copyright restrictions: please refer to our Creative Commons license terms governing the use of material on this site. All content, trademarks, and data on this website are the property of TKDS MEDIA or its licensors.',
                        'icon' => 'fa-copyright',
                        'color' => 'from-accent to-secondary'
                    ],
                    [
                        'title' => 'External Links',
                        'content' => 'TKDS MEDIA takes no responsibility for the content of external Internet Sites. Any links to third-party websites are provided for convenience only and we do not endorse the content of such sites.',
                        'icon' => 'fa-external-link-alt',
                        'color' => 'from-primary to-secondary'
                    ],
                    [
                        'title' => 'User Communications',
                        'content' => 'Any communication or material that you transmit to, or post on, any public area of the site including any data, questions, comments, suggestions, or the like, is, and will be treated as, non-confidential and non-proprietary information.',
                        'icon' => 'fa-comments',
                        'color' => 'from-secondary to-accent'
                    ],
                    [
                        'title' => 'Conflict Resolution',
                        'content' => 'If there is any conflict between these Terms and Conditions and rules and/or specific terms of use appearing on this site relating to specific material then the latter shall prevail.',
                        'icon' => 'fa-balance-scale',
                        'color' => 'from-accent to-primary'
                    ],
                    [
                        'title' => 'Governing Law',
                        'content' => 'These terms and conditions shall be governed and construed in accordance with the laws of England and Wales. Any disputes shall be subject to the exclusive jurisdiction of the Courts of England and Wales.',
                        'icon' => 'fa-gavel',
                        'color' => 'from-primary to-accent'
                    ],
                    [
                        'title' => 'Termination Clause',
                        'content' => 'If these Terms and Conditions are not accepted in full, the use of this site must be terminated immediately. We reserve the right to terminate or suspend access to our service for violations of these terms.',
                        'icon' => 'fa-times-circle',
                        'color' => 'from-secondary to-primary'
                    ]
                ];
            @endphp

            @foreach($terms as $index => $term)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ $index * 80 }}">
                    <div class="relative bg-gradient-to-br from-white/5 to-white/10 backdrop-blur-xl rounded-2xl p-4 md:p-6 lg:p-8 border border-white/10 hover:border-white/20 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 overflow-hidden">
                        <!-- Background Glow -->
                        <div class="absolute top-0 right-0 w-16 h-16 md:w-24 md:h-24 bg-gradient-to-br {{ $term['color'] }} opacity-20 rounded-full blur-xl transform translate-x-4 md:translate-x-8 -translate-y-4 md:-translate-y-8 group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <!-- Term Number -->
                        <div class="absolute top-3 right-3 md:top-6 md:right-6 w-8 h-8 md:w-12 md:h-12 bg-gradient-to-r {{ $term['color'] }} rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-black text-sm md:text-lg">{{ $index + 1 }}</span>
                        </div>

                        <!-- Content -->
                        <div class="flex flex-col md:flex-row md:items-start space-y-4 md:space-y-0 md:space-x-6">
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-r {{ $term['color'] }} rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 shadow-xl mx-auto md:mx-0">
                                <i class="fas {{ $term['icon'] }} text-white text-lg md:text-xl"></i>
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <h3 class="text-lg md:text-xl lg:text-2xl font-black text-white mb-3 md:mb-4 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:{{ $term['color'] }} group-hover:bg-clip-text transition-all duration-500 leading-tight">
                                    {{ $term['title'] }}
                                </h3>
                                <p class="text-gray-300 text-sm md:text-base lg:text-lg leading-relaxed group-hover:text-white transition-colors duration-500">
                                    {{ $term['content'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Agreement Section -->
        <div class="mt-16 md:mt-20" data-aos="fade-up">
            <div class="relative bg-gradient-to-r from-secondary/10 via-accent/10 to-primary/10 backdrop-blur-xl rounded-2xl md:rounded-3xl p-8 md:p-12 border border-secondary/20 text-center overflow-hidden">
                <!-- Animated Background -->
                <div class="absolute inset-0 bg-gradient-to-r from-secondary/5 to-accent/5 opacity-0 hover:opacity-100 transition-opacity duration-1000"></div>
                
                <!-- Content -->
                <div class="relative z-10">
                    <div class="w-16 h-16 md:w-24 md:h-24 bg-gradient-to-r from-secondary to-accent rounded-full flex items-center justify-center mx-auto mb-6 md:mb-8 shadow-2xl">
                        <i class="fas fa-handshake text-white text-2xl md:text-3xl"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-black text-white mb-4 md:mb-6">Ready to Agree?</h3>
                    <p class="text-gray-300 mb-8 md:mb-10 text-base md:text-lg lg:text-xl max-w-3xl mx-auto leading-relaxed px-4">
                        By using our services, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 md:gap-6 justify-center px-4">
                        <a href="{{ route('pricing') }}" class="inline-flex items-center justify-center space-x-3 px-6 md:px-10 py-4 md:py-5 bg-gradient-to-r from-secondary to-accent text-white font-bold rounded-xl md:rounded-2xl hover:from-accent hover:to-primary transition-all duration-300 transform hover:scale-105 shadow-2xl">
                            <i class="fas fa-rocket"></i>
                            <span>Get Started</span>
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center space-x-3 px-6 md:px-10 py-4 md:py-5 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-bold rounded-xl md:rounded-2xl hover:bg-white/20 transition-all duration-300">
                            <i class="fas fa-question-circle"></i>
                            <span>Have Questions?</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection