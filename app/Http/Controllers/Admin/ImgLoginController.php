<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImgLoginRequest;
use App\Models\ImgLogin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ImgLoginController extends Controller
{
    public function index(): View
    {
        $items = ImgLogin::orderByDesc('created_at')->get();
        return view('admin.img_login.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.img_login.create');
    }

    public function store(ImgLoginRequest $request): RedirectResponse
    {
        $desktopPath = $request->file('desktop_image')->store('img_login', 'public');
        $mobilePath = $request->file('mobile_image')->store('img_login', 'public');

        ImgLogin::create([
            'desktop_image' => $desktopPath,
            'mobile_image' => $mobilePath,
        ]);

        return redirect()->route('admin.img-login.index')
            ->with('success', 'Imagens de login cadastradas com sucesso.');
    }

    public function edit(ImgLogin $imgLogin): View
    {
        return view('admin.img_login.edit', compact('imgLogin'));
    }

    public function update(ImgLoginRequest $request, ImgLogin $imgLogin): RedirectResponse
    {
        $data = [];

        if ($request->hasFile('desktop_image')) {
            if ($imgLogin->desktop_image) {
                Storage::disk('public')->delete($imgLogin->desktop_image);
            }
            $data['desktop_image'] = $request->file('desktop_image')->store('img_login', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            if ($imgLogin->mobile_image) {
                Storage::disk('public')->delete($imgLogin->mobile_image);
            }
            $data['mobile_image'] = $request->file('mobile_image')->store('img_login', 'public');
        }

        $imgLogin->update($data);

        return redirect()->route('admin.img-login.index')
            ->with('success', 'Imagens de login atualizadas com sucesso.');
    }

    public function destroy(ImgLogin $imgLogin): RedirectResponse
    {
        if ($imgLogin->desktop_image) {
            Storage::disk('public')->delete($imgLogin->desktop_image);
        }
        if ($imgLogin->mobile_image) {
            Storage::disk('public')->delete($imgLogin->mobile_image);
        }

        $imgLogin->delete();

        return redirect()->route('admin.img-login.index')
            ->with('success', 'Registro removido com sucesso.');
    }
}