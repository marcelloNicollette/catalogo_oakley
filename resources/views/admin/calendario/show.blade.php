@extends('layouts.admin-layout')

@section('page_title', 'Olympikus - Visualizar Item do Calendário')

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
                {{ __('Visualizar Item do Calendário') }}
            </h2>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.calendario.edit', $calendario) }}"
                class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                {{ __('Editar') }}
            </a>
            <a href="{{ route('admin.calendario.index') }}"
                class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                {{ __('Voltar') }}
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="grid grid-cols-3 gap-10">
                <!-- Imagem -->
                @if ($calendario->img)
                    <div class="col-span-1">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Imagem</h3>
                            <img src="{{ asset('storage/' . $calendario->img) }}" alt="{{ $calendario->title }}"
                                class="w-full h-auto rounded-lg shadow-md">
                        </div>
                    </div>
                @endif

                <!-- Informações Principais -->
                <div class="{{ $calendario->img ? 'col-span-2' : 'col-span-3' }}">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Principais</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Título</label>
                                <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                    {{ $calendario->title }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ano</label>
                                <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                    {{ $calendario->ano }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Mês</label>
                                <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                    {{ $calendario->mes_nome }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Data</label>
                                <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                    {{ $calendario->data ? $calendario->data->format('d/m/Y') : '-' }}
                                </p>
                            </div>

                            @if ($calendario->info_1)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Informação 1</label>
                                    <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                        {{ $calendario->info_1 }}</p>
                                </div>
                            @endif

                            @if ($calendario->info_2)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Informação 2</label>
                                    <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                        {{ $calendario->info_2 }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Datas Específicas</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Data MKT</label>
                                <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                    {{ $calendario->data_mkt ? $calendario->data_mkt->format('d/m/Y') : '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Data Trade</label>
                                <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                    {{ $calendario->data_trade ? $calendario->data_trade->format('d/m/Y') : '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Data Cliente</label>
                                <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                    {{ $calendario->data_cliente ? $calendario->data_cliente->format('d/m/Y') : '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Data DTC</label>
                                <p class="mt-1 text-sm text-gray-900 px-3 py-2 rounded border">
                                    {{ $calendario->data_dtc ? $calendario->data_dtc->format('d/m/Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Produto Vinculado -->
            @if ($calendario->product)
                <div class="mt-6">
                    <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                        <h3 class="text-lg font-medium text-blue-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Produto Vinculado
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-blue-700">Nome do Produto</label>
                                <p class="mt-1 text-sm text-blue-900 px-3 py-2 rounded border border-blue-200">
                                    {{ $calendario->product->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-blue-700">Código</label>
                                <p class="mt-1 text-sm text-blue-900 px-3 py-2 rounded border border-blue-200">
                                    {{ $calendario->product->code }}</p>
                            </div>

                            @if ($calendario->product->description)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-blue-700">Descrição</label>
                                    <p class="mt-1 text-sm text-blue-900 px-3 py-2 rounded border border-blue-200">
                                        {{ $calendario->product->description }}</p>
                                </div>
                            @endif

                            <div class="md:col-span-2">
                                <a href="{{ route('admin.products.edit', $calendario->product) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Ver Produto Completo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Datas Específicas -->


            <!-- Informações do Sistema -->
            <!--<div class="mt-6">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Sistema</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Criado em</label>
                                        <p class="mt-1 text-sm text-gray-900 bg-white px-3 py-2 rounded border">
                                            {{ $calendario->created_at->format('d/m/Y H:i:s') }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Última atualização</label>
                                        <p class="mt-1 text-sm text-gray-900 bg-white px-3 py-2 rounded border">
                                            {{ $calendario->updated_at->format('d/m/Y H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>-->

            <!-- Ações -->
            <div class="mt-6 flex justify-end space-x-3">
                <form action="{{ route('admin.calendario.destroy', $calendario) }}" method="POST"
                    onsubmit="return confirm('Tem certeza que deseja excluir este item do calendário? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
