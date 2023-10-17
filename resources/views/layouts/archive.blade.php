{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')


{{-- PHP SCRIPT --}}
@php
    $currentArchive = explode('/', Route::current()->uri)[1];
@endphp


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
                {{-- <div>
                    <span>
                        <label class="fs-5 fw-semibold" for="establishment">Establishments</label>
                        <input class="fs-3" type="radio" name="link" id="establishment"
                            {{ $currentRoute == 'establishments' ? 'checked' : '' }}>
                    </span>
                    <span class="mx-3">
                        <label class="fs-5 fw-semibold" for="buildingPlan">Building Plan Application</label>
                        <input type="radio" name="link" id="buildingPlan"
                            {{ $currentRoute == 'fsec' ? 'checked' : '' }}>
                    </span>
                    <span class="d-inline">
                        <label class="fs-5 fw-semibold" for="users">Users</label>
                        <input type="radio" name="link" id="users" {{ $currentRoute == 'users' ? 'checked' : '' }}>
                    </span>
                </div> --}}
            </div>
            <div class="d-flex align-items-center gap-3 my-3">
                <div class="fs-5 fw-semibold">
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
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary px-3 py-1 rounded-0" data-bs-toggle="dropdown"
                        aria-expanded="false">
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
