@extends('errors::layout')

@section('content')
    <div class="card-body p-4">
        <div class="text-center">
            <h1 class="text-error">4<i class="mdi mdi-emoticon-sad"></i>3</h1>
            <h4 class="text-uppercase text-danger mt-3">Доступ запрещен</h4>
            <p class="text-muted mt-3">
                У вас нет прав для просмотра этой страницы.
            </p>

            <a class="btn btn-info mt-3" href="/"><i class="mdi mdi-reply"></i> На главную</a>
        </div>
    </div> <!-- end card-body-->
@endsection
