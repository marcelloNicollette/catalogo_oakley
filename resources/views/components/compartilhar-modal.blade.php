<!-- Modal de Histórico -->
<style>
    /* Radio Button */
    .radio-custom {
        appearance: none;
        -webkit-appearance: none;
    }

    .radio-custom:checked::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        background-color: #1f2937;
        border-radius: 50%;
    }
</style>
<div id="compartilharModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg max-w-xl w-full p-7">
        <form action="{{ route('shared.collection.generate') }}" method="POST">
            @csrf
            <input type="hidden" name="collection_id" id="collectionId">

            <!-- Tela 1: Formulário de Histórico -->
            <div id="historyForm" class="space-y-6">
                <p class="text-center">Compartilhar</p>
                <h2 class="text-xl font-medium text-center text-black" style="margin-top: 0px !important;"
                    id="collectionHistoryNameText">
                    1S25 Exclusivo Sapatarias
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-normal text-black mb-2">Nome da lista</label>
                        <input id="collectionHistoryName" name="collectionHistoryName" type="text" value=""
                            class="w-full font-normal text-base border-b border-black pb-2 outline-none" />
                    </div>

                    <div class="hidden">
                        <label class="block text-xs font-normal text-black mb-2">Categorias</label>
                        <div id="categorias-container" class="flex flex-wrap gap-3">
                            <label class="inline-flex items-center">
                                <input type="radio" name="categoria" class="form-radio" value="todas" checked>
                                <span class="ml-2 text-base">Todas</span>
                            </label>
                            <!-- Categorias dinâmicas serão inseridas aqui via JavaScript -->
                        </div>
                    </div>

                    <div class="flex gap-5">
                        <div class="flex-1">
                            <label class="block text-xs font-normal text-black mb-2">Segmentos</label>
                            <div class="flex flex-col gap-2">
                                <label class="inline-flex items-center w-full">
                                    <button type="button" name="segmentos" id="btnSelecaoSegmentos"
                                        class="w-full flex items-center justify-center space-x-2 px-3 py-[6px] bg-white text-black rounded-full hover:opacity-80 transition-colors border border-black">
                                        <span id="spanSelecionarSegmentos" class="text-base">Selecionar segmentos</span>
                                        <span id="btnContadorSegmentos"
                                            class="text-[14px] text-black opacity-50 underline ml-2"></span>
                                    </button>
                                    <input type="hidden" name="segmentos" id="segmentosSelecaoHidden" value="todos">
                                </label>
                            </div>
                        </div>

                        <div class="flex-1">
                            <label class="block text-xs font-normal text-black mb-2">Produtos</label>
                            <div class="flex flex-col gap-2">
                                <label class="inline-flex items-center w-full">
                                    <button type="button" name="produtos" id="btnSelecaoProdutos" disabled
                                        class="w-full flex items-center justify-center space-x-2 px-3 py-[6px] bg-white text-black rounded-full hover:opacity-80 transition-colors border border-black opacity-50 cursor-not-allowed">
                                        <span id="spanSelecionarProdutos" class="text-base">Selecionar produtos</span>
                                        <span id="btnContadorSelecionados"
                                            class="text-[14px] text-black opacity-50 underline ml-2"></span>
                                    </button>
                                    <input type="hidden" name="produtos" id="produtosSelecaoHidden" value="todos">
                                </label>
                            </div>
                        </div>
                    </div>


                    <div>
                        <label class="block  text-xs font-normal text-black mb-2">Opções</label>
                        <div class="flex flex-wrap gap-3">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="opcoes[]"
                                    class="form-checkbox w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative"
                                    value="ocultar_preco">
                                <span class="ml-2 text-sm">Ocultar Preço</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button id="sendHistory"
                    class="w-full bg-black text-white font-normal text-base py-3 px-4 rounded-full transition-colors">
                    Gerar Link
                </button>

                <div class="flex justify-center">

                    <button type="button" id="closeHistoryModal"
                        class="flex items-center border border-black rounded-full px-6 py-3 text-sm transition">
                        Voltar
                        <img src="/images/icon-voltar.png" alt="" class="ml-2 w-4 h-4" />
                    </button>
                </div>

                <!--<div class="text-center text-xs text-gray-600">
                    <p>
                        Precisa de ajuda? Envie um e-mail para
                        <a href="mailto:estudio@vulcabras.com" class="text-gray-600 underline">estudio@vulcabras.com</a>
                    </p>
                </div>-->
            </div>

            <!-- Tela 2: Confirmação de Envio -->
            <div id="historySuccess" class="hidden">
                <h2 class="text-xl font-semibold text-center text-gray-900 pb-[16px]">
                    Link gerado com sucesso!
                </h2>
                <h3 class="text-[16px] text-center text-black" id="generatedNameText"></h3>

                <div class="flex flex-col items-center gap-4 w-full">

                    <a id="generatedLink" href="http://"
                        class="w-full text-center p-2 rounded text-sm text-black opacity-50" target="_blank"
                        rel="noopener noreferrer"></a>
                    <div class="w-full justify-center">
                        <button type="button" id="copyLinkBtn"
                            class="w-full bg-black text-white font-normal text-base py-3 px-4 rounded-full transition-colors">
                            Copiar Link
                        </button>
                        <a id="openLinkBtn" href="#" target="_blank"
                            class="w-full border border-black text-black px-4 py-3 rounded-full text-base hover:bg-gray-50 transition flex items-center mt-3 text-center justify-center">
                            Abrir Link
                        </a>
                    </div>
                </div>

                <div class="flex justify-center pt-4">
                    <button type="button"
                        class="flex items-center border border-black rounded-full px-6 py-3 text-sm transition"
                        id="closeSuccessModal">
                        Voltar
                        <img src="/images/icon-voltar.png" alt="" class="ml-2 w-4 h-4" />
                    </button>
                </div>

                <div id="alertLinkGerado" class="hidden text-center text-[16px] text-black pt-10">
                    <p>Link copiado! <span class="opacity-50" id="spanLinkVisualizar">Para visualizar, é necessário
                            estar logado na plataforma.</span>

                    </p>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Seleção de Segmentos -->
