<?php

namespace App\Http\Controllers;

use App\Models\UserAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccessRequestController extends Controller
{
    /**
     * List admin access requests.
     */
    public function index()
    {
        try {
            $requests = UserAccess::orderByDesc('created_at')->paginate(20);
            $error = null;
            // Emails já existentes de usuários (apenas da página atual)
            $existingUserEmails = User::whereIn('email', $requests->pluck('email'))
                ->pluck('email')
                ->toArray();
        } catch (\Throwable $e) {
            $requests = collect();
            $error = $e->getMessage();
            $existingUserEmails = [];
        }

        return view('admin.access.index', [
            'requests' => $requests,
            'error' => $error,
            'existingUserEmails' => $existingUserEmails,
        ]);
    }

    /**
     * Store a new access request.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'setor' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        UserAccess::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Solicitação de acesso enviada com sucesso.',
            ], 201);
        }

        return back()->with('success', 'Solicitação de acesso enviada com sucesso.');
    }

    /**
     * Aprovar uma solicitação e converter em usuário.
     */
    public function approve(UserAccess $user_access)
    {
        // Evitar duplicar usuários com o mesmo e-mail
        if (User::where('email', $user_access->email)->exists()) {
            return redirect()->route('admin.access.index')
                ->with('error', 'Já existe um usuário com este e-mail.');
        }

        $plainPassword = Str::random(10);

        // Cria o usuário com os dados da solicitação
        $user = User::create([
            'name' => $user_access->name,
            'email' => $user_access->email,
            'password' => Hash::make($plainPassword),
            'company' => $user_access->company,
            'setor' => $user_access->setor,
            'phone' => $user_access->phone,
            // 'role' terá default 'user' via migration
        ]);

        // Marca a solicitação como aprovada
        $user_access->forceFill([
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ])->save();

        return redirect()->route('admin.access.index')
            ->with('success', 'Usuário criado e solicitação aprovada com sucesso.')
            ->with('new_user_password', $plainPassword)
            ->with('new_user_email', $user->email);
    }

    /**
     * Rejeitar uma solicitação de acesso.
     */
    public function reject(Request $request, UserAccess $user_access)
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $user_access->update([
            'rejected_at' => now(),
            'rejected_by' => Auth::id(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->route('admin.access.index')
            ->with('success', 'Solicitação rejeitada com sucesso.');
    }
}
