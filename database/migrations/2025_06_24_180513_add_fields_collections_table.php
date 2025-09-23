<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('description')->nullable()->default(null);
            $table->string('bg_color')->nullable()->default(null);
            $table->string('codigo_colecao')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            // Adicione outros campos conforme necessário
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn(['description', 'bg_color', 'codigo_colecao', 'image']);
        });
    }
};
