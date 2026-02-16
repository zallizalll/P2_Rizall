<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rukun extends Model
{
    protected $table = 'rukun';

    protected $fillable = [
        'type', // RT/RW
        'no'
    ];
}
