<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'ormawa_id',
        'division_id',
        'name',
        'nim',
        'phone',
        'email',
        'photo',
        'position',
        'period_start',
        'period_end',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'period_start' => 'integer',
        'period_end' => 'integer',
    ];

    public function ormawa()
    {
        return $this->belongsTo(Ormawa::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeCurrentPeriod($query)
    {
        $currentYear = date('Y');
        return $query->where('period_start', '<=', $currentYear)
                    ->where('period_end', '>=', $currentYear);
    }

    public function getPositionNameAttribute()
    {
        $positions = [
            'pembina' => 'Pembina',
            'ketua' => 'Ketua',
            'wakil_ketua' => 'Wakil Ketua',
            'sekretaris' => 'Sekretaris',
            'bendahara' => 'Bendahara',
            'kepala_divisi' => 'Kepala Divisi',
            'anggota_divisi' => 'Anggota',
        ];

        return $positions[$this->position] ?? $this->position;
    }
}