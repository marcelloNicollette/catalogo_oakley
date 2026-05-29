@props(['user' => null, 'type' => ''])

<style>
    .space-x-2> :not([hidden])~ :not([hidden]) {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
</style>

@php
    $segmentacoes = \App\Models\Segmentacao::where('active', 1)->get();
    $currentUrl = request()->path();
    $currentSlug = '';
    $parts = [];

    if (strpos($currentUrl, 'user/') === 0) {
        $parts = explode('/', $currentUrl);
        if (count($parts) > 1) {
            $currentSlug = $parts[1];
        }
    }

    $backColecoesUrl = null;
    if (count($parts) >= 4 && ($parts[2] ?? null) === 'colecoes') {
        $backColecoesUrl = url('/user/' . $parts[1] . '/colecoes');
    }
@endphp

@if ($type === '')
    <div x-data="{ mobileOpen: false }">
        <header class="flex items-center justify-between gap-4 p-5">
            <div class="flex items-center space-x-2 py-2">

                @if (\Illuminate\Support\Str::contains(request()->path(), 'colecoes') && count($parts) == 3)
                    <span class="text-base font-semibold lg:hidden">Coleções</span>
                @elseif (count($parts) == 4)
                    <span class="text-base font-semibold lg:hidden">Produtos</span>
                @endif



                @if (count($parts) == 2)
                    <a class="block"
                        href="{{ request()->route('slug') == null ? route('user.segmentacao') : route('user.slug', request()->route('slug')) }}">
                        <img src="/images/Oakley_logo.svg" alt="Oakley" class="h-6 w-auto" />
                    </a>
                @else
                    <a class="hidden lg:block"
                        href="{{ request()->route('slug') == null ? route('user.segmentacao') : route('user.slug', request()->route('slug')) }}">
                        <img src="/images/Oakley_logo.svg" alt="Oakley" class="h-6 w-auto" />
                    </a>
                @endif
            </div>
            <div class="hidden lg:flex items-center min-h-[40px]">


                <div class="relative inline-block text-left">
                    @if (count($parts) != 4 && count($parts) != 5 && count($parts) != 6)
                        @if ($currentSlug != 'segmentacao')
                            @foreach ($segmentacoes as $segmentacao)
                                @if ($currentSlug == $segmentacao->slug)
                                    <div
                                        class="block w-full bg-white text-black border border-black px-5 py-[10px] rounded-full shadow focus:outline-none focus:shadow-outline font-normal cursor-pointer hover:bg-gray-100 transition-colors duration-200 text-center">
                                        <a href="{{ route('user.segmentacao') }}" class="flex text-sm ">
                                            {{ $segmentacao->segmento }}

                                            <img src="/images/icones/setas.svg" class="float-right pl-[10px]"
                                                alt="Coleções" />
                                        </a>



                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>



                @if ($user)
                    @if ($currentSlug != 'segmentacao')
                        @if (count($parts) != 6)
                            @if ($user->segmentacoesCliente->count() != 1)
                                <!-- CTA Segmentações Cliente -->
                                <div x-data="{
                                    showModal: false,
                                    selectedSegmentacoes: [],
                                    segmentacoesDisponiveis: @js($user && $user->segmentacoesCliente->count() > 0 ? $user->segmentacoesCliente : \App\Models\SegmentacaoCliente::where('active', true)->get()),
                                    toggleSegmentacao(id) {
                                        const index = this.selectedSegmentacoes.indexOf(id);
                                        if (index > -1) {
                                            this.selectedSegmentacoes.splice(index, 1);
                                        } else {
                                            this.selectedSegmentacoes.push(id);
                                        }
                                        this.persistSelected();
                                    },
                                    toggleSelectAll(checked) {
                                        if (checked) {
                                            this.selectedSegmentacoes = this.segmentacoesDisponiveis.map(s => s.id);
                                        } else {
                                            this.selectedSegmentacoes = [];
                                        }
                                        this.persistSelected();
                                    },
                                    persistSelected() {
                                        try {
                                            localStorage.setItem('selectedSegmentacoes', JSON.stringify(this.selectedSegmentacoes));
                                        } catch (e) {
                                            console.error('Erro ao salvar segmentações selecionadas:', e);
                                        }
                                    },
                                    init() {
                                        const saved = localStorage.getItem('selectedSegmentacoes');
                                        if (saved) {
                                            try {
                                                this.selectedSegmentacoes = JSON.parse(saved);
                                            } catch (e) {
                                                this.selectedSegmentacoes = [];
                                            }
                                        }
                                    }
                                }" class="relative pl-[10px]">
                                    <!-- Botão CTA -->
                                    <button @click="showModal = true"
                                        class="flex items-center space-x-2 px-5 py-[9px] text-black  rounded-full hover:opacity-80 transition-colors border border-black">

                                        <div class="flex flex-row items-start">
                                            <span class="text-sm ">Segmentos: </span>
                                            <div class="text-sm max-w-[200px] truncate px-[5px] py-0">
                                                <span class="text-[#7A7A7A]"
                                                    x-text="selectedSegmentacoes.length === 0 ? 'Todos' : selectedSegmentacoes.length === 1 ? '1 seleção' : selectedSegmentacoes.length + ' seleções'"></span>
                                            </div>
                                        </div>

                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                            class="ml-0 mr-0" viewBox="0 0 12 8" fill="none">
                                            <path d="M1.10938 1.5L6.05912 6.44975L11.0089 1.5" stroke="black"
                                                stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </button>

                                    <!-- Modal -->
                                    <div x-show="showModal" x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0" @click.away="showModal = false"
                                        @keydown.escape.window="showModal = false"
                                        class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

                                        <!-- Overlay -->
                                        <div class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

                                        <!-- Modal Content -->
                                        <div class="flex items-center justify-center min-h-screen px-4 py-6">
                                            <div
                                                class="relative z-50 bg-white rounded-lg max-w-xl w-full mx-4 p-6 max-h-[60vh] overflow-hidden flex flex-col">
                                                <div class="flex justify-center items-center mb-6">
                                                    <h2 class="text-2xl font-semibold text-gray-900">Selecionar
                                                        Segmentos
                                                    </h2>
                                                </div>

                                                <!-- Header com controles -->
                                                <div class="flex justify-between items-center mb-4">
                                                    <div class="flex items-center gap-4">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" id="selecionarTodosSegmentacoes"
                                                                class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-3"
                                                                :checked="selectedSegmentacoes.length === segmentacoesDisponiveis
                                                                    .length && segmentacoesDisponiveis.length > 0"
                                                                @change="toggleSelectAll($event.target.checked)">
                                                            <span>Selecionar todos</span>
                                                        </label>
                                                        <span class="text-xs opacity-50">Selecionados: <span
                                                                x-text="selectedSegmentacoes.length"></span></span>
                                                        <span class="text-xs opacity-50">Total: <span
                                                                x-text="segmentacoesDisponiveis.length"></span></span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <div class="flex items-center border-b border-b-black px-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 text-black ml-1" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <input id="searchSegmentacaoInput" type="text"
                                                                placeholder="Buscar"
                                                                class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cabeçalho da tabela -->
                                                <div class="py-1 px-4 grid grid-cols-12 gap-4 text-xs">
                                                    <div class="col-span-12">Segmentação</div>
                                                </div>

                                                <!-- Lista de segmentações -->
                                                <div class="flex-1 overflow-y-auto" id="segmentacoesList">
                                                    <table class="min-w-full bg-white" id="segmentacaoTable">
                                                        <tbody id="segmentacaoTableBody">
                                                            <template x-for="segmentacao in segmentacoesDisponiveis"
                                                                :key="segmentacao.id">
                                                                <tr class="segmentacao-row">
                                                                    <td class="py-[10px] px-4 text-sm">
                                                                        <label
                                                                            class="inline-flex items-center gap-1 cursor-pointer">
                                                                            <input type="checkbox"
                                                                                :checked="selectedSegmentacoes.includes(
                                                                                    segmentacao
                                                                                    .id)"
                                                                                @change="toggleSegmentacao(segmentacao.id)"
                                                                                class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-3">
                                                                            <span x-text="segmentacao.nome"
                                                                                class="text-sm text-gray-900"></span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <div class="pt-4 mt-4">
                                                    <div class="flex justify-center gap-4">
                                                        <button @click="showModal = false"
                                                            class="w-full bg-white text-black border border-black font-normal text-base py-3 px-4 rounded-full hover:bg-[#E7E7E7] transition-colors">
                                                            Salvar
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Footer com botões -->
                                                <div class="pt-4 mt-4">
                                                    <div class="flex justify-center gap-4">
                                                        <button @click="showModal = false" type="button"
                                                            class="flex items-center border border-black rounded-full px-6 py-3 text-sm hover:bg-gray-200 transition">
                                                            Voltar
                                                            <img src="/images/icon-voltar.png" alt=""
                                                                class="ml-2 w-4 h-4" />
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endif


                @if ($user)
                    @if (count($parts) != 4 && count($parts) != 5 && count($parts) != 6)
                        <a href="/user/conta" rel="noopener noreferrer" class="text-gray-700 font-normal pl-[20px]">
                            {{ $user->name ?? 'Usuário' }}
                        </a>
                        <a href="/user/conta" class="px-5" rel="noopener noreferrer">
                            <img src="/images/icones/user.svg" alt="User" />
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                            @csrf
                            <button
                                class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-150"
                                onclick="localStorage.removeItem('selectedSegmentacoes');">
                                <img src="/images/icones/logout.svg" alt="Logout" />
                            </button>
                        </form>
                    @else
                        <div class="pl-4">
                            <a href="{{ $backColecoesUrl ?? url()->previous() }}"
                                class="flex items-center border border-black rounded-full px-3 py-2 text-md bg-gray-100 hover:bg-gray-200 transition text-[14px]">
                                Voltar
                                <img src="/images/icon-voltar.png" alt="" class="px-1" />
                            </a>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="flex items-center space-x-2">
                        <i class="fa-regular fa-user text-gray-700 hover:text-blue-600 text-lg"></i>
                        <span class="text-gray-700 font-semibold hover:text-blue-600">Login</span>
                    </a>
                @endif
            </div>

            <div class="flex items-center lg:hidden">
                @if (\Illuminate\Support\Str::contains(request()->path(), 'colecoes'))
                    <a href="{{ $backColecoesUrl ?? url()->previous() }}"
                        class="flex items-center border border-black rounded-full px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 transition">
                        Voltar
                        <img src="/images/icon-voltar.png" alt="" class="px-1" />
                    </a>
                @else
                    <button @click="mobileOpen = !mobileOpen"
                        class="flex items-center justify-center w-10 h-10  text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                @endif
            </div>
        </header>

        <div x-show="mobileOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 lg:hidden" style="display: none;">
            <div class="absolute inset-0 bg-black bg-opacity-50" @click="mobileOpen = false"></div>
            <div class="absolute top-0 right-0 w-64 max-w-full h-full bg-white shadow-lg flex flex-col p-5">
                <div class="flex items-center justify-between mb-4">
                    <span class="font-semibold text-gray-800">Menu</span>
                    <button @click="mobileOpen = false"
                        class="p-2 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto space-y-4">

                    @if (isset($segmentacoes) && $segmentacoes->count())
                        @if ($currentSlug != 'segmentacao')
                            @foreach ($segmentacoes as $segmentacao)
                                @if ($currentSlug == $segmentacao->slug)
                                    <a href="{{ route('user.segmentacao') }}"
                                        class="block w-full bg-white text-black border border-black px-4 py-2 rounded-full text-sm text-center hover:bg-[#E7E7E7]">
                                        {{ $segmentacao->segmento }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endif
                    @if ($user)
                        @if ($currentSlug != 'segmentacao')
                            @if (count($parts) != 6)
                                @if ($user->segmentacoesCliente->count() != 1)
                                    <div x-data="{
                                        showModal: false,
                                        selectedSegmentacoes: [],
                                        segmentacoesDisponiveis: @js($user && $user->segmentacoesCliente->count() > 0 ? $user->segmentacoesCliente : \App\Models\SegmentacaoCliente::where('active', true)->get()),
                                        toggleSegmentacao(id) {
                                            const index = this.selectedSegmentacoes.indexOf(id);
                                            if (index > -1) {
                                                this.selectedSegmentacoes.splice(index, 1);
                                            } else {
                                                this.selectedSegmentacoes.push(id);
                                            }
                                            this.persistSelected();
                                        },
                                        toggleSelectAll(checked) {
                                            if (checked) {
                                                this.selectedSegmentacoes = this.segmentacoesDisponiveis.map(s => s.id);
                                            } else {
                                                this.selectedSegmentacoes = [];
                                            }
                                            this.persistSelected();
                                        },
                                        persistSelected() {
                                            try {
                                                localStorage.setItem('selectedSegmentacoes', JSON.stringify(this.selectedSegmentacoes));
                                            } catch (e) {}
                                        },
                                        init() {
                                            const saved = localStorage.getItem('selectedSegmentacoes');
                                            if (saved) {
                                                try {
                                                    this.selectedSegmentacoes = JSON.parse(saved);
                                                } catch (e) {
                                                    this.selectedSegmentacoes = [];
                                                }
                                            }
                                        }
                                    }">
                                        <button @click="showModal = true"
                                            class="flex items-center justify-between space-x-2 px-4 py-2 text-black rounded-full hover:opacity-80 transition-colors border border-black w-full">
                                            <div class="flex flex-row items-start">
                                                <span class="text-sm">Segmentos:</span>
                                                <div class="text-sm max-w-[160px] truncate px-[5px]">
                                                    <span class="text-[#7A7A7A]"
                                                        x-text="selectedSegmentacoes.length === 0 ? 'Todos' : selectedSegmentacoes.length === 1 ? '1 seleção' : selectedSegmentacoes.length + ' seleções'"></span>
                                                </div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                                class="ml-0 mr-0" viewBox="0 0 12 8" fill="none">
                                                <path d="M1.10938 1.5L6.05912 6.44975L11.0089 1.5" stroke="black"
                                                    stroke-width="1.5" stroke-linecap="round" />
                                            </svg>
                                        </button>

                                        <div x-show="showModal" x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            @click.away="showModal = false" @keydown.escape.window="showModal = false"
                                            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                            <div class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>
                                            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                                                <div
                                                    class="relative z-50 bg-white rounded-lg max-w-xl w-full mx-4 p-6 max-h-[60vh] overflow-hidden flex flex-col">
                                                    <div class="flex justify-center items-center mb-6">
                                                        <h2 class="text-2xl font-semibold text-gray-900">Selecionar
                                                            Segmentos</h2>
                                                    </div>
                                                    <div class="flex justify-between items-center mb-4">
                                                        <div class="flex items-center gap-4">
                                                            <label class="flex items-center">
                                                                <input type="checkbox"
                                                                    id="selecionarTodosSegmentacoesMobile"
                                                                    class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-3"
                                                                    :checked="selectedSegmentacoes.length ===
                                                                        segmentacoesDisponiveis.length &&
                                                                        segmentacoesDisponiveis.length > 0"
                                                                    @change="toggleSelectAll($event.target.checked)">
                                                                <span>Selecionar todos</span>
                                                            </label>
                                                            <span class="text-xs opacity-50">Selecionados: <span
                                                                    x-text="selectedSegmentacoes.length"></span></span>
                                                            <span class="text-xs opacity-50">Total: <span
                                                                    x-text="segmentacoesDisponiveis.length"></span></span>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <div
                                                                class="flex items-center border-b border-b-black px-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-4 w-4 text-black ml-1"
                                                                    viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <input id="searchSegmentacaoInputMobile"
                                                                    type="text" placeholder="Buscar"
                                                                    class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="py-1 px-4 grid grid-cols-12 gap-4 text-xs">
                                                        <div class="col-span-12">Segmentação</div>
                                                    </div>
                                                    <div class="flex-1 overflow-y-auto" id="segmentacoesListMobile">
                                                        <table class="min-w-full bg-white"
                                                            id="segmentacaoTableMobile">
                                                            <tbody id="segmentacaoTableBodyMobile">
                                                                <template
                                                                    x-for="segmentacao in segmentacoesDisponiveis"
                                                                    :key="segmentacao.id">
                                                                    <tr class="segmentacao-row-mobile">
                                                                        <td class="py-[10px] px-4 text-sm">
                                                                            <label
                                                                                class="inline-flex items-center gap-1 cursor-pointer">
                                                                                <input type="checkbox"
                                                                                    :checked="selectedSegmentacoes.includes(
                                                                                        segmentacao.id)"
                                                                                    @change="toggleSegmentacao(segmentacao.id)"
                                                                                    class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-3">
                                                                                <span x-text="segmentacao.nome"
                                                                                    class="text-sm text-gray-900"></span>
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                </template>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="pt-4 mt-4">
                                                        <div class="flex justify-center gap-4">
                                                            <button @click="showModal = false"
                                                                class="w-full bg-white text-black border border-black font-normal text-base py-3 px-4 rounded-full hover:bg-[#E7E7E7] transition-colors">
                                                                Salvar
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="pt-4 mt-4">
                                                        <div class="flex justify-center gap-4">
                                                            <button @click="showModal = false" type="button"
                                                                class="flex items-center border border-black rounded-full px-6 py-3 text-sm hover:bg-gray-200 transition">
                                                                Voltar
                                                                <img src="/images/icon-voltar.png" alt=""
                                                                    class="ml-2 w-4 h-4" />
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                    @endif


                    @if ($user)
                        @if (count($parts) != 4 && count($parts) != 5 && count($parts) != 6)
                            <a href="/user/conta"
                                class="flex items-center justify-between py-2 border-b border-gray-200 text-gray-700">
                                <span>{{ $user->name ?? 'Usuário' }}</span>
                                <img src="/images/icones/user.svg" alt="User" class="w-5 h-5" />
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                                @csrf
                                <button
                                    class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors duration-150"
                                    onclick="localStorage.removeItem('selectedSegmentacoes');">
                                    <img src="/images/icones/logout.svg" alt="Logout" class="w-4 h-4 mr-2" />
                                    <span>Sair</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ url()->previous() }}"
                                class="flex items-center border border-black rounded-full px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 transition">
                                Voltar
                                <img src="/images/icon-voltar.png" alt="" class="px-1" />
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center space-x-2 py-2 border-b border-gray-200">
                            <i class="fa-regular fa-user text-gray-700 text-lg"></i>
                            <span class="text-gray-700 font-semibold">Login</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@elseif ($type === 'produto')
