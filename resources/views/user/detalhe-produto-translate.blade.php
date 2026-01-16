<x-layout-user-produto-translate title="Under Armour - Detalhe Produto">
    <style>
        .badge-icon-wrapper .badge-tooltip {
            visibility: hidden;
            opacity: 0;
            background-color: #fff;
            color: #000;
            text-align: center;
            position: absolute;
            z-index: 10;
            top: 15%;
            left: -170%;
            transform: translateX(-50%);
            transition: opacity 0.3s;
            white-space: nowrap;
            padding: 0;
            border-radius: 4px;
            font-size: 8px;
        }

        .badge-icon-wrapper:hover .badge-tooltip {
            visibility: visible;
            opacity: 1;
        }

        #imageModal {
            .swiper img {
                width: 100%;
                height: 100%;
                cursor: crosshair;
                /* Indicador de zoom */
            }

            .swiper-button-prev,
            .swiper-button-next {
                color: transparent !important;
                background: #FFF;
                border: 1px solid #FFF;
                opacity: 1 !important;
                z-index: 20;
                /* Garantir que fiquem acima do zoom */
            }

            .swiper-button-prev {
                left: 30px;
            }

            .swiper-button-next {
                right: 30px;
            }

            .swiper-button-next,
            .swiper-button-prev {
                color: #000;
                background: #fff;
                opacity: 0.2;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                margin-top: -25px;
                transition: all 0.3s;
            }

            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 15px;
            }
        }

        /* Shimmer para skeleton de carregamento */
        .skeleton-shimmer {
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite linear;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .word {
            white-space: normal;
            /* permite quebra de linha */
            word-break: keep-all;
            /* impede quebra dentro das palavras */
            overflow-wrap: break-word;
            /* garante quebra segura entre blocos */
            padding: 0 2px;
        }


        /* Container do grid ocupa todo espaço disponível */
        .image-grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0;
            width: 100%;
        }

        /* Cada célula mantém proporção quadrada */
        .image-cell {
            aspect-ratio: 1 / 1;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: opacity 0.2s;
        }


        /* Imagem preenche a célula mantendo proporção */
        .image-cell img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Container principal ocupa largura total */
        .main-container {
            display: flex;
            gap: 0.5rem;
            width: 100%;
            max-width: 100%;
        }

        /* Lado esquerdo flexível */
        .left-section {
            flex: 1;
            min-width: 0;
        }

        /* Lado direito fixo */
        .right-section {
            width: 500px;
            flex-shrink: 0;
        }
    </style>
    <main class="absolute top-20 lg:flex flex-1 produtos-page">
        @php
            $currentUrl = request()->path();
            $currentSlug = '';

            if (strpos($currentUrl, 'user') === 0) {
                $parts = explode('/', $currentUrl);
                if (count($parts) > 1) {
                    $currentSlug = $parts[4];
                }
            }
        @endphp
        <div class="max-w-full px-2 pb-3">
            <div class="main-container">
                <!-- Seção de Imagens - Esquerda -->
                <div class="left-section">
                    <!-- Grid de Imagens para Desktop (2 colunas x 4 linhas) -->
                    <div class="hidden lg:block bg-white rounded-lg border border-[#CBCBCB] overflow-hidden h-full">
                        <div class="image-grid-container h-full" id="desktopGrid">
                            <!-- Imagens serão carregadas dinamicamente via JavaScript -->
                        </div>
                    </div>

                    <!-- Loader de Imagens (Skeleton 2x2 com spinner por célula, desktop e mobile) -->
                    <div id="imageLoader"
                        class="bg-white rounded-lg shadow-sm border border-[#CBCBCB] overflow-hidden hidden h-screen">
                        <!-- Mobile/Tablet: grade 2x2 -->
                        <div class="lg:hidden grid grid-cols-2 gap-0 p-0 h-full">
                            @for ($i = 0; $i < 4; $i++)
                                <div class="border border-[#EFEFEF]">
                                    <div class="relative w-full h-full skeleton-shimmer"></div>
                                </div>
                            @endfor
                        </div>

                        <!-- Desktop: grade 2x2 -->
                        <div class="hidden lg:grid grid-cols-2 gap-0 p-0 h-full">
                            @for ($i = 0; $i < 4; $i++)
                                <div class="border border-[#EFEFEF]">
                                    <div class="relative w-full h-full skeleton-shimmer"></div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Estado vazio (sem imagens disponíveis) -->
                    <div id="imageEmpty"
                        class="bg-white rounded-lg shadow-sm border border-[#CBCBCB] flex items-center justify-center hidden"
                        style="margin-top: 0px;">
                        <div class="transition-opacity">
                            <img src="/images/img-padrao-ua.png" alt="Vista 1"
                                class="w-full object-contain rounded-lg "
                                onerror="this.src='/images/img-padrao-ua.png'">
                        </div>
                    </div>

                    <!-- Swiper para Tablet e Mobile -->
                    <div class="lg:hidden" id="mobileSwiper">
                        <div class="swiper thumbnailSwiper">
                            <div class="swiper-wrapper">
                                <!-- Slides serão carregados dinamicamente via JavaScript -->
                            </div>
                            <!-- Pagination dots -->
                            <div class="swiper-pagination mt-4"></div>
                        </div>
                    </div>
                </div>

                <!-- Seção de Detalhes - Direita -->
                <div class="right-section space-y-6" id="rightPanel">
                    <!-- Cabeçalho do Produto -->
                    <div class="bg-white rounded-lg p-5 shadow-sm border border-[#CBCBCB]">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-base text-black">{{ $produto->category->name }}
                                    <span class="opacity-50">{{ $produto->code }}</span>
                                </p>
                            </div>
                            <button id="favoriteBtn" class="text-black hover:text-black transition-colors">
                                <!-- Ícone Outline (vazio) -->
                                <svg id="iconOutline" class="w-6 h-6 float-right" xmlns="http://www.w3.org/2000/svg"
                                    width="18" height="16" viewBox="0 0 18 16" fill="none">
                                    <path
                                        d="M0 5.26362C0 8.97604 3.23565 12.6275 8.34743 15.7647C8.53776 15.878 8.80967 16 9 16C9.19033 16 9.46224 15.878 9.66163 15.7647C14.7644 12.6275 18 8.97604 18 5.26362C18 2.17865 15.7976 0 12.861 0C11.1843 0 9.82477 0.766885 9 1.94336C8.19335 0.775599 6.81571 0 5.13897 0C2.20242 0 0 2.17865 0 5.26362ZM1.45921 5.26362C1.45921 2.94553 3.01813 1.40305 5.12085 1.40305C6.82477 1.40305 7.80363 2.42266 8.38369 3.29412C8.6284 3.6427 8.78248 3.73856 9 3.73856C9.21752 3.73856 9.35347 3.63399 9.61631 3.29412C10.2417 2.44009 11.1843 1.40305 12.8792 1.40305C14.9819 1.40305 16.5408 2.94553 16.5408 5.26362C16.5408 8.50545 12.9789 12 9.19033 14.4227C9.0997 14.4837 9.03625 14.5272 9 14.5272C8.96375 14.5272 8.9003 14.4837 8.81873 14.4227C5.02115 12 1.45921 8.50545 1.45921 5.26362Z"
                                        fill="black" />
                                </svg>
                                <span id="favoriteText"
                                    class="text-sm opacity-50 float-left pt-[2px] pr-2 hidden">Adicionado aos
                                    Favoritos</span>
                                <!-- Ícone Preenchido (solid) -->
                                <svg id="iconFilled" class="w-6 h-6 text-black hidden"
                                    xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16"
                                    fill="none">
                                    <path
                                        d="M0 5.26362C0 8.97604 3.23565 12.6275 8.34743 15.7647C8.53776 15.878 8.80967 16 9 16C9.19033 16 9.46224 15.878 9.66163 15.7647C14.7643 12.6275 18 8.97604 18 5.26362C18 2.17865 15.7976 0 12.861 0C11.1843 0 9.82477 0.766885 9 1.94336C8.19335 0.775599 6.81571 0 5.13897 0C2.20242 0 0 2.17865 0 5.26362Z"
                                        fill="black" />
                                </svg>
                            </button>
                        </div>
                        <div class="my-4">
                            <h1 class="title extra-black text-[30px] lg:text-[35px] font-fko leading-[30px] uppercase">
                                {{ $produto->name }}
                            </h1>
                        </div>

                        <!-- Variações de Cor -->
                        <div class="mb-6">
                            <p class="text-xs text-black opacity-50 pb-2">Cores</p>
                            <!-- Primeira linha - 4 cores -->
                            <div class="grid grid-cols-3 lg:grid-cols-4 mb-4 gap-1">
                                @foreach ($produto->colors as $color)
                                    <!-- Cor 1 - Selecionada -->
                                    <div class="relative">
                                        <div class="box-color bg-white {{ $loop->first ? 'border border-black' : '' }} rounded-lg cursor-pointer transition-all duration-200 hover:shadow-md"
                                            data-color-code="{{ $color->color_code }}"
                                            data-genero="{{ $color->genero }}">
                                            <div class="relative">
                                                @php
                                                    $baseColorCode = str_replace('/', '_', $color->color_code);
                                                    $basePath = public_path(
                                                        '/images/produtos/' .
                                                            str_replace('/', '_', $produto->code) .
                                                            '_' .
                                                            $baseColorCode .
                                                            '.jpg',
                                                    );
                                                    $imgSrc = file_exists($basePath)
                                                        ? '/images/produtos/' .
                                                            str_replace('/', '_', $produto->code) .
                                                            '_' .
                                                            $baseColorCode .
                                                            '.jpg'
                                                        : '/images/img-padrao-ua.png';
                                                @endphp
                                                <img src="{{ $imgSrc }}" alt="{{ $color->color_name }}"
                                                    class="w-full object-contain rounded-lg" loading="lazy" />
                                                @if ($color->flag_product_id)
                                                    @if ($color->flagProduct->icon != null)
                                                        <div
                                                            class="badge-icon-wrapper absolute top-1 {{ $color->flagProduct->alinhamento }}-0">
                                                            <img src="/{{ $color->flagProduct->icon }}"
                                                                alt="{{ $color->flagProduct->flag_title }}"
                                                                class="badge-icon"
                                                                style="width:19px; height:19px; margin-right:3px">
                                                            <span class="badge-tooltip"
                                                                style="color: {{ $color->flagProduct->flag_color_text_bg }};">
                                                                {{ $color->flagProduct->flag_title }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <span
                                                            class="absolute top-2 left-1 bg-[{{ $color->flagProduct->flag_bg }}] text-[{{ $color->flagProduct->flag_color_text_bg }}] text-[10px] px-2 py-0.5 rounded-full">{{ $color->flagProduct->flag_title }}</span>
                                                    @endif
                                                @endif
                                            </div>

                                            <div class="text-center pb-2">
                                                <p class="text-xs text-black">{{ $color->color_name }}</p>
                                                <p class="text-xs text-black opacity-50 word">
                                                    {{ $color->color_description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Descrição -->
                        @if ($produto->description)
                            <div class="mb-6">
                                <h3 class="text-xs text-black opacity-50">Descrição</h3>
                                <p class="text-xs">
                                    {{ $produto->description }}
                                </p>
                            </div>
                        @endif

                        <!-- Preço -->
                        <div class="mb-6">
                            <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                                <div>
                                    <p class="text-xs text-black opacity-50">PDV</p>
                                    <p class="text-base">R$ {{ $produto->price }}</p>
                                </div>

                                <div>
                                    <p class="text-xs text-black opacity-50">Gênero</p>
                                    <p class="text-base genero">{{ $produto->colors->first()->genero }}</p>
                                </div>
                                @if ($produto->caracteristicasDestaque)
                                    @foreach ($produto->caracteristicasDestaque as $caracteristica)
                                        <div>
                                            <p class="text-xs text-black opacity-50">
                                                {{ $caracteristica->title }}</p>
                                            <p class="text-sm">{!! nl2br(e($caracteristica->description)) !!}</p>
                                        </div>
                                    @endforeach
                                @endif

                                @if ($produto->caracteristicas)
                                    @foreach ($produto->caracteristicas as $caract)
                                        <div>
                                            <p class="text-xs text-black opacity-50">{{ $caract->title }}</p>
                                            <p class="text-sm">{!! nl2br(e($caract->description)) !!}</p>
                                        </div>
                                    @endforeach
                                @endif


                                @php
                                    $firstColorNumeracao = optional($produto->colors->first()->numeracao)->numero;
                                    $productNumeracoesText = $produto->numeracoes
                                        ? $produto->numeracoes->pluck('numero')->implode(', ')
                                        : '';
                                    $initialNumeracao = $firstColorNumeracao ?: $productNumeracoesText;
                                @endphp
                                <div>
                                    <p class="text-xs text-black opacity-50">Tamanhos</p>
                                    <p class="text-sm" id="numeracao">{{ $initialNumeracao }}</p>
                                </div>

                            </div>
                        </div>

                        <!-- Tecnologias -->
                        @if (count($produto->technologyItems) > 0)
                            <div class="mb-6">
                                <h3 class="text-xs mb-3 text-black opacity-50">Tecnologias</h3>
                                <div class="">
                                    @foreach ($produto->technologyItems as $item)
                                        <div class="mb-[30px] flex">
                                            <div class="w-[65px] h-[65px] float-left mr-[10px] bg-black rounded-lg ">
                                                <img src="/{{ $item->icon }}" class="w-100 h-100 my-0 rounded-lg"
                                                    alt="{{ $item->name }}" />
                                            </div>
                                            <div class="w-[380px] min-h-[65px]">
                                                <p class="text-xs text-black opacity-50">{{ $item->name }}</p>
                                                <p class="text-xs">
                                                    {{ $item->description }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div style="clear: both;"></div>

                        <!-- Arquivos/Links -->
                        <div class="my-[30px]">
                            @if (count($produto->links) > 0)
                                <h3 class="text-xs mb-5 text-black opacity-50">Arquivos/Links</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($produto->links as $link)
                                        <a href="{{ $link->link_url }}" target="_blank"
                                            class="flex items-center gap-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm transition-colors">
                                            <img src="/images/icones/clip.png" alt="" />
                                            <span>{{ $link->link_title }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Sugestão de Atualização -->
                        <div class="border-t pt-4">
                            <button id="openSuggestionModal"
                                class="flex items-center gap-2 transition-colors text-xs  ">
                                <span class="opacity-50 hover:opacity-100 hover:underline">Enviar sugestão de
                                    atualização/correção</span>
                                <svg class="opacity-100" xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" viewBox="0 0 16 16" fill="none">
                                    <path
                                        d="M2.5393 16H12.0333C13.489 16 14.33 15.1576 14.33 13.4889V4.82974L13.028 6.13389V13.4241C13.028 14.2666 12.5752 14.6959 12.0172 14.6959H2.56355C1.75486 14.6959 1.302 14.2666 1.302 13.4241V4.23032C1.302 3.3879 1.75486 2.95048 2.56355 2.95048H9.93073L11.2327 1.64634H2.5393C0.857216 1.64634 0 2.48877 0 4.15742V13.4889C0 15.1657 0.857216 16 2.5393 16ZM5.48293 10.7511L7.05991 10.0625L14.6131 2.50497L13.5052 1.41143L5.96006 8.96896L5.23224 10.4919C5.16754 10.6295 5.32929 10.8158 5.48293 10.7511ZM15.2115 1.91365L15.7937 1.31423C16.0687 1.02262 16.0687 0.633807 15.7937 0.366498L15.6078 0.172092C15.3571 -0.0790163 14.9608 -0.0466151 14.694 0.212593L14.1036 0.795811L15.2115 1.91365Z"
                                        fill="black" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Imagens -->
        <div id="imageModal"
            class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center">
            <div class="relative w-[100vw] h-[100vh] bg-white mx-4">
                <!-- Botão Fechar -->
                <a onclick="closeImageModal()"
                    class="absolute top-4 right-4 flex items-center border border-black rounded-full px-3 py-2 text-md bg-gray-100 hover:bg-gray-200 transition text-[14px] z-50">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="px-1" />
                </a>

                <!-- Swiper Container -->
                <div class="swiper modalSwiper h-full">
                    <div class="swiper-wrapper">
                        @php
                            $suffixes = [
                                '',
                                '_A',
                                '_B',
                                '_C',
                                '_D',
                                '_E',
                                '_F',
                                '_G',
                                '_H',
                                '_I',
                                '_J',
                                '_K',
                                '_L',
                                '_M',
                                '_N',
                            ];
                            $vista = 1;
                        @endphp

                        @foreach ($suffixes as $suffix)
                            @php
                                $imagePath = public_path(
                                    'images/produtos/' .
                                        $produto->code .
                                        '_' .
                                        str_replace('/', '_', $produto->colors[0]->color_code) .
                                        $suffix .
                                        '.jpg',
                                );
                            @endphp
                            @if (file_exists($imagePath))
                                <div class="swiper-slide flex items-center justify-center">
                                    <img src="/images/produtos/{{ $produto->code }}_{{ str_replace('/', '_', $produto->colors[0]->color_code) }}{{ $suffix }}.jpg"
                                        alt="Vista {{ $vista }}"
                                        class="max-w-full max-h-full object-contain transition-transform duration-300 cursor-zoom-in"
                                        data-modal-image="/images/produtos/{{ $produto->code }}_{{ str_replace('/', '_', $produto->colors[0]->color_code) }}{{ $suffix }}.jpg"
                                        onerror="this.src='/images/img-padrao-ua.png'" />
                                </div>
                            @endif
                            @php $vista++; @endphp
                        @endforeach
                    </div>

                    <!-- Navigation buttons -->
                    <div class="swiper-button-next text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                            fill="none">
                            <circle cx="20" cy="20" r="20" transform="rotate(-180 20 20)"
                                fill="white" fill-opacity="1" />
                            <circle cx="20" cy="20" r="19.5" transform="rotate(-180 20 20)"
                                stroke="white" stroke-opacity="1" />
                            <path d="M17.334 26.6665L23.9336 20.0668L17.334 13.4672" stroke="black" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="swiper-button-prev text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                            fill="none">
                            <circle cx="20" cy="20" r="20" fill="white" fill-opacity="1" />
                            <circle cx="20" cy="20" r="19.5" stroke="white" stroke-opacity="1" />
                            <path d="M22.666 13.333L16.0664 19.9327L22.666 26.5323" stroke="black" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>

                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>

        <x-suggestion-modal />
    </main>

    @push('scripts')
        <!-- Swiper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.js"></script>

        <!-- SweetAlert2 JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.all.min.js"></script>

        <script>
            // Cache para armazenar informações de imagens válidas
            const imageCache = new Map();
            const suffixes = ['', '_A', '_B', '_C', '_D', '_E', '_F', '_G', '_H', '_I', '_J', '_K', '_L', '_M', '_N'];
            const productCode = '{{ str_replace('/', '_', $produto->code) }}';

            // Variáveis globais
            let currentColorCode = '{{ str_replace('/', '_', $produto->colors->first()->color_code) ?? '' }}';
            const productId = {{ $produto->id }};
            let modalSwiper;

            // Inicializar Swiper para mobile/tablet
            const swiper = new Swiper(".thumbnailSwiper", {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: false,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 15,
                    },
                },
            });

            // Função para verificar se imagem existe
            function checkImageExists(imagePath) {
                return new Promise((resolve) => {
                    const img = new Image();
                    img.onload = () => resolve(true);
                    img.onerror = () => resolve(false);
                    img.src = imagePath;
                });
            }

            // Pré-carrega informações sobre quais imagens existem para cada cor
            async function preloadImageInfo() {
                //console.log('Pré-carregando informações das imagens...');

                // Mostrar loader enquanto pré-carrega
                showLoading();
                setContentVisibility(false);

                const promises = [];
                const tempCache = new Map();

                coresData.forEach(cor => {
                    const color = cor.color_code.replace(/\//g, '_');

                    // Pré-criar lista ordenada pelos sufixos
                    const colorImages = suffixes.map((suffix, index) => ({
                        suffix,
                        index,
                        path: `/images/produtos/${productCode}_${color}${suffix}.jpg`,
                        exists: false
                    }));

                    tempCache.set(color, colorImages);

                    // Verificar existência sem alterar a ordem
                    colorImages.forEach(imgInfo => {
                        const p = checkImageExists(imgInfo.path).then(exists => {
                            imgInfo.exists = exists;
                        });
                        promises.push(p);
                    });
                });

                await Promise.all(promises);
                //console.log('Pré-carregamento concluído');

                // Consolidar cache mantendo ordem definida por 'suffixes'
                tempCache.forEach((images, color) => {
                    const validImages = images
                        .filter(img => img.exists)
                        .sort((a, b) => a.index - b.index)
                        .map(({
                            exists,
                            ...rest
                        }) => rest);

                    imageCache.set(color, validImages);
                });
            }

            // Função otimizada para carregar imagens (usa cache)
            function carregarImagensProdutoOtimizado(colorCode = null) {
                if (!colorCode) {
                    const coresFiltradas = filtrarCoresPorSegmentacao();
                    if (coresFiltradas.length > 0) {
                        colorCode = coresFiltradas[0].color_code;
                    } else {
                        return;
                    }
                }

                const color = colorCode.replace(/\//g, '_');
                const cachedImages = imageCache.get(color) || [];

                // Mostrar loader antes de atualizar o conteúdo
                showLoading();
                hideEmpty();
                setContentVisibility(false);

                // Atualizar imagens do desktop grid imediatamente
                const desktopGrid = document.getElementById('desktopGrid');
                if (desktopGrid) {
                    desktopGrid.innerHTML = '';

                    cachedImages.forEach((imgInfo, index) => {
                        const imageDiv = document.createElement('div');
                        imageDiv.className = 'image-cell ';
                        imageDiv.setAttribute('data-image', imgInfo.path);
                        imageDiv.onclick = function() {
                            openImageModal(this);
                        };

                        // Lógica para determinar as classes de corner
                        let cornerClass = 'rounded-none';
                        const totalImages = cachedImages.length;
                        const isFirstRow = index < 2; // Primeiras 2 imagens (índices 0 e 1)
                        const isLastImage = index === totalImages - 1; // Última imagem
                        const isOddTotal = totalImages % 2 !== 0; // Total ímpar

                        if (totalImages === 2) {
                            // Caso especial: apenas 2 imagens
                            cornerClass = index === 0 ? 'rounded-l-lg' : 'rounded-r-lg';
                        } else if (isFirstRow) {
                            // Primeira linha
                            cornerClass = index === 0 ? 'rounded-tl-lg border-b border-r' : 'rounded-tr-lg border-b';
                        } else if (isOddTotal && isLastImage) {
                            // Se total é ímpar e é a última imagem (sozinha na linha)
                            cornerClass = 'rounded-bl-lg border-r';
                        } else if (!isOddTotal && index >= totalImages - 2) {
                            // Última linha com 2 imagens (apenas quando total é PAR)
                            const isLeftColumn = index % 2 === 0; // Coluna esquerda (índices pares)
                            cornerClass = isLeftColumn ? 'rounded-bl-lg border-r' : 'rounded-br-lg';
                        } else {
                            // Última linha com 2 imagens (apenas quando total é PAR)
                            const isLeftColumn = index % 2 === 0; // Coluna esquerda (índices pares)
                            cornerClass = isLeftColumn ? 'border-b border-r' : 'border-b';
                        }
                        // Caso contrário, mantém 'rounded-none' para imagens do meio

                        imageDiv.className = `image-cell ${cornerClass}`;
                        imageDiv.innerHTML = `
            <img src="${imgInfo.path}" 
                 alt="Vista ${imgInfo.index + 1}" 
                 class=""
                 onerror="this.src='/images/img-padrao-ua.png'" />
        `;

                        desktopGrid.appendChild(imageDiv);
                    });
                }

                // Atualizar imagens do mobile swiper imediatamente
                const swiperWrapper = document.querySelector('.swiper-wrapper');
                if (swiperWrapper) {
                    swiperWrapper.innerHTML = '';

                    cachedImages.forEach(imgInfo => {
                        const slide = document.createElement('div');
                        slide.className = 'swiper-slide';

                        slide.innerHTML = `
                            <div class="bg-white cursor-pointer flex items-center justify-center hover:opacity-80 transition-opacity aspect-square w-full"
                                 data-image="${imgInfo.path}"
                                 onclick="openImageModal(this)">
                                <img src="${imgInfo.path}"
                                     alt="Vista ${imgInfo.index + 1}"
                                     class="max-w-[80%] max-h-[80%] object-contain"
                                     onerror="this.src='/images/img-padrao-ua.png'" />
                            </div>
                        `;

                        swiperWrapper.appendChild(slide);
                    });

                    // Reinicializar o swiper se existir
                    if (window.thumbnailSwiper) {
                        window.thumbnailSwiper.update();
                    }
                }

                // Atualizar imagens do modal imediatamente
                atualizarImagensModalOtimizado(colorCode);

                // Alternar estados de loading/empty conforme resultado
                if (cachedImages.length === 0) {
                    showEmpty();
                    setContentVisibility(false);
                } else {
                    // Espera as imagens renderizarem para esconder o loader
                    waitForImagesToLoad().then(() => {
                        hideLoadingAndEmpty();
                        setContentVisibility(true);
                    });
                }
            }

            // Função otimizada para atualizar imagens do modal
            function atualizarImagensModalOtimizado(colorCode) {
                const color = colorCode.replace(/\//g, '_');
                const cachedImages = imageCache.get(color) || [];

                // Primeiro, esconder todas as imagens do modal
                document.querySelectorAll('[data-modal-image]').forEach(img => {
                    img.style.display = 'none';
                });

                // Depois, mostrar e atualizar apenas as imagens que existem
                cachedImages.forEach(imgInfo => {
                    const modalImages = document.querySelectorAll('[data-modal-image]');
                    if (modalImages[imgInfo.index]) {
                        modalImages[imgInfo.index].setAttribute('data-modal-image', imgInfo.path);
                        modalImages[imgInfo.index].src = imgInfo.path;
                        modalImages[imgInfo.index].style.display = 'block';
                    }
                });
            }

            // Helpers de UI para loader/empty
            function showLoading() {
                const loader = document.getElementById('imageLoader');
                const right = document.getElementById('rightPanel');
                const desktopGrid = document.getElementById('desktopGrid');


                if (loader) {
                    // sincroniza altura com painel direito, preenchendo restante do espaço
                    //const rightH = right ? right.offsetHeight : 0;
                    //const gridH = desktopGrid ? desktopGrid.offsetHeight : 0;
                    //const minH = Math.max(rightH, gridH, 450);
                    //loader.style.minHeight = minH + 'px';
                    //loader.classList.remove('hidden');
                }

            }

            function hideLoadingAndEmpty() {
                const loader = document.getElementById('imageLoader');
                const empty = document.getElementById('imageEmpty');
                if (loader) {
                    loader.classList.add('hidden');
                    loader.style.minHeight = '';
                }
                if (empty) {
                    empty.classList.add('hidden');
                    empty.style.minHeight = '';
                }
            }

            function showEmpty() {
                const empty = document.getElementById('imageEmpty');
                const loader = document.getElementById('imageLoader');
                const right = document.getElementById('rightPanel');
                const desktopGrid = document.getElementById('desktopGrid');
                if (loader) loader.classList.add('hidden');
                if (empty) {
                    const rightH = right ? right.offsetHeight : 0;
                    const gridH = desktopGrid ? desktopGrid.offsetHeight : 0;
                    const minH = Math.max(rightH, gridH, 400);
                    empty.style.minHeight = minH + 'px';
                    empty.classList.remove('hidden');
                }
            }

            function hideEmpty() {
                const empty = document.getElementById('imageEmpty');
                if (empty) empty.classList.add('hidden');
            }

            function setContentVisibility(visible) {
                const desktopGrid = document.getElementById('desktopGrid');
                const mobileSwiper = document.getElementById('mobileSwiper');
                if (desktopGrid) desktopGrid.style.display = visible ? '' : 'none';
                if (mobileSwiper) mobileSwiper.style.display = visible ? '' : 'none';
            }

            // Aguarda carregamento real das imagens inseridas
            function waitForImagesToLoad() {
                const images = [];
                const desktopGrid = document.getElementById('desktopGrid');
                const swiperWrapper = document.querySelector('.swiper-wrapper');
                if (desktopGrid) {
                    images.push(...desktopGrid.querySelectorAll('img'));
                }
                if (swiperWrapper) {
                    images.push(...swiperWrapper.querySelectorAll('img'));
                }

                if (images.length === 0) return Promise.resolve();

                return new Promise((resolve) => {
                    let loadedCount = 0;
                    const total = images.length;

                    images.forEach((img) => {
                        const done = () => {
                            img.removeEventListener('load', done);
                            img.removeEventListener('error', done);
                            loadedCount++;
                            if (loadedCount >= total) {
                                resolve();
                            }
                        };

                        if (img.complete) {
                            // Já carregada ou em cache
                            done();
                        } else {
                            img.addEventListener('load', done);
                            img.addEventListener('error', done);
                        }
                    });
                });
            }

            // Inicializar Swiper para o modal
            function initModalSwiper() {
                modalSwiper = new Swiper(".modalSwiper", {
                    slidesPerView: 'auto',
                    spaceBetween: 30,
                    centeredSlides: true,
                    loop: true,
                    slidesPerView: 1.3,
                    spaceBetween: 30,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    keyboard: {
                        enabled: true,
                    },
                    effect: 'slide',
                    touchRatio: 1,
                    touchAngle: 45,
                    grabCursor: true,
                    autoHeight: false,
                    breakpoints: {
                        768: {
                            slidesPerView: 1.4,
                            spaceBetween: 40,
                        },
                        1024: {
                            slidesPerView: 1.3,
                            spaceBetween: 30,
                        }
                    },
                });
                // Resetar zoom ao trocar de slide
                modalSwiper.on('slideChange', () => {
                    document.querySelectorAll('.modalSwiper .swiper-slide img').forEach(img => {
                        img.style.transform = '';
                        img.classList.remove('cursor-zoom-out');
                        img.classList.add('cursor-zoom-in');
                    });
                });
            }

            // Função para abrir o modal de imagens
            function openImageModal(element) {
                const imageModal = document.getElementById('imageModal');
                const clickedImageSrc = element.getAttribute('data-image');

                imageModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                if (!modalSwiper) {
                    initModalSwiper();
                }

                const modalImages = document.querySelectorAll('[data-modal-image]');
                let targetIndex = 0;

                modalImages.forEach((img, index) => {
                    if (img.getAttribute('data-modal-image') === clickedImageSrc) {
                        targetIndex = index;
                    }
                });

                modalSwiper.slideTo(targetIndex, 0);
            }

            // Função para fechar o modal de imagens
            function closeImageModal() {
                const imageModal = document.getElementById('imageModal');
                imageModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Fechar modal com tecla ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            });

            // Fechar modal clicando fora da imagem
            document.getElementById('imageModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeImageModal();
                }
            });

            // Funcionalidade de favoritar
            const favoriteBtn = document.getElementById("favoriteBtn");
            const iconOutline = document.getElementById("iconOutline");
            const iconFilled = document.getElementById("iconFilled");

            // Estilos de fade adicionados dinamicamente para evitar editar o <head>
            function ensureFadeStyles() {
                const styleId = 'favoriteTextFadeStyles';
                if (!document.getElementById(styleId)) {
                    const style = document.createElement('style');
                    style.id = styleId;
                    style.textContent = `
                        @keyframes favFadeIn { from { opacity: 0 } to { opacity: 1 } }
                        @keyframes favFadeOut { from { opacity: 1 } to { opacity: 0 } }
                        .fade-in { animation: favFadeIn 400ms ease-in forwards; }
                        .fade-out { animation: favFadeOut 400ms ease-out forwards; }
                    `;
                    document.head.appendChild(style);
                }
            }

            ensureFadeStyles();

            // Helper para exibir mensagem com FadeIn e ocultar com FadeOut
            function showFavoriteMessage(message) {
                const favoriteText = document.getElementById('favoriteText');
                if (!favoriteText) return;

                favoriteText.textContent = message;
                favoriteText.classList.remove('hidden', 'fade-out');
                favoriteText.classList.add('fade-in');

                // Após 5s, faz o FadeOut e oculta o elemento
                setTimeout(() => {
                    favoriteText.classList.remove('fade-in');
                    favoriteText.classList.add('fade-out');
                    setTimeout(() => {
                        favoriteText.classList.add('hidden');
                        favoriteText.classList.remove('fade-out');
                    }, 400);
                }, 5000);
            }

            // Verificar estado inicial da wishlist
            checkWishlistStatus();

            favoriteBtn.addEventListener("click", () => {
                const isFavorited = iconFilled.classList.contains("hidden");

                if (isFavorited) {
                    addToWishlist();
                } else {
                    removeFromWishlist();
                }
            });

            function addToWishlist() {
                fetch('/user/wishlist/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            color_code: currentColorCode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            iconFilled.classList.remove("hidden");
                            iconOutline.classList.add("hidden");
                            showFavoriteMessage('Adicionado aos Favoritos');
                        } else {
                            showFavoriteMessage('Erro ao adicionar aos favoritos');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        showFavoriteMessage('Erro ao adicionar aos favoritos');
                    });
            }

            function removeFromWishlist() {
                fetch('/user/wishlist/remove', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            color_code: currentColorCode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            iconFilled.classList.add("hidden");
                            iconOutline.classList.remove("hidden");
                            showFavoriteMessage('Removido dos Favoritos');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            }

            function checkWishlistStatus() {
                fetch(`/user/wishlist/check?product_id=${productId}&color_code=${currentColorCode}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.is_favorited) {
                            iconFilled.classList.remove("hidden");
                            iconOutline.classList.add("hidden");
                        } else {
                            iconFilled.classList.add("hidden");
                            iconOutline.classList.remove("hidden");
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao verificar status da wishlist:', error);
                    });
            }

            // Event listener otimizado para seleção de cor
            function ativarEventListenersCoresOtimizado() {
                const colorVariants = document.querySelectorAll('[class^="box-color"]');
                colorVariants.forEach((variant) => {
                    variant.addEventListener("click", () => {
                        // Adicionar indicador visual imediato
                        //variant.style.opacity = '0.7';
                        //console.log(variant);
                        // Usar requestAnimationFrame para suavizar a transição
                        requestAnimationFrame(() => {
                            // Remove seleção de todas as cores
                            colorVariants.forEach((v) => {
                                v.classList.remove("border-black", "border-white");
                                v.classList.add("border-white");
                                v.style.opacity = '1';
                            });

                            // Adiciona seleção na cor clicada
                            variant.classList.remove("border-black", "border-white")
                            variant.classList.add("border-black");
                            variant.style.opacity = '1';

                            // Obtém o código da cor selecionada
                            const selectedColorCode = variant.getAttribute('data-color-code');
                            currentColorCode = selectedColorCode;

                            const selectedGenero = variant.getAttribute('data-genero');
                            currentGenero = selectedGenero;
                            console.log(currentGenero);
                            // Atualizar gênero na interface
                            document.querySelector('.genero').textContent = currentGenero;

                            // Carregar imagens da cor selecionada (agora instantâneo)
                            carregarImagensProdutoOtimizado(selectedColorCode);
                            // Atualizar numeração conforme a cor selecionada
                            updateNumeracaoByColorCode(selectedColorCode);

                            // Verificar status da wishlist (pode ser assíncrono sem afetar UX)
                            checkWishlistStatus();
                        });
                    });
                });
            }

            // Funcionalidade do Modal de Sugestão
            const suggestionModal = document.getElementById("suggestionModal");
            const suggestionForm = document.getElementById("suggestionForm");
            const suggestionSuccess = document.getElementById("suggestionSuccess");
            const openSuggestionModal = document.getElementById("openSuggestionModal");
            const closeSuggestionModal = document.getElementById("closeSuggestionModal");
            const closeSuccessModal = document.getElementById("closeSuccessModal");
            const sendSuggestion = document.getElementById("sendSuggestion");
            const suggestionText = document.getElementById("suggestionText");

            // Abrir modal
            if (openSuggestionModal) {
                openSuggestionModal.addEventListener("click", () => {
                    suggestionModal.classList.remove("hidden");
                    suggestionForm.classList.remove("hidden");
                    suggestionSuccess.classList.add("hidden");
                    suggestionText.value = "";
                });
            }

            // Fechar modal - botão voltar do formulário
            if (closeSuggestionModal) {
                closeSuggestionModal.addEventListener("click", () => {
                    suggestionModal.classList.add("hidden");
                });
            }

            // Fechar modal - botão voltar do sucesso
            if (closeSuccessModal) {
                closeSuccessModal.addEventListener("click", () => {
                    suggestionModal.classList.add("hidden");
                });
            }

            // Fechar modal clicando fora
            if (suggestionModal) {
                suggestionModal.addEventListener("click", (e) => {
                    if (e.target === suggestionModal) {
                        suggestionModal.classList.add("hidden");
                    }
                });
            }

            // Enviar sugestão
            if (sendSuggestion) {
                sendSuggestion.addEventListener("click", () => {
                    const suggestion = suggestionText.value.trim();

                    if (suggestion) {
                        suggestionForm.classList.add("hidden");
                        suggestionSuccess.classList.remove("hidden");
                    } else {
                        alert("Por favor, digite sua sugestão antes de enviar.");
                    }
                });
            }

            // Fechar modal com tecla ESC
            document.addEventListener("keydown", (e) => {
                if (e.key === "Escape" && suggestionModal && !suggestionModal.classList.contains("hidden")) {
                    suggestionModal.classList.add("hidden");
                }
            });

            // Dados das cores do produto para filtro dinâmico
            const productNumeracoesDefault =
                "{{ $produto->numeracoes ? $produto->numeracoes->pluck('numero')->implode(', ') : '' }}";
            const coresData = [
                @foreach ($produto->allColors as $color)
                    {
                        id: {{ $color->id }},
                        color_code: "{{ $color->color_code }}",
                        color_name: "{{ $color->color_name }}",
                        genero: "{{ $color->genero }}",
                        color_description: "{{ $color->color_description }}",
                        numeracao: "{{ optional($color->numeracao)->numero }}",
                        flag_product_id: {{ $color->flag_product_id ?? 'null' }},
                        flagProduct: @if ($color->flagProduct)
                            {
                                flag_title: "{{ $color->flagProduct->flag_title }}",
                                flag_bg: "{{ $color->flagProduct->flag_bg }}",
                                flag_color_text_bg: "{{ $color->flagProduct->flag_color_text_bg }}",
                                icon: "{{ $color->flagProduct->icon }}",
                                alinhamento: "{{ $color->flagProduct->alinhamento }}"
                            }
                        @else
                            null
                        @endif ,
                        segmentacaoIds: @json($color->segmentacoesCliente->pluck('id')->toArray())
                    },
                @endforeach
            ];

            function updateNumeracaoByColorCode(colorCode) {
                try {
                    const cor = coresData.find(c => c.color_code === colorCode);
                    const numeracaoEl = document.getElementById('numeracao');
                    if (numeracaoEl) {
                        numeracaoEl.textContent = (cor && cor.numeracao) ? cor.numeracao : productNumeracoesDefault;
                    }
                } catch (e) {
                    console.error('Erro atualizando numeração da cor:', e);
                }
            }

            // Função para filtrar cores baseado nas segmentações selecionadas
            function filtrarCoresPorSegmentacao() {
                let selectedSegmentacoes = [];
                try {
                    selectedSegmentacoes = JSON.parse(localStorage.getItem('selectedSegmentacoes') || '[]');
                } catch (e) {
                    console.error('Erro ao processar segmentações do localStorage:', e);
                    selectedSegmentacoes = [];
                }

                if (selectedSegmentacoes.length === 0) {
                    return coresData;
                }

                return coresData.filter(cor => {
                    return selectedSegmentacoes.some(segId =>
                        cor.segmentacaoIds.includes(parseInt(segId))
                    );
                });
            }

            // Função renderizar cores otimizada
            function renderizarCoresOtimizado() {
                const coresFiltradas = filtrarCoresPorSegmentacao();
                const coresContainer = document.querySelector('.grid.grid-cols-3.lg\\:grid-cols-4.mb-4');

                if (!coresContainer) return;

                // Usar DocumentFragment para melhor performance
                const fragment = document.createDocumentFragment();

                // Renderizar cores filtradas
                coresFiltradas.forEach((cor, index) => {
                    const corElement = document.createElement('div');
                    corElement.className = 'relative';

                    const colorCodeFormatted = cor.color_code.replace(/\//g, '_');
                    const isFirst = index === 0;

                    let flagHtml = '';
                    if (cor.flagProduct && cor.flagProduct.icon) {
                        flagHtml = `
                            <div class="badge-icon-wrapper absolute top-1 ${cor.flagProduct.alinhamento}-0">
                                <img src="/${cor.flagProduct.icon}" 
                                     alt="${cor.flagProduct.flag_title}" 
                                     class="badge-icon" 
                                     style="width:19px; height:19px; margin-right:3px">
                                <span class="badge-tooltip" 
                                      style="color: ${cor.flagProduct.flag_color_text_bg};">
                                    ${cor.flagProduct.flag_title}
                                </span>
                            </div>
                        `;
                    } else if (cor.flagProduct) {
                        flagHtml = `
                            <span class="absolute top-1 left-1 bg-[${cor.flagProduct.flag_bg}] text-[${cor.flagProduct.flag_color_text_bg}] text-[10px] px-2 py-0.5 rounded-full">
                                ${cor.flagProduct.flag_title}
                            </span>
                        `;
                    }

                    corElement.innerHTML = `
                        <div class="box-color bg-white ${isFirst ? 'border border-black' : 'border border-white'} rounded-lg cursor-pointer transition-all duration-200 " 
                             data-color-code="${cor.color_code}"
                             data-genero="${cor.genero}">
                            <div class="relative">
                                <img src="/images/produtos/{{ $produto->code }}_${colorCodeFormatted}.jpg" 
                                     alt="${cor.color_name}" 
                                     class="w-full object-contain rounded-lg"
                                     loading="lazy"
                                     onerror="this.src='/images/img-padrao-ua.png'" />
                                ${flagHtml}
                            </div>
                            <div class="text-center pb-2">
                                <p class="text-xs text-black">${cor.color_name}</p>
                                <p class="text-xs text-black opacity-50 word">${cor.color_description}</p>
                            </div>
                        </div>
                    `;

                    fragment.appendChild(corElement);
                });

                // Atualizar DOM uma única vez
                coresContainer.innerHTML = '';
                coresContainer.appendChild(fragment);

                // Reativar event listeners para as novas cores
                ativarEventListenersCoresOtimizado();

                // Carregar imagens da primeira cor filtrada
                if (coresFiltradas.length > 0) {
                    carregarImagensProdutoOtimizado(coresFiltradas[0].color_code);
                    updateNumeracaoByColorCode(coresFiltradas[0].color_code);
                }
            }

            // Função de inicialização otimizada
            async function inicializarPaginaProduto() {
                // Renderizar cores inicialmente
                renderizarCoresOtimizado();

                // Pré-carregar informações das imagens em background
                preloadImageInfo().then(() => {
                    // Recarregar com cache depois do pré-carregamento
                    const coresFiltradas = filtrarCoresPorSegmentacao();
                    if (coresFiltradas.length > 0) {
                        carregarImagensProdutoOtimizado(coresFiltradas[0].color_code);
                        updateNumeracaoByColorCode(coresFiltradas[0].color_code);
                    }
                });
            }

            // Listener para mudanças no localStorage das segmentações
            window.addEventListener('storage', function(e) {
                if (e.key === 'selectedSegmentacoes') {
                    console.log('Segmentações alteradas no localStorage, reaplicando filtros de cores...');
                    renderizarCoresOtimizado();
                }
            });

            // Listener customizado para mudanças na mesma aba
            let originalSetItem = localStorage.setItem;
            localStorage.setItem = function(key, value) {
                originalSetItem.apply(this, arguments);
                if (key === 'selectedSegmentacoes') {
                    console.log('Segmentações alteradas na mesma aba, reaplicando filtros de cores...');
                    renderizarCoresOtimizado();
                }
            };


            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', inicializarPaginaProduto);
            } else {
                inicializarPaginaProduto();
            }



            // ============================================
            // SOLUÇÃO ALTERNATIVA: ZOOM NATIVO SEM EASYZOOM
            // Adicione este código no lugar do EasyZoom
            // ============================================

            // Variáveis para controle do zoom
            let isZoomed = false;
            let currentZoomImage = null;

            // Função para adicionar zoom nativo em todas as imagens do modal
            function initializeNativeZoom() {
                console.log('🔍 Inicializando zoom nativo...');

                const modalImages = document.querySelectorAll('.modalSwiper .swiper-slide img');

                modalImages.forEach((img, index) => {
                    // Remover listeners anteriores
                    img.removeEventListener('click', handleImageZoomClick);
                    img.removeEventListener('mousemove', handleImageZoomMove);
                    img.removeEventListener('mouseleave', handleImageZoomLeave);

                    // Adicionar classe de zoom disponível
                    img.style.cursor = 'zoom-in';

                    // Adicionar event listener para click (ativar/desativar zoom)
                    img.addEventListener('click', handleImageZoomClick);

                    // Adicionar event listener para mousemove (quando zoom ativado)
                    img.addEventListener('mousemove', handleImageZoomMove);

                    // Adicionar event listener para mouseleave
                    img.addEventListener('mouseleave', handleImageZoomLeave);
                });

                console.log(`✅ Zoom nativo adicionado em ${modalImages.length} imagens`);
            }

            // Handler para click na imagem (ativar/desativar zoom)
            function handleImageZoomClick(e) {
                const img = e.currentTarget;

                if (!isZoomed) {
                    // Ativar zoom
                    activateZoom(img);
                } else {
                    // Desativar zoom
                    deactivateZoom(img);
                }
            }

            // Ativar zoom
            function activateZoom(img) {
                isZoomed = true;
                currentZoomImage = img;

                // Alterar cursor
                img.style.cursor = 'zoom-out';

                // Aplicar escala maior
                img.style.transform = 'scale(2)';
                img.style.transformOrigin = 'center center';
                img.style.transition = 'transform 0.3s ease';

                // Desabilitar swiper
                if (modalSwiper) {
                    modalSwiper.allowTouchMove = false;
                    modalSwiper.allowSlideNext = false;
                    modalSwiper.allowSlidePrev = false;
                }

                console.log('🔍 Zoom ativado (2x)');
            }

            // Desativar zoom
            function deactivateZoom(img) {
                isZoomed = false;
                currentZoomImage = null;

                // Restaurar cursor
                img.style.cursor = 'zoom-in';

                // Remover zoom
                img.style.transform = 'scale(1)';
                img.style.transformOrigin = 'center center';

                // Reabilitar swiper
                if (modalSwiper) {
                    modalSwiper.allowTouchMove = true;
                    modalSwiper.allowSlideNext = true;
                    modalSwiper.allowSlidePrev = true;
                }

                console.log('🔍 Zoom desativado');
            }

            // Handler para movimento do mouse (pan quando zoom ativado)
            function handleImageZoomMove(e) {
                if (!isZoomed) return;

                const img = e.currentTarget;
                const rect = img.getBoundingClientRect();

                // Calcular posição do mouse relativa à imagem (0 a 1)
                const x = (e.clientX - rect.left) / rect.width;
                const y = (e.clientY - rect.top) / rect.height;

                // Converter para porcentagem de transformOrigin
                const originX = x * 100;
                const originY = y * 100;

                // Aplicar transform origin baseado na posição do mouse
                img.style.transformOrigin = `${originX}% ${originY}%`;
            }

            // Handler para quando mouse sai da imagem
            function handleImageZoomLeave(e) {
                if (isZoomed) {
                    const img = e.currentTarget;
                    deactivateZoom(img);
                }
            }

            // Modificar função de atualização do modal para incluir zoom nativo
            function atualizarImagensModalComZoomNativo(colorCode) {
                const color = colorCode.replace(/\//g, '_');
                const cachedImages = imageCache.get(color) || [];

                // Primeiro, esconder todas as imagens do modal
                document.querySelectorAll('[data-modal-image]').forEach(img => {
                    const slide = img.closest('.swiper-slide');
                    if (slide) {
                        slide.style.display = 'none';
                    }
                });

                // Depois, mostrar e atualizar apenas as imagens que existem
                cachedImages.forEach(imgInfo => {
                    const modalImages = document.querySelectorAll('[data-modal-image]');
                    if (modalImages[imgInfo.index]) {
                        const img = modalImages[imgInfo.index];
                        const slide = img.closest('.swiper-slide');

                        img.setAttribute('data-modal-image', imgInfo.path);
                        img.src = imgInfo.path;

                        if (slide) {
                            slide.style.display = 'block';
                        }
                    }
                });

                // Reinicializar zoom nativo após atualizar as imagens
                setTimeout(() => {
                    initializeNativeZoom();
                    if (modalSwiper) {
                        modalSwiper.update();
                    }
                }, 100);
            }

            // Modificar openImageModal
            const originalOpenImageModal = window.openImageModal;
            window.openImageModal = function(element) {
                if (typeof originalOpenImageModal === 'function') {
                    originalOpenImageModal.call(this, element);
                }

                // Inicializar zoom nativo após abrir o modal
                setTimeout(() => {
                    initializeNativeZoom();
                }, 300);
            };

            // Modificar closeImageModal
            const originalCloseImageModal = window.closeImageModal;
            window.closeImageModal = function() {
                // Reset zoom state
                isZoomed = false;
                currentZoomImage = null;

                if (typeof originalCloseImageModal === 'function') {
                    originalCloseImageModal.call(this);
                }
            };

            // Listener para mudança de slide
            function setupModalSwiperZoomListeners() {
                if (typeof modalSwiper !== 'undefined' && modalSwiper) {
                    modalSwiper.on('slideChange', () => {
                        console.log('📱 Slide alterado - resetando zoom');

                        // Reset zoom em todas as imagens
                        document.querySelectorAll('.modalSwiper .swiper-slide img').forEach(img => {
                            img.style.transform = 'scale(1)';
                            img.style.cursor = 'zoom-in';
                        });

                        isZoomed = false;
                        currentZoomImage = null;

                        // Reabilitar swiper
                        setTimeout(() => {
                            if (modalSwiper) {
                                modalSwiper.allowTouchMove = true;
                                modalSwiper.allowSlideNext = true;
                                modalSwiper.allowSlidePrev = true;
                            }
                        }, 100);
                    });
                }
            }

            // Substituir função original
            window.atualizarImagensModalOtimizado = atualizarImagensModalComZoomNativo;

            // Inicializar quando a página carregar
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    setTimeout(setupModalSwiperZoomListeners, 1000);
                });
            } else {
                setTimeout(setupModalSwiperZoomListeners, 1000);
            }

            console.log('✅ Sistema de zoom nativo inicializado');
        </script>
    @endpush

    </x-layout-user-produto>
