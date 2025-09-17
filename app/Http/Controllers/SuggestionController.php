<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class SuggestionController extends Controller
{
    /**
     * Armazenar uma nova sugestão
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validar os dados recebidos
            $request->validate([
                'suggestion_text' => 'required|string|min:10|max:1000'
            ], [
                'suggestion_text.required' => 'O campo descrição é obrigatório.',
                'suggestion_text.min' => 'A descrição deve ter pelo menos 10 caracteres.',
                'suggestion_text.max' => 'A descrição não pode ter mais de 1000 caracteres.'
            ]);

            // Verificar se o usuário está autenticado
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você precisa estar logado para enviar sugestões.'
                ], 401);
            }

            // Criar a sugestão
            $suggestion = Suggestion::create([
                'user_id' => Auth::id(),
                'suggestion_text' => $request->suggestion_text,
                'url' => $request->current_url ?? $request->header('referer') ?? $request->url(),
                'status' => Suggestion::STATUS_PENDING
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sugestão enviada com sucesso! Obrigado pelo seu feedback.',
                'suggestion_id' => $suggestion->id
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor. Tente novamente mais tarde.'
            ], 500);
        }
    }
}
