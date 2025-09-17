<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'bg_color',
        'codigo_colecao',
        'image',
        'slug',
        'active',
        'segmentacao_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function segmentacao()
    {
        return $this->belongsTo(Segmentacao::class);
    }
}
