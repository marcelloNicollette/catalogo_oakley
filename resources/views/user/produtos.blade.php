<x-layout-user title="Oakley - Produtos">
    @php
        $userWishlist = [];
        if (Illuminate\Support\Facades\Auth::check()) {
            $userWishlist = \App\Models\Wishlist::where('user_id', Illuminate\Support\Facades\Auth::id())
                ->get(['product_id', 'color_code'])
                ->map(function ($item) {
                    return $item->product_id . '-' . str_replace('/', '_', $item->color_code);
                })
                ->toArray();
        }
    @endphp
    <main class="lg:flex flex-1 produtos-page">
        <style>
            @keyframes favFadeIn {
                from {
                    opacity: 0
                }

                to {
                    opacity: 1
                }
            }

            @keyframes favFadeOut {
                from {
                    opacity: 1
                }

                to {
                    opacity: 0
                }
            }

            .fade-in {
                animation: favFadeIn 400ms ease-in forwards;
            }

            .fade-out {
                animation: favFadeOut 400ms ease-out forwards;
            }

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
                font-size: 22px;
                font-style: normal;
                line-height: 20px;
                /* 90.909% */
                letter-spacing: -0.66px;
                text-transform: uppercase;
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
                height: calc(100vh - 160px);
                padding-bottom: 100px;
                /* ← adicionar isso */
            }

            #pedidoOverlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.55);

                z-index: 900;
            }

            body.pedido-mode #pedidoOverlay {
                display: block;
            }

            body.pedido-mode #produtos {
                position: relative;
            }

            body.pedido-mode #produtos>a {
                position: relative;
                z-index: 910;
            }

            #pedidoModal {
                display: none;
                position: fixed;
                inset: 0;
                background: #FFF;

                z-index: 980;
            }

            #pedidoModal.active {
                display: block;
            }

            #pedidoModalCard {
                background: #fff;
                width: 100%;
                height: 100%;
                border-radius: 14px;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }

            #pedidoModalHeader {
                display: flex;
                align-items: center;
                justify-content: end;
                gap: 16px;
                padding: 18px 24px;
            }

            #pedidoModalBody {
                flex: 1;
                overflow: auto;
                padding: 0 24px;
                width: 80vw;
                margin: 0 auto;
                text-align: center;
                scrollbar-width: none;
            }

            #pedidoModalBody h3 {
                font-size: 22px;
                margin: 0;
                font-weight: 400;
                color: #000;
                min-width: 450px;
                padding: 5px;

                color: #021489;
                font-family: 'AktivGrotesk', Arial, sans-serif;
                font-style: normal;
                line-height: 20px;
                /* 90.909% */
            }

            #pedidoTitleRow {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin: 18px auto;
            }

            #pedidoSaveBtn {

                color: #000;
                font-family: Roboto;
                font-size: 12px;
                font-style: normal;
                font-weight: 400;
                line-height: 15px;
                /* 125% */
                text-decoration-line: underline;
                text-decoration-style: solid;
                text-decoration-skip-ink: auto;
                text-decoration-thickness: auto;
                text-underline-offset: auto;
                text-underline-position: from-font;
                display: flex;
                gap: 4px;
            }

            #pedidoTitleRow svg,
            #pedidoTitleRow h3,
            #pedidoTitleRow button {
                align-self: baseline;
            }

            .pedido-modal-row {
                display: grid;
                grid-template-columns: 74px minmax(300px, 4fr) 1fr 1fr 1fr 1fr 1fr 1fr auto;
                gap: 14px;
                align-items: center;
                border-bottom: 1px solid #ececec;
                padding: 10px 0;
                min-width: 1120px;
            }

            .pedido-modal-thumb {
                width: 61px;
                object-fit: contain;
            }

            .pedido-modal-title {
                overflow: hidden;
                text-overflow: ellipsis;
                color: #000;
                text-overflow: ellipsis;
                white-space: nowrap;
                font-family: 'AktivGrotesk', Arial, sans-serif;
                font-size: 20px;
                font-style: normal;
                font-weight: bold;
                line-height: 24px;
                /* 120% */
                letter-spacing: -0.6px;
                text-transform: uppercase;
                text-align: left;
            }

            .pedido-modal-col {
                font-size: 14px;
                color: #000;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .pedido-modal-col.is-black {
                color: #000;
            }

            .pedido-modal-col.is-12px {
                font-size: 12px;
            }

            .pedido-modal-col.is-opacity {
                opacity: 0.5;
            }

            .pedido-modal-price {
                font-size: 16px;
                color: #000;
                white-space: nowrap;
            }

            .pedido-modal-price.is-16px {
                font-size: 16px;
            }

            .pedido-modal-remove {
                color: #000;
                opacity: 0.5;
                cursor: pointer;
                padding: 0;
                white-space: nowrap;
                font-family: Roboto;
                font-size: 14px;
                font-style: normal;
                font-weight: 400;
                line-height: 14px;
                /* 100% */
                text-decoration-line: underline;
                text-decoration-style: solid;
                text-decoration-skip-ink: auto;
                text-decoration-thickness: auto;
                text-underline-offset: auto;
                text-underline-position: from-font;
            }

            #pedidoModalEmpty {
                display: none;
                padding: 36px 8px;
                text-align: center;
                color: #666;
                font-size: 18px;
            }

            #pedidoModalFooter {
                padding: 14px 24px 20px;
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin: 0 auto;
            }

            .pedido-scroll-wrapper {
                flex: 1;
                display: flex;
                overflow: hidden;
                min-height: 0;
                width: 80vw;
                margin: 0 auto;
                text-align: center;
            }

            #pedidoModalBody::-webkit-scrollbar {
                display: none;
            }

            .pedido-custom-scrollbar {
                width: 10px;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 4px 0;
                gap: 2px;
                flex-shrink: 0;
            }

            .pedido-scroll-btn {
                width: 10px;
                height: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                user-select: none;
                flex-shrink: 0;
            }

            .pedido-scroll-track {
                flex: 1;
                width: 4px;
                background: transparent;
                border-radius: 999px;
                position: relative;
                cursor: pointer;
            }

            .pedido-scroll-thumb {
                width: 4px;
                background: #B4B2A9;
                border-radius: 999px;
                position: absolute;
                left: 0;
                top: 0;
                cursor: grab;
                transition: background 0.15s;
            }

            .pedido-scroll-thumb:hover {
                background: #888780;
            }

            .pedido-modal-cta {
                border-radius: 100px;
                border: 1px solid #000;
                padding: 18px 26px;
                background: #fff;
                color: #000;
                font-size: 16px;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                white-space: nowrap;
                line-height: 16px;
                font-weight: 400;
            }

            .pedido-modal-cta.is-dark {
                background: #000;
                color: #fff;
            }

            .pedido-modal-cta svg {
                display: block;
                flex: 0 0 auto;
            }

            body.pedido-modal-open {
                overflow: hidden;
            }

            #pedidoActions {
                position: fixed;
                right: 28px;
                bottom: 28px;
                display: flex;
                align-items: center;
                gap: 10px;
                z-index: 920;
            }

            #pedidoClearBtn {
                display: none;
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: #fff;
                color: #000;
                border: 1px solid #D9D9D9;
                cursor: pointer;
                display: none;
                align-items: center;
                justify-content: center;

                user-select: none;
                backdrop-filter: blur(2px);
                padding: 8.9px;
            }

            #pedidoClearBtn:focus {
                outline: none;
            }

            #pedidoClearBtn:focus-visible {
                outline: 2px solid rgba(0, 0, 0, 0.7);
                outline-offset: 3px;
            }

            #pedidoClearBtn svg {
                opacity: 0.75;
            }

            #pedidoHistoryBtn,
            #pedidoFavoritosBtn {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: #fff;
                color: #000;
                border: 1px solid #D9D9D9;
                cursor: pointer;
                display: none;
                align-items: center;
                justify-content: center;

                user-select: none;
                backdrop-filter: blur(2px);
                padding: 8.9px;
            }

            #pedidoFavoritosBtn .pedido-fav-icon-filled {
                display: none;
            }

            #pedidoFavoritosBtn .pedido-fav-icon-outline {
                display: block;
            }

            #pedidoFavoritosBtn.is-active .pedido-fav-icon-filled {
                display: block;
            }

            #pedidoFavoritosBtn.is-active .pedido-fav-icon-outline {
                display: none;
            }

            #pedidoHistoryModal {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.45);
                z-index: 981;
                align-items: center;
                justify-content: center;
                padding: 16px;
            }

            #pedidoHistoryModal.active {
                display: flex;
            }

            #pedidoHistoryModalCard {
                background: #fff;
                border-radius: 12px;
                width: 100%;
                max-width: 980px;
                padding: 24px;
                max-height: calc(100vh - 32px);
                display: flex;
                flex-direction: column;
            }

            #pedidoHistoryTableWrap {
                overflow: auto;
                max-height: calc(100vh - 280px);
                margin-top: 16px;
            }

            #pedidoHistoryTable {
                width: 100%;
                border-collapse: collapse;
            }

            #pedidoHistoryTable th,
            #pedidoHistoryTable td {
                text-align: left;
                padding: 10px 12px;
                border-bottom: 1px solid #eee;
                font-size: 14px;
            }

            .pedido-history-open-btn {
                color: #808080;
                text-decoration: underline;
                background: none;
                border: none;
                cursor: pointer;
                padding: 0;
            }

            .pedido-history-delete-btn {
                color: #808080;
                text-decoration: underline;
                background: none;
                border: none;
                cursor: pointer;
                padding: 0;
                margin-left: 14px;
            }

            #pedidoHistoryEmpty {
                display: none;
                text-align: center;
                color: #777;
                padding: 16px 0;
                font-size: 14px;
            }

            #pedidoFab {
                position: relative;
                width: 60px;
                height: 60px;
                border-radius: 10px;
                background: rgba(0, 0, 0, 0.20);
                backdrop-filter: blur(2px);
                color: #fff;
                border: 0;
                padding: 0;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: none;
                user-select: none;
            }

            body.pedido-mode #pedidoFab {
                background: #000;
            }

            #pedidoFabIcon {
                width: 23.6px;
                height: 23.5px;
                display: block;
            }

            #pedidoFab:focus {
                outline: none;
            }

            #pedidoFab:focus-visible {
                outline: 2px solid rgba(255, 255, 255, 0.9);
                outline-offset: 3px;
            }

            #pedidoCount {
                display: none;
                position: absolute;
                top: -6px;
                right: -6px;
                min-width: 22px;
                height: 22px;
                padding: 0 6px;
                border-radius: 999px;
                background: #fff;
                color: #000;
                font-size: 12px;
                font-weight: 600;
                align-items: center;
                justify-content: center;
                box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
            }

            .pedido-item-btn {
                display: none;
                position: absolute;
                top: 12px;
                right: 12px;
                width: 39px;
                height: 39px;
                border-radius: 4px;
                border: none;
                cursor: pointer;
                z-index: 30;
                font-size: 34px;
                line-height: 1;
                align-items: center;
                justify-content: center;
                color: #fff;
                background: rgba(0, 0, 0, 0.50);
                padding: 10px;
                font-weight: 300;
            }

            body.pedido-mode .pedido-item-btn {
                display: flex;
            }

            body.pedido-mode .favorite-btn {
                display: none !important;
            }

            .pedido-item-btn.is-added {
                background: rgba(0, 0, 0);
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

            @media (max-width: 1060px) {
                .fixed {
                    display: none;
                }

                .mobile-filter-trigger {
                    display: none;
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

            #vitrineModal {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.35);
                z-index: 982;
            }

            #vitrineModal.active {
                display: block;
            }

            #vitrineModalCard {
                background: #fff;
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }

            #vitrineModalHeader {
                display: flex;
                align-items: center;
                justify-content: end;
                gap: 16px;
                padding: 18px 24px;
            }

            #vitrineModalBody {
                flex: 1;
                overflow: hidden;
                padding: 0 20px 16px;
                width: 100%;
                margin: 0;
                text-align: center;
                display: flex;
                flex-direction: column;
                min-height: 0;
            }

            #vitrineTitleRow {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }

            #vitrineModalBody h3 {
                font-size: 22px;
                margin: 0;
                font-weight: 400;
                color: #021489;
                min-width: 450px;
                padding: 5px;
                font-family: 'AktivGrotesk', Arial, sans-serif;
                font-style: normal;
                line-height: 20px;
            }

            #vitrineTitleRow svg,
            #vitrineTitleRow h3 {
                align-self: baseline;
            }

            #vitrineGridWrap {
                width: 100%;
                height: 100%;
                margin: 0 auto 20px;
                border: 1px solid #D9D9D9;
                border-radius: 10px;

                display: block;
                overflow-x: hidden;
                overflow-y: auto;
                box-sizing: border-box;
                scrollbar-width: none;
                -ms-overflow-style: none;
                display: inline-flex;
                padding: 30px clamp(20px, 8vw, 100px) 0;
                flex-direction: column;
                align-items: center;
                gap: 30px;
            }

            #vitrineGridWrap::-webkit-scrollbar {
                width: 0;
                height: 0;
                display: none;
            }

            #vitrineGrid {
                min-width: 0;
                min-height: 0;
                justify-content: start;
                align-content: start;
                width: max-content;
                margin: 0 auto;

                display: inline-grid;
                row-gap: 3px;
                column-gap: 3px;
                grid-template-rows: none;
                grid-template-columns: none;
            }

            .vitrine-cell {
                border: 1px solid #D9D9D9;
                border-radius: 12px;
                overflow: hidden;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
                aspect-ratio: 1/1;

            }

            .vitrine-cell.is-over {
                outline: 1px solid rgba(0, 0, 0, 1);
                outline-offset: 0px;
                background: #fff;
            }

            .vitrine-cell img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                background: #fff;
            }

            .vitrine-remove {
                position: absolute;
                right: 8.5px;
                top: 8px;
                cursor: pointer;
            }

            .vitrine-cell.is-dragging .vitrine-remove {
                display: none;
            }

            .vitrine-controls {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 14px;
                flex-wrap: wrap;
                margin: 10px auto 0;
            }

            .vitrine-stepper {
                display: inline-flex;
                align-items: center;
                gap: 10px;
            }

            .vitrine-stepper span {
                color: #000;
                text-align: center;
                font-family: Roboto;
                font-size: 14px;
                font-style: normal;
                font-weight: 400;
                line-height: 16px;
                opacity: 0.5;
                /* 114.286% */
            }

            .vitrine-stepper button {

                border-radius: 4px;
                border: none;
                cursor: pointer;
                z-index: 30;
                font-size: 34px;
                line-height: 1;
                justify-content: center;
                color: #fff;
                background: rgba(0, 0, 0, 1);
                padding: 10px;
                font-weight: 300;
                display: flex;
                width: 31px;
                height: 31px;
                padding: 10px;
                align-items: center;
                gap: 10px;
            }

            .vitrine-stepper button:disabled {
                opacity: 0.35;
                cursor: not-allowed;
            }

            #vitrineProductsStrip {
                display: flex;
                justify-content: center;
                align-items: flex-start;
                gap: 2px;
                width: 100%;
                flex-wrap: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
                box-sizing: border-box;
                scroll-behavior: smooth;
            }

            #vitrineProductsStrip::-webkit-scrollbar {
                width: 0;
                height: 0;
                display: none;
            }

            #vitrineProductsStrip {
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .vitrine-strip-wrapper {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 6px;
                align-items: center;
            }

            .vitrine-custom-scrollbar {
                width: 80%;
                max-width: 880px;
                display: none;
                align-items: center;
                gap: 8px;
                padding: 0 8px 8px;
                box-sizing: border-box;
            }

            .vitrine-scroll-btn {
                width: 14px;
                height: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                user-select: none;
                flex-shrink: 0;
            }

            .vitrine-scroll-track {
                flex: 1;
                height: 4px;
                background: transparent;
                border-radius: 999px;
                position: relative;
                cursor: pointer;
            }

            .vitrine-scroll-thumb {
                height: 4px;
                background: #B4B2A9;
                border-radius: 999px;
                position: absolute;
                left: 0;
                top: 0;
                cursor: grab;
                transition: background 0.15s;
            }

            .vitrine-scroll-thumb:hover {
                background: #888780;
            }

            .vitrine-prod {
                display: flex;
                width: 82px;
                min-width: 82px;
                padding-bottom: 10px;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                flex: 0 0 auto;
            }

            .vitrine-prod:active {
                cursor: grabbing;
            }

            .vitrine-prod-thumb {
                width: 100%;
                height: 82px;
                align-self: stretch;
                aspect-ratio: 1/1;
                border-radius: 12px;
                border: 1px solid #D9D9D9;
            }

            .vitrine-prod-model,
            .vitrine-prod-color {
                color: #000;
                text-align: center;
                font-family: Roboto;
                font-size: 10px;
                font-style: normal;
                font-weight: 400;
                line-height: 12px;
                /* 120% */
                text-transform: uppercase;
            }

            .vitrine-prod-model {
                display: -webkit-box;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 2;
                overflow: hidden;
                text-overflow: ellipsis;
                max-height: 24px;
            }

            .vitrine-prod-color {
                color: rgba(0, 0, 0, 0.50);
                text-transform: capitalize;
            }

            #vitrineProductsEmpty {
                display: none;
                padding: 14px 8px 24px;
                text-align: center;
                color: #777;
                font-size: 14px;
            }

            @media (max-width: 1024px) {
                #vitrineGridWrap {
                    width: 100%;
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
                    if (count($parts) > 1) {
                        $currentSlug = $parts[3];
                    }
                }
            @endphp
            <!-- Filtros superiores -->
            <div
                class="fixed top-[70px] left-0 right-0 flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pt-4 pb-3 px-[10px] bg-white z-10">

                <!-- Esquerda: Coleção e Categoria (FLEXÍVEL) -->
                <div class="filters-left-section">
                    <!-- Coleção (largura fixa baseada no conteúdo) -->
                    <div class="select-container">
                        <div class="select-button p-5" id="colecaoSelectButton">
                            <span class="text-[16px] text-black">Coleção:</span>
                            <span class="text-[18px] text-[#7A7A7A]" id="colecaoSelectedText">
                                @if (!empty($currentSlug))
                                    @foreach ($colecoes as $colecao)
                                        @if ($currentSlug == $colecao->slug)
                                            @if ($colecao->description)
                                                {{ $colecao->name }} ({{ $colecao->description }})</>
                                            @else
                                                {{ $colecao->name }}
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                    Selecione uma coleção
                                @endif
                            </span>
                            <div class="pl-[5px]" id="colecaoArrow">
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
                                    data-collection-id="{{ $colecao->id }}" data-value="{{ $colecao->slug }}"
                                    {{ $currentSlug == $colecao->slug ? 'selected' : '' }}
                                    style=" {{ $currentSlug == $colecao->slug ? 'padding: 6px 15px 6px 1px;' : '' }}">
                                    <span class="check-icon"
                                        style="display: {{ $currentSlug == $colecao->slug ? 'inline; margin:0 5px 0 0 ;' : 'none' }};"><svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                            <path
                                                d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                        </svg></span>
                                    <span class="option-content"
                                        style="margin: {{ $currentSlug == $colecao->slug ? '0' : '0 20px' }};">
                                        @if ($colecao->description)
                                            {{ $colecao->name }}<span
                                                class="text-[14px] line-height-[16px] text-[#000] ml-[10px]">{{ $colecao->description }}</span>
                                        @else
                                            {{ $colecao->name }}
                                        @endif
                                    </span>
                                    <span class="x-icon"
                                        style="display: {{ $currentSlug == $colecao->slug ? 'inline-table' : 'none' }};">×</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

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
                            $availableSilhuetas = [];
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
                                        if (!empty($produto->silhueta)) {
                                            $availableSilhuetas[$produto->silhueta] = true;
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
                            $availableSilhuetas = array_keys($availableSilhuetas);
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

                            @if (!empty($availableSilhuetas))
                                <div class="filter-section">
                                    <label class="filter-label">Silhueta</label>
                                    <div class="filter-options" id="silhuetaOptions">
                                        @foreach ($availableSilhuetas as $silhueta)
                                            <div class="filter-option" data-type="silhueta"
                                                data-value="{{ $silhueta }}">{{ $silhueta }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

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
                class="gap-[10px] bg-white p-[10px] lg:mt-[4.8rem] overflow-auto height-ultra custom-scrollbar">

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
                                class="bg-white hover:shadow-md transition relative rounded-md border border-[#DEDEDE] flex flex-col group">
                                <div class="badge-container pt-2 px-2" style="">
                                </div>

                                <button
                                    class="favorite-btn absolute top-2 right-2 z-20 text-black hover:text-black transition-colors opacity-0 group-hover:opacity-100 transition-opacity duration-300 outline-none"
                                    type="button" onclick="event.preventDefault();">
                                    <!-- Ícone Outline (vazio) -->
                                    <svg class="icon-outline w-6 h-6 float-right" xmlns="http://www.w3.org/2000/svg"
                                        width="20" height="18" viewBox="0 0 20 18" fill="none">
                                        <path
                                            d="M0 5.92157C0 10.098 3.59517 14.2059 9.27492 17.7353C9.4864 17.8627 9.78852 18 10 18C10.2115 18 10.5136 17.8627 10.7351 17.7353C16.4048 14.2059 20 10.098 20 5.92157C20 2.45098 17.5529 0 14.29 0C12.427 0 10.9164 0.862745 10 2.18627C9.10373 0.872549 7.57301 0 5.70997 0C2.44713 0 0 2.45098 0 5.92157ZM1.62135 5.92157C1.62135 3.31373 3.35347 1.57843 5.68983 1.57843C7.58308 1.57843 8.6707 2.72549 9.31521 3.70588C9.58711 4.09804 9.75831 4.20588 10 4.20588C10.2417 4.20588 10.3927 4.08824 10.6848 3.70588C11.3797 2.7451 12.427 1.57843 14.3102 1.57843C16.6465 1.57843 18.3787 3.31373 18.3787 5.92157C18.3787 9.56863 14.4209 13.5 10.2115 16.2255C10.1108 16.2941 10.0403 16.3431 10 16.3431C9.95972 16.3431 9.88922 16.2941 9.79859 16.2255C5.57905 13.5 1.62135 9.56863 1.62135 5.92157Z"
                                            fill="black" />
                                    </svg>

                                    <span
                                        class="favorite-text text-sm opacity-50 float-left pt-[2px] pr-2 hidden rounded px-1 shadow-sm absolute right-8 w-max z-30 pointer-events-none">Adicionado
                                        aos Favoritos</span>
                                    <!-- Ícone Preenchido (solid) -->
                                    <svg class="icon-filled w-6 h-6 text-black hidden"
                                        xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                        viewBox="0 0 18 16" fill="none">
                                        <path
                                            d="M0 5.26362C0 8.97604 3.23565 12.6275 8.34743 15.7647C8.53776 15.878 8.80967 16 9 16C9.19033 16 9.46224 15.878 9.66163 15.7647C14.7643 12.6275 18 8.97604 18 5.26362C18 2.17865 15.7976 0 12.861 0C11.1843 0 9.82477 0.766885 9 1.94336C8.19335 0.775599 6.81571 0 5.13897 0C2.20242 0 0 2.17865 0 5.26362Z"
                                            fill="black" />
                                    </svg>
                                </button>

                                <button class="pedido-item-btn" type="button"
                                    aria-label="Adicionar ao pedido"></button>

                                <img src="/images/tenis-1.jpg" alt="Tênis"
                                    class="w-full object-contain rounded-t-md" />

                                <div class="p-4 flex-1 flex flex-col">
                                    <h2 class="notranslate title extra-black font-fko text-[28px] leading-[24px] pb-2">
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

                                            <p class="text-black opacity-50 mt-1 text-xs">PDV</p>
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

        <div id="pedidoOverlay" aria-hidden="true">
            <div class="flex justify-end" style="padding: 1.35rem 1.2rem">
                <button id="pedidoOverlayBackBtn" type="button" aria-label="Voltar"
                    class="flex items-center bg-white border border-black rounded-full px-4 py-2 text-sm hover:bg-gray-200 transition">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="ml-1 w-5 h-5" />
                </button>
            </div>
        </div>

        {{-- DEPOIS --}}
        <div id="pedidoModal" aria-hidden="true">
            <div id="pedidoModalCard">
                <div id="pedidoModalHeader">
                    <button id="pedidoModalBackBtn" type="button" aria-label="Voltar"
                        class="flex items-center bg-[#FFF] border border-black rounded-full px-4 py-2 text-sm hover:bg-gray-200 transition">
                        Voltar
                        <img src="/images/icon-voltar.png" alt="" class="ml-1 w-5 h-5" />
                    </button>
                </div>

                {{-- wrapper que cria a scrollbar customizada --}}
                <div class="pedido-scroll-wrapper">
                    <div id="pedidoModalBody">
                        <div id="pedidoTitleRow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="162" height="25"
                                viewBox="0 0 162 25" fill="none">
                                <path
                                    d="M114.907 14.9051C115.339 14.3924 115.586 13.7152 115.586 13.0063V10.3861H102.162V13.2975H109.579L103.083 20.462C102.651 20.9747 102.359 21.5886 102.359 22.3101V24.9747H115.777V22.0633H108.411L114.907 14.9051Z"
                                    fill="#021489" />
                                <path
                                    d="M154.958 13.3038C155.764 13.3038 156.418 13.962 156.418 14.7658V20.6076C156.418 21.4114 155.764 22.0696 154.951 22.0696H152.741C151.929 22.0696 151.275 21.4114 151.275 20.6076V14.7658C151.275 13.962 151.929 13.3038 152.741 13.3038H154.951M148.633 10.3924C147.014 10.3924 145.68 11.7025 145.68 13.3101V22.057C145.68 23.6709 147.014 24.981 148.633 24.981H159.085C160.705 24.981 162 23.6772 162 22.057V13.3101C162 11.6962 160.705 10.3924 159.085 10.3924H148.633Z"
                                    fill="#021489" />
                                <path
                                    d="M94.8339 10.3924H100.428V22.0633C100.428 23.6772 99.133 24.981 97.5137 24.981H94.8339V10.3924Z"
                                    fill="#021489" />
                                <path
                                    d="M120.476 24.981C118.857 24.981 117.53 23.6772 117.53 22.0633V10.3987H123.124V20.6076C123.124 21.4114 123.797 22.076 124.604 22.076H126.401C127.207 22.076 127.849 21.4177 127.849 20.6139V10.3987H140.847C142.467 10.3987 143.769 11.7089 143.769 13.3165V24.981H138.174V14.7595C138.174 13.9494 137.514 13.3038 136.707 13.3038H133.443V22.057C133.443 23.6709 132.148 24.9747 130.528 24.9747H120.476"
                                    fill="#021489" />
                                <path
                                    d="M86.6104 5.37342C84.5148 5.37342 82.6352 6.32279 81.4032 7.81646L67.1343 24.9747H75.2308L86.0579 11.9684C86.8708 11.0063 88.09 10.3861 89.4553 10.3861H92.3129L80.2284 24.9747H88.9155C90.9349 24.9747 92.5669 23.3418 92.5669 21.3228V5.37342H86.6167"
                                    fill="#021489" />
                                <path
                                    d="M68.271 7.82278L54.0021 24.981H62.0986L72.9257 11.9747C73.7385 11.0127 74.9578 10.3924 76.3231 10.3924H79.2696V5.37342H73.4845C71.389 5.37342 69.5157 6.32279 68.2774 7.81646"
                                    fill="#021489" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M26.1819 14.519C29.0395 14.6203 31.2303 14.3987 35.2119 13.5316C33.3322 14.9304 31.6748 17.4747 31.4907 19.4177C30.5 17.943 28.2076 15.6456 26.1819 14.5253M37.2122 25C36.4184 22.4684 35.25 16.7975 40.2793 13.2848C43.8672 10.7722 54.7705 7.8038 60.6063 5.67089L64.8038 0C60.8032 2.0443 55.6024 4.14557 50.8715 5.58861C40.3111 8.81646 33.9926 10.7278 25.858 10.8924C20.0031 11.0063 19.9206 8.24684 25.6167 3.31013C19.2157 5.78481 10.2683 8.71519 0 11.0127C9.16334 11.2722 16.1168 13.1266 20.2952 15.5443C26.2454 18.9873 27.6932 22.6076 28.3664 25H37.2122Z"
                                    fill="#021489" />
                            </svg>
                            <h3 class="p-0" id="titlePedido" contenteditable="true" spellcheck="false">AW26
                                Oportunidades_26052025_1</h3>
                            <button id="pedidoSaveBtn" type="button">Renomear <svg
                                    xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                    viewBox="0 0 15 15" fill="none">
                                    <path
                                        d="M2.38059 15H11.2813C12.6459 15 13.4344 14.2103 13.4344 12.6459V4.52788L12.2138 5.75052V12.5851C12.2138 13.3749 11.7892 13.7774 11.2661 13.7774H2.40333C1.64518 13.7774 1.22062 13.3749 1.22062 12.5851V3.96593C1.22062 3.17615 1.64518 2.76608 2.40333 2.76608H9.31006L10.5307 1.54344H2.38059C0.80364 1.54344 0 2.33322 0 3.89758V12.6459C0 14.2178 0.80364 15 2.38059 15ZM5.14025 10.0791L6.61866 9.43363L13.6998 2.34841L12.6611 1.32322L5.58756 8.4084L4.90522 9.83612C4.84457 9.9652 4.99621 10.1398 5.14025 10.0791ZM14.2608 1.79405L14.8066 1.23209C15.0645 0.958708 15.0645 0.594194 14.8066 0.343592L14.6323 0.161336C14.3972 -0.0740778 14.0258 -0.0437017 13.7756 0.199306L13.2221 0.746073L14.2608 1.79405Z"
                                        fill="black" />
                                </svg></button>
                        </div>
                        <div id="pedidoModalItems"></div>
                        <div id="pedidoModalEmpty">Nenhum item adicionado no pedido.</div>
                    </div>

                    {{-- scrollbar customizada --}}
                    <div class="pedido-custom-scrollbar">
                        <div class="pedido-scroll-btn" id="btnUp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="6" viewBox="0 0 7 6"
                                fill="none">
                                <path d="M3.46484 0L6.92895 6H0.000742197L3.46484 0Z" fill="#A9A9A9" />
                            </svg>
                        </div>
                        <div class="pedido-scroll-track" id="scrollTrack">
                            <div class="pedido-scroll-thumb" id="scrollThumb"></div>
                        </div>
                        <div class="pedido-scroll-btn" id="btnDown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="6" viewBox="0 0 7 6"
                                fill="none">
                                <path d="M3.46484 6L0.000742197 0H6.92895L3.46484 6Z" fill="#A9A9A9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div id="pedidoModalFooter">
                    <button type="button" class="pedido-modal-cta" id="pedidoModalVitrineBtn">
                        <svg width="29" height="18" viewBox="0 0 29 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.55838 8.20416H5.82661C7.43854 8.20416 8.38499 7.29256 8.38499 5.65754V2.56109C8.38499 0.926046 7.43854 0 5.82661 0H2.55838C0.946454 0 0 0.926046 0 2.56109V5.65754C0 7.29256 0.946454 8.20416 2.55838 8.20416ZM2.83936 6.22193C2.30698 6.22193 2.0408 5.94696 2.0408 5.39713V2.7926C2.0408 2.25724 2.30698 1.98232 2.83936 1.98232H5.54563C6.06323 1.98232 6.35899 2.25724 6.35899 2.7926V5.39713C6.35899 5.94696 6.06323 6.22193 5.54563 6.22193H2.83936ZM12.8511 8.20416H16.1341C17.746 8.20416 18.6777 7.29256 18.6777 5.65754V2.56109C18.6777 0.926046 17.746 0 16.1341 0H12.8511C11.2392 0 10.3075 0.926046 10.3075 2.56109V5.65754C10.3075 7.29256 11.2392 8.20416 12.8511 8.20416ZM13.132 6.22193C12.5997 6.22193 12.3335 5.94696 12.3335 5.39713V2.7926C12.3335 2.25724 12.5997 1.98232 13.132 1.98232H15.8531C16.3708 1.98232 16.6517 2.25724 16.6517 2.7926V5.39713C16.6517 5.94696 16.3708 6.22193 15.8531 6.22193H13.132ZM23.1734 8.20416H26.4415C28.0535 8.20416 29 7.29256 29 5.65754V2.56109C29 0.926046 28.0535 0 26.4415 0H23.1734C21.5614 0 20.6149 0.926046 20.6149 2.56109V5.65754C20.6149 7.29256 21.5614 8.20416 23.1734 8.20416ZM23.4543 6.22193C22.922 6.22193 22.641 5.94696 22.641 5.39713V2.7926C22.641 2.25724 22.922 1.98232 23.4543 1.98232H26.1606C26.6782 1.98232 26.9592 2.25724 26.9592 2.7926V5.39713C26.9592 5.94696 26.6782 6.22193 26.1606 6.22193H23.4543ZM2.55838 18H5.82661C7.43854 18 8.38499 17.074 8.38499 15.4389V12.3569C8.38499 10.7219 7.43854 9.79585 5.82661 9.79585H2.55838C0.946454 9.79585 0 10.7219 0 12.3569V15.4389C0 17.074 0.946454 18 2.55838 18ZM2.83936 16.0032C2.30698 16.0032 2.0408 15.7283 2.0408 15.193V12.6029C2.0408 12.0531 2.30698 11.7782 2.83936 11.7782H5.54563C6.06323 11.7782 6.35899 12.0531 6.35899 12.6029V15.193C6.35899 15.7283 6.06323 16.0032 5.54563 16.0032H2.83936ZM12.8511 18H16.1341C17.746 18 18.6777 17.074 18.6777 15.4389V12.3569C18.6777 10.7219 17.746 9.79585 16.1341 9.79585H12.8511C11.2392 9.79585 10.3075 10.7219 10.3075 12.3569V15.4389C10.3075 17.074 11.2392 18 12.8511 18ZM13.132 16.0032C12.5997 16.0032 12.3335 15.7283 12.3335 15.193V12.6029C12.3335 12.0531 12.5997 11.7782 13.132 11.7782H15.8531C16.3708 11.7782 16.6517 12.0531 16.6517 12.6029V15.193C16.6517 15.7283 16.3708 16.0032 15.8531 16.0032H13.132ZM23.1734 18H26.4415C28.0535 18 29 17.074 29 15.4389V12.3569C29 10.7219 28.0535 9.79585 26.4415 9.79585H23.1734C21.5614 9.79585 20.6149 10.7219 20.6149 12.3569V15.4389C20.6149 17.074 21.5614 18 23.1734 18ZM23.4543 16.0032C22.922 16.0032 22.641 15.7283 22.641 15.193V12.6029C22.641 12.0531 22.922 11.7782 23.4543 11.7782H26.1606C26.6782 11.7782 26.9592 12.0531 26.9592 12.6029V15.193C26.9592 15.7283 26.6782 16.0032 26.1606 16.0032H23.4543Z"
                                fill="black" />
                        </svg>
                        Vitrine
                    </button>
                    <button type="button" class="pedido-modal-cta is-dark" id="pedidoModalExportPdfBtn">PDF
                        <svg width="10" height="14" viewBox="0 0 10 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 7.65881C10 7.32784 9.76257 7.07121 9.43272 7.07121C9.27444 7.07121 9.12269 7.12527 9.01715 7.23333L7.51323 8.74611L5.15172 11.4002L5.52111 11.5353L5.58708 9.52273V0.621648C5.58708 0.277223 5.34302 0.0273438 5.00001 0.0273438C4.657 0.0273438 4.41293 0.277223 4.41293 0.621648V9.52273L4.4789 11.5353L4.85489 11.4002L2.48681 8.74611L0.982849 7.23333C0.883905 7.12527 0.725593 7.07121 0.567282 7.07121C0.237467 7.07121 0 7.32784 0 7.65881C0 7.82086 0.059367 7.96269 0.184697 8.09777L4.55806 12.5889C4.68338 12.7239 4.8351 12.7914 5.00001 12.7914C5.16491 12.7914 5.31663 12.7239 5.44196 12.5889L9.8219 8.09777C9.94726 7.96269 10 7.82086 10 7.65881ZM10 13.3925C10 13.0413 9.76916 12.7914 9.43272 12.7914H0.580476C0.237467 12.7914 0 13.0413 0 13.3925C0 13.7437 0.237467 14.0003 0.580476 14.0003H9.43272C9.76916 14.0003 10 13.7437 10 13.3925Z"
                                fill="white" />
                        </svg>
                    </button>
                    <button type="button" class="pedido-modal-cta is-dark"
                        id="pedidoModalExportPlanilhaBtn">Planilha
                        <svg width="10" height="14" viewBox="0 0 10 14" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 7.65881C10 7.32784 9.76257 7.07121 9.43272 7.07121C9.27444 7.07121 9.12269 7.12527 9.01715 7.23333L7.51323 8.74611L5.15172 11.4002L5.52111 11.5353L5.58708 9.52273V0.621648C5.58708 0.277223 5.34302 0.0273438 5.00001 0.0273438C4.657 0.0273438 4.41293 0.277223 4.41293 0.621648V9.52273L4.4789 11.5353L4.85489 11.4002L2.48681 8.74611L0.982849 7.23333C0.883905 7.12527 0.725593 7.07121 0.567282 7.07121C0.237467 7.07121 0 7.32784 0 7.65881C0 7.82086 0.059367 7.96269 0.184697 8.09777L4.55806 12.5889C4.68338 12.7239 4.8351 12.7914 5.00001 12.7914C5.16491 12.7914 5.31663 12.7239 5.44196 12.5889L9.8219 8.09777C9.94726 7.96269 10 7.82086 10 7.65881ZM10 13.3925C10 13.0413 9.76916 12.7914 9.43272 12.7914H0.580476C0.237467 12.7914 0 13.0413 0 13.3925C0 13.7437 0.237467 14.0003 0.580476 14.0003H9.43272C9.76916 14.0003 10 13.7437 10 13.3925Z"
                                fill="white" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="vitrineModal" aria-hidden="true">
            <div id="vitrineModalCard">
                <div id="vitrineModalHeader">
                    <button id="vitrineModalBackBtn" type="button" aria-label="Voltar"
                        class="flex items-center bg-[#FFF] border border-black rounded-full px-4 py-2 text-sm hover:bg-gray-200 transition">
                        Voltar
                        <img src="/images/icon-voltar.png" alt="" class="ml-1 w-5 h-5" />
                    </button>
                </div>
                <div id="vitrineModalBody">
                    <div id="vitrineGridWrap">
                        <div id="vitrineTitleRow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="162" height="25"
                                viewBox="0 0 162 25" fill="none">
                                <path
                                    d="M114.907 14.9051C115.339 14.3924 115.586 13.7152 115.586 13.0063V10.3861H102.162V13.2975H109.579L103.083 20.462C102.651 20.9747 102.359 21.5886 102.359 22.3101V24.9747H115.777V22.0633H108.411L114.907 14.9051Z"
                                    fill="#021489" />
                                <path
                                    d="M154.958 13.3038C155.764 13.3038 156.418 13.962 156.418 14.7658V20.6076C156.418 21.4114 155.764 22.0696 154.951 22.0696H152.741C151.929 22.0696 151.275 21.4114 151.275 20.6076V14.7658C151.275 13.962 151.929 13.3038 152.741 13.3038H154.951M148.633 10.3924C147.014 10.3924 145.68 11.7025 145.68 13.3101V22.057C145.68 23.6709 147.014 24.981 148.633 24.981H159.085C160.705 24.981 162 23.6772 162 22.057V13.3101C162 11.6962 160.705 10.3924 159.085 10.3924H148.633Z"
                                    fill="#021489" />
                                <path
                                    d="M94.8339 10.3924H100.428V22.0633C100.428 23.6772 99.133 24.981 97.5137 24.981H94.8339V10.3924Z"
                                    fill="#021489" />
                                <path
                                    d="M120.476 24.981C118.857 24.981 117.53 23.6772 117.53 22.0633V10.3987H123.124V20.6076C123.124 21.4114 123.797 22.076 124.604 22.076H126.401C127.207 22.076 127.849 21.4177 127.849 20.6139V10.3987H140.847C142.467 10.3987 143.769 11.7089 143.769 13.3165V24.981H138.174V14.7595C138.174 13.9494 137.514 13.3038 136.707 13.3038H133.443V22.057C133.443 23.6709 132.148 24.9747 130.528 24.9747H120.476"
                                    fill="#021489" />
                                <path
                                    d="M86.6104 5.37342C84.5148 5.37342 82.6352 6.32279 81.4032 7.81646L67.1343 24.9747H75.2308L86.0579 11.9684C86.8708 11.0063 88.09 10.3861 89.4553 10.3861H92.3129L80.2284 24.9747H88.9155C90.9349 24.9747 92.5669 23.3418 92.5669 21.3228V5.37342H86.6167"
                                    fill="#021489" />
                                <path
                                    d="M68.271 7.82278L54.0021 24.981H62.0986L72.9257 11.9747C73.7385 11.0127 74.9578 10.3924 76.3231 10.3924H79.2696V5.37342H73.4845C71.389 5.37342 69.5157 6.32279 68.2774 7.81646"
                                    fill="#021489" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M26.1819 14.519C29.0395 14.6203 31.2303 14.3987 35.2119 13.5316C33.3322 14.9304 31.6748 17.4747 31.4907 19.4177C30.5 17.943 28.2076 15.6456 26.1819 14.5253M37.2122 25C36.4184 22.4684 35.25 16.7975 40.2793 13.2848C43.8672 10.7722 54.7705 7.8038 60.6063 5.67089L64.8038 0C60.8032 2.0443 55.6024 4.14557 50.8715 5.58861C40.3111 8.81646 33.9926 10.7278 25.858 10.8924C20.0031 11.0063 19.9206 8.24684 25.6167 3.31013C19.2157 5.78481 10.2683 8.71519 0 11.0127C9.16334 11.2722 16.1168 13.1266 20.2952 15.5443C26.2454 18.9873 27.6932 22.6076 28.3664 25H37.2122Z"
                                    fill="#021489" />
                            </svg>
                            <h3 class="p-0" id="vitrineTitle" contenteditable="true" spellcheck="false">Vitrine
                            </h3>
                        </div>
                        <div id="vitrineGrid" role="grid" aria-label="Vitrine"></div>
                    </div>

                    <div class="vitrine-strip-wrapper" id="vitrineStripWrapper" aria-label="Produtos para arrastar">
                        <div id="vitrineProductsStrip"></div>
                        <div class="vitrine-custom-scrollbar" id="vitrineStripScrollbar" aria-hidden="true">
                            <div class="vitrine-scroll-btn" id="vitrineStripBtnLeft"
                                aria-label="Rolar para esquerda">
                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="6"
                                    viewBox="0 0 7 6" fill="none">
                                    <path d="M0.000742197 3L6.92895 6V0L0.000742197 3Z" fill="#A9A9A9" />
                                </svg>
                            </div>
                            <div class="vitrine-scroll-track" id="vitrineStripTrack">
                                <div class="vitrine-scroll-thumb" id="vitrineStripThumb"></div>
                            </div>
                            <div class="vitrine-scroll-btn" id="vitrineStripBtnRight"
                                aria-label="Rolar para direita">
                                <svg xmlns="http://www.w3.org/2000/svg" width="7" height="6"
                                    viewBox="0 0 7 6" fill="none">
                                    <path d="M6.92895 3L0.000742197 0V6L6.92895 3Z" fill="#A9A9A9" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div id="vitrineProductsEmpty">Nenhum produto no pedido para montar a vitrine.</div>

                    <div class="vitrine-controls" aria-label="Controles da vitrine">
                        <div class="vitrine-stepper">
                            <span>Linhas</span>
                            <button type="button" id="vitrineRowsMinusBtn" aria-label="Diminuir linhas">−</button>
                            <button type="button" id="vitrineRowsPlusBtn" aria-label="Aumentar linhas">+</button>
                        </div>
                        <div class="vitrine-stepper">
                            <span>Colunas</span>
                            <button type="button" id="vitrineColsMinusBtn" aria-label="Diminuir colunas">−</button>
                            <button type="button" id="vitrineColsPlusBtn" aria-label="Aumentar colunas">+</button>
                        </div>
                        <button type="button" class="pedido-modal-cta" id="vitrineAddAllBtn">Adicionar
                            todos</button>
                        <button type="button" class="pedido-modal-cta" id="vitrineRemoveAllBtn"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18"
                                fill="none">
                                <path
                                    d="M4.3719 3.69375H5.68595V1.96408C5.68595 1.50337 6.01653 1.20431 6.5124 1.20431H9.47108C9.96693 1.20431 10.2975 1.50337 10.2975 1.96408V3.69375H11.6115V1.88325C11.6115 0.71127 10.8347 0 9.56199 0H6.42149C5.14876 0 4.3719 0.71127 4.3719 1.88325V3.69375ZM0.619835 4.34036H15.3884C15.7273 4.34036 16 4.05747 16 3.72608C16 3.3947 15.7273 3.11989 15.3884 3.11989H0.619835C0.289256 3.11989 0 3.3947 0 3.72608C0 4.06555 0.289256 4.34036 0.619835 4.34036ZM4.21487 18H11.7934C12.9752 18 13.7686 17.2483 13.8265 16.0925L14.405 4.18679H13.0744L12.5207 15.9551C12.5042 16.44 12.1488 16.7795 11.6612 16.7795H4.33057C3.85951 16.7795 3.50413 16.4319 3.47934 15.9551L2.89256 4.18679H1.59504L2.18182 16.1006C2.23967 17.2563 3.01653 18 4.21487 18ZM5.55372 15.3974C5.86777 15.3974 6.07438 15.2034 6.06611 14.9205L5.80992 6.2721C5.80165 5.98921 5.59504 5.80331 5.29752 5.80331C4.98347 5.80331 4.77686 5.99729 4.78513 6.28019L5.03306 14.9205C5.04132 15.2115 5.24794 15.3974 5.55372 15.3974ZM8.00004 15.3974C8.31408 15.3974 8.53721 15.2034 8.53721 14.9205V6.28019C8.53721 5.99729 8.31408 5.80331 8.00004 5.80331C7.68592 5.80331 7.47111 5.99729 7.47111 6.28019V14.9205C7.47111 15.2034 7.68592 15.3974 8.00004 15.3974ZM10.4545 15.3974C10.7521 15.3974 10.9587 15.2115 10.967 14.9205L11.2148 6.28019C11.2232 5.99729 11.0165 5.80331 10.7025 5.80331C10.405 5.80331 10.1983 5.98921 10.1901 6.28019L9.94218 14.9205C9.93386 15.2034 10.1405 15.3974 10.4545 15.3974Z"
                                    fill="black" />
                            </svg> Remover todos</button>

                        <button type="button" class="pedido-modal-cta is-dark" id="vitrineExportPdfBtn">PDF
                            <svg width="10" height="14" viewBox="0 0 10 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 7.65881C10 7.32784 9.76257 7.07121 9.43272 7.07121C9.27444 7.07121 9.12269 7.12527 9.01715 7.23333L7.51323 8.74611L5.15172 11.4002L5.52111 11.5353L5.58708 9.52273V0.621648C5.58708 0.277223 5.34302 0.0273438 5.00001 0.0273438C4.657 0.0273438 4.41293 0.277223 4.41293 0.621648V9.52273L4.4789 11.5353L4.85489 11.4002L2.48681 8.74611L0.982849 7.23333C0.883905 7.12527 0.725593 7.07121 0.567282 7.07121C0.237467 7.07121 0 7.32784 0 7.65881C0 7.82086 0.059367 7.96269 0.184697 8.09777L4.55806 12.5889C4.68338 12.7239 4.8351 12.7914 5.00001 12.7914C5.16491 12.7914 5.31663 12.7239 5.44196 12.5889L9.8219 8.09777C9.94726 7.96269 10 7.82086 10 7.65881ZM10 13.3925C10 13.0413 9.76916 12.7914 9.43272 12.7914H0.580476C0.237467 12.7914 0 13.0413 0 13.3925C0 13.7437 0.237467 14.0003 0.580476 14.0003H9.43272C9.76916 14.0003 10 13.7437 10 13.3925Z"
                                    fill="white" />
                            </svg>
                        </button>
                        <button type="button" class="pedido-modal-cta is-dark" id="vitrineExportJpgBtn">JPG
                            <svg width="10" height="14" viewBox="0 0 10 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 7.65881C10 7.32784 9.76257 7.07121 9.43272 7.07121C9.27444 7.07121 9.12269 7.12527 9.01715 7.23333L7.51323 8.74611L5.15172 11.4002L5.52111 11.5353L5.58708 9.52273V0.621648C5.58708 0.277223 5.34302 0.0273438 5.00001 0.0273438C4.657 0.0273438 4.41293 0.277223 4.41293 0.621648V9.52273L4.4789 11.5353L4.85489 11.4002L2.48681 8.74611L0.982849 7.23333C0.883905 7.12527 0.725593 7.07121 0.567282 7.07121C0.237467 7.07121 0 7.32784 0 7.65881C0 7.82086 0.059367 7.96269 0.184697 8.09777L4.55806 12.5889C4.68338 12.7239 4.8351 12.7914 5.00001 12.7914C5.16491 12.7914 5.31663 12.7239 5.44196 12.5889L9.8219 8.09777C9.94726 7.96269 10 7.82086 10 7.65881ZM10 13.3925C10 13.0413 9.76916 12.7914 9.43272 12.7914H0.580476C0.237467 12.7914 0 13.0413 0 13.3925C0 13.7437 0.237467 14.0003 0.580476 14.0003H9.43272C9.76916 14.0003 10 13.7437 10 13.3925Z"
                                    fill="white" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="pedidoHistoryModal" aria-hidden="true">
            <div id="pedidoHistoryModalCard">
                <div class="flex justify-center items-center mb-4">
                    <h2 class="text-xl font-medium text-center">Histórico de Pedidos</h2>
                </div>
                <div class="flex items-center border-b border-b-black px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                            clip-rule="evenodd" />
                    </svg>
                    <input type="text" placeholder="Buscar" id="pedidoHistorySearchInput"
                        class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
                </div>
                <div id="pedidoHistoryTableWrap">
                    <table id="pedidoHistoryTable">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                                <th>Itens</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="pedidoHistoryTableBody"></tbody>
                    </table>
                    <div id="pedidoHistoryEmpty">Nenhum pedido salvo até o momento.</div>
                </div>
                <div class="pt-4 mt-2">
                    <div class="flex justify-center gap-4">
                        <button id="pedidoHistoryBackBtn" type="button"
                            class="flex items-center border border-black rounded-full px-6 py-3 text-sm">
                            Voltar
                            <img src="/images/icon-voltar.png" alt="" class="ml-2 w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="pedidoActions">


            <button id="pedidoHistoryBtn" type="button" aria-label="Histórico de pedidos">
                <img src="/images/icones/icone-pedido-history.svg" alt="" width="20" height="18" />
            </button>
            <button id="pedidoFavoritosBtn" type="button" aria-label="Favoritos">
                <svg class="pedido-fav-icon-outline" xmlns="http://www.w3.org/2000/svg" width="20"
                    height="18" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                        stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg class="pedido-fav-icon-filled" xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                    viewBox="0 0 18 16" fill="none">
                    <path
                        d="M0 5.26362C0 8.97604 3.23565 12.6275 8.34743 15.7647C8.53776 15.878 8.80967 16 9 16C9.19033 16 9.46224 15.878 9.66163 15.7647C14.7643 12.6275 18 8.97604 18 5.26362C18 2.17865 15.7976 0 12.861 0C11.1843 0 9.82477 0.766885 9 1.94336C8.19335 0.775599 6.81571 0 5.13897 0C2.20242 0 0 2.17865 0 5.26362Z"
                        fill="black" />
                </svg>
            </button>

            <button id="pedidoClearBtn" type="button" aria-label="Limpar pedido">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="18" viewBox="0 0 16 18"
                    fill="none">
                    <path
                        d="M4.3719 3.69375H5.68595V1.96408C5.68595 1.50337 6.01653 1.20431 6.5124 1.20431H9.47108C9.96693 1.20431 10.2975 1.50337 10.2975 1.96408V3.69375H11.6115V1.88325C11.6115 0.71127 10.8347 0 9.56199 0H6.42149C5.14876 0 4.3719 0.71127 4.3719 1.88325V3.69375ZM0.619835 4.34036H15.3884C15.7273 4.34036 16 4.05747 16 3.72608C16 3.3947 15.7273 3.11989 15.3884 3.11989H0.619835C0.289256 3.11989 0 3.3947 0 3.72608C0 4.06555 0.289256 4.34036 0.619835 4.34036ZM4.21487 18H11.7934C12.9752 18 13.7686 17.2483 13.8265 16.0925L14.405 4.18679H13.0744L12.5207 15.9551C12.5042 16.44 12.1488 16.7795 11.6612 16.7795H4.33057C3.85951 16.7795 3.50413 16.4319 3.47934 15.9551L2.89256 4.18679H1.59504L2.18182 16.1006C2.23967 17.2563 3.01653 18 4.21487 18ZM5.55372 15.3974C5.86777 15.3974 6.07438 15.2034 6.06611 14.9205L5.80992 6.2721C5.80165 5.98921 5.59504 5.80331 5.29752 5.80331C4.98347 5.80331 4.77686 5.99729 4.78513 6.28019L5.03306 14.9205C5.04132 15.2115 5.24794 15.3974 5.55372 15.3974ZM8.00004 15.3974C8.31408 15.3974 8.53721 15.2034 8.53721 14.9205V6.28019C8.53721 5.99729 8.31408 5.80331 8.00004 5.80331C7.68592 5.80331 7.47111 5.99729 7.47111 6.28019V14.9205C7.47111 15.2034 7.68592 15.3974 8.00004 15.3974ZM10.4545 15.3974C10.7521 15.3974 10.9587 15.2115 10.967 14.9205L11.2148 6.28019C11.2232 5.99729 11.0165 5.80331 10.7025 5.80331C10.405 5.80331 10.1983 5.98921 10.1901 6.28019L9.94218 14.9205C9.93386 15.2034 10.1405 15.3974 10.4545 15.3974Z"
                        fill="black" />
                </svg>
            </button>
            <button id="pedidoFab" type="button" aria-label="Pedido" aria-expanded="false">
                <span id="pedidoCount" aria-hidden="true"></span>
                <img id="pedidoFabIcon" src="/images/icones/icone-pedido.svg" alt="" />
            </button>
        </div>



    </main>

    @push('scripts')
        <script>
            const userWishlist = @json($userWishlist);
            const currentCollectionSlug = @json($currentSlug);
            const produtosData = [
                @if (!empty($produtos) && count($produtos) > 0)
                    @foreach ($produtos as $produtoGroup)
                        @if ($produtoGroup && $produtoGroup->product)
                            @php
                                $produto = $produtoGroup->product;
                                $imgPath = '/images/produtos/' . $produto->code . '_' . str_replace('/', '_', $produtoGroup->color_code) . '_A.jpg';
                                $imgFullPath = public_path($imgPath);
                                $img = file_exists($imgFullPath) ? $imgPath : '/images/img-padrao-mz.png';
                                $numeracaoIdsProduct = $produto->numeracoes ? $produto->numeracoes->pluck('id')->toArray() : [];
                                $numeracaoIdColor = $produtoGroup->numeracao ? $produtoGroup->numeracao->id : null;
                                $numeracaoIds = $numeracaoIdsProduct;
                                if ($numeracaoIdColor) {
                                    $numeracaoIds[] = $numeracaoIdColor;
                                }
                                $numeracaoIds = array_values(array_unique($numeracaoIds));
                                $tamanhoIds = $produto->sizes ? $produto->sizes->pluck('id')->toArray() : [];
                                $precoNumerico = $produto->price ?? 0;
                                $badges = $produtoGroup->flagProducts
                                    ? $produtoGroup->flagProducts
                                        ->map(function ($flag) {
                                            return [
                                                'id' => $flag->id,
                                                'title' => $flag->flag_title ?? '',
                                                'icon' => $flag->icon ?? '',
                                                'bg' => $flag->flag_bg ?? '',
                                                'color' => $flag->flag_color_text_bg ?? '',
                                                'align' => $flag->alinhamento ?? '',
                                                'orderfilterflag' => $flag->orderfilterflag ?? 0,
                                            ];
                                        })
                                        ->values()
                                        ->toArray()
                                    : [];
                                $firstBadge = !empty($badges) ? $badges[0] : null;
                                $classificacaoId = $firstBadge ? $firstBadge['id'] ?? null : ($produtoGroup->flagProduct ? $produtoGroup->flagProduct->id : null);
                                $segmentacaoIds = $produtoGroup->segmentacoesCliente ? $produtoGroup->segmentacoesCliente->pluck('id')->toArray() : [];
                            @endphp {
                                id: {{ $produto->id }},
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
                                precoNumerico: "{{ $produto->price ?? 0 }}",
                                genero: "{{ $produtoGroup->genero ?? '' }}",
                                silhueta: "{{ $produto->silhueta ?? '' }}",
                                linha: "{{ $produto->linha ?? '' }}",
                                numeracaoIds: @json($numeracaoIds),
                                tamanhoIds: @json($tamanhoIds),
                                classificacaoId: {{ $classificacaoId ?? 'null' }},
                                segmentacaoIds: @json($segmentacaoIds),
                                badges: @json($badges),
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
            const pedidoFab = document.getElementById("pedidoFab");
            const pedidoOverlay = document.getElementById("pedidoOverlay");
            const pedidoCountEl = document.getElementById("pedidoCount");
            const pedidoClearBtn = document.getElementById("pedidoClearBtn");
            const pedidoHistoryBtn = document.getElementById("pedidoHistoryBtn");
            const pedidoFavoritosBtn = document.getElementById("pedidoFavoritosBtn");
            const pedidoFabIcon = document.getElementById("pedidoFabIcon");
            const pedidoOverlayBackBtn = document.getElementById("pedidoOverlayBackBtn");
            const pedidoModal = document.getElementById("pedidoModal");
            const pedidoModalBackBtn = document.getElementById("pedidoModalBackBtn");
            const pedidoModalItems = document.getElementById("pedidoModalItems");
            const pedidoModalEmpty = document.getElementById("pedidoModalEmpty");
            const titlePedidoEl = document.getElementById("titlePedido");
            const pedidoSaveBtn = document.getElementById("pedidoSaveBtn");
            const pedidoHistoryModal = document.getElementById("pedidoHistoryModal");
            const pedidoHistoryBackBtn = document.getElementById("pedidoHistoryBackBtn");
            const pedidoHistorySearchInput = document.getElementById("pedidoHistorySearchInput");
            const pedidoHistoryTableBody = document.getElementById("pedidoHistoryTableBody");
            const pedidoHistoryEmpty = document.getElementById("pedidoHistoryEmpty");

            const pedidoIconDefaultSrc = "/images/icones/icone-pedido.svg";
            const pedidoIconSelectedSrc = "/images/icones/icone-pedido.svg";

            const pedidoStorageKey = "pedido_itens_ua_v1";
            let pedidoItens = carregarPedidoItens();
            let pedidosHistorico = [];

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

                    const badges = Array.isArray(produto.badges) && produto.badges.length ? produto.badges : (
                        produto.badge_title ? [{
                            title: produto.badge_title,
                            icon: produto.badge_icon,
                            bg: produto.badge_bg,
                            color: produto.badge_color,
                            align: produto.badge_icon_align
                        }] : []
                    );

                    if (badges.length) {
                        badgeContainer.innerHTML = "";

                        const align = (badges[0] && badges[0].align) ? badges[0].align : produto.badge_icon_align;
                        if (align == "right") {
                            badgeContainer.style.right = "0px";
                            badgeContainer.style.left = "";
                        }
                        if (align == "left") {
                            badgeContainer.style.left = "0px";
                            badgeContainer.style.right = "";
                        }

                        badges.forEach((badgeData) => {
                            const title = badgeData && badgeData.title ? badgeData.title : "";
                            if (!title) return;

                            const icon = badgeData && badgeData.icon ? badgeData.icon : "";
                            const bg = badgeData && badgeData.bg ? badgeData.bg : "";
                            const color = badgeData && badgeData.color ? badgeData.color : "";

                            if (icon) {
                                const badgeIconWrapper = document.createElement("div");
                                badgeIconWrapper.className = "badge-icon-wrapper";
                                badgeIconWrapper.style.position = "relative";
                                badgeIconWrapper.style.display = "block";

                                const badgeIcon = document.createElement("img");
                                badgeIcon.className = "badge-icon";
                                badgeIcon.src = "/" + icon;
                                badgeIcon.alt = title;
                                badgeIcon.style.width = "19px";
                                badgeIcon.style.height = "19px";

                                const badge = document.createElement("span");
                                badge.className = "badge-tooltip";
                                badge.textContent = title;
                                badge.style.backgroundColor = "transparent";
                                badge.style.color = color;
                                badge.style.fontSize = "10px";

                                badgeIconWrapper.appendChild(badgeIcon);
                                badgeIconWrapper.appendChild(badge);
                                badgeContainer.appendChild(badgeIconWrapper);
                            } else {
                                const badge = document.createElement("span");
                                badge.className = "badge";
                                badge.textContent = title;
                                badge.style.backgroundColor = bg;
                                badge.style.color = color;
                                //badge.style.display = "block";
                                badgeContainer.appendChild(badge);
                            }
                        });
                    }

                    // Lógica de Favoritos
                    const favBtn = clone.querySelector('.favorite-btn');
                    const iconOutline = clone.querySelector('.icon-outline');
                    const iconFilled = clone.querySelector('.icon-filled');
                    const favText = clone.querySelector('.favorite-text');

                    const prodKey = `${produto.id}-${produto.codigo_cor}`;

                    const pedidoBtn = clone.querySelector('.pedido-item-btn');
                    if (pedidoBtn) {
                        pedidoBtn.dataset.prodKey = prodKey;
                        aplicarEstadoPedidoBtn(pedidoBtn, prodKey);
                        pedidoBtn.onclick = function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            if (pedidoItens.has(prodKey)) {
                                pedidoItens.delete(prodKey);
                            } else {
                                pedidoItens.set(prodKey, {
                                    key: prodKey,
                                    product_id: produto.id,
                                    color_code: produto.codigo_cor,
                                    title: produto.title,
                                    imagem: produto.imagem,
                                    categoria: produto.categoria,
                                    genero: produto.genero,
                                    codigo: produto.codigo,
                                    cor: produto.cor,
                                    numeracao: produto.numeracao,
                                    preco: produto.preco
                                });
                            }
                            salvarPedidoItens();
                            aplicarEstadoPedidoBtn(pedidoBtn, prodKey);
                            atualizarPedidoBadge();
                            if (pedidoModal && pedidoModal.classList.contains('active')) {
                                renderPedidoModal();
                            }
                        };
                    }

                    link.addEventListener('click', (e) => {
                        if (document.body.classList.contains('pedido-mode')) {
                            e.preventDefault();
                            e.stopPropagation();
                        }
                    });

                    // Verifica se userWishlist está definido (pode estar vazio se não logado)
                    const isFavorited = (typeof userWishlist !== 'undefined' && Array.isArray(userWishlist)) ?
                        userWishlist.includes(prodKey) :
                        false;

                    if (isFavorited) {
                        iconFilled.classList.remove('hidden');
                        iconOutline.classList.add('hidden');
                        favBtn.classList.add('favorited');
                    } else {
                        iconFilled.classList.add('hidden');
                        iconOutline.classList.remove('hidden');
                        favBtn.classList.remove('favorited');
                    }

                    favBtn.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Verificar login (se userWishlist não existir ou auth falhar no back)
                        // Como injetamos userWishlist via PHP auth check, se for vazio pode ser user não logado ou sem favoritos.
                        // O backend vai retornar 401 se não logado.

                        const isFav = !iconFilled.classList.contains('hidden');
                        const url = isFav ? '/user/wishlist/remove' : '/user/wishlist/add';
                        const method = isFav ? 'DELETE' : 'POST';

                        // Optimistic UI update
                        if (isFav) {
                            iconFilled.classList.add('hidden');
                            iconOutline.classList.remove('hidden');
                            favText.textContent = 'Removido dos Favoritos';

                            if (typeof userWishlist !== 'undefined') {
                                const idx = userWishlist.indexOf(prodKey);
                                if (idx > -1) userWishlist.splice(idx, 1);
                            }
                        } else {
                            iconFilled.classList.remove('hidden');
                            iconOutline.classList.add('hidden');
                            favText.textContent = 'Adicionado aos Favoritos';

                            if (typeof userWishlist !== 'undefined') {
                                userWishlist.push(prodKey);
                            }
                        }

                        // Mostrar texto
                        favText.classList.remove('hidden', 'fade-out');
                        favText.classList.add('fade-in');

                        if (favBtn.msgTimeout) clearTimeout(favBtn.msgTimeout);

                        favBtn.msgTimeout = setTimeout(() => {
                            favText.classList.remove('fade-in');
                            favText.classList.add('fade-out');
                            setTimeout(() => {
                                favText.classList.add('hidden');
                                favText.classList.remove('fade-out');
                            }, 400);
                        }, 2000);

                        fetch(url, {
                                method: method,
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    product_id: produto.id,
                                    color_code: produto.codigo_cor
                                })
                            }).then(res => {
                                if (res.status === 401) {
                                    alert('Você precisa estar logado para favoritar produtos.');
                                    window.location.href = '/login'; // Redirecionar se necessário
                                    return {
                                        success: false
                                    };
                                }
                                return res.json();
                            })
                            .then(data => {
                                if (data && !data.success && data.message) {
                                    console.error('Erro:', data.message);
                                }
                            })
                            .catch(err => console.error('Erro:', err));
                    };

                    produtosContainer.appendChild(clone);
                });
            }

            function carregarPedidoItens() {
                try {
                    const raw = localStorage.getItem(pedidoStorageKey);
                    if (!raw) return new Map();
                    const parsed = JSON.parse(raw);
                    const map = new Map();
                    if (Array.isArray(parsed)) {
                        parsed.forEach((item) => {
                            if (!item) return;
                            if (typeof item === 'string') {
                                map.set(item, {
                                    key: item
                                });
                                return;
                            }
                            if (item.key) map.set(item.key, item);
                        });
                    }
                    return map;
                } catch (e) {
                    return new Map();
                }
            }

            function salvarPedidoItens() {
                try {
                    localStorage.setItem(pedidoStorageKey, JSON.stringify(Array.from(pedidoItens.values())));
                } catch (e) {}
            }

            function hasFavoritosNoPedido() {
                if (!(typeof userWishlist !== 'undefined' && Array.isArray(userWishlist) && userWishlist.length > 0)) {
                    return false;
                }
                const favSet = new Set(userWishlist);
                for (const key of pedidoItens.keys()) {
                    if (favSet.has(key)) return true;
                }
                return false;
            }

            function atualizarVisibilidadeCtasPedido() {
                const pedidoAtivo = document.body.classList.contains('pedido-mode');
                const count = pedidoItens.size;
                if (pedidoClearBtn) {
                    pedidoClearBtn.style.display = pedidoAtivo && count > 0 ? 'flex' : 'none';
                }
                if (pedidoHistoryBtn) {
                    pedidoHistoryBtn.style.display = pedidoAtivo ? 'flex' : 'none';
                }
                if (pedidoFavoritosBtn) {
                    pedidoFavoritosBtn.style.display = pedidoAtivo ? 'flex' : 'none';
                    pedidoFavoritosBtn.classList.toggle('is-active', pedidoAtivo && hasFavoritosNoPedido());
                }
            }

            function atualizarPedidoBadge() {
                if (!pedidoCountEl) return;
                const count = pedidoItens.size;
                pedidoCountEl.textContent = String(count);
                pedidoCountEl.style.display = count > 0 ? 'flex' : 'none';
                atualizarVisibilidadeCtasPedido();
            }

            function atualizarBotoesPedidoNosCards() {
                document.querySelectorAll('.pedido-item-btn').forEach((btn) => {
                    const prodKey = btn.dataset.prodKey;
                    if (!prodKey) return;
                    aplicarEstadoPedidoBtn(btn, prodKey);
                });
            }

            function aplicarEstadoPedidoBtn(btn, prodKey) {
                const isAdded = pedidoItens.has(prodKey);
                btn.classList.toggle('is-added', isAdded);
                btn.textContent = isAdded ? '−' : '+';
                btn.setAttribute('aria-label', isAdded ? 'Retirar do pedido' : 'Adicionar ao pedido');
            }

            function adicionarProdutoAoPedido(produto) {
                const prodKey = `${produto.id}-${produto.codigo_cor}`;
                if (pedidoItens.has(prodKey)) return false;
                pedidoItens.set(prodKey, {
                    key: prodKey,
                    product_id: produto.id,
                    color_code: produto.codigo_cor,
                    title: produto.title,
                    imagem: produto.imagem,
                    categoria: produto.categoria,
                    genero: produto.genero,
                    codigo: produto.codigo,
                    cor: produto.cor,
                    numeracao: produto.numeracao,
                    preco: produto.preco
                });
                return true;
            }

            function adicionarFavoritosAoPedido() {
                if (!(typeof userWishlist !== 'undefined' && Array.isArray(userWishlist)) || userWishlist.length === 0) {
                    alert('Você não tem favoritos para adicionar ao pedido.');
                    return;
                }

                let added = 0;
                userWishlist.forEach((key) => {
                    const produto = buscarProdutoPorKey(key);
                    if (!produto) return;
                    if (adicionarProdutoAoPedido(produto)) added++;
                });

                if (!document.body.classList.contains('pedido-mode')) {
                    setPedidoMode(true);
                }

                if (added === 0) {
                    alert('Nenhum favorito desta coleção foi encontrado para adicionar ao pedido.');
                    return;
                }

                salvarPedidoItens();
                atualizarPedidoBadge();
                atualizarBotoesPedidoNosCards();
                if (pedidoModal && pedidoModal.classList.contains('active')) {
                    renderPedidoModal();
                }
            }

            function limparPedido() {
                pedidoItens.clear();
                salvarPedidoItens();
                atualizarPedidoBadge();
                atualizarBotoesPedidoNosCards();
                if (pedidoModal && pedidoModal.classList.contains('active')) {
                    renderPedidoModal();
                }
            }

            function setPedidoMode(active) {
                document.body.classList.toggle('pedido-mode', active);
                if (pedidoFab) pedidoFab.setAttribute('aria-expanded', active ? 'true' : 'false');
                if (pedidoOverlay) pedidoOverlay.setAttribute('aria-hidden', active ? 'false' : 'true');
                if (pedidoFabIcon) pedidoFabIcon.src = active ? pedidoIconSelectedSrc : pedidoIconDefaultSrc;
                atualizarVisibilidadeCtasPedido();
            }

            function buscarProdutoPorKey(prodKey) {
                return produtosData.find((p) => `${p.id}-${p.codigo_cor}` === prodKey) || null;
            }

            function escapeHtml(value) {
                return String(value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function renderPedidoModal() {
                if (!pedidoModalItems || !pedidoModalEmpty) return;
                const itens = Array.from(pedidoItens.values());
                if (itens.length === 0) {
                    pedidoModalItems.innerHTML = '';
                    pedidoModalEmpty.style.display = 'block';
                    return;
                }

                pedidoModalEmpty.style.display = 'none';
                pedidoModalItems.innerHTML = itens.map((item) => {
                    const fallback = buscarProdutoPorKey(item.key);
                    const imagem = item.imagem || fallback?.imagem || '/images/img-padrao-mz.png';
                    const title = item.title || fallback?.title || '';
                    const categoria = item.categoria || fallback?.categoria || '';
                    const genero = item.genero || fallback?.genero || '';
                    const codigo = item.codigo || fallback?.codigo || '';
                    const cor = item.cor || fallback?.cor || '';
                    const numeracao = item.numeracao || fallback?.numeracao || '';
                    const preco = item.preco || fallback?.preco || '';

                    return `
                        <div class="pedido-modal-row">
                            <img class="pedido-modal-thumb" src="${escapeHtml(imagem)}" alt="${escapeHtml(title)}">
                            <div class="pedido-modal-title">${escapeHtml(title)}</div>
                            <div class="pedido-modal-col is-black">${escapeHtml(categoria)}</div>
                            <div class="pedido-modal-col is-opacity">${escapeHtml(genero)}</div>
                            <div class="pedido-modal-col is-opacity">${escapeHtml(codigo)}</div>
                            <div class="pedido-modal-col is-12px">${escapeHtml(cor)}</div>
                            <!--<div class="pedido-modal-col is-12px">${escapeHtml(numeracao)}</div>-->
                            <div class="pedido-modal-price is-16px">${escapeHtml(preco)}</div>
                            <button class="pedido-modal-remove" type="button" data-remove-pedido="${escapeHtml(item.key)}">Remover</button>
                        </div>
                    `;
                }).join('');

                pedidoModalItems.querySelectorAll('[data-remove-pedido]').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const prodKey = btn.getAttribute('data-remove-pedido');
                        if (!prodKey) return;
                        pedidoItens.delete(prodKey);
                        salvarPedidoItens();
                        atualizarPedidoBadge();
                        atualizarBotoesPedidoNosCards();
                        renderPedidoModal();
                    });
                });
            }

            function getNomeColecaoPedido() {
                const raw = (colecaoSelectedText?.textContent || '').replace(/\s+/g, ' ').trim();
                if (!raw || raw.toLowerCase() === 'selecione uma coleção') return 'Pedido';
                return raw.replace(/\s*\([^)]*\)\s*/g, ' ').replace(/\s+/g, ' ').trim() || 'Pedido';
            }

            function getDataPedidoDDMMAAAA() {
                const d = new Date();
                const dd = String(d.getDate()).padStart(2, '0');
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const yyyy = String(d.getFullYear());
                return `${dd}${mm}${yyyy}`;
            }

            function buildAutoPedidoTitle() {
                const nomeColecao = getNomeColecaoPedido();
                const data = getDataPedidoDDMMAAAA();
                const current = (titlePedidoEl?.textContent || '').replace(/\s+/g, ' ').trim();
                const basePrefix = `${nomeColecao}_${data}_`;
                if (titlePedidoEl?.dataset?.autoGenerated === 'true' && current.startsWith(basePrefix)) {
                    const match = current.match(/_(\d+)$/);
                    const version = match ? match[1] : '1';
                    return `${nomeColecao}_${data}_${version}`;
                }
                return `${nomeColecao}_${data}_1`;
            }

            function garantirTituloPedidoAuto() {
                if (!titlePedidoEl) return;
                const current = (titlePedidoEl.textContent || '').replace(/\s+/g, ' ').trim();
                const isHardcodedDefault = current === 'AW26 Oportunidades_26052025_1';
                const isEmptyOrPlaceholder = current === '' || current === 'Altere o título do pedido para salvar';
                const canOverwrite = titlePedidoEl.dataset.autoGenerated === 'true' || isHardcodedDefault ||
                    isEmptyOrPlaceholder;
                if (!canOverwrite) return;
                titlePedidoEl.textContent = buildAutoPedidoTitle();
                titlePedidoEl.dataset.autoGenerated = 'true';
            }

            function abrirPedidoModal() {
                if (!pedidoModal) return;
                garantirTituloPedidoAuto();
                renderPedidoModal();
                pedidoModal.classList.add('active');
                pedidoModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('pedido-modal-open');
            }

            function fecharPedidoModal() {
                if (!pedidoModal) return;
                pedidoModal.classList.remove('active');
                pedidoModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('pedido-modal-open');
            }

            function getPedidoTitle() {
                const title = (titlePedidoEl?.textContent || '').trim();
                return title !== '' ? title : 'Altere o título do pedido para salvar';
            }

            function getPedidoItemsPayload() {
                return Array.from(pedidoItens.values()).map((item) => {
                    return {
                        product_id: item.product_id,
                        color_code: item.color_code || null,
                        title: item.title || null,
                        categoria: item.categoria || null,
                        genero: item.genero || null,
                        codigo: item.codigo || null,
                        cor: item.cor || null,
                        numeracao: item.numeracao || null,
                        preco: item.preco || null,
                        imagem: item.imagem || null,
                    };
                });
            }

            function salvarPedidoNoServidor() {
                const title = getPedidoTitle();
                const items = getPedidoItemsPayload();
                if (title === 'Altere o título do pedido para salvar') {
                    alert('Altere o título do pedido para salvar.');
                    return;
                }
                if (items.length === 0) {
                    alert('Adicione ao menos 1 item para salvar o pedido.');
                    return;
                }

                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch('/user/pedidos', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf || ''
                        },
                        body: JSON.stringify({
                            title,
                            items
                        })
                    }).then(async (res) => {
                        if (res.status === 401) {
                            alert('Você precisa estar logado para salvar pedidos.');
                            window.location.href = '/login';
                            return null;
                        }
                        if (!res.ok) {
                            const data = await res.json().catch(() => null);
                            const msg = data?.message || 'Não foi possível salvar o pedido.';
                            throw new Error(msg);
                        }
                        return res.json();
                    })
                    .then((data) => {
                        if (!data) return;
                        alert(data.message || 'Pedido salvo com sucesso!');
                        limparPedidoAtualAposSalvar();
                        fecharPedidoModal();
                    })
                    .catch((err) => {
                        alert(err?.message || 'Não foi possível salvar o pedido.');
                    });
            }

            function limparPedidoAtualAposSalvar() {
                pedidoItens.clear();
                salvarPedidoItens();
                atualizarPedidoBadge();
                atualizarBotoesPedidoNosCards();
                if (titlePedidoEl) {
                    titlePedidoEl.textContent = buildAutoPedidoTitle();
                    titlePedidoEl.dataset.autoGenerated = 'true';
                }
                if (pedidoModal && pedidoModal.classList.contains('active')) {
                    renderPedidoModal();
                }
            }

            function renderPedidoHistoryTable() {
                if (!pedidoHistoryTableBody || !pedidoHistoryEmpty) return;
                if (!Array.isArray(pedidosHistorico) || pedidosHistorico.length === 0) {
                    pedidoHistoryTableBody.innerHTML = '';
                    pedidoHistoryEmpty.textContent = 'Nenhum pedido salvo até o momento.';
                    pedidoHistoryEmpty.style.display = 'block';
                    return;
                }

                pedidoHistoryEmpty.style.display = 'none';
                pedidoHistoryTableBody.innerHTML = pedidosHistorico.map((pedido) => `
                    <tr class="pedido-history-row" data-search="${escapeHtml((pedido.title || '') + ' ' + (pedido.created_at_label || ''))}">
                        <td>${escapeHtml(pedido.title || 'Pedido')}</td>
                        <td>${escapeHtml(pedido.created_at_label || '')}</td>
                        <td>${escapeHtml(String(pedido.items_count ?? 0))}</td>
                        <td>
                            <button type="button" class="pedido-history-open-btn" data-open-pedido-id="${escapeHtml(String(pedido.id))}">Abrir</button>
                            <button type="button" class="pedido-history-delete-btn" data-delete-pedido-id="${escapeHtml(String(pedido.id))}">Excluir</button>
                        </td>
                    </tr>
                `).join('');

                pedidoHistoryTableBody.querySelectorAll('[data-open-pedido-id]').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const id = Number(btn.getAttribute('data-open-pedido-id'));
                        const pedido = pedidosHistorico.find((p) => Number(p.id) === id);
                        if (!pedido) return;
                        aplicarPedidoSalvo(pedido);
                    });
                });

                pedidoHistoryTableBody.querySelectorAll('[data-delete-pedido-id]').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const id = Number(btn.getAttribute('data-delete-pedido-id'));
                        if (!id) return;
                        const ok = confirm('Deseja excluir este pedido?');
                        if (!ok) return;
                        excluirPedidoDoHistorico(id);
                    });
                });
            }

            function aplicarFiltroHistoricoPedidos() {
                const termo = (pedidoHistorySearchInput?.value || '').toLowerCase().trim();
                document.querySelectorAll('.pedido-history-row').forEach((row) => {
                    const txt = (row.getAttribute('data-search') || '').toLowerCase();
                    row.style.display = txt.includes(termo) ? '' : 'none';
                });
            }

            function carregarHistoricoPedidos() {
                fetch('/user/pedidos', {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(async (res) => {
                        const text = await res.text();
                        let data = null;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {}

                        if (!res.ok || !data || data.success !== true) {
                            if (text && text.toLowerCase().includes('<!doctype html')) {
                                throw new Error('Sessão expirada. Faça login novamente.');
                            }
                            throw new Error('Falha ao carregar histórico.');
                        }
                        return data;
                    })
                    .then((data) => {
                        pedidosHistorico = Array.isArray(data?.pedidos) ? data.pedidos : [];
                        renderPedidoHistoryTable();
                        aplicarFiltroHistoricoPedidos();
                    })
                    .catch((err) => {
                        console.error(err);
                        pedidosHistorico = [];
                        renderPedidoHistoryTable();
                        if (pedidoHistoryEmpty) {
                            pedidoHistoryEmpty.textContent = err?.message || 'Erro ao carregar histórico.';
                            pedidoHistoryEmpty.style.display = 'block';
                        }
                    });
            }

            function excluirPedidoDoHistorico(pedidoId) {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch(`/user/pedidos/${pedidoId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf || ''
                        }
                    })
                    .then(async (res) => {
                        const text = await res.text();
                        let data = null;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {}
                        if (!res.ok || !data || data.success !== true) {
                            const msg = data?.message || 'Não foi possível excluir o pedido.';
                            throw new Error(msg);
                        }
                        return data;
                    })
                    .then((data) => {
                        pedidosHistorico = pedidosHistorico.filter((p) => Number(p.id) !== Number(pedidoId));
                        renderPedidoHistoryTable();
                        aplicarFiltroHistoricoPedidos();
                        alert(data.message || 'Pedido excluído com sucesso!');
                    })
                    .catch((err) => {
                        alert(err?.message || 'Não foi possível excluir o pedido.');
                    });
            }

            function abrirPedidoHistoryModal() {
                if (!pedidoHistoryModal) return;
                renderPedidoHistoryTable();
                pedidoHistoryModal.classList.add('active');
                pedidoHistoryModal.setAttribute('aria-hidden', 'false');
            }

            function fecharPedidoHistoryModal() {
                if (!pedidoHistoryModal) return;
                pedidoHistoryModal.classList.remove('active');
                pedidoHistoryModal.setAttribute('aria-hidden', 'true');
            }

            function aplicarPedidoSalvo(pedido) {
                const title = (pedido?.title || '').trim();
                if (titlePedidoEl) {
                    titlePedidoEl.textContent = title !== '' ? title : buildAutoPedidoTitle();
                    titlePedidoEl.dataset.autoGenerated = title === '';
                }

                const itens = Array.isArray(pedido?.items) ? pedido.items : [];
                pedidoItens.clear();
                itens.forEach((item) => {
                    const productId = Number(item?.product_id || 0);
                    if (!productId) return;
                    const colorCode = item?.color_code ? String(item.color_code).replace(/\//g, '_') : '';
                    const key = `${productId}-${colorCode}`;
                    pedidoItens.set(key, {
                        key,
                        product_id: productId,
                        color_code: colorCode,
                        title: item?.title || '',
                        imagem: item?.imagem || '',
                        categoria: item?.categoria || '',
                        genero: item?.genero || '',
                        codigo: item?.codigo || '',
                        cor: item?.cor || '',
                        numeracao: item?.numeracao || '',
                        preco: item?.preco || '',
                    });
                });

                salvarPedidoItens();
                atualizarPedidoBadge();
                atualizarBotoesPedidoNosCards();
                fecharPedidoHistoryModal();
                abrirPedidoModal();
            }

            function getCurrentCollectionId() {
                const optionBySelected = document.querySelector('#colecaoOptions .option[selected]');
                const optionBySlug = currentCollectionSlug ?
                    document.querySelector(`#colecaoOptions .option[data-slug="${currentCollectionSlug}"]`) :
                    null;
                const option = optionBySelected || optionBySlug;
                const raw = option ? option.getAttribute('data-collection-id') : null;
                const id = raw ? Number(raw) : 0;
                return Number.isFinite(id) && id > 0 ? id : null;
            }

            function sanitizeFileName(name) {
                const value = String(name || '').trim();
                if (!value) return 'Pedido';
                return value.replace(/[\\/:*?"<>|]+/g, '-').replace(/\s+/g, ' ').trim();
            }

            function getPedidoProdutosSelecionados() {
                return Array.from(pedidoItens.values())
                    .map((item) => {
                        const id = Number(item?.product_id || 0);
                        if (!id) return null;
                        const colorCodeRaw = item?.color_code ? String(item.color_code) : '';
                        const colorCode = colorCodeRaw ? colorCodeRaw.replace(/_/g, '/') : '';
                        return {
                            id,
                            cor: item?.cor ? String(item.cor) : '',
                            color_code: colorCode
                        };
                    })
                    .filter(Boolean);
            }

            function submitPedidoExport(formato) {
                const collectionId = getCurrentCollectionId();
                if (!collectionId) {
                    alert('Não foi possível identificar a coleção para exportação.');
                    return;
                }

                const produtosSelecionados = getPedidoProdutosSelecionados();
                if (!produtosSelecionados.length) {
                    alert('Adicione ao menos 1 item no pedido para gerar o arquivo.');
                    return;
                }

                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = formato === 'planilha' ? '/user/export/pdf' : '/user/export/pedido/pdf';
                form.style.display = 'none';

                const inputToken = document.createElement('input');
                inputToken.type = 'hidden';
                inputToken.name = '_token';
                inputToken.value = csrf;
                form.appendChild(inputToken);

                const inputCollectionId = document.createElement('input');
                inputCollectionId.type = 'hidden';
                inputCollectionId.name = 'collection_id';
                inputCollectionId.value = String(collectionId);
                form.appendChild(inputCollectionId);

                const inputHistoryName = document.createElement('input');
                inputHistoryName.type = 'hidden';
                inputHistoryName.name = 'collectionHistoryName';
                inputHistoryName.value = sanitizeFileName((titlePedidoEl?.textContent || '').trim());
                form.appendChild(inputHistoryName);

                const inputPedidoTitle = document.createElement('input');
                inputPedidoTitle.type = 'hidden';
                inputPedidoTitle.name = 'pedidoTitle';
                inputPedidoTitle.value = (titlePedidoEl?.textContent || '').trim().replace(/\s+/g, ' ');
                form.appendChild(inputPedidoTitle);

                const inputProdutos = document.createElement('input');
                inputProdutos.type = 'hidden';
                inputProdutos.name = 'produtos';
                inputProdutos.value = 'selecao';
                form.appendChild(inputProdutos);

                const inputGrupo = document.createElement('input');
                inputGrupo.type = 'hidden';
                inputGrupo.name = 'grupo_opcoes';
                inputGrupo.value = 'separado';
                form.appendChild(inputGrupo);

                const inputFormato = document.createElement('input');
                inputFormato.type = 'hidden';
                inputFormato.name = 'formato';
                inputFormato.value = formato === 'planilha' ? 'planilha' : 'a4';
                form.appendChild(inputFormato);

                produtosSelecionados.forEach((produto, index) => {
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = `produtos_selecionados[${index}][id]`;
                    inputId.value = String(produto.id);
                    form.appendChild(inputId);

                    const inputCor = document.createElement('input');
                    inputCor.type = 'hidden';
                    inputCor.name = `produtos_selecionados[${index}][cor]`;
                    inputCor.value = produto.cor || '';
                    form.appendChild(inputCor);

                    const inputColorCode = document.createElement('input');
                    inputColorCode.type = 'hidden';
                    inputColorCode.name = `produtos_selecionados[${index}][color_code]`;
                    inputColorCode.value = produto.color_code || '';
                    form.appendChild(inputColorCode);
                });

                document.body.appendChild(form);
                form.submit();
                setTimeout(() => form.remove(), 0);
            }

            if (pedidoFab) {
                pedidoFab.addEventListener('click', () => {
                    const active = document.body.classList.contains('pedido-mode');
                    if (!active) {
                        setPedidoMode(true);
                        return;
                    }

                    if (pedidoItens.size === 0) {
                        setPedidoMode(false);
                    } else {
                        setPedidoMode(false);
                        abrirPedidoModal();
                    }
                });
            }

            if (pedidoOverlayBackBtn) {
                pedidoOverlayBackBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    setPedidoMode(false);
                });
            }

            if (pedidoClearBtn) {
                pedidoClearBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    limparPedido();
                });
            }

            if (pedidoHistoryBtn) {
                pedidoHistoryBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    carregarHistoricoPedidos();
                    abrirPedidoHistoryModal();
                });
            }

            if (pedidoFavoritosBtn) {
                pedidoFavoritosBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    adicionarFavoritosAoPedido();
                });
            }

            if (pedidoModalBackBtn) {
                pedidoModalBackBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    fecharPedidoModal();
                });
            }

            if (pedidoSaveBtn) {
                pedidoSaveBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    salvarPedidoNoServidor();
                });
            }

            if (pedidoHistoryBackBtn) {
                pedidoHistoryBackBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    fecharPedidoHistoryModal();
                });
            }

            if (pedidoHistorySearchInput) {
                pedidoHistorySearchInput.addEventListener('input', () => {
                    aplicarFiltroHistoricoPedidos();
                });
            }

            const pedidoModalExportPdfBtn = document.getElementById('pedidoModalExportPdfBtn');
            if (pedidoModalExportPdfBtn) {
                pedidoModalExportPdfBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    submitPedidoExport('pdf');
                });
            }

            const pedidoModalExportPlanilhaBtn = document.getElementById('pedidoModalExportPlanilhaBtn');
            if (pedidoModalExportPlanilhaBtn) {
                pedidoModalExportPlanilhaBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    submitPedidoExport('planilha');
                });
            }

            const pedidoModalVitrineBtn = document.getElementById('pedidoModalVitrineBtn');
            const vitrineModal = document.getElementById('vitrineModal');
            const vitrineModalBackBtn = document.getElementById('vitrineModalBackBtn');
            const vitrineTitleEl = document.getElementById('vitrineTitle');
            const vitrineGrid = document.getElementById('vitrineGrid');
            const vitrineGridWrap = document.getElementById('vitrineGridWrap');
            const vitrineRowsMinusBtn = document.getElementById('vitrineRowsMinusBtn');
            const vitrineRowsPlusBtn = document.getElementById('vitrineRowsPlusBtn');
            const vitrineColsMinusBtn = document.getElementById('vitrineColsMinusBtn');
            const vitrineColsPlusBtn = document.getElementById('vitrineColsPlusBtn');
            const vitrineProductsStrip = document.getElementById('vitrineProductsStrip');
            const vitrineStripWrapper = document.getElementById('vitrineStripWrapper');
            const vitrineStripScrollbar = document.getElementById('vitrineStripScrollbar');
            const vitrineStripTrack = document.getElementById('vitrineStripTrack');
            const vitrineStripThumb = document.getElementById('vitrineStripThumb');
            const vitrineStripBtnLeft = document.getElementById('vitrineStripBtnLeft');
            const vitrineStripBtnRight = document.getElementById('vitrineStripBtnRight');
            const vitrineProductsEmpty = document.getElementById('vitrineProductsEmpty');
            const vitrineAddAllBtn = document.getElementById('vitrineAddAllBtn');
            const vitrineRemoveAllBtn = document.getElementById('vitrineRemoveAllBtn');
            const vitrineExportPdfBtn = document.getElementById('vitrineExportPdfBtn');
            const vitrineExportJpgBtn = document.getElementById('vitrineExportJpgBtn');

            const VITRINE_MAX_COLS = 10;
            const vitrineStorageKey = `vitrine_layout_v1_${currentCollectionSlug || 'default'}`;
            let vitrineReturnToPedido = false;
            let vitrineBaseCellPx = null;

            function calcularVitrineBaseCellPx() {
                if (!vitrineGrid) return null;
                const wrap = vitrineGridWrap || vitrineGrid.parentElement;
                if (!wrap) return null;

                let gap = 10;
                try {
                    const g = getComputedStyle(vitrineGrid).gap || '';
                    const parsed = parseFloat(g);
                    if (Number.isFinite(parsed)) gap = parsed;
                } catch (e) {}

                const wrapW = Math.max(0, wrap.clientWidth || 0);
                const wrapH = Math.max(0, wrap.clientHeight || 0);
                let padL = 0;
                let padR = 0;
                let padT = 0;
                let padB = 0;
                try {
                    const wrapStyle = getComputedStyle(wrap);
                    padL = parseFloat(wrapStyle.paddingLeft) || 0;
                    padR = parseFloat(wrapStyle.paddingRight) || 0;
                    padT = parseFloat(wrapStyle.paddingTop) || 0;
                    padB = parseFloat(wrapStyle.paddingBottom) || 0;
                } catch (e) {}

                const availableW = Math.max(0, wrapW - padL - padR);
                const availableH = Math.max(0, wrapH - padT - padB);
                const minForMeasure = 50;
                if (availableW < minForMeasure || availableH < minForMeasure) return null;

                const baseCols = 5;
                const baseRows = 3;
                const baseMaxW = (availableW - gap * (baseCols - 1)) / baseCols;
                const baseMaxH = (availableH - gap * (baseRows - 1)) / baseRows;
                const baseCell = Math.floor(Math.min(baseMaxW, baseMaxH));
                return Number.isFinite(baseCell) && baseCell > 0 ? baseCell : null;
            }

            function getDefaultVitrineState() {
                return {
                    rows: 3,
                    cols: 5,
                    cells: {}
                };
            }

            function normalizarVitrineState(state) {
                const base = getDefaultVitrineState();
                const rows = Math.max(1, Number(state?.rows || base.rows) || base.rows);
                const cols = Math.min(VITRINE_MAX_COLS, Math.max(1, Number(state?.cols || base.cols) || base.cols));
                const total = rows * cols;
                const cells = {};
                const rawCells = state?.cells && typeof state.cells === 'object' ? state.cells : {};
                Object.keys(rawCells).forEach((k) => {
                    const idx = Number(k);
                    if (!Number.isFinite(idx) || idx < 0 || idx >= total) return;
                    const key = rawCells[k];
                    if (!key) return;
                    cells[String(idx)] = String(key);
                });
                return {
                    rows,
                    cols,
                    cells
                };
            }

            function carregarVitrineState() {
                try {
                    const raw = localStorage.getItem(vitrineStorageKey);
                    if (!raw) return getDefaultVitrineState();
                    const parsed = JSON.parse(raw);
                    return normalizarVitrineState(parsed);
                } catch (e) {
                    return getDefaultVitrineState();
                }
            }

            function salvarVitrineState(state) {
                try {
                    localStorage.setItem(vitrineStorageKey, JSON.stringify(state));
                } catch (e) {}
            }

            let vitrineState = carregarVitrineState();

            function getPedidoKeys() {
                return Array.from(pedidoItens.keys());
            }

            function getVitrineTotalCells() {
                return vitrineState.rows * vitrineState.cols;
            }

            function setVitrineCell(index, prodKey) {
                const idx = Number(index);
                if (!Number.isFinite(idx) || idx < 0) return;
                const total = getVitrineTotalCells();
                if (idx >= total) return;

                if (!prodKey) {
                    delete vitrineState.cells[String(idx)];
                } else {
                    vitrineState.cells[String(idx)] = String(prodKey);
                }
                salvarVitrineState(vitrineState);
            }

            function atualizarVitrineCounts() {
                if (vitrineRowsMinusBtn) vitrineRowsMinusBtn.disabled = vitrineState.rows <= 1;
                if (vitrineColsMinusBtn) vitrineColsMinusBtn.disabled = vitrineState.cols <= 1;
                if (vitrineColsPlusBtn) vitrineColsPlusBtn.disabled = vitrineState.cols >= VITRINE_MAX_COLS;
            }

            function centralizarVitrineGridHorizontal() {
                if (!vitrineGridWrap || !vitrineGrid) return;
                const max = Math.max(0, (vitrineGridWrap.scrollWidth || 0) - (vitrineGridWrap.clientWidth || 0));
                vitrineGridWrap.scrollLeft = Math.floor(max / 2);
            }

            let vitrineStripScrollInterval;
            let vitrineStripDragging = false;
            let vitrineStripStartX = 0;
            let vitrineStripStartLeft = 0;

            function updateVitrineStripScrollbar() {
                if (!vitrineProductsStrip || !vitrineStripScrollbar || !vitrineStripTrack || !vitrineStripThumb) return;
                const canScroll = vitrineProductsStrip.scrollWidth > vitrineProductsStrip.clientWidth + 1;
                vitrineStripScrollbar.style.display = canScroll ? 'flex' : 'none';
                vitrineProductsStrip.style.justifyContent = canScroll ? 'flex-start' : 'center';
                if (!canScroll) return;
                const trackW = vitrineStripTrack.clientWidth || 0;
                const ratio = vitrineProductsStrip.clientWidth / vitrineProductsStrip.scrollWidth;
                const thumbW = Math.max(28, trackW * ratio);
                const maxLeft = Math.max(0, trackW - thumbW);
                const scrollR = (vitrineProductsStrip.scrollWidth - vitrineProductsStrip.clientWidth) > 0 ?
                    (vitrineProductsStrip.scrollLeft / (vitrineProductsStrip.scrollWidth - vitrineProductsStrip.clientWidth)) :
                    0;
                vitrineStripThumb.style.width = `${thumbW}px`;
                vitrineStripThumb.style.left = `${scrollR * maxLeft}px`;
            }

            if (vitrineProductsStrip) {
                vitrineProductsStrip.addEventListener('scroll', updateVitrineStripScrollbar);
            }
            if (vitrineStripWrapper && vitrineProductsStrip) {
                vitrineStripWrapper.addEventListener('wheel', (e) => {
                    const canScroll = vitrineProductsStrip.scrollWidth > vitrineProductsStrip.clientWidth + 1;
                    if (!canScroll) return;

                    const deltaY = Number(e.deltaY) || 0;
                    const deltaX = Number(e.deltaX) || 0;
                    if (Math.abs(deltaY) < Math.abs(deltaX)) return;

                    const maxLeft = Math.max(0, vitrineProductsStrip.scrollWidth - vitrineProductsStrip.clientWidth);
                    if (maxLeft <= 0) return;

                    const prev = vitrineProductsStrip.scrollLeft;
                    const next = Math.max(0, Math.min(maxLeft, prev + deltaY));
                    if (next === prev) return;

                    e.preventDefault();
                    vitrineProductsStrip.scrollLeft = next;
                }, {
                    passive: false
                });
            }
            window.addEventListener('resize', updateVitrineStripScrollbar);

            if (vitrineStripBtnLeft && vitrineProductsStrip) {
                vitrineStripBtnLeft.addEventListener('mousedown', () => {
                    vitrineProductsStrip.scrollBy({
                        left: -60,
                        behavior: 'smooth'
                    });
                    vitrineStripScrollInterval = setInterval(() => vitrineProductsStrip.scrollBy({
                        left: -60
                    }), 100);
                });
            }
            if (vitrineStripBtnRight && vitrineProductsStrip) {
                vitrineStripBtnRight.addEventListener('mousedown', () => {
                    vitrineProductsStrip.scrollBy({
                        left: 60,
                        behavior: 'smooth'
                    });
                    vitrineStripScrollInterval = setInterval(() => vitrineProductsStrip.scrollBy({
                        left: 60
                    }), 100);
                });
            }
            document.addEventListener('mouseup', () => {
                if (vitrineStripScrollInterval) clearInterval(vitrineStripScrollInterval);
                vitrineStripScrollInterval = undefined;
                vitrineStripDragging = false;
            });

            if (vitrineStripThumb && vitrineStripTrack && vitrineProductsStrip) {
                vitrineStripThumb.addEventListener('mousedown', (e) => {
                    vitrineStripDragging = true;
                    vitrineStripStartX = e.clientX;
                    vitrineStripStartLeft = vitrineProductsStrip.scrollLeft;
                    e.preventDefault();
                });
                document.addEventListener('mousemove', (e) => {
                    if (!vitrineStripDragging) return;
                    const trackW = vitrineStripTrack.clientWidth - vitrineStripThumb.clientWidth;
                    if (trackW <= 0) return;
                    const delta = e.clientX - vitrineStripStartX;
                    const ratio = delta / trackW;
                    vitrineProductsStrip.scrollLeft = vitrineStripStartLeft + ratio * (vitrineProductsStrip
                        .scrollWidth - vitrineProductsStrip.clientWidth);
                });
                vitrineStripTrack.addEventListener('click', (e) => {
                    if (e.target === vitrineStripThumb) return;
                    const rect = vitrineStripTrack.getBoundingClientRect();
                    const ratio = (e.clientX - rect.left) / vitrineStripTrack.clientWidth;
                    vitrineProductsStrip.scrollLeft = ratio * (vitrineProductsStrip.scrollWidth - vitrineProductsStrip
                        .clientWidth);
                });
            }

            const vitrineTransparentDragImg = new Image();
            vitrineTransparentDragImg.src =
                'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="1" height="1"></svg>';
            let vitrineDragGhostEl = null;

            function vitrineStopGhost() {
                if (!vitrineDragGhostEl) return;
                vitrineDragGhostEl.remove();
                vitrineDragGhostEl = null;
            }

            function vitrineUpdateGhostPosition(e) {
                if (!vitrineDragGhostEl) return;
                if (!Number.isFinite(e.clientX) || !Number.isFinite(e.clientY)) return;
                vitrineDragGhostEl.style.left = `${e.clientX}px`;
                vitrineDragGhostEl.style.top = `${e.clientY}px`;
            }

            document.addEventListener('dragover', vitrineUpdateGhostPosition);
            document.addEventListener('drag', vitrineUpdateGhostPosition);
            document.addEventListener('drop', vitrineStopGhost);

            function vitrineStartGhostFromImg(img) {
                vitrineStopGhost();
                if (!img) return;
                const rect = img.getBoundingClientRect();
                const w = Math.max(1, Math.round(rect.width || img.clientWidth || 1));
                const h = Math.max(1, Math.round(rect.height || img.clientHeight || 1));

                const ghost = document.createElement('div');
                ghost.style.position = 'fixed';
                ghost.style.left = '-9999px';
                ghost.style.top = '0';
                ghost.style.width = `${w}px`;
                ghost.style.height = `${h}px`;
                ghost.style.pointerEvents = 'none';
                ghost.style.zIndex = '9999';
                ghost.style.background = 'transparent';
                ghost.style.boxShadow = 'none';
                ghost.style.filter = 'none';
                ghost.style.opacity = '1';
                ghost.style.transform = 'translate(-50%, -50%)';

                const ghostImg = img.cloneNode(true);
                ghostImg.removeAttribute('draggable');
                ghostImg.style.width = '100%';
                ghostImg.style.height = '100%';
                ghostImg.style.objectFit = 'contain';
                ghostImg.style.background = 'transparent';
                ghostImg.style.boxShadow = 'none';
                ghostImg.style.borderRadius = '12px';
                ghostImg.style.border = '1px solid #D9D9D9';
                ghostImg.style.filter = 'none';
                ghost.appendChild(ghostImg);

                document.body.appendChild(ghost);
                vitrineDragGhostEl = ghost;
            }

            function vitrineSetTransparentDragImage(e) {
                try {
                    e.dataTransfer.setDragImage(vitrineTransparentDragImg, 0, 0);
                } catch (err) {}
            }

            function renderVitrineProductsList() {
                if (!vitrineProductsStrip || !vitrineProductsEmpty) return;
                const keys = getPedidoKeys();
                if (!keys.length) {
                    vitrineProductsStrip.innerHTML = '';
                    vitrineProductsEmpty.style.display = 'block';
                    return;
                }
                vitrineProductsEmpty.style.display = 'none';
                vitrineProductsStrip.innerHTML = keys.map((prodKey) => {
                    const produto = buscarProdutoPorKey(prodKey);
                    const imagem = produto?.imagem || '/images/img-padrao-mz.png';
                    const title = produto?.title || '';
                    const cor = produto?.cor || '';
                    return `
                        <div class="vitrine-prod" data-vitrine-prodkey="${escapeHtml(prodKey)}">
                            <img draggable="true" class="vitrine-prod-thumb" src="${escapeHtml(imagem)}" alt="${escapeHtml(title)}" />
                            <div draggable="false" class="vitrine-prod-model">${escapeHtml(title)}</div>
                            <div draggable="false" class="vitrine-prod-color">${escapeHtml(cor)}</div>
                        </div>
                    `;
                }).join('');

                vitrineProductsStrip.querySelectorAll('[data-vitrine-prodkey] img').forEach((img) => {
                    img.addEventListener('dragstart', (e) => {
                        e.stopPropagation();
                        const wrapper = img.closest('[data-vitrine-prodkey]');
                        const prodKey = wrapper?.getAttribute('data-vitrine-prodkey') || '';
                        if (!prodKey) return;
                        e.dataTransfer.setData('text/plain', prodKey);
                        e.dataTransfer.setData('application/x-vitrine-source-index', '');
                        e.dataTransfer.effectAllowed = 'copyMove';
                        vitrineSetTransparentDragImage(e);
                        vitrineStartGhostFromImg(img);
                        vitrineUpdateGhostPosition(e);
                    });
                    img.addEventListener('dragend', () => {
                        vitrineStopGhost();
                    });
                });
                requestAnimationFrame(updateVitrineStripScrollbar);
            }

            function renderVitrineGrid() {
                if (!vitrineGrid) return;
                atualizarVitrineCounts();

                const total = getVitrineTotalCells();
                const cols = vitrineState.cols;
                const rows = vitrineState.rows;

                let gapX = 3;
                let gapY = 3;
                try {
                    const style = getComputedStyle(vitrineGrid);
                    const gx = parseFloat(style.columnGap || style.gap || '');
                    const gy = parseFloat(style.rowGap || style.gap || '');
                    if (Number.isFinite(gx)) gapX = gx;
                    if (Number.isFinite(gy)) gapY = gy;
                } catch (e) {}

                const wrap = vitrineGridWrap || vitrineGrid.parentElement;
                const minForMeasure = 50;
                const wrapW = Math.max(0, (wrap?.clientWidth || 0));
                const wrapH = Math.max(0, (wrap?.clientHeight || 0));
                let padL = 0;
                let padR = 0;
                let padT = 0;
                let padB = 0;
                let wrapGap = 0;
                try {
                    if (wrap) {
                        const wrapStyle = getComputedStyle(wrap);
                        padL = parseFloat(wrapStyle.paddingLeft) || 0;
                        padR = parseFloat(wrapStyle.paddingRight) || 0;
                        padT = parseFloat(wrapStyle.paddingTop) || 0;
                        padB = parseFloat(wrapStyle.paddingBottom) || 0;
                        const g = parseFloat(wrapStyle.gap || '');
                        if (Number.isFinite(g)) wrapGap = g;
                    }
                } catch (e) {}
                const availableW = Math.max(0, wrapW - padL - padR);
                let availableH = Math.max(0, wrapH - padT - padB);
                if (wrap === vitrineGridWrap) {
                    const titleRowEl = document.getElementById('vitrineTitleRow');
                    const titleH = titleRowEl ? Math.max(0, titleRowEl.offsetHeight || 0) : 0;
                    availableH = Math.max(0, availableH - titleH - wrapGap);
                }

                const maxCellW = cols > 0 ? (availableW - gapX * (cols - 1)) / cols : 0;

                const PREFERRED_VITRINE_CELL_PX = Number.isFinite(vitrineBaseCellPx) && vitrineBaseCellPx > 0 ?
                    vitrineBaseCellPx : 123.5;

                let cellByWidth = Math.floor(maxCellW);
                if (!Number.isFinite(cellByWidth) || cellByWidth < 1) cellByWidth = 1;
                if (availableW < minForMeasure) cellByWidth = 1;

                const cell = Math.max(1, Math.min(PREFERRED_VITRINE_CELL_PX, cellByWidth));

                vitrineGrid.style.gridTemplateColumns = `repeat(${cols}, ${cell}px)`;
                vitrineGrid.style.gridTemplateRows = `repeat(${rows}, ${cell}px)`;
                vitrineGrid.style.width = `${Math.max(0, cols * cell + gapX * (cols - 1))}px`;
                vitrineGrid.style.height = `${Math.max(0, rows * cell + gapY * (rows - 1))}px`;

                let html = '';
                for (let i = 0; i < total; i++) {
                    const prodKey = vitrineState.cells[String(i)] || '';
                    if (!prodKey) {
                        html += `<div class="vitrine-cell" data-vitrine-index="${i}"></div>`;
                        continue;
                    }
                    const produto = buscarProdutoPorKey(prodKey);
                    const imagem = produto?.imagem || '/images/img-padrao-mz.png';
                    const title = produto?.title || '';
                    html += `
                        <div class="vitrine-cell" data-vitrine-index="${i}" data-vitrine-dragkey="${escapeHtml(prodKey)}">
                            <img draggable="true" src="${escapeHtml(imagem)}" alt="${escapeHtml(title)}" />
                            <button type="button" class="vitrine-remove" aria-label="Remover item" data-vitrine-remove="${i}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
<path opacity="0.5" d="M3.82541 3.28334H4.97521V1.74585C4.97521 1.33633 5.26446 1.07049 5.69835 1.07049H8.2872C8.72107 1.07049 9.01035 1.33633 9.01035 1.74585V3.28334H10.1601V1.674C10.1601 0.63224 9.48038 0 8.36674 0H5.6188C4.50516 0 3.82541 0.63224 3.82541 1.674V3.28334ZM0.542355 3.8581H13.4649C13.7614 3.8581 14 3.60664 14 3.31207C14 3.01751 13.7614 2.77323 13.4649 2.77323H0.542355C0.253099 2.77323 0 3.01751 0 3.31207C0 3.61382 0.253099 3.8581 0.542355 3.8581ZM3.68802 16H10.3192C11.3533 16 12.0475 15.3318 12.0982 14.3044L12.6044 3.72159H11.4401L10.9556 14.1823C10.9411 14.6133 10.6302 14.9151 10.2035 14.9151H3.78925C3.37707 14.9151 3.06612 14.6062 3.04442 14.1823L2.53099 3.72159H1.39566L1.90909 14.3116C1.95971 15.339 2.63946 16 3.68802 16ZM4.8595 13.6865C5.1343 13.6865 5.31508 13.5141 5.30785 13.2627L5.08368 5.5752C5.07645 5.32374 4.89566 5.1585 4.63533 5.1585C4.36054 5.1585 4.17975 5.33093 4.18699 5.58239L4.40393 13.2627C4.41116 13.5213 4.59194 13.6865 4.8595 13.6865ZM7.00003 13.6865C7.27482 13.6865 7.47006 13.5141 7.47006 13.2627V5.58239C7.47006 5.33093 7.27482 5.1585 7.00003 5.1585C6.72518 5.1585 6.53722 5.33093 6.53722 5.58239V13.2627C6.53722 13.5141 6.72518 13.6865 7.00003 13.6865ZM9.14772 13.6865C9.40806 13.6865 9.58887 13.5213 9.59609 13.2627L9.81299 5.58239C9.82027 5.33093 9.63947 5.1585 9.36468 5.1585C9.10434 5.1585 8.92353 5.32374 8.91631 5.58239L8.69941 13.2627C8.69213 13.5141 8.87293 13.6865 9.14772 13.6865Z" fill="black"/>
</svg>
                            </button>
                        </div>
                    `;
                }
                vitrineGrid.innerHTML = html;

                vitrineGrid.querySelectorAll('[data-vitrine-remove]').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const idx = Number(btn.getAttribute('data-vitrine-remove'));
                        if (!Number.isFinite(idx)) return;
                        setVitrineCell(idx, null);
                        renderVitrineGrid();
                    });
                    btn.addEventListener('mousedown', (e) => {
                        e.stopPropagation();
                    });
                    btn.addEventListener('dragstart', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });

                vitrineGrid.querySelectorAll('.vitrine-cell').forEach((cell) => {
                    const idx = Number(cell.getAttribute('data-vitrine-index'));
                    if (!Number.isFinite(idx)) return;

                    cell.addEventListener('dragover', (e) => {
                        e.preventDefault();
                        cell.classList.add('is-over');
                        e.dataTransfer.dropEffect = 'move';
                    });
                    cell.addEventListener('dragleave', () => {
                        cell.classList.remove('is-over');
                    });
                    cell.addEventListener('drop', (e) => {
                        e.preventDefault();
                        cell.classList.remove('is-over');
                        const prodKey = e.dataTransfer.getData('text/plain') || '';
                        if (!prodKey) return;
                        const sourceIndexRaw = e.dataTransfer.getData('application/x-vitrine-source-index');
                        const sourceIndex = sourceIndexRaw !== '' ? Number(sourceIndexRaw) : null;
                        if (Number.isFinite(sourceIndex) && sourceIndex !== null && sourceIndex !== idx) {
                            const targetExisting = vitrineState.cells[String(idx)] || '';
                            setVitrineCell(idx, prodKey);
                            if (targetExisting) {
                                setVitrineCell(sourceIndex, targetExisting);
                            } else {
                                setVitrineCell(sourceIndex, null);
                            }
                            renderVitrineGrid();
                            return;
                        }
                        setVitrineCell(idx, prodKey);
                        renderVitrineGrid();
                    });
                });

                vitrineGrid.querySelectorAll('[data-vitrine-dragkey]').forEach((cell) => {
                    const idx = Number(cell.getAttribute('data-vitrine-index'));
                    const img = cell.querySelector('img');
                    if (!img) return;
                    img.addEventListener('dragstart', (e) => {
                        e.stopPropagation();
                        const prodKey = cell.getAttribute('data-vitrine-dragkey') || '';
                        if (!prodKey) return;
                        cell.classList.add('is-dragging');
                        e.dataTransfer.setData('text/plain', prodKey);
                        e.dataTransfer.setData('application/x-vitrine-source-index', Number.isFinite(idx) ?
                            String(idx) : '');
                        e.dataTransfer.effectAllowed = 'copyMove';
                        vitrineSetTransparentDragImage(e);
                        vitrineStartGhostFromImg(img);
                        vitrineUpdateGhostPosition(e);
                    });
                    img.addEventListener('dragend', () => {
                        cell.classList.remove('is-dragging');
                        vitrineStopGhost();
                    });
                });
            }

            function getVitrineExportFileName(ext) {
                const raw = (vitrineTitleEl?.textContent || titlePedidoEl?.textContent || 'Vitrine').trim();
                const base = sanitizeFileName(raw || 'Vitrine');
                return `${base}.${ext}`;
            }

            function getAllInlineCssText() {
                return Array.from(document.querySelectorAll('style'))
                    .map((s) => s.textContent || '')
                    .join('\n');
            }

            function absolutizeImgSrcs(root) {
                root.querySelectorAll('img').forEach((img) => {
                    const src = img.getAttribute('src') || '';
                    if (!src) return;
                    try {
                        const abs = new URL(src, window.location.origin).toString();
                        img.setAttribute('src', abs);
                    } catch (e) {}
                });
            }

            async function fetchAsDataUrl(url) {
                const res = await fetch(url, {
                    cache: 'force-cache'
                });
                if (!res.ok) throw new Error('Falha ao baixar imagem.');
                const blob = await res.blob();
                return await new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => resolve(String(reader.result || ''));
                    reader.onerror = () => reject(new Error('Falha ao ler imagem.'));
                    reader.readAsDataURL(blob);
                });
            }

            async function inlineImgSrcsAsDataUrl(root) {
                const imgs = Array.from(root.querySelectorAll('img'));
                const cache = new Map();
                for (const img of imgs) {
                    const src = img.getAttribute('src') || '';
                    if (!src || src.startsWith('data:')) continue;
                    if (cache.has(src)) {
                        img.setAttribute('src', cache.get(src));
                        continue;
                    }
                    try {
                        const dataUrl = await fetchAsDataUrl(src);
                        if (!dataUrl) continue;
                        cache.set(src, dataUrl);
                        img.setAttribute('src', dataUrl);
                    } catch (e) {}
                }
            }

            function inlineSvgsAsImgDataUrl(root) {
                const svgs = Array.from(root.querySelectorAll('svg'));
                if (!svgs.length) return;
                const serializer = new XMLSerializer();
                svgs.forEach((svg) => {
                    try {
                        if (!svg.getAttribute('xmlns')) {
                            svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
                        }
                        const xml = serializer.serializeToString(svg);
                        const dataUrl = `data:image/svg+xml;charset=utf-8,${encodeURIComponent(xml)}`;
                        const img = document.createElement('img');
                        img.setAttribute('src', dataUrl);
                        const w = svg.getAttribute('width');
                        const h = svg.getAttribute('height');
                        if (w) img.setAttribute('width', w);
                        if (h) img.setAttribute('height', h);
                        img.style.cssText = svg.getAttribute('style') || '';
                        svg.replaceWith(img);
                    } catch (e) {}
                });
            }

            function vitrineParsePx(value, fallback) {
                const n = parseFloat(String(value || ''));
                return Number.isFinite(n) ? n : fallback;
            }

            async function vitrineLoadImg(src) {
                const url = new URL(src, window.location.origin).toString();
                const dataUrl = await fetchAsDataUrl(url);
                return await new Promise((resolve, reject) => {
                    const img = new Image();
                    img.onload = () => resolve(img);
                    img.onerror = () => reject(new Error('Falha ao carregar imagem.'));
                    img.src = dataUrl;
                });
            }

            function vitrineRoundRectPath(ctx, x, y, w, h, r) {
                const radius = Math.max(0, Math.min(r, Math.min(w, h) / 2));
                ctx.beginPath();
                ctx.moveTo(x + radius, y);
                ctx.lineTo(x + w - radius, y);
                ctx.quadraticCurveTo(x + w, y, x + w, y + radius);
                ctx.lineTo(x + w, y + h - radius);
                ctx.quadraticCurveTo(x + w, y + h, x + w - radius, y + h);
                ctx.lineTo(x + radius, y + h);
                ctx.quadraticCurveTo(x, y + h, x, y + h - radius);
                ctx.lineTo(x, y + radius);
                ctx.quadraticCurveTo(x, y, x + radius, y);
                ctx.closePath();
            }

            function vitrineDrawContain(ctx, img, x, y, w, h, pad) {
                const px = Math.max(0, pad || 0);
                const innerW = Math.max(1, w - px * 2);
                const innerH = Math.max(1, h - px * 2);
                const iw = img.naturalWidth || img.width || 1;
                const ih = img.naturalHeight || img.height || 1;
                const scale = Math.min(innerW / iw, innerH / ih);
                const dw = Math.max(1, Math.floor(iw * scale));
                const dh = Math.max(1, Math.floor(ih * scale));
                const dx = Math.floor(x + px + (innerW - dw) / 2);
                const dy = Math.floor(y + px + (innerH - dh) / 2);
                ctx.drawImage(img, dx, dy, dw, dh);
            }

            async function vitrineCaptureToCanvasManual() {
                if (!vitrineGrid || !vitrineTitleEl) throw new Error('Elementos da vitrine não encontrados.');

                const paddingX = 100;
                const padTop = 28;
                const padBottom = 28;
                const headerGap = 22;
                const cols = vitrineState?.cols || 5;
                const rows = vitrineState?.rows || 3;

                const anyCell = vitrineGrid.querySelector('.vitrine-cell');
                const cellStyle = anyCell ? getComputedStyle(anyCell) : null;
                const cellW = vitrineParsePx(cellStyle?.width, 123.5);
                const cellH = vitrineParsePx(cellStyle?.height, 123.5);
                const radius = vitrineParsePx(cellStyle?.borderRadius, 12);
                const borderColor = cellStyle?.borderColor || '#D9D9D9';

                const gridStyle = getComputedStyle(vitrineGrid);
                const gapX = vitrineParsePx(gridStyle.columnGap || gridStyle.gap, 3);
                const gapY = vitrineParsePx(gridStyle.rowGap || gridStyle.gap, 3);

                const gridW = cols * cellW + Math.max(0, cols - 1) * gapX;
                const gridH = rows * cellH + Math.max(0, rows - 1) * gapY;

                const titleText = (vitrineTitleEl.textContent || '').trim();
                const titleStyle = getComputedStyle(vitrineTitleEl);
                const fontSize = vitrineParsePx(titleStyle.fontSize, 18);
                const fontFamily = titleStyle.fontFamily || 'Arial';
                const fontWeight = titleStyle.fontWeight || '400';
                const fontStyle = titleStyle.fontStyle || 'normal';
                const titleColor = titleStyle.color || '#000';

                const titleRow = document.getElementById('vitrineTitleRow');
                const logoSvg = titleRow ? titleRow.querySelector('svg') : null;
                let logoImg = null;
                let logoW = 0;
                let logoH = 0;
                if (logoSvg) {
                    try {
                        const serializer = new XMLSerializer();
                        const xml = serializer.serializeToString(logoSvg);
                        const dataUrl = `data:image/svg+xml;charset=utf-8,${encodeURIComponent(xml)}`;
                        logoW = vitrineParsePx(logoSvg.getAttribute('width'), 0);
                        logoH = vitrineParsePx(logoSvg.getAttribute('height'), 0);
                        logoImg = await new Promise((resolve, reject) => {
                            const img = new Image();
                            img.onload = () => resolve(img);
                            img.onerror = () => reject(new Error('Falha ao carregar logo.'));
                            img.src = dataUrl;
                        });
                    } catch (e) {}
                }

                const canvas = document.createElement('canvas');
                const canvasW = Math.ceil(gridW + paddingX * 2);
                const headerH = Math.max(logoH || 0, Math.ceil(fontSize * 1.6));
                const canvasH = Math.ceil(padTop + headerH + headerGap + gridH + padBottom);
                canvas.width = canvasW;
                canvas.height = canvasH;
                const ctx = canvas.getContext('2d');
                if (!ctx) throw new Error('Não foi possível criar canvas.');

                ctx.fillStyle = '#fff';
                ctx.fillRect(0, 0, canvasW, canvasH);

                ctx.textBaseline = 'middle';
                ctx.fillStyle = titleColor;
                ctx.font = `${fontStyle} ${fontWeight} ${fontSize}px ${fontFamily}`;
                const textW = ctx.measureText(titleText).width;
                const groupGap = 18;
                const groupW = (logoImg ? (logoW || logoImg.width) + groupGap : 0) + textW;
                const groupX = Math.max(0, Math.floor((canvasW - groupW) / 2));
                const headerY = padTop + Math.floor(headerH / 2);
                let xCursor = groupX;
                if (logoImg) {
                    const drawW = logoW || logoImg.width;
                    const drawH = logoH || logoImg.height;
                    ctx.drawImage(logoImg, xCursor, headerY - Math.floor(drawH / 2), drawW, drawH);
                    xCursor += drawW + groupGap;
                }
                ctx.fillText(titleText, xCursor, headerY);

                const startX = paddingX;
                const startY = padTop + headerH + headerGap;

                const keys = Object.values(vitrineState?.cells || {});
                const unique = Array.from(new Set(keys.filter(Boolean)));
                const imgMap = new Map();
                await Promise.all(unique.map(async (key) => {
                    const produto = buscarProdutoPorKey(key);
                    const src = produto?.imagem || '/images/img-padrao-mz.png';
                    try {
                        const img = await vitrineLoadImg(src);
                        imgMap.set(key, img);
                    } catch (e) {}
                }));

                for (let r = 0; r < rows; r++) {
                    for (let c = 0; c < cols; c++) {
                        const i = r * cols + c;
                        const x = startX + c * (cellW + gapX);
                        const y = startY + r * (cellH + gapY);

                        vitrineRoundRectPath(ctx, x, y, cellW, cellH, radius);
                        ctx.fillStyle = '#fff';
                        ctx.fill();
                        ctx.strokeStyle = borderColor;
                        ctx.lineWidth = 1;
                        ctx.stroke();

                        const prodKey = vitrineState?.cells?.[String(i)] || '';
                        if (prodKey && imgMap.has(prodKey)) {
                            ctx.save();
                            vitrineRoundRectPath(ctx, x, y, cellW, cellH, radius);
                            ctx.clip();
                            vitrineDrawContain(ctx, imgMap.get(prodKey), x, y, cellW, cellH, 10);
                            ctx.restore();
                        }
                    }
                }
                return canvas;
            }

            async function vitrineCaptureToCanvas() {
                try {
                    if (!vitrineGridWrap) throw new Error('Elemento vitrineGridWrap não encontrado.');
                    const contentW = Math.max(1, Math.ceil(vitrineGridWrap.scrollWidth || vitrineGridWrap.clientWidth ||
                        1));
                    const contentH = Math.max(1, Math.ceil(vitrineGridWrap.scrollHeight || vitrineGridWrap.clientHeight ||
                        1));
                    const paddingX = 100;
                    const w = contentW + paddingX * 2;
                    const h = contentH;

                    const clone = vitrineGridWrap.cloneNode(true);
                    clone.style.overflow = 'visible';
                    clone.style.width = `${contentW}px`;
                    clone.style.height = `${contentH}px`;
                    clone.style.background = '#fff';
                    clone.style.display = 'block';
                    clone.querySelectorAll('.vitrine-remove').forEach((el) => el.remove());
                    clone.querySelectorAll('.vitrine-cell').forEach((el) => {
                        el.classList.remove('is-over');
                        el.classList.remove('is-dragging');
                    });
                    absolutizeImgSrcs(clone);

                    const outer = document.createElement('div');
                    outer.style.width = `${w}px`;
                    outer.style.height = `${h}px`;
                    outer.style.background = '#fff';
                    outer.style.boxSizing = 'border-box';
                    outer.style.padding = `0 ${paddingX}px`;
                    outer.appendChild(clone);
                    inlineSvgsAsImgDataUrl(outer);
                    await inlineImgSrcsAsDataUrl(outer);

                    const css = getAllInlineCssText();
                    const svg = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="${w}" height="${h}">
                        <foreignObject width="100%" height="100%">
                            <div xmlns="http://www.w3.org/1999/xhtml">
                                <style>${css}</style>
                                ${outer.outerHTML}
                            </div>
                        </foreignObject>
                    </svg>
                `;
                    const blob = new Blob([svg], {
                        type: 'image/svg+xml;charset=utf-8'
                    });
                    const url = URL.createObjectURL(blob);

                    const img = new Image();
                    img.crossOrigin = 'anonymous';

                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d');
                    if (!ctx) {
                        URL.revokeObjectURL(url);
                        throw new Error('Não foi possível criar canvas.');
                    }
                    ctx.fillStyle = '#fff';
                    ctx.fillRect(0, 0, w, h);

                    await new Promise((resolve, reject) => {
                        img.onload = () => resolve(null);
                        img.onerror = () => reject(new Error('Falha ao renderizar imagem.'));
                        img.src = url;
                    }).finally(() => {
                        URL.revokeObjectURL(url);
                    });

                    ctx.drawImage(img, 0, 0);
                    return canvas;
                } catch (e) {
                    return await vitrineCaptureToCanvasManual();
                }
            }

            function downloadDataUrl(dataUrl, filename) {
                const a = document.createElement('a');
                a.href = dataUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
            }

            function downloadBlob(blob, filename) {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                setTimeout(() => URL.revokeObjectURL(url), 2000);
            }

            function dataUrlToUint8(dataUrl) {
                const idx = dataUrl.indexOf(',');
                const b64 = idx >= 0 ? dataUrl.slice(idx + 1) : dataUrl;
                const bin = atob(b64);
                const bytes = new Uint8Array(bin.length);
                for (let i = 0; i < bin.length; i++) bytes[i] = bin.charCodeAt(i);
                return bytes;
            }

            function concatUint8(chunks) {
                const total = chunks.reduce((acc, c) => acc + c.length, 0);
                const out = new Uint8Array(total);
                let off = 0;
                for (const c of chunks) {
                    out.set(c, off);
                    off += c.length;
                }
                return out;
            }

            function buildPdfA4FromJpegBytes(jpegBytes, imgW, imgH) {
                const encoder = new TextEncoder();
                const chunks = [];
                let offset = 0;
                const objOffsets = {};

                function pushStr(s) {
                    const b = encoder.encode(s);
                    chunks.push(b);
                    offset += b.length;
                }

                function pushBytes(b) {
                    chunks.push(b);
                    offset += b.length;
                }

                function addObj(id, bodyStr, streamBytes) {
                    objOffsets[id] = offset;
                    pushStr(`${id} 0 obj\n`);
                    if (streamBytes) {
                        pushStr(bodyStr);
                        pushStr('\nstream\n');
                        pushBytes(streamBytes);
                        pushStr('\nendstream\nendobj\n');
                        return;
                    }
                    pushStr(bodyStr);
                    pushStr('\nendobj\n');
                }

                const pageW = 595.28;
                const pageH = 841.89;
                const scale = Math.min(pageW / Math.max(1, imgW), pageH / Math.max(1, imgH));
                const drawW = imgW * scale;
                const drawH = imgH * scale;
                const x = (pageW - drawW) / 2;
                const y = pageH - drawH;

                const contentStream =
                    `q\n${drawW.toFixed(2)} 0 0 ${drawH.toFixed(2)} ${x.toFixed(2)} ${y.toFixed(2)} cm\n/Im0 Do\nQ\n`;
                const contentBytes = encoder.encode(contentStream);

                pushStr('%PDF-1.4\n');

                addObj(1, '<< /Type /Catalog /Pages 2 0 R >>');
                addObj(2, '<< /Type /Pages /Kids [3 0 R] /Count 1 >>');
                addObj(3,
                    `<< /Type /Page /Parent 2 0 R /Resources << /XObject << /Im0 4 0 R >> /ProcSet [/PDF /ImageC] >> /MediaBox [0 0 ${pageW.toFixed(2)} ${pageH.toFixed(2)}] /Contents 5 0 R >>`
                );
                addObj(4,
                    `<< /Type /XObject /Subtype /Image /Width ${Math.max(1, Math.round(imgW))} /Height ${Math.max(1, Math.round(imgH))} /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length ${jpegBytes.length} >>`,
                    jpegBytes
                );
                addObj(5, `<< /Length ${contentBytes.length} >>`, contentBytes);

                const xrefStart = offset;
                pushStr('xref\n');
                pushStr('0 6\n');
                pushStr('0000000000 65535 f \n');
                for (let id = 1; id <= 5; id++) {
                    const off = objOffsets[id] || 0;
                    pushStr(String(off).padStart(10, '0') + ' 00000 n \n');
                }
                pushStr('trailer\n');
                pushStr('<< /Size 6 /Root 1 0 R >>\n');
                pushStr('startxref\n');
                pushStr(String(xrefStart) + '\n');
                pushStr('%%EOF\n');

                return concatUint8(chunks);
            }

            async function exportVitrineJpg() {
                const canvas = await vitrineCaptureToCanvas();
                const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
                downloadDataUrl(dataUrl, getVitrineExportFileName('jpg'));
            }

            async function exportVitrinePdf() {
                const canvas = await vitrineCaptureToCanvas();
                const jpgDataUrl = canvas.toDataURL('image/jpeg', 0.92);
                const jpgBytes = dataUrlToUint8(jpgDataUrl);
                const pdfBytes = buildPdfA4FromJpegBytes(jpgBytes, canvas.width, canvas.height);
                const blob = new Blob([pdfBytes], {
                    type: 'application/pdf'
                });
                downloadBlob(blob, getVitrineExportFileName('pdf'));
            }

            function aplicarVitrineRows(nextRows) {
                const rows = Math.max(1, Number(nextRows) || 1);
                if (rows === vitrineState.rows) return;
                vitrineState.rows = rows;
                const total = getVitrineTotalCells();
                Object.keys(vitrineState.cells).forEach((k) => {
                    const idx = Number(k);
                    if (!Number.isFinite(idx) || idx < 0 || idx >= total) delete vitrineState.cells[k];
                });
                salvarVitrineState(vitrineState);
                renderVitrineGrid();
            }

            function aplicarVitrineCols(nextCols) {
                const cols = Math.min(VITRINE_MAX_COLS, Math.max(1, Number(nextCols) || 1));
                const oldCols = vitrineState.cols;
                if (cols === oldCols) return;
                const rows = vitrineState.rows;
                const newCells = {};
                const maxCols = Math.min(oldCols, cols);
                for (let r = 0; r < rows; r++) {
                    for (let c = 0; c < maxCols; c++) {
                        const oldIndex = r * oldCols + c;
                        const newIndex = r * cols + c;
                        const key = vitrineState.cells[String(oldIndex)];
                        if (key) newCells[String(newIndex)] = key;
                    }
                }
                vitrineState.cols = cols;
                vitrineState.cells = newCells;
                salvarVitrineState(vitrineState);
                renderVitrineGrid();
                requestAnimationFrame(() => centralizarVitrineGridHorizontal());
            }

            function vitrineRemoveAll() {
                vitrineState.cells = {};
                salvarVitrineState(vitrineState);
                renderVitrineGrid();
            }

            function vitrineAddAll() {
                const keys = getPedidoKeys();
                if (!keys.length) return;
                const used = new Set(Object.values(vitrineState.cells || {}));
                const queue = keys.filter((k) => !used.has(k));
                if (!queue.length) return;

                const total = getVitrineTotalCells();
                for (let i = 0; i < total && queue.length; i++) {
                    if (vitrineState.cells[String(i)]) continue;
                    vitrineState.cells[String(i)] = queue.shift();
                }
                salvarVitrineState(vitrineState);
                renderVitrineGrid();
            }

            function abrirVitrineModal() {
                if (!vitrineModal) return;
                vitrineReturnToPedido = Boolean(pedidoModal && pedidoModal.classList.contains('active'));
                if (vitrineReturnToPedido) {
                    try {
                        document.activeElement?.blur?.();
                    } catch (e) {}
                    fecharPedidoModal();
                }
                vitrineState = carregarVitrineState();
                if (vitrineTitleEl) {
                    const baseTitle = (titlePedidoEl?.textContent || '').trim();
                    vitrineTitleEl.textContent = baseTitle ? baseTitle : 'Vitrine';
                }
                vitrineModal.classList.add('active');
                vitrineModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('pedido-modal-open');
                requestAnimationFrame(() => {
                    vitrineBaseCellPx = calcularVitrineBaseCellPx();
                    renderVitrineGrid();
                    renderVitrineProductsList();
                    centralizarVitrineGridHorizontal();
                    updateVitrineStripScrollbar();
                });
            }

            function fecharVitrineModal() {
                if (!vitrineModal) return;
                vitrineModal.classList.remove('active');
                vitrineModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('pedido-modal-open');
                if (vitrineReturnToPedido) {
                    vitrineReturnToPedido = false;
                    abrirPedidoModal();
                }
            }

            if (pedidoModalVitrineBtn) {
                pedidoModalVitrineBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    abrirVitrineModal();
                });
            }

            if (vitrineModalBackBtn) {
                vitrineModalBackBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    fecharVitrineModal();
                });
            }

            if (vitrineRowsPlusBtn) {
                vitrineRowsPlusBtn.addEventListener('click', () => {
                    aplicarVitrineRows(vitrineState.rows + 1);
                });
            }
            if (vitrineRowsMinusBtn) {
                vitrineRowsMinusBtn.addEventListener('click', () => {
                    if (vitrineState.rows <= 1) return;
                    aplicarVitrineRows(vitrineState.rows - 1);
                });
            }
            if (vitrineColsPlusBtn) {
                vitrineColsPlusBtn.addEventListener('click', () => {
                    aplicarVitrineCols(vitrineState.cols + 1);
                });
            }
            if (vitrineColsMinusBtn) {
                vitrineColsMinusBtn.addEventListener('click', () => {
                    if (vitrineState.cols <= 1) return;
                    aplicarVitrineCols(vitrineState.cols - 1);
                });
            }
            if (vitrineAddAllBtn) {
                vitrineAddAllBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    vitrineAddAll();
                });
            }

            if (vitrineRemoveAllBtn) {
                vitrineRemoveAllBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    vitrineRemoveAll();
                });
            }

            if (vitrineExportJpgBtn) {
                vitrineExportJpgBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    try {
                        await exportVitrineJpg();
                    } catch (err) {
                        try {
                            console.error(err);
                        } catch (e) {}
                        const msg = err && typeof err === 'object' && 'message' in err && err.message ?
                            `Não foi possível gerar o JPG. (${err.message})` :
                            'Não foi possível gerar o JPG.';
                        alert(msg);
                    }
                });
            }

            if (vitrineExportPdfBtn) {
                vitrineExportPdfBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    try {
                        await exportVitrinePdf();
                    } catch (err) {
                        try {
                            console.error(err);
                        } catch (e) {}
                        const msg = err && typeof err === 'object' && 'message' in err && err.message ?
                            `Não foi possível gerar o PDF. (${err.message})` :
                            'Não foi possível gerar o PDF.';
                        alert(msg);
                    }
                });
            }

            window.addEventListener('resize', () => {
                if (vitrineModal && vitrineModal.classList.contains('active')) {
                    renderVitrineGrid();
                    requestAnimationFrame(() => centralizarVitrineGridHorizontal());
                    requestAnimationFrame(() => updateVitrineStripScrollbar());
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key !== 'Escape') return;
                if (vitrineModal && vitrineModal.classList.contains('active')) {
                    fecharVitrineModal();
                    return;
                }
                if (pedidoHistoryModal && pedidoHistoryModal.classList.contains('active')) {
                    fecharPedidoHistoryModal();
                    return;
                }
                if (pedidoModal && pedidoModal.classList.contains('active')) {
                    fecharPedidoModal();
                    return;
                }
                setPedidoMode(false);
            });

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

                        const matchesSilhueta = selectedFilters.silhueta.length === 0 ||
                            selectedFilters.silhueta.some(sil => (p.silhueta || '').toLowerCase() === sil.toLowerCase());

                        const matchesLinha = selectedFilters.linha.length === 0 ||
                            selectedFilters.linha.some(lin => (p.linha || '').toLowerCase() === lin.toLowerCase());

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
                            matchesTamanho && matchesClassificacao && matchesGenero && matchesSilhueta && matchesLinha &&
                            matchesSegmentacao &&
                            matchesPreco;
                    }
                );
            }

            function aplicarFiltros() {
                applySorting(selectedSortValue);
            }

            renderProdutos(produtosData, false);
            atualizarPedidoBadge();
            atualizarVisibilidadeCtasPedido();

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
                        console.log(option);
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
                    closeColecaoDropdown();
                    closeFilterDropdown();
                    closeSortDropdown();
                    openColecaoDropdown();
                }
            });

            colecaoOptions.addEventListener('click', function(e) {
                if (e.target.classList.contains('x-icon')) {
                    e.stopPropagation();
                    const option = e.target.closest('.option');
                    if (option) {
                        //colecaoSelectedText.textContent = 'Selecione uma coleção';
                        closeColecaoDropdown();
                        const slug = option.getAttribute('data-slug');
                        const currentUrl = window.location.href;
                        const newUrl = currentUrl.replace(/\/[^/]+$/, "");
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

                    const description = (option.querySelector('.option-content span') !== null) ? option.querySelector(
                        '.option-content span').textContent : '';
                    colecaoSelectedText.textContent = (description === '') ? text : text + ' ' + description;
                    closeColecaoDropdown();

                    window.location.href = newUrl;
                }
            });

            categorySelectButton.addEventListener('click', function(e) {

                e.stopPropagation();

                if (categoryOptions.classList.contains('show')) {
                    closeCategoryDropdown();
                    closeFilterDropdown();
                } else {
                    closeColecaoDropdown();
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
                silhueta: [],
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
                    closeColecaoDropdown();
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
                    selectedFilters.silhueta = [];
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
                    selectedFilters.silhueta.length + selectedFilters.linha.length +
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
                    closeColecaoDropdown();
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
                        silhueta: [],
                        linha: [],
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


            // ==================== SCROLLBAR CUSTOMIZADA DO MODAL ====================
            (function() {
                const content = document.getElementById('pedidoModalBody');
                const thumb = document.getElementById('scrollThumb');
                const track = document.getElementById('scrollTrack');
                const btnUp = document.getElementById('btnUp');
                const btnDown = document.getElementById('btnDown');

                if (!content || !thumb || !track || !btnUp || !btnDown) return;

                function updateThumb() {
                    if (content.scrollHeight <= content.clientHeight) {
                        thumb.style.display = 'none';
                        return;
                    }
                    thumb.style.display = 'block';
                    const trackH = track.clientHeight;
                    const ratio = content.clientHeight / content.scrollHeight;
                    const thumbH = Math.max(28, trackH * ratio);
                    const maxTop = trackH - thumbH;
                    const scrollR = content.scrollTop / (content.scrollHeight - content.clientHeight);
                    thumb.style.height = thumbH + 'px';
                    thumb.style.top = (scrollR * maxTop) + 'px';
                }

                content.addEventListener('scroll', updateThumb);
                window.addEventListener('resize', updateThumb);

                // re-calcular sempre que o modal abrir
                document.getElementById('pedidoModal').addEventListener('transitionend', updateThumb);

                // hook no abrirPedidoModal já existente
                const _abrirOriginal = window.abrirPedidoModal;
                if (typeof _abrirOriginal === 'function') {
                    window.abrirPedidoModal = function() {
                        _abrirOriginal.apply(this, arguments);
                        setTimeout(updateThumb, 50);
                    };
                }

                let scrollInterval;
                btnUp.addEventListener('mousedown', () => {
                    content.scrollBy({
                        top: -40,
                        behavior: 'smooth'
                    });
                    scrollInterval = setInterval(() => content.scrollBy({
                        top: -40
                    }), 100);
                });
                btnDown.addEventListener('mousedown', () => {
                    content.scrollBy({
                        top: 40,
                        behavior: 'smooth'
                    });
                    scrollInterval = setInterval(() => content.scrollBy({
                        top: 40
                    }), 100);
                });
                document.addEventListener('mouseup', () => clearInterval(scrollInterval));

                let dragging = false,
                    startY, startTop;
                thumb.addEventListener('mousedown', e => {
                    dragging = true;
                    startY = e.clientY;
                    startTop = content.scrollTop;
                    e.preventDefault();
                });
                document.addEventListener('mousemove', e => {
                    if (!dragging) return;
                    const delta = e.clientY - startY;
                    const ratio = delta / (track.clientHeight - thumb.clientHeight);
                    content.scrollTop = startTop + ratio * (content.scrollHeight - content.clientHeight);
                });
                document.addEventListener('mouseup', () => {
                    dragging = false;
                });

                track.addEventListener('click', e => {
                    if (e.target === thumb) return;
                    const rect = track.getBoundingClientRect();
                    const ratio = (e.clientY - rect.top) / track.clientHeight;
                    content.scrollTop = ratio * (content.scrollHeight - content.clientHeight);
                });
            })();
        </script>
    @endpush

</x-layout-user>
