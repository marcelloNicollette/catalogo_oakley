<?php
// app/Models/ShoeGridGroup.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoeGridGroup extends Model
{
    use SoftDeletes;

    protected $table = 'shoe_size_groups';

    protected $fillable = ['name', 'slug', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function grids(): HasMany
    {
        return $this->hasMany(ShoeGrid::class, 'shoe_size_group_id')
                    ->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('sort_order');
    }
}
