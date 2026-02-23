<!-- Modal de Sugestão -->
<div id="passwordRecoveryModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 {{ $errors->has('email_recover') || session('password_recovery_status') == 'link-sent' ? '' : 'hidden' }}">
    <style>
        .btn-bg-black-white {
            background-color: #FFF;
            color: #000;
        }

        .btn-bg-black-white:hover {
            background-color: #000;
            color: #FFF;
        }

        .input-email-password,
        .input-email-password:focus {
            border: 0;
            border-bottom: 1px solid #000;
            --tw-ring-color: transparent;
            --tw-ring-shadow: transparent;
            padding: 0;
        }

        input[name="email_recover"]:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 1) inset !important;
            -webkit-text-fill-color: black !important;
            border-bottom: 1px solid black;
        }
    </style>
    <div class="bg-white rounded-lg w-[630px] mx-4 px-[4rem] lg:px-[8rem] py-[3rem]">
        <!-- Tela 1: Formulário de Sugestão -->
        <div id="suggestionForm"
            class="space-y-6 {{ session('password_recovery_status') == 'link-sent' ? 'hidden' : '' }}">
            <form action="{{ route('password.recovery') }}" method="POST" class="space-y-6">
                @csrf
                <h2 class="text-xl text-center text-black">
                    Recuperar senha
                </h2>

                <div>
                    <label class="block text-black text-base">E-mail</label>
                    <input type="email" name="email_recover" id="email_recover" class="w-full input-email-password"
                        value="{{ old('email_recover') }}">
                </div>
                @error('email_recover')
                    <p class="text-[#FC0] text-sm">{{ $message }}</p>
                @enderror

                <button type="submit" id="sendSuggestion"
                    class="w-full btn-bg-black-white border border-black font-normal py-3 px-4 rounded-full transition-colors">
                    Solicitar recuperação de senha
                </button>
            </form>

            <div class="flex justify-center">
                <button onclick="closePasswordRecoveryModal()" type="button"
                    class="flex items-center border border-black rounded-full px-4 py-2 bg-white hover:bg-gray-200 transition text-[14px]"
                    id="closeSuggestionModal">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="px-1" />
                </button>
            </div>


        </div>

        <!-- Tela 2: Confirmação de Envio -->
        <div id="suggestionSuccess"
            class="space-y-6 {{ session('password_recovery_status') == 'link-sent' ? '' : 'hidden' }}">
            <h2 class="text-xl font-semibold text-center text-gray-900">
                Solicitação de recuperação enviado!
            </h2>

            <p class="text-center text-gray-600">
                Assim que processada será enviado para o e-mail cadastrado.
            </p>

            <div class="flex justify-center">
                <button onclick="closePasswordRecoveryModal()" type="button"
                    class="flex items-center border border-black rounded-full px-3 py-2 text-md bg-white hover:bg-gray-200 transition text-[14px]"
                    id="closeSuccessModal">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="px-1" />
                </button>
            </div>


        </div>
    </div>
</div>
