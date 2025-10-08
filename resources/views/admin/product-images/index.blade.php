@extends('layouts.admin-layout')

@section('page_title', 'Upload de Imagens de Produtos')

@section('content-wrapper')
    <div class="content-full">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-6 text-gray-800">Upload de Imagens de Produtos</h2>

            <form method="POST" action="{{ route('admin.product-images.store') }}" enctype="multipart/form-data"
                id="upload-form">
                @csrf

                <!-- Drag & Drop Zone -->
                <div id="drop-zone"
                    class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center transition-all duration-300 hover:border-indigo-400 hover:bg-indigo-50 cursor-pointer group">
                    <div class="space-y-4">
                        <div
                            class="mx-auto w-16 h-16 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p
                                class="text-lg font-medium text-gray-700 group-hover:text-indigo-600 transition-colors duration-300">
                                Arraste suas imagens aqui
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                ou <span class="text-indigo-600 font-medium">clique para selecionar</span>
                            </p>
                            <p class="text-xs text-gray-400 mt-2">
                                Máximo 600KB por imagem • jpg
                            </p>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="drop-zone-loading"
                        class="hidden absolute inset-0 bg-indigo-50 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto"></div>
                            <p class="text-indigo-600 mt-2 font-medium">Processando imagens...</p>
                        </div>
                    </div>

                    <!-- Drag Over State -->
                    <div id="drop-zone-active"
                        class="hidden absolute inset-0 bg-indigo-100 border-indigo-400 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <div class="mx-auto w-16 h-16 text-indigo-600">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-lg font-bold text-indigo-600">Solte as imagens aqui!</p>
                        </div>
                    </div>
                </div>

                <input type="file" name="images[]" multiple accept=".jpg,image/jpeg,image/jpg" id="file-input" class="hidden" />

                <!-- Preview Area -->
                <div id="preview-container" class="hidden mt-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">Imagens Selecionadas</h3>
                    <div id="preview-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                </div>

                <!-- Upload Progress -->
                <div id="upload-progress" class="hidden mt-6">
                    <div class="bg-gray-200 rounded-full h-2">
                        <div id="progress-bar" class="bg-indigo-600 h-2 rounded-full transition-all duration-300"
                            style="width: 0%"></div>
                    </div>
                    <p id="progress-text" class="text-sm text-gray-600 mt-2">Preparando upload...</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 mt-6">
                    <button type="submit" id="upload-btn"
                        class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 12l2 2 4-4"></path>
                            </svg>
                            Fazer Upload das Imagens
                        </span>
                    </button>
                    <button type="button" id="clear-btn"
                        class="px-6 py-3 bg-gray-500 text-white rounded-lg font-medium hover:bg-gray-600 transition-colors duration-200 disabled:opacity-50"
                        disabled>
                        Limpar Seleção
                    </button>
                </div>

                @error('images.*')
                    <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ $message }}
                    </div>
                @enderror

                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-700">
                        <strong>Dica:</strong> Se o nome já existir, o arquivo anterior será substituído automaticamente.
                    </p>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.product-images.sync') }}"
                class="mt-6 pt-6 border-t border-gray-200">
                @csrf
                <button type="submit"
                    class="px-6 py-3 bg-gray-700 text-white rounded-lg font-medium hover:bg-gray-800 transition-colors duration-200">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Sincronizar com pasta public/images/produtos
                    </span>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white shadow-sm rounded p-6">
                <h3 class="text-lg font-semibold mb-3">Imagens cadastradas (Banco)</h3>
                <div class="mb-3">
                    <input type="text" id="search-images" placeholder="Pesquisar por nome..."
                        class="border rounded p-2 w-full" />
                </div>
                <div id="image-cards">
                    @include('admin.product-images.partials.cards', ['dbImages' => $dbImages])
                </div>

                <div class="mt-4">{{ $dbImages->links() }}</div>
            </div>


        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // Search functionality (existing)
            var typingTimer;
            var doneTypingInterval = 300; // ms
            var $input = $('#search-images');

            function performSearch(query) {
                $.ajax({
                    url: '{{ route('admin.product-images.search') }}',
                    method: 'GET',
                    data: {
                        q: query
                    },
                    success: function(html) {
                        $('#image-cards').html(html);
                    }
                });
            }

            $input.on('keyup', function() {
                clearTimeout(typingTimer);
                var q = $(this).val();
                typingTimer = setTimeout(function() {
                    performSearch(q);
                }, doneTypingInterval);
            });

            $input.on('keydown', function() {
                clearTimeout(typingTimer);
            });

            // Paginação AJAX dentro dos cards
            $('#image-cards').on('click', 'nav a, .pagination a', function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                var q = $('#search-images').val();
                if (href.indexOf('?') === -1) {
                    href += '?';
                } else {
                    href += '&';
                }
                href += 'q=' + encodeURIComponent(q || '');
                $.get(href, function(html) {
                    $('#image-cards').html(html);
                });
            });

            // Drag & Drop Upload System
            const dropZone = document.getElementById('drop-zone');
            const dropZoneActive = document.getElementById('drop-zone-active');
            const dropZoneLoading = document.getElementById('drop-zone-loading');
            const fileInput = document.getElementById('file-input');
            const previewContainer = document.getElementById('preview-container');
            const previewGrid = document.getElementById('preview-grid');
            const uploadBtn = document.getElementById('upload-btn');
            const clearBtn = document.getElementById('clear-btn');
            const uploadProgress = document.getElementById('upload-progress');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            const uploadForm = document.getElementById('upload-form');

            let selectedFiles = [];
            const maxFileSize = 600 * 1024; // 600KB
            const allowedTypes = ['image/jpeg', 'image/jpg'];

            // File validation
            function validateFile(file) {
                const errors = [];

                if (!allowedTypes.includes(file.type)) {
                    errors.push(`${file.name}: Tipo de arquivo não permitido. Use apenas .jpg.`);
                }

                const lowerName = file.name.toLowerCase();
                if (!lowerName.endsWith('.jpg')) {
                    errors.push(`${file.name}: Extensão inválida. O arquivo deve terminar com .jpg.`);
                }

                if (file.size > maxFileSize) {
                    errors.push(`${file.name}: Arquivo muito grande. Máximo 600KB.`);
                }

                return errors;
            }

            // Show validation errors
            function showErrors(errors) {
                if (errors.length > 0) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg';
                    errorDiv.innerHTML = '<ul class="list-disc list-inside">' +
                        errors.map(error => `<li>${error}</li>`).join('') + '</ul>';

                    // Remove existing error messages
                    const existingErrors = document.querySelectorAll('.bg-red-100');
                    existingErrors.forEach(el => {
                        if (el.querySelector('ul')) el.remove();
                    });

                    uploadForm.appendChild(errorDiv);

                    setTimeout(() => {
                        errorDiv.remove();
                    }, 5000);
                }
            }

            // Create preview card
            function createPreviewCard(file, index) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const card = document.createElement('div');
                    card.className =
                        'relative group bg-gray-50 rounded-lg overflow-hidden border-2 border-gray-200 hover:border-indigo-300 transition-all duration-200';
                    card.innerHTML = `
                        <div class="aspect-square">
                            <img src="${e.target.result}" alt="${file.name}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-3">
                            <p class="text-sm font-medium text-gray-700 truncate" title="${file.name}">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
                        </div>
                        <button type="button" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600" onclick="removeFile(${index})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    `;
                    previewGrid.appendChild(card);
                };
                reader.readAsDataURL(file);
            }

            // Remove file from selection
            window.removeFile = function(index) {
                selectedFiles.splice(index, 1);
                updatePreview();
                updateFileInput();
                updateButtons();
            };

            // Update preview display
            function updatePreview() {
                previewGrid.innerHTML = '';
                if (selectedFiles.length > 0) {
                    previewContainer.classList.remove('hidden');
                    selectedFiles.forEach((file, index) => {
                        createPreviewCard(file, index);
                    });
                } else {
                    previewContainer.classList.add('hidden');
                }
            }

            // Update file input with selected files
            function updateFileInput() {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            }

            // Update button states
            function updateButtons() {
                const hasFiles = selectedFiles.length > 0;
                uploadBtn.disabled = !hasFiles;
                clearBtn.disabled = !hasFiles;
            }

            // Handle file selection
            function handleFiles(files) {
                const fileArray = Array.from(files);
                const errors = [];

                fileArray.forEach(file => {
                    const fileErrors = validateFile(file);
                    if (fileErrors.length === 0) {
                        // Check for duplicates
                        const isDuplicate = selectedFiles.some(existing =>
                            existing.name === file.name && existing.size === file.size
                        );
                        if (!isDuplicate) {
                            selectedFiles.push(file);
                        }
                    } else {
                        errors.push(...fileErrors);
                    }
                });

                if (errors.length > 0) {
                    showErrors(errors);
                }

                updatePreview();
                updateFileInput();
                updateButtons();
            }

            // Drag and drop events
            dropZone.addEventListener('click', () => fileInput.click());

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-indigo-400', 'bg-indigo-50');
                dropZoneActive.classList.remove('hidden');
            });

            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                if (!dropZone.contains(e.relatedTarget)) {
                    dropZone.classList.remove('border-indigo-400', 'bg-indigo-50');
                    dropZoneActive.classList.add('hidden');
                }
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-400', 'bg-indigo-50');
                dropZoneActive.classList.add('hidden');

                const files = e.dataTransfer.files;
                handleFiles(files);
            });

            // File input change
            fileInput.addEventListener('change', (e) => {
                handleFiles(e.target.files);
            });

            // Clear selection
            clearBtn.addEventListener('click', () => {
                selectedFiles = [];
                updatePreview();
                updateFileInput();
                updateButtons();
            });

            // Form submission with progress
            uploadForm.addEventListener('submit', function(e) {
                if (selectedFiles.length === 0) {
                    e.preventDefault();
                    return;
                }

                // Show progress
                uploadProgress.classList.remove('hidden');
                uploadBtn.disabled = true;
                clearBtn.disabled = true;

                // Simulate progress (since we can't track real progress with standard form submission)
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += Math.random() * 15;
                    if (progress > 90) progress = 90;

                    progressBar.style.width = progress + '%';
                    progressText.textContent = `Enviando imagens... ${Math.round(progress)}%`;
                }, 200);

                // Clean up on page unload
                window.addEventListener('beforeunload', () => {
                    clearInterval(progressInterval);
                });
            });

            // Initialize
            updateButtons();
        });
    </script>
@endpush
