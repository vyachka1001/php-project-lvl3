@extends('layouts.app')
<style>
    .ellipsis {
        position: relative;
    }

    .ellipsis span {
    position: absolute;
    left: 5;
    right: 10;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

    </style>
@section('content')
<main class="flex-grow-1">
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайт: {{ $url->name }}</h1>
        <table class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td>{{ $url->id }}</td>
                    </tr>
                    <tr>
                        <td>Имя</td>
                        <td>{{ $url->name }}</td>
                    </tr>
                    <tr>
                        <td>Дата создания</td>
                        <td>{{ $url->created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </table>
        <h2 class="mt-5 mb-3">Проверки</h2>
        <form class="mb-3" action="{{ route('url_checks.store', ['id' => $url->id]) }}" method="POST">
            @csrf
            <input type="submit" class="btn btn-primary" value="Запустить проверку">
        </form>
        <table class="table table-bordered table-hover text-nowrap" style="text-overflow: ellipsis;">
            <tbody>
                <tr> 
                    <th>ID</th>
                    <th>Код ответа</th>
                    <th>h1</th>
                    <th>title</th>
                    <th>description</th>
                    <th>Дата создания</th>
                </tr>
                @foreach($checks as $check)
                    <tr>
                        <td>{{ $check->id }}</span></td>
                        <td class="ellipsis">{{ $check->status_code }}</td>
                        <td class="ellipsis"><span>{{ $check->h1 }}</span></td>
                        <td class="ellipsis"><span>{{ $check->title }}</span></td>
                        <td class="ellipsis"><span>{{ $check->description }}</span></td>
                        <td>{{ $check->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
