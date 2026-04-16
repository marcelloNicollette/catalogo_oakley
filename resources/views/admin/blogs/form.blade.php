@extends('layouts.admin-layout')

@section('page_title', isset($blog) ? 'Editar Blog' : 'Novo Blog')

@section('content-wrapper')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
        {{ isset($blog) ? 'Editar Blog' : 'Novo Blog' }}
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST"
                        action="{{ isset($blog) ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($blog))
                            @method('PUT')
                        @endif

                        <!-- Titulo -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $blog->title ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subtitulo -->
                        <div class="mb-4">
                            <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtítulo</label>
                            <input type="text" name="subtitle" id="subtitle"
                                value="{{ old('subtitle', $blog->subtitle ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('subtitle')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Thumb Image -->
                        <div class="mb-4">
                            <label for="thumb_image" class="block text-sm font-medium text-gray-700">Imagem Thumb</label>
                            @if (isset($blog) && $blog->thumb_image)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $blog->thumb_image) }}" alt="Thumb Atual"
                                        class="h-32 w-auto object-cover rounded">
                                </div>
                            @endif
                            <input type="file" name="thumb_image" id="thumb_image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('thumb_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cover Image -->
                        <div class="mb-4">
                            <label for="cover_image" class="block text-sm font-medium text-gray-700">Imagem de Topo</label>
                            @if (isset($blog) && $blog->cover_image)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $blog->cover_image) }}" alt="Capa Atual"
                                        class="h-48 w-auto object-cover rounded">
                                </div>
                            @endif
                            <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('cover_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descrição / Olho -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição /
                                Olho</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $blog->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Conteudo (Editor Texto) -->
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Conteúdo</label>
                            <textarea name="content" id="content" rows="100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('content', $blog->content ?? '') }}</textarea>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Autor -->
                        <div class="mb-4">
                            <label for="author" class="block text-sm font-medium text-gray-700">Autor</label>
                            <input type="text" name="author" id="author"
                                value="{{ old('author', $blog->author ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('author')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <!-- Data Material -->
                            <div>
                                <label for="material_date" class="block text-sm font-medium text-gray-700">Data
                                    Material</label>
                                <input type="date" name="material_date" id="material_date"
                                    value="{{ old('material_date', isset($blog) && $blog->material_date ? $blog->material_date->format('Y-m-d') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('material_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Data Inserção -->
                            <div>
                                <label for="publish_at" class="block text-sm font-medium text-gray-700">Data
                                    Inserção</label>
                                <input type="datetime-local" name="publish_at" id="publish_at"
                                    value="{{ old('publish_at', isset($blog) && $blog->publish_at ? $blog->publish_at->format('Y-m-d\TH:i') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('publish_at')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Data Retirada -->
                            <div>
                                <label for="unpublish_at" class="block text-sm font-medium text-gray-700">Data
                                    Retirada</label>
                                <input type="datetime-local" name="unpublish_at" id="unpublish_at"
                                    value="{{ old('unpublish_at', isset($blog) && $blog->unpublish_at ? $blog->unpublish_at->format('Y-m-d\TH:i') : '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('unpublish_at')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Níveis de Acesso -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Níveis de Acesso</label>
                            <div class="space-y-2">
                                @php
                                    $accessLevels = ['representante', 'interno', 'fornecedor', 'convidado', 'cliente'];
                                    $currentLevels = old(
                                        'access_levels',
                                        isset($blog) && $blog->access_levels ? $blog->access_levels : [],
                                    );
                                @endphp
                                @foreach ($accessLevels as $level)
                                    <label class="inline-flex items-center mr-4">
                                        <input type="checkbox" name="access_levels[]" value="{{ $level }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            @checked(in_array($level, $currentLevels))>
                                        <span class="ml-2 text-sm text-gray-600">{{ ucfirst($level) }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('access_levels')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status & Active -->
                        <div class="flex space-x-6 mb-4">
                            <label for="status" class="inline-flex items-center">
                                <input type="checkbox" name="status" id="status" value="1"
                                    {{ old('status', $blog->status ?? true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Status (Publicado)</span>
                            </label>

                            <label for="active" class="inline-flex items-center">
                                <input type="checkbox" name="active" id="active" value="1"
                                    {{ old('active', $blog->active ?? true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Ativo</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.blogs.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($blog) ? 'Atualizar' : 'Criar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.6/tinymce.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                tinymce.init({
                    selector: '#content',
                    menubar: true,
                    plugins: 'lists link image table code autoresize',
                    toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | removeformat | code',
                    toolbar_mode: 'sliding',
                    paste_data_images: true,
                    automatic_uploads: true,
                    images_upload_handler: (blobInfo, progress) => new Promise(resolve => {
                        resolve(`data:${blobInfo.blob().type};base64,${blobInfo.base64()}`);
                    }),
                    content_style: 'body { font-family: Helvetica, Arial, sans-serif; font-size: 14px; }'
                });

                const form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function() {
                        tinymce.triggerSave();
                    });
                }
            });
        </script>
    @endpush
@endsection
