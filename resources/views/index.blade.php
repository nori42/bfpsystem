<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    {{-- CSS --}}
    @vite(['resources/sass/bootstrap.scss', 'resources/css/pages/login.css'])
</head>


<body>
    @isset($toastMssg)
        <x-toast :message="$toastMssg" />
    @endisset

    @if (session('toastMssg'))
        <x-toast :message="session('toastMssg')" />
    @endif

    <div class="d-flex vh-100 vw-100">
        <div class="leftPanel w-100 ">
            <div class="d-flex flex-column align-items-center justify-content-center h-100 pb-5" style="margin: 0 5rem;">
                <img class="align-self-start" src="{{ asset('img/LOGO.png') }}" width="160px" height="160px"
                    alt="">

                <div class="text-white fs-3 align-self-start"><i>Bureau of Fire Protection</i></div>
                <div class="fw-bolder text-white align-self-start" style="font-size: 48px;">Cebu City Fire Station
                </div>
                <p class="text-white text-justify mt-1 fs-5">We commit to prevent and suppress destructive fires,
                    investigate
                    its causes;enforce Fire Code and other related laws; respond
                    to man-made and natural disasters and other emergencies. ---- A modern fire service fully
                    capable of ensuring a fire safe
                    nation by 2034.
                </p>
                <p class="text-white"></p>
            </div>

        </div>
        <div class="rightPanel w-100 d-flex flex-column align-items-center justify-content-center">
            <div class="w-60 mb-4">
                <h3 class="fw-semibold text-start">Login</h3>
                <div class="text-secondary text-start">Please enter your details.</div>
            </div>
            <form class="w-60 mx-auto" action="/login" method="POST">
                @if (session('invalidCred'))
                    <div class="fs-5 text-danger my-2">Provided credentials is incorrect</div>
                @endif

                @csrf
                <div>
                    <label class="fs-5 text-secondary">Username @error('username')
                            <span class="text-danger fs-5">(Username is required)</span>
                        @enderror
                    </label>
                    <input class="form-control d-block fs-4 w-100" type="text" name="username" autocomplete="off">
                </div>

                <div class="mt-4">
                    <label class="fs-5 text-secondary" for="password">Password @error('password')
                            <span class="text-danger fs-5">(Password is required)</span>
                        @enderror
                    </label>

                    <div class="position-relative mb-5">
                        <input id="password" class="form-control d-block fs-5 w-100" type="password" name="password">
                        <button id="showPassword" data-shown="false" type="button" class="btn position-absolute fs-4"
                            style="right: 1rem; top: 0.05rem;">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>

                    {{-- <div class="d-flex gap-2 mt-1 mb-3">
                        <label class="fw-bold fs-6 my-3" for="showPassword">Show Password</label>
                        <input id="showPassword" class=" d-inline fs-4" type="checkbox" name="showPassword">
                    </div> --}}
                </div>

                <button class="btn btn-primary fs-3 fw-normal w-100 mt-3 py-2">Login</button>
                <div class="text-center mt-4">
                    <a href="/passwordreset" class="text-secondary text-center fs-6">Forgot
                        Password?
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
@vite(['resources/js/pages/login.js'])

</html>
