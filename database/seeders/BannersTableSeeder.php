<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('banners')->truncate();
        
        // Insert new data
        DB::table('banners')->insert([
            [
                'id' => 1,
                'image' => 'images/banners/1758554699.jpg',
                'image_mobile' => 'images/banners/1758554699-mobile.jpg',
                'active' => 1,
                'order' => 1,
                'created_at' => '2025-07-14 20:56:32',
                'updated_at' => '2025-09-22 15:24:59',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'image' => 'images/banners/1756850399.png',
                'image_mobile' => 'images/banners/1756850399-mobile.png',
                'active' => 1,
                'order' => 1,
                'created_at' => '2025-09-02 21:48:56',
                'updated_at' => '2025-09-02 21:59:59',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('BannersTableSeeder completed successfully.');
    }
}