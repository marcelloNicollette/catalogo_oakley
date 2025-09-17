<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ExportAllTablesToExcel extends Command
{
    protected $signature = 'db:export-all-excel';
    protected $description = 'Exporta todas as tabelas do banco de dados para arquivos Excel separados';

    public function handle()
    {
        $database = DB::getDatabaseName();
        $tables = DB::select('SHOW TABLES');
        $key = "Tables_in_$database";

        $exportPath = storage_path('app/exports');
        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0755, true);
        }

        foreach ($tables as $tableObj) {
            $table = $tableObj->$key;
            $columns = Schema::getColumnListing($table);
            $rows = DB::table($table)->get();

            $this->info("Exportando tabela: $table");

            $export = new class($rows, $columns) implements FromCollection, WithHeadings {
                private $data;
                private $columns;

                public function __construct(Collection $data, array $columns)
                {
                    $this->data = $data;
                    $this->columns = $columns;
                }

                public function collection()
                {
                    return $this->data;
                }

                public function headings(): array
                {
                    return $this->columns;
                }
            };

            Excel::store($export, "exports/{$table}.xlsx");
        }

        $this->info('✅ Todas as tabelas foram exportadas com sucesso!');
    }
}
