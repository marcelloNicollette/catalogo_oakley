<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedCollection extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'collection_id',
        'name',
        'segmentacoes',
        'products',
        'options',
    ];

    protected $casts = [
        'segmentacoes' => 'array',
        'products' => 'array',
        'options' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
