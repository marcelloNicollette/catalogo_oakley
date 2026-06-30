<?php

namespace Database\Seeders;

use App\Models\ShoeGrid;
use App\Models\ShoeGridGroup;
use App\Models\ShoeGridItem;
use App\Models\ShoeSize;
use Illuminate\Database\Seeder;

class ShoeGridSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Tamanhos (colunas) ─────────────────────────────────────────
        // [sort_order => [bra, usw, usm]]
        $sizesData = [
            ['bra' => 24,   'usw' => null,      'usm' => null],
            ['bra' => 25,   'usw' => null,      'usm' => null],
            ['bra' => 26,   'usw' => null,      'usm' => null],
            ['bra' => 27,   'usw' => null,      'usm' => null],
            ['bra' => 28,   'usw' => null,      'usm' => '1'],
            ['bra' => 29,   'usw' => 'W 3.5',   'usm' => '2'],
            ['bra' => 30,   'usw' => 'W 4',     'usm' => '2.5'],
            ['bra' => 31,   'usw' => 'W 4.5',   'usm' => '3'],
            ['bra' => 32,   'usw' => 'W 5',     'usm' => '3.5'],
            ['bra' => 33,   'usw' => 'W 6',     'usm' => '4.5'],
            ['bra' => 34,   'usw' => 'W 6.5',   'usm' => '5'],
            ['bra' => 35,   'usw' => 'W 7',     'usm' => '5.5'],
            ['bra' => 36,   'usw' => 'W 7.5',   'usm' => '6'],
            ['bra' => 37,   'usw' => 'W 8',     'usm' => '6.5'],
            ['bra' => 38,   'usw' => 'W 8.5',   'usm' => '7'],
            ['bra' => 39,   'usw' => 'W 9',     'usm' => '7.5'],
            ['bra' => 39.5, 'usw' => '-',       'usm' => '8'],
            ['bra' => 40,   'usw' => 'W 10',    'usm' => '8.5'],
            ['bra' => 40.5, 'usw' => 'W 10.5',  'usm' => '9'],
            ['bra' => 41,   'usw' => 'W 11',    'usm' => '9.5'],
            ['bra' => 42,   'usw' => 'W 11.5',  'usm' => '10'],
            ['bra' => 42.5, 'usw' => 'W 12',    'usm' => '10.5'],
        ];

        $sizeMap = []; // bra => id
        foreach ($sizesData as $i => $s) {
            $size = ShoeSize::create([...$s, 'sort_order' => $i + 1, 'active' => true]);
            $sizeMap[(string) $s['bra']] = $size->id;
        }

        // ── 2. Grupos e grades ────────────────────────────────────────────
        // Estrutura: grupo => [ grade => [bra => qty] ]
        $structure = [
            'Kids' => [
                'I24A' => [24=>1, 25=>1, 26=>2, 27=>2, 28=>3, 29=>3],
                'I30A' => [30=>1, 31=>2, 32=>3, 33=>3, 34=>3],
                'I30B' => [30=>1, 31=>1, 32=>1, 33=>2, 34=>2, 35=>3, 36=>3],
                'I31B' => [31=>1, 32=>1, 33=>2, 34=>2, 35=>3, 36=>3],
            ],
            'Feminino' => [
                'F34A' => [34=>1, 35=>1, 36=>2, 37=>2, 38=>3, 39=>3],
                'F35A' => [35=>1, 36=>2, 37=>2, 38=>3, 39=>3, 40=>1],
                'F35B' => [38=>1, 39=>1, 40=>2, 40.5=>2, 41=>3, 42=>3],
            ],
            'Masculino' => [
                'M38A' => [39=>1, 39.5=>1, 40=>2, 40.5=>2, 41=>3, 42.5=>3],
                'M39A' => [39.5=>1, 40=>1, 40.5=>2, 41=>2, 42=>3, 42.5=>3],
                'M39B' => [40.5=>1, 41=>1, 40=>2, 42.5=>2],
                'M43B' => [40.5=>1, 41=>1],
                'M45B' => [41=>1, 42=>1, 42.5=>2],
            ],
            'Enerzy' => [
                'M05Z' => [39.5=>1, 41=>1, 42=>2],
                'M38C' => [41=>1, 42=>1, 42.5=>2],
                'M39D' => [37=>1, 38=>1, 39=>2, 40=>2, 41=>3, 42.5=>3],
            ],
        ];

        foreach ($structure as $groupName => $grids) {
            $group = ShoeGridGroup::create([
                'name'       => $groupName,
                'slug'       => \Illuminate\Support\Str::slug($groupName),
                'sort_order' => array_search($groupName, array_keys($structure)) + 1,
                'active'     => true,
            ]);

            $gridOrder = 1;
            foreach ($grids as $code => $quantities) {
                $grid = ShoeGrid::create([
                    'shoe_size_group_id' => $group->id,
                    'code'               => $code,
                    'sort_order'         => $gridOrder++,
                    'active'             => true,
                ]);

                foreach ($quantities as $bra => $qty) {
                    $sizeId = $sizeMap[(string) $bra] ?? null;
                    if ($sizeId && $qty > 0) {
                        ShoeGridItem::create([
                            'shoe_grid_id' => $grid->id,
                            'shoe_size_id' => $sizeId,
                            'quantity'     => $qty,
                        ]);
                    }
                }
            }
        }
    }
}
