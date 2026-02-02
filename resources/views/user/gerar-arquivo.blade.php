<x-layout-user title="Under Armour - Gerar Arquivo">
    <style>
        .height-ultra {
            height: calc(100vh - 168px);
        }

        @media (min-width: 1280px) {
            .grid-colecao-gerar {
                height: 77vh;
            }

            .colecao-card {
                height: 35vh;
            }
        }

        @media (min-width: 1366px) {
            .grid-colecao-gerar {
                height: 79vh;
            }

            .colecao-card {
                height: 35vh;
            }
        }

        @media (min-width: 1470px) {
            .grid-colecao-gerar {
                height: 79vh;
            }
        }

        @media (min-width: 2566px) {
            .grid-colecao-gerar {
                height: 88vh;
            }


            .colecao-card {
                height: 28vh;
            }
        }

        @media (min-width: 3000px) {
            .grid-colecao-gerar {
                height: 91vh;
            }


            .colecao-card {
                height: 25vh;
            }
        }

        .option {
            padding: 8px 16px;
            cursor: pointer;
            border-bottom: 0;
            transition: all 0.2s ease;
        }

        .select-estilizado,
        .input-estilizado {
            border: 0px;
        }
    </style>
    <main class="lg:flex flex-1">
        <!-- Menu lateral -->
        <x-sidebar activeItem="gerar-arquivo" />

        <!-- Conteúdo principal -->
        <section class="flex-1 flex flex-col md:pr-0 md:pb-0 overflow-hidden">
            <!-- Filtros superiores -->
            <div
                class="flex flex-col md:flex-row justify-between items-end md:items-end gap-4 pt-4 pb-3 pr-4 bg-[#F1F1F1]">
                <!-- Esquerda: Coleção e Categoria -->
                <div class="flex gap-2">

                    <div class="select-container">
                        <div class="select-button p-5" id="selectButton">
                            <span class="text-[16px] text-black" id="colecaoSelectedTitle">Selecione uma coleção</span>

                            <div class="pl-[5px]" id="arrow">
                                <div class="pt-1" id="arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                        viewBox="0 0 12 8" fill="none">
                                        <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="options min-w-[200px] p-5" id="options">
                            @foreach ($colecoes as $colecao)
                                <div class="option text-[18px]" data-value="{{ $colecao->slug }}">
                                    {{ $colecao->name }}</span>
                                </div>
                            @endforeach
                            <div class="option text-black" data-value="todas">Todas</div>
                        </div>
                    </div>

                    <button id="openHistoryModal"
                        class="flex items-center justify-center bg-[#e7e7e7] rounded-lg px-5 py-2 border-[#e7e7e7] border hover:border-black hover:border">
                        <span class="text-base pr-2">Histórico</span> <img
                            src="{{ asset('/images/icones/historico.svg') }}" alt="Histórico" class="w-5 h-5">
                    </button>
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

                    <div class="filter-container">
                        <div class="filter-button" id="filterButton">
                            <span id="filterText">Filtrar</span>
                            <span id="filterCount" class="filter-count"
                                style="display: none; margin-left:5px; color: #7A7A7A;">0</span>
                            <div class="pl-[5px] pt-1" id="arrow2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8"
                                    fill="none">
                                    <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>

                        <div class="filter-dropdown" id="filterDropdown">
                            <div class="filter-section">
                                <label class="filter-label">Ano</label>
                                <div class="filter-options" id="yearOptions">
                                    @foreach ($years as $year)
                                        <div class="filter-option" data-type="year" data-value="{{ $year }}">
                                            {{ $year }}</div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="filter-section">
                                <label class="filter-label">Classificação</label>
                                <div class="filter-options classification-options" id="classificationOptions">
                                    <div class="filter-option" data-type="classification" data-value="oportunidades">
                                        Oportunidades</div>
                                    <div class="filter-option" data-type="classification" data-value="exclusivo">
                                        Exclusivo Sapatarias</div>
                                    <div class="filter-option" data-type="classification" data-value="familia">Família
                                        Corre</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sort-container">
                        <div class="sort-button" id="sortButton">
                            <span class="text-black mr-[5px]">Ordenar por:</span>
                            <span id="sortText" class="text-[#7A7A7A]">Mais nova</span>
                            <div class="pl-[5px] pt-1" id="sortArrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8"
                                    fill="none">
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
                        </div>
                    </div>
                </div>
            </div>


            <!-- Grid de Coleções -->
            <div class="bg-[#000000] p-[10px] rounded-tl-lg overflow-auto height-ultra custom-scrollbar">
                <div id="colecoes-grid"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-[10px]"
                    style="border-radius: 10px 0 0 0;">
                    <!-- Cards serão renderizados via JavaScript -->
                </div>
            </div>


            <!-- Template para os cards de coleções -->
            <template id="template-colecoes">
                <div class="colecao-card relative rounded overflow-hidden cursor-pointer hover:border hover:border-[#999]"
                    data-codigo="" data-name="" data-description="" data-slug="" data-segmentacao-id=""
                    onclick="openHistoryModalWithCollection(this.dataset.name, this)">
                    <div class="overlay absolute inset-0 bg-black bg-opacity-40 " style="display: none;"></div>
                    <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-6">
                        <h2 class="mb-2 codigo font-segmento neue-plak-extended"></h2>
                        <p class="text-lg opacity-90 description uppercase absolute bottom-6"></p>
                    </div>
                </div>
            </template>

            <x-gerar-arquivo-modal />

            <x-history-modal />

            </div>

        </section>


    </main>

    @push('scripts')
        <script>
            // Dados das coleções vindos do backend
            const colecoes = @json($colecoes);
            let colecoesFiltered = [...colecoes];
            //console.log(colecoesFiltered);
            // Dados das categorias do backend
            const categorias = @json($categorias ?? []);
            //console.log(categorias);

            // Elementos DOM
            const grid = document.getElementById('colecoes-grid');
            const template = document.getElementById('template-colecoes');
            const searchInput = document.querySelector('input[placeholder="Buscar"]');
            const selectButton = document.getElementById('selectButton');
            const selectedText = document.getElementById('selectedText');
            const arrow = document.getElementById('arrow');
            const options = document.getElementById('options');
            const optionElements = document.querySelectorAll('.option');

            // Variável para armazenar o valor selecionado
            let selectedColecaoValue = '';


            function removerFormatacao(texto) {
                return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[\s.]/g, "-");
            }

            // Função para renderizar as coleções
            function renderColecoes(colecoesToRender = colecoesFiltered) {
                grid.innerHTML = '';

                colecoesToRender.forEach(colecao => {
                    const clone = template.content.cloneNode(true);
                    const card = clone.querySelector('.colecao-card');
                    const overlay = clone.querySelector('.overlay');
                    const codigo = clone.querySelector('.codigo');
                    const title = clone.querySelector('.title');
                    const description = clone.querySelector('.description');
                    const formattedDescription = colecao.description;


                    const currentDate = new Date();
                    const formattedDateTime = currentDate.toISOString().slice(0, 19).replace(/[T:-]/g, '').slice(0, 12);
                    const newSlug = colecao.slug + '-' + formattedDateTime;

                    // Definir dados do card
                    card.setAttribute('data-id', colecao.id);
                    card.setAttribute('data-codigo', colecao.codigo_colecao);
                    card.setAttribute('data-slug', colecao.slug);
                    card.setAttribute('data-segmentacao-id', colecao.segmentacao_id);
                    card.setAttribute('data-name', newSlug);
                    card.setAttribute('data-title', colecao.name);
                    card.setAttribute('data-description', colecao.description || '');

                    // Definir estilo de fundo
                    if (colecao.bg_color && !colecao.image) {
                        card.style.backgroundColor = colecao.bg_color;
                    } else if (colecao.image) {
                        card.style.backgroundImage = `url('/${colecao.image}')`;
                        card.style.backgroundSize = 'cover';
                        card.style.backgroundPosition = 'center';
                        overlay.style.display = 'block';
                    }

                    // Preencher conteúdo
                    codigo.textContent = colecao.codigo_colecao;
                    description.textContent = colecao.description || '';

                    grid.appendChild(clone);

                });

                // Verificar se há menos de 12 registros e criar boxes vazios
                const totalRegistros = colecoesToRender.length;
                if (totalRegistros < 12) {
                    const boxesVazios = 12 - totalRegistros;

                    for (let i = 0; i < boxesVazios; i++) {
                        const clone = template.content.cloneNode(true);
                        const card = clone.querySelector('.colecao-card');
                        const overlay = clone.querySelector('.overlay');
                        const codigo = clone.querySelector('.codigo');
                        const description = clone.querySelector('.description');

                        // Configurar box vazio
                        card.style.backgroundColor = '#4A4A4A';
                        card.style.backgroundImage = 'none';
                        overlay.style.display = 'none';

                        // Remover conteúdo
                        codigo.textContent = '';
                        description.textContent = '';

                        // Remover evento de clique
                        card.style.cursor = 'default';

                        grid.appendChild(clone);
                    }
                }
            }

            // Função de busca
            function filtrarColecoes() {
                const searchTerm = searchInput.value.toLowerCase();

                colecoesFiltered = colecoes.filter(colecao => {
                    const matchSearch = !searchTerm ||
                        colecao.name.toLowerCase().includes(searchTerm) ||
                        colecao.codigo_colecao.toLowerCase().includes(searchTerm) ||
                        (colecao.description && colecao.description.toLowerCase().includes(searchTerm));

                    const matchSelect = !selectedColecaoValue || selectedColecaoValue === '' || selectedColecaoValue ===
                        'todas' ||
                        colecao.slug === selectedColecaoValue;

                    // Filtro por ano baseado no created_at
                    const matchYear = selectedFilters.year.length === 0 ||
                        selectedFilters.year.includes(new Date(colecao.created_at).getFullYear().toString());

                    // Filtro por classificação (pode ser implementado futuramente)
                    const matchClassification = selectedFilters.classification.length === 0;

                    return matchSearch && matchSelect && matchYear && matchClassification;
                });

                renderColecoes();
            }

            // Event listeners
            if (searchInput) {
                searchInput.addEventListener('input', filtrarColecoes);
            }

            // Toggle dropdown
            selectButton.addEventListener('click', function() {
                const isOpen = options.classList.contains('show');

                if (isOpen) {
                    closeSelectDropdown();
                } else {
                    openSelectDropdown();
                }
            });

            // Select option
            optionElements.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    optionElements.forEach(opt => opt.classList.remove('selected'));

                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Update selected text
                    document.getElementById('colecaoSelectedTitle').textContent = "Coleção: " + this
                        .textContent;
                    selectedText.textContent = this.textContent;

                    // Update selected value for filtering
                    selectedColecaoValue = this.getAttribute('data-value');

                    // Apply filter
                    filtrarColecoes();

                    // Close dropdown
                    closeSelectDropdown();
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!selectButton.contains(event.target) && !options.contains(event.target)) {
                    closeSelectDropdown();
                }
            });

            function openSelectDropdown() {
                options.classList.add('show');
                selectButton.classList.add('active');
                arrow.classList.add('up');
            }

            function closeSelectDropdown() {
                options.classList.remove('show');
                selectButton.classList.remove('active');
                arrow.classList.remove('up');
            }


            const filterButton = document.getElementById('filterButton');
            const filterText = document.getElementById('filterText');
            const filterCount = document.getElementById('filterCount');
            const arrow2 = document.getElementById('arrow2');
            const filterDropdown = document.getElementById('filterDropdown');
            const filterOptions = document.querySelectorAll('.filter-option');

            let selectedFilters = {
                year: [],
                classification: []
            };

            // Toggle dropdown
            filterButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = filterDropdown.classList.contains('show');

                if (isOpen) {
                    closeFilterDropdown();
                    closeSortDropdown();
                    closeSelectDropdown();
                } else {
                    openFilterDropdown();
                    closeSortDropdown();
                    closeSelectDropdown();
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
                        selectedFilters[type] = selectedFilters[type].filter(item => item !== value);

                        // Remove the remove button if it exists
                        const existingRemoveBtn = this.querySelector('.tag-remove');
                        if (existingRemoveBtn) {
                            existingRemoveBtn.remove();
                        }
                    } else {
                        // Select
                        this.classList.add('selected');
                        if (!selectedFilters[type].includes(value)) {
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

            function getDisplayText(type, value) {
                if (type === 'year') {
                    return value;
                } else if (type === 'classification') {
                    switch (value) {
                        case 'oportunidades':
                            return 'Oportunidades';
                        case 'exclusivo':
                            return 'Exclusivo Sapatarias';
                        case 'familia':
                            return 'Família Corre';
                        default:
                            return value;
                    }
                }
                return value;
            }

            function updateFilterCount() {
                const totalSelected = selectedFilters.year.length + selectedFilters.classification.length;

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
                selectedFilters[type] = selectedFilters[type].filter(item => item !== value);

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
                    closeFilterDropdown();
                    closeSelectDropdown();
                } else {
                    openSortDropdown();
                    closeFilterDropdown();
                    closeSelectDropdown();
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

                renderColecoes(sortedColecoes);
            }

            // Close dropdown with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeSelectDropdown();
                    closeFilterDropdown();
                    closeSortDropdown();
                }
            });


            // Renderização inicial
            document.addEventListener('DOMContentLoaded', () => {
                renderColecoes();
            });



            // Funcionalidade do Modal de Histórico
            const historyModal = document.getElementById("historyModal");
            const openHistoryModal = document.getElementById(
                "openHistoryModal"
            );

            // Abrir modal de histórico
            openHistoryModal.addEventListener("click", () => {
                historyModal.classList.remove("hidden");
            });
        </script>
    @endpush

</x-layout-user>
