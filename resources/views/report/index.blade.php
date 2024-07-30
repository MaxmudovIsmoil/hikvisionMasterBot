@extends('layouts.app')

@section('content')
    <div class="service-btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-sm btn-outline-primary mb-1"><i class="fas fa-list"></i> Barchasi</button>
        <button type="button" class="btn btn-sm btn-outline-primary mb-1">Terminal</button>
        <button type="button" class="btn btn-sm btn-outline-primary mb-1">Domofon</button>
        <button type="button" class="btn btn-sm btn-primary mb-1">Kamera</button>
    </div>
    <div class="content">
        <div class="content-header">
            <a data-store_url=""
               class="btn btn-outline-primary mb-1 btn-sm addBtn js_add_btn">
                <i class="fas fa-user-plus"></i>&nbsp; Qo'shish
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
                                    <th>Soni</th>
                                    <th>Telefon raqam (mijoz)</th>
                                    <th>Manzil</th>
                                    <th>Lokatsiya</th>
                                    <th>Status</th>
                                    <th class="text-right">Harakat</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Kamera o'rnatish</td>
                                    <td>2</td>
                                    <td>(94) 422-00-44</td>
                                    <td>Temurmalik 77B</td>
                                    <td>Lokatyiya</td>
                                    <td>
                                        <span class="badge rounded-pill bg-warning">Bajarilmoqda</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-around">
                                            <a class="btn btn-outline-info btn-sm" title="See">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Kamera o'rnatish (internet ko'ra olish)</td>
                                    <td>5</td>
                                    <td>(99) 229-53-55</td>
                                    <td>Charhiy</td>
                                    <td>Lokatsiya</td>
                                    <td>
                                        <span class="badge rounded-pill bg-danger">Bajarilmadi</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-around">
                                            <a class="btn btn-outline-info btn-sm" title="See">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Domofon o'rnatish</td>
                                    <td>3</td>
                                    <td>(90) 123-45-67</td>
                                    <td>Alisher Navoiy 102</td>
                                    <td>Lokatyiya</td>
                                    <td>
                                        <span class="badge rounded-pill bg-success">Yopildi</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-around">
                                            <a class="btn btn-outline-info btn-sm" title="See">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('report.add_edit_modal')
    </div>
@endsection

