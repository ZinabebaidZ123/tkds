<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Failed - Action Required</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background: white; }
        .header { background: linear-gradient(135deg, #dc2626, #b91c1c); padding: 40px 20px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 28px; }
        .content { padding: 40px 20px; }
        .alert-icon { background: #fee2e2; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .payment-details { background: #f8f9fa; border-radius: 12px; padding: 25px; margin: 25px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .detail-row:last-child { border-bottom: none; }
        .button { display: inline-block; background: linear-gradient(135deg, #C53030, #E53E3E); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
        .urgent-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 20px; margin: 25px 0; }
        .footer { background: #f8f9fa; padding: 30px 20px; text-align: center; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>⚠️ Payment Failed</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 18px;">
                Action required to continue your subscription
            </p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="alert-icon">
                <span style="font-size: 36px; color: #dc2626;">!</span>
            </div>

            <h2 style="color: #333; text-align: center; margin-bottom: 20px;">Payment Could Not Be Processed</h2>
            
            <p style="color: #555; line-height: 1.6; text-align: center; margin-bottom: 25px;">
                Hi {{ $payment->user->name }}, we encountered an issue processing your payment for 
                <strong>{{ $payment->subscription->pricingPlan->name }}</strong>. 
                Your subscription is temporarily on hold.
            </p>

            <!-- Urgent Action Required -->
            <div class="urgent-box">
                <h3 style="color: #dc2626; margin-top: 0;">🚨 Immediate Action Required</h3>
                <p style="color: #7f1d1d; margin: 10px 0;">
                    To avoid service interruption, please update your payment method or try a different card.
                    You have <strong>3 days</strong> to resolve this issue before your access is suspended.
                </p>
            </div>

            <!-- Payment Details -->
            <div class="payment-details">
                <h3 style="color: #333; margin-top: 0; margin-bottom: 20px;">Failed Payment Details</h3>
                
                <div class="detail-row">
                    <span>Plan:</span>
                    <span>{{ $payment->subscription->pricingPlan->name }}</span>
                </div>
                
                <div class="detail-row">
                    <span>Amount:</span>
                    <span>{{ $payment->getFormattedAmount() }}</span>
                </div>
                
                <div class="detail-row">
                    <span>Billing Cycle:</span>
                    <span>{{ ucfirst($payment->subscription->billing_cycle) }}</span>
                </div>
                
                <div class="detail-row">
                    <span>Failed Date:</span>
                    <span>{{ $payment->processed_at?->format('F j, Y g:i A') ?? now()->format('F j, Y g:i A') }}</span>
                </div>
                
                @if($payment->failure_reason)
                    <div class="detail-row">
                        <span>Reason:</span>
                        <span style="color: #dc2626;">{{ $payment->failure_reason }}</span>
                    </div>
                @endif
            </div>

            <!-- Common Solutions -->
            <h3 style="color: #333; margin-top: 30px;">💡 Common Solutions</h3>
            <ul style="color: #555; line-height: 1.8; padding-left: 20px;">
                <li><strong>Insufficient Funds:</strong> Ensure your account has enough balance</li>
                <li><strong>Expired Card:</strong> Update your payment method with a valid card</li>
                <li><strong>Incorrect Information:</strong> Verify your billing address and card details</li>
                <li><strong>Bank Restrictions:</strong> Contact your bank to authorize the transaction</li>
                <li><strong>Try Different Card:</strong> Use an alternative payment method</li>
            </ul>

            <!-- Action Buttons -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('user.subscription') }}" class="button">
                    🔧 Update Payment Method
                </a>
                <br>
                <a href="{{ route('user.subscription') }}" style="color: #C53030; text-decoration: none; font-weight: bold; margin-top: 15px; display: inline-block;">
                    Try Payment Again →
                </a>
            </div>

            <!-- Support -->
            <div style="background: #dbeafe; border: 1px solid #bfdbfe; border-radius: 8px; padding: 20px; margin: 25px 0; text-align: center;">
                <h4 style="color: #1e40af; margin-top: 0;">Need Help?</h4>
                <p style="color: #1e40af; margin: 10px 0;">
                    Our support team is here to help you resolve this payment issue quickly.
                </p>
                <a href="{{ route('contact') }}" style="color: #1e40af; font-weight: bold; text-decoration: none;">
                    📞 Contact Support
                </a>
            </div>

            <p style="color: #555; line-height: 1.6; text-align: center; margin-top: 25px;">
                We apologize for any inconvenience. Please resolve this issue as soon as possible 
                to continue enjoying your TKDS Media subscription.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>TKDS Media</strong> - Your World, Live and Direct</p>
            <p>
                <a href="{{ route('user.subscription') }}" style="color: #C53030;">Manage Subscription</a> | 
                <a href="{{ route('contact') }}" style="color: #C53030;">Contact Support</a> | 
                <a href="{{ route('user.dashboard') }}" style="color: #C53030;">Dashboard</a>
            </p>
            <p style="margin-top: 20px;">
                This email was sent to {{ $payment->user->email }}.<br>
                Please take action within 3 days to avoid service interruption.
            </p>
        </div>
    </div>
</body>
</html>