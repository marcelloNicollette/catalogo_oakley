@extends('layouts.admin-layout')

@push('css')
    <style>
        .qty-cell::-webkit-outer-spin-button,
        .qty-cell::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .qty-cell { -moz-appearance: textfield; }
    </style>
@endpush

@section('page_title', 'Grade de Calçados')

@section('content-wrapper')

    {{-- Cabeçalho --}}
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M3 14h18M10 3v18M14 3v18M3 6a3 3 0 013-3h12a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6z" />
            </svg>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Grade de Calçados</h2>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.shoe-grids.sizes.index') }}"
                class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Tamanhos
            </a>
            <a href="{{ route('admin.shoe-grids.groups.create') }}"
                class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Novo Grupo
            </a>
            <a href="{{ route('admin.shoe-grids.grids.create') }}"
                class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nova Grade
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabela --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-max w-full text-sm border-collapse">
                    <thead>
                        {{-- USW --}}
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase tracking-wider border-b border-r border-gray-200 w-28"
                                rowspan="3">Grupo</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-400 uppercase tracking-wider border-b border-r border-gray-200 w-20"
                                rowspan="3">Grade</th>
                            @foreach($sizes as $size)
                                <th class="px-2 py-1 text-center text-xs font-normal text-gray-400 border-b border-gray-100 min-w-[44px]">
                                    {{ $size->usw ?: '' }}
                                </th>
                            @endforeach
                            <th class="px-4 py-2 border-b border-l border-gray-200 w-32" rowspan="3"></th>
                        </tr>
                        {{-- USM --}}
                        <tr class="bg-gray-50">
                            @foreach($sizes as $size)
                                <th class="px-2 py-1 text-center text-xs font-normal text-gray-400 border-b border-gray-100">
                                    {{ $size->usm ?: '' }}
                                </th>
                            @endforeach
                        </tr>
                        {{-- BRA --}}
                        <tr class="bg-gray-50">
                            @foreach($sizes as $size)
                                <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
                                    {{ $size->bra % 1 == 0 ? (int)$size->bra : $size->bra }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($groups as $group)
                            @foreach($group->grids as $index => $grid)
                                <tr data-grid="{{ $grid->id }}">

                                    @if($index === 0)
                                        <td class="px-4 py-3 font-semibold text-gray-700 border-r border-gray-200 align-top bg-gray-50 whitespace-nowrap"
                                            rowspan="{{ $group->grids->count() }}">
                                            {{ $group->name }}
                                            <div class="mt-1">
                                                <a href="{{ route('admin.shoe-grids.groups.edit', $group) }}"
                                                   class="text-xs text-indigo-600 hover:text-indigo-900">editar</a>
                                            </div>
                                        </td>
                                    @endif

                                    <td class="px-4 py-3 font-mono font-medium text-gray-800 border-r border-gray-200 whitespace-nowrap">
                                        {{ $grid->code }}
                                    </td>

                                    @foreach($sizes as $size)
                                        @php $qty = $grid->quantityFor($size->id); @endphp
                                        <td class="text-center p-0 border-r border-gray-100">
                                            <input
                                                type="number" min="0" max="99"
                                                value="{{ $qty ?: '' }}"
                                                data-grid="{{ $grid->id }}"
                                                data-size="{{ $size->id }}"
                                                class="qty-cell w-full h-9 text-center text-sm border-0 bg-transparent
                                                       focus:bg-white focus:ring-1 focus:ring-indigo-500 rounded
                                                       {{ $qty ? 'font-semibold text-gray-900' : 'text-gray-300' }}"
                                            >
                                        </td>
                                    @endforeach

                                    <td class="px-4 py-3 border-l border-gray-200 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.shoe-grids.grids.edit', $grid) }}"
                                               class="flex items-center text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.shoe-grids.grids.destroy', $grid) }}"
                                                  method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Remover a grade {{ $grid->code }}?')"
                                                    class="flex items-center text-red-600 hover:text-red-900 transition duration-150 ease-in-out">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Excluir
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                        @if($groups->isEmpty())
                            <tr>
                                <td colspan="{{ $sizes->count() + 3 }}" class="px-6 py-12 text-center text-gray-400">
                                    Nenhuma grade cadastrada ainda.
                                    <a href="{{ route('admin.shoe-grids.grids.create') }}"
                                       class="text-indigo-600 hover:underline ml-1">Criar grade</a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div id="save-status" class="mt-3 text-xs text-gray-400 text-right hidden">Salvando...</div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    (() => {
        const status = document.getElementById('save-status');
        const url    = '{{ route("admin.shoe-grids.items.update") }}';
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
                        body: JSON.stringify({ shoe_grid_id: item.gridId, shoe_size_id: item.sizeId, quantity: item.qty }),
                    });
                } catch(e) { console.error('Erro ao salvar', e); }
            }
            status.textContent = '✓ Salvo';
            setTimeout(() => status.classList.add('hidden'), 1500);
        }

        document.querySelectorAll('.qty-cell').forEach(input => {
            input.addEventListener('change', () => {
                const qty = parseInt(input.value) || 0;
                const key = `${input.dataset.grid}_${input.dataset.size}`;
                input.classList.toggle('font-semibold', qty > 0);
                input.classList.toggle('text-gray-900', qty > 0);
                input.classList.toggle('text-gray-300', qty === 0);
                queue[key] = { gridId: input.dataset.grid, sizeId: input.dataset.size, qty };
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
