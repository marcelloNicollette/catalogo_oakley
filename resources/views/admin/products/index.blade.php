@extends('layouts.admin-layout')

@push('css')
    <style>
        .collection-card {
            transition: all 0.3s ease;
        }

        .collection-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endpush

@section('page_title', 'Under Amour - Produtos')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">

            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Produtos') }}
            </h2>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.products.create') }}"
                class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                {{ __('Novo Produto') }}
            </a>
            <a href="{{ route('admin.products.deleted') }}"
                class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
                {{ __('Excluídos') }}
            </a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <!-- Filtros e busca -->
            <form id="product-filters" class="mb-6">
                <div class="grid grid-cols-4 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Busca</label>
                        <input id="search" type="text" placeholder="Buscar por nome ou código"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="todos">Todos</option>
                            <option value="1">Ativos</option>
                            <option value="0">Inativos</option>
                        </select>
                    </div>
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700">Ordenar</label>
                        <select id="order"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="order_asc">Ordem ↑</option>
                            <option value="order_desc">Ordem ↓</option>
                            <option value="created_desc">Mais recentes</option>
                            <option value="created_asc">Mais antigos</option>
                            <option value="name_asc">Nome A-Z</option>
                            <option value="name_desc">Nome Z-A</option>
                            <option value="code_asc">Código A-Z</option>
                            <option value="code_desc">Código Z-A</option>
                            <option value="price_asc">Preço ↑</option>
                            <option value="price_desc">Preço ↓</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button id="clear" type="button"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            Limpar
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tabela -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço
                        </th>
                        <!--<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria
                                            </th>-->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                        </th>
                    </tr>
                </thead>
                <tbody id="products-tbody" class="bg-white divide-y divide-gray-200">
                    @foreach ($products as $product)
                        <tr class="product-row" data-name="{{ $product->name }}" data-code="{{ $product->code }}"
                            data-order="{{ $product->order ?? '' }}" data-price="{{ $product->price }}"
                            data-active="{{ $product->active ? '1' : '0' }}"
                            data-created="{{ optional($product->created_at)->timestamp }}">

                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->order ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">R$ {{ $product->price }}
                            </td>
                            <!--<td class="px-6 py-4 whitespace-nowrap">{{ $product->category->name }}</td>-->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="flex items-center text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center text-red-600 hover:text-red-900 transition duration-150 ease-in-out"
                                            onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div id="products-pagination" class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('product-filters');
            const searchInput = document.getElementById('search');
            const statusSelect = document.getElementById('status');
            const orderSelect = document.getElementById('order');
            const clearBtn = document.getElementById('clear');
            const tbody = document.getElementById('products-tbody');
            const pagination = document.getElementById('products-pagination');

            if (!tbody) return;

            let rows = Array.from(tbody.querySelectorAll('.product-row'));

            function isFilteringActive(search, status) {
                const hasSearch = !!search && search.length > 0;
                const hasStatus = status !== 'todos';
                return hasSearch || hasStatus;
            }

            function applyFilters() {
                const search = (searchInput && searchInput.value ? searchInput.value.trim().toLowerCase() : '');
                const status = (statusSelect && statusSelect.value ? statusSelect.value : 'todos');

                rows.forEach(row => {
                    const name = (row.dataset.name || '').toLowerCase();
                    const code = (row.dataset.code || '').toLowerCase();
                    const active = (row.dataset.active || '');

                    const matchesSearch = !search || name.includes(search) || code.includes(search);
                    const matchesStatus = status === 'todos' || active === status;

                    row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                });

                if (pagination) {
                    pagination.style.display = isFilteringActive(search, status) ? 'none' : '';
                }
            }

            function applySort() {
                if (!orderSelect) return;
                const order = orderSelect.value || 'created_desc';

                const rowsArray = Array.from(rows);

                rowsArray.sort((a, b) => {
                    const aName = (a.dataset.name || '').toLowerCase();
                    const bName = (b.dataset.name || '').toLowerCase();
                    const aCode = (a.dataset.code || '').toLowerCase();
                    const bCode = (b.dataset.code || '').toLowerCase();
                    const aOrder = parseInt(a.dataset.order || '0');
                    const bOrder = parseInt(b.dataset.order || '0');
                    const aPrice = parseFloat(a.dataset.price || '0');
                    const bPrice = parseFloat(b.dataset.price || '0');
                    const aCreated = parseInt(a.dataset.created || '0');
                    const bCreated = parseInt(b.dataset.created || '0');

                    switch (order) {
                        case 'order_asc':
                            return aOrder - bOrder;
                        case 'order_desc':
                            return bOrder - aOrder;
                        case 'created_asc':
                            return aCreated - bCreated;
                        case 'name_asc':
                            return aName.localeCompare(bName);
                        case 'name_desc':
                            return bName.localeCompare(aName);
                        case 'code_asc':
                            return aCode.localeCompare(bCode);
                        case 'code_desc':
                            return bCode.localeCompare(aCode);
                        case 'price_asc':
                            return aPrice - bPrice;
                        case 'price_desc':
                            return bPrice - aPrice;
                        case 'created_desc':
                        default:
                            return bCreated - aCreated;
                    }
                });

                rowsArray.forEach(row => tbody.appendChild(row));
                rows = rowsArray;

                // Reaplica filtros após ordenar para manter visibilidade correta
                applyFilters();
            }

            function resetFilters() {
                if (searchInput) searchInput.value = '';
                if (statusSelect) statusSelect.value = 'todos';
                if (orderSelect) orderSelect.value = 'created_desc';

                rows.forEach(row => row.style.display = '');
                if (pagination) pagination.style.display = '';

                applySort();
            }

            if (form) form.addEventListener('submit', e => e.preventDefault());
            if (searchInput) searchInput.addEventListener('input', applyFilters);
            if (statusSelect) statusSelect.addEventListener('change', applyFilters);
            if (orderSelect) orderSelect.addEventListener('change', applySort);
            if (clearBtn) clearBtn.addEventListener('click', resetFilters);

            // Ordenação inicial
            applySort();
        });
    </script>
@endpush
