<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ormawa extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'vision',
        'mission',
        'logo',
        'email',
        'phone',
        'instagram',
        'facebook',
        'youtube',
        'address',
        'established_year',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'established_year' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($ormawa) {
            if (empty($ormawa->slug)) {
                $ormawa->slug = Str::slug($ormawa->name);
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function receivedAnnouncements()
    {
        return $this->belongsToMany(Announcement::class, 'announcement_recipients')
            ->withPivot('is_read', 'read_at')
            ->withTimestamps();
    }

    public function isBem()
    {
        return $this->type === 'bem';
    }

    public function isUkm()
    {
        return $this->type === 'ukm';
    }
    public function divisions()
{
    return $this->hasMany(Division::class);
}

public function members()
{
    return $this->hasMany(OrganizationMember::class);
}

public function activeDivisions()
{
    return $this->hasMany(Division::class)->active()->ordered();
}

public function activeMembers()
{
    return $this->hasMany(OrganizationMember::class)->active();
}

public function currentMembers()
{
    return $this->hasMany(OrganizationMember::class)->active()->currentPeriod();
}
public function news()
{
    return $this->hasMany(News::class);
}

public function publishedNews()
{
    return $this->hasMany(News::class)->published()->latest('published_at');
}
public function photos()
{
    return $this->hasMany(Photo::class);
}

public function publicPhotos()
{
    return $this->hasMany(Photo::class)->public()->ordered();
}

public function featuredPhotos()
{
    return $this->hasMany(Photo::class)->public()->featured()->take(6);
}

// Method to get photo count
public function getPhotoCountAttribute()
{
    return $this->photos()->count();
}

}