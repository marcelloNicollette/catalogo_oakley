@extends('layouts.admin-layout')

@push('css')
    <style>
        .cell-input {
            min-width: 80px;
        }
    </style>
@endpush

@section('page_title', 'Tabela de Medidas')

@section('content-wrapper')

    {{-- Cabeçalho --}}
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Tabela de Medidas</h2>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.measure-tables.categories.create') }}"
                class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nova Categoria
            </a>
            <a href="{{ route('admin.measure-tables.tables.create') }}"
                class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nova Tabela
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-12 text-center text-gray-400">
                Nenhuma categoria cadastrada ainda.
                <a href="{{ route('admin.measure-tables.categories.create') }}"
                   class="text-indigo-600 hover:underline ml-1">Criar categoria</a>
            </div>
        </div>
    @endif

    {{-- Uma seção por categoria --}}
    @foreach($categories as $category)
        <div class="mb-8">

            {{-- Título da categoria --}}
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-700 uppercase tracking-wide">
                    {{ $category->name }}
                </h3>
                <div class="flex items-center space-x-3 text-sm">
                    <a href="{{ route('admin.measure-tables.columns.index', $category) }}"
                       class="text-indigo-600 hover:text-indigo-900 transition duration-150">
                        ⚙ Colunas
                    </a>
                    <a href="{{ route('admin.measure-tables.categories.edit', $category) }}"
                       class="text-indigo-600 hover:text-indigo-900 transition duration-150">
                        Editar categoria
                    </a>
                    <form action="{{ route('admin.measure-tables.categories.destroy', $category) }}"
                          method="POST" class="inline-block">
                        @csrf @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Remover a categoria {{ $category->name }} e todas as suas tabelas?')"
                            class="text-red-500 hover:text-red-700 transition duration-150">
                            Remover
                        </button>
                    </form>
                </div>
            </div>

            @if($category->tables->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-8 text-center text-gray-400 text-sm">
                        Nenhuma tabela nesta categoria.
                        <a href="{{ route('admin.measure-tables.tables.create') }}"
                           class="text-indigo-600 hover:underline ml-1">Criar tabela</a>
                    </div>
                </div>
            @endif

            {{-- Uma tabela por measure_table --}}
            @foreach($category->tables as $measureTable)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="px-6 pt-5 pb-2 flex items-center justify-between border-b border-gray-100">
                        <h4 class="font-semibold text-gray-800">{{ $measureTable->name }}</h4>
                        <div class="flex items-center space-x-4 text-sm font-medium">
                            <a href="{{ route('admin.measure-tables.edit-table', $measureTable) }}"
                               class="flex items-center text-indigo-600 hover:text-indigo-900 transition duration-150">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>
                            <form action="{{ route('admin.measure-tables.tables.destroy', $measureTable) }}"
                                  method="POST" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Remover a tabela {{ $measureTable->name }}?')"
                                    class="flex items-center text-red-600 hover:text-red-900 transition duration-150">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($category->columns->isEmpty())
                            <p class="text-sm text-gray-400">
                                Esta categoria não tem colunas configuradas.
                                <a href="{{ route('admin.measure-tables.columns.index', $category) }}"
                                   class="text-indigo-600 hover:underline">Configurar colunas</a>
                            </p>
                        @elseif($measureTable->rows->isEmpty())
                            <p class="text-sm text-gray-400">
                                Nenhuma linha cadastrada.
                                <a href="{{ route('admin.measure-tables.edit-table', $measureTable) }}"
                                   class="text-indigo-600 hover:underline">Editar tabela</a>
                            </p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            @foreach($category->columns as $col)
                                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ $col->name }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach($measureTable->rows as $row)
                                            <tr class="hover:bg-gray-50">
                                                @foreach($category->columns as $col)
                                                    <td class="px-4 py-2 text-center text-gray-700">
                                                        <input
                                                            type="text"
                                                            value="{{ $row->valueFor($col->id) }}"
                                                            data-row="{{ $row->id }}"
                                                            data-col="{{ $col->id }}"
                                                            placeholder="—"
                                                            class="cell-input w-full text-center rounded-md border-gray-300 shadow-sm
                                                                   focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm
                                                                   {{ $row->valueFor($col->id) ? 'font-medium text-gray-900' : 'text-gray-300' }}"
                                                        >
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    <div id="save-status" class="text-xs text-gray-400 text-right hidden">Salvando...</div>

@endsection

@push('scripts')
<script>
    (() => {
        const status = document.getElementById('save-status');
        const url    = '{{ route("admin.measure-tables.cells.update") }}';
        const token  = '{{ csrf_token() }}';
        let timer = null, queue = {};

        async function flush() {
            const items = Object.values(queue);
            if (!items.length) return;
            queue = {};

            for (const item of items) {
                try {
                    await fetch(url, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                        body: JSON.stringify({
                            measure_row_id:    item.rowId,
                            measure_column_id: item.colId,
                            value:             item.value,
                        }),
                    });
                } catch(e) { console.error('Erro ao salvar célula', e); }
            }

            status.textContent = '✓ Salvo';
            setTimeout(() => status.classList.add('hidden'), 1500);
        }

        document.querySelectorAll('.cell-input').forEach(input => {
            input.addEventListener('change', () => {
                const key = `${input.dataset.row}_${input.dataset.col}`;
                const has = input.value.trim().length > 0;

                input.classList.toggle('font-medium', has);
                input.classList.toggle('text-gray-900', has);
                input.classList.toggle('text-gray-300', !has);

                queue[key] = { rowId: input.dataset.row, colId: input.dataset.col, value: input.value };
                status.textContent = 'Salvando...';
                status.classList.remove('hidden');
                clearTimeout(timer);
                timer = setTimeout(flush, 800);
            });

            input.addEventListener('focus', () => input.select());
        });
    })();
</script>
@endpush
