<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TechnologyCategory;
use Illuminate\Http\Request;

class TechnologyCategoryController extends Controller
{
    public function index()
    {
        $categories = TechnologyCategory::withCount('items')->get();
        return view('admin.technology.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.technology.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'active' => 'boolean'
        ]);

        TechnologyCategory::create($validated);

        return redirect()->route('admin.technology.categories.index')
            ->with('success', 'Categoria de tecnologia criada com sucesso!');
    }

    public function edit(TechnologyCategory $category)
    {
        return view('admin.technology.categories.edit', compact('category'));
    }

    public function update(Request $request, TechnologyCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'active' => 'boolean'
        ]);

        $category->update($validated);

        return redirect()->route('admin.technology.categories.index')
            ->with('success', 'Categoria de tecnologia atualizada com sucesso!');
    }

    public function destroy(TechnologyCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.technology.categories.index')
            ->with('success', 'Categoria de tecnologia removida com sucesso!');
    }
}