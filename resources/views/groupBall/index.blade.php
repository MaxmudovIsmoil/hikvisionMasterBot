@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-datatable">
                            <table class="table" id="datatable">
                                <thead>
                                <tr>
                                    <th>Text</th>
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

    @include('groupBall.add_edit_modal')

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
                "url": '{{ route("getGroupBall") }}',
            },
            columns: [
                {data: 'text'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });


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
                    console.log('response: ', response);
                    if (response.success) {
                        form.find('#text').html(response.data.text);
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
                    console.log('response: ', response);
                    if (response.success) {
                        modal.modal('hide');
                        datatable.draw();
                    }
                },
                error: (response) => {
                    console.log("errors: ", response)
                }
            })
        });

    </script>
@endpush
