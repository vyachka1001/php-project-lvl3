<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sites</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    </head>
    <body >
        <main>
            <h1>Sites</h1>
            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>name</td>
                            <td>last_check</td>
                            <td>status_code</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($urls as $url)
                            <tr>
                                <td>{{ $url->id }}</td>
                                <td><a href="{{ route('urls.show', $url->id) }}">{{ $url->name }}</a></td>
                                <td>{{ $url->lastCheck }}</td>
                                <td>{{ $url->statusCode }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            <div>
        </main>
    </body>
</html>
