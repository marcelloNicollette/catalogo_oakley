@props(['activeItem' => null])

<!-- Menu lateral -->
<aside class="w-full lg:w-64 flex flex-col items-start py-6 space-y-3 pl-3">
    <a href="{{ route('user.slug', request()->route('slug')) }}"
        class="w-full h-[42px] content-center items-center text-gray-700 hover:bg-[#E7E7E7] pl-4 {{ $activeItem === 'inicio' ? 'bg-[#E7E7E7]' : '' }}">
        <img src="/images/icones/inicio.svg" class="float-left pr-[0.5rem]" alt="Início" />
        <span class="text-xs md:text-base mt-1">Início</span>
    </a>

    <a href="{{ route('user.slug.colecoes', request()->route('slug')) }}"
        class="w-full h-[42px] content-center items-center text-gray-700 hover:bg-[#E7E7E7] pl-4 {{ $activeItem === 'colecoes' ? 'bg-[#E7E7E7]' : '' }}">
        <img src="/images/icones/colecoes.svg" class="float-left pr-[0.5rem]" alt="Coleções" />
        <span class="text-xs md:text-base mt-1">Coleções</span>
    </a>

    <a href="{{ route('user.wishlist', request()->route('slug')) }}"
        class="w-full h-[42px] content-center items-center text-gray-700 hover:bg-[#E7E7E7] pl-4 {{ $activeItem === 'favoritos' ? 'bg-[#E7E7E7]' : '' }}">
        <img src="/images/icones/favoritos.svg" class="float-left pr-[0.5rem]" alt="Favoritos" />
        <span class="text-xs md:text-base mt-1">Favoritos</span>
    </a>

    <a href="{{ route('user.tecnologias', request()->route('slug')) }}"
        class="w-full h-[42px] content-center items-center text-gray-700 hover:bg-[#E7E7E7] pl-4 {{ $activeItem === 'tecnologias' ? 'bg-[#E7E7E7]' : '' }}">
        <img src="/images/icones/tecnologia.svg" class="float-left pr-[0.5rem]" alt="Tecnologias" />
        <span class="text-xs md:text-base mt-1">Tecnologias</span>
    </a>

    <a href="{{ route('user.conteudos', request()->route('slug')) }}"
        class="w-full h-[42px] content-center items-center text-gray-700 hover:bg-[#E7E7E7] pl-4 {{ $activeItem === 'conteudos' ? 'bg-[#E7E7E7]' : '' }}">
        <img src="/images/icones/conteudo.svg" class="float-left pr-[0.5rem]" alt="Conteúdos" />
        <span class="text-xs md:text-base mt-1">Conteúdos</span>
    </a>

    <a href="{{ route('user.gerar-arquivo', request()->route('slug')) }}"
        class="w-full h-[42px] content-center items-center text-gray-700 hover:bg-[#E7E7E7] pl-4 {{ $activeItem === 'gerar-arquivo' ? 'bg-[#E7E7E7]' : '' }}">
        <img src="/images/icones/arquivo.svg" class="float-left pr-[0.5rem]" alt="Gerar Arquivo" />
        <span class="text-xs md:text-base mt-1">Gerar Arquivo</span>
    </a>

    <!--<a href="{{ route('user.calendario', request()->route('slug')) }}"
        class="w-full h-[42px] content-center items-center text-gray-700 hover:bg-[#E7E7E7] pl-4 {{ $activeItem === 'calendario' ? 'bg-[#E7E7E7]' : '' }}">
        <img src="/images/icones/calendario.svg" class="float-left pr-[0.5rem]" alt="Calendário" />
        <span class="text-xs md:text-base mt-1">Calendário</span>
    </a>-->
</aside>
