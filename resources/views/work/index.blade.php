@extends('layouts.app')

@section('content')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body position-relative">
            <div class="form-modal-ex add-bnt">
                <!-- add btn click show modal -->
                <a href="javascript:void(0);" data-store_url="{{ route('work.store') }}"
                   class="btn btn-outline-primary js_add_btn">
                    <i data-feather="plus"></i>&nbsp; {{__("admin.Add")}}
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
                                        <th>{{__("admin.Name")}}</th>
                                        <th>{{__("admin.Status")}}</th>
                                        <th class="text-right">{{__("admin.Action")}}</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Multilingual -->
{{--            @include('admin.instance.add_edit_modal')--}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        function form_clear(form) {
            form.find('.js_name_ru').val('')
            let status = form.find('.js_status option');
            $.each(status, function (i, item) {
                $(item).removeAttr('selected');
            });
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
                {{--    "url": '{{ route("admin.getInstances") }}',--}}
                {{--},--}}
                {{--columns: [--}}
                {{--    {data: 'DT_RowIndex'},--}}
                {{--    {data: 'name_ru'},--}}
                {{--    {data: 'status'},--}}
                {{--    {data: 'action', name: 'action', orderable: false, searchable: false}--}}
                {{--]--}}
            });

            $('.js_add_btn').on('click', function () {
                modal.find('.modal-title').html('{{__("admin.Add Instance")}}')
                form_clear(form);
                let url = $(this).data('store_url');
                form.attr('action', url);
                modal.modal('show');
            });

            $(document).on('click', '.js_edit_btn', function (e) {
                e.preventDefault();
                modal.find('.modal-title').html('{{__("admin.Edit Instance")}}')
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
                            form.find('.js_name_ru').val(response.data.name_ru)
                            $.each(status, function (i, item) {
                                if (response.data.status === $(item).val()) {
                                    $(item).attr('selected', true);
                                }
                            })
                            modal.modal('show')
                        }
                    },
                    error: (response) => {
                        console.log('error: ', response)
                    }
                });
            })

            $(document).on('submit', '.js_add_edit_form', function (e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    dataType: "json",
                    data: $(this).serialize(),
                    success: (response) => {
                        if (response.success) {
                            modal.modal('hide')
                            form_clear(form)
                            table.draw();
                        }
                    },
                    error: (response) => {
                        if (typeof response.responseJSON.errors !== 'undefined') {
                            form.find('.js_name_ru').addClass('is-invalid')
                        }
                        console.log('error: ', response)
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
