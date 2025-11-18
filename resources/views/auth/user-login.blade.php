<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Under Armour</title>

    <!-- Favicon -->
    <link rel="icon" href="/images/Favicon_Olympikus.png" type="image/png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif
</head>

<body class="items-center lg:justify-center">
    <div class="flex flex-col-reverse lg:flex-row gap-2 min-h-screen">
        <!-- Lado esquerdo (fica abaixo no mobile, 3/4 no desktop) -->
        <div class="lg:w-[60%] 2xl:w-[70%] 3xl:w-[80%] w-full">
            <img src="/images/bg-geral.jpg" alt="Corredores" class="w-full h-full object-cover rounded-xl" />
        </div>

        <!-- Lado direito (formulário) -->
        <div
            class="lg:w-[40%] 2xl:w-[30%] 3xl:w-[20%] w-full bg-[#2735D4] flex flex-col items-center justify-start lg:justify-center p-6 lg:p-12 rounded-xl">
            <!-- Logo -->
            <img src="/images/logo-branco.png" alt="Olympikus" class="mb-6">

            <!-- Título -->
            <h2 class="text-xl text-white text-center m-5">Bem-vindo ao catálogo digital da Olympikus.</h2>

            <!-- Formulário -->
            <form class="w-full max-w-xs" method="POST" action="{{ url('/admin/login') }}">
                @csrf
                <input name="email" type="email" placeholder="E-mail"
                    class="w-full text-white py-2 mb-4 placeholder-white input-estilizado bg-transparent border-0 focus:ring-0" />
                <input name="password" type="password" placeholder="Senha"
                    class="w-full text-white py-2 mb-4 placeholder-white input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0" />

                <div class="text-sm text-white text-center m-4 opacity-70">Esqueceu a senha?</div>

                <button type="submit"
                    class="w-full border border-white text-white py-2 rounded-full hover:bg-white hover:text-[#2735D4] transition">
                    Entrar
                </button>

                <div class="text-xs text-white text-center mt-4 opacity-70">
                    Precisa de um login? <a href="#" class="text-white underline">Solicite um acesso</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