@endif

<script>
    // Interceptar navegações para páginas de produtos e adicionar segmentações selecionadas
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded and parsed');
        // Filtro de busca para Segmentações no modal
        const searchInput = document.getElementById('searchSegmentacaoInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.segmentacao-row');
                rows.forEach(function(row) {
                    const nameCell = row.querySelector('td');
                    const text = nameCell ? nameCell.textContent.toLowerCase() : '';
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
        // Função para adicionar parâmetros de segmentação aos links de produtos
        function addSegmentacaoParams(url) {
            const selectedSegmentacoes = localStorage.getItem('selectedSegmentacoes');

            if (selectedSegmentacoes) {
                try {
                    const segmentacoes = JSON.parse(selectedSegmentacoes);
                    if (segmentacoes && segmentacoes.length > 0) {
                        const urlObj = new URL(url, window.location.origin);
                        segmentacoes.forEach((id, index) => {
                            //urlObj.searchParams.append(`selected_segmentacoes[${index}]`, id);
                        });
                        return urlObj.toString();
                    }
                } catch (e) {
                    console.error('Erro ao processar segmentações selecionadas:', e);
                }
            }
            return url;
        }

        // Interceptar cliques em links que levam para páginas de produtos
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href) {
                const href = link.getAttribute('href');
                // Verificar se é um link para página de produtos (contém padrão /user/slug/colecao)
                if (href && href.match(/\/user\/[^/]+\/[^/]+$/)) {
                    e.preventDefault();
                    const newUrl = addSegmentacaoParams(href);
                    window.location.href = newUrl;
                }
            }
        });

        // Interceptar submissões de formulários que redirecionam para produtos
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form && form.action) {
                const action = form.getAttribute('action');
                if (action && action.match(/\/user\/[^/]+\/[^/]+$/)) {
                    const selectedSegmentacoes = localStorage.getItem('selectedSegmentacoes');

                    if (selectedSegmentacoes) {
                        try {
                            const segmentacoes = JSON.parse(selectedSegmentacoes);
                            if (segmentacoes && segmentacoes.length > 0) {
                                // Adicionar campos hidden para as segmentações
                                segmentacoes.forEach((id, index) => {
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = `selected_segmentacoes[${index}]`;
                                    input.value = id;
                                    form.appendChild(input);
                                });
                            }
                        } catch (e) {
                            console.error('Erro ao processar segmentações selecionadas:', e);
                        }
                    }
                }
            }
        });
    });
</script>
