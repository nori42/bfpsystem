@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-dashboard for='building plan' />
        @if (session()->get('searchQuery'))
            @php
                $message = "\"" . session()->get('searchQuery') . "\"" . ' Returns no result';
            @endphp
            <x-toast :message="$message" />
        @endif
        <x-pageWrapper>
            <div class="d-flex justify-content-center">
                <a href="/fsec/create" class="btn btn-success px-5 py-2 mt-3">
                    <span class="material-symbols-outlined align-middle">
                        assignment_add
                    </span>
                    New Building Plan Application
                </a>
            </div>
        </x-pageWrapper>
    </div>
@endsection
