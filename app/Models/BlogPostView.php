<?php 


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostView extends Model
{
    use HasFactory;

    protected $table = 'blog_post_views';

    protected $fillable = [
        'post_id',
        'ip_address',
        'user_agent',
        'referrer',
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public $timestamps = false;

    // Relationships
    public function post()
    {
        return $this->belongsTo(BlogPost::class);
    }
}