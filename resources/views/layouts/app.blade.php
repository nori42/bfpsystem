<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BFP System</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap-utilities.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap.rtl.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap-grid.css">
    <link rel="stylesheet" href="/css/modal.css">
    <link rel="stylesheet" href="/css/modified-boostrap.css">
    {{-- styles - google fonts --}}
    <link rel="stylesheet" href="/css/googlefonts.css">
    {{-- <script src="/js/tailwind.js"></script> --}}
</head>

<body class="d-flex">

    <!-- icons - https://icons.getbootstrap.com/ -->

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
                    <a class="btn w-100 text-end text-white" href="/establishments">
                        <!-- button Icon -->
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="btn-icon"
                                viewBox="0 0 16 16">
                                <path
                                    d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z" />
                                <path
                                    d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z" />
                            </svg>
                        </span>
                        Establishments
                    </a>
                </li>

                <!-- button -->
                <li class="m-2">
                    <a class="btn w-100 text-end text-white" href="/fsec">
                        <!-- button Icon -->
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="btn-icon"
                                viewBox="0 0 16 16">
                                <path
                                    d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                                <path
                                    d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                            </svg>
                        </span>
                        Building Plan
                    </a>
                </li>

                <!-- button -->
                <li class="m-2">
                    <a class="btn w-100 text-end text-white" href="#" disabled>
                        <!-- button Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="btn-icon"
                            viewBox="0 0 16 16">
                            <path
                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                        </svg>
                        Personnel
                    </a>
                </li>

                <!-- button -->
                <li class="m-2">
                    <a class="btn w-100 text-end text-white" href="#">
                        <!-- button Icon -->
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="btn-icon"
                                viewBox="0 0 16 16">
                                <path
                                    d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                                <path
                                    d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
                            </svg>
                        </span>
                        Activity Log
                    </a>
                </li>

                <!-- button -->
                <li class="m-2">
                    <a class="btn w-100 text-end text-white" href="/archived" disabled>
                        <!-- button Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="btn-icon"
                            viewBox="0 0 16 16">
                            <path
                                d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                        </svg>
                        Archive
                    </a>
                </li>



            </ul>
        </div>
    </nav>

    {{-- Righ Panel --}}
    <div class="page-container d-flex flex-column">

        <!-- PANEL  -->
        <div class="top-panel d-flex justify-content-between p-2" style="">

            {{-- Page Title --}}
            <h1 class="fs-4 text-white fw-bold mx-5 mt-1">{{ $page_title }}</h1>

            <!-- profile button -->
            <div class="position-relative py-0" data-dropdown-nb style="margin-right: 10% !important;">
                <button class="btn btn-profile rounded-0" onclick="toggleShow('dropdownMenu')">
                    <span>
                        <!-- icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="btn-profile-icon"
                            viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>

                        <!-- icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="btn-profile-icon"
                            viewBox="0 0 16 16">
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
                        <a href="#" class="btn w-100 text-end text-white fw-semibold">Info</a>
                        <a href="/" class="btn w-100 text-end text-white fw-semibold">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        {{-- DUMP CONTENT HERE --}}
        <div class="overflow-y-auto h-100" id="scrollable">
            @yield('content')
        </div>
    </div>

    {{-- FOOTER --}}
    <footer></footer>
    <script src="/js/script.js"></script>
    <script src="/css/bootstrap-5.3.0/js/bootstrap.js"></script>
    <script src="/js/modal.js" defer></script>

</body>

</html>
