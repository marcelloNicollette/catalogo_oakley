<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            if (!Schema::hasColumn('colors', 'periodo_vendas')) {
                $table->json('periodo_vendas')->nullable()->after('numeracao_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            if (Schema::hasColumn('colors', 'periodo_vendas')) {
                $table->dropColumn('periodo_vendas');
            }
        });
    }
};
