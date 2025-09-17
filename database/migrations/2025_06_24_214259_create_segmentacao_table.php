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
        Schema::create('segmentacao', function (Blueprint $table) {
            $table->id();
            $table->string('segmento');
            $table->string('image')->nullable()->default(null);
            $table->string('image_mobile')->nullable()->default(null);
            $table->string('slug')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segmentacao');
    }
};
