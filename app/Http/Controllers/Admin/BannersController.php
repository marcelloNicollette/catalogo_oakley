<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannersController extends Controller
{


    public function index()
    {
        $banners = Banner::orderBy('order')->paginate(50);
        return view('admin.banners.index', compact('banners'));
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:banners,id',
        ]);

        foreach ($request->order as $index => $id) {
            Banner::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'image.uploaded' => 'Falha ao enviar a imagem. Verifique o diretório temporário do PHP (upload_tmp_dir) e permissões.',
            'image_mobile.uploaded' => 'Falha ao enviar a imagem mobile. Verifique o diretório temporário do PHP (upload_tmp_dir) e permissões.',
            'image.mimes' => 'A imagem deve ser um arquivo do tipo: jpeg, png, jpg ou gif.',
            'image_mobile.mimes' => 'A imagem mobile deve ser um arquivo do tipo: jpeg, png, jpg ou gif.',
        ];

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_mobile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean',
            'link' => [
                'nullable',
                'string',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value && !preg_match('/^(https?:\\/\\/|\\/)/i', $value)) {
                        $fail('O link deve iniciar com http(s):// ou /.');
                    }
                },
            ],
            'access_levels' => 'nullable|array',
            'access_levels.*' => 'string|in:representante,interno,fornecedor,convidado,cliente',
        ], $messages);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/banners', 'public');
            $validated['image'] = 'storage/' . $path;
        }
        if ($request->hasFile('image_mobile')) {
            $pathMobile = $request->file('image_mobile')->store('images/banners', 'public');
            $validated['image_mobile'] = 'storage/' . $pathMobile;
        }
        //dd($validated);
        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner criado com sucesso.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $messages = [
            'image.uploaded' => 'Falha ao enviar a imagem. Verifique o diretório temporário do PHP (upload_tmp_dir) e permissões.',
            'image_mobile.uploaded' => 'Falha ao enviar a imagem mobile. Verifique o diretório temporário do PHP (upload_tmp_dir) e permissões.',
            'image.mimes' => 'A imagem deve ser um arquivo do tipo: jpeg, png, jpg ou gif.',
            'image_mobile.mimes' => 'A imagem mobile deve ser um arquivo do tipo: jpeg, png, jpg ou gif.',
        ];

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean',
            'link' => [
                'nullable',
                'string',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value && !preg_match('/^(https?:\\/\\/|\\/)/i', $value)) {
                        $fail('O link deve iniciar com http(s):// ou /.');
                    }
                },
            ],
            'access_levels' => 'nullable|array',
            'access_levels.*' => 'string|in:representante,interno,fornecedor,convidado,cliente',
        ], $messages);

        $accessLevels = $request->input('access_levels');
        if (is_array($accessLevels) && count($accessLevels) > 0) {
            $validated['access_levels'] = array_values($accessLevels);
        } else {
            $validated['access_levels'] = null;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/banners', 'public');
            $validated['image'] = 'storage/' . $path;
        }
        if ($request->hasFile('image_mobile')) {
            $pathMobile = $request->file('image_mobile')->store('images/banners', 'public');
            $validated['image_mobile'] = 'storage/' . $pathMobile;
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner atualizado com sucesso.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner removido com sucesso.');
    }
}
