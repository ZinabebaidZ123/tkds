<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopCart extends Model
{
    use HasFactory;

    protected $table = 'shop_cart';

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id');
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeForUserOrSession($query, $userId = null, $sessionId = null)
    {
        return $query->where(function($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            }
            if ($sessionId) {
                $q->orWhere('session_id', $sessionId);
            }
        });
    }

    // Methods
    public function getSubtotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }

    public function getFormattedSubtotal(): string
    {
        $currency = $this->product->currency ?? 'USD';
        $symbol = match($currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $currency . ' '
        };

        return $symbol . number_format($this->getSubtotal(), 2);
    }

    public function canAddQuantity(int $additionalQuantity = 1): bool
    {
        if ($this->product->isSoftware()) {
            return true; // Software can always be purchased
        }

        if (!$this->product->manage_stock) {
            return $this->product->isInStock();
        }

        return $this->product->stock_quantity >= ($this->quantity + $additionalQuantity);
    }

    public function increaseQuantity(int $amount = 1): bool
    {
        if (!$this->canAddQuantity($amount)) {
            return false;
        }

        $this->increment('quantity', $amount);
        return true;
    }

    public function decreaseQuantity(int $amount = 1): bool
    {
        if ($this->quantity <= $amount) {
            $this->delete();
            return true;
        }

        $this->decrement('quantity', $amount);
        return true;
    }

    public function updateQuantity(int $newQuantity): bool
    {
        if ($newQuantity <= 0) {
            $this->delete();
            return true;
        }

        if ($this->product->isSoftware()) {
            $this->update(['quantity' => $newQuantity]);
            return true;
        }

        if (!$this->product->manage_stock) {
            if ($this->product->isInStock()) {
                $this->update(['quantity' => $newQuantity]);
                return true;
            }
            return false;
        }

        if ($this->product->stock_quantity >= $newQuantity) {
            $this->update(['quantity' => $newQuantity]);
            return true;
        }

        return false;
    }

    // Static Methods
    public static function getCartItems($userId = null, $sessionId = null)
    {
        return self::with(['product.category'])
                  ->forUserOrSession($userId, $sessionId)
                  ->get();
    }

    public static function getCartTotal($userId = null, $sessionId = null): float
    {
        return self::getCartItems($userId, $sessionId)
                  ->sum(function($item) {
                      return $item->getSubtotal();
                  });
    }

    public static function getCartCount($userId = null, $sessionId = null): int
    {
        return self::forUserOrSession($userId, $sessionId)->sum('quantity');
    }

    public static function addToCart($productId, $quantity = 1, $userId = null, $sessionId = null): bool
    {
        $product = ShopProduct::find($productId);
        
        if (!$product || !$product->canPurchase()) {
            return false;
        }

        $existingItem = self::forUserOrSession($userId, $sessionId)
                           ->where('product_id', $productId)
                           ->first();

        if ($existingItem) {
            return $existingItem->increaseQuantity($quantity);
        }

        // Check stock for new item
        if (!$product->isSoftware() && $product->manage_stock && $product->stock_quantity < $quantity) {
            return false;
        }

        self::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'product_id' => $productId,
            'quantity' => $quantity
        ]);

        return true;
    }

    public static function removeFromCart($productId, $userId = null, $sessionId = null): bool
    {
        return self::forUserOrSession($userId, $sessionId)
                  ->where('product_id', $productId)
                  ->delete() > 0;
    }

    public static function clearCart($userId = null, $sessionId = null): bool
    {
        return self::forUserOrSession($userId, $sessionId)->delete() > 0;
    }

    public static function mergeCartOnLogin($userId, $sessionId): void
    {
        $sessionItems = self::where('session_id', $sessionId)->get();
        
        foreach ($sessionItems as $sessionItem) {
            $existingUserItem = self::where('user_id', $userId)
                                   ->where('product_id', $sessionItem->product_id)
                                   ->first();

            if ($existingUserItem) {
                $existingUserItem->increaseQuantity($sessionItem->quantity);
            } else {
                $sessionItem->update([
                    'user_id' => $userId,
                    'session_id' => null
                ]);
            }
        }

        // Clean up any remaining session items
        self::where('session_id', $sessionId)->delete();
    }
}