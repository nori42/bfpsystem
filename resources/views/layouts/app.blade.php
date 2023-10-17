<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>

    @vite('resources/sass/bootstrap.scss')
    @vite('resources/css/layout.css')
    {{-- @vite('resources/css/app.css') --}}
    @yield('stylesheet')
</head>

<body>
    <div class="d-flex h-100 w-100">
        {{-- Left Panel --}}
        <nav class="overflow-auto">
            <!--Nav Heading  -->
            <div class="p-4 d-flex flex-column align-items-center justify-content-center">
                <img class="rounded-circle" src="/img/LOGO.PNG" height="100px" width="100px" alt="logo">
                <h1 class="text-white fs-6 fw-bold px-3 text-center my-2">Cebu City Fire Station</h1>
            </div>
            <hr class="p-0 my-1 text-white border-3 w-75 mx-auto border-primary-subtle">
            @switch(auth()->user()->type)
                @case('FSIC')
                    <x-roleLinks.fsic />
                @break

                @case('FIREDRILL')
                    <x-roleLinks.firedrill />
                @break

                @case('FSEC')
                    <x-roleLinks.fsec />
                @break

                @default
                    <x-roleLinks.admin />
            @endswitch
        </nav>
        {{-- Righ Panel --}}
        <div class="page-container d-flex flex-column w-100">

            <!-- PANEL  -->
            <div class="top-panel d-flex justify-content-end p-2 align-items-center" style="position: sticky;">

                {{-- Page Title --}}
                {{-- <h1 class="fs-4 text-white fw-bold mx-5 mt-1">{{ $page_title }}</h1> --}}
                <!-- notification button -->
                @if (auth()->user()->type == 'ADMINISTRATOR' || auth()->user()->type == 'FSIC')
                    <div class="position-relative py-0" dropdown>
                        <button class="btn btn-top-panel rounded-0" dropdown-btn>
                            <i class="bi bi-bell-fill text-white fs-4"></i>
                        </button>

                        <!-- dropdown menu -->
                        <div id="notificationMenu" class="dropdown-profile-menu p-3 border-1 text-white" dropdown-menu
                            style="display:none !important; width:380px; left:calc(-1 * (100% + 180px));">
                            <ul class="list-unstyled">

                                <li class="fw-bold fs-6 ml-5 my-2 text-end">
                                    <div class="d-flex justify-content-between my-3">
                                        <div>Notifications</div>
                                        <a href="/expired/inspections"> View expired list</a>
                                    </div>
                                </li>

                                @if (count($expiredCount['expiredInspections']) == 0)
                                    <li>
                                        There are no notifications to show
                                    </li>
                                @endif

                                @foreach ($expiredCount['expiredInspections'] as $key => $value)
                                    <li>
                                        <a class="btn w-100 text-start text-white"
                                            href="/expired/inspections?dateFrom={{ $key }}&dateTo={{ $key }}">
                                            <span class="fw-bold">{{ count($value) }} Establishment's inspection</span>
                                            expired
                                            @if ($key != date('Y-m-d'))
                                                on
                                            @endif
                                            <span class="text-info">
                                                {{ $key == date('Y-m-d') ? 'today' : date('F d, Y', strtotime($key)) }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                @endif

                <!-- profile button -->
                <div class="position-relative py-0" dropdown style="margin-right: 10% !important;">
                    <button class="btn btn-top-panel rounded-0" dropdown-btn>
                        <i class="bi bi-person-fill text-white fs-3"></i>
                        <!-- icon -->
                        <i class="bi bi-caret-down-fill text-white fs-5"></i>
                    </button>

                    <!-- dropdown menu -->
                    <div id="dropdownMenu" dropdown-menu class="dropdown-profile-menu py-3 px-3 border-1"
                        style="display:none !important; left:calc(-1 * (100% + 75px));">
                        @if (auth()->user()->personnel_id == 0)
                            <div class="fs-6 fw-semibold text-white text-center align-middle">
                                {{ auth()->user()->name }}
                            </div>
                        @else
                            @php
                                $name = auth()->user()->personnel->first_name . ' ' . auth()->user()->personnel->last_name;
                            @endphp
                            <div class="fs-6 fw-semibold text-white text-center align-middle">
                                {{ $name }}
                            </div>
                        @endif
                        <div class="my-0 text-center text-white">{{ auth()->user()->type }}</div>
                        <hr class="text-white">
                        <!-- drop down links -->
                        <div class="d-inline flex-column">
                            @if (auth()->user()->id != 1)
                                <a href="/users/{{ auth()->user()->id }}"
                                    class="btn w-100 text-start text-white fw-semibold"><i
                                        class="bi bi-person-fill text-white fs-5"></i> <span class="mx-3">
                                        Account</span></a>
                            @endif
                            @if (auth()->user()->type == 'ADMINISTRATOR')
                                <a href="/settings" class="btn w-100 text-start text-white fw-semibold"><i
                                        class="bi bi-gear-fill fs-5"></i> <span class="mx-3">Print
                                        Settings</span></a>
                            @endif
                            <a href="/logout" class="btn w-100 text-start text-white fw-semibold"><i
                                    class="bi bi-box-arrow-left fs-5"></i> <span class="mx-3">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DUMP CONTENT HERE --}}
            <div class="overflow-y-auto h-100">
                @yield('content')


                {{-- FOOTER --}}
                <footer></footer>
            </div>
        </div>

        {{-- Global Environment --}}
        <script type="module">
            window.env = {
                APP_URL: "{{ env('APP_URL') }}"
            }
        </script>
    </div>


    @vite(['resources/js/app.js'])
    @yield('component-script')
    @yield('page-script')
</body>

</html>
