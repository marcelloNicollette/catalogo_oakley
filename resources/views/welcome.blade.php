<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Olympikus</title>

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

    <style>
        /* Customização do autocomplete */
        input[type="email"]:-webkit-autofill,
        input[type="password"]:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px rgba(39, 53, 212, 1) inset !important;
            -webkit-text-fill-color: rgba(39, 53, 212, 1) !important;
            border-bottom: 1px solid rgba(39, 53, 212, 1);
        }

        .input-style {
            padding: 20px 0;
        }
    </style>
</head>

<body class="items-center lg:justify-center">
    <div class="flex flex-col-reverse lg:flex-row gap-2 min-h-screen">
        <!-- Lado esquerdo (fica abaixo no mobile, 3/4 no desktop) -->
        <div class="lg:w-[60%] 2xl:w-[70%] 3xl:w-[80%] w-full">
            <img src="./images/bg-geral.jpg" alt="Corredores" class="w-full h-full object-cover rounded-xl" />
        </div>

        <!-- Lado direito (fica acima no mobile, 1/4 no desktop) -->
        <div
            class="lg:w-[40%] 2xl:w-[30%] 3xl:w-[20%] w-full bg-[#2735D4] flex flex-col items-center justify-start lg:justify-center p-6 lg:p-12 rounded-xl">

            <div class="m-5"><img src="/images/logo-branco.png" alt=""></div>

            <div class="mt-5">
                <a href="admin/login" class="bg-[#2735D4] border-white border rounded-full text-white py-2 px-5">Acesso
                    Administrativo</a>
            </div>
            <div class="mt-5">
                <a href="user/login" class="bg-[#2735D4] border-white border rounded-full text-white py-2 px-5">Acesso
                    Usuário</a>
            </div>
        </div>
    </div>
</body>

</html>
