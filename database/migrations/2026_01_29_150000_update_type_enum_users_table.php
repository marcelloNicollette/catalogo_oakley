<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifica a coluna 'type' na tabela 'users' para incluir 'user-adm' no ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN type ENUM('admin', 'user', 'user-adm') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverte a coluna 'type' para os valores originais (pode falhar se houver registros 'user-adm')
        DB::statement("ALTER TABLE users MODIFY COLUMN type ENUM('admin', 'user') DEFAULT 'user'");
    }
};
