@extends('layouts.admin-layout')

@section('page_title', 'Under Armour - Sugestões enviadas')

@section('content-wrapper')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 8h10M7 12h6m-6 4h8M5 7a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7z"></path>
            </svg>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Sugestões enviadas') }}
            </h2>
        </div>

        <form method="GET" action="{{ route('admin.suggestions.index') }}" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por texto/URL"
                class="border border-gray-300 rounded-lg px-3 py-2">

            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2">
                <option value="">Todos os status</option>
                @foreach ($statusOptions as $value => $label)
                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                        {{ $label }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-black hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg">
                Filtrar
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Texto
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Respondida?</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notas
                            Admin</th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($suggestions as $suggestion)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $suggestion->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ optional($suggestion->user)->name ?? '—' }}
                                <div class="text-xs text-gray-500">{{ optional($suggestion->user)->email }}</div>
                                <div class="text-xs text-gray-400">{{ $suggestion->created_at?->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ \Illuminate\Support\Str::limit($suggestion->suggestion_text, 120) }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                    @if ($suggestion->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($suggestion->status === 'reviewed') bg-blue-100 text-blue-800
                                    @elseif($suggestion->status === 'implemented') bg-green-100 text-green-800
                                    @elseif($suggestion->status === 'rejected') bg-red-100 text-red-800 @endif">
                                    {{ $statusOptions[$suggestion->status] ?? $suggestion->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.suggestions.update', $suggestion) }}"
                                    class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="responded"
                                        value="{{ $suggestion->status !== 'pending' ? 0 : 1 }}">
                                    @if ($suggestion->status === 'pending')
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-1 rounded">Marcar
                                            como respondida</button>
                                    @else
                                        <button type="submit"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-3 py-1 rounded">Marcar
                                            como pendente</button>
                                    @endif
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.suggestions.update', $suggestion) }}"
                                    class="space-y-2">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="admin_notes" rows="2" class="w-64 border border-gray-300 rounded-lg px-2 py-1"
                                        placeholder="Adicionar notas">{{ $suggestion->admin_notes }}</textarea>
                                    <div class="flex items-center space-x-2">
                                        <select name="status" class="border border-gray-300 rounded-lg px-2 py-1">
                                            <option value="">Manter</option>
                                            @foreach ($statusOptions as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ $suggestion->status === $value ? 'selected' : '' }}>
                                                    {{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit"
                                            class="bg-black hover:bg-gray-800 text-white text-sm px-3 py-1 rounded">Salvar</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $suggestions->links() }}
            </div>
        </div>
    </div>
@endsection
