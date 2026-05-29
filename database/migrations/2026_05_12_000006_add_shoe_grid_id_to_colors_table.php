<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
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

    public function down(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            if (Schema::hasColumn('colors', 'shoe_grid_id')) {
                $table->dropForeign(['shoe_grid_id']);
                $table->dropColumn('shoe_grid_id');
            }
        });
    }
};
