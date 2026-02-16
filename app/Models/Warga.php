<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
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
}
