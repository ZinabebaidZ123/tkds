<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $itemType }} Inquiry - {{ $itemName }}</title>
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
        .priority-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }
        .priority-high {
            background-color: #dc3545;
            color: white;
        }
        .priority-normal {
            background-color: #28a745;
            color: white;
        }
        .priority-test {
            background-color: #ffc107;
            color: #212529;
        }
        .content {
            padding: 30px;
        }
        .customer-info {
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
        .message-section {
            margin: 20px 0;
        }
        .message-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            font-style: italic;
            line-height: 1.8;
        }
        .item-info {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #e1e5e9;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>New {{ $itemType }} Inquiry</h1>
            <div class="priority-badge priority-{{ strtolower($priority) }}">
                @if($priority === 'high' || $priority === 'HIGH')
                    HIGH PRIORITY
                @elseif($priority === 'test' || $priority === 'TEST')
                    TEST MESSAGE
                @else
                    NORMAL PRIORITY
                @endif
            </div>
            @if(isset($reference_id))
            <p style="margin: 10px 0 0 0; font-size: 14px; opacity: 0.9;">
                Reference ID: {{ $reference_id }}
            </p>
            @endif
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Customer Information -->
            <div class="customer-info">
                <h3 style="margin-top: 0; color: #C53030;">Customer Information</h3>
                
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $name }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">
                        <a href="mailto:{{ $email }}" style="color: #C53030; text-decoration: none;">{{ $email }}</a>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">
                        @if($phone && $phone !== 'Not provided')
                            <a href="tel:{{ $phone }}" style="color: #C53030; text-decoration: none;">{{ $phone }}</a>
                        @else
                            <span style="color: #6c757d; font-style: italic;">Not provided</span>
                        @endif
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Submitted:</span>
                    <span class="info-value">{{ $submittedAt }}</span>
                </div>
                
                @if($payNow)
                <div class="info-row">
                    <span class="info-label">Payment:</span>
                    <span class="info-value" style="color: #28a745; font-weight: bold;">Ready to pay now</span>
                </div>
                @endif
            </div>

            <!-- Item Information -->
            <div class="item-info">
                <h3 style="margin-top: 0; color: #6f42c1;">
                    @if($itemType === 'Service')
                        Service Details
                    @else
                        Product Details
                    @endif
                </h3>
                
                <div class="info-row">
                    <span class="info-label">{{ $itemType }}:</span>
                    <span class="info-value" style="font-weight: bold;">{{ $itemName }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">ID:</span>
                    <span class="info-value">#{{ $itemId }}</span>
                </div>
            </div>

            <!-- Message Section -->
            <div class="message-section">
                <h3 style="color: #495057;">Customer Message</h3>
                <div class="message-content">
                    {{ $customerMessage }}
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="mailto:{{ $email }}?subject=Re: {{ $itemName }} Inquiry @if(isset($reference_id))(Ref: {{ $reference_id }})@endif" 
                   style="display: inline-block; background: linear-gradient(135deg, #C53030, #E53E3E); color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 0 10px; font-weight: bold;">
                    Reply to Customer
                </a>
                
                @if($phone && $phone !== 'Not provided')
                <a href="tel:{{ $phone }}" 
                   style="display: inline-block; background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 0 10px; font-weight: bold;">
                    Call Customer
                </a>
                @endif
            </div>

            <!-- Additional Information -->
            @if($priority === 'high' || $priority === 'HIGH')
            <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <strong>High Priority:</strong> Customer indicated they are ready to pay now. Please respond within 1 hour for best conversion rate.
            </div>
            @endif

            @if($priority === 'test' || $priority === 'TEST')
            <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <strong>Test Message:</strong> This is a test email to verify the email configuration. You can ignore this message.
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">
                This inquiry was submitted through the TKDS Media website.<br>
                <a href="https://tkdsmedia.com">Visit TKDS Media</a> | 
                <a href="mailto:info@tkdsmedia.com">Contact Support</a>
            </p>
            <p style="margin: 10px 0 0 0; font-size: 12px; color: #adb5bd;">
                Copyright {{ date('Y') }} TKDS Media. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>