<fieldset class="border border-1 mb-4">
    <legend class="block text-sm font-medium text-gray-700">Características do produto</legend>
    <div x-data="caracteristicas()" x-init="init()" class="space-y-4">
        <template x-for="(campo, index) in campos" :key="index">
            <div
                class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-2 bg-white border border-gray-200 rounded-lg p-4 shadow">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" :name="`caracteristica_title[]`" x-model="campo.caracteristica_title"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    <div class="flex items-center space-x-2 mt-1">
                        <label for="" class="text-sm font-medium text-gray-700">Destaque</label>
                        <input type="hidden" :name="`caracteristica_destaque[${index}]`"
                            :value="campo.caracteristica_destaque ? 1 : 0" />
                        <input type="checkbox" :checked="campo.caracteristica_destaque == 1"
                            @change="campo.caracteristica_destaque = $event.target.checked ? 1 : 0" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea :name="`caracteristica_description[]`" x-model="campo.caracteristica_description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        rows="2"></textarea>
                </div>
                <div class="mt-6 flex items-start justify-start w-auto">
                    <button type="button" @click="adicionarCampo()"
                        class="px-3 py-1 h-8 bg-green-500 text-white rounded hover:bg-green-600">+</button>
                    <template x-if="campos.length > 1">
                        <button type="button" @click="removerCampo(index)"
                            class="px-3 py-1 h-8 bg-red-500 text-white rounded hover:bg-red-600">−</button>
                    </template>
                </div>
            </div>
        </template>
    </div>
</fieldset>
