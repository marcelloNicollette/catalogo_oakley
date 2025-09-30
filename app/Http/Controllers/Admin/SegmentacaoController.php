<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Segmentacao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SegmentacaoController extends Controller
{


    public function index()
    {
        $segmentos = Segmentacao::paginate(10);
        return view('admin.segmento.index', compact('segmentos'));
    }

    public function create()
    {
        return view('admin.segmento.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'segmento' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['segmento']);
        //dd($validated);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/segmentacao'), $imageName);
            $validated['image'] = 'images/segmentacao/' . $imageName;
        }
        if ($request->hasFile('image_mobile')) {
            $image_mobile = $request->file('image_mobile');
            $imageNameMobile = time() . '-mobile.' . $image_mobile->extension();
            $image_mobile->move(public_path('images/segmentacao'), $imageNameMobile);
            $validated['image_mobile'] = 'images/segmentacao/' . $imageNameMobile;
        }
        //dd($validated);
        Segmentacao::create($validated);

        return redirect()->route('admin.segmento.index')
            ->with('success', 'Segmento criada com sucesso.');
    }

    public function edit(Segmentacao $segmento)
    {
        return view('admin.segmento.edit', compact('segmento'));
    }

    public function update(Request $request, Segmentacao $segmento)
    {
        $validated = $request->validate([
            'segmento' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['segmento']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/segmentacao'), $imageName);
            $validated['image'] = 'images/segmentacao/' . $imageName;
        }
        if ($request->hasFile('image_mobile')) {
            $image_mobile = $request->file('image_mobile');
            $imageNameMobile = time() . '-mobile.' . $image_mobile->extension();
            $image_mobile->move(public_path('images/segmentacao'), $imageNameMobile);
            $validated['image_mobile'] = 'images/segmentacao/' . $imageNameMobile;
        }

        $segmento->update($validated);

        return redirect()->route('admin.segmento.index')
            ->with('success', 'Segmento atualizada com sucesso.');
    }

    public function destroy(Segmentacao $segmento)
    {
        $segmento->delete();

        return redirect()->route('admin.segmento.index')
            ->with('success', 'Segmento removida com sucesso.');
    }
}
