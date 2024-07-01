@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="content-header">
            <a data-url="{{ route('user.store') }}"
               class="btn btn-outline-primary btn-sm addBtn js_add_btn">
                <i class="fas fa-user-plus"></i>&nbsp; Qo'shish
            </a>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-datatable">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Kasbi</th>
                                        <th>Ism</th>
                                        <th>Telefon raqam</th>
                                        <th>Yashsh mazil</th>
                                        <th>Role</th>
                                        <th>Login</th>
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

    @include('user.add_edit_modal')

@endsection


@push('script')
    <script src="{{ asset('assets/js/user.js') }}"></script>
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
                "url": '{{ route("getUsers") }}',
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'job'},
                {data: 'name'},
                {data: 'phone'},
                {data: 'address'},
                {data: 'role'},
                {data: 'username'},
                {data: 'action', orderable: false, searchable: false}
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
                    // console.log('response: ', response);
                    if (response.success) {
                        form.find('.js_job').val(response.data.job);
                        form.find('.js_name').val(response.data.name);
                        form.find('.js_phone').val(response.data.phone);
                        form.find('.js_address').val(response.data.address);
                        form.find('.js_username').val(response.data.username);
                        let status = form.find('.js_status option')
                        status.val(response.data.status);

                        let role = form.find('.js_role');
                        role.val(response.data.role);
                        if(response.data.role === 2) {
                            form.find('.js_div_login').removeClass('d-none');
                        }
                        else {
                            form.find('.js_div_login').addClass('d-none');
                        }
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
                    else {
                        let errors = response.errors;
                        if(response.errors.name)
                            handleFieldError(form, errors, 'name');
                        if(response.errors.phone)
                            handleFieldError(form, errors, 'phone');
                        if(response.errors.job)
                            handleFieldError(form, errors, 'job');
                        if(response.errors.address)
                            handleFieldError(form, errors, 'address');

                        if(response.errors.username)
                            handleFieldError(form, errors, 'username');

                        if(response.errors.password)
                            handleFieldError(form, errors, 'password');
                    }
                }
            })
        });


        // $(document).on("click", ".js_delete_btn", function () {
        //     let name = $(this).data('name')
        //     let url = $(this).data('url')
        //     deleteModal.find('.modal-title').html(name)
        //     let form = deleteModal.find('#js_modal_delete_form')
        //     form.attr('action', url)
        //     deleteModal.modal('show');
        // });

        $(document).on('submit', '#js_modal_delete_form', function (e) {
            e.preventDefault()
            delete_function(deleteModal, $(this), datatable);
        });

    </script>
@endpush
