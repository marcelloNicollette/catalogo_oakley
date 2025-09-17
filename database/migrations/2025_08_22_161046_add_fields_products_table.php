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
        Schema::table('products', function (Blueprint $table) {
            $table->string('flag_calendario')->default('0');
            $table->string('data_mkt')->nullable();
            $table->string('data_trade')->nullable();
            $table->string('data_cliente')->nullable();
            $table->string('data_dtc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('flag_calendario');
            $table->dropColumn('data_mkt');
            $table->dropColumn('data_trade');
            $table->dropColumn('data_cliente');
            $table->dropColumn('data_dtc');
        });
    }
};
