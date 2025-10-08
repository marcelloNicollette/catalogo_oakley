<form action="{{ $route }}" method="POST" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <!-- Mensagens de erro -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Erro na validação</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Categoria -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                Categoria <span class="text-red-500">*</span>
            </label>
            <select name="category_id" id="category_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Selecione uma categoria</option>
                @foreach (\App\Models\Category::with('segmentacao')->join('segmentacao', 'categories.segmento_id', '=', 'segmentacao.id')->orderBy('segmentacao.segmento')->orderBy('categories.name')->select('categories.*')->get() as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $subcategory->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->segmentacao->segmento ?? 'Sem segmento' }} -
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Faixa -->
        <div>
            <label for="faixa" class="block text-sm font-medium text-gray-700 mb-2">
                Faixa <span class="text-red-500">*</span>
            </label>
            <input type="text" name="faixa" id="faixa" required
                value="{{ old('faixa', $subcategory->faixa ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                placeholder="Ex: Infantil, Adulto, Juvenil">
            @error('faixa')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Slug -->
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                Slug
            </label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $subcategory->slug ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                placeholder="Será gerado automaticamente se deixado em branco">
            <p class="mt-1 text-xs text-gray-500">Se deixado em branco, será gerado automaticamente baseado na faixa</p>
            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ordem -->
        <div>
            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                Ordem
            </label>
            <input type="number" name="order" id="order" min="0"
                value="{{ old('order', $subcategory->order ?? 0) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                placeholder="0">
            <p class="mt-1 text-xs text-gray-500">Ordem de exibição (0 = primeira posição)</p>
            @error('order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Status Ativo -->
    <div class="flex items-center">
        <input type="hidden" name="active" value="0">
        <input type="checkbox" name="active" id="active" value="1"
            {{ old('active', $subcategory->active ?? true) ? 'checked' : '' }}
            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label for="active" class="ml-2 block text-sm text-gray-900">
            Subcategoria ativa
        </label>
    </div>

    <!-- Botões de ação -->
    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
        <a href="{{ route('admin.subcategories.index') }}"
            class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Cancelar
        </a>

        <button type="submit"
            class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ $subcategory ? 'Atualizar' : 'Criar' }} Subcategoria
        </button>
    </div>
</form>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faixaInput = document.getElementById('faixa');
            const slugInput = document.getElementById('slug');

            // Auto-gerar slug baseado na faixa
            faixaInput.addEventListener('input', function() {
                if (!slugInput.value || slugInput.dataset.autoGenerated) {
                    const slug = this.value
                        .toLowerCase()
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '') // Remove acentos
                        .replace(/[^a-z0-9\s-]/g, '') // Remove caracteres especiais
                        .replace(/\s+/g, '-') // Substitui espaços por hífens
                        .replace(/-+/g, '-') // Remove hífens duplicados
                        .replace(/^-|-$/g, ''); // Remove hífens do início e fim

                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                }
            });

            // Marcar como não auto-gerado se o usuário editar manualmente
            slugInput.addEventListener('input', function() {
                this.dataset.autoGenerated = 'false';
            });
        });
    </script>
@endpush
