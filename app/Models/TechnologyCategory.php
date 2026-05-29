<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnologyCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function items()
    {
        return $this->hasMany(TechnologyItem::class)->orderBy('order')->orderBy('id');
    }
}
