<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subcategories';

    protected $fillable = [
        'category_id',
        'faixa',
        'slug',
        'active',
        'order'
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subcategory) {
            if (empty($subcategory->slug)) {
                $subcategory->slug = Str::slug($subcategory->faixa);
            }
        });

        static::updating(function ($subcategory) {
            if ($subcategory->isDirty('faixa')) {
                $subcategory->slug = Str::slug($subcategory->faixa);
            }
        });
    }

    /**
     * Relacionamento com Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope para subcategorias ativas
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope para ordenação
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('faixa', 'asc');
    }
}