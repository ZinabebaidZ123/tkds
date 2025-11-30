<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to {{ $subscription->pricingPlan->name }}!</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background: white; }
        .header { background: linear-gradient(135deg, #C53030, #E53E3E); padding: 40px 20px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 28px; }
        .content { padding: 40px 20px; }
        .plan-card { background: #f8f9fa; border-radius: 12px; padding: 30px; margin: 20px 0; text-align: center; }
        .plan-name { font-size: 24px; font-weight: bold; color: #333; margin-bottom: 10px; }
        .plan-price { font-size: 32px; font-weight: bold; color: #C53030; margin: 15px 0; }
        .features { list-style: none; padding: 0; margin: 20px 0; }
        .features li { padding: 8px 0; color: #555; }
        .features li:before { content: "✓"; color: #10b981; font-weight: bold; margin-right: 10px; }
        .button { display: inline-block; background: linear-gradient(135deg, #C53030, #E53E3E); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
        .footer { background: #f8f9fa; padding: 30px 20px; text-align: center; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 Welcome to TKDS Media!</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 18px;">
                Your subscription is now active
            </p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2 style="color: #333; margin-bottom: 20px;">Hi {{ $subscription->user->name }},</h2>
            
            <p style="color: #555; line-height: 1.6; margin-bottom: 25px;">
                Thank you for subscribing to <strong>{{ $subscription->pricingPlan->name }}</strong>! 
                We're excited to have you as part of the TKDS Media family and can't wait to help you 
                transform your broadcasting experience.
            </p>

            <!-- Plan Details -->
            <div class="plan-card">
                <div class="plan-name">{{ $subscription->pricingPlan->name }}</div>
                <div style="color: #666; margin-bottom: 15px;">{{ $subscription->pricingPlan->short_description }}</div>
                <div class="plan-price">
                    {{ $subscription->getFormattedAmount() }}
                    <span style="font-size: 16px; color: #666;">/ {{ $subscription->billing_cycle }}</span>
                </div>
                
                @if($subscription->pricingPlan->getFeatures())
                    <ul class="features">
                        @foreach(array_slice($subscription->pricingPlan->getFeatures(), 0, 5) as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @endif

                @if($subscription->trial_end && $subscription->isTrialing())
                    <div style="background: #fef3cd; border: 1px solid #faebcc; border-radius: 8px; padding: 15px; margin-top: 20px;">
                        <strong>🎁 Trial Period Active</strong><br>
                        <span style="color: #856404;">Your trial ends on {{ $subscription->trial_end->format('F j, Y') }}</span>
                    </div>
                @endif
            </div>

            <!-- Next Steps -->
            <h3 style="color: #333; margin-top: 30px;">What's Next?</h3>
            <ul style="color: #555; line-height: 1.8;">
                <li><strong>Access Your Dashboard:</strong> Log in to your account to start using your new features</li>
                <li><strong>Set Up Your Profile:</strong> Complete your profile to get the most out of our platform</li>
                <li><strong>Explore Features:</strong> Check out all the amazing tools now available to you</li>
                <li><strong>Get Support:</strong> Our team is here to help you succeed</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('user.dashboard') }}" class="button">
                    Access Your Dashboard
                </a>
            </div>

            <!-- Billing Info -->
            <div style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h4 style="color: #333; margin-top: 0;">Billing Information</h4>
                <p style="color: #666; margin: 5px 0;"><strong>Plan:</strong> {{ $subscription->pricingPlan->name }}</p>
                <p style="color: #666; margin: 5px 0;"><strong>Billing Cycle:</strong> {{ ucfirst($subscription->billing_cycle) }}</p>
                <p style="color: #666; margin: 5px 0;"><strong>Amount:</strong> {{ $subscription->getFormattedAmount() }}</p>
                @if($subscription->next_payment_date)
                    <p style="color: #666; margin: 5px 0;"><strong>Next Payment:</strong> {{ $subscription->next_payment_date->format('F j, Y') }}</p>
                @endif
            </div>

            <p style="color: #555; line-height: 1.6;">
                If you have any questions or need assistance, don't hesitate to reach out to our support team. 
                We're here to ensure you have the best possible experience with TKDS Media.
            </p>

            <p style="color: #555; margin-top: 25px;">
                Welcome aboard!<br>
                <strong>The TKDS Media Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>TKDS Media</strong> - Your World, Live and Direct</p>
            <p>
                <a href="{{ route('user.subscription') }}" style="color: #C53030;">Manage Subscription</a> | 
                <a href="{{ route('contact') }}" style="color: #C53030;">Contact Support</a> | 
                <a href="{{ route('pricing') }}" style="color: #C53030;">View Plans</a>
            </p>
            <p style="margin-top: 20px;">
                This email was sent to {{ $subscription->user->email }}.<br>
                You're receiving this because you subscribed to {{ $subscription->pricingPlan->name }}.
            </p>
        </div>
    </div>
</body>
</html>