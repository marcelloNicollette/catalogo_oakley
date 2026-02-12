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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable(); // Olho
            $table->longText('content')->nullable();
            $table->string('author')->nullable();
            $table->date('material_date')->nullable();
            $table->dateTime('publish_at')->nullable(); // Data inserção
            $table->dateTime('unpublish_at')->nullable(); // Data retirada
            $table->boolean('status')->default(true);
            $table->boolean('active')->default(true);
            $table->json('access_levels')->nullable(); // Nível de acesso
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
