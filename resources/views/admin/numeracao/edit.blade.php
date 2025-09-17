@extends('layouts.admin-layout')

@push('css')
@endpush

@section('page_title', 'Olympikus - Numeração')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">

        <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-8 h-8 text-gray-800">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
            </svg>

            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Editar Número') }}
            </h2>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('admin.numeracao.update', $numeracao) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="numero" class="block text-sm font-medium text-gray-700">Numeração</label>
                    <input type="text" name="numero" id="numero"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('numero', $numeracao->numero) }}" required>
                    @error('numero')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="active" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="active" id="active"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="1" {{ old('active', $numeracao->active) == '1' ? 'selected' : '' }}>Ativo
                        </option>
                        <option value="0" {{ old('active', $numeracao->active) == '0' ? 'selected' : '' }}>Inativo
                        </option>
                    </select>
                    @error('active')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.numeracao.index') }}"
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
