<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlagProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'flag_product';

    protected $fillable = [
        'flag_title',
        'flag_description',
        'flag_bg',
        'flag_color_text_bg',
        'icon',
        'alinhamento',
        'orderfilterflag',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'orderfilterflag' => 'integer'
    ];

    public function colors()
    {
        return $this->hasMany(Color::class);
    }
}
