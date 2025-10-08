<?php

use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\CaracteristicaProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\ConteudoCategoryController as AdminConteudoCategoryController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SegmentacaoController;
use App\Http\Controllers\Admin\SegmentacaoClienteController;
use App\Http\Controllers\Admin\TechnologyCategoryController;
use App\Http\Controllers\Admin\TechnologyItemController;
use App\Http\Controllers\Admin\FlagProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SuggestionController as AdminSuggestionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ExportController;
use App\Http\Controllers\User\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\NumeracaoController;
use App\Http\Controllers\Admin\ConteudoCategoryController;
use App\Http\Controllers\Admin\ConteudoController;
use App\Http\Controllers\Admin\CalendarioController;
use App\Http\Controllers\Admin\GoogleSheetController as AdminGoogleSheetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\User\frontendController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Models\Collection;



Route::get('/', function () {
    return view('acessos');
});
Route::get('/acessos', function () {
    return view('acessos');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
    ->name('admin.login');
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/user/login', function () {
    return redirect('/acessos');
})->name('user.login');
Route::post('/user/login', [AuthenticatedSessionController::class, 'store']);


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::resource('/admin/collections', CollectionController::class)
        ->names([
            'index' => 'admin.collections.index',
            'create' => 'admin.collections.create',
            'store' => 'admin.collections.store',
            'edit' => 'admin.collections.edit',
            'update' => 'admin.collections.update',
            'destroy' => 'admin.collections.destroy'
        ]);
    Route::resource('/admin/banners', BannersController::class)
        ->names([
            'index' => 'admin.banners.index',
            'create' => 'admin.banners.create',
            'store' => 'admin.banners.store',
            'edit' => 'admin.banners.edit',
            'update' => 'admin.banners.update',
            'destroy' => 'admin.banners.destroy'
        ]);

    // Product Images Upload and Sync
    Route::get('/admin/product-images', [ProductImageController::class, 'index'])
        ->name('admin.product-images.index');
    Route::get('/admin/product-images/search', [ProductImageController::class, 'search'])
        ->name('admin.product-images.search');
    Route::post('/admin/product-images', [ProductImageController::class, 'store'])
        ->name('admin.product-images.store');
    Route::post('/admin/product-images/sync', [ProductImageController::class, 'syncFolder'])
        ->name('admin.product-images.sync');
    Route::delete('/admin/product-images/{productImage}', [ProductImageController::class, 'destroy'])
        ->name('admin.product-images.destroy');
    Route::resource('/admin/segmento', SegmentacaoController::class)
        ->names([
            'index' => 'admin.segmento.index',
            'create' => 'admin.segmento.create',
            'store' => 'admin.segmento.store',
            'edit' => 'admin.segmento.edit',
            'update' => 'admin.segmento.update',
            'destroy' => 'admin.segmento.destroy'
        ]);
    Route::resource('/admin/categories', CategoryController::class)
        ->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy'
        ]);

    // Rotas para Subcategorias (Faixas)
    Route::resource('/admin/subcategories', SubcategoryController::class)->names([
        'index' => 'admin.subcategories.index',
        'create' => 'admin.subcategories.create',
        'store' => 'admin.subcategories.store',
        'show' => 'admin.subcategories.show',
        'edit' => 'admin.subcategories.edit',
        'update' => 'admin.subcategories.update',
        'destroy' => 'admin.subcategories.destroy',
    ]);

    // Rota AJAX para buscar subcategorias por categoria
    Route::get('/admin/subcategories/by-category/{category}', [SubcategoryController::class, 'getByCategory'])
        ->name('admin.subcategories.by-category');

    // Listagem de produtos excluídos (soft deleted) - precisa vir antes da rota resource para evitar conflito com {product}
    Route::get('/admin/products/deleted', [ProductController::class, 'deleted'])
        ->name('admin.products.deleted');

    // Restaurar produto soft-deletado
    Route::post('/admin/products/{id}/restore', [ProductController::class, 'restore'])
        ->name('admin.products.restore');

    Route::resource('/admin/products', ProductController::class)
        ->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'show' => 'admin.products.show',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy'
        ]);

    // Rota para buscar subcategorias por categoria
    Route::get('/admin/products/subcategories/{category}', [ProductController::class, 'getSubcategories'])
        ->name('admin.products.subcategories');
    Route::resource('/admin/technology/categories', TechnologyCategoryController::class)
        ->names([
            'index' => 'admin.technology.categories.index',
            'create' => 'admin.technology.categories.create',
            'store' => 'admin.technology.categories.store',
            'edit' => 'admin.technology.categories.edit',
            'update' => 'admin.technology.categories.update',
            'destroy' => 'admin.technology.categories.destroy'
        ]);

    Route::resource('/admin/technology/items', TechnologyItemController::class)
        ->names([
            'index' => 'admin.technology.items.index',
            'create' => 'admin.technology.items.create',
            'store' => 'admin.technology.items.store',
            'edit' => 'admin.technology.items.edit',
            'update' => 'admin.technology.items.update',
            'destroy' => 'admin.technology.items.destroy'
        ]);
    Route::resource('/admin/flag-product', FlagProductController::class)
        ->names([
            'index' => 'admin.flag-product.index',
            'create' => 'admin.flag-product.create',
            'store' => 'admin.flag-product.store',
            'edit' => 'admin.flag-product.edit',
            'update' => 'admin.flag-product.update',
            'destroy' => 'admin.flag-product.destroy'
        ]);
    Route::resource('/admin/sizes', SizeController::class)
        ->names([
            'index' => 'admin.sizes.index',
            'create' => 'admin.sizes.create',
            'store' => 'admin.sizes.store',
            'edit' => 'admin.sizes.edit',
            'update' => 'admin.sizes.update',
            'destroy' => 'admin.sizes.destroy'
        ]);

    // Admin - Sugestões
    Route::get('/admin/suggestions', [AdminSuggestionController::class, 'index'])->name('admin.suggestions.index');
    Route::put('/admin/suggestions/{suggestion}', [AdminSuggestionController::class, 'update'])->name('admin.suggestions.update');
    Route::resource('/admin/numeracao', NumeracaoController::class)
        ->names([
            'index' => 'admin.numeracao.index',
            'create' => 'admin.numeracao.create',
            'store' => 'admin.numeracao.store',
            'edit' => 'admin.numeracao.edit',
            'update' => 'admin.numeracao.update',
            'destroy' => 'admin.numeracao.destroy'
        ]);
    Route::resource('/admin/caracteristicas', CaracteristicaProductController::class)
        ->names([
            'index' => 'admin.caracteristicas.index',
            'create' => 'admin.caracteristicas.create',
            'store' => 'admin.caracteristicas.store',
            'edit' => 'admin.caracteristicas.edit',
            'update' => 'admin.caracteristicas.update',
            'destroy' => 'admin.caracteristicas.destroy'
        ]);
    Route::resource('/admin/conteudos/categories', ConteudoCategoryController::class)
        ->names([
            'index' => 'admin.conteudos.categories.index',
            'create' => 'admin.conteudos.categories.create',
            'store' => 'admin.conteudos.categories.store',
            'edit' => 'admin.conteudos.categories.edit',
            'update' => 'admin.conteudos.categories.update',
            'destroy' => 'admin.conteudos.categories.destroy'
        ]);

    Route::resource('/admin/conteudos/items', ConteudoController::class)
        ->names([
            'index' => 'admin.conteudos.items.index',
            'create' => 'admin.conteudos.items.create',
            'store' => 'admin.conteudos.items.store',
            'edit' => 'admin.conteudos.items.edit',
            'update' => 'admin.conteudos.items.update',
            'destroy' => 'admin.conteudos.items.destroy'
        ]);
    Route::resource('/admin/calendario', CalendarioController::class)
        ->names([
            'index' => 'admin.calendario.index',
            'create' => 'admin.calendario.create',
            'store' => 'admin.calendario.store',
            'show' => 'admin.calendario.show',
            'edit' => 'admin.calendario.edit',
            'update' => 'admin.calendario.update',
            'destroy' => 'admin.calendario.destroy'
        ]);
    Route::get('/admin/leads', [LeadController::class, 'index'])
        ->name('admin.leads');


    Route::resource('/admin/users', UserController::class)
        ->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy'
        ]);

    // Reset de senha por admin
    Route::post('/admin/users/{user}/reset-password', [UserController::class, 'resetPassword'])
        ->name('admin.users.reset-password');

    Route::resource('/admin/segmentacao-cliente', SegmentacaoClienteController::class)
        ->names([
            'index' => 'admin.segmentacao-cliente.index',
            'create' => 'admin.segmentacao-cliente.create',
            'store' => 'admin.segmentacao-cliente.store',
            'show' => 'admin.segmentacao-cliente.show',
            'edit' => 'admin.segmentacao-cliente.edit',
            'update' => 'admin.segmentacao-cliente.update',
            'destroy' => 'admin.segmentacao-cliente.destroy'
        ]);



    Route::get('/admin/sync-produtos', [AdminGoogleSheetController::class, 'index'])
        ->name('admin.sync-produtos');
    Route::get('/admin/sync-representantes', [AdminGoogleSheetController::class, 'indexRepresentantes'])
        ->name('admin.sync-representantes');
    Route::get('/admin/sync-sheet', [AdminGoogleSheetController::class, 'sync'])
        ->name('admin.sync-sheet');
    Route::get('/admin/sync-users', [AdminGoogleSheetController::class, 'syncUsers'])
        ->name('admin.sync-users');
    Route::get('/admin/sync-users-async', [AdminGoogleSheetController::class, 'syncUsersAsync'])
        ->name('admin.sync-users-async');
    Route::get('/admin/export-users-passwords', [AdminGoogleSheetController::class, 'exportUsersWithPasswords'])
        ->name('admin.export-users-passwords');
    Route::get('/admin/prepare-batches', [AdminGoogleSheetController::class, 'prepareBatches'])
        ->name('admin.prepare-batches');
    Route::post('/admin/execute-batch/{batchIndex}', [AdminGoogleSheetController::class, 'executeBatch'])
        ->name('admin.execute-batch');
    Route::get('/admin/clear-batches', [AdminGoogleSheetController::class, 'clearBatches'])
        ->name('admin.clear-batches');
    Route::get('/admin/batch-status', [AdminGoogleSheetController::class, 'getBatchStatus'])
        ->name('admin.batch-status');
});

