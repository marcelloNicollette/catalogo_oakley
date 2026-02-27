<x-layout-user title="Olympikus - Produtos">
    <main class="lg:flex flex-1 produtos-page">
        <style>
            /* Container do card com altura mínima fixa */
            .bg-white.hover\:shadow-md {
                min-height: 450px;
                /* Ajuste este valor conforme necessário */
                display: flex;
                flex-direction: column;
            }

            /* Título com altura fixa e ellipsis para overflow */
            .title {
                display: -webkit-box;
                -webkit-line-clamp: 4;
                /* Limita a 3 linhas */
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;

                /* 3 linhas × ~18px por linha */

                line-height: 25px;
            }

            /* Alternativa: Se preferir que todos tenham exatamente a mesma altura */
            .title.fixed-height {
                height: 54px;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                line-height: 18px;
            }

            /* Garante que o conteúdo inferior fique alinhado */
            .p-4.flex-1.flex.flex-col {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            /* Container de imagem com altura fixa */
            .bg-white img {
                /* Ajuste conforme necessário */
                object-fit: contain;
            }

            /* Grid com 4 colunas fixas e altura uniforme */
            #produtos {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                /* Sempre 4 colunas iguais */
                gap: 10px;
                grid-auto-rows: min-content;
                /* Todas as linhas com mesma altura */
            }

            /* Garante que o link ocupe toda a célula do grid */
            #produtos>a {
                display: flex;
                flex-direction: column;
                height: auto;
            }

            /* Card ocupa todo o espaço disponível */
            #produtos>a>div {
                flex: 1;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            /* Responsivo: 2 colunas em tablets */
            @media (max-width: 1024px) {
                #produtos {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            /* Responsivo: 1 coluna em mobile */
            @media (max-width: 640px) {
                #produtos {
                    grid-template-columns: repeat(1, 1fr);
                }
            }

            .badge-icon-wrapper .badge-tooltip {
                visibility: hidden;
                opacity: 0;
                background-color: #fff;
                color: #000;
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
                height: calc(100vh - 85px);
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
            }

            .category-option.expanded .subcategory-dropdown {
                display: block;
            }

            .subcategory-option {
                padding: 0 0 0 25px;
                cursor: pointer;
                transition: background-color 0.2s;
                display: flex;
                align-items: center;
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
                padding: 0 3px;
            }

            .subcategory-option .check-icon {
                width: 14px;
                height: 14px;
                fill: currentColor;
                display: none;
                margin-right: 8px;
            }

            .subcategory-option .x-icon {
                margin-left: 8px;
                font-size: 18px;
                color: #999;
                display: none;
            }

            .subcategory-option.selected .check-icon {
                display: inline-table;
            }


            .options {
                max-height: 500px;
                border: 1px solid #DDD;
            }

            /* Adicione estas regras ao seu css.css */

            /* Container esquerdo (Coleção + Categoria) - flexível */
            .filters-left-section {
                display: flex;
                gap: 0.5rem;
                flex: 1;
                min-width: 0;
            }

            /* Container direito (Busca + Filtros + Ordenar) - largura fixa */
            .filters-right-section {
                display: flex;
                gap: 0.5rem;
                align-items: flex-end;
                flex-shrink: 0;
            }

            /* Select de coleção - largura mínima fixa */
            .select-container {
                flex-shrink: 0;
                min-width: fit-content;
            }

            /* Wrapper do category - ocupa espaço restante */
            .category-select-wrapper {
                flex: 1;
                min-width: 150px;
                /* Largura mínima antes de quebrar */
            }

            /* O botão de categoria ocupa 100% do wrapper */
            #categorySelectButton {
                width: 100% !important;
                max-width: fit-content !important;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            /* Texto truncado com ellipsis */
            #categorySelectedText {
                flex: 1;
                text-overflow: ellipsis;
                overflow: hidden;
                white-space: nowrap;
                min-width: 0;
            }

            /* Arrow mantém seu tamanho fixo */
            #categoryArrow {
                flex-shrink: 0;
            }

            /* Responsivo para telas menores */
            @media (max-width: 1400px) {
                .filters-right-section {
                    width: auto;
                    flex-wrap: wrap;
                }
            }

            @media (max-width: 768px) {
                .filters-left-section {
                    flex-direction: column;
                    width: 100%;
                }

                .category-select-wrapper {
                    width: 100%;
                }

                .filters-right-section {
                    width: 100%;
                    flex-direction: column;
                    align-items: stretch;
                }
            }


            /* Botão de filtro mobile - visível apenas em mobile */
            .mobile-filter-trigger {
                display: none;
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: #000;
                color: #fff;
                border: none;
                border-radius: 50px;
                padding: 16px 24px;
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                z-index: 999;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
                align-items: center;
                gap: 8px;
            }

            @media (max-width: 1200px) {
                .fixed {
                    display: none;
                }

                .mobile-filter-trigger {
                    display: flex;
                }

                /* Esconde os filtros desktop em mobile */
                .filters-desktop {
                    display: none !important;
                }
            }

            /* Overlay do menu mobile */
            .mobile-filter-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .mobile-filter-overlay.active {
                display: block;
                opacity: 1;
            }

            /* Menu lateral mobile */
            .mobile-filter-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 85%;
                max-width: 400px;
                height: 100vh;
                background: #fff;
                z-index: 1001;
                transition: right 0.3s ease;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
            }

            .mobile-filter-menu.active {
                right: 0;
            }

            /* Header do menu mobile */
            .mobile-filter-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px;
                border-bottom: 1px solid #e0e0e0;
                background: #f8f8f8;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .mobile-filter-header h2 {
                font-size: 20px;
                font-weight: 500;
                color: #000;
            }

            .mobile-filter-close {
                background: none;
                border: none;
                font-size: 28px;
                color: #666;
                cursor: pointer;
                padding: 0;
                width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Conteúdo do menu mobile */
            .mobile-filter-content {
                flex: 1;
                padding: 20px;
                overflow-y: auto;
            }

            /* Seção de filtro mobile */
            .mobile-filter-section {
                margin-bottom: 24px;
                padding-bottom: 24px;
                border-bottom: 1px solid #e0e0e0;
            }

            .mobile-filter-section:last-child {
                border-bottom: none;
            }

            .mobile-filter-section-title {
                font-size: 16px;
                font-weight: 500;
                color: #000;
                margin-bottom: 12px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .mobile-filter-section-title .clear-btn {
                font-size: 14px;
                color: #666;
                background: none;
                border: none;
                cursor: pointer;
                text-decoration: underline;
            }

            /* Select mobile personalizado */
            .mobile-select {
                width: 100%;
                padding: 14px;
                background: #f5f5f5;
                border: 1px solid #ddd;
                border-radius: 8px;
                font-size: 16px;
                color: #000;
                cursor: pointer;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .mobile-select-text {
                flex: 1;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .mobile-select-arrow {
                margin-left: 8px;
                transition: transform 0.3s;
            }

            .mobile-select.active .mobile-select-arrow {
                transform: rotate(180deg);
            }

            /* Opções do select mobile */
            .mobile-select-options {
                display: none;
                margin-top: 8px;
                background: #f5f5f5;
                border-radius: 8px;
                overflow: hidden;
            }

            .mobile-select-options.active {
                display: block;
            }

            .mobile-select-option {
                padding: 14px;
                border-bottom: 1px solid #e0e0e0;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .mobile-select-option:last-child {
                border-bottom: none;
            }

            .mobile-select-option.selected {
                background: #fff;
                font-weight: 500;
            }

            /* Chips de filtro mobile */
            .mobile-filter-chips {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .mobile-filter-chip {
                padding: 8px 16px;
                background: #f5f5f5;
                border: 1px solid #ddd;
                border-radius: 20px;
                font-size: 14px;
                color: #333;
                cursor: pointer;
                transition: all 0.2s;
            }

            .mobile-filter-chip.selected {
                background: #000;
                color: #fff;
                border-color: #000;
            }

            /* Input de busca mobile */
            .mobile-search-input {
                width: 100%;
                padding: 14px;
                background: #f5f5f5;
                border: 1px solid #ddd;
                border-radius: 8px;
                font-size: 16px;
                color: #000;
            }

            .mobile-search-input:focus {
                outline: none;
                border-color: #000;
            }

            /* Footer do menu mobile */
            .mobile-filter-footer {
                padding: 16px 20px;
                border-top: 1px solid #e0e0e0;
                background: #f8f8f8;
                display: flex;
                gap: 12px;
                position: sticky;
                bottom: 0;
            }

            .mobile-filter-footer button {
                flex: 1;
                padding: 14px;
                border: none;
                border-radius: 8px;
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
            }

            .mobile-filter-clear {
                background: #fff;
                color: #000;
                border: 1px solid #ddd;
            }

            .mobile-filter-apply {
                background: #000;
                color: #fff;
            }

            /* Badge de contagem */
            .filter-badge {
                background: #000;
                color: #fff;
                border-radius: 50%;
                width: 24px;
                height: 24px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                margin-left: 8px;
            }

            /* Subcategorias no mobile */
            .mobile-subcategory-list {
                display: none;
                margin-top: 8px;
                padding-left: 16px;
            }

            .mobile-subcategory-list.active {
                display: block;
            }

            .mobile-subcategory-item {
                padding: 10px 0;
                color: #666;
                cursor: pointer;
                font-size: 15px;
            }

            .mobile-subcategory-item.selected {
                color: #000;
                font-weight: 500;
            }

            /* Checkbox personalizado */
            .mobile-checkbox-wrapper {
                display: flex;
                align-items: center;
                padding: 12px 0;
            }

            .mobile-checkbox {
                width: 20px;
                height: 20px;
                border: 2px solid #7A7A7A;
                border-radius: 4px;
                margin-right: 12px;
                cursor: pointer;
                appearance: none;
                position: relative;
            }

            .mobile-checkbox:checked::after {
                content: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 8 8" fill="none"><path d="M2.86801 7.85661C3.13689 7.85661 3.36505 7.71755 3.52795 7.44812L5.38972 4.32373L7.25149 1.19935C7.34925 1.02553 7.44708 0.834327 7.44708 0.643129C7.44708 0.252041 7.12113 0 6.78705 0C6.57527 0 6.37155 0.139055 6.21672 0.391096L2.83542 6.17927L1.23032 3.96308C1.03477 3.68497 0.855515 3.6154 0.63553 3.6154C0.277025 3.6154 0 3.91962 0 4.302C0 4.49319 0.0733306 4.6757 0.187404 4.84086L2.17545 7.44812C2.37915 7.73491 2.59914 7.85661 2.86801 7.85661Z" fill="black"/></svg>');
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }

            .mobile-checkbox-label {
                font-size: 16px;
                color: #000;
                cursor: pointer;
            }

            /* Range de preço */
            .mobile-price-range {
                display: flex;
                gap: 12px;
                align-items: center;
            }

            .mobile-price-input {
                flex: 1;
                padding: 12px;
                background: #f5f5f5;
                border: 1px solid #ddd;
                border-radius: 8px;
                font-size: 16px;
            }

            .mobile-price-separator {
                color: #666;
            }

            /* Adjusting the scrollbar track's style */
            ::-webkit-scrollbar-track {
                background-color: #f5f5f5;
            }

            /* Customizing the appearance of the scrollbar thumb */
            ::-webkit-scrollbar-thumb {
                background-color: #888;
                border-radius: 10px;
            }

            /* Altering the scrollbar thumb's look when hovered */
            ::-webkit-scrollbar-thumb:hover {
                background-color: #333;
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
                    if (count($parts) > 1) {
                        $currentSlug = $parts[3];
                    }
                }
            @endphp
            <!-- Filtros superiores -->
            <div
                class="fixed top-[70px] left-0 right-0 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pt-4 pb-3 px-[10px] bg-[#F1F1F1] z-10">

                <!-- Esquerda: Coleção e Categoria (FLEXÍVEL) -->
                <div class="filters-left-section">

                    <!-- Categoria (OCUPA O ESPAÇO RESTANTE) -->
                    <div class="relative category-select-wrapper">
                        <div class="select-button p-5" id="categorySelectButton">
                            <span id="categorySelectedText">Categoria</span>
                            <div class="pl-[5px]" id="categoryArrow">
                                <div class="pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7"
                                        viewBox="0 0 12 7" fill="none">
                                        <path d="M0.75 0.75L5.69975 5.69975L10.6495 0.750001" stroke="black"
                                            stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="options min-w-[250px] p-5 custom-scrollbar-wh" id="categoryOptions">
                            @foreach ($categories as $category)
                                @php $hasSub = isset($category->subcategories) && count($category->subcategories) > 0; @endphp
                                <div class="option category-option {{ $hasSub ? 'has-subcategories' : '' }}"
                                    data-value="{{ $category->name }}" data-id="{{ $category->id }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <span class="check-icon" style="display: none;"><svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                                    <path
                                                        d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                                </svg></span>
                                            <span class="option-content">{{ $category->name }}</span>
                                        </div>
                                        @if ($hasSub)
                                            <span class="arrow-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                                    viewBox="0 0 12 8" fill="none">
                                                    <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" />
                                                </svg>
                                            </span>
                                        @endif
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
                                                    <span class="text-base">Todas</span>
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
                            <div class="option category-option selected" data-value="" data-id="">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="check-icon" style="display: block;"><svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                                <path
                                                    d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                            </svg></span>
                                        <span class="option-content">Todas</span>
                                    </div>
                                    <span class="x-icon" style="display: inline-table;">×</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Direita: Busca, Filtros e Ordenação (LARGURA FIXA) -->
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

                    <label class="inline-flex items-center bg-white px-[20px] py-[10px] rounded-lg h-[36px]">
                        <span class="text-[1rem] mr-1 leading-[0px]">Agrupar cores</span>
                        <input id="groupColors" type="checkbox"
                            class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative">
                    </label>

                    <div class="filter-container">
                        <div class="filter-button" id="filterButton">
                            <span id="filterText" class="text-[1rem] leading-[0px]">Filtrar</span>
                            <span id="filterCount" class="filter-count leading-[0px]"
                                style="display: none; margin-left:5px; color: #7A7A7A;">0</span>
                            <div class="pl-[5px] pt-1" id="arrow2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                    viewBox="0 0 12 8" fill="none">
                                    <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>

                        @php
                            $availableNumeracaoIds = [];
                            $availableSizeIds = [];
                            $availableGeneros = [];
                            $availableLinhas = [];
                            if (!empty($produtos)) {
                                foreach ($produtos as $produtoGroup) {
                                    if ($produtoGroup && $produtoGroup->product) {
                                        $produto = $produtoGroup->product;
                                        if ($produto->numeracoes) {
                                            foreach ($produto->numeracoes->pluck('id')->toArray() as $nid) {
                                                $availableNumeracaoIds[$nid] = true;
                                            }
                                        }
                                        if ($produtoGroup->numeracao) {
                                            $availableNumeracaoIds[$produtoGroup->numeracao->id] = true;
                                        }
                                        if ($produto->sizes) {
                                            foreach ($produto->sizes->pluck('id')->toArray() as $sid) {
                                                $availableSizeIds[$sid] = true;
                                            }
                                        }
                                        if (!empty($produtoGroup->genero)) {
                                            $availableGeneros[$produtoGroup->genero] = true;
                                        }
                                        if (!empty($produto->linha)) {
                                            $availableLinhas[$produto->linha] = true;
                                        }
                                    }
                                }
                            }
                            $availableNumeracaoIds = array_keys($availableNumeracaoIds);
                            $availableSizeIds = array_keys($availableSizeIds);
                            $availableGeneros = array_keys($availableGeneros);
                            $availableLinhas = array_keys($availableLinhas);
                        @endphp
                        <div class="filter-dropdown custom-scrollbar-wh" id="filterDropdown">
                            <div class="filter-section">
                                <label class="filter-label">Numeração/Tamanhos​</label>
                                <div class="filter-options" id="numeracaoOptions">
                                    @foreach ($numeracao->whereIn('id', $availableNumeracaoIds) as $num)
                                        <div class="filter-option" data-type="numeracao"
                                            data-value="{{ $num->id }}">{{ $num->numero }}</div>
                                    @endforeach
                                    @foreach ($tamanhos->whereIn('id', $availableSizeIds) as $size)
                                        <div class="filter-option" data-type="tamanho"
                                            data-value="{{ $size->id }}">{{ $size->size }}</div>
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
                                <label class="filter-label">Gênero</label>
                                <div class="filter-options" id="generoOptions">
                                    @foreach ($availableGeneros as $gen)
                                        <div class="filter-option" data-type="genero"
                                            data-value="{{ $gen }}">{{ $gen }}</div>
                                    @endforeach
                                </div>
                            </div>

                            @if (!empty($availableLinhas))
                                <div class="filter-section">
                                    <label class="filter-label">Linha</label>
                                    <div class="filter-options" id="linhaOptions">
                                        @foreach ($availableLinhas as $linha)
                                            <div class="filter-option" data-type="linha"
                                                data-value="{{ $linha }}">{{ $linha }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="filter-section">
                                <label class="filter-label">Valor</label>
                                <div class="filter-options price-options" id="priceOptions">
                                    <span class="text-sm pt-2">de</span> <input style="width: 30%;"
                                        class="filter-option" type="text" id="priceMin" placeholder="">
                                    <span class="text-sm pt-2">até</span> <input style="width: 30%;"
                                        class="filter-option" type="text" id="priceMax" placeholder="">
                                </div>
                            </div>
                            <div class="text-[#7A7A7A] text-[14px] underline cursor-pointer" id="clearFiltersBtn">
                                Limpar</div>
                        </div>


                    </div>

                    <div class="sort-container">
                        <div class="sort-button" id="sortButton">
                            <span class="text-[1rem] text-black mr-[5px] leading-[0px]">Ordenar por:</span>
                            <span id="sortText" class="text-[#7A7A7A] leading-[0px]"></span>
                            <div class="pl-[5px] pt-1" id="sortArrow">
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
                class="gap-[10px] bg-[#E6E6E6] p-[10px] lg:mt-[4.8rem] overflow-auto height-ultra custom-scrollbar">

                @if (empty($produtos) || count($produtos) == 0)
                    <div class="col-span-full flex items-center justify-center h-[100vh]">
                        <div class="text-center">
                            <p class="text-gray-600 text-xl font-medium">Nenhum produto disponível</p>
                        </div>
                    </div>
                @else
                    <template id="template-produto">
                        <a href="" class="block h-full">
                            <div
                                class="bg-white hover:shadow-md transition relative rounded-md border border-[#DEDEDE] flex flex-col">
                                <div class="badge-container pt-1 px-2" style="position:absolute; min-height: 35px;">
                                </div>
                                <img src="/images/tenis-1.jpg" alt="Tênis"
                                    class="w-full object-contain rounded-md" />

                                <div class="p-4 flex-1 flex flex-col">
                                    <h2 class="notranslate title font-normal font-fko text-[28px] leading-[24px] pb-2">
                                    </h2>

                                    <div class="flex-1 flex flex-col justify-between">
                                        <div class="mt-auto">
                                            <p class="text-sm pb-2">
                                                <span class="categoria text-black "></span>
                                                <span class="genero text-black opacity-50 pr-2"></span>
                                                <span class="codigo text-black opacity-50"></span>
                                            </p>
                                            <div class="float-right mr-[25%]">
                                                <p class="text-black opacity-50 text-xs title-caract-1"></p>
                                                <p class="numeracao text-black text-xs desc-caract-1"></p>
                                            </div>
                                            <p class="text-black opacity-50 text-xs">Cor</p>
                                            <p class="notranslate cor text-black text-xs pb-2"></p>

                                            <p class="text-black opacity-50 mt-1 text-xs pdv-label">PDV</p>
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
            const sharedOptions = @json($options ?? []);
            const produtosData = [
                @if (!empty($produtos) && count($produtos) > 0)
                    @foreach ($produtos as $produtoGroup)
                        @if ($produtoGroup && $produtoGroup->product)
                            @php
                                $produto = $produtoGroup->product;
                                $imgPath = '/images/produtos/' . $produto->code . '_' . str_replace('/', '_', $produtoGroup->color_code) . '.jpg';
                                $imgFullPath = public_path($imgPath);
                                $img = file_exists($imgFullPath) ? $imgPath : '/images/img-padrao-oly.png';
                                $numeracaoIdsProduct = $produto->numeracoes ? $produto->numeracoes->pluck('id')->toArray() : [];
                                $numeracaoIdColor = $produtoGroup->numeracao ? $produtoGroup->numeracao->id : null;
                                $numeracaoIds = $numeracaoIdsProduct;
                                if ($numeracaoIdColor) {
                                    $numeracaoIds[] = $numeracaoIdColor;
                                }
                                $numeracaoIds = array_values(array_unique($numeracaoIds));
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
                                numeracao: "{{ $produtoGroup->numeracao && $produtoGroup->numeracao->numero ? $produtoGroup->numeracao->numero : '' }}",
                                categoria: "{{ $produto->category ? $produto->category->name : '' }}",
                                subcategory_id: "{{ $produto->subcategory_id ?? '' }}",
                                preco: "R$ {{ $precoNumerico }}",
                                precoNumerico: "{{ $produto->price ?? 0 }}",
                                genero: "{{ $produtoGroup->genero ?? '' }}",
                                linha: "{{ $produto->linha ?? '' }}",
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

                    if (sharedOptions && (Array.isArray(sharedOptions) ? sharedOptions.includes('ocultar_preco') :
                            sharedOptions.ocultar_preco)) {
                        clone.querySelector(".preco").style.display = 'none';
                        const pdvLabel = clone.querySelector(".pdv-label");
                        if (pdvLabel) pdvLabel.style.display = 'none';
                    } else {
                        clone.querySelector(".preco").textContent = produto.preco;
                    }

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

            function parseMoney(value) {
                if (typeof value === 'number') return value;
                if (!value) return 0;
                value = value.toString();
                // Remove caracteres não numéricos exceto ponto e vírgula
                value = value.replace(/[^\d.,]/g, '');

                if (value === '') return 0;

                // Se tiver vírgula, assume formato BR (ex: 1.000,00 ou 100,00)
                if (value.includes(',')) {
                    // Remove pontos (milhar)
                    value = value.replace(/\./g, '');
                    // Troca vírgula por ponto
                    value = value.replace(',', '.');
                } else {
                    // Sem vírgula. Verifica pontos.
                    const parts = value.split('.');
                    // Se tiver múltiplos pontos, é milhar (ex: 1.000.000) -> remove todos
                    if (parts.length > 2) {
                        value = value.replace(/\./g, '');
                    }
                    // Se tiver um ponto e 3 dígitos no final (ex: 1.000), assume milhar -> remove ponto
                    // Cuidado: 1.000 pode ser 1 se for formato US. Mas no Brasil 1.000 é mil.
                    else if (parts.length === 2 && parts[1].length === 3) {
                        value = value.replace(/\./g, '');
                    }
                    // Caso contrário (ex: 100.50), deixa o ponto como decimal
                }

                return parseFloat(value) || 0;
            }

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

                        const matchesGenero = selectedFilters.genero.length === 0 ||
                            selectedFilters.genero.some(gen => (p.genero || '').toLowerCase() === gen.toLowerCase());

                        const matchesLinha = selectedFilters.linha.length === 0 ||
                            selectedFilters.linha.some(lin => (p.linha || '').toLowerCase() === lin.toLowerCase());

                        let matchesSegmentacao = true;
                        /*
                        try {
                            const selectedSegmentacoes = JSON.parse(localStorage.getItem('selectedSegmentacoes') || '[]');
                            if (selectedSegmentacoes.length > 0) {
                                matchesSegmentacao = selectedSegmentacoes.some(segId => p.segmentacaoIds.includes(parseInt(
                                    segId)));
                            }
                        } catch (e) {
                            console.error('Erro ao processar segmentações do localStorage:', e);
                        }
                        */

                        let matchesPreco = true;
                        // O preço do produto vem do PHP/DB como float (ex: 199.90), então usamos parseFloat direto.
                        // Usar parseMoney aqui poderia quebrar se o formato fosse interpretado incorretamente.
                        const productPrice = parseFloat(p.precoNumerico) || 0;

                        if (selectedFilters.priceMin !== null && selectedFilters.priceMin !== '') {
                            const minPrice = parseMoney(selectedFilters.priceMin);
                            matchesPreco = matchesPreco && productPrice >= minPrice;
                        }
                        if (selectedFilters.priceMax !== null && selectedFilters.priceMax !== '') {
                            const maxPrice = parseMoney(selectedFilters.priceMax);
                            matchesPreco = matchesPreco && productPrice <= maxPrice;
                        }

                        return matchesTermo && matchesCategoria && matchesSubcategoria && matchesNumeracao &&
                            matchesTamanho && matchesClassificacao && matchesGenero && matchesLinha && matchesSegmentacao &&
                            matchesPreco;
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
                        <span class='text-[16px] text-black'>Categoria: </span> 
                        <span class='text-[18px] text-[#7A7A7A]'>${categoryName} (${subcategoryName})</span>
                    `;
                } else {
                    categorySelectedText.innerHTML = `
                        <span class='text-[16px] text-black'>Categoria: </span> 
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

                subcategoryOption.addEventListener('click', function(e) {
                    if (e.target.classList.contains('x-icon')) {

                        e.stopPropagation();
                        const option = e.target.closest('.option');

                        if (option) {
                            categorySelectedText.innerHTML = "<span class='text-[16px] text-black'>Categoria</span>";
                            selectedCategory = '';
                            selectedSubcategory = '';
                            subcategoryOption.classList.remove('selected');
                            subcategoryOption.querySelector('.check-icon').style.display = 'none';
                            subcategoryOption.querySelector('.x-icon').style.display = 'none';

                            //closeCategoryDropdown();
                            aplicarFiltros();
                        }
                        return;
                    }
                });

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
                        <span class='text-[16px] text-black'>Categoria: </span> 
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
                                if (!subcategoryContainer.hasAttribute('data-loaded') &&
                                    subcategoryContainer
                                    .children.length === 0) {
                                    loadSubcategoriesInline(categoryId, subcategoryContainer,
                                        categoryOption);
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

            function openCategoryDropdown() {
                categoryOptions.classList.add('show');
                categoryArrow.classList.add('up');
            }

            function closeCategoryDropdown() {
                categoryOptions.classList.remove('show');
                categoryArrow.classList.remove('up');
            }

            categorySelectButton.addEventListener('click', function(e) {

                e.stopPropagation();

                if (categoryOptions.classList.contains('show')) {
                    closeCategoryDropdown();
                    closeFilterDropdown();
                } else {
                    closeFilterDropdown();
                    closeSortDropdown();
                    openCategoryDropdown();
                }
            });

            categoryOptions.addEventListener('click', function(e) {
                //console.log('chegou quix');
                if (e.target.closest('.subcategory-dropdown')) {
                    return;
                }

                if (e.target.classList.contains('x-icon')) {

                    e.stopPropagation();
                    const option = e.target.closest('.option');
                    if (option) {
                        categorySelectedText.innerHTML = "<span class='text-[16px] text-black'>Categoria</span>";
                        selectedCategory = '';
                        selectedSubcategory = '';

                        // Fechar todas as categorias expandidas
                        categoryOptions.querySelectorAll('.category-option').forEach(opt => {
                            opt.classList.remove('expanded');
                        });

                        //closeCategoryDropdown();
                        aplicarFiltros();
                    }
                    return;
                }

                let option = e.target;

                if (!option.classList.contains('option')) {
                    option = option.closest('.option');
                }

                if (option && option.classList.contains('option')) {
                    //console.log('Clicou na categoria opção abaixo');
                    const hasSubcategories = option.classList.contains('has-subcategories');

                    // Se não tem subcategorias ou já está carregado e não expandido, selecionar
                    if (!hasSubcategories || (option.hasAttribute('data-no-subcategories'))) {
                        categoryOptions.querySelectorAll('.option').forEach(opt => {
                            opt.classList.remove('selected');
                            opt.classList.remove('expanded');
                            opt.querySelector('.check-icon').style.display = 'none';
                            opt.querySelector('.x-icon').style.display = 'none';
                        });

                        option.classList.add('selected');
                        option.querySelector('.check-icon').style.display = 'inline';
                        option.querySelector('.x-icon').style.display = 'inline-table';

                        const value = option.getAttribute('data-value');
                        const text = option.querySelector('.option-content').textContent;
                        categorySelectedText.innerHTML = `
                            <span class='text-[16px] text-black'>Categoria: </span> 
                            <span class='text-[18px] text-[#7A7A7A]'>${text}</span>
                        `;

                        categoryOptions.querySelectorAll('.subcategory-option').forEach(opt => {
                            opt.classList.remove('selected');
                            opt.classList.remove('expanded');
                            opt.querySelector('.check-icon').style.display = 'none';
                            opt.querySelector('.x-icon').style.display = 'none';
                        });

                        selectedCategory = value;
                        selectedSubcategory = '';
                        //closeCategoryDropdown();
                        aplicarFiltros();
                    } else {

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
                genero: [],
                linha: [],
                priceMin: null,
                priceMax: null
            };

            filterButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = filterDropdown.classList.contains('show');

                if (isOpen) {
                    closeFilterDropdown();
                } else {
                    closeCategoryDropdown();
                    closeSortDropdown();
                    openFilterDropdown();
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

            let priceDebounceTimer;

            if (priceMinInput) {
                priceMinInput.addEventListener('input', function() {
                    selectedFilters.priceMin = this.value;
                    clearTimeout(priceDebounceTimer);
                    priceDebounceTimer = setTimeout(updateFilterCount, 500);
                });
            }

            if (priceMaxInput) {
                priceMaxInput.addEventListener('input', function() {
                    selectedFilters.priceMax = this.value;
                    clearTimeout(priceDebounceTimer);
                    priceDebounceTimer = setTimeout(updateFilterCount, 500);
                });
            }

            const clearFiltersBtn = document.getElementById('clearFiltersBtn');
            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener('click', function(e) {
                    e.stopPropagation();

                    // Clear selected filters object
                    selectedFilters.numeracao = [];
                    selectedFilters.tamanho = [];
                    selectedFilters.classification = [];
                    selectedFilters.genero = [];
                    selectedFilters.linha = [];
                    selectedFilters.priceMin = null;
                    selectedFilters.priceMax = null;

                    // Clear inputs
                    if (priceMinInput) priceMinInput.value = '';
                    if (priceMaxInput) priceMaxInput.value = '';

                    // Clear UI selections
                    document.querySelectorAll('.filter-option.selected').forEach(option => {
                        option.classList.remove('selected');
                        const removeBtn = option.querySelector('.tag-remove');
                        if (removeBtn) removeBtn.remove();
                    });

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
                    selectedFilters.classification.length + selectedFilters.genero.length +
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
                    closeCategoryDropdown();
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
                            const precoA = parseFloat(a.precoNumerico) || 0;
                            const precoB = parseFloat(b.precoNumerico) || 0;
                            return precoB - precoA;
                        });
                        break;
                    case 'menor-valor':
                        sortedProdutos.sort((a, b) => {
                            const precoA = parseFloat(a.precoNumerico) || 0;
                            const precoB = parseFloat(b.precoNumerico) || 0;
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


        <script>
            // Abrir/fechar menu mobile
            const trigger = document.getElementById('mobileFilterTrigger');
            const overlay = document.getElementById('mobileFilterOverlay');
            const menu = document.getElementById('mobileFilterMenu');
            const closeBtn = document.getElementById('mobileFilterClose');

            function openMobileFilters() {
                overlay.classList.add('active');
                menu.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileFilters() {
                overlay.classList.remove('active');
                menu.classList.remove('active');
                document.body.style.overflow = '';
            }

            trigger.addEventListener('click', openMobileFilters);
            overlay.addEventListener('click', closeMobileFilters);
            closeBtn.addEventListener('click', closeMobileFilters);

            // Toggle select mobile
            function toggleMobileSelect(type) {
                const options = document.getElementById(`mobile${type.charAt(0).toUpperCase() + type.slice(1)}Options`);
                const select = options.previousElementSibling;

                options.classList.toggle('active');
                select.classList.toggle('active');
            }

            // Selecionar coleção
            function selectCollection(name) {
                document.getElementById('mobileCollectionText').textContent = name;

                const options = document.querySelectorAll('#mobileCollectionOptions .mobile-select-option');
                options.forEach(opt => {
                    opt.classList.remove('selected');
                    opt.querySelector('span:last-child').style.display = 'none';
                });

                event.target.closest('.mobile-select-option').classList.add('selected');
                event.target.closest('.mobile-select-option').querySelector('span:last-child').style.display = 'block';

                toggleMobileSelect('collection');
                updateBadge();
            }

            // Selecionar categoria
            function selectCategory(name, subcategoryId) {
                if (subcategoryId) {
                    const subcategories = document.getElementById(`subcategory-${subcategoryId}`);
                    subcategories.classList.toggle('active');
                } else {
                    document.getElementById('mobileCategoryText').textContent = name;
                    toggleMobileSelect('category');
                    updateBadge();
                }
            }

            // Selecionar subcategoria
            function selectSubcategory(name) {
                document.getElementById('mobileCategoryText').textContent = name;

                const items = document.querySelectorAll('.mobile-subcategory-item');
                items.forEach(item => item.classList.remove('selected'));
                event.target.classList.add('selected');

                toggleMobileSelect('category');
                updateBadge();
            }

            // Toggle chips
            function toggleChip(element, type, value) {
                element.classList.toggle('selected');
                updateBadge();
            }

            // Atualizar badge de contagem
            function updateBadge() {
                let count = 0;

                // Contar filtros ativos
                const selectedChips = document.querySelectorAll('.mobile-filter-chip.selected');
                count += selectedChips.length;

                if (document.getElementById('mobileCollectionText').textContent !== 'Selecione uma coleção') count++;
                if (document.getElementById('mobileCategoryText').textContent !== 'Todas as categorias') count++;
                if (document.getElementById('mobilePriceMin').value) count++;
                if (document.getElementById('mobilePriceMax').value) count++;
                if (document.getElementById('mobileGroupColors').checked) count++;

                const badge = document.getElementById('mobileBadge');
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'inline-flex';
                } else {
                    badge.style.display = 'none';
                }
            }

            // Limpar filtros individuais
            function clearCollection() {
                document.getElementById('mobileCollectionText').textContent = 'Selecione uma coleção';
                const options = document.querySelectorAll('#mobileCollectionOptions .mobile-select-option');
                options.forEach(opt => {
                    opt.classList.remove('selected');
                    opt.querySelector('span:last-child').style.display = 'none';
                });
                updateBadge();
            }

            function clearCategory() {
                document.getElementById('mobileCategoryText').textContent = 'Todas as categorias';
                updateBadge();
            }

            function clearSizes() {
                const chips = document.querySelectorAll('#mobileSizeChips .mobile-filter-chip');
                chips.forEach(chip => chip.classList.remove('selected'));
                updateBadge();
            }

            function clearClassification() {
                const chips = document.querySelectorAll('#mobileClassificationChips .mobile-filter-chip');
                chips.forEach(chip => chip.classList.remove('selected'));
                updateBadge();
            }

            function clearPrice() {
                document.getElementById('mobilePriceMin').value = '';
                document.getElementById('mobilePriceMax').value = '';
                updateBadge();
            }

            // Limpar todos os filtros
            function clearAllFilters() {
                clearCollection();
                clearCategory();
                clearSizes();
                clearClassification();
                clearPrice();
                document.getElementById('mobileGroupColors').checked = false;
                document.getElementById('mobileSearch').value = '';
                updateBadge();
            }

            // Aplicar filtros
            function applyFilters() {
                console.log('Aplicando filtros...');
                // Aqui você sincronizaria com os filtros desktop
                closeMobileFilters();
            }

            // Sincronizar busca com tempo de debounce
            let searchTimeout;
            document.getElementById('mobileSearch').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    console.log('Buscando:', this.value);
                    // Sincronizar com busca desktop
                }, 300);
            });

            // Atualizar badge ao mudar inputs de preço
            document.getElementById('mobilePriceMin').addEventListener('input', updateBadge);
            document.getElementById('mobilePriceMax').addEventListener('input', updateBadge);
            document.getElementById('mobileGroupColors').addEventListener('change', updateBadge);




            // ==================== MOBILE FILTERS ====================
            (function() {
                // Variáveis globais mobile
                let mobileSelectedCategory = '';
                let mobileSelectedSubcategory = '';
                let mobileSelectedCollection = '{{ $currentSlug }}';

                // Abrir/fechar menu mobile
                const trigger = document.getElementById('mobileFilterTrigger');
                const overlay = document.getElementById('mobileFilterOverlay');
                const menu = document.getElementById('mobileFilterMenu');
                const closeBtn = document.getElementById('mobileFilterClose');

                function openMobileFilters() {
                    overlay.classList.add('active');
                    menu.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    syncDesktopToMobile();
                }

                function closeMobileFilters() {
                    overlay.classList.remove('active');
                    menu.classList.remove('active');
                    document.body.style.overflow = '';
                }

                if (trigger) trigger.addEventListener('click', openMobileFilters);
                if (overlay) overlay.addEventListener('click', closeMobileFilters);
                if (closeBtn) closeBtn.addEventListener('click', closeMobileFilters);

                // Sincronizar desktop para mobile ao abrir
                window.syncDesktopToMobile = function() {
                    // Busca
                    const desktopSearch = document.getElementById('search');
                    const mobileSearch = document.getElementById('mobileSearch');
                    if (desktopSearch && mobileSearch) {
                        mobileSearch.value = desktopSearch.value;
                    }

                    // Agrupar cores
                    const desktopGroupColors = document.getElementById('groupColors');
                    const mobileGroupColors = document.getElementById('mobileGroupColors');
                    if (desktopGroupColors && mobileGroupColors) {
                        mobileGroupColors.checked = desktopGroupColors.checked;
                    }

                    // Filtros de numeração/tamanho
                    document.querySelectorAll(
                        '.filter-option.selected[data-type="numeracao"], .filter-option.selected[data-type="tamanho"]'
                    ).forEach(opt => {
                        const type = opt.dataset.type;
                        const value = opt.dataset.value;
                        const mobileChip = document.querySelector(
                            `.mobile-filter-chip[data-type="${type}"][data-value="${value}"]`);
                        if (mobileChip) mobileChip.classList.add('selected');
                    });

                    // Filtros de classificação
                    document.querySelectorAll('.filter-option.selected[data-type="classification"]').forEach(opt => {
                        const value = opt.dataset.value;
                        const mobileChip = document.querySelector(
                            `.mobile-filter-chip[data-type="classification"][data-value="${value}"]`);
                        if (mobileChip) mobileChip.classList.add('selected');
                    });

                    // Preço
                    const priceMin = document.getElementById('priceMin');
                    const priceMax = document.getElementById('priceMax');
                    const mobilePriceMin = document.getElementById('mobilePriceMin');
                    const mobilePriceMax = document.getElementById('mobilePriceMax');
                    if (priceMin && mobilePriceMin) mobilePriceMin.value = priceMin.value;
                    if (priceMax && mobilePriceMax) mobilePriceMax.value = priceMax.value;

                    // Ordenação
                    const sortText = document.getElementById('sortText');
                    const mobileSortText = document.getElementById('mobileSortText');
                    if (sortText && mobileSortText) {
                        mobileSortText.textContent = sortText.textContent || 'Padrão';
                    }

                    updateMobileBadge();
                };

                // Toggle select mobile
                window.toggleMobileSelect = function(type) {
                    const options = document.getElementById(
                        `mobile${type.charAt(0).toUpperCase() + type.slice(1)}Options`);
                    const select = options.previousElementSibling;

                    if (options && select) {
                        options.classList.toggle('active');
                        select.classList.toggle('active');
                    }
                };

                // Selecionar coleção mobile
                window.selectMobileCollection = function(name, slug) {
                    document.getElementById('mobileCollectionText').textContent = name;
                    mobileSelectedCollection = slug;

                    const options = document.querySelectorAll('#mobileCollectionOptions .mobile-select-option');
                    options.forEach(opt => {
                        opt.classList.remove('selected');
                        opt.querySelector('span:last-child').style.display = 'none';
                    });

                    event.target.closest('.mobile-select-option').classList.add('selected');
                    event.target.closest('.mobile-select-option').querySelector('span:last-child').style.display =
                        'block';

                    toggleMobileSelect('collection');
                    updateMobileBadge();
                };

                // Selecionar categoria mobile
                window.selectMobileCategory = function(name, categoryId, hasSubcategories) {
                    if (hasSubcategories) {
                        const subcategories = document.getElementById(`mobile-subcategory-${categoryId}`);
                        if (subcategories) {
                            subcategories.classList.toggle('active');

                            // Atualizar arrow
                            const option = event.target.closest('.mobile-select-option');
                            const arrow = option.querySelector('span:last-child');
                            if (subcategories.classList.contains('active')) {
                                arrow.textContent = '↓';
                                arrow.style.display = 'block';
                            } else {
                                arrow.textContent = '→';
                                arrow.style.display = 'block';
                            }
                        }
                    } else {
                        document.getElementById('mobileCategoryText').textContent = name;
                        mobileSelectedCategory = name;
                        mobileSelectedSubcategory = '';

                        // Limpar todas as subcategorias
                        document.querySelectorAll('.mobile-subcategory-list').forEach(list => {
                            list.classList.remove('active');
                        });

                        const options = document.querySelectorAll('#mobileCategoryOptions > .mobile-select-option');
                        options.forEach(opt => {
                            opt.classList.remove('selected');
                            const lastSpan = opt.querySelector('span:last-child');
                            if (lastSpan && lastSpan.textContent === '✓') {
                                lastSpan.style.display = 'none';
                            }
                        });

                        event.target.closest('.mobile-select-option').classList.add('selected');
                        const checkmark = event.target.closest('.mobile-select-option').querySelector(
                            'span:last-child');
                        if (checkmark && checkmark.textContent === '✓') {
                            checkmark.style.display = 'block';
                        }

                        toggleMobileSelect('category');
                        updateMobileBadge();
                    }
                };

                // Selecionar subcategoria mobile
                window.selectMobileSubcategory = function(categoryName, categoryId, subcategoryId, subcategoryName) {
                    if (subcategoryId) {
                        document.getElementById('mobileCategoryText').textContent =
                            `${categoryName} (${subcategoryName})`;
                    } else {
                        document.getElementById('mobileCategoryText').textContent = categoryName;
                    }

                    mobileSelectedCategory = categoryName;
                    mobileSelectedSubcategory = subcategoryId;

                    const subcategoryList = document.getElementById(`mobile-subcategory-${categoryId}`);
                    const items = subcategoryList.querySelectorAll('.mobile-subcategory-item');
                    items.forEach(item => item.classList.remove('selected'));
                    event.target.classList.add('selected');

                    toggleMobileSelect('category');
                    updateMobileBadge();
                };

                // Selecionar ordenação mobile
                window.selectMobileSort = function(name, value) {
                    document.getElementById('mobileSortText').textContent = name;

                    const options = document.querySelectorAll('#mobileSortOptions .mobile-select-option');
                    options.forEach(opt => {
                        opt.classList.remove('selected');
                        opt.querySelector('span:last-child').style.display = 'none';
                    });

                    event.target.closest('.mobile-select-option').classList.add('selected');
                    event.target.closest('.mobile-select-option').querySelector('span:last-child').style.display =
                        'block';

                    toggleMobileSelect('sort');
                    updateMobileBadge();
                };

                // Toggle chips mobile
                window.toggleMobileChip = function(element, type, value) {
                    element.classList.toggle('selected');
                    updateMobileBadge();
                };

                // Atualizar badge de contagem mobile
                function updateMobileBadge() {
                    let count = 0;

                    const selectedChips = document.querySelectorAll('.mobile-filter-chip.selected');
                    count += selectedChips.length;

                    const collectionText = document.getElementById('mobileCollectionText').textContent;
                    if (collectionText && collectionText !== 'Selecione uma coleção' && collectionText !== 'Todas') count++;

                    const categoryText = document.getElementById('mobileCategoryText').textContent;
                    if (categoryText && categoryText !== 'Todas as categorias') count++;

                    if (document.getElementById('mobilePriceMin').value) count++;
                    if (document.getElementById('mobilePriceMax').value) count++;
                    if (document.getElementById('mobileGroupColors').checked) count++;

                    const badge = document.getElementById('mobileBadge');
                    if (count > 0) {
                        badge.textContent = count;
                        badge.style.display = 'inline-flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }

                // Limpar coleção mobile
                window.clearMobileCollection = function() {
                    document.getElementById('mobileCollectionText').textContent = 'Selecione uma coleção';
                    mobileSelectedCollection = '';
                    const options = document.querySelectorAll('#mobileCollectionOptions .mobile-select-option');
                    options.forEach(opt => {
                        opt.classList.remove('selected');
                        opt.querySelector('span:last-child').style.display = 'none';
                    });
                    updateMobileBadge();
                };

                // Limpar categoria mobile
                window.clearMobileCategory = function() {
                    document.getElementById('mobileCategoryText').textContent = 'Todas as categorias';
                    mobileSelectedCategory = '';
                    mobileSelectedSubcategory = '';

                    document.querySelectorAll('.mobile-subcategory-list').forEach(list => {
                        list.classList.remove('active');
                    });

                    const options = document.querySelectorAll('#mobileCategoryOptions > .mobile-select-option');
                    options.forEach(opt => {
                        opt.classList.remove('selected');
                        const lastSpan = opt.querySelector('span:last-child');
                        if (lastSpan) lastSpan.style.display = 'none';
                    });

                    // Selecionar "Todas"
                    const todasOption = document.querySelector(
                        '#mobileCategoryOptions .mobile-select-option[data-category-id=""]');
                    if (todasOption) {
                        todasOption.classList.add('selected');
                        todasOption.querySelector('span:last-child').style.display = 'block';
                    }

                    updateMobileBadge();
                };

                // Limpar tamanhos mobile
                window.clearMobileSizes = function() {
                    const chips = document.querySelectorAll('#mobileSizeChips .mobile-filter-chip');
                    chips.forEach(chip => chip.classList.remove('selected'));
                    updateMobileBadge();
                };

                // Limpar classificação mobile
                window.clearMobileClassification = function() {
                    const chips = document.querySelectorAll('#mobileClassificationChips .mobile-filter-chip');
                    chips.forEach(chip => chip.classList.remove('selected'));
                    updateMobileBadge();
                };

                // Limpar preço mobile
                window.clearMobilePrice = function() {
                    document.getElementById('mobilePriceMin').value = '';
                    document.getElementById('mobilePriceMax').value = '';
                    updateMobileBadge();
                };

                // Limpar todos os filtros mobile
                window.clearAllMobileFilters = function() {
                    clearMobileCollection();
                    clearMobileCategory();
                    clearMobileSizes();
                    clearMobileClassification();
                    clearMobilePrice();
                    document.getElementById('mobileGroupColors').checked = false;
                    document.getElementById('mobileSearch').value = '';

                    // Resetar ordenação
                    const sortOptions = document.querySelectorAll('#mobileSortOptions .mobile-select-option');
                    sortOptions.forEach(opt => {
                        opt.classList.remove('selected');
                        opt.querySelector('span:last-child').style.display = 'none';
                    });
                    const defaultSort = document.querySelector(
                        '#mobileSortOptions .mobile-select-option[data-value=""]');
                    if (defaultSort) {
                        defaultSort.classList.add('selected');
                        defaultSort.querySelector('span:last-child').style.display = 'block';
                    }
                    document.getElementById('mobileSortText').textContent = 'Padrão';

                    updateMobileBadge();
                };

                // Aplicar filtros mobile
                window.applyMobileFilters = function() {
                    // Sincronizar com desktop

                    // Busca
                    const mobileSearch = document.getElementById('mobileSearch');
                    const desktopSearch = document.getElementById('search');
                    if (mobileSearch && desktopSearch) {
                        desktopSearch.value = mobileSearch.value;
                    }

                    // Coleção (redirecionar se mudou)
                    if (mobileSelectedCollection !== '{{ $currentSlug }}') {
                        const currentUrl = window.location.href;
                        const newUrl = currentUrl.replace(/\/[^/]+$/, "") + (mobileSelectedCollection ? '/' +
                            mobileSelectedCollection : '');
                        window.location.href = newUrl;
                        return;
                    }

                    // Categoria
                    if (mobileSelectedCategory && mobileSelectedCategory !== 'Todas') {
                        selectedCategory = mobileSelectedCategory;
                        selectedSubcategory = mobileSelectedSubcategory;

                        const categoryText = mobileSelectedSubcategory ?
                            `${mobileSelectedCategory} (${document.querySelector(`.mobile-subcategory-item.selected[data-subcategory-id="${mobileSelectedSubcategory}"]`)?.textContent || ''})` :
                            mobileSelectedCategory;

                        document.getElementById('categorySelectedText').innerHTML = `
                <span class='text-[16px] text-black'>Categoria: </span> 
                <span class='text-[18px] text-[#7A7A7A]'>${categoryText}</span>
            `;
                    } else {
                        selectedCategory = '';
                        selectedSubcategory = '';
                        document.getElementById('categorySelectedText').innerHTML =
                            "<span class='text-[16px] text-black'>Categoria</span>";
                    }

                    // Agrupar cores
                    const mobileGroupColors = document.getElementById('mobileGroupColors');
                    const desktopGroupColors = document.getElementById('groupColors');
                    if (mobileGroupColors && desktopGroupColors) {
                        desktopGroupColors.checked = mobileGroupColors.checked;
                    }

                    // Limpar filtros desktop
                    document.querySelectorAll('.filter-option.selected').forEach(opt => {
                        opt.classList.remove('selected');
                        const removeBtn = opt.querySelector('.tag-remove');
                        if (removeBtn) removeBtn.remove();
                    });
                    selectedFilters = {
                        numeracao: [],
                        tamanho: [],
                        classification: [],
                        genero: [],
                        priceMin: null,
                        priceMax: null
                    };

                    // Aplicar filtros de numeração/tamanho
                    document.querySelectorAll('#mobileSizeChips .mobile-filter-chip.selected').forEach(chip => {
                        const type = chip.dataset.type;
                        const value = chip.dataset.value;

                        if (!selectedFilters[type].includes(value)) {
                            selectedFilters[type].push(value);
                        }

                        const desktopOption = document.querySelector(
                            `.filter-option[data-type="${type}"][data-value="${value}"]`);
                        if (desktopOption) {
                            desktopOption.classList.add('selected');

                            const removeBtn = document.createElement('span');
                            removeBtn.className = 'tag-remove';
                            removeBtn.innerHTML = '&times;';
                            removeBtn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                removeFilter(type, value);
                            });
                            desktopOption.appendChild(removeBtn);
                        }
                    });

                    // Aplicar filtros de classificação
                    document.querySelectorAll('#mobileClassificationChips .mobile-filter-chip.selected').forEach(
                        chip => {
                            const value = chip.dataset.value;

                            if (!selectedFilters.classification.includes(value)) {
                                selectedFilters.classification.push(value);
                            }

                            const desktopOption = document.querySelector(
                                `.filter-option[data-type="classification"][data-value="${value}"]`);
                            if (desktopOption) {
                                desktopOption.classList.add('selected');

                                const removeBtn = document.createElement('span');
                                removeBtn.className = 'tag-remove';
                                removeBtn.innerHTML = '&times;';
                                removeBtn.addEventListener('click', function(e) {
                                    e.stopPropagation();
                                    removeFilter('classification', value);
                                });
                                desktopOption.appendChild(removeBtn);
                            }
                        });

                    // Preço
                    const mobilePriceMin = document.getElementById('mobilePriceMin');
                    const mobilePriceMax = document.getElementById('mobilePriceMax');
                    const desktopPriceMin = document.getElementById('priceMin');
                    const desktopPriceMax = document.getElementById('priceMax');

                    if (mobilePriceMin && desktopPriceMin) {
                        desktopPriceMin.value = mobilePriceMin.value;
                        selectedFilters.priceMin = mobilePriceMin.value;
                    }
                    if (mobilePriceMax && desktopPriceMax) {
                        desktopPriceMax.value = mobilePriceMax.value;
                        selectedFilters.priceMax = mobilePriceMax.value;
                    }

                    // Ordenação
                    const selectedSortOption = document.querySelector(
                        '#mobileSortOptions .mobile-select-option.selected');
                    if (selectedSortOption) {
                        const sortValue = selectedSortOption.dataset.value;
                        selectedSortValue = sortValue;

                        document.querySelectorAll('.sort-option').forEach(opt => opt.classList.remove('selected'));
                        const desktopSortOption = document.querySelector(`.sort-option[data-value="${sortValue}"]`);
                        if (desktopSortOption) {
                            desktopSortOption.classList.add('selected');
                            document.getElementById('sortText').textContent = desktopSortOption.textContent;
                        }
                    }

                    // Atualizar contagem desktop
                    updateFilterCount();

                    // Aplicar filtros
                    aplicarFiltros();

                    // Fechar menu
                    closeMobileFilters();
                };

                // Eventos de atualização do badge
                if (document.getElementById('mobilePriceMin')) {
                    document.getElementById('mobilePriceMin').addEventListener('input', updateMobileBadge);
                }
                if (document.getElementById('mobilePriceMax')) {
                    document.getElementById('mobilePriceMax').addEventListener('input', updateMobileBadge);
                }
                if (document.getElementById('mobileGroupColors')) {
                    document.getElementById('mobileGroupColors').addEventListener('change', updateMobileBadge);
                }

                // Sincronizar busca com debounce
                let searchTimeout;
                if (document.getElementById('mobileSearch')) {
                    document.getElementById('mobileSearch').addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            updateMobileBadge();
                        }, 300);
                    });
                }
            })();
        </script>
    @endpush

</x-layout-user>
