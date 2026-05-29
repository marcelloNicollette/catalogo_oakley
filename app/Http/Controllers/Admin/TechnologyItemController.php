<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TechnologyItem;
use App\Models\TechnologyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TechnologyItemController extends Controller
{
    public function index()
    {
        $items = TechnologyItem::with('category')
            ->orderBy('technology_category_id')
            ->orderBy('name', 'asc')
            ->orderBy('id')
            ->get();
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
            'order' => 'nullable|integer|min:1',
            'active' => 'boolean'
        ]);

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/technology'), $imageName);
            $validated['icon'] = 'images/technology/' . $imageName;
        }

        DB::transaction(function () use (&$validated) {
            $categoryId = (int) $validated['technology_category_id'];
            $requestedOrder = isset($validated['order']) ? (int) $validated['order'] : null;

            $maxOrder = (int) (TechnologyItem::where('technology_category_id', $categoryId)->max('order') ?? 0);
            $newOrder = $requestedOrder ? min($requestedOrder, $maxOrder + 1) : $maxOrder + 1;

            TechnologyItem::where('technology_category_id', $categoryId)
                ->where('order', '>=', $newOrder)
                ->increment('order');

            $validated['order'] = $newOrder;

            TechnologyItem::create($validated);
        });

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
            'order' => 'nullable|integer|min:1',
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

        DB::transaction(function () use ($item, $validated) {
            $oldCategoryId = (int) $item->technology_category_id;
            $oldOrder = (int) ($item->order ?? 0);

            $newCategoryId = (int) $validated['technology_category_id'];
            $requestedOrder = array_key_exists('order', $validated) && $validated['order'] !== null
                ? (int) $validated['order']
                : null;

            if ($newCategoryId !== $oldCategoryId) {
                if ($oldOrder > 0) {
                    TechnologyItem::where('technology_category_id', $oldCategoryId)
                        ->where('order', '>', $oldOrder)
                        ->decrement('order');
                }

                $maxOrder = (int) (TechnologyItem::where('technology_category_id', $newCategoryId)->max('order') ?? 0);
                $newOrder = $requestedOrder ? min($requestedOrder, $maxOrder + 1) : $maxOrder + 1;

                TechnologyItem::where('technology_category_id', $newCategoryId)
                    ->where('order', '>=', $newOrder)
                    ->increment('order');

                $validated['order'] = $newOrder;
            } else {
                $maxOtherOrder = (int) (TechnologyItem::where('technology_category_id', $newCategoryId)
                    ->where('id', '!=', $item->id)
                    ->max('order') ?? 0);

                $maxPossible = $maxOtherOrder + 1;
                $newOrder = $requestedOrder ? min($requestedOrder, $maxPossible) : $oldOrder;

                if ($oldOrder > 0 && $newOrder !== $oldOrder) {
                    if ($newOrder < $oldOrder) {
                        TechnologyItem::where('technology_category_id', $newCategoryId)
                            ->whereBetween('order', [$newOrder, $oldOrder - 1])
                            ->increment('order');
                    } else {
                        TechnologyItem::where('technology_category_id', $newCategoryId)
                            ->whereBetween('order', [$oldOrder + 1, $newOrder])
                            ->decrement('order');
                    }
                }

                $validated['order'] = $newOrder;
            }

            $item->update($validated);
        });

        return redirect()->route('admin.technology.items.index')
            ->with('success', 'Item de tecnologia atualizado com sucesso!');
    }

    public function destroy(TechnologyItem $item)
    {
        if ($item->icon) {
            Storage::disk('public')->delete($item->icon);
        }

        DB::transaction(function () use ($item) {
            $categoryId = (int) $item->technology_category_id;
            $oldOrder = (int) ($item->order ?? 0);

            if ($oldOrder > 0) {
                TechnologyItem::where('technology_category_id', $categoryId)
                    ->where('order', '>', $oldOrder)
                    ->decrement('order');
            }

            $item->update(['order' => null]);
            $item->delete();
        });

        return redirect()->route('admin.technology.items.index')
            ->with('success', 'Item de tecnologia removido com sucesso!');
    }

    public function updateOrder(Request $request, TechnologyItem $item)
    {
        $validated = $request->validate([
            'order' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($item, $validated) {
            $categoryId = (int) $item->technology_category_id;
            $oldOrder = (int) ($item->order ?? 0);

            $maxOtherOrder = (int) (TechnologyItem::where('technology_category_id', $categoryId)
                ->where('id', '!=', $item->id)
                ->max('order') ?? 0);
            $maxPossible = $maxOtherOrder + 1;

            $newOrder = min((int) $validated['order'], $maxPossible);

            if ($oldOrder > 0 && $newOrder !== $oldOrder) {
                if ($newOrder < $oldOrder) {
                    TechnologyItem::where('technology_category_id', $categoryId)
                        ->whereBetween('order', [$newOrder, $oldOrder - 1])
                        ->increment('order');
                } else {
                    TechnologyItem::where('technology_category_id', $categoryId)
                        ->whereBetween('order', [$oldOrder + 1, $newOrder])
                        ->decrement('order');
                }
            }

            $item->update(['order' => $newOrder]);
        });

        return redirect()->route('admin.technology.items.index')
            ->with('success', 'Ordem atualizada com sucesso!');
    }
}