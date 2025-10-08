<div class="grid grid-cols-6 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-6 xl:grid-cols-6 gap-2">
    @foreach ($dbImages as $img)
        <div class="border rounded-sm overflow-hidden bg-gray-50">
            <a href="/{{ $img->path }}" target="_blank" class="block aspect-square bg-white">
                <img src="/{{ $img->path }}" alt="{{ $img->filename }}" loading="lazy"
                    class="w-full h-full object-cover" />
            </a>
            <div class="p-1 text-xs">
                <div class="font-medium truncate" title="{{ $img->filename }}">{{ $img->filename }}</div>
                <div class="text-gray-600">{{ number_format(($img->size ?? 0) / 1024, 1) }} KB</div>
                <div class="mt-1">
                    <form method="POST" action="{{ route('admin.product-images.destroy', $img) }}"
                        onsubmit="return confirm('Remover imagem?');">
                        @csrf
                        @method('DELETE')
                        <button class="px-2 py-1 bg-red-600 text-white rounded-sm text-xs">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
