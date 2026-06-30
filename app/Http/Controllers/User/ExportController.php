<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Color;
use App\Models\ExportUser;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelWriter;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ExportController extends Controller
{
    private function buildSelectedProductMeta(array $produtosSelecionados): array
    {
        $meta = [];

        foreach ($produtosSelecionados as $selection) {
            if (!is_array($selection)) {
                continue;
            }

            $productId = $selection['id'] ?? null;
            $colorCode = $selection['color_code'] ?? null;
            if ($productId === null || !$colorCode) {
                continue;
            }

            $gradeRows = is_array($selection['grade_rows'] ?? null) ? $selection['grade_rows'] : [];
            $normalizedRows = [];

            foreach ($gradeRows as $row) {
                if (!is_array($row)) {
                    continue;
                }

                $monthlyQuantities = [];
                if (is_array($row['monthly_quantities'] ?? null)) {
                    foreach ($row['monthly_quantities'] as $monthCode => $monthQty) {
                        $monthlyQuantities[(string) $monthCode] = max(0, min(15, (int) $monthQty));
                    }
                }

                $normalizedRows[] = [
                    'shoe_grid_id' => isset($row['shoe_grid_id']) ? (string) $row['shoe_grid_id'] : '',
                    'grade_code' => isset($row['grade_code']) ? trim((string) $row['grade_code']) : '',
                    'quantity' => max(0, min(15, (int) ($row['quantity'] ?? 0))),
                    'monthly_quantities' => $monthlyQuantities,
                ];
            }

            $meta[$productId . '-' . $colorCode] = [
                'grade_rows' => $normalizedRows,
            ];
        }

        return $meta;
    }

    private function getPedidoMonthColumns(): array
    {
        $labels = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];
        $cutoffDate = now()->startOfMonth()->addMonths(6);
        $cutoffMonth = (int) $cutoffDate->format('n');
        $semesterStartMonth = $cutoffMonth <= 6 ? 1 : 7;
        $start = $cutoffDate->copy()->setMonth($semesterStartMonth)->startOfMonth();
        $columns = [];

        for ($index = 0; $index < 6; $index++) {
            $date = $start->copy()->addMonths($index);
            $columns[] = [
                'code' => $date->format('Y-m'),
                'label' => $labels[((int) $date->format('n')) - 1] . '/' . $date->format('y'),
            ];
        }

        return $columns;
    }

    private function appendPlanilhaRows(
        array &$rows,
        array &$imagePaths,
        $color,
        array $opcoes,
        array $gradeRows = [],
        array $monthColumns = []
    ): void {
        $normalizedGradeRows = !empty($gradeRows) ? $gradeRows : [[
            'grade_code' => '',
            'quantity' => '',
            'monthly_quantities' => [],
        ]];
        $positiveGradeRows = array_values(array_filter($normalizedGradeRows, function ($gradeRow) {
            return isset($gradeRow['quantity']) && (int) $gradeRow['quantity'] > 0;
        }));

        if (!empty($positiveGradeRows)) {
            $normalizedGradeRows = $positiveGradeRows;
        } else {
            $normalizedGradeRows = [[
                'grade_code' => '',
                'quantity' => '',
                'monthly_quantities' => [],
            ]];
        }

        $imgRel = 'images/produtos/' . ($color->product->code ?? '') . '_' . str_replace('/', '_', ($color->color_code ?? '')) . '_A.jpg';
        $imgPath = public_path($imgRel);
        if (!file_exists($imgPath)) {
            $imgPath = public_path('images/img-padrao-mz.png');
        }

        foreach ($normalizedGradeRows as $gradeRow) {
            $row = [];
            $row[] = '';
            $row[] = $color->collection->codigo_colecao ?? ($color->collection->name ?? '');
            $row[] = optional($color->product->category)->name ?? '';
            if (!in_array('remover_codigo', $opcoes)) {
                $row[] = $color->product->code ?? '';
            }
            $row[] = $color->product->name ?? '';
            $row[] = $color->color_code ?? '';
            $row[] = $color->color_description ?? '';
            $row[] = $color->genero ?? '';
            $row[] = (string) ($gradeRow['grade_code'] ?? '');
            $row[] = (string) ($gradeRow['quantity'] ?? '');
            $monthlyQuantities = is_array($gradeRow['monthly_quantities'] ?? null) ? $gradeRow['monthly_quantities'] : [];
            foreach ($monthColumns as $monthColumn) {
                $monthCode = $monthColumn['code'] ?? '';
                $monthValue = $monthCode !== '' ? ($monthlyQuantities[$monthCode] ?? '') : '';
                $row[] = (string) $monthValue;
            }
            if (!in_array('remover_preco', $opcoes)) {
                $row[] = $this->formatPriceForPlanilha($color->product->price ?? null);
            }
            // Coluna de descrição temporariamente oculta na planilha.
            // if (!in_array('remover_descricao', $opcoes)) {
            //     $row[] = $color->product->description ?? '';
            // }

            $rows[] = $row;
            $imagePaths[] = $imgPath;
        }
    }

    private function formatPriceForPlanilha($price): string
    {
        if ($price === null || $price === '') {
            return '';
        }

        return number_format((float) $price, 2, ',', '.');
    }

    public function exportPdf(Request $request)
    {
        if ($request->user() && $request->user()->idioma) {
            App::setLocale($request->user()->idioma);
        }

        ini_set('memory_limit', '3072M'); // ou '3072M' se necessário
        ini_set('max_execution_time', '300'); // 5 minutos
        set_time_limit(300);
        //dd($request->all());
        // Verificar se produtos específicos foram selecionados
        $produtosSelecionados = $request->input('produtos_selecionados', []);
        $tipoProdutos = $request->input('produtos', 'todos');

        $query = Color::where('collection_id', $request->collection_id)
            ->with(['product', 'product.caracteristicas', 'product.caracteristicasDestaque', 'product.category', 'product.numeracoes', 'product.links',  'flagProduct', 'collection'])->orderBy('product_id', 'ASC');

        // Se produtos específicos foram selecionados, filtrar por eles
        if ($tipoProdutos === 'selecao' && !empty($produtosSelecionados)) {
            // Compatibilidade: pode ser um array de IDs ou um array de objetos {id, cor}
            $first = is_array($produtosSelecionados) ? reset($produtosSelecionados) : null;
            $isAssociativeSelection = is_array($first);

            if ($isAssociativeSelection && isset($first['id'])) {
                // Filtrar por par (product_id, cor). Preferir color_code se fornecido; caso contrário, color_name
                $query->where(function ($q) use ($produtosSelecionados) {
                    foreach ($produtosSelecionados as $sel) {
                        $productId = $sel['id'] ?? null;
                        $colorName = $sel['cor'] ?? ($sel['color_name'] ?? null);
                        $colorCode = $sel['color_code'] ?? null;

                        $q->orWhere(function ($q2) use ($productId, $colorName, $colorCode) {
                            if ($productId !== null) {
                                $q2->where('product_id', $productId);
                            }
                            if ($colorCode) {
                                $q2->where('color_code', $colorCode);
                            } elseif ($colorName) {
                                $q2->where('color_name', $colorName);
                            }
                        });
                    }
                });
            } else {
                // Tratar como array de IDs simples
                $ids = array_map('intval', (array) $produtosSelecionados);
                $query->whereIn('product_id', $ids);
            }
        }

        $produtos = $query->get()->sortBy(function ($item) {
            return optional($item->product->category)->name ?? '';
        });

        // Tradução dinâmica se o idioma não for PT
        $userLocale = $request->user()->idioma ?? 'pt';
        if ($userLocale !== 'pt') {
            try {
                $tr = new \Stichoza\GoogleTranslate\GoogleTranslate();
                $tr->setSource('pt');
                $tr->setTarget($userLocale);

                // Cache local para evitar requisições repetidas
                $translationsCache = [];

                $translate = function ($text) use ($tr, &$translationsCache) {
                    if (empty($text)) return $text;
                    $text = trim($text);
                    if (empty($text)) return $text;

                    $hash = md5($text);
                    if (isset($translationsCache[$hash])) {
                        return $translationsCache[$hash];
                    }

                    try {
                        $translated = $tr->translate($text);
                        $translationsCache[$hash] = $translated;
                        return $translated;
                    } catch (\Exception $e) {
                        return $text;
                    }
                };
                //dd($produtos->first()->product);
                foreach ($produtos as $collection) {
                    // Traduzir Categoria
                    if ($collection->product && $collection->product->category) {
                        $collection->product->category->name = $translate($collection->product->category->name);
                    }

                    if ($collection->product && $collection->product->description) {
                        $collection->product->description = $translate($collection->product->description);
                    }

                    // Traduzir Cor
                    if ($collection->color_name) {
                        $collection->color_name = $translate($collection->color_name);
                    }
                    if ($collection->color_description) {
                        $collection->color_description = $translate($collection->color_description);
                    }

                    // Traduzir Flag
                    if ($collection->flagProduct) {
                        $collection->flagProduct->flag_title = $translate($collection->flagProduct->flag_title);
                    }

                    // Traduzir Características Destaque
                    if ($collection->product->caracteristicasDestaque) {
                        foreach ($collection->product->caracteristicasDestaque as $caracteristica) {
                            $caracteristica->title = $translate($caracteristica->title);
                            $caracteristica->description = $translate($caracteristica->description);
                        }
                    }

                    // Traduzir Características
                    if ($collection->product->caracteristicas) {
                        foreach ($collection->product->caracteristicas as $caracteristica) {
                            $caracteristica->title = $translate($caracteristica->title);
                            $caracteristica->description = $translate($caracteristica->description);
                        }
                    }

                    // Traduzir Numerações (se contiver texto)
                    if ($collection->product->numeracoes) {
                        foreach ($collection->product->numeracoes as $numeracao) {
                            if (preg_match('/[a-zA-Z]/', $numeracao->numero)) {
                                $numeracao->numero = $translate($numeracao->numero);
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Erro na tradução PDF: ' . $e->getMessage());
            }
        }
        //dd($produtos);
        $opcoes = $request->input('opcoes', []);
        $grupo_opcoes = array_push($opcoes, $request->input('grupo_opcoes', []));

        $svgPath = public_path('/images/Oakley_logo_branco.svg');
        $svgContent = file_get_contents($svgPath);
        $base64Svg_preto = 'data:image/svg+xml;base64,' . base64_encode($svgContent);

        $svgPath_azul = public_path('/images/Oakley_logo.svg');
        $svgContent_azul = file_get_contents($svgPath_azul);
        $base64Svg_azul = 'data:image/svg+xml;base64,' . base64_encode($svgContent_azul);

        $data = [
            'collections' => $produtos,
            'remove_price'       => in_array('remover_preco', $opcoes),
            'remove_code'        => in_array('remover_codigo', $opcoes),
            'remove_description' => in_array('remover_descricao', $opcoes),
            'remove_tag'         => in_array('remover_tag', $opcoes),
            'remove_capa_retranca' => in_array('remover_capa_retranca', $opcoes),
            'image' => public_path('images/Oakley_logo.svg'),
            'name' => $request->user()->name,
            'request' => $request,
            'isPdf' => true,
            'base64Svg_preto' => $base64Svg_preto,
            'base64Svg_azul' => $base64Svg_azul,
        ];

        if (in_array('separado', $opcoes)) {
            $view = $request->formato === '16_9' ? 'exports.collection.16-9' : 'exports.collection.a4';
        } else {
            $view = $request->formato === '16_9' ? 'exports.collection.16-9-group' : 'exports.collection.a4-group';
        }

        if ($request->formato === 'planilha') {
            $monthColumns = $this->getPedidoMonthColumns();
            $headings = ['Imagem', 'Coleção', 'Categoria'];
            if (!in_array('remover_codigo', $opcoes)) {
                $headings[] = 'Código';
            }
            $headings[] = 'Produto';
            $headings[] = 'Cor código';
            $headings[] = 'Cor';
            $headings[] = 'Gênero';
            $headings[] = 'Grade';
            $headings[] = 'Qtd';
            foreach ($monthColumns as $monthColumn) {
                $headings[] = $monthColumn['label'] ?? '';
            }
            if (!in_array('remover_preco', $opcoes)) {
                $headings[] = 'Preço';
            }
            // Coluna de descrição temporariamente oculta na planilha.
            // if (!in_array('remover_descricao', $opcoes)) {
            //     $headings[] = 'Descrição';
            // }
            // }

            $rows = [];
            $imagePaths = [];
            $selectedMeta = $this->buildSelectedProductMeta((array) $produtosSelecionados);
            $produtosByKey = $produtos->keyBy(function ($color) {
                return ($color->product_id ?? '') . '-' . ($color->color_code ?? '');
            });

            if ($tipoProdutos === 'selecao' && !empty($selectedMeta)) {
                foreach ($selectedMeta as $selectionKey => $selectionMeta) {
                    $color = $produtosByKey->get($selectionKey);
                    if (!$color) {
                        continue;
                    }

                    $gradeRows = is_array($selectionMeta['grade_rows'] ?? null) ? $selectionMeta['grade_rows'] : [];
                    $this->appendPlanilhaRows($rows, $imagePaths, $color, $opcoes, $gradeRows, $monthColumns);
                }
            } else {
                foreach ($produtos as $color) {
                    $selectionKey = ($color->product_id ?? '') . '-' . ($color->color_code ?? '');
                    $selectionMeta = $selectedMeta[$selectionKey] ?? [];
                    $gradeRows = is_array($selectionMeta['grade_rows'] ?? null) ? $selectionMeta['grade_rows'] : [];
                    $this->appendPlanilhaRows($rows, $imagePaths, $color, $opcoes, $gradeRows, $monthColumns);
                }
            }

            $export = new class($rows, $headings, $imagePaths) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, WithDrawings, WithColumnWidths, WithEvents {
                private $rows;
                private $headings;
                private $imagePaths;
                public function __construct(array $rows, array $headings, array $imagePaths)
                {
                    $this->rows = $rows;
                    $this->headings = $headings;
                    $this->imagePaths = $imagePaths;
                }
                public function array(): array
                {
                    return $this->rows;
                }
                public function headings(): array
                {
                    return $this->headings;
                }
                public function drawings(): array
                {
                    $drawings = [];
                    $rowIndex = 2; // start after headings
                    foreach ($this->imagePaths as $path) {
                        if ($path && file_exists($path)) {
                            $drawing = new Drawing();
                            $drawing->setName('Imagem Produto');
                            $drawing->setDescription('Imagem do produto');
                            $drawing->setPath($path);
                            $drawing->setHeight(60);
                            $drawing->setCoordinates('A' . $rowIndex);
                            $drawings[] = $drawing;
                        }
                        $rowIndex++;
                    }
                    return $drawings;
                }
                public function columnWidths(): array
                {
                    return [
                        'A' => 18,
                    ];
                }
                public function registerEvents(): array
                {
                    return [
                        AfterSheet::class => function (AfterSheet $event) {
                            $rowCount = count($this->rows) + 1; // include heading
                            for ($r = 2; $r <= $rowCount; $r++) {
                                $event->sheet->getRowDimension($r)->setRowHeight(46);
                            }
                        }
                    ];
                }
            };

            $filename = $request->collectionHistoryName . '.xlsx';

            ExportUser::create([
                'user_id' => $request->user()->id,
                'collection_id' => $request->collection_id,
                'collection_history_name' => $request->collectionHistoryName,
                'formato' => $request->formato ?? 'a4',
                'produtos' => $tipoProdutos,
                'produtos_selecionados' => $produtosSelecionados,
                'opcoes' => $opcoes,
                'remove_price' => in_array('remover_preco', $opcoes),
                'remove_code' => in_array('remover_codigo', $opcoes),
                'remove_description' => in_array('remover_descricao', $opcoes),
                'remove_tag' => in_array('remover_tag', $opcoes),
                'remove_capa_retranca' => in_array('remover_capa_retranca', $opcoes),
                'filename' => $filename,
            ]);

            return Excel::download($export, $filename, ExcelWriter::XLSX);
        }


        $customPaper = [0, 0, 810, 1440];

        if ($request->formato === '16_9') {
            $pdf = PDF::loadView($view, $data);
            $pdf->setPaper($customPaper, 'landscape');
            $pdf->setOption(['dpi' => 120]);
        } else {
            $pdf = PDF::loadView($view, $data)
                ->setPaper('A4', 'landscape');
            $pdf->setOption(['dpi' => 120]);
        }

        $filename = $request->collectionHistoryName . '.pdf';

        // Registrar dados de exportação
        ExportUser::create([
            'user_id' => $request->user()->id,
            'collection_id' => $request->collection_id,
            'collection_history_name' => $request->collectionHistoryName,
            'formato' => $request->formato ?? 'a4',
            'produtos' => $tipoProdutos,
            'produtos_selecionados' => $produtosSelecionados,
            'opcoes' => $opcoes,
            'remove_price' => in_array('remover_preco', $opcoes),
            'remove_code' => in_array('remover_codigo', $opcoes),
            'remove_description' => in_array('remover_descricao', $opcoes),
            'remove_tag' => in_array('remover_tag', $opcoes),
            'remove_capa_retranca' => in_array('remover_capa_retranca', $opcoes),
            'filename' => $filename,
        ]);

        return $pdf->download($filename);
    }

    public function exportPedidoPdf(Request $request)
    {
        if ($request->user() && $request->user()->idioma) {
            App::setLocale($request->user()->idioma);
        }

        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '120');
        set_time_limit(120);

        $produtosSelecionados = $request->input('produtos_selecionados', []);
        $tipoProdutos = $request->input('produtos', 'selecao');

        $query = Color::where('collection_id', $request->collection_id)
            ->with(['product', 'product.category', 'numeracao', 'collection'])
            ->orderBy('product_id', 'ASC');

        if ($tipoProdutos === 'selecao' && !empty($produtosSelecionados)) {
            $first = is_array($produtosSelecionados) ? reset($produtosSelecionados) : null;
            $isAssociativeSelection = is_array($first);

            if ($isAssociativeSelection && isset($first['id'])) {
                $query->where(function ($q) use ($produtosSelecionados) {
                    foreach ($produtosSelecionados as $sel) {
                        $productId = $sel['id'] ?? null;
                        $colorCode = $sel['color_code'] ?? null;

                        $q->orWhere(function ($q2) use ($productId, $colorCode) {
                            if ($productId !== null) {
                                $q2->where('product_id', $productId);
                            }
                            if ($colorCode) {
                                $q2->where('color_code', $colorCode);
                            }
                        });
                    }
                });
            } else {
                $ids = array_map('intval', (array) $produtosSelecionados);
                $query->whereIn('product_id', $ids);
            }
        }

        $items = $query->get();

        if (!empty($produtosSelecionados)) {
            $orderMap = [];
            foreach ($produtosSelecionados as $idx => $sel) {
                $id = $sel['id'] ?? null;
                $code = $sel['color_code'] ?? null;
                if ($id && $code) {
                    $orderMap["{$id}-{$code}"] = $idx;
                }
            }
            if (!empty($orderMap)) {
                $items = $items->sortBy(function ($color) use ($orderMap) {
                    $key = ($color->product_id ?? '') . '-' . ($color->color_code ?? '');
                    return $orderMap[$key] ?? 999999;
                })->values();
            }
        }

        // Garante 1 linha por produto/cor no PDF do pedido.
        $items = $items
            ->unique(function ($color) {
                return ($color->product_id ?? '') . '-' . ($color->color_code ?? '');
            })
            ->values();

        $svgPathAzul = public_path('/images/Oakley_logo.svg');
        $svgContentAzul = file_exists($svgPathAzul) ? file_get_contents($svgPathAzul) : '';
        $base64SvgAzul = $svgContentAzul ? 'data:image/svg+xml;base64,' . base64_encode($svgContentAzul) : null;

        $pedidoTitle = trim((string) $request->input('pedidoTitle', ''));
        if ($pedidoTitle === '') {
            $pedidoTitle = trim((string) $request->input('collectionHistoryName', ''));
        }
        if ($pedidoTitle === '') {
            $pedidoTitle = 'Pedido';
        }

        $headings = ['Imagem', 'Produto', 'Categoria', 'Gênero', 'Código', 'Cor', 'Preço'];

        $data = [
            'items' => $items,
            'pedidoTitle' => $pedidoTitle,
            'headings' => $headings,
            'selectedMeta' => $this->buildSelectedProductMeta((array) $produtosSelecionados),
            'monthColumns' => $this->getPedidoMonthColumns(),
            'isPdf' => true,
            'base64Svg_azul' => $base64SvgAzul,
        ];

        $pdf = PDF::loadView('exports.pedido.a4', $data)
            ->setPaper('A4', 'portrait');
        $pdf->setOption(['dpi' => 120]);

        $filename = preg_replace('#[\\\\/:*?"<>|]+#u', '-', $pedidoTitle);
        $filename = trim(preg_replace('/\s+/u', ' ', $filename));
        if ($filename === '') {
            $filename = 'Pedido';
        }

        return $pdf->download($filename . '.pdf');
    }

    /**
     * Listar histórico de exportações do usuário
     */
    public function index(Request $request)
    {
        $exports = ExportUser::with(['collection'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.exports.index', compact('exports'));
    }

    /**
     * Exibir detalhes de uma exportação específica
     */
    public function show(Request $request, ExportUser $exportUser)
    {
        // Verificar se o usuário tem permissão para ver esta exportação
        if ($exportUser->user_id !== $request->user()->id) {
            abort(403, 'Acesso negado.');
        }

        return view('user.exports.show', compact('exportUser'));
    }

    /**
     * Regenerar PDF baseado nos dados salvos do ExportUser
     */
    public function regeneratePdf(Request $request, ExportUser $exportUser)
    {
        // Verificar se o usuário tem permissão para acessar esta exportação
        if ($exportUser->user_id !== $request->user()->id) {
            abort(403, 'Acesso negado.');
        }

        ini_set('memory_limit', '512M');

        // Recuperar dados salvos do ExportUser
        $produtosSelecionados = $exportUser->produtos_selecionados ?? [];
        $tipoProdutos = $exportUser->produtos;

        $query = Color::where('collection_id', $exportUser->collection_id)
            ->with(['product', 'product.caracteristicas', 'product.caracteristicasDestaque', 'product.category', 'flagProduct', 'collection']);

        // Se produtos específicos foram selecionados, filtrar por eles
        if ($tipoProdutos === 'selecao' && !empty($produtosSelecionados)) {
            $first = is_array($produtosSelecionados) ? reset($produtosSelecionados) : null;
            $isAssociativeSelection = is_array($first);

            if ($isAssociativeSelection && isset($first['id'])) {
                $query->where(function ($q) use ($produtosSelecionados) {
                    foreach ($produtosSelecionados as $sel) {
                        $productId = $sel['id'] ?? null;
                        $colorName = $sel['cor'] ?? ($sel['color_name'] ?? null);
                        $colorCode = $sel['color_code'] ?? null;

                        $q->orWhere(function ($q2) use ($productId, $colorName, $colorCode) {
                            if ($productId !== null) {
                                $q2->where('product_id', $productId);
                            }
                            if ($colorCode) {
                                $q2->where('color_code', $colorCode);
                            } elseif ($colorName) {
                                $q2->where('color_name', $colorName);
                            }
                        });
                    }
                });
            } else {
                $ids = array_map('intval', (array) $produtosSelecionados);
                $query->whereIn('product_id', $ids);
            }
        }

        $produtos = $query->get()->groupBy('product_id');
        $opcoes = $exportUser->opcoes ?? [];

        $merged = $produtos->collapse();

        $svgPath = public_path('/images/Oakley_logo.svg');
        $svgContent = file_get_contents($svgPath);
        $base64Svg = 'data:image/svg+xml;base64,' . base64_encode($svgContent);

        $svgPath_azul = public_path('/images/Oakley_logo.svg');
        $svgContent_azul = file_get_contents($svgPath_azul);
        $base64Svg_azul = 'data:image/svg+xml;base64,' . base64_encode($svgContent_azul);

        $data = [
            'collections' => $merged,
            'remove_price'       => $exportUser->remove_price,
            'remove_code'        => $exportUser->remove_code,
            'remove_description' => $exportUser->remove_description,
            'remove_tag'         => $exportUser->remove_tag,
            'remove_capa_retranca' => $exportUser->remove_capa_retranca,
            'image' => public_path('images/tenis-1.jpg'),
            'name' => $exportUser->user->name,
            'request' => (object) [
                'collection_id' => $exportUser->collection_id,
                'formato' => $exportUser->formato,
                'collectionHistoryName' => $exportUser->collection_history_name
            ],
            'base64Svg' => $base64Svg,
            'base64Svg_azul' => $base64Svg_azul,
        ];


        if (in_array('separado', $opcoes)) {
            $view = $exportUser->formato === '16_9' ? 'exports.collection.16-9' : 'exports.collection.a4';
        } else {
            $view = $exportUser->formato === '16_9' ? 'exports.collection.16-9-group' : 'exports.collection.a4-group';
        }

        if ($exportUser->formato === 'planilha') {
            $monthColumns = $this->getPedidoMonthColumns();

            $headings = ['Imagem', 'Coleção', 'Categoria'];
            if (!in_array('remover_codigo', $opcoes)) {
                $headings[] = 'Código';
            }
            $headings[] = 'Produto';
            $headings[] = 'Cor código';
            $headings[] = 'Cor';
            $headings[] = 'Gênero';
            $headings[] = 'Grade';
            $headings[] = 'Qtd';
            foreach ($monthColumns as $monthColumn) {
                $headings[] = $monthColumn['label'] ?? '';
            }
            if (!in_array('remover_preco', $opcoes)) {
                $headings[] = 'Preço';
            }
            // Coluna de descrição temporariamente oculta na planilha.
            // if (!in_array('remover_descricao', $opcoes)) {
            //     $headings[] = 'Descrição';
            // }

            $rows = [];
            $imagePaths = [];
            $selectedMeta = $this->buildSelectedProductMeta((array) $produtosSelecionados);
            $mergedByKey = $merged->keyBy(function ($item) {
                return ($item->product_id ?? '') . '-' . ($item->color_code ?? '');
            });

            if (!empty($selectedMeta)) {
                foreach ($selectedMeta as $selectionKey => $selectionMeta) {
                    $item = $mergedByKey->get($selectionKey);
                    if (!$item) {
                        continue;
                    }

                    $gradeRows = is_array($selectionMeta['grade_rows'] ?? null) ? $selectionMeta['grade_rows'] : [];
                    $this->appendPlanilhaRows($rows, $imagePaths, $item, $opcoes, $gradeRows, $monthColumns);
                }
            } else {
                foreach ($merged as $item) {
                    $this->appendPlanilhaRows($rows, $imagePaths, $item, $opcoes, [], $monthColumns);
                }
            }

            $export = new class($rows, $headings, $imagePaths) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, WithDrawings, WithColumnWidths, WithEvents {
                private $rows;
                private $headings;
                private $imagePaths;
                public function __construct(array $rows, array $headings, array $imagePaths)
                {
                    $this->rows = $rows;
                    $this->headings = $headings;
                    $this->imagePaths = $imagePaths;
                }
                public function array(): array
                {
                    return $this->rows;
                }
                public function headings(): array
                {
                    return $this->headings;
                }
                public function drawings(): array
                {
                    $drawings = [];
                    $rowIndex = 2; // start after headings
                    foreach ($this->imagePaths as $path) {
                        if ($path && file_exists($path)) {
                            $drawing = new Drawing();
                            $drawing->setName('Imagem Produto');
                            $drawing->setDescription('Imagem do produto');
                            $drawing->setPath($path);
                            $drawing->setHeight(60);
                            $drawing->setCoordinates('A' . $rowIndex);
                            $drawings[] = $drawing;
                        }
                        $rowIndex++;
                    }
                    return $drawings;
                }
                public function columnWidths(): array
                {
                    return [
                        'A' => 18,
                    ];
                }
                public function registerEvents(): array
                {
                    return [
                        AfterSheet::class => function (AfterSheet $event) {
                            $rowCount = count($this->rows) + 1; // include heading
                            for ($r = 2; $r <= $rowCount; $r++) {
                                $event->sheet->getRowDimension($r)->setRowHeight(46);
                            }
                        }
                    ];
                }
            };

            $filename = $exportUser->collection_history_name . '.xlsx';

            return Excel::download($export, $filename, ExcelWriter::XLSX);
        }


        $customPaper = [0, 0, 810, 1440];

        if ($exportUser->formato === '16_9') {
            $pdf = PDF::loadView($view, $data);
            $pdf->setPaper($customPaper, 'landscape');
            $pdf->setOption(['dpi' => 120]);
        } else {
            $pdf = PDF::loadView($view, $data)
                ->setPaper('A4', 'landscape');
            $pdf->setOption(['dpi' => 120]);
        }

        $filename = $exportUser->filename;

        return $pdf->download($filename);
    }

    /**
     * Deletar um registro de exportação
     */
    public function destroy(Request $request, ExportUser $exportUser)
    {
        // Verificar se o usuário tem permissão para deletar esta exportação
        if ($exportUser->user_id !== $request->user()->id) {
            abort(403, 'Acesso negado.');
        }

        $exportUser->delete();

        return redirect()->route('exports.index')
            ->with('success', 'Registro de exportação deletado com sucesso.');
    }
}
