<!-- Modal de Histórico -->
<div id="gerarArquivoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg max-w-xl w-full p-7">
        <form action="{{ route('user.export.pdf') }}" method="POST">
            @csrf
            <input type="hidden" name="collection_id" id="collectionId">

            <!-- Tela 1: Formulário de Histórico -->
            <div id="historyForm" class="space-y-6">
                <h2 class="text-xl font-medium text-center text-black" id="collectionHistoryNameText">
                    1S25 Exclusivo Sapatarias
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-normal text-black mb-2">Nome do arquivo</label>
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

                    <div>
                        <label class="block  text-xs font-normal text-black mb-2">Produtos</label>
                        <div class="flex flex-col gap-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="produtos" class="form-radio" value="selecao">
                                <span class="ml-2 text-base">Seleção</span>
                                <span class="text-xs ml-2" id="editSelectionContainer" style="display: none;"><a
                                        id="editSelection" href="#"
                                        onclick="abrirModalSelecaoProdutos(); return false;"
                                        class="text-black opacity-50 underline">Editar</a></span>
                                <span class="text-xs text-black ml-2">*Gera o arquivo somente com os itens
                                    selecionados.</span>
                            </label>
                            <!--<label class="inline-flex items-center">
                                <input type="radio" name="produtos" class="form-radio" value="favoritos">
                                <span class="ml-2 text-base">Favoritos</span>
                                <span class="text-xs text-black ml-2">*Gera o arquivo somente com os itens
                                    favoritados da
                                    coleção</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="produtos" class="form-radio" value="todos" checked>
                                <span class="ml-2 text-base">Todos</span>
                            </label>-->
                        </div>
                    </div>

                    <div>
                        <label class="block  text-xs font-normal text-black mb-2">Opções</label>
                        <div class="flex flex-wrap gap-3">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="opcoes[]" class="form-checkbox" value="remover_preco">
                                <span class="ml-2 text-sm">Remover Preço</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="opcoes[]" class="form-checkbox" value="remover_codigo">
                                <span class="ml-2 text-sm">Remover Código</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="opcoes[]" class="form-checkbox" value="remover_descricao">
                                <span class="ml-2 text-sm">Remover Descrição Tecnologias</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="opcoes[]" class="form-checkbox" value="remover_tag">
                                <span class="ml-2 text-sm">Remover Tag Exclusivo</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="opcoes[]" class="form-checkbox"
                                    value="remover_capa_retranca">
                                <span class="ml-2 text-sm">Remover Capa e Retrancas</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-normal text-black mb-2">Formato</label>
                        <div class="flex flex-wrap gap-3">
                            <label class="inline-flex items-center">
                                <input type="radio" name="formato" class="form-radio" value="a4" checked>
                                <span class="ml-2 text-sm">Impressão A4</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input disabled type="radio" name="formato" class="form-radio" value="16_9">
                                <span class="ml-2 text-sm opacity-50">Apresentação 16:9</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input disabled type="radio" name="formato" class="form-radio" value="planilha">
                                <span class="ml-2 text-sm opacity-50">Planilha</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button id="sendHistory"
                    class="w-full bg-black text-white font-normal text-base py-3 px-4 rounded-full hover:bg-gray-800 transition-colors">
                    Gerar arquivo
                </button>

                <div class="flex justify-center">

                    <button type="button" id="closeHistoryModal"
                        class="flex items-center border border-black rounded-full px-6 py-3 text-sm  hover:bg-gray-200 transition">
                        Voltar
                        <img src="/images/icon-voltar.png" alt="" class="ml-2 w-4 h-4" />
                    </button>
                </div>

                <div class="text-center text-xs text-gray-600">
                    <p>
                        Precisa de ajuda? Envie um e-mail para
                        <a href="mailto:estudio@vulcabras.com"
                            class="text-gray-600 underline">estudio@vulcabras.com</a>
                    </p>
                </div>
            </div>

            <!-- Tela 2: Confirmação de Envio -->
            <div id="historySuccess" class="space-y-6 hidden">
                <h2 class="text-xl font-semibold text-center text-gray-900">
                    Gerando arquivo!
                </h2>

                <p class="text-center text-gray-600">
                    Seu arquivo será gerado assim que fechar essa janela.
                </p>

                <div class="flex justify-center">
                    <button type="button"
                        class="flex items-center border border-black rounded-full px-3 py-2 text-md bg-gray-100 hover:bg-gray-200 transition text-[14px]"
                        id="closeSuccessModal">
                        Fechar
                    </button>
                </div>

                <div class="text-center text-xs text-gray-600">
                    <p>
                        Precisa de ajuda? Envie um e-mail para
                        <a href="mailto:estudio@vulcabras.com"
                            class="text-gray-600 underline">estudio@vulcabras.com</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Seleção de Produtos -->
