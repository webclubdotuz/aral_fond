@extends('layouts.main')

@push('css')
@livewireStyles
@endpush

@section('title', 'Катнасыушылар')
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
                <livewire:job-table />
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@livewireScripts
@endpush
