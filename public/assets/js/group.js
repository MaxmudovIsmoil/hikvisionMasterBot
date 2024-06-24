

function draw(item = 1) {
    let detailDiv = '<div class="row js_div_detail">\n' +
        '                                <div class="col-md-6 mb-2">\n' +
        '                                    <label for="key'+item+'">Ustun:</label>\n' +
        '                                    <input type="text" class="form-control js_key'+item+'" id="key'+item+'" name="key[]">\n' +
        '                                    <div class="invalid-feedback">Malumotni kiriting!</div>\n' +
        '                                </div>\n' +
        '                                <div class="col-md-6 mb-2">\n' +
        '                                    <label for="val'+item+'">Qiymati:</label>\n' +
        '                                    <input type="text" class="form-control js_val'+item+'" id="val'+item+'" name="val[]">\n' +
        '                                    <div class="invalid-feedback">Malumotni kiriting!</div>\n' +
        '                                </div>\n' +
        '                            </div>';

    $(document).find('.js_div_detail').last().after(detailDiv);
}

$(document).on('click', '.js_plus_btn', function () {
    let item = $(document).find('.js_div_detail').length;
    draw(item);
})

$(document).on('click', '.js_minus_btn', function () {
    let length = $(document).find('.js_div_detail').length;
    if (length > 1) {
        $(document).find('.js_div_detail').last().remove();
    }
})
