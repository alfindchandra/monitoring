<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'ormawa_id',
        'title',
        'description',
        'image',
        'event_date',
        'event_time',
        'location',
        'is_public',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_public' => 'boolean',
    ];

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }
}