<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Page analyzer</title>

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body>
        @include('flash::message')
        <main>
            {{-- <div class="container"> --}}
                <h1>Page analyzer</h1>
                <form action="{{ route('urls.store')}} " method="POST">
                    @csrf
                    <input type="text" placeholder="https://example.com" name="url[name]">
                    <input type="submit" class="btn btn-primary" value="Check">
                </form>
            {{-- </div> --}}
        </main>
    </body>
</html>