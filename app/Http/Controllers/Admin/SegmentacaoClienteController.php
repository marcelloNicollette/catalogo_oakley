<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SegmentacaoCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SegmentacaoClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $segmentacoesCliente = SegmentacaoCliente::with('users')->paginate(10);
        return view('admin.segmentacao-cliente.index', compact('segmentacoesCliente'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.segmentacao-cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['nome']);
        $validated['active'] = $request->has('active');

        SegmentacaoCliente::create($validated);

        return redirect()->route('admin.segmentacao-cliente.index')
            ->with('success', 'Segmentação de cliente criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SegmentacaoCliente $segmentacaoCliente)
    {
        $segmentacaoCliente->load('users');
        return view('admin.segmentacao-cliente.show', compact('segmentacaoCliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SegmentacaoCliente $segmentacaoCliente)
    {
        return view('admin.segmentacao-cliente.edit', compact('segmentacaoCliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SegmentacaoCliente $segmentacaoCliente)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'nullable|string',
            'active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['nome']);
        $validated['active'] = $request->has('active');

        $segmentacaoCliente->update($validated);

        return redirect()->route('admin.segmentacao-cliente.index')
            ->with('success', 'Segmentação de cliente atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SegmentacaoCliente $segmentacaoCliente)
    {
        $segmentacaoCliente->delete();

        return redirect()->route('admin.segmentacao-cliente.index')
            ->with('success', 'Segmentação de cliente removida com sucesso.');
    }
}
