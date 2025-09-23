<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CacheTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('cache')->truncate();
        
        // Insert new data
        DB::table('cache')->insert([
            [
                'key' => 'olympikus_cache_asdads@dasasd|127.0.0.1',
                'value' => 'i:1;',
                'expiration' => 1758073278,
            ],
            [
                'key' => 'olympikus_cache_asdads@dasasd|127.0.0.1:timer',
                'value' => 'i:1758073278;',
                'expiration' => 1758073278,
            ],
            [
                'key' => 'olympikus_cache_asdasd@dadas|127.0.0.1',
                'value' => 'i:1;',
                'expiration' => 1758073256,
            ],
            [
                'key' => 'olympikus_cache_asdasd@dadas|127.0.0.1:timer',
                'value' => 'i:1758073256;',
                'expiration' => 1758073256,
            ],
            [
                'key' => 'olympikus_cache_asdasd@dasdasd|127.0.0.1',
                'value' => 'i:1;',
                'expiration' => 1758073479,
            ],
            [
                'key' => 'olympikus_cache_asdasd@dasdasd|127.0.0.1:timer',
                'value' => 'i:1758073479;',
                'expiration' => 1758073479,
            ],
            [
                'key' => 'olympikus_cache_marcello@mpiza.com.br|127.0.0.1',
                'value' => 'i:1;',
                'expiration' => 1757710122,
            ],
            [
                'key' => 'olympikus_cache_marcello@mpiza.com.br|127.0.0.1:timer',
                'value' => 'i:1757710122;',
                'expiration' => 1757710122,
            ],
            [
                'key' => 'olympikus_cache_sdadasd@dadasd|127.0.0.1',
                'value' => 'i:1;',
                'expiration' => 1758073379,
            ],
            [
                'key' => 'olympikus_cache_sdadasd@dadasd|127.0.0.1:timer',
                'value' => 'i:1758073379;',
                'expiration' => 1758073379,
            ],
            [
                'key' => 'olympikus_cache_user@olympiku.com|127.0.0.1',
                'value' => 'i:1;',
                'expiration' => 1758642876,
            ],
            [
                'key' => 'olympikus_cache_user@olympiku.com|127.0.0.1:timer',
                'value' => 'i:1758642876;',
                'expiration' => 1758642876,
            ],
            [
                'key' => 'under_armour_cache_asdads@dadsa|127.0.0.1',
                'value' => 'i:1;',
                'expiration' => 1758118916,
            ],
            [
                'key' => 'under_armour_cache_asdads@dadsa|127.0.0.1:timer',
                'value' => 'i:1758118916;',
                'expiration' => 1758118916,
            ],
            [
                'key' => 'under_armour_cache_user@olympikus.com.br|127.0.0.1',
                'value' => 'i:1;',
                'expiration' => 1758138040,
            ],
            [
                'key' => 'under_armour_cache_user@olympikus.com.br|127.0.0.1:timer',
                'value' => 'i:1758138040;',
                'expiration' => 1758138040,
            ],
        ]);
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('CacheTableSeeder completed successfully.');
    }
}