<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    {{-- CSS --}}
    @vite(['resources/sass/bootstrap.scss', 'resources/css/pages/login.css'])
</head>

<body>
    <div class="d-flex vh-100 vw-100">
        <div class="leftPanel w-100 ">
            <h2 class="motto">To Save Live And Properties</h2>
            <div class="d-flex flex-column align-items-center justify-content-center h-100 pb-5">
                <img src="{{ asset('img/LOGO.png') }}" width="220px" height="220px" alt="">
                <h3 class="fw-bold text-white text-center">Bureau of Fire Protection <br> Cebu City Fire Station</h3>
                <p class="text-white w-85 text-center">We commit to prevent and suppress destructive fires, investigate
                    its causes;enforce Fire Code and other related laws; respond
                    to man-made and natural disasters and other emergencies.
                </p>
                <p class="text-white">A modern fire service fully capable of ensuring a fire safe
                    nation by 2034.</p>
            </div>
        </div>
        <div class="rightPanel w-100 d-flex flex-column align-items-center justify-content-center">
            <div class="w-60 mb-3">
                <h3 class="fw-semibold text-start">Login</h3>
                <div class="text-secondary text-start">Please enter your details.</div>
            </div>
            <form class="w-60 mx-auto" action="/login" method="POST">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="text-danger"></div>
                        <div class="fs-5 text-danger my-2">{{ $error }}</div>
                    @endforeach
                @endif
                @csrf
                <div>
                    <label class="fs-4">Username</label>
                    <input class="form-control d-block fs-4 w-100" type="text" name="username" autocomplete="off">
                </div>

                <div>
                    <label class="fs-4" for="password">Password</label>
                    <input id="password" class="form-control d-block fs-5 w-100" type="password" name="password">
                    <div class="mt-3">
                        <label class="fw-bold fs-6" for="showPassword">Show Password</label>
                        <input id="showPassword" class=" d-inline fs-4" type="checkbox" name="showPassword">
                    </div>
                </div>

                <button class="btn btn-primary fs-3 fw-normal w-100 mt-3 py-2">Login</button>
                <div class="text-center mt-4">
                    <a href="/passwordreset" class="text-primary text-center fs-5">Forgot
                        Password?
                    </a>
                </div>
            </form>

        </div>
    </div>
</body>
@vite(['resources/js/pages/login.js'])

</html>
