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
use App\Models\Size;
use App\Models\TechnologyCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class frontendController extends Controller
{
    //
    public function index()
    {

        $segmentacao = Segmentacao::all();
        return view('user.segmentacao', ['segmentacao' => $segmentacao]);
    }

    //
    public function conta()
    {
        $user = Auth::user();
        return view('user.conta-user', ['user' => $user]);
    } //
    public function updateUser(Request $request, User $user)
    {

        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            //'type' => ['required', 'string', 'in:admin,user'],
            //'collection_id' => ['nullable', 'exists:collections,id'],
            'company' => ['nullable', 'string', 'max:255'],
            'setor' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
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
        ];
        //dd($userData);
        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('user.conta')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function slug($slug)
    {

        $segmentacao = Segmentacao::all();
        $banners = Banner::where('active', 1)->get();
        return view('user.slug', ['segmentacao' => $segmentacao, 'banners' => $banners]);
    }
    public function colecoes($slug)
    {
        $segmentacao = Segmentacao::where('slug', $slug)->first();
        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();
        $data_years = Collection::pluck('created_at')->map(function ($item) {
            return date('Y', strtotime($item));
        })->unique()->sort(function ($a, $b) {
            return $b <=> $a;
        })->values();

        return view('user.colecoes', ['colecoes' => $colecoes, 'years' => $data_years]);
    }
    public function produtos($slug, $colecao)
    {
        $segmentacao = Segmentacao::where('slug', $slug)->first();
        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();
        $categories = Category::where('segmento_id', $segmentacao->id)->get();

        $colecao = Collection::where('slug', $colecao)->first();

        $numeracao = Numeracao::orderBy('numero', 'asc')->get();
        $tamanhos = Size::get();
        $flags = FlagProduct::whereHas('colors', function ($query) use ($colecao) {
            $query->where('collection_id', $colecao->id);
        })->get();

        $produtos = Color::where('collection_id', $colecao->id)
            ->with(['product', 'product.caracteristicasDestaque', 'product.category', 'flagProduct'])
            ->get();
        //dd($produtos->first()->product);

        return view('user.produtos', ['colecoes' => $colecoes, 'colecao' => $colecao, 'produtos' => $produtos, 'categories' => $categories, 'numeracao' => $numeracao, 'tamanhos' => $tamanhos, 'flags' => $flags]);
    }
    public function detalhe_produto($slug, $colecao, $produto)
    {
        $segmentacao = Segmentacao::where('slug', $slug)->first();
        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();
        $categories = Category::where('segmento_id', $segmentacao->id)->get();
        $produto = Product::where('slug', $produto)->with(['category', 'sizes', 'numeracoes', 'colors', 'caracteristicas', 'links', 'caracteristicasDestaque'])->first();
        //dd($produto);


        $colecao = Collection::where('slug', $colecao)->first();

        $produtos = Color::where('collection_id', $colecao->id)
            ->with(['product', 'product.caracteristicasDestaque', 'product.category'])
            ->get()
            ->groupBy('product_id');
        //dd($produtos);

        return view('user.detalhe-produto', ['produto' => $produto]);
    }


    public function tecnologias()
    {
        $tecnologia_categoria = TechnologyCategory::get();

        $tecnologias = TechnologyCategory::where('active', 1)->with('items')->get();


        return view('user.tecnologias', ['tecnologia_categoria' => $tecnologia_categoria, 'tecnologias' => $tecnologias]);
    }

    public function getProdutosPorCategoria(Request $request)
    {
        $categoriaSlug = $request->get('categoria');
        $collectionId = $request->get('collection_id');

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

        $produtos = $query->get()->groupBy('product_id');

        $produtosFormatados = [];
        foreach ($produtos as $produtoGroup) {
            $produto = $produtoGroup->first();
            $img = "/images/produtos/" . $produto->product->code . "_" . $produto->color_code . ".jpg";

            $produtosFormatados[] = [
                'id' => $produto->product->id,
                'title' => $produto->product->name,
                'imagem' => $img,
                'codigo' => $produto->product->code,
                'cor' => $produto->color_name,
                'categoria' => $produto->product->category->name,
                'preco' => 'R$' . number_format($produto->product->price, 2, ',', '.'),
                'slug' => $produto->product->slug,
                'selected' => false
            ];
        }

        return response()->json($produtosFormatados);
    }

    public function conteudos()
    {
        $categories = ConteudoCategory::get();

        $conteudos = ConteudoCategory::where('active', 1)->with('conteudo')->get();


        return view('user.conteudos', ['categories' => $categories, 'conteudos' => $conteudos]);
    }
    public function gerarArquivo($slug)
    {
        $segmentacao = Segmentacao::where('slug', $slug)->first();

        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();
        $categorias = Category::where('segmento_id', $segmentacao->id)->get();
        //dd($categorias);

        $data_years = Collection::pluck('created_at')->map(function ($item) {
            return date('Y', strtotime($item));
        })->unique()->sort(function ($a, $b) {
            return $b <=> $a;
        })->values();

        return view('user.gerar-arquivo', ['colecoes' => $colecoes, 'categorias' => $categorias, 'years' => $data_years]);
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
}
