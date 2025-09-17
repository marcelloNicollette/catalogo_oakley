<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Segmentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        //dd($categories);
        $segmentos = Segmentacao::all();
        return view('admin.categories.index', compact('categories', 'segmentos'));
    }

    public function create()
    {
        $segmentos = Segmentacao::all();
        return view('admin.categories.create', compact('segmentos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'segmento_id' => 'required|exists:segmentacao,id',
            'name' => 'required|max:255',
            'active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        //dd($validated);
        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria criada com sucesso.');
    }

    public function edit(Category $category)
    {
        $segmentos = Segmentacao::all();
        return view('admin.categories.edit', compact('category', 'segmentos'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'segmento_id' => 'required|exists:segmentacao,id',
            'name' => 'required|max:255',
            'active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria atualizada com sucesso.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria removida com sucesso.');
    }
}
