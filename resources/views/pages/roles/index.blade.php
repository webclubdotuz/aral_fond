@extends('layouts.main')

@push('css')
@livewireStyles

<link href="/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

@endpush

@section('title', 'Роли')
@section('right-button')
<div class="float-end pt-2">
    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomer">
        <i class="mdi mdi-plus-circle me-1"></i> Добавить клиента
    </button> --}}
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Информация</th>
                            <th>Slug</th>
                            <th>Пользователи</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td scope="row">{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
                            <td>{{ $role->slug }}</td>
                            <td>
                                @foreach ($role->users as $user)
                                <a href="{{ route('users.show', $user->id) }}" class="badge bg-primary">{{ $user->fullname }}</a>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="createCustomer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createCustomerLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createCustomerLabel">Добавить клиента</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Имя Фамилия</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Имя Фамилия" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Телефон</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">+998</span>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Телефон" required maxlength="9" minlength="9" pattern="[0-9]{9}">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Логин</label>
                                <input type="text" class="form-control" id="username" name="username" required>
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
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
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
            // modal
            'dropdownParent': $('#createCustomer')
        });
    });
</script>

@livewireScripts
@endpush
