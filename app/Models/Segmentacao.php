<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segmentacao extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'segmentacao';

    protected $fillable = [
        'id',
        'segmento',
        'image',
        'image_mobile',
        'slug',
        'active'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
