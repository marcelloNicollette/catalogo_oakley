<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserMailable;
use App\Models\Collection;
use App\Models\User;
use App\Services\GmailOAuthMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('collection');
        $user_login = Auth::user();

        $isAjax = $request->ajax();

        // Aplicar filtro de busca se fornecido
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('codigo_lider_comercial', 'LIKE', "%{$search}%")
                    ->orWhere('company', 'LIKE', "%{$search}%")
                    ->orWhere('setor', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('type', 'LIKE', "%{$search}%");
            });
            if ($isAjax) {
                $users = $query->orderBy('name')->get();

                return response()->json([
                    'rowsHtml' => view('admin.users.partials.rows', compact('users', 'user_login'))->render(),
                    'paginationHtml' => '',
                    'total' => $users->count(),
                ]);
            }

            if ($request->filled('page') && (int) $request->get('page') !== 1) {
                $queryParams = $request->query();
                unset($queryParams['page']);
                return redirect()->route('admin.users.index', $queryParams);
            }

            $users = $query->orderBy('name')->get();
            return view('admin.users.index', compact('user_login', 'users'));
        }

        $users = $query->paginate(1000)->appends($request->query());

        if ($isAjax) {
            return response()->json([
                'rowsHtml' => view('admin.users.partials.rows', compact('users', 'user_login'))->render(),
                'paginationHtml' => (string) $users->links(),
                'total' => $users->total(),
            ]);
        }

        return view('admin.users.index', compact('user_login', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $collections = Collection::where('active', true)->get();
        $segmentacoesCliente = \App\Models\SegmentacaoCliente::where('active', true)->get();
        return view('admin.users.create', compact('collections', 'segmentacoesCliente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type' => ['required', 'string', 'in:admin,user,user-adm'],
            'classification' => ['nullable', 'string', 'in:admin-user,representante,interno,fornecedor,convidado,cliente'],
            'collection_id' => ['nullable', 'exists:collections,id'],
            'company' => ['nullable', 'string', 'max:255'],
            'setor' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'codigo_lider_comercial' => ['nullable', 'string', 'max:50'],
            'segmentacoes_cliente' => ['nullable', 'array'],
            'segmentacoes_cliente.*' => ['exists:segmentacao_cliente,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'classification' => $request->classification,
            'collection_id' => $request->collection_id,
            'company' => $request->company,
            'setor' => $request->setor,
            'phone' => $request->phone,
            'codigo_lider_comercial' => $request->codigo_lider_comercial,
        ]);

        // Sincronizar segmentações de cliente
        if ($request->has('segmentacoes_cliente')) {
            $user->segmentacoesCliente()->sync($request->segmentacoes_cliente);
        }

        // Send welcome email with access information
        //$this->sendEmailUser($user, $request->password);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('collection');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $collections = Collection::where('active', true)->get();
        $segmentacoesCliente = \App\Models\SegmentacaoCliente::where('active', true)->get();
        $user->load('segmentacoesCliente');

        return view('admin.users.edit', compact('user', 'collections', 'segmentacoesCliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'type' => ['required', 'string', 'in:admin,user,user-adm'],
            'classification' => ['nullable', 'string', 'in:admin-user,representante,interno,fornecedor,convidado,cliente'],
            'collection_id' => ['nullable', 'exists:collections,id'],
            'company' => ['nullable', 'string', 'max:255'],
            'setor' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'codigo_lider_comercial' => ['nullable', 'string', 'max:50'],
            'segmentacoes_cliente' => ['nullable', 'array'],
            'segmentacoes_cliente.*' => ['exists:segmentacao_cliente,id'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'classification' => $request->classification,
            'collection_id' => $request->collection_id,
            'company' => $request->company,
            'setor' => $request->setor,
            'phone' => $request->phone,
            'codigo_lider_comercial' => $request->codigo_lider_comercial,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Sincronizar segmentações de cliente
        if ($request->has('segmentacoes_cliente')) {
            $user->segmentacoesCliente()->sync($request->segmentacoes_cliente);
        } else {
            // Se não há segmentações de cliente selecionadas, remove todas
            $user->segmentacoesCliente()->detach();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting the current authenticated user
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Você não pode excluir seu próprio usuário!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }

    /**
     * Send welcome email to user.
     */
    public function sendEmailUser(User $user, $password = null)
    {
        $mailer = new GmailOAuthMailer();
        $mailer->send(
            $user->email,
            $user->name,
            'Bem-vindo ao sistema!',
            'emails.user-cadastrado',
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
                'type' => $user->type
            ]
        );
    }

    /**
     * Generate and set a new password for the user, emailing them the new credentials.
     */
    public function resetPassword(Request $request, User $user)
    {
        // Generate a random strong password
        $newPassword = bin2hex(random_bytes(4)) . random_int(10, 99);

        // Update user's password
        $user->password = Hash::make($newPassword);
        $user->save();

        // Email the new password to the user
        //$this->sendEmailUser($user, $newPassword);

        return redirect()->route('admin.users.index')
            ->with('success', 'Nova senha gerada e enviada para o usuário!');
    }
}
