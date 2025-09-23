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
        Schema::create('user_segmentacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('segmentacao_id')
                ->constrained('segmentacao')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
            
            // Índice único para evitar duplicatas
            $table->unique(['user_id', 'segmentacao_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_segmentacao');
    }
};
