<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('color_flag_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('color_id')->constrained('colors')->onDelete('cascade');
            $table->foreignId('flag_product_id')->constrained('flag_product')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['color_id', 'flag_product_id']);
        });

        if (Schema::hasColumn('colors', 'flag_product_id')) {
            $now = now();

            $rows = DB::table('colors')
                ->select(['id as color_id', 'flag_product_id'])
                ->whereNotNull('flag_product_id')
                ->get();

            if ($rows->isNotEmpty()) {
                $inserts = $rows->map(function ($row) use ($now) {
                    return [
                        'color_id' => $row->color_id,
                        'flag_product_id' => $row->flag_product_id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                })->all();

                foreach (array_chunk($inserts, 500) as $chunk) {
                    DB::table('color_flag_product')->insertOrIgnore($chunk);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('color_flag_product');
    }
};

