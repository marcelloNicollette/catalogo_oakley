<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>@yield('page_title', 'Painel Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="/images/Favicon_Under_Armour.png" type="image/png">
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
                <svg xmlns="http://www.w3.org/2000/svg" width="278" height="19" viewBox="0 0 278 19"
                    fill="none">
                    <path
                        d="M44.6821 16.6595C39.2373 16.6595 39.1414 12.5182 39.1414 10.9237V3.38383C39.1414 2.92825 39.1048 2.32232 40.0732 2.32232H42.8915C43.8051 2.32232 43.7503 2.96925 43.7503 3.38383V10.9237C43.7503 11.4567 43.8462 12.9009 45.824 12.9009H50.5471C52.4884 12.9009 52.6026 11.4567 52.6026 10.9237V3.38383C52.6026 2.96469 52.5432 2.32232 53.4614 2.32232H56.298C57.3257 2.32232 57.2298 2.96925 57.2298 3.38383V10.9237C57.2298 12.5182 57.1339 16.6595 51.6708 16.6595H44.6821Z"
                        fill="black"></path>
                    <path
                        d="M70.7641 15.7483C68.8411 13.1651 66.1004 9.91686 63.3004 6.48178V15.6526C63.3004 16.049 63.3963 16.6595 62.4462 16.6595H59.8197C58.8696 16.6595 58.9838 16.049 58.9838 15.6526V3.38383C58.9838 2.96469 58.9473 2.32232 59.8197 2.32232H64.9402C66.3882 2.32232 68.4437 5.22893 69.7958 7.14693C70.8418 8.60934 72.7648 10.8098 74.0621 12.4636V3.38383C74.0621 2.96469 74.0073 2.32232 74.9574 2.32232H77.8168C78.7304 2.32232 78.671 2.96925 78.671 3.38383V16.6595H73.418C72.2943 16.6595 71.801 16.7369 70.7733 15.7483H70.7641Z"
                        fill="black"></path>
                    <path
                        d="M92.4109 12.8781C94.713 12.8781 94.544 10.6777 94.544 9.67084C94.544 6.29043 93.5939 6.15831 92.0683 6.15831H84.8329V12.8781H92.4109ZM80.3976 16.6595V2.34055H93.0778C93.8589 2.34055 99.057 2.24487 99.057 7.69362C99.057 13.1424 99.6645 16.6595 93.192 16.6595H86.3586L84.874 13.6572V16.6595H80.3976Z"
                        fill="black"></path>
                    <path
                        d="M104.022 2.43622H115.711C116.702 2.43622 116.57 3.08314 116.57 4.27677C116.57 5.39749 116.721 6.0262 115.711 6.0262H106.475C106.228 6.0262 105.388 5.89408 105.388 6.76879C105.388 7.64351 105.214 7.98519 106.151 7.98519H114.318C114.318 7.98519 115.496 10.2267 115.633 10.6048C115.825 10.9465 115.803 11.2699 115.081 11.2699H106.626L105.31 8.72324V12.4818C105.31 13.3565 106.091 13.1834 106.32 13.1834H115.917C116.867 13.1834 116.794 13.8485 116.794 14.9282C116.794 16.0854 116.871 16.7323 115.917 16.7323H103.771C102.761 16.7323 100.784 16.4271 100.784 13.2745V5.37927C100.784 4.56378 101.222 2.43622 104.022 2.43622Z"
                        fill="black"></path>
                    <path
                        d="M129.917 6.12187H124.226C123.271 6.12187 123.312 6.44533 123.312 6.72779V9.29271H129.177C132.014 9.29271 132.014 8.59112 132.014 7.84852C132.014 6.36788 131.899 6.12187 129.917 6.12187ZM119.731 2.34055H132.525C134.238 2.34055 136.732 2.32232 136.732 6.9328C136.732 9.9533 136.083 10.1036 134.713 11.033C137.015 11.4294 136.714 14.377 136.714 15.8941C136.714 16.6731 136.426 16.6549 136.198 16.6549H132.448C131.666 16.6549 131.858 15.4203 131.858 14.7733C131.858 13.0057 130.867 13.0831 130.488 13.0831H124.965C124.431 12.172 123.403 10.1219 123.403 10.1219V16.0672C123.403 16.582 122.892 16.6549 122.7 16.6549H118.931C119.142 16.6549 118.552 16.6913 118.552 16.1811V3.57517C118.552 2.68223 119.183 2.34055 119.731 2.34055Z"
                        fill="black"></path>
                    <path
                        d="M157.237 6.40433C157.027 6.76424 155.026 10.3724 154.875 10.6959C154.779 10.8462 154.875 10.9055 155.085 10.9055H159.484C159.731 10.9055 159.79 10.8508 159.713 10.6959C159.562 10.3724 157.657 6.76424 157.465 6.38611C157.41 6.29043 157.273 6.29043 157.237 6.40433ZM158.763 2.43622C159.694 2.43622 160.608 2.85535 161.599 4.77335C162.266 6.14009 166.911 14.5137 167.88 16.2631V16.7369H163.043L161.654 14.2312H155.771C155.771 14.2312 154.779 11.9715 154.496 11.3428C154.135 11.9305 152.194 15.6162 151.527 16.7369H146.672V16.4317C147.663 14.5683 154.423 2.43622 154.423 2.43622H158.763Z"
                        fill="black"></path>
                    <path
                        d="M180.565 6.12187H174.873C173.923 6.12187 173.96 6.44533 173.96 6.72779V9.29271H179.82C182.657 9.29271 182.657 8.59112 182.657 7.84852C182.657 6.36788 182.542 6.12187 180.56 6.12187H180.565ZM170.378 2.34055H183.173C184.886 2.34055 187.38 2.32232 187.38 6.9328C187.38 9.9533 186.731 10.1036 185.361 11.033C187.663 11.4294 187.361 14.377 187.361 15.8941C187.361 16.6731 187.078 16.6549 186.85 16.6549H183.1C182.319 16.6549 182.51 15.4203 182.51 14.7733C182.51 13.0057 181.519 13.0831 181.14 13.0831H175.618C175.083 12.172 174.055 10.1219 174.055 10.1219V16.0672C174.055 16.582 173.539 16.6549 173.352 16.6549H169.584C169.794 16.6549 169.204 16.6913 169.204 16.1811V3.57517C169.204 2.68223 169.83 2.34055 170.383 2.34055H170.378Z"
                        fill="black"></path>
                    <path
                        d="M198.557 16.6595C197.607 14.8736 194.958 9.95786 193.167 6.72779V15.6526C193.167 16.049 193.222 16.6595 192.313 16.6595H189.723C188.75 16.6595 188.828 16.049 188.828 15.6526V3.38383C188.828 2.96469 188.773 2.34055 189.723 2.34055H194.195C194.862 2.34055 195.816 2.19021 196.881 4.31321C197.68 6.02164 199.375 9.55695 200.535 11.4339C201.736 9.55695 203.467 6.02164 204.267 4.31321C205.313 2.18565 206.249 2.34055 206.989 2.34055H211.447C212.361 2.34055 212.265 2.96925 212.265 3.38383V15.6526C212.265 16.049 212.397 16.6595 211.447 16.6595H208.839C207.889 16.6595 207.962 16.049 207.962 15.6526V6.72779C206.153 9.95786 203.527 14.8736 202.536 16.6595H198.557Z"
                        fill="black"></path>
                    <path
                        d="M226.544 13.0103C228.695 13.0103 228.618 10.7916 228.618 9.30638C228.618 7.97608 228.924 5.88952 226.124 5.88952H221.382C218.601 5.88952 218.925 7.98064 218.925 9.30638C218.925 10.787 218.792 13.0103 220.944 13.0103H226.544ZM218.016 16.6959C213.772 16.6959 213.96 12.1583 213.96 9.21526C213.96 6.51822 213.654 2.3041 218.966 2.26765H228.394C233.724 2.26765 233.382 6.541 233.382 9.21526C233.382 12.1583 233.592 16.6959 229.289 16.6959H218.016Z"
                        fill="black"></path>
                    <path
                        d="M240.48 16.6595C235.035 16.6595 234.94 12.5182 234.94 10.9237V3.38383C234.94 2.92825 234.903 2.32232 235.871 2.32232H238.69C239.603 2.32232 239.544 2.96925 239.544 3.38383V10.9237C239.544 11.4567 239.64 12.9009 241.618 12.9009H246.341C248.282 12.9009 248.396 11.4567 248.396 10.9237V3.38383C248.396 2.96469 248.341 2.32232 249.255 2.32232H252.092C253.119 2.32232 253.023 2.96925 253.023 3.38383V10.9237C253.023 12.5182 252.927 16.6595 247.464 16.6595H240.476H240.48Z"
                        fill="black"></path>
                    <path
                        d="M260.547 6.12187C259.596 6.12187 259.633 6.44533 259.633 6.72779V9.29271H265.498C268.335 9.29271 268.335 8.59112 268.335 7.84852C268.335 6.36788 268.22 6.12187 266.243 6.12187H260.547ZM268.846 2.34055C270.559 2.34055 273.053 2.32232 273.053 6.9328C273.053 9.9533 272.404 10.1036 271.034 11.033C273.336 11.4294 273.035 14.377 273.035 15.8941C273.035 16.6731 272.752 16.6549 272.519 16.6549H268.769C267.987 16.6549 268.179 15.4203 268.179 14.7733C268.179 13.0057 267.188 13.0831 266.809 13.0831H261.286C260.752 12.172 259.724 10.1219 259.724 10.1219V16.0672C259.724 16.582 259.208 16.6549 259.016 16.6549H255.248C255.458 16.6549 254.869 16.6913 254.869 16.1811V3.57517C254.869 2.68223 255.495 2.34055 256.047 2.34055H268.846Z"
                        fill="black"></path>
                    <path
                        d="M275.785 14.7323H276.305C276.57 14.7323 276.616 14.6595 276.616 14.541V14.5137C276.616 14.3633 276.57 14.2768 276.305 14.2768H275.785V14.7369V14.7323ZM275.396 14.2449C275.396 14.008 275.424 13.9487 275.648 13.9487H276.465C276.854 13.9487 277.059 14.2585 277.059 14.5729C277.059 14.9009 276.913 15.1515 276.584 15.1515C276.689 15.3428 276.835 15.6253 276.94 15.803C277.086 16.0718 276.689 16.131 276.63 16.0718C276.392 15.7301 276.241 15.4339 276.082 15.197H275.798V15.9077C275.798 16.0991 275.634 16.1173 275.543 16.1173C275.396 16.1173 275.396 15.967 275.396 15.8485V14.2449ZM276.123 16.3952C276.954 16.3952 277.548 15.7711 277.548 14.9556C277.548 14.1401 276.94 13.5615 276.077 13.5615C275.346 13.5615 274.665 14.213 274.665 14.9556C274.665 15.7711 275.305 16.3952 276.123 16.3952ZM274.268 14.9556C274.268 13.9305 275.191 13.115 276.127 13.115C277.182 13.115 278 13.9305 278 14.9556C278 15.9806 277.155 16.8508 276.082 16.8508C275.008 16.8508 274.268 15.9761 274.268 14.9556Z"
                        fill="black"></path>
                    <path
                        d="M24.9538 9.49772C28.3066 8.0262 30.4991 5.81663 30.6133 3.3656C30.6133 3.3656 29.7317 2.68223 26.8723 1.6344C24.36 0.714123 22.4461 0.5 22.4461 0.5L22.4552 5.96241C22.4552 6.7779 22.1264 7.61162 21.5097 8.34966C19.6141 7.89408 17.5129 7.63895 15.3158 7.63895C13.1141 7.63895 11.0175 7.89863 9.1173 8.35421C8.49608 7.61617 8.1672 6.78246 8.1672 5.96697L8.17634 0.504556C8.17634 0.504556 6.26243 0.714123 3.75015 1.63895C0.88615 2.68679 0 3.3656 0 3.3656C0.118762 5.81663 2.3113 8.03075 5.66405 9.50228C2.3113 10.9738 0.12333 13.1834 0 15.6344C0 15.6344 0.88615 16.3178 3.74102 17.3656C6.2533 18.2859 8.1672 18.5 8.1672 18.5L8.15807 13.0376C8.15807 12.2221 8.48695 11.3884 9.10816 10.6503C11.0038 11.1059 13.1004 11.361 15.3021 11.361C17.5038 11.361 19.6049 11.1059 21.5006 10.6458C22.1218 11.3838 22.4507 12.2175 22.4507 13.033L22.4415 18.4954C22.4415 18.4954 24.36 18.2859 26.8677 17.361C29.7271 16.3132 30.6087 15.6298 30.6087 15.6298C30.49 13.1788 28.2974 10.9692 24.9447 9.49772H24.9538ZM15.3066 10.7278H15.2427C13.2557 10.7278 11.6387 10.2403 10.4511 9.50228C11.6387 8.75968 13.2603 8.27221 15.2473 8.27221H15.3706C17.3576 8.27221 18.9746 8.75968 20.1622 9.50228C18.9746 10.2449 17.353 10.7323 15.366 10.7323H15.3066V10.7278Z"
                        fill="black"></path>
                </svg>
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
