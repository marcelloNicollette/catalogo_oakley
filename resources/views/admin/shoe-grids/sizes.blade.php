@extends('layouts.admin-layout')

@section('page_title', 'Tamanhos - Grade de Calçados')

@section('content-wrapper')

    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.shoe-grids.index') }}"
               class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Tamanhos</h2>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulário novo tamanho --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900">
            <h3 class="text-sm font-medium text-gray-700 mb-4">Adicionar Novo Tamanho</h3>
            <form action="{{ route('admin.shoe-grids.sizes.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">BRA</label>
                        <input type="number" name="bra" step="0.5" min="10" max="60"
                            value="{{ old('bra') }}" placeholder="ex: 39.5"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('bra') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">USW</label>
                        <input type="text" name="usw" maxlength="10" value="{{ old('usw') }}" placeholder="W 8"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">USM</label>
                        <input type="text" name="usm" maxlength="10" value="{{ old('usm') }}" placeholder="6.5"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ordem</label>
                        <input type="number" name="sort_order" min="0"
                            value="{{ old('sort_order', $sizes->total() + 1) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Adicionar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Lista de tamanhos --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">BRA</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">USW</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">USM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Ordem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($sizes as $size)
                        {{-- Cada linha é um <form> completo ocupando o <tr> --}}
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-3 whitespace-nowrap">
                                <form id="form-size-{{ $size->id }}"
                                      action="{{ route('admin.shoe-grids.sizes.update', $size) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')
                                    {{-- inputs ficam dentro do form mas visualmente espalhados pelas colunas via JS não é possível --}}
                                    {{-- Usamos uma única linha de form com display contents (não suportado em todos os browsers) --}}
                                    {{-- Solução: form envolve a TR via atributo form="id" nos inputs --}}
                                </form>

                                <input form="form-size-{{ $size->id }}"
                                       type="number" name="bra" step="0.5"
                                       value="{{ $size->bra }}"
                                       class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <input form="form-size-{{ $size->id }}"
                                       type="text" name="usw" maxlength="10"
                                       value="{{ $size->usw }}"
                                       placeholder="—"
                                       class="w-28 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <input form="form-size-{{ $size->id }}"
                                       type="text" name="usm" maxlength="10"
                                       value="{{ $size->usm }}"
                                       placeholder="—"
                                       class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <input form="form-size-{{ $size->id }}"
                                       type="number" name="sort_order" min="0"
                                       value="{{ $size->sort_order }}"
                                       class="w-16 text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input form="form-size-{{ $size->id }}"
                                           type="hidden" name="active" value="0">
                                    <input form="form-size-{{ $size->id }}"
                                           type="checkbox" name="active" value="1"
                                           {{ $size->active ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="text-xs leading-5 font-semibold rounded-full px-2
                                        {{ $size->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $size->active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </label>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-4">
                                    {{-- Salvar: submete o form pelo atributo form= --}}
                                    <button form="form-size-{{ $size->id }}" type="submit"
                                        class="flex items-center text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                        Salvar
                                    </button>

                                    {{-- Excluir: aciona form de delete separado --}}
                                    <button type="button"
                                        onclick="if(confirm('Remover o tamanho BRA {{ $size->bra % 1 == 0 ? (int)$size->bra : $size->bra }}? Isso afetará todas as grades que usam este tamanho.')) document.getElementById('delete-size-{{ $size->id }}').submit()"
                                        class="flex items-center text-red-600 hover:text-red-900 transition duration-150 ease-in-out">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if($sizes->isEmpty())
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                Nenhum tamanho cadastrado ainda.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="mt-4">
                {{ $sizes->links() }}
            </div>
        </div>
    </div>

    {{-- Forms de exclusão ocultos (fora de qualquer outro form) --}}
    @foreach($sizes as $size)
        <form id="delete-size-{{ $size->id }}"
              action="{{ route('admin.shoe-grids.sizes.destroy', $size) }}"
              method="POST"
              style="display:none">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

@endsection
