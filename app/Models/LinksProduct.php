<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinksProduct extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'links_product';

    protected $fillable = [
        'link_title',
        'link_url',
        'product_id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
