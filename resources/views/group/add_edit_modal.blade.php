<!-- Modal -->
<div class="modal fade text-left static" id="add_edit_modal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Guruh qo'shish</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" class="js_add_edit_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="groupName">Guruh nomi:</label>
                            <input type="text" class="form-control" id="groupName" name="name">
                            <div class="invalid-feedback">Guruh nomini kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="user">Hodim biriktisih:</label>
                            <select class="form-select" id="user" name="user">
                                <option>Olimjon</option>
                                <option>Alijon</option>
                                <option>Asrorbek</option>
                            </select>
                            <div class="invalid-feedback">Hodimni tanlang!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="ball">Ball:</label>
                            <input type="text" class="form-control" id="ball" name="ball">
                            <div class="invalid-feedback">Balni kiriting!</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="masterLevel">usta darajasi:</label>
                            <input type="text" class="form-control" id="masterLevel" name="masterLevel">
                            <div class="invalid-feedback">Usta darajsini kiriting!</div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="masterLevelColumn">Ustun:</label>
                                    <input type="text" class="form-control" id="masterLevelColumn" name="masterLevelColumn">
                                    <div class="invalid-feedback">Usta darajsini kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="masterLevelVal">Qiymati:</label>
                                    <input type="text" class="form-control" id="masterLevelVal" name="masterLevelVal">
                                    <div class="invalid-feedback">Usta darajsini kiriting!</div>
                                </div>
                            </div>
                            <div class="add-btn-div d-flex justify-content-center mt-2">
                                <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-minus"></i>
                                </a>
                            </div>
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

