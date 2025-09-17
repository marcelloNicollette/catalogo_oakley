@extends('layouts.admin-layout')

@push('css')
    <style>
        /* Customizações específicas */
    </style>
@endpush

@section('page_title', 'Dashboard Administrador')

@section('content-wrapper')
    <div class="content-full">
        <h2 class="text-2xl font-semibold">Bem-vindo, {{ auth()->user()->name }}!</h2>
        <p>Use esse painel para gerenciar o sistema.</p>
    </div>
@endsection

@push('scripts')
    <script>
        // Scripts custom para dashboard
    </script>
@endpush
