<div id="historyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-8 max-w-3xl w-full mx-4">
        <div class="flex justify-center items-center mb-7">
            <h2 class="text-xl font-medium text-center">Histórico de Arquivos Gerados</h2>

        </div>
        <div class="flex items-center border-b border-b-black px-2 mb-[30px]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black ml-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                    clip-rule="evenodd" />
            </svg>
            <input type="text" placeholder="Buscar" id="searchHistoryInput"
                class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
        </div>
        <div class="overflow-x-auto h-[40vh]">
            <table class="min-w-full bg-white" id="historyTable">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-xs font-normal text-left">Nome</th>
                        <th class="py-2 px-4 text-xs font-normal text-left">Data</th>
                        <th class="py-2 px-4"></th>
                    </tr>
                </thead>
                <tbody id="historyTableBody">
                    @foreach ($exportUsers as $exportUser)
                        <tr class="history-row">
                            <td class="py-[10px] px-4 text-sm">{{ $exportUser->collection_history_name }}</td>
                            <td class="py-[10px] px-4 text-sm">{{ $exportUser->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-[10px] px-4 text-sm">
                                <a href="{{ route('exports.regenerate', $exportUser->id) }}"
                                    class="text-[#808080] hover:text-blue-800 underline"
                                    title="Baixar {{ $exportUser->filename }}">
                                    Baixar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer com botões -->
        <div class="pt-4 mt-4">
            <div class="flex justify-center gap-4">

                <button onclick="document.getElementById('historyModal').classList.add('hidden')" type="button"
                    id="voltarSelecao"
                    class="flex items-center border border-black rounded-full px-6 py-3 text-sm hover:bg-gray-200 transition">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="ml-2 w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('voltarSelecao').addEventListener('click', fecharhistoryModal);

    // Funcionalidade de filtro de busca
    document.getElementById('searchHistoryInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.history-row');

        rows.forEach(function(row) {
            const fileName = row.cells[0].textContent.toLowerCase();
            const fileDate = row.cells[1].textContent.toLowerCase();

            if (fileName.includes(searchTerm) || fileDate.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function fecharhistoryModal() {
        document.getElementById('historyModal').classList.add('hidden');
        // Reabrir o modal principal (gerar arquivo)
        //document.getElementById('gerarArquivoModal').classList.remove('hidden');
        produtosSelecionados = [];
        produtosDisponiveis = [];
    }
</script>
