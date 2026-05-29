@extends('layouts.admin-layout')

@push('css')
    <style>
        /* Customizações específicas */
    </style>
@endpush

@section('page_title', 'Dashboard Administrador')

@section('content-wrapper')
    <div class="flex items-center space-x-2 mb-6">
        <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
            </path>
        </svg>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Editar Coleção') }}
        </h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('admin.collections.update', $collection) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="segmentacao_id" class="block text-sm font-medium text-gray-700">Segmentação</label>
                    <select name="segmentacao_id" id="segmentacao_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Selecione uma segmentação</option>
                        @foreach ($segmentacoes as $segmentacao)
                            <option value="{{ $segmentacao->id }}"
                                {{ old('segmentacao_id', $collection->segmentacao_id) == $segmentacao->id ? 'selected' : '' }}>
                                {{ $segmentacao->segmento }}</option>
                        @endforeach
                    </select>
                    @error('segmentacao_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Nome -->
                <div class="mb-6">
                    <label for="name" class="flex items-center text-sm font-medium text-gray-700 mb-1">

                        Nome Coleção
                    </label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out"
                        value="{{ old('name', $collection->name) }}" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Descrição -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                    <input type="text" name="description" id="description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('description', $collection->description) }}">
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="codigo_colecao" class="block text-sm font-medium text-gray-700">Código Coleção</label>
                    <input type="text" name="codigo_colecao" id="codigo_colecao"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('codigo_colecao', $collection->codigo_colecao) }}" required>
                    @error('codigo_colecao')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug Coleção</label>
                    <input type="text" name="slug" id="slug"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('slug', $collection->slug) }}" required>
                    @error('slug')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="bg_color" class="block text-sm font-medium text-gray-700">Background Color</label>
                    <input type="color" name="bg_color" id="bg_color"
                        class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('bg_color', $collection->bg_color) }}">
                    @error('bg_color')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>



                <!-- Imagem -->
                <div class="mb-6">
                    <label for="image" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Imagem
                    </label>
                    <input type="file" name="image" id="image"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition duration-150 ease-in-out">
                    @if ($collection->image)
                        <div class="mt-2 relative group">
                            <img src="{{ asset('/' . $collection->image) }}" alt="Imagem atual"
                                class="h-32 w-auto object-cover rounded-lg shadow-sm">
                            <div
                                class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-150 ease-in-out rounded-lg flex items-center justify-center">
                                <span class="text-white text-sm">Imagem atual</span>
                            </div>
                        </div>
                    @endif
                    @error('image')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="active" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="active" id="active"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="1" {{ old('active', $collection->active) == '1' ? 'selected' : '' }}>Ativo
                        </option>
                        <option value="0" {{ old('active', $collection->active) == '0' ? 'selected' : '' }}>Inativo
                        </option>
                    </select>
                    @error('active')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botões -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.collections.index') }}"
                        class="flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Scripts custom para dashboard
    </script>
@endpush
