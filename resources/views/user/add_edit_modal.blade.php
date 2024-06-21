<!-- Modal -->
<div class="modal fade text-left static" id="add_edit_modal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hodim qo'shish</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" class="js_add_edit_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="job">Kasbi:</label>
                            <input type="text" class="form-control" id="job" name="job">
                            <div class="invalid-feedback">Kasbini kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="fio">F.I.O:</label>
                            <input type="text" class="form-control js_fio" id="fio" name="fio">
                            <div class="invalid-feedback">F.I.O ni kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="raqam">Telefon raqam:</label>
                            <input type="text" class="form-control" id="raqam" name="raqam">
                            <div class="invalid-feedback">Telefon raqam kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="address">Manzil:</label>
                            <input type="text" class="form-control" id="address" name="address">
                            <div class="invalid-feedback">Manzilni kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="status">Status:</label>
                            <select class="form-select" name="status" aria-label="status">
                                <option value="1">Faol</option>
                                <option value="0">No faol</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Jo'natish</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                </div>
            </form>
        </div>
    </div>
</div>

