@extends('layouts.admin-layout')

@use('Illuminate\Support\Str')

@push('css')
@endpush

@section('page_title', 'Oakley - Imagem Login')

@section('content-wrapper')
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Imagem de Login</h1>
            <a href="{{ route('admin.img-login.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Nova Imagem</a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($items as $item)
                <div class="border rounded p-4">
                    <div class="mb-3">
                        <p class="font-medium">Desktop</p>
                        @if ($item->desktop_url)
                            <img src="{{ $item->desktop_url }}" alt="Desktop" class="w-full h-48 object-cover rounded" />
                        @else
                            <p class="text-sm text-gray-500">Sem imagem desktop.</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <p class="font-medium">Mobile</p>
                        @if ($item->mobile_url)
                            <img src="{{ $item->mobile_url }}" alt="Mobile" class="w-full h-48 object-cover rounded" />
                        @else
                            <p class="text-sm text-gray-500">Sem imagem mobile.</p>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.img-login.edit', $item) }}"
                            class="px-3 py-2 bg-gray-200 rounded">Editar</a>
                        <form action="{{ route('admin.img-login.destroy', $item) }}" method="POST"
                            onsubmit="return confirm('Remover este registro?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded">Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>Nenhum registro cadastrado.</p>
            @endforelse
        </div>
    </div>
@endsection
