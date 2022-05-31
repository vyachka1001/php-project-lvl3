<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Page analyzer</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="antialiased">
        <main>
            <div class="container">
                <h1>Page analyzer</h1>
                <form action="/urls" method="POST">
                    @csrf
                    <input type="text" name="url[name]" placeholder="https://example.com">
                    <input type="submit" value="Check">
                </form>
            </div>
        </main>
    </body>
</html>
