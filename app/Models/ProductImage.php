<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'path',
        'size',
        'mime',
    ];

    protected static function booted(): void
    {
        static::deleting(function (ProductImage $productImage) {
            $baseDir = realpath(public_path('images/produtos'));
            if (!$baseDir) {
                return;
            }

            $candidates = [];
            if (!empty($productImage->path)) {
                $candidates[] = public_path(ltrim($productImage->path, '/'));
            }
            if (!empty($productImage->filename)) {
                $candidates[] = public_path('images/produtos/' . $productImage->filename);
            }

            foreach (array_values(array_unique($candidates)) as $absPath) {
                if (!File::exists($absPath)) {
                    continue;
                }

                $real = realpath($absPath);
                if (!$real) {
                    continue;
                }

                if (str_starts_with($real, $baseDir . DIRECTORY_SEPARATOR)) {
                    File::delete($real);
                }
            }
        });
    }
}
