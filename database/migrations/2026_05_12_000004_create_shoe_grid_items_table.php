<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela pivô: quantidade por grade + tamanho
        Schema::create('shoe_grid_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shoe_grid_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('shoe_size_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->unsignedTinyInteger('quantity')->default(0); // 0 = vazio, 1, 2, 3...
            $table->timestamps();

            $table->unique(['shoe_grid_id', 'shoe_size_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shoe_grid_items');
    }
};
