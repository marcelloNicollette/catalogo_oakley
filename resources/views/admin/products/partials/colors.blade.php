<fieldset class="border border-1 mb-4">
    <legend class="block text-sm font-medium text-gray-700">Cores disponíveis</legend>
    <div x-data="cores()" x-init="init()" class="space-y-4">
        <template x-for="(campo, index) in campos" :key="index">
            <div
                class="grid grid-cols-1 md:grid-cols-[1fr_1fr_1fr_1fr_1fr_auto] gap-2 bg-white border border-gray-200 rounded-lg p-4 shadow">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cor (Title)</label>
                    <input type="text" :name="`color_name[]`" x-model="campo.color_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Descrição</label>
                    <input type="text" :name="`color_description[]`" x-model="campo.color_description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Color Code</label>
                    <input type="text" :name="`color_code[]`" x-model="campo.color_code"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gênero</label>
                    <select :name="`color_genero[]`" x-model="campo.color_genero"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="infantil">Infantil</option>
                        <option value="masculino">Masculino</option>
                        <option value="feminino">Feminino</option>
                        <option value="unissex">Unissex</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Coleção</label>
                    <select :name="`color_collection_id[]`" x-model="campo.color_collection_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                        <option value="">Selecione uma coleção</option>
                        @foreach ($collections as $collection)
                            <option value="{{ $collection->id }}">
                                {{ $collection->codigo_colecao . ' - ' . $collection->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Flag</label>
                    <select :name="`color_flag_product_id[]`" x-model="campo.color_flag_product_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                        <option value="">Selecione a Flag</option>
                        @foreach ($flags as $flag)
                            <option value="{{ $flag->id }}">{{ $flag->flag_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-6 flex items-start justify-start w-auto space-x-2">
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
