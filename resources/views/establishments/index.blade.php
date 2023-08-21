@extends('layouts.app')


@section('content')
    @php
        $totalSubstation = 0;
        foreach ($issuedThisMonth as $key => $value) {
            if ($key != 'CBP') {
                $totalSubstation += $value;
            }
        }
    @endphp
    <div class="page-content">
        {{-- Put page content here --}}
        <x-search for="establishment" />
        @if (session()->get('searchQuery'))
            @php
                $message = "\"" . session()->get('searchQuery') . "\"" . ' Returns no result';
            @endphp
            <x-toast :message="$message" />
        @endif
        @if (session()->get('deleteSuccess'))
            <x-toast :message="session()->get('deleteSuccess')" />
        @endif
        <x-pageWrapper>
            <div class="d-flex justify-content-center">

                @if (auth()->user()->type === 'FSIC' || auth()->user()->type === 'ADMINISTRATOR')
                    <a class="btn btn-success text-white px-5 py-2 align-middle mt-1" href="/establishments/create"><span
                            class="material-symbols-outlined align-middle">domain_add</span> New Establishment</a>
                @endif
            </div>
        </x-pageWrapper>
    </div>
@endsection
