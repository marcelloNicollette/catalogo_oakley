<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasAccessControl;

class Conteudo extends Model
{
    use HasFactory, SoftDeletes, HasAccessControl;

    protected $table = 'conteudo';

    protected $fillable = [
        'conteudo_category_id',
        'name',
        'description',
        'link_url',
        'order',
        'access_levels',
    ];

    protected $casts = [
        'active' => 'boolean',
        'access_levels' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ConteudoCategory::class, 'conteudo_category_id');
    }
}
