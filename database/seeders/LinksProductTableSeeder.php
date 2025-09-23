<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinksProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('links_product')->truncate();
        
        // Insert new data
        DB::table('links_product')->insert([
            [
                'id' => 52,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-17 17:50:42',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => '2025-09-18 22:53:31',
            ],
            [
                'id' => 53,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-17 17:50:42',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => '2025-09-18 22:53:31',
            ],
            [
                'id' => 54,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-17 17:50:42',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => '2025-09-18 22:53:31',
            ],
            [
                'id' => 55,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-17 17:50:42',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => '2025-09-18 22:53:31',
            ],
            [
                'id' => 56,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-17 17:50:42',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => '2025-09-18 22:53:31',
            ],
            [
                'id' => 57,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-18 22:53:31',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => null,
            ],
            [
                'id' => 58,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-18 22:53:31',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => null,
            ],
            [
                'id' => 59,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-18 22:53:31',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => null,
            ],
            [
                'id' => 60,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-18 22:53:31',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => null,
            ],
            [
                'id' => 61,
                'link_title' => 'Google',
                'link_url' => 'https://www.google.com/',
                'product_id' => 38,
                'created_at' => '2025-09-18 22:53:31',
                'updated_at' => '2025-09-18 22:53:31',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('LinksProductTableSeeder completed successfully.');
    }
}