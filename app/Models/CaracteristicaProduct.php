<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaracteristicaProduct extends Model
{
    use SoftDeletes;

    protected $table = 'caracteristicas_product';

    protected $fillable = [
        'id',
        'title',
        'description',
        'destaque',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
