<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conteudo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'conteudo';

    protected $fillable = [
        'conteudo_category_id',
        'name',
        'description',
        'link_url',
        'order'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(ConteudoCategory::class, 'conteudo_category_id');
    }
}
