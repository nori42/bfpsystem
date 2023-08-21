{{-- GET LAYOUT/TEMPLATE --}}
@extends('layouts.app')

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
                {{-- Disabled For The Mean Time --}}
                {{-- <div>
                    <span>
                        <label class="fs-5 fw-semibold" for="establishment">Establishments</label>
                        <input class="fs-3" type="radio" name="link" id="establishment"
                            {{ $currentRoute == 'establishments' ? 'checked' : '' }}>
                    </span>
                    <span class="mx-3">
                        <label class="fs-5 fw-semibold" for="buildingPlan">Building Plan</label>
                        <input type="radio" name="link" id="buildingPlan"
                            {{ $currentRoute == 'fsec' ? 'checked' : '' }}>
                    </span>
                    <span class="d-inline">
                        <label class="fs-5 fw-semibold" for="users">Users</label>
                        <input type="radio" name="link" id="users" {{ $currentRoute == 'users' ? 'checked' : '' }}>
                    </span>
                </div> --}}
            </div>
            <div id="content">
                @yield('archiveContent')
            </div>
        </x-pageWrapper>
    </div>

    <script>
        function goTo(route) {
            document.querySelector('#content').innerHTML = '<h2 class="text-center text-secondary">Fetching data...</h2>'
            location.href = '/archived/' + route
        }
        document.querySelector('#establishment').addEventListener('click', () => goTo('establishments'))
        document.querySelector('#buildingPlan').addEventListener('click', () => goTo('fsec'))
        document.querySelector('#users').addEventListener('click', () => goTo('users'))
    </script>
@endsection
