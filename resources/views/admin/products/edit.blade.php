@extends('layouts.admin-layout')

@push('css')
    <style>
        /* Customizações específicas */
    </style>
@endpush

@section('page_title', 'Editar Produto')

@section('content-wrapper')
    <div class="flex items-center space-x-2 mb-6">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Editar Produto</h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div class="">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome do Produto</label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição do
                            Produto</label>
                        <textarea name="description" id="description"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="code" class="block text-sm font-medium text-gray-700">Código do Produto</label>
                        <input type="text" name="code" id="code"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('code', $product->code) }}" required>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="sku" class="block text-sm font-medium text-gray-700">SKU do Produto</label>
                        <input type="text" name="sku" id="sku"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('sku', $product->sku) }}">
                        @error('sku')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="price" class="block text-sm font-medium text-gray-700">Preço do Produto</label>

                        <input type="number" step="0.01" name="price" id="price"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('price', str_replace(',', '.', $product->price)) }}" required>
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="order" class="block text-sm font-medium text-gray-700">Ordem de Exibição</label>
                        <input type="number" name="order" id="order" min="1"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('order', $product->order) }}" placeholder="Deixe em branco para manter atual">
                        @error('order')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Se vazio, mantém a ordem atual do produto.</p>
                    </div>

                    <div class="">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Categoria do
                            Produto</label>
                        <select name="category_id" id="category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="">Selecione uma categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subcategoria do
                            Produto</label>
                        <select name="subcategory_id" id="subcategory_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Selecione uma categoria primeiro</option>
                        </select>
                        @error('subcategory_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <fieldset class="border border-1 bg-gray-100">
                        <legend class="block text-sm font-medium text-gray-700">Cores disponíveis
                        </legend>
                        <div x-data="cores()">

                            <div class="grid grid-cols-1 ">
                                <template x-for="(campo, index) in campos" :key="index">
                                    <div class="bg-gray-100 p-4 border border-gray-200 rounded-lg">
                                        <!-- Grid para os campos principais -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-4">
                                            <!-- Coluna 1: Título -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Cor (Title)</label>
                                                <input type="text" :name="`color_name[]`" x-model="campo.color_name"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                    name="color_name[]">
                                            </div>
                                            <!-- Coluna 2: Descrição -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                                                <input :name="`color_description[]`" x-model="campo.color_description"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                    rows="2" name="color_description[]"></input>
                                            </div>
                                            <!-- Coluna 3: Código Cor -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Color Code</label>
                                                <input :name="`color_code[]`" x-model="campo.color_code"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                    name="color_code[]"></input>
                                            </div>
                                            <!-- Coluna 4: Coleção -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Coleção</label>
                                                <select :name="`color_collection_id[]`" x-model="campo.color_collection_id"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    required>
                                                    <option value="">Selecione uma coleção</option>
                                                    @foreach ($collections as $collection)
                                                        <option value="{{ $collection->id }}"
                                                            {{ old('collection_id') == $collection->id ? 'selected' : '' }}>
                                                            {{ $collection->codigo_colecao . ' - ' . $collection->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Coluna 5: Flag -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Flag</label>
                                                <select :name="`color_flag_product_id[]`"
                                                    x-model="campo.color_flag_product_id"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">Selecione a Flag</option>
                                                    @foreach ($flags as $flag)
                                                        <option value="{{ $flag->id }}"
                                                            {{ old('flag_product_id') == $flag->id ? 'selected' : '' }}>
                                                            {{ $flag->flag_title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Coluna 6: Numeração (por cor) -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Numeração</label>
                                                <select :name="`color_numeracao_id[]`" x-model="campo.color_numeracao_id"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                    <option value="">Selecione a Numeração</option>
                                                    @foreach ($numeracoes as $numeracao)
                                                        <option value="{{ $numeracao->id }}"
                                                            {{ old('color_numeracao_id') == $numeracao->id ? 'selected' : '' }}>
                                                            {{ $numeracao->numero }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Coluna 6: Segmentação Cliente -->
                                        <div class="md:col-span-5">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Segmentações de
                                                Cliente</label>
                                            @if (isset($segmentacoesCliente) && $segmentacoesCliente->count() > 0)
                                                <div
                                                    class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 p-3 border border-gray-200 rounded-md bg-gray-50 max-h-32 overflow-y-auto">
                                                    @foreach ($segmentacoesCliente as $segmentacaoCliente)
                                                        <label class="flex items-center text-xs">
                                                            <input type="checkbox"
                                                                :name="`color_segmentacoes_cliente[${index}][]`"
                                                                :value="{{ $segmentacaoCliente->id }}"
                                                                :checked="campo.segmentacoes_cliente && campo.segmentacoes_cliente
                                                                    .includes({{ $segmentacaoCliente->id }})"
                                                                @change="
                                                       if ($event.target.checked) {
                                                           if (!campo.segmentacoes_cliente) campo.segmentacoes_cliente = [];
                                                           if (!campo.segmentacoes_cliente.includes({{ $segmentacaoCliente->id }})) {
                                                               campo.segmentacoes_cliente.push({{ $segmentacaoCliente->id }});
                                                           }
                                                       } else {
                                                           if (campo.segmentacoes_cliente) {
                                                               campo.segmentacoes_cliente = campo.segmentacoes_cliente.filter(id => id !== {{ $segmentacaoCliente->id }});
                                                           }
                                                       }
                                                   "
                                                                class="h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-1">
                                                            <span
                                                                class="text-gray-700">{{ $segmentacaoCliente->nome }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500">Selecione as segmentações de cliente
                                                    para esta cor</p>
                                            @else
                                                <div class="p-3 border border-gray-200 rounded-md bg-gray-50 text-center">
                                                    <p class="text-xs text-gray-500 mb-1">Nenhuma segmentação de cliente
                                                        disponível.</p>
                                                    <a href="{{ route('admin.segmentacao-cliente.create') }}"
                                                        class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                                        Criar nova segmentação de cliente
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Coluna 7: CTAS -->
                                        <div class="mt-6 flex items-start justify-start w-auto">
                                            <button type="button" @click="adicionarCampo()"
                                                class="px-3 py-1 h-8 mr-2 bg-green-500 text-white rounded hover:bg-green-600">+</button>

                                            <template x-if="campos.length > 1">
                                                <button type="button" @click="removerCampo(index)"
                                                    class="px-3 py-1 h-8 bg-red-500 text-white rounded hover:bg-red-600">−</button>
                                            </template>
                                        </div>
                                    </div>

                                </template>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="mb-4">
                    <fieldset class="border border-1 bg-gray-100">
                        <legend class="block text-sm font-medium text-gray-700">Características do produto
                        </legend>
                        <div x-data="caracteristicas()">
                            <div class="grid grid-cols-1 md:grid-cols-1" id="caracteristicas-container">
                                <template x-for="(campo, index) in campos" :key="campo.id + '-' + forceUpdate">
                                    <div class="grid grid-cols-1 md:grid-cols-[0.1fr_1fr_1fr_0.3fr_auto] gap-2 bg-gray-100 p-4 cursor-move hover:bg-gray-50 border border-gray-200 rounded-lg relative group transition-all duration-200"
                                        :id="'caracteristica-' + campo.id">
                                        <!-- Ícone de arrastar -->
                                        <div alt="Arrastar" class="flex items-center justify-center px-2">
                                            <div class="" title="Arraste para reordenar">
                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <!-- Linha vertical -->
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16" />
                                                    <!-- Seta para cima -->
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 8l4-4 4 4" />
                                                    <!-- Seta para baixo -->
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 16l-4 4-4-4" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- Coluna 1: Título -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Título</label>
                                            <input type="text" :name="`caracteristica_title[]`"
                                                x-model="campo.caracteristica_title"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                name="caracteristica_title[]">
                                        </div>

                                        <!-- Coluna 2: Descrição -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Descrição</label>
                                            <textarea :name="`caracteristica_description[]`" x-model="campo.caracteristica_description"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                rows="2" name="caracteristica_description[]"></textarea>
                                        </div>

                                        <div class="text-center">
                                            <label class="mt-1 block text-sm font-medium text-gray-700"
                                                for="destaque">Destaque </label>
                                            <input type="hidden" :name="`caracteristica_destaque[${index}]`"
                                                :value="campo.caracteristica_destaque ? 1 : 0">
                                            <input type="checkbox" :id="`caracteristica_destaque_${index}`"
                                                :checked="campo.caracteristica_destaque == 1"
                                                @change="campo.caracteristica_destaque = $event.target.checked ? 1 : 0">
                                        </div>

                                        <!-- Coluna 3: Botões -->
                                        <div class="mt-6 flex items-start justify-start w-auto">
                                            <button type="button" @click="adicionarCampo()"
                                                class="px-3 py-1 h-8 mr-2 bg-green-500 text-white rounded hover:bg-green-600">+</button>
                                            <template x-if="campos.length > 1">
                                                <button type="button" @click="removerCampo(index)"
                                                    class="px-3 py-1 h-8 bg-red-500 text-white rounded hover:bg-red-600">−</button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="mb-4">
                    <fieldset class="border border-1 bg-gray-100">
                        <legend class="block text-sm font-medium text-gray-700">Tamanhos disponíveis</legend>
                        <div x-data="sizes()" x-init="init">
                            <div class="grid grid-cols-1 md:grid-cols-1">
                                <template x-for="(campo, index) in campos" :key="index">
                                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-2 bg-gray-100 px-4 py-2">
                                        <!-- Coluna 1: Tamanho -->
                                        <div>
                                            <label for="size_ids"
                                                class="block text-sm font-medium text-gray-700">Tamanho</label>
                                            <select :name="`size_ids[]`" x-model="campo.size_id"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Selecione o tamanho</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Coluna 2: Estoque -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Estoque</label>
                                            <input type="number" :name="`size_stocks[]`" x-model="campo.stock"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                min="0" placeholder="0">
                                        </div>

                                        <!-- Coluna 3: Botões -->
                                        <div class="mt-6 flex items-start justify-start w-auto">
                                            <button type="button" @click="adicionarCampo()"
                                                class="px-3 py-1 h-8 mr-2 bg-green-500 text-white rounded hover:bg-green-600">+</button>

                                            <template x-if="campos.length > 1">
                                                <button type="button" @click="removerCampo(index)"
                                                    class="px-3 py-1 h-8 bg-red-500 text-white rounded hover:bg-red-600">−</button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="mb-4">
                    <fieldset class="border border-1 bg-gray-100">
                        <legend class="block text-sm font-medium text-gray-700">Numerações disponíveis</legend>
                        <div x-data="numeracoes()" x-init="init">
                            <div class="grid grid-cols-1 md:grid-cols-1">
                                <template x-for="(campo, index) in campos" :key="index">
                                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-2 bg-gray-100 px-4 py-2">
                                        <!-- Coluna 1: Numeração -->
                                        <div>
                                            <label for="numeracao_ids"
                                                class="block text-sm font-medium text-gray-700">Numeração</label>
                                            <select :name="`numeracao_ids[]`" x-model="campo.numeracao_id"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Selecione a numeração</option>
                                                @foreach ($numeracoes as $numeracao)
                                                    <option value="{{ $numeracao->id }}">{{ $numeracao->numero }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Coluna 2: Estoque -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Estoque</label>
                                            <input type="number" :name="`numeracao_stocks[]`" x-model="campo.stock"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                min="0" placeholder="0">
                                        </div>

                                        <!-- Coluna 3: Botões -->
                                        <div class="mt-6 flex items-start justify-start w-auto">
                                            <button type="button" @click="adicionarCampo()"
                                                class="px-3 py-1 h-8 mr-2 bg-green-500 text-white rounded hover:bg-green-600">+</button>

                                            <template x-if="campos.length > 1">
                                                <button type="button" @click="removerCampo(index)"
                                                    class="px-3 py-1 h-8 bg-red-500 text-white rounded hover:bg-red-600">−</button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </fieldset>
                </div>

                {{-- Tecnologias --}}
                <div class="mb-4">
                    <fieldset class="border-2 border-indigo-200 rounded-md bg-gray-100">
                        <legend class="px-2 text-sm font-medium text-gray-700">Tecnologias</legend>
                        <div class="px-3 py-2">
                            @if (isset($technologies) && $technologies->count() > 0)
                                @foreach ($technologies as $technology)
                                    <div class="mb-3">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">{{ $technology->name }}
                                        </h4>
                                        <div
                                            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 p-3 border border-indigo-200 rounded-md bg-white max-h-32 overflow-y-auto">
                                            @foreach ($technology->items as $item)
                                                <label class="flex items-center text-xs">
                                                    <input type="checkbox" name="technologies[]"
                                                        value="{{ $item->id }}"
                                                        {{ collect(json_decode($product->technologies, true))->contains($item->id) ? 'checked' : '' }}
                                                        class="h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-1">
                                                    <span class="text-gray-700">{{ $item->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                <p class="mt-1 text-xs text-indigo-700">Selecione as tecnologias para este produto</p>
                            @else
                                <div class="p-3 border border-indigo-200 rounded-md bg-white text-center">
                                    <p class="text-xs text-gray-500 mb-1">Nenhuma tecnologia disponível.</p>
                                    <a href="{{ route('admin.technology-categories.index') }}"
                                        class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                        Gerenciar tecnologias
                                    </a>
                                </div>
                            @endif
                        </div>
                    </fieldset>
                </div>

                <div class="mb-4">
                    <fieldset class="border border-1 bg-gray-100">
                        <legend class="block text-sm font-medium text-gray-700">Arquivos ou Links
                        </legend>
                        <div x-data="links()" x-init="init">

                            <div class="grid grid-cols-1 md:grid-cols-1">
                                <template x-for="(campo, index) in campos" :key="index">
                                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-2 bg-gray-100 px-4 py-2">
                                        <!-- Coluna 1: Título -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Título</label>
                                            <input type="text" :name="`link_title[]`" x-model="campo.link_title"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                name="link_title[]">

                                        </div>

                                        <!-- Coluna 2: URL -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">URL</label>
                                            <input type="text" :name="`link_url[]`" x-model="campo.link_url"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                name="link_url[]" placeholder="http://">
                                        </div>

                                        <!-- Coluna 3: Botões -->
                                        <div class="mt-6 flex items-start justify-start w-auto">
                                            <button type="button" @click="adicionarCampo()"
                                                class="px-3 py-1 h-8 mr-2 bg-green-500 text-white rounded hover:bg-green-600">+</button>

                                            <template x-if="campos.length > 1">
                                                <button type="button" @click="removerCampo(index)"
                                                    class="px-3 py-1 h-8 bg-red-500 text-white rounded hover:bg-red-600">−</button>
                                            </template>
                                        </div>
                                    </div>

                                </template>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <!-- Campos do Calendário -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informações do Calendário</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <label for="flag_calendario" class="block text-sm font-medium text-gray-700">Flag
                                Calendário</label>
                            <select name="flag_calendario" id="flag_calendario"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="0"
                                    {{ old('flag_calendario', $product->flag_calendario) == '0' ? 'selected' : '' }}>Não
                                </option>
                                <option value="1"
                                    {{ old('flag_calendario', $product->flag_calendario) == '1' ? 'selected' : '' }}>Sim
                                </option>
                            </select>
                            @error('flag_calendario')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="data_mkt" class="block text-sm font-medium text-gray-700">Data Marketing</label>
                            <input type="date" name="data_mkt" id="data_mkt"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('data_mkt', $product->data_mkt ? $product->data_mkt->format('Y-m-d') : '') }}">
                            @error('data_mkt')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="data_trade" class="block text-sm font-medium text-gray-700">Data Trade</label>
                            <input type="date" name="data_trade" id="data_trade"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('data_trade', $product->data_trade ? $product->data_trade->format('Y-m-d') : '') }}">
                            @error('data_trade')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="data_cliente" class="block text-sm font-medium text-gray-700">Data Cliente</label>
                            <input type="date" name="data_cliente" id="data_cliente"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('data_cliente', $product->data_cliente ? $product->data_cliente->format('Y-m-d') : '') }}">
                            @error('data_cliente')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="data_dtc" class="block text-sm font-medium text-gray-700">Data DTC</label>
                            <input type="date" name="data_dtc" id="data_dtc"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('data_dtc', $product->data_dtc ? $product->data_dtc->format('Y-m-d') : '') }}">
                            @error('data_dtc')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="grid grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="active" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="active" id="active"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="1" {{ old('active', $product->active) == '1' ? 'selected' : '' }}>Ativo
                            </option>
                            <option value="0" {{ old('active', $product->active) == '0' ? 'selected' : '' }}>Inativo
                            </option>
                        </select>
                    </div>
                </div>


                <div class="flex justify-end">
                    <a href="{{ route('admin.products.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Cancelar</a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@php
    $product['colors'] = $colors;
    $product['caracteristicas'] = $caracteristicas;
    $product['links'] = $links;
@endphp

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cores', () => ({
                campos: {!! json_encode(
                    $product->colors->map(function ($c) {
                        return [
                            'color_name' => $c->color_name,
                            'color_description' => $c->color_description,
                            'color_code' => $c->color_code,
                            'color_collection_id' => $c->collection_id,
                            'color_flag_product_id' => $c->flag_product_id,
                            'color_numeracao_id' => $c->numeracao_id,
                            'segmentacoes_cliente' => $c->segmentacoesCliente->pluck('id')->toArray(),
                        ];
                    }),
                ) !!} || [],
                init() {
                    if (!this.campos || this.campos.length === 0) {
                        this.campos = [{
                            color_name: '',
                            color_description: '',
                            color_code: '',
                            color_collection_id: '',
                            color_flag_product_id: '',
                            color_numeracao_id: '',
                            segmentacoes_cliente: []
                        }];
                    }
                },
                adicionarCampo() {
                    this.campos.push({
                        color_name: '',
                        color_description: '',
                        color_code: '',
                        color_collection_id: '',
                        color_flag_product_id: '',
                        color_numeracao_id: '',
                        segmentacoes_cliente: []
                    });
                },
                removerCampo(index) {
                    this.campos.splice(index, 1);
                }
            }));

            Alpine.data('caracteristicas', () => ({
                campos: {!! json_encode(
                    $product->caracteristicas->map(function ($c, $index) {
                        return (object) [
                            'id' => uniqid('carac_'),
                            'caracteristica_title' => $c->title,
                            'caracteristica_description' => $c->description,
                            'caracteristica_destaque' => $c->destaque,
                        ];
                    }),
                ) !!} || [],
                forceUpdate: Date.now(), // chave para forçar atualização
                init() {
                    if (this.campos.length === 0) {
                        this.adicionarCampo();
                    }

                    new Sortable(document.getElementById('caracteristicas-container'), {
                        animation: 150,
                        handle: '.cursor-move',
                        onEnd: (evt) => {
                            const oldIndex = evt.oldIndex;
                            const newIndex = evt.newIndex;

                            if (oldIndex === newIndex) return;

                            const movedItem = this.campos.splice(oldIndex, 1)[0];
                            this.campos.splice(newIndex, 0, movedItem);
                            // Força o Alpine a re-renderizar
                            this.forceUpdate = Date.now();
                        }
                    });
                },
                adicionarCampo() {
                    this.campos.push({
                        id: 'carac_' + Date.now(),
                        caracteristica_title: '',
                        caracteristica_description: '',
                        caracteristica_destaque: 0
                    });
                },
                removerCampo(index) {
                    this.campos.splice(index, 1);
                }
            }));

            Alpine.data('links', () => ({
                campos: [],
                init() {
                    const links = {!! json_encode(
                        $product->links->map(function ($c) {
                            return [
                                'link_title' => $c->link_title,
                                'link_url' => $c->link_url,
                            ];
                        }),
                    ) !!};
                    this.campos = links && links.length ? links : [{
                        link_title: '',
                        link_url: ''
                    }];
                },
                adicionarCampo() {
                    this.campos.push({
                        link_title: '',
                        link_url: ''
                    });
                },
                removerCampo(index) {
                    this.campos.splice(index, 1);
                }
            }));

            Alpine.data('sizes', () => ({
                campos: [],
                init() {
                    const sizes = {!! json_encode(
                        $product->sizes->map(function ($s) {
                            return [
                                'size_id' => $s->id,
                                'stock' => $s->pivot->stock,
                            ];
                        }),
                    ) !!};
                    this.campos = sizes && sizes.length ? sizes : [{
                        size_id: '',
                        stock: ''
                    }];
                },
                adicionarCampo() {
                    this.campos.push({
                        size_id: '',
                        stock: ''
                    });
                },
                removerCampo(index) {
                    this.campos.splice(index, 1);
                }
            }));

            Alpine.data('numeracoes', () => ({
                campos: [],
                init() {
                    const numeracoes = {!! json_encode(
                        $product->numeracoes->map(function ($n) {
                            return [
                                'numeracao_id' => $n->id,
                                'stock' => $n->pivot->stock,
                            ];
                        }),
                    ) !!};
                    this.campos = numeracoes && numeracoes.length ? numeracoes : [{
                        numeracao_id: '',
                        stock: ''
                    }];
                },
                adicionarCampo() {
                    this.campos.push({
                        numeracao_id: '',
                        stock: ''
                    });
                },
                removerCampo(index) {
                    this.campos.splice(index, 1);
                }
            }));
        });

        // Script para carregar subcategorias dinamicamente
        document.getElementById('category_id').addEventListener('change', function() {
            const categoryId = this.value;
            const subcategorySelect = document.getElementById('subcategory_id');

            // Limpar opções existentes
            subcategorySelect.innerHTML = '<option value="">Carregando...</option>';
            subcategorySelect.disabled = true;

            if (categoryId) {
                // Fazer requisição para buscar subcategorias
                fetch(`/admin/products/subcategories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        subcategorySelect.innerHTML = '<option value="">Selecione uma subcategoria</option>';

                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.faixa;

                            // Verificar se esta subcategoria deve estar selecionada
                            const oldSubcategoryId =
                                '{{ old('subcategory_id', $product->subcategory_id ?? '') }}';
                            if (subcategory.id == oldSubcategoryId) {
                                option.selected = true;
                            }

                            subcategorySelect.appendChild(option);
                        });

                        subcategorySelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Erro ao carregar subcategorias:', error);
                        subcategorySelect.innerHTML =
                            '<option value="">Erro ao carregar subcategorias</option>';
                        subcategorySelect.disabled = false;
                    });
            } else {
                subcategorySelect.innerHTML = '<option value="">Selecione uma categoria primeiro</option>';
                subcategorySelect.disabled = true;
            }
        });

        // Carregar subcategorias na inicialização se já houver uma categoria selecionada
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            if (categorySelect.value) {
                categorySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush
