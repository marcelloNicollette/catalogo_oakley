@extends('layouts.admin-layout')

@push('css')
    <style>
        .user-detail-card {
            transition: all 0.3s ease;
        }

        .user-avatar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
@endpush

@section('page_title', 'Under Armour - Detalhes do Usuário')

@section('content-wrapper')
    <div class="flex items-center space-x-2 mb-6">
        <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
            </path>
        </svg>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Detalhes do Usuário') }}
        </h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <!-- Header com avatar e informações básicas -->
            <div class="flex items-center space-x-6 mb-8">
                <div class="user-avatar h-24 w-24 rounded-full flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2
                        {{ $user->type === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($user->type) }}
                    </span>
                </div>
            </div>

            <!-- Informações detalhadas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="user-detail-card bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Informações Pessoais</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nome Completo</label>
                            <p class="text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">E-mail</label>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tipo de Usuário</label>
                            <p class="text-gray-900">{{ ucfirst($user->type) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Empresa</label>
                            <p class="text-gray-900">{{ $user->company ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Setor</label>
                            <p class="text-gray-900">{{ $user->setor ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Telefone</label>
                            <p class="text-gray-900">{{ $user->phone ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Código Líder Comercial</label>
                            <p class="text-gray-900">{{ $user->codigo_lider_comercial ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Coleção</label>
                            @if ($user->collection)
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $user->collection->name }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    Nenhuma coleção atribuída
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="user-detail-card bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Informações da Conta</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Data de Criação</label>
                            <p class="text-gray-900">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Última Atualização</label>
                            <p class="text-gray-900">
                                {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                        @if ($user->email_verified_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">E-mail Verificado em</label>
                                <p class="text-gray-900">{{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @else
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status do E-mail</label>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Não verificado
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center text-gray-600 hover:text-gray-900 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Voltar para Lista
                </a>

                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Editar
                    </a>

                    @if ($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out"
                                onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Excluir
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Scripts custom para visualização de usuário
    </script>
@endpush
