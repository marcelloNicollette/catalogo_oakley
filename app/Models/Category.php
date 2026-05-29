<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'segmento_id',
        'name',
        'slug',
        'active'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function segmentacao()
    {
        return $this->belongsTo(Segmentacao::class, 'segmento_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
