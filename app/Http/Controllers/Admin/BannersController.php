<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        ]);

        //dd($validated);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/banners'), $imageName);
            $validated['image'] = 'images/banners/' . $imageName;
        }
        if ($request->hasFile('image_mobile')) {
            $image_mobile = $request->file('image_mobile');
            $imageNameMobile = time() . '-mobile.' . $image_mobile->extension();
            $image_mobile->move(public_path('images/banners'), $imageNameMobile);
            $validated['image_mobile'] = 'images/banners/' . $imageNameMobile;
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
        ]);


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/banners'), $imageName);
            $validated['image'] = 'images/banners/' . $imageName;
        }
        if ($request->hasFile('image_mobile')) {
            $image_mobile = $request->file('image_mobile');
            $imageNameMobile = time() . '-mobile.' . $image_mobile->extension();
            $image_mobile->move(public_path('images/banners'), $imageNameMobile);
            $validated['image_mobile'] = 'images/banners/' . $imageNameMobile;
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
