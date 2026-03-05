@props(['activeItem' => null])

<!-- Menu lateral -->
<aside class="w-full lg:w-64 flex flex-col items-start p-5 space-y-3">
    @php
        $user = auth()->user();
        $classification = $user ? $user->classification : null;

        $menuItems = \App\Models\MenuItem::where('active', true)
            ->orderBy('order')
            ->get()
            ->filter(function ($item) use ($classification) {
                if (empty($item->allowed_classifications)) {
                    return true;
                }
                // Se o usuário não tem classificação mas o item exige, esconde (ou mostra se for permitido para null? assumindo que não)
                if (!$classification) {
                    return false;
                }
                return in_array($classification, $item->allowed_classifications);
            });

        // Mapa para compatibilidade com o activeItem existente
        $activeMap = [
            'Início' => 'inicio',
            'Coleções' => 'colecoes',
            'Compartilhar' => 'compartilhar',
            'Baixar' => 'gerar-arquivo',
            'Favoritos' => 'favoritos',
            'Tecnologias' => 'tecnologias',
            'Conteúdos' => 'conteudos',
            'Calendário' => 'calendario',
        ];
    @endphp

    @foreach ($menuItems as $item)
        @php
            $key = $activeMap[$item->label] ?? \Illuminate\Support\Str::slug($item->label);
            $isActive = $activeItem === $key;

            // Tratamento especial para rotas que precisam de parâmetros
            $routeParams = [];
            if (request()->route('slug')) {
                $routeParams['slug'] = request()->route('slug');
            }

            $url = $item->url;
            if ($item->route) {
                // Verifica se a rota existe para evitar erro
                if (\Illuminate\Support\Facades\Route::has($item->route)) {
                    $url = route($item->route, $routeParams);
                } else {
                    $url = '#';
                }
            }
        @endphp

        <a href="{{ $url }}"
            class="w-full h-[42px] content-center items-center text-gray-700 hover:bg-[#E7E7E7] pl-4 {{ $isActive ? 'bg-[#E7E7E7]' : '' }}">
            @if ($item->icon)
                <img src="{{ $item->icon }}" class="float-left pr-[0.5rem]" alt="{{ $item->label }}" />
            @endif
            <span class="text-xs md:text-base mt-1">{{ $item->label }}</span>
        </a>
    @endforeach
</aside>
