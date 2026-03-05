<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'label',
        'route',
        'url',
        'icon',
        'order',
        'allowed_classifications',
        'active',
    ];

    protected $casts = [
        'allowed_classifications' => 'array',
        'active' => 'boolean',
    ];
}
