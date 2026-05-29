<?php
// app/Models/MeasureRow.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeasureRow extends Model
{
    protected $fillable = ['measure_table_id', 'label', 'sort_order'];

    public function table(): BelongsTo
    {
        return $this->belongsTo(MeasureTable::class, 'measure_table_id');
    }

    public function cells(): HasMany
    {
        return $this->hasMany(MeasureCell::class);
    }

    public function valueFor(int $columnId): string
    {
        return $this->cells->firstWhere('measure_column_id', $columnId)?->value ?? '';
    }
}
