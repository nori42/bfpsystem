<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap-utilities.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap.rtl.css">
    <link rel="stylesheet" href="/css/bootstrap-5.3.0/css/bootstrap-grid.css">
    <link rel="stylesheet" href="/css/modified-boostrap.css">
    <style>

        .container{
            width: 40% !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        form{
            border: 1px solid black;
            background-color: #EDEDED;
            width: 434px;
        }

        .btn-login{
            background-color: #672424 !important;
            color: #D6D6D6 !important;
            font-weight: 1000;

        }

        body{
            background-color: #D6D6D6 !important;
        }

        .field-container input{
            padding-top: 5px !important;
            padding-bottom: 5px !important;
            border-radius: 5px;
            border: 1px solid !important;
        }

        .field-container{
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="top-panel text-center p-3">
        <div class="fs-6 text-white fw-bold">Bureau of Fire Protection  Management System</div>
    </div>
    <div class="container m-auto">
        <form action="/authenticate" method="POST" class="p-5" style="margin-top: 4rem !important;">
            @csrf
            <div class="">
                <img class="mx-auto" src="/img/LOGO.PNG" alt="logo">
            </div>
            <div class="field-container m-2">
                <label for="username">USERNAME</label> <br>
                <input type="text" name="username" class="w-100 mt-1">
            </div>
            <div class="field-container m-2">
                <label for="password">PASSWORD</label> <br>
                <input type="password" name="password" class="w-100 mt-1">
            </div>
            <div class="field-container m-2 text-center">
                <input type="submit" value="Log In" class="btn btn-login px-5 mt-4" style="padding-left: 5rem !important; padding-right: 5rem !important;"> 
            </div>
        </form>
    </div>
</body>
</html>