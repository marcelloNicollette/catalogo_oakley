<form action="{{ $route }}" method="POST" class="space-y-4">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
        <input type="text" name="title" id="title" value="{{ old('title', $caracteristica->title ?? '') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
        <textarea name="description" id="description"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            rows="3">{{ old('description', $caracteristica->description ?? '') }}</textarea>
    </div>

    <div>
        <label for="product_id" class="block text-sm font-medium text-gray-700">Produto</label>
        <select name="product_id" id="product_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required>
            <option value="">Selecione...</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected(old('product_id', $caracteristica->product_id ?? '') == $product->id)>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="pt-4 text-right">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Salvar
        </button>
    </div>
</form>
