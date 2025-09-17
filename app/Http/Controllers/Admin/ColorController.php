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
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:7',
            'active' => 'boolean'
        ]);

        Color::create($validated);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor criada com sucesso.');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:7',
            'active' => 'boolean'
        ]);

        $color->update($validated);

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