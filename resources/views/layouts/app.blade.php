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
                        <span>
                            <!-- icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                class="btn-profile-icon" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>

                            <!-- icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                class="btn-profile-icon" viewBox="0 0 16 16">
                                <path
                                    d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                            </svg>
                        </span>
                    </button>

                    <!-- dropdown menu -->
                    <div id="dropdownMenu" class="dropdown-profile-menu py-2 px-3 border-1"
                        style="display:none !important;">
                        <div class="d-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                class="btn-profile-icon" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                            <span class="mx-3 fw-semibold text-white">User1</span>
                        </div>

                        <hr>
                        <!-- drop down links -->
                        <div class="d-inline flex-column">
                            <a href="#" class="btn w-100 text-start text-white fw-semibold">Info</a>
                            <a href="/" class="btn w-100 text-start text-white fw-semibold">Logout</a>
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

        <!-- icons - https://icons.getbootstrap.com/ -->

        <script src="{{ asset('js/app.min.js') }}" defer></script>
        @vite(['resources/js/app.js'])
        {{-- <script src="/js/script.js" defer></script> --}}
        {{-- <script src="/css/bootstrap-5.3.0/js/bootstrap.js"></script> --}}
        {{-- <script src="/js/modal.js" defer></script> --}}
    </div>

</body>

</html>
