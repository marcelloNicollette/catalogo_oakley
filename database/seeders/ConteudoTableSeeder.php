<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConteudoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('conteudo')->truncate();
        
        // Insert new data
        DB::table('conteudo')->insert([
            [
                'id' => 1,
                'conteudo_category_id' => 1,
                'name' => 'Vídeo Lançamento Família Corre',
                'link_url' => 'https://google.com/',
                'description' => 'Descrição Lançamento Família Corre
Descrição Lançamento Família Corre
Descrição Lançamento Família Corre',
                'order' => 1,
                'active' => 1,
                'created_at' => '2025-08-27 19:38:22',
                'updated_at' => '2025-08-27 19:39:02',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'conteudo_category_id' => 2,
                'name' => 'Manual de Marca 2025',
                'link_url' => 'https://google.com/',
                'description' => 'Descrição de Marca 2025
Descrição de Marca 2025
Descrição de Marca 2025
Descrição de Marca 2025',
                'order' => 1,
                'active' => 1,
                'created_at' => '2025-08-27 19:40:47',
                'updated_at' => '2025-08-27 19:40:47',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'conteudo_category_id' => 3,
                'name' => 'Template Apresentação 2025',
                'link_url' => 'https://www.google.com/',
                'description' => 'Descrição Apresentação 2025
Descrição Apresentação 2025
Descrição Apresentação 2025',
                'order' => 1,
                'active' => 1,
                'created_at' => '2025-08-27 19:41:17',
                'updated_at' => '2025-08-27 19:41:17',
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'conteudo_category_id' => 1,
                'name' => 'Vídeo Lançamento Família Corre',
                'link_url' => 'https://google.com/',
                'description' => 'Descrição Lançamento Família Corre
Descrição Lançamento Família Corre
Descrição Lançamento Família Corre',
                'order' => 2,
                'active' => 1,
                'created_at' => '2025-08-27 19:38:22',
                'updated_at' => '2025-08-27 19:39:02',
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'conteudo_category_id' => 2,
                'name' => 'Manual de Marca 2025',
                'link_url' => 'https://google.com/',
                'description' => 'Descrição de Marca 2025
Descrição de Marca 2025
Descrição de Marca 2025
Descrição de Marca 2025',
                'order' => 2,
                'active' => 1,
                'created_at' => '2025-08-27 19:40:47',
                'updated_at' => '2025-08-27 19:40:47',
                'deleted_at' => null,
            ],
            [
                'id' => 6,
                'conteudo_category_id' => 3,
                'name' => 'Template Apresentação 2025',
                'link_url' => 'https://www.google.com/',
                'description' => 'Descrição Apresentação 2025
Descrição Apresentação 2025
Descrição Apresentação 2025',
                'order' => 2,
                'active' => 1,
                'created_at' => '2025-08-27 19:41:17',
                'updated_at' => '2025-08-27 19:41:17',
                'deleted_at' => null,
            ],
            [
                'id' => 7,
                'conteudo_category_id' => 1,
                'name' => 'Vídeo Lançamento Família Corre',
                'link_url' => 'https://google.com/',
                'description' => 'Descrição Lançamento Família Corre
Descrição Lançamento Família Corre
Descrição Lançamento Família Corre',
                'order' => 3,
                'active' => 1,
                'created_at' => '2025-08-27 19:38:22',
                'updated_at' => '2025-08-27 19:39:02',
                'deleted_at' => null,
            ],
            [
                'id' => 8,
                'conteudo_category_id' => 2,
                'name' => 'Manual de Marca 2025',
                'link_url' => 'https://google.com/',
                'description' => 'Descrição de Marca 2025
Descrição de Marca 2025
Descrição de Marca 2025
Descrição de Marca 2025',
                'order' => 3,
                'active' => 1,
                'created_at' => '2025-08-27 19:40:47',
                'updated_at' => '2025-08-27 19:40:47',
                'deleted_at' => null,
            ],
            [
                'id' => 9,
                'conteudo_category_id' => 3,
                'name' => 'Template Apresentação 2025',
                'link_url' => 'https://www.google.com/',
                'description' => 'Descrição Apresentação 2025
Descrição Apresentação 2025
Descrição Apresentação 2025',
                'order' => 3,
                'active' => 1,
                'created_at' => '2025-08-27 19:41:17',
                'updated_at' => '2025-08-27 19:41:17',
                'deleted_at' => null,
            ],
            [
                'id' => 10,
                'conteudo_category_id' => 1,
                'name' => 'Vídeo Lançamento Família Corre',
                'link_url' => 'https://google.com/',
                'description' => 'Descrição Lançamento Família Corre
Descrição Lançamento Família Corre
Descrição Lançamento Família Corre',
                'order' => 4,
                'active' => 1,
                'created_at' => '2025-08-27 19:38:22',
                'updated_at' => '2025-08-27 19:39:02',
                'deleted_at' => null,
            ],
            [
                'id' => 11,
                'conteudo_category_id' => 2,
                'name' => 'Manual de Marca 2025',
                'link_url' => 'https://google.com/',
                'description' => 'Descrição de Marca 2025
Descrição de Marca 2025
Descrição de Marca 2025
Descrição de Marca 2025',
                'order' => 4,
                'active' => 1,
                'created_at' => '2025-08-27 19:40:47',
                'updated_at' => '2025-08-27 19:40:47',
                'deleted_at' => null,
            ],
            [
                'id' => 12,
                'conteudo_category_id' => 3,
                'name' => 'Template Apresentação 2025',
                'link_url' => 'https://www.google.com/',
                'description' => 'Descrição Apresentação 2025
Descrição Apresentação 2025
Descrição Apresentação 2025',
                'order' => 4,
                'active' => 1,
                'created_at' => '2025-08-27 19:41:17',
                'updated_at' => '2025-08-27 19:41:17',
                'deleted_at' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('ConteudoTableSeeder completed successfully.');
    }
}