@extends('layouts.admin-layout')

@section('page_title', 'Under Armour - Solicitações de Acesso')

@section('content-wrapper')
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
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
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
        <div class="p-6 text-gray-900">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criado em
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Situação
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
                                    Empresa:
                                    {{ \Illuminate\Support\Str::limit($request->company, 20, '...') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Setor: {{ $request->setor }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Telefone: {{ $request->phone }}
                                </p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $request->email }}</td>

                            <td class="px-6 py-4 whitespace-nowrap">{{ $request->created_at?->format('d/m/Y H:i') }}</td>
                            @php
                                $approved = !is_null($request->approved_at);

                                $exists = in_array(
                                    strtolower($request->email),
                                    array_map('strtolower', $existingUserEmails ?? []),
                                );
                            @endphp
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($approved)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Aprovado</span>
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
                                @if (!$approved && !$exists)
                                    <form method="POST" action="{{ route('admin.access.approve', $request->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                            Aprovar
                                        </button>
                                    </form>
                                @elseif ($approved)
                                    <button
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md bg-green-100 text-green-800 cursor-not-allowed"
                                        disabled>
                                        Aprovado
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
@endsection
