@extends('layouts.admin-layout')

@push('css')
    <style>
        .subcategory-detail-card {
            transition: all 0.3s ease;
        }
    </style>
@endpush

@section('page_title', 'Oakley - Detalhes da Subcategoria')

@section('content-wrapper')
    <div class="flex items-center space-x-2 mb-6">
        <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
            </path>
        </svg>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Detalhes da Subcategoria') }}
        </h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Header com informações básicas -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $subcategory->faixa }}</h3>
                    <p class="text-gray-600">Categoria: {{ $subcategory->category->name }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.subcategories.edit', $subcategory) }}"
                        class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('admin.subcategories.index') }}"
                        class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18">
                            </path>
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Detalhes da subcategoria -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="subcategory-detail-card bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Informações Básicas</h4>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">ID:</span>
                            <span class="ml-2 text-sm text-gray-900">{{ $subcategory->id }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Faixa:</span>
                            <span class="ml-2 text-sm text-gray-900">{{ $subcategory->faixa }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Slug:</span>
                            <span class="ml-2 text-sm text-gray-900">{{ $subcategory->slug }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Categoria:</span>
                            <span class="ml-2 text-sm text-gray-900">{{ $subcategory->category->name }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Ordem:</span>
                            <span class="ml-2 text-sm text-gray-900">{{ $subcategory->order }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Status:</span>
                            @if ($subcategory->active)
                                <span
                                    class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Ativo
                                </span>
                            @else
                                <span
                                    class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inativo
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="subcategory-detail-card bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Informações de Sistema</h4>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Criado em:</span>
                            <span
                                class="ml-2 text-sm text-gray-900">{{ $subcategory->created_at->format('d/m/Y H:i:s') }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Atualizado em:</span>
                            <span
                                class="ml-2 text-sm text-gray-900">{{ $subcategory->updated_at->format('d/m/Y H:i:s') }}</span>
                        </div>
                        @if ($subcategory->deleted_at)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Excluído em:</span>
                                <span
                                    class="ml-2 text-sm text-red-600">{{ $subcategory->deleted_at->format('d/m/Y H:i:s') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="mt-8 flex justify-end space-x-3">
                <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" class="inline"
                    onsubmit="return confirm('Tem certeza que deseja excluir esta subcategoria? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Excluir Subcategoria
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Scripts custom para detalhes da subcategoria
    </script>
@endpush
