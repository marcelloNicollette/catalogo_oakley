<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('colors', 'genero')) {
            return;
        }

        DB::statement("ALTER TABLE colors MODIFY COLUMN genero ENUM('Masculino', 'Feminino', 'Unissex', 'Infantil', 'Garotos', 'Garotas') DEFAULT 'Masculino'");
    }

    public function down(): void
    {
        if (!Schema::hasColumn('colors', 'genero')) {
            return;
        }

        DB::statement("UPDATE colors SET genero = 'Masculino' WHERE genero IN ('Garotos', 'Garotas')");
        DB::statement("ALTER TABLE colors MODIFY COLUMN genero ENUM('Masculino', 'Feminino', 'Unissex', 'Infantil') DEFAULT 'Masculino'");
    }
};
