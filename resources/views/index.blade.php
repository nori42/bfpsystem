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

                <div class="text-white fs-3 align-self-start">Bureau of Fire Protection</div>
                <div class="fw-bolder text-white align-self-start" style="font-size: 48px;">Cebu City Fire Station
                </div>
                <p class="text-white text-justify">We commit to prevent and suppress destructive fires, investigate
                    its causes;enforce Fire Code and other related laws; respond
                    to man-made and natural disasters and other emergencies. ---- A modern fire service fully
                    capable of ensuring a fire safe
                    nation by 2034.
                </p>
                <p class="text-white"></p>
            </div>

        </div>
        <div class="rightPanel w-100 d-flex flex-column align-items-center justify-content-center">
            <div class="w-60 mb-3">
                <h3 class="fw-semibold text-start">Login</h3>
                <div class="text-secondary text-start">Please enter your details.</div>
            </div>
            <form class="w-60 mx-auto" action="/login" method="POST">
                @if (session('invalidCred'))
                    <div class="fs-5 text-danger my-2">Provided credentials is incorrect</div>
                @endif

                @csrf
                <div>
                    <label class="fs-4">Username @error('username')
                            <span class="text-danger fs-5">(Username is required)</span>
                        @enderror
                    </label>
                    <input class="form-control d-block fs-4 w-100" type="text" name="username" autocomplete="off">
                </div>

                <div>
                    <label class="fs-4" for="password">Password @error('password')
                            <span class="text-danger fs-5">(Password is required)</span>
                        @enderror
                    </label>
                    <input id="password" class="form-control d-block fs-5 w-100" type="password" name="password">

                    <div class="mt-3">
                        <label class="fw-bold fs-6" for="showPassword">Show Password</label>
                        <input id="showPassword" class=" d-inline fs-4" type="checkbox" name="showPassword">
                    </div>
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
