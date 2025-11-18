<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'ormawa_id',
        'phone',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKetuaBem()
    {
        return $this->role === 'ketua_bem';
    }

    public function isKetuaUkm()
    {
        return $this->role === 'ketua_ukm';
    }
}
