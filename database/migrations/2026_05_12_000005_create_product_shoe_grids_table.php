<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_shoe_grids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('shoe_grid_id')->constrained('shoe_grids')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['product_id', 'shoe_grid_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_shoe_grids');
    }
};