<div id="selecaoProdutosModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-60 hidden">
    <div class="bg-white rounded-lg max-w-4xl w-full mx-4 p-6 max-h-[90vh] overflow-hidden flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Seleção</h2>

        </div>

        <!-- Header com controles -->
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-4">
                <label class="flex items-center">
                    <input type="radio" id="selecionarTodos" name="selecao_tipo" class="mr-2 text-base">
                    <span>Selecionar todos</span>
                </label>
                <span class="text-xs opacity-50">Selecionados: <span id="contadorSelecionados">0</span></span>
                <span class="text-xs opacity-50">Total: <span id="totalProdutos">0</span></span>
            </div>
            <div class="flex items-center gap-2">

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
                    class="bg-black text-white px-8 py-3 rounded-full hover:bg-gray-800 transition-colors w-full font-normal">
                    Salvar
                </button>
            </div>
            <div class="flex justify-center gap-4">
                <button type="button" id="closeSelecaoProdutosModal"
                    class="flex items-center border border-black rounded-full px-6 py-3 text-sm  hover:bg-gray-200 transition">
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
            sendHistoryBtn.textContent = 'Gerar arquivo';
            sendHistoryBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    // Função global para abrir modal com coleção (será chamada do gerar-arquivo.blade.php)
    window.openHistoryModalWithCollection = function(collectionName, element) {
        const modal = document.getElementById('gerarArquivoModal');
        const collectionInput = document.getElementById('collectionHistoryName');
        const collectionText = document.getElementById('collectionHistoryNameText');

        // Reabilitar o botão sendHistory ao abrir o modal
        reabilitarBotaoSendHistory();

        // Obter segmentacao_id do elemento clicado
        const segmentacaoId = element.getAttribute('data-segmentacao-id');

        // Armazenar collection ID atual
        collectionIdAtual = element.getAttribute('data-collection-id') || element.getAttribute('data-id');
        console.log(collectionName);
        // Preencher dados do modal
        if (collectionInput) {
            collectionInput.value = collectionName;
        }

        document.getElementById('collectionId').value = collectionIdAtual;

        if (collectionText) {
            collectionText.textContent = element.getAttribute('data-codigo') || collectionName;
        }
        console.log(collectionText.textContent);
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

    // Event listener para interceptar o botão sendHistory quando necessário
    document.addEventListener('DOMContentLoaded', function() {
        // Controlar visibilidade do link 'Editar' baseado na seleção do radio button
        const radioSelecao = document.querySelector('input[name="produtos"][value="selecao"]');
        const editContainer = document.getElementById('editSelectionContainer');
        const radiosProdutos = document.querySelectorAll('input[name="produtos"]');

        // Função para mostrar/ocultar o link Editar
        function toggleEditLink() {
            if (radioSelecao && radioSelecao.checked) {
                editContainer.style.display = 'inline';
            } else {
                editContainer.style.display = 'none';
            }
        }

        // Adicionar event listeners a todos os radio buttons de produtos
        radiosProdutos.forEach(radio => {
            radio.addEventListener('change', toggleEditLink);
        });

        // Verificar estado inicial
        toggleEditLink();

        const sendHistoryBtn = document.getElementById('sendHistory');

        if (sendHistoryBtn) {
            // Remover event listeners existentes clonando o elemento
            const newSendHistoryBtn = sendHistoryBtn.cloneNode(true);
            sendHistoryBtn.parentNode.replaceChild(newSendHistoryBtn, sendHistoryBtn);

            // Adicionar novo event listener
            newSendHistoryBtn.addEventListener('click', function(event) {
                const selecaoRadio = document.querySelector('input[name="produtos"][value="selecao"]');
                const categoriasSelecionadas = document.querySelectorAll(
                    'input[name="categoria"]:checked');

                if (selecaoRadio && selecaoRadio.checked) {
                    // Verificar se produtos foram selecionados (novo formato id+cor)
                    const produtosSelecionadosInputs = document.querySelectorAll(
                        'input[name^="produtos_selecionados["]');
                    if (produtosSelecionadosInputs.length === 0) {
                        // Verificar se uma categoria específica está selecionada (não "todas")
                        if (categoriasSelecionadas.length === 0 || categoriasSelecionadas[0].value ===
                            'todas') {
                            alert(
                                'Por favor, selecione uma categoria específica para usar a seleção de produtos.'
                            );
                            // Evitar envio e propagação quando alertar
                            event.preventDefault();
                            event.stopPropagation();
                            return false;
                        }

                        // Prevenir o comportamento padrão e abrir o modal de seleção
                        event.preventDefault();
                        event.stopPropagation();

                        abrirModalSelecaoProdutos();
                        return false;
                    }
                }

                // Desabilitar o botão durante o processamento
                newSendHistoryBtn.disabled = true;
                newSendHistoryBtn.textContent = 'Gerando arquivo...';
                newSendHistoryBtn.classList.add('opacity-50', 'cursor-not-allowed');

                // Mostrar tela de sucesso
                const historyForm = document.getElementById('historyForm');
                const historySuccess = document.getElementById('historySuccess');

                historyForm.classList.add('hidden');
                historySuccess.classList.remove('hidden');

                // Submeter o formulário
                const form = document.querySelector('#gerarArquivoModal form');
                form.submit();
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
        document.getElementById('gerarArquivoModal').classList.add('hidden');

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

        fetch(`/user/api/produtos-por-categoria?categoria=${categoriasParam}&collection_id=${collectionIdAtual}`)
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
            <div class="py-1 px-2 grid grid-cols-12 gap-4 items-center hover:bg-gray-50 transition-colors produto-row" data-produto-nome="${produto.title.toLowerCase()}" data-produto-codigo="${produto.codigo.toLowerCase()}">
                <div class="col-span-1">
                    <input type="checkbox" 
                           id="produto_${produto.id}" 
                           value="${produto.id}" 
                           data-cor="${produto.cor}"
                           class="produto-checkbox" 
                           ${produto.selected ? 'checked' : ''}>
                </div>
                <div class="col-span-2 text-sm ">${produto.codigo}</div>
                <div class="col-span-3 text-sm ">${produto.title}</div>
                <div class="col-span-2 text-sm ">${produto.cor}</div>
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
    document.getElementById('closeHistoryModal').addEventListener('click', fecharModalSelecaoProdutos);

    // Event listener para o botão de fechar o modal de sucesso
    document.getElementById('closeSuccessModal').addEventListener('click', function() {
        document.getElementById('gerarArquivoModal').classList.add('hidden');
        // Reabilitar o botão sendHistory
        reabilitarBotaoSendHistory();
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
            }
        });

        atualizarContador();
    });

    document.getElementById('salvarSelecao').addEventListener('click', function() {
        if (produtosSelecionados.length === 0) {
            alert('Por favor, selecione pelo menos um produto.');
            return;
        }

        // Capturar a quantidade antes de limpar o array
        const quantidadeSelecionados = produtosSelecionados.length;

        // Adicionar produtos selecionados ao formulário
        const form = document.querySelector('#gerarArquivoModal form');

        // Remover inputs de produtos anteriores se existirem
        const existingProductInputs = form.querySelectorAll('input[name="produtos_selecionados[]"]');
        existingProductInputs.forEach(input => input.remove());

        // Adicionar os produtos selecionados (id e cor) como inputs hidden
        produtosSelecionados.forEach((produto, index) => {
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = `produtos_selecionados[${index}][id]`;
            inputId.value = produto.id;
            form.appendChild(inputId);

            const inputCor = document.createElement('input');
            inputCor.type = 'hidden';
            inputCor.name = `produtos_selecionados[${index}][cor]`;
            inputCor.value = produto.cor;
            form.appendChild(inputCor);
        });

        console.log('Produtos selecionados:', produtosSelecionados);

        // Fechar modal de seleção e voltar ao modal anterior
        document.getElementById('selecaoProdutosModal').classList.add('hidden');
        document.getElementById('gerarArquivoModal').classList.remove('hidden');

        // Mostrar alert com a quantidade correta
        //alert(`${quantidadeSelecionados} produto(s) selecionado(s).`);

        // Atualizar o texto do link "Editar" para mostrar quantos produtos foram selecionados
        const editSelection = document.getElementById('editSelection');
        if (editSelection) {
            editSelection.textContent = `Editar (${quantidadeSelecionados} selecionados)`;
        }
    });

    function fecharModalSelecaoProdutos() {
        //console.log('Fechar modal seleção produtos');
        // Fechar modal de seleção de produtos
        document.getElementById('selecaoProdutosModal').classList.add('hidden');

        // Fechar modal principal (gerar arquivo)
        document.getElementById('gerarArquivoModal').classList.add('hidden');

        // Reabilitar o botão sendHistory
        reabilitarBotaoSendHistory();

        // Limpar formulário completamente
        limparFormulario();

        // Resetar arrays de produtos
        produtosSelecionados = [];
        produtosDisponiveis = [];
    }

    function limparFormulario() {
        // Limpar campo nome do arquivo
        //document.getElementById('collectionHistoryName').value = '';

        const editContainer = document.getElementById('editSelectionContainer');

        // Resetar categorias para "Todas"
        const radioTodas = document.querySelector('input[name="categoria"][value="todas"]');
        if (radioTodas) {
            radioTodas.checked = true;
            editContainer.style.display = 'none';
        }

        // Resetar produtos para "Todos"
        const radioTodosProdutos = document.querySelector('input[name="produtos"][value="todos"]');
        if (radioTodosProdutos) {
            radioTodosProdutos.checked = true;
        }

        // Desmarcar todas as opções de personalização
        const checkboxesOpcoes = document.querySelectorAll('input[name="opcoes[]"]');
        checkboxesOpcoes.forEach(checkbox => {
            checkbox.checked = false;
        });

        // Resetar formato para PDF
        const radioPDF = document.querySelector('input[name="formato"][value="pdf"]');
        if (radioPDF) {
            radioPDF.checked = true;
        }

        // Limpar collection ID
        document.getElementById('collectionId').value = '';

        // Resetar texto do título
        const titleText = document.getElementById('collectionHistoryNameText');
        if (titleText) {
            titleText.textContent = '';
        }

        // Resetar texto do link "Editar"
        const editSelection = document.getElementById('editSelection');
        if (editSelection) {
            editSelection.textContent = 'Editar';
        }

        // Remover inputs de produtos selecionados
        const form = document.querySelector('#gerarArquivoModal form');
        const existingProductInputs = form.querySelectorAll('input[name="produtos_selecionados[]"]');
        existingProductInputs.forEach(input => input.remove());
    }
</script>
