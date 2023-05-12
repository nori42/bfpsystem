<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    @vite(['resources/sass/main.scss'])
    <style>
        .container {
            width: 27% !important;
            background-color: #e2e2e2;
            padding: 1px;
            margin-top: 5%;
            box-shadow: 1px 1px 6px #b5b5b5;
        }

        body {
            background-color: white !important;
            height: 100vh;
            overflow-y: auto;
        }

        .btn-login {
            background-color: #1C3B64;
            color: white;
            font-weight: bold;
        }

        form {
            margin: 0;
            border: 1px solid white;
        }

        .btn-login:hover {
            background-color: #1C3B64;
            color: white;
        }

        .btn-login:active {
            background-color: #1C3B64 !important;
            color: white !important;
        }

        .field-container input {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
            padding-left: 8px;
            border-radius: 5px;
            border: 1px solid !important;
        }
    </style>
</head>

<body>
    <div class="top-panel text-center p-3">
        <div class="fs-6 text-white fw-bold">Bureau of Fire Protection Management System</div>
    </div>
    <div class="container mx-auto">
        <form action="/login" method="POST" class="p-5">

            @isset($MSSG)
                <h3 class="text-danger">{{ $MSSG }}</h3>
            @endisset
            @csrf
            <div class="">
                <img class="mx-auto" src="/img/LOGO.PNG" alt="logo">
            </div>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="text-danger">{{ $error }}</div>
                @endforeach
            @endif
            <input class="form-control my-4 d-block w-100 py-3" type="text" name="username" placeholder="USERNAME">
            <input class="form-control my-4 d-block w-100 py-3" type="password" name="password" placeholder="PASSWORD">

            <div class="field-container m-2 text-center">
                <button class="btn btn-login mt-4 py-3 rounded-2 w-85">LOGIN</button>
            </div>
        </form>
    </div>

    <div style="height:100px;">

    </div>
</body>

</html>
