<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SegmentacaoCliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'segmentacao_cliente';

    protected $fillable = [
        'nome',
        'descricao',
        'slug',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Relacionamento many-to-many com usuários
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_segmentacao_cliente')
                    ->withTimestamps();
    }

    /**
     * Relacionamento many-to-many com cores
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_segmentacao_cliente')
                    ->withTimestamps();
    }

    /**
     * Gerar slug automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nome);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nome')) {
                $model->slug = Str::slug($model->nome);
            }
        });
    }
}
