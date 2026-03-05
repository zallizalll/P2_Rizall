<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    protected $table = 'family';

    protected $fillable = [
        'no_kk',
        'rt_id',
        'rw_id',
        'address',
        'family_head_id',
    ];

    public function rt()
    {
        return $this->belongsTo(Rukun::class, 'rt_id');
    }

    public function rw()
    {
        return $this->belongsTo(Rukun::class, 'rw_id');
    }

    public function familyHead()
    {
        return $this->belongsTo(Warga::class, 'family_head_id');
    }

    public function members()
    {
        return $this->hasMany(Warga::class, 'no_kk', 'no_kk');
    }
}