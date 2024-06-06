@extends('layouts.app')

@section('content')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body position-relative">
            <div class="form-modal-ex add-bnt">
                <!-- add btn click show modal -->
                <a href="javascript:void(0);" data-store_url="{{ route('master.store') }}"
                   class="btn btn-outline-primary js_add_btn">
                    <i data-feather="user-plus"></i>&nbsp; Qo'shish
                </a>
            </div>
            <!-- Multilingual -->
            <section id="multilingual-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-datatable">
                                <table class="table" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Kasbi</th>
                                        <th>FISH</th>
                                        <th>Rasm</th>
                                        <th>Telefon raqam</th>
                                        <th>Manzil</th>
                                        <th>Status</th>
                                        <th class="text-right">Harakat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Kamerachi</td>
                                            <td>OLimjon Aliyev</td>
                                            <td>img</td>
                                            <td>90 123 45 67</td>
                                            <td>Alisher Navoiy 102</td>
                                            <td>ok</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Multilingual -->
{{--            @include('admin.user.add_edit_modal')--}}
        </div>
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
                    sInfo: "Показаны с _START_ по _END_ из _TOTAL_ записей",
                    emptyTable: "Информация недоступна",
                    sInfoFiltered: "(Отфильтровано из _MAX_ записей)",
                    sZeroRecords: "Информация не найдена",
                    oPaginate: {
                        sNext: "Следующий",
                        sPrevious: "Предыдущий",
                    },
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

            $('.js_instance').select2();

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
