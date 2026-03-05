<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentLog extends Model
{
    protected $table = 'document_log';

    public $timestamps = false;

    protected $fillable = [
        'detail',
        'doc_type',
        'local_file',
        'created_at',
    ];

    protected $casts = [
        'detail'     => 'array',
        'created_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->created_at)) {
                $model->created_at = now();
            }
        });
    }
}