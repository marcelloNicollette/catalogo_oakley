<x-layout-user title="Under Armour - Conteúdos">
    <style>
        .options {
            width: 270px;
        }

        .check-icon {
            color: #000;
            font-weight: bold;
            font-size: 16px;
            width: 16px;
            text-align: center;
        }

        .option {
            padding: 1px 16px;
            border-bottom: 0;
        }

        .height-ultra {
            height: calc(100vh - 160px);
        }
    </style>
    <main class="lg:flex flex-1 produtos-page">
        <!-- Menu lateral -->
        <x-sidebar activeItem="conteudos" />

        <!-- Conteúdo principal -->
        <section class="flex-1 flex flex-col md:pr-0 md:pb-0 overflow-hidden">
            <!-- Filtros superiores -->
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pt-4 pb-3 pr-4 bg-[#F1F1F1]">
                <!-- Esquerda: Coleção e Categoria -->
                <div class="flex gap-2">

                    <div class="select-container">
                        <div class="select-button p-5" id="selectButton">
                            <span id="selectedText">Categoria</span>
                            <div class="" id="arrow">
                                <div class="pt-1" id="arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8"
                                        viewBox="0 0 12 8" fill="none">
                                        <path d="M1 1L5.94975 5.94975L10.8995 1" stroke="black" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>


                        <div class="options min-w-[345px] p-5" id="options">

                            @foreach ($categories as $item)
                                <div class="option text-[18px] font-normal" data-categoria-id="{{ $item->id }}"
                                    data-value="{{ $item->id }}">
                                    <span class="check-icon" style="display: none;"><svg
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                            <path
                                                d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                        </svg></span>
                                    <span class="option-content text-black">
                                        {{ $item->category }}
                                    </span>
                                    <span class="x-icon" style="display: none;">×</span>
                                </div>
                            @endforeach
                            <div class="option" data-categoria-id="" data-value="">
                                <span class="check-icon" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 640 640">
                                        <path
                                            d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z" />
                                    </svg></span>
                                <span class="text-[16px] text-black font-normal option-content">Todas</span>
                                <span class="x-icon" style="display: none;">×</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Direita: Busca e outros -->
                <div class="flex flex-wrap gap-2 items-end justify-end">
                    <div class="flex items-center border-b border-b-black px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black ml-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                clip-rule="evenodd" />
                        </svg>
                        <input type="text" placeholder="Buscar"
                            class="input-estilizado bg-transparent border-0 focus:outline-none focus:ring-0 p-1" />
                    </div>
                </div>
            </div>

            <div class="bg-[#E6E6E6] rounded-tl-lg overflow-auto height-ultra custom-scrollbar">
                <div class="my-custom-bg p-12 max-w-[999px] mx-auto pb-0">
                    @foreach ($conteudos as $item)
                        <div class="mb-10" data-categoria-id="{{ $item->id }}">
                            <div class="flex items-center">
                                <img src="/{{ $item->icon }}" class="" alt="{{ $item->category }}" />
                                <h2 class="neue-plak-extended text-[38px] font-black uppercase pt-1 pl-1">
                                    {{ $item->category }}</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if ($item->conteudo->count() > 0)
                                    @foreach ($item->conteudo as $conteudo)
                                        <div class="flex items-start gap-2 tecnologia">
                                            <div class="justify-center p-2 ">
                                                <img src="/images/icones/clip.png" class="w-full" alt="" />
                                            </div>
                                            <div class="pt-1">
                                                <a href="{{ $conteudo->link_url }}" target="_blank" class="">
                                                    <p class="text-xs">{{ $conteudo->name }} </p>
                                                    <p class="text-xs text-black opacity-50 max-w-[460px] pr-4">
                                                        {{ $conteudo->description }} </p>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-xs max-w-[460px] pr-6">Não temos item cadastrado nessa categoria.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach


                </div>

                <!-- Sugestão de Atualização -->
                <div class="border-t max-w-[999px] mx-auto p-12 pt-0">
                    <button id="openSuggestionModal" class="flex items-center gap-2 transition-colors text-xs  ">
                        <span class="opacity-50 hover:opacity-100 hover:underline">Enviar sugestão de
                            atualização/correção</span>
                        <svg class="opacity-100" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 16 16" fill="none">
                            <path
                                d="M2.5393 16H12.0333C13.489 16 14.33 15.1576 14.33 13.4889V4.82974L13.028 6.13389V13.4241C13.028 14.2666 12.5752 14.6959 12.0172 14.6959H2.56355C1.75486 14.6959 1.302 14.2666 1.302 13.4241V4.23032C1.302 3.3879 1.75486 2.95048 2.56355 2.95048H9.93073L11.2327 1.64634H2.5393C0.857216 1.64634 0 2.48877 0 4.15742V13.4889C0 15.1657 0.857216 16 2.5393 16ZM5.48293 10.7511L7.05991 10.0625L14.6131 2.50497L13.5052 1.41143L5.96006 8.96896L5.23224 10.4919C5.16754 10.6295 5.32929 10.8158 5.48293 10.7511ZM15.2115 1.91365L15.7937 1.31423C16.0687 1.02262 16.0687 0.633807 15.7937 0.366498L15.6078 0.172092C15.3571 -0.0790163 14.9608 -0.0466151 14.694 0.212593L14.1036 0.795811L15.2115 1.91365Z"
                                fill="black" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <x-suggestion-modal />
    </main>
    @push('scripts')
        <!-- SweetAlert2 JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.all.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectContainer = document.querySelector('.select-container');
                const selectButton = selectContainer.querySelector('.select-button');
                const selectOptions = selectContainer.querySelector('.options');
                const selectArrow = selectContainer.querySelector('#arrow');
                const inputBusca = document.querySelector('.input-estilizado');
                const tecnologias = document.querySelectorAll('.my-custom-bg > div');

                let selectedCategoryId = 'todas';

                // Função para abrir/fechar dropdown
                function toggleDropdown() {
                    const isOpen = selectOptions.classList.contains('show');
                    if (isOpen) {
                        selectOptions.classList.remove('show');
                        selectArrow.classList.remove('up');
                    } else {
                        selectOptions.classList.add('show');
                        selectArrow.classList.add('up');
                    }
                }

                // Função para fechar dropdown
                function closeDropdown() {
                    selectOptions.classList.remove('show');
                    selectArrow.classList.remove('up');
                }

                function filtrarTecnologiasCategoria() {
                    tecnologias.forEach(tecnologia => {
                        const matchCategoria = selectedCategoryId === 'Todas' || tecnologia.getAttribute(
                            'data-categoria-id') === selectedCategoryId;
                        tecnologia.style.display = (matchCategoria) ? 'block' : 'none';
                    });
                }

                function filtrarTecnologias() {
                    const termoBusca = inputBusca.value.toLowerCase();

                    const tecnologiasInput = document.querySelectorAll('.tecnologia');
                    console.log(selectedCategoryId, termoBusca);
                    tecnologiasInput.forEach(tecnologia => {
                        console.log(tecnologia);
                        const nome = tecnologia.querySelector('p').textContent.toLowerCase();
                        const textoTotal = tecnologia.textContent.toLowerCase();
                        const matchBusca = nome.includes(termoBusca) || textoTotal.includes(termoBusca);
                        tecnologia.style.display = (matchBusca) ? 'flex' : 'none';
                    });
                }

                // Event listeners para o select customizado
                selectButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleDropdown();
                });

                // Event listener para as opções

                selectOptions.addEventListener('click', function(e) {
                    // Handle X icon click to remove selection
                    if (e.target.classList.contains('x-icon')) {
                        e.stopPropagation();
                        const option = e.target.closest('.option');
                        if (option) {
                            // Remove selection and reset category filter
                            selectButton.querySelector('span').textContent = 'Categoria';
                            selectedCategoryId = '';
                            closeDropdown();
                            filtrarTecnologiasCategoria();
                        }
                        return;
                    }

                    let option = e.target;

                    // Find the option element if clicked on child elements
                    if (!option.classList.contains('option')) {
                        option = option.closest('.option');
                    }

                    if (option && option.classList.contains('option')) {
                        e.stopPropagation();

                        // Remove selected state from all options
                        selectOptions.querySelectorAll('.option').forEach(opt => {
                            opt.classList.remove('selected');
                            opt.classList.add('opacity-50');
                            opt.querySelector('.check-icon').style.display = 'none';
                            opt.querySelector('.x-icon').style.display = 'none';
                        });

                        // Add selected state to clicked option
                        option.classList.add('selected');
                        option.classList.remove('opacity-50');
                        option.querySelector('.check-icon').style.display = 'inline';
                        option.querySelector('.x-icon').style.display = 'inline';

                        const value = option.getAttribute('data-value');
                        const text = option.querySelector('.option-content') ? option.querySelector(
                            '.option-content').textContent : option.textContent;
                        selectButton.querySelector('span').textContent = text;
                        selectedCategoryId = value || text;
                        closeDropdown();
                        filtrarTecnologiasCategoria();
                    }
                });

                // Fechar dropdown ao clicar fora
                document.addEventListener('click', function(e) {
                    if (!selectContainer.contains(e.target)) {
                        closeDropdown();
                    }
                });

                inputBusca.addEventListener('input', filtrarTecnologias);
            });



            // Funcionalidade do Modal de Sugestão
            const suggestionModal = document.getElementById("suggestionModal");
            const suggestionForm = document.getElementById("suggestionForm");
            const suggestionSuccess = document.getElementById("suggestionSuccess");
            const openSuggestionModal = document.getElementById(
                "openSuggestionModal"
            );
            const closeSuggestionModal = document.getElementById(
                "closeSuggestionModal"
            );
            const closeSuccessModal = document.getElementById("closeSuccessModal");
            const sendSuggestion = document.getElementById("sendSuggestion");
            const suggestionText = document.getElementById("suggestionText");

            // Abrir modal
            openSuggestionModal.addEventListener("click", () => {
                suggestionModal.classList.remove("hidden");
                suggestionForm.classList.remove("hidden");
                suggestionSuccess.classList.add("hidden");
                suggestionText.value = "";
            });

            // Fechar modal - botão voltar do formulário
            closeSuggestionModal.addEventListener("click", () => {
                suggestionModal.classList.add("hidden");
            });

            // Fechar modal - botão voltar do sucesso
            closeSuccessModal.addEventListener("click", () => {
                suggestionModal.classList.add("hidden");
            });

            // Fechar modal clicando fora
            suggestionModal.addEventListener("click", (e) => {
                if (e.target === suggestionModal) {
                    suggestionModal.classList.add("hidden");
                }
            });

            // Enviar sugestão
            sendSuggestion.addEventListener("click", () => {
                const suggestion = suggestionText.value.trim();

                if (suggestion) {
                    // Simula envio da sugestão
                    suggestionForm.classList.add("hidden");
                    suggestionSuccess.classList.remove("hidden");
                } else {
                    alert("Por favor, digite sua sugestão antes de enviar.");
                }
            });

            // Fechar modal com tecla ESC
            document.addEventListener("keydown", (e) => {
                if (
                    e.key === "Escape" &&
                    !suggestionModal.classList.contains("hidden")
                ) {
                    suggestionModal.classList.add("hidden");
                }
            });
        </script>
    @endpush
</x-layout-user>
