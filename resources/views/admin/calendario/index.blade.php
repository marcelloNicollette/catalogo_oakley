@extends('layouts.admin-layout')

@push('css')
    <style>
        .calendario-card {
            transition: all 0.3s ease;
        }

        .calendario-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endpush

@section('page_title', 'Oakley - Calendário')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Calendário') }}
            </h2>
        </div>
        <a href="{{ route('admin.calendario.create') }}"
            class="flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            {{ __('Novo Item') }}
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Imagem</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ano/Mês</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($calendarios as $calendario)
                            <tr class="calendario-card">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($calendario->img)
                                        <img src="{{ asset('storage/' . $calendario->img) }}" alt="{{ $calendario->title }}"
                                            class="h-12 w-12 object-cover rounded-lg">
                                    @else
                                        @php
                                            $img =
                                                '/images/produtos/' .
                                                $calendario->product->code .
                                                '_' .
                                                $calendario->product->colors->first()->color_code .
                                                '.jpg';
                                            if (file_exists(public_path($img))) {
                                                echo '<img src="' .
                                                    asset($img) .
                                                    '" 
                                                alt="' .
                                                    $calendario->product->code .
                                                    '"
                                                class="h-12 w-12 object-cover rounded-lg">';
                                            }
                                        @endphp
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $calendario->title }}</div>
                                    @if ($calendario->info_1)
                                        <div class="text-sm text-gray-500">{{ $calendario->info_1 }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $calendario->ano }}</div>
                                    <div class="text-sm text-gray-500">{{ $calendario->mes_nome }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if ($calendario->data)
                                        {{ $calendario->data->format('d/m/Y') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if ($calendario->product)
                                        <div class="flex items-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $calendario->product->deleted_at ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                                {{ $calendario->product->name }}
                                                @if ($calendario->product->deleted_at)
                                                    <span class="ml-1 text-red-600 font-bold">🚩</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">Código: {{ $calendario->product->code }}
                                            @if ($calendario->product->deleted_at)
                                                <span class="text-red-500 font-semibold ml-2">(DELETADO)</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.calendario.show', $calendario) }}"
                                            class="flex items-center text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Ver
                                        </a>
                                        <a href="{{ route('admin.calendario.edit', $calendario) }}"
                                            class="flex items-center text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">
                                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.calendario.destroy', $calendario) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center text-red-600 hover:text-red-900 transition duration-150 ease-in-out">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
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
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Nenhum item encontrado no calendário.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($calendarios->hasPages())
                <div class="mt-6">
                    {{ $calendarios->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
