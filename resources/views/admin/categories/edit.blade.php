@extends('layouts.admin-layout')

@push('css')
    <style>
        /* Customizações específicas */
    </style>
@endpush

@section('page_title', 'Editar Categoria')

@section('content-wrapper')
    <div class="flex items-center space-x-2 mb-6">
        <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
            </path>
        </svg>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Editar Categoria') }}
        </h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')


                <div class="mb-4">
                    <label for="segmento_id" class="block text-sm font-medium text-gray-700">Segmento</label>
                    <select name="segmento_id" id="segmento_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        required>
                        <option value="">Selecione um segmento</option>
                        @foreach ($segmentos as $segmento)
                            <option value="{{ $segmento->id }}"
                                {{ old('segmento_id', $category->segmento_id) == $segmento->id ? 'selected' : '' }}>
                                {{ $segmento->segmento }}
                            </option>
                        @endforeach
                    </select>
                    @error('segmento_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome da Categoria</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="active" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="active" id="active"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="1" {{ old('active', $category->active) == '1' ? 'selected' : '' }}>Ativo
                        </option>
                        <option value="0" {{ old('active', $category->active) == '0' ? 'selected' : '' }}>Inativo
                        </option>
                    </select>
                    @error('active')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.categories.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Cancelar</a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar</button>
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
