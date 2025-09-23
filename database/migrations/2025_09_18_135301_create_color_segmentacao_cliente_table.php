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
        Schema::create('color_segmentacao_cliente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('color_id')->constrained('colors')->onDelete('cascade');
            $table->foreignId('segmentacao_cliente_id')->constrained('segmentacao_cliente')->onDelete('cascade');
            $table->timestamps();
            
            // Evitar duplicatas
            $table->unique(['color_id', 'segmentacao_cliente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_segmentacao_cliente');
    }
};
