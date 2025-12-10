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
        DB::statement("ALTER TABLE `export_users` MODIFY `formato` ENUM('16_9','a4','planilha') DEFAULT 'a4'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `export_users` MODIFY `formato` ENUM('16_9','a4') DEFAULT 'a4'");
    }
};

