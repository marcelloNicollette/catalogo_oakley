<form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST"
    class="space-y-4">
    @csrf
    @if (isset($user))
        @method('PUT')
    @endif

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nome Completo</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required>
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required>
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">
            {{ isset($user) ? 'Nova Senha' : 'Senha' }}
        </label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <input type="password" name="password" id="password"
                class="flex-1 border-gray-300 rounded-l-md focus:ring-blue-500 focus:border-blue-500"
                {{ isset($user) ? '' : 'required' }}
                placeholder="{{ isset($user) ? 'Deixe em branco para manter a senha atual' : '' }}">
            @if (!isset($user))
                <button type="button" id="generatePassword"
                    class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 text-gray-500 text-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    Gerar
                </button>
            @endif
        </div>
        @if (isset($user))
            <p class="mt-1 text-sm text-gray-500">Deixe em branco se não quiser alterar a senha</p>
        @else
            <p class="mt-1 text-sm text-gray-500">Clique em "Gerar" para criar uma senha aleatória de 8 dígitos</p>
        @endif
        @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
            {{ isset($user) ? 'Confirmar Nova Senha' : 'Confirmar Senha' }}
        </label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="{{ isset($user) ? 'Confirme a nova senha' : 'Confirme a senha' }}">
        @error('password_confirmation')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Usuário</label>
        <select name="type" id="type"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required>
            <option value="">Selecione o tipo</option>
            <option value="admin" @selected(old('type', $user->type ?? '') == 'admin')>Administrador</option>
            <option value="user" @selected(old('type', $user->type ?? '') == 'user')>Usuário</option>
        </select>
        @error('type')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="company" class="block text-sm font-medium text-gray-700">Empresa</label>
        <input type="text" name="company" id="company" value="{{ old('company', $user->company ?? '') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('company')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="setor" class="block text-sm font-medium text-gray-700">Setor</label>
        <input type="text" name="setor" id="setor" value="{{ old('setor', $user->setor ?? '') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('setor')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        @error('phone')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="collection_id" class="block text-sm font-medium text-gray-700">Coleção</label>
        <select name="collection_id" id="collection_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Selecione uma coleção (opcional)</option>
            @foreach ($collections as $collection)
                <option value="{{ $collection->id }}" @selected(old('collection_id', $user->collection_id ?? '') == $collection->id)>
                    {{ $collection->name }} - {{ $collection->codigo_colecao }}
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-sm text-gray-500">Selecione a coleção que o usuário poderá visualizar</p>
        @error('collection_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-4 flex justify-end space-x-3">
        <a href="{{ route('admin.users.index') }}"
            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition duration-150 ease-in-out">
            Cancelar
        </a>
        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-150 ease-in-out">
            Salvar
        </button>
    </div>
</form>
