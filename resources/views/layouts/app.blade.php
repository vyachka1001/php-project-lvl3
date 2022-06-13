<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf-param" content="_token" />

        <title>Анализатор страниц</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="min-vh-100 d-flex flex-column">
        <header class="flex-shrink-0">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark px-3">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">Анализатор страниц</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link active" aria-current="page" href="/">Главная</a>
                            <a class="nav-link" href="{{ route('urls.index') }}">Сайты</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        @include('flash::message')

        <main class="flex-grow-1">
            <div class="container-lg">
                <div class="container">
                    <h1>@yield('header')</h1>
                    <div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-top py-3 mt-5 flex-shrink-0 mt-auto">
            <div class="container-lg">
                <div class="text-center">
                    <a href="https://hexlet.io/pages/about" target="_blank">Hexlet</a>
                </div>
            </div>
        </footer>
    </body>
</html>