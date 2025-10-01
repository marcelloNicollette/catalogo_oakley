<x-layout-user title="Under Armour - Segmentação">
    <style>
        .font-segmento {
            color: #FFF;
            text-align: center;
            font-size: 50px;
            font-style: normal;
            font-weight: 800;
            line-height: 40px;
            /* 80% */
            letter-spacing: -4px;
            text-transform: uppercase;
        }

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
            }
        }

        @media (min-width: 3000px) {
            .font-segmento {
                font-size: 6rem;
                line-height: 5rem;
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

        .grid-item a,
        .grid-item div.notColection {
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

    <div id="produtos" class="grid grid-cols-1 lg:grid-cols-2 gap-2 full-height-container">
        @foreach ($segmentacao as $segmento)
            <div class="relative group cursor-pointer rounded-lg grid-item">
                @if ($segmento->collections->count() > 0)
                    <a href="/user/{{ $segmento->slug }}" class="block relative overflow-hidden">
                    @else
                        <div class="block relative overflow-hidden notColection cursor-default">
                @endif
                <!-- Desktop Image -->
                <img src="{{ '/' . $segmento->image }}"
                    class="hidden lg:block transition-transform duration-300 group-hover:scale-110"
                    alt="{{ $segmento->name }}" />
                <!-- Mobile Image -->
                <img src="{{ '/' . $segmento->image_mobile }}"
                    class="block lg:hidden transition-transform duration-300 group-hover:scale-110"
                    alt="{{ $segmento->name }}" />

                <!-- Text Overlay -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="bg-[#E31B23] px-10 py-5 pointer-events-auto">
                        <h2 class="font-segmento text-center">
                            {{ $segmento->segmento }}
                        </h2>
                    </div>
                </div>
                @if ($segmento->collections->count() > 0)
                    </a>
                @else
            </div>
        @endif
    </div>
    @endforeach
    </div>
</x-layout-user>
