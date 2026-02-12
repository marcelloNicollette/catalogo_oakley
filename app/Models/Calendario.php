<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasAccessControl;

class Calendario extends Model
{
    use HasFactory, SoftDeletes, HasAccessControl;

    protected $table = 'calendario';

    protected $fillable = [
        'title',
        'img',
        'ano',
        'mes',
        'info_1',
        'info_2',
        'data',
        'data_mkt',
        'data_trade',
        'data_cliente',
        'data_dtc',
        'product_id',
        'access_levels',
    ];

    protected $casts = [
        'data' => 'date',
        'data_mkt' => 'date',
        'data_trade' => 'date',
        'data_cliente' => 'date',
        'data_dtc' => 'date',
        'mes' => 'integer',
        'access_levels' => 'array',
    ];

    /**
     * Scope para filtrar por ano
     */
    public function scopeByAno($query, $ano)
    {
        return $query->where('ano', $ano);
    }

    /**
     * Scope para filtrar por mês
     */
    public function scopeByMes($query, $mes)
    {
        return $query->where('mes', $mes);
    }

    /**
     * Relacionamento com Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor para formatar o nome do mês
     */
    public function getMesNomeAttribute()
    {
        $meses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        return $meses[$this->mes] ?? 'Mês inválido';
    }
}
