<?php
// app/Models/ShoeSize.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoeSize extends Model
{
    protected $fillable = ['bra', 'usw', 'usm', 'sort_order', 'active'];

    protected $casts = [
        'bra'    => 'decimal:1',
        'active' => 'boolean',
    ];

    public function gridItems(): HasMany
    {
        return $this->hasMany(ShoeGridItem::class);
    }

    // Label amigável para exibição na coluna
    public function getLabelAttribute(): string
    {
        return $this->bra ? number_format((float) $this->bra, 1, ',', '') : '-';
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('sort_order');
    }
}
