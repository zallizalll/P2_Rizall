<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LurahConfig extends Model
{
    protected $table = 'lurah_config';

    protected $fillable = [
        'name',
        'province',
        'city',
        'district',
        'pos_code',
        'address',
        'contact',
        'logo',
    ];
}