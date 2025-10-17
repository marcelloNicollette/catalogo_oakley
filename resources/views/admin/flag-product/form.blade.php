@extends('layouts.admin-layout')

@section('page_title', isset($flagProduct) ? 'Editar Flag' : 'Nova Flag')

@section('content-wrapper')
    <div class="flex items-center space-x-2 mb-6">
        <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
        </svg>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ isset($flagProduct) ? 'Editar Flag' : 'Nova Flag' }}
        </h2>
    </div>

    <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form
                action="{{ isset($flagProduct) ? route('admin.flag-product.update', $flagProduct) : route('admin.flag-product.store') }}"
                method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @if (isset($flagProduct))
                    @method('PUT')
                @endif

                <div>
                    <label for="flag_title" class="block text-sm font-medium text-gray-700">Título Flag</label>
                    <input type="text" name="flag_title" id="flag_title"
                        value="{{ old('flag_title', $flagProduct->flag_title ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        required>
                    @error('flag_title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>



                <div>
                    <label for="flag_description" class="block text-sm font-medium text-gray-700">Flag Descrição</label>
                    <textarea name="flag_description" id="flag_description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('flag_description', $flagProduct->flag_description ?? '') }}</textarea>
                    @error('flag_description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="flag_bg" class="block text-sm font-medium text-gray-700">Flag Color</label>
                        <input type="color" name="flag_bg" id="flag_bg"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('flag_bg', $flagProduct->flag_bg ?? '') }}">
                        Color: {{ old('flag_bg', $flagProduct->flag_bg ?? '') }}
                        @error('flag_bg')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="flag_color_text_bg" class="block text-sm font-medium text-gray-700">Flag Color
                            Text</label>
                        <input type="color" name="flag_color_text_bg" id="flag_color_text_bg"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('flag_color_text_bg', $flagProduct->flag_color_text_bg ?? '') }}">
                        Color: {{ old('flag_color_text_bg', $flagProduct->flag_color_text_bg ?? '') }}
                        @error('flag_color_text_bg')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700">Ícone da Flag</label>
                        <input type="file" name="icon" id="icon" accept="image/*"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @if (isset($flagProduct) && $flagProduct->icon)
                            <div class="mt-2">
                                <img src="{{ asset($flagProduct->icon) }}" alt="Ícone atual"
                                    class="h-16 w-16 object-cover rounded">
                                <p class="text-sm text-gray-500 mt-1">Ícone atual</p>
                            </div>
                        @endif
                        @error('icon')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alinhamento" class="block text-sm font-medium text-gray-700">Alinhamento</label>
                        <select name="alinhamento" id="alinhamento"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="right"
                                {{ old('alinhamento', $flagProduct->alinhamento ?? 'right') == 'right' ? 'selected' : '' }}>
                                Direita</option>
                            <option value="left"
                                {{ old('alinhamento', $flagProduct->alinhamento ?? 'left') == 'left' ? 'selected' : '' }}>
                                Esquerda</option>
                        </select>
                        @error('alinhamento')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="orderfilterflag" class="block text-sm font-medium text-gray-700">Ordem para
                            filtro</label>
                        <input type="number" name="orderfilterflag" id="orderfilterflag"
                            value="{{ old('orderfilterflag', $flagProduct->orderfilterflag ?? 0) }}" min="0"
                            step="1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                        @error('orderfilterflag')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <input type="checkbox" name="status" id="status" value="1"
                        {{ old('status', $flagProduct->status ?? true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">Ativo</span>

                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.flag-product.index') }}"
                        class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ isset($flagProduct) ? 'Atualizar' : 'Salvar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
