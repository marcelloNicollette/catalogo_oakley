<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserWishlistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('user_wishlists')->truncate();
        
        // Insert new data
        DB::table('user_wishlists')->insert([
            [
                'id' => 23,
                'user_id' => 3,
                'product_id' => 30,
                'color_code' => 'PTO_CH',
                'created_at' => '2025-09-16 18:44:16',
                'updated_at' => '2025-09-16 18:44:16',
            ],
            [
                'id' => 24,
                'user_id' => 3,
                'product_id' => 30,
                'color_code' => 'MLT/PT',
                'created_at' => '2025-09-16 18:44:18',
                'updated_at' => '2025-09-16 18:44:18',
            ],
            [
                'id' => 25,
                'user_id' => 3,
                'product_id' => 30,
                'color_code' => 'BCOPTO',
                'created_at' => '2025-09-16 18:44:19',
                'updated_at' => '2025-09-16 18:44:19',
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('UserWishlistsTableSeeder completed successfully.');
    }
}