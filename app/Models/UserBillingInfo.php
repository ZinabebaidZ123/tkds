<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBillingInfo extends Model
{
    use HasFactory;

    protected $table = 'user_billing_info';

    protected $fillable = [
        'user_id',
        'billing_name',
        'billing_email',
        'billing_phone',
        'company_name',
        'tax_id',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Methods
    public function getFullAddress(): string
    {
        $address = $this->address_line_1;
        
        if ($this->address_line_2) {
            $address .= ', ' . $this->address_line_2;
        }
        
        $address .= ', ' . $this->city;
        
        if ($this->state) {
            $address .= ', ' . $this->state;
        }
        
        $address .= ' ' . $this->postal_code . ', ' . $this->country;
        
        return $address;
    }

    public function makeDefault(): void
    {
        // Remove default from other billing info
        self::where('user_id', $this->user_id)->update(['is_default' => false]);
        
        // Set this as default
        $this->update(['is_default' => true]);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}

