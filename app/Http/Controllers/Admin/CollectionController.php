<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Segmentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::get();
        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        $segmentacoes = Segmentacao::where('active', true)->get();
        return view('admin.collections.create', compact('segmentacoes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'codigo_colecao' => 'required|max:255',
            'bg_color' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'segmentacao_id' => 'nullable|exists:segmentacao,id',
            'active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']) . "-" . Str::slug($validated['codigo_colecao']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/collections'), $imageName);
            $validated['image'] = 'images/collections/' . $imageName;
        }
        //dd($validated);
        Collection::create($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Coleção criada com sucesso.');
    }

    public function edit(Collection $collection)
    {
        $segmentacoes = Segmentacao::where('active', true)->get();
        return view('admin.collections.edit', compact('collection', 'segmentacoes'));
    }

    public function update(Request $request, Collection $collection)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
            'codigo_colecao' => 'nullable|max:255',
            'slug' => 'required|max:255',
            'bg_color' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'segmentacao_id' => 'nullable|exists:segmentacao,id',
            'active' => 'boolean'
        ]);
        //dd($validated);
        //$validated['slug'] = Str::slug($validated['name']) . "-" . Str::slug($validated['codigo_colecao']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/collections'), $imageName);
            $validated['image'] = 'images/collections/' . $imageName;
        }

        $collection->update($validated);
        //dd($collection);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Coleção atualizada com sucesso.');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();

        return redirect()->route('admin.collections.index')
            ->with('success', 'Coleção removida com sucesso.');
    }
}
