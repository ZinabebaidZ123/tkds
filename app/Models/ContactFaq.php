<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactFaq extends Model
{
    use HasFactory;

    protected $table = 'contact_faqs';

    protected $fillable = [
        'question',
        'answer',
        'category',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getCategoryLabel(): string
    {
        $categories = [
            'general' => 'General',
            'technical' => 'Technical',
            'billing' => 'Billing',
            'support' => 'Support'
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }
}