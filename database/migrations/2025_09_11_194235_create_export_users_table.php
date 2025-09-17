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
        Schema::create('export_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('collection_id')->constrained()->onDelete('cascade');
            $table->string('collection_history_name')->nullable();
            $table->enum('formato', ['16_9', 'a4'])->default('a4');
            $table->enum('produtos', ['todos', 'selecao', 'favoritos'])->default('todos');
            $table->json('produtos_selecionados')->nullable(); // Array de IDs dos produtos selecionados
            $table->json('opcoes')->nullable(); // Array das opções selecionadas (remover_preco, remover_codigo, etc.)
            $table->boolean('remove_price')->default(false);
            $table->boolean('remove_code')->default(false);
            $table->boolean('remove_description')->default(false);
            $table->boolean('remove_tag')->default(false);
            $table->string('filename')->nullable(); // Nome do arquivo gerado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_users');
    }
};
