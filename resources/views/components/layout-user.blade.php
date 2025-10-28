<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Under Armour' }}</title>
    <!-- Favicon -->
    <link rel="icon" href="/images/Favicon_Under_Armour.png" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.min.css" />

    <!-- Alpine.js for interactive components (modal, toggles, etc.) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body,
        html {
            height: 100%;
            overflow: hidden;
        }
    </style>

    <link rel="stylesheet" href="/css/css.css" />

    <!-- Scripts e estilos adicionais -->
    @stack('styles')
</head>

<body class="bg-[#F1F1F1] flex flex-col min-h-screen">
    <!-- Header -->
    <x-header :user="auth()->user()" />

    <!-- Conteúdo principal -->
    <main class="w-[100vw] lg:h-[100vh] overflow-hidden">
        {{ $slot }}
    </main>

    <!-- Footer (opcional) -->
    @isset($footer)
        <footer>
            {{ $footer }}
        </footer>
    @endisset

    <!-- Scripts adicionais -->
    @stack('scripts')
</body>

</html>
