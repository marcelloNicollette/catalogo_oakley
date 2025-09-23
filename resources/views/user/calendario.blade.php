<x-layout-user title="Olympikus - Segmentação">
    <style>
        .select-container {
            position: relative;
            width: 150px;
            margin: 0 auto;
        }

        .option {
            padding: 8px 16px;
            font-size: 18px;
            color: #000;
            cursor: pointer;
            border-bottom: 0;
            transition: all 0.2s ease;
        }

        @media (min-width: 1280px) {

            #produtos {
                min-height: 79vh;
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
    <main class="lg:flex flex-1">
        <!-- Menu lateral -->
        <x-sidebar activeItem="calendario" />

        <!-- Conteúdo principal -->
        <section class="flex-1 flex flex-col p-4 md:pt-0 md:pr-0 md:pl-4 md:pb-0 overflow-hidden">
            @php

                $currentUrl = request()->path();
                $currentUrlComplete = request()->path();
                $currentSlug = '';

                if (strpos($currentUrl, 'user') === 0) {
                    $parts = explode('/', $currentUrl);
                    //dd($parts);
                    if (count($parts) > 1) {
                        $currentSlug = $parts[1];
                    }
                }

            @endphp
            <!-- Filtros superiores -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pt-4 pb-3 pr-4">
                <!-- Esquerda: fitro ano -->
                <div class="flex gap-2">
                    <div class="select-container">
                        <div class="select-button" id="selectButton">
                            <span id="selectedText">Ano</span>
                            <div class="" id="arrow">
                                <div class="pt-1" id="arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                        viewBox="0 0 12 8" fill="none">
                                        <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="options" id="options">
                            @foreach ($anos as $ano)
                                <div class="option text-[18px]" data-value="{{ $ano }}"
                                    {{ $calendarios->first()->ano == $ano ? 'data-selected="true"' : '' }}>
                                    {{ $ano }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Direita: Busca -->
                <div class="flex flex-wrap gap-2 items-end justify-end mt-6">
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


                </div>
            </div>

            <!-- Lista de Produtos -->
            <div id="produtos"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-1 bg-[#E6E6E6] lg:p-[3.125rem] rounded-xl overflow-auto lg:h-[75vh] xl:h-[79vh] 2xl:h-[78vh] 3xl:h-[80vh]">
                <!-- Template de Produto -->
                <template id="template-produto">

                    <div class="bg-white pb-4 shadow-sm hover:shadow-md transition rounded mb-12">

                        <img src="/images/tenis-1.jpg" alt="Tênis" class="w-full object-contain rounded" />
                        <div class="px-4">
                            <h2
                                class="title font-normal font-fko text-[24px] leading-[26px] py-3 uppercase min-h-[3vh]">
                            </h2>
                            <p class="text-black text-xs pb-3">
                                <span class="categoria text-black"></span>
                                <span class="codigo text-black opacity-50"></span>
                            </p>
                            <section class="grid grid-cols-2">
                                <div class="pb-2">
                                    <p class="text-black opacity-50 text-xs title-caract-1">Data Mkt</p>
                                    <p class="dt_mkt text-black text-xs desc-caract-1"></p>
                                </div>
                                <div class="pb-2">
                                    <p class="text-black opacity-50 text-xs title-caract-1">Data Trade</p>
                                    <p class="dt_trade text-black text-xs desc-caract-1"></p>
                                </div>
                                <div class="">
                                    <p class="text-black opacity-50 text-xs title-caract-1">Data Cliente</p>
                                    <p class="dt_cliente text-black text-xs desc-caract-1"></p>
                                </div>
                                <div class="">
                                    <p class="text-black opacity-50 text-xs title-caract-1">Data DTC</p>
                                    <p class="dt_dtc text-black text-xs desc-caract-1"></p>
                                </div>
                            </section>
                        </div>
                    </div>

                </template>
            </div>


        </section>


    </main>

    @push('scripts')
        <script>
            const produtosData = [
                @foreach ($calendarios as $produtoGroup)
                    @if ($produtoGroup->img != null)
                        @php $img = asset('storage/' . $produtoGroup->img); @endphp
                    @else
                        @php $img = "/images/produtos/".$produtoGroup->product->code."_".str_replace('/', '_', $produtoGroup->product->colors->first()->color_code).".jpg"; @endphp
                    @endif {
                        title: {!! json_encode($produtoGroup->title) !!},
                        imagem: "{{ $img }}",
                        info1: {!! json_encode($produtoGroup->info_1) !!},
                        info2: {!! json_encode($produtoGroup->info_2) !!},
                        data: "{{ $produtoGroup->data->format('d/m/Y') }}",
                        data_mkt: "{{ $produtoGroup->data_mkt->format('d/m/Y') }}",
                        data_trade: "{{ $produtoGroup->data_trade->format('d/m/Y') }}",
                        data_cliente: "{{ $produtoGroup->data_cliente->format('d/m/Y') }}",
                        data_dtc: "{{ $produtoGroup->data_dtc->format('d/m/Y') }}",
                        ano: "{{ $produtoGroup->ano }}",
                        mes: "{{ $produtoGroup->mes }}",
                    },
                @endforeach
            ];

            const produtosContainer = document.getElementById("produtos");
            const template = document.getElementById("template-produto");
            const groupCheckbox = document.getElementById("groupColors");

            // Declarar selectedYear antes de usar
            let selectedYear = '{{ $calendarios->first()->ano }}';

            function renderProdutos(produtos, agrupado = false) {
                produtosContainer.innerHTML = "";
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

                // Ordenar produtos por mês (decrescente)
                listaParaRenderizar.sort((a, b) => parseInt(b.mes) - parseInt(a.mes));

                const mesesNomes = {
                    1: 'JANEIRO',
                    2: 'FEVEREIRO',
                    3: 'MARÇO',
                    4: 'ABRIL',
                    5: 'MAIO',
                    6: 'JUNHO',
                    7: 'JULHO',
                    8: 'AGOSTO',
                    9: 'SETEMBRO',
                    10: 'OUTUBRO',
                    11: 'NOVEMBRO',
                    12: 'DEZEMBRO'
                };

                let mesAnterior = null;

                listaParaRenderizar.forEach((produto) => {
                    // Adicionar título do mês se for diferente do anterior
                    if (produto.mes !== mesAnterior) {
                        const tituloMes = document.createElement('h2');
                        tituloMes.className =
                            'text-black text-[38px] font-fko font-normal mes col-span-full leading-[26px]';
                        tituloMes.textContent = mesesNomes[parseInt(produto.mes)] || 'MÊS DESCONHECIDO';
                        produtosContainer.appendChild(tituloMes);
                        mesAnterior = produto.mes;
                    }

                    const clone = template.content.cloneNode(true);

                    clone.querySelector("img").src = produto.imagem;
                    clone.querySelector("h2").textContent = produto.title;
                    clone.querySelector(".codigo").textContent = produto.info2;
                    clone.querySelector(".categoria").textContent = produto.info1;
                    clone.querySelector(".dt_mkt").textContent = produto.data_mkt;
                    clone.querySelector(".dt_trade").textContent = produto.data_trade;
                    clone.querySelector(".dt_cliente").textContent = produto.data_cliente;
                    clone.querySelector(".dt_dtc").textContent = produto.data_dtc;

                    produtosContainer.appendChild(clone);
                });
            }

            // Aplicar filtro inicial baseado no ano selecionado
            const produtosFiltradosIniciais = selectedYear ?
                produtosData.filter(p => p.ano === selectedYear) :
                produtosData;
            renderProdutos(produtosFiltradosIniciais, false);

            const searchInput = document.querySelector(
                ".input-estilizado.bg-transparent"
            );
            searchInput.setAttribute("id", "search");

            function filtrarProdutos(termo, ano = '') {
                return produtosData.filter(
                    (p) => {
                        const matchesTermo = p.title.toLowerCase().includes(termo) ||
                            p.info1.toLowerCase().includes(termo) ||
                            p.info2.toLowerCase().includes(termo);
                        const matchesAno = ano === '' || p.ano === ano;
                        return matchesTermo && matchesAno;
                    }
                );
            }

            // Select customizado
            const selectContainer = document.querySelector('.select-container');
            const selectButton = selectContainer.querySelector('.select-button');
            const selectOptions = selectContainer.querySelector('.options');
            const selectArrow = selectContainer.querySelector('#arrow');

            // Definir texto inicial do botão
            selectButton.querySelector('span').innerHTML = 'Ano: <span class="opacity-50">' + selectedYear + '</span>';

            // Função para abrir/fechar dropdown
            function toggleDropdown() {
                const isOpen = selectOptions.classList.contains('show');
                if (isOpen) {
                    selectOptions.classList.remove('show');
                    selectArrow.classList.remove('up');
                } else {
                    selectOptions.classList.add('show');
                    selectArrow.classList.add('up');
                }
            }

            // Função para fechar dropdown
            function closeDropdown() {
                selectOptions.classList.remove('show');
                selectArrow.classList.remove('up');
            }

            function aplicarFiltros() {
                const termo = searchInput.value.toLowerCase();
                const ano = selectedYear;
                const agrupado = groupCheckbox ? groupCheckbox.checked : false;
                const filtrados = filtrarProdutos(termo, ano);
                renderProdutos(filtrados, agrupado);
            }

            // Event listeners para o select customizado
            selectButton.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleDropdown();
            });

            // Event listener para as opções
            selectOptions.addEventListener('click', function(e) {
                const option = e.target.closest('.option');
                if (option) {
                    e.stopPropagation();

                    // Atualizar texto do botão
                    selectButton.querySelector('span').innerHTML = 'Ano: <span class="opacity-50">' + option
                        .textContent + '</span>';

                    // Atualizar ano selecionado
                    selectedYear = option.getAttribute('data-value');

                    // Fechar dropdown
                    closeDropdown();

                    // Aplicar filtro
                    aplicarFiltros();
                }
            });

            // Fechar dropdown ao clicar fora
            document.addEventListener('click', function(e) {
                if (!selectContainer.contains(e.target)) {
                    closeDropdown();
                }
            });

            searchInput.addEventListener("input", aplicarFiltros);
        </script>
    @endpush

</x-layout-user>
