<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('colors') || !Schema::hasColumn('colors', 'flag_product_id')) {
            return;
        }

        try {
            DB::statement('ALTER TABLE `colors` DROP FOREIGN KEY `colors_flag_product_id_foreign`');
        } catch (\Throwable $e) {
        }

        DB::statement('ALTER TABLE `colors` MODIFY `flag_product_id` BIGINT UNSIGNED NULL');

        try {
            DB::statement('ALTER TABLE `colors` ADD CONSTRAINT `colors_flag_product_id_foreign` FOREIGN KEY (`flag_product_id`) REFERENCES `flag_product`(`id`) ON DELETE SET NULL');
        } catch (\Throwable $e) {
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('colors') || !Schema::hasColumn('colors', 'flag_product_id')) {
            return;
        }

        try {
            DB::statement('ALTER TABLE `colors` DROP FOREIGN KEY `colors_flag_product_id_foreign`');
        } catch (\Throwable $e) {
        }

        DB::statement('ALTER TABLE `colors` MODIFY `flag_product_id` BIGINT UNSIGNED NOT NULL');

        try {
            DB::statement('ALTER TABLE `colors` ADD CONSTRAINT `colors_flag_product_id_foreign` FOREIGN KEY (`flag_product_id`) REFERENCES `flag_product`(`id`) ON DELETE CASCADE');
        } catch (\Throwable $e) {
        }
    }
};

