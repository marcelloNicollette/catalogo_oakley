<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TechnologyItem;
use App\Models\TechnologyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnologyItemController extends Controller
{
    public function index()
    {
        $items = TechnologyItem::with('category')->get();
        return view('admin.technology.items.index', compact('items'));
    }

    public function create()
    {
        $categories = TechnologyCategory::where('active', true)->get();
        return view('admin.technology.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'technology_category_id' => 'required|exists:technology_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:svg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/technology'), $imageName);
            $validated['icon'] = 'images/technology/' . $imageName;
        }

        TechnologyItem::create($validated);

        return redirect()->route('admin.technology.items.index')
            ->with('success', 'Item de tecnologia criado com sucesso!');
    }

    public function edit(TechnologyItem $item)
    {
        $categories = TechnologyCategory::where('active', true)->get();
        return view('admin.technology.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, TechnologyItem $item)
    {
        $validated = $request->validate([
            'technology_category_id' => 'required|exists:technology_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:svg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/technology'), $imageName);
            $validated['icon'] = 'images/technology/' . $imageName;
        } else {
            $validated['icon'] = $item->icon;
        }

        $item->update($validated);

        return redirect()->route('admin.technology.items.index')
            ->with('success', 'Item de tecnologia atualizado com sucesso!');
    }

    public function destroy(TechnologyItem $item)
    {
        if ($item->icon) {
            Storage::disk('public')->delete($item->icon);
        }

        $item->delete();

        return redirect()->route('admin.technology.items.index')
            ->with('success', 'Item de tecnologia removido com sucesso!');
    }
}
