@extends('layouts.admin-layout')

@push('css')
    <style>
        .user-card {
            transition: all 0.3s ease;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endpush

@section('page_title', 'Segmentação de Clientes')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Segmentação de Clientes') }}
            </h2>
        </div>
        <a href="{{ route('admin.segmentacao-cliente.create') }}"
            class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            {{ __('Nova Segmentação') }}
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filtros (3 colunas) -->
    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
        <div class="grid grid-cols-4 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Busca</label>
                <input type="text" id="search" placeholder="Nome, slug ou descrição"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Todos</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>
            <div>
                <label for="usuarios" class="block text-sm font-medium text-gray-700">Usuários Vinculados</label>
                <select id="usuarios"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Todos</option>
                    <option value="com">Com usuários</option>
                    <option value="sem">Sem usuários</option>
                </select>
            </div>
            <div class="mt-6">
                <button type="button" id="clearFilters"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm">
                    Limpar
                </button>
            </div>
        </div>

    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nome
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descrição
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Usuários Vinculados
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody id="segmentacoesTableBody" class="bg-white divide-y divide-gray-200">
                        @forelse ($segmentacoesCliente as $segmentacaoCliente)
                            <tr class="user-card"
                                data-name="{{ \Illuminate\Support\Str::lower($segmentacaoCliente->nome) }}"
                                data-slug="{{ \Illuminate\Support\Str::lower($segmentacaoCliente->slug) }}"
                                data-descricao="{{ \Illuminate\Support\Str::lower($segmentacaoCliente->descricao ?? '') }}"
                                data-status="{{ $segmentacaoCliente->active ? 'ativo' : 'inativo' }}"
                                data-users-count="{{ $segmentacaoCliente->users->count() }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $segmentacaoCliente->nome }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $segmentacaoCliente->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if ($segmentacaoCliente->descricao)
                                        {{ \Illuminate\Support\Str::limit($segmentacaoCliente->descricao ?? '', 20) }}
                                    @else
                                        Sem descrição
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($segmentacaoCliente->active)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Ativo
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inativo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $segmentacaoCliente->users->count() }} usuário(s)
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.segmentacao-cliente.show', $segmentacaoCliente) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                        <a href="{{ route('admin.segmentacao-cliente.edit', $segmentacaoCliente) }}"
                                            class="text-blue-600 hover:text-blue-900">Editar</a>
                                        <form
                                            action="{{ route('admin.segmentacao-cliente.destroy', $segmentacaoCliente) }}"
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Tem certeza que deseja excluir esta segmentação?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Nenhuma segmentação encontrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const searchInput = document.getElementById('search');
            const statusSelect = document.getElementById('status');
            const usuariosSelect = document.getElementById('usuarios');
            const clearBtn = document.getElementById('clearFilters');
            const tbody = document.getElementById('segmentacoesTableBody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const paginationContainer = document.getElementById('paginationContainer');

            const applyFilters = () => {
                const search = (searchInput.value || '').toLowerCase().trim();
                const status = (statusSelect.value || '').trim();
                const usuarios = (usuariosSelect.value || '').trim();

                let visibleCount = 0;

                rows.forEach(row => {
                    const name = (row.getAttribute('data-name') || '').toLowerCase();
                    const slug = (row.getAttribute('data-slug') || '').toLowerCase();
                    const descricao = (row.getAttribute('data-descricao') || '').toLowerCase();
                    const rowStatus = (row.getAttribute('data-status') || '').trim();
                    const usersCount = parseInt(row.getAttribute('data-users-count') || '0', 10);

                    let matches = true;

                    // Busca por nome/slug/descrição
                    if (search) {
                        const haystack = name + ' ' + slug + ' ' + descricao;
                        if (!haystack.includes(search)) {
                            matches = false;
                        }
                    }

                    // Filtro de status
                    if (matches && status) {
                        if (rowStatus !== status) {
                            matches = false;
                        }
                    }

                    // Filtro por usuários vinculados
                    if (matches && usuarios) {
                        if (usuarios === 'com' && usersCount === 0) {
                            matches = false;
                        } else if (usuarios === 'sem' && usersCount > 0) {
                            matches = false;
                        }
                    }

                    row.style.display = matches ? '' : 'none';
                    if (matches) visibleCount++;
                });

                // Oculta paginação quando filtros ativos (qualquer valor diferente de vazio)
                const anyFilterActive = !!(search || status || usuarios);
                if (paginationContainer) {
                    paginationContainer.style.display = anyFilterActive ? 'none' : '';
                }
            };

            const clearFilters = () => {
                searchInput.value = '';
                statusSelect.value = '';
                usuariosSelect.value = '';
                applyFilters();
            };

            searchInput.addEventListener('input', applyFilters);
            statusSelect.addEventListener('change', applyFilters);
            usuariosSelect.addEventListener('change', applyFilters);
            clearBtn.addEventListener('click', clearFilters);
        })();
    </script>
@endpush
