<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SegmentacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('segmentacao')->truncate();
        
        // Insert new data
        DB::table('segmentacao')->insert([
            [
                'id' => 1,
                'segmento' => 'Calçados',
                'image' => 'images/segmentacao/1756832248.png',
                'image_mobile' => 'images/segmentacao/1756832248-mobile.png',
                'slug' => 'calcados',
                'active' => 1,
                'created_at' => '2025-06-25 20:05:32',
                'updated_at' => '2025-09-18 16:13:25',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'segmento' => 'Vestuário e Acessórios',
                'image' => 'images/segmentacao/1756832261.png',
                'image_mobile' => 'images/segmentacao/1756832261-mobile.png',
                'slug' => 'vestuario-e-acessorios',
                'active' => 1,
                'created_at' => '2025-06-25 20:07:16',
                'updated_at' => '2025-09-02 16:57:41',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'segmento' => 'Corre',
                'image' => 'images/segmentacao/1756832278.png',
                'image_mobile' => 'images/segmentacao/1756832278-mobile.png',
                'slug' => 'corre',
                'active' => 1,
                'created_at' => '2025-06-25 20:08:14',
                'updated_at' => '2025-09-02 16:57:58',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('SegmentacaoTableSeeder completed successfully.');
    }
}