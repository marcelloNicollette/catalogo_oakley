<x-layout-user title="Under Armour - Produtos">
    <main class="lg:flex flex-1 produtos-page">
        <style>
            .badge-icon-wrapper .badge-tooltip {
                visibility: hidden;
                opacity: 0;
                background-color: #fff;
                /* pode trocar pelo badge_bg */
                color: #000;
                /* ou badge_color */
                text-align: center;

                position: absolute;
                z-index: 10;
                top: 15%;
                left: -240%;
                transform: translateX(-50%);
                transition: opacity 0.3s;
                white-space: nowrap;
            }

            .badge-icon-wrapper:hover .badge-tooltip {
                visibility: visible;
                opacity: 1;
            }

            .height-ultra {
                height: calc(100vh - 156px);
            }


            /* Estilos para dropdown aninhado de subcategorias */
            .category-option {
                position: relative;
            }

            /* Usa seta SVG sempre visível */
            .category-option .arrow-icon {
                display: inline-flex;
                align-items: center;
                color: #FFF;
                opacity: .5;
                transition: transform .3s, opacity .2s, color .2s;
            }

            .category-option.has-subcategories .arrow-icon {
                color: #000;
                opacity: 1;
            }

            .category-option.expanded .arrow-icon {
                transform: rotate(180deg);
            }

            /* Remove pseudo-seta antiga */
            .category-option .option-content::after {
                content: none !important;
            }

            .subcategory-dropdown {
                display: none;
                padding-left: 20px;
                margin-top: 5px;
            }

            .category-option.expanded .subcategory-dropdown {
                display: block;
            }

            .subcategory-option {
                padding: 0 12px;
                cursor: pointer;
                transition: background-color 0.2s;
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 16px;
                color: #5B5B5B;
                font-weight: 400;
                margin: 2px 0;
            }

            .subcategory-option:hover {
                /*background-color: #f5f5f5;*/
            }

            .subcategory-option.selected {
                font-weight: 400;
                color: #5B5B5B;
            }

            .subcategory-option .check-icon {
                width: 14px;
                height: 14px;
                fill: currentColor;
                display: none;
                margin-right: 8px;
            }

            .subcategory-option.selected .check-icon {
                display: inline;
            }

            .subcategory-option .x-icon {
                margin-left: 8px;
                font-size: 18px;
                color: #999;
                display: none;
            }

            .subcategory-option.selected .x-icon {
                display: inline-table;
            }


            .options {
                max-height: 500px;
            }

            /* Para Firefox */
            .custom-scrollbar {
                scrollbar-width: thin;
                /* auto, thin, none */
                scrollbar-color: #A9A9A9 #000000;
                /* thumb track */
            }
        </style>
        <!-- Conteúdo principal -->
        <section class="flex-1 flex flex-col overflow-hidden">
            @php

                $currentUrl = request()->path();
                $currentUrlComplete = request()->path();
                $currentSlug = '';

                if (strpos($currentUrl, 'user') === 0) {
                    $parts = explode('/', $currentUrl);
                    //dd($parts);
                    if (count($parts) > 1) {
                        $currentSlug = $parts[3];
                    }
                }

            @endphp
            <div
                class="fixed top-[70px] left-0 right-0 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pt-4 pb-3 px-[10px] bg-[#F1F1F1] z-10">
                <!-- Esquerda: Coleção e Categoria -->
                <div class="flex gap-2">
                    <div class="select-container">
                        <div class="select-button p-5" id="colecaoSelectButton">
                            <span class="text-[16px] text-black">Coleção:</span>
                            <span class="text-[18px] text-[#7A7A7A]" id="colecaoSelectedText">
                                @if (!empty($currentSlug))
                                    @foreach ($colecoes as $colecao)
                                        @if ($currentSlug == $colecao->slug)
                                            {{ $colecao->name }}
                                        @endif
                                    @endforeach
                                @else
                                    Selecione uma coleção
                                @endif
                            </span>
                            <div class="" id="colecaoArrow">
                                <div class="pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7"
                                        viewBox="0 0 12 7" fill="none">
                                        <path d="M0.75 0.75L5.69975 5.69975L10.6495 0.750001" stroke="black"
                                            stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="options p-5" id="colecaoOptions">
                            @foreach ($colecoes as $colecao)
                                <div class="option text-[18px]" data-slug="{{ $colecao->slug }}"
                                    data-value="{{ $colecao->slug }}"
                                    {{ $currentSlug == $colecao->slug ? 'selected' : '' }}
                                    style=" {{ $currentSlug == $colecao->slug ? 'padding: 6px 15px 6px 1px;' : '' }}">
                                    <span class="check-icon"
                                        style="display: {{ $currentSlug == $colecao->slug ? 'inline; margin:0 10px;' : 'none' }};"><svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                            <path
                                                d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                        </svg></span>
                                    <span class="option-content"
                                        style="margin: {{ $currentSlug == $colecao->slug ? '0' : '0 20px' }};">
                                        {{ $colecao->name }}
                                    </span>
                                    <span class="x-icon"
                                        style="display: {{ $currentSlug == $colecao->slug ? 'inline-table' : 'none' }};">×</span>
                                </div>
                            @endforeach
                            <div class="option" data-slug="" data-value="">
                                <span class="check-icon" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 640">
                                        <path
                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                    </svg></span>
                                <span class="text-sm option-content">Todas</span>
                                <span class="x-icon" style="display: none;">×</span>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div class="select-button p-5" id="categorySelectButton">
                            <span id="categorySelectedText">Categoria</span>
                            <div class="" id="categoryArrow">
                                <div class="pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7"
                                        viewBox="0 0 12 7" fill="none">
                                        <path d="M0.75 0.75L5.69975 5.69975L10.6495 0.750001" stroke="black"
                                            stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="options min-w-[250px] p-5 custom-scrollbar" id="categoryOptions"
                            style="
    left: 185px; top:5rem;">
                            @foreach ($categories as $category)
                                @php $hasSub = isset($category->subcategories) && count($category->subcategories) > 0; @endphp
                                <div class="option category-option {{ $hasSub ? 'has-subcategories' : '' }}"
                                    data-value="{{ $category->name }}" data-id="{{ $category->id }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="check-icon" style="display: none;"><svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                                    <path
                                                        d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                                </svg></span>
                                            <span class="option-content">{{ $category->name }}</span>
                                        </div>
                                        <!--<span class="arrow-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                                viewBox="0 0 12 8" fill="none">
                                                <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" />
                                            </svg>
                                        </span>-->
                                        <span class="x-icon" style="display: none;">×</span>
                                    </div>

                                    @if ($hasSub)
                                        <div class="subcategory-dropdown" data-category-id="{{ $category->id }}">
                                            <div class="subcategory-option" data-value=""
                                                data-category-id="{{ $category->id }}">
                                                <div style="display: flex; align-items: center;">
                                                    <svg class="check-icon" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 640 640">
                                                        <path
                                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                                    </svg>
                                                    <span class="text-sm ">Todas</span>
                                                </div>
                                                <span class="x-icon">×</span>
                                            </div>
                                            @foreach ($category->subcategories as $sub)
                                                <div class="subcategory-option" data-value="{{ $sub->id }}"
                                                    data-category-id="{{ $category->id }}">
                                                    <div style="display: flex; align-items: center;">
                                                        <svg class="check-icon" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 640 640">
                                                            <path
                                                                d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                                        </svg>
                                                        <span>{{ $sub->faixa }}</span>
                                                    </div>
                                                    <span class="x-icon">×</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                    @endif
                                </div>
                            @endforeach
                            <div class="option selected" data-value="">
                                <span class="check-icon" style="display: inline;"><svg
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                        <path
                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                    </svg></span>
                                <span class="text-base option-content">Todas</span>
                                <span class="x-icon" style="display: inline-table;">×</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Direita: Busca e outros -->
                <div class="flex flex-wrap gap-2 items-end justify-end">
                    <div class="flex items-center border-b border-b-black px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black ml-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                clip-rule="evenodd" />
                        </svg>
                        <input type="text" placeholder="Buscar" id="search"
                            class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
                    </div>

                    <label class="inline-flex items-center text-sm bg-white px-[20px] py-[10px] rounded-lg">
                        <span class="text-base mr-1">Agrupar cores</span>
                        <input id="groupColors" type="checkbox"
                            class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative">
                    </label>

                    <div class="filter-container">
                        <div class="filter-button" id="filterButton">
                            <span id="filterText">Filtrar</span>
                            <span id="filterCount" class="filter-count"
                                style="display: none; margin-left:10px; color: #7A7A7A;">0</span>
                            <div class="pl-2 pt-1" id="arrow2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                    viewBox="0 0 12 8" fill="none">
                                    <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>

                        <div class="filter-dropdown custom-scrollbar-wh" style="width: 228px;overflow-x:hidden;"
                            id="filterDropdown">
                            <div class="filter-section">
                                <label class="filter-label">Numeração/Tamanhos​</label>
                                <div class="filter-options" id="numeracaoOptions">
                                    @foreach ($numeracao as $num)
                                        <div class="filter-option" data-type="numeracao"
                                            data-value="{{ $num->id }}">
                                            {{ $num->numero }}</div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="filter-section">
                                <label class="filter-label">Classificação</label>
                                <div class="filter-options classification-options" id="classificationOptions">
                                    @foreach ($flags as $flag)
                                        <div class="filter-option" data-type="classification"
                                            data-value="{{ $flag->id }}">
                                            {{ $flag->flag_title }}</div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="filter-section">
                                <label class="filter-label">Valor</label>
                                <div class="filter-options price-options" id="priceOptions">
                                    <span class="text-sm pt-2">de</span> <input style="width: 30%;"
                                        class="filter-option" type="text" id="priceMin" placeholder="0,00">
                                    <span class="text-sm pt-2">até</span> <input style="width: 30%;"
                                        class="filter-option" type="text" id="priceMax" placeholder="999,99">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sort-container">
                        <div class="sort-button" id="sortButton">
                            <span class="text-black mr-2">Ordenar por:</span>
                            <span id="sortText" class="text-[#7A7A7A]"></span>
                            <div class="pl-2 pt-1" id="sortArrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                    viewBox="0 0 12 8" fill="none">
                                    <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>

                        <div class="sort-dropdown" id="sortDropdown">
                            <div class="sort-option" data-value="">Padrão</div>
                            <div class="sort-option" data-value="mais-nova">Mais novos</div>
                            <div class="sort-option" data-value="mais-antiga">Mais antigos</div>
                            <div class="sort-option" data-value="ultima-atualizacao">Última atualização</div>
                            <div class="sort-option" data-value="maior-valor">Maior valor</div>
                            <div class="sort-option" data-value="menor-valor">Menor valor</div>
                            <div class="sort-option" data-value="a-z">A-Z</div>
                            <div class="sort-option" data-value="z-a">Z-A</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Produtos -->
            <div id="produtos"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[10px] p-1 bg-[#1D1D1D] lg:p-[10px] mt-72 lg:mt-[4.8rem] overflow-auto height-ultra custom-scrollbar">

                @if (empty($produtos) || count($produtos) == 0)
                    <!-- Mensagem quando não há produtos -->
                    <div class="col-span-full flex items-center justify-center h-[100vh]">
                        <div class="text-center">
                            <p class="text-gray-600 text-xl font-medium">Nenhum produto disponível</p>
                        </div>
                    </div>
                @else
                    <!-- Template de Produto -->
                    <template id="template-produto">
                        <a href="" class="block h-full">
                            <div
                                class="bg-white hover:shadow-md transition relative rounded-md border border-[#DEDEDE] flex flex-col">
                                <div class="badge-container pt-1 px-2" style="position:absolute; min-height: 35px;">

                                </div>
                                <img src="/images/tenis-1.jpg" alt="Tênis"
                                    class="w-full object-contain rounded-md" />

                                <div class="p-4 flex-1 flex flex-col">
                                    <h2 class="title uppercase font-black font-fko text-[22px] leading-[18px] pb-2">
                                    </h2>

                                    <!-- Wrapper para empurrar preço para baixo -->
                                    <div class="flex-1 flex flex-col justify-between">
                                        <div class="mt-auto">
                                            <p class="text-sm pb-2">
                                                <span class="categoria text-black "></span>
                                                <span class="genero text-black opacity-50 px-2"></span>
                                                <span class="codigo text-black opacity-50"></span>
                                            </p>
                                            <div class="float-right mr-[25%]">
                                                <p class="text-black opacity-50 text-xs title-caract-1"></p>
                                                <p class="numeracao text-black text-xs desc-caract-1"></p>
                                            </div>
                                            <p class="text-black opacity-50 text-xs">Cor</p>
                                            <p class="cor text-black text-xs pb-2"></p>


                                            <p class="text-black opacity-50 mt-1 text-xs ">PDV</p>
                                            <p class="text-base preco text-black"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </template>
                @endif
            </div>


        </section>


    </main>

    @push('scripts')
        <script>
            const produtosData = [
                @if (!empty($produtos) && count($produtos) > 0)
                    @foreach ($produtos as $produtoGroup)
                        @if ($produtoGroup && $produtoGroup->product)
                            @php
                                $produto = $produtoGroup->product;
                                $imgPath = '/images/produtos/' . $produto->code . '_' . str_replace('/', '_', $produtoGroup->color_code) . '.jpg';
                                $imgFullPath = public_path($imgPath);
                                $img = file_exists($imgFullPath) ? $imgPath : '/images/img-padrao-oly.png';
                                $numeracaoIds = $produto->numeracao ? $produto->numeracao->pluck('id')->toArray() : [];
                                $tamanhoIds = $produto->sizes ? $produto->sizes->pluck('id')->toArray() : [];
                                $precoNumerico = $produto->price ?? 0;
                                $classificacaoId = $produtoGroup->flagProduct ? $produtoGroup->flagProduct->id : null;
                                $segmentacaoIds = $produtoGroup->segmentacoesCliente ? $produtoGroup->segmentacoesCliente->pluck('id')->toArray() : [];
                            @endphp {
                                title: "{{ $produto->name ?? '' }}",
                                imagem: "{{ $img }}",
                                codigo: "{{ $produto->code ?? '' }}",
                                'title-caract-1': "{{ $produto->caracteristicasDestaque && $produto->caracteristicasDestaque->first() ? $produto->caracteristicasDestaque->first()->title : '' }}",
                                'desc-caract-1': "{{ $produto->caracteristicasDestaque && $produto->caracteristicasDestaque->first() ? $produto->caracteristicasDestaque->first()->description : '' }}",
                                cor: "{{ $produtoGroup->color_name ?? '' }}",
                                codigo_cor: "{{ str_replace('/', '_', $produtoGroup->color_code ?? '') }}",
                                numeracao: "{{ $produtoGroup->numeracao ? $produtoGroup->numeracao->numero : '' }}",
                                categoria: "{{ $produto->category ? $produto->category->name : '' }}",
                                subcategory_id: "{{ $produto->subcategory_id ?? '' }}",
                                preco: "R$ {{ $precoNumerico }}",
                                precoNumerico: "R$ {{ $precoNumerico }}",
                                genero: "{{ $produtoGroup->genero ?? '' }}",
                                numeracaoIds: @json($numeracaoIds),
                                tamanhoIds: @json($tamanhoIds),
                                classificacaoId: {{ $classificacaoId ?? 'null' }},
                                segmentacaoIds: @json($segmentacaoIds),
                                badge_title: "{{ $produtoGroup->flagProduct->flag_title ?? '' }}",
                                badge_icon: "{{ $produtoGroup->flagProduct->icon ?? '' }}",
                                badge_bg: "{{ $produtoGroup->flagProduct->flag_bg ?? '' }}",
                                badge_color: "{{ $produtoGroup->flagProduct->flag_color_text_bg ?? '' }}",
                                badge_icon_align: "{{ $produtoGroup->flagProduct->alinhamento ?? '' }}",
                                orderfilterflag: {{ $produtoGroup->flagProduct->orderfilterflag ?? 0 }},
                                slug: "{{ $produto->slug ?? '' }}",
                                order: {{ $produto->order ?? 0 }}
                            },
                        @endif
                    @endforeach
                @endif
            ];

            const produtosContainer = document.getElementById("produtos");
            const template = document.getElementById("template-produto");
            const groupCheckbox = document.getElementById("groupColors");

            let selectedCategory = '';
            let selectedSubcategory = '';



            // Coleção dropdown
            const colecaoSelectButton = document.getElementById('colecaoSelectButton');
            const colecaoOptions = document.getElementById('colecaoOptions');
            const colecaoSelectedText = document.getElementById('colecaoSelectedText');
            const colecaoArrow = document.getElementById('colecaoArrow');


            // Category dropdown
            const categorySelectButton = document.getElementById('categorySelectButton');
            const categoryOptions = document.getElementById('categoryOptions');
            const categorySelectedText = document.getElementById('categorySelectedText');
            const categoryArrow = document.getElementById('categoryArrow');

            function renderProdutos(produtos, agrupado = false) {
                if (!produtos || produtos.length == 0) {
                    produtosContainer.innerHTML = `
                        <div class="col-span-full flex items-center justify-center h-[70vh]">
                            <div class="text-center">
                                <p class="text-gray-600 text-xl font-medium">Nenhum produto disponível</p>
                            </div>
                        </div>
                    `;
                    return;
                } else {
                    produtosContainer.innerHTML = "";
                }

                let listaParaRenderizar = [];

                if (agrupado) {
                    const produtosPorNome = {};
                    produtos.forEach((p) => {
                        if (!produtosPorNome[p.title]) {
                            produtosPorNome[p.title] = p;
                        }
                    });
                    listaParaRenderizar = Object.values(produtosPorNome);
                } else {
                    listaParaRenderizar = produtos;
                }

                listaParaRenderizar.forEach((produto) => {
                    const clone = template.content.cloneNode(true);
                    const link = clone.querySelector("a");
                    link.href = `{{ $currentSlug }}/${produto.codigo}/${produto.codigo_cor}`;
                    clone.querySelector("img").src = produto.imagem;
                    clone.querySelector("h2").textContent = produto.title;
                    clone.querySelector(".codigo").textContent = produto.codigo;
                    clone.querySelector(".cor").textContent = produto.cor;
                    clone.querySelector(".genero").textContent = produto.genero;
                    clone.querySelector(".categoria").textContent = produto.categoria;
                    clone.querySelector(".title-caract-1").textContent = 'Numeração';
                    clone.querySelector(".desc-caract-1").textContent = produto['numeracao'];
                    clone.querySelector(".preco").textContent = produto.preco;

                    const badgeContainer = clone.querySelector(".badge-container");

                    if (produto.badge_title != "") {
                        const badge_icon_align = produto.badge_icon_align;

                        if (produto.badge_icon != "") {
                            const badgeIconWrapper = document.createElement("div");
                            badgeIconWrapper.className = "badge-icon-wrapper";
                            badgeIconWrapper.style.position = "relative";
                            badgeIconWrapper.style.display = "inline-block";

                            const badgeIcon = document.createElement("img");
                            badgeIcon.className = "badge-icon";
                            badgeIcon.src = "/" + produto.badge_icon;
                            badgeIcon.alt = produto.badge_title;
                            badgeIcon.style.width = "19px";
                            badgeIcon.style.height = "19px";

                            if (badge_icon_align == "right") {
                                badgeContainer.style.right = "5px";
                            }
                            if (badge_icon_align == "left") {
                                badgeContainer.style.left = "5px";
                            }

                            const badge = document.createElement("span");
                            badge.className = "badge-tooltip";
                            badge.textContent = produto.badge_title;
                            badge.style.backgroundColor = 'transparent';
                            badge.style.color = produto.badge_color;
                            badge.style.fontSize = "10px";

                            badgeIconWrapper.appendChild(badgeIcon);
                            badgeIconWrapper.appendChild(badge);
                            badgeContainer.appendChild(badgeIconWrapper);
                        } else {
                            const badge = document.createElement("span");
                            badge.className = "badge";
                            badge.textContent = produto.badge_title;
                            badge.style.backgroundColor = produto.badge_bg;
                            badge.style.color = produto.badge_color;

                            if (badge_icon_align == "right") {
                                badgeContainer.style.right = "5px";
                            }
                            if (badge_icon_align == "left") {
                                badgeContainer.style.left = "5px";
                            }

                            badgeContainer.appendChild(badge);
                        }
                    }

                    produtosContainer.appendChild(clone);
                });
            }

            const searchInput = document.getElementById("search") ||
                document.querySelector(".input-estilizado.bg-transparent") ||
                document.querySelector(".input-estilizado");

            function filtrarProdutos(termo, categoria = '') {
                return produtosData.filter(
                    (p) => {
                        const matchesTermo = p.cor.toLowerCase().includes(termo) ||
                            p.title.toLowerCase().includes(termo) ||
                            p.codigo.toLowerCase().includes(termo);

                        const matchesCategoria = categoria === '' || p.categoria === categoria;
                        const matchesSubcategoria = selectedSubcategory === '' || p.subcategory_id == selectedSubcategory;

                        const matchesNumeracao = selectedFilters.numeracao.length === 0 ||
                            selectedFilters.numeracao.some(numId => p.numeracaoIds.includes(parseInt(numId)));

                        const matchesTamanho = selectedFilters.tamanho.length === 0 ||
                            selectedFilters.tamanho.some(sizeId => p.tamanhoIds.includes(parseInt(sizeId)));

                        const matchesClassificacao = selectedFilters.classification.length === 0 ||
                            (p.classificacaoId && selectedFilters.classification.includes(p.classificacaoId.toString()));

                        let matchesSegmentacao = true;
                        try {
                            const selectedSegmentacoes = JSON.parse(localStorage.getItem('selectedSegmentacoes') || '[]');
                            if (selectedSegmentacoes.length > 0) {
                                matchesSegmentacao = selectedSegmentacoes.some(segId => p.segmentacaoIds.includes(parseInt(
                                    segId)));
                            }
                        } catch (e) {
                            console.error('Erro ao processar segmentações do localStorage:', e);
                        }

                        let matchesPreco = true;
                        if (selectedFilters.priceMin !== null && selectedFilters.priceMin !== '') {
                            const minPrice = parseFloat(selectedFilters.priceMin.replace(',', '.'));
                            matchesPreco = matchesPreco && p.precoNumerico >= minPrice;
                        }
                        if (selectedFilters.priceMax !== null && selectedFilters.priceMax !== '') {
                            const maxPrice = parseFloat(selectedFilters.priceMax.replace(',', '.'));
                            matchesPreco = matchesPreco && p.precoNumerico <= maxPrice;
                        }

                        return matchesTermo && matchesCategoria && matchesSubcategoria && matchesNumeracao &&
                            matchesTamanho && matchesClassificacao && matchesSegmentacao && matchesPreco;
                    }
                );
            }

            function aplicarFiltros() {
                applySorting(selectedSortValue);
            }

            renderProdutos(produtosData, false);

            window.addEventListener('storage', function(e) {
                if (e.key === 'selectedSegmentacoes') {
                    //console.log('Segmentações alteradas no localStorage, reaplicando filtros...');
                    aplicarFiltros();
                }
            });

            let originalSetItem = localStorage.setItem;
            localStorage.setItem = function(key, value) {
                originalSetItem.apply(this, arguments);
                if (key === 'selectedSegmentacoes') {
                    //console.log('Segmentações alteradas na mesma aba, reaplicando filtros...');
                    aplicarFiltros();
                }
            };

            // Função para carregar subcategorias dentro do dropdown de categoria
            function loadSubcategoriesInline(categoryId, container, categoryOption) {
                if (container.hasAttribute('data-loaded')) {
                    return;
                }

                fetch(`/user/api/subcategories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            container.innerHTML = '';
                            categoryOption.classList.add('has-subcategories');

                            const allOption = document.createElement('div');
                            allOption.className = 'subcategory-option';
                            allOption.setAttribute('data-value', '');
                            allOption.setAttribute('data-category-id', categoryId);
                            allOption.innerHTML = `
                                <div style="display: flex; align-items: center;">
                                    <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                        <path d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z"/>
                                    </svg>
                                    <span>Todas</span>
                                </div>
                                <span class="x-icon">×</span>
                            `;
                            container.appendChild(allOption);

                            data.forEach(subcategory => {
                                const option = document.createElement('div');
                                option.className = 'subcategory-option';
                                option.setAttribute('data-value', subcategory.id);
                                option.setAttribute('data-category-id', categoryId);
                                option.innerHTML = `
                                    <div style="display: flex; align-items: center;">
                                        <svg class="check-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                            <path d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z"/>
                                        </svg>
                                        <span>${subcategory.name}</span>
                                    </div>
                                    <span class="x-icon">×</span>
                                `;
                                container.appendChild(option);
                            });

                            container.querySelectorAll('.subcategory-option').forEach(subOption => {
                                subOption.addEventListener('click', function(e) {
                                    e.stopPropagation();
                                    handleSubcategorySelection(this);
                                });
                            });

                            container.setAttribute('data-loaded', 'true');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao carregar subcategorias:', error);
                    });
            }

            // Função para lidar com a seleção de subcategoria
            function handleSubcategorySelection(subcategoryOption) {
                const subcategoryId = subcategoryOption.getAttribute('data-value');
                const categoryId = subcategoryOption.getAttribute('data-category-id');
                const subcategoryName = subcategoryOption.querySelector('span').textContent;

                const categoryOption = document.querySelector(`.category-option[data-id="${categoryId}"]`);
                const categoryName = categoryOption.querySelector('.option-content').textContent;

                selectedCategory = categoryOption.getAttribute('data-value');
                selectedSubcategory = subcategoryId;

                if (subcategoryId) {
                    categorySelectedText.innerHTML = `
                        <span class='text-[16px] text-black'>Categoria </span> 
                        <span class='text-[18px] text-[#7A7A7A]'>${categoryName} (${subcategoryName})</span>
                    `;
                } else {
                    categorySelectedText.innerHTML = `
                        <span class='text-[16px] text-black'>Categoria </span> 
                        <span class='text-[18px] text-[#7A7A7A]'>${categoryName}</span>
                    `;
                }

                categoryOptions.querySelectorAll('.option').forEach(opt => {
                    opt.classList.remove('selected');
                    opt.querySelector('.check-icon').style.display = 'none';
                    opt.querySelector('.x-icon').style.display = 'none';
                });

                categoryOption.classList.add('selected');
                //categoryOption.querySelector('.check-icon').style.display = 'inline';
                //categoryOption.querySelector('.x-icon').style.display = 'inline';

                const subcategoryContainer = subcategoryOption.closest('.subcategory-dropdown');

                document.querySelectorAll('.subcategory-option').forEach(opt => {
                    opt.classList.remove('selected');
                    opt.querySelector('.check-icon').style.display = 'none';
                    opt.querySelector('.x-icon').style.display = 'none';
                });
                subcategoryOption.classList.add('selected');
                subcategoryOption.querySelector('.check-icon').style.display = 'inline';
                subcategoryOption.querySelector('.x-icon').style.display = 'inline-table';

                //closeCategoryDropdown();
                aplicarFiltros();
            }

            // Inicializar estrutura de subcategorias nos options de categoria
            function updateCategoryDropdownStructure() {
                categoryOptions.querySelectorAll('.category-option').forEach(categoryOption => {
                    const categoryId = categoryOption.getAttribute('data-id');

                    if (categoryId) {
                        let subcategoryContainer = categoryOption.querySelector('.subcategory-dropdown');
                        if (!subcategoryContainer) {
                            subcategoryContainer = document.createElement('div');
                            subcategoryContainer.className = 'subcategory-dropdown';
                            subcategoryContainer.setAttribute('data-category-id', categoryId);
                            categoryOption.appendChild(subcategoryContainer);
                        }

                        // Clique na categoria: apenas expande/colapsa; carrega via AJAX se não houver conteúdo
                        categoryOption.addEventListener('click', function(e) {
                            e.stopPropagation();

                            if (e.target.closest('.subcategory-dropdown') ||
                                e.target.classList.contains('check-icon') ||
                                e.target.classList.contains('x-icon')) {
                                return;
                            }

                            const subcategoryContainer = this.querySelector('.subcategory-dropdown');
                            const hasSubcategories = this.classList.contains('has-subcategories');

                            // Se NÃO tem subcategorias, filtra diretamente pela categoria
                            if (!hasSubcategories || (subcategoryContainer && subcategoryContainer.children
                                    .length === 0)) {
                                const categoryName = this.getAttribute('data-value');
                                const categoryId = this.getAttribute('data-id');

                                // Define a categoria selecionada
                                selectedCategory = categoryName;
                                selectedSubcategory = ''; // Limpa subcategoria

                                // Atualiza o texto do botão
                                categorySelectedText.innerHTML = `
                        <span class='text-[16px] text-black'>Categoria </span> 
                        <span class='text-[18px] text-[#7A7A7A]'>${categoryName}</span>
                    `;

                                categoryOptions.querySelectorAll('.subcategory-option').forEach(
                                    opt => {
                                        opt.classList.remove('selected');
                                        opt.querySelector('.check-icon').style.display = 'none';
                                        opt.querySelector('.x-icon').style.display = 'none';
                                    });

                                // Atualiza visual de seleção
                                categoryOptions.querySelectorAll('.category-option').forEach(opt => {
                                    opt.classList.remove('selected');
                                    opt.querySelector('.check-icon').style.display = 'none';
                                    const xIcon = opt.querySelector('.x-icon');
                                    if (xIcon) xIcon.style.display = 'none';
                                });

                                categoryOptions.querySelectorAll('.option').forEach(opt => {
                                    opt.classList.remove('selected');
                                    opt.querySelector('.check-icon').style.display = 'none';
                                    opt.querySelector('.x-icon').style.display = 'none';
                                });

                                this.classList.add('selected');
                                //this.querySelector('.option-content').style.margin = '0';
                                this.querySelector('.check-icon').style.display = 'inline';
                                const xIcon = this.querySelector('.x-icon');
                                if (xIcon) xIcon.style.display = 'inline-table';

                                // Aplica o filtro
                                aplicarFiltros();

                                // Opcional: fechar o dropdown após selecionar
                                // closeCategoryDropdown();

                                return;
                            }

                            const isExpanded = this.classList.contains('expanded');

                            // Não fecha outros dropdowns, apenas expande o clicado
                            if (!isExpanded) {

                                this.classList.add('expanded');
                                // Garante que o dropdown abre abaixo do item principal
                                const subcategoryContainer = this.querySelector('.subcategory-dropdown');
                                if (subcategoryContainer) {
                                    subcategoryContainer.style.display = 'block';
                                }
                                if (!subcategoryContainer.hasAttribute('data-loaded') && subcategoryContainer
                                    .children.length === 0) {
                                    loadSubcategoriesInline(categoryId, subcategoryContainer, categoryOption);
                                }
                            } else {

                                this.classList.remove('expanded');
                                const subcategoryContainer = this.querySelector('.subcategory-dropdown');
                                if (subcategoryContainer) {
                                    subcategoryContainer.style.display = 'none';
                                }
                            }

                        });

                        // Bind de seleção para subcategorias já renderizadas
                        subcategoryContainer.querySelectorAll('.subcategory-option').forEach(subOption => {
                            subOption.addEventListener('click', function(e) {
                                e.stopPropagation();
                                handleSubcategorySelection(this);
                            });
                        });
                    }
                });
            }

            function openColecaoDropdown() {
                colecaoOptions.classList.add('show');
                colecaoArrow.classList.add('up');
            }

            function closeColecaoDropdown() {
                colecaoOptions.classList.remove('show');
                colecaoArrow.classList.remove('up');
            }

            function openCategoryDropdown() {
                categoryOptions.classList.add('show');
                categoryArrow.classList.add('up');
            }

            function closeCategoryDropdown() {
                categoryOptions.classList.remove('show');
                categoryArrow.classList.remove('up');
            }

            colecaoSelectButton.addEventListener('click', function(e) {
                e.stopPropagation();
                if (colecaoOptions.classList.contains('show')) {
                    closeColecaoDropdown();
                } else {
                    closeCategoryDropdown();
                    openColecaoDropdown();
                }
            });

            colecaoOptions.addEventListener('click', function(e) {
                if (e.target.classList.contains('x-icon')) {
                    e.stopPropagation();
                    const option = e.target.closest('.option');
                    if (option) {
                        colecaoSelectedText.textContent = 'Selecione uma coleção';
                        closeColecaoDropdown();
                        const slug = option.getAttribute('data-slug');
                        const currentUrl = window.location.href;
                        const newUrl = currentUrl.replace(/\/[^/]+$/, "") + '/' + slug;
                        window.location.href = newUrl;
                    }
                    return;
                }

                let option = e.target;

                if (!option.classList.contains('option')) {
                    option = option.closest('.option');
                }

                if (option && option.classList.contains('option')) {
                    colecaoOptions.querySelectorAll('.option').forEach(opt => {
                        opt.classList.remove('selected');
                        opt.querySelector('.check-icon').style.display = 'none';
                        opt.querySelector('.x-icon').style.display = 'none';
                    });

                    option.classList.add('selected');
                    option.style.padding = '6px 15px 6px 1px';
                    option.querySelector('.check-icon').style.display = 'inline';
                    option.querySelector('.x-icon').style.display = 'inline-table';

                    const slug = option.getAttribute('data-slug');
                    const currentUrl = window.location.href;
                    const newUrl = currentUrl.replace(/\/[^/]+$/, "") + '/' + slug;

                    const text = option.querySelector('.option-content').textContent;
                    colecaoSelectedText.textContent = text;
                    closeColecaoDropdown();

                    window.location.href = newUrl;
                }
            });

            categorySelectButton.addEventListener('click', function(e) {
                console.log('Clicou na categoria');
                e.stopPropagation();

                if (categoryOptions.classList.contains('show')) {
                    closeCategoryDropdown();
                } else {
                    closeColecaoDropdown();
                    openCategoryDropdown();
                }
            });

            categoryOptions.addEventListener('click', function(e) {
                // Tratar cliques em subcategorias primeiro
                const subOption = e.target.closest('.subcategory-option');
                if (subOption) {
                    e.stopPropagation();
                    // limpar seleção anterior de subcategorias
                    categoryOptions.querySelectorAll('.subcategory-option').forEach(opt => {
                        opt.classList.remove('selected');
                        const ci = opt.querySelector('.check-icon');
                        const xi = opt.querySelector('.x-icon');
                        if (ci) ci.style.display = 'none';
                        if (xi) xi.style.display = 'none';
                    });

                    subOption.classList.add('selected');
                    const ci = subOption.querySelector('.check-icon');
                    const xi = subOption.querySelector('.x-icon');
                    if (ci) ci.style.display = 'inline';
                    if (xi) xi.style.display = 'inline-table';

                    selectedSubcategory = subOption.getAttribute('data-value') || '';
                    closeCategoryDropdown();
                    aplicarFiltros();
                    return;
                }

                // Handle X icon click para remover seleção (categoria ou subcategoria)
                if (e.target.classList.contains('x-icon')) {
                    e.stopPropagation();

                    // Limpar seleção visual de categorias
                    categoryOptions.querySelectorAll('.option').forEach(opt => {
                        opt.classList.remove('selected');
                        const ci = opt.querySelector('.check-icon');
                        const xi = opt.querySelector('.x-icon');
                        if (ci) ci.style.display = 'none';
                        if (xi) xi.style.display = 'none';
                    });

                    // Limpar seleção visual de subcategorias
                    categoryOptions.querySelectorAll('.subcategory-option').forEach(opt => {
                        opt.classList.remove('selected');
                        const ci = opt.querySelector('.check-icon');
                        const xi = opt.querySelector('.x-icon');
                        if (ci) ci.style.display = 'none';
                        if (xi) xi.style.display = 'none';
                    });

                    // Resetar filtros de categoria e subcategoria
                    categorySelectedText.innerHTML = "<span class='text-[16px] text-black'>Categoria</span>";
                    selectedCategory = '';
                    selectedSubcategory = '';

                    closeCategoryDropdown();
                    aplicarFiltros();
                    return;
                }

                let option = e.target;
                if (!option.classList.contains('option')) {
                    option = option.closest('.option');
                }

                if (option && option.classList.contains('option')) {
                    const hasSubcategories = option.classList.contains('has-subcategories');

                    // Seleção direta quando não há subcategorias
                    if (!hasSubcategories || option.hasAttribute('data-no-subcategories')) {
                        categoryOptions.querySelectorAll('.option').forEach(opt => {
                            opt.classList.remove('selected');
                            opt.classList.remove('expanded');
                            const ci = opt.querySelector('.check-icon');
                            const xi = opt.querySelector('.x-icon');
                            if (ci) ci.style.display = 'none';
                            if (xi) xi.style.display = 'none';
                        });

                        option.classList.add('selected');
                        const ci = option.querySelector('.check-icon');
                        const xi = option.querySelector('.x-icon');
                        if (ci) ci.style.display = 'inline';
                        if (xi) xi.style.display = 'inline-table';

                        const value = option.getAttribute('data-value');
                        const text = option.querySelector('.option-content').textContent;
                        categorySelectedText.innerHTML = `
                            <span class='text-[16px] text-black'>Categoria </span> 
                            <span class='text-[18px] text-[#7A7A7A]'>${text}</span>
                        `;
                        selectedCategory = value;
                        selectedSubcategory = '';
                        aplicarFiltros();
                    }
                }
            });

            const filterButton = document.getElementById('filterButton');
            const filterText = document.getElementById('filterText');
            const filterCount = document.getElementById('filterCount');
            const arrow2 = document.getElementById('arrow2');
            const filterDropdown = document.getElementById('filterDropdown');
            const filterOptions = document.querySelectorAll('.filter-option');

            let selectedFilters = {
                numeracao: [],
                tamanho: [],
                classification: [],
                priceMin: null,
                priceMax: null
            };

            filterButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = filterDropdown.classList.contains('show');

                if (isOpen) {
                    closeFilterDropdown();
                } else {
                    openFilterDropdown();
                    closeSortDropdown();
                }
            });

            filterOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();

                    const type = this.dataset.type;
                    const value = this.dataset.value;

                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        if (Array.isArray(selectedFilters[type])) {
                            selectedFilters[type] = selectedFilters[type].filter(item => item !== value);
                        }

                        const existingRemoveBtn = this.querySelector('.tag-remove');
                        if (existingRemoveBtn) {
                            existingRemoveBtn.remove();
                        }
                    } else {
                        this.classList.add('selected');
                        if (Array.isArray(selectedFilters[type]) && !selectedFilters[type].includes(value)) {
                            selectedFilters[type].push(value);
                        }

                        const removeBtn = document.createElement('span');
                        removeBtn.className = 'tag-remove';
                        removeBtn.innerHTML = '&times;';
                        removeBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            removeFilter(type, value);
                        });

                        this.appendChild(removeBtn);
                    }

                    updateFilterCount();
                });
            });

            const priceMinInput = document.getElementById('priceMin');
            const priceMaxInput = document.getElementById('priceMax');

            if (priceMinInput) {
                priceMinInput.addEventListener('input', function() {
                    selectedFilters.priceMin = this.value;
                    updateFilterCount();
                });
            }

            if (priceMaxInput) {
                priceMaxInput.addEventListener('input', function() {
                    selectedFilters.priceMax = this.value;
                    updateFilterCount();
                });
            }

            document.addEventListener('click', function(event) {
                if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                    closeFilterDropdown();
                }
            });

            filterDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            function openFilterDropdown() {
                filterDropdown.classList.add('show');
                filterButton.classList.add('active');
                arrow2.classList.add('up');
            }

            function closeFilterDropdown() {
                filterDropdown.classList.remove('show');
                filterButton.classList.remove('active');
                arrow2.classList.remove('up');
            }

            function updateFilterCount() {
                const totalSelected = selectedFilters.numeracao.length + selectedFilters.tamanho.length +
                    selectedFilters.classification.length +
                    (selectedFilters.priceMin ? 1 : 0) +
                    (selectedFilters.priceMax ? 1 : 0);

                if (totalSelected > 0) {
                    if (totalSelected == 1) {
                        filterText.textContent = 'Filtrar:';
                        filterCount.textContent = totalSelected + ' seleção';
                    } else {
                        filterCount.textContent = totalSelected + ' seleções';
                    }

                    filterCount.style.display = 'inline';
                } else {
                    filterText.textContent = 'Filtrar';
                    filterCount.style.display = 'none';
                }

                aplicarFiltros();
            }

            function removeFilter(type, value) {
                if (Array.isArray(selectedFilters[type])) {
                    selectedFilters[type] = selectedFilters[type].filter(item => item !== value);
                } else {
                    selectedFilters[type] = null;
                }

                const option = document.querySelector(`.filter-option[data-type="${type}"][data-value="${value}"]`);
                if (option) {
                    option.classList.remove('selected');

                    const existingRemoveBtn = option.querySelector('.tag-remove');
                    if (existingRemoveBtn) {
                        existingRemoveBtn.remove();
                    }
                }

                updateFilterCount();
            }

            const sortButton = document.getElementById('sortButton');
            const sortText = document.getElementById('sortText');
            const sortArrow = document.getElementById('sortArrow');
            const sortDropdown = document.getElementById('sortDropdown');
            const sortOptions = document.querySelectorAll('.sort-option');

            let selectedSortValue = '';

            (function initDefaultSortSelection() {
                const optionToSelect = Array.from(sortOptions).find(opt => opt.getAttribute('data-value') ===
                    selectedSortValue);
                if (optionToSelect) {
                    sortOptions.forEach(opt => opt.classList.remove('selected'));
                    optionToSelect.classList.add('selected');
                    sortText.textContent = optionToSelect.textContent;
                }
            })();

            sortButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = sortDropdown.classList.contains('show');

                if (isOpen) {
                    closeSortDropdown();
                } else {
                    closeFilterDropdown();
                    openSortDropdown();
                }
            });

            sortOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();

                    sortOptions.forEach(opt => opt.classList.remove('selected'));

                    this.classList.add('selected');

                    sortText.textContent = this.textContent;

                    selectedSortValue = this.getAttribute('data-value');

                    applySorting(selectedSortValue);

                    closeSortDropdown();
                });
            });

            document.addEventListener('click', function(event) {
                if (!sortButton.contains(event.target) && !sortDropdown.contains(event.target)) {
                    closeSortDropdown();
                }
            });

            sortDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            function openSortDropdown() {
                sortDropdown.classList.add('show');
                sortButton.classList.add('active');
                sortArrow.classList.add('up');
            }

            function closeSortDropdown() {
                sortDropdown.classList.remove('show');
                sortButton.classList.remove('active');
                sortArrow.classList.remove('up');
            }

            function applySorting(sortValue) {
                const termo = ((searchInput && searchInput.value) ? searchInput.value : '').toLowerCase();
                const categoria = selectedCategory;
                const produtosFiltrados = filtrarProdutos(termo, categoria);
                let sortedProdutos = [...produtosFiltrados];

                if (!sortValue) {
                    sortValue = selectedSortValue;
                }

                switch (sortValue) {
                    case 'mais-nova':
                        sortedProdutos.sort((a, b) => {
                            const ao = Number(a.orderfilterflag ?? 0);
                            const bo = Number(b.orderfilterflag ?? 0);
                            if (ao !== bo) return ao - bo;
                            return (a.title || '').localeCompare(b.title || '');
                        });
                        break;
                    case 'mais-antiga':
                        sortedProdutos.sort((a, b) => {
                            const ao = Number(a.orderfilterflag ?? 0);
                            const bo = Number(b.orderfilterflag ?? 0);
                            if (ao !== bo) return bo - ao;
                            return (a.title || '').localeCompare(b.title || '');
                        });
                        break;
                    case 'recentes':
                        sortedProdutos.sort((a, b) => b.codigo.localeCompare(a.codigo));
                        break;
                    case 'ultima-atualizacao':
                        sortedProdutos.sort((a, b) => b.codigo.localeCompare(a.codigo));
                        break;
                    case 'maior-valor':
                        sortedProdutos.sort((a, b) => {
                            const precoA = parseFloat(a.precoNumerico.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
                            const precoB = parseFloat(b.precoNumerico.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
                            return precoB - precoA;
                        });
                        break;
                    case 'menor-valor':
                        sortedProdutos.sort((a, b) => {
                            const precoA = parseFloat(a.precoNumerico.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
                            const precoB = parseFloat(b.precoNumerico.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
                            return precoA - precoB;
                        });
                        break;
                    case 'a-z':
                        sortedProdutos.sort((a, b) => a.title.localeCompare(b.title));
                        break;
                    case 'z-a':
                        sortedProdutos.sort((a, b) => b.title.localeCompare(a.title));
                        break;
                    default:
                        sortedProdutos.sort((a, b) => Number(a.order ?? 0) - Number(b.order ?? 0));
                        break;
                }

                const agrupado = groupCheckbox.checked;
                renderProdutos(sortedProdutos, agrupado);
            }

            document.addEventListener('click', function(e) {
                // Não fechar se o clique foi dentro de algum dropdown ou botão
                if (!e.target.closest('.select-container') &&
                    !e.target.closest('.filter-container') &&
                    !e.target.closest('.sort-container')) {
                    closeColecaoDropdown();
                    closeCategoryDropdown();
                    closeFilterDropdown();
                    closeSortDropdown();
                }
            });

            if (searchInput) {
                searchInput.addEventListener("input", aplicarFiltros);
            }
            groupCheckbox.addEventListener("change", aplicarFiltros);

            // Inicializar estrutura de subcategorias
            updateCategoryDropdownStructure();

            aplicarFiltros();
        </script>
    @endpush

</x-layout-user>
