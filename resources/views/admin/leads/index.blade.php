@extends('layouts.admin-krayin')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3/dist/tailwind.min.css">
    <style>
        /* personalização leve para Kanban e cards */
        .kanban-column {
            min-width: 250px;
        }
    </style>
@endpush

@section('page_title', 'Leads')

@section('content-wrapper')
    <div class="space-y-8">
        {{-- 🧾 Resumo das leads --}}
        <div class="flex space-x-4">
            <div class="p-4 bg-white rounded shadow flex-1">
                <h3 class="text-lg font-semibold">Total de Leads</h3>
                <p class="text-3xl">{{ $counts['total'] }}</p>
            </div>
            <div class="p-4 bg-white rounded shadow flex-1">
                <h3 class="text-lg font-semibold text-green-600">Leads Ganhos</h3>
                <p class="text-3xl">{{ $counts['won'] }}</p>
            </div>
            <div class="p-4 bg-white rounded shadow flex-1">
                <h3 class="text-lg font-semibold text-red-600">Leads Perdidos</h3>
                <p class="text-3xl">{{ $counts['lost'] }}</p>
            </div>
        </div>

        {{-- 📊 Kanban básico --}}
        <div class="flex space-x-4 overflow-auto">
            @foreach ($pipelines as $status => $leads)
                <div class="kanban-column bg-gray-100 rounded p-2">
                    <h4 class="font-semibold mb-2">{{ ucfirst($status) }} ({{ count($leads) }})</h4>
                    @foreach ($leads as $lead)
                        <div class="p-2 bg-white rounded shadow mb-2">
                            <strong>{{ $lead->title }}</strong><br>
                            <small>{{ $lead->contact_name }}</small>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Ex: permitir drag & drop simples com SortableJS
    </script>
@endpush
