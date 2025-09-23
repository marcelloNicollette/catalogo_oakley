<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('users')->truncate();
        
        // Insert new data
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@olympikus.com',
                'email_verified_at' => null,
                'password' => '$2y$12$ox1XfxL0YRkO4JD07f1GLOBQIl0QhbguXQFyX3nCC1Pq.KCqjAuMi',
                'remember_token' => null,
                'created_at' => '2025-06-10 18:58:28',
                'updated_at' => '2025-06-10 18:58:28',
                'role' => 'admin',
                'type' => 'admin',
                'collection_id' => null,
                'company' => null,
                'setor' => null,
                'phone' => null,
            ],
            [
                'id' => 3,
                'name' => 'User',
                'email' => 'user@olympikus.com',
                'email_verified_at' => null,
                'password' => '$2y$12$ox1XfxL0YRkO4JD07f1GLOBQIl0QhbguXQFyX3nCC1Pq.KCqjAuMi',
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
                'role' => 'user',
                'type' => 'user',
                'collection_id' => null,
                'company' => null,
                'setor' => null,
                'phone' => null,
            ],
            [
                'id' => 4,
                'name' => 'Marcello Waba DTC',
                'email' => 'marcello@waba.com.br',
                'email_verified_at' => null,
                'password' => '$2y$12$ox1XfxL0YRkO4JD07f1GLOBQIl0QhbguXQFyX3nCC1Pq.KCqjAuMi',
                'remember_token' => null,
                'created_at' => '2025-08-29 16:23:56',
                'updated_at' => '2025-09-18 16:55:19',
                'role' => 'user',
                'type' => 'user',
                'collection_id' => null,
                'company' => null,
                'setor' => null,
                'phone' => null,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('UsersTableSeeder completed successfully.');
    }
}