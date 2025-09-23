<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('categories')->truncate();
        
        // Insert new data
        DB::table('categories')->insert([
            [
                'id' => 1,
                'segmento_id' => 1,
                'name' => 'Corrida',
                'slug' => 'corrida',
                'active' => 1,
                'created_at' => '2025-06-26 16:00:38',
                'updated_at' => '2025-06-26 16:07:27',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'segmento_id' => 1,
                'name' => 'Treino',
                'slug' => 'treino',
                'active' => 1,
                'created_at' => '2025-06-26 16:04:00',
                'updated_at' => '2025-06-26 16:04:00',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'segmento_id' => 1,
                'name' => 'Casual',
                'slug' => 'casual',
                'active' => 1,
                'created_at' => '2025-06-26 16:04:11',
                'updated_at' => '2025-06-26 16:09:26',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'segmento_id' => 1,
                'name' => 'Chinelo',
                'slug' => 'chinelo',
                'active' => 1,
                'created_at' => '2025-06-26 16:09:54',
                'updated_at' => '2025-09-10 20:13:27',
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'segmento_id' => 1,
                'name' => 'Infantil',
                'slug' => 'infantil',
                'active' => 1,
                'created_at' => '2025-06-26 16:10:03',
                'updated_at' => '2025-06-26 16:10:03',
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'segmento_id' => 2,
                'name' => 'Corrida',
                'slug' => 'corrida',
                'active' => 1,
                'created_at' => '2025-06-26 16:00:38',
                'updated_at' => '2025-06-26 16:07:27',
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'segmento_id' => 2,
                'name' => 'Treino',
                'slug' => 'treino',
                'active' => 1,
                'created_at' => '2025-06-26 16:04:00',
                'updated_at' => '2025-06-26 16:04:00',
                'deleted_at' => null,
            ],
            [
                'id' => 8,
                'segmento_id' => 2,
                'name' => 'Casual',
                'slug' => 'casual',
                'active' => 1,
                'created_at' => '2025-06-26 16:04:11',
                'updated_at' => '2025-06-26 16:09:26',
                'deleted_at' => null,
            ],
            [
                'id' => 9,
                'segmento_id' => 1,
                'name' => 'Caminhada',
                'slug' => 'caminhada',
                'active' => 1,
                'created_at' => '2025-09-10 20:13:12',
                'updated_at' => '2025-09-10 20:13:12',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('CategoriesTableSeeder completed successfully.');
    }
}