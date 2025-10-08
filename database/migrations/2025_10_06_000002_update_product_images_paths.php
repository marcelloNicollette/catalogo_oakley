<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('product_images')
            ->whereNotNull('path')
            ->where('path', 'not like', 'images/produtos/%')
            ->update(['path' => DB::raw("CONCAT('images/produtos/', filename)")]);
    }

    public function down(): void
    {
        DB::table('product_images')
            ->whereNotNull('path')
            ->where('path', 'like', 'images/produtos/%')
            ->update(['path' => DB::raw("CONCAT('produtos/', filename)")]);
    }
};