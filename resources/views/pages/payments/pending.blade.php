@extends('layouts.main')

@push('css')
    <!-- Datatables css -->
    <link href="/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    @livewireStyles
@endpush

@section('title', 'Счета')
@section('right-button')
<div class="float-end pt-2">

</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Клиент</th>
                            <th>Телефон</th>
                            <th>Заказ</th>
                            <th>Сумма</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->customer->fullname }}</td>
                            <td>{{ $order->customer->phone }}</td>
                            <td>{!! $order->full_info !!}</td>
                            <td>{{ $order->summa }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="payOrder({{ $order->id }})">
                                    <i class="mdi mdi-cash me-1"></i> Оплатить
                                </button>
                            </td>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="payOrder" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="payOrderLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="payOrderLabel">Оплата заказа</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="payOrderForm">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Клиент</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Имя Фамилия" required readonly>
                                <input type="hidden" class="form-control" id="customer_id" name="customer_id" required readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="info" class="form-label m-0">Заказ информация</label>
                                <div class="m-0 bg-light p-2" id="info"></div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="order_summa" class="form-label">Сумма</label>
                                <input type="text" class="form-control" id="order_summa" name="order_summa" placeholder="Сумма" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="summa" class="form-label">Сумма</label>
                                <input type="text" class="form-control" id="summa" name="summa" placeholder="Сумма" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="pay_method" class="form-label">Тип оплаты</label>
                                <select class="form-select" id="pay_method" name="pay_method" required>
                                    <option value="">Выберите тип оплаты</option>
                                    <option value="cash">Наличные</option>
                                    <option value="card">Карта</option>
                                    <option value="transfer">Перевод</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
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


<!-- Datatables js -->
<script src="/assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>

<!-- Input Mask js -->
<script src="/assets/vendor/jquery-input-mask/jquery.inputmask.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $("#basic-datatable").DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Russian.json'
            },
            columnDefs: [{
                orderable: false,
                targets: [4]
            }]
        });
    });

    $("#order_summa").inputmask("numeric", {
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

    $("#summa").inputmask("numeric", {
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



    function payOrder(id) {

        $.ajax({
            url: '/orders/' + id + '/getOrder',
            type: 'GET',
            success: function(data) {

                console.log(data);

                $("#payOrderForm").attr("action", "/orders/" + id + "/payment");

                $('#payOrder').modal('show');

                $('#fullname').val(data.fullname);
                $('#customer_id').val(data.customer_id);
                $('#info').html(data.info + "lore ipsum");
                $('#order_summa').val(data.summa);

            }
        });

    }
</script>

@endpush
