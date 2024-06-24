<!-- Modal -->
<div class="modal fade text-left static" id="add_edit_modal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kategoriya</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" class="js_add_edit_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="name">Nomi:</label>
                            <input type="text" class="form-control js_name" id="name" name="name">
                            <div class="invalid-feedback">Nomini kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="fio">Status:</label>
                            <select name="status" class="form-select js_status" aria-label="Status">
                                <option value="1">Faol</option>
                                <option value="0">No faol</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                </div>
            </form>
        </div>
    </div>
</div>

