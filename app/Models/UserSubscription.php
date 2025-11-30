<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pricing_plan_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'stripe_price_id',
        'billing_cycle',
        'status',
        'current_period_start',
        'current_period_end',
        'trial_end',
        'canceled_at',
        'cancel_at_period_end',
        'amount',
        'currency',
        'payment_method',
        'next_payment_date'
    ];

    protected $casts = [
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'trial_end' => 'datetime',
        'canceled_at' => 'datetime',
        'next_payment_date' => 'datetime',
        'amount' => 'decimal:2',
        'cancel_at_period_end' => 'boolean'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pricingPlan()
    {
        return $this->belongsTo(PricingPlan::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentHistory::class, 'subscription_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'trialing']);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }

    public function scopeTrialing($query)
    {
        return $query->where('status', 'trialing');
    }

    public function scopePastDue($query)
    {
        return $query->where('status', 'past_due');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeExpiring($query, $days = 7)
    {
        return $query->where('current_period_end', '<=', now()->addDays($days))
                    ->whereIn('status', ['active', 'trialing']);
    }

    // ✅ NEW: Scope for truly expired subscriptions only
    public function scopeTrulyExpired($query)
    {
        return $query->where('current_period_end', '<=', now())
                    ->whereIn('status', ['active', 'trialing'])
                    ->where('current_period_end', '!=', null);
    }

    // Methods
    public function isActive(): bool
    {
        return in_array($this->status, ['active', 'trialing']);
    }

    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    public function isTrialing(): bool
    {
        return $this->status === 'trialing';
    }

    public function isPastDue(): bool
    {
        return $this->status === 'past_due';
    }

    // ✅ FIXED: More accurate expiry check
    public function isExpired(): bool
    {
        if (!$this->current_period_end) {
            return false; // No end date = not expired
        }

        return $this->current_period_end->isPast();
    }

    public function isExpiringSoon(int $days = 7): bool
    {
        return $this->current_period_end && 
               $this->current_period_end->isBefore(now()->addDays($days));
    }

    // ✅ FIXED: Better remaining days calculation
    public function getRemainingDays(): int
    {
        if (!$this->current_period_end) {
            // No end date means unlimited or not properly set
            return 999; // Return large number instead of 0
        }

        if ($this->current_period_end->isPast()) {
            return 0; // Actually expired
        }

        return max(0, now()->diffInDays($this->current_period_end, false));
    }

    // ✅ NEW: Check if subscription should be auto-removed
    public function shouldAutoRemove(): bool
    {
        // Only remove if ALL conditions are met:
        // 1. Has a valid period end date
        // 2. Period end is actually in the past
        // 3. Status is still active/trialing (not already handled)
        // 4. Actually expired (not just 0 remaining due to null date)
        
        if (!$this->current_period_end) {
            return false; // No end date = don't remove
        }

        if (!$this->current_period_end->isPast()) {
            return false; // Not actually expired yet
        }

        if (!in_array($this->status, ['active', 'trialing'])) {
            return false; // Already handled or inactive
        }

        // Additional safety: Only remove if expired for more than 1 day
        return $this->current_period_end->diffInDays(now()) > 1;
    }

    public function getStatusBadge(): array
    {
        return match ($this->status) {
            'active' => [
                'text' => 'Active',
                'class' => 'bg-green-100 text-green-800',
                'icon' => 'fas fa-check-circle'
            ],
            'trialing' => [
                'text' => 'Trial',
                'class' => 'bg-blue-100 text-blue-800',
                'icon' => 'fas fa-gift'
            ],
            'past_due' => [
                'text' => 'Past Due',
                'class' => 'bg-yellow-100 text-yellow-800',
                'icon' => 'fas fa-exclamation-triangle'
            ],
            'canceled' => [
                'text' => 'Canceled',
                'class' => 'bg-red-100 text-red-800',
                'icon' => 'fas fa-times-circle'
            ],
            'expired' => [
                'text' => 'Expired',
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-clock'
            ],
            'inactive' => [
                'text' => 'Inactive',
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-pause-circle'
            ],
            'incomplete' => [
                'text' => 'Incomplete',
                'class' => 'bg-orange-100 text-orange-800',
                'icon' => 'fas fa-hourglass-half'
            ],
            default => [
                'text' => ucfirst($this->status),
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-question-circle'
            ]
        };
    }

    public function getFormattedAmount(): string
    {
        $symbol = match ($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $this->currency . ' '
        };

        return $symbol . number_format($this->amount, 2);
    }

    public function getBillingCycleLabel(): string
    {
        return ucfirst($this->billing_cycle);
    }

    public function getNextPaymentAmount(): string
    {
        return $this->getFormattedAmount() . ' / ' . $this->billing_cycle;
    }

    // ✅ FIXED: Better renewal calculation
    public function getDaysUntilRenewal(): int
    {
        // For trialing subscriptions, use trial_end
        if ($this->isTrialing() && $this->trial_end) {
            return max(0, now()->diffInDays($this->trial_end, false));
        }

        // For active subscriptions, use next_payment_date or current_period_end
        $renewalDate = $this->next_payment_date ?? $this->current_period_end;
        
        if (!$renewalDate) {
            return 999; // No renewal date set
        }

        return max(0, now()->diffInDays($renewalDate, false));
    }

    public function canCancel(): bool
    {
        return in_array($this->status, ['active', 'trialing']) && !$this->cancel_at_period_end;
    }

    public function canResume(): bool
    {
        return $this->status === 'canceled' && !$this->isExpired();
    }

    public function canUpgrade(): bool
    {
        return in_array($this->status, ['active', 'trialing']);
    }

    // ✅ FIXED: getTrialDaysRemaining method
    public function getTrialDaysRemaining(): int
    {
        if (!$this->trial_end || !$this->isTrialing()) {
            return 0;
        }

        return max(0, now()->diffInDays($this->trial_end, false));
    }

    public function isTrialExpiring(int $days = 3): bool
    {
        return $this->isTrialing() && $this->getTrialDaysRemaining() <= $days;
    }

    public function getTotalPaid(): float
    {
        return $this->payments()
                   ->where('status', 'succeeded')
                   ->sum('amount');
    }

    public function getLastPayment(): ?PaymentHistory
    {
        return $this->payments()
                   ->where('status', 'succeeded')
                   ->orderBy('processed_at', 'desc')
                   ->first();
    }

    public function getFailedPaymentsCount(): int
    {
        return $this->payments()
                   ->where('status', 'failed')
                   ->count();
    }

    public function hasFailedPayments(): bool
    {
        return $this->getFailedPaymentsCount() > 0;
    }

    // ✅ NEW: Get status display with more details
    public function getDetailedStatus(): string
    {
        if ($this->cancel_at_period_end && $this->status === 'active') {
            return "Canceling on {$this->current_period_end->format('M d, Y')}";
        }

        if ($this->status === 'canceled' && $this->canceled_at) {
            return "Canceled on {$this->canceled_at->format('M d, Y')}";
        }

        if ($this->status === 'expired') {
            return "Expired on {$this->current_period_end->format('M d, Y')}";
        }

        if ($this->isTrialing()) {
            return "Trial ends in {$this->getTrialDaysRemaining()} days";
        }

        if ($this->status === 'active' && $this->current_period_end) {
            return "Renews on {$this->current_period_end->format('M d, Y')}";
        }

        return ucfirst($this->status);
    }

    // ✅ NEW: Check if subscription has valid period dates
    public function hasValidPeriodDates(): bool
    {
        return $this->current_period_start && $this->current_period_end;
    }

    // ✅ NEW: Fix subscription dates if they're missing
    public function fixMissingDates(): bool
    {
        if ($this->hasValidPeriodDates()) {
            return true; // Already has valid dates
        }

        try {
            $currentPeriodStart = $this->current_period_start ?? $this->created_at;
            $currentPeriodEnd = null;

            if ($this->isTrialing() && $this->pricingPlan->trial_days > 0) {
                $currentPeriodEnd = $currentPeriodStart->addDays($this->pricingPlan->trial_days);
                $this->trial_end = $currentPeriodEnd;
            } else {
                $currentPeriodEnd = $this->billing_cycle === 'yearly' 
                    ? $currentPeriodStart->addYear()
                    : $currentPeriodStart->addMonth();
            }

            $this->update([
                'current_period_start' => $currentPeriodStart,
                'current_period_end' => $currentPeriodEnd,
                'next_payment_date' => $currentPeriodEnd,
            ]);

            \Log::info('Fixed missing subscription dates', [
                'subscription_id' => $this->id,
                'period_start' => $currentPeriodStart->format('Y-m-d H:i:s'),
                'period_end' => $currentPeriodEnd->format('Y-m-d H:i:s')
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to fix subscription dates', [
                'subscription_id' => $this->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    // Static methods
    public static function findByStripeId(string $stripeSubscriptionId): ?self
    {
        return self::where('stripe_subscription_id', $stripeSubscriptionId)->first();
    }

    public static function getActiveCount(): int
    {
        return self::active()->count();
    }

    public static function getExpiringSoonCount(int $days = 7): int
    {
        return self::expiring($days)->count();
    }

    public static function getRevenueThisMonth(): float
    {
        return PaymentHistory::where('status', 'succeeded')
                           ->whereBetween('processed_at', [
                               now()->startOfMonth(),
                               now()->endOfMonth()
                           ])
                           ->sum('amount');
    }

    public static function getRevenueThisYear(): float
    {
        return PaymentHistory::where('status', 'succeeded')
                           ->whereBetween('processed_at', [
                               now()->startOfYear(),
                               now()->endOfYear()
                           ])
                           ->sum('amount');
    }

    // ✅ NEW: Auto-fix subscriptions with missing dates
    public static function fixSubscriptionsWithMissingDates(): int
    {
        $fixedCount = 0;
        
        $subscriptions = self::active()
            ->where(function($query) {
                $query->whereNull('current_period_end')
                      ->orWhereNull('current_period_start');
            })
            ->get();
        
        foreach ($subscriptions as $subscription) {
            if ($subscription->fixMissingDates()) {
                $fixedCount++;
            }
        }

        if ($fixedCount > 0) {
            \Log::info("Fixed {$fixedCount} subscriptions with missing dates");
        }

        return $fixedCount;
    }

    // ✅ NEW: Auto-remove only truly expired subscriptions
    public static function autoRemoveExpiredSubscriptions(): int
    {
        $removedCount = 0;
        
        $subscriptions = self::trulyExpired()->get();
        
        foreach ($subscriptions as $subscription) {
            try {
                if ($subscription->shouldAutoRemove()) {
                    \Log::info('Auto-removing truly expired subscription', [
                        'subscription_id' => $subscription->id,
                        'user_id' => $subscription->user_id,
                        'plan_name' => $subscription->pricingPlan->name,
                        'current_period_end' => $subscription->current_period_end->format('Y-m-d H:i:s'),
                        'days_past_expiry' => $subscription->current_period_end->diffInDays(now())
                    ]);

                    // Store data before deletion for logging
                    $subscriptionData = [
                        'id' => $subscription->id,
                        'user_id' => $subscription->user_id,
                        'plan_name' => $subscription->pricingPlan->name
                    ];

                    // Delete the subscription completely
                    $subscription->delete();

                    \Log::info('Expired subscription removed from database', $subscriptionData);
                    $removedCount++;
                }
            } catch (\Exception $e) {
                \Log::error('Failed to auto-remove expired subscription', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $removedCount;
    }

    // ✅ Boot method to auto-fix dates on creation
    protected static function boot()
    {
        parent::boot();

        // Auto-fix missing dates when subscription is created
        static::created(function ($subscription) {
            if (!$subscription->hasValidPeriodDates()) {
                $subscription->fixMissingDates();
            }
        });

        // Auto-fix missing dates when subscription is updated
        static::updating(function ($subscription) {
            if (!$subscription->hasValidPeriodDates() && in_array($subscription->status, ['active', 'trialing'])) {
                $subscription->fixMissingDates();
            }
        });
    }
}