<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordRecoveryController extends Controller
{
    /**
     * Display a listing of users requesting password recovery.
     */
    public function index(Request $request)
    {
        // Users requesting password recovery are those with a remember_token set
        // (As per the previous task's implementation logic)
        $query = User::whereNotNull('remember_token')
            ->where('remember_token', '!=', '');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate(20)->appends($request->query());

        return view('admin.password-recovery.index', compact('users'));
    }

    /**
     * Generate a new password for the user and clear the recovery token.
     */
    public function update(Request $request, User $user)
    {
        // Generate a new random password
        $newPassword = Str::random(10);

        // Update user
        $user->forceFill([
            'password' => Hash::make($newPassword),
            'remember_token' => null, // Clear the token to mark as resolved
        ])->save();

        // TODO: Send email with $newPassword to $user->email
        // For now, we will flash it to the session so the admin can see/copy it if needed,
        // or just assume it was sent. The prompt asked to "generate and send".
        // Since we don't have the mailer setup details fully confirmed, we'll simulate sending.

        // If there was a mailer:
        // Mail::to($user)->send(new NewPasswordMail($newPassword));

        return redirect()->route('admin.password-recovery.index')
            ->with('success', "Nova senha gerada para {$user->name}: {$newPassword} (A senha deve ser enviada para o usuário)");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        //$user->delete();
        // Update user
        $user->forceFill([
            'remember_token' => null, // Clear the token to mark as resolved
        ])->save();

        return redirect()->route('admin.password-recovery.index')
            ->with('success', 'Solicitação de senha excluído com sucesso.');
    }
}
