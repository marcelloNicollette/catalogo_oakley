<?php
namespace Database\Seeders;

use App\Models\MeasureCategory;
use App\Models\MeasureCell;
use App\Models\MeasureColumn;
use App\Models\MeasureRow;
use App\Models\MeasureTable;
use Illuminate\Database\Seeder;

class MeasureTableSeeder extends Seeder
{
    public function run(): void
    {
        // ── CALÇADOS ────────────────────────────────────────────────────────
        $calcados = MeasureCategory::create([
            'name' => 'Calçados', 'slug' => 'calcados', 'sort_order' => 1, 'active' => true,
        ]);

        $cols = [];
        foreach (['BRA', 'USW', 'USM', 'Comprimento do pé (cm)'] as $i => $name) {
            $cols[$name] = MeasureColumn::create([
                'measure_category_id' => $calcados->id,
                'name' => $name, 'sort_order' => $i + 1, 'active' => true,
            ]);
        }

        // Calçados Adultos
        $adultos = MeasureTable::create([
            'measure_category_id' => $calcados->id,
            'name' => 'Calçados Adultos', 'sort_order' => 1, 'active' => true,
        ]);

        $adultosData = [
            ['24', '', '', '24'],
            ['25', '', '', '25'],
            ['26', '', '', '26'],
            ['27', '', '', '27'],
            ['28', '', '1', '28'],
            ['29', 'W 3.5', '2', '29'],
            ['30', 'W 4', '2.5', '30'],
            ['31', 'W 4.5', '3', '31'],
            ['32', 'W 5', '3.5', '32'],
            ['33', 'W6', '4.5', '33'],
            ['34', 'W 6.5', '5', '34'],
            ['35', 'W 7', '5.5', '35'],
            ['36', 'W 7.5', '6', '36'],
            ['37', 'W 8', '6.5', '37'],
            ['38', 'W 8.5', '7', '38'],
            ['39', 'W 9', '7.5', '39'],
            ['39,5', '-', '8', '39,5'],
            ['40', 'W 10', '8.5', '40'],
            ['40,5', 'W 10.5', '9', '40,5'],
            ['41', 'W 11', '9.5', '41'],
            ['42', 'W 11.5', '10', '42'],
            ['42,5', 'W 12', '10.5', '42,5'],
            ['43', '', '11', '43'],
            ['43,5', '', '11.5', '43,5'],
            ['44', '', '12', '44'],
            ['45', '', '13', '45'],
            ['46', '', '14', '46'],
            ['47', '', '15', '47'],
            ['48', '', '16', '48'],
        ];

        $colIds = array_values(array_map(fn($c) => $c->id, $cols));
        foreach ($adultosData as $i => $values) {
            $row = MeasureRow::create([
                'measure_table_id' => $adultos->id,
                'label' => $values[0], 'sort_order' => $i + 1,
            ]);
            foreach ($values as $j => $val) {
                if ($val !== '') {
                    MeasureCell::create([
                        'measure_row_id'    => $row->id,
                        'measure_column_id' => $colIds[$j],
                        'value'             => $val,
                    ]);
                }
            }
        }

        // Calçados Infantil
        $infantil = MeasureTable::create([
            'measure_category_id' => $calcados->id,
            'name' => 'Calçados Infantil', 'sort_order' => 2, 'active' => true,
        ]);

        $infantilData = [
            ['24', '', '', '24'], ['25', '', '', '25'], ['26', '', '', '26'],
            ['27', '', '', '27'], ['28', '', '1', '28'],
            ['29', 'W 3.5', '2', '29'], ['30', 'W 4', '2.5', '30'],
            ['31', 'W 4.5', '3', '31'], ['32', 'W 5', '3.5', '32'],
            ['33', 'W6', '4.5', '33'], ['34', 'W 6.5', '5', '34'],
            ['35', 'W 7', '5.5', '35'], ['36', 'W 7.5', '6', '36'],
            ['37', 'W 8', '6.5', '37'],
        ];

        foreach ($infantilData as $i => $values) {
            $row = MeasureRow::create([
                'measure_table_id' => $infantil->id,
                'label' => $values[0], 'sort_order' => $i + 1,
            ]);
            foreach ($values as $j => $val) {
                if ($val !== '') {
                    MeasureCell::create([
                        'measure_row_id'    => $row->id,
                        'measure_column_id' => $colIds[$j],
                        'value'             => $val,
                    ]);
                }
            }
        }

        // ── VESTUÁRIO E ACESSÓRIOS ──────────────────────────────────────────
        $vestuario = MeasureCategory::create([
            'name' => 'Vestuário e Acessórios', 'slug' => 'vestuario-e-acessorios',
            'sort_order' => 2, 'active' => true,
        ]);

        $vCols = [];
        foreach (['BRA', 'Peito', 'Cintura', 'Quadril'] as $i => $name) {
            $vCols[$name] = MeasureColumn::create([
                'measure_category_id' => $vestuario->id,
                'name' => $name, 'sort_order' => $i + 1, 'active' => true,
            ]);
        }

        $vColIds = array_values(array_map(fn($c) => $c->id, $vCols));
        $sizes   = [['PP', '87 - 92', '72 - 77', '87 - 92'], ['P', '87 - 92', '72 - 77', '87 - 92'],
                    ['M', '87 - 92', '72 - 77', '87 - 92'], ['G', '87 - 92', '72 - 77', '87 - 92'],
                    ['GG', '87 - 92', '72 - 77', '87 - 92']];

        $tables = [
            ['Camisetas e Jaquetas Masculino', 1],
            ['Camisetas e Jaquetas Feminino', 2],
            ['Calças e Shorts Masculino', 3],
        ];

        foreach ($tables as [$tableName, $order]) {
            $table = MeasureTable::create([
                'measure_category_id' => $vestuario->id,
                'name' => $tableName, 'sort_order' => $order, 'active' => true,
            ]);

            foreach ($sizes as $i => $values) {
                $row = MeasureRow::create([
                    'measure_table_id' => $table->id,
                    'label' => $values[0], 'sort_order' => $i + 1,
                ]);
                foreach ($values as $j => $val) {
                    MeasureCell::create([
                        'measure_row_id'    => $row->id,
                        'measure_column_id' => $vColIds[$j],
                        'value'             => $val,
                    ]);
                }
            }
        }
    }
}