<div id="selecaoSegmentosModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-60 hidden">
    <div class="bg-white rounded-lg max-w-xl w-full mx-4 p-6 max-h-[80vh] overflow-hidden flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Selecionar Segmentos</h2>

        </div>

        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-4">
                <label class="flex items-center">
                    <input type="checkbox" id="selecionarTodosSegmentos"
                        class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-3">
                    <span>Selecionar todos</span>
                </label>
                <span class="text-xs opacity-50">Selecionados: <span
                        id="contadorSegmentosSelecionados">0</span></span>
                <span class="text-xs opacity-50">Total: <span id="totalSegmentos">0</span></span>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex items-center border-b border-b-black px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                            clip-rule="evenodd" />
                    </svg>
                    <input id="buscarSegmento" type="text" placeholder="Buscar"
                        class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
                </div>
            </div>
        </div>

        <div class="py-1 px-4 grid grid-cols-12 gap-4 text-xs">
            <div class="col-span-12">Segmentação</div>
        </div>

        <div class="flex-1 overflow-y-auto" id="segmentosList"></div>

        <div class="flex flex-col justify-end items-center mt-4 gap-3">


            <button id="salvarSelecaoSegmentos"
                class="bg-black text-white px-8 py-3 rounded-full transition-colors w-full font-normal">Salvar
                Seleção</button>

            <button id="cancelarSelecaoSegmentos"
                class="flex items-center border border-black rounded-full px-6 py-3 text-sm transition">Voltar
                <img src="/images/icon-voltar.png" alt="" class="ml-2 w-4 h-4" /></button>

        </div>
    </div>
    @php
        $segmentosUsuario =
            auth()->user() && auth()->user()->segmentacoesCliente->count() > 0
                ? auth()->user()->segmentacoesCliente
                : \App\Models\SegmentacaoCliente::where('active', true)->get();
    @endphp
</div>

