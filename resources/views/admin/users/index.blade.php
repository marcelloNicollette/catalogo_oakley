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

@section('page_title', 'Oakley - Usuários')

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
            <form id="usersSearchForm" method="GET" action="{{ route('admin.users.index') }}"
                class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="search" class="block float-left text-sm font-medium text-gray-700"
                        style="margin:.6rem 1rem .6rem 1rem;">Filtrar: </label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Digite nome, código líder, coleção..."
                        class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        style="width: 33%;">
                </div>
                <div class="flex space-x-2">
                    Total de registros: <span
                        id="usersTotalCount">{{ method_exists($users, 'total') ? $users->total() : $users->count() }}</span>
                </div>
            </form>
            <div id="usersSearchResult" class="mt-3 text-sm text-gray-600"
                @if (!request('search')) style="display:none" @endif>
                Resultados para: <strong
                    id="usersSearchTerm">{{ request('search') ? '"' . request('search') . '"' : '' }}</strong>
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
                                Nome</th>

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
                    <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                        @include('admin.users.partials.rows', [
                            'users' => $users,
                            'user_login' => $user_login,
                        ])
                    </tbody>
                </table>
            </div>

            <div id="usersPagination" class="mt-4" @if (!method_exists($users, 'links')) style="display:none" @endif>
                @if (method_exists($users, 'links'))
                    {{ $users->appends(request()->except('page'))->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const form = document.getElementById('usersSearchForm');
            const tableBody = document.getElementById('usersTableBody');
            const totalCount = document.getElementById('usersTotalCount');
            const pagination = document.getElementById('usersPagination');
            const searchResult = document.getElementById('usersSearchResult');
            const searchTermEl = document.getElementById('usersSearchTerm');

            if (!searchInput || !form || !tableBody || !totalCount || !pagination || !searchResult || !
                searchTermEl) {
                return;
            }

            let timeout;
            let lastTerm = searchInput.value.trim();

            function setUrl(term) {
                const nextUrl = new URL(window.location.href);
                nextUrl.searchParams.delete('page');
                if (term) {
                    nextUrl.searchParams.set('search', term);
                } else {
                    nextUrl.searchParams.delete('search');
                }
                history.replaceState({}, '', nextUrl.toString());
            }

            function applyResult(term, data) {
                tableBody.innerHTML = data.rowsHtml || '';
                totalCount.textContent = typeof data.total === 'number' ? String(data.total) : String(data.total ||
                    '');

                if (term) {
                    searchTermEl.textContent = `"${term}"`;
                    searchResult.style.display = 'block';
                    pagination.style.display = 'none';
                } else {
                    searchTermEl.textContent = '';
                    searchResult.style.display = 'none';
                    if (data.paginationHtml) {
                        pagination.innerHTML = data.paginationHtml;
                        pagination.style.display = 'block';
                    } else {
                        pagination.innerHTML = '';
                        pagination.style.display = 'none';
                    }
                }
            }

            function load(term) {
                if (term === lastTerm) {
                    return;
                }
                lastTerm = term;

                const url = new URL(form.action, window.location.origin);
                if (term) {
                    url.searchParams.set('search', term);
                }

                const onSuccess = function(data) {
                    applyResult(term, data || {});
                    setUrl(term);
                };

                if (window.jQuery) {
                    window.jQuery.ajax({
                        url: url.toString(),
                        method: 'GET',
                        dataType: 'json',
                        success: onSuccess,
                    });
                    return;
                }

                fetch(url.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then(response => response.json())
                    .then(onSuccess);
            }

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    load(searchInput.value.trim());
                }, 400);
            });

            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(timeout);
                    load(searchInput.value.trim());
                }
            });

            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Escape') {
                    searchInput.value = '';
                    clearTimeout(timeout);
                    load('');
                }
            });
        });
    </script>
@endpush
