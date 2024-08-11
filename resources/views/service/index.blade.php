@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="content-header">
            <a data-store_url="{{ route('service.store') }}"
               class="btn btn-outline-primary btn-sm addBtn js_add_btn" style="opacity: 1;">
                <i class="fas fa-plus"></i>&nbsp; Qo'shish
            </a>
            <div class="text-primary fw-600 div-count">Jami: <span>{{ $count }}</span></div>
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

        @include('service.add_edit_modal')

        @include('service.show_modal')
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/js/install.js') }}"></script>
    <script>
        $(document).ready(function () {
            var modal = $(document).find('#add_edit_modal');
            var deleteModal = $('#deleteModal')
            var form = modal.find('.js_add_edit_form');

            var table = $('#datatable').DataTable({
                scrollY: '65vh',
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
                    "url": "{{ route('getServices') }}",
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


            // let srviceNotificationSource = new EventSource(route("service-notification"));
            // srviceNotificationSource.onmessage = function(event) {
            //     let data = JSON.parse(event.data);
            //     console.log('data: ', data);
            //     //Mana shu yerda logika yoziladi.  `oc` o’zgaruvchida backenddan kelayotgan data bo’ladi
            // }

            $(document).on('click', '.js_add_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html("Servis joylash");
                formClear(form);
                let url = $(this).data('store_url');
                form.attr('action', url);
                modal.modal('show');
            });

            $(document).on('click', '.js_edit_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html('Taxrirlash')
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
                console.log(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "JSON",
                    success: (response) => {
                        console.log(response)
                        if (response.success) {
                            showModal.find('.js_blanka_number').html(response.data.blanka_number);
                            showModal.find('.js_name').html(response.data.name);
                            showModal.find('.js_area_address').html(response.data.area+', '+response.data.address);
                            showModal.find('.js_price').html(response.data.price);
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

            $(document).on('submit', '#js_modal_delete_form', function (e) {
                e.preventDefault()
                delete_function(deleteModal, $(this), table);
            });
        });
    </script>
@endpush
