@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="content-header">
            <a data-url="{{ route('categoryInstall.store') }}"
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

    @include('categoryInstall.add_edit_modal')

@endsection


@push('script')
    <script>
        var modal = $('#add_edit_modal');

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
                searchPlaceholder: "Izlash",
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": '{{ route("getCategoryInstall") }}',
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'},
                {data: 'status'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $(document).on('click', '.js_add_btn', function () {
            let url = $(this).data('url')
            let form = modal.find('.js_add_edit_form')

            formClear(form);
            modal.find('.modal-title').html('Kategoriya qo\'shish');
            form.attr('action', url);
            modal.modal('show');
        })


        $(document).on('click', '.js_edit_btn', function () {
            let one_url = $(this).data('one_url');
            let update_url = $(this).data('update_url');
            let form = modal.find('.js_add_edit_form');
            formClear(form);

            modal.find('.modal-title').html('Kategoriya taxrirlash');
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
                        let statusOptions = form.find('.js_status option');
                        statusOptions.each(function () {
                            if ($(this).val() == response.data.status) {
                                $(this).prop('selected', true);
                                return false;
                            }
                        });
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
                    // console.log("errors: ", response)
                    if (response.responseJSON.errors.name) {
                        handleFieldError(form, response.responseJSON.errors, 'name');
                    }
                }
            })
        });

        $(document).on('submit', '#js_modal_delete_form', function (e) {
            e.preventDefault();
            const deleteModal = $('#deleteModal');
            const $this = $(this);
            delete_function(deleteModal, $this, datatable);
        });
    </script>
@endpush
