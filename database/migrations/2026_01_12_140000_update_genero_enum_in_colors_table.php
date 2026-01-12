<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE colors MODIFY COLUMN genero ENUM('Masculino', 'Feminino', 'Unissex', 'Infantil') DEFAULT 'Masculino'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting might lose data if 'Infantil' was used, but strictly speaking we revert the schema definition.
        // We can't easily remove 'Infantil' if there are rows with that value without data loss or update.
        // For safety in down(), we might just leave it or try to convert. 
        // Typically we just revert the definition.

        // This query might fail if there are 'Infantil' values. 
        // DB::statement("ALTER TABLE colors MODIFY COLUMN genero ENUM('Masculino', 'Feminino', 'Unissex') DEFAULT 'Masculino'");
    }
};
