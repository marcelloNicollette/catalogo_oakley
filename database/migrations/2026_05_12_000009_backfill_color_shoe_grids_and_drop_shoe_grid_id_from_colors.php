<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('colors', 'shoe_grid_id')) {
            $rows = DB::table('colors')
                ->whereNotNull('shoe_grid_id')
                ->select('id as color_id', 'shoe_grid_id')
                ->get()
                ->map(fn($r) => [
                    'color_id' => $r->color_id,
                    'shoe_grid_id' => $r->shoe_grid_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
                ->all();

            if (!empty($rows)) {
                DB::table('color_shoe_grids')->insertOrIgnore($rows);
            }

            Schema::table('colors', function (Blueprint $table) {
                $table->dropForeign(['shoe_grid_id']);
                $table->dropColumn('shoe_grid_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            if (!Schema::hasColumn('colors', 'shoe_grid_id')) {
                $table->foreignId('shoe_grid_id')
                    ->nullable()
                    ->after('numeracao_id')
                    ->constrained('shoe_grids')
                    ->nullOnDelete();
            }
        });
    }
};
