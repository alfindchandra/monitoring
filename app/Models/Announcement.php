<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ormawa_id',
        'title',
        'content',
        'attachment',
        'status',
        'priority',
        'sent_at',
        'is_public',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class);
    }

    public function recipients()
    {
        return $this->belongsToMany(Ormawa::class, 'announcement_recipients')
            ->withPivot('is_read', 'read_at')
            ->withTimestamps();
    }

    public function announcementRecipients()
    {
        return $this->hasMany(AnnouncementRecipient::class);
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }
}
