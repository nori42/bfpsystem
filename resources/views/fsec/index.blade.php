@extends('layouts.app')

{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-dashboard for='building plan' />
        <x-pageWrapper>
            <div class="d-flex justify-content-center">
                <a href="/fsec/create" class="btn btn-success mt-3 fs-5">
                    <span class="material-symbols-outlined align-middle">
                        assignment_add
                    </span>
                    New Building Plan
                </a>
            </div>
        </x-pageWrapper>
    </div>
@endsection
