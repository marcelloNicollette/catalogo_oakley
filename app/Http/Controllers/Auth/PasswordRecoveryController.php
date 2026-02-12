<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Assuming we might need Mail later, but strictly following instruction to register token
use Illuminate\Support\Str;

class PasswordRecoveryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email_recover' => ['required', 'email', 'exists:users,email'],
        ], [
            'email_recover.required' => 'O campo e-mail é obrigatório.',
            'email_recover.email' => 'Por favor, insira um e-mail válido.',
            'email_recover.exists' => 'Não encontramos um usuário com este e-mail.',
        ]);

        $user = User::where('email', $request->email_recover)->first();

        // Generate token and save to remember_token as requested
        $token = Str::random(60);
        $user->forceFill([
            'remember_token' => $token,
        ])->save();

        // TODO: Enviar o e-mail com o link contendo o token.
        // O usuário disse: "depois irei montar uma area para recuperar senha"
        // Então por enquanto apenas geramos o token e salvamos.
        
        // Retornamos com session flash para manipular o modal no front
        return back()->with('password_recovery_status', 'link-sent');
    }
}
