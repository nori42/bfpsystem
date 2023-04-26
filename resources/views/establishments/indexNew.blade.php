@extends('layouts.app')


@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-dashboard for="establishment" />
        <x-pageWrapper>
            <div class="d-flex justify-content-center">
                <a href="/establishments/create" class="btn btn-success mt-3 fs-5">
                    <span class="material-symbols-outlined align-middle">
                        domain_add
                    </span>
                    New Establishment
                </a>
            </div>
        </x-pageWrapper>
    </div>
@endsection
