@extends('layouts.main')

@push('css')
@livewireStyles
@endpush

@section('title', 'Клиенты')
@section('right-button')
<div class="float-end pt-2">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomer">
        <i class="mdi mdi-plus-circle me-1"></i> Добавить клиента
    </button>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <livewire:customer-table />
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
                <form action="{{ route('customers.store') }}" method="post">
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
                                <label for="birthday" class="form-label">Дата рождения</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="source" class="form-label">Источник</label>
                                <input type="autocomplete" class="form-control" id="source" name="source" placeholder="Источник" required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Адрес</label>
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Комментарий</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
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
@livewireScripts
@endpush
