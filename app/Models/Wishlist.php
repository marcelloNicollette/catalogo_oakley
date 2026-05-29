<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Wishlist extends Model
{
    protected $table = 'user_wishlists';

    protected $fillable = [
        'user_id',
        'product_id',
        'color_code'
    ];

    /**
     * Relacionamento com o usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com o produto
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relacionamento com a cor do produto
     */
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_code', 'color_code')
            ->where('product_id', $this->product_id);
    }

    /**
     * Relacionamento customizado para buscar cor com substituição de caracteres
     */
    public function colorWithReplace()
    {
        $normalized = str_replace('/', '_', $this->color_code);

        return Color::withTrashed()
            ->where('product_id', $this->product_id)
            ->where(function ($query) use ($normalized) {
                $query->whereRaw('REPLACE(color_code, "/", "_") = ?', [$normalized])
                    ->orWhere('color_code', $normalized);
            })
            ->first();
    }
}
