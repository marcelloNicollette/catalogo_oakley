<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'collection_id',
        'company',
        'setor',
        'phone',
        'codigo_lider_comercial',
        'idioma',
        'classification',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->type === 'admin';
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Relacionamento com a wishlist
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Verificar se um produto está na wishlist
     */
    public function hasInWishlist($productId, $colorCode = null)
    {
        return $this->wishlist()
            ->where('product_id', $productId)
            ->where('color_code', $colorCode)
            ->exists();
    }

    /**
     * Relacionamento many-to-many com segmentações
     */
    public function segmentacoes()
    {
        return $this->belongsToMany(Segmentacao::class, 'user_segmentacao')
            ->withTimestamps();
    }

    /**
     * Verificar se o usuário tem acesso a uma segmentação específica
     */
    public function hasAccessToSegmentacao($segmentacaoId)
    {
        return $this->segmentacoes()->where('segmentacao_id', $segmentacaoId)->exists();
    }

    /**
     * Verificar se o usuário tem acesso a uma segmentação por slug
     */
    public function hasAccessToSegmentacaoBySlug($slug)
    {
        return $this->segmentacoes()->where('slug', $slug)->exists();
    }

    /**
     * Relacionamento many-to-many com segmentações de cliente
     */
    public function segmentacoesCliente()
    {
        return $this->belongsToMany(SegmentacaoCliente::class, 'user_segmentacao_cliente')
            ->withTimestamps();
    }

    /**
     * Verificar se o usuário tem acesso a uma segmentação de cliente específica
     */
    public function hasAccessToSegmentacaoCliente($segmentacaoClienteId)
    {
        return $this->segmentacoesCliente()->where('segmentacao_cliente_id', $segmentacaoClienteId)->exists();
    }

    /**
     * Verificar se o usuário tem acesso a uma segmentação de cliente por slug
     */
    public function hasAccessToSegmentacaoClienteBySlug($slug)
    {
        return $this->segmentacoesCliente()->where('slug', $slug)->exists();
    }
}
