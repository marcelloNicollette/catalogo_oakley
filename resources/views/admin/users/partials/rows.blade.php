@foreach ($users as $user)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-sm font-medium text-gray-700">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </span>
                    </div>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ str($user->name)->limit(20) }}</div>

                    <div class="text-sm text-gray-600">
                        Empresa: {{ str($user->company)->limit(15) }}
                        Setor: {{ $user->company->setor ?? '-' }}
                        Phone: {{ $user->company->phone ?? '-' }}
                    </div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->type === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                {{ ucfirst($user->type) }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $user->codigo_lider_comercial ?? '-' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            @if ($user->collection)
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                    {{ $user->collection->name }}
                </span>
            @else
                <span class="text-gray-400">Nenhuma</span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.show', $user) }}"
                    class="flex items-center text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Ver
                </a>
                @if ($user_login->type === 'admin' && $user_login->classification === null)
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="flex items-center text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Editar
                    </a>
                    @if ($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center text-red-600 hover:text-red-900 transition duration-150 ease-in-out"
                                onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Excluir
                            </button>
                        </form>
                        <form action="{{ route('admin.users.reset-password', $user) }}" method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Gerar nova senha para este usuário? A senha será enviada por e-mail.')">
                            @csrf
                            <button type="submit"
                                class="flex items-center text-yellow-600 hover:text-yellow-800 transition duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m0 14v1m7-7h1M4 12H3m15.364-6.364l.707.707M5.636 18.364l-.707.707M18.364 18.364l.707-.707M5.636 5.636l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                                </svg>
                                Gerar nova senha
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </td>
    </tr>
@endforeach
