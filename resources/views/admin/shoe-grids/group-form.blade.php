@extends('layouts.admin-layout')

@section('page_title', $group->exists ? 'Editar Grupo' : 'Novo Grupo')

@section('content-wrapper')

    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.shoe-grids.index') }}"
           class="text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $group->exists ? 'Editar Grupo: ' . $group->name : 'Novo Grupo' }}
        </h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

            <form action="{{ $group->exists
                    ? route('admin.shoe-grids.groups.update', $group)
                    : route('admin.shoe-grids.groups.store') }}"
                  method="POST">
                @csrf
                @if($group->exists) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome do Grupo *</label>
                        <input type="text" name="name" id="name" required
                            placeholder="ex: Masculino"
                            value="{{ old('name', $group->name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700">Ordem de Exibição</label>
                        <input type="number" name="sort_order" id="sort_order" min="0"
                            value="{{ old('sort_order', $group->sort_order ?? 0) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="flex items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1"
                                {{ old('active', $group->active ?? true) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-700">Ativo</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.shoe-grids.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-150 ease-in-out">
                        {{ $group->exists ? 'Salvar Alterações' : 'Criar Grupo' }}
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- Zona de perigo (só na edição) --}}
    @if($group->exists)
        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-red-100">
            <div class="p-6">
                <h3 class="text-sm font-medium text-red-600 mb-1">Zona de Perigo</h3>
                <p class="text-sm text-gray-500 mb-4">Remover este grupo apagará também todas as suas grades e quantidades.</p>
                <form action="{{ route('admin.shoe-grids.groups.destroy', $group) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Remover o grupo {{ $group->name }} e todas as suas grades?')"
                        class="flex items-center text-red-600 hover:text-red-900 transition duration-150 ease-in-out text-sm font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Remover Grupo
                    </button>
                </form>
            </div>
        </div>
    @endif

@endsection
