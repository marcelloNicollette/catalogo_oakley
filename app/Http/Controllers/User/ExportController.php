<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Color;
use App\Models\ExportUser;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
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

        $produtos = $query->get();
        //dd($produtos);
        $opcoes = $request->input('opcoes', []);
        $grupo_opcoes = $request->input('grupo_opcoes', []);

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
        ];
        //dd($data);
        if ($grupo_opcoes === 'separado') {
            $view = $request->formato === '16_9' ? 'exports.collection.presentation' : 'exports.collection.a4';
        } else {
            $view = $request->formato === '16_9' ? 'exports.collection.presentation-group' : 'exports.collection.a4-group';
        }

        //return view($view, $data);
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
