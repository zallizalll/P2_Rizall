<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
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

    // ⬇ TAMBAHAN PENTING
    public function head()
    {
        return $this->belongsTo(Warga::class, 'family_head_id');
    }
}
