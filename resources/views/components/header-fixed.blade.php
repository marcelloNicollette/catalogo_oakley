@props(['user' => null])

<header class="fixed top-0 left-0 right-0 flex items-center justify-between gap-4 p-5 bg-[#F1F1F1] z-50">
    <div class="flex items-center space-x-2">
        <a href="{{ route('user.segmentacao') }}"><img src="/images/logo.png" alt="Logo" /></a>
    </div>
    <div class="flex items-center space-x-4">
        @php
            $segmentacoes = \App\Models\Segmentacao::where('active', 1)->get();
            $currentUrl = request()->path();
            $currentSlug = '';

            if (strpos($currentUrl, 'user/') === 0) {
                $parts = explode('/', $currentUrl);
                if (count($parts) > 1) {
                    $currentSlug = $parts[1];
                }
            }
        @endphp

        <style>
            #segmentacao-select {
                min-width: 120px;
                max-width: 123px;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                text-align: center;
                font-weight: 400;
                letter-spacing: 0.01em;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
                padding-left: 15px;
                padding-right: 25px;
                font-size: 14px;
            }

            #segmentacao-select::-ms-expand {
                display: none;
            }

            #segmentacao-select option {
                background-color: white;
                color: black;
                padding: 8px;
                text-align: left;
            }
        </style>
        <div class="relative inline-block text-left">
            @if (count($parts) != 4 && count($parts) != 5)
                @if ($currentSlug != 'segmentacao')
                    @foreach ($segmentacoes as $segmentacao)
                        @if ($currentSlug == $segmentacao->slug)
                            <div
                                class="block w-full bg-black text-white border-none px-5 py-2 pr-5 rounded-full shadow leading-tight focus:outline-none focus:shadow-outline font-normal text-sm cursor-pointer hover:bg-gray-900 transition-colors duration-200 text-center">
                                <a href="{{ route('user.segmentacao') }}" class="">
                                    {{ $segmentacao->segmento }}

                                    <img src="/images/icones/setas.svg" class="float-right pl-[0.5rem] pt-1"
                                        alt="Coleções" />
                                </a>



                            </div>
                        @endif
                    @endforeach
                @endif




            @endif
        </div>

        @if ($user)
            @if (count($parts) != 4 && count($parts) != 5 && count($parts) != 2)
                <button class="text-gray-700 font-normal hover:text-gray-400">
                    {{ $user->name ?? 'Usuário' }}
                </button>
                <a href="/user/conta" rel="noopener noreferrer">
                    <img src="/images/icones/user.svg" alt="User" />
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                    @csrf
                    <button
                        class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-150">
                        <img src="/images/icones/logout.svg" alt="Logout" />
                    </button>
                </form>
            @else
                <a href="javascript: history.go(-1);"
                    class="flex items-center border border-black rounded-full px-3 py-2 text-md bg-gray-100 hover:bg-gray-200 transition text-[14px]">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="px-1" />
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="flex items-center space-x-2">
                <i class="fa-regular fa-user text-gray-700 hover:text-blue-600 text-lg"></i>
                <span class="text-gray-700 font-semibold hover:text-blue-600">Login</span>
            </a>
        @endif
    </div>
</header>
