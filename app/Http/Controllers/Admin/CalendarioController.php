<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calendario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CalendarioController extends Controller
{
    public function index()
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
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('admin.calendario.index', compact('calendarios'));
    }

    public function create()
    {
        return view('admin.calendario.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ano' => 'required|string|max:4',
            'mes' => 'required|integer|between:1,12',
            'info_1' => 'nullable|string|max:255',
            'info_2' => 'nullable|string|max:255',
            'data' => 'nullable|date',
            'data_mkt' => 'nullable|date',
            'data_trade' => 'nullable|date',
            'data_cliente' => 'nullable|date',
            'data_dtc' => 'nullable|date',
            'access_levels' => 'nullable|array',
            'access_levels.*' => 'string|in:representante,interno,fornecedor,convidado,cliente',
        ]);

        // Upload da imagem se fornecida
        if ($request->hasFile('img')) {
            $validated['img'] = $request->file('img')->store('calendario', 'public');
        }

        Calendario::create($validated);

        return redirect()->route('admin.calendario.index')
            ->with('success', 'Item do calendário criado com sucesso.');
    }

    public function show(Calendario $calendario)
    {
        return view('admin.calendario.show', compact('calendario'));
    }

    public function edit(Calendario $calendario)
    {
        $calendario->load(['product', 'product.colors' => function ($query) {
            $query->limit(1);
        }]);

        return view('admin.calendario.edit', compact('calendario'));
    }

    public function update(Request $request, Calendario $calendario)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ano' => 'required|string|max:4',
            'mes' => 'required|integer|between:1,12',
            'info_1' => 'nullable|string|max:255',
            'info_2' => 'nullable|string|max:255',
            'data' => 'nullable|date',
            'data_mkt' => 'nullable|date',
            'data_trade' => 'nullable|date',
            'data_cliente' => 'nullable|date',
            'data_dtc' => 'nullable|date',
            'access_levels' => 'nullable|array',
            'access_levels.*' => 'string|in:representante,interno,fornecedor,convidado,cliente',
        ]);

        // Upload da nova imagem se fornecida
        if ($request->hasFile('img')) {
            // Remove a imagem antiga se existir
            if ($calendario->img) {
                Storage::disk('public')->delete($calendario->img);
            }
            $validated['img'] = $request->file('img')->store('calendario', 'public');
        }

        $calendario->update($validated);

        return redirect()->route('admin.calendario.index')
            ->with('success', 'Item do calendário atualizado com sucesso.');
    }

    public function destroy(Calendario $calendario)
    {
        // Remove a imagem se existir
        if ($calendario->img) {
            Storage::disk('public')->delete($calendario->img);
        }

        $calendario->delete();

        return redirect()->route('admin.calendario.index')
            ->with('success', 'Item do calendário removido com sucesso.');
    }
}
