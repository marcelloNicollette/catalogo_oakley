<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('sizes')->truncate();
        
        // Insert new data
        DB::table('sizes')->insert([
            [
                'id' => 1,
                'size' => 'PP',
                'active' => 1,
                'created_at' => '2025-07-21 15:57:30',
                'updated_at' => '2025-07-21 16:01:59',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'size' => 'P',
                'active' => 1,
                'created_at' => '2025-07-21 16:02:04',
                'updated_at' => '2025-07-21 16:02:04',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'size' => 'M',
                'active' => 1,
                'created_at' => '2025-07-21 16:02:15',
                'updated_at' => '2025-07-21 16:02:15',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'size' => 'G',
                'active' => 1,
                'created_at' => '2025-07-21 16:02:18',
                'updated_at' => '2025-07-21 16:02:18',
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'size' => 'GG',
                'active' => 1,
                'created_at' => '2025-07-21 16:02:22',
                'updated_at' => '2025-07-21 16:02:22',
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'size' => '2GG',
                'active' => 1,
                'created_at' => '2025-07-21 16:02:33',
                'updated_at' => '2025-07-21 16:02:33',
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'size' => '3GG',
                'active' => 1,
                'created_at' => '2025-07-21 16:02:44',
                'updated_at' => '2025-07-21 16:02:44',
                'deleted_at' => null,
            ],
            [
                'id' => 8,
                'size' => 'Ú',
                'active' => 1,
                'created_at' => '2025-07-21 16:03:01',
                'updated_at' => '2025-07-21 16:03:01',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('SizesTableSeeder completed successfully.');
    }
}