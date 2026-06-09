<x-layout-user-produto title="Oakley - Produto">


    @php

        $currentUrl = request()->path();
        $currentSlug = '';

        if (strpos($currentUrl, 'user') === 0) {
            $parts = explode('/', $currentUrl);
            //dd($parts);
            if (count($parts) > 1) {
                $currentSlug = $parts[1];
            }
        }

    @endphp


    <div class="bg-white w-full flex justify-center items-center mt-20 h-full">
        <!-- Tela 1: Formulário de Sugestão -->
        <form method="POST" action="{{ route('user.conta.update', $user->id) }}" id="suggestionForm"
            class="space-y-6 w-[540px] h-[90vh] mt-10">
            @csrf

            <input type="hidden" name="id" value="{{ $user->id }}">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @if (session('language_changed'))
                    <script>
                        // Aguardar um momento para a mensagem ser vista
                        setTimeout(function() {
                            console.log('🔄 Recarregando página após mudança de idioma...');
                            window.location.reload();
                        }, 1500);
                    </script>
                @endif
            @endif
            @if ($errors->any())
                <div class="space-y-2">
                    @foreach ($errors->all() as $error)
                        <div class="text-red-500 text-sm">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif
            <div>
                <label for="name" class="block text-[16px] font-normal text-black mb-2">Nome</label>
                <div class="border-b border-gray-300 pb-2">
                    <input type="text" name="name" id="name"
                        class="w-full resize-none border-none outline-none text-gray-700 placeholder-gray-400"
                        value="{{ $user->name }}" />
                </div>
            </div>

            <div>
                <label for="email" class="block text-[16px] font-normal text-black mb-2">E-mail</label>
                <div class="border-b border-gray-300 pb-2">
                    <input type="text" name="email" id="email"
                        class="w-full resize-none border-none outline-none text-gray-700 placeholder-gray-400" disabled
                        value="{{ $user->email }}" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="company" class="block text-[16px] font-normal text-black mb-2">Empresa</label>
                    <div class="border-b border-gray-300 pb-2">
                        <input type="text" name="company" id="company"
                            class="w-full resize-none border-none outline-none text-gray-700 placeholder-gray-400"
                            value="{{ $user->company ?? '' }}" />
                    </div>
                </div>
                <div>
                    <label for="setor" class="block text-[16px] font-normal text-black mb-2">Setor</label>
                    <div class="border-b border-gray-300 pb-2">
                        <input type="text" name="setor" id="setor"
                            class="w-full resize-none border-none outline-none text-gray-700 placeholder-gray-400"
                            value="{{ $user->setor ?? '' }}" />
                    </div>
                </div>
            </div>

            <div>
                <label for="phone" class="block text-[16px] font-normal text-black mb-2">Telefone</label>
                <div class="border-b border-gray-300 pb-2">
                    <input type="text" name="phone" id="phone"
                        class="w-full resize-none border-none outline-none text-gray-700 placeholder-gray-400"
                        value="{{ $user->phone ?? '' }}" />
                </div>
            </div>


            <div>
                <label for="password" class="block text-[16px] font-normal text-black mb-2">Nova senha</label>
                <div class="border-b border-gray-300 pb-2">
                    <input type="password" name="password" id="password"
                        class="w-full resize-none border-none outline-none text-gray-700 placeholder-gray-400"
                        placeholder="Digite a nova senha (opcional)" />
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-[16px] font-normal text-black mb-2">Confirmar
                    senha</label>
                <div class="border-b border-gray-300 pb-2">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full resize-none border-none outline-none text-gray-700 placeholder-gray-400"
                        placeholder="Confirme a nova senha" />
                </div>
            </div>

            <div>
                <label for="idioma" class="block text-[16px] font-normal text-black mb-2">Idioma</label>
                <div class="pb-2">
                    <input {{ ($user->idioma ?? 'pt') === 'pt' ? 'checked' : '' }} type="radio" name="idioma"
                        id="idioma_pt" value="pt" class="ml-2" onchange="previewLanguageChange('pt')" />
                    Português

                    <input {{ ($user->idioma ?? 'pt') === 'en' ? 'checked' : '' }} type="radio" name="idioma"
                        id="idioma_en" value="en" class="ml-3" onchange="previewLanguageChange('en')" />
                    Inglês

                    <input {{ ($user->idioma ?? 'pt') === 'es' ? 'checked' : '' }} type="radio" name="idioma"
                        id="idioma_es" value="es" class="ml-3" onchange="previewLanguageChange('es')" />
                    Espanhol
                </div>
            </div>

            <script>
                function previewLanguageChange(lang) {
                    // Mapear esp para es (código do Google)
                    const googleLang = lang;

                    // Armazenar no localStorage para sincronizar com outras abas
                    localStorage.setItem('userLanguageChanged', googleLang);

                    console.log('🔄 Idioma selecionado:', lang, '(Google:', googleLang + ')');
                }
            </script>

            <button id="sendSuggestion"
                class="w-full bg-white hover:bg-[#E7E7E7] text-black border border-black font-normal py-3 px-4 rounded-full transition-colors text-base">
                Editar dados
            </button>



            <div class="text-center text-xs text-gray-600">
                <p>
                    Precisa de ajuda? Envie um e-mail para
                    <a href="mailto:falecomaoakley@br.luxottica.com" class="text-gray-600 underline">falecomaoakley@br.luxottica.com</a>
                </p>
            </div>
        </form>

        <!-- Tela 2: Confirmação de Envio -->
        <div id="suggestionSuccess" class="space-y-6 hidden">
            <h2 class="text-xl font-semibold text-center text-gray-900">
                Sugestão enviada!
            </h2>

            <p class="text-center text-gray-600">
                Sua sugestão será revisada e ajustada assim que possível.
            </p>

            <div class="flex justify-center">
                <button
                    class="flex items-center border border-black rounded-full px-3 py-2 text-md bg-gray-100 hover:bg-gray-200 transition text-[14px]"
                    id="closeSuccessModal">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="px-1" />
                </button>
            </div>

            <div class="text-center text-xs text-gray-600">
                <p>
                    Precisa de ajuda? Envie um e-mail para
                    <a href="mailto:falecomaoakley@br.luxottica.com" class="text-gray-600 underline">falecomaoakley@br.luxottica.com</a>
                </p>
            </div>
        </div>
    </div>


    @push('scripts')
    @endpush

</x-layout-user-produto>
