<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlagProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('flag_product')->truncate();
        
        // Insert new data
        DB::table('flag_product')->insert([
            [
                'id' => 1,
                'flag_title' => 'Cor nova',
                'flag_description' => 'cor nova',
                'flag_bg' => '#2735d4',
                'flag_color_text_bg' => '#ffffff',
                'icon' => null,
                'alinhamento' => 'left',
                'status' => 1,
                'created_at' => '2025-07-02 20:16:50',
                'updated_at' => '2025-07-02 20:19:42',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'flag_title' => 'Continuidade',
                'flag_description' => 'Continuidade',
                'flag_bg' => '#cccccc',
                'flag_color_text_bg' => '#FFFFFF',
                'icon' => null,
                'alinhamento' => 'left',
                'status' => 1,
                'created_at' => '2025-07-02 20:45:43',
                'updated_at' => '2025-07-02 20:45:43',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'flag_title' => 'Exclusivo Netshoes',
                'flag_description' => 'Exclusivo Netshoes',
                'flag_bg' => '#000000',
                'flag_color_text_bg' => '#000000',
                'icon' => 'images/flags/1757020984_68ba033866011.png',
                'alinhamento' => 'right',
                'status' => 1,
                'created_at' => '2025-09-04 21:23:04',
                'updated_at' => '2025-09-04 21:23:04',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'flag_title' => 'Authentic Feet',
                'flag_description' => 'Authentic Feet',
                'flag_bg' => '#000000',
                'flag_color_text_bg' => '#000000',
                'icon' => 'images/flags/1757537727_68c1e5bf9e1a4.png',
                'alinhamento' => 'right',
                'status' => 1,
                'created_at' => '2025-09-10 20:55:27',
                'updated_at' => '2025-09-10 20:55:27',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('FlagProductTableSeeder completed successfully.');
    }
}