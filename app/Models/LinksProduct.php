<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasAccessControl;

class LinksProduct extends Model
{
    use HasFactory, SoftDeletes, HasAccessControl;

    protected $table = 'links_product';

    protected $fillable = [
        'link_title',
        'link_url',
        'product_id',
        'access_levels',
    ];

    protected $casts = [
        'access_levels' => 'array',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
