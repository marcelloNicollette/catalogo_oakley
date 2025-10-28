<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->orderBy('id', 'DESC')->paginate(100);
        return view('admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'faixa' => 'required|string|max:255',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:0'
        ]);

        // Define valores padrão
        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;
        $validated['order'] = $request->has('order') ? (int) $request->input('order') : 0;
        $validated['slug'] = Str::slug($validated['faixa']);

        Subcategory::create($validated);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategoria criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        $subcategory->load('category');
        return view('admin.subcategories.show', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'faixa' => 'required|string|max:255',
            'active' => 'boolean',
            'order' => 'nullable|integer|min:0'
        ]);

        // Define valores padrão
        $validated['active'] = $request->has('active') ? (bool) $request->input('active') : true;
        $validated['order'] = $request->has('order') ? (int) $request->input('order') : 0;
        $validated['slug'] = Str::slug($validated['faixa']);

        $subcategory->update($validated);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategoria removida com sucesso!');
    }

    /**
     * Get subcategories by category (for AJAX)
     */
    public function getByCategory(Request $request)
    {
        $categoryId = $request->get('category_id');
        $subcategories = Subcategory::where('category_id', $categoryId)
            ->where('active', true)
            ->ordered()
            ->get(['id', 'faixa']);

        return response()->json($subcategories);
    }
}
