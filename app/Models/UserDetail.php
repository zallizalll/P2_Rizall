<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_detail';

    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'no_hp',
        'address',
        'birth_date',
        'nik',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}