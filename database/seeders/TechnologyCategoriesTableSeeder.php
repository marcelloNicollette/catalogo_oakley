<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnologyCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('technology_categories')->truncate();
        
        // Insert new data
        DB::table('technology_categories')->insert([
            [
                'id' => 1,
                'name' => 'Cabedal',
                'active' => 1,
                'created_at' => '2025-06-30 13:30:04',
                'updated_at' => '2025-06-30 13:30:04',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'Entressola',
                'active' => 1,
                'created_at' => '2025-06-30 13:30:26',
                'updated_at' => '2025-06-30 13:30:26',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'Vestuário',
                'active' => 1,
                'created_at' => '2025-06-30 13:30:48',
                'updated_at' => '2025-06-30 13:30:48',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'name' => 'FOTOS/VÍDEOS',
                'active' => 1,
                'created_at' => '2025-08-01 14:34:28',
                'updated_at' => '2025-08-01 14:34:37',
                'deleted_at' => '2025-08-01 14:34:37',
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('TechnologyCategoriesTableSeeder completed successfully.');
    }
}