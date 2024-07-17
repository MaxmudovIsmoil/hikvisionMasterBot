<!-- Modal -->
<div class="modal fade text-left static" id="add_edit_modal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ish joylash</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" class="js_add_edit_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label for="cat">Kategoriya:</label>
                                    <select class="form-select js_category_id" aria-label="category_id" name="category_id" aria-label="cat">
                                        @foreach($category as $cat)
                                            <option value="{{$cat['id']}}">{{ $cat['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Hodimni tanlang!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="blanka">Blanka raqami:</label>
                                    <input type="text" class="form-control js_blanka_number" aria-label="blanka" name="blanka_number">
                                    <div class="invalid-feedback">Blanka raqamini kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="name">F.I.O:</label>
                                    <input type="text" class="form-control js_name" aria-label="name" name="name">
                                    <div class="invalid-feedback">F.I.O ni kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="phone">Telefon raqam:</label>
                                    <input type="number" class="form-control js_phone" aria-label="phone" name="phone">
                                    <div class="invalid-feedback">Telefon raqamni kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="area">Hudud:</label>
                                    <input type="text" class="form-control js_area" aria-label="area" name="area">
                                    <div class="invalid-feedback">Hududni kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="address">Manzil:</label>
                                    <input type="text" class="form-control js_address" aria-label="address" name="address">
                                    <div class="invalid-feedback">Manzilni kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="quantity">Hizmat soni:</label>
                                    <input type="number" class="form-control js_quantity" aria-label="quantity" name="quantity">
                                    <div class="invalid-feedback">Hizmat narxini kiriting!</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="price">Hizmat narxi:</label>
                                    <input type="number" class="form-control js_price" aria-label="price" name="price">
                                    <div class="invalid-feedback">Hizmat narxini kiriting!</div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="location">Geo locatsiya:</label>
                                    <input type="text" class="form-control js_location" aria-label="location" name="location">
                                    <div class="invalid-feedback">Geo locatsiyani kiriting!</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-0">Guruhlar</p>
                            <div class="check-list">
                                <div class="form-check check0">
                                    <input class="form-check-input jsCheckAll" type="checkbox" value="0" name="group[]" id="check0">
                                    <label class="form-check-label" for="check0">
                                        Barcha guruhlar
                                    </label>
                                </div>
                                @foreach($groups as $g)
                                    <div class="form-check">
                                        <input class="form-check-input jsCheckOne" type="checkbox" name="group[]" value="{{ $g['id'] }}" id="check{{$g['id']}}">
                                        <label class="form-check-label" for="check{{$g['id']}}">
                                            {{ $g['name'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="description">Ish haqida ma'lumot</label>
                            <textarea class="form-control jd_description" aria-label="description" name="description" rows="3"></textarea>
                            <div class="invalid-feedback">Geo locatsiyani kiriting!</div>
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

