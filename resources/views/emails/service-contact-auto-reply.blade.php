<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for contacting TKDS Media</title>
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
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #495057;
            margin-bottom: 20px;
        }
        .inquiry-info {
            background-color: #f8f9fa;
            border-left: 4px solid #C53030;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        .response-time {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            border: 1px solid #e1e5e9;
            text-align: center;
        }
        .next-steps {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .contact-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .social-links {
            text-align: center;
            margin: 30px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 15px;
            background-color: #C53030;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
        }
        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 30px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #C53030;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            .header, .content {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Thank You!</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">
                We've received your inquiry about {{ $itemName }}
            </p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                Hello {{ $name }},
            </div>

            <p style="font-size: 16px; color: #495057;">
                Thank you for your interest in <strong>{{ $itemName }}</strong>! We're excited to help you achieve your goals with our {{ strtolower($itemType) }}.
            </p>

            <!-- Inquiry Summary -->
            <div class="inquiry-info">
                <h3 style="margin-top: 0; color: #C53030;">Your Inquiry Details</h3>
                <p><strong>{{ $itemType }}:</strong> {{ $itemName }}</p>
                <p><strong>Submitted:</strong> {{ $submittedAt }}</p>
                @if(isset($reference_id))
                <p><strong>Reference ID:</strong> {{ $reference_id }}</p>
                @else
                <p><strong>Reference ID:</strong> #{{ $itemId }}-{{ date('Ymd-His') }}</p>
                @endif
                @if($payNow)
                <p style="color: #28a745; font-weight: bold;">Priority Status: Ready to Purchase</p>
                @endif
            </div>

            <!-- Response Time -->
            <div class="response-time">
                <h3 style="margin-top: 0; color: #495057;">What's Next?</h3>
                @if($priority === 'high' || $priority === 'HIGH')
                <p style="color: #28a745; font-weight: bold; font-size: 18px;">
                    High Priority Response - We'll contact you within 1 hour!
                </p>
                @else
                <p style="color: #495057; font-size: 16px;">
                    We'll contact you within 24 hours during business hours
                </p>
                @endif
                <p style="font-size: 14px; color: #6c757d;">
                    Business Hours: Monday - Friday, 9:00 AM - 6:00 PM (EST)
                </p>
            </div>

            <!-- Next Steps -->
            <div class="next-steps">
                <h3 style="margin-top: 0;">While You Wait</h3>
                <ul style="margin: 0; padding-left: 20px;">
                    <li>Check your email for our response (including spam folder)</li>
                    <li>Save our contact information for easy reference</li>
                    <li>Visit our website to explore more services</li>
                    @if($itemType === 'Product')
                    <li>Check out our product documentation and demos</li>
                    @else
                    <li>Review our service portfolio and case studies</li>
                    @endif
                </ul>
            </div>

            <!-- Contact Information -->
            <div class="contact-info">
                <h3 style="margin-top: 0; color: #495057;">Contact Information</h3>
                <p><strong>Email:</strong> <a href="mailto:info@tkdsmedia.com" style="color: #C53030;">info@tkdsmedia.com</a></p>
                <p><strong>Phone:</strong> <a href="tel:+12313600088" style="color: #C53030;">+1 (231) 360-0088</a></p>
                <p><strong>Website:</strong> <a href="https://tkdsmedia.com" style="color: #C53030;">www.tkdsmedia.com</a></p>
            </div>

            <!-- Message Preview -->
            <div style="background-color: #f8f9fa; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h3 style="margin-top: 0; color: #495057;">Your Message</h3>
                <div style="font-style: italic; color: #6c757d; border-left: 3px solid #dee2e6; padding-left: 15px;">
                    "{{ Str::limit($customerMessage, 200) }}"
                </div>
            </div>

            <!-- Social Links -->
            {{-- <div class="social-links">
                <p style="color: #495057; margin-bottom: 15px;">Follow us for updates and insights:</p>
                <a href="#" title="Facebook">Facebook</a>
                <a href="#" title="Twitter">Twitter</a>
                <a href="#" title="LinkedIn">LinkedIn</a>
                <a href="#" title="YouTube">YouTube</a>
                <a href="#" title="Instagram">Instagram</a>
            </div> --}}
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">
                <strong>TKDS Media</strong> - Your World, Live and Direct<br>
                Leading the future of digital broadcasting
            </p>
            <p style="margin: 15px 0 0 0; font-size: 12px; color: #adb5bd;">
                Copyright {{ date('Y') }} TKDS Media LLC. All rights reserved.<br>
                You received this email because you submitted an inquiry on our website.
            </p>
        </div>
    </div>
</body>
</html>