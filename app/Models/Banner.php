<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasAccessControl;

class Banner extends Model
{
    use HasFactory, SoftDeletes, HasAccessControl;

    protected $table = 'banners';

    protected $fillable = [
        'id',
        'image',
        'image_mobile',
        'active',
        'order',
        'link',
        'access_levels',
    ];

    protected $casts = [
        'access_levels' => 'array',
    ];
}
