<!-- Modal -->
<div class="modal fade text-left static" id="stopModal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ishni to'xtatish</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" class="js_stop_form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="comment">Ishni to'xtatish uchun sabab</label>
                        <input type="text" class="form-control js_comment" aria-label="comment" name="comment">
                        <div class="invalid-feedback">Sababni kiriting!</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">To'xtatish</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                </div>
            </form>
        </div>
    </div>
</div>

