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

    /**
     * Relacionamento many-to-many com usuários
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_segmentacao')
                    ->withTimestamps();
    }

    /**
     * Relacionamento many-to-many com cores
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_segmentacao');
    }
}
