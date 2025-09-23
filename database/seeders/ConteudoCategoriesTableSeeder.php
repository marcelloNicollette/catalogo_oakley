<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConteudoCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('conteudo_categories')->truncate();
        
        // Insert new data
        DB::table('conteudo_categories')->insert([
            [
                'id' => 1,
                'category' => 'Fotos/Vídeos',
                'icon' => 'images/conteudos/1756323360.png',
                'order' => 1,
                'active' => 1,
                'created_at' => '2025-08-27 19:36:00',
                'updated_at' => '2025-09-10 14:32:21',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'category' => 'Manuais/Marca',
                'icon' => 'images/conteudos/1756323372.png',
                'order' => 2,
                'active' => 1,
                'created_at' => '2025-08-27 19:36:12',
                'updated_at' => '2025-09-10 14:32:06',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'category' => 'Templates/Apresentações',
                'icon' => 'images/conteudos/1756323398.png',
                'order' => 3,
                'active' => 1,
                'created_at' => '2025-08-27 19:36:38',
                'updated_at' => '2025-09-10 14:32:29',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('ConteudoCategoriesTableSeeder completed successfully.');
    }
}