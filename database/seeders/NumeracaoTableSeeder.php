<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NumeracaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('numeracao')->truncate();
        
        // Insert new data
        DB::table('numeracao')->insert([
            [
                'id' => 1,
                'numero' => '28/36',
                'active' => 1,
                'created_at' => '2025-07-21 16:25:33',
                'updated_at' => '2025-07-21 16:26:45',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'numero' => '33/44',
                'active' => 1,
                'created_at' => '2025-07-21 16:27:03',
                'updated_at' => '2025-07-21 16:27:03',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'numero' => '34/45',
                'active' => 1,
                'created_at' => '2025-07-21 16:27:10',
                'updated_at' => '2025-07-21 16:27:10',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'numero' => '34/44',
                'active' => 1,
                'created_at' => '2025-07-21 16:27:18',
                'updated_at' => '2025-07-21 16:27:18',
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'numero' => '37/44',
                'active' => 1,
                'created_at' => '2025-07-21 16:27:25',
                'updated_at' => '2025-07-21 16:27:25',
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'numero' => '34/41',
                'active' => 1,
                'created_at' => '2025-07-21 16:27:31',
                'updated_at' => '2025-07-21 16:27:31',
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'numero' => '34/48',
                'active' => 1,
                'created_at' => '2025-07-21 16:27:38',
                'updated_at' => '2025-07-21 16:27:38',
                'deleted_at' => null,
            ],
            [
                'id' => 8,
                'numero' => '36/44',
                'active' => 1,
                'created_at' => '2025-07-21 16:27:45',
                'updated_at' => '2025-07-22 15:43:07',
                'deleted_at' => null,
            ],
            [
                'id' => 9,
                'numero' => '33/34 a 43/44',
                'active' => 1,
                'created_at' => '2025-07-21 16:27:52',
                'updated_at' => '2025-07-21 16:27:52',
                'deleted_at' => null,
            ],
            [
                'id' => 10,
                'numero' => '35/48',
                'active' => 1,
                'created_at' => '2025-09-10 20:16:45',
                'updated_at' => '2025-09-10 20:16:45',
                'deleted_at' => null,
            ],
            [
                'id' => 11,
                'numero' => '35/44',
                'active' => 1,
                'created_at' => '2025-09-10 20:17:29',
                'updated_at' => '2025-09-10 20:17:29',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('NumeracaoTableSeeder completed successfully.');
    }
}