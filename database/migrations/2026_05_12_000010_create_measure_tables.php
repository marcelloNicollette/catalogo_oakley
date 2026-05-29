<?php
// 2026_05_12_000010_create_measure_categories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Calçados | Vestuário e Acessórios
        Schema::create('measure_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Calçados, Vestuário e Acessórios
            $table->string('slug')->unique();
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Calçados Adultos | Calçados Infantil | Camisetas Masculino...
        Schema::create('measure_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('measure_category_id')
                  ->constrained()->cascadeOnDelete();
            $table->string('name');           // Calçados Adultos
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Colunas dinâmicas por categoria: BRA, USW, USM, Peito, Cintura, Quadril...
        Schema::create('measure_columns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('measure_category_id')
                  ->constrained()->cascadeOnDelete();
            $table->string('name');           // BRA, USW, Peito...
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Linhas: PP, P, M, G, GG / 24, 25, 26...
        Schema::create('measure_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('measure_table_id')
                  ->constrained()->cascadeOnDelete();
            $table->string('label');          // PP, P, M / 24, 25...
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Células: valor por linha + coluna
        Schema::create('measure_cells', function (Blueprint $table) {
            $table->id();
            $table->foreignId('measure_row_id')
                  ->constrained()->cascadeOnDelete();
            $table->foreignId('measure_column_id')
                  ->constrained()->cascadeOnDelete();
            $table->string('value')->nullable(); // "87 - 92", "W 3.5", "24"
            $table->timestamps();

            $table->unique(['measure_row_id', 'measure_column_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measure_cells');
        Schema::dropIfExists('measure_rows');
        Schema::dropIfExists('measure_columns');
        Schema::dropIfExists('measure_tables');
        Schema::dropIfExists('measure_categories');
    }
};
