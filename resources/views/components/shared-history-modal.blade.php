<div id="sharedHistoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-8 max-w-3xl w-full mx-4">
        <div class="flex justify-center items-center mb-7">
            <h2 class="text-xl font-medium text-center">Histórico de Links Compartilhados</h2>

        </div>
        <div class="flex items-center border-b border-b-black px-2 mb-[30px]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black ml-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                    clip-rule="evenodd" />
            </svg>
            <input type="text" placeholder="Buscar" id="searchSharedHistoryInput"
                class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
        </div>
        <div class="overflow-x-auto h-[calc(100vh-450px)]">
            <table class="min-w-full bg-white" id="sharedHistoryTable">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-xs font-normal text-left">Nome</th>
                        <th class="py-2 px-4 text-xs font-normal text-left">Data</th>
                        <th class="py-2 px-4"></th>
                    </tr>
                </thead>
                <tbody id="sharedHistoryTableBody">
                    @foreach ($sharedCollections as $sharedCollection)
                        <tr class="shared-history-row">
                            <td class="py-[10px] px-4 text-sm">{{ $sharedCollection->name ?? 'Sem nome' }}</td>
                            <td class="py-[10px] px-4 text-sm">{{ $sharedCollection->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-[10px] px-4 text-sm whitespace-nowrap">
                                <a href="{{ route('shared.collection', $sharedCollection->uuid) }}"
                                    class="text-[#808080] hover:text-blue-800 underline mr-4" target="_blank"
                                    title="Abrir Link">
                                    Abrir
                                </a>
                                <button
                                    onclick="copiarLinkCompartilhamento('{{ route('shared.collection', $sharedCollection->uuid) }}')"
                                    class="text-[#808080] hover:text-blue-800 underline cursor-pointer mr-4"
                                    title="Copiar Link">
                                    Copiar
                                </button>
                                <form action="{{ route('shared.collection.destroy', $sharedCollection->uuid) }}"
                                    method="POST" class="inline-block"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-[#808080] hover:text-red-600 underline cursor-pointer"
                                        title="Excluir Link">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer com botões -->
        <div class="pt-4 mt-4">
            <div class="flex justify-center gap-4">

                <button onclick="document.getElementById('sharedHistoryModal').classList.add('hidden')" type="button"
                    id="voltarSharedHistory"
                    class="flex items-center border border-black rounded-full px-6 py-3 text-sm">
                    Voltar
                    <img src="/images/icon-voltar.png" alt="" class="ml-2 w-4 h-4" />
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('voltarSharedHistory').addEventListener('click', fecharSharedHistoryModal);

    // Funcionalidade de filtro de busca
    document.getElementById('searchSharedHistoryInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.shared-history-row');

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

    function fecharSharedHistoryModal() {
        document.getElementById('sharedHistoryModal').classList.add('hidden');
    }

    function copiarLinkCompartilhamento(url) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(() => {
                alert('Link copiado para a área de transferência!');
            }).catch(err => {
                console.error('Erro ao copiar: ', err);
                fallbackCopyTextToClipboard(url);
            });
        } else {
            fallbackCopyTextToClipboard(url);
        }
    }

    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'sucesso' : 'falha';
            if (successful) {
                alert('Link copiado para a área de transferência!');
            } else {
                alert('Não foi possível copiar o link.');
            }
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
            alert('Erro ao copiar link. Por favor, copie manualmente.');
        }
        document.body.removeChild(textArea);
    }
</script>
