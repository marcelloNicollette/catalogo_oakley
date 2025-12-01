<x-layout-user title="Under Armour - Coleções">
    <style>
        .height-ultra {
            height: calc(100vh - 168px);
        }

        @media (max-width: 768px) {

            .colecao-card {
                height: 30vh;
            }
        }

        @media (min-width: 768px) {

            .colecao-card {
                height: 30vh;
            }
        }

        @media (min-width: 1080px) {

            .colecao-card {
                height: 20vh;
            }
        }


        @media (min-width: 1280px) {

            .colecao-card {
                height: 35vh;
            }
        }

        @media (min-width: 2566px) {

            .colecao-card {
                height: 28vh;
            }
        }

        @media (min-width: 3000px) {


            .colecao-card {
                height: 25vh;
            }
        }

        .select-button:hover,
        .select-button:focus,
        .select-button:active,
        .select-button.active {
            border-color: transparent;
        }

        /* Para Firefox */
        .custom-scrollbar {
            scrollbar-width: thin;
            /* auto, thin, none */
            scrollbar-color: #A9A9A9 #000000;
            /* thumb track */
        }
    </style>
    <main class="lg:flex flex-1">
        <!-- Menu lateral -->
        <x-sidebar activeItem="colecoes" />

        <!-- Conteúdo principal -->
        <section class="flex-1 flex flex-col overflow-hidden">

            <!-- Filtros superiores -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pt-4 pb-3 pr-4">
                <!-- Esquerda: Coleção e Categoria -->
                <div class="flex gap-2">

                    <div class="select-container">
                        <div class="select-button p-5" id="colecaoSelectButton">
                            <span class="text-[16px] text-black">Selecione uma coleção</span>
                            <span class="text-[18px] text-[#7A7A7A]" id="colecaoSelectedText">
                                @if (!empty($currentSlug))
                                    @foreach ($colecoes as $colecao)
                                        @if ($currentSlug == $colecao->slug)
                                            {{ $colecao->name }}
                                        @endif
                                    @endforeach
                                @else
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
                                    data-value="{{ $colecao->slug }}" style="">
                                    <span class="check-icon" style="display: none;"><svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                            <path
                                                d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                        </svg></span>
                                    <span class="option-content" style="">
                                        {{ $colecao->name }}
                                    </span>
                                    <span class="x-icon" style="display: none;">×</span>
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
                        <input id="buscar" type="text" placeholder="Buscar"
                            class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
                    </div>

                    <div class="filter-container">
                        <div class="filter-button" id="filterButton">
                            <span id="filterText">Filtrar</span>
                            <span id="filterCount" class="filter-count"
                                style="display: none; margin-left:10px; color: #7A7A7A;">0</span>
                            <div class="pl-2 pt-1" id="arrow2">
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid de Coleções -->
            <div class="bg-[#000000] p-[10px] rounded-tl-lg height-ultra overflow-auto custom-scrollbar">
                <div id="colecoes-grid"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-[10px]"
                    style="border-radius: 10px 0 0 0;">
                    <!-- Cards serão renderizados via JavaScript -->
                </div>
            </div>


            <!-- Template para os cards de coleções -->
            <template id="template-colecoes">
                <div class="colecao-card relative rounded overflow-hidden cursor-pointer hover:border hover:border-[#999]"
                    data-codigo="" data-name="" data-description="" data-slug="">
                    <div class="overlay absolute inset-0 bg-black bg-opacity-40 " style="display: none;"></div>
                    <div
                        class="absolute inset-0 flex flex-col justify-center items-center text-white p-6 gap-10 mt-10">
                        <h2 class="mb-2 codigo font-segmento neue-plak-extended"></h2>
                        <p class="text-lg opacity-90 description uppercase"></p>
                    </div>
                </div>
            </template>



            </div>

        </section>


    </main>

    @push('scripts')
        <script>
            // Dados das coleções vindos do backend
            const colecoes = @json($colecoes);
            let colecoesFiltered = [...colecoes];

            // Elementos DOM
            const grid = document.getElementById('colecoes-grid');
            const template = document.getElementById('template-colecoes');
            const searchInput = document.querySelector('input[id="buscar"]');
            // Dropdown de Coleção (igual ao de produtos)
            const colecaoSelectButton = document.getElementById('colecaoSelectButton');
            const colecaoSelectedText = document.getElementById('colecaoSelectedText');
            const colecaoArrow = document.getElementById('colecaoArrow');
            const colecaoOptions = document.getElementById('colecaoOptions');

            function openColecaoDropdown() {
                colecaoOptions.classList.add('show');
                colecaoArrow.classList.add('up');
            }

            function closeColecaoDropdown() {
                colecaoOptions.classList.remove('show');
                colecaoArrow.classList.remove('up');
            }

            // Função para renderizar as coleções
            function renderColecoes(colecoesToRender = colecoesFiltered) {
                grid.innerHTML = '';

                // Renderizar coleções existentes
                colecoesToRender.forEach(colecao => {
                    const clone = template.content.cloneNode(true);
                    const card = clone.querySelector('.colecao-card');
                    const overlay = clone.querySelector('.overlay');
                    const codigo = clone.querySelector('.codigo');
                    const description = clone.querySelector('.description');

                    // Definir dados do card
                    card.setAttribute('data-codigo', colecao.codigo_colecao);
                    card.setAttribute('data-slug', colecao.slug);
                    card.setAttribute('data-name', colecao.name);
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

                    // Adicionar evento de clique
                    card.addEventListener('click', () => {
                        // Redirecionar para a URL atual com o slug no final
                        const slug = card.getAttribute('data-slug');
                        const currentUrl = window.location.href;
                        const newUrl = currentUrl.endsWith('/') ? currentUrl + slug : currentUrl + '/' + slug;
                        window.location.href = newUrl;
                    });

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
                        card.style.backgroundColor = '#CFCFCF';
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
                    const matchSelect = true;

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
            colecaoSelectButton.addEventListener('click', function(e) {
                e.stopPropagation();
                if (colecaoOptions.classList.contains('show')) {
                    closeColecaoDropdown();
                } else {
                    openColecaoDropdown();
                }
            });

            // Handle selection and navigation
            colecaoOptions.addEventListener('click', function(e) {
                // Handle X icon click to remove selection
                if (e.target.classList.contains('x-icon')) {
                    e.stopPropagation();
                    const option = e.target.closest('.option');
                    if (option) {
                        colecaoSelectedText.textContent = '';
                        closeColecaoDropdown();
                    }
                    return;
                }

                let option = e.target;
                if (!option.classList.contains('option')) {
                    option = option.closest('.option');
                }

                if (option && option.classList.contains('option')) {
                    // Reset visual state
                    colecaoOptions.querySelectorAll('.option').forEach(opt => {
                        opt.classList.remove('selected');
                        const checkIcon = opt.querySelector('.check-icon');
                        const xIcon = opt.querySelector('.x-icon');
                        if (checkIcon) checkIcon.style.display = 'none';
                        if (xIcon) xIcon.style.display = 'none';
                    });

                    // Apply selected state
                    option.classList.add('selected');
                    const xIcon = option.querySelector('.x-icon');
                    if (xIcon) xIcon.style.display = 'inline';

                    const slug = option.getAttribute('data-slug');
                    const text = option.querySelector('.option-content').textContent;
                    //colecaoSelectedText.textContent = text;
                    closeColecaoDropdown();

                    // Build URL: from /user/{slug}/colecoes -> /user/{slug}/colecoes/{slug}
                    const currentUrl = window.location.href.replace(/\/$/, '');
                    const newUrl = currentUrl + (slug ? '/' + slug : '');
                    window.location.href = newUrl;
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!colecaoSelectButton.contains(event.target) && !colecaoOptions.contains(event.target)) {
                    closeColecaoDropdown();
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
                classification: []
            };

            // Toggle dropdown
            filterButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = filterDropdown.classList.contains('show');

                if (isOpen) {
                    closeFilterDropdown();
                } else {
                    closeSortDropdown();
                    closeColecaoDropdown()
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


            (function initDefaultSortSelection() {
                const optionToSelect = Array.from(sortOptions).find(opt => opt.getAttribute('data-value') ===
                    selectedSortValue);
                if (optionToSelect) {
                    sortOptions.forEach(opt => opt.classList.remove('selected'));
                    optionToSelect.classList.add('selected');
                    sortText.textContent = optionToSelect.textContent;
                }
            })();

            // Toggle sort dropdown
            sortButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = sortDropdown.classList.contains('show');

                if (isOpen) {
                    closeSortDropdown();
                } else {
                    closeFilterDropdown();
                    closeColecaoDropdown()
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

                renderColecoes(sortedColecoes);
            }

            // Close dropdown with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeColecaoDropdown();
                    closeFilterDropdown();
                    closeSortDropdown();
                }
            });


            // Renderização inicial
            document.addEventListener('DOMContentLoaded', () => {
                renderColecoes();
            });
        </script>
    @endpush

</x-layout-user>