@section('script')
    <script>
        function form_clear(form) {
            form.find('.js_name').val('')
            form.find('.js_phone').val('')
            form.find('.js_username').val('')
            form.find('.js_password').val('')
            form.find('.js_photo').val('')
            let status = form.find('.js_status option');
            $.each(status, function (i, item) {
                $(item).removeAttr('selected');
            });
            form.find('.js_instance').val(null).trigger('change')
        }

        $(document).ready(function () {
            var modal = $(document).find('#add_edit_modal');
            var deleteModal = $('#deleteModal')
            var form = modal.find('.js_add_edit_form');

            var table = $('#datatable').DataTable({
                paging: true,
                pageLength: 20,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                language: {
                    search: "",
                    searchPlaceholder: " Поиск...",
                    sLengthMenu: "Кўриш _MENU_ тадан",
                    // sInfo: "Показаны с _START_ по _END_ из _TOTAL_ записей",
                    // emptyTable: "Информация недоступна",
                    // sInfoFiltered: "(Отфильтровано из _MAX_ записей)",
                    // sZeroRecords: "Информация не найдена",
                    // oPaginate: {
                    //     sNext: "Следующий",
                    //     sPrevious: "Предыдущий",
                    // },
                },
                processing: false,
                serverSide: false,
                {{--ajax: {--}}
                {{--    "url": '{{ route("admin.getUsers") }}',--}}
                {{--},--}}
                {{--columns: [--}}
                {{--    {data: 'DT_RowIndex'},--}}
                {{--    {data: 'photo'},--}}
                {{--    {data: 'instance', name: 'instance'},--}}
                {{--    {data: 'name'},--}}
                {{--    {data: 'phone'},--}}
                {{--    {data: 'username'},--}}
                {{--    {data: 'status'},--}}
                {{--    {data: 'action', name: 'action', orderable: false, searchable: false}--}}
                {{--]--}}
            });


            $(document).on('click', '.js_add_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html('{{__("admin.Add user")}}')
                form_clear(form);
                let url = $(this).data('store_url');
                form.attr('action', url);
                modal.modal('show');
            });

            $(document).on('click', '.js_edit_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html('{{__("admin.Edit user")}}')
                let status = form.find('.js_status option')
                let url = $(this).data('one_data_url')
                let update_url = $(this).data('update_url')
                form.attr('action', update_url)
                form_clear(form);

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: (response) => {
                        form.append("<input type='hidden' name='_method' value='PUT'>");
                        if (response.success) {
                            let instance_array = [];
                            for (let i = 0; i < response.data.user_instances.length; i++) {
                                instance_array[i] = response.data.user_instances[i].instance_id;
                            }
                            form.find('.js_instance').val(instance_array)
                            form.find('.js_instance').trigger('change')

                            form.find('.js_name').val(response.data.name)
                            form.find('.js_phone').val(response.data.phone)
                            form.find('.js_username').val(response.data.username)
                            $.each(status, function (i, item) {
                                if (response.data.status === $(item).val()) {
                                    $(item).attr('selected', true);
                                }
                            })
                            modal.modal('show')
                        }
                    },
                    error: (response) => {
                        // console.log('error: ',response)
                    }
                });
            })

            $(document).on('submit', '.js_add_edit_form', function (e) {
                e.preventDefault();
                let instance = form.find('.js_instance');
                let name = form.find('.js_name')
                let phone = form.find('.js_phone')
                let photo = form.find('.js_photo')
                let username = form.find('.js_username')
                let password = form.find('.js_password')

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: new FormData(this),
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        // console.log(response)
                        if (response.success) {
                            modal.modal('hide')
                            form_clear(form)
                            table.draw();
                        }
                    },
                    error: (response) => {
                        if (typeof response.responseJSON.error !== 'undefined') {
                            instance.addClass('is-invalid');
                            instance.siblings('.invalid-feedback').html('{{ __('Admin.instance_fail') }}');
                        }
                        if (typeof response.responseJSON.errors !== 'undefined') {
                            if (response.responseJSON.errors.name) {
                                name.addClass('is-invalid');
                                name.siblings('.invalid-feedback').html(response.responseJSON.errors.name[0]);
                            }
                            if (response.responseJSON.errors.phone) {
                                phone.addClass('is-invalid');
                                phone.siblings('.invalid-feedback').html(response.responseJSON.errors.phone[0]);
                            }
                            if (response.responseJSON.errors.username) {
                                username.addClass('is-invalid');
                                username.siblings('.invalid-feedback').html(response.responseJSON.errors.username[0]);
                            }
                            if (response.responseJSON.errors.password) {
                                password.addClass('is-invalid');
                                password.siblings('.invalid-feedback').html(response.responseJSON.errors.password[0]);
                            }
                            if (response.responseJSON.errors.photo) {
                                photo.addClass('is-invalid');
                                photo.siblings('.invalid-feedback').html(response.responseJSON.errors.photo[0]);
                            }
                        }
                        // console.log('error: ', response);
                    }
                });
            });


            $(document).on("click", ".js_delete_btn", function () {
                let name = $(this).data('name')
                let url = $(this).data('url')

                deleteModal.find('.modal-title').html(name)

                let form = deleteModal.find('#js_modal_delete_form')
                form.attr('action', url)
                deleteModal.modal('show');
            });

            $(document).on('submit', '#js_modal_delete_form', function (e) {
                e.preventDefault()
                delete_function(deleteModal, $(this), table);
            });
        });
    </script>
@endsection
