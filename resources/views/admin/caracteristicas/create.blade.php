@extends('layouts.admin-layout')

@push('css')
    <style>
        .collection-card {
            transition: all 0.3s ease;
        }

        .collection-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endpush

@section('page_title', 'Olympikus - Características')

@section('content-wrapper')
    <div class="flex items-center space-x-2 mb-6">
        <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
            </path>
        </svg>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Nova Característica') }}
        </h2>
    </div>


    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            @include('admin.caracteristicas.form', [
                'route' => route('admin.caracteristicas.store'),
                'method' => 'POST',
                'caracteristica' => null,
            ])
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Scripts custom para dashboard
    </script>
@endpush
