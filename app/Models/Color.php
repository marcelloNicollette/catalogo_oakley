<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'color_name',
        'color_description',
        'color_code',
        'product_id',
        'collection_id',
        'flag_product_id',
        'numeracao_id',
        'is_new',
        'active'
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

    public function numeracao()
    {
        return $this->belongsTo(Numeracao::class, 'numeracao_id');
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
