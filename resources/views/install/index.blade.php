@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="service-btn-group" role="group" aria-label="Basic example">
            <a href="{{ route("getInstall", 0) }}" class="btn btn-sm js_cat_btn mb-1 btn-primary">
                <i class="fas fa-list"></i> Barchasi
                <span class="badge bg-success">{{ $allCount }}</span>
            </a>
            @foreach($category as $cat)
                <a href="{{ route("getInstall", $cat['id']) }}"
                   class="btn btn-sm js_cat_btn mb-1 @if(Request::is('install/get/'.$cat['id']) == $cat['id']) btn-primary @else btn-outline-primary @endif">
                    {{ $cat['name'] }}
                    <span class="badge bg-success">{{ $cat['install_count'] }}</span>
                </a>
            @endforeach
        </div>
        <div class="content-header">
            <a data-store_url="{{ route('install.store') }}"
               class="btn btn-outline-primary btn-sm addBtn js_add_btn" style="opacity: 1;">
                <i class="fas fa-plus"></i>&nbsp; Qo'shish
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
                                        <th>Blanka Raqami</th>
                                        <th>F.I.O</th>
                                        <th>Manzil</th>
                                        <th>Tefeon raqam</th>
                                        <th>Xizmat narxi</th>
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

        @include('install.add_edit_modal')

        @include('install.show_modal')
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            var modal = $(document).find('#add_edit_modal');
            var deleteModal = $('#deleteModal')
            var form = modal.find('.js_add_edit_form');

            var table = $('#datatable').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                paging: true,
                pageLength: 100,
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
                    "url": "{{ route('getInstall', 0) }}",
                },
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'blanka_number' },
                    { data: 'name' },
                    { data: 'address' },
                    { data: 'phone' },
                    { data: 'price' },
                    { data: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $(document).on('click', '.js_cat_btn', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $(this).siblings('.btn-primary')
                    .removeClass('btn-primary')
                    .addClass('btn-outline-primary');
                $(this)
                    .removeClass('btn-outline-primary')
                    .addClass('btn-primary');

                table.destroy();
                table = $('#datatable').DataTable({
                    scrollY: '60vh',
                    scrollCollapse: true,
                    paging: true,
                    pageLength: 100,
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
                        "url": url,
                    },
                    columns: [
                        { data: 'DT_RowIndex' },
                        { data: 'blanka_number' },
                        { data: 'name' },
                        { data: 'address' },
                        { data: 'phone' },
                        { data: 'price' },
                        { data: 'status' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
            });


            $(document).on('click', '.js_add_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html("Ish joylash");
                formClear(form);
                let url = $(this).data('store_url');
                form.attr('action', url);
                modal.modal('show');
            });

            $(document).on('click', '.js_edit_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html('Taxrirlash')
                let status = form.find('.js_status option')
                let url = $(this).data('one_data_url')
                let update_url = $(this).data('update_url')
                form.attr('action', update_url)
                formClear(form);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: (response) => {
                        form.append("<input type='hidden' name='_method' value='PUT'>");
                        if (response.success) {

                            let category = form.find('.js_category_id option')
                            category.val(response.data.category_id);

                            let group = form.find('.js_group option')
                            group.val(response.data.group);

                            form.find('.js_name').val(response.data.name)
                            form.find('.js_blanka_number').val(response.data.blanka_number)
                            form.find('.js_address').val(response.data.address)
                            form.find('.js_area').val(response.data.area)
                            form.find('.js_location').val(response.data.location)
                            form.find('.js_price').val(response.data.price);
                            form.find('.js_description').val(response.data.description);

                            modal.modal('show')
                        }
                    },
                    error: (response) => {
                        console.log('error: ',response)
                    }
                });
            })

            $(document).on('submit', '.js_add_edit_form', function (e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    data: new FormData(this),
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        console.log(response)
                        if (response.success) {
                            modal.modal('hide')
                            formClear(form)
                            table.draw();
                        }
                    },
                    error: (response) => {
                        console.log('error: ', response)
                        let errors = response.responseJSON.errors;
                        handleFieldError(form, errors, 'blanka_number');
                        handleFieldError(form, errors, 'name');
                        handleFieldError(form, errors, 'phone');
                        handleFieldError(form, errors, 'area');
                        handleFieldError(form, errors, 'address');
                        handleFieldError(form, errors, 'price');
                        handleFieldError(form, errors, 'location');
                        handleFieldError(form, errors, 'description');
                    }
                });
            });


            $(document).on("click", ".js_show_btn", function () {
                let showModal = $('#show_modal');
                let url = $(this).data('url');
                // form.attr('action', url)
                showModal.modal('show');
            });

            $(document).on('submit', '#js_modal_delete_form', function (e) {
                e.preventDefault()
                delete_function(deleteModal, $(this), table);
            });
        });
    </script>
@endpush
