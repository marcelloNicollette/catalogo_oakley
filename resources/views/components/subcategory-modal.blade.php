@props([
    'categories' => [],
    'subcategory' => null,
])
<style>
    .z-51 {
        z-index: 51;
    }
</style>
<!-- Modal de Subcategoria -->
<div id="subcategoryModal" x-data="{
    show: false,
    loading: false,
    subcategory: @js($subcategory),
    categories: @js($categories),
    form: {
        id: @js($subcategory->id ?? null),
        category_id: @js($subcategory->category_id ?? ''),
        faixa: @js($subcategory->faixa ?? ''),
        slug: @js($subcategory->slug ?? ''),
        order: @js($subcategory->order ?? 0),
        active: @js($subcategory->active ?? true)
    },
    errors: {},
    mode: 'create', // 'create' ou 'edit'

    openModal(mode = 'create', subcategory = null) {
        this.mode = mode;
        this.errors = {};

        if (mode === 'edit' && subcategory) {
            this.form = {
                id: subcategory.id,
                category_id: subcategory.category_id,
                faixa: subcategory.faixa,
                slug: subcategory.slug,
                order: subcategory.order,
                active: subcategory.active
            };
        } else {
            this.form = {
                id: null,
                category_id: '',
                faixa: '',
                slug: '',
                order: 0,
                active: true
            };
        }

        this.show = true;
        document.body.classList.add('overflow-hidden');
    },

    closeModal() {
        this.show = false;
        this.errors = {};
        document.body.classList.remove('overflow-hidden');
    },

    generateSlug() {
        if (this.form.faixa && !this.form.slug) {
            this.form.slug = this.form.faixa
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        }
    },

    async submitForm() {
        this.loading = true;
        this.errors = {};

        try {
            const url = this.mode === 'edit' ?
                `/admin/subcategories/${this.form.id}` :
                '/admin/subcategories';

            const method = this.mode === 'edit' ? 'PUT' : 'POST';

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name=csrf-token]').content);

            if (method === 'PUT') {
                formData.append('_method', 'PUT');
            }

            Object.keys(this.form).forEach(key => {
                if (key !== 'id') {
                    formData.append(key, this.form[key]);
                }
            });

            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (response.ok) {
                this.closeModal();
                // Recarregar a página ou atualizar a lista
                window.location.reload();
            } else {
                this.errors = data.errors || {};
            }
        } catch (error) {
            console.error('Erro ao salvar subcategoria:', error);
            this.errors = { general: ['Erro interno do servidor'] };
        } finally {
            this.loading = false;
        }
    }
}" x-show="show" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @keydown.escape.window="closeModal()"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-51" style="display: none;">

    <!-- Modal Content -->
    <div @click.away="closeModal()" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">

        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900"
                    x-text="mode === 'edit' ? 'Editar Subcategoria' : 'Nova Subcategoria'"></h3>
            </div>
            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Form -->
        <form @submit.prevent="submitForm()" class="p-6">
            <!-- Mensagens de erro gerais -->
            <div x-show="errors.general" class="mb-4 bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Erro na validação</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <template x-for="error in errors.general">
                                <p x-text="error"></p>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Categoria -->
                <div>
                    <label for="modal_category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Categoria <span class="text-red-500">*</span>
                    </label>
                    <select x-model="form.category_id" id="modal_category_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        :class="errors.category_id ? 'border-red-500' : 'border-gray-300'">
                        <option value="">Selecione uma categoria</option>
                        <template x-for="category in categories" :key="category.id">
                            <option :value="category.id"
                                x-text="category.name + ' - ' + (category.segmentacao ? category.segmentacao.segmento : 'Sem segmento')">
                            </option>
                        </template>
                    </select>
                    <template x-if="errors.category_id">
                        <p class="mt-1 text-sm text-red-600" x-text="errors.category_id[0]"></p>
                    </template>
                </div>

                <!-- Faixa -->
                <div>
                    <label for="modal_faixa" class="block text-sm font-medium text-gray-700 mb-2">
                        Faixa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" x-model="form.faixa" @input="generateSlug()" id="modal_faixa" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        :class="errors.faixa ? 'border-red-500' : 'border-gray-300'"
                        placeholder="Ex: Infantil, Adulto, Juvenil">
                    <template x-if="errors.faixa">
                        <p class="mt-1 text-sm text-red-600" x-text="errors.faixa[0]"></p>
                    </template>
                </div>

                <!-- Slug -->
                <div>
                    <label for="modal_slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Slug
                    </label>
                    <input type="text" x-model="form.slug" id="modal_slug"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        :class="errors.slug ? 'border-red-500' : 'border-gray-300'"
                        placeholder="Será gerado automaticamente se deixado em branco">
                    <p class="mt-1 text-xs text-gray-500">Se deixado em branco, será gerado automaticamente baseado na
                        faixa</p>
                    <template x-if="errors.slug">
                        <p class="mt-1 text-sm text-red-600" x-text="errors.slug[0]"></p>
                    </template>
                </div>

                <!-- Ordem -->
                <div>
                    <label for="modal_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Ordem
                    </label>
                    <input type="number" x-model="form.order" id="modal_order" min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        :class="errors.order ? 'border-red-500' : 'border-gray-300'" placeholder="0">
                    <p class="mt-1 text-xs text-gray-500">Ordem de exibição (0 = primeira posição)</p>
                    <template x-if="errors.order">
                        <p class="mt-1 text-sm text-red-600" x-text="errors.order[0]"></p>
                    </template>
                </div>
            </div>

            <!-- Status Ativo -->
            <div class="mt-6 flex items-center">
                <input type="checkbox" x-model="form.active" id="modal_active"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="modal_active" class="ml-2 block text-sm text-gray-900">
                    Subcategoria ativa
                </label>
            </div>

            <!-- Botões de ação -->
            <div class="mt-8 flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <button type="button" @click="closeModal()"
                    class="flex items-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </button>

                <button type="submit" :disabled="loading"
                    class="flex items-center bg-blue-500 hover:bg-blue-600 disabled:bg-blue-300 text-white font-semibold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <svg x-show="!loading" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    <svg x-show="loading" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span
                        x-text="loading ? 'Salvando...' : (mode === 'edit' ? 'Atualizar' : 'Criar') + ' Subcategoria'"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Funções globais para abrir o modal
    window.openSubcategoryModal = function(mode = 'create', subcategory = null) {
        const modal = Alpine.$data(document.getElementById('subcategoryModal'));
        modal.openModal(mode, subcategory);
    };

    window.closeSubcategoryModal = function() {
        const modal = Alpine.$data(document.getElementById('subcategoryModal'));
        modal.closeModal();
    };
</script>
