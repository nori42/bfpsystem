<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>

    {{-- <link rel="stylesheet" href="/css/styles.css"> --}}
    {{-- <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap-utilities.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap.rtl.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap-grid.css"> --}}
    {{-- <link rel="stylesheet" href="/css/googlefonts.css"> --}}
    @vite(['resources/sass/main.scss'])
    {{-- <script src="/js/tailwind.js"></script> --}}
</head>

<body>
    <div class="d-flex h-100 w-100">
        {{-- Left Panel --}}
        <nav class="d-flex flex-column">
            <!--Nav Heading  -->
            <div class="p-4 d-flex flex-column align-items-center justify-content-center">
                <img class="rounded-circle" src="/img/LOGO.PNG" height="100px" width="100px" alt="logo">
                <h1 class="text-white fs-6 fw-bold px-3 text-center my-2">Cebu City Fire Station</h1>
            </div>
            <hr class="p-0 my-1 text-white border-3 w-75 mx-auto">
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
                <!-- profile button -->
                <div class="position-relative py-0" data-dropdown-nb>
                    <button class="btn btn-profile rounded-0" onclick="toggleShow('notificationMenu')">
                        <i class="bi bi-bell-fill text-white fs-4"></i>
                    </button>

                    <!-- dropdown menu -->
                    <div id="notificationMenu" class="dropdown-profile-menu py-2 px-2 border-1 text-white" dropdown-menu
                        style="display:none !important; width:280px; left:calc(-1 * (100% + 180px));">
                        <ul class="list-unstyled">
                            <li class="fw-bold fs-5 ml-5 my-2"> Today </li>

                            <li>
                                <a class="btn w-100 text-start text-white" href="">This is a notification
                                    sample
                                </a>
                            </li>

                            <li>
                                <a class="btn w-100 text-start text-white" href="">This is a notification
                                    sample
                                </a>
                            </li>

                            <li class="fw-bold fs-5 ml-5 my-2"> Earlier </li>

                            <li>
                                <a class="btn w-100 text-start text-white" href="">This is a notification
                                    sample
                                    <div class="notif-time fw-bold">
                                        yesterday
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a class="btn w-100 text-start text-white" href="">This is a notification
                                    sample
                                    <div class="notif-time fw-bold">
                                        2 days ago
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- profile button -->
                <div class="position-relative py-0" data-dropdown-nb style="margin-right: 10% !important;">
                    <button class="btn btn-profile rounded-0" onclick="toggleShow('dropdownMenu')">
                        <i class="bi bi-person-fill text-white fs-3"></i>
                        <!-- icon -->
                        <i class="bi bi-caret-down-fill text-white fs-5"></i>
                    </button>

                    <!-- dropdown menu -->
                    <div id="dropdownMenu" dropdown-menu class="dropdown-profile-menu py-2 px-3 border-1"
                        style="display:none !important; left:calc(-1 * (100% + 75px));">
                        @if (auth()->user()->personnel_id == 0)
                            <div class="mx-3 fs-6 fw-semibold text-white text-center align-middle">
                                {{ auth()->user()->username }}
                            </div>
                        @else
                            @php
                                $name = auth()->user()->personnel->person->first_name . ' ' . auth()->user()->personnel->person->last_name;
                            @endphp
                            <div class="fs-6 fw-semibold text-white text-center align-middle">
                                {{ $name }}
                            </div>
                        @endif
                        <div class="my-0 text-center text-white">{{ auth()->user()->type }}</div>
                        <hr class="text-white">
                        <!-- drop down links -->
                        <div class="d-inline flex-column">
                            <a href="/users/{{ auth()->user()->id }}"
                                class="btn w-100 text-start text-white fw-semibold"><i
                                    class="bi bi-person-fill text-white fs-5"></i> <span class="mx-3">
                                    Account</span></a>
                            <a href="/logout" class="btn w-100 text-start text-white fw-semibold"><i
                                    class="bi bi-box-arrow-left fs-5"></i> <span class="mx-3">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- User Info Modal --}}
            <x-modal id="modalInfo" width="50" topLocation="8">
                <h1 class="fs-4">User Info</h1>
                <hr>
                <div class="d-flex gap-2">
                    <x-form.input label="Username" name="username" :value="auth()->user()->username" :readonly="true" />
                    <x-form.input label="User Type" name="userType" :value="auth()->user()->type" :readonly="true" />
                </div>
            </x-modal>

            {{-- DUMP CONTENT HERE --}}
            <div class="overflow-y-auto h-100">
                @yield('content')


                {{-- FOOTER --}}
                <footer></footer>
            </div>
        </div>


        <!-- icons - https://icons.getbootstrap.com/ -->

        <script src="{{ asset('js/app.min.js') }}" defer></script>
        @vite(['resources/js/app.js'])
        {{-- <script src="/js/script.js" defer></script> --}}
        {{-- <script src="/css/bootstrap-5.3.0/js/bootstrap.js"></script> --}}
        {{-- <script src="/js/modal.js" defer></script> --}}
    </div>

</body>

</html>
