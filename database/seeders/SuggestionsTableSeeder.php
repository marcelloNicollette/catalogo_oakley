<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuggestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('suggestions')->truncate();
        
        // Insert new data
        DB::table('suggestions')->insert([
            [
                'id' => 1,
                'user_id' => 3,
                'suggestion_text' => 'REgistro de sugestao PRide 4',
                'url' => 'http://127.0.0.1:8000/user/calcados/colecoes/2s25-2s25/pride-4',
                'status' => 'pending',
                'admin_notes' => null,
                'created_at' => '2025-09-16 16:26:42',
                'updated_at' => '2025-09-16 16:26:42',
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'suggestion_text' => 'Tecnologia',
                'url' => 'http://127.0.0.1:8000/user/calcados/tecnologias',
                'status' => 'pending',
                'admin_notes' => null,
                'created_at' => '2025-09-16 16:34:56',
                'updated_at' => '2025-09-16 16:34:56',
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'suggestion_text' => 'Enviar um conteudo maior',
                'url' => 'http://127.0.0.1:8000/user/calcados/conteudos',
                'status' => 'pending',
                'admin_notes' => null,
                'created_at' => '2025-09-16 16:35:30',
                'updated_at' => '2025-09-16 16:35:30',
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('SuggestionsTableSeeder completed successfully.');
    }
}