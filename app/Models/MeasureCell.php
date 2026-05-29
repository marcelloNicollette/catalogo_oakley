<?php
// app/Models/MeasureCell.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasureCell extends Model
{
    protected $fillable = ['measure_row_id', 'measure_column_id', 'value'];

    public function row(): BelongsTo
    {
        return $this->belongsTo(MeasureRow::class, 'measure_row_id');
    }

    public function column(): BelongsTo
    {
        return $this->belongsTo(MeasureColumn::class, 'measure_column_id');
    }
}
