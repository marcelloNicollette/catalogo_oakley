<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Calendario;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Color;
use App\Models\ConteudoCategory;
use App\Models\FlagProduct;
use App\Models\Numeracao;
use App\Models\Product;
use App\Models\Segmentacao;
use App\Models\SegmentacaoCliente;
use App\Models\SharedCollection;
use App\Models\Size;
use App\Models\TechnologyCategory;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules;

class frontendController extends Controller
{
    //
    public function index()
    {

        $segmentacao = Segmentacao::with('collections')->get();
        //dd($segmentacao);
        return view('user.segmentacao', ['segmentacao' => $segmentacao]);
    }

    //
    public function conta()
    {
        $user = Auth::user();
        return view('user.conta-user', ['user' => $user]);
    } //
    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            //'type' => ['required', 'string', 'in:admin,user'],
            //'collection_id' => ['nullable', 'exists:collections,id'],
            'company' => ['nullable', 'string', 'max:255'],
            'setor' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'idioma' => 'required|in:pt,en,es',
        ];

        $request->validate($validationRules);

        $userData = [
            'name' => $request->name,
            //'email' => $request->email,
            //'type' => $request->type,
            //'collection_id' => $request->collection_id,
            'company' => $request->company,
            'setor' => $request->setor,
            'phone' => $request->phone,
            'idioma' => $request->idioma,
        ];
        //dd($userData);
        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Atualiza via query builder para evitar alertas de tipo sobre métodos no Authenticatable
        User::where('id', $user->id)->update($userData);

        return redirect()->route('user.conta')
            ->with('success', 'Usuário atualizado com sucesso!')
            ->with('language_changed', true);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.conta')
            ->with('success', 'Senha atualizada com sucesso!');
    }

    public function slug($slug)
    {

        $segmentacao = Segmentacao::all();
        $banners = Banner::where('active', 1)->forUser()->orderBy('order', 'asc')->get();
        return view('user.slug', ['segmentacao' => $segmentacao, 'banners' => $banners]);
    }
    public function colecoes($slug)
    {
        $user = Auth::user();
        $segmentacao = Segmentacao::where('slug', $slug)->first();
        $query = Collection::where('segmentacao_id', $segmentacao->id);

        if (!in_array($user->type, ['user-adm', 'admin'])) {
            //dd('Usuário não tem permissão para ver coleções inativas');
            $query->where('active', true);
        }

        $colecoes = $query->orderBy('id', 'desc')->get();
        $data_years = Collection::pluck('created_at')->map(function ($item) {
            return date('Y', strtotime($item));
        })->unique()->sort(function ($a, $b) {
            return $b <=> $a;
        })->values();

        return view('user.colecoes', ['colecoes' => $colecoes, 'years' => $data_years]);
    }
    // Nova função para recuperar selectedSegmentacoes do localStorage
    public function getSelectedSegmentacoes(Request $request)
    {
        $selectedSegmentacoes = $request->input('selected_segmentacoes', []);

        if (empty($selectedSegmentacoes)) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma segmentação selecionada encontrada',
                'data' => []
            ]);
        }

        // Buscar as segmentações selecionadas no banco
        $segmentacoes = \App\Models\SegmentacaoCliente::whereIn('id', $selectedSegmentacoes)
            ->where('active', true)
            ->get(['id', 'nome', 'descricao']);

        return response()->json([
            'success' => true,
            'message' => 'Segmentações recuperadas com sucesso',
            'data' => [
                'selected_ids' => $selectedSegmentacoes,
                'segmentacoes' => $segmentacoes,
                'total' => count($selectedSegmentacoes)
            ]
        ]);
    }

    public function produtos($slug, $colecao, Request $request)
    {

        //dd($this->getSelectedSegmentacoes($request));
        $segmentacao = Segmentacao::where('slug', $slug)->first();
        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();
        //$categories = Category::where('segmento_id', $segmentacao->id)->get();

        $colecao = Collection::where('slug', $colecao)->first();

        $numeracao = Numeracao::orderBy('numero', 'asc')->get();
        $tamanhos = Size::get();
        $flags = FlagProduct::whereHas('colors', function ($query) use ($colecao) {
            $query->where('collection_id', $colecao->id);
        })->get();

        // Verificar se o usuário logado tem segmentações de cliente
        $user = Auth::user();
        $userSegmentacoesCliente = $user->segmentacoesCliente;

        $produtosQuery = Color::where('collection_id', $colecao->id)
            ->with(['product', 'product.caracteristicasDestaque', 'product.category', 'flagProduct', 'flagProducts', 'segmentacoesCliente'])->orderBy('product_id', 'asc');

        // Verificar se há segmentações selecionadas no request (vindas do modal)
        $selectedSegmentacoes = $request->input('selected_segmentacoes');
        //dd($selectedSegmentacoes);
        if ($selectedSegmentacoes && is_array($selectedSegmentacoes) && count($selectedSegmentacoes) > 0) {
            // Filtrar cores baseado nas segmentações selecionadas no modal
            $produtosQuery->whereHas('segmentacoesCliente', function ($query) use ($selectedSegmentacoes) {
                $query->whereIn('segmentacao_cliente_id', $selectedSegmentacoes);
            });
        } elseif ($userSegmentacoesCliente->count() > 0) {
            // Se não há seleção específica, usar todas as segmentações do usuário
            $segmentacaoClienteIds = $userSegmentacoesCliente->pluck('id');
            $produtosQuery->whereHas('segmentacoesCliente', function ($query) use ($segmentacaoClienteIds) {
                $query->whereIn('segmentacao_cliente_id', $segmentacaoClienteIds);
            });
        }

        $produtos = $produtosQuery->get();
        //dd($produtos->first()->segmentacoesCliente);
        //dd($produtos->first()->product);

        foreach ($produtos as $produto) {

            // Validação para garantir que o produto tenha ID e evitar erros na busca
            $segmentacoesDaCor = collect([]);

            if (isset($produto->id)) {
                $segmentacoesDaCor = SegmentacaoCliente::whereHas('colors', function ($query) use ($produto) {
                    $query->where('colors.id', $produto->id);
                })->get();
            }

            // Inclui as segmentações como um relacionamento no objeto produto
            $produto->setRelation('segmentacoesCliente', $segmentacoesDaCor);
        }
        //dd($produtos->first());

        $availableCategoryIds = $produtos->pluck('product.category_id')->filter()->unique()->values()->all();
        $availableSubcategoryIds = $produtos->pluck('product.subcategory_id')->filter()->unique()->values()->all();

        $categoriesQuery = Category::where('segmento_id', $segmentacao->id)->orderBy('name', 'asc');

        if (count($availableCategoryIds) > 0) {
            $categoriesQuery->whereIn('id', $availableCategoryIds);
        } else {
            $categoriesQuery->whereRaw('1 = 0');
        }

        $categoriesQuery->with([
            'subcategories' => function ($query) use ($availableSubcategoryIds) {
                if (count($availableSubcategoryIds) > 0) {
                    $query->whereIn('id', $availableSubcategoryIds);
                } else {
                    $query->whereRaw('1 = 0');
                }

                $query->ordered();
            }
        ]);

        $categories = $categoriesQuery->get();

        return view('user.produtos', ['colecoes' => $colecoes, 'colecao' => $colecao, 'produtos' => $produtos, 'categories' => $categories, 'numeracao' => $numeracao, 'tamanhos' => $tamanhos, 'flags' => $flags]);
    }
    public function detalhe_produto($slug, $colecao, $produto, $codigo_cor)
    {
        $segmentacao = Segmentacao::where('slug', $slug)->first();
        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();
        $categories = Category::where('segmento_id', $segmentacao->id)->get();

        $colecao = Collection::where('slug', $colecao)->first();

        // Verificar se o usuário logado tem segmentações de cliente
        $user = Auth::user();
        $userSegmentacoesCliente = $user->segmentacoesCliente;

        $hasColorFlagProductTable = Schema::hasTable('color_flag_product');
        $colorRelations = ['numeracao', 'segmentacoesCliente', 'flagProduct'];
        if ($hasColorFlagProductTable) {
            $colorRelations[] = 'flagProducts';
        }

        // Buscar o produto com suas relações
        $produto = Product::where('code', $produto)->with(['category', 'sizes', 'numeracoes', 'caracteristicas', 'links', 'caracteristicasDestaque', 'colors'])->first();

        // Buscar apenas as cores do produto que estão vinculadas às segmentações do cliente
        if ($userSegmentacoesCliente->isNotEmpty()) {
            $allColorsQuery = Color::where('product_id', $produto->id)
                ->where('collection_id', $colecao->id)
                ->whereHas('segmentacoesCliente', function ($query) use ($userSegmentacoesCliente) {
                    $segmentacaoIds = $userSegmentacoesCliente->pluck('id')->toArray();
                    $query->whereIn('segmentacao_cliente_id', $segmentacaoIds);
                })
                ->with($colorRelations);
        } else {
            // Se o usuário não tem segmentações de cliente, buscar todas as cores
            $allColorsQuery = Color::where('product_id', $produto->id)
                ->where('collection_id', $colecao->id)
                ->with($colorRelations);
        }

        // Se $codigo_cor foi fornecido, ordenar para que essa cor seja a primeira
        if ($codigo_cor) {
            $allColorsQuery->orderByRaw("CASE WHEN color_code = ? THEN 0 ELSE 1 END", str_replace('_', '/', $codigo_cor));
        }

        $allColors = $allColorsQuery->get();
        //dd($allColors);
        // Adicionar as cores com segmentações ao produto para uso no JavaScript
        $produto->allColors = $allColors;
        $produto->colors = $allColors; // Manter compatibilidade
        //dd($produto->colors);


        $produtosQuery = Color::where('collection_id', $colecao->id)
            ->with(['product', 'product.caracteristicasDestaque', 'product.category']);

        // Se $codigo_cor foi fornecido, ordenar para que o produto com essa cor seja o primeiro
        if ($codigo_cor) {
            $produtosQuery->orderByRaw("CASE WHEN color_code = ? THEN 0 ELSE 1 END", [$codigo_cor]);
        }

        $produtos = $produtosQuery->get()->groupBy('product_id');

        return view('user.detalhe-produto', ['produto' => $produto, 'hasColorFlagProductTable' => $hasColorFlagProductTable]);
    }

    public function detalhe_produto_translate($slug, $colecao, $produto, $codigo_cor)
    {
        $segmentacao = Segmentacao::where('slug', $slug)->first();
        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();
        $categories = Category::where('segmento_id', $segmentacao->id)->get();

        // Verificar se o usuário logado tem segmentações de cliente
        $user = Auth::user();
        $userSegmentacoesCliente = $user->segmentacoesCliente;

        $hasColorFlagProductTable = Schema::hasTable('color_flag_product');
        $colorRelations = ['numeracao', 'segmentacoesCliente', 'flagProduct'];
        if ($hasColorFlagProductTable) {
            $colorRelations[] = 'flagProducts';
        }


        // Buscar o produto com suas relações
        $produto = Product::where('code', $produto)->with(['category', 'sizes', 'numeracoes', 'caracteristicas', 'links', 'caracteristicasDestaque', 'colors'])->first();

        // Buscar apenas as cores do produto que estão vinculadas às segmentações do cliente
        if ($userSegmentacoesCliente->isNotEmpty()) {
            $allColorsQuery = Color::where('product_id', $produto->id)
                ->whereHas('segmentacoesCliente', function ($query) use ($userSegmentacoesCliente) {
                    $segmentacaoIds = $userSegmentacoesCliente->pluck('id')->toArray();
                    $query->whereIn('segmentacao_cliente_id', $segmentacaoIds);
                })
                ->with($colorRelations);
        } else {
            // Se o usuário não tem segmentações de cliente, buscar todas as cores
            $allColorsQuery = Color::where('product_id', $produto->id)
                ->with($colorRelations);
        }

        // Se $codigo_cor foi fornecido, ordenar para que essa cor seja a primeira
        if ($codigo_cor) {
            $allColorsQuery->orderByRaw("CASE WHEN color_code = ? THEN 0 ELSE 1 END", str_replace('_', '/', $codigo_cor));
        }

        $allColors = $allColorsQuery->get();
        //dd($allColors);
        // Adicionar as cores com segmentações ao produto para uso no JavaScript
        $produto->allColors = $allColors;
        $produto->colors = $allColors; // Manter compatibilidade

        $colecao = Collection::where('slug', $colecao)->first();

        $produtosQuery = Color::where('collection_id', $colecao->id)
            ->with(['product', 'product.caracteristicasDestaque', 'product.category']);

        // Se $codigo_cor foi fornecido, ordenar para que o produto com essa cor seja o primeiro
        if ($codigo_cor) {
            $produtosQuery->orderByRaw("CASE WHEN color_code = ? THEN 0 ELSE 1 END", [$codigo_cor]);
        }

        $produtos = $produtosQuery->get()->groupBy('product_id');

        return view('user.detalhe-produto-translate', ['produto' => $produto, 'hasColorFlagProductTable' => $hasColorFlagProductTable]);
    }


    public function tecnologias()
    {
        $tecnologia_categoria = TechnologyCategory::get();

        $tecnologias = TechnologyCategory::where('active', 1)
            ->with(['items' => function ($query) {
                $query->reorder()->orderByRaw('TRIM(name) asc')->orderBy('id');
            }])
            ->get();


        return view('user.tecnologias', ['tecnologia_categoria' => $tecnologia_categoria, 'tecnologias' => $tecnologias]);
    }

    public function getProdutosPorCategoria(Request $request)
    {
        $categoriaSlug = $request->get('categoria');
        $collectionId = $request->get('collection_id');

        // Verificar se o usuário logado tem segmentações de cliente
        $user = Auth::user();
        $userSegmentacoesCliente = $user->segmentacoesCliente;

        if (!$collectionId) {
            return response()->json(['error' => 'Collection ID é obrigatório'], 400);
        }

        $query = Color::where('collection_id', $collectionId)
            ->with(['product', 'product.caracteristicasDestaque', 'product.category']);

        // Se uma categoria específica foi selecionada, filtrar por ela
        if ($categoriaSlug && $categoriaSlug !== 'todas') {
            $query->whereHas('product.category', function ($q) use ($categoriaSlug) {
                $q->where('slug', $categoriaSlug);
            });
        }

        // Verificar se há segmentações selecionadas no request (vindas do modal)
        $selectedSegmentacoes = $request->input('selected_segmentacoes');
        //dd($selectedSegmentacoes);
        if ($selectedSegmentacoes && is_array($selectedSegmentacoes) && count($selectedSegmentacoes) > 0) {
            // Filtrar cores baseado nas segmentações selecionadas no modal
            $query->whereHas('segmentacoesCliente', function ($query) use ($selectedSegmentacoes) {
                $query->whereIn('segmentacao_cliente_id', $selectedSegmentacoes);
            });
        } elseif ($userSegmentacoesCliente->count() > 0) {
            // Se não há seleção específica, usar todas as segmentações do usuário
            $segmentacaoClienteIds = $userSegmentacoesCliente->pluck('id');
            $query->whereHas('segmentacoesCliente', function ($query) use ($segmentacaoClienteIds) {
                $query->whereIn('segmentacao_cliente_id', $segmentacaoClienteIds);
            });
        }

        //$produtos = $query->get()->groupBy('product_id');
        $produtos = $query->get();
        //dd($produtos);

        $produtosFormatados = [];
        foreach ($produtos as $produtoGroup) {
            $produto = $produtoGroup;
            $product = $produto->product;
            if (!$product) {
                continue;
            }

            $colorCode = $produto->color_code ? str_replace('/', '_', $produto->color_code) : null;
            $img = ($product->code && $colorCode)
                ? ("/images/produtos/" . $product->code . "_" . $colorCode . ".jpg")
                : "/images/img-padrao-mz.png";

            // Verificar se o produto está nos favoritos do usuário usando query direta na Wishlist
            $isFavorito = false;
            if ($user) {
                $isFavorito = Wishlist::where('user_id', $user->id)
                    ->where('product_id', $produto->product->id)
                    ->where(function ($query) use ($produto) {
                        $query->where('color_code', str_replace('/', '_', $produto->color_code))
                            ->orWhere('color_code', $produto->color_code);
                    })
                    ->exists();
            }

            $produtosFormatados[] = [
                'id' => $produto->product->id,
                'title' => $produto->product->name,
                'imagem' => $img,
                'codigo' => $produto->product->code,
                'cor' => $produto->color_name,
                'categoria' => $produto->product->category->name,
                'preco' => 'R$' . $produto->product->price,
                'slug' => $produto->product->slug,
                'selected' => false,
                'favoritos' => $isFavorito
            ];
        }

        return response()->json($produtosFormatados);
    }

    public function materiais()
    {
        $categories = ConteudoCategory::get();

        $conteudos = ConteudoCategory::where('active', 1)->with('conteudo')->get();


        return view('user.conteudos', ['categories' => $categories, 'conteudos' => $conteudos]);
    }
    public function gerarArquivo($slug)
    {
        $user = Auth::user();
        $segmentacao = Segmentacao::where('slug', $slug)->first();

        $colecoes = Collection::where('segmentacao_id', $segmentacao->id);
        $categorias = Category::where('segmento_id', $segmentacao->id)->get();
        //dd($categorias);

        if (!in_array($user->type, ['user-adm', 'admin'])) {
            //dd('Usuário não tem permissão para ver coleções inativas');
            $colecoes->where('active', true);
        }

        $colecoes = $colecoes->orderBy('id', 'desc')->get();
        //dd($categorias);

        $data_years = Collection::pluck('created_at')->map(function ($item) {
            return date('Y', strtotime($item));
        })->unique()->sort(function ($a, $b) {
            return $b <=> $a;
        })->values();

        return view('user.gerar-arquivo', ['colecoes' => $colecoes, 'categorias' => $categorias, 'years' => $data_years]);
    }

    public function compartilhar($slug)
    {
        $user = Auth::user();
        $segmentacao = Segmentacao::where('slug', $slug)->first();

        $colecoes = Collection::where('segmentacao_id', $segmentacao->id);
        $categorias = Category::where('segmento_id', $segmentacao->id)->get();

        if (!in_array($user->type, ['user-adm', 'admin'])) {
            $colecoes->where('active', true);
        }

        $colecoes = $colecoes->orderBy('id', 'desc')->get();
        $data_years = Collection::pluck('created_at')->map(function ($item) {
            return date('Y', strtotime($item));
        })->unique()->sort(function ($a, $b) {
            return $b <=> $a;
        })->values();

        $sharedCollections = SharedCollection::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.compartilhar', [
            'colecoes' => $colecoes,
            'categorias' => $categorias,
            'years' => $data_years,
            'sharedCollections' => $sharedCollections
        ]);
    }


    public function calendario($slug)
    {
        $calendarios = Calendario::with([
            'product' => function ($query) {
                $query->withTrashed();
            },
            'product.colors' => function ($query) {
                $query->withTrashed()->limit(1);
            }
        ])
            ->orderBy('ano', 'DESC')
            ->orderBy('mes', 'DESC')
            ->get();

        $anos = $calendarios->pluck('ano')->unique();

        //dd($calendarios);

        return view('user.calendario', ['calendarios' => $calendarios, 'anos' => $anos]);
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = \App\Models\Subcategory::where('category_id', $categoryId)
            ->where('active', true)
            ->orderBy('faixa')
            ->get(['id', 'faixa as name']);

        return response()->json($subcategories);
    }
}
