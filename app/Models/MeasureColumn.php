<?php
// app/Models/MeasureColumn.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasureColumn extends Model
{
    protected $fillable = ['measure_category_id', 'name', 'sort_order', 'active'];
    protected $casts    = ['active' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MeasureCategory::class, 'measure_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('sort_order');
    }
}
