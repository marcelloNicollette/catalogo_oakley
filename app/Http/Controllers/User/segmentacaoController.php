<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Segmentacao;
use Illuminate\Http\Request;

class segmentacaoController extends Controller
{
    //
    public function index()
    {

        $segmentacao = Segmentacao::all();
        return view('user.segmentacao', ['segmentacao' => $segmentacao]);
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

        return view('user.colecoes', ['colecoes' => $colecoes]);
    }
    public function produtos($slug, $colecao)
    {
        $segmentacao = Segmentacao::where('slug', $slug)->first();
        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();
        $categories = Category::where('segmento_id', $segmentacao->id)->get();


        $colecao = Collection::where('slug', $colecao)->first();

        $produtos = Color::where('collection_id', $colecao->id)
            ->with(['product', 'product.caracteristicasDestaque', 'product.category'])
            ->get()
            ->groupBy('product_id');
        //dd($produtos);

        return view('user.produtos', ['colecoes' => $colecoes, 'colecao' => $colecao, 'produtos' => $produtos, 'categories' => $categories]);
    }
}
