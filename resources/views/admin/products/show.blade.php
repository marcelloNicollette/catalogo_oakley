@extends('layouts.admin-layout')

@section('content-wrapper')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
            <p class="text-sm text-gray-500">Código: {{ $product->code }}</p>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                <!-- Imagens do Produto -->
                <div class="space-y-4">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg">
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-center object-cover">
                    </div>
                    @if ($product->additional_images)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach (json_decode($product->additional_images) as $image)
                                <div class="aspect-w-1 aspect-h-1 overflow-hidden rounded-lg">
                                    <img src="{{ asset($image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-center object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Informações do Produto -->
                <div class="space-y-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900">Detalhes do Produto</h2>
                        <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Preço</h3>
                            <p class="mt-1 text-lg font-semibold text-gray-900">R$
                                {{ number_format($product->price, 2, ',', '.') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">SKU</h3>
                            <p class="mt-1 text-gray-900">{{ $product->sku }}</p>
                        </div>
                    </div>

                    <!-- Informações do Calendário -->
                    @if ($product->flag_calendario)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datas do Calendário</h3>
                            <div class="grid grid-cols-2 gap-4">
                                @if ($product->data_mkt)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Data MKT</h4>
                                        <p class="mt-1 text-gray-900">{{ $product->data_mkt->format('d/m/Y') }}</p>
                                    </div>
                                @endif
                                @if ($product->data_trade)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Data Trade</h4>
                                        <p class="mt-1 text-gray-900">{{ $product->data_trade->format('d/m/Y') }}</p>
                                    </div>
                                @endif
                                @if ($product->data_cliente)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Data Cliente</h4>
                                        <p class="mt-1 text-gray-900">{{ $product->data_cliente->format('d/m/Y') }}</p>
                                    </div>
                                @endif
                                @if ($product->data_dtc)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Data DTC</h4>
                                        <p class="mt-1 text-gray-900">{{ $product->data_dtc->format('d/m/Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Cores Disponíveis -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Cores Disponíveis</h3>
                        <div class="flex space-x-2">
                            @foreach ($product->colors as $color)
                                <div class="relative group">
                                    <div class="w-10 h-10 rounded-full border-2 border-gray-200"
                                        style="background-color: {{ $color->hex_code }}"></div>
                                    <div
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                        {{ $color->name }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tamanhos Disponíveis -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Tamanhos Disponíveis</h3>
                        <div class="grid grid-cols-6 gap-2">
                            @foreach ($product->sizes as $size)
                                <div class="text-center border rounded-md py-2">
                                    <span class="text-sm font-medium">{{ $size->number }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Especificações Técnicas -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Especificações Técnicas</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Peso</h4>
                                <p class="mt-1">{{ $product->weight }}g</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Altura</h4>
                                <p class="mt-1">{{ $product->height }}cm</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Drop</h4>
                                <p class="mt-1">{{ $product->drop }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Linha</h4>
                                <p class="mt-1">{{ $product->line }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tecnologias -->
                    @if ($product->technologies)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Tecnologias</h3>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach (json_decode($product->technologies) as $tech)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $tech }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Informações Adicionais -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Adicionais</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Data de Lançamento</h4>
                                <p class="mt-1">
                                    {{ $product->launch_date ? $product->launch_date->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Origem</h4>
                                <p class="mt-1">{{ $product->origin }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Gênero</h4>
                                <p class="mt-1">{{ $product->gender }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Atividade Sugerida</h4>
                                <p class="mt-1">{{ $product->suggested_activity }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Superfície</h4>
                                <p class="mt-1">{{ $product->surface }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vídeo do Produto -->
                    @if ($product->video_url)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Vídeo do Produto</h3>
                            <div class="aspect-w-16 aspect-h-9">
                                <iframe src="{{ $product->video_url }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen class="w-full h-full rounded-lg"></iframe>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
