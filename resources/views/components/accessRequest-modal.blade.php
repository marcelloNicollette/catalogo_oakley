<!-- Modal de Sugestão -->
<div id="accessRequestModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <style>
        .btn-bg-black-white {
            background-color: #FFF;
            color: #000;
        }

        .btn-bg-black-white:hover {
            background-color: #000;
            color: #FFF;
        }

        .input,
        .input:focus {
            border: 0;
            border-bottom: 1px solid #000;
            --tw-ring-color: transparent;
            --tw-ring-shadow: transparent;
            padding: 0;
        }
    </style>
    <div class="bg-white rounded-lg w-[630px] mx-4 px-[4rem] lg:px-[4rem] py-[3rem]">
        <!-- Tela 1: Formulário de Sugestão -->
        <div id="suggestionForm" class="space-y-6">
            <h2 class="text-xl text-center text-black">
                Solicitar Acesso
            </h2>

            <form class="space-y-8">
                <div>
                    <label class="block text-gray-700 text-base">Nome</label>
                    <input name="name" id="name" type="text"
                        class="w-full border-b-2 border-gray-300 py-4 px-0 bg-transparent focus:outline-none focus:border-gray-900 transition input">
                    @error('name')
                        <p class="text-[#FF0000] text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="block text-gray-700 text-base">E-mail</label>
                    <input name="email" id="email" type="email"
                        class="w-full border-b-2 border-gray-300 py-4 px-0 bg-transparent focus:outline-none focus:border-gray-900 transition input">
                    @error('email')
                        <p class="text-[#FF0000] text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-6">
                    <div class="flex-1">
                        <label class="block text-gray-700 text-base">Empresa</label>
                        <input name="company" id="company" type="text"
                            class="w-full border-b-2 border-gray-300 py-4 px-0 bg-transparent focus:outline-none focus:border-gray-900 transition input">
                        @error('company')
                            <p class="text-[#FF0000] text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 text-base">Setor</label>
                        <input name="setor" id="setor" type="text"
                            class="w-full border-b-2 border-gray-300 py-4 px-0 bg-transparent focus:outline-none focus:border-gray-900 transition input">
                        @error('setor')
                            <p class="text-[#FF0000] text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-base">Telefone</label>
                    <input name="phone" id="phone" type="tel"
                        class="w-full border-b-2 border-gray-300 py-4 px-0 bg-transparent focus:outline-none focus:border-gray-900 transition input">
                    @error('phone')
                        <p class="text-[#FF0000] text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 justify-items-center">
                    <button type="submit"
                        class="w-full bg-gray-900 text-white py-4 rounded-full hover:bg-gray-800 transition font-normal text-lg mb-4">
                        Enviar solicitação
                    </button>

                    <button onclick="closeAccessRequestModal()"
                        class="flex items-center border border-black rounded-full px-4 py-2 bg-white hover:bg-gray-200 transition text-[14px]  text-center"
                        id="closeSuggestionModal">
                        Voltar
                        <img src="/images/icon-voltar.png" alt="" class="px-1" />
                    </button>
                </div>
            </form>

            <div class="text-center text-xs text-gray-600 mt-8">
                Precisa de ajuda? Envie um e-mail para <a href="mailto:estudio@vulcabras.com"
                    class="text-blue-600 underline">estudio@vulcabras.com</a>
            </div>

        </div>

        <!-- Tela 2: Confirmação de Envio -->
        <div id="suggestionSuccess" class="space-y-6 hidden">
            <h2 class="text-xl font-semibold text-center text-gray-900">
                Link de recuperação enviado!
            </h2>

            <p class="text-center text-gray-600">
                Um link de recuperação foi enviado para o e-mail cadastrado.
            </p>

            <div class="flex justify-center">
                <button onclick="closeAccessRequestModal()"
                    class="flex items-center border border-black rounded-full px-3 py-2 text-md bg-white hover:bg-gray-200 transition text-[14px]"
                    id="closeSuccessModal">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="px-1" />
                </button>
            </div>


        </div>
    </div>
</div>
