<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shoe_size_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Kids, Feminino, Masculino, Enerzy
            $table->string('slug')->unique(); // kids, feminino, masculino, enerzy
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shoe_size_groups');
    }
};
