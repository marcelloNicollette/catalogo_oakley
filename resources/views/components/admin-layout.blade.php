@extends('layouts.admin-layout')

@section('content-wrapper')
    @isset($header)
        <div class="mb-6">
            {{ $header }}
        </div>
    @endisset

    {{ $slot }}
@endsection
