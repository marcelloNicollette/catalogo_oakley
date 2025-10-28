<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImgLogin extends Model
{
    use HasFactory;

    protected $table = 'img_login';

    protected $fillable = [
        'desktop_image',
        'mobile_image',
    ];

    protected $appends = [
        'desktop_url',
        'mobile_url',
    ];

    public function getDesktopUrlAttribute(): ?string
    {
        return $this->desktop_image ? Storage::url($this->desktop_image) : null;
    }

    public function getMobileUrlAttribute(): ?string
    {
        return $this->mobile_image ? Storage::url($this->mobile_image) : null;
    }
}