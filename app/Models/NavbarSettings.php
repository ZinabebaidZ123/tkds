<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavbarSettings extends Model
{
    protected $fillable = [
        'logo',
        'show_countdown',
        'countdown_text',
        'contact_button_text',
        'contact_type',
        'contact_value',
        'custom_links',
        'status'
    ];

    protected $casts = [
        'show_countdown' => 'boolean',
        'custom_links' => 'array'
    ];

    public static function current()
    {
        return static::where('status', 'active')->first() ?? new static();
    }

    public function getContactUrlAttribute(): string
    {
        switch ($this->contact_type) {
            case 'whatsapp':
                return 'https://wa.me/' . str_replace(['+', ' ', '-'], '', $this->contact_value);
            case 'call':
                return 'tel:' . $this->contact_value;
            case 'email':
                return 'mailto:' . $this->contact_value;
            default:
                return '#';
        }
    }

    public function getCustomLinksArray(): array
    {
        return is_array($this->custom_links) ? $this->custom_links : [];
    }
}