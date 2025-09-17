@extends('layouts.admin-layout')

@push('css')
    <style>
        /* Customizações específicas */
    </style>
@endpush

@section('page_title', isset($category) ? 'Editar Categoria de Conteúdo' : 'Nova Categoria de Conteúdo')

@section('content-wrapper')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        {{ isset($category) ? 'Editar Categoria de Conteúdo' : 'Nova Categoria de Conteúdo' }}
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form enctype="multipart/form-data" method="POST"
                        action="{{ isset($category) ? route('admin.conteudos.categories.update', $category) : route('admin.conteudos.categories.store') }}">
                        @csrf
                        @if (isset($category))
                            @method('PUT')
                        @endif


                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">Categoria</label>
                            <input type="text" name="category" id="category"
                                value="{{ old('category', $category->category ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                            <input type="file" name="icon" id="icon"
                                value="{{ old('icon', $category->icon ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('icon')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700">Ordem</label>
                            <input type="number" name="order" id="order"
                                value="{{ old('order', $category->order ?? 0) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="active" class="inline-flex items-center">
                                <input type="checkbox" name="active" id="active" value="1"
                                    {{ old('active', $category->active ?? true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Ativo</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.conteudos.categories.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($category) ? 'Atualizar' : 'Criar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
