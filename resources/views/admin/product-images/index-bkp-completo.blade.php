@extends('layouts.admin-layout')

@section('page_title', 'Upload de Imagens de Produtos')

@section('content-wrapper')
    <div class="content-full">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow-sm rounded p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Upload de imagens (máx 600KB)</h2>
            <form method="POST" action="{{ route('admin.product-images.store') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <input type="file" name="images[]" multiple accept="image/*" class="border rounded p-2 w-full" />
                <p class="text-sm text-gray-600">Se o nome já existir, o arquivo anterior será substituído.</p>
                @error('images.*')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Enviar</button>
            </form>

            <form method="POST" action="{{ route('admin.product-images.sync') }}" class="mt-4">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded">Sincronizar com pasta
                    public/images/produtos</button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white shadow-sm rounded p-6">
                <h3 class="text-lg font-semibold mb-3">Imagens cadastradas (Banco)</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($dbImages as $img)
                        <div class="border rounded overflow-hidden bg-gray-50">
                            <a href="/{{ $img->path }}" target="_blank" class="block aspect-square bg-white">
                                <img src="/{{ $img->path }}" alt="{{ $img->filename }}"
                                    class="w-full h-full object-cover" />
                            </a>
                            <div class="p-2 text-sm">
                                <div class="font-medium truncate" title="{{ $img->filename }}">{{ $img->filename }}</div>
                                <div class="text-gray-600">{{ number_format(($img->size ?? 0) / 1024, 1) }} KB</div>
                                <div class="mt-2">
                                    <form method="POST" action="{{ route('admin.product-images.destroy', $img) }}"
                                        onsubmit="return confirm('Remover imagem?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1 bg-red-600 text-white rounded text-xs">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">{{ $dbImages->links() }}</div>
            </div>

            <div class="bg-white shadow-sm rounded p-6">
                <h3 class="text-lg font-semibold mb-3">Conteúdo da pasta public/images/produtos</h3>
                @if (count($folderImages) > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach ($folderImages as $f)
                            <div class="border rounded overflow-hidden bg-gray-50">
                                <a href="/{{ $f['path'] }}" target="_blank" class="block aspect-square bg-white">
                                    <img src="/{{ $f['path'] }}" alt="{{ $f['filename'] }}"
                                        class="w-full h-full object-cover" />
                                </a>
                                <div class="p-2 text-sm">
                                    <div class="font-medium truncate" title="{{ $f['filename'] }}">{{ $f['filename'] }}
                                    </div>
                                    <div class="text-gray-600">{{ number_format(($f['size'] ?? 0) / 1024, 1) }} KB</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">Nenhum arquivo encontrado na pasta.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
