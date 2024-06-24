<!-- Delete Modal -->
<div class="modal fade modal-danger text-left" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel"></h5>
            </div>
            <div class="modal-body">
                <span class="js_message fw-600">Rostdan ham oʻchirib tashlamoqchimisiz?</span>
                <span class="js_danger text-danger"></span>
            </div>
            <div class="modal-footer">
                <form id="js_modal_delete_form" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" name="saveBtn" class="btn btn-danger">Xa</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yo'q</button>
            </div>
        </div>
    </div>
</div>
