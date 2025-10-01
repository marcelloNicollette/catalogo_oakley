@extends('layouts.admin-layout')

@push('css')
    <style>
        /* Customizações específicas */
    </style>
@endpush

@section('page_title', 'Produtos')

@section('content-wrapper')
    <div class="flex items-center space-x-2 mb-6">
        <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Novo Produto') }}
        </h2>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome do Produto</label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição do
                            Produto</label>
                        <textarea name="description" id="description"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="code" class="block text-sm font-medium text-gray-700">Código do Produto</label>
                        <input type="text" name="code" id="code"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('code') }}" required>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="sku" class="block text-sm font-medium text-gray-700">SKU do Produto</label>
                        <input type="text" name="sku" id="sku"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('sku') }}">
                        @error('sku')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="">
                        <label for="price" class="block text-sm font-medium text-gray-700">Preço do Produto</label>
                        <input type="number" step="0.01" name="price" id="price"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            value="{{ old('price') }}" required>
                        @error('price')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subcategoria do
                            Produto</label>
                        <select name="subcategory_id" id="subcategory_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            disabled>
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
                        <div class="bg-gray-50 " x-data="{
                            campos: [{ color_name: '', color_description: '', color_code: '', color_collection_id: '', color_flag_product_id: '', segmentacoes_cliente: [] }],
                            adicionarCampo() {
                                this.campos.push({ color_name: '', color_description: '', color_code: '', color_collection_id: '', color_flag_product_id: '', segmentacoes_cliente: [] });
                            },
                            removerCampo(index) {
                                this.campos.splice(index, 1);
                            }
                        }">

                            <div class="grid grid-cols-1">
                                <template x-for="(campo, index) in campos" :key="index">
                                    <div class="bg-gray-100 p-4 border border-gray-200 rounded-lg mb-4">
                                        <!-- Grid para os campos principais -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
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
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    required>
                                                    <option value="">Selecione a Flag</option>
                                                    @foreach ($flags as $flag)
                                                        <option value="{{ $flag->id }}"
                                                            {{ old('flag_product_id') == $flag->id ? 'selected' : '' }}>
                                                            {{ $flag->flag_title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Seção de Segmentação Cliente -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Segmentação
                                                Cliente</label>
                                            @if ($segmentacoesCliente->count() > 0)
                                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                                                    @foreach ($segmentacoesCliente as $segmentacao)
                                                        <label class="flex items-center space-x-2 text-sm">
                                                            <input type="checkbox"
                                                                :name="`color_segmentacoes_cliente[${index}][]`"
                                                                value="{{ $segmentacao->id }}"
                                                                @change="
                                                                    if ($event.target.checked) {
                                                                        if (!campo.segmentacoes_cliente.includes({{ $segmentacao->id }})) {
                                                                            campo.segmentacoes_cliente.push({{ $segmentacao->id }});
                                                                        }
                                                                    } else {
                                                                        campo.segmentacoes_cliente = campo.segmentacoes_cliente.filter(id => id !== {{ $segmentacao->id }});
                                                                    }
                                                                "
                                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                            <span>{{ $segmentacao->nome }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-500">Nenhuma segmentação de cliente disponível.
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Botões de ação -->
                                        <div class="flex items-center justify-start space-x-2">
                                            <button type="button" @click="adicionarCampo()"
                                                class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">+
                                                Adicionar Cor</button>

                                            <template x-if="campos.length > 1">
                                                <button type="button" @click="removerCampo(index)"
                                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">−
                                                    Remover</button>
                                            </template>
                                        </div>
                                    </div>

                                </template>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="mb-4">
                    <fieldset class="border border-1  bg-gray-100">
                        <legend class="block text-sm font-medium text-gray-700">Características do produto
                        </legend>
                        <div x-data="{
                            campos: [{ caracteristica_title: '', caracteristica_description: '', caracteristica_destaque: '' }],
                            adicionarCampo() {
                                this.campos.push({ caracteristica_title: '', caracteristica_description: '', caracteristica_destaque: '' });
                            },
                            removerCampo(index) {
                                this.campos.splice(index, 1);
                            }
                        }">

                            <div class="grid grid-cols-1 md:grid-cols-1">
                                <template x-for="(campo, index) in campos" :key="index">
                                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_0.3fr_auto] gap-2  bg-gray-100 p-4">
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


                                            <!-- Campo oculto que é sincronizado com o estado do checkbox -->
                                            <input type="hidden" :name="`caracteristica_destaque[${index}]`"
                                                :value="campo.caracteristica_destaque ? 1 : 0">

                                            <!-- Checkbox sem name, usado apenas para interação -->
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
                        <div x-data="{
                            campos: [{ size_id: '', stock: '' }],
                            adicionarCampo() {
                                this.campos.push({ size_id: '', stock: '' });
                            },
                            removerCampo(index) {
                                this.campos.splice(index, 1);
                            }
                        }">
                            <div class="grid grid-cols-1 md:grid-cols-1">
                                <template x-for="(campo, index) in campos" :key="index">
                                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-2  bg-gray-100 px-4 py-2">
                                        <!-- Coluna 1: Tamanho -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Tamanho</label>
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
                        <div x-data="{
                            campos: [{ numeracao_id: '', stock: '' }],
                            adicionarCampo() {
                                this.campos.push({ numeracao_id: '', stock: '' });
                            },
                            removerCampo(index) {
                                this.campos.splice(index, 1);
                            }
                        }">
                            <div class="grid grid-cols-1 md:grid-cols-1">
                                <template x-for="(campo, index) in campos" :key="index">
                                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-2 bg-gray-100 px-4 py-2">
                                        <!-- Coluna 1: Numeração -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Numeração</label>
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

                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <label for="technologies" class="block text-sm font-medium text-gray-700">Tecnologias</label>
                    </div>
                    <select name="technologies[]" id="technologies" multiple
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @foreach ($technologies as $technology)
                            <optgroup label="{{ $technology->name }}">
                                @foreach ($technology->items as $technologyItem)
                                    <option value="{{ $technologyItem->id }}">{{ $technologyItem->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('technologies')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <fieldset class="border border-1 bg-gray-100">
                        <legend class="block text-sm font-medium text-gray-700">Arquivos ou Links
                        </legend>
                        <div x-data="{
                            campos: [{ link_title: '', link_url: '' }],
                            adicionarCampo() {
                                this.campos.push({ link_title: '', link_url: '' });
                            },
                            removerCampo(index) {
                                this.campos.splice(index, 1);
                            }
                        }">

                            <div class="grid grid-cols-1 md:grid-cols-1">
                                <template x-for="(campo, index) in campos" :key="index">
                                    <div class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-2 bg-gray-100 px-4 py-2">
                                        <!-- Coluna 1: Título -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Título</label>
                                            <input type="text" :name="`link_title[]`" x-model="campo.link_title"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                name="link_title[]" required>

                                        </div>

                                        <!-- Coluna 2: URL -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">URL</label>
                                            <input type="text" :name="`link_url[]`" x-model="campo.link_url"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                name="link_url[]" required placeholder="http://">
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
                                <option value="0" {{ old('flag_calendario') == '0' ? 'selected' : '' }}>Não</option>
                                <option value="1" {{ old('flag_calendario') == '1' ? 'selected' : '' }}>Sim</option>
                            </select>
                            @error('flag_calendario')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="data_mkt" class="block text-sm font-medium text-gray-700">Data Marketing</label>
                            <input type="date" name="data_mkt" id="data_mkt"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('data_mkt') }}">
                            @error('data_mkt')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="data_trade" class="block text-sm font-medium text-gray-700">Data Trade</label>
                            <input type="date" name="data_trade" id="data_trade"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('data_trade') }}">
                            @error('data_trade')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="data_cliente" class="block text-sm font-medium text-gray-700">Data Cliente</label>
                            <input type="date" name="data_cliente" id="data_cliente"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('data_cliente') }}">
                            @error('data_cliente')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="data_dtc" class="block text-sm font-medium text-gray-700">Data DTC</label>
                            <input type="date" name="data_dtc" id="data_dtc"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                value="{{ old('data_dtc') }}">
                            @error('data_dtc')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="active" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="active" id="active"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="1" {{ old('active') == '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('active')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('subcategory_id');

            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;

                // Limpar subcategorias
                subcategorySelect.innerHTML = '<option value="">Carregando...</option>';
                subcategorySelect.disabled = true;

                if (categoryId) {
                    // Fazer requisição para buscar subcategorias
                    fetch(`{{ url('/admin/products/subcategories') }}/${categoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            subcategorySelect.innerHTML =
                                '<option value="">Selecione uma subcategoria</option>';

                            if (data.length > 0) {
                                data.forEach(subcategory => {
                                    const option = document.createElement('option');
                                    option.value = subcategory.id;
                                    option.textContent = subcategory.faixa;

                                    // Manter seleção se houver old value
                                    if ('{{ old('subcategory_id') }}' == subcategory.id) {
                                        option.selected = true;
                                    }

                                    subcategorySelect.appendChild(option);
                                });
                                subcategorySelect.disabled = false;
                            } else {
                                subcategorySelect.innerHTML =
                                    '<option value="">Nenhuma subcategoria encontrada</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao carregar subcategorias:', error);
                            subcategorySelect.innerHTML =
                                '<option value="">Erro ao carregar subcategorias</option>';
                        });
                } else {
                    subcategorySelect.innerHTML =
                        '<option value="">Selecione uma categoria primeiro</option>';
                    subcategorySelect.disabled = true;
                }
            });

            // Carregar subcategorias se já houver uma categoria selecionada (para casos de erro de validação)
            if (categorySelect.value) {
                categorySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush
