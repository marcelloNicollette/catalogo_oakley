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
        Schema::create('calendario', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('img')->nullable();
            $table->string('ano')->default('2025');
            $table->integer('mes')->default(1);
            $table->string('info_1')->nullable();
            $table->string('info_2')->nullable();
            $table->date('data')->nullable();
            $table->date('data_mkt')->nullable();
            $table->date('data_trade')->nullable();
            $table->date('data_cliente')->nullable();
            $table->date('data_dtc')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendario');
    }
};
