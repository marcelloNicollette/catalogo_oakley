{{-- resources/views/admin/measure-tables/category-form.blade.php --}}
@extends('layouts.admin-layout')

@section('page_title', $category->exists ? 'Editar Categoria' : 'Nova Categoria')

@section('content-wrapper')

    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.measure-tables.index') }}"
            class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $category->exists ? 'Editar: ' . $category->name : 'Nova Categoria' }}
        </h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form
                action="{{ $category->exists
                    ? route('admin.measure-tables.categories.update', $category)
                    : route('admin.measure-tables.categories.store') }}"
                method="POST">
                @csrf
                @if ($category->exists)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome *</label>
                        <input type="text" name="name" required value="{{ old('name', $category->name) }}"
                            placeholder="ex: Calçados"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ordem</label>
                        <input type="number" name="sort_order" min="0"
                            value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1"
                                {{ old('active', $category->active ?? true) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">Ativo</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.measure-tables.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-150">
                        {{ $category->exists ? 'Salvar Alterações' : 'Criar Categoria' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($category->exists)
        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-red-100">
            <div class="p-6">
                <h3 class="text-sm font-medium text-red-600 mb-1">Zona de Perigo</h3>
                <p class="text-sm text-gray-500 mb-4">Remover esta categoria apagará também todas as suas tabelas e linhas.
                </p>
                <form action="{{ route('admin.measure-tables.categories.destroy', $category) }}" method="POST"
                    class="inline-block">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Remover a categoria {{ $category->name }}?')"
                        class="flex items-center text-red-600 hover:text-red-900 text-sm font-medium transition duration-150">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Remover Categoria
                    </button>
                </form>
            </div>
        </div>
    @endif

@endsection
