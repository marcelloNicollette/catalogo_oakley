<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory;

    protected $table = 'user_access';

    protected $fillable = [
        'name',
        'email',
        'company',
        'setor',
        'phone',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];
}