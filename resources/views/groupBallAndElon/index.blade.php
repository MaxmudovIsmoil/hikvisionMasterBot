@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="content-body size-14">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-datatable">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Guruh bal yig'ish haqida ma'lumot</th>
                                        <th class="text-right">Harakat</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="alert alert-success text-center position-relative">
                            <a class="btn btn-sm btn-primary add-elon-btn js_add_btn"><i class="fas fa-plus"></i> Qo'shish</a>
                            <p class="h4 mb-0">E'lonlar</p>
                        </div>
                        <div class="card">
                            <div class="card-datatable">
                                <table class="table" id="elon">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Guruh</th>
                                            <th>E'lon</th>
                                            <th>Vaqti</th>
                                            <th class="text-right">Harakat</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('groupBallAndElon.add_edit_modal')
    @include('groupBallAndElon.elon_modal')

@endsection


@push('script')
    <script>
        var modal = $('#add_edit_modal');

        var datatable = $('#datatable').DataTable({
            scrollY: '70vh',
            scrollCollapse: true,
            paging: false,
            lengthChange: false,
            searching: false,
            info: false,
            autoWidth: true,
            language: {
                search: "",
                searchPlaceholder: "Izlash",
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": '{{ route("getGroupBall") }}',
            },
            columns: [
                {data: 'text'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });


        $(document).on('click', '.js_edit_btn', function () {
            let one_url = $(this).data('one_url');
            let update_url = $(this).data('update_url');
            let form = modal.find('.js_add_edit_form');
            formClear(form);

            modal.find('.modal-title').html('Taxrirlash');
            form.attr('action', update_url);
            form.append('<input type="hidden" name="_method" value="PUT">');

            $.ajax({
                type: 'GET',
                url: one_url,
                dataType: 'JSON',
                success: (response) => {
                    // console.log('response: ', response);
                    if (response.success) {
                        form.find('#text').html(response.data.text);
                    }
                    modal.modal('show');
                },
                error: (response) => {
                    console.log('error: ', response)
                }
            });
        });


        $('.js_add_edit_form').on('submit', function (e) {
            e.preventDefault()
            let form = $(this)
            let action = form.attr('action')

            $.ajax({
                url: action,
                type: "POST",
                dataType: "json",
                data: form.serialize(),
                success: (response) => {
                    // console.log('response: ', response);
                    if (response.success) {
                        modal.modal('hide');
                        datatable.draw();
                    }
                },
                error: (response) => {
                    console.log("errors: ", response)
                }
            })
        });

        // Elon
        var elonModal = $('#elonModal');

        var elon = $('#elon').DataTable({
            scrollY: '70vh',
            scrollCollapse: true,
            paging: false,
            lengthChange: false,
            searching: false,
            info: false,
            autoWidth: true,
            language: {
                search: "",
                searchPlaceholder: "Izlash",
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": '{{ route("getElon") }}',
            },
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'group'},
                {data: 'message'},
                {data: 'created_at'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });


        $(document).on('click', '.js_add_btn', function (e) {
            e.preventDefault();
            elonModal.modal('show');
        });

        $('.js_elon_form').on('submit', function (e) {
            e.preventDefault()
            let form = $(this)
            let action = form.attr('action')

            $.ajax({
                url: action,
                type: "POST",
                dataType: "json",
                data: form.serialize(),
                success: (response) => {
                    console.log('response: ', response);
                    if (response.success) {
                        elonModal.modal('hide');
                        elon.draw();
                    }
                },
                error: (response) => {
                    console.log("errors: ", response)
                }
            })
        });

        $(document).on('submit', '#js_modal_delete_form', function (e) {
            e.preventDefault();
            let deleteModal = $('#deleteModal');
            delete_function(deleteModal, $(this), elon);
        });


        $('.modal button[data-bs-dismiss="modal"]').click(function() {
            $('.jsCheckOne').removeAttr('disabled');
        });

    </script>
@endpush
