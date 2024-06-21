<!-- Modal -->
<div class="modal fade text-left static" id="add_edit_modal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ish joylash</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" class="js_add_edit_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="blanka">Blanka raqami:</label>
                            <input type="text" class="form-control" id="blanka" name="blanka">
                            <div class="invalid-feedback">Blanka raqamini kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="fio">F.I.O:</label>
                            <input type="text" class="form-control js_fio" id="fio" name="fio">
                            <div class="invalid-feedback">F.I.O ni kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="area">Hudud:</label>
                            <input type="text" class="form-control" id="area" name="area">
                            <div class="invalid-feedback">Hududni kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="address">Manzil:</label>
                            <input type="text" class="form-control" id="address" name="address">
                            <div class="invalid-feedback">Manzilni kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="location">Geo locatsiya:</label>
                            <input type="text" class="form-control" id="location" name="location">
                            <div class="invalid-feedback">Geo locatsiyani kiriting!</div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="description">Ish haqida ma'lumot</label>
                            <textarea class="form-control" id="description"  name="description" rows="3"></textarea>
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

