<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    public function index()
    {
        $dbImages = ProductImage::orderByRaw('BINARY filename')
            ->paginate(60);

        $diskPath = public_path('images/produtos');
        $folderImages = [];
        if (File::exists($diskPath)) {
            $files = File::files($diskPath);
            foreach ($files as $f) {
                $folderImages[] = [
                    'filename' => $f->getFilename(),
                    'path' => 'images/produtos/' . $f->getFilename(),
                    'size' => $f->getSize(),
                    'mime' => File::mimeType($f->getRealPath()),
                ];
            }
        }

        return view('admin.product-images.index', compact('dbImages', 'folderImages'));
    }

    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));
        $query = ProductImage::query();
        if ($q !== '') {
            $query->where('filename', 'LIKE', "%{$q}%");
        }
        $dbImages = $query->orderBy('filename')->paginate(40);
        return view('admin.product-images.partials.cards', compact('dbImages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg|mimetypes:image/jpeg|max:600', // 600 KB
        ]);

        if ($request->hasFile('images')) {
            // Ensure target directory exists
            if (!File::exists(public_path('images/produtos'))) {
                File::makeDirectory(public_path('images/produtos'), 0755, true);
            }
            foreach ($request->file('images') as $image) {
                $originalName = $image->getClientOriginalName();
                // Normaliza para .jpg se vier .jpeg
                $extension = strtolower($image->getClientOriginalExtension());
                if ($extension === 'jpeg') {
                    $filename = pathinfo($originalName, PATHINFO_FILENAME) . '.jpg';
                } else {
                    $filename = $originalName;
                }
                $targetPath = public_path('images/produtos/' . $filename);

                // If exists, delete previous file
                if (File::exists($targetPath)) {
                    File::delete($targetPath);
                }

                // Capture metadata before moving the file to avoid temp path issues
                $size = $image->getSize();
                $mime = 'image/jpeg';

                // Move new file
                $image->move(public_path('images/produtos'), $filename);

                $fullPath = 'images/produtos/' . $filename;

                // Upsert into DB by filename; replace existing
                ProductImage::updateOrCreate(
                    ['filename' => $filename],
                    ['path' => $fullPath, 'size' => $size, 'mime' => $mime]
                );
            }
        }

        return redirect()->route('admin.product-images.index')
            ->with('success', 'Upload concluído com sucesso.');
    }

    public function syncFolder()
    {
        $diskPath = public_path('images/produtos');
        if (!File::exists($diskPath)) {
            return redirect()->route('admin.product-images.index')
                ->with('error', 'Pasta images/produtos não encontrada.');
        }

        $files = File::files($diskPath);
        $chunkSize = 500;
        $chunks = array_chunk($files, $chunkSize);
        foreach ($chunks as $chunk) {
            foreach ($chunk as $f) {
                ProductImage::updateOrCreate(
                    ['filename' => $f->getFilename()],
                    [
                        'path' => 'images/produtos/' . $f->getFilename(),
                        'size' => $f->getSize(),
                        'mime' => File::mimeType($f->getRealPath()),
                    ]
                );
            }
        }

        return redirect()->route('admin.product-images.index')
            ->with('success', 'Sincronização com a pasta concluída.');
    }

    public function destroy(ProductImage $productImage)
    {

        $productImage->delete();

        return redirect()->route('admin.product-images.index')
            ->with('success', 'Imagem removida.');
    }
}
