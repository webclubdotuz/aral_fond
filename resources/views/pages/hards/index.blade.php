@extends('layouts.main')

@push('css')
@livewireStyles

<link href="/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

@endpush

@section('title', 'Хранилище')
@section('right-button')
<div class="float-end pt-2">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomer">
        <i class="mdi mdi-plus-circle me-1"></i> Добавить
    </button>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hards as $hard)
                        <tr>
                            <td scope="row">{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
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
                <form action="{{ route('hards.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Наименование</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Имя Фамилия" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Информация</label>
                                <textarea type="text" class="form-control" id="description" name="description" required></textarea>
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
