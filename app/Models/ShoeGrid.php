<?php
// app/Models/ShoeGrid.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoeGrid extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shoe_size_group_id', 'code', 'description', 'sort_order', 'active',
    ];

    protected $casts = ['active' => 'boolean'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(ShoeGridGroup::class, 'shoe_size_group_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShoeGridItem::class);
    }

    // Retorna quantidade para um shoe_size_id específico
    public function quantityFor(int $sizeId): int
    {
        return $this->items->firstWhere('shoe_size_id', $sizeId)?->quantity ?? 0;
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('sort_order');
    }
}
