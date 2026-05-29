@extends('layouts.admin-layout')

@push('css')
    <style>
        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .qty-input {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@section('page_title', $grid->exists ? 'Editar Grade' : 'Nova Grade')

@section('content-wrapper')

    @if ($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 rounded-lg text-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.shoe-grids.index') }}"
            class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $grid->exists ? 'Editar Grade: ' . $grid->code : 'Nova Grade' }}
        </h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

            <form
                action="{{ $grid->exists ? route('admin.shoe-grids.grids.update', $grid) : route('admin.shoe-grids.grids.store') }}"
                method="POST">
                @csrf
                @if ($grid->exists)
                    @method('PUT')
                @endif

                {{-- Dados básicos --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                    <div>
                        <label for="shoe_size_group_id" class="block text-sm font-medium text-gray-700">Grupo *</label>
                        <select name="shoe_size_group_id" id="shoe_size_group_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Selecione um grupo</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}"
                                    {{ old('shoe_size_group_id', $grid->shoe_size_group_id) == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('shoe_size_group_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Código da Grade *</label>
                        <input type="text" name="code" id="code" required maxlength="20" placeholder="ex: M38A"
                            value="{{ old('code', $grid->code) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono uppercase">
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700">Ordem de Exibição</label>
                        <input type="number" name="sort_order" id="sort_order" min="0"
                            value="{{ old('sort_order', $grid->sort_order ?? 0) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <input type="text" name="description" id="description"
                            value="{{ old('description', $grid->description) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="flex items-end">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1"
                                {{ old('active', $grid->active ?? true) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">Ativo</span>
                        </label>
                    </div>
                </div>

                {{-- Grade de quantidades --}}
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Quantidades por Tamanho</h3>

                    <div class="overflow-x-auto">
                        <table class="text-xs border-collapse">
                            <thead>
                                <tr>
                                    <td class="pr-3 py-1 text-right text-gray-400 font-medium">USW</td>
                                    @foreach ($sizes as $size)
                                        <td class="px-2 py-1 text-center text-gray-400 min-w-[52px]">{{ $size->usw ?: '' }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="pr-3 py-1 text-right text-gray-400 font-medium">USM</td>
                                    @foreach ($sizes as $size)
                                        <td class="px-2 py-1 text-center text-gray-400">{{ $size->usm ?: '' }}</td>
                                    @endforeach
                                </tr>
                                <tr class="bg-gray-50">
                                    <td
                                        class="pr-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        BRA</td>
                                    @foreach ($sizes as $size)
                                        <td
                                            class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">
                                            {{ $size->bra % 1 == 0 ? (int) $size->bra : $size->bra }}
                                        </td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td
                                        class="pr-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Qtd</td>
                                    @foreach ($sizes as $size)
                                        @php
                                            $currentQty = old(
                                                "quantities.{$size->id}",
                                                $grid->exists ? $grid->quantityFor($size->id) : 0,
                                            );
                                        @endphp
                                        <td class="px-1 py-1 border border-gray-200">
                                            <input type="number" name="quantities[{{ $size->id }}]" min="0"
                                                max="99" value="{{ $currentQty ?: '' }}"
                                                class="qty-input w-full h-8 text-center text-sm rounded-md border-gray-300 shadow-sm
                                                       focus:border-indigo-500 focus:ring-indigo-500
                                                       {{ $currentQty ? 'font-semibold text-gray-900 bg-indigo-50' : 'text-gray-400 bg-white' }}">
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Ações --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.shoe-grids.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-150 ease-in-out">
                        {{ $grid->exists ? 'Salvar Alterações' : 'Criar Grade' }}
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.qty-input').forEach(input => {
            const update = () => {
                const has = parseInt(input.value) > 0;
                input.classList.toggle('font-semibold', has);
                input.classList.toggle('text-gray-900', has);
                input.classList.toggle('bg-indigo-50', has);
                input.classList.toggle('text-gray-400', !has);
                input.classList.toggle('bg-white', !has);
            };
            input.addEventListener('input', update);
            input.addEventListener('focus', () => input.select());
        });
    </script>
@endpush
