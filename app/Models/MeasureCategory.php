<?php
// app/Models/MeasureCategory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeasureCategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'sort_order', 'active'];
    protected $casts    = ['active' => 'boolean'];

    public function tables(): HasMany
    {
        return $this->hasMany(MeasureTable::class)->orderBy('sort_order');
    }

    public function columns(): HasMany
    {
        return $this->hasMany(MeasureColumn::class)->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('sort_order');
    }
}
