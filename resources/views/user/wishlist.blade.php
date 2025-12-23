<x-layout-user title="Under Armour - Favoritos">
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


            .height-ultra {
                height: calc(100vh - 170px);
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
                min-width: 50px;
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





            .produtos-page .option-content {
                margin: 0 5px 0 20px;
            }

            .produtos-page .option.selected .option-content {
                margin: 0 5px 0 12px;
            }


            .produtos-page .option.category-option.selected .option-content {
                margin: 0 5px 0 5px;
            }
        </style>

        <!-- Menu lateral -->
        <x-sidebar activeItem="favoritos" />


        <!-- Conteúdo principal -->
        <section class="flex-1 flex flex-col overflow-hidden">
            @php

                $currentUrl = request()->path();
                $currentUrlComplete = request()->path();
                $currentSlug = '';

                //dd($currentSlug);

            @endphp
            <!-- Filtros superiores -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pt-4 pb-3 pr-4">
                <!-- Esquerda: Coleção e Categoria (FLEXÍVEL) -->
                <div class="filters-left-section">
                    <!-- Coleção (largura fixa baseada no conteúdo) -->
                    <div class="select-container">
                        <div class="select-button p-5" id="colecaoSelectButton">

                            <span class="text-[16px]" id="colecaoSelectedText">
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
                        <div class="options p-5 min-w-[200px]" id="colecaoOptions">
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

                    <!-- Categoria (OCUPA O ESPAÇO RESTANTE) -->
                    <div class="relative category-select-wrapper">
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
                        <div class="options min-w-[250px] p-5 custom-scrollbar" id="categoryOptions" style="">
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
                                        <span class="arrow-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                                viewBox="0 0 12 8" fill="none">
                                                <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" />
                                            </svg>
                                        </span>
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
                                                    <span class="">Todas</span>
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
                                <span class="option-content">Todas</span>
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

                    <!--<label class="inline-flex items-center text-sm bg-white px-[20px] py-[10px] rounded-lg">
                        <span class="text-base mr-1">Agrupar cores</span>
                        <input id="groupColors" type="checkbox"
                            class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative">
                    </label>-->

                    <div class="filter-container">
                        <div class="filter-button" id="filterButton">
                            <span id="filterText" class="text-[1rem] leading-[0px]">Filtrar</span>
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

                        <div class="filter-dropdown custom-scrollbar-wh" id="filterDropdown">
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
                                        class="filter-option" type="text" id="priceMin" placeholder="0,00"
                                        data-type="price" data-range="min">
                                    <span class="text-sm pt-2">até</span> <input style="width: 30%;"
                                        class="filter-option" type="text" id="priceMax" placeholder="999,99"
                                        data-type="price" data-range="max">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sort-container">
                        <div class="sort-button" id="sortButton">
                            <span class="text-black mr-2 text-[1rem] leading-[0px]">Ordenar por:</span>
                            <span id="sortText" class="text-[#7A7A7A] leading-[0px]"></span>
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
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4 gap-3 p-2 bg-[#E6E6E6] rounded-tl-lg overflow-auto custom-scrollbar height-ultra">

                <!-- Template de Produto -->
                <template id="template-produto">
                    <a href="" class="block">
                        <div class="bg-white shadow-sm hover:shadow-md transition relative rounded-md">
                            <div class="badge-container pt-1 px-2" style="position:absolute; min-height: 35px;">

                            </div>
                            <!-- Botão de Favoritos -->
                            <div class="absolute top-2 right-2">
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

                                        <p class="text-black opacity-50 mt-1 text-xs ">Segmentação</p>
                                        <p class="text-base collection text-black"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>


        </section>



        <!-- Botão flutuante para abrir filtros (mobile) -->
        <button class="mobile-filter-trigger" id="mobileFilterTrigger">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M2 4h16M6 10h8M9 16h2" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Filtros
            <span class="filter-badge" id="mobileBadge" style="display: none;">0</span>
        </button>

        <!-- Overlay -->
        <div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>

        <!-- Menu lateral mobile -->
        <div class="mobile-filter-menu" id="mobileFilterMenu">
            <!-- Header -->
            <div class="mobile-filter-header">
                <h2>Filtros</h2>
                <button class="mobile-filter-close" id="mobileFilterClose">&times;</button>
            </div>

            <!-- Conteúdo -->
            <div class="mobile-filter-content">
                <!-- Busca -->
                <div class="mobile-filter-section">
                    <div class="mobile-filter-section-title">Buscar</div>
                    <input type="text" class="mobile-search-input" id="mobileSearch"
                        placeholder="Buscar produto...">
                </div>

                <!-- Coleção -->
                <div class="mobile-filter-section">
                    <div class="mobile-filter-section-title">
                        Coleção
                        <button class="clear-btn" onclick="clearCollection()">Limpar</button>
                    </div>
                    <div class="mobile-select" onclick="toggleMobileSelect('collection')">
                        <span class="mobile-select-text" id="mobileCollectionText">Selecione uma coleção</span>
                        <span class="mobile-select-arrow">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                        </span>
                    </div>
                    <div class="mobile-select-options" id="mobileCollectionOptions">

                        @foreach ($colecoes as $colecao)
                            @if ($currentSlug == $colecao->slug)
                                <div class="mobile-select-option" onclick="selectCollection('{{ $colecao->name }}')">
                                    <span>{{ $colecao->name }}</span>
                                    <span style="display: none;">✓</span>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>

                <!-- Categoria -->
                <div class="mobile-filter-section">
                    <div class="mobile-filter-section-title">
                        Categoria
                        <button class="clear-btn" onclick="clearCategory()">Limpar</button>
                    </div>
                    <div class="mobile-select" onclick="toggleMobileSelect('category')">
                        <span class="mobile-select-text" id="mobileCategoryText">Todas as categorias</span>
                        <span class="mobile-select-arrow">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                        </span>
                    </div>
                    <div class="mobile-select-options" id="mobileCategoryOptions">
                        <div class="mobile-select-option" onclick="selectCategory('Todos', null)">
                            <span>Todos</span>
                            <span style="display: none;">✓</span>
                        </div>
                        @foreach ($categories as $category)
                            <div class="mobile-select-option"
                                onclick="selectCategory('{{ $category->name }}', '{{ $category->slug }}')">
                                <span>{{ $category->name }}</span>
                                <span style="display: none;">✓</span>
                            </div>
                        @endforeach
                        <div class="mobile-select-option" onclick="selectCategory('Corrida', 'running')">
                            <span>Corrida</span>
                            <span>→</span>
                        </div>
                        <div class="mobile-subcategory-list" id="subcategory-running">
                            <div class="mobile-subcategory-item" onclick="selectSubcategory('Corrida - Asfalto')">
                                Asfalto</div>
                            <div class="mobile-subcategory-item" onclick="selectSubcategory('Corrida - Trail')">Trail
                            </div>
                        </div>
                        <div class="mobile-select-option" onclick="selectCategory('Caminhada', null)">
                            <span>Caminhada</span>
                            <span style="display: none;">✓</span>
                        </div>
                        <div class="mobile-select-option" onclick="selectCategory('Casual', null)">
                            <span>Casual</span>
                            <span style="display: none;">✓</span>
                        </div>
                    </div>
                </div>

                <!-- Numeração/Tamanhos -->
                <div class="mobile-filter-section">
                    <div class="mobile-filter-section-title">
                        Numeração/Tamanhos
                        <button class="clear-btn" onclick="clearSizes()">Limpar</button>
                    </div>
                    <div class="mobile-filter-chips" id="mobileSizeChips">
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '35')">35</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '36')">36</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '37')">37</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '38')">38</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '39')">39</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '40')">40</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '41')">41</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '42')">42</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '43')">43</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'size', '44')">44</div>
                    </div>
                </div>

                <!-- Classificação -->
                <div class="mobile-filter-section">
                    <div class="mobile-filter-section-title">
                        Classificação
                        <button class="clear-btn" onclick="clearClassification()">Limpar</button>
                    </div>
                    <div class="mobile-filter-chips" id="mobileClassificationChips">
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'class', 'lancamento')">Lançamento
                        </div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'class', 'destaque')">Destaque</div>
                        <div class="mobile-filter-chip" onclick="toggleChip(this, 'class', 'promocao')">Promoção</div>
                    </div>
                </div>

                <!-- Valor -->
                <div class="mobile-filter-section">
                    <div class="mobile-filter-section-title">
                        Valor
                        <button class="clear-btn" onclick="clearPrice()">Limpar</button>
                    </div>
                    <div class="mobile-price-range">
                        <input type="text" class="mobile-price-input" id="mobilePriceMin" placeholder="0,00">
                        <span class="mobile-price-separator">até</span>
                        <input type="text" class="mobile-price-input" id="mobilePriceMax" placeholder="999,99">
                    </div>
                </div>

                <!-- Agrupar cores -->
                <div class="mobile-filter-section" style="border-bottom: none;">
                    <div class="mobile-checkbox-wrapper">
                        <input type="checkbox" class="mobile-checkbox" id="mobileGroupColors">
                        <label for="mobileGroupColors" class="mobile-checkbox-label">Agrupar cores</label>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mobile-filter-footer">
                <button class="mobile-filter-clear" onclick="clearAllFilters()">Limpar tudo</button>
                <button class="mobile-filter-apply" onclick="applyFilters()">Aplicar</button>
            </div>
        </div>


    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const produtosData = [
                    @foreach ($produtos as $produto)
                        @php
                            $img = '/images/produtos/' . $produto->product->code . '_' . str_replace('/', '_', $produto->color_code) . '.jpg';
                            $flagId = optional(optional($produto->color)->flagProduct)->id;
                            $numeracaoId = optional($produto->color)->numeracao_id;
                            $priceValue = (float) str_replace([','], ['.'], $produto->product->price);
                        @endphp {
                            id: "{{ $produto->product->id }}",
                            color_code: "{{ $produto->color_code }}",
                            title: "{{ $produto->product->name }}",
                            imagem: "{{ $img }}",
                            codigo: "{{ $produto->product->code }}",
                            'title-caract-1': "{{ $produto->product->caracteristicasDestaque->first()->title ?? '' }}",
                            'desc-caract-1': "{{ $produto->product->caracteristicasDestaque->first()->description ?? '' }}",
                            cor: "{{ $produto->color->color_name }}",
                            codigo_cor: "{{ str_replace('/', '_', $produto->color->color_code) }}",
                            numeracao: "{{ $produto->numeracao ? $produto->numeracao->numero : '' }}",
                            numeracao_id: {{ $numeracaoId ?? 'null' }},
                            categoria: "{{ $produto->product->category->name }}",
                            subcategory_id: "{{ $produto->product->subcategory_id ?? '' }}",
                            preco: "R${{ $produto->product->price }}",
                            price_value: {{ $priceValue ?: 0 }},
                            slug: "{{ $produto->product->slug }}",
                            slug_collection: "{{ $produto->color->collection->slug }}",
                            collection: "{{ $produto->color->collection->codigo_colecao }}",
                            segmento: "{{ $produto->product->category->segmentacao->slug }}",
                            classification_id: {{ $flagId ?? 'null' }},
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
                        // Agrupar por código de produto para consolidar variações de cor
                        const produtosPorCodigo = {};
                        produtos.forEach((p) => {
                            const key = String(p.codigo);
                            if (!produtosPorCodigo[key]) {
                                produtosPorCodigo[key] = p;
                            }
                        });
                        listaParaRenderizar = Object.values(produtosPorCodigo);
                    } else {
                        listaParaRenderizar = produtos;
                    }

                    listaParaRenderizar.forEach((produto) => {
                        //console.log(produto);
                        const clone = template.content.cloneNode(true);
                        const link = clone.querySelector("a");
                        link.href =
                            `/user/${produto.segmento}/colecoes/${produto.slug_collection}/${produto.codigo}/${produto.codigo_cor}`;
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
                                //console.log('clique ativo');
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
                let selectedSubcategory = '';

                const searchInput = document.getElementById('search');

                function filtrarProdutos(termo, categoria = '', colecao = '') {
                    return produtosData.filter(
                        (p) => {
                            const matchesTermo = p.cor.toLowerCase().includes(termo) ||
                                p.title.toLowerCase().includes(termo) ||
                                String(p.codigo).toLowerCase().includes(termo);
                            const matchesCategoria = categoria === '' || p.categoria === categoria;
                            const matchesSubcategoria = selectedSubcategory === '' || String(p.subcategory_id) ===
                                String(selectedSubcategory);
                            const matchesColecao = colecao === '' || p.slug_collection === colecao;

                            // Aplicar filtros avançados
                            const matchesFilters = aplicarFiltrosAvancados(p);

                            return matchesTermo && matchesCategoria && matchesSubcategoria && matchesColecao &&
                                matchesFilters;
                        }
                    );
                }

                function aplicarFiltrosAvancados(produto) {
                    // Filtro de numeração
                    if (selectedFilters.numeracao.length > 0) {
                        const numId = produto.numeracao_id;
                        if (!numId || !selectedFilters.numeracao.includes(String(numId))) {
                            return false;
                        }
                    }

                    // Filtro de classificação
                    if (selectedFilters.classification.length > 0) {
                        const classId = produto.classification_id;
                        if (!classId || !selectedFilters.classification.includes(String(classId))) {
                            return false;
                        }
                    }

                    // Filtro de preço
                    if (selectedFilters.price.min !== '' || selectedFilters.price.max !== '') {
                        const precoNum = typeof produto.price_value === 'number' ? produto.price_value : parseFloat(
                            String(produto.preco).replace('R$', '').replace('.', '').replace(',', '.'));
                        const min = selectedFilters.price.min !== '' ? parseFloat(selectedFilters.price.min.replace(',',
                            '.')) : 0;
                        const max = selectedFilters.price.max !== '' ? parseFloat(selectedFilters.price.max.replace(',',
                            '.')) : Infinity;

                        if (precoNum < min || precoNum > max) {
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
                    const termo = (searchInput?.value || '').trim().toLowerCase();
                    const categoria = selectedCategory;
                    const colecao = selectedCollection;
                    const agrupado = groupCheckbox ? groupCheckbox.checked : false;
                    let filtrados = filtrarProdutos(termo, categoria, colecao);
                    filtrados = applySorting(selectedSortValue, filtrados);
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
                            // Remove selection and reset collection filter
                            colecaoSelectedText.textContent = 'Selecione uma coleção';
                            selectedCollection = '';
                            option.querySelector('.option-content').style.margin = "0 20px";
                            option.querySelector('.check-icon').style.display = 'none';
                            option.querySelector('.x-icon').style.display = 'none';
                            closeColecaoDropdown();
                            aplicarFiltros();
                        }
                        return;
                    }

                    let option = e.target;

                    // Find the option element if clicked on child elements
                    if (!option.classList.contains('option')) {
                        option = option.closest('.option');
                        option.querySelector('.option-content').style.margin = "0 20px";
                    }

                    if (option && option.classList.contains('option')) {
                        // Remove selected state from all options
                        colecaoOptions.querySelectorAll('.option').forEach(opt => {
                            opt.classList.remove('selected');
                            opt.querySelector('.check-icon').style.display = 'none';
                            opt.querySelector('.x-icon').style.display = 'none';
                            opt.querySelector('.option-content').style.margin = "0 20px";
                        });

                        // Add selected state to clicked option
                        option.classList.add('selected');
                        option.querySelector('.check-icon').style.display = 'inline';
                        option.querySelector('.x-icon').style.display = 'inline-table';

                        const value = option.getAttribute('data-value');
                        const text = option.querySelector('.option-content').textContent;
                        option.querySelector('.option-content').style.margin = "0 20px 0 5px";
                        colecaoSelectedText.textContent = "Coleção:" + text;
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
                        closeFilterDropdown();
                        closeSortDropdown();
                    } else {
                        closeColecaoDropdown();
                        closeFilterDropdown();
                        closeSortDropdown();
                        openCategoryDropdown();
                    }
                });

                categoryOptions.addEventListener('click', function(e) {
                    // Tratar cliques em subcategorias primeiro
                    const subOption = e.target.closest('.subcategory-option');
                    if (subOption) {
                        e.stopPropagation();
                        // limpar seleção anterior
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
                        if (xi) xi.style.display = 'inline';

                        selectedSubcategory = subOption.getAttribute('data-value') || '';
                        closeCategoryDropdown();
                        aplicarFiltros();
                        return;
                    }
                    // Handle X icon click to remove selection (categoria ou subcategoria)
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


                        // Resetar filtros de categoria e subcategoria
                        categorySelectedText.textContent = 'Categoria';
                        selectedCategory = '';
                        selectedSubcategory = '';

                        closeCategoryDropdown();
                        aplicarFiltros();
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
                        option.querySelector('.x-icon').style.display = 'inline-table';

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
                    numeracao: [],
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
                        closeSortDropdown();
                        closeCategoryDropdown();
                    } else {
                        openFilterDropdown();
                        closeSortDropdown();
                        closeCategoryDropdown();
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
                        aplicarFiltros();
                    });
                });

                // Handle price input changes
                const priceInputs = document.querySelectorAll('input[data-type="price"]');
                priceInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        const range = this.dataset.range;
                        selectedFilters.price[range] = this.value;
                        updateFilterCount();
                        aplicarFiltros();
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
                    const totalSelected = selectedFilters.numeracao.length +
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
                // Toggle sort dropdown
                sortButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = sortDropdown.classList.contains('show');

                    if (isOpen) {
                        closeSortDropdown();
                        closeCategoryDropdown();
                        closeFilterDropdown();
                    } else {
                        closeCategoryDropdown();
                        closeFilterDropdown();
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

                        // Reaplicar filtros para refletir a ordenação
                        aplicarFiltros();

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

                function applySorting(sortValue, lista) {
                    const arr = [...lista];
                    switch (sortValue) {
                        case 'maior-valor':
                            arr.sort((a, b) => (b.price_value || 0) - (a.price_value || 0));
                            break;
                        case 'menor-valor':
                            arr.sort((a, b) => (a.price_value || 0) - (b.price_value || 0));
                            break;
                        case 'a-z':
                            arr.sort((a, b) => a.title.localeCompare(b.title));
                            break;
                        case 'z-a':
                            arr.sort((a, b) => b.title.localeCompare(a.title));
                            break;
                        default:
                            // Para 'mais-nova', 'mais-antiga' e outras sem dados, manter ordem atual
                            break;
                    }
                    return arr;
                }

                // Close dropdowns when clicking outside
                document.addEventListener('click', function() {
                    closeColecaoDropdown();
                    closeCategoryDropdown();
                    closeFilterDropdown();
                    closeSortDropdown();
                });

                // Event listeners for filters
                if (searchInput) {
                    searchInput.addEventListener("input", aplicarFiltros);
                }
                if (groupCheckbox) {
                    groupCheckbox.addEventListener("change", aplicarFiltros);
                }
            });
        </script>
    @endpush

</x-layout-user>
