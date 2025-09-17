<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConteudoCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'conteudo_categories';

    protected $fillable = [
        'category',
        'icon',
        'order'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function conteudo()
    {
        return $this->hasMany(Conteudo::class);
    }
}
