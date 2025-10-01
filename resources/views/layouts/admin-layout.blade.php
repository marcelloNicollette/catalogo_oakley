<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>@yield('page_title', 'Painel Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="/images/Favicon_Olympikus.png" type="image/png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('modal', {
                modals: new Set(),
                isOpen(modal) {
                    return this.modals.has(modal)
                },
                open(modal) {
                    this.modals.add(modal)
                },
                close(modal) {
                    this.modals.delete(modal)
                },
            })
        })
    </script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @stack('css')
</head>

<body class="flex flex-col bg-gray-50" x-data @open-modal.window="$store.modal.open($event.detail)"
    @close-modal.window="$store.modal.close($event.detail)">

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <button id="mobile-menu-button" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <!--<h1 class="font-semibold text-xl text-gray-800">@yield('page_title', 'Admin')</h1>-->
                <img src="{{ asset('images/logo-Olympikus.png') }}" alt="Logo" class="w-32">
            </div>
            <div class="flex items-center space-x-4">
                <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                    @csrf
                    <button
                        class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span>Sair</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Overlay para menu mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden md:hidden"></div>

    <!-- Sidebar e Conteúdo -->
    <div class="grid grid-cols-4 gap-4">
        <aside
            class="inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-200 transform md:translate-x-0 transition-all duration-300 ease-in-out -translate-x-full overflow-y-auto">
            <div class="flex flex-col h-full">

                <!-- Navegação -->
                @php
                    $currentRoute = request()->path();
                @endphp
                <nav class="flex-1 py-2 px-4 space-y-1">
                    <a href="{{ url('/admin/dashboard') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/dashboard') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ url('/admin/banners') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/banners') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>

                        <span>Banners</span>
                    </a>
                    <a href="{{ url('/admin/segmento') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/segmento') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z">
                            </path>
                        </svg>
                        <span>Segmentação</span>
                    </a>
                    <a href="{{ url('/admin/collections') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/collections') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span>Coleções</span>
                    </a>
                    <a href="{{ url('/admin/categories') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/categories') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span>Categorias</span>
                    </a>
                    <a href="{{ url('/admin/subcategories') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/subcategories') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span>Subcategorias(Faixas)</span>
                    </a>
                    <a href="{{ url('/admin/flag-product') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/flag-product') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9">
                            </path>
                        </svg>
                        <span>Flags Produtos</span>
                    </a>
                    <a href="{{ url('/admin/numeracao') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/numeracao') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.242 5.992h12m-12 6.003H20.24m-12 5.999h12M4.117 7.495v-3.75H2.99m1.125 3.75H2.99m1.125 0H5.24m-1.92 2.577a1.125 1.125 0 1 1 1.591 1.59l-1.83 1.83h2.16M2.99 15.745h1.125a1.125 1.125 0 0 1 0 2.25H3.74m0-.002h.375a1.125 1.125 0 0 1 0 2.25H2.99" />
                        </svg>

                        <span>Numeração</span>
                    </a>
                    <a href="{{ url('/admin/sizes') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/sizes') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>

                        <span>Tamanhos</span>
                    </a>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/technology') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                </path>
                            </svg>
                            <span>{{ __('Tecnologia') }}</span>
                            <svg class="w-4 h-4 ml-2" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute left-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
                            <div class="px-2 py-2 bg-white rounded-md shadow">
                                <a href="{{ route('admin.technology.categories.index') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ str_contains($currentRoute, 'admin/technology/categories') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                                    {{ __('Categorias') }}
                                </a>
                                <a href="{{ route('admin.technology.items.index') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ str_contains($currentRoute, 'admin/technology/items') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                                    {{ __('Itens') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ url('/admin/products') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/products') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span>Produtos</span>
                    </a>

                    <a href="{{ route('admin.calendario.index') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/calendario') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Calendário</span>
                    </a>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/conteudos') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                </path>
                            </svg>
                            <span>{{ __('Conteúdos') }}</span>
                            <svg class="w-4 h-4 ml-2" :class="{ 'rotate-180': open }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute left-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
                            <div class="px-2 py-2 bg-white rounded-md shadow">
                                <a href="{{ route('admin.conteudos.categories.index') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ str_contains($currentRoute, 'admin/conteudos/categories') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                                    {{ __('Categorias') }}
                                </a>
                                <a href="{{ route('admin.conteudos.items.index') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 {{ str_contains($currentRoute, 'admin/conteudos/items') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                                    {{ __('Conteúdo Itens') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/segmentacao-cliente') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/segmentacao-cliente') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span>Segmentação de Clientes</span>
                    </a>
                    <a href="{{ url('/admin/users') }}"
                        class="flex items-center px-3 py-2 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ str_contains($currentRoute, 'admin/users') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <span>Usuários</span>
                    </a>

                </nav>
            </div>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="col-span-3 p-6">
            @yield('content-wrapper')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 text-gray-600 text-center p-4 mt-auto">
        <p class="text-sm">&copy; {{ date('Y') }} Olympikus - Todos os direitos reservados</p>
    </footer>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.querySelector('aside');

            const overlay = document.getElementById('sidebar-overlay');

            function toggleMobileMenu() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }

            mobileMenuButton.addEventListener('click', toggleMobileMenu);

            overlay.addEventListener('click', toggleMobileMenu);

            // Fecha o menu ao clicar fora em telas pequenas
            document.addEventListener('click', function(event) {
                const isClickInsideMenu = sidebar.contains(event.target);
                const isClickOnButton = mobileMenuButton.contains(event.target);

                if (!isClickInsideMenu && !isClickOnButton && window.innerWidth < 768 && !sidebar.classList
                    .contains('-translate-x-full')) {
                    toggleMobileMenu();
                }
            });

            // Atualiza o estado do menu ao redimensionar a tela
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });
    </script>
</body>

</html>
