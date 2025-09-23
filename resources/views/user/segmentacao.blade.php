<x-layout-user title="Olympikus - Segmentação">
    <style>
        @media (max-width: 1024px) {
            .font-segmento {
                font-size: 40px;
                line-height: 42px;
            }
        }

        @media (min-width: 2566px) {
            .font-segmento {
                font-size: 6rem;
                line-height: 5rem;
                padding-right: 3rem;
            }
        }

        @media (min-width: 3000px) {
            .font-segmento {
                font-size: 6rem;
                line-height: 5rem;
                padding: 0 13rem 2rem 3rem;
            }
        }

        /* Estilos para altura 100% */
        .full-height-container {
            height: 100vh;
            min-height: 100vh;
            padding-bottom: 75px;
        }

        .grid-item {
            height: 100%;
            min-height: 300px;
            /* altura mínima para mobile */
        }

        .grid-item a {
            height: 100%;
            display: block;
            border-radius: 0.5rem;
            /* rounded-lg para o container do link */
            overflow: hidden;
            /* garante que o hover não saia das bordas arredondadas */
        }

        .grid-item img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 0.5rem;
            /* rounded-lg */
        }

        @media (max-width: 1024px) {
            .full-height-container {
                height: 100vh;
                min-height: 100vh;
            }

            .grid-item {
                height: calc(85vh / 3);
                /* cada item ocupa 1/3 da altura da tela no mobile */
                min-height: calc(85vh / 3);
            }
        }
    </style>

    <div id="produtos" class="grid grid-cols-1 lg:grid-cols-3 gap-2 full-height-container">
        @foreach ($segmentacao as $segmento)
            <div class="relative group cursor-pointer rounded-lg grid-item">
                <a href="/user/{{ $segmento->slug }}" class="block relative overflow-hidden">
                    <!-- Desktop Image -->
                    <img src="{{ '/' . $segmento->image }}"
                        class="hidden lg:block transition-transform duration-300 group-hover:scale-110"
                        alt="{{ $segmento->name }}" />
                    <!-- Mobile Image -->
                    <img src="{{ '/' . $segmento->image_mobile }}"
                        class="block lg:hidden transition-transform duration-300 group-hover:scale-110"
                        alt="{{ $segmento->name }}" />

                    <!-- Text Overlay -->
                    <div class="absolute drop-shadow-lg  inset-0 flex items-end justify-start p-9 xl:p-12">
                        <h2
                            class="text-white text-4xl lg:text-7xl uppercase tracking-wide font-segmento font-fko xl:text-7xl 3xl:text-9xl">
                            {{ $segmento->segmento }}
                        </h2>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</x-layout-user>
