<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'color_name',
        'color_description',
        'color_code',
        'genero',
        'periodo_vendas',
        'product_id',
        'collection_id',
        'flag_product_id',
        'numeracao_id',
        'is_new',
        'active'
    ];

    protected $casts = [
        'periodo_vendas' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function flagProduct()
    {
        return $this->belongsTo(FlagProduct::class);
    }

    public function flagProducts()
    {
        return $this->belongsToMany(FlagProduct::class, 'color_flag_product')
            ->withTimestamps();
    }

    public function numeracao(): BelongsTo
    {
        return $this->belongsTo(Numeracao::class, 'numeracao_id');
    }

    public function shoeGrids(): BelongsToMany
    {
        return $this->belongsToMany(ShoeGrid::class, 'color_shoe_grids')->withTimestamps();
    }

    /**
     * Relacionamento many-to-many com segmentações de cliente
     */
    public function segmentacoesCliente()
    {
        return $this->belongsToMany(SegmentacaoCliente::class, 'color_segmentacao_cliente')
                    ->withTimestamps();
    }
}
