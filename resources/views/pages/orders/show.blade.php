@extends('layouts.main')

@push('css')
    @livewireStyles
@endpush

@section('title', $order->customer->fullname)
@section('right-button')
    <div class="float-end pt-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editOrder">
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
                                <span class="d-md-block">Заказы информация</span>
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
                            <table class="table table-sm table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Дата</th>
                                        <th>Информация</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderInfos as $orderInfo)
                                        <tr>
                                            <td>{{ $loop->iteration }})</td>
                                            <td class="col-2"><i class="mdi mdi-calendar"></i> {{ $orderInfo->date_human }}</td>
                                            <td><i class="mdi mdi-information"></i> {{ $orderInfo->info }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-6">
                                    <p class="mt-3">
                                        <strong>Комментарий:</strong> {{ $order->comment }}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="m-0 mt-3">
                                        <strong>Срок:</strong> {{ $order->deadline_human }}
                                    </p>

                                    <p class="m-0">
                                        <strong>Сумма:</strong> {{ $order->summa_human }}
                                    </p>

                                    <p class="m-0">
                                        <strong>Оплачено:</strong> {{ number_format($order->payments_sum, 0, '.', ' ') }} сум
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile-b2">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>Сумма</th>
                                        <th>Тип</th>
                                        <th>Комментарий</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->date_human }}</td>
                                            <td>{{ $payment->summa_human }}</td>
                                            <td>{{ $payment->pay_method_human }}</td>
                                            <td>{{ $payment->comment }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Order Modal -->
    <div id="editOrder" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editOrderLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editOrderLabel">Добавить клиента</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('orders.update', $order->id) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Клиент</label>
                                    <input type="text" class="form-control" name="fullname" placeholder="Имя Фамилия"
                                        required value="{{ $order->customer->fullname }}" readonly>
                                    <input type="hidden" name="customer_id" value="{{ $order->customer->id }}">
                                </div>
                            </div>

                            <div class="col-12" id="order_items">
                                @foreach ($order->orderInfos as $orderInfo)
                                    <div class="row order_items_clone">
                                        <div class="col-4">
                                            <label for="date_id_{{ $orderInfo->iteration }}" class="form-label">Дата</label>
                                            <input type="date" class="form-control"
                                                id="date_id_{{ $orderInfo->iteration }}" name="date[]" required
                                                value="{{ $orderInfo->date }}">
                                        </div>
                                        <div class="col-8">
                                            <label for="info_id_{{ $orderInfo->iteration }}"
                                                class="form-label">Информация</label>
                                            <textarea class="form-control"
                                                id="info_id_{{ $orderInfo->iteration }}" name="info[]"
                                                placeholder="Информация" required>{{ $orderInfo->info }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <a href="javascript:void(0)" class="order_items_remove text-danger float-end">
                                                Удалить &times;
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-12">
                                <p class="text-center">
                                    <a href="javascript:void(0)" id="add-more" class="text-success"><i
                                            class="mdi mdi-plus-circle"></i> Добавить еще</a>
                                </p>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="deadline" class="form-label">Срок</label>
                                    <input type="date" class="form-control" name="deadline" placeholder="Срок" required
                                        value="{{ $order->deadline }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="summa" class="form-label">Сумма</label>
                                    <input type="text" class="form-control" name="summa" placeholder="Сумма"
                                        required value="{{ $order->summa }}" id="summa">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Комментарий</label>
                                    <textarea class="form-control" name="comment" rows="3">{{ $order->comment }}</textarea>
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
    <script src="{{ asset('vendor/cloneData.js') }}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
