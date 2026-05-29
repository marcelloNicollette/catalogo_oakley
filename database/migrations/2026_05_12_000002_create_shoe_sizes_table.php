<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de tamanhos disponíveis (colunas da grade)
        Schema::create('shoe_sizes', function (Blueprint $table) {
            $table->id();
            $table->decimal('bra', 4, 1)->nullable();   // 24, 25, 26 ... 42,5
            $table->string('usw', 10)->nullable();       // W 3.5, W 4, W 4.5 ...
            $table->string('usm', 10)->nullable();       // 1, 2, 2.5 ...
            $table->integer('sort_order')->default(0);   // ordem de exibição
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shoe_sizes');
    }
};
