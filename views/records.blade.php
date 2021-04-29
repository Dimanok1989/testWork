@extends('index')

@section('title', "Все записи")

@section('content')

    <div class="d-flex justify-content-center align-items-center mt-4 mb-3">
        <h4 class="text-center mb-0">Все записи - <span id="count-records">{{ $records ?? 0 }}</span></h4>
        <span class="px-2"></span>
        <a href="/" class="btn btn-success btn-sm">Добавить запись</a>
    </div>

    <div class="input-group mb-3 records-rows mx-auto">
        <input type="text" class="form-control" placeholder="Введите имя, номер телефона или email адрес клиента..." aria-label="Введите имя, номер телефона или email адрес клиента..." onkeyup="app.writeSearch(this);" id="search-word">
        <button class="btn btn-outline-secondary" type="button" onclick="app.search();">Найти</button>
    </div>

    <div id="records-rows" class="px-3 mx-auto records-rows"></div>

    <div class="text-center py-2" id="loading-rows">
        <div class="spinner-grow spinner-grow-sm text-primary" role="status"></div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {

            app.showRecords();

            window.onscroll = () => {

                if (window.pageYOffset + window.innerHeight >= document.documentElement.clientHeight - 200 && !app.process && !app.endRecords) {
                    app.showRecords();
                }
            }
            
        });
    </script>
@endsection