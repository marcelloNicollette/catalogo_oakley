@extends('layouts.admin-layout')

@section('page_title', $measureTable->exists ? 'Editar Tabela' : 'Nova Tabela')

@section('content-wrapper')

    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.measure-tables.index') }}"
           class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $measureTable->exists ? 'Editar Tabela: ' . $measureTable->name : 'Nova Tabela' }}
        </h2>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded-lg text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ── Dados básicos ──────────────────────────────────────────────────── --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900">
            <form action="{{ $measureTable->exists
                    ? route('admin.measure-tables.tables.update', $measureTable)
                    : route('admin.measure-tables.tables.store') }}"
                  method="POST"
                  id="table-form">
                @csrf
                @if($measureTable->exists) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Categoria *</label>
                        <select name="measure_category_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="category-select">
                            <option value="">Selecione...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('measure_category_id', $measureTable->measure_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('measure_category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome da Tabela *</label>
                        <input type="text" name="name" required
                            value="{{ old('name', $measureTable->name) }}"
                            placeholder="ex: Calçados Adultos"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ordem</label>
                        <input type="number" name="sort_order" min="0"
                            value="{{ old('sort_order', $measureTable->sort_order ?? 0) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="flex items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1"
                                {{ old('active', $measureTable->active ?? true) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">Ativo</span>
                        </label>
                    </div>
                </div>

                @if(!$measureTable->exists)
                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-150 ease-in-out">
                            Criar Tabela
                        </button>
                    </div>
                @endif

                {{-- ── Grade de linhas + células (só na edição) ───────────────── --}}
                @if($measureTable->exists && isset($columns) && $columns->isNotEmpty())

                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-medium text-gray-700">Linhas e Valores</h3>
                            <button type="button" id="add-row-btn"
                                class="flex items-center text-sm text-indigo-600 hover:text-indigo-900 font-medium transition duration-150">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Adicionar Linha
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm" id="rows-table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                            Ordem
                                        </th>
                                        @foreach($columns as $col)
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ $col->name }}
                                            </th>
                                        @endforeach
                                        <th class="px-4 py-2 w-16"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100" id="rows-tbody">
                                    @foreach($measureTable->rows as $i => $row)
                                        <tr class="hover:bg-gray-50" data-row-index="{{ $i }}">
                                            {{-- ID oculto --}}
                                            <input type="hidden" name="rows[{{ $i }}][id]" value="{{ $row->id }}">

                                            {{-- Label / Sort --}}
                                            <td class="px-4 py-2">
                                                <input type="text"
                                                    name="rows[{{ $i }}][label]"
                                                    value="{{ $row->label }}"
                                                    placeholder="PP / 24"
                                                    required
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium">
                                                <input type="hidden"
                                                    name="rows[{{ $i }}][sort_order]"
                                                    value="{{ $row->sort_order }}">
                                            </td>

                                            {{-- Células por coluna --}}
                                            @foreach($columns as $col)
                                                <td class="px-4 py-2 text-center">
                                                    <input type="text"
                                                        name="rows[{{ $i }}][cells][{{ $col->id }}]"
                                                        value="{{ $row->valueFor($col->id) }}"
                                                        placeholder="—"
                                                        class="w-full text-center rounded-md border-gray-300 shadow-sm
                                                               focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                </td>
                                            @endforeach

                                            {{-- Remover linha --}}
                                            <td class="px-4 py-2 text-center">
                                                <button type="button"
                                                    onclick="if(confirm('Remover a linha {{ $row->label }}?')) document.getElementById('delete-row-{{ $row->id }}').submit()"
                                                    class="text-red-400 hover:text-red-600 transition duration-150">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Ações --}}
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 mt-6">
                        <a href="{{ route('admin.measure-tables.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-150 ease-in-out">
                            Salvar Alterações
                        </button>
                    </div>

                @elseif($measureTable->exists && isset($columns) && $columns->isEmpty())
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-sm text-gray-400">
                            Configure as colunas da categoria antes de adicionar linhas.
                            <a href="{{ route('admin.measure-tables.columns.index', $measureTable->measure_category_id) }}"
                               class="text-indigo-600 hover:underline">Configurar colunas</a>
                        </p>
                    </div>
                @endif

            </form>
        </div>
    </div>

    {{-- Forms de exclusão de linhas (fora do form principal) --}}
    @if($measureTable->exists)
        @foreach($measureTable->rows as $row)
            <form id="delete-row-{{ $row->id }}"
                  action="{{ route('admin.measure-tables.rows.destroy', $row) }}"
                  method="POST" style="display:none">
                @csrf @method('DELETE')
            </form>
        @endforeach
    @endif

@endsection

@push('scripts')
@if($measureTable->exists && isset($columns) && $columns->isNotEmpty())
<script>
    // Adicionar nova linha dinamicamente
    (() => {
        const tbody    = document.getElementById('rows-tbody');
        const addBtn   = document.getElementById('add-row-btn');
        const columns  = @json($columns->map(fn($c) => ['id' => $c->id, 'name' => $c->name]));

        if (!addBtn) return;

        addBtn.addEventListener('click', () => {
            const idx = tbody.querySelectorAll('tr').length;

            let cells = columns.map(col => `
                <td class="px-4 py-2 text-center">
                    <input type="text"
                        name="rows[${idx}][cells][${col.id}]"
                        placeholder="—"
                        class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </td>
            `).join('');

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50';
            tr.innerHTML = `
                <td class="px-4 py-2">
                    <input type="text"
                        name="rows[${idx}][label]"
                        placeholder="PP / 24"
                        required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-medium">
                    <input type="hidden" name="rows[${idx}][sort_order]" value="${idx}">
                </td>
                ${cells}
                <td class="px-4 py-2 text-center">
                    <button type="button" onclick="this.closest('tr').remove()"
                        class="text-red-400 hover:text-red-600 transition duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
            tr.querySelector('input[type="text"]').focus();
        });
    })();
</script>
@endif
@endpush
