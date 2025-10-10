<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            if (!Schema::hasColumn('colors', 'numeracao_id')) {
                $table->unsignedBigInteger('numeracao_id')->nullable()->after('flag_product_id');
                $table->foreign('numeracao_id')->references('id')->on('numeracao')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colors', function (Blueprint $table) {
            if (Schema::hasColumn('colors', 'numeracao_id')) {
                $table->dropForeign(['numeracao_id']);
                $table->dropColumn('numeracao_id');
            }
        });
    }
};