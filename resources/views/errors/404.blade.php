<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
</head>

<body>
    <div style="width:50%; margin: auto auto; height: 50%; text-align: center ">
        <a href={{ url()->previous() }} style="background: ">Go Back</a>
        <h1>404</h1>
        <h3>Page Does Not Exist</h3>
    </div>
    </div>
</body>

</html>
