<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = ['action', 'user_id', 'metadata', 'executed_at'];

    protected $casts = [
        'metadata' => 'array',
        'executed_at' => 'datetime',
    ];
}
