<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LurahConfig extends Model
{
    use HasFactory;

    protected $table = 'lurah_config';

    protected $fillable = [
        'name',
        'province',
        'city',
        'district',
        'pos_code',
        'logo',
    ];
}