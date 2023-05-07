@extends('layouts.app')


@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-dashboard for="establishment" />
        @if (session()->get('MSSG'))
            <h5 class="text-danger">"{{ session()->get('SEARCH') }}" Returns {{ session()->get('MSSG') }}</h5>
        @endif
        <x-pageWrapper>
            <div class="d-flex justify-content-center">

                @if (auth()->user()->type === 'FSIC' || auth()->user()->type === 'ADMIN')
                    <a class="btn btn-success text-white px-5 py-2 align-middle mt-3" href="/establishments/create"><span
                            class="material-symbols-outlined align-middle">domain_add</span> New Establishment</a>
                @endif
            </div>
        </x-pageWrapper>
    </div>
@endsection
