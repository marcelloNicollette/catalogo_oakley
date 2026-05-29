<?php
// app/Models/MeasureTable.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeasureTable extends Model
{
    use SoftDeletes;

    protected $fillable = ['measure_category_id', 'name', 'sort_order', 'active'];
    protected $casts    = ['active' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MeasureCategory::class, 'measure_category_id');
    }

    public function rows(): HasMany
    {
        return $this->hasMany(MeasureRow::class)->orderBy('sort_order');
    }

    // Retorna o valor de uma célula para row+column
    public function cellValue(int $rowId, int $columnId): string
    {
        foreach ($this->rows as $row) {
            if ($row->id === $rowId) {
                $cell = $row->cells->firstWhere('measure_column_id', $columnId);
                return $cell?->value ?? '';
            }
        }
        return '';
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderBy('sort_order');
    }
}
