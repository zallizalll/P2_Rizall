<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'email',
        'password',
        'jabatan_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    // alias untuk kemudahan akses di blade
    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    // name dari userDetail
    public function getNameAttribute()
    {
        return $this->userDetail?->name ?? '';
    }
}
