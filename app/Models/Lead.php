<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'title',
        'contact_name',
        'email',
        'phone',
        'status',
        'user_id', // opcional: se quiser vincular ao usuário
    ];

    // Exemplo de status possíveis: 'new', 'contacted', 'won', 'lost'
    const STATUSES = [
        'new' => 'Novo',
        'contacted' => 'Contactado',
        'won' => 'Ganho',
        'lost' => 'Perdido',
    ];

    // Relacionamento opcional
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
