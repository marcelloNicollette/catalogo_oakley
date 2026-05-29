@extends('layouts.admin-layout')

@use('Illuminate\Support\Str')

@push('css')
@endpush

@section('page_title', 'Oakley - Imagem Login')

@section('content-wrapper')
    <div class="container mx-auto p-6 max-w-2xl">
        <h1 class="text-2xl font-semibold mb-4">Cadastrar Imagem de Login</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ms-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.img-login.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block font-medium mb-1">Imagem Desktop</label>
                <input type="file" name="desktop_image" accept="image/*" class="w-full border rounded p-2" required />
            </div>
            <div>
                <label class="block font-medium mb-1">Imagem Mobile</label>
                <input type="file" name="mobile_image" accept="image/*" class="w-full border rounded p-2" required />
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Salvar</button>
                <a href="{{ route('admin.img-login.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
