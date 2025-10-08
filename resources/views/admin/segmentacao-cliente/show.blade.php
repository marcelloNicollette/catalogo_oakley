@extends('layouts.admin-layout')

@section('page_title', 'Visualizar Segmentação de Cliente')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
            </svg>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Visualizar Segmentação') }}
            </h2>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.segmentacao-cliente.edit', $segmentacaoCliente) }}"
                class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                {{ __('Editar') }}
            </a>
            <a href="{{ route('admin.segmentacao-cliente.index') }}"
                class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Voltar') }}
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <!-- Informações da Segmentação -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informações da Segmentação</h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nome</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $segmentacaoCliente->nome }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Slug</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $segmentacaoCliente->slug }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <p class="mt-1">
                                @if($segmentacaoCliente->active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inativo
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Data de Criação</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $segmentacaoCliente->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($segmentacaoCliente->descricao)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500">Descrição</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $segmentacaoCliente->descricao }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Usuários Vinculados -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Usuários Vinculados</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $segmentacaoCliente->users->count() }} {{ $segmentacaoCliente->users->count() === 1 ? 'usuário' : 'usuários' }}
                    </span>
                </div>

                @if($segmentacaoCliente->users->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($segmentacaoCliente->users as $user)
                            <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">
                                            {{ $user->name }}
                                        </h4>
                                        <p class="text-sm text-gray-500 truncate">
                                            {{ $user->email }}
                                        </p>
                                        @if($user->company)
                                            <p class="text-xs text-gray-400 truncate">
                                                {{ $user->company }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum usuário vinculado</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Esta segmentação ainda não possui usuários vinculados.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection