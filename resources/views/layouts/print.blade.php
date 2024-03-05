<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite('resources/sass/bootstrap.scss')
    @vite('resources/css/global.css')
    @vite('resources/css/pages/printables/print.css')
    @yield('stylesheet')
</head>

<body>
    <div class="nav d-flex justify-content-center align-items-center bg-white p-3 rounded-3 gap-3">
        @yield('btngroup')
        <div>
            <button class="btn btn-primary" printbtn>
                Print Certificate
                <i class="bi bi-printer-fill"></i>
            </button>
        </div>
        <div>
            <span class="fw-semibold">Issued For:</span> <span class="text-decoration-underline"> @yield('issuedFor')
            </span>
        </div>
    </div>

    @yield('printTools')

    {{-- Debugging Tools --}}
    {{-- <div class="debugTools d-flex flex-column p-3 bg-white rounded-3 gap-2">
        <button class="btn btn-primary">Move</button>
    </div> --}}

    @yield('printablePage')
    @vite(['resources/js/globalVar.js'])
    @yield('pagescript')

    @
    <script defer src="{{ Vite::asset('resources/js/pages/printables/print.js') }}"></script>
    <script defer src="{{ Vite::asset('resources/js/pages/printables/print2.js') }}"></script>

    {{-- Footer --}}
    <div class="footer">
        BFP Print
    </div>
</body>

</html>
