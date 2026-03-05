@extends('layouts.admin-layout')

@section('page_title', 'Olympikus - Novo Item de Menu')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Novo Item de Menu') }}
        </h2>
        <a href="{{ route('admin.menu-items.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg">
            Voltar
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('admin.menu-items.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="label" class="block text-sm font-medium text-gray-700">Label</label>
                        <input type="text" name="label" id="label" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('label') }}">
                        @error('label')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700">Ordem</label>
                        <input type="number" name="order" id="order"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('order', 0) }}">
                    </div>

                    <div>
                        <label for="route" class="block text-sm font-medium text-gray-700">Rota (Ex: user.slug.colecoes)</label>
                        <input type="text" name="route" id="route"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('route') }}">
                    </div>

                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700">URL (Ex: /user/colecoes)</label>
                        <input type="text" name="url" id="url"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('url') }}">
                    </div>

                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700">Ícone (Caminho relativo, ex: /images/icones/colecoes.svg)</label>
                        <input type="text" name="icon" id="icon"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('icon') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" checked>
                                <span class="ml-2">Ativo</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Permissões (Classificações Permitidas)</label>
                    <p class="text-xs text-gray-500 mb-4">Se nenhuma for selecionada, o item será visível para todos.</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($classifications as $classification)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="allowed_classifications[]" value="{{ $classification }}"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2">{{ ucfirst($classification) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
