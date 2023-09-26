<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite(['resources/sass/bootstrap.scss', 'resources/css/pages/login.css'])
</head>

<body class="bg-primary-nb">
    <div class="d-flex justify-content-center mx-auto mb-5">
        <div>
            <div class="mb-4">
                <div class="d-flex justify-content-center">
                    <img class="mt-3 mx-auto" src="/img/LOGO.png" alt="BFP LOGO" height="150" width="150">
                </div>
                <div class="text-center text-white fs-5">Bureau of Fire Protection <br> Cebu City Fire Station</div>
            </div>
            <div class="bg-white p-5 rounded-4">
                <div class="w-60 mb-3">
                    <h3 class="fw-semibold text-start">Create New Password</h3>
                </div>
                <form class="mx-auto" action="/updatepassword" method="POST" style="width: 32rem;">
                    @csrf
                    @method('PUT')
                    {{-- @if ($errors->any())
    
                        {{ dd($errors) }}
                        @foreach ($errors->all() as $error)
                            <div class="fs-6 text-danger my-2">{{ $error }}</div>
                        @endforeach
                    @endif --}}
                    <div class="text-secondary">

                        @if ($errors->has('password'))
                            @foreach ($errors->get('password') as $error)
                                @if ($error === 'The password field must be at least 8 characters.')
                                    <span class="text-danger">{{ $error }}</span><br>
                                @elseif ($error === 'The password field must contain at least one uppercase and one lowercase letter.')
                                    <span class="text-danger">{{ $error }}</span><br>
                                @elseif ($error === 'The password field must contain at least one number.')
                                    <span class="text-danger">{{ $error }}</span><br>
                                @else
                                    <span>{{ $error }}</span><br>
                                @endif
                            @endforeach
                        @else
                            <span>The password field must be at least 8 characters.</span><br>
                            <span>The password field must contain at least one uppercase and one lowercase
                                letter.</span><br>
                            <span>The password field must contain at least one number.</span>
                        @endif
                    </div>
                    <div>
                        <label class="fs-4">Password</label>
                        <input id="password" class="form-control d-block fs-5 w-100" type="password" name="password"
                            required>
                    </div>

                    <div>
                        <label class="fs-4">Confirm Password</label>
                        <input class="form-control d-block fs-5 w-100" id="confirmPassword" name="confirmPassword"
                            type="password" required autocomplete="off">
                    </div>

                    <button class="btn btn-primary fs-4 fw-normal w-100 mt-5 py-2">Update</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script defer>
    const passwordInput = document.getElementById('password')
    const confirmPasswordInput = document.getElementById('confirmPassword');

    confirmPasswordInput.addEventListener('input', () => {
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity('Passwords do not match');
        } else {
            confirmPasswordInput.setCustomValidity('');
        }
    });
</script>

</html>
