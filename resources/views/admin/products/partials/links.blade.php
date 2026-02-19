<fieldset class="border border-1 mb-4">
    <legend class="block text-sm font-medium text-gray-700">Arquivos ou Links</legend>
    <div x-data="links" class="space-y-4">
        <template x-for="(campo, index) in campos" :key="index">
            <div
                class="grid grid-cols-1 md:grid-cols-[1fr_1fr_auto] gap-2 bg-white border border-gray-200 rounded-lg p-4 shadow">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" :name="`link_title[]`" x-model="campo.link_title"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">URL</label>
                    <input type="text" :name="`link_url[]`" x-model="campo.link_url"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required placeholder="http://" />
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Classificações com acesso</label>
                    <div class="space-y-1">
                        @php
                            $accessLevels = ['representante', 'interno', 'fornecedor', 'convidado', 'cliente'];
                        @endphp
                        @foreach ($accessLevels as $level)
                            <label class="inline-flex items-center mr-4">
                                <input type="checkbox" :name="`access_levels[${index}][]`"
                                    :value="'{{ $level }}'"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    x-model="campo.access_levels">
                                <span class="ml-2 text-sm text-gray-600">{{ ucfirst($level) }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Se nenhuma classificação for marcada, o link ficará visível
                        para todos os usuários logados.</p>
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
