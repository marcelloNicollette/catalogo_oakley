<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnologyItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('technology_items')->truncate();
        
        // Insert new data
        DB::table('technology_items')->insert([
            [
                'id' => 1,
                'technology_category_id' => 1,
                'name' => 'GRIPPER',
                'description' => 'O Corre Supra traz o que há de melhor no mundo em termos de materiais e tecnologias para que os corredores brasileiros atinjam sua máxima performance. Teste 1',
                'icon' => 'images/technology/1757339180.jpg',
                'active' => 1,
                'created_at' => '2025-06-30 13:51:55',
                'updated_at' => '2025-09-08 13:46:20',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'technology_category_id' => 1,
                'name' => 'EVASENSE',
                'description' => 'O Corre Supra traz o que há de melhor no mundo em termos de materiais e tecnologias para que os corredores brasileiros atinjam sua máxima performance. Teste 2',
                'icon' => 'images/technology/1757339189.jpg',
                'active' => 1,
                'created_at' => '2025-06-30 13:54:44',
                'updated_at' => '2025-09-08 13:46:29',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'technology_category_id' => 1,
                'name' => 'BORRACHA MICHELIN',
                'description' => 'O Corre Supra traz o que há de melhor no mundo em termos de materiais e tecnologias para que os corredores brasileiros atinjam sua máxima performance. Teste 3',
                'icon' => 'images/technology/1757339196.jpg',
                'active' => 1,
                'created_at' => '2025-07-31 20:14:58',
                'updated_at' => '2025-09-08 13:46:36',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'technology_category_id' => 2,
                'name' => 'GRIPPER',
                'description' => 'O Corre Supra traz o que há de melhor no mundo em termos de materiais e tecnologias para que os corredores brasileiros atinjam sua máxima performance. Teste 4',
                'icon' => 'images/technology/1757339205.jpg',
                'active' => 1,
                'created_at' => '2025-06-30 13:51:55',
                'updated_at' => '2025-09-08 13:46:45',
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'technology_category_id' => 2,
                'name' => 'EVASENSE',
                'description' => 'O Corre Supra traz o que há de melhor no mundo em termos de materiais e tecnologias para que os corredores brasileiros atinjam sua máxima performance. Teste 5',
                'icon' => 'images/technology/1757339212.jpg',
                'active' => 1,
                'created_at' => '2025-06-30 13:54:44',
                'updated_at' => '2025-09-08 13:46:52',
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'technology_category_id' => 2,
                'name' => 'BORRACHA MICHELIN',
                'description' => 'O Corre Supra traz o que há de melhor no mundo em termos de materiais e tecnologias para que os corredores brasileiros atinjam sua máxima performance. Teste 6',
                'icon' => 'images/technology/1757339220.jpg',
                'active' => 1,
                'created_at' => '2025-07-31 20:14:58',
                'updated_at' => '2025-09-08 13:47:00',
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'technology_category_id' => 3,
                'name' => 'GRIPPER',
                'description' => 'O Corre Supra traz o que há de melhor no mundo em termos de materiais e tecnologias para que os corredores brasileiros atinjam sua máxima performance. Teste 7',
                'icon' => 'images/technology/1757339228.jpg',
                'active' => 1,
                'created_at' => '2025-06-30 13:51:55',
                'updated_at' => '2025-09-08 13:47:08',
                'deleted_at' => null,
            ],
            [
                'id' => 8,
                'technology_category_id' => 3,
                'name' => 'EVASENSE',
                'description' => 'O Corre Supra traz o que há de melhor no mundo em termos de materiais e tecnologias para que os corredores brasileiros atinjam sua máxima performance. Teste 8',
                'icon' => 'images/technology/1757339234.jpg',
                'active' => 1,
                'created_at' => '2025-06-30 13:54:44',
                'updated_at' => '2025-09-08 13:47:14',
                'deleted_at' => null,
            ],
            [
                'id' => 9,
                'technology_category_id' => 3,
                'name' => 'BORRACHA MICHELIN',
                'description' => 'O Corre Supra traz o que há de melhor no mundo em termos de materiais e tecnologias para que os corredores brasileiros atinjam sua máxima performance. Teste 9',
                'icon' => 'images/technology/1757339243.jpg',
                'active' => 1,
                'created_at' => '2025-07-31 20:14:58',
                'updated_at' => '2025-09-08 13:47:23',
                'deleted_at' => null,
            ],
            [
                'id' => 10,
                'technology_category_id' => 1,
                'name' => 'ELEVATE PRO',
                'description' => 'ELEVATE PRO',
                'icon' => 'images/technology/1757339302.jpg',
                'active' => 1,
                'created_at' => '2025-09-08 13:48:22',
                'updated_at' => '2025-09-08 13:48:22',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('TechnologyItemsTableSeeder completed successfully.');
    }
}