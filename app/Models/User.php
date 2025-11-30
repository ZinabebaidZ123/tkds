<?php
// File: app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'date_of_birth',
        'gender',
        'status',
        'last_login_at',
        'email_verified_at',
        'email_verification_token',
        'password_reset_token',
        'password_reset_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
        'password_reset_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'password_reset_expires_at' => 'datetime',
        ];
    }

    // ===================== BASIC RELATIONSHIPS =====================
    
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function billingInfo()
    {
        return $this->hasMany(UserBillingInfo::class);
    }

    public function shippingInfo()
    {
        return $this->hasMany(UserShippingInfo::class);
    }

    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }

    public function defaultBillingInfo()
    {
        return $this->hasOne(UserBillingInfo::class)->where('is_default', true);
    }

    public function defaultShippingInfo()
    {
        return $this->hasOne(UserShippingInfo::class)->where('is_default', true);
    }

    // ===================== SUBSCRIPTION RELATIONSHIPS =====================
    
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(UserSubscription::class)->whereIn('status', ['active', 'trialing']);
    }

    public function paymentHistory()
    {
        return $this->hasMany(PaymentHistory::class);
    }

    // ===================== SHOP RELATIONSHIPS =====================
    
    /**
     * Shop Orders (One-to-Many)
     */
    public function orders()
    {
        return $this->hasMany(ShopOrder::class);
    }

    /**
     * Shop Cart Items (One-to-Many)
     */
    public function cartItems()
    {
        return $this->hasMany(ShopCart::class);
    }

    /**
     * Shop Reviews (One-to-Many)
     */
    public function shopReviews()
    {
        return $this->hasMany(ShopReview::class);
    }

    /**
     * Shop Downloads (One-to-Many)
     */
    public function downloads()
    {
        return $this->hasMany(ShopDownload::class);
    }

    /**
     * Shop Wishlist (One-to-Many)
     */
    public function wishlist()
    {
        return $this->hasMany(ShopWishlist::class);
    }

    // ===================== SUBSCRIPTION METHODS =====================
    
    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()->whereIn('status', ['active', 'trialing'])->exists();
    }

    public function hasAnySubscription(): bool
    {
        return $this->subscriptions()->exists();
    }

    public function getCurrentSubscription(): ?UserSubscription
    {
        return $this->subscriptions()
                   ->whereIn('status', ['active', 'trialing'])
                   ->with('pricingPlan')
                   ->first();
    }

    public function getLatestSubscription(): ?UserSubscription
    {
        return $this->subscriptions()
                   ->with('pricingPlan')
                   ->orderBy('created_at', 'desc')
                   ->first();
    }

    public function isSubscribedTo(PricingPlan $plan): bool
    {
        return $this->subscriptions()
                   ->where('pricing_plan_id', $plan->id)
                   ->whereIn('status', ['active', 'trialing'])
                   ->exists();
    }

    public function getSubscriptionStatus(): string
    {
        $subscription = $this->getCurrentSubscription();
        
        if (!$subscription) {
            return 'no_subscription';
        }
        
        return $subscription->status;
    }

    public function getSubscriptionStatusBadge(): array
    {
        $subscription = $this->getCurrentSubscription();
        
        if (!$subscription) {
            return [
                'text' => 'No Plan',
                'class' => 'bg-gray-500/20 text-gray-400',
                'icon' => 'fas fa-times-circle'
            ];
        }
        
        return $subscription->getStatusBadge();
    }

    public function isOnTrial(): bool
    {
        return $this->subscriptions()->where('status', 'trialing')->exists();
    }

    public function hasExpiredSubscription(): bool
    {
        return $this->subscriptions()
                   ->where('status', 'canceled')
                   ->orWhere('current_period_end', '<', now())
                   ->exists();
    }

    public function getSubscriptionEndDate(): ?string
    {
        $subscription = $this->getCurrentSubscription();
        
        if (!$subscription || !$subscription->current_period_end) {
            return null;
        }
        
        return $subscription->current_period_end->format('M j, Y');
    }

    public function getTotalSpent(): float
    {
        // First try from payment history
        $paymentTotal = $this->paymentHistory()
                           ->where('status', 'succeeded')
                           ->sum('amount');

        // Also add shop orders total
        $shopTotal = $this->orders()
                         ->where('payment_status', 'paid')
                         ->sum('total_amount');

        return $paymentTotal + $shopTotal;
    }

    public function getLastPayment(): ?PaymentHistory
    {
        return $this->paymentHistory()
                   ->where('status', 'succeeded')
                   ->latest('processed_at')
                   ->first();
    }

    public function hasFailedPayments(): bool
    {
        return $this->paymentHistory()
                   ->where('status', 'failed')
                   ->exists();
    }

    public function getSubscriptionPlan(): ?PricingPlan
    {
        $subscription = $this->getCurrentSubscription();
        
        return $subscription ? $subscription->pricingPlan : null;
    }

    public function getSubscriptionDisplayName(): string
    {
        $subscription = $this->getCurrentSubscription();
        
        if (!$subscription) {
            return 'No Active Plan';
        }
        
        return $subscription->pricingPlan->name . ' (' . ucfirst($subscription->billing_cycle) . ')';
    }

    public function canUpgradeSubscription(): bool
    {
        $currentSubscription = $this->getCurrentSubscription();
        
        if (!$currentSubscription) {
            return true; // Can subscribe to any plan
        }
        
        // Check if there are higher tier plans available
        return PricingPlan::where('status', 'active')
                         ->where('show_in_pricing', true)
                         ->where('id', '!=', $currentSubscription->pricing_plan_id)
                         ->exists();
    }

    public function getTrialDaysRemaining(): int
    {
        $subscription = $this->subscriptions()->where('status', 'trialing')->first();
        
        if (!$subscription || !$subscription->trial_end) {
            return 0;
        }
        
        return max(0, now()->diffInDays($subscription->trial_end, false));
    }

    // ===================== SHOP HELPER METHODS =====================
    
    public function getOrdersCount(): int
    {
        return $this->orders()->count();
    }

    public function getReviewsCount(): int
    {
        return $this->shopReviews()->count();
    }

    public function hasOrdered(ShopProduct $product): bool
    {
        return $this->orders()
            ->where('payment_status', 'paid')
            ->whereHas('items', function($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();
    }

    public function hasReviewed(ShopProduct $product): bool
    {
        return $this->shopReviews()
            ->where('product_id', $product->id)
            ->exists();
    }

    public function canReview(ShopProduct $product): bool
    {
        return $this->hasOrdered($product) && !$this->hasReviewed($product);
    }

    public function getCartItemsCount(): int
    {
        return $this->cartItems()->sum('quantity');
    }

    public function getCartTotal(): float
    {
        return $this->cartItems()->with('product')->get()->sum(function($item) {
            return $item->product ? $item->product->getPrice() * $item->quantity : 0;
        });
    }

    // ===================== SCOPES =====================
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }

    public function scopeWithActiveSubscription($query)
    {
        return $query->whereHas('subscriptions', function($q) {
            $q->whereIn('status', ['active', 'trialing']);
        });
    }

    public function scopeWithoutSubscription($query)
    {
        return $query->whereDoesntHave('subscriptions');
    }

    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    // ===================== HELPER METHODS =====================
    
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function getAvatarUrl(): string
    {
        if ($this->avatar && filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }
        
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=fff&background=C53030&size=200';
    }

    public function getInitials(): string
    {
        $nameParts = explode(' ', $this->name);
        $initials = '';
        
        foreach (array_slice($nameParts, 0, 2) as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }
        
        return $initials ?: 'U';
    }

    public function getStatusBadge(): array
    {
        return match($this->status) {
            'active' => [
                'text' => 'Active',
                'class' => 'bg-green-100 text-green-800',
                'icon' => 'fas fa-check-circle'
            ],
            'inactive' => [
                'text' => 'Inactive',
                'class' => 'bg-red-100 text-red-800',
                'icon' => 'fas fa-times-circle'
            ],
            'suspended' => [
                'text' => 'Suspended',
                'class' => 'bg-yellow-100 text-yellow-800',
                'icon' => 'fas fa-pause-circle'
            ],
            default => [
                'text' => 'Unknown',
                'class' => 'bg-gray-100 text-gray-800',
                'icon' => 'fas fa-question-circle'
            ]
        };
    }

    public function getFormattedNameAttribute()
    {
        return $this->name ?? 'Unknown User';
    }

    public function getLastLoginFormatted(): string
    {
        if (!$this->last_login_at) {
            return 'Never';
        }

        return $this->last_login_at->diffForHumans();
    }

    public function getJoinedDateFormatted(): string
    {
        return $this->created_at->format('M j, Y');
    }

    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    public function getFullProfileData(): array
    {
        return [
            'user' => $this->toArray(),
            'profile' => $this->profile?->toArray(),
            'billing' => $this->billingInfo()->get()->toArray(),
            'shipping' => $this->shippingInfo()->get()->toArray(),
        ];
    }

    // ===================== ADMIN METHODS =====================
    
    public function markAsVerified(): void
    {
        $this->update([
            'email_verified_at' => now(),
            'email_verification_token' => null
        ]);
    }

    public function activate(): void
    {
        $this->update(['status' => 'active']);
    }

    public function deactivate(): void
    {
        $this->update(['status' => 'inactive']);
    }

    public function suspend(): void
    {
        $this->update(['status' => 'suspended']);
    }

    public function cancelSubscription(string $reason = null): void
    {
        $subscription = $this->getCurrentSubscription();
        if ($subscription) {
            $subscription->cancel($reason);
        }
    }

    // Auto-create profile when user is created
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create([]);
        });
    }
}