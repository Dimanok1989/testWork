function App() {

    this.addRecord = e => {

        let form = $('#add-record');
        let formdata = form.serializeArray();

        $('#add-record').find('button').prop('disabled', true);
        $(e).find('.loading-button').show();

        $.ajax({
            url: "/addRecord",
            type: "POST",
            dataType: "JSON",
            data: formdata,
            success: data => {

                form.find('.invalid-feedback').each(el => {
                    $(el).html($(el).data('default'));
                });

                form.find('input').removeClass('is-invalid, is-valid');

                $('#records-count').text(data.count);

                $('#add-record').after(`<div class="alert alert-success mx-auto add-record-form" role="alert" id="new-alert-${data.record.id}">${data.message}</div>`);

                setTimeout(() => {
                    $(`#new-alert-${data.record.id}`).remove();
                }, 5000);

                form[0].reset();
                
            },
            error: error => {

                form.find('input').removeClass('is-invalid').addClass('is-valid');

                if (typeof error.responseJSON.errors == "object") {
                    error.responseJSON.errors.forEach(row => {
                        form.find(`#client-${row.name}-block .invalid-feedback`).html(row.message);
                        form.find(`#client-${row.name}`).removeClass('is-valid').addClass('is-invalid');
                    });
                }

            },
            complete: () => {
                $('#add-record').find('button').prop('disabled', false);
                $(e).find('.loading-button').hide();
            }
        });

    }

    this.page = 1;

    this.process = false;

    this.endRecords = false;

    this.showRecords = (search = null) => {

        if (this.process || this.endRecords)
            return null;

        this.process = true;

        $('#loading-rows').show();

        if (this.page === 1)
            $('#records-rows').empty();

        $.ajax({
            url: "/showRecords",
            type: "POST",
            dataType: "JSON",
            data: {
                page: this.page,
                search,
            },
            success: data => {

                data.records.forEach(row => {
                    $('#records-rows').append(this.getHutmRecordRow(row));
                });

                if (search && !data.records.length && this.page == 1) {
                    $('#records-rows').append(`<div class="text-center my-3"><b>Ничего не найдено</b></div>`);
                }

                if (data.next > data.last) {
                    this.endRecords = true;
                    $('#records-rows').append(`<div class="text-center text-muted my-3" id="end-rows-message"><small>Это все записи!</small></div>`);
                }

                this.page = data.next;

            },
            error: error => {

            },
            complete: () => {
                $('#loading-rows').hide();
                this.process = false;
            }
        });

    }

    this.getHutmRecordRow = row => {

        let word = $('#search-word').val();
        let regexp = new RegExp(word, 'ig');

        let name = String(row.name).replace(regexp, `<span style="background: #3fff00; color: #000; border-radius: 3px;">${word}</span>`);
        let phone = String(row.phone).replace(regexp, `<span style="background: #3fff00; color: #000; border-radius: 3px;">${word}</span>`);
        let email = String(row.email).replace(regexp, `<span style="background: #3fff00; color: #000; border-radius: 3px;">${word}</span>`);

        return `<div class="card px-3 py-2 my-2">
            <div class="d-flex align-items-center justify-content-between">
                <b class="mb-0">
                    <span>#${row.id}</span>
                    <span>${name}</span>
                </b>
                <small>${row.date}</small>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div>тел. ${phone}</div>
                    <div>${email}</div>
                </div>
                <button class="btn btn-danger btn-sm">Удалить</div>
            </div>
        </div>`;

    }

    this.searchTimeOut = null;

    this.writeSearch = e => {

        clearTimeout(this.searchTimeOut);

        if (event.keyCode == 13)
            return this.search();

        this.searchTimeOut = setTimeout(this.search, 500);

    }

    this.search = () => {

        let search = $('#search-word').val();

        this.page = 1;
        this.endRecords = false;

        this.showRecords(search);

    }

}

const app = new App();