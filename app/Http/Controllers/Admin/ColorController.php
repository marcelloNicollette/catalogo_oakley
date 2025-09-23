<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::paginate(10);
        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        $segmentacoesCliente = \App\Models\SegmentacaoCliente::where('active', true)->get();
        return view('admin.colors.create', compact('segmentacoesCliente'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:7',
            'active' => 'boolean',
            'segmentacoes_cliente' => 'nullable|array',
            'segmentacoes_cliente.*' => 'exists:segmentacao_cliente,id'
        ]);

        $color = Color::create($validated);

        // Sincronizar segmentações de cliente
        if ($request->has('segmentacoes_cliente')) {
            $color->segmentacoesCliente()->sync($request->segmentacoes_cliente);
        }

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor criada com sucesso.');
    }

    public function edit(Color $color)
    {
        $segmentacoesCliente = \App\Models\SegmentacaoCliente::where('active', true)->get();
        $color->load('segmentacoesCliente');
        return view('admin.colors.edit', compact('color', 'segmentacoesCliente'));
    }

    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:7',
            'active' => 'boolean',
            'segmentacoes_cliente' => 'nullable|array',
            'segmentacoes_cliente.*' => 'exists:segmentacao_cliente,id'
        ]);

        $color->update($validated);

        // Sincronizar segmentações de cliente
        if ($request->has('segmentacoes_cliente')) {
            $color->segmentacoesCliente()->sync($request->segmentacoes_cliente);
        } else {
            // Se não há segmentações selecionadas, remove todas
            $color->segmentacoesCliente()->detach();
        }

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor atualizada com sucesso.');
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor removida com sucesso.');
    }
}