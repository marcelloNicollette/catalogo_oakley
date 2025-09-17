<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::paginate(10);
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'size' => 'required|max:255',
            'active' => 'boolean'
        ]);

        Size::create($validated);

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Tamanho criado com sucesso.');
    }

    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        $validated = $request->validate([
            'size' => 'required|max:255',
            'active' => 'boolean'
        ]);

        $size->update($validated);

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Tamanho atualizado com sucesso.');
    }

    public function destroy(Size $size)
    {
        $size->delete();

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Tamanho removido com sucesso.');
    }
}
