<?php
// app/Models/ShoeGridItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoeGridItem extends Model
{
    protected $fillable = ['shoe_grid_id', 'shoe_size_id', 'quantity'];

    public function grid(): BelongsTo
    {
        return $this->belongsTo(ShoeGrid::class, 'shoe_grid_id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(ShoeSize::class, 'shoe_size_id');
    }
}