<!-- Modal de Seleção de Produtos -->
<div id="selecaoProdutosModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-60 hidden">
    <div class="bg-white rounded-lg max-w-4xl w-full mx-4 p-6 max-h-[90vh] overflow-hidden flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Seleção</h2>

        </div>

        <!-- Header com controles -->
        <div class="flex justify-between items-baseline mb-4">
            <div class="flex flex-col items-center gap-4 text-base items-baseline">
                <!-- Categorias dos produtos (checkboxes) -->
                <div id="categoriasSelecionaveis" class="flex items-center gap-2 flex-wrap ml-4">

                    <label class="flex items-center">
                        <input type="checkbox" id="selecionarTodos" name="selecao_tipo"
                            class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-3">
                        <span>Todos</span>
                    </label>

                </div>

                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <span class="text-xs opacity-50">Selecionados: <span id="contadorSelecionados">0</span></span>
                    <span class="text-xs opacity-50">Total: <span id="totalProdutos">0</span></span>
                </div>
            </div>
            <div class="flex items-center border-b border-b-black px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black ml-1" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                        clip-rule="evenodd" />
                </svg>
                <input id="buscarProduto" type="text" placeholder="Buscar"
                    class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
            </div>

        </div>

        <!-- Cabeçalho da tabela -->
        <div class="py-1 px-4 grid grid-cols-12 gap-4 text-xs">
            <div class="col-span-1">Incluir</div>
            <div class="col-span-2">Código</div>
            <div class="col-span-3">Nome</div>
            <div class="col-span-2">Cor</div>
            <div class="col-span-2">Categoria</div>
            <div class="col-span-2">Preço</div>
        </div>

        <!-- Lista de produtos -->
        <div id="produtosList" class="flex-1 overflow-y-auto">
            <!-- Produtos serão carregados aqui via JavaScript -->
        </div>

        <!-- Footer com botões -->
        <div class="pt-4 mt-4">
            <div class="flex justify-center gap-4 mb-3">
                <button type="button" id="salvarSelecao"
                    class="bg-black text-white px-8 py-3 rounded-full transition-colors w-full font-normal">
                    Salvar
                </button>
            </div>
            <div class="flex justify-center gap-4">
                <button type="button" id="closeSelecaoProdutosModal"
                    class="flex items-center border border-black rounded-full px-6 py-3 text-sm transition">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="ml-2 w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Função para renderizar categorias baseadas na segmentação
    // A constante 'categorias' é definida no arquivo gerar-arquivo.blade.php
    function renderizarCategorias(segmentacaoId) {
        const container = document.getElementById('categorias-container');

        // Limpar categorias existentes (exceto "Todas")
        const categoriasExistentes = container.querySelectorAll('label:not(:first-child)');
        categoriasExistentes.forEach(label => label.remove());

        // Filtrar categorias pela segmentação
        const categoriasFiltradas = categorias.filter(categoria => {
            return categoria.segmento_id == segmentacaoId;
        });

        // Adicionar categorias filtradas
        categoriasFiltradas.forEach(categoria => {
            const label = document.createElement('label');
            label.className = 'inline-flex items-center';

            const input = document.createElement('input');
            input.type = 'radio';
            input.name = 'categoria';
            input.className = 'form-radio';
            input.value = categoria.slug || categoria.name.toLowerCase();

            const span = document.createElement('span');
            span.className = 'ml-2';
            span.textContent = categoria.name;

            label.appendChild(input);
            label.appendChild(span);
            container.appendChild(label);
        });
    }

    // Função para reabilitar o botão sendHistory
    function reabilitarBotaoSendHistory() {

        const sendHistoryBtn = document.getElementById('sendHistory');
        if (sendHistoryBtn) {
            sendHistoryBtn.disabled = false;
            sendHistoryBtn.textContent = 'Gerar Link';
            sendHistoryBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    // Função global para abrir modal com coleção (será chamada do compartilhar.blade.php)
    window.openCompartilharModalWithCollection = function(collectionName, element) {
        const modal = document.getElementById('compartilharModal');
        const collectionInput = document.getElementById('collectionHistoryName');
        const collectionText = document.getElementById('collectionHistoryNameText');

        // Reabilitar o botão sendHistory ao abrir o modal
        reabilitarBotaoSendHistory();

        // Obter segmentacao_id do elemento clicado
        const segmentacaoId = element.getAttribute('data-segmentacao-id');

        // Armazenar collection ID atual
        collectionIdAtual = element.getAttribute('data-collection-id') || element.getAttribute('data-id');
        //console.log(collectionName);
        // Preencher dados do modal
        if (collectionInput) {
            collectionInput.value = collectionName;
        }

        document.getElementById('collectionId').value = collectionIdAtual;

        if (collectionText) {
            collectionText.textContent = element.getAttribute('data-codigo') || collectionName;
        }

        // Renderizar categorias baseadas na segmentação
        if (segmentacaoId) {
            renderizarCategorias(segmentacaoId);
        }

        // Mostrar modal
        modal.classList.remove('hidden');
    };

    // Variáveis globais para o modal de seleção de produtos
    let produtosSelecionados = [];
    let produtosDisponiveis = [];
    let collectionIdAtual = null;
    // Variáveis para seleção de segmentos
    let segmentosDisponiveis = @json($segmentosUsuario ?? []);
    let segmentosSelecionados = [];

    // Event listener para interceptar o botão sendHistory quando necessário
    document.addEventListener('DOMContentLoaded', function() {
        const selecaoButton = document.getElementById('btnSelecaoProdutos');
        const produtosHidden = document.getElementById('produtosSelecaoHidden');
        const selecaoSegmentosButton = document.getElementById('btnSelecaoSegmentos');
        const segmentosHidden = document.getElementById('segmentosSelecaoHidden');
        // Atualizar contador de segmentos no CTA ao carregar
        const contadorSegSpan = document.getElementById('btnContadorSegmentos');
        const segsInit = getSelectedSegmentacoesLocal();
        if (contadorSegSpan) {
            //contadorSegSpan.textContent = (segsInit && segsInit.length ? segsInit.length : 0) + ' (Editar)';
        }

        // Desabilitar/habilitar CTA de produtos conforme seleção inicial de segmentos
        if (selecaoButton) {
            const hasSegsInit = (segsInit && segsInit.length > 0);
            selecaoButton.disabled = !hasSegsInit;
            selecaoButton.classList.toggle('opacity-50', !hasSegsInit);
            selecaoButton.classList.toggle('cursor-not-allowed', !hasSegsInit);
        }

        // Clique no CTA: define modo seleção e abre modal (sem toggle)
        if (selecaoButton) {
            selecaoButton.addEventListener('click', function() {
                if (produtosHidden) produtosHidden.value = 'selecao';
                // Antes de abrir produtos, exigir seleção de segmentos
                const segs = getSelectedSegmentacoesLocal();
                if (!segs || segs.length === 0) {
                    alert('Por favor, selecione pelo menos um segmento antes de selecionar produtos.');
                    abrirModalSelecaoSegmentos();
                    return;
                }
                abrirModalSelecaoProdutos();
            });
        }

        if (selecaoSegmentosButton) {
            selecaoSegmentosButton.addEventListener('click', function() {
                if (segmentosHidden) segmentosHidden.value = 'selecao';
                abrirModalSelecaoSegmentos();
            });
        }

        const sendHistoryBtn = document.getElementById('sendHistory');

        if (sendHistoryBtn) {
            // Remover event listeners existentes clonando o elemento
            const newSendHistoryBtn = sendHistoryBtn.cloneNode(true);
            sendHistoryBtn.parentNode.replaceChild(newSendHistoryBtn, sendHistoryBtn);

            // Adicionar novo event listener
            newSendHistoryBtn.addEventListener('click', function(event) {

                // Exigir segmento selecionado para gerar
                const segs = getSelectedSegmentacoesLocal();
                if (!segs || segs.length === 0) {
                    alert('Selecione pelo menos um segmento para gerar os produtos.');
                    event.preventDefault();
                    event.stopPropagation();
                    abrirModalSelecaoSegmentos();
                    return false;
                }
                const tipoProdutos = produtosHidden ? produtosHidden.value : 'todos';
                const categoriasSelecionadas = document.querySelectorAll(
                    'input[name="categoria"]:checked');

                if (produtosSelecionados.length === 0) {
                    alert(
                        'Por favor, selecione pelo menos um produto para gerar o PDF.'
                    );
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }

                newSendHistoryBtn.disabled = true;
                newSendHistoryBtn.textContent = 'Gerando link...';
                newSendHistoryBtn.classList.add('opacity-50', 'cursor-not-allowed');

                const form = document.querySelector('#compartilharModal form');
                const formData = new FormData(form);

                // Adicionar segmentos manualmente
                formData.delete('selected_segmentacoes[]');
                segs.forEach(id => {
                    formData.append('selected_segmentacoes[]', id);
                });

                // Adicionar produtos selecionados manualmente
                formData.delete('produtos_selecionados[]');
                // Enviar como um único campo JSON para evitar estouro de max_input_vars (PHP Warning: Input variables exceeded 1000)
                formData.append('produtos_selecionados', JSON.stringify(produtosSelecionados));

                // Adicionar collection_id e nome
                formData.append('collection_id', document.getElementById('collectionId').value);
                formData.append('collectionHistoryName', document.getElementById(
                    'collectionHistoryName').value);

                // Adicionar categorias
                categoriasSelecionadas.forEach(c => {
                    formData.append('categorias[]', c.value);
                });

                // Fazer requisição AJAX
                fetch("{{ route('shared.collection.generate') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const historyForm = document.getElementById('historyForm');
                            const historySuccess = document.getElementById('historySuccess');
                            const generatedLinkInput = document.getElementById('generatedLink');
                            const openLinkBtn = document.getElementById('openLinkBtn');

                            const generatedNameText = document.getElementById('generatedNameText');

                            // Atualizar texto com nome da coleção
                            generatedNameText.textContent = data.name;

                            generatedLinkInput.href = data.link;
                            generatedLinkInput.innerText = data.link;
                            openLinkBtn.href = data.link;

                            historyForm.classList.add('hidden');
                            historySuccess.classList.remove('hidden');

                            // Configurar botão de copiar
                            const copyBtn = document.getElementById('copyLinkBtn');
                            // Remover listener antigo se houver
                            const newCopyBtn = copyBtn.cloneNode(true);
                            copyBtn.parentNode.replaceChild(newCopyBtn, copyBtn);

                            newCopyBtn.addEventListener('click', function() {
                                const tempInput = document.createElement("input");
                                tempInput.value = data.link;
                                document.body.appendChild(tempInput);
                                tempInput.select();
                                document.execCommand("copy");
                                document.body.removeChild(tempInput);

                                const originalText = this.textContent;
                                this.textContent = 'Copiado!';
                                document.getElementById('alertLinkGerado').classList.remove(
                                    'hidden');
                                //this.classList.remove('bg-black');
                                //this.classList.add('bg-green-600');

                                setTimeout(() => {
                                    this.textContent = originalText;
                                    //this.classList.remove('bg-green-600');
                                    //this.classList.add('bg-black');
                                }, 2000);
                            });
                        } else {
                            alert('Erro ao gerar link: ' + (data.message || 'Erro desconhecido'));
                            newSendHistoryBtn.disabled = false;
                            newSendHistoryBtn.textContent = 'Gerar Link';
                            newSendHistoryBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Ocorreu um erro ao gerar o link. Tente novamente.');
                        newSendHistoryBtn.disabled = false;
                        newSendHistoryBtn.textContent = 'Gerar Link';
                        newSendHistoryBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
            });
        }
    });

    // Função para abrir o modal de seleção de produtos
    function abrirModalSelecaoProdutos() {
        const categoriasSelecionadas = Array.from(document.querySelectorAll('input[name="categoria"]:checked'))
            .map(checkbox => checkbox.value);

        if (!collectionIdAtual) {
            alert('Erro: Collection ID não encontrado.');
            return;
        }

        // Fechar o modal principal (gerar arquivo)
        document.getElementById('compartilharModal').classList.add('hidden');

        // Mostrar o modal de seleção de produtos
        document.getElementById('selecaoProdutosModal').classList.remove('hidden');

        // Carregar produtos
        carregarProdutosPorCategoria(categoriasSelecionadas);
    }

    // Função para carregar produtos por categoria via AJAX
    function carregarProdutosPorCategoria(categorias) {
        const produtosList = document.getElementById('produtosList');
        produtosList.innerHTML = '<div class="col-span-full text-center py-4">Carregando produtos...</div>';

        // Se "todas" está selecionada, usar todas as categorias
        const categoriasParam = categorias.includes('todas') ? 'todas' : categorias.join(',');

        const segs = getSelectedSegmentacoesLocal();
        const segParams = (segs && segs.length > 0) ? segs.map(id => `selected_segmentacoes[]=${id}`).join('&') : '';
        const url = `/user/api/produtos-por-categoria?categoria=${categoriasParam}&collection_id=${collectionIdAtual}` +
            (segParams ? `&${segParams}` : '');
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                produtosDisponiveis = data;
                renderizarProdutos(data);
            })
            .catch(error => {
                console.error('Erro ao carregar produtos:', error);
                produtosList.innerHTML =
                    '<div class="col-span-full text-center py-4 text-red-500">Erro ao carregar produtos. Tente novamente.</div>';
            });
    }

    // Função para renderizar a lista de produtos
    function renderizarProdutos(produtos) {
        const produtosList = document.getElementById('produtosList');
        const totalProdutos = document.getElementById('totalProdutos');

        if (produtos.length === 0) {
            produtosList.innerHTML =
                '<div class="text-center py-8 text-gray-500">Nenhum produto encontrado para as categorias selecionadas.</div>';
            totalProdutos.textContent = '0';
            return;
        }

        totalProdutos.textContent = produtos.length;

        produtosList.innerHTML = produtos.map(produto => `
            <div class="py-1 px-2 grid grid-cols-12 gap-4 items-center hover:bg-gray-50 transition-colors produto-row" data-produto-nome="${produto.title.toLowerCase()}" data-produto-codigo="${produto.codigo.toLowerCase()}" data-produto-categoria="${(produto.categoria || '').toLowerCase()}" data-favoritos="${produto.favoritos}">
                <div class="col-span-1 text-center">
                    <input type="checkbox" 
                           id="produto_${produto.id}" 
                           value="${produto.id}" 
                           data-cor="${produto.cor}"
                           data-categoria="${produto.categoria || ''}"
                           class="produto-checkbox w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative " 
                           ${(Array.isArray(produtosSelecionados) && produtosSelecionados.some(p => p.id === produto.id && p.cor === produto.cor)) || produto.selected ? 'checked' : ''}>
                </div>
                <div class="col-span-2 text-sm ">${produto.codigo}</div>
                <div class="notranslate col-span-3 text-sm ">${produto.title}</div>
                <div class="notranslate col-span-2 text-sm ">${produto.cor}</div>
                <div class="col-span-2 text-sm ">${produto.categoria}</div>
                <div class="col-span-2 text-sm ">${produto.preco}</div>
            </div>
        `).join('');

        // Adicionar event listeners aos checkboxes
        document.querySelectorAll('.produto-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const produtoId = parseInt(this.value);
                const produtoCor = this.getAttribute('data-cor');
                if (this.checked) {
                    if (!produtosSelecionados.some(p => p.id === produtoId && p.cor === produtoCor)) {
                        produtosSelecionados.push({
                            id: produtoId,
                            cor: produtoCor
                        });
                    }
                } else {
                    produtosSelecionados = produtosSelecionados.filter(p => !(p.id === produtoId && p
                        .cor === produtoCor));
                }
                atualizarContador();
            });
        });

        atualizarContador();

        // Renderizar checkboxes de categorias para seleção em massa
        renderizarCategoriasSelecionaveis(produtos);
    }

    // Função para atualizar contador de selecionados
    function atualizarContador() {

        const contadorSelecionados = document.getElementById('contadorSelecionados');
        contadorSelecionados.textContent = produtosSelecionados.length;

        // Atualizar estado do radio "Selecionar todos"
        const selecionarTodosRadio = document.getElementById('selecionarTodos');
        const totalCheckboxes = document.querySelectorAll('.produto-checkbox').length;
        selecionarTodosRadio.checked = produtosSelecionados.length === totalCheckboxes && totalCheckboxes > 0;

    }

    // Event listeners para os botões do modal
    document.getElementById('closeSelecaoProdutosModal').addEventListener('click', fecharModalSelecaoProdutos);
    //document.getElementById('voltarSelecao').addEventListener('click', fecharModalSelecaoProdutos);
    document.getElementById('closeHistoryModal').addEventListener('click', handleCloseHistoryModal);

    // Event listener para o botão de fechar o modal de sucesso
    document.getElementById('closeSuccessModal').addEventListener('click', function() {
        document.getElementById('compartilharModal').classList.add('hidden');
        // Reabilitar o botão sendHistory
        reabilitarBotaoSendHistory();
        handleCloseHistoryModal();
        // Mostrar novamente o formulário e esconder o sucesso
        document.getElementById('historyForm').classList.remove('hidden');
        document.getElementById('historySuccess').classList.add('hidden');
    });

    // Funcionalidade de busca
    document.getElementById('buscarProduto').addEventListener('input', function() {
        const termoBusca = this.value.toLowerCase();
        const produtoRows = document.querySelectorAll('.produto-row');

        produtoRows.forEach(row => {
            const nome = row.getAttribute('data-produto-nome');
            const codigo = row.getAttribute('data-produto-codigo');

            if (nome.includes(termoBusca) || codigo.includes(termoBusca)) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('salvarSelecao').addEventListener('click', function() {
        if (produtosSelecionados.length === 0) {
            alert('Por favor, selecione pelo menos um produto.');
            return;
        }

        // Capturar a quantidade antes de limpar o array
        const quantidadeSelecionados = produtosSelecionados.length;

        // Adicionar produtos selecionados ao formulário
        const form = document.querySelector('#compartilharModal form');


        // Remover inputs de produtos anteriores se existirem
        const existingProductInputs = form.querySelectorAll('input[name^="produtos_selecionados"]');
        existingProductInputs.forEach(input => input.remove());

        // Adicionar os produtos selecionados (id e cor) como um único input hidden JSON
        const inputProdutos = document.createElement('input');
        inputProdutos.type = 'hidden';
        inputProdutos.name = 'produtos_selecionados';
        inputProdutos.value = JSON.stringify(produtosSelecionados);
        form.appendChild(inputProdutos);

        //console.log('Produtos selecionados:', produtosSelecionados);

        // Fechar modal de seleção e voltar ao modal anterior
        document.getElementById('selecaoProdutosModal').classList.add('hidden');
        document.getElementById('compartilharModal').classList.remove('hidden');

        // Atualizar contador no botão "Selecionado(s):"
        const contadorSpan = document.getElementById('btnContadorSelecionados');
        const contadorSpanText = document.getElementById('spanSelecionarProdutos');
        if (contadorSpan && quantidadeSelecionados > 0) {
            contadorSpanText.textContent = "Selecionados: ";
            contadorSpan.textContent = quantidadeSelecionados + ' (Editar)';
        } else {
            contadorSpanText.textContent = "Selecionar segmentos ";
        }

        // Garantir modo seleção ativo no envio
        const produtosHidden = document.getElementById('produtosSelecaoHidden');
        if (produtosHidden) produtosHidden.value = 'selecao';
    });

    // ===== Seleção de Segmentos =====
    function abrirModalSelecaoSegmentos() {
        // Fechar modal principal
        document.getElementById('compartilharModal').classList.add('hidden');
        // Abrir modal de segmentos
        document.getElementById('selecaoSegmentosModal').classList.remove('hidden');
        renderizarSegmentos(segmentosDisponiveis);
    }

    function fecharModalSelecaoSegmentos() {
        document.getElementById('selecaoSegmentosModal').classList.add('hidden');
        // Voltar ao modal principal
        document.getElementById('compartilharModal').classList.remove('hidden');
    }

    function renderizarSegmentos(lista) {
        const contTotal = document.getElementById('totalSegmentos');
        contTotal.textContent = (lista && lista.length) ? lista.length : 0;
        const contSel = document.getElementById('contadorSegmentosSelecionados');
        const container = document.getElementById('segmentosList');

        // Carregar seleção do localStorage
        segmentosSelecionados = getSelectedSegmentacoesLocal();
        contSel.textContent = segmentosSelecionados.length;

        if (!lista || lista.length === 0) {
            container.innerHTML = '<div class="text-center py-8 text-gray-500">Nenhum segmento disponível.</div>';
            return;
        }

        container.innerHTML = lista.map(seg => `
            <div class=\"py-[5px] px-4 text-sm\">
                <label class=\"inline-flex items-center gap-1 cursor-pointer\">
                    <input type=\"checkbox\" data-id=\"${seg.id}\" ${segmentosSelecionados.includes(seg.id) ? 'checked' : ''}
                        class=\"segmento-checkbox w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-3\">
                    <span class=\"text-sm text-gray-900\">${seg.nome}</span>
                </label>
            </div>
        `).join('');

        document.querySelectorAll('.segmento-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const id = parseInt(this.getAttribute('data-id'));
                if (this.checked) {
                    if (!segmentosSelecionados.includes(id)) segmentosSelecionados.push(id);
                } else {
                    segmentosSelecionados = segmentosSelecionados.filter(s => s !== id);
                }
                document.getElementById('contadorSegmentosSelecionados').textContent =
                    segmentosSelecionados.length;
                atualizarSelecionarTodosSegmentos();
            });
        });

        atualizarSelecionarTodosSegmentos();
    }

    function atualizarSelecionarTodosSegmentos() {
        const total = document.querySelectorAll('.segmento-checkbox').length;
        const chk = document.getElementById('selecionarTodosSegmentos');
        chk.checked = (segmentosSelecionados.length === total && total > 0);
    }

    document.getElementById('selecionarTodosSegmentos').addEventListener('change', function() {
        const check = this.checked;
        const boxes = document.querySelectorAll('.segmento-checkbox');
        segmentosSelecionados = [];
        boxes.forEach(b => {
            b.checked = check;
            if (check) segmentosSelecionados.push(parseInt(b.getAttribute('data-id')));
        });
        document.getElementById('contadorSegmentosSelecionados').textContent = segmentosSelecionados.length;
    });

    document.getElementById('buscarSegmento').addEventListener('input', function() {
        const termo = this.value.toLowerCase();
        document.querySelectorAll('#segmentosList > div').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(termo) ? '' : 'none';
        });
    });

    //document.getElementById('closeSelecaoSegmentosModal').addEventListener('click', cancelarSelecaoSegmentos);
    document.getElementById('cancelarSelecaoSegmentos').addEventListener('click', cancelarSelecaoSegmentos);

    document.getElementById('salvarSelecaoSegmentos').addEventListener('click', function() {
        if (!segmentosSelecionados || segmentosSelecionados.length === 0) {
            alert('Por favor, selecione pelo menos um segmento.');
            return;
        }
        // Persistir no localStorage
        localStorage.setItem('selectedSegmentacoesModal', JSON.stringify(segmentosSelecionados));

        // Atualizar contador no botão
        const contadorSegSpan = document.getElementById('btnContadorSegmentos');
        const contadorSpanText = document.getElementById('spanSelecionarSegmentos');
        if (contadorSegSpan && segmentosSelecionados.length > 0) {
            contadorSpanText.textContent = "Selecionados:";
            contadorSegSpan.textContent = segmentosSelecionados.length + ' (Editar)';
        } else {
            contadorSpanText.textContent = "Selecionar segmentos ";
        }

        // Habilitar CTA de produtos após salvar seleção de segmentos
        const selecaoButton = document.getElementById('btnSelecaoProdutos');
        if (selecaoButton) {
            const hasSegs = segmentosSelecionados.length > 0;
            selecaoButton.disabled = !hasSegs;
            selecaoButton.classList.toggle('opacity-50', !hasSegs);
            selecaoButton.classList.toggle('cursor-not-allowed', !hasSegs);
        }

        fecharModalSelecaoSegmentos();
    });

    function cancelarSelecaoSegmentos() {
        // Limpar seleção em memória
        segmentosSelecionados = [];

        // Desmarcar todas as checkboxes visíveis
        document.querySelectorAll('.segmento-checkbox').forEach(cb => {
            cb.checked = false;
        });

        // Atualizar contadores e selecionar todos
        document.getElementById('contadorSegmentosSelecionados').textContent = 0;
        const chkTodos = document.getElementById('selecionarTodosSegmentos');
        if (chkTodos) chkTodos.checked = false;

        // Limpar persistência
        try {
            localStorage.removeItem('selectedSegmentacoesModal');
        } catch (e) {}

        // Atualizar CTA no modal principal
        const contadorSegSpan = document.getElementById('btnContadorSegmentos');
        const contadorSpanText = document.getElementById('spanSelecionarSegmentos');
        if (contadorSegSpan) {
            contadorSegSpan.textContent = '';
            contadorSpanText.textContent = "Selecionar segmentos ";
        }

        // Desabilitar CTA de produtos ao cancelar seleção de segmentos
        const selecaoButton = document.getElementById('btnSelecaoProdutos');
        if (selecaoButton) {
            selecaoButton.disabled = true;
            selecaoButton.classList.add('opacity-50', 'cursor-not-allowed');
        }

        // Fechar modal de segmentos e voltar ao modal principal
        fecharModalSelecaoSegmentos();
    }

    function getSelectedSegmentacoesLocal() {
        try {
            const raw = localStorage.getItem('selectedSegmentacoesModal');
            if (!raw) return [];
            const arr = JSON.parse(raw);
            return Array.isArray(arr) ? arr : [];
        } catch (e) {
            return [];
        }
    }

    function fecharModalSelecaoProdutos() {
        //console.log('Fechar modal seleção produtos');
        // Fechar modal de seleção de produtos
        document.getElementById('selecaoProdutosModal').classList.add('hidden');

        // Fechar modal principal (gerar arquivo)
        document.getElementById('compartilharModal').classList.remove('hidden');

        // Reabilitar o botão sendHistory
        reabilitarBotaoSendHistory();

        // Limpar formulário completamente
        //limparFormulario();

        // Resetar arrays de produtos
        //produtosSelecionados = [];
        //produtosDisponiveis = [];
    }

    function fecharGeral() {
        //console.log('Fechar modal seleção produtos');
        // Fechar modal de seleção de produtos
        document.getElementById('selecaoProdutosModal').classList.add('hidden');

        // Fechar modal principal (gerar arquivo)
        document.getElementById('compartilharModal').classList.add('hidden');

        // Reabilitar o botão sendHistory
        reabilitarBotaoSendHistory();

        // Limpar formulário completamente
        //limparFormulario();

        // Resetar arrays de produtos
        //produtosSelecionados = [];
        //produtosDisponiveis = [];
    }

    function limparFormulario() {
        // Resetar categorias para "Todas"
        const radioTodas = document.querySelector('input[name="categoria"][value="todas"]');
        if (radioTodas) {
            radioTodas.checked = true;
        }

        // Resetar contador e tipo de produtos
        const contadorSpan = document.getElementById('btnContadorSelecionados');
        if (contadorSpan) {
            contadorSpan.textContent = '';
        }
        const produtosHidden = document.getElementById('produtosSelecaoHidden');
        if (produtosHidden) {
            produtosHidden.value = 'todos';
        }

        // Desmarcar todas as opções de personalização
        const checkboxesOpcoes = document.querySelectorAll('#compartilharModal input[name="opcoes[]"]');
        checkboxesOpcoes.forEach(checkbox => {
            checkbox.checked = false;
        });

        // Limpar collection ID
        const collectionIdInput = document.getElementById('collectionId');
        if (collectionIdInput) collectionIdInput.value = '';

        // Resetar texto do título
        const titleText = document.getElementById('collectionHistoryNameText');
        if (titleText) {
            titleText.textContent = '';
        }

        // Remover inputs de produtos selecionados
        const form = document.querySelector('#compartilharModal form');
        if (form) {
            const existingProductInputs = form.querySelectorAll('input[name^="produtos_selecionados"]');
            existingProductInputs.forEach(input => input.remove());
        }
    }

    function handleCloseHistoryModal() {

        // Zerar produtos selecionados
        produtosSelecionados = [];
        const contadorProdutosSpan = document.getElementById('btnContadorSelecionados');
        //
        if (contadorProdutosSpan) {
            const contadorSpanText = document.getElementById('spanSelecionarProdutos');
            contadorSpanText.textContent = "Selecionar produtos";
            contadorProdutosSpan.textContent = '';
        }
        const produtosHidden = document.getElementById('produtosSelecaoHidden');
        if (produtosHidden) {
            produtosHidden.value = 'todos';
        }
        const form = document.querySelector('#compartilharModal form');
        if (form) {
            const existingProductInputs = form.querySelectorAll('input[name^="produtos_selecionados"]');
            existingProductInputs.forEach(input => input.remove());
        }

        // Zerar segmentos selecionados
        segmentosSelecionados = [];
        try {
            localStorage.removeItem('selectedSegmentacoesModal');
        } catch (e) {}
        const contadorSegSpan = document.getElementById('btnContadorSegmentos');
        const contadorSpanText = document.getElementById('spanSelecionarSegmentos');
        if (contadorSegSpan) {
            contadorSpanText.textContent = "Selecionar segmentos";
            contadorSegSpan.textContent = '';
        }
        // Desmarcar checkboxes do modal de segmentos, se presentes
        document.querySelectorAll('.segmento-checkbox').forEach(cb => {
            cb.checked = false;
        });
        const chkTodosSegmentos = document.getElementById('selecionarTodosSegmentos');
        if (chkTodosSegmentos) {
            chkTodosSegmentos.checked = false;
        }
        const contSelSeg = document.getElementById('contadorSegmentosSelecionados');
        if (contSelSeg) {
            contSelSeg.textContent = 0;
        }

        // Fechar modais e reabilitar estado
        fecharGeral();

        // Desabilitar CTA de produtos ao limpar histórico/seleções
        const selecaoButton = document.getElementById('btnSelecaoProdutos');
        if (selecaoButton) {
            selecaoButton.disabled = true;
            selecaoButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    // Renderiza checkboxes de categorias e vincula seleção em massa
    function renderizarCategoriasSelecionaveis(produtos) {
        const container = document.getElementById('categoriasSelecionaveis');
        if (!container) return;

        // Extrair categorias únicas dos produtos
        const categoriasSet = new Set((produtos || []).map(p => (p.categoria || '').trim()).filter(Boolean));
        const categorias = Array.from(categoriasSet).sort((a, b) => a.localeCompare(b));

        if (categorias.length === 0) {
            container.innerHTML = '';
            return;
        }

        container.innerHTML = [
            `
                <label class="flex items-center">
                    <input type="checkbox" id="selecionarTodos" name="selecao_tipo"
                        class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-2">
                    <span>Todos</span>
                </label>
            `,
            ...categorias.map(cat => `
                <label class="inline-flex items-center">
                    <input type="checkbox" class="categoria-select-checkbox w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-2" data-categoria="${cat}">
                    <span class="text-base">${cat}</span>
                </label>
            `),
            `
                <label class="flex items-center">
                    <input type="checkbox" id="selecionarFavoritos" name="selecionarFavoritos"
                        class="w-[15px] h-[15px] rounded border-2 border-[#7A7A7A] bg-white checked:bg-white checked:border-[#7A7A7A] focus:ring-0 cursor-pointer relative mr-2">
                    <span>Favoritos</span>
                </label>
            `,
        ].join('');

        // Vincular eventos: marcar/desmarcar todos os produtos daquela categoria (apenas visíveis)
        container.querySelectorAll('.categoria-select-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const categoria = (this.getAttribute('data-categoria') || '').toLowerCase();
                const produtoRows = document.querySelectorAll('.produto-row');
                produtoRows.forEach(row => {
                    const rowCategoria = row.getAttribute('data-produto-categoria') || '';
                    if (row.style.display !== 'none' && rowCategoria === categoria) {
                        const checkbox = row.querySelector('.produto-checkbox');
                        if (!checkbox) return;
                        const produtoId = parseInt(checkbox.value);
                        const produtoCor = checkbox.getAttribute('data-cor');

                        checkbox.checked = this.checked;
                        if (this.checked) {
                            if (!produtosSelecionados.some(p => p.id === produtoId && p.cor ===
                                    produtoCor)) {
                                produtosSelecionados.push({
                                    id: produtoId,
                                    cor: produtoCor
                                });
                            }
                        } else {
                            produtosSelecionados = produtosSelecionados.filter(p => !(p.id ===
                                produtoId && p.cor === produtoCor));
                        }
                    }
                });
                //atualizarEstadoSelecionarTodos();
                atualizarContador();
            });
        });

        document.getElementById('selecionarFavoritos').addEventListener('change', function() {
            const produtoRows = document.querySelectorAll('.produto-row');
            produtoRows.forEach(row => {
                const rowFavoritos = row.getAttribute('data-favoritos') || '';
                if (row.style.display !== 'none' && rowFavoritos === 'true') {
                    const checkbox = row.querySelector('.produto-checkbox');
                    if (!checkbox) return;
                    const produtoId = parseInt(checkbox.value);
                    const produtoCor = checkbox.getAttribute('data-cor');

                    checkbox.checked = this.checked;
                    if (this.checked) {
                        if (!produtosSelecionados.some(p => p.id === produtoId && p.cor ===
                                produtoCor)) {
                            produtosSelecionados.push({
                                id: produtoId,
                                cor: produtoCor
                            });
                        }
                    } else {
                        produtosSelecionados = produtosSelecionados.filter(p => !(p.id ===
                            produtoId && p.cor === produtoCor));
                    }
                }
            });
            //atualizarEstadoSelecionarTodos();
            atualizarContador();
        });


        document.getElementById('selecionarTodos').addEventListener('change', function() {

            const checkboxes = document.querySelectorAll('.produto-checkbox');
            const isChecked = this.checked;

            checkboxes.forEach(checkbox => {
                // Só alterar checkboxes visíveis
                const row = checkbox.closest('.produto-row');
                if (row.style.display !== 'none') {
                    checkbox.checked = isChecked;
                    const produtoId = parseInt(checkbox.value);
                    const produtoCor = checkbox.getAttribute('data-cor');

                    if (isChecked) {
                        if (!produtosSelecionados.some(p => p.id === produtoId && p.cor ===
                                produtoCor)) {
                            produtosSelecionados.push({
                                id: produtoId,
                                cor: produtoCor
                            });
                        }
                    } else {
                        produtosSelecionados = produtosSelecionados.filter(p => !(p.id ===
                            produtoId &&
                            p
                            .cor === produtoCor));
                    }
                }
            });

            atualizarContador();
        });
    }
</script>
