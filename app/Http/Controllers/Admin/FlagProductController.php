<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlagProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlagProductController extends Controller
{
    public function index()
    {
        $flags = FlagProduct::orderBy('flag_title')->paginate(10);
        return view('admin.flag-product.index', compact('flags'));
    }

    public function create()
    {
        return view('admin.flag-product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'flag_title' => 'required|string|max:255',
            'flag_description' => 'nullable|string',
            'flag_bg' => 'required|string',
            'flag_color_text_bg' => 'required|string',
            'icon' => 'nullable|image|mimes:svg,png,jpg,jpeg,gif|max:2048',
            'alinhamento' => 'nullable|string',
            'orderfilterflag' => 'required|integer|min:0',
            'status' => 'boolean'
        ]);

        $data = $request->all();

        // Processar upload da imagem
        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();
            $image->move(public_path('images/flags'), $imageName);
            $data['icon'] = 'images/flags/' . $imageName;
        }

        FlagProduct::create($data);

        return redirect()->route('admin.flag-product.index')
            ->with('success', 'Flag criada com sucesso!');
    }

    public function edit(FlagProduct $flagProduct)
    {
        return view('admin.flag-product.edit', compact('flagProduct'));
    }

    public function update(Request $request, FlagProduct $flagProduct)
    {
        $request->validate([
            'flag_title' => 'required|string|max:255',
            'flag_description' => 'nullable|string',
            'flag_bg' => 'required|string',
            'flag_color_text_bg' => 'required|string',
            'icon' => 'nullable|image|mimes:svg,png,jpg,jpeg,gif|max:2048',
            'alinhamento' => 'nullable|string',
            'orderfilterflag' => 'required|integer|min:0',
            'status' => 'boolean'
        ]);

        $data = $request->all();

        // Processar upload da imagem
        if ($request->hasFile('icon')) {
            // Remover imagem anterior se existir
            if ($flagProduct->icon && file_exists(public_path($flagProduct->icon))) {
                unlink(public_path($flagProduct->icon));
            }

            $image = $request->file('icon');
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();
            $image->move(public_path('images/flags'), $imageName);
            $data['icon'] = 'images/flags/' . $imageName;
        }

        $flagProduct->update($data);

        return redirect()->route('admin.flag-product.index')
            ->with('success', 'Flag atualizada com sucesso!');
    }

    public function destroy(FlagProduct $flagProduct)
    {

        $flagProduct->delete();

        return redirect()->route('admin.flag-product.index')
            ->with('success', 'Flag excluída com sucesso!');
    }
}
