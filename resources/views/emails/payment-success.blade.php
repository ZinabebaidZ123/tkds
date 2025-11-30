<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Successful</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background: white; }
        .header { background: linear-gradient(135deg, #10b981, #059669); padding: 40px 20px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 28px; }
        .content { padding: 40px 20px; }
        .success-icon { background: #d1fae5; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .invoice-box { background: #f8f9fa; border-radius: 12px; padding: 25px; margin: 25px 0; }
        .invoice-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .invoice-row:last-child { border-bottom: none; font-weight: bold; font-size: 18px; }
        .button { display: inline-block; background: linear-gradient(135deg, #C53030, #E53E3E); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
        .footer { background: #f8f9fa; padding: 30px 20px; text-align: center; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>✅ Payment Successful!</h1>
            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 18px;">
                Thank you for your payment
            </p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="success-icon">
                <span style="font-size: 36px; color: #10b981;">✓</span>
            </div>

            <h2 style="color: #333; text-align: center; margin-bottom: 20px;">Payment Received</h2>
            
            <p style="color: #555; line-height: 1.6; text-align: center; margin-bottom: 25px;">
                Hi {{ $payment->user->name }}, your payment has been successfully processed. 
                Your subscription continues without interruption.
            </p>

            <!-- Invoice Details -->
            <div class="invoice-box">
                <h3 style="color: #333; margin-top: 0; margin-bottom: 20px;">Payment Details</h3>
                
                <div class="invoice-row">
                    <span>Transaction ID:</span>
                    <span style="font-family: monospace;">{{ $payment->stripe_payment_intent_id }}</span>
                </div>
                
                <div class="invoice-row">
                    <span>Plan:</span>
                    <span>{{ $payment->subscription->pricingPlan->name }}</span>
                </div>
                
                <div class="invoice-row">
                    <span>Billing Period:</span>
                    <span>{{ $payment->subscription->current_period_start->format('M j') }} - {{ $payment->subscription->current_period_end->format('M j, Y') }}</span>
                </div>
                
                <div class="invoice-row">
                    <span>Payment Method:</span>
                    <span>{{ ucfirst($payment->payment_method ?? 'Card') }}</span>
                </div>
                
                <div class="invoice-row">
                    <span>Payment Date:</span>
                    <span>{{ $payment->processed_at->format('F j, Y g:i A') }}</span>
                </div>
                
                <div class="invoice-row">
                    <span style="color: #059669;">Total Amount:</span>
                    <span style="color: #059669;">{{ $payment->getFormattedAmount() }}</span>
                </div>
            </div>

            <!-- Next Payment Info -->
            @if($payment->subscription->next_payment_date)
                <div style="background: #dbeafe; border: 1px solid #bfdbfe; border-radius: 8px; padding: 20px; margin: 25px 0;">
                    <h4 style="color: #1e40af; margin-top: 0;">📅 Next Payment</h4>
                    <p style="color: #1e40af; margin: 5px 0;">
                        Your next payment of <strong>{{ $payment->getFormattedAmount() }}</strong> 
                        will be automatically charged on <strong>{{ $payment->subscription->next_payment_date->format('F j, Y') }}</strong>
                    </p>
                </div>
            @endif

            <!-- Receipt & Support -->
            <div style="text-align: center; margin: 30px 0;">
                @if($payment->receipt_url)
                    <a href="{{ $payment->receipt_url }}" class="button" target="_blank">
                        📄 Download Receipt
                    </a>
                @endif
            </div>

            <p style="color: #555; line-height: 1.6; text-align: center;">
                Questions about your payment? Our support team is here to help.
            </p>

            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ route('user.subscription') }}" style="color: #C53030; text-decoration: none; font-weight: bold;">
                    Manage Your Subscription →
                </a>
            </div>
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
                Keep this receipt for your records.
            </p>
        </div>
    </div>
</body>
</html>