<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    </head>
    <body>
        @include('flash::message')
        <h1>Site {{ $url->name }}</h1>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>id</td>
                    <td>{{ $url->id }}</td>
                </tr>
                <tr>
                    <td>name</td>
                    <td>{{ $url->name }}</td>
                </tr>
                <tr>
                    <td>created_at</td>
                    <td>{{ $url->created_at }}</td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('urls.index') }}">Sites</a>

        <h2>Checks</h2>
        <form action="{{ route('url_checks.store', ['id' => $url->id]) }}" method="POST">
            @csrf
            <input type="submit" class="btn btn-primary" value="Execute check">
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>id</td>
                    <td>created_at</td>
                </tr>
            </thead>
            <tbody>
                @foreach($checks as $check)
                    <tr>
                        <td>{{ $check->id }}</td>
                        <td>{{ $check->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
