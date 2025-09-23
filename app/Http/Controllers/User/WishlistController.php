<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\FlagProduct;
use App\Models\Numeracao;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Segmentacao;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    /**
     * Adicionar produto à wishlist
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_code' => 'nullable|string'
        ]);

        $user = Auth::user();

        // Verificar se já existe na wishlist
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('color_code', $request->color_code)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Produto já está na sua lista de favoritos'
            ], 409);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'color_code' => $request->color_code
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produto adicionado aos favoritos!'
        ]);
    }

    /**
     * Remover produto da wishlist
     */
    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_code' => 'nullable|string'
        ]);

        $user = Auth::user();

        $deleted = Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('color_code', $request->color_code)
            ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Produto removido dos favoritos'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produto não encontrado na lista de favoritos'
        ], 404);
    }

    /**
     * Verificar se produto está na wishlist
     */
    public function check(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_code' => 'nullable|string'
        ]);

        $user = Auth::user();

        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->where('color_code', $request->color_code)
            ->exists();

        return response()->json([
            'is_favorited' => $exists
        ]);
    }

    /**
     * Listar todos os produtos da wishlist do usuário
     */
    public function index($slug)
    {
        $user = Auth::user();
        $segmentacao = Segmentacao::where('slug', $slug)->first();
        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();

        $categories = Category::where('segmento_id', $segmentacao->id)->get();

        $years = Collection::pluck('created_at')->map(function ($item) {
            return date('Y', strtotime($item));
        })->unique()->sort(function ($a, $b) {
            return $b <=> $a;
        })->values();

        $colecao = Collection::where('segmentacao_id', $segmentacao->id)->first();

        $numeracao = Numeracao::get();
        $tamanhos = Size::get();
        $flags = FlagProduct::whereHas('colors', function ($query) use ($colecao) {
            $query->where('collection_id', $colecao->id);
        })->get();

        $produtos = Wishlist::with([
            'product' => function ($query) {
                $query->withTrashed();
            },
            'product.caracteristicasDestaque' => function ($query) {
                $query->withTrashed();
            },
            'product.category' => function ($query) {
                $query->withTrashed();
            },
            'product.colors' => function ($query) {
                $query->withTrashed();
            }
        ])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Adicionar cores com lógica de substituição manualmente
        foreach ($produtos as $produto) {
            $produto->color = $produto->colorWithReplace();
            if ($produto->color) {
                $produto->color->load(['flagProduct' => function ($query) {
                    $query->withTrashed();
                }, 'collection' => function ($query) {
                    $query->withTrashed();
                }]);
            }
        }



        return view('user.wishlist', compact('produtos', 'colecoes', 'categories', 'years', 'numeracao', 'tamanhos', 'flags'));
    }

    /**
     * Contar itens na wishlist
     */
    public function count(): JsonResponse
    {
        $user = Auth::user();

        $count = Wishlist::where('user_id', $user->id)->count();

        return response()->json([
            'count' => $count
        ]);
    }
}
