<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConteudoCategory;
use Illuminate\Http\Request;

class ConteudoCategoryController extends Controller
{
    public function index()
    {
        $categories = ConteudoCategory::withCount('conteudo')->get();
        return view('admin.conteudos.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.conteudos.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'icon' => 'nullable|image|max:255',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean'
        ]);
        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/conteudos'), $imageName);
            $validated['icon'] = 'images/conteudos/' . $imageName;
        } else {
            $validated['icon'] = null;
        }
        // Define valor padrão se 'order' não for enviado
        $validated['order'] = $request->has('order') ? (int) $request->input('order') : 0;

        // Define valor padrão se 'active' não for enviado
        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;
        ConteudoCategory::create($validated);

        return redirect()->route('admin.conteudos.categories.index')
            ->with('success', 'Categoria de conteúdo criada com sucesso!');
    }

    public function edit(ConteudoCategory $category)
    {
        return view('admin.conteudos.categories.edit', compact('category'));
    }

    public function update(Request $request, ConteudoCategory $category)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'icon' => 'nullable|image|max:255',
            'order' => 'nullable|integer',
            'active' => 'nullable|boolean'
        ]);
        // Define valor padrão se 'order' não for enviado
        $validated['order'] = $request->has('order') ? (int) $request->input('order') : 0;

        // Define valor padrão se 'active' não for enviado
        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/conteudos'), $imageName);
            $validated['icon'] = 'images/conteudos/' . $imageName;
        } else {
            $validated['icon'] = $category->icon;
        }

        $category->update($validated);

        return redirect()->route('admin.conteudos.categories.index')
            ->with('success', 'Categoria de conteúdo atualizada com sucesso!');
    }

    public function destroy(ConteudoCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.conteudos.categories.index')
            ->with('success', 'Categoria de conteúdo removida com sucesso!');
    }
}
