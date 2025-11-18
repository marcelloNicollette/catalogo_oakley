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

@section('page_title', 'Under Armour - Usuários')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                </path>
            </svg>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Usuários') }}
            </h2>
        </div>
        <a href="{{ route('admin.users.create') }}"
            class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            {{ __('Novo Usuário') }}
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulário de Busca -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="search" class="block float-left text-sm font-medium text-gray-700"
                        style="margin:.6rem 1rem .6rem 1rem;">Filtrar: </label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Digite nome, código líder, coleção..."
                        class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        style="width: 33%;">
                </div>
                <div class="flex space-x-2">
                    Total de registros: {{ $users->total() }}
                </div>
            </form>
            @if (request('search'))
                <div class="mt-3 text-sm text-gray-600">
                    Resultados para: <strong>"{{ request('search') }}"</strong>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <div class="p-6 text-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dados</th>

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Código Líder</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Coleção</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $user->name }}<br>
                                                <span class="text-[12px] text-gray-500">
                                                    {{ $user->email }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->type === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->codigo_lider_comercial ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($user->collection)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $user->collection->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Nenhuma</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="flex items-center text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Ver
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="flex items-center text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Editar
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center text-red-600 hover:text-red-900 transition duration-150 ease-in-out"
                                                    onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Excluir
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.users.reset-password', $user) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Gerar nova senha para este usuário? A senha será enviada por e-mail.')">
                                                @csrf
                                                <button type="submit"
                                                    class="flex items-center text-yellow-600 hover:text-yellow-800 transition duration-150 ease-in-out">
                                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 4v1m0 14v1m7-7h1M4 12H3m15.364-6.364l.707.707M5.636 18.364l-.707.707M18.364 18.364l.707-.707M5.636 5.636l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                                                    </svg>
                                                    Gerar nova senha
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if (method_exists($users, 'links'))
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const tableBody = document.querySelector('tbody');
            const tableRows = Array.from(tableBody.querySelectorAll('tr'));
            const noResultsMessage = document.querySelector('.text-center.py-8');
            const paginationDiv = document.querySelector('.mt-4');

            // Função de debounce para otimizar performance
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Função para filtrar a tabela
            function filterTable(searchTerm) {
                const term = searchTerm.toLowerCase().trim();
                let visibleRows = 0;

                tableRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let rowText = '';

                    // Concatena o texto de todas as células (exceto a última que contém os botões)
                    for (let i = 0; i < cells.length - 1; i++) {
                        rowText += cells[i].textContent.toLowerCase() + ' ';
                    }

                    if (term === '' || rowText.includes(term)) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Mostrar/ocultar mensagem de "nenhum resultado"
                if (noResultsMessage) {
                    if (visibleRows === 0 && term !== '') {
                        noResultsMessage.style.display = 'block';
                        noResultsMessage.querySelector('h3').textContent = 'Nenhum usuário encontrado';
                        noResultsMessage.querySelector('p').textContent = `Nenhum resultado para "${searchTerm}"`;
                    } else {
                        noResultsMessage.style.display = 'none';
                    }
                }

                // Ocultar paginação durante filtro local
                if (paginationDiv) {
                    paginationDiv.style.display = term === '' ? 'block' : 'none';
                }
            }

            // Aplicar debounce na função de filtro
            const debouncedFilter = debounce(filterTable, 300);

            // Event listener para o campo de busca
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    debouncedFilter(e.target.value);
                });

                // Limpar filtro quando o campo estiver vazio
                searchInput.addEventListener('keyup', function(e) {
                    if (e.key === 'Escape' || e.target.value === '') {
                        filterTable('');
                    }
                });
            }

            // Adicionar indicador visual de filtro ativo
            function updateSearchIndicator(isActive) {
                const searchContainer = searchInput.closest('.flex-1');
                const label = searchContainer.querySelector('label');

                if (isActive) {
                    label.textContent = 'Buscar Usuários (Filtro Ativo)';
                    label.classList.add('text-blue-600', 'font-semibold');
                    searchInput.classList.add('border-blue-500', 'ring-1', 'ring-blue-500');
                } else {
                    label.textContent = 'Buscar Usuários';
                    label.classList.remove('text-blue-600', 'font-semibold');
                    searchInput.classList.remove('border-blue-500', 'ring-1', 'ring-blue-500');
                }
            }

            // Atualizar indicador quando houver mudanças
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    updateSearchIndicator(e.target.value.trim() !== '');
                });
            }
        });
    </script>
@endpush
