{{-- Exemplo de uso do componente Sidebar --}}

{{-- Exemplo 1: Usando o sidebar sem item ativo --}}
<x-layout-user title="Dashboard">
    <div class="flex">
        <x-sidebar />
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
            <p>Conteúdo da página principal...</p>
        </main>
    </div>
</x-layout-user>

{{-- Exemplo 2: Usando o sidebar com item "inicio" ativo --}}
<x-layout-user title="Início">
    <div class="flex">
        <x-sidebar activeItem="inicio" />
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Página Inicial</h1>
            <p>Conteúdo da página inicial...</p>
        </main>
    </div>
</x-layout-user>

{{-- Exemplo 3: Usando o sidebar com item "colecoes" ativo --}}
<x-layout-user title="Coleções">
    <div class="flex">
        <x-sidebar activeItem="colecoes" />
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Coleções</h1>
            <p>Lista de coleções...</p>
        </main>
    </div>
</x-layout-user>

{{-- Exemplo 4: Usando o sidebar com item "favoritos" ativo --}}
<x-layout-user title="Favoritos">
    <div class="flex">
        <x-sidebar activeItem="favoritos" />
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Favoritos</h1>
            <p>Produtos favoritos...</p>
        </main>
    </div>
</x-layout-user>

{{-- 
Itens disponíveis para activeItem:
- inicio
- colecoes
- favoritos
- tecnologias
- conteudos
- arquivo
- calendario
--}}