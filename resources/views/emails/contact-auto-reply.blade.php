{{-- File: resources/views/emails/contact-auto-reply.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->auto_reply_subject ?? 'Thank you for contacting TKDS Media' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #C53030, #E53E3E);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #C53030, #E53E3E);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .highlight {
            background: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #C53030;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank You for Contacting Us!</h1>
        <p>TKDS Media - Professional Broadcasting Solutions</p>
    </div>
    
    <div class="content">
        <p>Dear {{ $submission->first_name }},</p>
        
        <p>{{ $settings->auto_reply_message ?? 'Thank you for reaching out to us. We have received your message and will get back to you within 24 hours.' }}</p>
        
        <div class="highlight">
            <h3>Your Message Summary:</h3>
            <p><strong>Name:</strong> {{ $submission->full_name }}</p>
            <p><strong>Email:</strong> {{ $submission->email }}</p>
            @if($submission->phone)
                <p><strong>Phone:</strong> {{ $submission->phone }}</p>
            @endif
            @if($submission->service_interest)
                <p><strong>Service Interest:</strong> {{ $submission->getServiceInterestLabel() }}</p>
            @endif
            @if($submission->budget)
                <p><strong>Budget:</strong> {{ $submission->getBudgetLabel() }}</p>
            @endif
            <p><strong>Message:</strong> {{ Str::limit($submission->message, 200) }}</p>
        </div>
        
        <p>We appreciate your interest in our broadcasting solutions. Our team will review your inquiry and get back to you as soon as possible.</p>
        
        <p>In the meantime, feel free to:</p>
        <ul>
            <li>Visit our <a href="{{ route('home') }}">website</a> to learn more about our services</li>
            <li>Check out our <a href="{{ route('blog.index') }}">blog</a> for industry insights</li>
            <li>Follow us on social media for updates</li>
        </ul>
        
        <p>Best regards,<br>
        The TKDS Media Team</p>
        
        @if($settings->office_phone || $settings->office_email)
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
            <h4>Contact Information:</h4>
            @if($settings->office_phone)
                <p><strong>Phone:</strong> {{ $settings->office_phone }}</p>
            @endif
            @if($settings->office_email)
                <p><strong>Email:</strong> {{ $settings->office_email }}</p>
            @endif
        </div>
        @endif
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} TKDS Media. All rights reserved.</p>
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html>

{{-- File: resources/views/emails/contact-notification.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission - {{ $submission->full_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #C53030, #E53E3E);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .info-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #C53030;
        }
        .priority-high { border-left-color: #dc2626; background: #fef2f2; }
        .priority-medium { border-left-color: #d97706; background: #fffbeb; }
        .priority-low { border-left-color: #059669; background: #f0fdf4; }
        .message-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #e5e7eb;
        }
        .actions {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background: #C53030;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 0 10px;
        }
        .button-secondary {
            background: #6b7280;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚨 New Contact Form Submission</h1>
        <p>Received {{ $submission->created_at->format('M d, Y \a\t g:i A') }}</p>
    </div>
    
    <div class="content">
        <div class="priority-{{ strtolower($submission->getPriorityLabel()) }}" style="padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            <h2 style="margin: 0; color: #333;">{{ $submission->getPriorityLabel() }} Priority Lead</h2>
            <p style="margin: 5px 0 0 0; font-size: 14px;">Priority Score: {{ $submission->getPriorityScore() }}/100</p>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <h3 style="margin: 0 0 10px 0; color: #C53030;">👤 Contact Details</h3>
                <p><strong>Name:</strong> {{ $submission->full_name }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a></p>
                @if($submission->phone)
                    <p><strong>Phone:</strong> <a href="tel:{{ $submission->phone }}">{{ $submission->phone }}</a></p>
                @endif
            </div>
            
            <div class="info-item">
                <h3 style="margin: 0 0 10px 0; color: #C53030;">🎯 Inquiry Details</h3>
                @if($submission->service_interest)
                    <p><strong>Service:</strong> {{ $submission->getServiceInterestLabel() }}</p>
                @endif
                @if($submission->budget)
                    <p><strong>Budget:</strong> {{ $submission->getBudgetLabel() }}</p>
                @endif
                <p><strong>Submitted:</strong> {{ $submission->created_at->diffForHumans() }}</p>
            </div>
        </div>
        
        <div class="message-box">
            <h3 style="margin: 0 0 15px 0; color: #C53030;">💬 Message</h3>
            <p style="margin: 0; white-space: pre-wrap;">{{ $submission->message }}</p>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <h3 style="margin: 0 0 10px 0; color: #C53030;">🌐 Technical Info</h3>
                <p><strong>IP Address:</strong> {{ $submission->ip_address }}</p>
                <p><strong>User Agent:</strong> {{ Str::limit($submission->user_agent, 50) }}</p>
            </div>
            
            <div class="info-item">
                <h3 style="margin: 0 0 10px 0; color: #C53030;">📊 Lead Analysis</h3>
                <p><strong>Priority:</strong> {{ $submission->getPriorityLabel() }}</p>
                <p><strong>Score:</strong> {{ $submission->getPriorityScore() }}/100</p>
                <p><strong>Status:</strong> {{ ucfirst($submission->status) }}</p>
            </div>
        </div>
        
        <div class="actions">
            <a href="{{ route('admin.contact.submissions.show', $submission) }}" class="button">
                View in Admin Panel
            </a>
            <a href="mailto:{{ $submission->email }}?subject=Re: Your inquiry to TKDS Media&body=Hi {{ $submission->first_name }},%0D%0A%0D%0AThank you for contacting TKDS Media..." class="button button-secondary">
                Reply via Email
            </a>
            @if($submission->phone)
                <a href="tel:{{ $submission->phone }}" class="button button-secondary">
                    Call {{ $submission->first_name }}
                </a>
            @endif
        </div>
        
        <div style="background: #e0f2fe; padding: 15px; border-radius: 8px; margin-top: 20px;">
            <h4 style="margin: 0 0 10px 0; color: #0277bd;">🎯 Recommended Next Steps:</h4>
            <ul style="margin: 0; padding-left: 20px;">
                @if($submission->getPriorityScore() >= 80)
                    <li><strong>High Priority:</strong> Contact within 1 hour</li>
                    <li>Assign to senior sales representative</li>
                    <li>Prepare custom proposal</li>
                @elseif($submission->getPriorityScore() >= 50)
                    <li><strong>Medium Priority:</strong> Contact within 4 hours</li>
                    <li>Send detailed service information</li>
                    <li>Schedule demo if interested</li>
                @else
                    <li><strong>Standard Follow-up:</strong> Contact within 24 hours</li>
                    <li>Send general company information</li>
                    <li>Add to newsletter if appropriate</li>
                @endif
            </ul>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} TKDS Media Admin System</p>
        <p>This notification was sent to: {{ implode(', ', $settings->getNotificationEmailsArray()) }}</p>
    </div>
</body>
</html>