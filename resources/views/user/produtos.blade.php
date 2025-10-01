<x-layout-user title="Under Armour">
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

            @media (min-width: 1280px) {

                #produtos {
                    min-height: 75vh;
                }
            }

            @media (min-width: 1280px) {

                #produtos {
                    min-height: 80vh;
                }
            }

            @media (min-width: 2566px) {
                #produtos {
                    min-height: 88vh;
                }
            }

            @media (min-width: 3000px) {
                #produtos {
                    min-height: 91vh;
                }
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
            <!-- Filtros superiores -->
            <div
                class="fixed top-[70px] left-0 right-0 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pt-4 pb-3 px-[10px] bg-[#F1F1F1] z-10">
                <!-- Esquerda: Coleção e Categoria -->
                <div class="flex gap-2">
                    <div class="select-container">
                        <div class="select-button" id="colecaoSelectButton">
                            <span id="colecaoSelectedText">
                                @if (!empty($currentSlug))
                                    @foreach ($colecoes as $colecao)
                                        @if ($currentSlug == $colecao->slug)
                                            {{ $colecao->codigo_colecao }} - <span
                                                style="font-size: 14px;">{{ $colecao->name }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    Selecione uma coleção
                                @endif
                            </span>
                            <div class="" id="colecaoArrow">
                                <div class="pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                        viewBox="0 0 12 8" fill="none">
                                        <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="options" id="colecaoOptions">

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
                                        {{ $colecao->codigo_colecao }} -
                                        <span style="font-size: 14px;">{{ ucwords(strtolower($colecao->name)) }}</span>
                                    </span>
                                    <span class="x-icon"
                                        style="display: {{ $currentSlug == $colecao->slug ? 'inline' : 'none' }};">×</span>
                                </div>
                            @endforeach
                            <div class="option" data-slug="" data-value="">
                                <span class="check-icon" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 640">
                                        <path
                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                    </svg></span>
                                <span class="option-content">Todas</span>
                                <span class="x-icon" style="display: none;">×</span>
                            </div>
                        </div>
                    </div>

                    <div class="select-container w-[160px]">
                        <div class="select-button" id="categorySelectButton">
                            <span id="categorySelectedText">Categorias</span>
                            <div class="" id="categoryArrow">
                                <div class="pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                        viewBox="0 0 12 8" fill="none">
                                        <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="options" id="categoryOptions">

                            @foreach ($categories as $category)
                                <div class="option" data-value="{{ $category->name }}" data-id="{{ $category->id }}">
                                    <span class="check-icon" style="display: none;"><svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                            <path
                                                d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                        </svg></span>
                                    <span class="option-content">{{ $category->name }}</span>
                                    <span class="x-icon" style="display: none;">×</span>
                                </div>
                            @endforeach
                            <div class="option selected" data-value="">
                                <span class="check-icon" style="display: inline;"><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                        <path
                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                    </svg></span>
                                <span class="option-content">Todas</span>
                                <span class="x-icon" style="display: inline;">×</span>
                            </div>
                        </div>
                    </div>

                    <div class="select-container w-[190px]" id="subcategoryContainer" style="display: none;">
                        <div class="select-button" id="subcategorySelectButton">
                            <span id="subcategorySelectedText">Selecione uma categoria primeiro</span>
                            <div class="" id="subcategoryArrow">
                                <div class="pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                        viewBox="0 0 12 8" fill="none">
                                        <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="options" id="subcategoryOptions">
                            <div class="option" data-value="" selected>
                                <span class="check-icon" style="display: inline;"><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                        <path
                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                    </svg></span>
                                <span class="option-content">Todas as faixas</span>
                                <span class="x-icon" style="display: inline;">×</span>
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
                        <input type="text" placeholder="Buscar"
                            class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
                    </div>

                    <label class="inline-flex items-center text-sm bg-white px-[20px] py-[9px] rounded-lg">
                        <span class="mr-1">Agrupar cores</span>
                        <input id="groupColors" type="checkbox" class="form-checkbox text-blue-600 rounded" />
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

                        <div class="filter-dropdown" style="width: 310px;" id="filterDropdown">
                            <div class="filter-section">
                                <label class="filter-label">Numeração</label>
                                <div class="filter-options" id="numeracaoOptions">
                                    @foreach ($numeracao as $num)
                                        <div class="filter-option" data-type="numeracao"
                                            data-value="{{ $num->id }}">
                                            {{ $num->numero }}</div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="filter-section">
                                <label class="filter-label">Tamanho</label>
                                <div class="filter-options" id="tamanhoOptions">
                                    @foreach ($tamanhos as $size)
                                        <div class="filter-option" data-type="tamanho"
                                            data-value="{{ $size->id }}">
                                            {{ $size->size }}</div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="filter-section">
                                <label class="filter-label">Classificação</label>
                                <div class="filter-options classification-options" id="classificationOptions">
                                    @foreach ($flags as $flag)
                                        <div class="filter-option" data-type="classification"
                                            data-value="{{ $flag->id }}" style="width: ">
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
                            <span id="sortText" class="text-[#7A7A7A]">Mais nova</span>
                            <div class="pl-2 pt-1" id="sortArrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                    viewBox="0 0 12 8" fill="none">
                                    <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>

                        <div class="sort-dropdown" id="sortDropdown">
                            <div class="sort-option" data-value="mais-nova">Mais nova</div>
                            <div class="sort-option" data-value="mais-antiga">Mais antiga</div>
                            <div class="sort-option" data-value="recentes">Recentes</div>
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
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[10px] p-1 bg-[#E6E6E6] lg:p-[10px] min-h-[80vh] xl:min-h-[88vh] ultra:min-h-[88vh] mt-72 lg:mt-[4.8rem] overflow-auto h-[0vh]">

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
                        <a href="" class="block">
                            <div
                                class="bg-white hover:shadow-md transition relative rounded-md border border-[#DEDEDE]">
                                <div class="badge-container pt-1 px-2" style="position:absolute; min-height: 35px;">

                                </div>
                                <img src="/images/tenis-1.jpg" alt="Tênis"
                                    class="w-full object-contain rounded-md" />
                                <div class="px-4 pt-0 pb-2">
                                    <h2 class="title font-normal font-fko text-[28px] leading-[24px] pb-2"></h2>
                                    <p class="text-sm pb-2">
                                        <span class="categoria text-black "></span> <span
                                            class="codigo text-black opacity-50"></span>
                                    </p>
                                    <div class="float-right mr-[25%]">
                                        <p class="text-black opacity-50 text-xs title-caract-1"></p>
                                        <p class="numeracao text-black text-xs desc-caract-1"></p>
                                    </div>
                                    <p class="text-black opacity-50 text-xs">Cor</p>
                                    <p class="cor text-black text-xs pb-2"></p>

                                    <p class="text-black opacity-50 mt-1 text-xs title-caract-1">PDV</p>
                                    <p class="text-base preco text-black"></p>
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
                        @php
                            $imgPath = '/images/produtos/' . $produtoGroup->product->code . '_' . str_replace('/', '_', $produtoGroup->color_code) . '.jpg';
                            $imgFullPath = public_path($imgPath);
                            $img = file_exists($imgFullPath) ? $imgPath : '/images/img-padrao-oly.png';
                            $produto = $produtoGroup->product;
                            $numeracaoIds = $produto->numeracoes->pluck('id')->toArray();
                            $tamanhoIds = $produto->sizes->pluck('id')->toArray();
                            $precoNumerico = $produto->price;
                            $classificacaoId = $produtoGroup->flagProduct ? $produtoGroup->flagProduct->id : null;
                            $segmentacaoIds = $produtoGroup->segmentacoesCliente->pluck('id')->toArray();
                        @endphp {
                            title: "{{ $produto->name }}",
                            imagem: "{{ $img }}",
                            codigo: "{{ $produto->code }}",
                            'title-caract-1': "{{ $produto->caracteristicasDestaque->first()->title ?? '' }}",
                            'desc-caract-1': "{{ $produto->caracteristicasDestaque->first()->description ?? '' }}",
                            cor: "{{ $produtoGroup->color_name }}",
                            codigo_cor: "{{ str_replace('/', '_', $produtoGroup->color_code) }}",
                            numeracao: "34/44",
                            categoria: "{{ $produto->category->name }}",
                            subcategory_id: "{{ $produto->subcategory_id }}",
                            preco: "R$ {{ $precoNumerico }}",
                            precoNumerico: "R$ {{ $precoNumerico }}",
                            numeracaoIds: @json($numeracaoIds),
                            tamanhoIds: @json($tamanhoIds),
                            classificacaoId: {{ $classificacaoId ?? 'null' }},
                            segmentacaoIds: @json($segmentacaoIds),
                            badge_title: "{{ $produtoGroup->flagProduct->flag_title ?? '' }}",
                            badge_icon: "{{ $produtoGroup->flagProduct->icon ?? '' }}",
                            badge_bg: "{{ $produtoGroup->flagProduct->flag_bg ?? '' }}",
                            badge_color: "{{ $produtoGroup->flagProduct->flag_color_text_bg ?? '' }}",
                            badge_icon_align: "{{ $produtoGroup->flagProduct->alinhamento ?? '' }}",
                            slug: "{{ $produto->slug }}"
                        },
                    @endforeach
                @endif
            ];

            const produtosContainer = document.getElementById("produtos");
            const template = document.getElementById("template-produto");
            const groupCheckbox = document.getElementById("groupColors");

            // Custom dropdown functionality
            let selectedCategory = '';
            let selectedSubcategory = '';

            // Subcategory dropdown elements
            const subcategoryContainer = document.getElementById('subcategoryContainer');
            const subcategorySelectButton = document.getElementById('subcategorySelectButton');
            const subcategoryOptions = document.getElementById('subcategoryOptions');
            const subcategorySelectedText = document.getElementById('subcategorySelectedText');
            const subcategoryArrow = document.getElementById('subcategoryArrow');

            function renderProdutos(produtos, agrupado = false) {

                if (!produtos || produtos.length == 0) {
                    // Mensagem quando não há produtos
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
                    clone.querySelector(".categoria").textContent = produto.categoria;
                    clone.querySelector(".title-caract-1").textContent = produto['title-caract-1'];
                    clone.querySelector(".desc-caract-1").textContent = produto['desc-caract-1'];
                    clone.querySelector(".preco").textContent = produto.preco;

                    const badgeContainer = clone.querySelector(".badge-container");

                    if (produto.badge_title != "") {
                        const badge_icon_align = produto.badge_icon_align;

                        if (produto.badge_icon != "") {
                            // caso tenha ícone, span vira tooltip
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
                            // caso NÃO tenha ícone, mostra badge normal
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



            const searchInput = document.querySelector(
                ".input-estilizado.bg-transparent"
            );
            searchInput.setAttribute("id", "search");

            function filtrarProdutos(termo, categoria = '') {
                return produtosData.filter(
                    (p) => {
                        // Filtro por termo de busca
                        const matchesTermo = p.cor.toLowerCase().includes(termo) ||
                            p.title.toLowerCase().includes(termo) ||
                            p.codigo.toLowerCase().includes(termo);

                        // Filtro por categoria
                        const matchesCategoria = categoria === '' || p.categoria === categoria;

                        // Filtro por subcategoria
                        const matchesSubcategoria = selectedSubcategory === '' || p.subcategory_id == selectedSubcategory;

                        // Filtro por numeração
                        const matchesNumeracao = selectedFilters.numeracao.length === 0 ||
                            selectedFilters.numeracao.some(numId => p.numeracaoIds.includes(parseInt(numId)));

                        // Filtro por tamanho
                        const matchesTamanho = selectedFilters.tamanho.length === 0 ||
                            selectedFilters.tamanho.some(sizeId => p.tamanhoIds.includes(parseInt(sizeId)));

                        // Filtro por classificação
                        const matchesClassificacao = selectedFilters.classification.length === 0 ||
                            (p.classificacaoId && selectedFilters.classification.includes(p.classificacaoId.toString()));

                        // Filtro por segmentações do localStorage
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

                        // Filtro por preço
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
                const termo = searchInput.value.toLowerCase();
                const categoria = selectedCategory;
                const agrupado = groupCheckbox.checked;
                const filtrados = filtrarProdutos(termo, categoria);
                renderProdutos(filtrados, agrupado);
            }

            // Função para carregar subcategorias
            function loadSubcategories(categoryId) {
                if (!categoryId || categoryId === '') {
                    // Ocultar dropdown de subcategorias se nenhuma categoria selecionada
                    subcategoryContainer.style.display = 'none';
                    selectedSubcategory = '';
                    return;
                }

                // Fazer requisição para buscar subcategorias
                fetch(`/user/api/subcategories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Limpar opções existentes
                        subcategoryOptions.innerHTML = '';

                        // Adicionar opção "Todas as subcategorias"
                        const allOption = document.createElement('div');
                        allOption.className = 'option';
                        allOption.setAttribute('data-value', '');
                        allOption.innerHTML = `
                            <div class="option-content">
                                <span>Todas as faixas</span>
                            </div>
                            <i class="fas fa-check check-icon" style="display: none;"></i>
                            <i class="fas fa-times x-icon" style="display: none;"></i>
                        `;
                        subcategoryOptions.appendChild(allOption);

                        // Adicionar subcategorias
                        data.forEach(subcategory => {
                            const option = document.createElement('div');
                            option.className = 'option';
                            option.setAttribute('data-value', subcategory.id);
                            option.innerHTML = `
                                <div class="option-content">
                                    <span>${subcategory.name}</span>
                                </div>
                                <i class="fas fa-check check-icon" style="display: none;"></i>
                                <i class="fas fa-times x-icon" style="display: none;"></i>
                            `;
                            subcategoryOptions.appendChild(option);
                        });

                        // Resetar seleção de subcategoria
                        subcategorySelectedText.textContent = 'Todas as faixas';
                        selectedSubcategory = '';

                        // Mostrar dropdown de subcategorias
                        subcategoryContainer.style.display = 'block';

                        // Aplicar filtros
                        aplicarFiltros();
                    })
                    .catch(error => {
                        console.error('Erro ao carregar subcategorias:', error);
                        subcategoryContainer.style.display = 'none';
                    });
            }

            renderProdutos(produtosData, false);

            // Listener para mudanças no localStorage das segmentações
            window.addEventListener('storage', function(e) {
                if (e.key === 'selectedSegmentacoes') {
                    console.log('Segmentações alteradas no localStorage, reaplicando filtros...');
                    aplicarFiltros();
                }
            });

            // Listener customizado para mudanças na mesma aba
            let originalSetItem = localStorage.setItem;
            localStorage.setItem = function(key, value) {
                originalSetItem.apply(this, arguments);
                if (key === 'selectedSegmentacoes') {
                    console.log('Segmentações alteradas na mesma aba, reaplicando filtros...');
                    aplicarFiltros();
                }
            };

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

            // Subcategory dropdown functions
            function openSubcategoryDropdown() {
                subcategoryOptions.classList.add('show');
                subcategorySelectButton.classList.add('active');
                subcategoryArrow.classList.add('up');
            }

            function closeSubcategoryDropdown() {
                subcategoryOptions.classList.remove('show');
                subcategorySelectButton.classList.remove('active');
                subcategoryArrow.classList.remove('up');
            }

            // Subcategory dropdown event listeners
            subcategorySelectButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = subcategoryOptions.classList.contains('show');

                if (isOpen) {
                    closeSubcategoryDropdown();
                } else {
                    openSubcategoryDropdown();
                }
            });

            subcategoryOptions.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Handle subcategory selection
            subcategoryOptions.addEventListener('click', function(e) {
                // Handle X icon click to remove selection
                if (e.target.classList.contains('x-icon')) {
                    e.stopPropagation();
                    const option = e.target.closest('.option');
                    if (option) {
                        // Remove selection and reset subcategory filter
                        subcategorySelectedText.textContent = 'Todas as subcategorias';
                        selectedSubcategory = '';
                        closeSubcategoryDropdown();
                        aplicarFiltros();
                    }
                    return;
                }

                let option = e.target;

                // Find the option element if clicked on child elements
                if (!option.classList.contains('option')) {
                    option = option.closest('.option');
                }

                if (option && option.classList.contains('option')) {
                    // Remove selected state from all options
                    subcategoryOptions.querySelectorAll('.option').forEach(opt => {
                        opt.classList.remove('selected');
                        opt.querySelector('.check-icon').style.display = 'none';
                        opt.querySelector('.x-icon').style.display = 'none';
                    });

                    // Add selected state to clicked option
                    option.classList.add('selected');
                    option.querySelector('.check-icon').style.display = 'inline';
                    option.querySelector('.x-icon').style.display = 'inline';

                    const value = option.getAttribute('data-value');
                    const text = option.querySelector('.option-content').textContent;
                    subcategorySelectedText.textContent = text;
                    selectedSubcategory = value;
                    closeSubcategoryDropdown();
                    aplicarFiltros();
                }
            });

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

            // Coleção dropdown events
            colecaoSelectButton.addEventListener('click', function(e) {
                e.stopPropagation();
                //console.log(colecaoOptions);
                if (colecaoOptions.classList.contains('show')) {
                    closeColecaoDropdown();
                } else {
                    closeCategoryDropdown();
                    openColecaoDropdown();
                }
            });

            colecaoOptions.addEventListener('click', function(e) {
                // Handle X icon click to remove selection
                if (e.target.classList.contains('x-icon')) {
                    e.stopPropagation();
                    const option = e.target.closest('.option');
                    if (option) {
                        // Remove selection and navigate to products without collection filter
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

                // Find the option element if clicked on child elements
                if (!option.classList.contains('option')) {
                    option = option.closest('.option');
                }

                if (option && option.classList.contains('option')) {
                    // Remove selected state from all options
                    colecaoOptions.querySelectorAll('.option').forEach(opt => {
                        opt.classList.remove('selected');
                        opt.querySelector('.check-icon').style.display = 'none';
                        opt.querySelector('.x-icon').style.display = 'none';
                    });

                    // Add selected state to clicked option
                    option.classList.add('selected');
                    //console.log('opa');
                    option.style.padding = '6px 15px 6px 1px';
                    option.querySelector('.check-icon').style.display = 'inline';
                    option.querySelector('.x-icon').style.display = 'inline';

                    const slug = option.getAttribute('data-slug');
                    const currentUrl = window.location.href;
                    const newUrl = currentUrl.replace(/\/[^/]+$/, "") + '/' + slug;

                    const text = option.querySelector('.option-content').textContent;
                    colecaoSelectedText.textContent = text;
                    closeColecaoDropdown();

                    // Navigate to the selected collection
                    window.location.href = newUrl;
                }
            });

            // Category dropdown events
            categorySelectButton.addEventListener('click', function(e) {
                e.stopPropagation();

                if (categoryOptions.classList.contains('show')) {
                    closeCategoryDropdown();
                } else {
                    closeColecaoDropdown();
                    openCategoryDropdown();
                }
            });

            categoryOptions.addEventListener('click', function(e) {
                // Handle X icon click to remove selection
                if (e.target.classList.contains('x-icon')) {
                    e.stopPropagation();
                    const option = e.target.closest('.option');
                    if (option) {
                        // Remove selection and reset category filter
                        categorySelectedText.textContent = 'Todas as categorias';
                        selectedCategory = '';
                        closeCategoryDropdown();
                        aplicarFiltros();
                    }
                    return;
                }

                let option = e.target;

                // Find the option element if clicked on child elements
                if (!option.classList.contains('option')) {
                    option = option.closest('.option');
                }

                if (option && option.classList.contains('option')) {
                    // Remove selected state from all options
                    categoryOptions.querySelectorAll('.option').forEach(opt => {
                        opt.classList.remove('selected');
                        opt.querySelector('.check-icon').style.display = 'none';
                        opt.querySelector('.x-icon').style.display = 'none';
                    });

                    // Add selected state to clicked option
                    option.classList.add('selected');
                    option.querySelector('.check-icon').style.display = 'inline';
                    option.querySelector('.x-icon').style.display = 'inline';

                    const value = option.getAttribute('data-value');
                    const categoryId = option.getAttribute('data-id');
                    const text = option.querySelector('.option-content').textContent;
                    categorySelectedText.textContent = text;
                    selectedCategory = value;
                    closeCategoryDropdown();

                    // Carregar subcategorias quando categoria for selecionada
                    loadSubcategories(categoryId);

                    aplicarFiltros();
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
            // Toggle dropdown
            filterButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = filterDropdown.classList.contains('show');

                if (isOpen) {
                    closeFilterDropdown();
                } else {
                    openFilterDropdown();
                }
            });

            // Handle filter selection
            filterOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();

                    const type = this.dataset.type;
                    const value = this.dataset.value;

                    if (this.classList.contains('selected')) {
                        // Deselect
                        this.classList.remove('selected');
                        if (Array.isArray(selectedFilters[type])) {
                            selectedFilters[type] = selectedFilters[type].filter(item => item !== value);
                        }

                        // Remove the remove button if it exists
                        const existingRemoveBtn = this.querySelector('.tag-remove');
                        if (existingRemoveBtn) {
                            existingRemoveBtn.remove();
                        }
                    } else {
                        // Select
                        this.classList.add('selected');
                        if (Array.isArray(selectedFilters[type]) && !selectedFilters[type].includes(value)) {
                            selectedFilters[type].push(value);
                        }

                        // Add remove button to the selected item
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

            // Add event listeners for price filters
            const priceMinInput = document.getElementById('price-min');
            const priceMaxInput = document.getElementById('price-max');

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

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                    closeFilterDropdown();
                }
            });

            // Prevent dropdown from closing when clicking inside
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
                        filterCount.textContent = totalSelected + ' seleção';
                    } else {
                        filterCount.textContent = totalSelected + ' seleções';
                    }

                    filterCount.style.display = 'inline';
                } else {
                    filterText.textContent = 'Filtrar';
                    filterCount.style.display = 'none';
                }

                // Aplicar filtros sempre que houver mudança
                aplicarFiltros();
            }

            function removeFilter(type, value) {
                // Remove from selectedFilters
                if (Array.isArray(selectedFilters[type])) {
                    selectedFilters[type] = selectedFilters[type].filter(item => item !== value);
                } else {
                    selectedFilters[type] = null;
                }

                // Update UI - remove selected class from dropdown option
                const option = document.querySelector(`.filter-option[data-type="${type}"][data-value="${value}"]`);
                if (option) {
                    option.classList.remove('selected');

                    // Remove the remove button from the dropdown option
                    const existingRemoveBtn = option.querySelector('.tag-remove');
                    if (existingRemoveBtn) {
                        existingRemoveBtn.remove();
                    }
                }

                updateFilterCount();
            }

            // Sort dropdown functionality
            const sortButton = document.getElementById('sortButton');
            const sortText = document.getElementById('sortText');
            const sortArrow = document.getElementById('sortArrow');
            const sortDropdown = document.getElementById('sortDropdown');
            const sortOptions = document.querySelectorAll('.sort-option');

            let selectedSortValue = 'mais-nova';

            // Toggle sort dropdown
            sortButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = sortDropdown.classList.contains('show');

                if (isOpen) {
                    closeSortDropdown();
                } else {
                    openSortDropdown();
                }
            });

            // Handle sort selection
            sortOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();

                    // Remove selected class from all options
                    sortOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Update selected text
                    sortText.textContent = this.textContent;

                    // Update selected value
                    selectedSortValue = this.getAttribute('data-value');

                    // Apply sorting (you can implement the sorting logic here)
                    applySorting(selectedSortValue);

                    // Close dropdown
                    closeSortDropdown();
                });
            });

            // Close sort dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!sortButton.contains(event.target) && !sortDropdown.contains(event.target)) {
                    closeSortDropdown();
                }
            });

            // Prevent dropdown from closing when clicking inside
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
                // Obter produtos filtrados atuais
                const termo = searchInput.value.toLowerCase();
                const categoria = selectedCategory;
                const produtosFiltrados = filtrarProdutos(termo, categoria);
                let sortedProdutos = [...produtosFiltrados];

                switch (sortValue) {
                    case 'mais-nova':
                        // Ordenar por mais novo (por código do produto)
                        sortedProdutos.sort((a, b) => b.codigo.localeCompare(a.codigo));
                        break;
                    case 'mais-antiga':
                        // Ordenar por mais antigo (por código do produto)
                        sortedProdutos.sort((a, b) => a.codigo.localeCompare(b.codigo));
                        break;
                    case 'recentes':
                        // Ordenar por recentes (por código do produto - descendente)
                        sortedProdutos.sort((a, b) => b.codigo.localeCompare(a.codigo));
                        break;
                    case 'ultima-atualizacao':
                        // Ordenar por última atualização (por código do produto - descendente)
                        sortedProdutos.sort((a, b) => b.codigo.localeCompare(a.codigo));
                        break;
                    case 'maior-valor':
                        // Ordenar por maior preço
                        sortedProdutos.sort((a, b) => b.precoNumerico - a.precoNumerico);
                        break;
                    case 'menor-valor':
                        // Ordenar por menor preço
                        sortedProdutos.sort((a, b) => a.precoNumerico - b.precoNumerico);
                        break;
                    case 'a-z':
                        // Ordenar por nome A-Z
                        sortedProdutos.sort((a, b) => a.title.localeCompare(b.title));
                        break;
                    case 'z-a':
                        // Ordenar por nome Z-A
                        sortedProdutos.sort((a, b) => b.title.localeCompare(a.title));
                        break;
                    default:
                        // Ordenação padrão
                        break;
                }

                const agrupado = groupCheckbox.checked;
                renderProdutos(sortedProdutos, agrupado);
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                closeColecaoDropdown();
                closeCategoryDropdown();
                closeSubcategoryDropdown();
                closeFilterDropdown();
                closeSortDropdown();
            });

            // Event listeners for filters
            searchInput.addEventListener("input", aplicarFiltros);
            groupCheckbox.addEventListener("change", aplicarFiltros);

            // Inicializar produtos na página
            aplicarFiltros();
        </script>
    @endpush

</x-layout-user>
