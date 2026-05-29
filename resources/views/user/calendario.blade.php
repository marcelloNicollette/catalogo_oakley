<x-layout-user title="Oakley - Calendário">
    <style>
        .options {
            width: 200px;
            max-width: none;
        }

        .check-icon {
            color: #000;
            font-weight: bold;
            font-size: 16px;
            width: 16px;
            text-align: center;
        }

        .option {
            padding: 1px 20px;
            border-bottom: 0;
        }

        .option.selected {
            padding: 1px 0px;
        }

        .height-ultra {
            height: calc(100vh - 85px);
        }
    </style>
    <main class="lg:flex flex-1">
        <!-- Menu lateral -->
        <x-sidebar activeItem="calendario" />

        <!-- Conteúdo principal -->
        <section class="flex-1 flex flex-col md:pr-0 md:pb-0 overflow-hidden">

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
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pt-4 pb-3 pr-4 bg-white">
                <!-- Esquerda: fitro ano -->
                <div class="flex gap-2">

                    <div class="select-container">
                        <div class="select-button p-5" id="selectButton">
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


                        <div class="options  p-5" id="options">

                            @foreach ($anos as $ano)
                                <div class="option gap-[10px] text-[18px] font-normal opacity-50"
                                    data-value="{{ $ano }}">
                                    <span class="check-icon" style="display: none;"><svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                            <path
                                                d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                        </svg></span>
                                    <span class="option-content text-black">
                                        {{ $ano }}
                                    </span>
                                    <span class="x-icon" style="display: none;">×</span>
                                </div>
                            @endforeach
                            <div class="option" data-categoria-id="" data-value="">
                                <span class="check-icon" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 640">
                                        <path
                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                    </svg></span>
                                <span class="text-[16px] text-black font-normal option-content">Todas</span>
                                <span class="x-icon" style="display: none;">×</span>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Direita: Busca -->
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


                </div>
            </div>

            <!-- Lista de Produtos -->
            <div id="calendario"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-1 bg-white lg:p-[3.125rem] rounded-tl-lg overflow-auto height-ultra custom-scrollbar">
                <!-- Template de Produto -->
                <template id="template-produto">

                    <div class="bg-white pb-4 shadow-sm hover:shadow-md transition rounded mb-12">

                        <img src="/images/tenis-1.jpg" alt="Tênis" class="w-full object-contain rounded" />
                        <div class="px-4">
                            <h2
                                class="notranslate title font-normal font-fko text-[24px] leading-[26px] py-3 uppercase min-h-[3vh]">
                            </h2>
                            <p class="text-black text-xs pb-3">
                                <span class="categoria text-black"></span>
                                <span class="codigo text-black opacity-50"></span>
                            </p>
                            <section class="grid grid-cols-2">
                                <div class="pb-2" id="data">
                                    <p class="text-black opacity-50 text-xs title-caract-1">Data</p>
                                    <p class="data text-black text-xs desc-caract-1"></p>
                                </div>
                                <div class="pb-2" id="data_mkt">
                                    <p class="text-black opacity-50 text-xs title-caract-1">Data Mkt</p>
                                    <p class="dt_mkt text-black text-xs desc-caract-1"></p>
                                </div>
                                <div class="pb-2" id="data_trade">
                                    <p class="text-black opacity-50 text-xs title-caract-1">Data Trade</p>
                                    <p class="dt_trade text-black text-xs desc-caract-1"></p>
                                </div>
                                <div class="pb-2" id="data_cliente">
                                    <p class="text-black opacity-50 text-xs title-caract-1">Data Cliente</p>
                                    <p class="dt_cliente text-black text-xs desc-caract-1"></p>
                                </div>
                                <div class="pb-2" id="data_dtc">
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
                        data: "{{ $produtoGroup->data != null ? $produtoGroup->data->format('d/m/Y') : '' }}",
                        data_mkt: "{{ $produtoGroup->data_mkt != null ? $produtoGroup->data_mkt->format('d/m/Y') : '' }}",
                        data_trade: "{{ $produtoGroup->data_trade != null ? $produtoGroup->data_trade->format('d/m/Y') : '' }}",
                        data_cliente: "{{ $produtoGroup->data_cliente != null ? $produtoGroup->data_cliente->format('d/m/Y') : '' }}",
                        data_dtc: "{{ $produtoGroup->data_dtc != null ? $produtoGroup->data_dtc->format('d/m/Y') : '' }}",
                        ano: "{{ $produtoGroup->ano != null ? $produtoGroup->ano : date('Y') }}",
                        mes: "{{ $produtoGroup->mes != null ? $produtoGroup->mes : date('m') }}",
                    },
                @endforeach
            ];

            const produtosContainer = document.getElementById("produtos");
            const template = document.getElementById("template-produto");
            const groupCheckbox = document.getElementById("groupColors");

            // Declarar selectedYear antes de usar
            let selectedYear = '{{ $calendarios->count() != 0 ? $calendarios->first()->ano : date('Y') }}';

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
                    if (produto.data != '') {
                        clone.querySelector(".data").textContent = produto.data;
                    } else {
                        clone.querySelector("#data").style.display = 'none';
                    }
                    if (produto.data_mkt != '') {
                        clone.querySelector(".dt_mkt").textContent = produto.data_mkt;
                    } else {
                        clone.querySelector("#data_mkt").style.display = 'none';
                    }
                    if (produto.data_trade != '') {
                        clone.querySelector(".dt_trade").textContent = produto.data_trade;
                    } else {
                        clone.querySelector("#data_trade").style.display = 'none';
                    }
                    if (produto.data_cliente != '') {
                        clone.querySelector(".dt_cliente").textContent = produto.data_cliente;
                    } else {
                        clone.querySelector("#data_cliente").style.display = 'none';
                    }
                    if (produto.data_dtc != '') {
                        clone.querySelector(".dt_dtc").textContent = produto.data_dtc;
                    } else {
                        clone.querySelector("#data_dtc").style.display = 'none';
                    }

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

            selectOptions.addEventListener('click', function(e) {
                // Handle X icon click to remove selection
                if (e.target.classList.contains('x-icon')) {
                    e.stopPropagation();
                    const option = e.target.closest('.option');
                    if (option) {
                        // Remove selection and reset category filter
                        selectButton.querySelector('span').textContent = 'Ano';
                        selectedCategoryId = '';
                        // Atualizar ano selecionado
                        selectedYear = "";

                        // Fechar dropdown
                        closeDropdown();

                        // Aplicar filtro
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
                    e.stopPropagation();

                    // Remove selected state from all options
                    selectOptions.querySelectorAll('.option').forEach(opt => {
                        opt.classList.remove('selected');
                        opt.classList.add('opacity-50');
                        opt.querySelector('.check-icon').style.display = 'none';
                        opt.querySelector('.x-icon').style.display = 'none';
                    });

                    // Add selected state to clicked option
                    option.classList.add('selected');
                    option.classList.remove('opacity-50');
                    option.querySelector('.check-icon').style.display = 'inline-table';
                    option.querySelector('.x-icon').style.display = 'inline-table';

                    const value = option.getAttribute('data-value');
                    const text = option.querySelector('.option-content') ? option.querySelector(
                        '.option-content').textContent : option.textContent;
                    selectButton.querySelector('span').innerHTML =
                        "Ano: <span style='font-size:18px; color:#7A7A7A;'>" +
                        text + "</span>";
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
