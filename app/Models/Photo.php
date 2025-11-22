<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'ormawa_id',
        'user_id',
        'album',
        'title',
        'description',
        'path',
        'thumbnail_path',
        'photographer',
        'taken_date',
        'location',
        'is_featured',
        'is_public',
        'order',
        'views_count',
        'downloads_count',
    ];

    protected $casts = [
        'taken_date' => 'date',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'views_count' => 'integer',
        'downloads_count' => 'integer',
        'order' => 'integer',
    ];

    // Relationships
    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByAlbum($query, $album)
    {
        return $query->where('album', $album);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->latest();
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementDownloads()
    {
        $this->increment('downloads_count');
    }

    public function getImageUrlAttribute()
    {
        return $this->path ? asset('storage/' . $this->path) : null;
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : $this->image_url;
    }
}