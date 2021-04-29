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

    <div class="mx-auto add-record-form px-3">
        <code>Нужно создать форму записи клиента состоящую из 3х полей: имя, телефон, мейл. 
            А также нужно создать страницу со списком всех записаных клиентов и с возможностью фильтровать по всем 3м полям. Также нужно создать возможность удаление клиентов.
            Нужно сделать без использования фрейм-ворков, на чистом php (на фронте использование фреймворков - плюс).
            То как будет выглядить визуально интерфейс - не принципиально.</code>
    </div>

@endsection