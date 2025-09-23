<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSegmentacaoClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('user_segmentacao_cliente')->truncate();
        
        // Insert new data
        DB::table('user_segmentacao_cliente')->insert([
            [
                'id' => 6,
                'user_id' => 4,
                'segmentacao_cliente_id' => 1,
                'created_at' => '2025-09-18 16:55:19',
                'updated_at' => '2025-09-18 16:55:19',
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('UserSegmentacaoClienteTableSeeder completed successfully.');
    }
}