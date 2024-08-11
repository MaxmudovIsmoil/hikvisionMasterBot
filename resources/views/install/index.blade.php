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
        <div class="content-body size-14">
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
        @include('install.stop_modal')
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/js/install.js') }}"></script>
    <script>
        $(document).ready(function () {
            var modal = $(document).find('#add_edit_modal');
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
                    { data: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            {{--let orderfieldNotificationsSource = new EventSource('{{route("install-notification")}}');--}}
            {{--orderfieldNotificationsSource.onmessage = function(event) {--}}
            {{--    let data = JSON.parse(event.data);--}}
            {{--    console.log('data: ', data);--}}
            {{--    //Mana shu yerda logika yoziladi.  `oc` o’zgaruvchida backenddan kelayotgan data bo’ladi--}}
            {{--}--}}


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

            $(document).on('click', '.js_stop_btn', function (e) {
                e.preventDefault();
                let stopModal = $('#stopModal');
                let form = stopModal.find('form');
                let url = $(this).data('url');
                form.attr('action', url);
                form.find('.js_comment').val('');
                stopModal.modal('show');
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
                        handleFieldError(form, errors, 'quantity');
                        handleFieldError(form, errors, 'location');
                        handleFieldError(form, errors, 'description');

                        handleFieldError(form, errors, 'comment');
                    }
                });
            });


            $(document).on("click", ".js_show_btn", function () {
                let showModal = $('#show_modal');
                $.ajax({
                    url: $(this).data('url'),
                    type: "GET",
                    dataType: "JSON",
                    success: (response) => {
                        // console.log(response)
                        if (response.success) {
                            showModal.find('.js_category').html(response.data.category);
                            showModal.find('.js_blanka_number').html(response.data.blanka_number);
                            showModal.find('.js_name').html(response.data.name);
                            showModal.find('.js_phone').html(response.data.phone);
                            showModal.find('.js_area_address').html(response.data.area+', '+response.data.address);
                            showModal.find('.js_quantity').html(response.data.quantity);
                            showModal.find('.js_price').html(response.data.price);
                            showModal.find('.js_location').html(locationSet(response.data.location));
                            showModal.find('.js_description').html(response.data.description);
                            showModal.find('.js_created_date').html(response.data.created_at);

                            let group = groupSet(response.data.groups)
                            showModal.find('.js_groups').html(group);
                            showModal.find('.js_status').html(response.data.status);
                            showModal.find('.js_comment').html(response.data.comment);

                            showModal.modal('show');
                        }
                    },
                    error: (response) => {
                        console.log('error: ', response)
                    }
                });
            });


            $(document).on('submit', '.js_stop_form', function (e) {
                let stopModal = $(this).closest('#stopModal');
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    data: form.serialize(),
                    dataType: "JSON",
                    success: (response) => {
                        console.log(response)
                        if (response.success) {
                            stopModal.modal('hide');
                            form.find('.js_comment').val('');
                            table.draw();
                        }
                    },
                    error: (response) => {
                        console.log('error: ', response)
                        if (response.responseJSON && response.responseJSON.errors) {
                            let errors = response.responseJSON.errors;
                            handleFieldError(form, errors, 'comment');
                        }
                    }
                });
            });
        });
    </script>
@endpush
