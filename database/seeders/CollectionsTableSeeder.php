<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('collections')->truncate();
        
        // Insert new data
        DB::table('collections')->insert([
            [
                'id' => 1,
                'segmentacao_id' => 1,
                'name' => 'SAPATARIA',
                'description' => 'Exclusivo Sapatarias',
                'bg_color' => '#2735D4',
                'codigo_colecao' => '1S25',
                'image' => null,
                'slug' => 'sapataria-1s25',
                'active' => 1,
                'created_at' => '2023-06-24 19:10:24',
                'updated_at' => '2025-09-10 18:58:15',
                'deleted_at' => '2025-09-10 18:58:15',
            ],
            [
                'id' => 3,
                'segmentacao_id' => 1,
                'name' => 'SAPATARIA',
                'description' => 'Exclusivo Sapatarias 2024',
                'bg_color' => '#0a0a0a',
                'codigo_colecao' => '1S24',
                'image' => null,
                'slug' => 'sapataria-1s24',
                'active' => 1,
                'created_at' => '2024-06-26 14:20:42',
                'updated_at' => '2025-09-10 18:58:18',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'segmentacao_id' => 1,
                'name' => 'FAMÍLIA CORRE',
                'description' => 'FAMÍLIA CORRE',
                'bg_color' => '#ffffff',
                'codigo_colecao' => '1S25',
                'image' => 'images/collections/1752598087.jpg',
                'slug' => 'familia-corre-1s25',
                'active' => 1,
                'created_at' => '2024-07-15 16:48:07',
                'updated_at' => '2025-09-10 18:58:20',
                'deleted_at' => null,
            ],
            [
                'id' => 8,
                'segmentacao_id' => 1,
                'name' => 'VESTUÁRIO',
                'description' => 'Exclusivo Sapatarias',
                'bg_color' => '#2735D4',
                'codigo_colecao' => '1S25',
                'image' => null,
                'slug' => 'vestuario-sapataria-1s25',
                'active' => 1,
                'created_at' => '2025-06-24 19:10:24',
                'updated_at' => '2025-09-10 18:58:22',
                'deleted_at' => null,
            ],
            [
                'id' => 9,
                'segmentacao_id' => 1,
                'name' => 'VESTUÁRIO FAMÍLIA CORRE',
                'description' => 'FAMÍLIA CORRE',
                'bg_color' => '#ffffff',
                'codigo_colecao' => '1S25',
                'image' => 'images/collections/1752598087.jpg',
                'slug' => 'vestuario-familia-corre-1s25',
                'active' => 1,
                'created_at' => '2025-07-15 16:48:07',
                'updated_at' => '2025-09-10 18:58:26',
                'deleted_at' => null,
            ],
            [
                'id' => 10,
                'segmentacao_id' => 1,
                'name' => 'CORRE',
                'description' => 'Exclusivo Sapatarias',
                'bg_color' => '#2735D4',
                'codigo_colecao' => '1S25',
                'image' => null,
                'slug' => 'corre-1s25',
                'active' => 1,
                'created_at' => '2025-06-24 19:10:24',
                'updated_at' => '2025-09-10 18:58:28',
                'deleted_at' => null,
            ],
            [
                'id' => 11,
                'segmentacao_id' => 1,
                'name' => '2S25',
                'description' => 'Geral',
                'bg_color' => '#ae0909',
                'codigo_colecao' => '2S25',
                'image' => null,
                'slug' => '2s25-2s25',
                'active' => 1,
                'created_at' => '2025-09-10 17:51:24',
                'updated_at' => '2025-09-10 18:00:14',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('CollectionsTableSeeder completed successfully.');
    }
}