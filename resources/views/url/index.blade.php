@extends('layouts.app')
@section('content')
    <h1 class="mt-5 mb-3">Сайты</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-nowrap">
            <tbody>
                <tr> 
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Последняя проверка</th>
                    <th>Код ответа</th>
                </tr>
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
        <nav class="d-flex justify-items-center justify-content-between">
            <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                <div>
                    
                </div>
    
                <div>
                    <ul class="pagination">
                        {{ $urls->links() }}
                    </ul>
                </div>
            </div>
        </nav>
    </div>
@endsection