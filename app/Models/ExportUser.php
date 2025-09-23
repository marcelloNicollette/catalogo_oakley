<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExportUser extends Model
{
    protected $fillable = [
        'user_id',
        'collection_id',
        'collection_history_name',
        'formato',
        'produtos',
        'produtos_selecionados',
        'opcoes',
        'remove_price',
        'remove_code',
        'remove_description',
        'remove_tag',
        'remove_capa_retranca',
        'filename',
    ];

    protected $casts = [
        'produtos_selecionados' => 'array',
        'opcoes' => 'array',
        'remove_price' => 'boolean',
        'remove_code' => 'boolean',
        'remove_description' => 'boolean',
        'remove_tag' => 'boolean',
        'remove_capa_retranca' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
}
