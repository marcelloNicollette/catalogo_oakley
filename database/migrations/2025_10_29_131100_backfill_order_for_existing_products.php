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
        // Popula `order` sequencialmente para registros existentes não deletados (deleted_at IS NULL)
        // Estratégia compatível com MySQL 5.7+: variável de usuário para ROW_NUMBER
        DB::statement('SET @rownum := 0');
        DB::statement('
            UPDATE products p
            JOIN (
                SELECT id, (@rownum := @rownum + 1) AS rn
                FROM products
                WHERE deleted_at IS NULL
                ORDER BY id
            ) seq ON seq.id = p.id
            SET p.`order` = seq.rn
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverte o backfill zerando `order` para todos os registros
        DB::statement('UPDATE products SET `order` = NULL');
    }
};