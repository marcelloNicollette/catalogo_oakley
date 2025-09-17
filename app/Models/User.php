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
        'phone'
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
}
