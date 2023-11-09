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
                    <div>
                        <div class="text-secondary fw-bold text-center">Click To Add New Establishment</div>
                        <a class="btn btn-primary text-white px-5 py-2 align-middle mt-1 fs-4"
                            href="/establishments/create"><i class="bi bi-building-fill-add"></i> New Establishment</a>
                    </div>
                @endif
            </div>
        </x-pageWrapper>
    </div>
@endsection
