<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GenerateAllSeeders extends Command
{
    protected $signature = 'make:all-seeders-from-db {--exclude=*} {--limit=1000}';
    protected $description = 'Generate seeders for all database tables';

    private $excludedTables = [
        'migrations',
        'password_resets',
        'password_reset_tokens',
        'failed_jobs',
        'personal_access_tokens',
    ];

    public function handle()
    {
        $excludedTables = array_merge(
            $this->excludedTables,
            $this->option('exclude')
        );

        $limit = $this->option('limit');

        // Get all table names
        $tables = collect(DB::select('SHOW TABLES'))
            ->map(function ($table) {
                return array_values((array) $table)[0];
            })
            ->reject(function ($table) use ($excludedTables) {
                return in_array($table, $excludedTables);
            });

        if ($tables->isEmpty()) {
            $this->error('No tables found to generate seeders for!');
            return 1;
        }

        $this->info("Found {$tables->count()} tables to process...");
        $this->newLine();

        $generatedSeeders = [];

        foreach ($tables as $table) {
            $this->info("Processing table: {$table}");

            $result = $this->call('make:seeder-from-db', [
                'table' => $table,
                '--limit' => $limit
            ]);

            if ($result === 0) {
                $generatedSeeders[] = ucfirst(str_replace('_', '', ucwords($table, '_'))) . 'TableSeeder';
                $this->info("✓ Generated seeder for {$table}");
            } else {
                $this->warn("✗ Skipped {$table} (empty or error)");
            }
        }

        $this->newLine();
        $this->info('All seeders generated successfully!');
        $this->newLine();

        if (!empty($generatedSeeders)) {
            $this->info('Add these lines to your DatabaseSeeder.php:');
            $this->newLine();
            foreach ($generatedSeeders as $seeder) {
                $this->line("\$this->call([{$seeder}::class]);");
            }
        }

        return 0;
    }
}
