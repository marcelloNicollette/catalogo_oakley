@extends('layouts.admin-layout')

@section('page_title', 'Colunas — ' . $category->name)

@section('content-wrapper')

    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.measure-tables.index') }}" class="text-gray-400 hover:text-gray-600 transition duration-150">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Colunas — {{ $category->name }}
        </h2>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Adicionar coluna --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900">
            <h3 class="text-sm font-medium text-gray-700 mb-4">Adicionar Nova Coluna</h3>
            <form action="{{ route('admin.measure-tables.columns.store', $category) }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome *</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                            placeholder="ex: BRA, Peito, Cintura"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ordem</label>
                        <input type="number" name="sort_order" min="0"
                            value="{{ old('sort_order', $columns->count() + 1) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex items-end">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1" checked
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">Ativo</span>
                        </label>
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Adicionar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Lista de colunas --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">
                            Ordem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($columns as $col)
                        <tr class="hover:bg-gray-50">
                            <form id="col-form-{{ $col->id }}"
                                action="{{ route('admin.measure-tables.columns.update', $col) }}" method="POST">
                                @csrf @method('PUT')
                            </form>

                            <td class="px-6 py-3">
                                <input form="col-form-{{ $col->id }}" type="text" name="name"
                                    value="{{ $col->name }}" required
                                    class="w-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </td>
                            <td class="px-6 py-3">
                                <input form="col-form-{{ $col->id }}" type="number" name="sort_order" min="0"
                                    value="{{ $col->sort_order }}"
                                    class="w-16 text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </td>
                            <td class="px-6 py-3">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input form="col-form-{{ $col->id }}" type="hidden" name="active"
                                        value="0">
                                    <input form="col-form-{{ $col->id }}" type="checkbox" name="active"
                                        value="1" {{ $col->active ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span
                                        class="text-xs leading-5 font-semibold rounded-full px-2
                                        {{ $col->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $col->active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </label>
                            </td>
                            <td class="px-6 py-3 text-sm font-medium">
                                <div class="flex items-center space-x-4">
                                    <button form="col-form-{{ $col->id }}" type="submit"
                                        class="flex items-center text-indigo-600 hover:text-indigo-900 transition duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                        Salvar
                                    </button>
                                    <button type="button"
                                        onclick="if(confirm('Remover a coluna {{ $col->name }}? Isso apagará todos os valores desta coluna.')) document.getElementById('del-col-{{ $col->id }}').submit()"
                                        class="flex items-center text-red-600 hover:text-red-900 transition duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                Nenhuma coluna cadastrada ainda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Forms de delete ocultos --}}
    @foreach ($columns as $col)
        <form id="del-col-{{ $col->id }}" action="{{ route('admin.measure-tables.columns.destroy', $col) }}"
            method="POST" style="display:none">
            @csrf @method('DELETE')
        </form>
    @endforeach

@endsection
