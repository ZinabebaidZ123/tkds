<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Blog Post Published</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #C53030, #E53E3E);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .logo {
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            color: #ffffff;
        }
        .logo-text {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 1px;
        }
        .header-subtitle {
            margin: 10px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .post-info {
            background-color: #f8f9fa;
            border-left: 4px solid #C53030;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
            min-width: 100px;
        }
        .info-value {
            color: #212529;
        }
        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin: 20px 0;
        }
        .post-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            background: linear-gradient(135deg, #C53030, #E53E3E);
            color: white;
            margin-bottom: 15px;
        }
        .post-title {
            font-size: 24px;
            font-weight: 800;
            color: #212529;
            margin-bottom: 15px;
            line-height: 1.3;
        }
        .post-excerpt {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            line-height: 1.8;
            margin: 20px 0;
            color: #495057;
        }
        .post-meta-section {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #e1e5e9;
        }
        .post-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .meta-item {
            display: flex;
            align-items: center;
            color: #495057;
            font-size: 14px;
        }
        .meta-icon {
            margin-right: 8px;
            color: #C53030;
            width: 16px;
            height: 16px;
        }
        .cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #C53030, #E53E3E);
            color: white !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
            text-align: center;
            margin: 0 auto;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(197, 48, 48, 0.3);
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(197, 48, 48, 0.4);
            background: linear-gradient(135deg, #B91C1C, #DC2626);
        }
        
        .cta-button:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .cta-button:hover:before {
            left: 100%;
        }
        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #C53030;
            text-decoration: none;
        }
        .newsletter-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            text-align: center;
            color: #495057;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            .header, .content {
                padding: 20px;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                margin-bottom: 5px;
            }
            .post-title {
                font-size: 20px;
            }
            .post-meta {
                flex-direction: column;
                gap: 10px;
            }
            .cta-button {
                display: flex;
                margin: 10px auto;
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <svg class="logo-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <span class="logo-text">TKDS MEDIA</span>
            </div>
            <h1>New Article Published!</h1>
            <p class="header-subtitle">Exciting new content awaits you</p>
        </div>

        <!-- Content -->
        <div class="content">
            @if($post->featured_image)
            <img src="{{ $post->getFeaturedImageUrl() }}" alt="{{ $post->title }}" class="post-image">
            @endif
            
            <div class="post-badge">
                <svg style="width: 12px; height: 12px; margin-right: 6px;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                NEW POST
            </div>
            
            <h2 class="post-title">{{ $post->title }}</h2>
            
            <!-- Post Information -->
            <div class="post-info">
                <h3 style="margin-top: 0; color: #C53030;">Article Details</h3>
                
                @if($post->author)
                <div class="info-row">
                    <span class="info-label">Author:</span>
                    <span class="info-value">{{ $post->author->name }}</span>
                </div>
                @endif
                
                @if($post->category)
                <div class="info-row">
                    <span class="info-label">Category:</span>
                    <span class="info-value">{{ $post->category->name }}</span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="info-label">Reading Time:</span>
                    <span class="info-value">{{ $post->getReadingTime() }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Published:</span>
                    <span class="info-value">{{ $post->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <!-- Post Excerpt -->
            {{-- <div style="margin: 20px 0;">
                <h3 style="color: #495057;">Article Preview</h3>
                <div class="post-excerpt">
                    @if($post->excerpt)
                        {{ $post->excerpt }}
                    @else
                        {{ $post->getExcerpt(150) }}
                    @endif
                </div>
            </div> --}}

            <!-- Post Meta Section -->
            <div class="post-meta-section">
                <h3 style="margin-top: 0; color: #6f42c1;">Article Information</h3>
                <div class="post-meta">
                    @if($post->author)
                    <div class="meta-item">
                        <svg class="meta-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        <span>By {{ $post->author->name }}</span>
                    </div>
                    @endif
                    
                    @if($post->category)
                    <div class="meta-item">
                        <svg class="meta-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2h-8l-2-2z"/>
                        </svg>
                        <span>{{ $post->category->name }}</span>
                    </div>
                    @endif
                    
                    <div class="meta-item">
                        <svg class="meta-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        <span>{{ $post->getReadingTime() }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('blog.show', $post->slug) }}" class="cta-button">
                    <span style="position: relative; z-index: 2;">
                        Read Full Article
                        <svg style="width: 18px; height: 18px; margin-left: 10px; vertical-align: middle;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                        </svg>
                    </span>
                </a>
            </div>

            <!-- Newsletter Information -->
            <div class="newsletter-info">
                <p style="margin: 0 0 10px 0; font-weight: bold;">
                    <svg style="width: 16px; height: 16px; margin-right: 8px; vertical-align: middle; color: #C53030;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Thank you for subscribing to our newsletter!
                </p>
                <p style="margin: 0; color: #6c757d; font-size: 14px;">
                    This email was sent because you subscribed to our blog updates.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">
                Stay connected for more amazing content and updates.<br>
                <a href="https://tkdsmedia.com">Visit TKDS Media</a> | 
                <a href="mailto:info@tkdsmedia.com">Contact Support</a>
            </p>
            <p style="margin: 10px 0 0 0; font-size: 12px; color: #adb5bd;">
                If you no longer wish to receive these emails, you can 
                <a href="#" style="color: #C53030;">unsubscribe here</a>.
            </p>
            <p style="margin: 10px 0 0 0; font-size: 12px; color: #adb5bd;">
                Copyright {{ date('Y') }} TKDS Media. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>