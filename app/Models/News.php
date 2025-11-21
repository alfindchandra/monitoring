<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'ormawa_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author',
        'category',
        'status',
        'is_featured',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
                
                // Ensure unique slug
                $count = 1;
                while (static::where('slug', $news->slug)->exists()) {
                    $news->slug = Str::slug($news->title) . '-' . $count;
                    $count++;
                }
            }
        });
    }

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(NewsPhoto::class)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function publish()
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words/minute
        return $minutes;
    }

    public function news()
{
    return $this->hasMany(News::class);
}
    public function getCategoryNameAttribute()
    {
        $categories = [
            'prestasi' => 'Prestasi',
            'kegiatan' => 'Kegiatan',
            'pengumuman' => 'Pengumuman',
            'opini' => 'Opini',
            'liputan' => 'Liputan',
            'lainnya' => 'Lainnya',
        ];

        return $categories[$this->category] ?? $this->category;
    }
}
