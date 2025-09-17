<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaracteristicaProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CaracteristicaProductController extends Controller
{
    public function index()
    {
        $caracteristicas = CaracteristicaProduct::with('product')->paginate(10);
        return view('admin.caracteristicas.index', compact('caracteristicas'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.caracteristicas.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'destaque' => 'nullable|boolean',
            'product_id' => 'required|exists:products,id',
        ]);

        CaracteristicaProduct::create($request->all());

        return redirect()->route('admin.caracteristicas.index')->with('success', 'Característica criada com sucesso!');
    }

    public function edit(CaracteristicaProduct $caracteristica)
    {
        $products = Product::all();
        return view('admin.caracteristicas.edit', compact('caracteristica', 'products'));
    }

    public function update(Request $request, CaracteristicaProduct $caracteristica)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'destaque' => 'nullable|boolean',
            'product_id' => 'required|exists:products,id',
        ]);

        $caracteristica->update($request->all());

        return redirect()->route('admin.caracteristicas.index')->with('success', 'Característica atualizada com sucesso!');
    }

    public function destroy(CaracteristicaProduct $caracteristica)
    {
        $caracteristica->delete();
        return redirect()->route('admin.caracteristicas.index')->with('success', 'Característica excluída com sucesso!');
    }
}
