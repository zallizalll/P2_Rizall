<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';

    protected $fillable = [
        'nik',
        'no_kk',
        'name',
        'gender',
        'birth_place',
        'birth_date',
        'religious',
        'education',
        'living_status',
        'married_status',
        'occupation',
        'blood_type',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class, 'no_kk', 'no_kk');
    }
}