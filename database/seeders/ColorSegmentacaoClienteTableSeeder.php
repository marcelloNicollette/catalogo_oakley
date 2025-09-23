<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSegmentacaoClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('color_segmentacao_cliente')->truncate();
        
        // Insert new data
        DB::table('color_segmentacao_cliente')->insert([
            [
                'id' => 1,
                'color_id' => 396,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:29:33',
                'updated_at' => '2025-09-18 16:29:33',
            ],
            [
                'id' => 2,
                'color_id' => 397,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:36:40',
                'updated_at' => '2025-09-18 16:36:40',
            ],
            [
                'id' => 3,
                'color_id' => 398,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:36:40',
                'updated_at' => '2025-09-18 16:36:40',
            ],
            [
                'id' => 4,
                'color_id' => 399,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:36:40',
                'updated_at' => '2025-09-18 16:36:40',
            ],
            [
                'id' => 5,
                'color_id' => 400,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:36:40',
                'updated_at' => '2025-09-18 16:36:40',
            ],
            [
                'id' => 6,
                'color_id' => 401,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:36:40',
                'updated_at' => '2025-09-18 16:36:40',
            ],
            [
                'id' => 7,
                'color_id' => 402,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:36:40',
                'updated_at' => '2025-09-18 16:36:40',
            ],
            [
                'id' => 8,
                'color_id' => 403,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 9,
                'color_id' => 403,
                'segmentacao_cliente_id' => 2,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 10,
                'color_id' => 403,
                'segmentacao_cliente_id' => 3,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 11,
                'color_id' => 403,
                'segmentacao_cliente_id' => 4,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 12,
                'color_id' => 404,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 13,
                'color_id' => 404,
                'segmentacao_cliente_id' => 2,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 14,
                'color_id' => 404,
                'segmentacao_cliente_id' => 3,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 15,
                'color_id' => 404,
                'segmentacao_cliente_id' => 4,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 16,
                'color_id' => 405,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 17,
                'color_id' => 405,
                'segmentacao_cliente_id' => 2,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 18,
                'color_id' => 405,
                'segmentacao_cliente_id' => 3,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 19,
                'color_id' => 405,
                'segmentacao_cliente_id' => 4,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 20,
                'color_id' => 406,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 21,
                'color_id' => 406,
                'segmentacao_cliente_id' => 2,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 22,
                'color_id' => 406,
                'segmentacao_cliente_id' => 3,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 23,
                'color_id' => 406,
                'segmentacao_cliente_id' => 4,
                'created_at' => '2025-09-18 16:37:33',
                'updated_at' => '2025-09-18 16:37:33',
            ],
            [
                'id' => 24,
                'color_id' => 407,
                'segmentacao_cliente_id' => 2,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 25,
                'color_id' => 407,
                'segmentacao_cliente_id' => 3,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 26,
                'color_id' => 407,
                'segmentacao_cliente_id' => 4,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 27,
                'color_id' => 408,
                'segmentacao_cliente_id' => 2,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 28,
                'color_id' => 408,
                'segmentacao_cliente_id' => 3,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 29,
                'color_id' => 408,
                'segmentacao_cliente_id' => 4,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 30,
                'color_id' => 409,
                'segmentacao_cliente_id' => 2,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 31,
                'color_id' => 409,
                'segmentacao_cliente_id' => 3,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 32,
                'color_id' => 409,
                'segmentacao_cliente_id' => 4,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 33,
                'color_id' => 410,
                'segmentacao_cliente_id' => 2,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 34,
                'color_id' => 410,
                'segmentacao_cliente_id' => 3,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 35,
                'color_id' => 410,
                'segmentacao_cliente_id' => 4,
                'created_at' => '2025-09-18 16:51:47',
                'updated_at' => '2025-09-18 16:51:47',
            ],
            [
                'id' => 36,
                'color_id' => 411,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 22:53:31',
                'updated_at' => '2025-09-18 22:53:31',
            ],
            [
                'id' => 37,
                'color_id' => 413,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 22:54:02',
                'updated_at' => '2025-09-18 22:54:02',
            ],
            [
                'id' => 38,
                'color_id' => 419,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-19 18:50:27',
                'updated_at' => '2025-09-19 18:50:27',
            ],
            [
                'id' => 39,
                'color_id' => 420,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-19 18:50:27',
                'updated_at' => '2025-09-19 18:50:27',
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('ColorSegmentacaoClienteTableSeeder completed successfully.');
    }
}