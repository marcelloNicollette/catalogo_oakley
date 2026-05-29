<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Numeracao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'numeracao';

    protected $fillable = [
        'numero',
        'active'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'numeracao');
    }

    public function colors()
    {
        return $this->hasMany(Color::class, 'numeracao_id');
    }
}
