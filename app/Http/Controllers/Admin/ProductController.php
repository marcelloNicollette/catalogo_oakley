<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaracteristicaProduct;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Category;
use App\Models\Color;
use App\Models\FlagProduct;
use App\Models\LinksProduct;
use App\Models\Size;
use App\Models\Numeracao;
use App\Models\TechnologyCategory;
use App\Models\TechnologyItem;
use App\Models\Calendario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::with(['collection', 'category'])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(500);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Lista produtos excluídos (soft deleted)
     */
    public function deleted()
    {
        $products = Product::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(100);
        return view('admin.products.deleted', compact('products'));
    }

    /**
     * Restaurar produto soft-deletado
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();


        // Se ao restaurar o produto ele não tiver ordem definida, atribuir o próximo índice
        if ($product->order === null) {
            $nextOrder = (int) Product::whereNull('deleted_at')->max('order');
            $product->order = $nextOrder + 1;
            $product->save();
        }

        return redirect()->route('admin.products.deleted')
            ->with('success', 'Produto restaurado com sucesso.');
    }

    public function create()
    {
        $collections = Collection::where('active', true)->get();
        $categories = Category::where('active', true)->get();
        $colors = Color::where('active', true)->get();
        $flags = FlagProduct::where('status', true)->get();
        $technologies = TechnologyCategory::where('active', true)->with('items')->get();
        $sizes = Size::where('active', true)->get();
        $numeracoes = Numeracao::where('active', true)->get();
        $segmentacoesCliente = \App\Models\SegmentacaoCliente::where('active', true)->get();

        return view('admin.products.create', compact('collections', 'categories', 'colors', 'flags', 'technologies', 'sizes', 'numeracoes', 'segmentacoesCliente'));
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'code' => 'required|string|unique:products,code',
            'sku' => 'nullable|string|max:255',
            'technologies' => 'nullable|array',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'flag_calendario' => 'nullable|boolean',
            'data_mkt' => 'nullable|date',
            'data_trade' => 'nullable|date',
            'data_cliente' => 'nullable|date',
            'data_dtc' => 'nullable|date',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:1'
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . $validated['code'];

        // Processar tecnologias
        if ($request->has('technologies')) {
            $validated['technologies'] = json_encode($request->technologies);
        }

        // Criação com resolução de conflito de ordem (se fornecida)
        if ($request->filled('order')) {
            $newOrder = (int) $request->input('order');

            DB::transaction(function () use (&$validated, $newOrder, &$product) {
                $hasConflict = Product::whereNull('deleted_at')
                    ->where('order', $newOrder)
                    ->exists();

                if ($hasConflict) {
                    Product::whereNull('deleted_at')
                        ->where('order', '>=', $newOrder)
                        ->increment('order');
                }

                $validated['order'] = $newOrder;
                $product = Product::create($validated);
            });
        } else {
            $product = Product::create($validated);
        }

        // Inserir cores (se houver)
        if ($request->has('color_name') && count($request->input('color_name')) > 0) {
            $product->addColors([
                'names' => $request->input('color_name'),
                'descriptions' => $request->input('color_description', []),
                'codes' => $request->input('color_code', []),
                'generos' => $request->input('color_genero', []),
                'collections' => $request->input('color_collection_id', []),
                'flags' => $request->input('color_flag_product_id', []),
                'numeracao_ids' => $request->input('color_numeracao_id', []),
                'segmentacoes_cliente' => $request->input('color_segmentacoes_cliente', []),
            ]);
        }

        // Inserir características (se houver)
        if ($request->has('caracteristica_title') && count($request->input('caracteristica_title')) > 0) {
            $product->addCaracteristicas([
                'titles' => $request->input('caracteristica_title'),
                'descriptions' => $request->input('caracteristica_description', []),
                'destaques' => $request->input('caracteristica_destaque', []),
            ]);
        }

        // Inserir links (se houver)
        if ($request->has('link_title') && count($request->input('link_title')) > 0) {
            $product->addCaracteristicas([
                'titles' => $request->input('caracteristica_title'),
                'descriptions' => $request->input('caracteristica_description', []),
                'destaques' => $request->input('caracteristica_destaque', []),
            ]);
        }
        if ($request->has('size_ids') && count($request->input('size_ids')) > 0) {
            $product->addSizes([
                'size_ids' => $request->input('size_ids'),
                'stocks' => $request->input('size_stocks', []),
            ]);
        }

        // Atualiza numerações
        if ($request->has('numeracao_ids') && count($request->input('numeracao_ids')) > 0) {
            $product->addNumeracoes([
                'numeracao_ids' => $request->input('numeracao_ids'),
                'stocks' => $request->input('numeracao_stocks', []),
            ]);
        }

        // Sincroniza com calendário
        $this->syncCalendario($product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto criado com sucesso.');
    }

    public function edit(Product $product)
    {
        $collections = Collection::get();
        $categories = Category::where('active', true)->get();
        $colors = Color::where('product_id', $product->id)->with('segmentacoesCliente')->get();
        $caracteristicas = CaracteristicaProduct::where('product_id', $product->id)->get();
        $links = LinksProduct::where('product_id', $product->id)->get();
        $flags = FlagProduct::where('status', true)->get();
        $technologies = TechnologyCategory::where('active', true)->with('items')->get();
        $sizes = Size::where('active', true)->get();
        $numeracoes = Numeracao::where('active', true)->get();
        $segmentacoesCliente = \App\Models\SegmentacaoCliente::where('active', true)->get();

        // Carregar relacionamentos de sizes e numeração do produto
        $product->load(['sizes', 'numeracoes']);

        return view('admin.products.edit', compact('product', 'collections', 'categories', 'colors', 'caracteristicas', 'flags', 'technologies', 'links', 'sizes', 'numeracoes', 'segmentacoesCliente'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'code' => 'required|string',
            //'code' => 'required|string|unique:products,code,' . $product->id,
            'sku' => 'nullable|string|max:255',
            'technologies' => 'nullable|array',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'flag_calendario' => 'nullable|boolean',
            'data_mkt' => 'nullable|date',
            'data_trade' => 'nullable|date',
            'data_cliente' => 'nullable|date',
            'data_dtc' => 'nullable|date',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:1'
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . $validated['code'];

        if ($request->has('technologies')) {
            $validated['technologies'] = json_encode($request->technologies);
        }

        // Atualiza o produto com ajuste de ordem e resolução de conflito
        if ($request->filled('order')) {
            $newOrder = (int) $request->input('order');

            DB::transaction(function () use ($product, $newOrder, &$validated) {
                $hasConflict = Product::whereNull('deleted_at')
                    ->where('id', '!=', $product->id)
                    ->where('order', $newOrder)
                    ->exists();

                if ($hasConflict) {
                    // Empurra para baixo todos os produtos ativos com ordem >= nova ordem
                    Product::whereNull('deleted_at')
                        ->where('id', '!=', $product->id)
                        ->where('order', '>=', $newOrder)
                        ->increment('order');
                }

                $validated['order'] = $newOrder;
                $product->update($validated);
            });
        } else {
            unset($validated['order']);
            $product->update($validated);
        }

        // Atualiza cores
        if ($request->has('color_name') && count($request->input('color_name')) > 0) {
            $product->syncColors([
                'names' => $request->input('color_name'),
                'descriptions' => $request->input('color_description', []),
                'codes' => $request->input('color_code', []),
                'generos' => $request->input('color_genero', []),
                'collections' => $request->input('color_collection_id', []),
                'flags' => $request->input('color_flag_product_id', []),
                'numeracao_ids' => $request->input('color_numeracao_id', []),
                'segmentacoes_cliente' => $request->input('color_segmentacoes_cliente', []),
            ]);
        }

        // Atualiza características
        if ($request->has('caracteristica_title') && count($request->input('caracteristica_title')) > 0) {
            $product->syncCaracteristicas([
                'titles' => $request->input('caracteristica_title'),
                'descriptions' => $request->input('caracteristica_description', []),
                'destaques' => $request->input('caracteristica_destaque', []),
            ]);
        }

        // Atualiza links
        if ($request->has('link_title') && count($request->input('link_title')) > 0 && $request->input('link_title')[0] != null) {
            $product->syncLinks([
                'link_title' => $request->input('link_title'),
                'link_url' => $request->input('link_url', ''),
            ]);
        } else {
            $product->links()->delete();
        }
        //dd($request->input('size_ids'));
        // Atualiza tamanhos
        if ($request->has('size_ids') && count($request->input('size_ids')) > 0 && $request->input('size_ids')[0] != null) {
            $product->syncSizes([
                'size_ids' => $request->input('size_ids'),
                'stocks' => $request->input('size_stocks', []),
            ]);
        } else {
            $product->sizes()->detach();
        }

        // Atualiza numerações
        if ($request->has('numeracao_ids') && count($request->input('numeracao_ids')) > 0 && $request->input('numeracao_ids')[0] != null) {
            $product->syncNumeracoes([
                'numeracao_ids' => $request->input('numeracao_ids'),
                'stocks' => $request->input('numeracao_stocks', []),
            ]);
        } else {
            $product->numeracoes()->detach();
        }

        // Sincroniza com calendário
        $this->syncCalendario($product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto excluído com sucesso.');
    }

    /**
     * Sincroniza os dados do calendário com o produto
     */
    private function syncCalendario(Product $product)
    {
        // Se o produto tem flag_calendario ativo e pelo menos uma data preenchida
        if ($product->flag_calendario && ($product->data_mkt || $product->data_trade || $product->data_cliente || $product->data_dtc)) {
            // Busca ou cria um registro de calendário para este produto
            $calendario = Calendario::where('product_id', $product->id)->first();

            if (!$calendario) {
                $calendario = new Calendario();
                $calendario->product_id = $product->id;
            }

            // Carrega a categoria do produto se não estiver carregada
            if (!$product->relationLoaded('category')) {
                $product->load('category');
            }

            // Atualiza os dados do calendário com base no produto
            $calendario->title = $product->name;
            $calendario->ano = now()->year; // Ano atual como padrão
            $calendario->mes = now()->month; // Mês atual como padrão
            $calendario->info_1 = $product->category->name;
            $calendario->info_2 = $product->code;

            // Define a data principal como a primeira data disponível
            $calendario->data = $product->data_cliente ?: ($product->data_mkt ?: ($product->data_trade ?: $product->data_dtc));

            // Copia as datas específicas
            $calendario->data_mkt = $product->data_mkt;
            $calendario->data_trade = $product->data_trade;
            $calendario->data_cliente = $product->data_cliente;
            $calendario->data_dtc = $product->data_dtc;

            // Ajusta ano e mês baseado na data principal
            if ($calendario->data) {
                $calendario->ano = $calendario->data->year;
                $calendario->mes = $calendario->data->month;
            }

            $calendario->save();
        } else {
            // Se o flag_calendario está desativo ou não há datas, remove o registro do calendário
            Calendario::where('product_id', $product->id)->delete();
        }
    }

    /**
     * Retorna as subcategorias de uma categoria específica
     */
    public function getSubcategories($categoryId)
    {
        $subcategories = \App\Models\Subcategory::where('category_id', $categoryId)
            ->where('active', true)
            ->orderBy('faixa')
            ->get(['id', 'faixa']);

        return response()->json($subcategories);
    }
}
