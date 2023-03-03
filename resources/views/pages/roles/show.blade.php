@extends('layouts.main')

@push('css')
@livewireStyles
@endpush

@section('title', $customer->fullname)
@section('right-button')
<div class="float-end pt-2">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCustomer">
        <i class="mdi mdi-pencil me-1"></i> Редактировать
    </button>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                    <li class="nav-item">
                        <a href="#order-b2" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                            <i class="mdi mdi-order-bool-descending-variant d-md-none d-block"></i>
                            <span class="d-md-block">Заказы</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#profile-b2" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            <i class="mdi mdi-wallet-plus d-md-none d-block"></i>
                            <span class="d-md-block">Платежи</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="order-b2">

                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addOrder">
                            <i class="mdi mdi-plus me-1"></i> Добавить заказ
                        </button>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>
                                        Полная инфо
                                    </th>
                                    <th>Сумма</th>
                                    <th>Информация</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->orders as $order)
                                <tr>
                                    <td scope="row">{{ $order->created_at }}</td>
                                    <td>
                                        @foreach ($order->orderInfos as $orderInfo)
                                            <x-order-info :orderInfo="$orderInfo" />
                                        @endforeach
                                    </td>
                                    <td>{{ $order->summa }}</td>
                                    <td>{{ $order->comment }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-eye"></i></a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="profile-b2">
                        <p>...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Edit Modal -->
<div id="editCustomer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCustomerLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editCustomerLabel">Добавить клиента</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('customers.update', $customer->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Имя Фамилия</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Имя Фамилия" required value="{{ $customer->fullname }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Телефон</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">+998</span>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Телефон" required maxlength="9" minlength="9" pattern="[0-9]{9}" value="{{ $customer->phone }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Дата рождения</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" required value="{{ $customer->birthday }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="source" class="form-label">Источник</label>
                                <input type="autocomplete" class="form-control" id="source" name="source" placeholder="Источник" required value="{{ $customer->source }}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Адрес</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ $customer->address }}</textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Комментарий</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3">{{ $customer->comment }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Order Modal -->
<div id="addOrder" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addOrderLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addOrderLabel">Добавить клиента</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('orders.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Клиент</label>
                                <input type="text" class="form-control" name="fullname" placeholder="Имя Фамилия" required value="{{ $customer->fullname }}" readonly>
                                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                            </div>
                        </div>

                        <div class="col-12" id="order_items">
                            <div class="row order_items_clone">
                                <div class="col-4">
                                    <label for="date_id_0" class="form-label">Дата</label>
                                    <input type="date" class="form-control" id="date_id_0" name="date[]" required>
                                </div>
                                <div class="col-8">
                                    <label for="info_id_0" class="form-label">Информация</label>
                                    <input type="text" class="form-control" id="info_id_0" name="info[]" placeholder="Информация" required>
                                </div>
                                <div class="col-12">
                                    <a href="javascript:void(0)" class="order_items_remove text-danger float-end">
                                        Удалить &times;
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="text-center">
                                <a href="javascript:void(0)" id="add-more" class="text-success"><i class="mdi mdi-plus-circle"></i> Добавить еще</a>
                            </p>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Срок</label>
                                <input type="date" class="form-control" name="deadline">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="summa" class="form-label">Сумма</label>
                                <input type="text" class="form-control" name="summa" placeholder="Сумма" required id="summa">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Комментарий</label>
                                <textarea class="form-control" name="comment" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{asset('vendor/cloneData.js')}}"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script src="/assets/vendor/jquery-input-mask/jquery.inputmask.bundle.min.js"></script>
@livewireScripts
<script>

    $("#summa").inputmask({
        alias: "numeric",
        groupSeparator: " ",
        autoGroup: true,
        digits: 0,
        digitsOptional: false,
        prefix: '',
        placeholder: "",
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true,
        unmaskAsNumber: true
    });


    $('a#add-more').cloneData({
        mainContainerId: 'order_items',
        cloneContainer: 'order_items_clone',
        removeButtonClass: 'order_items_remove',
        removeConfirm: true, // default true confirm before delete clone item
        removeConfirmMessage: 'Действительно удалить?', // Confirm message
        // confirm delete message
        // append: '<a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media">Remove</a>', // Set extra HTML append to clone HTML
        minLimit: 1, // Default 1 set minimum clone HTML required
        maxLimit: 100, // Default unlimited or set maximum limit of clone HTML
        defaultRender: 1,
    });
</script>


@endpush
