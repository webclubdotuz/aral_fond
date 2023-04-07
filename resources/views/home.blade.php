@extends('layouts.main')

@section('title', 'Главная')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1 class="text-success">
                    Балл қойылған: {{ $ball_is }}
                </h1>
                <h1 class="text-danger">
                    Балл қойылмаган: {{ $ball_null }}
                </h1>
            </div>
        </div>
    </div>
</div>

@endsection
