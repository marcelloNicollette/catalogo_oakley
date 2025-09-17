<x-layout-user title="Olympikus - Favoritos">
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
                top: 25%;
                left: -150%;
                transform: translateX(-50%);
                transition: opacity 0.3s;
                white-space: nowrap;
            }

            .badge-icon-wrapper:hover .badge-tooltip {
                visibility: visible;
                opacity: 1;
            }

            .price-range {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px;
            }

            .price-range input {
                flex: 1;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 14px;
            }

            .price-range input:focus {
                outline: none;
                border-color: #007bff;
            }

            .price-separator {
                color: #666;
                font-weight: bold;
            }

            .option {
                padding: 8px 16px;
                font-size: 14px;
                color: #999;
                cursor: pointer;
                border-bottom: 0;
                transition: all 0.2s ease;
            }
        </style>

        <!-- Menu lateral -->
        <x-sidebar activeItem="favoritos" />


        <!-- Conteúdo principal -->
        <section class="flex-1 flex flex-col md:pr-0 md:pb-0 overflow-hidden">
            @php

                $currentUrl = request()->path();
                $currentUrlComplete = request()->path();
                $currentSlug = '';

                //dd($currentSlug);

            @endphp
            <!-- Filtros superiores -->
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pt-4 pb-3 px-4  bg-[#F1F1F1] z-50">
                <!-- Esquerda: Coleção e Categoria -->
                <div class="flex gap-2">
                    <div class="select-container" style="width: 225px;">
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
                            <div class="option" data-slug="" data-value="">
                                <span class="check-icon" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 640">
                                        <path
                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                    </svg></span>
                                <span class="option-content">Selecione uma coleção</span>
                                <span class="x-icon" style="display: none;">×</span>
                            </div>
                            @foreach ($colecoes as $colecao)
                                <div class="option text-[18px]" data-slug="{{ $colecao->slug }}"
                                    data-value="{{ $colecao->slug }}"
                                    {{ $currentSlug == $colecao->slug ? 'selected' : '' }}>
                                    <span class="check-icon"
                                        style="display: {{ $currentSlug == $colecao->slug ? 'inline' : 'none' }};"><svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                            <path
                                                d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                        </svg></span>
                                    <span class="option-content">
                                        {{ $colecao->codigo_colecao }} -
                                        <span style="font-size: 14px;">{{ ucwords(strtolower($colecao->name)) }}</span>
                                    </span>
                                    <span class="x-icon"
                                        style="display: {{ $currentSlug == $colecao->slug ? 'inline' : 'none' }};">×</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="select-container" style="width: 205px;">
                        <div class="select-button" id="categorySelectButton">
                            <span id="categorySelectedText">Todas as categorias</span>
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
                            <div class="option" data-value="" selected>
                                <span class="check-icon" style="display: inline;"><svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                        <path
                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                    </svg></span>
                                <span class="option-content">Todas as categorias</span>
                                <span class="x-icon" style="display: inline;">×</span>
                            </div>
                            @foreach ($categories as $category)
                                <div class="option" data-value="{{ $category->name }}">
                                    <span class="check-icon" style="display: none;"><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                            <path
                                                d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                        </svg></span>
                                    <span class="option-content">{{ $category->name }}</span>
                                    <span class="x-icon" style="display: none;">×</span>
                                </div>
                            @endforeach
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
                        <input id="groupColors" type="checkbox" class="form-checkbox text-white rounded" />
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

                        <div class="filter-dropdown" id="filterDropdown">
                            <div class="filter-section">
                                <label class="filter-label">Numeração</label>
                                <div class="filter-options" id="yearOptions">
                                    @foreach ($numeracao as $num)
                                        <div class="filter-option" data-type="year"
                                            data-value="{{ $num->id }}">
                                            {{ $num->numero }}</div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="filter-section">
                                <label class="filter-label">Tamanho</label>
                                <div class="filter-options" id="sizeOptions">
                                    @foreach ($tamanhos as $size)
                                        <div class="filter-option" data-type="size"
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
                                    <span class="text-sm pt-2">de</span>
                                    <input style="width: 30%;" class="filter-option" type="text"
                                        data-type="price" data-range="min" value="" placeholder="0">
                                    <span class="text-sm pt-2">até</span>
                                    <input style="width: 30%;" class="filter-option" type="text"
                                        data-type="price" data-range="max" value="" placeholder="1000">
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
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-3 ml-4 p-2 bg-[#E6E6E6] h-[76vh] lg:h-[65vh] xl:h-[76vh] rounded-xl overflow-auto">

                <!-- Template de Produto -->
                <template id="template-produto">
                    <!--<a href="" class="block">-->
                    <div
                        class="bg-white shadow-sm hover:shadow-md transition relative rounded-md h-[60vh] lg:h-[75vh] xl:h-[60vh]">
                        <div class="badge-container pt-1 px-2" style="position:absolute; min-height: 35px;">

                        </div>
                        <!-- Botão de Favoritos -->
                        <div class="absolute top-2 right-2 z-10">
                            <button class="favoriteBtn text-black hover:text-black transition-colors"
                                data-product-id="" data-color-code="">
                                <!-- Ícone Outline (vazio) -->
                                <svg class="iconOutline w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
                                    width="18" height="16" viewBox="0 0 18 16" fill="none">
                                    <path
                                        d="M0 5.26362C0 8.97604 3.23565 12.6275 8.34743 15.7647C8.53776 15.878 8.80967 16 9 16C9.19033 16 9.46224 15.878 9.66163 15.7647C14.7644 12.6275 18 8.97604 18 5.26362C18 2.17865 15.7976 0 12.861 0C11.1843 0 9.82477 0.766885 9 1.94336C8.19335 0.775599 6.81571 0 5.13897 0C2.20242 0 0 2.17865 0 5.26362ZM1.45921 5.26362C1.45921 2.94553 3.01813 1.40305 5.12085 1.40305C6.82477 1.40305 7.80363 2.42266 8.38369 3.29412C8.6284 3.6427 8.78248 3.73856 9 3.73856C9.21752 3.73856 9.35347 3.63399 9.61631 3.29412C10.2417 2.44009 11.1843 1.40305 12.8792 1.40305C14.9819 1.40305 16.5408 2.94553 16.5408 5.26362C16.5408 8.50545 12.9789 12 9.19033 14.4227C9.0997 14.4837 9.03625 14.5272 9 14.5272C8.96375 14.5272 8.9003 14.4837 8.81873 14.4227C5.02115 12 1.45921 8.50545 1.45921 5.26362Z"
                                        fill="black" />
                                </svg>
                                <!-- Ícone Preenchido (solid) -->
                                <svg class="iconFilled w-5 h-5 text-black" xmlns="http://www.w3.org/2000/svg"
                                    width="18" height="16" viewBox="0 0 18 16" fill="none">
                                    <path
                                        d="M0 5.26362C0 8.97604 3.23565 12.6275 8.34743 15.7647C8.53776 15.878 8.80967 16 9 16C9.19033 16 9.46224 15.878 9.66163 15.7647C14.7643 12.6275 18 8.97604 18 5.26362C18 2.17865 15.7976 0 12.861 0C11.1843 0 9.82477 0.766885 9 1.94336C8.19335 0.775599 6.81571 0 5.13897 0C2.20242 0 0 2.17865 0 5.26362Z"
                                        fill="black" />
                                </svg>
                            </button>
                        </div>
                        <img src="/images/tenis-1.jpg" alt="Tênis" class="w-full object-contain rounded-md" />
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

                            <p class="text-black opacity-50 mt-1 text-xs title-caract-1">Coleção</p>
                            <p class="text-base collection text-black"></p>

                            <p class="text-black opacity-50 mt-1 text-xs title-caract-1">PDV</p>
                            <p class="text-base preco text-black"></p>
                        </div>
                    </div>
                    <!--</a>-->
                </template>
            </div>


        </section>


    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const produtosData = [
                    @foreach ($produtos as $produto)
                        @php

                            $img = '/images/produtos/' . $produto->product->code . '_' . str_replace('/', '_', $produto->color_code) . '.jpg';
                        @endphp {
                            id: "{{ $produto->product->id }}",
                            color_code: "{{ $produto->color_code }}",
                            title: "{{ $produto->product->name }}",
                            imagem: "{{ $img }}",
                            codigo: "{{ $produto->product->code }}",
                            'title-caract-1': "{{ $produto->product->caracteristicasDestaque->first()->title ?? '' }}",
                            'desc-caract-1': "{{ $produto->product->caracteristicasDestaque->first()->description ?? '' }}",
                            cor: "{{ $produto->color->color_name }}",
                            numeracao: "34/44",
                            categoria: "{{ $produto->product->category->name }}",
                            preco: "R${{ number_format($produto->product->price, 2, ',', '.') }}",
                            slug: "{{ $produto->product->slug }}",
                            collection: "{{ $produto->color->collection->codigo_colecao }}"
                        },
                    @endforeach
                ];

                const produtosContainer = document.getElementById("produtos");
                const template = document.getElementById("template-produto");
                const groupCheckbox = document.getElementById("groupColors");

                function renderProdutos(produtos, agrupado = false) {
                    produtosContainer.innerHTML = "";
                    let listaParaRenderizar = [];

                    if (agrupado) {
                        const produtosPorCor = {};
                        produtos.forEach((p) => {
                            if (!produtosPorCor[p.cor]) {
                                produtosPorCor[p.cor] = p;
                            }
                        });
                        listaParaRenderizar = Object.values(produtosPorCor);
                    } else {
                        listaParaRenderizar = produtos;
                    }

                    listaParaRenderizar.forEach((produto) => {
                        const clone = template.content.cloneNode(true);

                        // Adicionar classe product-card ao div principal
                        const productDiv = clone.querySelector('div');
                        if (productDiv) {
                            productDiv.classList.add('product-card');
                        }

                        //const link = clone.querySelector("a");
                        //link.href = `{{ $currentSlug }}/${produto.slug}`;
                        clone.querySelector("img").src = produto.imagem;
                        clone.querySelector("h2").textContent = produto.title;
                        clone.querySelector(".codigo").textContent = produto.codigo;
                        clone.querySelector(".cor").textContent = produto.cor;
                        clone.querySelector(".collection").textContent = produto.collection;
                        clone.querySelector(".categoria").textContent = produto.categoria;
                        clone.querySelector(".title-caract-1").textContent = produto['title-caract-1'];
                        clone.querySelector(".desc-caract-1").textContent = produto['desc-caract-1'];
                        clone.querySelector(".preco").textContent = produto.preco;

                        // Configurar botão de favoritos
                        const favoriteBtn = clone.querySelector('.favoriteBtn');
                        if (favoriteBtn && produto.id && produto.color_code) {
                            favoriteBtn.setAttribute('data-product-id', produto.id);
                            favoriteBtn.setAttribute('data-color-code', produto.color_code);
                        }


                        produtosContainer.appendChild(clone);
                    });

                    // Configurar event listeners para botões de favoritos após renderização
                    setupFavoriteButtons();
                }

                // Função para configurar os event listeners dos botões de favoritos
                function setupFavoriteButtons() {
                    const favoriteButtons = document.querySelectorAll('.favoriteBtn');

                    favoriteButtons.forEach(button => {
                        // Remove event listeners anteriores para evitar duplicação
                        button.replaceWith(button.cloneNode(true));
                    });

                    // Reseleciona os botões após a clonagem
                    const newFavoriteButtons = document.querySelectorAll('.favoriteBtn');

                    newFavoriteButtons.forEach(button => {
                        const productId = button.getAttribute('data-product-id');
                        const colorCode = button.getAttribute('data-color-code');

                        if (productId && colorCode) {
                            // Verificar status inicial da wishlist
                            checkWishlistStatus(button, productId, colorCode);

                            // Adicionar event listener
                            button.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();

                                const iconOutline = button.querySelector('.iconOutline');
                                const iconFilled = button.querySelector('.iconFilled');
                                const isFavorited = iconFilled.classList.contains('hidden');
                                console.log('clique ativo');
                                if (isFavorited) {
                                    addToWishlist(button, productId, colorCode);
                                } else {
                                    removeFromWishlist(button, productId, colorCode);
                                }
                            });
                        }
                    });
                }

                // Função para adicionar à wishlist
                function addToWishlist(button, productId, colorCode) {
                    fetch('{{ route('user.wishlist.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                color_code: colorCode
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const iconOutline = button.querySelector('.iconOutline');
                                const iconFilled = button.querySelector('.iconFilled');

                                iconFilled.classList.remove('hidden');
                                iconOutline.classList.add('hidden');
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao adicionar aos favoritos:', error);
                        });
                }

                // Função para remover da wishlist
                function removeFromWishlist(button, productId, colorCode) {
                    fetch('{{ route('user.wishlist.remove') }}', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                color_code: colorCode
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Recarregar a página para mostrar apenas os produtos que estão no banco
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao remover dos favoritos:', error);
                        });
                }

                // Função para verificar status da wishlist
                function checkWishlistStatus(button, productId, colorCode) {
                    // Na página da wishlist, todos os produtos devem aparecer como favoritos por padrão
                    const iconOutline = button.querySelector('.iconOutline');
                    const iconFilled = button.querySelector('.iconFilled');

                    // Definir estado inicial como favorito (ícone preenchido)
                    iconFilled.classList.remove('hidden');
                    iconOutline.classList.add('hidden');

                    // Verificar status real da wishlist
                    fetch(`{{ route('user.wishlist.check') }}?product_id=${productId}&color_code=${colorCode}`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Se não estiver favoritado, remover da página (opcional)
                            // ou manter como favorito já que estamos na página de wishlist
                            if (!data.is_favorited) {
                                // Produto não está mais na wishlist, mas mantemos o ícone preenchido
                                // pois estamos na página de favoritos
                                iconFilled.classList.remove('hidden');
                                iconOutline.classList.add('hidden');
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao verificar status da wishlist:', error);
                            // Em caso de erro, manter como favorito
                            iconFilled.classList.remove('hidden');
                            iconOutline.classList.add('hidden');
                        });
                }

                // Custom dropdown functionality
                let selectedCategory = '';
                let selectedCollection = '';

                const searchInput = document.querySelector(
                    ".input-estilizado.bg-transparent"
                );
                searchInput.setAttribute("id", "search");

                function filtrarProdutos(termo, categoria = '', colecao = '') {
                    return produtosData.filter(
                        (p) => {
                            const matchesTermo = p.cor.toLowerCase().includes(termo) ||
                                p.title.toLowerCase().includes(termo);
                            const matchesCategoria = categoria === '' || p.categoria === categoria;
                            const matchesColecao = colecao === '' || p.collection === colecao;

                            // Aplicar filtros avançados
                            const matchesFilters = aplicarFiltrosAvancados(p);

                            return matchesTermo && matchesCategoria && matchesColecao && matchesFilters;
                        }
                    );
                }

                function aplicarFiltrosAvancados(produto) {
                    // Filtro de numeração (year)
                    if (selectedFilters.year.length > 0) {
                        // Assumindo que o produto tem informação de numeração
                        // Como não temos essa info no produto, vamos pular por enquanto
                    }

                    // Filtro de tamanho
                    if (selectedFilters.size.length > 0) {
                        // Assumindo que o produto tem informação de tamanho
                        // Como não temos essa info no produto, vamos pular por enquanto
                    }

                    // Filtro de classificação
                    if (selectedFilters.classification.length > 0) {
                        // Assumindo que o produto tem informação de classificação
                        // Como não temos essa info no produto, vamos pular por enquanto
                    }

                    // Filtro de preço
                    if (selectedFilters.price.min !== '' || selectedFilters.price.max !== '') {
                        const preco = parseFloat(produto.preco.replace('R$', '').replace('.', '').replace(',', '.'));
                        const min = selectedFilters.price.min !== '' ? parseFloat(selectedFilters.price.min) : 0;
                        const max = selectedFilters.price.max !== '' ? parseFloat(selectedFilters.price.max) : Infinity;

                        if (preco < min || preco > max) {
                            return false;
                        }
                    }

                    return true;
                }

                function filtrarColecoes() {
                    // Esta função era chamada mas não existia
                    // Agora vamos aplicar os filtros aos produtos
                    aplicarFiltros();
                }

                function aplicarFiltros() {
                    const termo = searchInput.value.toLowerCase();
                    const categoria = selectedCategory;
                    const colecao = selectedCollection;
                    const agrupado = groupCheckbox.checked;
                    const filtrados = filtrarProdutos(termo, categoria, colecao);
                    renderProdutos(filtrados, agrupado);
                    // Configurar botões de favoritos após re-renderização
                    setupFavoriteButtons();
                }

                renderProdutos(produtosData, false);
                // Configurar botões de favoritos na renderização inicial
                setupFavoriteButtons();

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
                    console.log(colecaoOptions);
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
                            // Remove selection and reset collection filter
                            colecaoSelectedText.textContent = 'Selecione uma coleção';
                            selectedCollection = '';
                            closeColecaoDropdown();
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
                        colecaoOptions.querySelectorAll('.option').forEach(opt => {
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
                        colecaoSelectedText.textContent = text;
                        selectedCollection = value;
                        closeColecaoDropdown();

                        // Apply filters instead of navigating
                        aplicarFiltros();
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
                            categorySelectedText.textContent = 'Selecione uma categoria';
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
                        const text = option.querySelector('.option-content').textContent;
                        categorySelectedText.textContent = text;
                        selectedCategory = value;
                        closeCategoryDropdown();
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
                    year: [],
                    size: [],
                    classification: [],
                    price: {
                        min: '',
                        max: ''
                    }
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

                        // Handle price inputs differently
                        if (type === 'price') {
                            return; // Price inputs are handled by input events
                        }

                        if (this.classList.contains('selected')) {
                            // Deselect
                            this.classList.remove('selected');
                            if (selectedFilters[type] && Array.isArray(selectedFilters[type])) {
                                selectedFilters[type] = selectedFilters[type].filter(item => item !==
                                    value);
                            }

                            // Remove the remove button if it exists
                            const existingRemoveBtn = this.querySelector('.tag-remove');
                            if (existingRemoveBtn) {
                                existingRemoveBtn.remove();
                            }
                        } else {
                            // Select
                            this.classList.add('selected');
                            if (selectedFilters[type] && Array.isArray(selectedFilters[type]) && !
                                selectedFilters[
                                    type].includes(value)) {
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

                // Handle price input changes
                const priceInputs = document.querySelectorAll('input[data-type="price"]');
                priceInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        const range = this.dataset.range;
                        selectedFilters.price[range] = this.value;
                        updateFilterCount();
                    });
                });

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
                    const totalSelected = selectedFilters.year.length +
                        selectedFilters.size.length +
                        selectedFilters.classification.length +
                        (selectedFilters.price.min !== '' || selectedFilters.price.max !== '' ? 1 : 0);

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
                    filtrarColecoes();
                }

                function removeFilter(type, value) {
                    // Remove from selectedFilters
                    if (selectedFilters[type] && Array.isArray(selectedFilters[type])) {
                        selectedFilters[type] = selectedFilters[type].filter(item => item !== value);
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
                    // Implement sorting logic based on sortValue
                    let sortedColecoes = [...colecoesFiltered];

                    switch (sortValue) {
                        case 'mais-nova':
                            // Sort by newest (assuming there's a created_at or similar field)
                            sortedColecoes.sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));
                            break;
                        case 'mais-antiga':
                            // Sort by oldest
                            sortedColecoes.sort((a, b) => new Date(a.created_at || 0) - new Date(b.created_at || 0));
                            break;
                        case 'recentes':
                            // Sort by recent updates (assuming there's an updated_at field)
                            sortedColecoes.sort((a, b) => new Date(b.updated_at || 0) - new Date(a.updated_at || 0));
                            break;
                        case 'ultima-atualizacao':
                            // Sort by last update
                            sortedColecoes.sort((a, b) => new Date(b.updated_at || 0) - new Date(a.updated_at || 0));
                            break;
                        default:
                            // Default sorting
                            break;
                    }

                    // Re-aplicar filtros após ordenação
                    aplicarFiltros();
                }

                // Close dropdowns when clicking outside
                document.addEventListener('click', function() {
                    closeColecaoDropdown();
                    closeCategoryDropdown();
                    closeFilterDropdown();
                    closeSortDropdown();
                });

                // Event listeners for filters
                searchInput.addEventListener("input", aplicarFiltros);
                groupCheckbox.addEventListener("change", aplicarFiltros);
            });
        </script>
    @endpush

</x-layout-user>
