<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Oakley</title>
    <!-- Favicon -->
    <link rel="icon" href="/images/Oakley_logo.svg" type="image/svg+xml">
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
        [type=text]:focus,
        input:where(:not([type])):focus,
        [type=email]:focus,
        [type=url]:focus,
        [type=password]:focus,
        [type=number]:focus,
        [type=date]:focus,
        [type=datetime-local]:focus,
        [type=month]:focus,
        [type=search]:focus,
        [type=tel]:focus,
        [type=time]:focus,
        [type=week]:focus,
        [multiple]:focus,
        textarea:focus,
        select:focus {

            border-color: #000;
        }

        /* Customização do autocomplete */
        input[type="email"]:-webkit-autofill,
        input[type="password"]:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px #fff inset !important;
            -webkit-text-fill-color: #000 !important;
            border-bottom: 1px solid #000;
        }

        .input-style {
            padding: 20px 0;
        }
    </style>
</head>

<body class="items-center lg:justify-center bg-white text-black">
    <!-- Layout Mobile/Tablet: Mensagem de aplicação não disponível -->
    <div class="lg:hidden flex flex-col min-h-screen p-2">
        <!-- Seção azul com mensagem -->
        <div class="bg-white flex flex-col justify-between items-center p-4 flex-1 border border-black rounded-xl">
            <!-- Logo no topo -->
            <div class="flex justify-center w-full pt-4">
                <img src="/images/Oakley_logo.svg" alt="Oakley" class="h-8 w-auto" />
            </div>

            <!-- Conteúdo central -->
            <div class="flex flex-col items-center justify-center flex-1 w-full px-6">
                <!-- Ícone (opcional - você pode remover se não quiser) -->
                <!--<div class="mb-6">
                    <svg class="w-20 h-20 text-white opacity-80" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4"></path>
                    </svg>
                </div>-->

                <!-- Título -->
                <h2 class="text-black text-center mb-4">
                    Disponível apenas para desktop. <br>Versões para mobile e tablet chegam em breve.
                </h2>

                <!-- Mensagem -->
                <p class="text-black text-center text-base opacity-90 mb-8 max-w-sm">
                    Para acessar o catálogo digital da Oakley, utilize um computador ou tablet com tela maior.
                </p>

                <!-- Informação adicional (opcional) -->
                <div class="bg-black/5 rounded-lg p-4 max-w-sm">
                    <p class="text-black text-sm text-center opacity-80">
                        Para uma melhor experiência, recomendamos o acesso através de dispositivos com tela de pelo
                        menos 1024px de largura.
                    </p>
                </div>
            </div>

            <!-- Rodapé -->
            <div class="text-xs text-black text-center opacity-70 pb-4">
                <p>© {{ date('Y') }} Oakley</p>
            </div>
        </div>

        <!-- Seção da imagem abaixo -->
        <div class="flex-1">
            <img src="{{ isset($imgLogin) && $imgLogin?->mobile_url ? $imgLogin->mobile_url : asset('images/bg-geral.jpg') }}"
                alt="Corredores" class="w-full h-full object-cover" />
        </div>
    </div>

    <!-- Layout Desktop: Lado a lado -->
    <div class="hidden lg:flex flex-row gap-2 min-h-screen p-2 h-[100vh]">

        <!-- Lado esquerdo (3/4 no desktop) -->
        <div class="lg:w-[60%] 2xl:w-[70%] 3xl:w-[80%] w-full">
            <img src="{{ isset($imgLogin) && $imgLogin?->desktop_url ? $imgLogin->desktop_url : asset('images/bg-geral.jpg') }}"
                alt="Corredores" class="w-full h-full object-cover rounded-xl" />
        </div>

        <!-- Lado direito (formulário) -->
        <div
            class="lg:w-[40%] 2xl:w-[30%] 3xl:w-[20%] w-full bg-white flex flex-col justify-between items-center p-6 lg:p-12 rounded-xl min-h-full border border-black">
            <!-- Logo no topo -->
            <div class="flex justify-center w-full">
                <img src="/images/Oakley_logo.svg" alt="Oakley" class="h-8 w-auto" />
            </div>

            <!-- Conteúdo central -->
            <div class="items-center justify-center w-[350px]">
                <!-- Título -->
                <h2 class="text-xl text-black text-center mb-8">Bem-vindo ao catálogo <br>digital da Oakley.</h2>

                <!-- Formulário -->
                <form class="" method="POST" action="{{ url('/admin/login') }}">
                    @csrf
                    <input name="email" type="email" placeholder="E-mail"
                        class="w-full text-black py-5 mb-2 placeholder-gray-500 input-estilizado bg-transparent border-0 focus:ring-0 input-style" />
                    @error('email')
                        <p class="text-[#FC0] text-sm">{{ $message }}</p>
                    @enderror
                    <input name="password" type="password" placeholder="Senha"
                        class="w-full text-black py-5 mb-2 placeholder-gray-500 input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 input-style" />
                    @error('password')
                        <p class="text-[#FC0] text-sm">{{ $message }}</p>
                    @enderror
                    <div class="text-sm text-black text-center m-4 opacity-70 cursor-pointer hover:opacity-100 transition"
                        onclick="openPasswordRecoveryModal()">Esqueceu a senha?</div>

                    <button type="submit"
                        class="w-full border border-black text-black hover:bg-black hover:text-white py-2 rounded-full transition">
                        Entrar
                    </button>
                </form>
            </div>

            <!-- Rodapé -->
            <div class="text-xs text-black text-center opacity-70">
                Precisa de um login? <a href="#" class="text-black underline cursor-pointer"
                    onclick="openAccessRequestModal()">Solicite um acesso</a>
            </div>
        </div>
    </div>

    <x-passwordRecovery-modal />

    <x-accessRequest-modal />


    <script>
        function openPasswordRecoveryModal() {
            document.getElementById('passwordRecoveryModal').classList.remove('hidden');
        }

        function closePasswordRecoveryModal() {
            document.getElementById('passwordRecoveryModal').classList.add('hidden');
        }

        function openAccessRequestModal() {
            document.getElementById('accessRequestModal').classList.remove('hidden');
        }

        function closeAccessRequestModal() {
            document.getElementById('accessRequestModal').classList.add('hidden');
        }

        // Fechar modal ao clicar fora dele
        document.getElementById('passwordRecoveryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePasswordRecoveryModal();
            }
        });

        document.getElementById('accessRequestModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAccessRequestModal();
            }
        });
    </script>
</body>

</html>
