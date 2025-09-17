<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Olympikus - Novo Layout</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <link rel="stylesheet" href="/css/css.css" />
</head>

<body class="bg-[#F1F1F1] flex flex-col min-h-screen">
    <!-- Header -->
    <header class="flex items-center justify-between gap-4 pt-4 pr-4 pl-4 pb-2">
        <div class="flex items-center space-x-2">
            <img src="/images/logo.png" alt="Logo" />
        </div>
        <div class="flex items-center space-x-4">
            <!--<button class="text-gray-700 font-semibold hover:text-blue-600">
          Calçados
        </button>-->
            <button class="text-gray-700 font-semibold hover:text-blue-600">
                João
            </button>

            <i class="fa-regular fa-user text-gray-700 hover:text-blue-600 text-lg"></i>

            <img src="/images/icones/logout.svg" alt="Logo" />
        </div>
    </header>

    <div id="produtos" class="grid grid-cols-1 lg:grid-cols-3 gap-2">
        <div>
            <img src="/images/segmento-calcados-desk.jpg" class="hidden lg:block w-full" alt="" />
            <img src="/images/segmento-calcados-mobile.jpg" class="block lg:hidden w-full" alt="" />
        </div>
        <div>
            <img src="/images/segmento-vestuario-desk.jpg" class="hidden lg:block w-full" alt="" />
            <img src="/images/segmento-vestuario-mobile.jpg" class="block lg:hidden w-full" alt="" />
        </div>
        <div>
            <img src="/images/segmento-corre-desk.jpg" class="hidden lg:block w-full" alt="" />
            <img src="/images/segmento-corre-mobile.jpg" class="block lg:hidden w-full" alt="" />
        </div>
    </div>
</body>

</html>
