@extends('layouts.admin-layout')

@push('css')
    <style>
        /* Customizações específicas */
    </style>
@endpush

@section('page_title', isset($item) ? 'Editar Item de Conteúdo' : 'Novo Item de Conteúdo')

@section('content-wrapper')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        {{ isset($item) ? 'Editar Item de Conteúdo' : 'Novo Item de Conteúdo' }}
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST"
                        action="{{ isset($item) ? route('admin.conteudos.items.update', $item) : route('admin.conteudos.items.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($item))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label for="conteudo_category_id"
                                class="block text-sm font-medium text-gray-700">Categoria</label>
                            <select name="conteudo_category_id" id="conteudo_category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                                <option value="">Selecione uma categoria</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('conteudo_category_id', $item->conteudo_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('conteudo_category_id')
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
                            <label for="link_url" class="block text-sm font-medium text-gray-700">Link url</label>
                            <input type="text" name="link_url" id="link_url"
                                value="{{ old('link_url', $item->link_url ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                            @error('link_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700">Ordem</label>
                            <input type="number" name="order" id="order"
                                value="{{ old('order', $item->order ?? 0) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                            @error('link_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Níveis de Acesso -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Níveis de Acesso (Se vazio, visível
                                para todos)</label>
                            <div class="space-y-2">
                                @php
                                    $accessLevels = ['representante', 'interno', 'fornecedor', 'convidado', 'cliente'];
                                    $currentLevels = old('access_levels', $item->access_levels ?? []);
                                @endphp
                                @foreach ($accessLevels as $level)
                                    <label class="inline-flex items-center mr-4">
                                        <input type="checkbox" name="access_levels[]" value="{{ $level }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            @checked(in_array($level, $currentLevels))>
                                        <span class="ml-2 text-sm text-gray-600">{{ ucfirst($level) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('access_levels')
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
                            <a href="{{ route('admin.conteudos.items.index') }}"
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
