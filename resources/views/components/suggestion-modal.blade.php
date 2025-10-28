<!-- Modal de Sugestão -->
<div id="suggestionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg max-w-xl w-full mx-4 p-10">
        <!-- Tela 1: Formulário de Sugestão -->
        <div id="suggestionForm" class="space-y-6">
            <h2 class="text-xl font-medium text-center text-black">
                Sugestão de Atualização/Correção
            </h2>

            <div>
                <label for="suggestionText" class="block text-[16px] font-normal text-black mb-2">Descrição</label>
                <div class="border-b border-gray-300 pb-2">
                    <input type="text" name="suggestionText" id="suggestionText"
                        class="w-full resize-none border-none outline-none text-gray-700 placeholder-gray-400" />
                </div>
            </div>

            <button id="sendSuggestion"
                class="w-full bg-black  text-white font-normal py-3 px-4 rounded-full transition-colors text-base">
                Enviar sugestão
            </button>

            <div class="flex justify-center">
                <button
                    class="flex items-center border border-black rounded-full px-5 py-2 text-md bg-white transition text-[14px]"
                    id="closeSuggestionModal">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="px-1" />
                </button>
            </div>

            <div class="text-center text-xs text-gray-600">
                <p>
                    Precisa de ajuda? Envie um e-mail para
                    <a href="mailto:estudio@vulcabras.com" class="text-gray-600 underline">estudio@vulcabras.com</a>
                </p>
            </div>
        </div>

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
                    <a href="mailto:estudio@vulcabras.com" class="text-gray-600 underline">estudio@vulcabras.com</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const suggestionModal = document.getElementById('suggestionModal');
        const suggestionForm = document.getElementById('suggestionForm');
        const suggestionSuccess = document.getElementById('suggestionSuccess');
        const suggestionText = document.getElementById('suggestionText');
        const sendSuggestionBtn = document.getElementById('sendSuggestion');
        const closeSuggestionModal = document.getElementById('closeSuggestionModal');
        const closeSuccessModal = document.getElementById('closeSuccessModal');

        // Função para fechar o modal
        function closeModal() {
            suggestionModal.classList.add('hidden');
            suggestionForm.classList.remove('hidden');
            suggestionSuccess.classList.add('hidden');
            suggestionText.value = '';
            sendSuggestionBtn.disabled = false;
            sendSuggestionBtn.textContent = 'Enviar sugestão';
        }

        // Event listeners para fechar modal
        closeSuggestionModal.addEventListener('click', closeModal);
        closeSuccessModal.addEventListener('click', closeModal);

        // Fechar modal clicando fora dele
        suggestionModal.addEventListener('click', function(e) {
            if (e.target === suggestionModal) {
                closeModal();
            }
        });

        // Enviar sugestão
        sendSuggestionBtn.addEventListener('click', function() {
            const suggestionTextValue = suggestionText.value.trim();

            // Validação básica
            if (suggestionTextValue.length < 10) {
                alert('A descrição deve ter pelo menos 10 caracteres.');
                return;
            }

            if (suggestionTextValue.length > 1000) {
                alert('A descrição não pode ter mais de 1000 caracteres.');
                return;
            }

            // Desabilitar botão e mostrar loading
            sendSuggestionBtn.disabled = true;
            sendSuggestionBtn.textContent = 'Enviando...';

            // Preparar dados para envio
            const formData = new FormData();
            formData.append('suggestion_text', suggestionTextValue);
            formData.append('current_url', window.location.href);

            // Verificar se a meta tag CSRF existe
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                formData.append('_token', csrfToken.getAttribute('content'));
            } else {
                alert(
                    'Erro de segurança: Token CSRF não encontrado. Recarregue a página e tente novamente.'
                    );
                sendSuggestionBtn.disabled = false;
                sendSuggestionBtn.textContent = 'Enviar sugestão';
                return;
            }

            // Enviar via fetch
            fetch('{{ route('suggestions.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar tela de sucesso
                        suggestionForm.classList.add('hidden');
                        suggestionSuccess.classList.remove('hidden');
                    } else {
                        // Mostrar erro
                        alert(data.message || 'Erro ao enviar sugestão. Tente novamente.');
                        sendSuggestionBtn.disabled = false;
                        sendSuggestionBtn.textContent = 'Enviar sugestão';
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao enviar sugestão. Verifique sua conexão e tente novamente.');
                    sendSuggestionBtn.disabled = false;
                    sendSuggestionBtn.textContent = 'Enviar sugestão';
                });
        });
    });
</script>
