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
        Schema::table('flag_product', function (Blueprint $table) {
            $table->integer('orderfilterflag')->default(0)->after('alinhamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flag_product', function (Blueprint $table) {
            $table->dropColumn('orderfilterflag');
        });
    }
};
