<x-layout-user-produto title="Olympikus - Produto">
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
                width: 70%;
                height: 100%;
            }

            .swiper-button-prev,
            .swiper-button-next {
                color: transparent !important;
                background: #FFF;
                border: 1px solid #FFF;
                opacity: 1 !important;
            }

            .swiper-button-prev {
                left: 30px;
            }

            .swiper-button-next {
                right: 30px;
            }
        }
    </style>
    <main class="absolute top-20 lg:flex flex-1 produtos-page">
        @php

            $currentUrl = request()->path();
            $currentSlug = '';

            if (strpos($currentUrl, 'user') === 0) {
                $parts = explode('/', $currentUrl);
                //dd($parts);
                if (count($parts) > 1) {
                    $currentSlug = $parts[4];
                }
            }

        @endphp
        <div class="max-w-full px-2 pb-3">
            <div class="flex gap-2">
                <!-- Seção de Imagens - Esquerda -->
                <div class="flex-1 space-y-4">
                    <!-- Grid de Imagens para Desktop (2 colunas x 4 linhas) -->
                    <div class="hidden lg:grid grid-cols-2 bg-white rounded-lg shadow-sm border border-[#CBCBCB]"
                        id="desktopGrid">

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
                                <div class="cursor-pointer hover:opacity-80 transition-opacity rounded-lg"
                                    data-image="/images/produtos/{{ $produto->code }}_{{ str_replace('/', '_', $produto->colors[0]->color_code) }}{{ $suffix }}.jpg"
                                    onclick="openImageModal(this)">
                                    <img src="/images/produtos/{{ $produto->code }}_{{ str_replace('/', '_', $produto->colors[0]->color_code) }}{{ $suffix }}.jpg"
                                        alt="Vista {{ $vista }}" class="w-full object-contain rounded-lg" />
                                </div>
                            @endif
                            @php $vista++; @endphp
                        @endforeach
                    </div>

                    <!-- Swiper para Tablet e Mobile -->
                    <div class="lg:hidden" id="mobileSwiper">
                        <div class="swiper thumbnailSwiper">
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
                                        <div class="swiper-slide">
                                            <div class="bg-white cursor-pointer flex items-center justify-center hover:opacity-80 transition-opacity aspect-square w-full"
                                                data-image="/images/produtos/{{ $produto->code }}_{{ str_replace('/', '_', $produto->colors[0]->color_code) }}{{ $suffix }}.jpg"
                                                onclick="openImageModal(this)">
                                                <img src="/images/produtos/{{ $produto->code }}_{{ str_replace('/', '_', $produto->colors[0]->color_code) }}{{ $suffix }}.jpg"
                                                    alt="Vista {{ $vista }}"
                                                    class="max-w-[80%] max-h-[80%] object-contain" />
                                            </div>
                                        </div>
                                    @endif
                                    @php $vista++; @endphp
                                @endforeach
                            </div>
                            <!-- Pagination dots -->
                            <div class="swiper-pagination mt-4"></div>
                        </div>
                    </div>
                </div>

                <!-- Seção de Detalhes - Direita -->
                <div class="w-[460px] flex-shrink-0 space-y-6">
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
                                    class="text-sm opacity-50 float-left pt-[2px] pr-2 hidden">Adicionado
                                    aos
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
                        <div class=" mb-4">
                            <h1 class="text-[38px] lg:text-[55px] font-normal font-fko">
                                {{ $produto->name }}
                            </h1>
                        </div>

                        <!-- Variações de Cor -->
                        <div class="mb-6">
                            <p class="text-xs text-black opacity-50 pb-2">Cores</p>
                            <!-- Primeira linha - 4 cores -->
                            <div class="grid grid-cols-3 lg:grid-cols-4 mb-4">

                                @foreach ($produto->colors as $color)
                                    <!-- Cor 1 - Selecionada -->
                                    <div class="relative">
                                        <div class="box-color bg-white {{ $loop->first ? 'border border-black' : '' }} rounded-lg cursor-pointer"
                                            data-color-code="{{ $color->color_code }}">
                                            <div class="relative">
                                                <img src="/images/produtos/{{ $produto->code }}_{{ str_replace('/', '_', $color->color_code) }}.jpg"
                                                    alt="{{ $color->color_name }}"
                                                    class="w-full object-contain rounded-t-lg" />
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
                                                <p class="text-xs text-black opacity-50">
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
                                    <p class="text-base">R$ {{ number_format($produto->price, 2, ',', '.') }}</p>
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

                            </div>
                        </div>

                        <!-- Tecnologias -->
                        @if (count($produto->technologyItems) > 0)
                            <div class="mb-6">
                                <h3 class="text-xs mb-3 text-black opacity-50">Tecnologias</h3>
                                <div class="">
                                    @foreach ($produto->technologyItems as $item)
                                        <div class="mb-[30px]">
                                            <div class="w-[65px] h-[65px] float-left mr-[10px] bg-black rounded-lg ">
                                                <img src="/{{ $item->icon }}" class="w-100 h-100 my-0 rounded-lg"
                                                    alt="{{ $item->name }}" />
                                            </div>
                                            <div>
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
                        @if (count($produto->links) > 0)
                            <div class="my-[30px]">
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
                            </div>
                        @endif

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
        <style>
            #imageModal {

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
        </style>
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
                                        alt="Vista {{ $vista }}" class="max-w-full max-h-full object-contain"
                                        data-modal-image="/images/produtos/{{ $produto->code }}_{{ str_replace('/', '_', $produto->colors[0]->color_code) }}{{ $suffix }}.jpg" />
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
                    // Quando a largura for >= 640px (tablet)
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 15,
                    },
                },
            });

            // Inicializar Swiper para o modal
            let modalSwiper;

            function initModalSwiper() {
                modalSwiper = new Swiper(".modalSwiper", {
                    slidesPerView: 'auto',
                    spaceBetween: 30,
                    centeredSlides: true,
                    loop: true,

                    // Configuração para mostrar preview da próxima imagem
                    slidesPerView: 1.3,
                    spaceBetween: 30,


                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    keyboard: {
                        enabled: true,
                    },

                    // Efeitos
                    effect: 'slide',

                    // Configurações de toque
                    touchRatio: 1,
                    touchAngle: 45,
                    grabCursor: true,

                    // Auto height
                    autoHeight: false,

                    // Breakpoints para responsividade
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
            }

            // Função para abrir o modal de imagens
            function openImageModal(element) {
                const imageModal = document.getElementById('imageModal');
                const clickedImageSrc = element.getAttribute('data-image');

                // Mostrar o modal
                imageModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Inicializar o Swiper se ainda não foi inicializado
                if (!modalSwiper) {
                    initModalSwiper();
                }

                // Encontrar o índice da imagem clicada e ir para ela
                const modalImages = document.querySelectorAll('[data-modal-image]');
                let targetIndex = 0;

                modalImages.forEach((img, index) => {
                    if (img.getAttribute('data-modal-image') === clickedImageSrc) {
                        targetIndex = index;
                    }
                });

                // Ir para o slide correto
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

            const favoriteBtn = document.getElementById("favoriteBtn");
            const iconOutline = document.getElementById("iconOutline");
            const iconFilled = document.getElementById("iconFilled");

            // Funcionalidade de favoritar
            let currentColorCode = '{{ str_replace('/', '_', $produto->colors->first()->color_code) ?? '' }}';
            const productId = {{ $produto->id }};

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

                            // Atualiza o texto do favoriteText e mostra por 5 segundos
                            const favoriteText = document.getElementById('favoriteText');
                            favoriteText.textContent = 'Adicionado aos Favoritos';
                            favoriteText.classList.remove('hidden');

                            setTimeout(() => {
                                favoriteText.classList.add('hidden');
                            }, 5000);
                        } else {
                            // Atualiza o texto do favoriteText para mostrar erro
                            const favoriteText = document.getElementById('favoriteText');
                            favoriteText.textContent = 'Erro ao adicionar aos favoritos';
                            favoriteText.classList.remove('hidden');

                            setTimeout(() => {
                                favoriteText.classList.add('hidden');
                            }, 5000);
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        // Atualiza o texto do favoriteText para mostrar erro
                        const favoriteText = document.getElementById('favoriteText');
                        favoriteText.textContent = 'Erro ao adicionar aos favoritos';
                        favoriteText.classList.remove('hidden');

                        setTimeout(() => {
                            favoriteText.classList.add('hidden');
                        }, 5000);
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

                            // Atualiza o texto do favoriteText e mostra por 5 segundos
                            const favoriteText = document.getElementById('favoriteText');
                            favoriteText.textContent = 'Removido dos Favoritos';
                            favoriteText.classList.remove('hidden');

                            setTimeout(() => {
                                favoriteText.classList.add('hidden');
                            }, 5000);
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

            // Funcionalidade de seleção de cor
            const colorVariants = document.querySelectorAll('[class^="box-color"]');
            colorVariants.forEach((variant) => {
                variant.addEventListener("click", () => {
                    // Remove seleção de todas as cores
                    colorVariants.forEach((v) => {
                        v.classList.remove("border-black", "border");
                    });

                    // Adiciona seleção na cor clicada
                    variant.classList.add("border-black", "border");

                    // Obtém o código da cor selecionada
                    const selectedColorCode = variant.getAttribute('data-color-code');
                    const color = selectedColorCode.replace(/\//g, "_");
                    // Atualiza a variável global da cor atual
                    currentColorCode = selectedColorCode;

                    // Verifica o status da wishlist para a nova cor
                    checkWishlistStatus();

                    // Atualiza todas as imagens do produto com a nova cor
                    const suffixes = ['', '_A', '_B', '_C', '_D', '_E', '_F', '_G', '_H', '_I', '_J', '_K',
                        '_L', '_M', '_N'
                    ];
                    const productCode = '{{ str_replace('/', '_', $produto->code) }}';

                    // Função para verificar se a imagem existe
                    function checkImageExists(imagePath) {
                        return new Promise((resolve) => {
                            const img = new Image();
                            img.onload = () => resolve(true);
                            img.onerror = () => resolve(false);
                            img.src = imagePath;
                        });
                    }

                    // Atualiza as imagens do grid desktop
                    document.querySelectorAll('#desktopGrid div[data-image]').forEach(async (div, index) => {
                        const newImagePath =
                            `/images/produtos/${productCode}_${color}${suffixes[index]}.jpg`;
                        
                        const imageExists = await checkImageExists(newImagePath);
                        if (imageExists) {
                            div.setAttribute('data-image', newImagePath);
                            div.querySelector('img').src = newImagePath;
                            div.style.display = 'block'; // Mostra o elemento
                        } else {
                            div.style.display = 'none'; // Esconde o elemento se a imagem não existir
                        }
                    });

                    // Atualiza as imagens do Swiper mobile
                    document.querySelectorAll('.swiper-slide div[data-image]').forEach(async (div, index) => {
                        const newImagePath =
                            `/images/produtos/${productCode}_${color}${suffixes[index]}.jpg`;
                        
                        const imageExists = await checkImageExists(newImagePath);
                        if (imageExists) {
                            div.setAttribute('data-image', newImagePath);
                            div.querySelector('img').src = newImagePath;
                            div.style.display = 'block'; // Mostra o elemento
                        } else {
                            div.style.display = 'none'; // Esconde o elemento se a imagem não existir
                        }
                    });

                    // Atualiza as imagens do modal
                    document.querySelectorAll('[data-modal-image]').forEach(async (img, index) => {
                        const newImagePath =
                            `/images/produtos/${productCode}_${color}${suffixes[index]}.jpg`;
                        
                        const imageExists = await checkImageExists(newImagePath);
                        if (imageExists) {
                            img.setAttribute('data-modal-image', newImagePath);
                            img.src = newImagePath;
                            img.style.display = 'block'; // Mostra o elemento
                        } else {
                            img.style.display = 'none'; // Esconde o elemento se a imagem não existir
                        }
                    });
                });
            });

            // Funcionalidade do Modal de Sugestão
            const suggestionModal = document.getElementById("suggestionModal");
            const suggestionForm = document.getElementById("suggestionForm");
            const suggestionSuccess = document.getElementById("suggestionSuccess");
            const openSuggestionModal = document.getElementById(
                "openSuggestionModal"
            );
            const closeSuggestionModal = document.getElementById(
                "closeSuggestionModal"
            );
            const closeSuccessModal = document.getElementById("closeSuccessModal");
            const sendSuggestion = document.getElementById("sendSuggestion");
            const suggestionText = document.getElementById("suggestionText");

            // Abrir modal
            openSuggestionModal.addEventListener("click", () => {
                suggestionModal.classList.remove("hidden");
                suggestionForm.classList.remove("hidden");
                suggestionSuccess.classList.add("hidden");
                suggestionText.value = "";
            });

            // Fechar modal - botão voltar do formulário
            closeSuggestionModal.addEventListener("click", () => {
                suggestionModal.classList.add("hidden");
            });

            // Fechar modal - botão voltar do sucesso
            closeSuccessModal.addEventListener("click", () => {
                suggestionModal.classList.add("hidden");
            });

            // Fechar modal clicando fora
            suggestionModal.addEventListener("click", (e) => {
                if (e.target === suggestionModal) {
                    suggestionModal.classList.add("hidden");
                }
            });

            // Enviar sugestão
            sendSuggestion.addEventListener("click", () => {
                const suggestion = suggestionText.value.trim();

                if (suggestion) {
                    // Simula envio da sugestão
                    suggestionForm.classList.add("hidden");
                    suggestionSuccess.classList.remove("hidden");
                } else {
                    alert("Por favor, digite sua sugestão antes de enviar.");
                }
            });

            // Fechar modal com tecla ESC
            document.addEventListener("keydown", (e) => {
                if (
                    e.key === "Escape" &&
                    !suggestionModal.classList.contains("hidden")
                ) {
                    suggestionModal.classList.add("hidden");
                }
            });
        </script>
    @endpush

</x-layout-user-produto>
