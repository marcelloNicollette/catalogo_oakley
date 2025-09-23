<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductNumeracaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('product_numeracao')->truncate();
        
        // Insert new data
        DB::table('product_numeracao')->insert([
            [
                'id' => 9,
                'product_id' => 28,
                'numeracao_id' => 4,
                'stock' => 0,
                'created_at' => '2025-09-10 18:22:05',
                'updated_at' => '2025-09-10 18:22:05',
            ],
            [
                'id' => 11,
                'product_id' => 30,
                'numeracao_id' => 4,
                'stock' => 0,
                'created_at' => '2025-09-10 20:03:27',
                'updated_at' => '2025-09-19 18:50:27',
            ],
            [
                'id' => 12,
                'product_id' => 31,
                'numeracao_id' => 4,
                'stock' => 0,
                'created_at' => '2025-09-10 20:09:27',
                'updated_at' => '2025-09-18 16:36:40',
            ],
            [
                'id' => 13,
                'product_id' => 32,
                'numeracao_id' => 4,
                'stock' => 0,
                'created_at' => '2025-09-10 20:15:23',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 14,
                'product_id' => 29,
                'numeracao_id' => 10,
                'stock' => 0,
                'created_at' => '2025-09-10 20:16:59',
                'updated_at' => '2025-09-10 20:16:59',
            ],
            [
                'id' => 15,
                'product_id' => 27,
                'numeracao_id' => 11,
                'stock' => 0,
                'created_at' => '2025-09-10 20:17:53',
                'updated_at' => '2025-09-10 20:17:53',
            ],
            [
                'id' => 16,
                'product_id' => 33,
                'numeracao_id' => 6,
                'stock' => 0,
                'created_at' => '2025-09-10 20:29:23',
                'updated_at' => '2025-09-10 20:29:23',
            ],
            [
                'id' => 17,
                'product_id' => 34,
                'numeracao_id' => 7,
                'stock' => 0,
                'created_at' => '2025-09-10 20:35:10',
                'updated_at' => '2025-09-10 20:39:53',
            ],
            [
                'id' => 18,
                'product_id' => 35,
                'numeracao_id' => 1,
                'stock' => 0,
                'created_at' => '2025-09-10 20:39:28',
                'updated_at' => '2025-09-10 20:39:28',
            ],
            [
                'id' => 19,
                'product_id' => 36,
                'numeracao_id' => 1,
                'stock' => 0,
                'created_at' => '2025-09-10 20:47:26',
                'updated_at' => '2025-09-10 20:47:26',
            ],
            [
                'id' => 20,
                'product_id' => 37,
                'numeracao_id' => 9,
                'stock' => 0,
                'created_at' => '2025-09-10 20:53:40',
                'updated_at' => '2025-09-18 22:54:02',
            ],
            [
                'id' => 21,
                'product_id' => 38,
                'numeracao_id' => 4,
                'stock' => 0,
                'created_at' => '2025-09-10 21:00:26',
                'updated_at' => '2025-09-18 22:53:31',
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('ProductNumeracaoTableSeeder completed successfully.');
    }
}