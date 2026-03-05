<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::orderBy('order')->get();
        return view('admin.menu-items.index', compact('menuItems'));
    }

    public function create()
    {
        $classifications = [
            'admin-user',
            'representante',
            'interno',
            'fornecedor',
            'convidado',
            'cliente'
        ];
        return view('admin.menu-items.create', compact('classifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'integer',
            'allowed_classifications' => 'nullable|array',
            'active' => 'boolean',
        ]);

        MenuItem::create($request->all());

        return redirect()->route('admin.menu-items.index')->with('success', 'Item de menu criado com sucesso.');
    }

    public function edit(MenuItem $menuItem)
    {
        $classifications = [
            'admin-user',
            'representante',
            'interno',
            'fornecedor',
            'convidado',
            'cliente'
        ];
        return view('admin.menu-items.edit', compact('menuItem', 'classifications'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $request->merge(['active' => $request->input('active', 0)]);
        $request->merge(['allowed_classifications' => $request->input('allowed_classifications', null)]);
        //dd($request->all());
        $request->validate([
            'label' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'order' => 'integer',
            'allowed_classifications' => 'nullable|array',
            'active' => 'boolean',
        ]);

        $menuItem->update($request->all());

        return redirect()->route('admin.menu-items.index')->with('success', 'Item de menu atualizado com sucesso.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return redirect()->route('admin.menu-items.index')->with('success', 'Item de menu removido com sucesso.');
    }
}
