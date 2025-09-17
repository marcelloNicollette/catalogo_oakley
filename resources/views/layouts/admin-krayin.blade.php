<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>@yield('page_title', 'Painel Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @stack('css')
</head>

<body class="min-h-screen flex flex-col bg-gray-100">

    <!-- Header -->
    <header class="bg-blue-800 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="font-bold text-xl">@yield('page_title', 'Admin')</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="hover:underline">Sair</button>
            </form>
        </div>
    </header>

    <!-- Sidebar e Conteúdo -->
    <div class="flex flex-1 container mx-auto">
        <aside class="w-64 bg-blue-700 text-white p-4 hidden md:block">
            <!-- Navegação Krayin -->
            <nav class="flex flex-col space-y-2">
                <a href="{{ url('/admin/dashboard') }}" class="hover:underline">Dashboard</a>
                <a href="{{ url('/admin/collections') }}" class="hover:underline">Coleções</a>
                <a href="{{ url('/admin/categories') }}" class="hover:underline">Categorias</a>
                <a href="{{ url('/admin/products') }}" class="hover:underline">Produtos</a>

                <a href="{{ url('/admin/usuarios') }}" class="hover:underline">Usuários</a>
                <!-- Adicione mais links conforme necessário -->
            </nav>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="flex-1 p-6">
            @yield('content-wrapper')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center p-4 mt-auto">
        &copy; {{ date('Y') }} Seu Sistema
    </footer>

    @stack('scripts')
</body>

</html>
