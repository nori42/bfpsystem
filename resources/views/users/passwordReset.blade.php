<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/sass/bootstrap.scss', 'resources/css/pages/login.css'])
</head>

<body>
    {{-- {{ isset($debug) ? dd($debug[0]) : '' }} --}}
    <div class="d-flex vh-100 vw-100">
        <div class="leftPanel w-100 ">
            <div class="d-flex flex-column align-items-center justify-content-center h-100 pb-5" style="margin: 0 5rem;">
                <img class="align-self-start" src="{{ asset('img/LOGO.png') }}" width="160px" height="160px"
                    alt="">

                <div class="fw-semibold text-white fs-3 align-self-start">Bureau of Fire Protection</div>
                <div class="fw-bold text-white align-self-start" style="font-size: 48px;">Cebu City Fire Station
                </div>
                <p class="text-white">We commit to prevent and suppress destructive fires, investigate
                    its causes;enforce Fire Code and other related laws; respond
                    to man-made and natural disasters and other emergencies. ---- A modern fire service fully
                    capable of ensuring a fire safe
                    nation by 2034.
                </p>
                <p class="text-white"></p>
            </div>

        </div>
        <div class="rightPanel w-100 d-flex flex-column align-items-center justify-content-center">
            @if (!isset($resetSent))
                <div class="w-60 mb-3">
                    <h3 class="fw-semibold text-start">Password Reset</h3>
                    <div class="text-secondary text-start">Please enter the username</div>
                </div>
                <form class="w-60 mx-auto" action="/request/passwordreset" method="POST">
                    @csrf
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="text-danger"></div>
                            <div class="fs-5 text-danger my-2">{{ $error }}</div>
                        @endforeach
                    @endif
                    @csrf
                    <div>
                        <label class="fs-4" for="username">Username</label>
                        <input class="form-control d-block fs-4 w-100" type="text" name="username"
                            autocomplete="off">
                    </div>

                    <button class="btn btn-primary fs-4 fw-normal w-100 mt-3 py-2">Send Request</button>
                </form>
                <a href="/" class="my-4 fs-5">Back to Login</a>
            @else
                <div>
                    <div class="fs-2 fw-bold">
                        @if (isset($resetAlreadySent))
                            @if ($resetAlreadySent)
                                Request Already Sent<i class="bi bi-send-check text-success"></i>
                            @else
                                Request Sent <i class="bi bi-send-check text-success"></i>
                            @endif
                        @endif
                    </div>
                    <div class="fs-4">
                        Get the new password to the admin
                    </div>
                    <div class="text-secondary">
                        Upon resetting the password, it is strongly advised to change it immediately.
                    </div>
                </div>
                <a href="/" class="my-4 fs-4">Back to Login</a>
            @endif


        </div>
    </div>
</body>
<script>
    const showPassword = document.querySelector('#showPassword')

    showPassword.addEventListener('change', function() {
        if (showPassword.checked) {
            document.querySelector('#password').type = "text"
        } else {
            document.querySelector('#password').type = "password"
        }
    })
</script>

</html>
