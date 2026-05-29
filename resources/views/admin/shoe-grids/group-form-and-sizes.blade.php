{{-- resources/views/admin/shoe-grids/group-form.blade.php --}}
@extends('layouts.admin')

@section('title', $group->exists ? 'Editar Grupo' : 'Novo Grupo')

@section('content')
<div class="max-w-lg mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.shoe-grids.index') }}"
           class="text-gray-400 hover:text-gray-600">← Voltar</a>
        <h1 class="text-xl font-bold text-gray-900">
            {{ $group->exists ? 'Editar: '.$group->name : 'Novo Grupo' }}
        </h1>
    </div>

    <form method="POST"
          action="{{ $group->exists
              ? route('admin.shoe-grids.groups.update', $group)
              : route('admin.shoe-grids.groups.store') }}"
          class="bg-white rounded-xl shadow-sm border border-gray-200 divide-y divide-gray-100">
        @csrf
        @if($group->exists) @method('PUT') @endif

        <div class="p-6 space-y-4">
            <div>
                <label class="label">Nome *</label>
                <input type="text" name="name"
                       value="{{ old('name', $group->name) }}"
                       placeholder="ex: Masculino"
                       required class="input">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label">Ordem</label>
                <input type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $group->sort_order ?? 0) }}"
                       class="input w-32">
            </div>

            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1"
                       {{ old('active', $group->active ?? true) ? 'checked' : '' }}
                       class="rounded">
                <span class="text-sm text-gray-700">Ativo</span>
            </label>
        </div>

        <div class="p-6 flex justify-between">
            <a href="{{ route('admin.shoe-grids.index') }}"
               class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                {{ $group->exists ? 'Salvar' : 'Criar grupo' }}
            </button>
        </div>
    </form>

    @if($group->exists)
        <form method="POST"
              action="{{ route('admin.shoe-grids.groups.destroy', $group) }}"
              onsubmit="return confirm('Remover o grupo e todas as suas grades?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="text-sm text-red-500 hover:text-red-700 hover:underline">
                Remover grupo
            </button>
        </form>
    @endif
</div>
@endsection


{{-- =========================================================
     resources/views/admin/shoe-grids/sizes.blade.php
     ========================================================= --}}
@extends('layouts.admin')

@section('title', 'Tamanhos')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.shoe-grids.index') }}"
               class="text-gray-400 hover:text-gray-600">← Grade</a>
            <h1 class="text-xl font-bold text-gray-900">Tamanhos</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulário de novo tamanho --}}
    <form method="POST" action="{{ route('admin.shoe-grids.sizes.store') }}"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        @csrf
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Novo Tamanho</h2>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 items-end">
            <div>
                <label class="label">BRA</label>
                <input type="number" name="bra" step="0.5" min="10" max="60"
                       value="{{ old('bra') }}" class="input" placeholder="ex: 39.5">
            </div>
            <div>
                <label class="label">USW</label>
                <input type="text" name="usw" maxlength="10"
                       value="{{ old('usw') }}" class="input" placeholder="W 8">
            </div>
            <div>
                <label class="label">USM</label>
                <input type="text" name="usm" maxlength="10"
                       value="{{ old('usm') }}" class="input" placeholder="6.5">
            </div>
            <div>
                <label class="label">Ordem</label>
                <input type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $sizes->count() + 1) }}" class="input">
            </div>
            <div>
                <button type="submit" class="btn btn-primary w-full">Adicionar</button>
            </div>
        </div>
    </form>

    {{-- Lista de tamanhos --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">BRA</th>
                    <th class="px-4 py-3 text-left">USW</th>
                    <th class="px-4 py-3 text-left">USM</th>
                    <th class="px-4 py-3 text-center">Ordem</th>
                    <th class="px-4 py-3 text-center">Ativo</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sizes as $size)
                <tr>
                    <form method="POST"
                          action="{{ route('admin.shoe-grids.sizes.update', $size) }}">
                        @csrf @method('PUT')
                        <td class="px-4 py-2">
                            <input type="number" name="bra" step="0.5"
                                   value="{{ $size->bra }}" class="input-inline w-20">
                        </td>
                        <td class="px-4 py-2">
                            <input type="text" name="usw" maxlength="10"
                                   value="{{ $size->usw }}" class="input-inline w-20">
                        </td>
                        <td class="px-4 py-2">
                            <input type="text" name="usm" maxlength="10"
                                   value="{{ $size->usm }}" class="input-inline w-16">
                        </td>
                        <td class="px-4 py-2 text-center">
                            <input type="number" name="sort_order" min="0"
                                   value="{{ $size->sort_order }}" class="input-inline w-16 text-center">
                        </td>
                        <td class="px-4 py-2 text-center">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" name="active" value="1"
                                   {{ $size->active ? 'checked' : '' }} class="rounded">
                        </td>
                        <td class="px-4 py-2 text-right whitespace-nowrap">
                            <button type="submit"
                                    class="text-blue-500 hover:text-blue-700 text-xs mr-3">
                                salvar
                            </button>
                    </form>
                            <form method="POST"
                                  action="{{ route('admin.shoe-grids.sizes.destroy', $size) }}"
                                  class="inline"
                                  onsubmit="return confirm('Remover tamanho {{ $size->bra }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-red-400 hover:text-red-600 text-xs">
                                    remover
                                </button>
                            </form>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $sizes->links() }}
    </div>
</div>
@endsection
