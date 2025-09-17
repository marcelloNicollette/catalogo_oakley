<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suggestion extends Model
{
    protected $fillable = [
        'user_id',
        'suggestion_text',
        'url',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relacionamento com o usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Status possíveis para as sugestões
     */
    const STATUS_PENDING = 'pending';
    const STATUS_REVIEWED = 'reviewed';
    const STATUS_IMPLEMENTED = 'implemented';
    const STATUS_REJECTED = 'rejected';

    /**
     * Retorna array com os status disponíveis
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Pendente',
            self::STATUS_REVIEWED => 'Revisada',
            self::STATUS_IMPLEMENTED => 'Implementada',
            self::STATUS_REJECTED => 'Rejeitada'
        ];
    }
}
