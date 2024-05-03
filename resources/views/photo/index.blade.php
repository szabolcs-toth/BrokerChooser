<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="antialiased">
    <div style="background-color: {{$color}}">
        <a href="{{ route('photo.thankYou', ['variable' => $variable]) }}" class="btn btn-primary">Gooooooo</a>
    </div>
</body>
</html>
