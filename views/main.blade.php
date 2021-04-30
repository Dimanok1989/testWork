@extends('index')

@section('title', "Тестовое задание")

@section('content')

    <h4 class="text-center mt-5 mb-3">Добавить запись</h4>

    <form class="card mx-auto p-3 add-record-form position-relative needs-validation" novalidate id="add-record">

        <div class="mb-3" id="client-name-block">
            <label for="client-name" class="form-label">Имя *</label>
            <input name="name" type="text" class="form-control" id="client-name" required>
            <div class="invalid-feedback" data-default="Введите имя клиента">Введите имя клиента</div>
        </div>

        <div class="mb-3" id="client-phone-block">
            <label for="client-phone" class="form-label">Номер телефона *</label>
            <input name="phone" type="text" class="form-control" id="client-phone" required>
            <div class="invalid-feedback" data-default="Введите номер телефона клиента">Введите номер телефона клиента</div>
        </div>

        <div class="mb-3" id="client-email-block">
            <label for="client-email" class="form-label">Email адрес *</label>
            <input name="email" type="email" class="form-control" id="client-email" required>
            <div class="invalid-feedback" data-default="Введите адрес электронной почты клиента">Введите адрес электронной почты клиента</div>
        </div>

        <button class="btn btn-success btn-block position-relative" type="button" onclick="app.addRecord(this);">
            <span>Добавить</span>
            <span class="spinner-grow spinner-grow-sm loading-button" role="status" aria-hidden="true"></span>
        </button>

        <div class="text-center mt-3">
            <a href="/records">Все записи <b id="records-count">{{ $records ?? 0 }}</b></a>
        </div>

    </form>

@endsection