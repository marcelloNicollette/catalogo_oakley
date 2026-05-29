@extends('layouts.admin-layout')

@push('css')
    <style>
        /* Customizações específicas */
    </style>
@endpush

@section('page_title', isset($item) ? 'Editar Item de Tecnologia' : 'Novo Item de Tecnologia')

@section('content-wrapper')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        {{ isset($item) ? 'Editar Item de Tecnologia' : 'Novo Item de Tecnologia' }}
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST"
                        action="{{ isset($item) ? route('admin.technology.items.update', $item) : route('admin.technology.items.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($item))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label for="technology_category_id"
                                class="block text-sm font-medium text-gray-700">Categoria</label>
                            <select name="technology_category_id" id="technology_category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                                <option value="">Selecione uma categoria</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('technology_category_id', $item->technology_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('technology_category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                            <input type="number" name="order" id="order" min="1"
                                value="{{ old('order', $item->order ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $item->name ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>{{ old('description', $item->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="block text-sm font-medium text-gray-700">Ícone</label>
                            <input type="file" name="icon" id="icon"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".svg,.png,.jpg,.gif">
                            @if (isset($item) && $item->icon)
                                <div class="mt-2">
                                    <p>Ícone Atual</p>
                                    <img src="{{ asset('/' . $item->icon) }}" alt="{{ $item->name }}"
                                        class="w-10 object-contain">
                                </div>
                            @endif
                            @error('icon')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="active" class="inline-flex items-center">
                                <input type="checkbox" name="active" id="active" value="1"
                                    {{ old('active', $item->active ?? true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Ativo</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.technology.items.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($item) ? 'Atualizar' : 'Criar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
