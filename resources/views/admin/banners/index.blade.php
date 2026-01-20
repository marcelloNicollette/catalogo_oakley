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

@section('page_title', 'Banners')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-800" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" enable-background="new 0 0 32 32"
                xml:space="preserve">
                <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="25" y1="28"
                    x2="7" y2="28" />
                <line fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10" x1="16" y1="23"
                    x2="16" y2="4" />
                <polyline fill="none" stroke="#000000" stroke-width="2" stroke-miterlimit="10"
                    points="9,16 16,23 23,16 " />
            </svg>

            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Banners') }}
            </h2>
        </div>
        <a href="{{ route('admin.banners.create') }}"
            class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            {{ __('Novo Banner') }}
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

            <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Imagem</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Imagem Mobile</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                        </th>
                    </tr>
                </thead>
                <tbody id="banners-table-body" class="bg-white divide-y divide-gray-200">
                    @foreach ($banners as $banner)
                        <tr data-id="{{ $banner->id }}" class="cursor-move">

                            <td class="px-6 py-4 whitespace-nowrap"><img src="{{ asset('/' . $banner->image) }}"
                                    alt="Imagem atual" class="h-32 w-auto object-cover rounded-lg shadow-sm"></td>
                            <td class="px-6 py-4 whitespace-nowrap"><img src="{{ asset('/' . $banner->image_mobile) }}"
                                    alt="Imagem atual" class="h-32 w-auto object-cover rounded-lg shadow-sm"></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $banner->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $banner->active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap banner-order">{{ $banner->order }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                        class="flex items-center text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center text-red-600 hover:text-red-900 transition duration-150 ease-in-out"
                                            onclick="return confirm('Tem certeza que deseja excluir esta coleção?')">
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

            <div class="mt-4">
                {{ $banners->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('banners-table-body');
            var sortable = Sortable.create(el, {
                animation: 150,
                onEnd: function(evt) {
                    var order = [];
                    el.querySelectorAll('tr').forEach(function(row) {
                        var id = row.getAttribute('data-id');
                        if (id) {
                            order.push(id);
                        }
                    });

                    // Update the visual order numbers
                    el.querySelectorAll('tr').forEach(function(row, index) {
                        var orderCell = row.querySelector('.banner-order');
                        if (orderCell) {
                            orderCell.textContent = index + 1;
                        }
                    });

                    if (order.length > 0) {
                        fetch('{{ route('admin.banners.reorder') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    order: order
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Ordem atualizada com sucesso.');
                                } else {
                                    console.error('Erro ao atualizar ordem.');
                                }
                            })
                            .catch(error => console.error('Erro:', error));
                    }
                }
            });
        });
    </script>
@endpush
