@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="content-header">
            <a data-url="{{ route('group.store') }}"
               class="btn btn-outline-primary btn-sm addBtn js_add_btn">
                <i class="fas fa-plus"></i>&nbsp; Qo'shish
            </a>
        </div>
        <div class="content-body size-14">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-datatable">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Nomi</th>
                                        <th>Telefon raqam</th>
                                        <th>Darajasi</th>
                                        <th>Ballari</th>
                                        <th>Soni</th>
                                        <th>Status</th>
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

    @include('group.add_edit_modal')

@endsection


@push('script')
    <script src="{{ asset('assets/js/group.js') }}"></script>
    <script>

        var modal = $('#add_edit_modal');
        var deleteModal = $('#deleteModal');

        var datatable = $('#datatable').DataTable({
            scrollY: '70vh',
            scrollCollapse: true,
            paging: false,
            lengthChange: false,
            searching: true,
            info: false,
            autoWidth: true,
            language: {
                search: "",
                searchPlaceholder: "Search",
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": '{{ route("getGroups") }}',
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'level', name: 'level'},
                {data: 'ball', name: 'ball'},
                {data: 'user_count', name: 'user_count'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $(document).on('click', '.js_add_btn', function () {
            let url = $(this).data('url')
            let form = modal.find('.js_add_edit_form')

            formClear(form);
            modal.find('.modal-title').html('Group qo\'shish');
            form.attr('action', url);
            modal.modal('show');
        })


        $(document).on('click', '.js_edit_btn', function () {
            let one_url = $(this).data('one_url');
            let update_url = $(this).data('update_url');
            let form = modal.find('.js_add_edit_form');
            formClear(form);

            modal.find('.modal-title').html('Edit group');
            form.attr('action', update_url);
            form.append('<input type="hidden" name="_method" value="PUT">');

            $.ajax({
                type: 'GET',
                url: one_url,
                dataType: 'JSON',
                success: (response) => {
                    console.log('response: ', response);
                    if (response.success) {
                        form.find('.js_name').val(response.data.name);
                        form.find('.js_address').val(response.data.address);
                        form.find('.js_phone').val(response.data.phone);
                        form.find('.js_ball').val(response.data.ball);
                        form.find('.js_level').val(response.data.level);
                        let status = form.find('.js_status option')
                        status.val(response.data.status);
                        let users = form.find('.jsCheckOne');

                        let userResponses = response.data.user.reduce((acc, userRes) => {
                            if(userRes['capitan']) {
                                form.find('.js_capitan_id').val(userRes['user_id']);
                                capitanChange(userRes['user_id']);
                                acc[userRes['user_id']] = false;
                                return acc;
                            }
                            acc[userRes['user_id']] = true;
                            return acc;
                        }, {});

                        // form.find('.js_capitan_id option').val(capitanId);
                        users.each(function (i, user) {
                            let userId = parseFloat($(this).val());
                            if (userResponses[userId]) {
                                $(this).prop('checked', true);
                            }
                        });

                        groupDetailSet(response.data.detail);

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
                    console.log('response: ', response);
                    if (response.success) {
                        modal.modal('hide');
                        datatable.draw();
                    }
                    else {
                        let errors = response.errors;
                        console.log("errors: ", errors)

                        handleFieldError(form, errors, 'name');
                        handleFieldError(form, errors, 'level');
                        handleFieldError(form, errors, 'phone');
                        handleFieldError(form, errors, 'ball');
                        handleFieldError(form, errors, 'capitan_id');


                        let length = $('.js_div_detail').length;
                        for(let i = 0; i <= length; i++) {
                            if (errors['key.'+i]) {
                                form.find(`.js_key${i}`).addClass('is-invalid');
                                // form.find(`.js_key${i}`).siblings('.invalid-feedback').html(errors['key.'+i]);
                            }

                            if (errors['val.'+i]) {
                                form.find(`.js_val${i}`).addClass('is-invalid');
                                // form.find(`.js_val${i}`).siblings('.invalid-feedback').html(errors['val.'+i]);
                            }

                        }
                    }
                }
            })
        });


        $(document).on('submit', '#js_modal_delete_form', function (e) {
            e.preventDefault()
            delete_function(deleteModal, $(this), datatable);
        });
    </script>
@endpush
