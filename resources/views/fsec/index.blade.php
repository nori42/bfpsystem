@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-search for='building plan' />
        @if (session()->get('searchQuery'))
            @php
                $message = "\"" . session()->get('searchQuery') . "\"" . ' Returns no result';
            @endphp
            <x-toast :message="$message" />
        @endif
        @if (session()->get('toastMssg'))
            <x-toast :message="session()->get('toastMssg')" />
        @endif
        <x-pageWrapper>
            <div class="d-flex justify-content-center">
                <div>
                    <div class="text-secondary fw-bold text-center">Click To Add New Application</div>
                    <a href="/fsec/create" class="btn btn-success px-5 py-2 mt-md-1 fs-4">
                        <span class="material-symbols-outlined align-middle fs-3">
                            assignment_add
                        </span>
                        New Building Plan Application
                    </a>
                </div>
            </div>
            <iframe id="iFramePending" src="{{ env('APP_URL') . '/fsec/pending' }}" frameborder="0" width="100%"
                height="800px"></iframe>
        </x-pageWrapper>
    </div>
@endsection
