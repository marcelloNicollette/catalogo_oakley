<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conteudo;
use App\Models\ConteudoCategory;
use Illuminate\Http\Request;

class ConteudoController extends Controller
{
    public function index()
    {
        $conteudos = Conteudo::withCount('category')->get();
        $categories = ConteudoCategory::get();
        return view('admin.conteudos.items.index', compact('conteudos', 'categories'));
    }

    public function create()
    {
        $categories = ConteudoCategory::get();
        return view('admin.conteudos.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conteudo_category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
            'access_levels' => 'nullable|array',
            'access_levels.*' => 'string|in:representante,interno,fornecedor,convidado,cliente',
        ]);
        // Define valor padrão se 'order' não for enviado
        $validated['order'] = $request->has('order') ? (int) $request->input('order') : 0;

        // Define valor padrão se 'active' não for enviado
        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;
        Conteudo::create($validated);

        return redirect()->route('admin.conteudos.items.index')
            ->with('success', 'Conteúdo criado com sucesso!');
    }

    public function edit(Conteudo $item)
    {
        $categories = ConteudoCategory::get();
        return view('admin.conteudos.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Conteudo $item)
    {
        $validated = $request->validate([
            'conteudo_category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean',
            'access_levels' => 'nullable|array',
            'access_levels.*' => 'string|in:representante,interno,fornecedor,convidado,cliente',
        ]);
        // Define valor padrão se 'order' não for enviado
        $validated['order'] = $request->has('order') ? (int) $request->input('order') : 0;

        // Define valor padrão se 'active' não for enviado
        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;
        //dd($item->update($validated));
        $item->update($validated);

        return redirect()->route('admin.conteudos.items.index')
            ->with('success', 'Conteúdo atualizado com sucesso!');
    }

    public function destroy(Conteudo $item)
    {
        $item->delete();

        return redirect()->route('admin.conteudos.items.index')
            ->with('success', 'Conteúdo removido com sucesso!');
    }
}
