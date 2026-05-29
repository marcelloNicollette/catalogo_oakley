<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShoeGrid;
use App\Models\ShoeGridGroup;
use App\Models\ShoeGridItem;
use App\Models\ShoeSize;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ShoeGridController extends Controller
{
    // ─── INDEX ───────────────────────────────────────────────────────────────

    public function index()
    {
        $sizes = ShoeSize::active()->get();

        // Grupos com suas grades e itens carregados de uma vez (evita N+1)
        $groups = ShoeGridGroup::with([
            'grids' => fn($q) => $q->orderBy('sort_order')->with('items'),
        ])
            ->active()
            ->get();

        return view('admin.shoe-grids.index', compact('groups', 'sizes'));
    }

    // ─── GRUPOS ──────────────────────────────────────────────────────────────

    public function createGroup()
    {
        return view('admin.shoe-grids.group-form', ['group' => new ShoeGridGroup]);
    }

    public function storeGroup(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'sort_order' => 'integer|min:0',
            'active'     => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);

        ShoeGridGroup::create($data);

        return redirect()->route('admin.shoe-grids.index')
                         ->with('success', 'Grupo criado com sucesso.');
    }

    public function editGroup(ShoeGridGroup $group)
    {
        return view('admin.shoe-grids.group-form', compact('group'));
    }

    public function updateGroup(Request $request, ShoeGridGroup $group)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'sort_order' => 'integer|min:0',
            'active'     => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $group->update($data);

        return redirect()->route('admin.shoe-grids.index')
                         ->with('success', 'Grupo atualizado.');
    }

    public function destroyGroup(ShoeGridGroup $group)
    {
        $group->delete();

        return redirect()->route('admin.shoe-grids.index')
                         ->with('success', 'Grupo removido.');
    }

    // ─── GRADES ──────────────────────────────────────────────────────────────

    public function createGrid()
    {
        $groups = ShoeGridGroup::active()->get();
        $sizes  = ShoeSize::active()->get();

        return view('admin.shoe-grids.grid-form', [
            'grid'   => new ShoeGrid,
            'groups' => $groups,
            'sizes'  => $sizes,
        ]);
    }

    public function storeGrid(Request $request)
    {
        $data = $request->validate([
            'shoe_size_group_id' => 'required|exists:shoe_size_groups,id',
            'code'               => [
                'required', 'string', 'max:20',
                Rule::unique('shoe_grids')->where(
                    fn($q) => $q->where('shoe_size_group_id', $request->shoe_size_group_id)
                ),
            ],
            'description'        => 'nullable|string|max:255',
            'sort_order'         => 'integer|min:0',
            'active'             => 'boolean',
            'quantities'         => 'nullable|array',  // [shoe_size_id => quantity]
            'quantities.*'       => 'nullable|integer|min:0|max:99',
        ]);

        $grid = ShoeGrid::create($data);

        $this->syncItems($grid, $request->input('quantities', []));

        return redirect()->route('admin.shoe-grids.index')
                         ->with('success', 'Grade criada com sucesso.');
    }

    public function editGrid(ShoeGrid $grid)
    {
        $groups = ShoeGridGroup::active()->get();
        $sizes  = ShoeSize::active()->get();
        $grid->load('items');

        return view('admin.shoe-grids.grid-form', compact('grid', 'groups', 'sizes'));
    }

    public function updateGrid(Request $request, ShoeGrid $grid)
    {
        $data = $request->validate([
            'shoe_size_group_id' => 'required|exists:shoe_size_groups,id',
            'code'               => [
                'required', 'string', 'max:20',
                Rule::unique('shoe_grids')
                    ->where(fn($q) => $q->where('shoe_size_group_id', $request->shoe_size_group_id))
                    ->ignore($grid->id),
            ],
            'description'        => 'nullable|string|max:255',
            'sort_order'         => 'integer|min:0',
            'active'             => 'boolean',
            'quantities'         => 'nullable|array',
            'quantities.*'       => 'integer|min:0|max:99',
        ]);

        $grid->update($data);

        $this->syncItems($grid, $request->input('quantities', []));

        return redirect()->route('admin.shoe-grids.index')
                         ->with('success', 'Grade atualizada.');
    }

    public function destroyGrid(ShoeGrid $grid)
    {
        $grid->delete();

        return redirect()->route('admin.shoe-grids.index')
                         ->with('success', 'Grade removida.');
    }

    // ─── EDIÇÃO INLINE (AJAX) ─────────────────────────────────────────────────

    /**
     * Atualiza a quantidade de um item específico via AJAX.
     * POST /admin/shoe-grids/items/update
     */
    public function updateItem(Request $request)
    {
        $validated = $request->validate([
            'shoe_grid_id' => 'required|exists:shoe_grids,id',
            'shoe_size_id' => 'required|exists:shoe_sizes,id',
            'quantity'     => 'required|integer|min:0|max:99',
        ]);

        ShoeGridItem::updateOrCreate(
            [
                'shoe_grid_id' => $validated['shoe_grid_id'],
                'shoe_size_id' => $validated['shoe_size_id'],
            ],
            ['quantity' => $validated['quantity']]
        );

        return response()->json(['ok' => true]);
    }

    // ─── TAMANHOS ─────────────────────────────────────────────────────────────

    public function sizes()
    {
        $sizes = ShoeSize::orderBy('sort_order')->paginate(30);

        return view('admin.shoe-grids.sizes', compact('sizes'));
    }

    public function storeSize(Request $request)
    {
        $data = $request->validate([
            'bra'        => 'nullable|numeric|min:10|max:60',
            'usw'        => 'nullable|string|max:10',
            'usm'        => 'nullable|string|max:10',
            'sort_order' => 'integer|min:0',
            'active'     => 'boolean',
        ]);

        ShoeSize::create($data);

        return back()->with('success', 'Tamanho criado.');
    }

    public function updateSize(Request $request, ShoeSize $size)
    {
        $data = $request->validate([
            'bra'        => 'nullable|numeric|min:10|max:60',
            'usw'        => 'nullable|string|max:10',
            'usm'        => 'nullable|string|max:10',
            'sort_order' => 'integer|min:0',
            'active'     => 'boolean',
        ]);

        $size->update($data);

        return back()->with('success', 'Tamanho atualizado.');
    }

    public function destroySize(ShoeSize $size)
    {
        $size->delete();

        return back()->with('success', 'Tamanho removido.');
    }

    // ─── HELPER ───────────────────────────────────────────────────────────────

    private function syncItems(ShoeGrid $grid, array $quantities): void
    {
        foreach ($quantities as $sizeId => $qty) {
            $qty = (int) $qty;

            if ($qty > 0) {
                ShoeGridItem::updateOrCreate(
                    ['shoe_grid_id' => $grid->id, 'shoe_size_id' => $sizeId],
                    ['quantity' => $qty]
                );
            } else {
                // Remove o registro se quantidade for 0 (mantém tabela limpa)
                ShoeGridItem::where('shoe_grid_id', $grid->id)
                             ->where('shoe_size_id', $sizeId)
                             ->delete();
            }
        }
    }
}
