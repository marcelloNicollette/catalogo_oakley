<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('color_shoe_grids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('color_id')->constrained('colors')->cascadeOnDelete();
            $table->foreignId('shoe_grid_id')->constrained('shoe_grids')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['color_id', 'shoe_grid_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('color_shoe_grids');
    }
};
