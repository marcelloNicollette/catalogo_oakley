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


    @vite(['resources/js/app.js'])

    <!-- Scripts e estilos adicionais -->
    @stack('styles')

    @php
        // Obter idioma do usuário
        $userLanguage = auth()->check() ? auth()->user()->idioma ?? 'pt' : 'pt';

        // Mapear códigos de idioma
        $languageMap = [
            'pt' => ['code' => 'pt', 'name' => 'Português', 'flag' => '🇧🇷'],
            'en' => ['code' => 'en', 'name' => 'English', 'flag' => '🇺🇸'],
            'es' => ['code' => 'es', 'name' => 'Español', 'flag' => '🇪🇸'],
        ];

        $currentLang = $languageMap[$userLanguage] ?? $languageMap['pt'];
        $googleTranslateCode = $currentLang['code'];
    @endphp

    <style>
        /* Esconder completamente todos os elementos do Google Translate */
        #google_translate_element {
            position: fixed !important;
            left: -9999px !important;
            top: -9999px !important;
            opacity: 0 !important;
        }

        .goog-te-banner-frame,
        .goog-te-banner-frame.skiptranslate,
        .skiptranslate,
        body>.skiptranslate,
        iframe.skiptranslate {
            display: none !important;
            visibility: hidden !important;
        }

        body {
            top: 0 !important;
        }
    </style>
</head>

<body class="bg-[#F1F1F1] flex flex-col min-h-screen">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-30C286HJT7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-30C286HJT7');
    </script>
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

    <!-- Google Translate Script -->
    <div id="google_translate_element"></div>
    <script type="text/javascript">
        const USER_LANGUAGE = '{{ $googleTranslateCode }}';

        function setGoogleTranslateCookie(langCode) {
            const cookieName = 'googtrans';
            const cookieValue = '/pt/' + langCode;
            const domain = window.location.hostname;
            document.cookie = cookieName + '=' + cookieValue + '; path=/; domain=' + domain;
            document.cookie = cookieName + '=' + cookieValue + '; path=/';
        }

        function removeGoogleTranslateCookie() {
            const domain = window.location.hostname;
            document.cookie = 'googtrans=; path=/; domain=' + domain + '; expires=Thu, 01 Jan 1970 00:00:00 GMT';
            document.cookie = 'googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
        }

        if (USER_LANGUAGE !== 'pt') {
            setGoogleTranslateCookie(USER_LANGUAGE);
        } else {
            removeGoogleTranslateCookie();
        }

        function googleTranslateElementInit() {
            try {
                new google.translate.TranslateElement({
                    pageLanguage: 'pt',
                    includedLanguages: 'pt,en,es',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                    autoDisplay: false
                }, 'google_translate_element');
            } catch (error) {
                console.error('Erro ao inicializar Google Translate:', error);
            }
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.min.js"></script>

    <!-- Scripts adicionais -->
    @stack('scripts')
</body>

</html>
