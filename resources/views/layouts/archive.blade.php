{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')


{{-- PHP SCRIPT --}}
@php
    $currentArchive = explode('/', Route::current()->uri)[1];
@endphp

@section('stylesheet')
    <style>
        .dropdown-item:active {
            background-color: var(--primary-color);
        }
    </style>
@endsection
{{-- PUT CONTENT TO LAYOUT/TEMPLATE --}}
@section('content')
    <div class="page-content">
        {{-- Put page content here --}}
        <x-pageWrapper>
            @php
                $currentRoute = explode('/', Route::current()->uri())[1];
            @endphp
            <div class="d-flex align-items-center gap-5">
                <div style="width:230px;">
                    <div class="fs-3 fw-semibold">Archive</div>
                    <div class="text-secondary">List of deleted
                        {{ $currentRoute == 'fsec' ? 'building plans' : $currentRoute }}</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3 my-3">
                <div>
                    <button type="button" class="btn btn-primary py-2 px-5" data-bs-toggle="dropdown" aria-expanded="false">
                        @switch($currentArchive)
                            @case('establishments')
                                Establishments
                            @break

                            @case('fsec')
                                Building Plan Applications
                            @break

                            @case('users')
                                Users
                            @break

                            @case('fsic')
                                Inspections
                            @break

                            @case('firedrill')
                                Firedrill
                            @break

                            @default
                        @endswitch
                        <i class="bi bi-caret-down-fill"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item fs-5" href="/archived/establishments">Establishments</a></li>
                        <li><a class="dropdown-item fs-5" href="/archived/fsec">Building Plan Applications</a></li>
                        <li><a class="dropdown-item fs-5" href="/archived/users">Users</a>
                        <li><a class="dropdown-item fs-5" href="/archived/fsic">Inspections</a>
                        <li><a class="dropdown-item fs-5" href="/archived/firedrill">Firedrill</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div id="content">
                @yield('archiveContent')
            </div>
        </x-pageWrapper>
    </div>
@endsection

@section('page-script')
    <script>
        function goTo(route) {
            document.querySelector('#content').innerHTML = '<h2 class="text-center text-secondary">Fetching data...</h2>'
            location.href = '/archived/' + route
        }
        document.querySelector('#establishment').addEventListener('click', () => goTo('establishments'))
        document.querySelector('#users').addEventListener('click', () => goTo('users'))
        document.querySelector('#buildingPlan').addEventListener('click', () => goTo('fsec'))
    </script>
@endsection
