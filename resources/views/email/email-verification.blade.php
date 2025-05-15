<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

    </style>
</head>
<body>
    <h1>Email verification</h1>
    <p>
        Hello, <br>
        nous vous avons envoyé cet e-mail pour vérifier si cet e-mail : <a href="http://localhost:8000/verify/{{$user->emailIsValid}}">{{$user->email}}</a>
        que vous avez fourni est valide
    </p>

    <a href="http://localhost:8000/check_email/{{$user->remember_token}}">Vérifier mon email</a>
</body>
</html>
