{{-- 
    EXEMPLO DE USO DO LAYOUT LAYOUT-USER
    
    Para usar o layout em qualquer página de usuário, simplesmente envolva o conteúdo com:
    
    <x-layout-user title="Título da Página">
        <!-- Conteúdo da página aqui -->
    </x-layout-user>
    
    O layout inclui:
    - Estrutura HTML completa
    - Meta tags responsivas
    - Tailwind CSS
    - Font Awesome
    - Swiper (para carrosséis)
    - CSS customizado
    - Header com componente reutilizável
    - Área principal flexível
    - Suporte a scripts e estilos adicionais
    
    Parâmetros disponíveis:
    - title: Título da página (opcional, padrão: "Olympikus")
    - footer: Conteúdo do footer (opcional)
    
    Stacks disponíveis:
    - @push('styles') - Para estilos adicionais no <head>
    - @push('scripts') - Para scripts adicionais antes do </body>
    
    Exemplo completo:
--}}

<x-layout-user title="Minha Página">
    {{-- Conteúdo principal da página --}}
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Título da Página</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Cards ou conteúdo aqui --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Card 1</h2>
                <p class="text-gray-600">Conteúdo do card...</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Card 2</h2>
                <p class="text-gray-600">Conteúdo do card...</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Card 3</h2>
                <p class="text-gray-600">Conteúdo do card...</p>
            </div>
        </div>
    </div>
    
    {{-- Exemplo de uso de stacks --}}
    @push('styles')
        <style>
            .custom-style {
                /* Estilos customizados aqui */
            }
        </style>
    @endpush
    
    @push('scripts')
        <script>
            // Scripts customizados aqui
            console.log('Página carregada!');
        </script>
    @endpush
</x-layout-user>