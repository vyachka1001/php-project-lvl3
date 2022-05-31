<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="antialiased">
        <h1>Сайт {{ $url->name }}</h1>
        <p>id = {{ $url->id }}</p>
        <p>name = {{ $url->name }}</p>
        <p>created_at = {{ $url->created_at }}</p>
        <a href="{{ route('urls') }}">Сайты</a>
    </body>
</html>
