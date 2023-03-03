@extends('layouts.main')

@push('css')
@livewireStyles

<link href="/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

@endpush

@section('title', 'Редактирование')
@section('right-button')
<div class="float-end py-2">
    <a href="{{ route('users.index') }}" class="btn btn-primary">
        <i class="mdi mdi-list me-1"></i> Список пользователей
    </a>
</div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Имя Фамилия</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Имя Фамилия" required value="{{ $user->fullname }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Телефон</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">+998</span>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Телефон" required maxlength="9" minlength="9" pattern="[0-9]{9}" value="{{ $user->phone }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Логин</label>
                                <input type="text" class="form-control" id="username" name="username" required value="{{ $user->username }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="roles" class="form-label">Роль</label>
                                <select class="form-select select2" id="roles" name="roles" multiple>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->hasRole($role->slug) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<!--  Select2 Js -->
<script src="/assets/vendor/select2/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#roles').select2({
            'placeholder': 'Выберите роль',
        });
    });
</script>

@livewireScripts
@endpush
