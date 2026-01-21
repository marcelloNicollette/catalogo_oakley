@extends('layouts.admin-layout')

@section('page_title', 'Olympikus - Solicitações de Acesso')

@section('content-wrapper')
    <div x-data="{ rejectionModalOpen: false, rejectionAction: '' }">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Solicitações de Acesso') }}
                </h2>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (!empty($error))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ $error }}</span>
            </div>
        @endif

        @if (session('new_user_password'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">Usuário criado: {{ session('new_user_email') }}. Senha provisória:
                    <strong>{{ session('new_user_password') }}</strong></span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 overflow-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                E-mail
                            </th>
                            <!--<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa
                                                                                                                </th>
                                                                                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Setor
                                                                                                                </th>
                                                                                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone
                                                                                                                </th>-->
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Criado em
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Situação
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($requests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $request->name }}

                                    <p class="text-xs text-gray-500">
                                        Empresa: {{ $request->company }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Setor: {{ $request->setor }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Telefone: {{ $request->phone }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $request->email }}</td>
                                <!--<td class="px-6 py-4 whitespace-nowrap">{{ $request->company }}</td>
                                                                                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->setor }}</td>
                                                                                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->phone }}</td>-->
                                <td class="px-6 py-4 whitespace-nowrap">{{ $request->created_at?->format('d/m/Y H:i') }}
                                </td>
                                @php
                                    $approved = !is_null($request->approved_at);
                                    $rejected = !is_null($request->rejected_at);
                                    $exists = in_array(
                                        strtolower($request->email),
                                        array_map('strtolower', $existingUserEmails ?? []),
                                    );
                                @endphp
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($approved)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Aprovado</span>
                                    @elseif ($rejected)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-red-100 text-red-800"
                                            title="{{ $request->rejection_reason }}">Reprovado</span>
                                    @elseif ($exists)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Já
                                            é usuário</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">Pendente</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (!$approved && !$exists && !$rejected)
                                        <div class="flex space-x-2">
                                            <form method="POST"
                                                action="{{ route('admin.access.approve', $request->id) }}">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                                    Aprovar
                                                </button>
                                            </form>
                                            <button type="button"
                                                @click="rejectionModalOpen = true; rejectionAction = '{{ route('admin.access.reject', $request->id) }}'"
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                                Reprovar
                                            </button>
                                        </div>
                                    @elseif ($approved)
                                        <button
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md bg-green-100 text-green-800 cursor-not-allowed"
                                            disabled>
                                            Aprovado
                                        </button>
                                    @elseif ($rejected)
                                        <button
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md bg-red-100 text-red-800 cursor-not-allowed"
                                            disabled title="{{ $request->rejection_reason }}">
                                            Reprovado
                                        </button>
                                    @else
                                        <button
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-yellow-100 text-yellow-800 cursor-not-allowed"
                                            disabled>
                                            Já é usuário
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4" colspan="8">Nenhuma solicitação encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    @if (method_exists($requests, 'links'))
                        {{ $requests->links() }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="rejectionModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="rejectionModalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    aria-hidden="true" @click="rejectionModalOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="rejectionModalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form method="POST" :action="rejectionAction">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mt-3 mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Reprovar Solicitação
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 mb-2">
                                            Por favor, informe o motivo da reprovação:
                                        </p>
                                        <textarea name="rejection_reason" rows="3"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                            required placeholder="Digite o motivo aqui..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="mt-3 mr-3  w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Reprovar
                            </button>
                            <button type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                @click="rejectionModalOpen = false">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
