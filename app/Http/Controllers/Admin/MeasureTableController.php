<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MeasureCategory;
use App\Models\MeasureCell;
use App\Models\MeasureColumn;
use App\Models\MeasureRow;
use App\Models\MeasureTable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MeasureTableController extends Controller
{
    // ─── INDEX ───────────────────────────────────────────────────────────────

    public function index()
    {
        $categories = MeasureCategory::with([
            'columns' => fn($q) => $q->active(),
            'tables'  => fn($q) => $q->active()->with([
                'rows' => fn($q) => $q->with('cells'),
            ]),
        ])->active()->get();

        return view('admin.measure-tables.index', compact('categories'));
    }

    // ─── CATEGORIAS ──────────────────────────────────────────────────────────

    public function createCategory()
    {
        return view('admin.measure-tables.category-form', [
            'category' => new MeasureCategory,
        ]);
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'active'     => 'nullable|boolean',
        ]);
        $data['slug']       = Str::slug($data['name']);
        $data['active']     = $request->boolean('active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        MeasureCategory::create($data);

        return redirect()->route('admin.measure-tables.index')
                         ->with('success', 'Categoria criada.');
    }

    public function editCategory(MeasureCategory $category)
    {
        return view('admin.measure-tables.category-form', compact('category'));
    }

    public function updateCategory(Request $request, MeasureCategory $category)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'active'     => 'nullable|boolean',
        ]);
        $data['slug']       = Str::slug($data['name']);
        $data['active']     = $request->boolean('active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $category->update($data);

        return redirect()->route('admin.measure-tables.index')
                         ->with('success', 'Categoria atualizada.');
    }

    public function destroyCategory(MeasureCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.measure-tables.index')
                         ->with('success', 'Categoria removida.');
    }

    // ─── COLUNAS ─────────────────────────────────────────────────────────────

    public function columns(MeasureCategory $category)
    {
        $columns = $category->columns()->get();
        return view('admin.measure-tables.columns', compact('category', 'columns'));
    }

    public function storeColumn(Request $request, MeasureCategory $category)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'active'     => 'nullable|boolean',
        ]);
        $data['measure_category_id'] = $category->id;
        $data['active']              = $request->boolean('active', true);
        $data['sort_order']          = $data['sort_order'] ?? 0;

        MeasureColumn::create($data);

        return back()->with('success', 'Coluna adicionada.');
    }

    public function updateColumn(Request $request, MeasureColumn $column)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'active'     => 'nullable|boolean',
        ]);
        $data['active']     = $request->boolean('active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $column->update($data);

        return back()->with('success', 'Coluna atualizada.');
    }

    public function destroyColumn(MeasureColumn $column)
    {
        $categoryId = $column->measure_category_id;
        $column->delete();
        return redirect()->route('admin.measure-tables.columns', $categoryId)
                         ->with('success', 'Coluna removida.');
    }

    // ─── TABELAS ─────────────────────────────────────────────────────────────

    public function createTable()
    {
        $categories = MeasureCategory::active()->get();
        return view('admin.measure-tables.table-form', [
            'measureTable' => new MeasureTable,
            'categories'   => $categories,
        ]);
    }

    public function storeTable(Request $request)
    {
        $data = $request->validate([
            'measure_category_id' => 'required|exists:measure_categories,id',
            'name'                => 'required|string|max:150',
            'sort_order'          => 'nullable|integer|min:0',
            'active'              => 'nullable|boolean',
        ]);
        $data['active']     = $request->boolean('active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        MeasureTable::create($data);

        return redirect()->route('admin.measure-tables.index')
                         ->with('success', 'Tabela criada.');
    }

    public function editTable(MeasureTable $measureTable)
    {
        $categories = MeasureCategory::active()->get();
        $columns    = $measureTable->category->columns()->active()->get();

        // Carrega rows com cells para preencher o form
        $measureTable->load(['rows.cells']);

        return view('admin.measure-tables.table-form', compact('measureTable', 'categories', 'columns'));
    }

    public function updateTable(Request $request, MeasureTable $measureTable)
    {
        $data = $request->validate([
            'measure_category_id' => 'required|exists:measure_categories,id',
            'name'                => 'required|string|max:150',
            'sort_order'          => 'nullable|integer|min:0',
            'active'              => 'nullable|boolean',
            'rows'                => 'nullable|array',
            'rows.*.label'        => 'required|string|max:50',
            'rows.*.cells'        => 'nullable|array',
            'rows.*.cells.*'      => 'nullable|string|max:100',
        ]);

        $measureTable->update([
            'measure_category_id' => $data['measure_category_id'],
            'name'                => $data['name'],
            'sort_order'          => $data['sort_order'] ?? 0,
            'active'              => $request->boolean('active'),
        ]);

        // Sincroniza rows e cells
        $this->syncRows($measureTable, $request->input('rows', []));

        return redirect()->route('admin.measure-tables.index')
                         ->with('success', 'Tabela atualizada.');
    }

    public function destroyTable(MeasureTable $measureTable)
    {
        $measureTable->delete();
        return redirect()->route('admin.measure-tables.index')
                         ->with('success', 'Tabela removida.');
    }

    // ─── EDIÇÃO INLINE DE CÉLULA (AJAX) ──────────────────────────────────────

    public function updateCell(Request $request)
    {
        $validated = $request->validate([
            'measure_row_id'    => 'required|exists:measure_rows,id',
            'measure_column_id' => 'required|exists:measure_columns,id',
            'value'             => 'nullable|string|max:100',
        ]);

        MeasureCell::updateOrCreate(
            [
                'measure_row_id'    => $validated['measure_row_id'],
                'measure_column_id' => $validated['measure_column_id'],
            ],
            ['value' => $validated['value'] ?? '']
        );

        return response()->json(['ok' => true]);
    }

    // ─── LINHA: adicionar/remover via form ────────────────────────────────────

    public function storeRow(Request $request, MeasureTable $measureTable)
    {
        $data = $request->validate([
            'label'      => 'required|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data['measure_table_id'] = $measureTable->id;
        $data['sort_order']       = $data['sort_order'] ?? ($measureTable->rows()->count() + 1);

        MeasureRow::create($data);

        return back()->with('success', 'Linha adicionada.');
    }

    public function destroyRow(MeasureRow $row)
    {
        $tableId = $row->measure_table_id;
        $row->delete();
        return redirect()->route('admin.measure-tables.edit-table', $tableId)
                         ->with('success', 'Linha removida.');
    }

    // ─── HELPER ───────────────────────────────────────────────────────────────

    private function syncRows(MeasureTable $measureTable, array $rows): void
    {
        // Mantém apenas IDs vindos do form
        $existingIds = [];

        foreach ($rows as $rowData) {
            $rowId = $rowData['id'] ?? null;

            if ($rowId) {
                $row = MeasureRow::find($rowId);
                if ($row) {
                    $row->update([
                        'label'      => $rowData['label'],
                        'sort_order' => $rowData['sort_order'] ?? 0,
                    ]);
                }
            } else {
                $row = MeasureRow::create([
                    'measure_table_id' => $measureTable->id,
                    'label'            => $rowData['label'],
                    'sort_order'       => $rowData['sort_order'] ?? 0,
                ]);
            }

            $existingIds[] = $row->id;

            // Sincroniza células da linha
            foreach ($rowData['cells'] ?? [] as $columnId => $value) {
                if (trim((string) $value) !== '') {
                    MeasureCell::updateOrCreate(
                        ['measure_row_id' => $row->id, 'measure_column_id' => $columnId],
                        ['value' => $value]
                    );
                } else {
                    MeasureCell::where('measure_row_id', $row->id)
                               ->where('measure_column_id', $columnId)
                               ->delete();
                }
            }
        }

        // Remove rows que não vieram no form
        $measureTable->rows()
                     ->whereNotIn('id', $existingIds)
                     ->each(fn($r) => $r->delete());
    }
}