Route::middleware(['auth', 'user'])->group(function () {

    Route::get('/user/segmentacao', [frontendController::class, 'index'])
        ->name('user.segmentacao');


    Route::get('/user/conta', [frontendController::class, 'conta'])->name('user.conta');
    Route::post('/user/conta/update', [frontendController::class, 'updateUser'])->name('user.conta.update');
    Route::post('/user/conta/update-password', [frontendController::class, 'updatePassword'])->name('user.conta.update-password');


    Route::get('/user/{slug}', [frontendController::class, 'slug'])
        ->name('user.slug');
    Route::get('/user/{slug}/tecnologias', [frontendController::class, 'tecnologias'])
        ->name('user.tecnologias');
    Route::get('/user/{slug}/conteudos', [frontendController::class, 'conteudos'])
        ->name('user.conteudos');
    Route::get('/user/{slug}/gerar-arquivo', [frontendController::class, 'gerarArquivo'])
        ->name('user.gerar-arquivo');
    Route::get('/user/{slug}/calendario', [frontendController::class, 'calendario'])
        ->name('user.calendario');
    Route::get('/user/{slug}/colecoes', [frontendController::class, 'colecoes'])
        ->name('user.slug.colecoes');
    Route::get('/user/{slug}/colecoes/{colecao}', [frontendController::class, 'produtos'])
        ->name('user.colecao');
    Route::get('/user/{slug}/colecoes/{colecao}/{code}/{codigo_cor}', [frontendController::class, 'detalhe_produto'])
        ->name('user.colecao.produto');

    // Export routes
    Route::post('/user/export/pdf', [ExportController::class, 'exportPdf'])->name('user.export.pdf');
    // HTML preview for debugging fonts/layout
    Route::get('/user/export/preview', [ExportController::class, 'previewHtml'])->name('user.export.preview');
    Route::get('/user/exports', [ExportController::class, 'index'])->name('exports.index');
    Route::get('/user/exports/{exportUser}', [ExportController::class, 'show'])->name('exports.show');
    Route::get('/user/exports/{exportUser}/regenerate', [ExportController::class, 'regeneratePdf'])->name('exports.regenerate');
    Route::delete('/user/exports/{exportUser}', [ExportController::class, 'destroy'])->name('exports.destroy');

    // Wishlist routes
    Route::get('/user/{slug}/favoritos', [WishlistController::class, 'index'])->name('user.wishlist');
    Route::post('/user/wishlist/add', [WishlistController::class, 'add'])->name('user.wishlist.add');
    Route::delete('/user/wishlist/remove', [WishlistController::class, 'remove'])->name('user.wishlist.remove');
    Route::get('/user/wishlist/check', [WishlistController::class, 'check'])->name('user.wishlist.check');
    Route::get('/user/wishlist/count', [WishlistController::class, 'count'])->name('user.wishlist.count');

    // AJAX routes
    Route::get('/user/api/produtos-por-categoria', [frontendController::class, 'getProdutosPorCategoria'])->name('user.api.produtos-categoria');
    Route::post('/user/api/selected-segmentacoes', [frontendController::class, 'getSelectedSegmentacoes'])->name('user.api.selected-segmentacoes');
    Route::get('/user/api/subcategories/{categoryId}', [frontendController::class, 'getSubcategories'])->name('user.api.subcategories');



    // Suggestions routes
    Route::post('/suggestions', [\App\Http\Controllers\SuggestionController::class, 'store'])->name('suggestions.store');

    // Debug de fontes: página HTML simples para verificar carregamento das variações
    Route::get('/debug/fonts', function () {
        return view('debug.fonts');
    })->name('debug.fonts');
});
require __DIR__ . '/auth.php';
