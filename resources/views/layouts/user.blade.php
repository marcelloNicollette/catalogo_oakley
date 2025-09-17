<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Usuário - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">
    <header class="bg-green-600 text-black p-4">
        <h1 class="text-xl font-bold">Área do Usuário</h1>
    </header>

    <nav x-data="{ open: false }" class="bg-green-500 text-white">
        <div class="px-4 py-2 flex justify-between items-center">
            <div class="text-lg font-semibold">Usuário</div>
            <button @click="open = !open" class="md:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'inline-flex': open, 'hidden': !open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div :class="{ 'block': open, 'hidden': !open }"
            class="md:flex md:items-center md:justify-start px-4 pb-2 md:pb-0 hidden">
            <a href="{{ url('/user/dashboard') }}" class="block px-3 py-2 hover:underline">Dashboard</a>
            <a href="{{ url('/user/perfil') }}" class="block px-3 py-2 hover:underline">Perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block px-3 py-2 hover:underline text-left">Sair</button>
            </form>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>

    <footer class="bg-green-600 text-black text-center p-2">
        &copy; {{ date('Y') }} Usuário
    </footer>
</body>

</html>
