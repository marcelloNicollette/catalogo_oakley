<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Color;
use App\Models\FlagProduct;
use App\Models\Numeracao;
use App\Models\Product;
use App\Models\Segmentacao;
use App\Models\SegmentacaoCliente;
use App\Models\SharedCollection;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SharedCollectionController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'collectionHistoryName' => 'nullable|string',
            'selected_segmentacoes' => 'nullable|array',
            'produtos_selecionados' => 'nullable', // Pode ser array ou string JSON
            'opcoes' => 'nullable|array',
        ]);

        $uuid = Str::uuid();

        $products = $request->produtos_selecionados;

        // Se for string JSON (enviado como campo único para evitar max_input_vars), decodifica
        if (is_string($products)) {
            $products = json_decode($products, true);
        }

        // Se for array de strings JSON (legado ou envio múltiplo), decodifica cada item
        if (is_array($products) && !empty($products)) {
            $products = array_map(function ($p) {
                return is_string($p) ? json_decode($p, true) : $p;
            }, $products);
        }

        $sharedCollection = SharedCollection::create([
            'uuid' => $uuid,
            'user_id' => Auth::id(),
            'collection_id' => $request->collection_id,
            'name' => $request->collectionHistoryName,
            'segmentacoes' => $request->selected_segmentacoes,
            'products' => $products,
            'options' => $request->opcoes,
        ]);

        return response()->json([
            'success' => true,
            'link' => route('shared.collection', $uuid),
            'name' => $sharedCollection->name,
        ]);
    }

    public function show($uuid)
    {
        $sharedCollection = SharedCollection::where('uuid', $uuid)->firstOrFail();

        $colecao = $sharedCollection->collection;
        $segmentacao = $colecao->segmentacao; // Assuming relationship exists
        $user = $sharedCollection->user;

        // Construct the base URL for product links: /user/{userSlug}/colecoes/{collectionSlug}
        $currentSlug = '/user/' . $user->slug . '/colecoes/' . $colecao->slug;
        $segmentacaoSlug = $segmentacao->slug ?? 'olympikus'; // Default or retrieve from relation

        // Load necessary data for the view
        $categories = Category::where('segmento_id', $segmentacao->id)->get();
        $numeracao = Numeracao::orderBy('numero', 'asc')->get();
        $tamanhos = Size::get();
        $flags = FlagProduct::whereHas('colors', function ($query) use ($colecao) {
            $query->where('collection_id', $colecao->id);
        })->get();

        // Pass single collection as a collection for the view to avoid undefined variable error
        // and restrict navigation to the shared collection only
        $colecoes = collect([$colecao]);

        // Decode stored selection
        $selectedProducts = $sharedCollection->products ?? [];
        $selectedSegmentacoes = $sharedCollection->segmentacoes ?? [];
        $options = $sharedCollection->options ?? [];

        // Build products query
        $produtosQuery = Color::where('collection_id', $colecao->id)
            ->with(['numeracao', 'product', 'product.caracteristicasDestaque', 'product.caracteristicas', 'product.category', 'flagProduct'])
            ->orderBy('product_id', 'ASC');

        // Filter by selected products if any
        if (!empty($selectedProducts)) {
            $produtosQuery->where(function ($q) use ($selectedProducts) {
                foreach ($selectedProducts as $p) {
                    if (is_string($p)) {
                        $p = json_decode($p, true);
                    }
                    if (is_array($p) && isset($p['id'])) {
                        $q->orWhere(function ($subQ) use ($p) {
                            $subQ->where('product_id', $p['id'])
                                ->where('color_code', $p['cor']);
                        });
                    }
                }
            });
        } elseif (!empty($selectedSegmentacoes)) {
            // Filter by selected segments if no specific products selected
            $produtosQuery->whereHas('segmentacoesCliente', function ($query) use ($selectedSegmentacoes) {
                $query->whereIn('segmentacao_cliente_id', $selectedSegmentacoes);
            });
        }

        $produtos = $produtosQuery->get();

        foreach ($produtos as $produto) {
            // Validação para garantir que o produto tenha ID e evitar erros na busca
            $segmentacoesDaCor = collect([]);

            if (isset($produto->id)) {
                $segmentacoesDaCor = SegmentacaoCliente::whereHas('colors', function ($query) use ($produto) {
                    $query->where('color_id', $produto->id);
                })->get();
            }

            // Adiciona a coleção de segmentações ao objeto do produto (cor)
            $produto->segmentacoesCliente = $segmentacoesDaCor;
        }

        return view('shared.collection', compact('produtos', 'categories', 'numeracao', 'tamanhos', 'flags', 'options', 'currentSlug', 'segmentacaoSlug', 'colecoes', 'sharedCollection'));
    }

    public function destroy($uuid)
    {
        $sharedCollection = SharedCollection::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();
        $sharedCollection->delete();

        return back()->with('success', 'Histórico excluído com sucesso!');
    }
}
