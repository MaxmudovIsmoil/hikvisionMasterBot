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
                            <table class="table" id="userDatatable">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Nomi</th>
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

    @include('user.add_edit_modal')

@endsection


@push('script')
{{--    <script src="{{ asset('assets/js/user.js') }}"></script>--}}
    <script>
        $('.js_user').select2();

        var modal = $('#add_edit_modal');

        var userDatatable = $('#groupDatatable').DataTable({
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
                {data: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
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
                    // console.log('response: ', response);
                    if (response.success) {
                        form.find('.js_name').val(response.data.name);
                        let status = form.find('.js_status option')
                        $.each(status, function (i, item) {
                            if (response.data.status === $(item).val()) {
                                $(item).attr('selected', true);
                            }
                        })
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
                        groupDatatable.draw();
                    }
                    else {
                        let errors = response.errors;
                        console.log("errors: ", errors)

                        handleFieldError(form, errors, 'name');
                        handleFieldError(form, errors, 'level');
                        handleFieldError(form, errors, 'ball');

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

        // $(document).on('submit', '#js_modal_delete_form', function (e) {
        //     e.preventDefault();
        //     const deleteModal = $('#deleteModal');
        //     const $this = $(this);
        //     // delete_function(deleteModal, $this, groupDatatable);
        // });
        //
        //
        //
        // $(document).on("click", ".js_recovery_btn", function () {
        //
        //     let name = $(this).data('name')
        //     let url = $(this).data('url')
        //     recoveryModal.find('.modal-title').html(name)
        //
        //     let form = recoveryModal.find('#js_modal_recovery_form')
        //     form.attr('action', url)
        //     recoveryModal.modal('show');
        // });
        //
        // $(document).on('submit', '#js_modal_recovery_form', function (e) {
        //     e.preventDefault();
        //     const $this = $(this);
        //     delete_function(recoveryModal, $this, groupDatatable);
        // });


        // // Access Level
        // const accessLevelModal = $('#accessLevelModal');
        // $(document).on('click', '.js_access_level_btn', function(e) {
        //     e.preventDefault();
        //     let name = $(this).data('name');
        //     let one_url = $(this).data('one_url');
        //     let update_url = $(this).data('update_url');
        //     let form = accessLevelModal.find('.js_access_level_form');
        //     form.attr('action', update_url);
        //
        //     $.ajax({
        //         type: 'GET',
        //         url: one_url,
        //         dataType: 'JSON',
        //         success: (response) => {
        //             // console.log('response: ', response);
        //             if (response.success) {
        //                 drawAccessLevelTable(response.data.menu, response.data.btn);
        //             }
        //             accessLevelModal.find('.modal-title').text(name);
        //             accessLevelModal.modal('show');
        //         },
        //         error: (response) => {
        //             console.log('error: ', response)
        //         }
        //     });
        // });
        //
        // $(document).on('submit', '.js_access_level_form', function(e) {
        //     e.preventDefault();
        //     let form = $(this);
        //     let action = form.attr('action');
        //
        //     $.ajax({
        //         url: action,
        //         type: "POST",
        //         dataType: "json",
        //         data: form.serialize(),
        //         success: (response) => {
        //             // console.log('response: ', response);
        //             if (response.success) {
        //                 accessLevelModal.modal('hide');
        //                 // groupDatatable.draw();
        //             }
        //         },
        //         error: (error) => {
        //             console.log('Error: ', error);
        //         }
        //     })
        // });
    </script>
    {{--    <script src="{{ asset('assets/js/group.js') }}"></script>--}}
@endpush
