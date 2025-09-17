@extends('layouts.admin-layout')

@section('page_title', 'Olympikus - Novo Item do Calendário')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Novo Item do Calendário') }}
            </h2>
        </div>
        <a href="{{ route('admin.calendario.index') }}"
            class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            {{ __('Voltar') }}
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.calendario.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Título -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                            required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ano -->
                    <div>
                        <label for="ano" class="block text-sm font-medium text-gray-700 mb-2">Ano *</label>
                        <input type="text" name="ano" id="ano" value="{{ old('ano', '2025') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('ano') border-red-500 @enderror"
                            required>
                        @error('ano')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mês -->
                    <div>
                        <label for="mes" class="block text-sm font-medium text-gray-700 mb-2">Mês *</label>
                        <select name="mes" id="mes"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('mes') border-red-500 @enderror"
                            required>
                            <option value="">Selecione o mês</option>
                            @php
                                $meses = [
                                    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                                    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                                    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                                ];
                            @endphp
                            @foreach ($meses as $numero => $nome)
                                <option value="{{ $numero }}" {{ old('mes') == $numero ? 'selected' : '' }}>
                                    {{ $nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('mes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Imagem -->
                    <div class="md:col-span-2">
                        <label for="img" class="block text-sm font-medium text-gray-700 mb-2">Imagem</label>
                        <input type="file" name="img" id="img" accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('img') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Formatos aceitos: JPEG, PNG, JPG, GIF. Tamanho máximo: 2MB</p>
                        @error('img')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info 1 -->
                    <div>
                        <label for="info_1" class="block text-sm font-medium text-gray-700 mb-2">Informação 1</label>
                        <input type="text" name="info_1" id="info_1" value="{{ old('info_1') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('info_1') border-red-500 @enderror">
                        @error('info_1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info 2 -->
                    <div>
                        <label for="info_2" class="block text-sm font-medium text-gray-700 mb-2">Informação 2</label>
                        <input type="text" name="info_2" id="info_2" value="{{ old('info_2') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('info_2') border-red-500 @enderror">
                        @error('info_2')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data -->
                    <div>
                        <label for="data" class="block text-sm font-medium text-gray-700 mb-2">Data</label>
                        <input type="date" name="data" id="data" value="{{ old('data') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('data') border-red-500 @enderror">
                        @error('data')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data MKT -->
                    <div>
                        <label for="data_mkt" class="block text-sm font-medium text-gray-700 mb-2">Data MKT</label>
                        <input type="date" name="data_mkt" id="data_mkt" value="{{ old('data_mkt') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('data_mkt') border-red-500 @enderror">
                        @error('data_mkt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data Trade -->
                    <div>
                        <label for="data_trade" class="block text-sm font-medium text-gray-700 mb-2">Data Trade</label>
                        <input type="date" name="data_trade" id="data_trade" value="{{ old('data_trade') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('data_trade') border-red-500 @enderror">
                        @error('data_trade')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data Cliente -->
                    <div>
                        <label for="data_cliente" class="block text-sm font-medium text-gray-700 mb-2">Data Cliente</label>
                        <input type="date" name="data_cliente" id="data_cliente" value="{{ old('data_cliente') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('data_cliente') border-red-500 @enderror">
                        @error('data_cliente')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data DTC -->
                    <div>
                        <label for="data_dtc" class="block text-sm font-medium text-gray-700 mb-2">Data DTC</label>
                        <input type="date" name="data_dtc" id="data_dtc" value="{{ old('data_dtc') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('data_dtc') border-red-500 @enderror">
                        @error('data_dtc')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('admin.calendario.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection