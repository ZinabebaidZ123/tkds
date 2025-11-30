<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscription Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background: white; }
        .header { background: linear-gradient(135deg, #6b7280, #4b5563); padding: 40px 20px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 28px; }
        .content { padding: 40px 20px; }
        .cancel-icon { background: #f3f4f6; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .details-box { background: #f8f9fa; border-radius: 12px; padding: 25px; margin: 25px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .detail-row:last-child { border-bottom: none; }
        .button { display: inline-block; background: linear-gradient(135deg, #C53030, #E53E3E); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
        .feedback-box { background: #fef3cd; border: 1px solid #faebcc; border-radius: 8px; padding: 20px; margin: 25px 0; }
        .footer { background: #f8f9fa; padding: 30px 20px; text-align: center; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Subscription Cancelled</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 18px;">
                We're sorry to see you go
            </p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="cancel-icon">
                <span style="font-size: 36px; color: #6b7280;">📋</span>
            </div>

            <h2 style="color: #333; text-align: center; margin-bottom: 20px;">Your Subscription Has Been Cancelled</h2>
            
            <p style="color: #555; line-height: 1.6; text-align: center; margin-bottom: 25px;">
                Hi {{ $subscription->user->name }}, your <strong>{{ $subscription->pricingPlan->name }}</strong> 
                subscription has been successfully cancelled as requested.
            </p>

            <!-- Cancellation Details -->
            <div class="details-box">
                <h3 style="color: #333; margin-top: 0; margin-bottom: 20px;">Cancellation Details</h3>
                
                <div class="detail-row">
                    <span>Plan:</span>
                    <span>{{ $subscription->pricingPlan->name }}</span>
                </div>
                
                <div class="detail-row">
                    <span>Cancelled Date:</span>
                    <span>{{ $subscription->canceled_at->format('F j, Y g:i A') }}</span>
                </div>
                
                <div class="detail-row">
                    <span>Last Billing Amount:</span>
                    <span>{{ $subscription->getFormattedAmount() }}</span>
                </div>
                
                @if($subscription->current_period_end && $subscription->current_period_end->isFuture())
                    <div class="detail-row">
                        <span style="color: #059669;">Access Until:</span>
                        <span style="color: #059669; font-weight: bold;">{{ $subscription->current_period_end->format('F j, Y') }}</span>
                    </div>
                @endif
            </div>

            <!-- Access Information -->
            @if($subscription->current_period_end && $subscription->current_period_end->isFuture())
                <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 20px; margin: 25px 0;">
                    <h4 style="color: #065f46; margin-top: 0;">✅ You Still Have Access</h4>
                    <p style="color: #065f46; margin: 10px 0;">
                        Good news! You can continue using all features until <strong>{{ $subscription->current_period_end->format('F j, Y') }}</strong>. 
                        After this date, your access will end and no further charges will be made.
                    </p>
                </div>
            @else
                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 20px; margin: 25px 0;">
                    <h4 style="color: #7f1d1d; margin-top: 0;">🔒 Access Ended</h4>
                    <p style="color: #7f1d1d; margin: 10px 0;">
                        Your subscription access has ended. You can reactivate anytime to regain full access to all features.
                    </p>
                </div>
            @endif

            <!-- What You'll Miss -->
            @if($subscription->pricingPlan->getFeatures())
                <h3 style="color: #333; margin-top: 30px;">What You'll Be Missing</h3>
                <ul style="color: #555; line-height: 1.8; padding-left: 20px;">
                    @foreach(array_slice($subscription->pricingPlan->getFeatures(), 0, 4) as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            @endif

            <!-- Feedback Request -->
            <div class="feedback-box">
                <h4 style="color: #92400e; margin-top: 0;">📝 Help Us Improve</h4>
                <p style="color: #92400e; margin: 10px 0;">
                    We'd love to know why you cancelled. Your feedback helps us improve TKDS Media for everyone.
                </p>
                <a href="{{ route('contact') }}?subject=Cancellation Feedback" style="color: #92400e; font-weight: bold; text-decoration: none;">
                    Share Your Feedback →
                </a>
            </div>

            <!-- Reactivation -->
            <div style="text-align: center; margin: 30px 0;">
                <h3 style="color: #333;">Changed Your Mind?</h3>
                <p style="color: #555; margin-bottom: 20px;">
                    You can reactivate your subscription anytime with just a few clicks.
                </p>
                <a href="{{ route('pricing') }}" class="button">
                    🔄 Reactivate Subscription
                </a>
            </div>

            <!-- Account Information -->
            <div style="background: #dbeafe; border: 1px solid #bfdbfe; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h4 style="color: #1e40af; margin-top: 0;">👤 Your Account</h4>
                <p style="color: #1e40af; margin: 10px 0;">
                    Your TKDS Media account remains active. You can still:
                </p>
                <ul style="color: #1e40af; margin: 10px 0; padding-left: 20px;">
                    <li>Log in to your dashboard</li>
                    <li>View your subscription history</li>
                    <li>Reactivate your subscription</li>
                    <li>Access our free resources</li>
                </ul>
            </div>

            <p style="color: #555; line-height: 1.6; text-align: center; margin-top: 25px;">
                Thank you for being part of the TKDS Media community. We hope to serve you again in the future!
            </p>

            <p style="color: #555; text-align: center; margin-top: 20px;">
                The TKDS Media Team
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>TKDS Media</strong> - Your World, Live and Direct</p>
            <p>
                <a href="{{ route('pricing') }}" style="color: #C53030;">View Plans</a> | 
                <a href="{{ route('contact') }}" style="color: #C53030;">Contact Support</a> | 
                <a href="{{ route('user.dashboard') }}" style="color: #C53030;">Dashboard</a>
            </p>
            <p style="margin-top: 20px;">
                This email was sent to {{ $subscription->user->email }}.<br>
                You can reactivate your subscription anytime.
            </p>
        </div>
    </div>
</body>
</html>