<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class OccasionTestimonial extends Model
{
    protected $fillable = [
        'occasion_id',
        'customer_name',
        'customer_title',
        'customer_image',
        'testimonial_text',
        'rating',
        'is_featured',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function occasion(): BelongsTo
    {
        return $this->belongsTo(Occasion::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Accessors
    public function getCustomerImageUrlAttribute()
    {
        if ($this->customer_image) {
            return Storage::url($this->customer_image);
        }

        // Generate avatar with initials
        $initials = collect(explode(' ', $this->customer_name))
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->take(2)
            ->implode('');

        return "https://ui-avatars.com/api/?name={$initials}&size=128&background=C53030&color=fff&bold=true";
    }

    public function getStarRatingAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '★' : '☆';
        }
        return $stars;
    }

    public function getExcerptAttribute($length = 150)
    {
        return strlen($this->testimonial_text) > $length 
            ? substr($this->testimonial_text, 0, $length) . '...'
            : $this->testimonial_text;
    }
}

