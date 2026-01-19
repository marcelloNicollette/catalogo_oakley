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

class ExportController extends Controller
{

    public function exportPdf(Request $request)
    {
        ini_set('memory_limit', '2048M'); // ou '3072M' se necessário
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
        //dd($produtos);
        $opcoes = $request->input('opcoes', []);
        $grupo_opcoes = $request->input('grupo_opcoes', []);

        $svgPath = public_path('/images/logo-preto.svg');
        $svgContent = file_get_contents($svgPath);
        $base64Svg_preto = 'data:image/svg+xml;base64,' . base64_encode($svgContent);

        $svgPath_vermelho = public_path('/images/logo-vermelho.svg');
        $svgContent_vermelho = file_get_contents($svgPath_vermelho);
        $base64Svg_vermelho = 'data:image/svg+xml;base64,' . base64_encode($svgContent_vermelho);

        $data = [
            'collections' => $produtos,
            'remove_price'       => in_array('remover_preco', $opcoes),
            'remove_code'        => in_array('remover_codigo', $opcoes),
            'remove_description' => in_array('remover_descricao', $opcoes),
            'remove_tag'         => in_array('remover_tag', $opcoes),
            'remove_capa_retranca' => in_array('remover_capa_retranca', $opcoes),
            'image' => public_path('images/tenis-1.jpg'),
            'name' => $request->user()->name,
            'request' => $request,
            'isPdf' => true,
            'base64Svg_preto' => $base64Svg_preto,
            'base64Svg_vermelho' => $base64Svg_vermelho,
        ];
        //dd($data);
        if ($grupo_opcoes === 'separado') {
            $view = $request->formato === '16_9' ? 'exports.collection.presentation' : 'exports.collection.a4';
        } else {
            $view = $request->formato === '16_9' ? 'exports.collection.presentation-group' : 'exports.collection.a4-group';
        }

        if ($request->formato === 'planilha') {
            $headings = ['Imagem', 'Coleção', 'Categoria'];
            if (!in_array('remover_codigo', $opcoes)) {
                $headings[] = 'Código';
            }
            $headings[] = 'Produto';
            $headings[] = 'Cor código';
            $headings[] = 'Cor';
            $headings[] = 'Gênero';
            if (!in_array('remover_preco', $opcoes)) {
                $headings[] = 'Preço';
            }
            if (!in_array('remover_descricao', $opcoes)) {
                $headings[] = 'Descrição';
            }

            $rows = [];
            $imagePaths = [];
            foreach ($produtos as $color) {
                $row = [];
                // placeholder for image column (handled by drawings)
                $row[] = '';
                $row[] = $color->collection->codigo_colecao ?? ($color->collection->name ?? '');
                $row[] = optional($color->product->category)->name ?? '';
                if (!in_array('remover_codigo', $opcoes)) {
                    $row[] = $color->product->code ?? '';
                }
                $row[] = $color->product->name ?? '';
                $row[] = $color->color_code ?? '';
                $row[] = $color->color_name ?? '';
                $row[] = $color->genero ?? '';
                if (!in_array('remover_preco', $opcoes)) {
                    $row[] = $color->product->price ?? '';
                }
                if (!in_array('remover_descricao', $opcoes)) {
                    $row[] = $color->product->description ?? '';
                }
                $rows[] = $row;

                $imgRel = 'images/produtos/' . ($color->product->code ?? '') . '_' . str_replace('/', '_', ($color->color_code ?? '')) . '.jpg';
                $imgPath = public_path($imgRel);
                if (!file_exists($imgPath)) {
                    $imgPath = public_path('images/img-padrao-ua.png');
                }
                $imagePaths[] = $imgPath;
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

            $filename = $request->collectionHistoryName . '.xls';

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

            return Excel::download($export, $filename, ExcelWriter::XLS);
        }

        $pdf = PDF::loadView($view, $data)
            ->setPaper('A4', 'landscape');
        $pdf->setOption(['dpi' => 120]);

        if ($request->formato === '16_9') {
            $pdf->setPaper('a4', 'landscape');
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

        $data = [
            'collections' => $produtos,
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
            'isPdf' => true,
        ];

        $view = $exportUser->formato === '16_9' ? 'exports.collection.presentation' : 'exports.collection.a4';

        $pdf = PDF::loadView($view, $data)
            ->setPaper('A4', 'landscape');

        $pdf->setOption(['dpi' => 120]);

        if ($exportUser->formato === '16_9') {
            $pdf->setPaper('a4', 'landscape');
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
