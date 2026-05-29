<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cada linha da grade (ex: I24A, F34A, M38A...)
        Schema::create('shoe_grids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shoe_size_group_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('code');           // I24A, I30B, F34A, M38A...
            $table->string('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['shoe_size_group_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shoe_grids');
    }
};
