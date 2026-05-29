<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnologyItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'technology_category_id',
        'name',
        'description',
        'icon',
        'order',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(TechnologyCategory::class, 'technology_category_id');
    }
}
