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


    <link rel="stylesheet" href="/css/css.css" />

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
        #google_translate_element,
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

    <div id="google_translate_element"></div>

    <!-- Header -->
    <x-header-fixed :user="auth()->user()" :type="'produto'" />

    <!-- Conteúdo principal -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer (opcional) -->
    @isset($footer)
        <footer>
            {{ $footer }}
        </footer>
    @endisset

    <!-- Google Translate Script -->
    <script type="text/javascript">
        // Configuração do idioma do usuário
        const USER_LANGUAGE = '{{ $googleTranslateCode }}';

        console.log('🚀 Iniciando sistema de tradução...');
        console.log('👤 Idioma do usuário:', USER_LANGUAGE);

        // Função para definir cookie do Google Translate
        function setGoogleTranslateCookie(langCode) {
            const cookieName = 'googtrans';
            const cookieValue = '/pt/' + langCode;
            const domain = window.location.hostname;

            // Define o cookie
            document.cookie = cookieName + '=' + cookieValue + '; path=/; domain=' + domain;
            document.cookie = cookieName + '=' + cookieValue + '; path=/';

            console.log('🍪 Cookie definido:', cookieName + '=' + cookieValue);
        }

        // Função para remover cookie do Google Translate
        function removeGoogleTranslateCookie() {
            const domain = window.location.hostname;
            document.cookie = 'googtrans=; path=/; domain=' + domain + '; expires=Thu, 01 Jan 1970 00:00:00 GMT';
            document.cookie = 'googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
            console.log('🍪 Cookie removido');
        }

        // Função para obter cookie
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return null;
        }

        // Aplicar tradução antes do Google Translate carregar
        if (USER_LANGUAGE !== 'pt') {
            console.log('🔧 Definindo cookie antes de carregar Google Translate');
            setGoogleTranslateCookie(USER_LANGUAGE);
        } else {
            console.log('🔧 Removendo cookie para exibir em português');
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

                console.log('✅ Google Translate inicializado');

                // Verificar se a tradução foi aplicada
                setTimeout(function() {
                    const currentCookie = getCookie('googtrans');
                    console.log('🍪 Cookie atual:', currentCookie);

                    if (currentCookie && currentCookie.includes(USER_LANGUAGE)) {
                        console.log('✅ Tradução aplicada via cookie');
                    } else if (USER_LANGUAGE !== 'pt') {
                        console.log('⚠️ Cookie não definido corretamente, tentando novamente...');
                        setGoogleTranslateCookie(USER_LANGUAGE);

                        // Recarregar para aplicar
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    }
                }, 2000);
            } catch (error) {
                console.error('❌ Erro ao inicializar Google Translate:', error);
            }
        }

        // Detectar mudanças de idioma no localStorage (outras abas)
        window.addEventListener('storage', function(e) {
            if (e.key === 'userLanguageChanged') {
                const newLang = e.newValue;
                console.log('📡 Evento storage detectado - novo idioma:', newLang);

                if (newLang) {
                    console.log('🔄 Idioma alterado em outra aba para:', newLang);

                    if (newLang === 'pt') {
                        removeGoogleTranslateCookie();
                    } else {
                        setGoogleTranslateCookie(newLang);
                    }

                    // Recarregar para aplicar mudança
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                }
            }
        });

        // Verificar mudanças periódicas no localStorage (mesma aba)
        let lastCheckedLanguage = USER_LANGUAGE;

        setInterval(function() {
            const storedLang = localStorage.getItem('userLanguageChanged');

            if (storedLang && storedLang !== lastCheckedLanguage) {
                console.log('🔄 Idioma alterado (verificação periódica):', storedLang);
                lastCheckedLanguage = storedLang;

                if (storedLang === 'pt') {
                    removeGoogleTranslateCookie();
                } else {
                    setGoogleTranslateCookie(storedLang);
                }

                // Recarregar para aplicar mudança
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        }, 1000);

        // Log de debug
        console.log('🍪 Cookie inicial:', getCookie('googtrans'));
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

    <!-- SweetAlert2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.min.js"></script>

    <!-- Scripts adicionais -->
    @stack('scripts')
</body>

</html>
