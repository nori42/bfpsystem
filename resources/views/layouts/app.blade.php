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

            @if (auth()->user()->type == 'ADMIN')
                <!-- Nav Links -->
                <div class="nav-links overflow-y-auto ">
                    <ul class="py-3 list-unstyled">

                        {{-- <li class="mx-3 fw-bold text-white fs-6">Menu</li> --}}

                        <!-- button -->
                        <li class="m-2">
                            <a class="btn w-100 text-start text-white" href="/establishments">
                                <!-- button Icon -->
                                <span class="material-symbols-outlined align-middle fs-2">
                                    domain
                                </span>
                                Establishments
                            </a>
                        </li>

                        <!-- button -->
                        <li class="m-2">
                            <a class="btn w-100 text-start text-white" href="/fsec">
                                <!-- button Icon -->
                                <span class="material-symbols-outlined align-middle fs-2">
                                    corporate_fare
                                </span>
                                Building Plan
                            </a>
                        </li>

                        <!-- button -->
                        <li class="m-2">
                            <a class="btn w-100 text-start text-white" href="/personnel" disabled>
                                <!-- button Icon -->
                                <span class="material-symbols-outlined align-middle fs-2">
                                    group
                                </span>
                                Personnel
                            </a>
                        </li>

                        <!-- button -->
                        <li class="m-2">
                            <a class="btn w-100 text-start text-white" href="/users" disabled>
                                <!-- button Icon -->
                                <span class="material-symbols-outlined align-middle fs-2">
                                    account_box
                                </span>
                                Users
                            </a>
                        </li>

                        <!-- button -->
                        <li class="m-2">
                            <a class="btn w-100 text-start text-white" href="#" disabled>
                                <!-- button Icon -->
                                <span class="material-symbols-outlined align-middle fs-2">
                                    receipt_long
                                </span>
                                Reports
                            </a>
                        </li>

                        <!-- button -->
                        <li class="m-2">
                            <a class="btn w-100 text-start text-white" href="#">
                                <!-- button Icon -->
                                <span class="material-symbols-outlined align-middle fs-2">
                                    event_note
                                </span>
                                Activity Log
                            </a>
                        </li>

                        <!-- button -->
                        <li class="m-2">
                            <a class="btn w-100 text-start text-white" href="/archived" disabled>
                                <!-- button Icon -->
                                <span class="material-symbols-outlined align-middle fs-2">
                                    dresser
                                </span>
                                Archive
                            </a>
                        </li>

                    </ul>
                </div>
            @endif

            @if (auth()->user()->type == 'FSIC')
                <x-navLinks>
                    <x-navLinks.link href="/establishments">
                        <span class="material-symbols-outlined align-middle fs-2">
                            domain
                        </span>
                        Establishments
                    </x-navLinks.link>

                    <x-navLinks.link href="#">
                        <span class="material-symbols-outlined align-middle fs-2">
                            receipt_long
                        </span>
                        Reports
                    </x-navLinks.link>

                    <x-navLinks.link href="#">
                        <span class="material-symbols-outlined align-middle fs-2">
                            event_note
                        </span>
                        Activity Log
                    </x-navLinks.link>
                </x-navLinks>
            @endif

            @if (auth()->user()->type == 'FIREDRILL')
                <x-navLinks>
                    <x-navLinks.link href="/establishments">
                        <span class="material-symbols-outlined align-middle fs-2">
                            domain
                        </span>
                        Establishments
                    </x-navLinks.link>

                    <x-navLinks.link href="#">
                        <span class="material-symbols-outlined align-middle fs-2">
                            receipt_long
                        </span>
                        Reports
                    </x-navLinks.link>

                    <x-navLinks.link href="#">
                        <span class="material-symbols-outlined align-middle fs-2">
                            event_note
                        </span>
                        Activity Log
                    </x-navLinks.link>
                </x-navLinks>
            @endif

            @if (auth()->user()->type == 'FSEC')
                <x-navLinks>
                    <x-navLinks.link href="/fsec">
                        <span class="material-symbols-outlined align-middle fs-2">
                            domain
                        </span>
                        Building Plan
                    </x-navLinks.link>

                    <x-navLinks.link href="#">
                        <span class="material-symbols-outlined align-middle fs-2">
                            receipt_long
                        </span>
                        Reports
                    </x-navLinks.link>

                    <x-navLinks.link href="#">
                        <span class="material-symbols-outlined align-middle fs-2">
                            event_note
                        </span>
                        Activity Log
                    </x-navLinks.link>
                </x-navLinks>
            @endif

        </nav>

        {{-- Righ Panel --}}
        <div class="page-container d-flex flex-column w-100">

            <!-- PANEL  -->
            <div class="top-panel d-flex justify-content-end p-2" style="position: sticky;">

                {{-- Page Title --}}
                {{-- <h1 class="fs-4 text-white fw-bold mx-5 mt-1">{{ $page_title }}</h1> --}}

                <!-- profile button -->
                <div class="position-relative py-0" data-dropdown-nb style="margin-right: 10% !important;">
                    <button class="btn btn-profile rounded-0" onclick="toggleShow('dropdownMenu')">
                        <i class="bi bi-person-fill text-white fs-3"></i>
                        <!-- icon -->
                        <i class="bi bi-caret-down-fill text-white fs-5"></i>
                    </button>

                    <!-- dropdown menu -->
                    <div id="dropdownMenu" class="dropdown-profile-menu py-2 px-3 border-1"
                        style="display:none !important;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-fill text-white fs-3"></i>
                            <span class="mx-3 fw-semibold text-white align-middle">{{ auth()->user()->username }}</span>
                        </div>

                        <hr>
                        <!-- drop down links -->
                        <div class="d-inline flex-column">
                            <button class="btn w-100 text-start text-white fw-semibold nowrap"
                                onclick="openModal('modalInfo',toggleShow('dropdownMenu'))">Account</button>
                            <a href="/logout" class="btn w-100 text-start text-white fw-semibold">Logout</a>
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
