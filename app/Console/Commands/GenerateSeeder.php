<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateSeeder extends Command
{
    protected $signature = 'make:seeder-from-db {table} {--model=} {--limit=1000}';
    protected $description = 'Generate a seeder from existing database table data';

    public function handle()
    {
        $tableName = $this->argument('table');
        $modelName = $this->option('model') ?: Str::studly(Str::singular($tableName));
        $limit = $this->option('limit');

        if (!Schema::hasTable($tableName)) {
            $this->error("Table '{$tableName}' does not exist!");
            return 1;
        }

        $data = DB::table($tableName)->limit($limit)->get();

        if ($data->isEmpty()) {
            $this->error("Table '{$tableName}' is empty!");
            return 1;
        }

        $seederName = Str::studly($tableName) . 'TableSeeder';
        $seederPath = database_path("seeders/{$seederName}.php");

        $seederContent = $this->generateSeederContent($seederName, $tableName, $modelName, $data);

        file_put_contents($seederPath, $seederContent);

        $this->info("Seeder created successfully!");
        $this->info("File: {$seederPath}");
        $this->info("Don't forget to add it to DatabaseSeeder.php:");
        $this->info("\$this->call([{$seederName}::class]);");

        return 0;
    }

    private function generateSeederContent($seederName, $tableName, $modelName, $data)
    {
        $dataArray = $data->map(function ($item) {
            return (array) $item;
        })->toArray();

        // Format the data array nicely
        $formattedData = $this->formatDataArray($dataArray);

        return "<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class {$seederName} extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        DB::table('{$tableName}')->truncate();
        
        // Insert new data
        DB::table('{$tableName}')->insert({$formattedData});
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        \$this->command->info('{$seederName} completed successfully.');
    }
}";
    }

    private function formatDataArray($data)
    {
        $output = "[\n";

        foreach ($data as $row) {
            $output .= "            [\n";
            foreach ($row as $key => $value) {
                if (is_null($value)) {
                    $formattedValue = 'null';
                } elseif (is_string($value)) {
                    $formattedValue = "'" . addslashes($value) . "'";
                } elseif (is_bool($value)) {
                    $formattedValue = $value ? 'true' : 'false';
                } else {
                    $formattedValue = $value;
                }

                $output .= "                '{$key}' => {$formattedValue},\n";
            }
            $output .= "            ],\n";
        }

        $output .= "        ]";

        return $output;
    }
}
