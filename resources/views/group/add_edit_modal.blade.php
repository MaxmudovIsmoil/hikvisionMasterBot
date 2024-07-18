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
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="groupName">Guruh nomi:</label>
                                    <input type="text" class="form-control js_name" id="groupName" name="name">
                                    <div class="invalid-feedback">Guruh nomini kiriting!</div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="capitan">Masul Usta (Yetakchi):</label>
                                    <select class="form-select js_capitan_id" aria-label="capitan" name="capitan_id">
                                        <option value="">---</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Ustani tanlang!</div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="phone">Telefon raqam:</label>
                                    <input type="number" class="form-control js_phone" id="phone" name="phone" placeholder="901234567">
                                    <div class="invalid-feedback">Telefon raqamni kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="ball">Ball:</label>
                                    <input type="number" class="form-control js_ball" id="ball" name="ball">
                                    <div class="invalid-feedback">Balni kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="status">Status:</label>
                                    <select class="form-select js_status" id="status" name="status">
                                        <option value="1">Faol</option>
                                        <option value="0">No faol</option>
                                    </select>
                                    <div class="invalid-feedback">Hodimni tanlang!</div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="level">Guruh darajasi:</label>
                                    <input type="text" class="form-control js_level" id="level" name="level">
                                    <div class="invalid-feedback">Guruh darajsini kiriting!</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-0">Hodimlar</p>
                            <div class="check-list">
                                @foreach($users as $u)
                                    <div class="form-check jsCheckboxForm">
                                        <input class="form-check-input jsCheckOne" type="checkbox" name="user[]" value="{{ $u['id'] }}" id="check{{$u['id']}}">
                                        <label class="form-check-label" for="check{{$u['id']}}">
                                            {{ $u['name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row js_div_detail">
                                <div class="col-md-6 mb-2">
                                    <label for="key0">Ustun:</label>
                                    <input type="text" class="form-control js_key0" id="key0" name="key[]">
                                    <div class="invalid-feedback">Malumotni kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="val0">Qiymati:</label>
                                    <input type="text" class="form-control js_val0" id="val0" name="val[]">
                                    <div class="invalid-feedback">Malumotni kiriting!</div>
                                </div>
                            </div>
                            <div class="add-btn-div d-flex justify-content-center mt-2">
                                <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm js_plus_btn">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm js_minus_btn">
                                    <i class="fas fa-minus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Saqlash</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                </div>
            </form>
        </div>
    </div>
</div>
