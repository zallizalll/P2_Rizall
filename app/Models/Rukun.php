<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rukun extends Model
{
    use HasFactory;

    protected $table = 'rukun';

    protected $fillable = [
        'type',
        'no',
    ];

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getFullNameAttribute()
    {
        return $this->type . ' ' . $this->no;
    }
}