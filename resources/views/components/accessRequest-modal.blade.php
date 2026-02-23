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

        input[id="email"]:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px rgba(255, 255, 255, 1) inset !important;
            -webkit-text-fill-color: black !important;
            border-bottom: 1px solid black;
        }
    </style>
    <div class="bg-white rounded-lg w-[630px] mx-4 px-[4rem] lg:px-[4rem] py-[3rem]">
        <!-- Tela 1: Formulário de Sugestão -->
        <div id="accessForm" class="space-y-6">
            <h2 class="text-xl text-center text-black">
                Solicitar Acesso
            </h2>

            <form class="space-y-8" method="POST" action="{{ route('access-requests.store') }}">
                @csrf
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
        <div id="solicitacaoSuccess" class="space-y-6 hidden">
            <h2 class="text-xl font-semibold text-center text-gray-900">
                Solicitação enviada!
            </h2>

            <p class="text-center text-gray-600">
                Recebemos sua solicitação de acesso. Em breve entraremos em contato pelo e-mail informado.
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('accessRequestModal');
                const formWrapper = document.getElementById('accessForm');
                const successWrapper = document.getElementById('solicitacaoSuccess');
                const closeSuccessBtn = document.getElementById('closeSuccessModal');

                const form = modal.querySelector('form');
                const submitBtn = form.querySelector('button[type="submit"]');

                function setFieldError(fieldName, message) {
                    const input = form.querySelector(`[name="${fieldName}"]`);
                    if (!input) return;
                    input.classList.add('border-red-500');
                    let err = input.nextElementSibling;
                    if (!err || !(err.classList.contains('text-[#FF0000]') || err.classList.contains('field-error'))) {
                        err = document.createElement('p');
                        err.className = 'field-error text-[#FF0000] text-sm mt-2';
                        input.insertAdjacentElement('afterend', err);
                    }
                    err.textContent = message;
                }

                function clearErrors() {
                    // Limpa mensagens de erro sem depender de seletor com caracteres especiais
                    Array.from(form.querySelectorAll('p')).forEach(el => {
                        if (el.classList.contains('text-[#FF0000]')) {
                            el.textContent = '';
                        }
                        if (el.classList.contains('field-error')) {
                            // Remove elementos de erro criados via JS para evitar acúmulo
                            el.remove();
                        }
                    });
                    form.querySelectorAll('input').forEach(el => el.classList.remove('border-red-500'));
                }

                function resetFormInputs() {
                    form.querySelectorAll('input').forEach(el => {
                        if (el.type === 'text' || el.type === 'email' || el.type === 'tel') {
                            el.value = '';
                        }
                    });
                }

                function showSuccessOnly() {

                    // Esconde o formulário e mostra somente a mensagem de sucesso
                    document.getElementById('accessForm').classList.add('hidden');
                    successWrapper.classList.remove('hidden');
                    formWrapper.style.display = 'none';
                    successWrapper.style.display = 'block';
                }

                function showFormInitial() {
                    // Restaura a visualização do formulário para próxima abertura do modal
                    clearErrors();
                    resetFormInputs();
                    successWrapper.classList.add('hidden');
                    formWrapper.classList.remove('hidden');
                    successWrapper.style.display = 'none';
                    formWrapper.style.display = 'block';
                }

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    clearErrors();

                    const payload = {
                        name: form.querySelector('[name="name"]').value.trim(),
                        email: form.querySelector('[name="email"]').value.trim(),
                        company: form.querySelector('[name="company"]').value.trim(),
                        setor: form.querySelector('[name="setor"]').value.trim(),
                        phone: form.querySelector('[name="phone"]').value.trim(),
                    };

                    // CSRF: tenta primeiro o input oculto do form e depois a meta tag
                    const csrfInput = form.querySelector('input[name="_token"]');
                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    const csrf = (csrfInput && csrfInput.value) || (csrfMeta && csrfMeta.getAttribute(
                        'content')) || '';
                    if (!csrf) {
                        alert('Erro de segurança: CSRF token ausente.');
                        return;
                    }

                    submitBtn.disabled = true;
                    const originalText = submitBtn.textContent;
                    submitBtn.textContent = 'Enviando...';

                    fetch('{{ route('access-requests.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: JSON.stringify(payload),
                        })
                        .then(async (response) => {
                            let data;
                            try {
                                data = await response.json();
                            } catch (_) {
                                data = null;
                            }
                            if (response.ok) {
                                // Mostrar sucesso no próprio modal
                                clearErrors();
                                resetFormInputs();
                                showSuccessOnly();
                            } else if (response.status === 422 && data && data.errors) {
                                // Erros de validação
                                Object.entries(data.errors).forEach(([field, messages]) => {
                                    setFieldError(field, Array.isArray(messages) ? messages[0] :
                                        String(messages));
                                });
                            } else {
                                alert(data?.message || 'Erro ao enviar solicitação. Tente novamente.');
                            }
                        })
                        .catch((err) => {
                            alert('Falha na conexão. Verifique sua internet e tente novamente.');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                        });
                });

                // Ao fechar pela tela de sucesso, restaura a visualização inicial para próxima abertura
                if (closeSuccessBtn) {
                    closeSuccessBtn.addEventListener('click', function() {
                        showFormInitial();
                    });
                }
            });
        </script>
    </div>
</div>
