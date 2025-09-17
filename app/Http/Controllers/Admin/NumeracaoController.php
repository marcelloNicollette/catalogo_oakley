<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Numeracao;
use Illuminate\Http\Request;

class NumeracaoController extends Controller
{
    public function index()
    {
        $numeracao = Numeracao::paginate(10);
        return view('admin.numeracao.index', compact('numeracao'));
    }

    public function create()
    {
        return view('admin.numeracao.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|max:255',
            'active' => 'boolean'
        ]);

        Numeracao::create($validated);

        return redirect()->route('admin.numeracao.index')
            ->with('success', 'Numeração criado com sucesso.');
    }

    public function edit(Numeracao $numeracao)
    {
        return view('admin.numeracao.edit', compact('numeracao'));
    }

    public function update(Request $request, Numeracao $numeracao)
    {
        $validated = $request->validate([
            'numero' => 'required|max:255',
            'active' => 'boolean'
        ]);

        $numeracao->update($validated);

        return redirect()->route('admin.numeracao.index')
            ->with('success', 'Numeração atualizado com sucesso.');
    }

    public function destroy(Numeracao $numeracao)
    {
        $numeracao->delete();

        return redirect()->route('admin.numeracao.index')
            ->with('success', 'Numeração removido com sucesso.');
    }
}
