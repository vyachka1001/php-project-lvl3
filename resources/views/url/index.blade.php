<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Сайты</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body >
        <main>
            <h1>Сайты</h1>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>name</td>
                            <td>created_at</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($urls as $url)
                            <tr>
                                <td>{{$url->id}}</td>
                                <td><a href="{{route('urls.show', $url->id)}}">{{$url->name}}</a></td>
                                <td>{{$url->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            <div>
        </main>
    </body>
</html>
