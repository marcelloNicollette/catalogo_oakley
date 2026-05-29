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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
            ->where('color_code', str_replace('/', '_', $request->color_code))
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
            'color_code' => str_replace('/', '_', $request->color_code)
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
            ->where('color_code', str_replace('/', '_', $request->color_code))
            ->orWhere('color_code', $request->color_code)
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
            ->where('color_code', str_replace('/', '_', $request->color_code))
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
        if (!$segmentacao) {
            abort(404);
        }
        $colecoes = Collection::where('segmentacao_id', $segmentacao->id)->get();

        $categories = Category::where('segmento_id', $segmentacao->id)->get();


        $years = $colecoes->pluck('created_at')->map(function ($item) {
            if ($item instanceof \Carbon\CarbonInterface) {
                return $item->format('Y');
            }
            return date('Y', strtotime((string) $item));
        })->unique()->sort(function ($a, $b) {
            return $b <=> $a;
        })->values();

        $colecao = Collection::where('segmentacao_id', $segmentacao->id)->first();

        $numeracao = Numeracao::get();
        $tamanhos = Size::get();
        $collectionIds = $colecoes->pluck('id')->filter()->values();
        $hasColorFlagProductTable = Schema::hasTable('color_flag_product');

        $flagIds = collect();
        if ($collectionIds->isNotEmpty()) {
            $flagIds = $flagIds
                ->merge(
                    DB::table('colors')
                        ->whereIn('collection_id', $collectionIds)
                        ->whereNull('deleted_at')
                        ->whereNotNull('flag_product_id')
                        ->pluck('flag_product_id')
                )
                ->unique()
                ->filter()
                ->values();

            if ($hasColorFlagProductTable) {
                $flagIds = $flagIds
                    ->merge(
                        DB::table('color_flag_product')
                            ->join('colors', 'colors.id', '=', 'color_flag_product.color_id')
                            ->whereIn('colors.collection_id', $collectionIds)
                            ->whereNull('colors.deleted_at')
                            ->pluck('color_flag_product.flag_product_id')
                    )
                    ->unique()
                    ->filter()
                    ->values();
            }
        }

        $flags = $flagIds->isNotEmpty()
            ? FlagProduct::whereIn('id', $flagIds)
                ->orderBy('orderfilterflag')
                ->orderBy('flag_title')
                ->get()
            : collect();

        $wishlistQuery = Wishlist::with([
            'product' => function ($query) {
                $query->withTrashed();
            },
            'product.caracteristicasDestaque' => function ($query) {
                $query->withTrashed();
            },
            'product.category' => function ($query) {
                $query->withTrashed();
            }
        ])
            ->where('user_id', $user->id)
            // Filtrar pela segmentação do slug via categoria do produto
            ->whereHas('product.category.segmentacao', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });

        $produtos = $wishlistQuery
            ->orderBy('created_at', 'desc')
            ->get();

        // Adicionar cores com lógica de substituição manualmente
        foreach ($produtos as $produto) {
            $produto->color = $produto->colorWithReplace();
            if ($produto->color) {
                $relations = [
                    'flagProduct' => function ($query) {
                        $query->withTrashed();
                    },
                    'collection' => function ($query) {
                        $query->withTrashed();
                    }
                ];

                if ($hasColorFlagProductTable) {
                    $relations['flagProducts'] = function ($query) {
                        $query->withTrashed();
                    };
                }

                $produto->color->load($relations);
            }
        }




        return view('user.wishlist', compact('produtos', 'colecoes', 'categories', 'years', 'numeracao', 'tamanhos', 'flags', 'hasColorFlagProductTable'));
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
