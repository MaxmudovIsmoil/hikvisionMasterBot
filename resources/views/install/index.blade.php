@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="service-btn-group" role="group" aria-label="Basic example">
            <a href="{{ route('install.index', 0) }}" class="btn btn-sm btn-primary mb-1"><i class="fas fa-list"></i> Barchasi</a>
            @foreach($category as $cat)
                <a href="{{ route('install.index', $cat['id']) }}" class="btn btn-sm btn-outline-primary mb-1">{{ $cat['name'] }}</a>
            @endforeach
        </div>
        <div class="content-header">
            <a data-store_url="{{ route('install.store') }}"
               class="btn btn-outline-primary btn-sm addBtn js_add_btn">
                <i class="fas fa-plus"></i>&nbsp; Qo'shish
            </a>
{{--            <div class="status-btn-group">--}}
{{--                <a href="#" class="btn btn-sm btn-secondary">Barchasi</a>--}}
{{--                <a href="#" class="btn btn-sm btn-info">Yangi</a>--}}
{{--                <a href="#" class="btn btn-sm btn-warning">Jarayonda</a>--}}
{{--                <a href="#" class="btn btn-sm btn-success">Yopilgan</a>--}}
{{--                <a href="#" class="btn btn-sm btn-danger">Bekor qilingan</a>--}}
{{--            </div>--}}
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
                                        <th>Fish</th>
                                        <th>Huhud</th>
                                        <th>Manzil</th>
                                        <th>Geo lokatsiya</th>
                                        <th>Xizmat narxi</th>
                                        <th>Status</th>
                                        <th class="text-right">Harakat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($installs as $install)
                                        <tr style="background: #ffebb0e6;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>12</td>
                                            <td>Aliyev Olimjon</td>
                                            <td>Charhiy</td>
                                            <td>Nurafshon ko'chasi 102</td>
                                            <td>Link</td>
                                            <td>520 000 so'm</td>
                                            <td>
                                                <span class="badge rounded-pill bg-warning">Jarayonda</span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-around">
                                                    <a class="btn btn-info btn-sm text-white" title="See">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-primary btn-sm js_add_btn" title="Edit">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr style="background: #cefee8;">
                                        <td>2</td>
                                        <td>13</td>
                                        <td>Tohirov Shohruh</td>
                                        <td>Chorsu</td>
                                        <td>Namuna mahallasi 35</td>
                                        <td>Link</td>
                                        <td>360 000 so'm</td>
                                        <td>
                                            <span class="badge rounded-pill bg-success">Yopilgan</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a class="btn btn-info btn-sm text-white" title="See">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-primary btn-sm js_add_btn" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="background: #93baf3eb;">
                                        <td>3</td>
                                        <td>15</td>
                                        <td>Ergashev Shokirjon</td>
                                        <td>Archazor</td>
                                        <td>Furqat kochasi 27</td>
                                        <td>Link</td>
                                        <td>750 000 so'm</td>
                                        <td>
                                            <span class="badge rounded-pill bg-primary">Yangi</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a class="btn btn-info btn-sm text-white" title="See">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-primary btn-sm js_add_btn" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="background: #ff3e5057;">
                                        <td>4</td>
                                        <td>17</td>
                                        <td>Qodirov Abbosxon</td>
                                        <td>Archazor</td>
                                        <td>Uzumzor ko'chasi 87</td>
                                        <td>Link</td>
                                        <td>450 000 so'm</td>
                                        <td>
                                            <span class="badge rounded-pill bg-danger">Bekor qilindi</span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a class="btn btn-info btn-sm text-white" title="See">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-primary btn-sm js_add_btn" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" title="Delete">
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

        @include('install.add_edit_modal')
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
                // processing: false,
                // serverSide: false,
            });


            $(document).on('click', '.js_add_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html("Ish joylash");
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
