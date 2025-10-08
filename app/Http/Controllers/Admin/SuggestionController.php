<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    /**
     * Lista as sugestões enviadas pelos usuários
     */
    public function index(Request $request)
    {
        $query = Suggestion::with('user')->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('suggestion_text', 'LIKE', "%{$search}%")
                  ->orWhere('url', 'LIKE', "%{$search}%");
            });
        }

        $suggestions = $query->paginate(15)->appends($request->query());

        $statusOptions = Suggestion::getStatusOptions();

        return view('admin.suggestions.index', compact('suggestions', 'statusOptions'));
    }

    /**
     * Atualiza status/notas da sugestão (flag de respondido)
     */
    public function update(Request $request, Suggestion $suggestion)
    {
        $data = $request->validate([
            'responded'   => ['nullable', 'boolean'],
            'status'      => ['nullable', 'in:pending,reviewed,implemented,rejected'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        if (array_key_exists('responded', $data)) {
            $suggestion->status = $data['responded'] ? Suggestion::STATUS_REVIEWED : Suggestion::STATUS_PENDING;
        }

        if (!empty($data['status'])) {
            $suggestion->status = $data['status'];
        }

        if (array_key_exists('admin_notes', $data)) {
            $suggestion->admin_notes = $data['admin_notes'];
        }

        $suggestion->save();

        return redirect()->route('admin.suggestions.index')->with('success', 'Sugestão atualizada com sucesso.');
    }
}