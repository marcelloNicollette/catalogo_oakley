<x-layout-user title="Olympikus - Segmentação">


    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Gerenciador de Segmentações Selecionadas</h1>

            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Status Atual</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600" id="total-count">0</div>
                        <div class="text-sm text-gray-600">Segmentações Selecionadas</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-green-600" id="localStorage-status">✓</div>
                        <div class="text-sm text-gray-600">LocalStorage Status</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600" id="backend-status">-</div>
                        <div class="text-sm text-gray-600">Backend Status</div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Ações</h2>
                <div class="flex flex-wrap gap-3">
                    <button id="btn-load-from-localStorage"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                        Carregar do LocalStorage
                    </button>
                    <button id="btn-send-to-backend"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                        Enviar para Backend
                    </button>
                    <button id="btn-clear-all"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                        Limpar Tudo
                    </button>
                    <button id="btn-refresh"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                        Atualizar
                    </button>
                </div>
            </div>

            <!-- LocalStorage Data -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Dados do LocalStorage</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <pre id="localStorage-data" class="text-sm text-gray-700 whitespace-pre-wrap">Carregando...</pre>
                </div>
            </div>

            <!-- Backend Response -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Resposta do Backend</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <pre id="backend-response" class="text-sm text-gray-700 whitespace-pre-wrap">Nenhuma requisição feita ainda...</pre>
                </div>
            </div>

            <!-- Segmentações Detalhadas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Segmentações Detalhadas</h2>
                <div id="segmentacoes-list" class="space-y-3">
                    <p class="text-gray-500">Nenhuma segmentação carregada...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>


    <script src="{{ asset('js/selected-segmentacoes.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const manager = new SelectedSegmentacoesManager();

            // Elementos DOM
            const totalCountEl = document.getElementById('total-count');
            const localStorageStatusEl = document.getElementById('localStorage-status');
            const backendStatusEl = document.getElementById('backend-status');
            const localStorageDataEl = document.getElementById('localStorage-data');
            const backendResponseEl = document.getElementById('backend-response');
            const segmentacoesListEl = document.getElementById('segmentacoes-list');
            const toastContainer = document.getElementById('toast-container');

            // Botões
            const btnLoadFromLocalStorage = document.getElementById('btn-load-from-localStorage');
            const btnSendToBackend = document.getElementById('btn-send-to-backend');
            const btnClearAll = document.getElementById('btn-clear-all');
            const btnRefresh = document.getElementById('btn-refresh');

            // Função para mostrar toast
            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                const bgColor = {
                    'success': 'bg-green-500',
                    'error': 'bg-red-500',
                    'warning': 'bg-yellow-500',
                    'info': 'bg-blue-500'
                } [type] || 'bg-blue-500';

                toast.className =
                    `${bgColor} text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
                toast.textContent = message;

                toastContainer.appendChild(toast);

                // Animar entrada
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);

                // Remover após 3 segundos
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        toastContainer.removeChild(toast);
                    }, 300);
                }, 3000);
            }

            // Função para atualizar status
            function updateStatus() {
                const data = manager.getFromLocalStorage();
                totalCountEl.textContent = data.length;
                localStorageStatusEl.textContent = data.length > 0 ? '✓' : '✗';
                localStorageDataEl.textContent = JSON.stringify(data, null, 2);
            }

            // Função para renderizar lista de segmentações
            function renderSegmentacoesList(segmentacoes = []) {
                if (segmentacoes.length === 0) {
                    segmentacoesListEl.innerHTML = '<p class="text-gray-500">Nenhuma segmentação encontrada...</p>';
                    return;
                }

                const html = segmentacoes.map(seg => `
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold text-gray-800">${seg.nome}</h3>
                        <p class="text-sm text-gray-600">ID: ${seg.id}</p>
                        ${seg.descricao ? `<p class="text-sm text-gray-500 mt-1">${seg.descricao}</p>` : ''}
                    </div>
                    <button onclick="removeSegmentacao(${seg.id})" class="text-red-500 hover:text-red-700 text-sm">
                        Remover
                    </button>
                </div>
            </div>
        `).join('');

                segmentacoesListEl.innerHTML = html;
            }

            // Função global para remover segmentação
            window.removeSegmentacao = function(id) {
                manager.removeSegmentacao(id);
                updateStatus();
                showToast(`Segmentação ${id} removida`, 'warning');
            };

            // Event listeners
            btnLoadFromLocalStorage.addEventListener('click', function() {
                updateStatus();
                showToast('Dados carregados do localStorage', 'success');
            });

            btnSendToBackend.addEventListener('click', async function() {
                btnSendToBackend.disabled = true;
                btnSendToBackend.textContent = 'Enviando...';

                try {
                    const response = await manager.sendToBackend();
                    backendResponseEl.textContent = JSON.stringify(response, null, 2);

                    if (response.success) {
                        backendStatusEl.textContent = '✓';
                        renderSegmentacoesList(response.data.segmentacoes);
                        showToast('Dados enviados com sucesso!', 'success');
                    } else {
                        backendStatusEl.textContent = '✗';
                        showToast(response.message || 'Erro ao enviar dados', 'error');
                    }
                } catch (error) {
                    backendStatusEl.textContent = '✗';
                    showToast('Erro na comunicação com o servidor', 'error');
                } finally {
                    btnSendToBackend.disabled = false;
                    btnSendToBackend.textContent = 'Enviar para Backend';
                }
            });

            btnClearAll.addEventListener('click', function() {
                if (confirm('Tem certeza que deseja limpar todas as segmentações?')) {
                    manager.clearAll();
                    updateStatus();
                    renderSegmentacoesList([]);
                    backendResponseEl.textContent = 'Dados limpos...';
                    backendStatusEl.textContent = '-';
                    showToast('Todas as segmentações foram removidas', 'warning');
                }
            });

            btnRefresh.addEventListener('click', function() {
                updateStatus();
                showToast('Página atualizada', 'info');
            });

            // Inicializar
            updateStatus();
        });
    </script>

</x-layout-user>
