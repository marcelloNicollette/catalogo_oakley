<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegmentacaoClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('segmentacao_cliente')->truncate();
        
        // Insert new data
        DB::table('segmentacao_cliente')->insert([
            [
                'id' => 1,
                'nome' => 'DTC',
                'descricao' => null,
                'slug' => 'dtc',
                'active' => 1,
                'created_at' => '2025-09-18 14:09:09',
                'updated_at' => '2025-09-18 15:47:37',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'nome' => 'SPORTING GOODS T1',
                'descricao' => null,
                'slug' => 'sporting-goods-t1',
                'active' => 1,
                'created_at' => '2025-09-18 15:41:18',
                'updated_at' => '2025-09-18 15:41:18',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'nome' => 'SPORTING GOODS T2',
                'descricao' => null,
                'slug' => 'sporting-goods-t2',
                'active' => 1,
                'created_at' => '2025-09-18 15:41:28',
                'updated_at' => '2025-09-18 15:41:28',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'nome' => 'SPORTING GOODS T3',
                'descricao' => null,
                'slug' => 'sporting-goods-t3',
                'active' => 1,
                'created_at' => '2025-09-18 15:41:42',
                'updated_at' => '2025-09-18 15:41:42',
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'nome' => 'FAMILY FTW T1',
                'descricao' => null,
                'slug' => 'family-ftw-t1',
                'active' => 1,
                'created_at' => '2025-09-18 15:42:29',
                'updated_at' => '2025-09-18 15:42:29',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('SegmentacaoClienteTableSeeder completed successfully.');
    }
}